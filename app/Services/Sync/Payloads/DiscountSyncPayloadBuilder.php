<?php

namespace App\Services\Sync\Payloads;

use App\Models\Discount;
use RuntimeException;

class DiscountSyncPayloadBuilder
{
    public function build(
        Discount $discount
    ): array {

        if (!$discount->sync_uuid) {
            throw new RuntimeException(
                "Discount [{$discount->id}] does not have a synchronization UUID."
            );
        }

        return [
            'name' =>
                $discount->name,

            'type' =>
                $discount->type,

            'value' =>
                $discount->value !== null
                    ? (float) $discount->value
                    : 0,

            'start_date' =>
                $discount->start_date
                    ? $discount->start_date->format('Y-m-d')
                    : null,

            'end_date' =>
                $discount->end_date
                    ? $discount->end_date->format('Y-m-d')
                    : null,

            'is_automatic' =>
                (bool) $discount->is_automatic,

            'status' =>
                (bool) $discount->status,
        ];
    }
}