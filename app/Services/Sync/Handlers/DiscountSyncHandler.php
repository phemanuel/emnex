<?php

namespace App\Services\Sync\Handlers;

use App\Contracts\Sync\SyncHandler;
use App\Models\Discount;
use App\Models\SyncDevice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use RuntimeException;

class DiscountSyncHandler implements SyncHandler
{
    public function create(
        string $syncUuid,
        array $payload,
        SyncDevice $device
    ): array {

        $data = $this->validatePayload(
            $payload,
            false
        );

        $this->validateDateRange(
            $data
        );

        $discount = Discount::withTrashed()
            ->where('company_id', $device->company_id)
            ->where('sync_uuid', $syncUuid)
            ->first();

        $this->ensureNameAvailable(
            $device->company_id,
            $data['name'],
            $discount?->id
        );

        /*
        |--------------------------------------------------------------------------
        | Same Sync Identity
        |--------------------------------------------------------------------------
        */

        if ($discount) {

            $wasTrashed =
                $discount->trashed();

            if ($wasTrashed) {
                $discount->restore();
            }

            $discount->fill(
                $this->prepareData($data)
            );

            $discount->company_id =
                $device->company_id;

            $discount->save();

            return [
                'entity' => 'discount',
                'sync_uuid' => $discount->sync_uuid,
                'action' => $wasTrashed
                    ? 'restored'
                    : 'updated',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | New Discount
        |--------------------------------------------------------------------------
        */

        $discount = new Discount();

        $discount->sync_uuid =
            $syncUuid;

        $discount->company_id =
            $device->company_id;

        $discount->fill(
            $this->prepareData($data)
        );

        $discount->save();

        return [
            'entity' => 'discount',
            'sync_uuid' => $discount->sync_uuid,
            'action' => 'created',
        ];
    }


    public function update(
        string $syncUuid,
        array $payload,
        SyncDevice $device
    ): array {

        $discount = Discount::withTrashed()
            ->where('company_id', $device->company_id)
            ->where('sync_uuid', $syncUuid)
            ->first();

        if (!$discount) {

            throw new RuntimeException(
                "Discount [{$syncUuid}] could not be found."
            );
        }

        if ($discount->trashed()) {

            throw new RuntimeException(
                "Discount [{$syncUuid}] is deleted and cannot be updated."
            );
        }

        $data = $this->validatePayload(
            $payload,
            true
        );

        $this->validateDateRange(
            $data,
            $discount
        );

        if (array_key_exists('name', $data)) {

            $this->ensureNameAvailable(
                $device->company_id,
                $data['name'],
                $discount->id
            );
        }

        $discount->fill(
            $this->prepareData($data)
        );

        $discount->company_id =
            $device->company_id;

        $discount->save();

        return [
            'entity' => 'discount',
            'sync_uuid' => $discount->sync_uuid,
            'action' => 'updated',
        ];
    }


    public function delete(
        string $syncUuid,
        array $payload,
        SyncDevice $device
    ): array {

        $discount = Discount::withTrashed()
            ->where('company_id', $device->company_id)
            ->where('sync_uuid', $syncUuid)
            ->first();

        if (!$discount) {

            return [
                'entity' => 'discount',
                'sync_uuid' => $syncUuid,
                'action' => 'already_missing',
            ];
        }

        if ($discount->trashed()) {

            return [
                'entity' => 'discount',
                'sync_uuid' => $discount->sync_uuid,
                'action' => 'already_deleted',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Soft Delete
        |--------------------------------------------------------------------------
        |
        | Existing EMNEX Discount behavior allows the discount record to be
        | soft-deleted while preserving historical/product references.
        |
        */

        $discount->delete();

        return [
            'entity' => 'discount',
            'sync_uuid' => $discount->sync_uuid,
            'action' => 'deleted',
        ];
    }


    private function validatePayload(
        array $payload,
        bool $partial
    ): array {

        $required =
            $partial
                ? 'sometimes'
                : 'required';

        return Validator::make(
            $payload,
            [
                'name' => [
                    $required,
                    'string',
                    'max:255',
                ],

                'type' => [
                    $required,
                    'in:Percentage,Fixed',
                ],

                'value' => [
                    $required,
                    'numeric',
                    'min:0',
                ],

                'start_date' => [
                    $required,
                    'date',
                ],

                'end_date' => [
                    $required,
                    'date',
                ],

                'is_automatic' => [
                    $required,
                    'boolean',
                ],

                'status' => [
                    $required,
                    'boolean',
                ],
            ]
        )->validate();
    }


    private function prepareData(
        array $data
    ): array {

        $prepared = [];

        if (array_key_exists('name', $data)) {
            $prepared['name'] =
                trim($data['name']);
        }

        if (array_key_exists('type', $data)) {
            $prepared['type'] =
                $data['type'];
        }

        if (array_key_exists('value', $data)) {
            $prepared['value'] =
                $data['value'];
        }

        if (array_key_exists('start_date', $data)) {
            $prepared['start_date'] =
                $data['start_date'];
        }

        if (array_key_exists('end_date', $data)) {
            $prepared['end_date'] =
                $data['end_date'];
        }

        if (array_key_exists('is_automatic', $data)) {
            $prepared['is_automatic'] =
                (bool) $data['is_automatic'];
        }

        if (array_key_exists('status', $data)) {
            $prepared['status'] =
                (bool) $data['status'];
        }

        return $prepared;
    }


    private function validateDateRange(
        array $data,
        ?Discount $discount = null
    ): void {

        $startDate =
            $data['start_date']
            ?? $discount?->start_date;

        $endDate =
            $data['end_date']
            ?? $discount?->end_date;

        if (!$startDate || !$endDate) {
            return;
        }

        $start =
            Carbon::parse($startDate);

        $end =
            Carbon::parse($endDate);

        if ($end->lt($start)) {

            throw new RuntimeException(
                'Discount end date must be on or after the start date.'
            );
        }
    }


    private function ensureNameAvailable(
        int $companyId,
        string $name,
        ?int $ignoreId = null
    ): void {

        $name =
            trim($name);

        $query = Discount::withTrashed()
            ->where('company_id', $companyId)
            ->whereRaw(
                'LOWER(name) = ?',
                [strtolower($name)]
            );

        if ($ignoreId !== null) {

            $query->where(
                'id',
                '!=',
                $ignoreId
            );
        }

        if ($query->exists()) {

            throw new RuntimeException(
                "Discount name [{$name}] already belongs to another Discount."
            );
        }
    }
}