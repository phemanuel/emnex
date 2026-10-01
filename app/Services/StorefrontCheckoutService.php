<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\StockMovement;
use App\Models\Storefront;
use App\Models\ShippingLocation;
use App\Models\ShippingSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use RuntimeException;

use App\Jobs\SendStorefrontOrderConfirmation;

class StorefrontCheckoutService
{
    /*
    |--------------------------------------------------------------------------
    | Storefront
    |--------------------------------------------------------------------------
    */

    public function findStorefront(
        string $slug
    ): ?Storefront {

        return Storefront::query()
            ->with('company')
            ->where(
                'slug',
                $slug
            )
            ->first();

    }


    public function requireActiveStorefront(
        string $slug
    ): Storefront {

        $storefront =
            $this->findStorefront(
                $slug
            );

        if (
            !$storefront ||
            $storefront->status !== 'Active'
        ) {

            throw ValidationException::withMessages([
                'storefront' =>
                    'This online store is currently unavailable.',
            ]);

        }

        return $storefront;
    }


    /*
    |--------------------------------------------------------------------------
    | Head Office
    |--------------------------------------------------------------------------
    */

    public function getHeadOffice(
        int $companyId
    ): Branch {

        $branch =
            Branch::query()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'is_head_office',
                    true
                )
                ->where(
                    'status',
                    true
                )
                ->first();

        if (!$branch) {

            throw ValidationException::withMessages([
                'branch' =>
                    'This store is temporarily unable to process online orders.',
            ]);

        }

