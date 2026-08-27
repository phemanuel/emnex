<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [

        'company_id',

        'branch_id',

        'customer_id',

        'order_number',

        'order_date',

        'status',

        'subtotal',

        'discount_amount',

        'tax_amount',

        'total_amount',

        'notes',

        'created_by',

    ];


    protected function casts(): array
    {
        return [

            'company_id' =>
                'integer',

            'branch_id' =>
                'integer',

            'customer_id' =>
                'integer',

            'order_date' =>
                'date',

            'subtotal' =>
                'decimal:2',

            'discount_amount' =>
                'decimal:2',

            'tax_amount' =>
                'decimal:2',

            'total_amount' =>
                'decimal:2',

            'created_by' =>
                'integer',

        ];
    }


    public function items(): HasMany
    {
        return $this->hasMany(
            SalesOrderItem::class,
            'sales_order_id'
        );
    }


    public function company(): BelongsTo
    {
        return $this->belongsTo(
            Company::class
        );
    }


    public function branch(): BelongsTo
    {
        return $this->belongsTo(
            Branch::class,
            'branch_id'
        );
    }


    public function customer(): BelongsTo
    {
        return $this->belongsTo(
            Customer::class,
            'customer_id'
        );
    }


    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }
}