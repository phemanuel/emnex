<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoodsReceivedItem extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'goods_received_id',

        'purchase_order_item_id',

        'product_id',

        'ordered_quantity',

        'received_quantity',

        'unit_cost',

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

            'goods_received_id' =>
                'integer',

            'purchase_order_item_id' =>
                'integer',

            'product_id' =>
                'integer',

            'ordered_quantity' =>
                'decimal:2',

            'received_quantity' =>
                'decimal:2',

            'unit_cost' =>
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

    public function goodsReceived(): BelongsTo
    {
        return $this->belongsTo(
            GoodsReceived::class,
            'goods_received_id'
        );
    }


    public function purchaseOrderItem(): BelongsTo
    {
        return $this->belongsTo(
            PurchaseOrderItem::class,
            'purchase_order_item_id'
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