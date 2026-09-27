<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Throwable;

class SystemHealthController extends Controller
{
    public function index(): View
    {
        $databaseHealthy =
            true;


        try {

            DB::select(
                'SELECT 1'
            );

        } catch (Throwable $exception) {

            $databaseHealthy =
                false;

        }


        $checks = [

            [
                'name' =>
                    'Database',

                'description' =>
                    'Primary EMNEX database connection.',

                'healthy' =>
                    $databaseHealthy,
            ],

            [
                'name' =>
                    'Companies table',

                'description' =>
                    'Core tenant records are available.',

                'healthy' =>
                    Schema::hasTable(
                        'companies'
                    ),
            ],

            [
                'name' =>
                    'Orders table',

                'description' =>
                    'Commerce order infrastructure is available.',

                'healthy' =>
                    Schema::hasTable(
                        'orders'
                    ),
            ],

            [
                'name' =>
                    'Payments table',

                'description' =>
                    'Payment infrastructure is available.',

                'healthy' =>
                    Schema::hasTable(
                        'payments'
                    ),
            ],

            [
                'name' =>
                    'Storefronts table',

                'description' =>
                    'Public Storefront infrastructure is available.',

                'healthy' =>
                    Schema::hasTable(
                        'storefronts'
                    ),
            ],

        ];


        $healthyCount =
            collect(
                $checks
            )
                ->where(
                    'healthy',
                    true
                )
                ->count();


        return view(
            'platform.system-health.index',
            compact(
                'checks',
                'healthyCount'
            )
        );
    }
}