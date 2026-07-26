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
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = auth()->user();

        if (!$user) {
            abort(401);
        }

        // Company owner bypasses all permission checks
        if ($user->is_owner) {
            return $next($request);
        }

        if (!$user->role) {
            abort(403, 'No role assigned.');
        }

        $hasPermission = $user->role
            ->permissions()
            ->where('permissions.name', $permission)
            ->where('permissions.status', true)
            ->exists();

        if (!$hasPermission) {
            abort(403, 'You do not have permission to perform this action.');
        }

        return $next($request);
    }
}