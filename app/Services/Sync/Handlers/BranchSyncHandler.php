<?php

namespace App\Services\Sync\Handlers;

use App\Contracts\Sync\SyncHandler;
use App\Models\Branch;
use App\Models\SyncDevice;
use Illuminate\Support\Facades\Validator;
use RuntimeException;

class BranchSyncHandler implements SyncHandler
{
    public function create(
        string $syncUuid,
        array $payload,
        SyncDevice $device
    ): array {

        $companyId =
            (int) $device->company_id;

        $this->validatePayload(
            $payload,
            true
        );

        $branch =
            Branch::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'sync_uuid',
                    $syncUuid
                )
                ->first();

        $this->ensureNoCodeConflict(
            $payload,
            $companyId,
            $branch
        );

        $this->ensureHeadOfficeRules(
            $payload,
            $companyId,
            $branch
        );

        if (!$branch) {

            $branch =
                new Branch();

            $branch->sync_uuid =
                $syncUuid;

            $branch->company_id =
                $companyId;

        } elseif ($branch->trashed()) {

            $branch->restore();

        }

        $branch->fill(
            $this->branchData(
                $payload
            )
        );

        $branch->company_id =
            $companyId;

        $branch->sync_uuid =
            $syncUuid;

        $branch->save();

        return [
            'entity' =>
                'branch',

            'sync_uuid' =>
                $branch->sync_uuid,

            'action' =>
                'created',
        ];
    }


    public function update(
        string $syncUuid,
        array $payload,
        SyncDevice $device
    ): array {

        $companyId =
            (int) $device->company_id;

        $this->validatePayload(
            $payload,
            false
        );

        $branch =
            Branch::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'sync_uuid',
                    $syncUuid
                )
                ->first();

        if (!$branch) {

            throw new RuntimeException(
                "Branch [{$syncUuid}] does not exist for this company."
            );

        }

        if ($branch->trashed()) {

            throw new RuntimeException(
                "Branch [{$syncUuid}] is deleted and cannot be updated."
            );

        }

        $this->ensureNoCodeConflict(
            $payload,
            $companyId,
            $branch
        );

        $this->ensureHeadOfficeRules(
            $payload,
            $companyId,
            $branch
        );

        $branch->fill(
            $this->branchData(
                $payload
            )
        );

        $branch->company_id =
            $companyId;

        $branch->save();

        return [
            'entity' =>
                'branch',

            'sync_uuid' =>
                $branch->sync_uuid,

            'action' =>
                'updated',
        ];
    }


    public function delete(
        string $syncUuid,
        array $payload,
        SyncDevice $device
    ): array {

        $companyId =
            (int) $device->company_id;

        $branch =
            Branch::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'sync_uuid',
                    $syncUuid
                )
                ->first();

        if (!$branch) {

            return [
                'entity' =>
                    'branch',

                'sync_uuid' =>
                    $syncUuid,

                'action' =>
                    'already_missing',
            ];
        }

        if ($branch->trashed()) {

            return [
                'entity' =>
                    'branch',

                'sync_uuid' =>
                    $syncUuid,

                'action' =>
                    'already_deleted',
            ];
        }

        if ($branch->is_head_office) {

            throw new RuntimeException(
                'The Head Office branch cannot be deleted.'
            );
        }

        $branch->delete();

        return [
            'entity' =>
                'branch',

            'sync_uuid' =>
                $syncUuid,

            'action' =>
                'deleted',
        ];
    }


    private function validatePayload(
        array $payload,
        bool $creating
    ): void {

        $required =
            $creating
                ? 'required'
                : 'sometimes';

        Validator::make(
            $payload,
            [
                'branch_code' => [
                    $required,
                    'string',
                ],

                'name' => [
                    $required,
                    'string',
                ],

                'phone' => [
                    'sometimes',
                    'nullable',
                    'string',
                ],

                'email' => [
                    'sometimes',
                    'nullable',
                    'email',
                ],

                'address' => [
                    'sometimes',
                    'nullable',
                    'string',
                ],

                'is_head_office' => [
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


    private function branchData(
        array $payload
    ): array {

        return collect(
            $payload
        )
            ->only([
                'branch_code',
                'name',
                'phone',
                'email',
                'address',
                'is_head_office',
                'status',
            ])
            ->toArray();
    }


    private function ensureNoCodeConflict(
        array $payload,
        int $companyId,
        ?Branch $currentBranch = null
    ): void {

        $branchCode =
            $payload['branch_code']
            ?? $currentBranch?->branch_code;

        if (!$branchCode) {
            return;
        }

        $query =
            Branch::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'branch_code',
                    $branchCode
                );

        if ($currentBranch) {

            $query->where(
                'id',
                '!=',
                $currentBranch->id
            );
        }

        if ($query->exists()) {

            throw new RuntimeException(
                "Branch code [{$branchCode}] already belongs to another branch."
            );
        }
    }


    private function ensureHeadOfficeRules(
        array $payload,
        int $companyId,
        ?Branch $currentBranch = null
    ): void {

        $incomingHeadOffice =
            array_key_exists(
                'is_head_office',
                $payload
            )
                ? (bool) $payload['is_head_office']
                : (bool) $currentBranch?->is_head_office;

        $incomingStatus =
            array_key_exists(
                'status',
                $payload
            )
                ? (bool) $payload['status']
                : (bool) $currentBranch?->status;


        /*
        |--------------------------------------------------------------------------
        | Existing Head Office Protection
        |--------------------------------------------------------------------------
        */

        if (
            $currentBranch &&
            $currentBranch->is_head_office
        ) {

            if (!$incomingHeadOffice) {

                throw new RuntimeException(
                    'The Head Office branch cannot be changed to a regular branch.'
                );
            }

            if (!$incomingStatus) {

                throw new RuntimeException(
                    'The Head Office branch cannot be disabled.'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Only One Head Office
        |--------------------------------------------------------------------------
        */

        if ($incomingHeadOffice) {

            $query =
                Branch::withTrashed()
                    ->where(
                        'company_id',
                        $companyId
                    )
                    ->where(
                        'is_head_office',
                        true
                    );

            if ($currentBranch) {

                $query->where(
                    'id',
                    '!=',
                    $currentBranch->id
                );
            }

            if ($query->exists()) {

                throw new RuntimeException(
                    'This company already has a Head Office branch.'
                );
            }
        }
    }
}