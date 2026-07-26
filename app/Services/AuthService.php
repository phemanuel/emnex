<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Authenticate a user.
     */
    public function login(array $credentials, bool $remember = false): User
    {        
        /*
        |--------------------------------------------------------------------------
        | Find Company
        |--------------------------------------------------------------------------
        */

        $company = Company::where('company_code', $credentials['company_code'])
            ->where('status', true)
            ->first();

        if (!$company) {
            throw ValidationException::withMessages([
                'company_code' => 'Invalid company code.',
            ]);
        }
    

        /*
        |--------------------------------------------------------------------------
        | Find User
        |--------------------------------------------------------------------------
        */

        $user = User::where('company_id', $company->id)
            ->where('username', $credentials['username'])
            ->where('status', true)
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'username' => 'Invalid username.',
            ]);
        }
        // dd('User found');

        /*
        |--------------------------------------------------------------------------
        | Verify Password
        |--------------------------------------------------------------------------
        */

        if (!Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'password' => 'Incorrect password.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Login User
        |--------------------------------------------------------------------------
        */

        Auth::login($user, $remember);

        /*
        |--------------------------------------------------------------------------
        | Update Login Details
        |--------------------------------------------------------------------------
        */

        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Store Company Session
        |--------------------------------------------------------------------------
        */

        session([
            'company_id'       => $company->id,
            'company_name'     => $company->name,
            'company_code'     => $company->company_code,
            'branch_id'        => $user->branch_id,
            'currency'         => $company->currency,
            'currency_symbol'  => $company->currency_symbol,
            'timezone'         => $company->timezone,
        ]);

        return $user;
    }

    /**
     * Logout the current user.
     */
    public function logout(): void
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();
    }
}