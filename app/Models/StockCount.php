<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StockCount extends Model
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

        'reference_no',

        'count_date',

        'status',

        'notes',

        'created_by',

        'completed_by',

        'completed_at',

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

            'count_date' =>
                'date',

            'created_by' =>
                'integer',

            'completed_by' =>
                'integer',

            'completed_at' =>
                'datetime',

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
     * User who created the stock count.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }


    /**
     * User who completed the stock count.
     */
    public function completedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'completed_by'
        );
    }


    /**
     * Stock count items.
     */
    public function items(): HasMany
    {
        return $this->hasMany(
            StockCountItem::class,
            'stock_count_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */


    /**
     * Company stock counts.
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
     * Branch stock counts.
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
     * Filter by status.
     */
    public function scopeStatus(
        Builder $query,
        string $status
    ): Builder {

        return $query->where(
            'status',
            $status
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */


    /**
     * Check if count is draft.
     */
    public function isDraft(): bool
    {
        return $this->status === 'Draft';
    }


    /**
     * Check if count is in progress.
     */
    public function isInProgress(): bool
    {
        return $this->status === 'In Progress';
    }


    /**
     * Check if count is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'Completed';
    }


    /**
     * Check if count is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === 'Cancelled';
    }


    /**
     * Check if count can be edited.
     */
    public function canEdit(): bool
    {
        return in_array(
            $this->status,
            [
                'Draft',
                'In Progress',
            ],
            true
        );
    }


    /**
     * Check if count can be completed.
     */
    public function canComplete(): bool
    {
        return $this->status ===
            'In Progress';
    }


    /**
     * Total items.
     */
    public function itemCount(): int
    {
        return $this->items()->count();
    }


    /**
     * Items with variance.
     */
    public function varianceItemCount(): int
    {
        return $this->items()
            ->where(
                'variance',
                '!=',
                0
            )
            ->count();
    }


    /**
     * Total positive variance.
     */
    public function positiveVariance(): float
    {
        return (float) $this->items()
            ->where(
                'variance',
                '>',
                0
            )
            ->sum('variance');
    }


    /**
     * Total negative variance.
     */
    public function negativeVariance(): float
    {
        return (float) $this->items()
            ->where(
                'variance',
                '<',
                0
            )
            ->sum('variance');
    }

}