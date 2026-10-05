<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait HasSyncUuid
{
    protected static function bootHasSyncUuid(): void
    {
        static::creating(function ($model): void {

            if (empty($model->sync_uuid)) {
                $model->sync_uuid = (string) Str::uuid();
            }

        });
    }
}