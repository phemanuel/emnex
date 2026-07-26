<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Customer Model
 *
 * Represents a customer belonging to a company.
 */
class Customer extends Model
{
    use HasFactory, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'company_id',

        'customer_code',

        'first_name',
        'last_name',
        'company_name',

        'email',
        'phone',

        'address',
        'city',
        'state',
        'country',

        'date_of_birth',

        'credit_limit',
        'opening_balance',
        'current_balance',

        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'company_id'       => 'integer',

            'date_of_birth'    => 'date',

            'credit_limit'     => 'decimal:2',
            'opening_balance'  => 'decimal:2',
            'current_balance'  => 'decimal:2',

            'status'           => 'boolean',
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
     * Orders
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    /**
     * Payments
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'customer_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Active customers.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    /**
     * Company customers.
     */
    public function scopeForCompany(Builder $query, int $companyId): Builder
    {
        return $query->where('company_id', $companyId);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Customer full name.
     */
    public function fullName(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    /**
     * Display name.
     * Returns company name if available,
     * otherwise customer's full name.
     */
    public function displayName(): string
    {
        return $this->company_name ?: $this->fullName();
    }

    /**
     * Check if customer is active.
     */
    public function isActive(): bool
    {
        return $this->status;
    }

    /**
     * Check if customer has available credit.
     */
    public function hasCredit(float $amount): bool
    {
        return ($this->current_balance + $amount) <= $this->credit_limit;
    }
}