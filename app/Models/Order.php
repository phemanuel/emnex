<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Order Model
 *
 * Represents a sales transaction.
 */
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

        'order_number',

        'subtotal',
        'discount_amount',
        'tax_amount',
        'total_amount',
        'paid_amount',
        'balance_amount',

        'payment_status',
        'order_status',

        'notes',
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
            'customer_id'     => 'integer',
            'cashier_id'      => 'integer',

            'subtotal'        => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'tax_amount'      => 'decimal:2',
            'total_amount'    => 'decimal:2',
            'paid_amount'     => 'decimal:2',
            'balance_amount'  => 'decimal:2',
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
     * Customer
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Cashier
     */
    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    /**
     * Order Items
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    /**
     * Payments
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'order_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeForCompany(Builder $query, int $companyId): Builder
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('order_status', 'Completed');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('order_status', 'Pending');
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
        return $this->order_status === 'Completed';
    }

    /**
     * Check if the order is fully paid.
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'Paid';
    }

    /**
     * Check if the order is pending.
     */
    public function isPending(): bool
    {
        return $this->order_status === 'Pending';
    }

    /**
     * Check if there is an outstanding balance.
     */
    public function hasBalance(): bool
    {
        return $this->balance_amount > 0;
    }

    /**
     * Total number of items in the order.
     */
    public function totalItems(): int
    {
        return $this->orderItems()->sum('quantity');
    }
}