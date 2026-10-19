<?php

namespace App\Services\Sync;

use App\Models\Branch;
use App\Models\SyncDevice;
use App\Models\SyncQueue;
use App\Services\Sync\Payloads\BranchSyncPayloadBuilder;
use RuntimeException;

class BranchSyncQueueService
{
    public function __construct(
        protected SyncQueueService $queue,
        protected BranchSyncPayloadBuilder $payloadBuilder
    ) {
    }


    /*
    |--------------------------------------------------------------------------
    | Queue Branch Create
    |--------------------------------------------------------------------------
    */

    public function create(
        SyncDevice $device,
        Branch $branch
    ): SyncQueue {

        $this->validateBranch(
            $device,
            $branch
        );

        $payload =
            $this->payloadBuilder
                ->build(
                    $branch
                );

        return $this->queue->enqueue(

            device:
                $device,

            entity:
                'branch',

            entitySyncUuid:
                $branch->sync_uuid,

            operation:
                SyncQueueService::OPERATION_CREATE,

            payload:
                $payload

        );
    }


    /*
    |--------------------------------------------------------------------------
    | Queue Branch Update
    |--------------------------------------------------------------------------
    */

    public function update(
        SyncDevice $device,
        Branch $branch
    ): SyncQueue {

        $this->validateBranch(
            $device,
            $branch
        );

        $payload =
            $this->payloadBuilder
                ->build(
                    $branch
                );

        return $this->queue->enqueue(

            device:
                $device,

            entity:
                'branch',

            entitySyncUuid:
                $branch->sync_uuid,

            operation:
                SyncQueueService::OPERATION_UPDATE,

            payload:
                $payload

        );
    }


    /*
    |--------------------------------------------------------------------------
    | Queue Branch Delete
    |--------------------------------------------------------------------------
    */

    public function delete(
        SyncDevice $device,
        Branch $branch
    ): SyncQueue {

        $this->validateBranch(
            $device,
            $branch
        );

        return $this->queue->enqueue(

            device:
                $device,

            entity:
                'branch',

            entitySyncUuid:
                $branch->sync_uuid,

            operation:
                SyncQueueService::OPERATION_DELETE,

            payload:
                []

        );
    }


    /*
    |--------------------------------------------------------------------------
    | Validate Branch For Device
    |--------------------------------------------------------------------------
    */

    private function validateBranch(
        SyncDevice $device,
        Branch $branch
    ): void {

        if (!$branch->sync_uuid) {

            throw new RuntimeException(
                "Branch [{$branch->id}] does not have a synchronization UUID."
            );
        }

        if (
            (int) $device->company_id
            !==
            (int) $branch->company_id
        ) {

            throw new RuntimeException(
                'The synchronization device and Branch belong to different companies.'
            );
        }
    }
}