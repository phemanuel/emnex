<?php

namespace App\Http\Controllers\Platform\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PlatformLoginController extends Controller
{
    public function show()
    {
        return view(
            'platform.auth.login'
        );
    }


    public function login(
        Request $request
    ) {

        $credentials =
            $request->validate([

                'email' =>
                    [
                        'required',
                        'email',
                    ],

                'password' =>
                    [
                        'required',
                        'string',
                    ],

            ]);


        $remember =
            $request->boolean(
                'remember'
            );


        if (
            !Auth::guard('platform')
                ->attempt(
                    $credentials,
                    $remember
                )
        ) {

            throw ValidationException::withMessages([

                'email' =>
                    'The email address or password is incorrect.',

            ]);

        }


        $request->session()
            ->regenerate();


        $admin =
            Auth::guard('platform')
                ->user();


        if (!$admin->status) {

            Auth::guard('platform')
                ->logout();


            throw ValidationException::withMessages([

                'email' =>
                    'This platform account is currently disabled.',

            ]);

        }


        $admin->update([

            'last_login_at' =>
                now(),

            'last_activity_at' =>
                now(),

        ]);


        return redirect()
            ->intended(
                route(
                    'platform.dashboard'
                )
            );
    }


    public function logout(
        Request $request
    ) {

        Auth::guard('platform')
            ->logout();


        $request->session()
            ->invalidate();


        $request->session()
            ->regenerateToken();


        return redirect()
            ->route(
                'platform.login'
            );
    }
}