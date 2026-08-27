<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * OrderItem Model
 *
 * Represents an individual product within an order.
 */
class OrderItem extends Model
{
    use HasFactory;


   /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'company_id',

        'order_id',

        'product_id',

        'product_name',

        'product_barcode',

        'quantity',

        'unit_price',

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

            'company_id' =>
                'integer',

            'order_id' =>
                'integer',

            'product_id' =>
                'integer',

            'quantity' =>
                'decimal:2',

            'unit_price' =>
                'decimal:2',

            'discount' =>
                'decimal:2',

            'tax' =>
                'decimal:2',

            'total' =>
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
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * Order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
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
     * Filter by company.
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
     * Total discount for this line.
     */
    public function totalDiscount(): float
    {
        return (float) $this->discount_amount;
    }

    /**
     * Total tax for this line.
     */
    public function totalTax(): float
    {
        return (float) $this->tax_amount;
    }

    /**
     * Final amount for this line.
     */
    public function total(): float
    {
        return (float) $this->line_total;
    }
}