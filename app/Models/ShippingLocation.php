<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingLocation extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'description',
        'shipping_fee',
        'sort_order',
        'status',
        'created_by',
        'updated_by',
    ];


    protected function casts(): array
    {
        return [
            'company_id' =>
                'integer',

            'shipping_fee' =>
                'decimal:2',

            'sort_order' =>
                'integer',

            'status' =>
                'boolean',

            'created_by' =>
                'integer',

            'updated_by' =>
                'integer',
        ];
    }


    public function company(): BelongsTo
    {
        return $this->belongsTo(
            Company::class,
            'company_id'
        );
    }


    public function scopeForCompany(
        Builder $query,
        int $companyId
    ): Builder {

        return $query->where(
            'company_id',
            $companyId
        );
    }


    public function scopeActive(
        Builder $query
    ): Builder {

        return $query->where(
            'status',
            true
        );
    }
}