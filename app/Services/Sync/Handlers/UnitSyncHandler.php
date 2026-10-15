<?php

namespace App\Services\Sync\Handlers;

use App\Contracts\Sync\SyncHandler;
use App\Models\Product;
use App\Models\SyncDevice;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;
use RuntimeException;

class UnitSyncHandler implements SyncHandler
{
    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create(
        string $syncUuid,
        array $payload,
        SyncDevice $device
    ): array {

        $data = $this->validatePayload(
            $payload,
            false
        );

        $unit = Unit::withTrashed()
            ->where('company_id', $device->company_id)
            ->where('sync_uuid', $syncUuid)
            ->first();

        $this->ensureUnitCodeAvailable(
            $device->company_id,
            $data['unit_code'],
            $unit?->id
        );

        /*
        |--------------------------------------------------------------------------
        | Same Sync Identity Already Exists
        |--------------------------------------------------------------------------
        */

        if ($unit) {

            if ($unit->trashed()) {
                $unit->restore();
            }

            $unit->fill(
                $this->prepareData($data)
            );

            /*
            |--------------------------------------------------------------------------
            | Company Comes From Authenticated Device
            |--------------------------------------------------------------------------
            */

            $unit->company_id =
                $device->company_id;

            $unit->save();

            return [
                'entity' => 'unit',
                'sync_uuid' => $unit->sync_uuid,
                'action' => 'updated',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Create New Unit
        |--------------------------------------------------------------------------
        */

        $unit = new Unit();

        /*
        |--------------------------------------------------------------------------
        | sync_uuid Is Infrastructure Identity
        |--------------------------------------------------------------------------
        |
        | It is intentionally not fillable.
        |
        */

        $unit->sync_uuid =
            $syncUuid;

        $unit->company_id =
            $device->company_id;

        $unit->fill(
            $this->prepareData($data)
        );

        $unit->save();

        return [
            'entity' => 'unit',
            'sync_uuid' => $unit->sync_uuid,
            'action' => 'created',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        string $syncUuid,
        array $payload,
        SyncDevice $device
    ): array {

        $unit = Unit::withTrashed()
            ->where('company_id', $device->company_id)
            ->where('sync_uuid', $syncUuid)
            ->first();

        if (!$unit) {
            throw new RuntimeException(
                "Unit [{$syncUuid}] could not be found."
            );
        }

        if ($unit->trashed()) {
            throw new RuntimeException(
                "Unit [{$syncUuid}] is deleted and cannot be updated."
            );
        }

        $data = $this->validatePayload(
            $payload,
            true
        );

        /*
        |--------------------------------------------------------------------------
        | Business Identifier Conflict
        |--------------------------------------------------------------------------
        */

        if (array_key_exists('unit_code', $data)) {

            $this->ensureUnitCodeAvailable(
                $device->company_id,
                $data['unit_code'],
                $unit->id
            );
        }

        $unit->fill(
            $this->prepareData($data)
        );

        /*
        |--------------------------------------------------------------------------
        | Never Accept Incoming company_id
        |--------------------------------------------------------------------------
        */

        $unit->company_id =
            $device->company_id;

        $unit->save();

        return [
            'entity' => 'unit',
            'sync_uuid' => $unit->sync_uuid,
            'action' => 'updated',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function delete(
        string $syncUuid,
        array $payload,
        SyncDevice $device
    ): array {

        $unit = Unit::withTrashed()
            ->where('company_id', $device->company_id)
            ->where('sync_uuid', $syncUuid)
            ->first();

        if (!$unit) {

            return [
                'entity' => 'unit',
                'sync_uuid' => $syncUuid,
                'action' => 'already_missing',
            ];
        }

        if ($unit->trashed()) {

            return [
                'entity' => 'unit',
                'sync_uuid' => $unit->sync_uuid,
                'action' => 'already_deleted',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Preserve Product References
        |--------------------------------------------------------------------------
        */

        $hasProducts = Product::withTrashed()
            ->where('company_id', $device->company_id)
            ->where('unit_id', $unit->id)
            ->exists();

        if ($hasProducts) {

            throw new RuntimeException(
                "Unit [{$syncUuid}] is used by one or more products and cannot be deleted."
            );
        }

        $unit->delete();

        return [
            'entity' => 'unit',
            'sync_uuid' => $unit->sync_uuid,
            'action' => 'deleted',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    private function validatePayload(
        array $payload,
        bool $partial
    ): array {

        $required =
            $partial
                ? 'sometimes'
                : 'required';

        $validator = Validator::make(
            $payload,
            [
                'unit_code' => [
                    $required,
                    'string',
                ],

                'name' => [
                    $required,
                    'string',
                ],

                'short_name' => [
                    'sometimes',
                    'nullable',
                    'string',
                ],

                'description' => [
                    'sometimes',
                    'nullable',
                    'string',
                ],

                'status' => [
                    $required,
                    'boolean',
                ],
            ]
        );

        return $validator->validate();
    }


    /*
    |--------------------------------------------------------------------------
    | Prepare Data
    |--------------------------------------------------------------------------
    */

    private function prepareData(
        array $data
    ): array {

        $prepared = [];

        if (
            array_key_exists(
                'unit_code',
                $data
            )
        ) {

            $prepared['unit_code'] =
                trim($data['unit_code']);
        }

        if (
            array_key_exists(
                'name',
                $data
            )
        ) {

            $prepared['name'] =
                trim($data['name']);
        }

        if (
            array_key_exists(
                'short_name',
                $data
            )
        ) {

            $prepared['short_name'] =
                $data['short_name'] !== null
                    ? trim($data['short_name'])
                    : null;
        }

        if (
            array_key_exists(
                'description',
                $data
            )
        ) {

            $prepared['description'] =
                $data['description'];
        }

        if (
            array_key_exists(
                'status',
                $data
            )
        ) {

            $prepared['status'] =
                (bool) $data['status'];
        }

        return $prepared;
    }


    /*
    |--------------------------------------------------------------------------
    | Unit Code Conflict
    |--------------------------------------------------------------------------
    |
    | sync_uuid identifies the record.
    |
    | unit_code remains a business identifier and must never silently cause
    | two records with different sync identities to be merged.
    |
    */

    private function ensureUnitCodeAvailable(
        int $companyId,
        string $unitCode,
        ?int $ignoreId = null
    ): void {

        $unitCode =
            trim($unitCode);

        $query = Unit::withTrashed()
            ->where('company_id', $companyId)
            ->where('unit_code', $unitCode);

        if ($ignoreId !== null) {

            $query->where(
                'id',
                '!=',
                $ignoreId
            );
        }

        $conflict =
            $query->first();

        if ($conflict) {

            throw new RuntimeException(
                "Unit code [{$unitCode}] already belongs to another Unit."
            );
        }
    }
}