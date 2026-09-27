<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataLifecycleSetting extends Model
{
    protected $fillable = [

        'enabled',
        'inactivity_days',
        'grace_period_days',
        'warning_days',
        'automatic_scheduling',
        'automatic_purge',
        'archive_disk',
        'archive_directory',
        'archive_retention_days',
        'updated_by',

    ];


    protected function casts(): array
    {
        return [

            'enabled' =>
                'boolean',

            'warning_days' =>
                'array',

            'automatic_scheduling' =>
                'boolean',

            'automatic_purge' =>
                'boolean',

        ];
    }


    public static function current(): self
    {
        return static::query()
            ->firstOrCreate(
                ['id' => 1],
                [
                    'enabled' => true,

                    'inactivity_days' =>
                        540,

                    'grace_period_days' =>
                        30,

                    'warning_days' =>
                        [
                            90,
                            30,
                            7,
                        ],

                    'automatic_scheduling' =>
                        false,

                    'automatic_purge' =>
                        false,

                    'archive_disk' =>
                        'local',

                    'archive_directory' =>
                        'company-archives',
                ]
            );
    }
}