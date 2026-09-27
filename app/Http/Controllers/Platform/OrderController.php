<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(
        Request $request
    ): View {

        $orders =
            Order::query()
                ->with([
                    'company',
                    'customer',
                ])
                ->when(
                    $request->filled(
                        'channel'
                    ),
                    fn ($query) =>
                        $query->where(
                            'sales_channel',
                            $request->channel
                        )
                )
                ->latest()
                ->paginate(30)
                ->withQueryString();


        return view(
            'platform.orders.index',
            compact(
                'orders'
            )
        );
    }
}