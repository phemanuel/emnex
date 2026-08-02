<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Setting Model
 *
 * Stores company-specific application settings.
 */
class Setting extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'company_id',

        // Company
        'company_name',
        'company_email',
        'company_phone',
        'company_address',
        'company_logo',

        // Localization
        'currency',
        'currency_symbol',
        'timezone',
        'date_format',
        'time_format',

        // Tax
        'tax_enabled',
        'tax_rate',

        // Receipt
        'receipt_header',
        'receipt_footer',
        'receipt_width',
        'print_logo',
        'print_barcode',

        // Inventory
        'low_stock_alert',
        'allow_negative_stock',

        // Sales
        'allow_price_override',
        'allow_discount',
        'enable_customer_credit',
        'default_customer_id',

        // System
        'maintenance_mode',
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

        'tax_enabled'            => 'boolean',

        'print_logo'             => 'boolean',

        'print_barcode'          => 'boolean',

        'allow_negative_stock'   => 'boolean',

        'allow_price_override'   => 'boolean',

        'allow_discount'         => 'boolean',

        'enable_customer_credit' => 'boolean',

        'maintenance_mode'       => 'boolean',

        'status'                 => 'boolean',

        'tax_rate'               => 'decimal:2',

        'low_stock_alert'        => 'integer',

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
     * Default Customer
     */
    public function defaultCustomer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'default_customer_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Active settings.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Check if tax is enabled.
     */
    public function taxEnabled(): bool
    {
        return (bool) $this->tax_enabled;
    }

    /**
     * Check if discounts are enabled.
     */
    public function discountsEnabled(): bool
    {
        return (bool) $this->allow_discount;
    }

    /**
     * Check if negative stock is allowed.
     */
    public function allowsNegativeStock(): bool
    {
        return (bool) $this->allow_negative_stock;
    }

    /**
     * Check if price override is allowed.
     */
    public function allowsPriceOverride(): bool
    {
        return (bool) $this->allow_price_override;
    }
}