<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class BaseController extends Controller
{
    /**
     * Success flash message.
     */
    protected function success(
        string $message,
        string $route,
        array $parameters = []
    ): RedirectResponse {

        return redirect()
            ->route($route, $parameters)
            ->with('success', $message);

    }

    /**
     * Error flash message.
     */
    protected function error(
        string $message
    ): RedirectResponse {

        return back()
            ->withInput()
            ->with('error', $message);

    }

    /**
     * JSON Success Response.
     */
    protected function successResponse(
        mixed $data = null,
        string $message = 'Success',
        int $status = 200
    ): JsonResponse {

        return response()->json([

            'success' => true,

            'message' => $message,

            'data' => $data,

        ], $status);

    }

    /**
     * JSON Error Response.
     */
    protected function errorResponse(
        string $message = 'An error occurred.',
        int $status = 500
    ): JsonResponse {

        return response()->json([

            'success' => false,

            'message' => $message,

        ], $status);

    }

    /**
     * Execute a database transaction.
     */
    protected function transaction(callable $callback)
    {
        return DB::transaction($callback);
    }

    /**
     * Handle unexpected exceptions.
     */
    protected function handleException(Throwable $exception)
    {
        report($exception);

        if (request()->expectsJson()) {

            return $this->errorResponse(
                $exception->getMessage(),
                500
            );

        }

        return $this->error(
            app()->environment('production')
                ? 'Something went wrong.'
                : $exception->getMessage()
        );
    }
}