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
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\TaxRate;
use App\Models\User;
use App\Models\StockMovement;
use App\Models\TerminalAssignment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Services\ActivityLogger;
use App\Services\DocumentNumberService;

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

    /**
     * Return the current POS context for internal operations.     *
    
     */
    protected function posContextOrFail(): array
    {
        /*
        |--------------------------------------------------------------------------
        | User
        |--------------------------------------------------------------------------
        */

        $user =
            auth()->user();


        /*
        |--------------------------------------------------------------------------
        | Terminal Assignment
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


        if (! $terminalAssignment) {

            abort(
                422,
                'No active terminal is assigned to the current user.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Branch
        |--------------------------------------------------------------------------
        */

        $branch =
            $terminalAssignment->branch;


        if (! $branch) {

            abort(
                422,
                'The assigned terminal branch could not be found.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Terminal
        |--------------------------------------------------------------------------
        */

        $terminal =
            $terminalAssignment->terminal;


        if (! $terminal) {

            abort(
                422,
                'The assigned terminal could not be found.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Cash Drawer
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


        if (! $drawer) {

            abort(
                422,
                'You must open your cash drawer before completing a sale.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Return Context
        |--------------------------------------------------------------------------
        */

        return [

            'user' =>
                $user,

            'assignment' =>
                $terminalAssignment,

            'branch' =>
                $branch,

            'terminal' =>
                $terminal,

            'drawer' =>
                $drawer,

        ];

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


    /**
     * Store and complete a POS sale.
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

                'status' => false,

                'message' => 'You do not have permission to complete sales.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'customer_id' => [
                'nullable',
                'integer',
            ],

            'discount_id' => [
                'nullable',
                'integer',
            ],

            'tax_rate_id' => [
                'nullable',
                'integer',
            ],

            'discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'tax' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'subtotal' => [
                'required',
                'numeric',
                'min:0',
            ],

            'total' => [
                'required',
                'numeric',
                'min:0',
            ],

            'grand_total' => [
                'required',
                'numeric',
                'min:0',
            ],

            'total_items' => [
                'required',
                'integer',
                'min:1',
            ],

            'total_quantity' => [
                'required',
                'numeric',
                'min:1',
            ],

            'payment_method' => [
                'required',
                'string',
                'max:50',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0',
            ],

            'reference_no' => [
                'nullable',
                'string',
                'max:100',
            ],

            'remarks' => [
                'nullable',
                'string',
                'max:1000',
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

            'items.*.discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'items.*.tax' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'items.*.total' => [
                'required',
                'numeric',
                'min:0',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Complete Sale
        |--------------------------------------------------------------------------
        */

        try {

            $result = DB::transaction(function () use (
                $validated
            ) {

                /*
                |--------------------------------------------------------------------------
                | POS Context
                |--------------------------------------------------------------------------
                */

                $context = $this->posContextOrFail();


                $companyId =
                    $this->companyId;

                $branch =
                    $context['branch'];

                $terminal =
                    $context['terminal'];

                $drawer =
                    $context['drawer'];


                /*
                |--------------------------------------------------------------------------
                | Payment
                |--------------------------------------------------------------------------
                */

                $paymentMethod =
                    $validated['payment_method'];

                $receivedAmount =
                    (float) $validated['amount'];

                $grandTotal =
                    round(
                        (float) $validated['grand_total'],
                        2
                    );


                if ($grandTotal < 0) {

                    throw ValidationException::withMessages([

                        'grand_total' => [
                            'Invalid sale total.',
                        ],

                    ]);

                }


                if (
                    $paymentMethod === 'Cash'
                    && $receivedAmount < $grandTotal
                ) {

                    throw ValidationException::withMessages([

                        'amount' => [
                            'Amount received is less than the sale total.',
                        ],

                    ]);

                }


                /*
                |--------------------------------------------------------------------------
                | Change
                |--------------------------------------------------------------------------
                */

                $changeGiven =
                    $paymentMethod === 'Cash'
                        ? round(
                            max(
                                0,
                                $receivedAmount - $grandTotal
                            ),
                            2
                        )
                        : 0;


                /*
                |--------------------------------------------------------------------------
                | Customer
                |--------------------------------------------------------------------------
                */

                $customerId =
                    $validated['customer_id'] ?? null;

                if ($customerId) {

                    $customerExists =
                        Customer::query()
                            ->where('company_id', $companyId)
                            ->whereKey($customerId)
                            ->exists();

                    if (! $customerExists) {

                        throw ValidationException::withMessages([

                            'customer_id' => [
                                'The selected customer is invalid.',
                            ],

                        ]);

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | Prepare / Lock Stock
                |--------------------------------------------------------------------------
                */

                $preparedItems = [];

                foreach ($validated['items'] as $item) {

                    $product =
                        Product::query()
                            ->where('company_id', $companyId)
                            ->whereKey($item['product_id'])
                            ->where('status', 1)
                            ->first();

                    if (! $product) {

                        throw ValidationException::withMessages([

                            'items' => [
                                'One or more selected products are invalid or inactive.',
                            ],

                        ]);

                    }


                    $quantity =
                        (float) $item['quantity'];


                    /*
                    |--------------------------------------------------------------------------
                    | Lock Product Stock
                    |--------------------------------------------------------------------------
                    */

                    $stock =
                        ProductStock::query()
                            ->where('company_id', $companyId)
                            ->where('branch_id', $branch->id)
                            ->where('product_id', $product->id)
                            ->lockForUpdate()
                            ->first();

                    if (! $stock) {

                        throw ValidationException::withMessages([

                            'items' => [
                                "No stock record exists for {$product->name}.",
                            ],

                        ]);

                    }


                    if (
                        (float) $stock->available_quantity
                        < $quantity
                    ) {

                        throw ValidationException::withMessages([

                            'items' => [
                                "Insufficient stock for {$product->name}.",
                            ],

                        ]);

                    }


                    $preparedItems[] = [

                        'product' => $product,

                        'stock' => $stock,

                        'quantity' => $quantity,

                        'unit_price' =>
                            round(
                                (float) $item['unit_price'],
                                2
                            ),

                        'discount' =>
                            round(
                                (float) ($item['discount'] ?? 0),
                                2
                            ),

                        'tax' =>
                            round(
                                (float) ($item['tax'] ?? 0),
                                2
                            ),

                        'total' =>
                            round(
                                (float) $item['total'],
                                2
                            ),

                    ];

                }


                /*
                |--------------------------------------------------------------------------
                | Order Number
                |--------------------------------------------------------------------------
                */

                $orderNumber =
                    DocumentNumberService::generate(
                        'Order',
                        $companyId
                    );


                /*
                |--------------------------------------------------------------------------
                | Create Order
                |--------------------------------------------------------------------------
                */

                $order =
                    Order::query()->create([

                        'company_id' =>
                            $companyId,

                        'branch_id' =>
                            $branch->id,

                        'terminal_id' =>
                            $terminal->id,

                        'customer_id' =>
                            $customerId,

                        'cashier_id' =>
                            auth()->id(),

                        'order_no' =>
                            $orderNumber,

                        'subtotal' =>
                            round(
                                (float) $validated['subtotal'],
                                2
                            ),

                        'discount' =>
                            round(
                                (float) ($validated['discount'] ?? 0),
                                2
                            ),

                        'discount_id' =>
                            $validated['discount_id'] ?? null,

                        'tax_rate_id' =>
                            $validated['tax_rate_id'] ?? null,

                        'tax' =>
                            round(
                                (float) ($validated['tax'] ?? 0),
                                2
                            ),

                        'total' =>
                            round(
                                (float) $validated['total'],
                                2
                            ),

                        'amount_paid' =>
                            $grandTotal,

                        'balance' =>
                            0,

                        'total_items' =>
                            $validated['total_items'],

                        'total_quantity' =>
                            round(
                                (float) $validated['total_quantity'],
                                2
                            ),

                        'change_given' =>
                            $changeGiven,

                        'grand_total' =>
                            $grandTotal,

                        'completed_at' =>
                            now(),

                        'payment_status' =>
                            'Paid',

                        'order_status' =>
                            'Completed',

                        'sales_channel' =>
                            'POS',

                        'receipt_printed' =>
                            false,

                        'remarks' =>
                            $validated['remarks'] ?? null,

                        'created_by' =>
                            auth()->id(),

                        'updated_by' =>
                            auth()->id(),

                    ]);


                /*
                |--------------------------------------------------------------------------
                | Order Items
                |--------------------------------------------------------------------------
                */

                foreach ($preparedItems as $item) {

                    $product =
                        $item['product'];

                    OrderItem::query()->create([

                        'company_id' =>
                            $companyId,

                        'order_id' =>
                            $order->id,

                        'product_id' =>
                            $product->id,

                        'product_name' =>
                            $product->name,

                        'product_barcode' =>
                            $product->barcode,

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


                /*
                |--------------------------------------------------------------------------
                | Invoice Number
                |--------------------------------------------------------------------------
                */

                $invoiceNumber =
                    DocumentNumberService::generate(
                        'Invoice',
                        $companyId
                    );


                /*
                |--------------------------------------------------------------------------
                | Create Invoice
                |--------------------------------------------------------------------------
                */

                $invoice =
                    Invoice::query()->create([

                        'company_id' =>
                            $companyId,

                        'branch_id' =>
                            $branch->id,

                        'terminal_id' =>
                            $terminal->id,

                        'order_id' =>
                            $order->id,

                        'customer_id' =>
                            $customerId,

                        'invoice_no' =>
                            $invoiceNumber,

                        'invoice_date' =>
                            today(),

                        'subtotal' =>
                            $order->subtotal,

                        'discount' =>
                            $order->discount,

                        'tax' =>
                            $order->tax,

                        'total' =>
                            $order->total,

                        'amount_paid' =>
                            $grandTotal,

                        'balance' =>
                            0,

                        'total_quantity' =>
                            $order->total_quantity,

                        'total_items' =>
                            $order->total_items,

                        'grand_total' =>
                            $grandTotal,

                        'payment_status' =>
                            'Paid',

                        'invoice_status' =>
                            'Active',

                        'remarks' =>
                            $validated['remarks'] ?? null,

                        'created_by' =>
                            auth()->id(),

                        'updated_by' =>
                            auth()->id(),

                    ]);


                /*
                |--------------------------------------------------------------------------
                | Invoice Items
                |--------------------------------------------------------------------------
                */

                foreach ($preparedItems as $item) {

                    $product =
                        $item['product'];

                    InvoiceItem::query()->create([

                        'company_id' =>
                            $companyId,

                        'invoice_id' =>
                            $invoice->id,

                        'product_id' =>
                            $product->id,

                        'product_name' =>
                            $product->name,

                        'product_barcode' =>
                            $product->barcode,

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

                $paymentMethod =
                    PaymentMethod::query()
                        ->where('company_id', $this->companyId)
                        ->where('name', $validated['payment_method'])
                        ->active()
                        ->first();

                if (! $paymentMethod) {

                    throw ValidationException::withMessages([
                        'payment_method' =>
                            'The selected payment method is invalid or inactive.',
                    ]);
                }

                $paymentNumber = DocumentNumberService::generate(
                    'Payment',
                    $this->companyId
                );


                /*
                |--------------------------------------------------------------------------
                | Payment
                |--------------------------------------------------------------------------
                */

                $payment =
                    Payment::query()->create([

                        'company_id' =>
                            $companyId,

                        'branch_id' =>
                            $branch->id,

                        'terminal_id' =>
                            $terminal->id,

                        'order_id' =>
                            $order->id,

                        'customer_id' =>
                            $customerId,

                        'received_by' =>
                            auth()->id(),

                        'payment_method_id' => 
                            $paymentMethod->id,

                        'payment_method' =>
                            $paymentMethod->name,

                        'payment_number'  => 
                            $paymentNumber,

                        'amount' =>
                            $grandTotal,

                        'reference_no' =>
                            $validated['reference_no'] ?? null,

                        'payment_status' =>
                            'Completed',

                        'payment_date' =>
                            now(),

                        'remarks' =>
                            $validated['remarks'] ?? null,

                    ]);


                /*
                |--------------------------------------------------------------------------
                | Cash Drawer
                |--------------------------------------------------------------------------
                */

                if ($paymentMethod === 'Cash') {

                    $lockedDrawer =
                        CashDrawer::query()
                            ->where('company_id', $companyId)
                            ->where('branch_id', $branch->id)
                            ->where('terminal_id', $terminal->id)
                            ->where('status', 'Open')
                            ->whereKey($drawer->id)
                            ->lockForUpdate()
                            ->first();

                    if (! $lockedDrawer) {

                        throw ValidationException::withMessages([

                            'payment_method' => [
                                'The active cash drawer is no longer available.',
                            ],

                        ]);

                    }


                    $balanceBefore =
                        round(
                            (float) $lockedDrawer->expected_balance,
                            2
                        );

                    $balanceAfter =
                        round(
                            $balanceBefore + $grandTotal,
                            2
                        );


                    $lockedDrawer->cash_sales =
                        round(
                            (float) $lockedDrawer->cash_sales
                            + $grandTotal,
                            2
                        );

                    $lockedDrawer->expected_balance =
                        $balanceAfter;

                    $lockedDrawer->save();


                    CashDrawerTransaction::query()->create([

                        'company_id' =>
                            $companyId,

                        'branch_id' =>
                            $branch->id,

                        'terminal_id' =>
                            $terminal->id,

                        'cash_drawer_id' =>
                            $lockedDrawer->id,

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
                            $validated['remarks'] ?? null,

                    ]);

                }


                /*
                |--------------------------------------------------------------------------
                | Deduct Stock + Create Stock Movements
                |--------------------------------------------------------------------------
                */

                foreach ($preparedItems as $item) {

                    $product =
                        $item['product'];

                    $stock =
                        $item['stock'];

                    $stockBefore =
                        round(
                            (float) $stock->quantity,
                            2
                        );

                    $stock->quantity =
                        round(
                            $stockBefore - $item['quantity'],
                            2
                        );

                    $stock->available_quantity =
                        max(
                            0,
                            round(
                                (float) $stock->quantity
                                - (float) $stock->reserved_quantity,
                                2
                            )
                        );

                    $stock->save();


                    StockMovement::query()->create([

                        'company_id' =>
                            $companyId,

                        'branch_id' =>
                            $branch->id,

                        'product_id' =>
                            $product->id,

                        'order_id' =>
                            $order->id,

                        'reference_no' =>
                            $order->order_no,

                        'unit_cost' =>
                            $product->cost_price ?? 0,

                        'quantity' =>
                            $item['quantity'],

                        'balance_after' =>
                            $stock->quantity,

                        'remarks' =>
                            'POS Sale',

                        'created_by' =>
                            auth()->id(),

                        'movement_type' =>
                            'Sale',

                        'stock_before' =>
                            $stockBefore,

                    ]);

                }


                /*
                |--------------------------------------------------------------------------
                | Return Result
                |--------------------------------------------------------------------------
                */

                return [

                    'order' =>
                        $order->fresh([
                            'orderItems',
                            'payments',
                            'invoice',
                        ]),

                    'payment' =>
                        $payment,

                    'invoice' =>
                        $invoice->fresh([
                            'invoiceItems',
                        ]),

                    'change' =>
                        $changeGiven,

                ];

            });


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'pos',

                'sale_completed',

                "POS sale {$result['order']->order_no} completed.",

                $result['order'],

                null,

                $result['order']->toArray()

            );


            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'status' =>
                    true,

                'message' =>
                    'Sale completed successfully.',

                'data' =>
                    $result,

            ]);

        } catch (ValidationException $e) {

            throw $e;

        } catch (Throwable $e) {

            report($e);

            return response()->json([

                'status' =>
                    false,

                'message' =>
                    'The sale could not be completed. Nothing was saved.',

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