<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class PaymentMethod extends Model
{
    use HasFactory, SoftDeletes;


    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'company_id',

        'name',

        'code',

        'icon',

        'color',

        'requires_reference',

        'is_cash',

        'allow_change',

        'display_order',

        'status',

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

            'requires_reference' => 'boolean',

            'is_cash' => 'boolean',

            'allow_change' => 'boolean',

            'display_order' => 'integer',

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
        return $this->belongsTo(
            Company::class
        );
    }



    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */


    /**
     * Active payment methods only.
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
     * Cash payment methods.
     */
    public function scopeCash(
        Builder $query
    ): Builder {

        return $query->where(
            'is_cash',
            true
        );

    }



    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */


    public function isActive(): bool
    {
        return $this->status;
    }


    public function requiresReference(): bool
    {
        return $this->requires_reference;
    }


    public function allowsChange(): bool
    {
        return $this->allow_change;
    }

}