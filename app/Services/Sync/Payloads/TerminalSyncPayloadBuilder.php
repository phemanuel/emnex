<?php

namespace App\Services\Sync\Payloads;

use App\Models\Terminal;
use RuntimeException;

class TerminalSyncPayloadBuilder
{
    public function build(Terminal $terminal): array
    {
        $terminal->loadMissing('branch');

        if (! $terminal->branch) {
            throw new RuntimeException(
                "Terminal [{$terminal->id}] does not have a valid branch."
            );
        }

        if (! $terminal->branch->sync_uuid) {
            throw new RuntimeException(
                "Branch [{$terminal->branch->id}] does not have a synchronization UUID."
            );
        }

        return [
            'branch_sync_uuid' =>
                $terminal->branch->sync_uuid,

            'terminal_code' =>
                $terminal->terminal_code,

            'terminal_name' =>
                $terminal->terminal_name,

            'description' =>
                $terminal->description,

            'device_name' =>
                $terminal->device_name,

            'ip_address' =>
                $terminal->ip_address,

            'status' =>
                (bool) $terminal->status,
        ];
    }
}