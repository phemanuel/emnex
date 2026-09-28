<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingLocation;
use App\Models\ShippingSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShippingController extends Controller
{
    public function setup(): View
    {
        abort_unless(
            canAccess('shipping.view') ||
            canAccess('shipping.manage'),
            403
        );


        $companyId =
            auth()->user()->company_id;


        $settings =
            ShippingSetting::query()
                ->firstOrCreate(
                    [
                        'company_id' =>
                            $companyId,
                    ],
                    [
                        'enabled' =>
                            false,

                        'shipping_mode' =>
                            'location',

                        'manual_shipping_fee' =>
                            0,

                        'created_by' =>
                            auth()->id(),
                    ]
                );


        $locations =
            ShippingLocation::query()
                ->forCompany($companyId)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get();


        return view(
            'shipping.setup',
            compact(
                'settings',
                'locations'
            )
        );
    }


    public function updateSettings(
        Request $request
    ): RedirectResponse {

        abort_unless(
            canAccess('shipping.manage'),
            403
        );


        $validated =
            $request->validate([
                'enabled' =>
                    ['nullable', 'boolean'],

                'shipping_mode' =>
                    [
                        'required',
                        'in:location,manual',
                    ],

                'manual_shipping_fee' =>
                    [
                        'nullable',
                        'numeric',
                        'min:0',
                    ],
            ]);


        $companyId =
            auth()->user()->company_id;


        $settings =
            ShippingSetting::query()
                ->firstOrCreate([
                    'company_id' =>
                        $companyId,
                ]);


        $settings->update([
            'enabled' =>
                $request->boolean('enabled'),

            'shipping_mode' =>
                $validated['shipping_mode'],

            'manual_shipping_fee' =>
                $validated['shipping_mode'] === 'manual'
                    ? ($validated['manual_shipping_fee'] ?? 0)
                    : 0,

            'updated_by' =>
                auth()->id(),
        ]);


        return back()->with(
            'success',
            'Shipping settings updated successfully.'
        );
    }


    public function storeLocation(
        Request $request
    ): RedirectResponse {

        abort_unless(
            canAccess('shipping.manage'),
            403
        );


        $validated =
            $request->validate([
                'name' =>
                    [
                        'required',
                        'string',
                        'max:150',
                    ],

                'description' =>
                    [
                        'nullable',
                        'string',
                        'max:255',
                    ],

                'shipping_fee' =>
                    [
                        'required',
                        'numeric',
                        'min:0',
                    ],

                'sort_order' =>
                    [
                        'nullable',
                        'integer',
                        'min:0',
                    ],
            ]);


        ShippingLocation::create([
            'company_id' =>
                auth()->user()->company_id,

            'name' =>
                trim(
                    $validated['name']
                ),

            'description' =>
                isset(
                    $validated['description']
                )
                    ? trim(
                        $validated['description']
                    )
                    : null,

            'shipping_fee' =>
                $validated['shipping_fee'],

            'sort_order' =>
                $validated['sort_order']
                ?? 0,

            'status' =>
                true,

            'created_by' =>
                auth()->id(),

            'updated_by' =>
                auth()->id(),
        ]);


        return back()->with(
            'success',
            'Shipping location added successfully.'
        );
    }


    public function updateLocation(
        Request $request,
        ShippingLocation $shippingLocation
    ): RedirectResponse {

        abort_unless(
            canAccess('shipping.manage'),
            403
        );


        abort_unless(
            $shippingLocation->company_id ===
            auth()->user()->company_id,
            404
        );


        $validated =
            $request->validate([
                'name' =>
                    [
                        'required',
                        'string',
                        'max:150',
                    ],

                'description' =>
                    [
                        'nullable',
                        'string',
                        'max:255',
                    ],

                'shipping_fee' =>
                    [
                        'required',
                        'numeric',
                        'min:0',
                    ],

                'sort_order' =>
                    [
                        'nullable',
                        'integer',
                        'min:0',
                    ],
            ]);


        $shippingLocation->update([
            'name' =>
                trim(
                    $validated['name']
                ),

            'description' =>
                isset(
                    $validated['description']
                )
                    ? trim(
                        $validated['description']
                    )
                    : null,

            'shipping_fee' =>
                $validated['shipping_fee'],

            'sort_order' =>
                $validated['sort_order']
                ?? 0,

            'updated_by' =>
                auth()->id(),
        ]);


        return back()->with(
            'success',
            'Shipping location updated.'
        );
    }


    public function toggleLocation(
        ShippingLocation $shippingLocation
    ): JsonResponse {

        abort_unless(
            canAccess('shipping.manage'),
            403
        );


        abort_unless(
            $shippingLocation->company_id ===
            auth()->user()->company_id,
            404
        );


        $shippingLocation->update([
            'status' =>
                !$shippingLocation->status,

            'updated_by' =>
                auth()->id(),
        ]);


        return response()->json([
            'success' =>
                true,

            'status' =>
                $shippingLocation->status,

            'message' =>
                $shippingLocation->status
                    ? 'Shipping location enabled.'
                    : 'Shipping location disabled.',
        ]);
    }


    public function deleteLocation(
        ShippingLocation $shippingLocation
    ): JsonResponse {

        abort_unless(
            canAccess('shipping.manage'),
            403
        );


        abort_unless(
            $shippingLocation->company_id ===
            auth()->user()->company_id,
            404
        );


        $shippingLocation->delete();


        return response()->json([
            'success' =>
                true,

            'message' =>
                'Shipping location deleted.',
        ]);
    }
}