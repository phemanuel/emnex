<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
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

        'order_id',

        'customer_id',

        'invoice_no',

        'invoice_date',

        'subtotal',

        'discount',

        'tax',

        'total',

        'amount_paid',

        'balance',

        'total_quantity',

        'total_items',

        'grand_total',

        'payment_status',

        'invoice_status',

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

            'order_id' =>
                'integer',

            'customer_id' =>
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

            'total_quantity' =>
                'decimal:2',

            'total_items' =>
                'integer',

            'grand_total' =>
                'decimal:2',

            'invoice_date' =>
                'date',

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
     * Sales Order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(
            Order::class,
            'order_id'
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
     * Invoice Items
     */
    public function invoiceItems(): HasMany
    {
        return $this->hasMany(
            InvoiceItem::class,
            'invoice_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Filter by company.
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
     * Active invoices.
     */
    public function scopeActive(
        Builder $query
    ): Builder {

        return $query->where(
            'invoice_status',
            'Active'
        );

    }


    /**
     * Paid invoices.
     */
    public function scopePaid(
        Builder $query
    ): Builder {

        return $query->where(
            'payment_status',
            'Paid'
        );

    }


    /**
     * Pending invoices.
     */
    public function scopePending(
        Builder $query
    ): Builder {

        return $query->where(
            'payment_status',
            'Pending'
        );

    }


    /**
     * Partially paid invoices.
     */
    public function scopePartial(
        Builder $query
    ): Builder {

        return $query->where(
            'payment_status',
            'Partial'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Check if invoice is paid.
     */
    public function isPaid(): bool
    {
        return $this->payment_status ===
            'Paid';
    }


    /**
     * Check if invoice is partially paid.
     */
    public function isPartiallyPaid(): bool
    {
        return $this->payment_status ===
            'Partial';
    }


    /**
     * Check if invoice payment is pending.
     */
    public function isPaymentPending(): bool
    {
        return $this->payment_status ===
            'Pending';
    }


    /**
     * Check if invoice is active.
     */
    public function isActive(): bool
    {
        return $this->invoice_status ===
            'Active';
    }


    /**
     * Check if invoice has outstanding balance.
     */
    public function hasBalance(): bool
    {
        return (float) $this->balance > 0;
    }


    /**
     * Total quantity in the invoice.
     */
    public function totalQuantity(): float
    {
        return (float) $this->invoiceItems()->sum(
            'quantity'
        );
    }


    /**
     * Total number of invoice lines.
     */
    public function totalItems(): int
    {
        return $this->invoiceItems()->count();
    }

}