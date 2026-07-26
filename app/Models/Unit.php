<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Unit Model
 *
 * Represents a unit of measurement for products.
 *
 * Examples:
 * - Piece (PCS)
 * - Kilogram (KG)
 * - Litre (LTR)
 * - Carton (CTN)
 */
class Unit extends Model
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
        'short_name',
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
            'company_id' => 'integer',
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
        return $this->hasMany(Product::class, 'unit_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Active units only.
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
     * Check if unit is active.
     */
    public function isActive(): bool
    {
        return $this->status;
    }

    /**
     * Display unit name.
     *
     * Example:
     * Piece (PCS)
     */
    public function displayName(): string
    {
        return "{$this->name} ({$this->short_name})";
    }
}