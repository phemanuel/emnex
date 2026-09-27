<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Order;
use App\Models\Storefront;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [

            'companies' =>
                Company::query()
                    ->count(),

            'active_companies' =>
                Company::query()
                    ->where(
                        'status',
                        true
                    )
                    ->count(),

            'users' =>
                User::query()
                    ->count(),

            'storefronts' =>
                Storefront::query()
                    ->count(),

            'active_storefronts' =>
                Storefront::query()
                    ->where(
                        'status',
                        'Active'
                    )
                    ->count(),

            'setup_storefronts' =>
                Storefront::query()
                    ->where(
                        'status',
                        'Setup'
                    )
                    ->count(),

            'online_orders_today' =>
                Order::query()
                    ->where(
                        'sales_channel',
                        'Online'
                    )
                    ->whereDate(
                        'created_at',
                        today()
                    )
                    ->count(),

            'pos_orders_today' =>
                Order::query()
                    ->where(
                        'sales_channel',
                        'POS'
                    )
                    ->whereDate(
                        'created_at',
                        today()
                    )
                    ->count(),

        ];


        $recentCompanies =
            Company::query()
                ->latest()
                ->limit(8)
                ->get();


        $recentOnlineOrders =
            Order::query()
                ->with([
                    'company',
                    'customer',
                ])
                ->where(
                    'sales_channel',
                    'Online'
                )
                ->latest()
                ->limit(8)
                ->get();


        return view(
            'platform.dashboard.index',
            compact(
                'stats',
                'recentCompanies',
                'recentOnlineOrders'
            )
        );
    }
}