<?php

namespace App\Services\Sync;

use App\Models\SyncDevice;
use App\Models\SyncQueue;
use Illuminate\Support\Str;
use RuntimeException;

class SyncQueueService
{
    /*
    |--------------------------------------------------------------------------
    | Queue Statuses
    |--------------------------------------------------------------------------
    */

    public const STATUS_PENDING = 'pending';

    public const STATUS_PROCESSING = 'processing';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_FAILED = 'failed';


    /*
    |--------------------------------------------------------------------------
    | Mutation Operations
    |--------------------------------------------------------------------------
    */

    public const OPERATION_CREATE = 'create';

    public const OPERATION_UPDATE = 'update';

    public const OPERATION_DELETE = 'delete';


    /*
    |--------------------------------------------------------------------------
    | Enqueue Mutation
    |--------------------------------------------------------------------------
    */

    public function enqueue(
        SyncDevice $device,
        string $entity,
        string $entitySyncUuid,
        string $operation,
        array $payload = [],
        ?string $mutationUuid = null
    ): SyncQueue {
        $this->validateOperation($operation);

        return SyncQueue::create([
            'company_id' => $device->company_id,
            'device_id' => $device->id,

            'mutation_uuid' => $mutationUuid ?: (string) Str::uuid(),

            'entity' => $entity,
            'entity_sync_uuid' => $entitySyncUuid,
            'operation' => $operation,

            'payload' => $payload,

            'status' => self::STATUS_PENDING,
            'attempts' => 0,

            'available_at' => now(),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Get Pending Queue
    |--------------------------------------------------------------------------
    */

    public function pending(
        SyncDevice $device,
        int $limit = 100
    ) {
        return SyncQueue::query()
            ->where('company_id', $device->company_id)
            ->where('device_id', $device->id)
            ->where('status', self::STATUS_PENDING)
            ->where(function ($query) {
                $query
                    ->whereNull('available_at')
                    ->orWhere('available_at', '<=', now());
            })
            ->orderBy('id')
            ->limit($limit)
            ->get();
    }


    /*
    |--------------------------------------------------------------------------
    | Mark Processing
    |--------------------------------------------------------------------------
    */

    public function markProcessing(
        SyncQueue $queue
    ): void {
        $queue->forceFill([
            'status' => self::STATUS_PROCESSING,
            'attempts' => $queue->attempts + 1,
            'processing_started_at' => now(),
            'last_error' => null,
        ])->save();
    }


    /*
    |--------------------------------------------------------------------------
    | Mark Completed
    |--------------------------------------------------------------------------
    */

    public function markCompleted(
        SyncQueue $queue
    ): void {
        $queue->forceFill([
            'status' => self::STATUS_COMPLETED,
            'processed_at' => now(),
            'failed_at' => null,
            'last_error' => null,
        ])->save();
    }


    /*
    |--------------------------------------------------------------------------
    | Mark Failed
    |--------------------------------------------------------------------------
    */

    public function markFailed(
        SyncQueue $queue,
        string $error,
        ?int $retryAfterSeconds = null
    ): void {
        $queue->forceFill([
            'status' => self::STATUS_FAILED,
            'failed_at' => now(),
            'last_error' => $error,
            'available_at' => $retryAfterSeconds !== null
                ? now()->addSeconds($retryAfterSeconds)
                : null,
        ])->save();
    }


    /*
    |--------------------------------------------------------------------------
    | Retry
    |--------------------------------------------------------------------------
    */

    public function retry(
        SyncQueue $queue,
        ?int $delaySeconds = 0
    ): void {
        $queue->forceFill([
            'status' => self::STATUS_PENDING,
            'processing_started_at' => null,
            'processed_at' => null,
            'failed_at' => null,
            'last_error' => null,
            'available_at' => $delaySeconds > 0
                ? now()->addSeconds($delaySeconds)
                : now(),
        ])->save();
    }


    /*
    |--------------------------------------------------------------------------
    | Pending Count
    |--------------------------------------------------------------------------
    */

    public function pendingCount(
        SyncDevice $device
    ): int {
        return SyncQueue::query()
            ->where('company_id', $device->company_id)
            ->where('device_id', $device->id)
            ->where('status', self::STATUS_PENDING)
            ->count();
    }


    /*
    |--------------------------------------------------------------------------
    | Failed Count
    |--------------------------------------------------------------------------
    */

    public function failedCount(
        SyncDevice $device
    ): int {
        return SyncQueue::query()
            ->where('company_id', $device->company_id)
            ->where('device_id', $device->id)
            ->where('status', self::STATUS_FAILED)
            ->count();
    }


    /*
    |--------------------------------------------------------------------------
    | Validate Operation
    |--------------------------------------------------------------------------
    */

    protected function validateOperation(
        string $operation
    ): void {
        if (!in_array($operation, [
            self::OPERATION_CREATE,
            self::OPERATION_UPDATE,
            self::OPERATION_DELETE,
        ], true)) {
            throw new RuntimeException(
                'Invalid synchronization operation.'
            );
        }
    }
}

