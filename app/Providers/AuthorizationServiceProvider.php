<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AuthorizationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        /*
        |--------------------------------------------------------------------------
        | Permission Directive
        |--------------------------------------------------------------------------
        */

        Blade::if('permission', function ($permission) {

            return auth()->check()
                && auth()->user()->hasPermission($permission);

        });


        /*
        |--------------------------------------------------------------------------
        | Role Directive
        |--------------------------------------------------------------------------
        */

        Blade::if('role', function ($role) {

            return auth()->check()
                && auth()->user()->hasRole($role);

        });


        /*
        |--------------------------------------------------------------------------
        | Unless Permission Directive
        |--------------------------------------------------------------------------
        */

        Blade::if('unlesspermission', function ($permission) {

            return !auth()->check()
                || !auth()->user()->hasPermission($permission);

        });

    }
}