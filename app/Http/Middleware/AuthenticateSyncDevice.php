<?php

namespace App\Http\Middleware;

use App\Services\Sync\SyncIdentityService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AuthenticateSyncDevice
{
    public function __construct(
        protected SyncIdentityService $syncIdentityService
    ) {
    }

    /**
     * Handle an incoming request.
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $deviceUuid = $request->header('X-Sync-Device');
        $syncToken = $request->header('X-Sync-Token');

        if (!$deviceUuid || !$syncToken) {
            return response()->json([
                'success' => false,
                'message' => 'Synchronization credentials are required.',
            ], 401);
        }

        try {
            $device = $this->syncIdentityService->authenticate(
                $deviceUuid,
                $syncToken
            );
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid synchronization credentials.',
            ], 401);
        }

        /*
        |--------------------------------------------------------------------------
        | Make authenticated device available to the request
        |--------------------------------------------------------------------------
        */

        $request->attributes->set(
            'sync_device',
            $device
        );

        return $next($request);
    }
}

