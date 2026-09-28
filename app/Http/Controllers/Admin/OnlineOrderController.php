<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OnlineOrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Online Orders List
    |--------------------------------------------------------------------------
    */

    public function index(
        Request $request
    ): ViewContract {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('shipping.orders')) {

            abort(
                403,
                'You do not have permission to view online orders.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Company Scope
        |--------------------------------------------------------------------------
        */

        $companyId =
            auth()->user()->company_id;


        /*
        |--------------------------------------------------------------------------
        | Validate Filters
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([

                'search' => [
                    'nullable',
                    'string',
                    'max:150',
                ],

                'fulfilment_status' => [
                    'nullable',
                    'in:Pending,Processing,Shipped,Delivered',
                ],

                'payment_status' => [
                    'nullable',
                    'in:Pending,Paid',
                ],

                'shipping_method' => [
                    'nullable',
                    'in:location,manual',
                ],

                'date_from' => [
                    'nullable',
                    'date',
                ],

                'date_to' => [
                    'nullable',
                    'date',
                    'after_or_equal:date_from',
                ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        |
        | This page must never mix POS or Phone orders into the Storefront
        | fulfilment workflow.
        |
        */

        $query =
            Order::query()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'sales_channel',
                    'Online'
                )
                ->with([
                    'customer',
                ]);


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if (! empty($validated['search'])) {

            $search =
                trim(
                    $validated['search']
                );


            $query->where(
                function ($query) use ($search) {

                    $query
                        ->where(
                            'order_no',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhereHas(
                            'customer',
                            function ($customerQuery) use ($search) {

                                $customerQuery
                                    ->where(
                                        'first_name',
                                        'like',
                                        '%' . $search . '%'
                                    )
                                    ->orWhere(
                                        'last_name',
                                        'like',
                                        '%' . $search . '%'
                                    )
                                    ->orWhere(
                                        'email',
                                        'like',
                                        '%' . $search . '%'
                                    )
                                    ->orWhere(
                                        'phone',
                                        'like',
                                        '%' . $search . '%'
                                    );

                            }
                        );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Fulfilment Filter
        |--------------------------------------------------------------------------
        */

        if (! empty($validated['fulfilment_status'])) {

            $query->where(
                'fulfilment_status',
                $validated['fulfilment_status']
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Payment Filter
        |--------------------------------------------------------------------------
        */

        if (! empty($validated['payment_status'])) {

            $query->where(
                'payment_status',
                $validated['payment_status']
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Shipping Method
        |--------------------------------------------------------------------------
        */

        if (! empty($validated['shipping_method'])) {

            $query->where(
                'shipping_method',
                $validated['shipping_method']
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Date Range
        |--------------------------------------------------------------------------
        */

        if (! empty($validated['date_from'])) {

            $query->whereDate(
                'completed_at',
                '>=',
                $validated['date_from']
            );

        }


        if (! empty($validated['date_to'])) {

            $query->whereDate(
                'completed_at',
                '<=',
                $validated['date_to']
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Orders
        |--------------------------------------------------------------------------
        */

        $orders =
            $query
                ->orderByDesc('completed_at')
                ->orderByDesc('id')
                ->paginate(20)
                ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Fulfilment Summary
        |--------------------------------------------------------------------------
        |
        | Summary cards are deliberately calculated independently of the
        | currently selected filters so they always show the company's real
        | online fulfilment workload.
        |
        */

        $summaryQuery =
            Order::query()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'sales_channel',
                    'Online'
                );


        $summary = [

            'pending' =>
                (clone $summaryQuery)
                    ->where(
                        'fulfilment_status',
                        'Pending'
                    )
                    ->count(),

            'processing' =>
                (clone $summaryQuery)
                    ->where(
                        'fulfilment_status',
                        'Processing'
                    )
                    ->count(),

            'shipped' =>
                (clone $summaryQuery)
                    ->where(
                        'fulfilment_status',
                        'Shipped'
                    )
                    ->count(),

            'delivered' =>
                (clone $summaryQuery)
                    ->where(
                        'fulfilment_status',
                        'Delivered'
                    )
                    ->count(),

        ];


        /*
        |--------------------------------------------------------------------------
        | Currency
        |--------------------------------------------------------------------------
        */

        $currencySymbol =
            auth()->user()
                ->company
                ->currency_symbol
            ?: '₦';


        return view(
            'shipping.orders.index',
            [

                'orders' =>
                    $orders,

                'summary' =>
                    $summary,

                'currencySymbol' =>
                    $currencySymbol,

            ]
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Online Order Details
    |--------------------------------------------------------------------------
    */

    public function show(
        int $order
    ): ViewContract {

        if (! canAccess('shipping.orders')) {

            abort(
                403,
                'You do not have permission to view online orders.'
            );

        }


        $companyId =
            auth()->user()->company_id;


        $order =
            Order::query()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'sales_channel',
                    'Online'
                )
                ->with([
                    'customer',
                    'orderItems',
                    'invoice',
                    'payments',
                ])
                ->findOrFail(
                    $order
                );


        $currencySymbol =
            auth()->user()
                ->company
                ->currency_symbol
            ?: '₦';


        return view(
            'shipping.orders.show',
            [

                'order' =>
                    $order,

                'currencySymbol' =>
                    $currencySymbol,

            ]
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Update Fulfilment
    |--------------------------------------------------------------------------
    */

    public function updateFulfilment(
        Request $request,
        int $order
    ): RedirectResponse {

        if (! canAccess('shipping.orders')) {

            abort(
                403,
                'You do not have permission to manage online order fulfilment.'
            );

        }


        $companyId =
            auth()->user()->company_id;


        $order =
            Order::query()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'sales_channel',
                    'Online'
                )
                ->findOrFail(
                    $order
                );


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([

                'fulfilment_status' => [
                    'required',
                    'in:Processing,Shipped,Delivered',
                ],

                'tracking_reference' => [
                    'nullable',
                    'string',
                    'max:190',
                ],

                'shipping_notes' => [
                    'nullable',
                    'string',
                    'max:2000',
                ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | Existing Status
        |--------------------------------------------------------------------------
        */

        $currentStatus =
            $order->fulfilment_status
            ?: 'Pending';


        $nextStatus =
            $validated['fulfilment_status'];


        /*
        |--------------------------------------------------------------------------
        | Allowed Progression
        |--------------------------------------------------------------------------
        |
        | We intentionally do not permit arbitrary backwards movement.
        |
        */

        $allowedTransitions = [

            'Pending' => [
                'Processing',
            ],

            'Processing' => [
                'Shipped',
            ],

            'Shipped' => [
                'Delivered',
            ],

            'Delivered' => [],

        ];


        if (
            ! in_array(
                $nextStatus,
                $allowedTransitions[$currentStatus]
                    ?? [],
                true
            )
        ) {

            throw ValidationException::withMessages([

                'fulfilment_status' =>
                    'This fulfilment status change is not allowed.',

            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Update Data
        |--------------------------------------------------------------------------
        */

        $updateData = [

            'fulfilment_status' =>
                $nextStatus,

            'shipping_notes' =>
                $validated['shipping_notes']
                ?? $order->shipping_notes,

            'updated_by' =>
                auth()->id(),

        ];


        /*
        |--------------------------------------------------------------------------
        | Shipped
        |--------------------------------------------------------------------------
        */

        if (
            $nextStatus ===
            'Shipped'
        ) {

            $updateData['tracking_reference'] =
                $validated['tracking_reference']
                ?? null;


            $updateData['shipped_at'] =
                now();

        }


        /*
        |--------------------------------------------------------------------------
        | Delivered
        |--------------------------------------------------------------------------
        */

        if (
            $nextStatus ===
            'Delivered'
        ) {

            $updateData['delivered_at'] =
                now();

        }


        $order->update(
            $updateData
        );


        return redirect()
            ->route(
                'shipping.orders.show',
                $order
            )
            ->with(
                'success',
                'Order fulfilment updated successfully.'
            );

    }
}