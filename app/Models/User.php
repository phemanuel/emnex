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

        'employee_no',

        'first_name',

        'last_name',

        'other_name',

        'username',

        'email',

        'phone',

        'gender',

        'date_of_birth',

        'employment_date',

        'address',

        'notes',

        'password',

        'status',

        'force_password_change',

        'password_changed_at',

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

            'email_verified_at' => 'datetime',

            'date_of_birth' => 'date',

            'employment_date' => 'date',

            'last_login_at' => 'datetime',

            'last_activity_at' => 'datetime',

            'password_changed_at' => 'datetime',

            'is_owner' => 'boolean',

            'two_factor_enabled' => 'boolean',

            'status' => 'boolean',

            'force_password_change' => 'boolean',

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
    | Terminal Assignments
    |--------------------------------------------------------------------------
    */

    /**
     * Return all terminal assignments for the user.
     */
    public function terminalAssignments()
    {
        return $this->hasMany(
            TerminalAssignment::class,
            'user_id'
        );
    }

    /**
     * Return the user's active terminal assignment.
     */
    public function activeTerminalAssignment()
    {
        return $this->hasOne(
            TerminalAssignment::class,
            'user_id'
        )->where('status', 'Active');
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
    
    public function forcePasswordReset(): bool
    {
        return (bool) $this->force_password_change;
    }

    /*
    |--------------------------------------------------------------------------
    | Authorization Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Check if user owns the company.
     */
    public function isOwner(): bool
    {
        return $this->role?->code === 'owner';
    }


    /**
     * Check if user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        return strtolower($this->role?->code ?? '') === strtolower($role);
    }


    /**
     * Get all permission codes assigned to user.
     */
    public function permissionCodes(): array
    {
        return cache()->remember(
            'user_permissions_'.$this->id,
            now()->addMinutes(30),
            function () {

                if (! $this->role) {
                    return [];
                }

                return $this->role
                    ->permissions()
                    ->where('permissions.status', true)
                    ->pluck('permissions.code')
                    ->toArray();

            }
        );
    }


    /**
     * Check if user has a permission.
     */
    public function hasPermission(string $permission): bool
    {
        /*
        |--------------------------------------------------------------------------
        | Owner bypass
        |--------------------------------------------------------------------------
        */

        if ($this->isOwner()) {
            return true;
        }


        /*
        |--------------------------------------------------------------------------
        | Direct permission check
        |--------------------------------------------------------------------------
        */

        return in_array(
            $permission,
            $this->permissionCodes()
        );
    }


    /**
     * Check if user has any permission from list.
     */
    public function hasAnyPermission(array $permissions): bool
    {
        foreach ($permissions as $permission) {

            if ($this->hasPermission($permission)) {
                return true;
            }

        }

        return false;
    }


    /**
     * Check if user has all permissions.
     */
    public function hasAllPermissions(array $permissions): bool
    {
        foreach ($permissions as $permission) {

            if (! $this->hasPermission($permission)) {
                return false;
            }

        }

        return true;
    }

    public function getFullNameAttribute(): string
    {
        return trim(implode(' ', array_filter([
            $this->first_name,
            $this->other_name,
            $this->last_name,
        ])));
    }

}