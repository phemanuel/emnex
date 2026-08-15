<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockCountItem extends Model
{

    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'stock_count_id',

        'product_id',

        'system_quantity',

        'counted_quantity',

        'variance',

        'unit_cost',

        'notes',

    ];


    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [

            'stock_count_id' =>
                'integer',

            'product_id' =>
                'integer',

            'system_quantity' =>
                'decimal:2',

            'counted_quantity' =>
                'decimal:2',

            'variance' =>
                'decimal:2',

            'unit_cost' =>
                'decimal:2',

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */


    /**
     * Stock Count
     */
    public function stockCount(): BelongsTo
    {
        return $this->belongsTo(
            StockCount::class,
            'stock_count_id'
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


    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */


    /**
     * Filter items by product.
     */
    public function scopeProduct(
        Builder $query,
        int $productId
    ): Builder {

        return $query->where(
            'product_id',
            $productId
        );

    }


    /**
     * Items with variance.
     */
    public function scopeWithVariance(
        Builder $query
    ): Builder {

        return $query->where(
            'variance',
            '!=',
            0
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */


    /**
     * Calculate variance.
     *
     * Counted quantity - system quantity.
     */
    public function calculateVariance(): float
    {
        return round(
            (float) $this->counted_quantity
            -
            (float) $this->system_quantity,
            2
        );
    }


    /**
     * Synchronize variance.
     */
    public function syncVariance(): void
    {

        $this->variance =
            $this->calculateVariance();

    }


    /**
     * Check if quantity increased.
     */
    public function isIncrease(): bool
    {
        return (float) $this->variance > 0;
    }


    /**
     * Check if quantity decreased.
     */
    public function isDecrease(): bool
    {
        return (float) $this->variance < 0;
    }


    /**
     * Check if there is no variance.
     */
    public function hasNoVariance(): bool
    {
        return (float) $this->variance === 0.0;
    }


    /**
     * Variance value.
     */
    public function varianceValue(): float
    {
        return round(
            (float) $this->variance *
            (float) $this->unit_cost,
            2
        );
    }

}