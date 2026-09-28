<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Services\StorefrontCheckoutService;
use App\Models\ShippingLocation;
use App\Models\ShippingSetting;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Throwable;

class StorefrontCheckoutController extends Controller
{
    public function __construct(
        protected StorefrontCheckoutService $checkoutService
    ) {
    }


    /*
    |--------------------------------------------------------------------------
    | Checkout Page
    |--------------------------------------------------------------------------
    */

    public function checkout(
        string $storefrontSlug
    ): ViewContract {

        $storefront =
            $this->checkoutService
                ->findStorefront(
                    $storefrontSlug
                );


        if (
            !$storefront ||
            $storefront->status !== 'Active'
        ) {

            return $this->unavailableView(
                $storefront
            );

        }


        $shippingSettings =
            ShippingSetting::query()
                ->where(
                    'company_id',
                    $storefront->company_id
                )
                ->first();


        $shippingLocations =
            collect();


        if (
            $shippingSettings?->enabled &&
            $shippingSettings->shipping_mode === 'location'
        ) {

            $shippingLocations =
                ShippingLocation::query()
                    ->where(
                        'company_id',
                        $storefront->company_id
                    )
                    ->where(
                        'status',
                        true
                    )
                    ->orderBy('sort_order')
                    ->orderBy('name')
                    ->get();

        }


        return view(
            'storefront.public.checkout',
            [
                'storefront' =>
                    $storefront,

                'company' =>
                    $storefront->company,

                'shippingSettings' =>
                    $shippingSettings,

                'shippingLocations' =>
                    $shippingLocations,

                'currencySymbol' =>
                    $storefront
                        ->company
                        ->currency_symbol
                    ?: '₦',
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Secure Cart Quote
    |--------------------------------------------------------------------------
    */

   public function quote(
        Request $request,
        string $storefrontSlug
    ): JsonResponse {

        $validated =
            $request->validate([

                'items' => [
                    'required',
                    'array',
                    'min:1',
                ],

                'items.*.id' => [
                    'required',
                    'integer',
                    'min:1',
                ],

                'items.*.quantity' => [
                    'required',
                    'integer',
                    'min:1',
                ],

                'shipping_location_id' => [
                    'nullable',
                    'integer',
                    'min:1',
                ],

            ]);


        $storefront =
            $this->checkoutService
                ->requireActiveStorefront(
                    $storefrontSlug
                );


        $quote =
            $this->checkoutService
                ->quote(
                    $storefront,
                    $validated['items'],
                    $validated['shipping_location_id']
                        ?? null
                );


        return response()->json([

            'success' => true,

            'data' => [

                'items' =>
                    $quote['items'],

                'subtotal' =>
                    $quote['subtotal'],

                'discount' =>
                    $quote['discount'],

                'tax' =>
                    $quote['tax'],

                'shipping_enabled' =>
                    $quote['shipping_enabled'],

                'shipping_mode' =>
                    $quote['shipping_mode'],

                'shipping_fee' =>
                    $quote['shipping_fee'],

                'shipping_resolved' =>
                    $quote['shipping_resolved'],

                'shipping_location' =>
                    $quote['shipping_location'],

                'grand_total' =>
                    $quote['grand_total'],

                'total_quantity' =>
                    $quote['total_quantity'],

                'total_items' =>
                    $quote['total_items'],

                'currency_symbol' =>
                    $storefront
                        ->company
                        ->currency_symbol
                    ?: '₦',

            ],

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Create Order + Initialize Paystack
    |--------------------------------------------------------------------------
    */

    public function initialize(
        Request $request,
        string $storefrontSlug
    ): JsonResponse {

    $storefront =
        $this->checkoutService
            ->requireActiveStorefront(
                $storefrontSlug
            );


    $shippingSettings =
        ShippingSetting::query()
            ->where(
                'company_id',
                $storefront->company_id
            )
            ->first();


    $requiresAddress =
        !$shippingSettings?->enabled ||
        $shippingSettings->shipping_mode === 'manual';


    $requiresLocation =
        $shippingSettings?->enabled &&
        $shippingSettings->shipping_mode === 'location';

       $validated =
        $request->validate([

            'first_name' => [
                'required',
                'string',
                'max:100',
            ],

            'last_name' => [
                'nullable',
                'string',
                'max:100',
            ],

            'email' => [
                'required',
                'email',
                'max:190',
            ],

            'phone' => [
                'required',
                'string',
                'max:30',
            ],

            'address' => [
                $requiresAddress
                    ? 'required'
                    : 'nullable',
                'string',
                'max:500',
            ],

            'city' => [
                $requiresAddress
                    ? 'required'
                    : 'nullable',
                'string',
                'max:100',
            ],

            'state' => [
                $requiresAddress
                    ? 'required'
                    : 'nullable',
                'string',
                'max:100',
            ],

            'shipping_location_id' => [
                $requiresLocation
                    ? 'required'
                    : 'nullable',
                'integer',
                'min:1',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.id' => [
                'required',
                'integer',
                'min:1',
            ],

            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],

        ]);

        $storefront =
            $this->checkoutService
                ->requireActiveStorefront(
                    $storefrontSlug
                );


        try {

            $order =
                $this->checkoutService
                    ->createPendingOrder(
                        $storefront,
                        $validated,
                        $validated['items']
                    );


            $payment =
                $this->checkoutService
                    ->initializePayment(
                        $storefront,
                        $order
                    );


            return response()->json([

                'success' =>
                    true,

                'message' =>
                    'Redirecting to secure payment.',

                'authorization_url' =>
                    $payment[
                        'authorization_url'
                    ],

                'reference' =>
                    $payment[
                        'reference'
                    ],

            ]);

        } catch (ValidationException $exception) {

            throw $exception;

        } catch (Throwable $exception) {

            report(
                $exception
            );


            return response()->json(
                [

                    'success' =>
                        false,

                    'message' =>
                        'We could not start your payment. Please try again.',

                ],
                422
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Paystack Callback
    |--------------------------------------------------------------------------
    */

    public function callback(
        Request $request,
        string $storefrontSlug
    ): ViewContract {

        $storefront =
            $this->checkoutService
                ->findStorefront(
                    $storefrontSlug
                );


        if (!$storefront) {

            return view(
                'storefront.public.checkout-failed',
                [

                    'storefront' =>
                        null,

                    'company' =>
                        null,

                    'message' =>
                        'We could not locate the store for this payment.',

                ]
            );

        }


        $reference =
            trim(
                (string) (
                    $request->query(
                        'reference'
                    )
                    ?? $request->query(
                        'trxref'
                    )
                    ?? ''
                )
            );


        if (!$reference) {

            return view(
                'storefront.public.checkout-failed',
                [

                    'storefront' =>
                        $storefront,

                    'company' =>
                        $storefront->company,

                    'message' =>
                        'The payment reference is missing.',

                ]
            );

        }


        try {

            $gatewayData =
                $this->checkoutService
                    ->verifyPayment(
                        $reference
                    );


            $order =
                $this->checkoutService
                    ->completePaidOrder(
                        $storefront,
                        $gatewayData
                    );


            return view(
                'storefront.public.checkout-success',
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

        } catch (Throwable $exception) {

            report(
                $exception
            );


            return view(
                'storefront.public.checkout-failed',
                [

                    'storefront' =>
                        $storefront,

                    'company' =>
                        $storefront->company,

                    'message' =>
                        $exception instanceof RuntimeException
                            ? $exception->getMessage()
                            : 'We could not confirm this payment. Please contact the store if you were charged.',

                ]
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Unavailable
    |--------------------------------------------------------------------------
    */

    protected function unavailableView(
        $storefront
    ): ViewContract {

        if (!$storefront) {

            return view(
                'storefront.public.unavailable',
                [

                    'storefront' =>
                        null,

                    'company' =>
                        null,

                    'statusType' =>
                        'not-created',

                    'title' =>
                        'This store is not available yet',

                    'message' =>
                        'The online store you are looking for is not currently available.',

                ]
            );

        }


        if (
            $storefront->status ===
            'Setup'
        ) {

            return view(
                'storefront.public.unavailable',
                [

                    'storefront' =>
                        $storefront,

                    'company' =>
                        $storefront->company,

                    'statusType' =>
                        'setup',

                    'title' =>
                        'We’re getting this store ready',

                    'message' =>
                        'This online store is currently being prepared. Please check back soon.',

                ]
            );

        }


        return view(
            'storefront.public.unavailable',
            [

                'storefront' =>
                    $storefront,

                'company' =>
                    $storefront->company,

                'statusType' =>
                    'disabled',

                'title' =>
                    'Store temporarily unavailable',

                'message' =>
                    'This online store is currently unavailable. Please check back later.',

            ]
        );

    }
}