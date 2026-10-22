<?php

namespace App\Services\Sync;

use App\Models\Order;
use App\Models\SyncDevice;
use App\Models\SyncQueue;
use RuntimeException;

class CompletedSaleSyncQueueService
{
    public function __construct(
        protected SyncQueueService $syncQueueService,
        protected CompletedSaleSyncPayloadBuilder $payloadBuilder
    ) {
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create(
        SyncDevice $device,
        Order $order
    ): SyncQueue {
        return $this->enqueue(
            $device,
            $order,
            'create'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        SyncDevice $device,
        Order $order
    ): SyncQueue {
        return $this->enqueue(
            $device,
            $order,
            'update'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Enqueue
    |--------------------------------------------------------------------------
    */

    protected function enqueue(
        SyncDevice $device,
        Order $order,
        string $operation
    ): SyncQueue {
        if (
            (int) $device->company_id
            !==
            (int) $order->company_id
        ) {
            throw new RuntimeException(
                'The sync device and sale do not belong to the same company.'
            );
        }

        if (empty($order->sync_uuid)) {
            throw new RuntimeException(
                "Order [{$order->id}] does not have a sync UUID."
            );
        }

        if ($order->order_status !== 'Completed') {
            throw new RuntimeException(
                "Order [{$order->id}] is not completed and cannot be queued as a completed sale."
            );
        }

        $payload =
            $this->payloadBuilder->build(
                $order
            );

        return $this->syncQueueService->enqueue(
            $device,
            'sale',
            $order->sync_uuid,
            $operation,
            $payload
        );
    }
}