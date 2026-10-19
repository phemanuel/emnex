<?php

namespace App\Services\Sync;

use App\Models\SyncDevice;
use App\Models\SyncQueue;
use App\Models\Terminal;
use App\Services\Sync\Payloads\TerminalSyncPayloadBuilder;
use RuntimeException;

class TerminalSyncQueueService
{
    public function __construct(
        protected SyncQueueService $queue,
        protected TerminalSyncPayloadBuilder $payloadBuilder
    ) {}

    public function create(
        SyncDevice $device,
        Terminal $terminal
    ): SyncQueue {

        $this->validateTerminal(
            $device,
            $terminal
        );

        $payload =
            $this->payloadBuilder->build(
                $terminal
            );

        return $this->queue->enqueue(
            device: $device,
            entity: 'terminal',
            entitySyncUuid: $terminal->sync_uuid,
            operation: SyncQueueService::OPERATION_CREATE,
            payload: $payload
        );
    }

    public function update(
        SyncDevice $device,
        Terminal $terminal
    ): SyncQueue {

        $this->validateTerminal(
            $device,
            $terminal
        );

        $payload =
            $this->payloadBuilder->build(
                $terminal
            );

        return $this->queue->enqueue(
            device: $device,
            entity: 'terminal',
            entitySyncUuid: $terminal->sync_uuid,
            operation: SyncQueueService::OPERATION_UPDATE,
            payload: $payload
        );
    }

    public function delete(
        SyncDevice $device,
        Terminal $terminal
    ): SyncQueue {

        $this->validateTerminal(
            $device,
            $terminal
        );

        return $this->queue->enqueue(
            device: $device,
            entity: 'terminal',
            entitySyncUuid: $terminal->sync_uuid,
            operation: SyncQueueService::OPERATION_DELETE,
            payload: []
        );
    }

    private function validateTerminal(
        SyncDevice $device,
        Terminal $terminal
    ): void {

        if (! $terminal->sync_uuid) {

            throw new RuntimeException(
                "Terminal [{$terminal->id}] does not have a synchronization UUID."
            );
        }

        if (
            (int) $device->company_id !==
            (int) $terminal->company_id
        ) {

            throw new RuntimeException(
                'The synchronization device and Terminal belong to different companies.'
            );
        }
    }
}