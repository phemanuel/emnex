<?php

namespace App\Services\Sync;

use App\Models\SyncDevice;
use App\Models\SyncQueue;
use App\Models\TaxRate;
use App\Services\Sync\Payloads\TaxRateSyncPayloadBuilder;
use RuntimeException;

class TaxRateSyncQueueService
{
    public function __construct(
        protected SyncQueueService $queue,
        protected TaxRateSyncPayloadBuilder $payloadBuilder
    ) {
    }

    public function create(
        SyncDevice $device,
        TaxRate $taxRate
    ): SyncQueue {

        $this->validateTaxRate(
            $device,
            $taxRate
        );

        return $this->queue->enqueue(
            device: $device,
            entity: 'tax_rate',
            entitySyncUuid: $taxRate->sync_uuid,
            operation: SyncQueueService::OPERATION_CREATE,
            payload: $this->payloadBuilder->build($taxRate)
        );
    }

    public function update(
        SyncDevice $device,
        TaxRate $taxRate
    ): SyncQueue {

        $this->validateTaxRate(
            $device,
            $taxRate
        );

        return $this->queue->enqueue(
            device: $device,
            entity: 'tax_rate',
            entitySyncUuid: $taxRate->sync_uuid,
            operation: SyncQueueService::OPERATION_UPDATE,
            payload: $this->payloadBuilder->build($taxRate)
        );
    }

    public function delete(
        SyncDevice $device,
        TaxRate $taxRate
    ): SyncQueue {

        $this->validateTaxRate(
            $device,
            $taxRate
        );

        return $this->queue->enqueue(
            device: $device,
            entity: 'tax_rate',
            entitySyncUuid: $taxRate->sync_uuid,
            operation: SyncQueueService::OPERATION_DELETE,
            payload: []
        );
    }

    private function validateTaxRate(
        SyncDevice $device,
        TaxRate $taxRate
    ): void {

        if (!$taxRate->sync_uuid) {
            throw new RuntimeException(
                "Tax rate [{$taxRate->id}] does not have a synchronization UUID."
            );
        }

        if (
            (int) $device->company_id
            !==
            (int) $taxRate->company_id
        ) {
            throw new RuntimeException(
                'The synchronization device and Tax Rate belong to different companies.'
            );
        }
    }
}