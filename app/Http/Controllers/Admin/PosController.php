<?php

namespace App\Http\Controllers\Admin;

use App\Models\CashDrawer;
use App\Models\CashDrawerTransaction;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\TaxRate;
use App\Models\User;
use App\Models\TerminalAssignment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Services\ActivityLogger;

class PosController extends BaseController
{
     protected ActivityLogger $activityLogger;


    public function __construct(ActivityLogger $activityLogger)
    {
        parent::__construct();

        $this->activityLogger = $activityLogger;
    }
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    /**
     * Modern POS screen.
     */
    public function index(
        Request $request
    ) {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('pos.sell')) {

            abort(
                403,
                'You do not have permission to access the POS.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Current User
        |--------------------------------------------------------------------------
        */

        $user =
            auth()->user();


        /*
        |--------------------------------------------------------------------------
        | Active Terminal Assignment
        |--------------------------------------------------------------------------
        */

        $terminalAssignment =
            TerminalAssignment::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'user_id',
                    $user->id
                )

                ->where(
                    'status',
                    'active'
                )

                ->with([
                    'branch',
                    'terminal',
                ])

                ->latest(
                    'assigned_at'
                )

                ->first();


        /*
        |--------------------------------------------------------------------------
        | Terminal Assignment Check
        |--------------------------------------------------------------------------
        */

        if (! $terminalAssignment) {

            return redirect()
                ->route(
                    'dashboard'
                )
                ->with(
                    'error',
                    'You must have an active terminal assigned before using the POS.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Branch
        |--------------------------------------------------------------------------
        */

        $branch =
            $terminalAssignment->branch;


        /*
        |--------------------------------------------------------------------------
        | Terminal
        |--------------------------------------------------------------------------
        */

        $terminal =
            $terminalAssignment->terminal;


        /*
        |--------------------------------------------------------------------------
        | Current Open Drawer
        |--------------------------------------------------------------------------
        */

        $drawer =
            CashDrawer::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'branch_id',
                    $terminalAssignment->branch_id
                )

                ->where(
                    'terminal_id',
                    $terminalAssignment->terminal_id
                )

                ->where(
                    'opened_by',
                    $user->id
                )

                ->where(
                    'status',
                    'open'
                )

                ->latest(
                    'opened_at'
                )

                ->first();


        /*
        |--------------------------------------------------------------------------
        | Drawer Check
        |--------------------------------------------------------------------------
        */

        if (! $drawer) {

            return redirect()
                ->route(
                    'cash-drawer.index'
                )
                ->with(
                    'error',
                    'You must open your cash drawer before starting a sale.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | POS View
        |--------------------------------------------------------------------------
        */

        return view(
            'pos.index',
            compact(
                'user',
                'terminalAssignment',
                'branch',
                'terminal',
                'drawer'
            )
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Context
    |--------------------------------------------------------------------------
    */

    /**
     * Return the current POS context.
     */
    public function context(): JsonResponse
    {
        if (! canAccess('pos.sell')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to access the POS.',

            ], 403);
        }


        $user =
            auth()->user();


        $terminalAssignment =
            TerminalAssignment::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'user_id',
                    $user->id
                )

                ->where(
                    'status',
                    'active'
                )

                ->with([
                    'branch',
                    'terminal',
                ])

                ->latest(
                    'assigned_at'
                )

                ->first();


        if (! $terminalAssignment) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'No active terminal is assigned to the current user.',

            ], 422);
        }


