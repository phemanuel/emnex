<?php

namespace App\Helpers;

use App\Models\Setting;

class CurrencyHelper
{

    /*
    |--------------------------------------------------------------------------
    | Current Settings
    |--------------------------------------------------------------------------
    */

    /**
     * Get the active settings for the current company.
     */
    public static function settings(): ?Setting
    {
        return Setting::active()
            ->where(
                'company_id',
                companyId()
            )
            ->first();
    }


    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    */

    /**
     * Get the current currency code.
     */
    public static function currency(): string
    {
        return self::settings()?->currency
            ?? 'NGN';
    }


    /**
     * Get the current currency symbol.
     */
    public static function symbol(): string
    {
        return self::settings()?->currency_symbol
            ?? '';
    }


    /*
    |--------------------------------------------------------------------------
    | Formatting
    |--------------------------------------------------------------------------
    */

    /**
     * Format an amount using the company's configured currency.
     */
    public static function format(
        float|int|string|null $amount
    ): string {

        $value =
            (float) (
                $amount ?? 0
            );


        return self::symbol()
            .
            number_format(
                $value,
                2
            );

    }

}

