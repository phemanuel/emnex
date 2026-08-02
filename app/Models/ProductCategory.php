<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Product Category Model
 *
 * Handles product classification.
 *
 * Example:
 *
 * Electronics
 *      |
 *      Phones
 *
 */
class ProductCategory extends Model
{

    use HasFactory, SoftDeletes;



    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'company_id',

        'category_code',

        'name',

        'description',

        'parent_id',

        'image',

        'sort_order',

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

            'company_id' => 'integer',

            'parent_id' => 'integer',

            'sort_order' => 'integer',

            'status' => 'boolean',

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
        return $this->belongsTo(Company::class);
    }


    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }


    public function children(): HasMany
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }


    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }


    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'updated_by'
        );
    } 


    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */



    /**
     * Active categories only.
     */
    public function scopeActive(
        Builder $query
    ): Builder
    {

        return $query->where(
            'status',
            true
        );

    }



    /**
     * Categories for a specific company.
     */
    public function scopeForCompany(
        Builder $query,
        int $companyId
    ): Builder
    {

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
     * Check if category is active.
     */
    public function isActive(): bool
    {

        return $this->status;

    }



    /**
     * Display category name.
     */
    public function displayName(): string
    {

        return $this->name;

    }



}