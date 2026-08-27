<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrderItem extends Model
{
    use HasFactory;


    protected $fillable = [

        'sales_order_id',

        'product_id',

        'quantity',

        'unit_price',

        'discount_amount',

        'tax_amount',

        'total',

    ];


    protected function casts(): array
    {
        return [

            'sales_order_id' =>
                'integer',

            'product_id' =>
                'integer',

            'quantity' =>
                'decimal:2',

            'unit_price' =>
                'decimal:2',

            'discount_amount' =>
                'decimal:2',

            'tax_amount' =>
                'decimal:2',

            'total' =>
                'decimal:2',

        ];
    }


    public function salesOrder(): BelongsTo
    {
        return $this->belongsTo(
            SalesOrder::class,
            'sales_order_id'
        );
    }


    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class,
            'product_id'
        );
    }
}
