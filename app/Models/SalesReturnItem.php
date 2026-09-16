<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesReturnItem extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'company_id',

        'sales_return_id',

        'order_item_id',

        'product_id',

        'product_name',

        'product_barcode',

        'quantity',

        'unit_price',

        'unit_cost',

        'discount',

        'tax',

        'total',

    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [

            'company_id'     => 'integer',

            'sales_return_id' => 'integer',

            'order_item_id'  => 'integer',

            'product_id'     => 'integer',

            'quantity'      => 'decimal:2',

            'unit_price'    => 'decimal:2',

            'unit_cost'     => 'decimal:2',

            'discount'      => 'decimal:2',

            'tax'           => 'decimal:2',

            'total'         => 'decimal:2',

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
     * Sales Return
     */
    public function salesReturn(): BelongsTo
    {
        return $this->belongsTo(
            SalesReturn::class,
            'sales_return_id'
        );
    }

    /**
     * Original Order Item
     */
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(
            OrderItem::class,
            'order_item_id'
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
     * Filter by company.
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

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get the total returned cost.
     */
    public function returnedCost(): float
    {
        return (float) $this->quantity * (float) $this->unit_cost;
    }

    /**
     * Get the total returned quantity.
     */
    public function returnedQuantity(): float
    {
        return (float) $this->quantity;
    }

    /**
     * Get the total returned value.
     */
    public function returnedValue(): float
    {
        return (float) $this->total;
    }
}