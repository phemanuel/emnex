<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    /**
     * Show Login Page
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {

        /**
         * |--------------------------------------------------------------------------
         * | Validate Request
         * |--------------------------------------------------------------------------
         */

        $credentials =
            $request->validate([

                'login' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'password' => [
                    'required',
                    'string',
                ],

            ], [

                'login.required' =>
                    'Please enter your username or email address.',

                'password.required' =>
                    'Please enter your password.',

            ]);


        /**
         * |--------------------------------------------------------------------------
         * | Authenticate User
         * |--------------------------------------------------------------------------
         */

        $this->authService->login(
            $credentials,
            $request->boolean(
                'remember'
            )
        );


        /**
         * |--------------------------------------------------------------------------
         * | Regenerate Session
         * |--------------------------------------------------------------------------
         */

        $request
            ->session()
            ->regenerate();


        /**
         * |--------------------------------------------------------------------------
         * | Redirect
         * |--------------------------------------------------------------------------
         */

        return redirect()
            ->route(
                'dashboard'
            );

    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $this->authService->logout();

        return redirect()->route('login');
    }
}