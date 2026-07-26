<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Payment Model
 *
 * Represents a payment made against an order.
 */
class Payment extends Model
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
        'customer_id',

        'received_by',

        'payment_number',

        'payment_method',

        'amount',

        'reference_no',
        'transaction_reference',
        'payment_gateway',

        'payment_status',

        'payment_date',

        'remarks',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [

            'company_id'      => 'integer',
            'branch_id'       => 'integer',
            'terminal_id'     => 'integer',

            'order_id'        => 'integer',
            'customer_id'     => 'integer',

            'received_by'     => 'integer',

            'amount'          => 'decimal:2',

            'payment_date'    => 'datetime',
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
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * Branch
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    /**
     * Terminal
     */
    public function terminal(): BelongsTo
    {
        return $this->belongsTo(Terminal::class, 'terminal_id');
    }

    /**
     * Order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Customer
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Cashier
     */
    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Filter by company.
     */
    public function scopeForCompany(Builder $query, int $companyId): Builder
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('payment_status', 'Completed');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('payment_status', 'Pending');
    }

    public function scopeMethod(Builder $query, string $method): Builder
    {
        return $query->where('payment_method', $method);
    }
    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Check if payment is completed.
     */
    public function isCompleted(): bool
    {
        return $this->payment_status === 'Completed';
    }

    /**
     * Check if payment is cash.
     */
    public function isCash(): bool
    {
        return $this->payment_method === 'Cash';
    }

    /**
     * Check if payment is card.
     */
    public function isCard(): bool
    {
        return $this->payment_method === 'Card';
    }

    /**
     * Check if payment is bank transfer.
     */
    public function isTransfer(): bool
    {
        return $this->payment_method === 'Bank Transfer';
    }
}