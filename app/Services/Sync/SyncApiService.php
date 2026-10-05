<?php

namespace App\Services\Sync;

use App\Models\SyncDevice;
use App\Models\SyncLog;
use App\Models\SyncMutation;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class SyncApiService
{
    public function __construct(
        protected SyncIdempotencyService $idempotency,
        protected SyncHandlerResolver $handlers
    ) {
    }


    /**
     * Accept one synchronization mutation.
     */
    public function push(
        SyncDevice $device,
        array $mutation
    ): array {
        $startedAt = microtime(true);

        $mutationUuid =
            $mutation['mutation_uuid'];

        $entitySyncUuid =
            $mutation['entity_sync_uuid'];

        $entity =
            strtolower(
                trim($mutation['entity'])
            );

        $operation =
            strtolower(
                trim($mutation['operation'])
            );

        $payload =
            $mutation['payload'] ?? [];


        /*
        |--------------------------------------------------------------------------
        | Existing Mutation
        |--------------------------------------------------------------------------
        */

        $existing = $this->idempotency->find(
            $device,
            $mutationUuid
        );

        if ($existing) {

            /*
            |--------------------------------------------------------------------------
            | Failed Mutation Retry
            |--------------------------------------------------------------------------
            |
            | Failed mutations retain the same mutation_uuid and are allowed
            | to re-enter processing.
            |
            */

            if ($existing->status === 'failed') {

                $syncMutation =
                    $this->idempotency->retry(
                        $existing
                    );

            } else {

                $response =
                    $this->duplicateResponse(
                        $existing
                    );

                $this->writeLog(
                    $device,
                    $mutation,
                    $response['accepted'] ?? false
                        ? 'duplicate'
                        : 'failed',
                    $response['message']
                        ?? 'Existing mutation returned.',
                    null,
                    $this->durationMs($startedAt)
                );

                return $response;
            }

        } else {

            /*
            |--------------------------------------------------------------------------
            | Begin Mutation
            |--------------------------------------------------------------------------
            |
            | The unique mutation_uuid constraint protects against two
            | identical requests being inserted concurrently.
            |
            */

            try {

                $syncMutation =
                    $this->idempotency->begin(
                        $device,
                        $mutationUuid,
                        $entity,
                        $entitySyncUuid,
                        $operation,
                        $payload
                    );

            } catch (QueryException $e) {

                /*
                |--------------------------------------------------------------------------
                | Concurrent Duplicate
                |--------------------------------------------------------------------------
                */

                $existing =
                    $this->idempotency->find(
                        $device,
                        $mutationUuid
                    );

                if (!$existing) {
                    throw $e;
                }

                /*
                |--------------------------------------------------------------------------
                | Concurrent Failed Mutation
                |--------------------------------------------------------------------------
                */

                if ($existing->status === 'failed') {

                    $syncMutation =
                        $this->idempotency->retry(
                            $existing
                        );

                } else {

                    $response =
                        $this->duplicateResponse(
                            $existing
                        );

                    $this->writeLog(
                        $device,
                        $mutation,
                        $response['accepted'] ?? false
                            ? 'duplicate'
                            : 'failed',
                        $response['message']
                            ?? 'Existing mutation returned.',
                        null,
                        $this->durationMs($startedAt)
                    );

                    return $response;
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Unsupported / Not Yet Attached Entity
        |--------------------------------------------------------------------------
        |
        | Preserve the existing synchronization foundation behaviour until
        | a real module handler has been registered.
        |
        */

        if (!$this->handlers->supports($entity)) {

            $response = [
                'mutation_uuid' =>
                    $mutationUuid,

                'entity_sync_uuid' =>
                    $entitySyncUuid,

                'accepted' =>
                    true,

                'processed' =>
                    false,

                'message' =>
                    'Mutation accepted by synchronization foundation.',
            ];

            try {

                $this->idempotency->complete(
                    $syncMutation,
                    $response
                );

                $this->writeLog(
                    $device,
                    $mutation,
                    'completed',
                    $response['message'],
                    null,
                    $this->durationMs($startedAt)
                );

                return $response;

            } catch (\Throwable $e) {

                $this->idempotency->fail(
                    $syncMutation,
                    $e->getMessage()
                );

                $this->writeLog(
                    $device,
                    $mutation,
                    'failed',
                    'The mutation could not be processed.',
                    $e->getMessage(),
                    $this->durationMs($startedAt)
                );

                throw $e;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Module Processing
        |--------------------------------------------------------------------------
        */

        try {

            $response = DB::transaction(
                function () use (
                    $device,
                    $mutation,
                    $syncMutation,
                    $mutationUuid,
                    $entitySyncUuid,
                    $entity,
                    $operation,
                    $payload,
                    $startedAt
                ): array {

                    $handler =
                        $this->handlers->resolve(
                            $entity
                        );

                    /*
                    |--------------------------------------------------------------------------
                    | Execute Operation
                    |--------------------------------------------------------------------------
                    */

                    $result = match ($operation) {

                        'create' =>
                            $handler->create(
                                $entitySyncUuid,
                                $payload,
                                $device
                            ),

                        'update' =>
                            $handler->update(
                                $entitySyncUuid,
                                $payload,
                                $device
                            ),

                        'delete' =>
                            $handler->delete(
                                $entitySyncUuid,
                                $payload,
                                $device
                            ),

                        default =>
                            throw new \InvalidArgumentException(
                                "Unsupported synchronization operation [{$operation}]."
                            ),
                    };


                    /*
                    |--------------------------------------------------------------------------
                    | Successful Response
                    |--------------------------------------------------------------------------
                    */

                    $response = [
                        'mutation_uuid' =>
                            $mutationUuid,

                        'entity_sync_uuid' =>
                            $entitySyncUuid,

                        'accepted' =>
                            true,

                        'processed' =>
                            true,

                        'result' =>
                            $result,

                        'message' =>
                            'Mutation processed successfully.',
                    ];


                    /*
                    |--------------------------------------------------------------------------
                    | Complete Mutation
                    |--------------------------------------------------------------------------
                    */

                    $this->idempotency->complete(
                        $syncMutation,
                        $response
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Success Log
                    |--------------------------------------------------------------------------
                    */

                    $this->writeLog(
                        $device,
                        $mutation,
                        'completed',
                        $response['message'],
                        null,
                        $this->durationMs($startedAt)
                    );


                    return $response;
                }
            );

            return $response;

        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Mark Mutation Failed
            |--------------------------------------------------------------------------
            |
            | The business transaction has already rolled back at this point.
            | The failed SyncMutation is intentionally stored outside that
            | transaction so the failure remains available for retry.
            |
            */

            $this->idempotency->fail(
                $syncMutation,
                $e->getMessage()
            );


            /*
            |--------------------------------------------------------------------------
            | Failure Log
            |--------------------------------------------------------------------------
            */

            $this->writeLog(
                $device,
                $mutation,
                'failed',
                'The mutation could not be processed.',
                $e->getMessage(),
                $this->durationMs($startedAt)
            );

            throw $e;
        }
    }


    /**
     * Return the result of a previously processed mutation.
     */
    protected function duplicateResponse(
        SyncMutation $mutation
    ): array {
        if ($mutation->status === 'completed') {

            return [
                ...($mutation->response ?? []),

                'mutation_uuid' =>
                    $mutation->mutation_uuid,

                'accepted' =>
                    true,

                'already_processed' =>
                    true,
            ];
        }


        if ($mutation->status === 'processing') {

            return [
                'mutation_uuid' =>
                    $mutation->mutation_uuid,

                'accepted' =>
                    true,

                'already_processed' =>
                    false,

                'processing' =>
                    true,

                'message' =>
                    'This mutation is currently being processed.',
            ];
        }


        return [
            'mutation_uuid' =>
                $mutation->mutation_uuid,

            'accepted' =>
                false,

            'already_processed' =>
                false,

            'failed' =>
                true,

            'message' =>
                'This mutation previously failed and may be retried.',
        ];
    }


    /**
     * Write synchronization audit information.
     */
    protected function writeLog(
        SyncDevice $device,
        array $mutation,
        string $status,
        ?string $message = null,
        ?string $error = null,
        ?int $durationMs = null
    ): void {
        SyncLog::create([
            'company_id' =>
                $device->company_id,

            'device_id' =>
                $device->id,

            'mutation_uuid' =>
                $mutation['mutation_uuid'] ?? null,

            'entity_sync_uuid' =>
                $mutation['entity_sync_uuid'] ?? null,

            'entity' =>
                $mutation['entity'] ?? null,

            'operation' =>
                $mutation['operation'] ?? null,

            'direction' =>
                'push',

            'status' =>
                $status,

            'message' =>
                $message,

            'error' =>
                $error,

            'duration_ms' =>
                $durationMs,
        ]);
    }


    /**
     * Calculate elapsed processing time in milliseconds.
     */
    protected function durationMs(
        float $startedAt
    ): int {
        return (int) round(
            (microtime(true) - $startedAt) * 1000
        );
    }
}