        $drawer =
            CashDrawer::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'branch_id',
                    $terminalAssignment->branch_id
                )

                ->where(
                    'terminal_id',
                    $terminalAssignment->terminal_id
                )

                ->where(
                    'opened_by',
                    $user->id
                )

                ->where(
                    'status',
                    'open'
                )

                ->latest(
                    'opened_at'
                )

                ->first();


        return response()->json([

            'success' =>
                true,

            'user' => [

                'id' =>
                    $user->id,

                'name' =>
                    trim(
                        ($user->last_name ?? '')
                        . ' '
                        . ($user->first_name ?? '')
                    ),

            ],

            'branch' => [

                'id' =>
                    $terminalAssignment->branch?->id,

                'name' =>
                    $terminalAssignment->branch?->name,

            ],

            'terminal' => [

                'id' =>
                    $terminalAssignment->terminal?->id,

                'name' =>
                    $terminalAssignment->terminal?->terminal_name,

            ],

            'drawer' => $drawer
                ? [

                    'id' =>
                        $drawer->id,

                    'status' =>
                        $drawer->status,

                    'opened_at' =>
                        $drawer->opened_at?->toISOString(),

                ]
                : null,

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Products
    |--------------------------------------------------------------------------
    */

    /**
     * Return POS products.
     */
    public function products(
        Request $request
    ): JsonResponse {

        if (! canAccess('pos.sell')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to access POS products.',

            ], 403);
        }


        $user =
            auth()->user();


        $terminalAssignment =
            $this->currentTerminalAssignment();


        if (! $terminalAssignment) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'No active terminal is assigned to the current user.',

            ], 422);
        }


        $query =
            Product::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'status',
                    '1'
                );


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        $search =
            trim(
                (string) $request->input(
                    'search',
                    ''
                )
            );


        if ($search !== '') {

            $query->where(

                function ($q) use (
                    $search
                ) {

                    $q

                        ->where(
                            'name',
                            'like',
                            '%' . $search . '%'
                        )

                        ->orWhere(
                            'sku',
                            'like',
                            '%' . $search . '%'
                        )

                        ->orWhere(
                            'barcode',
                            'like',
                            '%' . $search . '%'
                        )

                        ->orWhere(
                            'product_code',
                            'like',
                            '%' . $search . '%'
                        );

                }

            );

        }


        /*
        |--------------------------------------------------------------------------
        | Category
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled(
                'category_id'
            )
        ) {

            $query->where(
                'product_category_id',
                $request->category_id
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

        $products =
            $query

                ->with([
                    'unit',
                    'category',
                ])

                ->latest(
                    'id'
                )

                ->paginate(
                    30
                );


        /*
        |--------------------------------------------------------------------------
        | Branch Stock
        |--------------------------------------------------------------------------
        */

        $productIds =
            collect(
                $products->items()
            )
            ->pluck(
                'id'
            );


        $stocks =
            ProductStock::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'branch_id',
                    $terminalAssignment->branch_id
                )

                ->whereIn(
                    'product_id',
                    $productIds
                )

                ->get()

                ->keyBy(
                    'product_id'
                );


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        $data =
            collect(
                $products->items()
            )
            ->map(
                function (
                    $product
                ) use (
                    $stocks
                ) {

                    $stock =
                        $stocks->get(
                            $product->id
                        );


                    return [

                        'id' =>
                            $product->id,

                        'name' =>
                            $product->name,

                        'product_code' =>
                            $product->product_code,

                        'sku' =>
                            $product->sku,

                        'barcode' =>
                            $product->barcode,

                        'image' =>
                            $product->image,

                        'selling_price' =>
                            (float) $product->selling_price,

                        'cost_price' =>
                            (float) $product->cost_price,

                        'unit' => [

                            'id' =>
                                $product->unit?->id,

                            'name' =>
                                $product->unit?->name,

                        ],

                        'category' => [

                            'id' =>
                                $product->productCategory?->id,

                            'name' =>
                                $product->productCategory?->name,

                        ],

                        'stock' =>
                            (float) (
                                $stock?->available_quantity
                                ?? 0
                            ),

                    ];

                }
            )
            ->values();


        return response()->json([

            'success' =>
                true,

            'data' =>
                $data,

            'pagination' => [

                'current_page' =>
                    $products->currentPage(),

                'last_page' =>
                    $products->lastPage(),

                'per_page' =>
                    $products->perPage(),

                'total' =>
                    $products->total(),

            ],

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Product Search
    |--------------------------------------------------------------------------
    */

    /**
     * Search products for POS.
     */
    public function productSearch(
        Request $request
    ): JsonResponse {

        return $this->products(
            $request
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Product Details
    |--------------------------------------------------------------------------
    */

    /**
     * Return a product for the POS.
     */
    public function productDetails(
        int $id
    ): JsonResponse {

        if (! canAccess('pos.sell')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to access this product.',

            ], 403);
        }


        $assignment =
            $this->currentTerminalAssignment();


        if (! $assignment) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'No active terminal is assigned.',

            ], 422);
        }


        $product =
            Product::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'id',
                    $id
                )

                ->with([
                    'unit',
                    'productCategory',
                ])

                ->first();


        if (! $product) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Product not found.',

            ], 404);
        }


        $stock =
            ProductStock::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'branch_id',
                    $assignment->branch_id
                )

                ->where(
                    'product_id',
                    $product->id
                )

                ->first();


        return response()->json([

            'success' =>
                true,

            'data' => [

                'id' =>
                    $product->id,

                'name' =>
                    $product->name,

                'product_code' =>
                    $product->product_code,

                'sku' =>
                    $product->sku,

                'barcode' =>
                    $product->barcode,

                'description' =>
                    $product->description,

                'image' =>
                    $product->image,

                'selling_price' =>
                    (float) $product->selling_price,

                'stock' =>
                    (float) (
                        $stock?->available_quantity
                        ?? 0
                    ),

                'unit' => [

                    'id' =>
                        $product->unit?->id,

                    'name' =>
                        $product->unit?->name,

                ],

                'category' => [

                    'id' =>
                        $product->productCategory?->id,

                    'name' =>
                        $product->productCategory?->name,

                ],

            ],

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Barcode
    |--------------------------------------------------------------------------
    */

    /**
     * Return a product by barcode.
     */
    public function productByBarcode(
        string $barcode
    ): JsonResponse {

        if (! canAccess('pos.sell')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to use POS barcode lookup.',

            ], 403);
        }


        $assignment =
            $this->currentTerminalAssignment();


        if (! $assignment) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'No active terminal is assigned.',

            ], 422);
        }


        $product =
            Product::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'barcode',
                    $barcode
                )

                ->with([
                    'unit',
                    'productCategory',
                ])

                ->first();


        if (! $product) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'No product was found for this barcode.',

            ], 404);
        }


        $stock =
            ProductStock::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'branch_id',
                    $assignment->branch_id
                )

                ->where(
                    'product_id',
                    $product->id
                )

                ->first();


        return response()->json([

            'success' =>
                true,

            'data' => [

                'id' =>
                    $product->id,

                'name' =>
                    $product->name,

                'product_code' =>
                    $product->product_code,

                'sku' =>
                    $product->sku,

                'barcode' =>
                    $product->barcode,

                'selling_price' =>
                    (float) $product->selling_price,

                'stock' =>
                    (float) (
                        $stock?->available_quantity
                        ?? 0
                    ),

                'image' =>
                    $product->image,

            ],

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Categories
    |--------------------------------------------------------------------------
    */

    /**
     * Return product categories.
     */
    public function categories(): JsonResponse
    {
        if (! canAccess('pos.sell')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view POS categories.',

            ], 403);
        }


        $categories =
            \App\Models\ProductCategory::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->orderBy(
                    'name'
                )

                ->get([
                    'id',
                    'name',
                ]);


        return response()->json([

            'success' =>
                true,

            'data' =>
                $categories,

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Customers
    |--------------------------------------------------------------------------
    */

    /**
     * Return POS customers.
     */
    public function customers(
        Request $request
    ): JsonResponse {

        if (! canAccess('pos.sell')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view customers.',

            ], 403);
        }


        $query =
            Customer::query()

                ->where(
                    'company_id',
                    $this->companyId
                );


        $search =
            trim(
                (string) $request->input(
                    'search',
                    ''
                )
            );


        if ($search !== '') {

            $query->where(

                function ($q) use (
                    $search
                ) {

                    $q

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
                            'phone',
                            'like',
                            '%' . $search . '%'
                        )

                        ->orWhere(
                            'email',
                            'like',
                            '%' . $search . '%'
                        );

                }

            );

        }


        $customers =
            $query

                ->latest(
                    'id'
                )

                ->paginate(
                    20
                );


        $data =
            collect(
                $customers->items()
            )
            ->map(
                function ($customer) {

                    return [

                        'id' =>
                            $customer->id,

                        'name' =>
                            trim(
                                ($customer->last_name ?? '')
                                . ' '
                                . ($customer->first_name ?? '')
                            ),

                        'first_name' =>
                            $customer->first_name,

                        'last_name' =>
                            $customer->last_name,

                        'phone' =>
                            $customer->phone,

                        'email' =>
                            $customer->email,

                    ];

                }
            )
            ->values();


        return response()->json([

            'success' =>
                true,

            'data' =>
                $data,

            'pagination' => [

                'current_page' =>
                    $customers->currentPage(),

                'last_page' =>
                    $customers->lastPage(),

                'per_page' =>
                    $customers->perPage(),

                'total' =>
                    $customers->total(),

            ],

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Customer Details
    |--------------------------------------------------------------------------
    */

    /**
     * Return a customer.
     */
    public function customerDetails(
        int $id
    ): JsonResponse {

        if (! canAccess('pos.sell')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view customers.',

            ], 403);
        }


        $customer =
            Customer::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'id',
                    $id
                )

                ->first();


        if (! $customer) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Customer not found.',

            ], 404);
        }


        return response()->json([

            'success' =>
                true,

            'data' => [

                'id' =>
                    $customer->id,

                'name' =>
                    trim(
                        ($customer->last_name ?? '')
                        . ' '
                        . ($customer->first_name ?? '')
                    ),

                'first_name' =>
                    $customer->first_name,

                'last_name' =>
                    $customer->last_name,

                'phone' =>
                    $customer->phone,

                'email' =>
                    $customer->email,

            ],

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Discounts
    |--------------------------------------------------------------------------
    */

    /**
     * Return POS discounts.
     */
    public function discounts(): JsonResponse
    {
        if (! canAccess('pos.sell')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view POS discounts.',

            ], 403);
        }


        $discounts =
            Discount::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->orderBy(
                    'name'
                )

                ->get();


        return response()->json([

            'success' =>
                true,

            'data' =>
                $discounts,

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Tax Rates
    |--------------------------------------------------------------------------
    */

    /**
     * Return POS tax rates.
     */
    public function taxRates(): JsonResponse
    {
        if (! canAccess('pos.sell')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view POS tax rates.',

            ], 403);
        }


        $taxRates =
            TaxRate::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->orderBy(
                    'name'
                )

                ->get();


        return response()->json([

            'success' =>
                true,

            'data' =>
                $taxRates,

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Store Order
    |--------------------------------------------------------------------------
    */

    /**
     * Create/save a POS order.
     */
    public function storeOrder(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('pos.sell')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to create sales.',

            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([

                'customer_id' => [
                    'nullable',
                    'integer',
                ],

                'items' => [
                    'required',
                    'array',
                    'min:1',
                ],

                'items.*.product_id' => [
                    'required',
                    'integer',
                ],

                'items.*.quantity' => [
                    'required',
                    'numeric',
                    'gt:0',
                ],

                'items.*.unit_price' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'discount_id' => [
                    'nullable',
                    'integer',
                ],

                'tax_rate_id' => [
                    'nullable',
                    'integer',
                ],

                'remarks' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],

            ]);


        try {

            $result =
                DB::transaction(

                    function () use (
                        $validated
                    ) {

                        $context =
                            $this->posContextOrFail();


                        $order =
                            new Order();


                        $order->company_id =
                            $this->companyId;

                        $order->branch_id =
                            $context['assignment']->branch_id;

                        $order->terminal_id =
                            $context['assignment']->terminal_id;

                        $order->customer_id =
                            $validated['customer_id']
                            ?? null;

                        $order->cashier_id =
                            auth()->id();

                        $order->created_by =
                            auth()->id();

                        $order->order_status =
                            'Pending';

                        $order->payment_status =
                            'Pending';

                        $order->sales_channel =
                            'POS';

                        $order->remarks =
                            $validated['remarks']
                            ?? null;

                        $order->discount_id =
                            $validated['discount_id']
                            ?? null;

                        $order->tax_rate_id =
                            $validated['tax_rate_id']
                            ?? null;


                        /*
                        |--------------------------------------------------------------------------
                        | Calculate Items
                        |--------------------------------------------------------------------------
                        */

                        $subtotal =
                            0;

                        $totalQuantity =
                            0;

                        $totalItems =
                            0;


                        $preparedItems = [];


                        foreach (
                            $validated['items']
                            as $item
                        ) {

                            $product =
                                Product::query()

                                    ->where(
                                        'company_id',
                                        $this->companyId
                                    )

                                    ->where(
                                        'id',
                                        $item['product_id']
                                    )

                                    ->first();


                            if (! $product) {

                                throw ValidationException::withMessages([

                                    'items' =>
                                        'One of the selected products could not be found.',

                                ]);

                            }


                            $stock =
                                ProductStock::query()

                                    ->where(
                                        'company_id',
                                        $this->companyId
                                    )

                                    ->where(
                                        'branch_id',
                                        $context['assignment']->branch_id
                                    )

                                    ->where(
                                        'product_id',
                                        $product->id
                                    )

                                    ->lockForUpdate()

                                    ->first();


                            $quantity =
                                (float) $item['quantity'];


                            $unitPrice =
                                (float) $item['unit_price'];


                            if (
                                ! $stock
                                || (float) $stock->available_quantity < $quantity
                            ) {

                                throw ValidationException::withMessages([

                                    'items' =>
                                        "Insufficient stock for {$product->name}.",

                                ]);

                            }


                            $lineTotal =
                                $quantity
                                * $unitPrice;


                            $subtotal +=
                                $lineTotal;

                            $totalQuantity +=
                                $quantity;

                            $totalItems++;


                            $preparedItems[] = [

                                'product' =>
                                    $product,

                                'quantity' =>
                                    $quantity,

                                'unit_price' =>
                                    $unitPrice,

                                'line_total' =>
                                    $lineTotal,

                            ];

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Discount
                        |--------------------------------------------------------------------------
                        */

                        $discountAmount =
                            0;


                        if (
                            ! empty(
                                $validated['discount_id']
                            )
                        ) {

                            $discount =
                                Discount::query()

                                    ->where(
                                        'company_id',
                                        $this->companyId
                                    )

                                    ->where(
                                        'id',
                                        $validated['discount_id']
                                    )

                                    ->first();


                            if ($discount) {

                                /*
                                | Existing discount structures vary by
                                | implementation, so this is intentionally
                                | kept conservative here.
                                */

                                if (
                                    isset(
                                        $discount->percentage
                                    )
                                ) {

                                    $discountAmount =
                                        $subtotal
                                        * (
                                            (float) $discount->percentage
                                            / 100
                                        );

                                } elseif (
                                    isset(
                                        $discount->amount
                                    )
                                ) {

                                    $discountAmount =
                                        (float) $discount->amount;

                                }

                            }

                        }


                        $discountAmount =
                            min(
                                $discountAmount,
                                $subtotal
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | Tax
                        |--------------------------------------------------------------------------
                        */

                        $taxableAmount =
                            $subtotal
                            - $discountAmount;


                        $taxAmount =
                            0;


                        if (
                            ! empty(
                                $validated['tax_rate_id']
                            )
                        ) {

                            $taxRate =
                                TaxRate::query()

                                    ->where(
                                        'company_id',
                                        $this->companyId
                                    )

                                    ->where(
                                        'id',
                                        $validated['tax_rate_id']
                                    )

                                    ->first();


                            if (
                                $taxRate
                                && isset(
                                    $taxRate->rate
                                )
                            ) {

                                $taxAmount =
                                    $taxableAmount
                                    * (
                                        (float) $taxRate->rate
                                        / 100
                                    );

                            }

                        }


                        $total =
                            $taxableAmount
                            + $taxAmount;


                        /*
                        |--------------------------------------------------------------------------
                        | Order Number
                        |--------------------------------------------------------------------------
                        |
                        | This should ultimately use the project's
                        | DocumentNumberService if your Order creation
                        | service already does so.
                        |
                        */

                        $order->order_no =
                            'POS-' . now()->format(
                                'YmdHis'
                            ) . '-' . auth()->id();


                        $order->subtotal =
                            $subtotal;

                        $order->discount =
                            $discountAmount;

                        $order->tax =
                            $taxAmount;

                        $order->total =
                            $total;

                        $order->grand_total =
                            $total;

                        $order->amount_paid =
                            0;

                        $order->balance =
                            $total;

                        $order->total_items =
                            $totalItems;

                        $order->total_quantity =
                            $totalQuantity;

                        $order->change_given =
                            0;

                        $order->receipt_printed =
                            false;


                        $order->save();


                        /*
                        |--------------------------------------------------------------------------
                        | Order Items
                        |--------------------------------------------------------------------------
                        */

                        foreach (
                            $preparedItems
                            as $preparedItem
                        ) {

                            $product =
                                $preparedItem['product'];


                            OrderItem::create([

                                'order_id' =>
                                    $order->id,

                                'product_id' =>
                                    $product->id,

                                'product_name' =>
                                    $product->name,

                                'quantity' =>
                                    $preparedItem['quantity'],

                                'unit_price' =>
                                    $preparedItem['unit_price'],

                                'discount' =>
                                    0,

                                'tax' =>
                                    0,

                                'total' =>
                                    $preparedItem['line_total'],

                            ]);

                        }


                        return [

                            'order' =>
                                $order->fresh([
                                    'customer',
                                    'orderItems',
                                ]),

                        ];

                    }

                );


            return response()->json([

                'success' =>
                    true,

                'message' =>
                    'Sale order saved successfully.',

                'data' =>
                    $result['order'],

            ]);


        } catch (ValidationException $e) {

            throw $e;


        } catch (\Throwable $e) {

            Log::error(

                'Failed to create POS order.',

                [

                    'company_id' =>
                        $this->companyId,

                    'user_id' =>
                        auth()->id(),

                    'error' =>
                        $e->getMessage(),

                ]

            );


            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Unable to create sale order. Please try again.',

            ], 500);

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Order Details
    |--------------------------------------------------------------------------
    */

    /**
     * Return an order.
     */
    public function orderDetails(
        int $id
    ): JsonResponse {

        if (! canAccess('pos.sell')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view this order.',

            ], 403);
        }


        $order =
            Order::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'id',
                    $id
                )

                ->with([
                    'customer',
                    'orderItems',
                    'payments',
                ])

                ->first();


        if (! $order) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Order not found.',

            ], 404);
        }


        return response()->json([

            'success' =>
                true,

            'data' =>
                $order,

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Hold Order
    |--------------------------------------------------------------------------
    */

    /**
     * Hold the current sale.
     */
    public function holdOrder(
        Request $request
    ): JsonResponse {

        if (! canAccess('pos.sell')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to hold sales.',

            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | Hold
        |--------------------------------------------------------------------------
        |
        | The POS JavaScript will submit the current cart here.
        | The order is deliberately kept Pending/Held until retrieved.
        |
        */

        $validated =
            $request->validate([

                'customer_id' => [
                    'nullable',
                    'integer',
                ],

                'items' => [
                    'required',
                    'array',
                    'min:1',
                ],

                'items.*.product_id' => [
                    'required',
                    'integer',
                ],

                'items.*.quantity' => [
                    'required',
                    'numeric',
                    'gt:0',
                ],

                'items.*.unit_price' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | Create Order
        |--------------------------------------------------------------------------
        */

        $validated['remarks'] =
            $request->input(
                'remarks'
            );


        $result =
            $this->storeOrder(
                new Request(
                    $validated
                )
            );


        /*
        |--------------------------------------------------------------------------
        | Existing Order
        |--------------------------------------------------------------------------
        |
        | The detailed held-order lifecycle will be completed in pos.js
        | and the dedicated order-state implementation.
        |
        */

        return $result;

    }


    /*
    |--------------------------------------------------------------------------
    | Held Orders
    |--------------------------------------------------------------------------
    */

    /**
     * Return held orders.
     */
    public function heldOrders(
        Request $request
    ): JsonResponse {

        if (! canAccess('pos.sell')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view held sales.',

            ], 403);
        }


        $query =
            Order::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'order_status',
                    'Held'
                )

                ->with([
                    'customer',
                    'orderItems',
                ]);


        $search =
            trim(
                (string) $request->input(
                    'search',
                    ''
                )
            );


        if ($search !== '') {

            $query->where(

                function ($q) use (
                    $search
                ) {

                    $q

                        ->where(
                            'order_no',
                            'like',
                            '%' . $search . '%'
                        )

                        ->orWhereHas(
                            'customer',
                            function (
                                $customerQuery
                            ) use (
                                $search
                            ) {

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
                                    );

                            }
                        );

                }

            );

        }


        $orders =
            $query
                ->latest()
                ->paginate(
                    15
                );


        return response()->json([

            'success' =>
                true,

            'data' =>
                $orders->items(),

            'pagination' => [

                'current_page' =>
                    $orders->currentPage(),

                'last_page' =>
                    $orders->lastPage(),

                'per_page' =>
                    $orders->perPage(),

                'total' =>
                    $orders->total(),

            ],

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Retrieve Order
    |--------------------------------------------------------------------------
    */

    /**
     * Retrieve a held order.
     */
    public function retrieveOrder(
        int $id
    ): JsonResponse {

        if (! canAccess('pos.sell')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to retrieve held sales.',

            ], 403);
        }


        $order =
            Order::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'id',
                    $id
                )

                ->where(
                    'order_status',
                    'Held'
                )

                ->with([
                    'customer',
                    'orderItems',
                ])

                ->first();


        if (! $order) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Held sale not found.',

            ], 404);
        }


        $order->update([

            'order_status' =>
                'Pending',

            'updated_by' =>
                auth()->id(),

        ]);


        return response()->json([

            'success' =>
                true,

            'message' =>
                'Held sale retrieved successfully.',

            'data' =>
                $order->fresh([
                    'customer',
                    'orderItems',
                ]),

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Payment
    |--------------------------------------------------------------------------
    */

    /**
     * Store a payment against an order.
     */
    public function storePayment(
        Request $request,
        int $id
    ): JsonResponse {

        if (! canAccess('pos.sell')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to process payments.',

            ], 403);
        }


        $validated =
            $request->validate([

                'payment_method' => [
                    'required',
                    'string',
                ],

                'amount' => [
                    'required',
                    'numeric',
                    'gt:0',
                ],

                'reference_no' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'remarks' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],

            ]);


        try {

            $result =
                DB::transaction(

                    function () use (
                        $validated,
                        $id
                    ) {

                        $context =
                            $this->posContextOrFail();


                        $order =
                            Order::query()

                                ->where(
                                    'company_id',
                                    $this->companyId
                                )

                                ->where(
                                    'id',
                                    $id
                                )

                                ->lockForUpdate()

                                ->first();


                        if (! $order) {

                            throw ValidationException::withMessages([

                                'order' =>
                                    'Order not found.',

                            ]);
                        }


                        $amount =
                            (float) $validated['amount'];


                        $payment =
                            Payment::create([

                                'company_id' =>
                                    $this->companyId,

                                'branch_id' =>
                                    $context['assignment']->branch_id,

                                'terminal_id' =>
                                    $context['assignment']->terminal_id,

                                'order_id' =>
                                    $order->id,

                                'customer_id' =>
                                    $order->customer_id,

                                'received_by' =>
                                    auth()->id(),

                                'payment_method' =>
                                    $validated['payment_method'],

                                'amount' =>
                                    $amount,

                                'reference_no' =>
                                    $validated['reference_no']
                                    ?? null,

                            ]);


                        return [

                            'order' =>
                                $order->fresh([
                                    'payments',
                                ]),

                            'payment' =>
                                $payment->fresh(),

                        ];

                    }

                );


            return response()->json([

                'success' =>
                    true,

                'message' =>
                    'Payment recorded successfully.',

                'data' => [

                    'order' =>
                        $result['order'],

                    'payment' =>
                        $result['payment'],

                ],

            ]);


        } catch (ValidationException $e) {

            throw $e;


        } catch (\Throwable $e) {

            Log::error(

                'Failed to store POS payment.',

                [

                    'company_id' =>
                        $this->companyId,

                    'user_id' =>
                        auth()->id(),

                    'order_id' =>
                        $id,

                    'error' =>
                        $e->getMessage(),

                ]

            );


            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Unable to record payment. Please try again.',

            ], 500);

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Payments
    |--------------------------------------------------------------------------
    */

    /**
     * Return payments for an order.
     */
    public function payments(
        int $id
    ): JsonResponse {

        if (! canAccess('pos.sell')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view payments.',

            ], 403);
        }


        $payments =
            Payment::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'order_id',
                    $id
                )

                ->latest()

                ->get();


        return response()->json([

            'success' =>
                true,

            'data' =>
                $payments,

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Complete Sale
    |--------------------------------------------------------------------------
    */

    /**
     * Complete a POS sale.
     */
    public function completeSale(
        Request $request,
        int $id
    ): JsonResponse {

        if (! canAccess('pos.sell')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to complete sales.',

            ], 403);
        }


        $validated =
            $request->validate([

                'payment_method' => [
                    'required',
                    'string',
                ],

                'amount' => [
                    'required',
                    'numeric',
                    'gt:0',
                ],

                'reference_no' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'remarks' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],

            ]);


        try {

            $result =
                DB::transaction(

                    function () use (
                        $validated,
                        $id
                    ) {

                        $context =
                            $this->posContextOrFail();


                        $order =
                            Order::query()

                                ->where(
                                    'company_id',
                                    $this->companyId
                                )

                                ->where(
                                    'id',
                                    $id
                                )

                                ->with([
                                    'orderItems',
                                    'payments',
                                ])

                                ->lockForUpdate()

                                ->first();


                        if (! $order) {

                            throw ValidationException::withMessages([

                                'order' =>
                                    'Sale order not found.',

                            ]);
                        }


                        if (
                            $order->order_status ===
                            'Completed'
                        ) {

                            throw ValidationException::withMessages([

                                'order' =>
                                    'This sale has already been completed.',

                            ]);
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Payment Amount
                        |--------------------------------------------------------------------------
                        */

                        $receivedAmount =
                            (float) $validated['amount'];


                        $grandTotal =
                            (float) $order->grand_total;


                        if (
                            $validated['payment_method'] ===
                            'Cash'
                            && $receivedAmount < $grandTotal
                        ) {

                            throw ValidationException::withMessages([

                                'amount' =>
                                    'Cash received cannot be less than the sale total.',

                            ]);

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Change
                        |--------------------------------------------------------------------------
                        */

                        $change =
                            max(
                                0,
                                $receivedAmount
                                - $grandTotal
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | Payment
                        |--------------------------------------------------------------------------
                        */

                        $payment =
                            Payment::create([

                                'company_id' =>
                                    $this->companyId,

                                'branch_id' =>
                                    $context['assignment']->branch_id,

                                'terminal_id' =>
                                    $context['assignment']->terminal_id,

                                'order_id' =>
                                    $order->id,

                                'customer_id' =>
                                    $order->customer_id,

                                'received_by' =>
                                    auth()->id(),

                                'payment_method' =>
                                    $validated['payment_method'],

                                'amount' =>
                                    $grandTotal,

                                'reference_no' =>
                                    $validated['reference_no']
                                    ?? null,

                            ]);


                        /*
                        |--------------------------------------------------------------------------
                        | Cash Drawer
                        |--------------------------------------------------------------------------
                        */

                        $drawer =
                            $context['drawer'];


                        if (
                            $validated['payment_method'] ===
                            'Cash'
                        ) {

                            /*
                            |------------------------------------------------------------------
                            | Current Drawer Balance
                            |------------------------------------------------------------------
                            */

                            $drawer =
                                CashDrawer::query()

                                    ->where(
                                        'id',
                                        $drawer->id
                                    )

                                    ->lockForUpdate()

                                    ->first();


                            $balanceBefore =
                                (float) $drawer->expected_balance;


                            $balanceAfter =
                                $balanceBefore
                                + $grandTotal;


                            $drawer->cash_sales =
                                (float) $drawer->cash_sales
                                + $grandTotal;


                            $drawer->expected_balance =
                                $balanceAfter;


                            $drawer->save();


                            /*
                            |--------------------------------------------------------------------------
                            | Cash Drawer Transaction
                            |--------------------------------------------------------------------------
                            */

                            CashDrawerTransaction::create([

                                'company_id' =>
                                    $this->companyId,

                                'branch_id' =>
                                    $drawer->branch_id,

                                'terminal_id' =>
                                    $drawer->terminal_id,

                                'cash_drawer_id' =>
                                    $drawer->id,

                                'payment_id' =>
                                    $payment->id,

                                'order_id' =>
                                    $order->id,

                                'created_by' =>
                                    auth()->id(),

                                'transaction_type' =>
                                    'Sale',

                                'amount' =>
                                    $grandTotal,

                                'balance_before' =>
                                    $balanceBefore,

                                'balance_after' =>
                                    $balanceAfter,

                                'reference_no' =>
                                    $order->order_no,

                                'remarks' =>
                                    'Cash payment received for sales order: '
                                    . $order->order_no,

                            ]);

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Stock
                        |--------------------------------------------------------------------------
                        */

                        foreach (
                            $order->orderItems
                            as $orderItem
                        ) {

                            $stock =
                                ProductStock::query()

                                    ->where(
                                        'company_id',
                                        $this->companyId
                                    )

                                    ->where(
                                        'branch_id',
                                        $context['assignment']->branch_id
                                    )

                                    ->where(
                                        'product_id',
                                        $orderItem->product_id
                                    )

                                    ->lockForUpdate()

                                    ->first();


                            if ($stock) {

                                $quantity =
                                    (float) $orderItem->quantity;


                                $stock->quantity =
                                    max(
                                        0,
                                        (float) $stock->quantity
                                        - $quantity
                                    );


                                $stock->available_quantity =
                                    max(
                                        0,
                                        (float) $stock->available_quantity
                                        - $quantity
                                    );


                                $stock->save();

                            }

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Order
                        |--------------------------------------------------------------------------
                        */

                        $order->amount_paid =
                            $grandTotal;

                        $order->balance =
                            0;

                        $order->change_given =
                            $change;

                        $order->payment_status =
                            'Paid';

                        $order->order_status =
                            'Completed';

                        $order->completed_at =
                            now();

                        $order->updated_by =
                            auth()->id();

                        $order->save();


                        /*
                        |--------------------------------------------------------------------------
                        | Invoice
                        |--------------------------------------------------------------------------
                        */

                        $invoice =
                            Invoice::create([

                                'company_id' =>
                                    $this->companyId,

                                'branch_id' =>
                                    $context['assignment']->branch_id,

                                'terminal_id' =>
                                    $context['assignment']->terminal_id,

                                'order_id' =>
                                    $order->id,

                                'customer_id' =>
                                    $order->customer_id,

                            ]);


                        foreach (
                            $order->orderItems
                            as $orderItem
                        ) {

                            InvoiceItem::create([

                                'invoice_id' =>
                                    $invoice->id,

                                'product_id' =>
                                    $orderItem->product_id,

                                'description' =>
                                    $orderItem->product_name,

                                'quantity' =>
                                    $orderItem->quantity,

                                'unit_price' =>
                                    $orderItem->unit_price,

                                'discount' =>
                                    $orderItem->discount,

                                'tax' =>
                                    $orderItem->tax,

                                'total' =>
                                    $orderItem->total,

                            ]);

                        }


                        return [

                            'order' =>
                                $order->fresh([
                                    'customer',
                                    'orderItems',
                                    'payments',
                                    'invoice',
                                ]),

                            'payment' =>
                                $payment->fresh(),

                            'invoice' =>
                                $invoice->fresh([
                                    'invoiceItems',
                                ]),

                            'change' =>
                                $change,

                        ];

                    }

                );


            return response()->json([

                'success' =>
                    true,

                'message' =>
                    'Sale completed successfully.',

                'data' => [

                    'order' =>
                        $result['order'],

                    'payment' =>
                        $result['payment'],

                    'invoice' =>
                        $result['invoice'],

                    'change' =>
                        $result['change'],

                ],

            ]);


        } catch (ValidationException $e) {

            throw $e;


        } catch (\Throwable $e) {

            Log::error(

                'Failed to complete POS sale.',

                [

                    'company_id' =>
                        $this->companyId,

                    'user_id' =>
                        auth()->id(),

                    'order_id' =>
                        $id,

                    'error' =>
                        $e->getMessage(),

                ]

            );


            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Unable to complete sale. Please try again.',

            ], 500);

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Receipt
    |--------------------------------------------------------------------------
    */

    /**
     * Return receipt data for an order.
     */
    public function receipt(
        int $id
    ): JsonResponse {

        if (! canAccess('pos.sell')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view this receipt.',

            ], 403);
        }


        $order =
            Order::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'id',
                    $id
                )

                ->with([
                    'customer',
                    'branch',
                    'terminal',
                    'cashier',
                    'orderItems',
                    'payments',
                    'invoice',
                ])

                ->first();


        if (! $order) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Sale order not found.',

            ], 404);
        }


        return response()->json([

            'success' =>
                true,

            'data' =>
                $order,

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Invoice
    |--------------------------------------------------------------------------
    */

    /**
     * Return invoice data for an order.
     */
    public function invoice(
        int $id
    ): JsonResponse {

        if (! canAccess('pos.sell')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view invoices.',

            ], 403);
        }


        $invoice =
            Invoice::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'order_id',
                    $id
                )

                ->with([
                    'invoiceItems',
                    'order',
                    'customer',
                ])

                ->latest(
                    'id'
                )

                ->first();


        if (! $invoice) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Invoice not found.',

            ], 404);
        }


        return response()->json([

            'success' =>
                true,

            'data' =>
                $invoice,

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Return the current active terminal assignment.
     */
    protected function currentTerminalAssignment()
    {
        return TerminalAssignment::query()

            ->where(
                'company_id',
                $this->companyId
            )

            ->where(
                'user_id',
                auth()->id()
            )

            ->where(
                'status',
                'active'
            )

            ->with([
                'branch',
                'terminal',
            ])

            ->latest(
                'assigned_at'
            )

            ->first();
    }


    /**
     * Return current POS context or throw a validation exception.
     */
    protected function posContextOrFail(): array
    {
        $assignment =
            $this->currentTerminalAssignment();


        if (! $assignment) {

            throw ValidationException::withMessages([

                'terminal' =>
                    'No active terminal is assigned to the current user.',

            ]);

        }


        $drawer =
            CashDrawer::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'branch_id',
                    $assignment->branch_id
                )

                ->where(
                    'terminal_id',
                    $assignment->terminal_id
                )

                ->where(
                    'opened_by',
                    auth()->id()
                )

                ->where(
                    'status',
                    'open'
                )

                ->first();


        if (! $drawer) {

            throw ValidationException::withMessages([

                'cash_drawer' =>
                    'You must open your cash drawer before using the POS.',

            ]);

        }


        return [

            'assignment' =>
                $assignment,

            'drawer' =>
                $drawer,

        ];

    }

    /*
    |--------------------------------------------------------------------------
    | Sales History
    |--------------------------------------------------------------------------
    */

    /**
     * Return today's completed sales history.
     */
    public function salesHistory(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('pos.sell')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view sales history.',

            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | Current User
        |--------------------------------------------------------------------------
        */

        $user =
            auth()->user();


        /*
        |--------------------------------------------------------------------------
        | Role
        |--------------------------------------------------------------------------
        */

        $role =
            $user->role?->code;


        /*
        |--------------------------------------------------------------------------
        | Access Scope
        |--------------------------------------------------------------------------
        */

        $canManageAllBranches =
            in_array(
                $role,
                [
                    'owner',
                    'administrator',
                ],
                true
            );


        $currentBranchId =
            $user->branch_id;


        /*
        |--------------------------------------------------------------------------
        | Date
        |--------------------------------------------------------------------------
        */

        $startDate =
            now()->startOfDay();

        $endDate =
            now()->endOfDay();


        /*
        |--------------------------------------------------------------------------
        | Orders
        |--------------------------------------------------------------------------
        */

        $query =
            Order::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'order_status',
                    'Completed'
                )

                ->whereBetween(
                    'completed_at',
                    [
                        $startDate,
                        $endDate,
                    ]
                )

                ->with([
                    'customer',
                    'cashier',
                    'payments',
                ]);


        /*
        |--------------------------------------------------------------------------
        | Branch Scope
        |--------------------------------------------------------------------------
        */

        if (! $canManageAllBranches) {

            $query->where(
                'branch_id',
                $currentBranchId
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Cashier Scope
        |--------------------------------------------------------------------------
        |
        | Cashiers only see their own completed sales.
        |
        */

        if (
            ! $canManageAllBranches
            && $role === 'cashier'
        ) {

            $query->where(
                'cashier_id',
                $user->id
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        $search =
            trim(
                (string) $request->input(
                    'search',
                    ''
                )
            );


        if (
            $search !== ''
        ) {

            $query->where(

                function ($q) use (
                    $search
                ) {

                    $q

                        ->where(
                            'order_no',
                            'like',
                            '%' . $search . '%'
                        )

                        ->orWhereHas(
                            'customer',
                            function (
                                $customerQuery
                            ) use (
                                $search
                            ) {

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
        | Summary Query
        |--------------------------------------------------------------------------
        */

        $summaryOrders =
            clone $query;


        /*
        |--------------------------------------------------------------------------
        | Total Sales
        |--------------------------------------------------------------------------
        */

        $totalSales =
            (float) $summaryOrders
                ->sum(
                    'grand_total'
                );


        /*
        |--------------------------------------------------------------------------
        | Transaction Count
        |--------------------------------------------------------------------------
        */

        $transactionCount =
            (clone $summaryOrders)
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Average Sale
        |--------------------------------------------------------------------------
        */

        $averageSale =
            $transactionCount > 0

                ? $totalSales / $transactionCount

                : 0;


        /*
        |--------------------------------------------------------------------------
        | Payments
        |--------------------------------------------------------------------------
        */

        $orderIds =
            (clone $summaryOrders)
                ->pluck(
                    'id'
                );


        $payments =
            Payment::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->whereIn(
                    'order_id',
                    $orderIds
                )

                ->whereIn(
                    'payment_status',
                    [
                        'Completed',
                        'Paid',
                        'completed',
                        'paid',
                    ]
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | Payment Breakdown
        |--------------------------------------------------------------------------
        */

        $cashSales =
            (float) $payments
                ->where(
                    'payment_method',
                    'Cash'
                )
                ->sum(
                    'amount'
                );


        $cardSales =
            (float) $payments
                ->where(
                    'payment_method',
                    'Card'
                )
                ->sum(
                    'amount'
                );


        $transferSales =
            (float) $payments
                ->where(
                    'payment_method',
                    'Transfer'
                )
                ->sum(
                    'amount'
                );


        $walletSales =
            (float) $payments
                ->where(
                    'payment_method',
                    'Wallet'
                )
                ->sum(
                    'amount'
                );


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $sales =
            $query

                ->latest(
                    'completed_at'
                )

                ->paginate(
                    15
                );


        /*
        |--------------------------------------------------------------------------
        | Response Data
        |--------------------------------------------------------------------------
        */

        $data =
            collect(
                $sales->items()
            )
            ->map(
                function (
                    $order
                ) {

                    $cashier =
                        $order->cashier;


                    return [

                        'id' =>
                            $order->id,

                        'order_no' =>
                            $order->order_no,

                        'customer_name' =>
                            $order->customer

                                ? trim(
                                    ($order->customer->last_name ?? '')
                                    . ' '
                                    . ($order->customer->first_name ?? '')
                                )

                                : 'Walk-in Customer',

                        'cashier_name' =>
                            $cashier

                                ? trim(
                                    ($cashier->last_name ?? '')
                                    . ' '
                                    . ($cashier->first_name ?? '')
                                )

                                : '—',

                        'payment_method' =>
                            $order->payments
                                ->pluck(
                                    'payment_method'
                                )
                                ->unique()
                                ->implode(
                                    ', '
                                ),

                        'total' =>
                            (float) $order->grand_total,

                        'completed_at' =>
                            $order->completed_at
                                ?->toISOString(),

                    ];

                }
            )
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'summary' => [

                'total_sales' =>
                    $totalSales,

                'transaction_count' =>
                    $transactionCount,

                'average_sale' =>
                    (float) $averageSale,

                'cash_sales' =>
                    $cashSales,

                'card_sales' =>
                    $cardSales,

                'transfer_sales' =>
                    $transferSales,

                'wallet_sales' =>
                    $walletSales,

            ],

            'data' =>
                $data,

            'pagination' => [

                'current_page' =>
                    $sales->currentPage(),

                'last_page' =>
                    $sales->lastPage(),

                'per_page' =>
                    $sales->perPage(),

                'total' =>
                    $sales->total(),

            ],

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Approvers
    |--------------------------------------------------------------------------
    */

    /**
     * Return authorized POS adjustment approvers.
     */
    public function approvers(): JsonResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('pos.sell')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to load POS approvers.',

            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | Current POS Context
        |--------------------------------------------------------------------------
        */

        $assignment =
            $this->currentTerminalAssignment();


        if (! $assignment) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'No active terminal is assigned to the current user.',

            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | Authorized Roles
        |--------------------------------------------------------------------------
        */

        $allowedRoles = [

            'owner',
            'administrator',
            'branch_manager',
            'supervisor',

        ];


        /*
        |--------------------------------------------------------------------------
        | Approvers
        |--------------------------------------------------------------------------
        */

        $users =
    User::query()

        ->where(
            'company_id',
            $this->companyId
        )

        ->where(
            'id',
            '!=',
            auth()->id()
        )

        ->with(
            'role'
        )

        ->get([
            'id',
            'first_name',
            'last_name',
            'role_id',
            'branch_id',
        ]);


$data =
    $users

        ->filter(
            function ($user) use (
                $assignment,
                $allowedRoles
            ) {

                $role =
                    $user->role?->code;


                if (
                    ! in_array(
                        $role,
                        $allowedRoles,
                        true
                    )
                ) {

                    return false;

                }


                if (
                    in_array(
                        $role,
                        [
                            'owner',
                            'administrator',
                        ],
                        true
                    )
                ) {

                    return true;

                }


                return (int) $user->branch_id
                    ===
                    (int) $assignment->branch_id;

            }
        )

        ->map(
            function ($user) {

                return [

                    'id' =>
                        $user->id,

                    'name' =>
                        trim(
                            ($user->last_name ?? '')
                            . ' '
                            . ($user->first_name ?? '')
                        ),

                    'role' =>
                        $user->role?->code,

                ];

            }
        )

        ->values();

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'data' =>
                $data,

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Adjustment Approval
    |--------------------------------------------------------------------------
    */

    /**
     * Verify an authorized user before applying a POS adjustment.
     */
    public function approveAdjustment(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('pos.sell')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to request POS adjustment approval.',

            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([

                'approver_id' => [
                    'required',
                    'integer',
                ],

                'password' => [
                    'required',
                    'string',
                ],

                'action' => [
                    'required',
                    'string',
                    'in:discount,tax',
                ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | Current POS Context
        |--------------------------------------------------------------------------
        */

        $assignment =
            $this->currentTerminalAssignment();


        if (! $assignment) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'No active terminal is assigned to the current user.',

            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | Current User
        |--------------------------------------------------------------------------
        */

        $user =
            auth()->user();


        /*
        |--------------------------------------------------------------------------
        | Approver
        |--------------------------------------------------------------------------
        */

        $approver =
            \App\Models\User::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'id',
                    $validated['approver_id']
                )

                ->first();


        if (! $approver) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'The selected approver could not be found.',

            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | Approver Role
        |--------------------------------------------------------------------------
        */

        $approverRole =
            $approver->role?->code;


        $allowedRoles = [

            'owner',
            'administrator',
            'branch_manager',
            'supervisor',

        ];


        if (
            ! in_array(
                $approverRole,
                $allowedRoles,
                true
            )
        ) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'The selected user is not authorized to approve POS adjustments.',

            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Self Approval
        |--------------------------------------------------------------------------
        */

        if (
            (int) $approver->id
            ===
            (int) $user->id
        ) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You cannot approve your own POS adjustment.',

            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | Branch Scope
        |--------------------------------------------------------------------------
        */

        if (
            in_array(
                $approverRole,
                [
                    'branch_manager',
                    'supervisor',
                ],
                true
            )
        ) {

            if (
                (int) $approver->branch_id
                !==
                (int) $assignment->branch_id
            ) {

                return response()->json([

                    'success' =>
                        false,

                    'message' =>
                        'The selected approver is not authorized for this terminal branch.',

                ], 403);
            }

        }


        /*
        |--------------------------------------------------------------------------
        | Password Verification
        |--------------------------------------------------------------------------
        */

        if (
            ! \Illuminate\Support\Facades\Hash::check(
                $validated['password'],
                $approver->password
            )
        ) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'The approver password is incorrect.',

            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | Approval
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'message' =>
                'Adjustment approved successfully.',

            'data' => [

                'approver_id' =>
                    $approver->id,

                'approver_name' =>
                    trim(
                        ($approver->last_name ?? '')
                        . ' '
                        . ($approver->first_name ?? '')
                    ),

                'approver_role' =>
                    $approverRole,

                'action' =>
                    $validated['action'],

            ],

        ]);

    }
}