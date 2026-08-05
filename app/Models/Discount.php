<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Discount Model
 *
 * Represents a reusable discount that can be assigned to products.
 */
class Discount extends Model
{
    use HasFactory, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'company_id',
        'name',
        'type',
        'value',
        'start_date',
        'end_date',
        'status',
        'is_automatic',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'company_id' => 'integer',
            'value'      => 'decimal:2',
            'start_date' => 'date',
            'end_date'   => 'date',
            'status'     => 'boolean',
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
     * Products
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'discount_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Active discounts.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    /**
     * Company discounts.
     */
    public function scopeForCompany(Builder $query, int $companyId): Builder
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Currently valid discounts.
     */
    public function scopeCurrent(Builder $query): Builder
    {
        return $query
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now());
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Check if discount is active.
     */
    public function isActive(): bool
    {
        return $this->status;
    }

    /**
     * Check if discount is currently valid.
     */
    public function isCurrent(): bool
    {
        $today = now()->toDateString();

        return $this->status &&
            $this->start_date <= $today &&
            $this->end_date >= $today;
    }

    /**
     * Display discount.
     *
     * Example:
     * 10%
     * ₦500.00
     */
    public function displayValue(): string
    {
        return $this->type === 'Percentage'
            ? "{$this->value}%"
            : '₦' . number_format($this->value, 2);
    }
}