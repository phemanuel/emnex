<?php

namespace App\Contracts\Sync;

use App\Models\SyncDevice;

interface SyncHandler
{
    /**
     * Create a synchronized business record.
     */
    public function create(
        string $syncUuid,
        array $payload,
        SyncDevice $device
    ): array;


    /**
     * Update a synchronized business record.
     */
    public function update(
        string $syncUuid,
        array $payload,
        SyncDevice $device
    ): array;


    /**
     * Delete a synchronized business record.
     */
    public function delete(
        string $syncUuid,
        array $payload,
        SyncDevice $device
    ): array;
}