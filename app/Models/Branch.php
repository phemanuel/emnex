<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Customer;

/**
 * Branch Model
 *
 * Represents a physical branch belonging to a company.
 */
class Branch extends Model
{
    use HasFactory, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'company_id',
        'branch_code',
        'name',
        'phone',
        'email',
        'address',
        'is_head_office',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'is_head_office' => 'boolean',
        'status' => 'boolean',
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
     * Users
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'branch_id');
    }

    /**
     * POS Terminals
     */
    public function terminals(): HasMany
    {
        return $this->hasMany(Terminal::class, 'branch_id');
    }

    /**
     * Product Stocks
     */
    public function productStocks(): HasMany
    {
        return $this->hasMany(ProductStock::class, 'branch_id');
    }

    /**
     * Stock Movements
     */
    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class, 'branch_id');
    }

    /**
     * Orders
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'branch_id');
    }

    /**
     * Payments
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'branch_id');
    }

    /**
     * Activity Logs
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'branch_id');
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
     * Active branches only.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    /**
     * Head office only.
     */
    public function scopeHeadOffice(Builder $query): Builder
    {
        return $query->where('is_head_office', true);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Determine if this branch is the head office.
     */
    public function isHeadOffice(): bool
    {
        return $this->is_head_office;
    }

    /**
     * Determine if this branch is active.
     */
    public function isActive(): bool
    {
        return $this->status;
    }

    /**
     * Display branch name with code.
     */
    public function displayName(): string
    {
        return "{$this->branch_code} - {$this->name}";
    }
}