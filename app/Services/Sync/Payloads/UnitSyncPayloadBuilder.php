<?php

namespace App\Services\Sync\Payloads;

use App\Models\Unit;
use RuntimeException;

class UnitSyncPayloadBuilder
{
    public function build(
        Unit $unit
    ): array {

        if (!$unit->sync_uuid) {

            throw new RuntimeException(
                "Unit [{$unit->id}] does not have a synchronization UUID."
            );
        }

        return [

            'unit_code' =>
                $unit->unit_code,

            'name' =>
                $unit->name,

            'short_name' =>
                $unit->short_name,

            'description' =>
                $unit->description,

            'status' =>
                (bool) $unit->status,

        ];
    }
}