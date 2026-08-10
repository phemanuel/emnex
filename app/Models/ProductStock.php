<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

        'available_quantity',

        'reorder_level',

        'maximum_stock',

    ];


    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [

            'company_id' =>
                'integer',

            'branch_id' =>
                'integer',

            'product_id' =>
                'integer',

            'quantity' =>
                'decimal:2',

            'reserved_quantity' =>
                'decimal:2',

            'available_quantity' =>
                'decimal:2',

            'reorder_level' =>
                'decimal:2',

            'maximum_stock' =>
                'decimal:2',

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
        return $this->belongsTo(
            Company::class,
            'company_id'
        );
    }


    /**
     * Branch
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(
            Branch::class,
            'branch_id'
        );
    }


    /**
     * Product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class,
            'product_id'
        );
    }


    /**
     * Stock Movements
     *
     * Movement history for this product.
     *
     * Branch filtering is applied when retrieving
     * movements for a specific stock record.
     */
    public function movements(): HasMany
    {
        return $this->hasMany(
            StockMovement::class,
            'product_id',
            'product_id'
        )->where(
            'branch_id',
            $this->branch_id
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */


    /**
     * Company stock
     */
    public function scopeForCompany(
        Builder $query,
        int $companyId
    ): Builder {

        return $query->where(
            'company_id',
            $companyId
        );

    }


    /**
     * Branch stock
     */
    public function scopeBranch(
        Builder $query,
        int $branchId
    ): Builder {

        return $query->where(
            'branch_id',
            $branchId
        );

    }


    /**
     * Low stock
     */
    public function scopeLowStock(
        Builder $query
    ): Builder {

        return $query->whereColumn(
            'quantity',
            '<=',
            'reorder_level'
        );

    }


    /**
     * Out of stock
     */
    public function scopeOutOfStock(
        Builder $query
    ): Builder {

        return $query->where(
            'quantity',
            '<=',
            0
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */


    /**
     * Synchronize available quantity.
     *
     * Available quantity is always:
     *
     * Quantity - Reserved Quantity
     */
    public function syncAvailableQuantity(): void
    {

        $this->available_quantity =
            max(
                0,
                (float) $this->quantity -
                (float) $this->reserved_quantity
            );


        $this->save();

    }


    /**
     * Available stock.
     */
    public function availableQuantity(): float
    {
        return (float)
            $this->available_quantity;
    }


    /**
     * Check stock availability.
     */
    public function hasStock(
        float $quantity = 1
    ): bool {

        return
            (float) $this->available_quantity
            >= $quantity;

    }


    /**
     * Check low stock.
     */
    public function isLowStock(): bool
    {

        return
            (float) $this->quantity
            <= (float) $this->reorder_level;

    }


    /**
     * Check out of stock.
     */
    public function isOutOfStock(): bool
    {

        return
            (float) $this->quantity <= 0;

    }


    /**
     * Stock status.
     */
    public function stockStatus(): string
    {

        if ($this->isOutOfStock()) {

            return 'Out of Stock';

        }


        if ($this->isLowStock()) {

            return 'Low Stock';

        }


        return 'In Stock';

    }


    /**
     * Inventory value.
     */
    public function stockValue(): float
    {

        return (float)
            (
                (float) $this->quantity *
                (float) (
                    $this->product?->cost_price ?? 0
                )
            );

    }
}