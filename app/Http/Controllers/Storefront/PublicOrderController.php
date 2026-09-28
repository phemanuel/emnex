<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Storefront;
use Illuminate\Contracts\View\View;

class PublicOrderController extends Controller
{
    public function show(
        string $storefrontSlug,
        string $token
    ): View {

        $storefront =
            Storefront::query()
                ->with('company')
                ->where(
                    'slug',
                    $storefrontSlug
                )
                ->first();


        if (!$storefront) {

            return view(
                'storefront.public.order-unavailable',
                [
                    'storefront' => null,
                    'company' => null,
                ]
            );
        }


        $order =
            Order::query()
                ->with([
                    'customer',
                    'orderItems',
                    'payments',
                    'invoice',
                ])
                ->where(
                    'company_id',
                    $storefront->company_id
                )
                ->where(
                    'sales_channel',
                    'Online'
                )
                ->where(
                    'public_token',
                    $token
                )
                ->where(
                    'payment_status',
                    'Paid'
                )
                ->first();


        if (!$order) {

            return view(
                'storefront.public.order-unavailable',
                [
                    'storefront' =>
                        $storefront,

                    'company' =>
                        $storefront->company,
                ]
            );
        }


        return view(
            'storefront.public.order',
            [
                'storefront' =>
                    $storefront,

                'company' =>
                    $storefront->company,

                'order' =>
                    $order,

                'currencySymbol' =>
                    $storefront
                        ->company
                        ->currency_symbol
                    ?: '₦',
            ]
        );
    }
}