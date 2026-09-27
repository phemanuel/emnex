<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Storefront;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    public function index(): View
    {
        $storefronts =
            Storefront::query()
                ->with('company')
                ->latest()
                ->paginate(25);


        $orderCounts =
            Order::query()
                ->selectRaw(
                    'company_id, COUNT(*) as total'
                )
                ->where(
                    'sales_channel',
                    'Online'
                )
                ->groupBy(
                    'company_id'
                )
                ->pluck(
                    'total',
                    'company_id'
                );


        return view(
            'platform.storefronts.index',
            compact(
                'storefronts',
                'orderCounts'
            )
        );
    }
}