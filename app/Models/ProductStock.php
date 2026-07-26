<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ProductStock Model
 *
 * Represents the current stock balance of a product
 * in a specific branch.
 */
class ProductStock extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'company_id',
        'branch_id',
        'product_id',
        'quantity',
        'reserved_quantity',
        'reorder_level',
        'last_stock_update',
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
            'branch_id'        => 'integer',
            'product_id'       => 'integer',
            'quantity'         => 'decimal:2',
            'reserved_quantity'=> 'decimal:2',
            'reorder_level'    => 'decimal:2',
            'last_stock_update'=> 'datetime',
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
     * Product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Active company stock.
     */
    public function scopeForCompany(Builder $query, int $companyId): Builder
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Filter by branch.
     */
    public function scopeBranch(Builder $query, int $branchId): Builder
    {
        return $query->where('branch_id', $branchId);
    }

    /**
     * Low stock items.
     */
    public function scopeLowStock(Builder $query): Builder
    {
        return $query->whereColumn('quantity', '<=', 'reorder_level');
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Available stock after reservations.
     */
    public function availableQuantity(): float
    {
        return (float) ($this->quantity - $this->reserved_quantity);
    }

    /**
     * Check if stock is available.
     */
    public function hasStock(float $qty = 1): bool
    {
        return $this->availableQuantity() >= $qty;
    }

    /**
     * Check if stock is low.
     */
    public function isLowStock(): bool
    {
        return $this->quantity <= $this->reorder_level;
    }

    /**
     * Check if stock is empty.
     */
    public function isOutOfStock(): bool
    {
        return $this->quantity <= 0;
    }
}