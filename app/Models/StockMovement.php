<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


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

        'reference_no',

        'unit_cost',

        'quantity',

        'balance_after',

        'remarks',

        'created_by',

        'movement_type',

        'stock_before',

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

            'product_id' =>
                'integer',

            'order_id' =>
                'integer',

            'created_by' =>
                'integer',

            'unit_cost' =>
                'decimal:2',

            'quantity' =>
                'decimal:2',

            'stock_before' =>
                'decimal:2',

            'balance_after' =>
                'decimal:2',

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
     * Product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class,
            'product_id'
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
     * User who created the movement.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    /*
|--------------------------------------------------------------------------
| User
|--------------------------------------------------------------------------
*/

public function user(): BelongsTo
{
    return $this->belongsTo(
        User::class,
        'user_id'
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
     * Filter by branch.
     */
    public function scopeBranch(
        Builder $query,
        int $branchId
    ): Builder {

        return $query->where(
            'branch_id',
            $branchId
        );

    }


    /**
     * Filter by movement type.
     */
    public function scopeType(
        Builder $query,
        string $type
    ): Builder {

        return $query->where(
            'movement_type',
            $type
        );

    }


    /**
     * Latest movements first.
     */
    public function scopeLatestMovement(
        Builder $query
    ): Builder {

        return $query->latest('id');

    }


    /*
    |--------------------------------------------------------------------------
    | Movement Types
    |--------------------------------------------------------------------------
    */


    /**
     * Movement types allowed by the database.
     */
    public static function movementTypes(): array
    {
        return [

            'Opening Stock',

            'Purchase',

            'Sale',

            'Return',

            'Adjustment',

            'Transfer',

            'Damage',

            'Expired',

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Movement Direction
    |--------------------------------------------------------------------------
    */


    /**
     * Determine whether this movement increases stock.
     */
    public function isStockIn(): bool
    {
        return in_array(
            $this->movement_type,
            [

                'Opening Stock',

                'Purchase',

                'Return',

            ],
            true
        );
    }


    /**
     * Determine whether this movement reduces stock.
     */
    public function isStockOut(): bool
    {
        return in_array(
            $this->movement_type,
            [

                'Sale',

                'Damage',

                'Expired',

            ],
            true
        );
    }


    /**
     * Determine whether this movement is an adjustment.
     */
    public function isAdjustment(): bool
    {
        return $this->movement_type ===
            'Adjustment';
    }


    /**
     * Determine whether this movement is a transfer.
     */
    public function isTransfer(): bool
    {
        return $this->movement_type ===
            'Transfer';
    }


    /*
    |--------------------------------------------------------------------------
    | Human Readable Movement Type
    |--------------------------------------------------------------------------
    */

    public function movementLabel(): string
    {
        return match ($this->movement_type) {

            'Opening Stock' =>
                'Opening Stock',

            'Purchase' =>
                'Purchase',

            'Sale' =>
                'Sale',

            'Return' =>
                'Return',

            'Adjustment' =>
                'Stock Adjustment',

            'Transfer' =>
                'Stock Transfer',

            'Damage' =>
                'Damaged Stock',

            'Expired' =>
                'Expired Stock',

            default =>
                $this->movement_type,

        };
    }
}

