<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class GoodsReceived extends Model
{
    use HasFactory;


     /*
    |--------------------------------------------------------------------------
    | Table
    |--------------------------------------------------------------------------
    */

    protected $table =
        'goods_received';

    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'company_id',

        'branch_id',

        'purchase_order_id',

        'supplier_id',

        'receipt_number',

        'received_date',

        'status',

        'notes',

        'received_by',

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

            'purchase_order_id' =>
                'integer',

            'supplier_id' =>
                'integer',

            'received_by' =>
                'integer',

            'received_date' =>
                'date',

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


    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(
            PurchaseOrder::class,
            'purchase_order_id'
        );
    }


    public function supplier(): BelongsTo
    {
        return $this->belongsTo(
            Supplier::class,
            'supplier_id'
        );
    }


    public function receiver(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'received_by'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Received By
    |--------------------------------------------------------------------------
    */

    /**
     * User who received the goods.
     */
    public function receivedBy()
    {
        return $this->belongsTo(
            User::class,
            'received_by'
        );
    }


    public function items(): HasMany
    {
        return $this->hasMany(
            GoodsReceivedItem::class,
            'goods_received_id'
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
}