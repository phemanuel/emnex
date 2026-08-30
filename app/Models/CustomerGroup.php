<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Helpers\CurrencyHelper;


class CustomerGroup extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'company_id',

        'name',

        'code',

        'description',

        'discount_percentage',

        'credit_limit',

        'status',

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

            'discount_percentage' =>
                'decimal:2',

            'credit_limit' =>
                'decimal:2',

            'status' =>
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
     * Customers
     *
     * This relationship will be used when
     * the Customers module is created.
     */
    public function customers(): HasMany
    {
        return $this->hasMany(
            Customer::class,
            'customer_group_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */


    /**
     * Active customer groups only.
     */
    public function scopeActive(
        Builder $query
    ): Builder {

        return $query->where(
            'status',
            true
        );

    }


    /**
     * Customer groups belonging to company.
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


    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */


    /**
     * Check if customer group is active.
     */
    public function isActive(): bool
    {
        return (bool) $this->status;
    }


    /**
     * Get customer count.
     */
    public function customerCount(): int
    {
        return $this->customers()->count();
    }


    /**
     * Get formatted discount percentage.
     */
    public function formattedDiscount(): string
    {
        return number_format(
            (float) $this->discount_percentage,
            2
        ) . '%';
    }


    /**
     * Get formatted credit limit.
     */
    public function formattedCreditLimit(): string
    {
       return \App\Helpers\CurrencyHelper::format( (float) $this->credit_limit );
    }


    /**
     * Display name.
     */
    public function displayName(): string
    {
        return $this->name .
            ' (' .
            $this->code .
            ')';
    }

}