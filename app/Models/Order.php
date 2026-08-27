<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
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

        'terminal_id',

        'customer_id',

        'cashier_id',

        'order_no',

        'subtotal',

        'discount',

        'discount_id',

        'tax_rate_id',

        'tax',

        'total',

        'amount_paid',

        'balance',

        'total_items',

        'total_quantity',

        'change_given',

        'grand_total',

        'completed_at',

        'payment_status',

        'order_status',

        'sales_channel',

        'receipt_printed',

        'remarks',

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

            'customer_id' =>
                'integer',

            'cashier_id' =>
                'integer',

            'discount_id' =>
                'integer',

            'tax_rate_id' =>
                'integer',

            'subtotal' =>
                'decimal:2',

            'discount' =>
                'decimal:2',

            'tax' =>
                'decimal:2',

            'total' =>
                'decimal:2',

            'amount_paid' =>
                'decimal:2',

            'balance' =>
                'decimal:2',

            'total_items' =>
                'integer',

            'total_quantity' =>
                'decimal:2',

            'change_given' =>
                'decimal:2',

            'grand_total' =>
                'decimal:2',

            'completed_at' =>
                'datetime',

            'receipt_printed' =>
                'boolean',

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
     * Cashier
     */
    public function cashier(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'cashier_id'
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
     * Discount
     */
    public function discountRecord(): BelongsTo
    {
        return $this->belongsTo(
            Discount::class,
            'discount_id'
        );
    }


    /**
     * Tax Rate
     */
    public function taxRate(): BelongsTo
    {
        return $this->belongsTo(
            TaxRate::class,
            'tax_rate_id'
        );
    }


    /**
     * Order Items
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(
            OrderItem::class,
            'order_id'
        );
    }


    /**
     * Payments
     */
    public function payments(): HasMany
    {
        return $this->hasMany(
            Payment::class,
            'order_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Company orders.
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
     * Completed orders.
     */
    public function scopeCompleted(
        Builder $query
    ): Builder {

        return $query->where(
            'order_status',
            'Completed'
        );

    }


    /**
     * Pending orders.
     */
    public function scopePending(
        Builder $query
    ): Builder {

        return $query->where(
            'order_status',
            'Pending'
        );

    }


    /**
     * Draft orders.
     */
    public function scopeDraft(
        Builder $query
    ): Builder {

        return $query->where(
            'order_status',
            'Draft'
        );

    }


    /**
     * Held orders.
     */
    public function scopeHeld(
        Builder $query
    ): Builder {

        return $query->where(
            'order_status',
            'Held'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Check if the order is completed.
     */
    public function isCompleted(): bool
    {
        return $this->order_status ===
            'Completed';
    }


    /**
     * Check if the order is paid.
     */
    public function isPaid(): bool
    {
        return $this->payment_status ===
            'Paid';
    }


    /**
     * Check if the order is pending payment.
     */
    public function isPaymentPending(): bool
    {
        return $this->payment_status ===
            'Pending';
    }


    /**
     * Check if the order is partially paid.
     */
    public function isPartiallyPaid(): bool
    {
        return $this->payment_status ===
            'Partial';
    }


    /**
     * Check if the order is pending.
     */
    public function isPending(): bool
    {
        return $this->order_status ===
            'Pending';
    }


    /**
     * Check if the order is draft.
     */
    public function isDraft(): bool
    {
        return $this->order_status ===
            'Draft';
    }


    /**
     * Check if the order is held.
     */
    public function isHeld(): bool
    {
        return $this->order_status ===
            'Held';
    }


    /**
     * Check if there is an outstanding balance.
     */
    public function hasBalance(): bool
    {
        return (float) $this->balance > 0;
    }


    /**
     * Total quantity in the order.
     */
    public function totalQuantity(): float
    {
        return (float) $this->orderItems()->sum(
            'quantity'
        );
    }


    /**
     * Total number of order lines.
     */
    public function totalItems(): int
    {
        return $this->orderItems()->count();
    }


    /**
     * Check if the order is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->order_status ===
            'Cancelled';
    }


    /**
     * Check if the order is refunded.
     */
    public function isRefunded(): bool
    {
        return $this->order_status ===
            'Refunded';
    }

}