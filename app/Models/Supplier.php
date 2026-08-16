<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\PurchaseOrder;
use App\Models\GoodsReceived;
use App\Models\PurchaseReturn;

class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;


    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'company_id',

        'supplier_code',

        'name',

        'contact_person',

        'email',

        'phone',

        'alternate_phone',

        'address',

        'city',

        'state',

        'country',

        'tax_number',

        'payment_terms',

        'credit_limit',

        'current_balance',

        'notes',

        'status',

        'created_by',

        'updated_by',

    ];


    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'credit_limit' =>
            'decimal:2',

        'current_balance' =>
            'decimal:2',

        'status' =>
            'boolean',

    ];


    /*
    |--------------------------------------------------------------------------
    | Company
    |--------------------------------------------------------------------------
    */

    public function company()
    {
        return $this->belongsTo(
            Company::class
        );
    }


    /**
     * User who created the supplier.
     */
    public function creator()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }


    /**
     * User who last updated the supplier.
     */
    public function updater()
    {
        return $this->belongsTo(
            User::class,
            'updated_by'
        );
    }

        /*
    |--------------------------------------------------------------------------
    | Purchasing Relationships
    |--------------------------------------------------------------------------
    */


    /**
     * Purchase Orders
     */
    public function purchaseOrders()
    {
        return $this->hasMany(
            PurchaseOrder::class,
            'supplier_id'
        );
    }


    /**
     * Goods Received
     */
    public function goodsReceived()
    {
        return $this->hasMany(
            GoodsReceived::class,
            'supplier_id'
        );
    }


    /**
     * Purchase Returns
     */
    public function purchaseReturns()
    {
        return $this->hasMany(
            PurchaseReturn::class,
            'supplier_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Display Name
    |--------------------------------------------------------------------------
    */

    public function displayName(): string
    {
        return $this->name;
    }


    /*
    |--------------------------------------------------------------------------
    | Available Credit
    |--------------------------------------------------------------------------
    */

    public function availableCredit(): float
    {
        return max(
            0,
            (float) $this->credit_limit -
            (float) $this->current_balance
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Status Label
    |--------------------------------------------------------------------------
    */

    public function statusLabel(): string
    {
        return $this->status
            ? 'Active'
            : 'Inactive';
    }
}