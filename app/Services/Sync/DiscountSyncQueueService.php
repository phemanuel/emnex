<?php

namespace App\Services\Sync;

use App\Models\Discount;
use App\Models\SyncDevice;
use App\Models\SyncQueue;
use App\Services\Sync\Payloads\DiscountSyncPayloadBuilder;
use RuntimeException;

class DiscountSyncQueueService
{
    public function __construct(
        protected SyncQueueService $queue,
        protected DiscountSyncPayloadBuilder $payloadBuilder
    ) {
    }

    public function create(
        SyncDevice $device,
        Discount $discount
    ): SyncQueue {

        $this->validateDiscount(
            $device,
            $discount
        );

        return $this->queue->enqueue(
            device: $device,
            entity: 'discount',
            entitySyncUuid: $discount->sync_uuid,
            operation: SyncQueueService::OPERATION_CREATE,
            payload: $this->payloadBuilder->build($discount)
        );
    }

    public function update(
        SyncDevice $device,
        Discount $discount
    ): SyncQueue {

        $this->validateDiscount(
            $device,
            $discount
        );

        return $this->queue->enqueue(
            device: $device,
            entity: 'discount',
            entitySyncUuid: $discount->sync_uuid,
            operation: SyncQueueService::OPERATION_UPDATE,
            payload: $this->payloadBuilder->build($discount)
        );
    }

    public function delete(
        SyncDevice $device,
        Discount $discount
    ): SyncQueue {

        $this->validateDiscount(
            $device,
            $discount
        );

        return $this->queue->enqueue(
            device: $device,
            entity: 'discount',
            entitySyncUuid: $discount->sync_uuid,
            operation: SyncQueueService::OPERATION_DELETE,
            payload: []
        );
    }

    private function validateDiscount(
        SyncDevice $device,
        Discount $discount
    ): void {

        if (!$discount->sync_uuid) {
            throw new RuntimeException(
                "Discount [{$discount->id}] does not have a synchronization UUID."
            );
        }

        if (
            (int) $device->company_id
            !==
            (int) $discount->company_id
        ) {
            throw new RuntimeException(
                'The synchronization device and Discount belong to different companies.'
            );
        }
    }
}