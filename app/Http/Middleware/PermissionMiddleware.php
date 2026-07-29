<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(
        Request $request,
        Closure $next,
        string $permission
    ): Response {

        /*
        |--------------------------------------------------------------------------
        | Check Authentication
        |--------------------------------------------------------------------------
        */

        if (!auth()->check()) {

            abort(401);

        }


        /*
        |--------------------------------------------------------------------------
        | Check Permission
        |--------------------------------------------------------------------------
        */

        if (!auth()->user()->hasPermission($permission)) {


            if ($request->expectsJson()) {

                return response()->json([

                    'success' => false,

                    'message' => 'You do not have permission to perform this action.'

                ], 403);

            }


            abort(403, 'You do not have permission to access this page.');

        }


        return $next($request);
    }
}