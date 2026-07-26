<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * User Model
 *
 * Represents an authenticated user of the Emnex POS system.
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'company_id',
        'branch_id',
        'role_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'gender',
        'date_of_birth',
        'employment_date',
        'avatar',
        'password',
        'force_password_change',
        'password_changed_at',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | Hidden
    |--------------------------------------------------------------------------
    */

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'email_verified_at'      => 'datetime',
            'password'               => 'hashed',
            'date_of_birth'          => 'date',
            'employment_date'        => 'date',
            'password_changed_at'    => 'datetime',
            'force_password_change'  => 'boolean',
            'status'                 => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Company
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * Branch
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    /**
     * Role
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Orders handled by this user.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'cashier_id');
    }

    /**
     * Payments received by this user.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'received_by');
    }

    /**
     * Activity logs.
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public function fullName(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function initials(): string
    {
        return strtoupper(
            substr($this->first_name ?? '', 0, 1) .
            substr($this->last_name ?? '', 0, 1)
        );
    }

    public function isActive(): bool
    {
        return (bool) $this->status;
    }

    public function isOwner(): bool
    {
        return $this->role?->name === 'Owner';
    }

    public function hasRole(string $role): bool
    {
        return strtolower($this->role?->name ?? '') === strtolower($role);
    }

    public function forcePasswordReset(): bool
    {
        return (bool) $this->force_password_change;
    }

    public function permissionNames()
    {
        return cache()->remember(
            'permissions_'.$this->id,
            now()->addMinutes(30),
            function () {
                return $this->role
                    ? $this->role->permissions()
                        ->where('permissions.status', true)
                        ->pluck('permissions.name')
                        ->toArray()
                    : [];
            }
        );
    }
}