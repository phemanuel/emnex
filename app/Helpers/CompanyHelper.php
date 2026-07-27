<?php

namespace App\Helpers;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class CompanyHelper
{
    /**
     * Get the authenticated user's company.
     */
    public static function current(): ?Company
    {
        if (!Auth::check()) {
            return null;
        }

        return Auth::user()->company;
    }

    /**
     * Get the authenticated company ID.
     */
    public static function id(): ?int
    {
        return self::current()?->id;
    }
}