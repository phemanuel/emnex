<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;


class SalesReturn extends Model
{

    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'company_id',

        'branch_id',

        'terminal_id',

        'order_id',

        'invoice_id',

        'customer_id',

        'return_number',

        'return_type',

        'order_total',

        'amount_paid',

        'balance',

        'refund_amount',

        'refund_method',

        'return_status',

        'reason',

        'remarks',

        'processed_by',

        'processed_at',

        'created_by',

        'updated_by',

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

            'terminal_id' =>
                'integer',

            'order_id' =>
                'integer',

            'invoice_id' =>
                'integer',

            'customer_id' =>
                'integer',

            'order_total' =>
                'decimal:2',

            'amount_paid' =>
                'decimal:2',

            'balance' =>
                'decimal:2',

            'refund_amount' =>
                'decimal:2',

            'processed_by' =>
                'integer',

            'processed_at' =>
                'datetime',

            'created_by' =>
                'integer',

            'updated_by' =>
                'integer',

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
     * Branch
     */
    public function branch(): BelongsTo
    {

        return $this->belongsTo(
            Branch::class,
            'branch_id'
        );

    }


    /**
     * Terminal
     */
    public function terminal(): BelongsTo
    {

        return $this->belongsTo(
            Terminal::class,
            'terminal_id'
        );

    }


    /**
     * Order
     */
    public function order(): BelongsTo
    {

        return $this->belongsTo(
            Order::class,
            'order_id'
        );

    }


    /**
     * Invoice
     */
    public function invoice(): BelongsTo
    {

        return $this->belongsTo(
            Invoice::class,
            'invoice_id'
        );

    }


    /**
     * Customer
     */
    public function customer(): BelongsTo
    {

        return $this->belongsTo(
            Customer::class,
            'customer_id'
        );

    }


    /**
     * Processed By
     */
    public function processedBy(): BelongsTo
    {

        return $this->belongsTo(
            User::class,
            'processed_by'
        );

    }


    /**
     * Created By
     */
    public function createdBy(): BelongsTo
    {

        return $this->belongsTo(
            User::class,
            'created_by'
        );

    }


    /**
     * Updated By
     */
    public function updatedBy(): BelongsTo
    {

        return $this->belongsTo(
            User::class,
            'updated_by'
        );

    }


    /**
     * Return Payments
     */
    public function payments(): HasMany
    {

        return $this->hasMany(
            SalesReturnPayment::class,
            'sales_return_id'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Company returns.
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


    /**
     * Completed returns.
     */
    public function scopeCompleted(
        Builder $query
    ): Builder {

        return $query->where(
            'return_status',
            'Completed'
        );

    }


    /**
     * Pending returns.
     */
    public function scopePending(
        Builder $query
    ): Builder {

        return $query->where(
            'return_status',
            'Pending'
        );

    }


    /**
     * Cancelled returns.
     */
    public function scopeCancelled(
        Builder $query
    ): Builder {

        return $query->where(
            'return_status',
            'Cancelled'
        );

    }


    /**
     * Failed returns.
     */
    public function scopeFailed(
        Builder $query
    ): Builder {

        return $query->where(
            'return_status',
            'Failed'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Check if return is completed.
     */
    public function isCompleted(): bool
    {

        return $this->return_status ===
            'Completed';

    }


    /**
     * Check if return is pending.
     */
    public function isPending(): bool
    {

        return $this->return_status ===
            'Pending';

    }


    /**
     * Check if return is cancelled.
     */
    public function isCancelled(): bool
    {

        return $this->return_status ===
            'Cancelled';

    }


    /**
     * Check if return is failed.
     */
    public function isFailed(): bool
    {

        return $this->return_status ===
            'Failed';

    }


    /**
     * Check if stock should be returned.
     */
    public function returnsStock(): bool
    {

        return $this->return_type ===
            'Completed';

    }


    /**
     * Check if refund has been processed.
     */
    public function isProcessed(): bool
    {

        return
            $this->return_status ===
            'Completed';

    }

}