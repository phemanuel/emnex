<?php

namespace App\Services\Sync\Payloads;

use App\Models\TaxRate;
use RuntimeException;

class TaxRateSyncPayloadBuilder
{
    public function build(
        TaxRate $taxRate
    ): array {

        if (!$taxRate->sync_uuid) {
            throw new RuntimeException(
                "Tax rate [{$taxRate->id}] does not have a synchronization UUID."
            );
        }

        return [
            'name' =>
                $taxRate->name,

            'rate' =>
                $taxRate->rate !== null
                    ? (float) $taxRate->rate
                    : 0,

            'status' =>
                (bool) $taxRate->status,
        ];
    }
}