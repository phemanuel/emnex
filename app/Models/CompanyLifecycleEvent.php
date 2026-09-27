<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyLifecycleEvent extends Model
{
    protected $fillable = [

        'company_id',
        'archive_id',
        'event',
        'from_status',
        'to_status',
        'description',
        'metadata',
        'platform_admin_id',

    ];


    protected function casts(): array
    {
        return [

            'metadata' =>
                'array',

        ];
    }
}