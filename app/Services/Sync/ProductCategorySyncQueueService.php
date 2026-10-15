<?php

namespace App\Services\Sync;

use App\Models\ProductCategory;
use App\Models\SyncDevice;
use App\Models\SyncQueue;
use App\Services\Sync\Payloads\ProductCategorySyncPayloadBuilder;
use RuntimeException;

class ProductCategorySyncQueueService
{
    public function __construct(
        protected SyncQueueService $queue,
        protected ProductCategorySyncPayloadBuilder $payloadBuilder
    ) {
    }

    public function create(
        SyncDevice $device,
        ProductCategory $category
    ): SyncQueue {

        $this->validateCategory(
            $device,
            $category
        );

        return $this->queue->enqueue(
            device: $device,
            entity: 'product_category',
            entitySyncUuid: $category->sync_uuid,
            operation: SyncQueueService::OPERATION_CREATE,
            payload: $this->payloadBuilder->build($category)
        );
    }

    public function update(
        SyncDevice $device,
        ProductCategory $category
    ): SyncQueue {

        $this->validateCategory(
            $device,
            $category
        );

        return $this->queue->enqueue(
            device: $device,
            entity: 'product_category',
            entitySyncUuid: $category->sync_uuid,
            operation: SyncQueueService::OPERATION_UPDATE,
            payload: $this->payloadBuilder->build($category)
        );
    }

    public function delete(
        SyncDevice $device,
        ProductCategory $category
    ): SyncQueue {

        $this->validateCategory(
            $device,
            $category
        );

        return $this->queue->enqueue(
            device: $device,
            entity: 'product_category',
            entitySyncUuid: $category->sync_uuid,
            operation: SyncQueueService::OPERATION_DELETE,
            payload: []
        );
    }

    private function validateCategory(
        SyncDevice $device,
        ProductCategory $category
    ): void {

        if (!$category->sync_uuid) {
            throw new RuntimeException(
                "Product category [{$category->id}] does not have a synchronization UUID."
            );
        }

        if (
            (int) $device->company_id
            !==
            (int) $category->company_id
        ) {
            throw new RuntimeException(
                'The synchronization device and Product Category belong to different companies.'
            );
        }
    }
}