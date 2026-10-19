<?php

namespace App\Services\Sync\Handlers;

use App\Contracts\Sync\SyncHandler;
use App\Models\Branch;
use App\Models\SyncDevice;
use App\Models\Terminal;
use Illuminate\Support\Facades\Validator;
use RuntimeException;

class TerminalSyncHandler implements SyncHandler
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

        $companyId =
            (int) $device->company_id;

        $this->validatePayload(
            $payload,
            true
        );

        $terminal =
            Terminal::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'sync_uuid',
                    $syncUuid
                )
                ->first();

        $data =
            $this->prepareData(
                $payload,
                $companyId,
                $terminal,
                true
            );

        $this->ensureNoCodeConflict(
            $data,
            $companyId,
            $terminal
        );

        if (!$terminal) {

            $terminal =
                new Terminal();

            $terminal->sync_uuid =
                $syncUuid;

            $terminal->company_id =
                $companyId;

        } elseif ($terminal->trashed()) {

            $terminal->restore();

        }

        $terminal->fill(
            $data
        );

        $terminal->company_id =
            $companyId;

        $terminal->sync_uuid =
            $syncUuid;

        $terminal->save();

        return [
            'entity' =>
                'terminal',

            'sync_uuid' =>
                $terminal->sync_uuid,

            'action' =>
                'created',
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

        $companyId =
            (int) $device->company_id;

        $this->validatePayload(
            $payload,
            false
        );

        $terminal =
            Terminal::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'sync_uuid',
                    $syncUuid
                )
                ->first();

        if (!$terminal) {

            throw new RuntimeException(
                "Terminal [{$syncUuid}] does not exist for this company."
            );
        }

        if ($terminal->trashed()) {

            throw new RuntimeException(
                "Terminal [{$syncUuid}] is deleted and cannot be updated."
            );
        }

        $data =
            $this->prepareData(
                $payload,
                $companyId,
                $terminal,
                false
            );

        $this->ensureNoCodeConflict(
            $data,
            $companyId,
            $terminal
        );

        $terminal->fill(
            $data
        );

        $terminal->company_id =
            $companyId;

        $terminal->save();

        return [
            'entity' =>
                'terminal',

            'sync_uuid' =>
                $terminal->sync_uuid,

            'action' =>
                'updated',
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

        $companyId =
            (int) $device->company_id;

        $terminal =
            Terminal::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'sync_uuid',
                    $syncUuid
                )
                ->first();

        if (!$terminal) {

            return [
                'entity' =>
                    'terminal',

                'sync_uuid' =>
                    $syncUuid,

                'action' =>
                    'already_missing',
            ];
        }

        if ($terminal->trashed()) {

            return [
                'entity' =>
                    'terminal',

                'sync_uuid' =>
                    $syncUuid,

                'action' =>
                    'already_deleted',
            ];
        }

        $terminal->delete();

        return [
            'entity' =>
                'terminal',

            'sync_uuid' =>
                $syncUuid,

            'action' =>
                'deleted',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Validate Payload
    |--------------------------------------------------------------------------
    */

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
                'branch_sync_uuid' => [
                    $required,
                    'uuid',
                ],

                'terminal_code' => [
                    $required,
                    'string',
                    'max:50',
                ],

                'terminal_name' => [
                    $required,
                    'string',
                    'max:100',
                ],

                'description' => [
                    'sometimes',
                    'nullable',
                    'string',
                    'max:500',
                ],

                'device_name' => [
                    'sometimes',
                    'nullable',
                    'string',
                    'max:150',
                ],

                'ip_address' => [
                    'sometimes',
                    'nullable',
                    'ip',
                ],

                'status' => [
                    $required,
                    'boolean',
                ],
            ]
        )->validate();
    }


    /*
    |--------------------------------------------------------------------------
    | Prepare Data
    |--------------------------------------------------------------------------
    */

    private function prepareData(
        array $payload,
        int $companyId,
        ?Terminal $terminal,
        bool $creating
    ): array {

        $data =
            collect(
                $payload
            )
                ->only([
                    'terminal_code',
                    'terminal_name',
                    'description',
                    'device_name',
                    'ip_address',
                    'status',
                ])
                ->toArray();


        /*
        |--------------------------------------------------------------------------
        | Branch Relationship
        |--------------------------------------------------------------------------
        */

        if (
            array_key_exists(
                'branch_sync_uuid',
                $payload
            )
        ) {

            $data['branch_id'] =
                $this->resolveBranch(
                    $payload[
                        'branch_sync_uuid'
                    ],
                    $companyId
                );

        } elseif ($creating) {

            throw new RuntimeException(
                'A synchronized Terminal requires a branch synchronization UUID.'
            );

        } elseif (!$terminal?->branch_id) {

            throw new RuntimeException(
                'The Terminal does not have a valid branch.'
            );
        }


        return $data;
    }


    /*
    |--------------------------------------------------------------------------
    | Resolve Branch
    |--------------------------------------------------------------------------
    */

    private function resolveBranch(
        string $syncUuid,
        int $companyId
    ): int {

        $branch =
            Branch::query()
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
                "Branch [{$syncUuid}] has not been synchronized yet."
            );
        }

        return (int) $branch->id;
    }


    /*
    |--------------------------------------------------------------------------
    | Terminal Code Conflict
    |--------------------------------------------------------------------------
    */

    private function ensureNoCodeConflict(
        array $data,
        int $companyId,
        ?Terminal $currentTerminal = null
    ): void {

        $terminalCode =
            $data['terminal_code']
            ?? $currentTerminal?->terminal_code;

        if (!$terminalCode) {
            return;
        }

        $query =
            Terminal::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'terminal_code',
                    $terminalCode
                );

        if ($currentTerminal) {

            $query->where(
                'id',
                '!=',
                $currentTerminal->id
            );
        }

        if ($query->exists()) {

            throw new RuntimeException(
                "Terminal code [{$terminalCode}] already belongs to another terminal."
            );
        }
    }
}