<?php

namespace App\Services\Sync\Handlers;

use App\Contracts\Sync\SyncHandler;
use App\Models\Product;
use App\Models\SyncDevice;
use App\Models\TaxRate;
use Illuminate\Support\Facades\Validator;
use RuntimeException;

class TaxRateSyncHandler implements SyncHandler
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

        $taxRate = TaxRate::withTrashed()
            ->where('company_id', $device->company_id)
            ->where('sync_uuid', $syncUuid)
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Business Name Conflict
        |--------------------------------------------------------------------------
        */

        $this->ensureNameAvailable(
            $device->company_id,
            $data['name'],
            $taxRate?->id
        );

        /*
        |--------------------------------------------------------------------------
        | Same Synchronization Identity
        |--------------------------------------------------------------------------
        */

        if ($taxRate) {

            $wasTrashed =
                $taxRate->trashed();

            if ($wasTrashed) {
                $taxRate->restore();
            }

            $taxRate->fill(
                $this->prepareData($data)
            );

            $taxRate->company_id =
                $device->company_id;

            $taxRate->save();

            return [
                'entity' => 'tax_rate',
                'sync_uuid' => $taxRate->sync_uuid,
                'action' => $wasTrashed
                    ? 'restored'
                    : 'updated',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Create New Tax Rate
        |--------------------------------------------------------------------------
        */

        $taxRate = new TaxRate();

        $taxRate->sync_uuid =
            $syncUuid;

        $taxRate->company_id =
            $device->company_id;

        $taxRate->fill(
            $this->prepareData($data)
        );

        $taxRate->save();

        return [
            'entity' => 'tax_rate',
            'sync_uuid' => $taxRate->sync_uuid,
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

        $taxRate = TaxRate::withTrashed()
            ->where('company_id', $device->company_id)
            ->where('sync_uuid', $syncUuid)
            ->first();

        if (!$taxRate) {

            throw new RuntimeException(
                "Tax rate [{$syncUuid}] could not be found."
            );
        }

        if ($taxRate->trashed()) {

            throw new RuntimeException(
                "Tax rate [{$syncUuid}] is deleted and cannot be updated."
            );
        }

        $data = $this->validatePayload(
            $payload,
            true
        );

        /*
        |--------------------------------------------------------------------------
        | Name Conflict
        |--------------------------------------------------------------------------
        */

        if (array_key_exists('name', $data)) {

            $this->ensureNameAvailable(
                $device->company_id,
                $data['name'],
                $taxRate->id
            );
        }

        $taxRate->fill(
            $this->prepareData($data)
        );

        $taxRate->company_id =
            $device->company_id;

        $taxRate->save();

        return [
            'entity' => 'tax_rate',
            'sync_uuid' => $taxRate->sync_uuid,
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

        $taxRate = TaxRate::withTrashed()
            ->where('company_id', $device->company_id)
            ->where('sync_uuid', $syncUuid)
            ->first();

        if (!$taxRate) {

            return [
                'entity' => 'tax_rate',
                'sync_uuid' => $syncUuid,
                'action' => 'already_missing',
            ];
        }

        if ($taxRate->trashed()) {

            return [
                'entity' => 'tax_rate',
                'sync_uuid' => $taxRate->sync_uuid,
                'action' => 'already_deleted',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent Deletion When Products Reference Tax Rate
        |--------------------------------------------------------------------------
        */

        $hasProducts = Product::withTrashed()
            ->where('company_id', $device->company_id)
            ->where('tax_rate_id', $taxRate->id)
            ->exists();

        if ($hasProducts) {

            throw new RuntimeException(
                "Tax rate [{$syncUuid}] is used by one or more products and cannot be deleted."
            );
        }

        $taxRate->delete();

        return [
            'entity' => 'tax_rate',
            'sync_uuid' => $taxRate->sync_uuid,
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
                'name' => [
                    $required,
                    'string',
                    'max:255',
                ],

                'rate' => [
                    $required,
                    'numeric',
                    'min:0',
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

        if (array_key_exists('name', $data)) {

            $prepared['name'] =
                trim($data['name']);
        }

        if (array_key_exists('rate', $data)) {

            $prepared['rate'] =
                $data['rate'];
        }

        if (array_key_exists('status', $data)) {

            $prepared['status'] =
                (bool) $data['status'];
        }

        return $prepared;
    }


    /*
    |--------------------------------------------------------------------------
    | Name Conflict
    |--------------------------------------------------------------------------
    |
    | Tax rate names are company-scoped business identifiers.
    |
    | A matching name under another sync_uuid is a conflict, not a reason
    | to merge the records.
    |
    */

    private function ensureNameAvailable(
        int $companyId,
        string $name,
        ?int $ignoreId = null
    ): void {

        $name =
            trim($name);

        $query = TaxRate::withTrashed()
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

        $conflict =
            $query->first();

        if ($conflict) {

            throw new RuntimeException(
                "Tax rate name [{$name}] already belongs to another Tax Rate."
            );
        }
    }
}