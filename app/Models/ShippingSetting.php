<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingSetting extends Model
{
    protected $fillable = [
        'company_id',
        'enabled',
        'shipping_mode',
        'manual_shipping_fee',
        'created_by',
        'updated_by',
    ];


    protected function casts(): array
    {
        return [
            'company_id' =>
                'integer',

            'enabled' =>
                'boolean',

            'manual_shipping_fee' =>
                'decimal:2',

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
}