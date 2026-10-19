<?php

namespace App\Services\Sync\Payloads;

use App\Models\Branch;

class BranchSyncPayloadBuilder
{
    /*
    |--------------------------------------------------------------------------
    | Build Portable Branch Snapshot
    |--------------------------------------------------------------------------
    |
    | Database IDs, company_id, timestamps and deleted_at are deliberately
    | excluded.
    |
    | sync_uuid travels separately as entity_sync_uuid.
    |
    */

    public function build(
        Branch $branch
    ): array {

        return [

            'branch_code' =>
                $branch->branch_code,

            'name' =>
                $branch->name,

            'phone' =>
                $branch->phone,

            'email' =>
                $branch->email,

            'address' =>
                $branch->address,

            'is_head_office' =>
                (bool) $branch->is_head_office,

            'status' =>
                (bool) $branch->status,

        ];
    }
}