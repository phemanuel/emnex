<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{

    /**
     * |--------------------------------------------------------------------------
     * | Authenticate User
     * |--------------------------------------------------------------------------
     */

    public function login(
        array $credentials,
        bool $remember = false
    ): User {

        $login =
            trim(
                (string) (
                    $credentials['login']
                    ?? ''
                )
            );


        /**
         * |--------------------------------------------------------------------------
         * | Determine Login Type
         * |--------------------------------------------------------------------------
         *
         * | Email addresses are looked up strictly by email.
         * |
         * | Everything else is treated as a username.
         * |
         */

        $isEmail =
            filter_var(
                $login,
                FILTER_VALIDATE_EMAIL
            ) !== false;


        /**
         * |--------------------------------------------------------------------------
         * | Find User
         * |--------------------------------------------------------------------------
         */

        $query =
            User::query()
                ->with('company')
                ->where(
                    'status',
                    true
                );


        if ($isEmail) {

            $user =
                $query
                    ->where(
                        'email',
                        $login
                    )
                    ->first();

        } else {

            $users =
                $query
                    ->where(
                        'username',
                        $login
                    )
                    ->limit(2)
                    ->get();


            /**
             * |--------------------------------------------------------------------------
             * | Duplicate Username Protection
             * |--------------------------------------------------------------------------
             *
             * | Company Code is no longer part of authentication.
             * |
             * | If the same username exists for multiple users, EMNEX cannot safely
             * | determine which workspace the person intended to access.
             * |
             * | In that case, require the globally unique email address instead.
             * |
             */

            if ($users->count() > 1) {

                throw ValidationException::withMessages([

                    'login' =>
                        'This username is linked to more than one account. Please sign in with your email address.',

                ]);

            }


            $user =
                $users->first();

        }


        if (!$user) {

            throw ValidationException::withMessages([

                'login' =>
                    'Invalid username or email.',

            ]);

        }


        /**
         * |--------------------------------------------------------------------------
         * | Verify Company
         * |--------------------------------------------------------------------------
         */

        $company =
            $user->company;


        if (
            !$company
            ||
            !$company->status
        ) {

            throw ValidationException::withMessages([

                'login' =>
                    'This account is currently unavailable.',

            ]);

        }


        /**
         * |--------------------------------------------------------------------------
         * | Verify Password
         * |--------------------------------------------------------------------------
         */

        if (
            !Hash::check(
                $credentials['password'],
                $user->password
            )
        ) {

            throw ValidationException::withMessages([

                'password' =>
                    'Incorrect password.',

            ]);

        }


        /**
         * |--------------------------------------------------------------------------
         * | Login User
         * |--------------------------------------------------------------------------
         */

        Auth::login(
            $user,
            $remember
        );


        /**
         * |--------------------------------------------------------------------------
         * | Update Login Details
         * |--------------------------------------------------------------------------
         */

        $user->update([

            'last_login_at' =>
                now(),

            'last_login_ip' =>
                request()->ip(),

        ]);


        /**
         * |--------------------------------------------------------------------------
         * | Store Company Session
         * |--------------------------------------------------------------------------
         *
         * | The company is now determined from the authenticated user rather
         * | than from a company code supplied by the browser.
         * |
         */

        session([

            'company_id' =>
                $company->id,

            'company_name' =>
                $company->name,

            'company_code' =>
                $company->company_code,

            'branch_id' =>
                $user->branch_id,

            'currency' =>
                $company->currency,

            'currency_symbol' =>
                $company->currency_symbol,

            'timezone' =>
                $company->timezone,

        ]);


        return $user;

    }


    /**
     * |--------------------------------------------------------------------------
     * | Logout
     * |--------------------------------------------------------------------------
     */

    public function logout(): void
    {

        Auth::logout();


        request()
            ->session()
            ->invalidate();


        request()
            ->session()
            ->regenerateToken();

    }

}