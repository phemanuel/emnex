<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class SalesReturnPayment extends Model
{

    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'sales_return_id',

        'payment_id',

        'amount',

    ];


    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {

        return [

            'sales_return_id' =>
                'integer',

            'payment_id' =>
                'integer',

            'amount' =>
                'decimal:2',

        ];

    }


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

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
     * Payment
     */
    public function payment(): BelongsTo
    {

        return $this->belongsTo(
            Payment::class,
            'payment_id'
        );

    }

}