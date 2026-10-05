<?php

namespace App\Services\Sync;

use App\Models\SyncDevice;
use App\Models\SyncMutation;

class SyncIdempotencyService
{
    /**
     * Find an existing mutation for the authenticated device.
     */
    public function find(
        SyncDevice $device,
        string $mutationUuid
    ): ?SyncMutation {
        return SyncMutation::query()
            ->where('company_id', $device->company_id)
            ->where('device_id', $device->id)
            ->where('mutation_uuid', $mutationUuid)
            ->first();
    }

    /**
     * Create the mutation record before processing.
     *
     * The unique mutation_uuid constraint protects against
     * duplicate requests arriving at the same time.
     */
    public function begin(
        SyncDevice $device,
        string $mutationUuid,
        string $entity,
        string $entitySyncUuid,
        string $operation,
        array $payload
    ): SyncMutation {
        return SyncMutation::create([
            'company_id' => $device->company_id,
            'device_id' => $device->id,
            'mutation_uuid' => $mutationUuid,
            'entity' => $entity,
            'entity_sync_uuid' => $entitySyncUuid,
            'operation' => $operation,
            'payload' => $payload,
            'status' => 'processing',
        ]);
    }

    /**
     * Mark the mutation as successfully processed.
     */
    public function complete(
        SyncMutation $mutation,
        array $response
    ): void {
        $mutation->forceFill([
            'status' => 'completed',
            'response' => $response,
            'error' => null,
            'processed_at' => now(),
        ])->save();
    }

    /**
     * Mark the mutation as failed.
     */
    public function fail(
        SyncMutation $mutation,
        string $error
    ): void {
        $mutation->forceFill([
            'status' => 'failed',
            'error' => $error,
        ])->save();
    }

    /**
     * Return the stored response from a completed mutation.
     */
    public function storedResponse(
        SyncMutation $mutation
    ): ?array {
        if ($mutation->status !== 'completed') {
            return null;
        }

        return $mutation->response;
    }

    /**
     * Prepare a previously failed mutation for another processing attempt.
     */
    public function retry(
        SyncMutation $mutation
    ): SyncMutation {
        if ($mutation->status !== 'failed') {
            throw new \LogicException(
                "Only failed synchronization mutations can be retried."
            );
        }

        $mutation->forceFill([
            'status' => 'processing',
            'response' => null,
            'error' => null,
            'processed_at' => null,
        ])->save();

        return $mutation;
    }
}

