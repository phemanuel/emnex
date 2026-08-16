<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseReturnItem extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'purchase_return_id',

        'goods_received_item_id',

        'product_id',

        'quantity',

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

            'purchase_return_id' =>
                'integer',

            'goods_received_item_id' =>
                'integer',

            'product_id' =>
                'integer',

            'quantity' =>
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

    public function purchaseReturn(): BelongsTo
    {
        return $this->belongsTo(
            PurchaseReturn::class,
            'purchase_return_id'
        );
    }


    public function goodsReceivedItem(): BelongsTo
    {
        return $this->belongsTo(
            GoodsReceivedItem::class,
            'goods_received_item_id'
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