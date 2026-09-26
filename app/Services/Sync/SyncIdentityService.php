<?php

namespace App\Services\Sync;

use App\Models\SyncDevice;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RuntimeException;

class SyncIdentityService
{
    /**
     * Create a new synchronization device.
     *
     * The raw token is returned once to the caller.
     * Only the hash is stored in the database.
     */
    public function registerDevice(
        int $companyId,
        ?int $branchId = null,
        ?int $terminalId = null,
        ?string $deviceName = null,
        string $deviceType = 'local',
        ?string $appVersion = null,
        ?string $databaseVersion = null
    ): array {
        $deviceUuid = (string) Str::uuid();

        $syncToken = Str::random(64);

        $device = SyncDevice::create([
            'company_id' => $companyId,
            'branch_id' => $branchId,
            'terminal_id' => $terminalId,

            'device_uuid' => $deviceUuid,

            'device_name' => $deviceName,
            'device_type' => $deviceType,

            'app_version' => $appVersion,
            'database_version' => $databaseVersion,

            'sync_token_hash' => Hash::make($syncToken),
            'token_created_at' => now(),

            'is_active' => true,
            'last_seen_at' => now(),
        ]);

        return [
            'device' => $device,
            'sync_token' => $syncToken,
        ];
    }

    /**
     * Validate a device and token.
     */
    public function authenticate(
        string $deviceUuid,
        string $syncToken
    ): SyncDevice {
        $device = SyncDevice::query()
            ->where('device_uuid', $deviceUuid)
            ->where('is_active', true)
            ->first();

        if (!$device) {
            throw new RuntimeException('Synchronization device was not found or is inactive.');
        }

        if (
            !$device->sync_token_hash ||
            !Hash::check($syncToken, $device->sync_token_hash)
        ) {
            throw new RuntimeException('Invalid synchronization credentials.');
        }

        $device->forceFill([
            'last_seen_at' => now(),
        ])->save();

        return $device;
    }

    /**
     * Mark the device as having completed synchronization.
     */
    public function markSynced(SyncDevice $device): void
    {
        $device->forceFill([
            'last_seen_at' => now(),
            'last_sync_at' => now(),
        ])->save();
    }

    /**
     * Disable a device.
     */
    public function deactivate(SyncDevice $device): void
    {
        $device->forceFill([
            'is_active' => false,
        ])->save();
    }

    /**
     * Reactivate a device.
     */
    public function activate(SyncDevice $device): void
    {
        $device->forceFill([
            'is_active' => true,
        ])->save();
    }
}

