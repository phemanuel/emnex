<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyArchive extends Model
{
    protected $fillable = [

        'original_company_id',
        'company_name',
        'company_code',
        'status',
        'archive_format',
        'storage_disk',
        'storage_path',
        'archive_size',
        'checksum',
        'manifest',
        'verification',
        'error_message',
        'requested_at',
        'started_at',
        'completed_at',
        'verified_at',
        'purged_at',
        'requested_by',

    ];


    protected function casts(): array
    {
        return [

            'manifest' =>
                'array',

            'verification' =>
                'array',

            'requested_at' =>
                'datetime',

            'started_at' =>
                'datetime',

            'completed_at' =>
                'datetime',

            'verified_at' =>
                'datetime',

            'purged_at' =>
                'datetime',

        ];
    }


    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(
            PlatformAdmin::class,
            'requested_by'
        );
    }


    public function isVerified(): bool
    {
        return $this->status ===
            'Verified';
    }
}