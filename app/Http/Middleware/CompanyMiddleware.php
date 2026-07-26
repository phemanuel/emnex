<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        /*
        |--------------------------------------------------------------------------
        | Check authenticated user
        |--------------------------------------------------------------------------
        */

        if (!Auth::check()) {

            return redirect()->route('login');

        }


        /*
        |--------------------------------------------------------------------------
        | Check company assignment
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();


        if (!$user->company_id) {

            abort(403, 'User is not assigned to a company.');

        }


        /*
        |--------------------------------------------------------------------------
        | Share company globally
        |--------------------------------------------------------------------------
        */

        app()->instance(
            'current_company',
            $user->company
        );


        return $next($request);
    }
}