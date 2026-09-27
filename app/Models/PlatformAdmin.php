<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class PlatformAdmin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [

        'first_name',
        'last_name',
        'email',
        'password',
        'access_level',
        'status',
        'two_factor_enabled',
        'last_login_at',
        'last_activity_at',

    ];


    protected $hidden = [

        'password',
        'remember_token',

    ];


    protected function casts(): array
    {
        return [

            'status' =>
                'boolean',

            'two_factor_enabled' =>
                'boolean',

            'last_login_at' =>
                'datetime',

            'last_activity_at' =>
                'datetime',

            'password' =>
                'hashed',

        ];
    }


    public function fullName(): string
    {
        return trim(
            $this->first_name .
            ' ' .
            $this->last_name
        );
    }


    public function initials(): string
    {
        return strtoupper(
            substr(
                $this->first_name ?? '',
                0,
                1
            )
            .
            substr(
                $this->last_name ?? '',
                0,
                1
            )
        );
    }


    public function isOwner(): bool
    {
        return $this->access_level ===
            'owner';
    }


    public function isAdmin(): bool
    {
        return in_array(
            $this->access_level,
            [
                'owner',
                'admin',
            ],
            true
        );
    }


    public function canManagePlatform(): bool
    {
        return $this->isAdmin();
    }
}