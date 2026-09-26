<?php

namespace App\Services\Sync;

use App\Models\SyncDevice;
use App\Models\SyncLog;
use App\Models\SyncMutation;
use Illuminate\Database\QueryException;

class SyncApiService
{
    public function __construct(
        protected SyncIdempotencyService $idempotency
    ) {
    }

    /**
     * Accept one synchronization mutation.
     *
     * Module-specific mutation handling will be attached later.
     */
    public function push(
        SyncDevice $device,
        array $mutation
    ): array {
        $startedAt = microtime(true);

        $mutationUuid = $mutation['mutation_uuid'];
        $entitySyncUuid = $mutation['entity_sync_uuid'];
        $entity = $mutation['entity'];
        $operation = $mutation['operation'];

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
            $response = $this->duplicateResponse($existing);

            $this->writeLog(
                $device,
                $mutation,
                $response['accepted'] ?? false
                    ? 'duplicate'
                    : 'failed',
                $response['message'] ?? 'Existing mutation returned.',
                null,
                $this->durationMs($startedAt)
            );

            return $response;
        }

        /*
        |--------------------------------------------------------------------------
        | Begin Mutation
        |--------------------------------------------------------------------------
        |
        | The unique mutation_uuid constraint protects us if two
        | identical requests arrive at the same time.
        |
        */

        try {
            $syncMutation = $this->idempotency->begin(
                $device,
                $mutationUuid,
                $entity,
                $entitySyncUuid,
                $operation,
                $mutation['payload'] ?? []
            );
        } catch (QueryException $e) {
            /*
            |--------------------------------------------------------------------------
            | Concurrent Duplicate
            |--------------------------------------------------------------------------
            |
            | Another request may have inserted the same mutation between
            | our initial lookup and this insert.
            |
            */

            $existing = $this->idempotency->find(
                $device,
                $mutationUuid
            );

            if ($existing) {
                $response = $this->duplicateResponse($existing);

                $this->writeLog(
                    $device,
                    $mutation,
                    $response['accepted'] ?? false
                        ? 'duplicate'
                        : 'failed',
                    $response['message'] ?? 'Existing mutation returned.',
                    null,
                    $this->durationMs($startedAt)
                );

                return $response;
            }

            throw $e;
        }

        /*
        |--------------------------------------------------------------------------
        | Module Processing
        |--------------------------------------------------------------------------
        |
        | We deliberately do not process Products, Orders, Payments,
        | Stock, Returns, etc. here yet.
        |
        */

        try {
            $response = [
                'mutation_uuid' => $mutationUuid,
                'entity_sync_uuid' => $entitySyncUuid,
                'accepted' => true,
                'processed' => false,
                'message' => 'Mutation accepted by synchronization foundation.',
            ];

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

    /**
     * Return the result of a previously processed mutation.
     */
    protected function duplicateResponse(
        SyncMutation $mutation
    ): array {
        if ($mutation->status === 'completed') {
            return [
                ...($mutation->response ?? []),
                'mutation_uuid' => $mutation->mutation_uuid,
                'accepted' => true,
                'already_processed' => true,
            ];
        }

        if ($mutation->status === 'processing') {
            return [
                'mutation_uuid' => $mutation->mutation_uuid,
                'accepted' => true,
                'already_processed' => false,
                'processing' => true,
                'message' => 'This mutation is currently being processed.',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Failed Mutation
        |--------------------------------------------------------------------------
        |
        | The mutation identity remains the same. A later request can
        | retry using the same mutation_uuid.
        |
        */

        return [
            'mutation_uuid' => $mutation->mutation_uuid,
            'accepted' => false,
            'already_processed' => false,
            'failed' => true,
            'message' => 'This mutation previously failed and may be retried.',
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
            'company_id' => $device->company_id,
            'device_id' => $device->id,
            'mutation_uuid' => $mutation['mutation_uuid'] ?? null,
            'entity_sync_uuid' => $mutation['entity_sync_uuid'] ?? null,
            'entity' => $mutation['entity'] ?? null,
            'operation' => $mutation['operation'] ?? null,
            'direction' => 'push',
            'status' => $status,
            'message' => $message,
            'error' => $error,
            'duration_ms' => $durationMs,
        ]);
    }

    /**
     * Calculate elapsed processing time in milliseconds.
     */
    protected function durationMs(float $startedAt): int
    {
        return (int) round(
            (microtime(true) - $startedAt) * 1000
        );
    }
}