        return $branch;
    }


    /*
    |--------------------------------------------------------------------------
    | Quote
    |--------------------------------------------------------------------------
    |
    | Only product ID + quantity come from the browser.
    |
    | Price, name, stock and totals come from EMNEX.
    |
    */

   public function quote(
        Storefront $storefront,
        array $items,
        ?int $shippingLocationId = null,
        bool $requireShippingResolved = false
    ): array {

        if (empty($items)) {

            throw ValidationException::withMessages([
                'items' =>
                    'Your bag is empty.',
            ]);

        }


        $headOffice =
            $this->getHeadOffice(
                $storefront->company_id
            );


        $preparedItems =
            [];


        $subtotal =
            0;


        $discountTotal =
            0;


        $taxTotal =
            0;


        $totalQuantity =
            0;


        foreach ($items as $cartItem) {

            $productId =
                (int) (
                    $cartItem['id']
                    ?? 0
                );


            $quantity =
                (int) (
                    $cartItem['quantity']
                    ?? 0
                );


            if (
                $productId <= 0 ||
                $quantity <= 0
            ) {

                throw ValidationException::withMessages([
                    'items' =>
                        'One or more cart items are invalid.',
                ]);

            }


            /*
            |--------------------------------------------------------------------------
            | Product
            |--------------------------------------------------------------------------
            */

            $product =
                Product::query()
                    ->where(
                        'company_id',
                        $storefront->company_id
                    )
                    ->where(
                        'status',
                        true
                    )
                    ->find(
                        $productId
                    );


            if (!$product) {

                throw ValidationException::withMessages([
                    'items' =>
                        'One of the products in your bag is no longer available.',
                ]);

            }


            /*
            |--------------------------------------------------------------------------
            | Stock Behaviour
            |--------------------------------------------------------------------------
            |
            | Only stock-tracked products depend on Head Office ProductStock.
            |
            | Non-stock products can be sold without a ProductStock record.
            |
            */

            $tracksStock =
                $product->tracksStock();


            $availableQuantity =
                null;


            if ($tracksStock) {

                $stock =
                    ProductStock::query()
                        ->where(
                            'company_id',
                            $storefront->company_id
                        )
                        ->where(
                            'branch_id',
                            $headOffice->id
                        )
                        ->where(
                            'product_id',
                            $product->id
                        )
                        ->first();


                $availableQuantity =
                    (float) (
                        $stock?->available_quantity
                        ?? 0
                    );


                if (
                    $quantity >
                    $availableQuantity
                ) {

                    throw ValidationException::withMessages([
                        'items' =>
                            '"' .
                            $product->name .
                            '" only has ' .
                            number_format(
                                $availableQuantity,
                                0
                            ) .
                            ' available.',
                    ]);

                }

            }


            /*
            |--------------------------------------------------------------------------
            | Server Price
            |--------------------------------------------------------------------------
            */

            $unitPrice =
                (float)
                $product->selling_price;


            $gross =
                $unitPrice *
                $quantity;


            /*
            |--------------------------------------------------------------------------
            | Public Discount / Tax
            |--------------------------------------------------------------------------
            |
            | Do not trust discount or tax values supplied by JavaScript.
            |
            | When Storefront discount/tax rules are formalised later,
            | resolve them here from EMNEX.
            |
            */

            $discount =
                0;


            $tax =
                0;


            $lineTotal =
                max(
                    0,
                    $gross
                    - $discount
                    + $tax
                );


            $subtotal +=
                $gross;


            $discountTotal +=
                $discount;


            $taxTotal +=
                $tax;


            $totalQuantity +=
                $quantity;


            $preparedItems[] = [

                'product_id' =>
                    $product->id,

                'product_code' =>
                    $product->product_code,

                'product_name' =>
                    $product->name,

                'product_barcode' =>
                    $product->barcode,

                'image_url' =>
                    $product->imageUrl(),

                'quantity' =>
                    $quantity,

                /*
                |--------------------------------------------------------------------------
                | Stock Information
                |--------------------------------------------------------------------------
                */

                'tracks_stock' =>
                    $tracksStock,

                'available_quantity' =>
                    $availableQuantity,

                'unit_price' =>
                    $unitPrice,

                'unit_cost' =>
                    (float)
                    $product->cost_price,

                'discount' =>
                    $discount,

                'tax' =>
                    $tax,

                'total' =>
                    $lineTotal,

            ];

        }


        /*
        |--------------------------------------------------------------------------
        | Shipping
        |--------------------------------------------------------------------------
        */

        $shipping =
            $this->resolveShipping(
                $storefront,
                $shippingLocationId,
                $requireShippingResolved
            );


        $shippingFee =
            (float)
            $shipping['fee'];


        /*
        |--------------------------------------------------------------------------
        | Grand Total
        |--------------------------------------------------------------------------
        */

        $grandTotal =
            max(
                0,
                $subtotal
                - $discountTotal
                + $taxTotal
                + $shippingFee
            );


        return [

            'head_office' =>
                $headOffice,

            'items' =>
                $preparedItems,

            'subtotal' =>
                round(
                    $subtotal,
                    2
                ),

            'discount' =>
                round(
                    $discountTotal,
                    2
                ),

            'tax' =>
                round(
                    $taxTotal,
                    2
                ),

            'total_quantity' =>
                $totalQuantity,

            'total_items' =>
                count(
                    $preparedItems
                ),

            'grand_total' =>
                round(
                    $grandTotal,
                    2
                ),

            'shipping_enabled' =>
                $shipping['enabled'],

            'shipping_mode' =>
                $shipping['method'],

            'shipping_fee' =>
                round(
                    $shippingFee,
                    2
                ),

            'shipping_resolved' =>
                $shipping['resolved'],

            'shipping_location' =>
                $shipping['location'],

        ];

    }
    protected function resolveShipping(
    Storefront $storefront,
        ?int $shippingLocationId = null,
        bool $requireResolved = false
    ): array {

        $settings =
            ShippingSetting::query()
                ->where(
                    'company_id',
                    $storefront->company_id
                )
                ->first();


        /*
        |--------------------------------------------------------------------------
        | Shipping Disabled
        |--------------------------------------------------------------------------
        */

        if (
            !$settings ||
            !$settings->enabled
        ) {

            return [
                'enabled' =>
                    false,

                'method' =>
                    null,

                'fee' =>
                    0,

                'resolved' =>
                    true,

                'location' =>
                    null,
            ];

        }


        /*
        |--------------------------------------------------------------------------
        | Manual Address
        |--------------------------------------------------------------------------
        */

        if (
            $settings->shipping_mode === 'manual'
        ) {

            return [
                'enabled' =>
                    true,

                'method' =>
                    'manual',

                'fee' =>
                    (float)
                    $settings->manual_shipping_fee,

                'resolved' =>
                    true,

                'location' =>
                    null,
            ];

        }


        /*
        |--------------------------------------------------------------------------
        | Predefined Location
        |--------------------------------------------------------------------------
        */

        if (!$shippingLocationId) {

            if ($requireResolved) {

                throw ValidationException::withMessages([
                    'shipping_location_id' =>
                        'Please select a shipping location.',
                ]);

            }


            return [
                'enabled' =>
                    true,

                'method' =>
                    'location',

                'fee' =>
                    0,

                'resolved' =>
                    false,

                'location' =>
                    null,
            ];

        }


        $location =
            ShippingLocation::query()
                ->where(
                    'company_id',
                    $storefront->company_id
                )
                ->where(
                    'status',
                    true
                )
                ->find(
                    $shippingLocationId
                );


        if (!$location) {

            throw ValidationException::withMessages([
                'shipping_location_id' =>
                    'The selected shipping location is unavailable.',
            ]);

        }


        return [
            'enabled' =>
                true,

            'method' =>
                'location',

            'fee' =>
                (float)
                $location->shipping_fee,

            'resolved' =>
                true,

            'location' => [
                'id' =>
                    $location->id,

                'name' =>
                    $location->name,

                'description' =>
                    $location->description,
            ],
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Create Pending Order
    |--------------------------------------------------------------------------
    */

    public function createPendingOrder(
        Storefront $storefront,
        array $customerData,
        array $items
    ): Order {

        return DB::transaction(
            function () use (
                $storefront,
                $customerData,
                $items
            ) {

               $quote =
                $this->quote(
                    $storefront,
                    $items,
                    isset(
                        $customerData['shipping_location_id']
                    )
                        ? (int)
                            $customerData['shipping_location_id']
                        : null,
                    true
                );


                $headOffice =
                    $quote['head_office'];


                $customer =
                    $this->resolveCustomer(
                        $storefront,
                        $customerData
                    );


                $orderNo =
                    DocumentNumberService::generate(
                        'order',
                        $storefront->company_id
                    );


                $invoiceNo =
                    DocumentNumberService::generate(
                        'invoice',
                        $storefront->company_id
                    );


                /*
                |--------------------------------------------------------------------------
                | Order
                |--------------------------------------------------------------------------
                */

                $order =
                    Order::create([

                        'company_id' =>
                            $storefront->company_id,

                        'branch_id' =>
                            $headOffice->id,

                        'terminal_id' =>
                            null,

                        'customer_id' =>
                            $customer->id,

                        'cashier_id' =>
                            null,

                        'order_no' =>
                            $orderNo,

                        'public_token' =>
                             Str::random(64),

                        'subtotal' =>
                            $quote['subtotal'],

                        'discount' =>
                            $quote['discount'],

                        'discount_id' =>
                            null,

                        'tax_rate_id' =>
                            null,

                        'tax' =>
                            $quote['tax'],

                        'total' =>
                            $quote['grand_total'],

                        'amount_paid' =>
                            0,

                        'balance' =>
                            $quote['grand_total'],

                        'total_items' =>
                            $quote['total_items'],

                        'total_quantity' =>
                            $quote['total_quantity'],

                        'change_given' =>
                            0,

                        'grand_total' =>
                            $quote['grand_total'],

                        'completed_at' =>
                            null,

                        'payment_status' =>
                            'Pending',

                        'order_status' =>
                            'Draft',

                        'sales_channel' =>
                            'Online',

                        'receipt_printed' =>
                            false,

                        'remarks' =>
                            'Online Storefront checkout.',

                        'created_by' =>
                            null,

                        'updated_by' =>
                            null,

                        'shipping_method' =>
                            $quote['shipping_mode'],


                        'shipping_location_id' =>
                            $quote['shipping_location']['id']
                                ?? null,


                        'shipping_location_name' =>
                            $quote['shipping_location']['name']
                                ?? null,


                        'shipping_address' =>
                            $quote['shipping_mode'] === 'manual'
                                ? ($customerData['address'] ?? null)
                                : null,


                        'shipping_city' =>
                            $quote['shipping_mode'] === 'manual'
                                ? ($customerData['city'] ?? null)
                                : null,


                        'shipping_state' =>
                            $quote['shipping_mode'] === 'manual'
                                ? ($customerData['state'] ?? null)
                                : null,


                        'shipping_fee' =>
                            $quote['shipping_fee'],


                        'fulfilment_status' =>
                            'Pending',

                    ]);


                /*
                |--------------------------------------------------------------------------
                | Order Items
                |--------------------------------------------------------------------------
                */

                foreach (
                    $quote['items']
                    as $item
                ) {

                    OrderItem::create([

                        'company_id' =>
                            $storefront->company_id,

                        'order_id' =>
                            $order->id,

                        'product_id' =>
                            $item['product_id'],

                        'product_name' =>
                            $item['product_name'],

                        'product_barcode' =>
                            $item['product_barcode'],

                        'quantity' =>
                            $item['quantity'],

                        'unit_price' =>
                            $item['unit_price'],

                        'unit_cost' =>
                            $item['unit_cost'],

                        'discount' =>
                            $item['discount'],

                        'tax' =>
                            $item['tax'],

                        'total' =>
                            $item['total'],

                    ]);

                }


                /*
                |--------------------------------------------------------------------------
                | Invoice
                |--------------------------------------------------------------------------
                */

                $invoice =
                    Invoice::create([

                        'company_id' =>
                            $storefront->company_id,

                        'branch_id' =>
                            $headOffice->id,

                        'terminal_id' =>
                            null,

                        'order_id' =>
                            $order->id,

                        'customer_id' =>
                            $customer->id,

                        'invoice_no' =>
                            $invoiceNo,

                        'invoice_date' =>
                            now()
                                ->toDateString(),

                        'subtotal' =>
                            $quote['subtotal'],

                        'discount' =>
                            $quote['discount'],

                        'tax' =>
                            $quote['tax'],

                        'total' =>
                            $quote['grand_total'],

                        'amount_paid' =>
                            0,

                        'balance' =>
                            $quote['grand_total'],

                        'total_quantity' =>
                            $quote['total_quantity'],

                        'total_items' =>
                            $quote['total_items'],

                        'grand_total' =>
                            $quote['grand_total'],

                        'payment_status' =>
                            'Pending',

                        'invoice_status' =>
                            'Active',

                        'remarks' =>
                            'Online Storefront order ' .
                            $order->order_no,

                        'created_by' =>
                            null,

                        'updated_by' =>
                            null,

                    ]);


                /*
                |--------------------------------------------------------------------------
                | Invoice Items
                |--------------------------------------------------------------------------
                */

                foreach (
                    $quote['items']
                    as $item
                ) {

                    InvoiceItem::create([

                        'company_id' =>
                            $storefront->company_id,

                        'invoice_id' =>
                            $invoice->id,

                        'product_id' =>
                            $item['product_id'],

                        'product_name' =>
                            $item['product_name'],

                        'product_barcode' =>
                            $item['product_barcode'],

                        'quantity' =>
                            $item['quantity'],

                        'unit_price' =>
                            $item['unit_price'],

                        'discount' =>
                            $item['discount'],

                        'tax' =>
                            $item['tax'],

                        'total' =>
                            $item['total'],

                    ]);

                }


                return $order
                    ->load([
                        'customer',
                        'invoice',
                        'orderItems',
                    ]);

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Customer
    |--------------------------------------------------------------------------
    */

    protected function resolveCustomer(
        Storefront $storefront,
        array $data
    ): Customer {

        $email =
            strtolower(
                trim(
                    $data['email']
                )
            );


        $phone =
            trim(
                $data['phone']
            );


        /*
        |--------------------------------------------------------------------------
        | Prefer Email
        |--------------------------------------------------------------------------
        */

        $customer =
            Customer::query()
                ->forCompany(
                    $storefront->company_id
                )
                ->where(
                    'email',
                    $email
                )
                ->first();


        /*
        |--------------------------------------------------------------------------
        | Then Phone
        |--------------------------------------------------------------------------
        */

        if (!$customer) {

            $customer =
                Customer::query()
                    ->forCompany(
                        $storefront->company_id
                    )
                    ->where(
                        'phone',
                        $phone
                    )
                    ->first();

        }


        $fullAddress =
        collect([

            trim(
                (string) (
                    $data['address']
                    ?? ''
                )
            ),

            trim(
                (string) (
                    $data['city']
                    ?? ''
                )
            ),

            trim(
                (string) (
                    $data['state']
                    ?? ''
                )
            ),

        ])
        ->filter()
        ->implode(', ');


        if ($customer) {

            /*
            |--------------------------------------------------------------------------
            | Refresh useful contact information
            |--------------------------------------------------------------------------
            */

            $customer->update([

                'first_name' =>
                    $data['first_name'],

                'last_name' =>
                    $data['last_name']
                        ?? $customer->last_name,

                'email' =>
                    $email,

                'phone' =>
                    $phone,

                'address' =>
                    $fullAddress,

                'customer_type' =>
                    'Online',

                'status' =>
                    true,

                'updated_by' =>
                    null,

            ]);


            return $customer;

        }


        return Customer::create([

            'company_id' =>
                $storefront->company_id,

            'customer_code' =>
                DocumentNumberService::generate(
                    'customer',
                    $storefront->company_id
                ),

            'first_name' =>
                $data['first_name'],

            'last_name' =>
                $data['last_name']
                    ?? null,

            'email' =>
                $email,

            'phone' =>
                $phone,

            'address' =>
                $fullAddress,

            'credit_limit' =>
                0,

            'current_balance' =>
                0,

            'customer_type' =>
                'Online',

            'loyalty_points' =>
                0,

            'status' =>
                true,

            'created_by' =>
                null,

            'updated_by' =>
                null,

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Initialize Paystack
    |--------------------------------------------------------------------------
    */

    public function initializePayment(
        Storefront $storefront,
        Order $order
    ): array {

        $secretKey =
            config(
                'services.paystack.secret_key'
            );


        if (!$secretKey) {

            throw new RuntimeException(
                'Paystack has not been configured.'
            );

        }


        $reference =
            'SF-' .
            $order->id .
            '-' .
            Str::upper(
                Str::random(12)
            );


        $amountInSubunit =
            (int)
            round(
                (float)
                $order->grand_total
                * 100
            );


        $callbackUrl =
            route(
                'storefront.public.checkout.callback',
                [
                    'storefrontSlug' =>
                        $storefront->slug,
                ]
            );


        $response =
            Http::withToken(
                $secretKey
            )
            ->acceptJson()
            ->asJson()
            ->timeout(30)
            ->post(
                config(
                    'services.paystack.base_url',
                    'https://api.paystack.co'
                ) .
                '/transaction/initialize',
                [

                    'email' =>
                        $order
                            ->customer
                            ->email,

                    'amount' =>
                        $amountInSubunit,

                    'currency' =>
                        config(
                            'services.paystack.currency',
                            'NGN'
                        ),

                    'reference' =>
                        $reference,

                    'callback_url' =>
                        $callbackUrl,

                    'metadata' =>
                        json_encode([

                            'order_id' =>
                                $order->id,

                            'order_no' =>
                                $order->order_no,

                            'storefront_id' =>
                                $storefront->id,

                            'storefront_slug' =>
                                $storefront->slug,

                        ]),

                ]
            );


        if (
            !$response->successful() ||
            !$response->json(
                'status'
            )
        ) {

            throw new RuntimeException(
                $response->json(
                    'message'
                )
                ?: 'Unable to initialize payment.'
            );

        }


        return [

            'authorization_url' =>
                $response->json(
                    'data.authorization_url'
                ),

            'access_code' =>
                $response->json(
                    'data.access_code'
                ),

            'reference' =>
                $response->json(
                    'data.reference'
                ),

        ];

    }


    /*
    |--------------------------------------------------------------------------
    | Verify Paystack
    |--------------------------------------------------------------------------
    */

    public function verifyPayment(
        string $reference
    ): array {

        $secretKey =
            config(
                'services.paystack.secret_key'
            );


        if (!$secretKey) {

            throw new RuntimeException(
                'Paystack has not been configured.'
            );

        }


        $response =
            Http::withToken(
                $secretKey
            )
            ->acceptJson()
            ->timeout(30)
            ->get(
                config(
                    'services.paystack.base_url',
                    'https://api.paystack.co'
                ) .
                '/transaction/verify/' .
                urlencode(
                    $reference
                )
            );


        if (
            !$response->successful() ||
            !$response->json(
                'status'
            )
        ) {

            throw new RuntimeException(
                $response->json(
                    'message'
                )
                ?: 'Payment verification failed.'
            );

        }


        return
            $response->json(
                'data'
            );

    }


    /*
    |--------------------------------------------------------------------------
    | Complete Paid Order
    |--------------------------------------------------------------------------
    */

    public function completePaidOrder(
        Storefront $storefront,
        array $gatewayData
    ): Order {

        $reference =
            (string) (
                $gatewayData['reference']
                ?? ''
            );


        if (!$reference) {

            throw new RuntimeException(
                'Payment reference is missing.'
            );

        }


        if (
            (
                $gatewayData['status']
                ?? null
            ) !== 'success'
        ) {

            throw new RuntimeException(
                'The payment was not successful.'
            );

        }


        $metadata =
            $gatewayData['metadata']
            ?? [];


        if (is_string($metadata)) {

            $metadata =
                json_decode(
                    $metadata,
                    true
                )
                ?: [];

        }


        $orderId =
            (int) (
                $metadata['order_id']
                ?? 0
            );


        if ($orderId <= 0) {

            throw new RuntimeException(
                'Unable to identify the order for this payment.'
            );

        }


        return DB::transaction(
            function () use (
                $storefront,
                $gatewayData,
                $reference,
                $orderId
            ) {

                $order =
                    Order::query()
                        ->where(
                            'company_id',
                            $storefront->company_id
                        )
                        ->where(
                            'sales_channel',
                            'Online'
                        )
                        ->lockForUpdate()
                        ->find(
                            $orderId
                        );


                if (!$order) {

                    throw new RuntimeException(
                        'The order could not be found.'
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Already Processed
                |--------------------------------------------------------------------------
                */

                if (
                    $order->payment_status ===
                    'Paid'
                ) {

                    return $order->load([
                        'customer',
                        'invoice',
                        'orderItems',
                        'payments',
                    ]);

                }


                $existingPayment =
                    Payment::query()
                        ->where(
                            'company_id',
                            $storefront->company_id
                        )
                        ->where(
                            'transaction_reference',
                            $reference
                        )
                        ->first();


                if ($existingPayment) {

                    return $order->load([
                        'customer',
                        'invoice',
                        'orderItems',
                        'payments',
                    ]);

                }


                /*
                |--------------------------------------------------------------------------
                | Verify Amount
                |--------------------------------------------------------------------------
                */

                $expectedAmount =
                    (int)
                    round(
                        (float)
                        $order->grand_total
                        * 100
                    );


                $paidAmount =
                    (int) (
                        $gatewayData['amount']
                        ?? 0
                    );


                if (
                    $paidAmount !==
                    $expectedAmount
                ) {

                    throw new RuntimeException(
                        'The verified payment amount does not match the order total.'
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Stock
                |--------------------------------------------------------------------------
                */

                $items =
                    OrderItem::query()
                        ->where(
                            'order_id',
                            $order->id
                        )
                        ->get();


                foreach ($items as $item) {

                    $product =
                        Product::query()
                            ->where(
                                'company_id',
                                $storefront->company_id
                            )
                            ->lockForUpdate()
                            ->find(
                                $item->product_id
                            );


                    if (!$product) {

                        throw new RuntimeException(
                            'A product in this order no longer exists.'
                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Non-Stock Product
                    |--------------------------------------------------------------------------
                    |
                    | The item remains part of the Order, Invoice and Payment.
                    |
                    | However, products that do not track inventory have no ProductStock
                    | balance to reduce and must not create a StockMovement.
                    |
                    */

                    if (!$product->tracksStock()) {

                        continue;

                    }


                    $stock =
                        ProductStock::query()
                            ->where(
                                'company_id',
                                $storefront->company_id
                            )
                            ->where(
                                'branch_id',
                                $order->branch_id
                            )
                            ->where(
                                'product_id',
                                $item->product_id
                            )
                            ->lockForUpdate()
                            ->first();


                    if (!$stock) {

                        throw new RuntimeException(
                            'Stock could not be found for "' .
                            $item->product_name .
                            '".'
                        );

                    }


                    $quantity =
                        (float)
                        $item->quantity;


                    $availableQuantity =
                        (float)
                        $stock->available_quantity;


                    if (
                        $quantity >
                        $availableQuantity
                    ) {

                        throw new RuntimeException(
                            '"' .
                            $item->product_name .
                            '" no longer has enough stock to complete this order.'
                        );

                    }


                    $stockBefore =
                        (float)
                        $stock->quantity;


                    $newQuantity =
                        $stockBefore
                        - $quantity;


                    if (
                        $newQuantity < 0
                    ) {

                        throw new RuntimeException(
                            'Stock cannot become negative for "' .
                            $item->product_name .
                            '".'
                        );

                    }


                    $reservedQuantity =
                        (float)
                        $stock->reserved_quantity;


                    $newAvailableQuantity =
                        max(
                            0,
                            $newQuantity
                            - $reservedQuantity
                        );


                    $stock->update([

                        'quantity' =>
                            $newQuantity,

                        'available_quantity' =>
                            $newAvailableQuantity,

                    ]);


                    StockMovement::create([

                        'company_id' =>
                            $storefront->company_id,

                        'branch_id' =>
                            $order->branch_id,

                        'product_id' =>
                            $item->product_id,

                        'order_id' =>
                            $order->id,

                        'reference_no' =>
                            $order->order_no,

                        'unit_cost' =>
                            (float)
                            $product->cost_price,

                        'quantity' =>
                            $quantity,

                        'stock_before' =>
                            $stockBefore,

                        'balance_after' =>
                            $newQuantity,

                        'remarks' =>
                            'Online Storefront order completed: ' .
                            $order->order_no,

                        /*
                         * This needs stock_movements.created_by
                         * to permit NULL for public online sales.
                         */
                        'created_by' =>
                            null,

                        'movement_type' =>
                            'Sale',

                    ]);

                }


                /*
                |--------------------------------------------------------------------------
                | Payment Method
                |--------------------------------------------------------------------------
                */

                $paymentMethod =
                    PaymentMethod::query()
                        ->where(
                            'company_id',
                            $storefront->company_id
                        )
                        ->active()
                        ->where(
                            'is_cash',
                            false
                        )
                        ->orderByRaw(
                            "CASE
                                WHEN name = 'Transfer' THEN 0
                                WHEN name = 'Card' THEN 1
                                WHEN name = 'POS' THEN 2
                                ELSE 3
                            END"
                        )
                        ->orderBy(
                            'display_order'
                        )
                        ->first();


                if (!$paymentMethod) {

                    throw new RuntimeException(
                        'No active online-compatible payment method has been configured.'
                    );

                }


                $paymentNumber =
                    DocumentNumberService::generate(
                        'payment',
                        $storefront->company_id
                    );


                $channel =
                    (string) (
                        $gatewayData['channel']
                        ?? 'online'
                    );


                /*
                |--------------------------------------------------------------------------
                | Payment
                |--------------------------------------------------------------------------
                |
                | "Transfer" is used here because it exists in every payment_method
                | enum version you supplied.
                |
                | The actual source remains available as:
                | payment_gateway = Paystack
                | remarks = Paystack channel
                |
                */

                $gatewayChannel =
                    strtolower(
                        (string) (
                            $gatewayData['channel']
                            ?? ''
                        )
                    );


                $paymentMethodValue =
                    match ($gatewayChannel) {

                        'card' =>
                            'Card',

                        'bank',
                        'bank_transfer',
                        'transfer' =>
                            'Transfer',

                        'ussd' =>
                            'Transfer',

                        default =>
                            'Transfer',

                    };

                Payment::create([

                    'company_id' =>
                        $storefront->company_id,

                    'branch_id' =>
                        $order->branch_id,

                    'terminal_id' =>
                        null,

                    'order_id' =>
                        $order->id,

                    'customer_id' =>
                        $order->customer_id,

                    'received_by' =>
                        null,

                    'payment_number' =>
                        $paymentNumber,

                    'payment_method_id' =>
                        $paymentMethod->id,

                    'payment_method' =>
                        $paymentMethodValue,

                    'amount' =>
                        (float)
                        $order->grand_total,

                    'reference_no' =>
                        $order->order_no,

                    'transaction_reference' =>
                        $reference,

                    'payment_gateway' =>
                        'Paystack',

                    'payment_status' =>
                        'Completed',

                    'payment_date' =>
                        now(),

                    'remarks' =>
                        'Paystack online payment. Channel: ' .
                        $channel .
                        '. Order: ' .
                        $order->order_no,

                ]);


                /*
                |--------------------------------------------------------------------------
                | Invoice
                |--------------------------------------------------------------------------
                */

                $invoice =
                    Invoice::query()
                        ->where(
                            'order_id',
                            $order->id
                        )
                        ->lockForUpdate()
                        ->first();


                if (!$invoice) {

                    throw new RuntimeException(
                        'Invoice could not be found for this order.'
                    );

                }


                $invoice->update([

                    'amount_paid' =>
                        $order->grand_total,

                    'balance' =>
                        0,

                    'payment_status' =>
                        'Paid',

                    'invoice_status' =>
                        'Active',

                    'updated_by' =>
                        null,

                ]);


                /*
                |--------------------------------------------------------------------------
                | Order
                |--------------------------------------------------------------------------
                */

                $order->update([

                    'amount_paid' =>
                        $order->grand_total,

                    'balance' =>
                        0,

                    'change_given' =>
                        0,

                    'payment_status' =>
                        'Paid',

                    'order_status' =>
                        'Completed',

                    'completed_at' =>
                        now(),

                    'updated_by' =>
                        null,

                ]);


                /*
                |--------------------------------------------------------------------------
                | Customer Last Purchase
                |--------------------------------------------------------------------------
                */

                if ($order->customer_id) {

                    Customer::query()
                        ->whereKey(
                            $order->customer_id
                        )
                        ->update([
                            'last_purchase_date' =>
                                now()
                                    ->toDateString(),
                        ]);

                }

                $orderId =
                    $order->id;


                DB::afterCommit(
                    function () use (
                        $orderId
                    ) {

                        SendStorefrontOrderConfirmation::dispatch(
                            $orderId
                        );

                    }
                );


                return $order
                    ->fresh()
                    ->load([
                        'customer',
                        'invoice',
                        'orderItems',
                        'payments',
                    ]);

            }
        );

    }
}