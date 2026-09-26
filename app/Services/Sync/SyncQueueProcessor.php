<?php

namespace App\Services\Sync;

use App\Models\SyncDevice;
use App\Models\SyncQueue;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Throwable;

class SyncQueueProcessor
{
    public function __construct(
        protected SyncQueueService $queueService
    ) {
    }

    /*
    |--------------------------------------------------------------------------
    | Process Device Queue
    |--------------------------------------------------------------------------
    */

    public function process(
        SyncDevice $device,
        ?int $limit = null
    ): array {
        $limit ??= (int) config(
            'services.sync.batch_size',
            100
        );

        $queues = $this->queueService->pending(
            $device,
            $limit
        );

        $results = [
            'device_uuid' => $device->device_uuid,
            'total' => $queues->count(),
            'completed' => 0,
            'failed' => 0,
            'processing' => 0,
            'results' => [],
        ];

        foreach ($queues as $queue) {
            $result = $this->processQueueItem(
                $device,
                $queue
            );

            $results['results'][] = $result;

            if ($result['status'] === 'completed') {
                $results['completed']++;
            } elseif ($result['status'] === 'failed') {
                $results['failed']++;
            } elseif ($result['status'] === 'processing') {
                $results['processing']++;
            }
        }

        return $results;
    }


    /*
    |--------------------------------------------------------------------------
    | Process Individual Queue Item
    |--------------------------------------------------------------------------
    */

    public function processQueueItem(
        SyncDevice $device,
        SyncQueue $queue
    ): array {
        /*
        |--------------------------------------------------------------------------
        | Verify Ownership
        |--------------------------------------------------------------------------
        */

        if (
            (int) $queue->company_id !== (int) $device->company_id ||
            (int) $queue->device_id !== (int) $device->id
        ) {
            return [
                'queue_id' => $queue->id,
                'mutation_uuid' => $queue->mutation_uuid,
                'status' => 'failed',
                'message' => 'The queue item does not belong to this device.',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Mark Processing
        |--------------------------------------------------------------------------
        */

        $this->queueService->markProcessing($queue);

        try {
            $response = $this->sendMutation(
                $device,
                $queue
            );

            $result = $this->handleResponse(
                $queue,
                $response
            );

            return $result;

        } catch (ConnectionException $e) {
            return $this->handleFailure(
                $queue,
                'Synchronization server could not be reached.',
                $e
            );

        } catch (Throwable $e) {
            report($e);

            return $this->handleFailure(
                $queue,
                'Synchronization failed unexpectedly.',
                $e
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Send Mutation
    |--------------------------------------------------------------------------
    */

    protected function sendMutation(
        SyncDevice $device,
        SyncQueue $queue
    ): Response {
        $serverUrl = rtrim(
            (string) config('services.sync.server_url'),
            '/'
        );

        $endpoint = $serverUrl . '/api/sync/push';

        return Http::withHeaders([
            'Accept' => 'application/json',
            'X-Sync-Device' => $device->device_uuid,
            'X-Sync-Token' => $this->getSyncToken($device),
        ])
            ->connectTimeout(
                (int) config(
                    'services.sync.connect_timeout',
                    10
                )
            )
            ->timeout(
                (int) config(
                    'services.sync.timeout',
                    30
                )
            )
            ->post($endpoint, [
                'mutations' => [
                    [
                        'mutation_uuid' => $queue->mutation_uuid,
                        'entity' => $queue->entity,
                        'entity_sync_uuid' => $queue->entity_sync_uuid,
                        'operation' => $queue->operation,
                        'payload' => $queue->payload ?? [],
                    ],
                ],
            ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Handle Successful HTTP Response
    |--------------------------------------------------------------------------
    */

    protected function handleResponse(
        SyncQueue $queue,
        Response $response
    ): array {
        if (!$response->successful()) {
            $message = $this->responseErrorMessage(
                $response
            );

            return $this->handleFailure(
                $queue,
                $message
            );
        }

        $body = $response->json();

        if (
            !is_array($body) ||
            ($body['success'] ?? false) !== true
        ) {
            return $this->handleFailure(
                $queue,
                'Synchronization server returned an invalid response.'
            );
        }

        $mutationResult = $body['data']['results'][0] ?? null;

        if (!is_array($mutationResult)) {
            return $this->handleFailure(
                $queue,
                'Synchronization server did not return a mutation result.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Accepted / Completed
        |--------------------------------------------------------------------------
        */

        if (($mutationResult['accepted'] ?? false) === true) {
            $this->queueService->markCompleted($queue);

            return [
                'queue_id' => $queue->id,
                'mutation_uuid' => $queue->mutation_uuid,
                'status' => 'completed',
                'already_processed' =>
                    (bool) ($mutationResult['already_processed'] ?? false),
                'message' =>
                    $mutationResult['message']
                    ?? 'Mutation synchronized successfully.',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Server Rejected Mutation
        |--------------------------------------------------------------------------
        */

        return $this->handleFailure(
            $queue,
            $mutationResult['message']
                ?? 'Synchronization server rejected the mutation.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Handle Failure
    |--------------------------------------------------------------------------
    */

    protected function handleFailure(
        SyncQueue $queue,
        string $message,
        ?Throwable $exception = null
    ): array {
        $error = $exception
            ? $exception->getMessage()
            : $message;

        $retryDelay = (int) config(
            'services.sync.retry_delay',
            30
        );

        $this->queueService->markFailed(
            $queue,
            $error,
            $retryDelay
        );

        return [
            'queue_id' => $queue->id,
            'mutation_uuid' => $queue->mutation_uuid,
            'status' => 'failed',
            'message' => $message,
            'retry_after' => $retryDelay,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Response Error Message
    |--------------------------------------------------------------------------
    */

    protected function responseErrorMessage(
        Response $response
    ): string {
        $body = $response->json();

        if (
            is_array($body) &&
            isset($body['message']) &&
            is_string($body['message'])
        ) {
            return $body['message'];
        }

        return sprintf(
            'Synchronization server returned HTTP %d.',
            $response->status()
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Sync Token
    |--------------------------------------------------------------------------
    */

    protected function getSyncToken(
        SyncDevice $device
    ): string {
        /*
        |--------------------------------------------------------------------------
        | Important
        |--------------------------------------------------------------------------
        |
        | SyncDevice stores only the hashed token, so the original token
        | cannot be recovered from the database.
        |
        | The local installation therefore needs access to its original
        | sync token through secure server-side configuration.
        |
        |--------------------------------------------------------------------------
        */

        $token = config('services.sync.device_token');

        if (!$token) {
            throw new \RuntimeException(
                'The synchronization device token is not configured.'
            );
        }

        return $token;
    }
}

