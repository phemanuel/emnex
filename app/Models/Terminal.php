<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Terminal Model
 *
 * Represents a POS terminal within a branch.
 */
class Terminal extends Model
{
    use HasFactory, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'company_id',

        'branch_id',

        'terminal_code',

        'terminal_name',

        'description',

        'device_name',

        'ip_address',

        'status',

        'last_seen_at',

    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'status' => 'boolean',

        'last_seen_at' => 'datetime',

    ];

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
     * Orders processed on this terminal.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'terminal_id');
    }

    /**
     * Payments received on this terminal.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'terminal_id');
    }

    /**
     * Activity logs for this terminal.
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'terminal_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Active terminals.
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

    /**
     * Check if the terminal is active.
     */
    public function isActive(): bool
    {
        return $this->status;
    }

    /**
     * Display terminal name with code.
     */
    public function displayName(): string
    {
        return "{$this->terminal_code} - {$this->terminal_name}";
    }

    /**
     * Total orders processed.
     */
    public function totalOrders(): int
    {
        return $this->orders()->count();
    }

    /**
     * Total payments received.
     */
    public function totalPayments(): int
    {
        return $this->payments()->count();
    }

    /**
     * Total activity logs.
     */
    public function totalActivities(): int
    {
        return $this->activityLogs()->count();
    }
}