<?php

namespace App\Services\Sync;

use App\Models\SyncDevice;
use App\Models\SyncQueue;
use App\Models\Unit;
use App\Services\Sync\Payloads\UnitSyncPayloadBuilder;
use RuntimeException;

class UnitSyncQueueService
{
    public function __construct(
        protected SyncQueueService $queue,
        protected UnitSyncPayloadBuilder $payloadBuilder
    ) {
    }


    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create(
        SyncDevice $device,
        Unit $unit
    ): SyncQueue {

        $this->validateUnit(
            $device,
            $unit
        );

        return $this->queue->enqueue(

            device:
                $device,

            entity:
                'unit',

            entitySyncUuid:
                $unit->sync_uuid,

            operation:
                SyncQueueService::OPERATION_CREATE,

            payload:
                $this->payloadBuilder->build(
                    $unit
                )

        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        SyncDevice $device,
        Unit $unit
    ): SyncQueue {

        $this->validateUnit(
            $device,
            $unit
        );

        return $this->queue->enqueue(

            device:
                $device,

            entity:
                'unit',

            entitySyncUuid:
                $unit->sync_uuid,

            operation:
                SyncQueueService::OPERATION_UPDATE,

            payload:
                $this->payloadBuilder->build(
                    $unit
                )

        );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function delete(
        SyncDevice $device,
        Unit $unit
    ): SyncQueue {

        $this->validateUnit(
            $device,
            $unit
        );

        return $this->queue->enqueue(

            device:
                $device,

            entity:
                'unit',

            entitySyncUuid:
                $unit->sync_uuid,

            operation:
                SyncQueueService::OPERATION_DELETE,

            payload:
                []

        );
    }


    /*
    |--------------------------------------------------------------------------
    | Validate
    |--------------------------------------------------------------------------
    */

    private function validateUnit(
        SyncDevice $device,
        Unit $unit
    ): void {

        if (!$unit->sync_uuid) {

            throw new RuntimeException(
                "Unit [{$unit->id}] does not have a synchronization UUID."
            );
        }

        if (
            (int) $device->company_id
            !==
            (int) $unit->company_id
        ) {

            throw new RuntimeException(
                'The synchronization device and Unit belong to different companies.'
            );
        }
    }
}