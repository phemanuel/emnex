<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends Model
{
    use HasFactory, SoftDeletes;


    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'company_id',

        'branch_id',

        'supplier_id',

        'order_number',

        'order_date',

        'expected_date',

        'status',

        'subtotal',

        'discount',

        'tax',

        'shipping',

        'total',

        'notes',

        'created_by',

        'approved_by',

        'approved_at',

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

            'supplier_id' =>
                'integer',

            'created_by' =>
                'integer',

            'approved_by' =>
                'integer',

            'order_date' =>
                'date',

            'expected_date' =>
                'date',

            'subtotal' =>
                'decimal:2',

            'discount' =>
                'decimal:2',

            'tax' =>
                'decimal:2',

            'shipping' =>
                'decimal:2',

            'total' =>
                'decimal:2',

            'approved_at' =>
                'datetime',

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function company(): BelongsTo
    {
        return $this->belongsTo(
            Company::class,
            'company_id'
        );
    }


    public function branch(): BelongsTo
    {
        return $this->belongsTo(
            Branch::class,
            'branch_id'
        );
    }


    public function supplier(): BelongsTo
    {
        return $this->belongsTo(
            Supplier::class,
            'supplier_id'
        );
    }


    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }


    public function approver(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'approved_by'
        );
    }


    public function items(): HasMany
    {
        return $this->hasMany(
            PurchaseOrderItem::class,
            'purchase_order_id'
        );
    }


    public function goodsReceived(): HasMany
    {
        return $this->hasMany(
            GoodsReceived::class,
            'purchase_order_id'
        );
    }


    public function purchaseReturns(): HasMany
    {
        return $this->hasMany(
            PurchaseReturn::class,
            'purchase_order_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
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

    public function isDraft(): bool
    {
        return $this->status === 'Draft';
    }


    public function isPending(): bool
    {
        return $this->status === 'Pending';
    }


    public function isApproved(): bool
    {
        return $this->status === 'Approved';
    }


    public function isPartiallyReceived(): bool
    {
        return $this->status === 'Partially Received';
    }


    public function isReceived(): bool
    {
        return $this->status === 'Received';
    }


    public function isCancelled(): bool
    {
        return $this->status === 'Cancelled';
    }
}