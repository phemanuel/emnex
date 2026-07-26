<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * StockMovement Model
 *
 * Records every inventory movement performed in the system.
 */
class StockMovement extends Model
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
        'product_id',
        'order_id',
        'user_id',

        'movement_type',

        'quantity',

        'stock_before',
        'stock_after',

        'reference_number',

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
            'company_id'   => 'integer',
            'branch_id'    => 'integer',
            'product_id'   => 'integer',
            'order_id'     => 'integer',
            'user_id'      => 'integer',

            'quantity'     => 'decimal:2',
            'stock_before' => 'decimal:2',
            'stock_after'  => 'decimal:2',
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
     * Product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
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

    /**
     * Filter by branch.
     */
    public function scopeBranch(Builder $query, int $branchId): Builder
    {
        return $query->where('branch_id', $branchId);
    }

    /**
     * Filter by movement type.
     */
    public function scopeType(Builder $query, string $type): Builder
    {
        return $query->where('movement_type', $type);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Determine whether this movement increased stock.
     */
    public function isStockIn(): bool
    {
        return in_array($this->movement_type, [
            'Opening Stock',
            'Purchase',
            'Adjustment In',
            'Transfer In',
            'Customer Return',
        ]);
    }

    /**
     * Determine whether this movement reduced stock.
     */
    public function isStockOut(): bool
    {
        return in_array($this->movement_type, [
            'Sale',
            'Adjustment Out',
            'Transfer Out',
            'Damaged',
            'Expired',
            'Supplier Return',
        ]);
    }
}