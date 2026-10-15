<?php

namespace App\Services\Sync;

use App\Models\Product;
use App\Models\SyncDevice;
use App\Models\SyncQueue;
use App\Services\Sync\Payloads\ProductSyncPayloadBuilder;
use RuntimeException;


class ProductSyncQueueService
{
    public function __construct(
        protected SyncQueueService $queue,
        protected ProductSyncPayloadBuilder $payloadBuilder
    ) {
    }


    /*
    |--------------------------------------------------------------------------
    | Queue Product Create
    |--------------------------------------------------------------------------
    */

    public function create(
        SyncDevice $device,
        Product $product
    ): SyncQueue {

        $this->validateProduct(
            $device,
            $product
        );


        /*
        |--------------------------------------------------------------------------
        | Build Portable Product Snapshot
        |--------------------------------------------------------------------------
        */

        $payload =
            $this->payloadBuilder
                ->build(
                    $product
                );


        /*
        |--------------------------------------------------------------------------
        | Queue Mutation
        |--------------------------------------------------------------------------
        */

        return $this->queue->enqueue(

            device:
                $device,

            entity:
                'product',

            entitySyncUuid:
                $product->sync_uuid,

            operation:
                SyncQueueService::OPERATION_CREATE,

            payload:
                $payload

        );
    }


    /*
    |--------------------------------------------------------------------------
    | Queue Product Update
    |--------------------------------------------------------------------------
    */

    public function update(
        SyncDevice $device,
        Product $product
    ): SyncQueue {

        $this->validateProduct(
            $device,
            $product
        );


        /*
        |--------------------------------------------------------------------------
        | Build Portable Product Snapshot
        |--------------------------------------------------------------------------
        */

        $payload =
            $this->payloadBuilder
                ->build(
                    $product
                );


        /*
        |--------------------------------------------------------------------------
        | Queue Mutation
        |--------------------------------------------------------------------------
        */

        return $this->queue->enqueue(

            device:
                $device,

            entity:
                'product',

            entitySyncUuid:
                $product->sync_uuid,

            operation:
                SyncQueueService::OPERATION_UPDATE,

            payload:
                $payload

        );
    }


    /*
    |--------------------------------------------------------------------------
    | Queue Product Delete
    |--------------------------------------------------------------------------
    */

    public function delete(
        SyncDevice $device,
        Product $product
    ): SyncQueue {

        $this->validateProduct(
            $device,
            $product
        );


        /*
        |--------------------------------------------------------------------------
        | Delete Payload
        |--------------------------------------------------------------------------
        |
        | The receiving side identifies the Product entirely through
        | entity_sync_uuid.
        |
        | No Product snapshot is necessary for deletion.
        |
        */

        return $this->queue->enqueue(

            device:
                $device,

            entity:
                'product',

            entitySyncUuid:
                $product->sync_uuid,

            operation:
                SyncQueueService::OPERATION_DELETE,

            payload:
                []

        );
    }


    /*
    |--------------------------------------------------------------------------
    | Validate Product For Device
    |--------------------------------------------------------------------------
    */

    private function validateProduct(
        SyncDevice $device,
        Product $product
    ): void {

        /*
        |--------------------------------------------------------------------------
        | Synchronization Identity
        |--------------------------------------------------------------------------
        */

        if (!$product->sync_uuid) {

            throw new RuntimeException(
                "Product [{$product->id}] does not have a synchronization UUID."
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Company Isolation
        |--------------------------------------------------------------------------
        |
        | A synchronization device must never queue a Product belonging to
        | another company.
        |
        */

        if (
            (int) $device->company_id
            !==
            (int) $product->company_id
        ) {

            throw new RuntimeException(
                'The synchronization device and Product belong to different companies.'
            );
        }
    }
}