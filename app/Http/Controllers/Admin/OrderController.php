<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Terminal;
use App\Models\Setting;
use App\Models\StockMovement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\CustomerGroup;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use App\Services\DocumentNumberService;
use Barryvdh\DomPDF\Facade\Pdf;


class OrderController extends BaseController
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
     * Display Sales Orders.
     */
    public function index()
    {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('orders.view')) {

            abort(
                403,
                'You do not have permission to view sales orders.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Company
        |--------------------------------------------------------------------------
        */

        $company =
            $this->company;


        $companyId =
            $this->companyId;


        /*
        |--------------------------------------------------------------------------
        | Branches
        |--------------------------------------------------------------------------
        */

        $branches =
            Branch::query()
                ->where(
                    'company_id',
                    $companyId
                )
                ->orderBy(
                    'name'
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | Customers
        |--------------------------------------------------------------------------
        */

        $customers =
            Customer::query()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'status',
                    true
                )
                ->orderBy(
                    'first_name'
                )
                ->orderBy(
                    'last_name'
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | Terminals
        |--------------------------------------------------------------------------
        */

        $terminals =
            Terminal::query()
                ->where(
                    'company_id',
                    $companyId
                )
                ->orderBy(
                    'terminal_name'
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view(
            'sales.orders.index',
            compact(
                'company',
                'branches',
                'customers',
                'terminals'
            )
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Orders Table
    |--------------------------------------------------------------------------
    */

    /**
     * Return Sales Orders table.
     */
    public function ordersTable(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('orders.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view sales orders.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */

        $query =
            Order::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->with([
                    'customer',
                    'branch',
                    'terminal',
                    'cashier',
                    'createdBy',
                    'updatedBy',
                ]);


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('search')
        ) {

            $search =
                trim(
                    $request->search
                );


            $query->where(
                function ($q) use ($search) {

                    /*
                    |----------------------------------------------------------
                    | Order Number
                    |----------------------------------------------------------
                    */

                    $q->where(
                        'order_no',
                        'like',
                        "%{$search}%"
                    );


                    /*
                    |----------------------------------------------------------
                    | Customer
                    |----------------------------------------------------------
                    */

                    $q->orWhereHas(
                        'customer',
                        function ($customer) use (
                            $search
                        ) {

                            $customer->where(
                                'company_id',
                                $this->companyId
                            );


                            $customer->where(
                                function ($q) use (
                                    $search
                                ) {

                                    $q->where(
                                        'customer_code',
                                        'like',
                                        "%{$search}%"
                                    );

                                    $q->orWhere(
                                        'first_name',
                                        'like',
                                        "%{$search}%"
                                    );

                                    $q->orWhere(
                                        'last_name',
                                        'like',
                                        "%{$search}%"
                                    );

                                    $q->orWhereRaw(
                                        "CONCAT(first_name, ' ', last_name) LIKE ?",
                                        [
                                            "%{$search}%"
                                        ]
                                    );

                                }
                            );

                        }
                    );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Customer
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('customer_id')
        ) {

            $query->where(
                'customer_id',
                $request->customer_id
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Branch
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('branch_id')
        ) {

            $query->where(
                'branch_id',
                $request->branch_id
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Order Status
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('order_status')
        ) {

            $query->where(
                'order_status',
                $request->order_status
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Payment Status
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('payment_status')
        ) {

            $query->where(
                'payment_status',
                $request->payment_status
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Date From
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('date_from')
        ) {

            $query->whereDate(
                'created_at',
                '>=',
                $request->date_from
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Date To
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('date_to')
        ) {

            $query->whereDate(
                'created_at',
                '<=',
                $request->date_to
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $orders =
            $query
                ->latest('id')
                ->paginate(15)
                ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Table
        |--------------------------------------------------------------------------
        */

        $html =
            view(
                'sales.orders.partials.table',
                compact(
                    'orders'
                )
            )->render();


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $statsQuery =
            Order::query()
                ->where(
                    'company_id',
                    $this->companyId
                );


        $total =
            (clone $statsQuery)
                ->count();


        $draft =
            (clone $statsQuery)
                ->where(
                    'order_status',
                    'Draft'
                )
                ->count();


        $completed =
            (clone $statsQuery)
                ->where(
                    'order_status',
                    'Completed'
                )
                ->count();


        $salesValue =
            (clone $statsQuery)
                ->where(
                    'order_status',
                    'Completed'
                )
                ->sum(
                    'grand_total'
                );


        $stats = [

            'total' =>
                $total,

            'draft' =>
                $draft,

            'completed' =>
                $completed,

            'sales_value' =>
                (float) $salesValue,

        ];


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'html' =>
                $html,

            'pagination' =>
                $orders
                    ->links()
                    ->render(),

            'stats' =>
                $stats,

        ]);

    }


   /*
    |--------------------------------------------------------------------------
    | Order Details
    |--------------------------------------------------------------------------
    */

    /**
     * Return Sales Order details.
     */
    public function orderDetails(
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('orders.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view sales orders.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Query
        |--------------------------------------------------------------------------
        */

        $orderQuery =
            Order::query()
                ->where(
                    'company_id',
                    $this->companyId
                );


        if (
            ! canManageAllBranches()
        ) {

            $orderQuery->where(
                'branch_id',
                currentBranchId()
            );

        }


        $order =
            $orderQuery
                ->with([

                'customer',

                'branch',

                'terminal',

                'cashier',

                'createdBy',

                'updatedBy',

                'orderItems.product',


                ])
                ->find(
                    $id
                );


        if (!$order) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Sales order not found.',

            ], 404);

        }


        return response()->json([

            'success' =>
                true,

            'data' => [

                'id' =>
                    $order->id,

                'order_no' =>
                    $order->order_no,

                'customer' => $order->customer
                    ? [
                        'id' =>
                            $order->customer->id,

                        'name' =>
                            $order->customer->displayName(),

                        'code' =>
                            $order->customer->customer_code,
                    ]
                    : null,

                'branch' => $order->branch
                    ? [
                        'id' =>
                            $order->branch->id,

                        'name' =>
                            $order->branch->name,
                    ]
                    : null,

                'terminal' => $order->terminal
                    ? [
                        'id' =>
                            $order->terminal->id,

                        'name' =>
                            $order->terminal->displayName(),
                    ]
                    : null,

                'cashier' => $order->cashier
                    ? [
                        'id' =>
                            $order->cashier->id,

                        'name' =>
                            $order->cashier->name
                                ?? trim(
                                    $order->cashier->first_name .
                                    ' ' .
                                    ($order->cashier->last_name ?? '')
                                ),
                    ]
                    : null,

                'subtotal' =>
                    (float) $order->subtotal,

                'discount' =>
                    (float) $order->discount,

                'tax' =>
                    (float) $order->tax,

                'total' =>
                    (float) $order->total,

                'amount_paid' =>
                    (float) $order->amount_paid,

                'balance' =>
                    (float) $order->balance,

                'change_given' =>
                    (float) $order->change_given,

                'grand_total' =>
                    (float) $order->grand_total,

                'total_items' =>
                    (int) $order->total_items,

                'total_quantity' =>
                    (float) $order->total_quantity,

                'payment_status' =>
                    $order->payment_status,

                'order_status' =>
                    $order->order_status,

                'sales_channel' =>
                    $order->sales_channel,

                'receipt_printed' =>
                    (bool) $order->receipt_printed,

                'remarks' =>
                    $order->remarks,
                
                    'created_by' => $order->createdBy
                    ? [
                        'id' =>
                            $order->createdBy->id,

                        'name' =>
                            $order->createdBy->name
                                ?? trim(
                                    $order->createdBy->first_name .
                                    ' ' .
                                    ($order->createdBy->last_name ?? '')
                                ),
                    ]
                    : null,


                'updated_by' => $order->updatedBy
                    ? [
                        'id' =>
                            $order->updatedBy->id,

                        'name' =>
                            $order->updatedBy->name
                                ?? trim(
                                    $order->updatedBy->first_name .
                                    ' ' .
                                    ($order->updatedBy->last_name ?? '')
                                ),
                    ]
                    : null,


                'created_at' =>
                    $order->created_at,


                'updated_at' =>
                    $order->updated_at,


                'completed_at' =>
                    $order->completed_at,                

                'items' =>
                    $order->orderItems
                        ->map(
                            function ($item) {

                                return [

                                    'id' =>
                                        $item->id,

                                    'product_id' =>
                                        $item->product_id,

                                    'product_name' =>
                                        $item->product_name,

                                    'product_barcode' =>
                                        $item->product_barcode,

                                    'quantity' =>
                                        (float) $item->quantity,

                                    'unit_price' =>
                                        (float) $item->unit_price,

                                    'discount' =>
                                        (float) $item->discount,

                                    'tax' =>
                                        (float) $item->tax,

                                    'total' =>
                                        (float) $item->total,

                                ];

                            }
                        )
                        ->values(),

            ],

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Customers
    |--------------------------------------------------------------------------
    */

    /**
     * Return customers for Sales Orders.
     */
    public function customers(): JsonResponse
    {

        if (! canAccess('orders.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view customers.',

            ], 403);

        }


        $customers =
            Customer::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->where(
                    'status',
                    true
                )
                ->orderBy(
                    'first_name'
                )
                ->orderBy(
                    'last_name'
                )
                ->get();


        return response()->json([

            'success' =>
                true,

            'data' =>
                $customers->map(
                    function ($customer) {

                        return [

                            'id' =>
                                $customer->id,

                            'name' =>
                                $customer->displayName(),

                            'customer_code' =>
                                $customer->customer_code,

                        ];

                    }
                )->values(),

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Branches
    |--------------------------------------------------------------------------
    */

    /**
     * Return branches for Sales Orders.
     */
    public function branches(): JsonResponse
    {

        if (! canAccess('orders.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view branches.',

            ], 403);

        }


        $branches =
            Branch::query()
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
                $branches,

        ]);

    }


   /*
    |--------------------------------------------------------------------------
    | Products
    |--------------------------------------------------------------------------
    */

    /**
     * Return active products available in the selected branch.
     */
    public function products(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('orders.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view products.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Validate Branch
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([

                'branch_id' => [

                    'required',

                    'integer',

                ],

                'search' => [

                    'nullable',

                    'string',

                    'max:100',

                ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | Branch Access
        |--------------------------------------------------------------------------
        */

        $branchQuery =
            Branch::query()
                ->where(
                    'company_id',
                    $this->companyId
                );


        if (
            ! canManageAllBranches()
        ) {

            $branchQuery->where(
                'id',
                currentBranchId()
            );

        }


        $branch =
            $branchQuery->find(
                $validated['branch_id']
            );


        if (!$branch) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Selected branch is invalid or unavailable.',

            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        $search =
            trim(
                $validated['search'] ?? ''
            );


        /*
        |--------------------------------------------------------------------------
        | Branch Stock
        |--------------------------------------------------------------------------
        */

        $stockQuery =
            ProductStock::query()
                ->where(
                    'product_stocks.company_id',
                    $this->companyId
                )
                ->where(
                    'product_stocks.branch_id',
                    $branch->id
                )
                ->where(
                    'product_stocks.available_quantity',
                    '>',
                    0
                )
                ->with([
                    'product',
                ]);


        if ($search !== '') {

            $stockQuery->whereHas(
                'product',
                function ($query) use (
                    $search
                ) {

                    $query
                        ->where(
                            'company_id',
                            $this->companyId
                        )
                        ->where(
                            'status',
                            true
                        )
                        ->where(
                            function ($query) use (
                                $search
                            ) {

                                $query
                                    ->where(
                                        'name',
                                        'like',
                                        '%' . $search . '%'
                                    )
                                    ->orWhere(
                                        'product_code',
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
                                    );

                            }
                        );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Get Results
        |--------------------------------------------------------------------------
        */

        $stocks =
            $stockQuery
                ->latest(
                    'product_stocks.id'
                )
                ->limit(20)
                ->get();


        /*
        |--------------------------------------------------------------------------
        | No Products
        |--------------------------------------------------------------------------
        */

        if (
            $stocks->isEmpty()
        ) {

            return response()->json([

                'success' =>
                    true,

                'data' =>
                    [],

                'message' =>
                    $search !== ''
                        ? 'No products with available stock were found in the selected branch.'
                        : 'No products with available stock are currently available in the selected branch.',

            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'data' =>
                $stocks->map(
                    function ($stock) {

                        $product =
                            $stock->product;


                        return [

                            'id' =>
                                $product->id,

                            'product_id' =>
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
                                (float)
                                $product->selling_price,

                            'available_quantity' =>
                                (float)
                                $stock->available_quantity,

                            'stock_id' =>
                                $stock->id,

                        ];

                    }
                )->values(),

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Store Order
    |--------------------------------------------------------------------------
    */

    /**
     * Store Sales Order.
     */
    public function storeOrder(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('orders.create')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to create sales orders.',

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

                'branch_id' => [
                    'required',
                    'integer',
                ],

                'terminal_id' => [
                    'nullable',
                    'integer',
                ],

                'sales_channel' => [
                    'required',
                    'in:POS,Online,Phone',
                ],

                'remarks' => [
                    'nullable',
                    'string',
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
                    'gte:0',
                ],

                'items.*.discount_amount' => [
                    'nullable',
                    'numeric',
                    'gte:0',
                ],

                'items.*.tax_amount' => [
                    'nullable',
                    'numeric',
                    'gte:0',
                ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | Transaction
        |--------------------------------------------------------------------------
        */

        try {

            $order =
                DB::transaction(
                    function () use (
                        $validated
                    ) {

                        /*
                        |--------------------------------------------------------------------------
                        | Branch
                        |--------------------------------------------------------------------------
                        */

                        $branch =
                            Branch::query()
                                ->where(
                                    'company_id',
                                    $this->companyId
                                )
                                ->find(
                                    $validated['branch_id']
                                );


                        if (!$branch) {

                            throw ValidationException::withMessages([

                                'branch_id' =>
                                    'The selected branch is invalid.',

                            ]);

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Customer
                        |--------------------------------------------------------------------------
                        */

                        $customer = null;


                        if (
                            !empty(
                                $validated['customer_id']
                            )
                        ) {

                            $customer =
                                Customer::query()
                                    ->where(
                                        'company_id',
                                        $this->companyId
                                    )
                                    ->where(
                                        'status',
                                        true
                                    )
                                    ->find(
                                        $validated['customer_id']
                                    );


                            if (!$customer) {

                                throw ValidationException::withMessages([

                                    'customer_id' =>
                                        'The selected customer is invalid.',

                                ]);

                            }

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Terminal
                        |--------------------------------------------------------------------------
                        */

                        $terminal = null;


                        if (
                            !empty(
                                $validated['terminal_id']
                            )
                        ) {

                            $terminal =
                                Terminal::query()
                                    ->where(
                                        'company_id',
                                        $this->companyId
                                    )
                                    ->where(
                                        'branch_id',
                                        $validated['branch_id']
                                    )
                                    ->find(
                                        $validated['terminal_id']
                                    );


                            if (!$terminal) {

                                throw ValidationException::withMessages([

                                    'terminal_id' =>
                                        'The selected terminal is invalid for this branch.',

                                ]);

                            }

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Prepare Items
                        |--------------------------------------------------------------------------
                        */

                        $orderItems =
                            [];

                        $subtotal =
                            0;

                        $discountTotal =
                            0;

                        $taxTotal =
                            0;

                        $totalQuantity =
                            0;


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
                                        'status',
                                        true
                                    )
                                    ->find(
                                        $item['product_id']
                                    );


                            if (!$product) {

                                throw ValidationException::withMessages([

                                    'items' =>
                                        'One or more selected products are invalid.',

                                ]);

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Values
                            |--------------------------------------------------------------------------
                            */

                            $quantity =
                                (float)
                                $item['quantity'];


                            $unitPrice =
                                (float)
                                $item['unit_price'];


                            $discount =
                                (float)
                                (
                                    $item['discount_amount']
                                    ?? 0
                                );


                            $tax =
                                (float)
                                (
                                    $item['tax_amount']
                                    ?? 0
                                );


                            /*
                            |--------------------------------------------------------------------------
                            | Gross Line Amount
                            |--------------------------------------------------------------------------
                            */

                            $gross =
                                $quantity *
                                $unitPrice;


                            /*
                            |--------------------------------------------------------------------------
                            | Discount Validation
                            |--------------------------------------------------------------------------
                            */

                            if (
                                $discount >
                                $gross
                            ) {

                                throw ValidationException::withMessages([

                                    'items' =>
                                        sprintf(
                                            'Discount for %s cannot exceed the line amount.',
                                            $product->name
                                        ),

                                ]);

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Line Total
                            |--------------------------------------------------------------------------
                            */

                            $lineTotal =
                                max(
                                    $gross -
                                    $discount +
                                    $tax,
                                    0
                                );


                            /*
                            |--------------------------------------------------------------------------
                            | Totals
                            |--------------------------------------------------------------------------
                            */

                            $subtotal +=
                                $gross;


                            $discountTotal +=
                                $discount;


                            $taxTotal +=
                                $tax;


                            $totalQuantity +=
                                $quantity;


                            /*
                            |--------------------------------------------------------------------------
                            | Product Snapshot
                            |--------------------------------------------------------------------------
                            */

                            $orderItems[] = [

                                'company_id' =>
                                    $this->companyId,

                                'product_id' =>
                                    $product->id,

                                'product_name' =>
                                    $product->name,

                                'product_barcode' =>
                                    $product->barcode,

                                'quantity' =>
                                    $quantity,

                                'unit_price' =>
                                    $unitPrice,

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
                        | Order Totals
                        |--------------------------------------------------------------------------
                        */

                        $grandTotal =
                            max(
                                $subtotal -
                                $discountTotal +
                                $taxTotal,
                                0
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | Order Number
                        |--------------------------------------------------------------------------
                        */

                        $orderNo =
                            DocumentNumberService::generate(
                                'order',
                                $this->companyId
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | Create Order
                        |--------------------------------------------------------------------------
                        */

                        $order =
                            Order::create([

                                'company_id' =>
                                    $this->companyId,

                                'branch_id' =>
                                    $validated['branch_id'],

                                'terminal_id' =>
                                    $validated['terminal_id']
                                        ?? null,

                                'customer_id' =>
                                    $validated['customer_id']
                                        ?? null,

                                'cashier_id' =>
                                    auth()->id(),

                                'order_no' =>
                                    $orderNo,

                                'subtotal' =>
                                    $subtotal,

                                'discount' =>
                                    $discountTotal,

                                'discount_id' =>
                                    null,

                                'tax_rate_id' =>
                                    null,

                                'tax' =>
                                    $taxTotal,

                                'total' =>
                                    $grandTotal,

                                'amount_paid' =>
                                    0,

                                'balance' =>
                                    $grandTotal,

                                'total_items' =>
                                    count(
                                        $orderItems
                                    ),

                                'total_quantity' =>
                                    $totalQuantity,

                                'change_given' =>
                                    0,

                                'grand_total' =>
                                    $grandTotal,

                                'completed_at' =>
                                    null,

                                'payment_status' =>
                                    'Pending',

                                'order_status' =>
                                    'Draft',

                                'sales_channel' =>
                                    $validated['sales_channel'],

                                'receipt_printed' =>
                                    false,

                                'remarks' =>
                                    $validated['remarks']
                                        ?? null,

                                'created_by' =>
                                    auth()->id(),

                                'updated_by' =>
                                    null,

                            ]);


                        /*
                        |--------------------------------------------------------------------------
                        | Create Order Items
                        |--------------------------------------------------------------------------
                        */

                        foreach (
                            $orderItems
                            as $item
                        ) {

                            OrderItem::create([

                                'company_id' =>
                                    $item['company_id'],

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

                                'discount' =>
                                    $item['discount'],

                                'tax' =>
                                    $item['tax'],

                                'total' =>
                                    $item['total'],

                            ]);

                        }


                        return $order;
                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            if (
                isset(
                    $this->activityLogger
                )
            ) {

                $this->activityLogger->log(

                    'orders',

                    'create',

                    'Created sales order: ' .
                        $order->order_no,

                    $order,

                    null,

                    $order->toArray()

                );

            }


            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'success' =>
                    true,

                'message' =>
                    'Sales order created successfully.',

                'data' => [

                    'id' =>
                        $order->id,

                    'order_no' =>
                        $order->order_no,

                    'order_status' =>
                        $order->order_status,

                    'payment_status' =>
                        $order->payment_status,

                    'grand_total' =>
                        (float)
                        $order->grand_total,

                ],

            ], 201);

        }
        catch (ValidationException $e) {

            throw $e;

        }
        catch (\Throwable $e) {

            Log::error(
                'Failed to store sales order.',
                [

                    'company_id' =>
                        $this->companyId,

                    'user_id' =>
                        auth()->id(),

                    'error' =>
                        $e->getMessage(),

                    'trace' =>
                        $e->getTraceAsString(),

                ]
            );


            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Unable to create sales order. Please try again.',

            ], 500);

        }

    }

   /*
    |--------------------------------------------------------------------------
    | Update Order
    |--------------------------------------------------------------------------
    */

    /**
     * Update a Draft or Held Sales Order.
     */
    public function updateOrder(
        Request $request,
        int $id
    ): JsonResponse {

    /*
|--------------------------------------------------------------------------
| Update Order Debug
|--------------------------------------------------------------------------
*/

\Log::info(
    'Sales Order updateOrder reached.',
    [

        'order_id' =>
            $id,

        'method' =>
            $request->method(),

        'payload' =>
            $request->all(),

    ]
);

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('orders.update')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to update sales orders.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Locate Order
        |--------------------------------------------------------------------------
        */

        $orderQuery =
            Order::query()
                ->where(
                    'company_id',
                    $this->companyId
                );


        if (
            ! canManageAllBranches()
        ) {

            $orderQuery->where(
                'branch_id',
                currentBranchId()
            );

        }


        $order =
            $orderQuery->find(
                $id
            );


        if (!$order) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Sales order not found.',

            ], 404);

        }


        /*
        |--------------------------------------------------------------------------
        | Status Protection
        |--------------------------------------------------------------------------
        */

        if (
            ! in_array(
                $order->order_status,
                [
                    'Draft',
                    'Held',
                ],
                true
            )
        ) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'This sales order can no longer be edited.',

            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([

                'branch_id' => [

                    'required',

                    'integer',

                ],

                'customer_id' => [

                    'nullable',

                    'integer',

                ],

                'terminal_id' => [

                    'nullable',

                    'integer',

                ],

                'sales_channel' => [

                    'required',

                    'in:POS,Online,Phone',

                ],

                'remarks' => [

                    'nullable',

                    'string',

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

                    'gte:0',

                ],

                'items.*.discount_amount' => [

                    'nullable',

                    'numeric',

                    'gte:0',

                ],

                'items.*.tax_amount' => [

                    'nullable',

                    'numeric',

                    'gte:0',

                ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | Business Validation
        |--------------------------------------------------------------------------
        */

        $branch =
            Branch::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->when(
                    ! canManageAllBranches(),
                    fn ($query) =>
                        $query->where(
                            'id',
                            currentBranchId()
                        )
                )
                ->find(
                    $validated['branch_id']
                );


        if (!$branch) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Selected branch is invalid or unavailable.',

            ], 422);

        }


        $customer = null;


        if (
            ! empty(
                $validated['customer_id']
            )
        ) {

            $customer =
                Customer::query()
                    ->where(
                        'company_id',
                        $this->companyId
                    )
                    ->where(
                        'status',
                        true
                    )
                    ->find(
                        $validated['customer_id']
                    );


            if (!$customer) {

                return response()->json([

                    'success' =>
                        false,

                    'message' =>
                        'Selected customer is invalid or inactive.',

                ], 422);

            }

        }


        $terminal = null;


        if (
            ! empty(
                $validated['terminal_id']
            )
        ) {

            $terminal =
                Terminal::query()
                    ->where(
                        'company_id',
                        $this->companyId
                    )
                    ->where(
                        'branch_id',
                        $branch->id
                    )
                    ->where(
                        'status',
                        true
                    )
                    ->find(
                        $validated['terminal_id']
                    );


            if (!$terminal) {

                return response()->json([

                    'success' =>
                        false,

                    'message' =>
                        'Selected terminal is invalid for the selected branch.',

                ], 422);

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

        $productIds =
            collect(
                $validated['items']
            )
                ->pluck(
                    'product_id'
                )
                ->unique()
                ->values();


        $products =
            Product::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->whereIn(
                    'id',
                    $productIds
                )
                ->where(
                    'status',
                    true
                )
                ->get()
                ->keyBy(
                    'id'
                );


        if (
            $products->count() !==
            $productIds->count()
        ) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'One or more selected products are invalid or inactive.',

            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        try {

            DB::transaction(
                function () use (
                    $validated,
                    $products,
                    $order
                ) {

                    $subtotal =
                        0;

                    $discountTotal =
                        0;

                    $taxTotal =
                        0;

                    $totalQuantity =
                        0;

                    $items =
                        [];


                    foreach (
                        $validated['items']
                        as $item
                    ) {

                        $product =
                            $products->get(
                                $item['product_id']
                            );


                        $quantity =
                            (float)
                            $item['quantity'];


                        $unitPrice =
                            (float)
                            $item['unit_price'];


                        $discount =
                            (float)
                            (
                                $item['discount_amount']
                                ?? 0
                            );


                        $tax =
                            (float)
                            (
                                $item['tax_amount']
                                ?? 0
                            );


                        $lineSubtotal =
                            $quantity *
                            $unitPrice;


                        if (
                            $discount >
                            $lineSubtotal
                        ) {

                            throw ValidationException::withMessages([

                                'items' =>
                                    'Discount cannot exceed the product line amount.',

                            ]);

                        }


                        $lineTotal =
                            max(
                                $lineSubtotal -
                                $discount +
                                $tax,
                                0
                            );


                        $subtotal +=
                            $lineSubtotal;


                        $discountTotal +=
                            $discount;


                        $taxTotal +=
                            $tax;


                        $totalQuantity +=
                            $quantity;


                        $items[] = [

                            'product_id' =>
                                $product->id,

                            'product_name' =>
                                $product->name,

                            'product_barcode' =>
                                $product->barcode,

                            'quantity' =>
                                $quantity,

                            'unit_price' =>
                                $unitPrice,

                            'discount' =>
                                $discount,

                            'tax' =>
                                $tax,

                            'total' =>
                                $lineTotal,

                        ];

                    }


                    $grandTotal =
                        max(
                            $subtotal -
                            $discountTotal +
                            $taxTotal,
                            0
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Update Header
                    |--------------------------------------------------------------------------
                    */

                    $order->update([

                        'branch_id' =>
                            $validated['branch_id'],

                        'terminal_id' =>
                            $validated['terminal_id']
                                ?? null,

                        'customer_id' =>
                            $validated['customer_id']
                                ?? null,

                        'subtotal' =>
                            $subtotal,

                        'discount' =>
                            $discountTotal,

                        'tax' =>
                            $taxTotal,

                        'total' =>
                            $grandTotal,

                        'amount_paid' =>
                            0,

                        'balance' =>
                            $grandTotal,

                        'total_items' =>
                            count(
                                $items
                            ),

                        'total_quantity' =>
                            $totalQuantity,

                        'change_given' =>
                            0,

                        'grand_total' =>
                            $grandTotal,

                        'sales_channel' =>
                            $validated['sales_channel'],

                        'remarks' =>
                            $validated['remarks']
                                ?? null,

                        'updated_by' =>
                            auth()->id(),

                    ]);


                    /*
                    |--------------------------------------------------------------------------
                    | Replace Items
                    |--------------------------------------------------------------------------
                    */

                    $order->orderItems()->delete();


                    foreach (
                        $items
                        as $item
                    ) {

                        OrderItem::create([

                            'company_id' =>
                                $this->companyId,

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

                            'discount' =>
                                $item['discount'],

                            'tax' =>
                                $item['tax'],

                            'total' =>
                                $item['total'],

                        ]);

                    }

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'orders',

                'update',

                'Updated sales order: ' .
                    $order->order_no,

                $order,

                null,

                $order->fresh()->toArray()

            );


            return response()->json([

                'success' =>
                    true,

                'message' =>
                    'Sales order updated successfully.',

                'data' => [

                    'id' =>
                        $order->id,

                    'order_no' =>
                        $order->order_no,

                ],

            ]);

        }
        catch (ValidationException $e) {

            throw $e;

        }
        catch (\Throwable $e) {

            Log::error(
                'Failed to update sales order.',
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
                    'Unable to update sales order. Please try again.',

            ], 500);

        }

    }

    /*
    |--------------------------------------------------------------------------
    | Delete Order
    |--------------------------------------------------------------------------
    */

    /**
     * Delete a Draft/Held Sales Order.
     */
    public function deleteOrder(
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('orders.delete')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to delete sales orders.',

            ], 403);

        }


        try {

            /*
            |--------------------------------------------------------------------------
            | Find Order
            |--------------------------------------------------------------------------
            */

            $order =
                Order::query()
                    ->where(
                        'company_id',
                        $this->companyId
                    )
                    ->find(
                        $id
                    );


            if (! $order) {

                return response()->json([

                    'success' =>
                        false,

                    'message' =>
                        'Sales order not found.',

                ], 404);

            }


            /*
            |--------------------------------------------------------------------------
            | Status Protection
            |--------------------------------------------------------------------------
            */

            if (
                ! in_array(
                    $order->order_status,
                    [
                        'Draft',
                        'Held',
                    ],
                    true
                )
            ) {

                return response()->json([

                    'success' =>
                        false,

                    'message' =>
                        'Only Draft or Held sales orders can be deleted.',

                ], 422);

            }


            /*
            |--------------------------------------------------------------------------
            | Capture Old Values
            |--------------------------------------------------------------------------
            */

            $oldValues =
                $order->toArray();


            /*
            |--------------------------------------------------------------------------
            | Delete
            |--------------------------------------------------------------------------
            */

            DB::transaction(
                function () use (
                    $order
                ) {

                    $order->delete();

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'sales_orders',

                'delete',

                'Deleted sales order: ' .
                    $order->order_no,

                $order,

                $oldValues,

                null

            );


            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'success' =>
                    true,

                'message' =>
                    'Sales order deleted successfully.',

            ]);

        }
        catch (\Throwable $e) {

            \Log::error(
                'Failed to delete sales order.',
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
                    'Unable to delete sales order. Please try again.',

            ], 500);

        }

    }
    /*
    |--------------------------------------------------------------------------
    | Terminals
    |--------------------------------------------------------------------------
    */

    /**
     * Return active terminals for the selected branch.
     */
    public function terminals(
        Request $request
    ): JsonResponse {

        if (! canAccess('orders.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view terminals.',

            ], 403);

        }


        $request->validate([

            'branch_id' => [
                'required',
                'integer',
            ],

        ]);


        $branch =
            Branch::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->find(
                    $request->branch_id
                );


        if (!$branch) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'The selected branch is invalid.',

            ], 422);

        }


        $terminals =
            Terminal::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->where(
                    'branch_id',
                    $branch->id
                )
                ->where(
                    'status',
                    true
                )
                ->orderBy(
                    'terminal_name'
                )
                ->get([
                    'id',
                    'terminal_code',
                    'terminal_name',
                ]);


        return response()->json([

            'success' =>
                true,

            'data' =>
                $terminals->map(
                    function ($terminal) {

                        return [

                            'id' =>
                                $terminal->id,

                            'name' =>
                                $terminal->displayName(),

                            'terminal_code' =>
                                $terminal->terminal_code,

                            'terminal_name' =>
                                $terminal->terminal_name,

                        ];

                    }
                )->values(),

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Customer Groups
    |--------------------------------------------------------------------------
    */

    /**
     * Return customer groups for Sales Orders.
     */
    public function customerGroups(): JsonResponse
    {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('orders.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view customer groups.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Customer Groups
        |--------------------------------------------------------------------------
        */

        $groups =
            CustomerGroup::query()
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


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'data' =>
                $groups,

        ]);

    }

/*
|--------------------------------------------------------------------------
| Store Customer
|--------------------------------------------------------------------------
*/

/**
 * Store a customer from the Sales Order modal.
 */
public function storeCustomer(
    Request $request
): JsonResponse {

    /*
    |--------------------------------------------------------------------------
    | Permission
    |--------------------------------------------------------------------------
    */

    if (! canAccess('customers.create')) {

        return response()->json([

            'success' =>
                false,

            'message' =>
                'You do not have permission to create customers.',

        ], 403);

    }


    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    $validated =
        $request->validate([

            'customer_group_id' => [

                'nullable',

                'integer',

                Rule::exists(
                    'customer_groups',
                    'id'
                )->where(
                    fn ($query) =>
                        $query
                            ->where(
                                'company_id',
                                $this->companyId
                            )
                            ->where(
                                'status',
                                true
                            )
                ),

            ],

            'first_name' => [
                'required',
                'string',
                'max:255',
            ],

            'last_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'customer_type' => [
                'required',
                'string',
                'max:255',
            ],

        ]);


    /*
    |--------------------------------------------------------------------------
    | Normalize Contact Values
    |--------------------------------------------------------------------------
    */

    $phone =
        ! empty(
            $validated['phone']
        )
            ? trim(
                $validated['phone']
            )
            : null;


    $email =
        ! empty(
            $validated['email']
        )
            ? strtolower(
                trim(
                    $validated['email']
                )
            )
            : null;


    /*
    |--------------------------------------------------------------------------
    | Customer Group
    |--------------------------------------------------------------------------
    */

    $customerGroup = null;


    if (
        ! empty(
            $validated['customer_group_id']
        )
    ) {

        $customerGroup =
            CustomerGroup::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->where(
                    'status',
                    true
                )
                ->findOrFail(
                    $validated['customer_group_id']
                );

    }


    /*
    |--------------------------------------------------------------------------
    | Archived Customer Detection
    |--------------------------------------------------------------------------
    */

    $archivedCustomer = null;


    /*
    |--------------------------------------------------------------------------
    | Phone + Email
    |--------------------------------------------------------------------------
    */

    if (
        $phone &&
        $email
    ) {

        $archivedCustomer =
            Customer::onlyTrashed()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->where(
                    'phone',
                    $phone
                )
                ->where(
                    'email',
                    $email
                )
                ->latest(
                    'deleted_at'
                )
                ->first();

    }


    /*
    |--------------------------------------------------------------------------
    | Phone
    |--------------------------------------------------------------------------
    */

    if (
        ! $archivedCustomer &&
        $phone
    ) {

        $archivedCustomer =
            Customer::onlyTrashed()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->where(
                    'phone',
                    $phone
                )
                ->latest(
                    'deleted_at'
                )
                ->first();

    }


    /*
    |--------------------------------------------------------------------------
    | Email
    |--------------------------------------------------------------------------
    */

    if (
        ! $archivedCustomer &&
        $email
    ) {

        $archivedCustomer =
            Customer::onlyTrashed()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->where(
                    'email',
                    $email
                )
                ->latest(
                    'deleted_at'
                )
                ->first();

    }


    /*
    |--------------------------------------------------------------------------
    | Restore Archived Customer
    |--------------------------------------------------------------------------
    */

    if ($archivedCustomer) {

        $customer =
            DB::transaction(
                function () use (
                    $archivedCustomer,
                    $validated,
                    $customerGroup,
                    $phone,
                    $email
                ) {

                    $archivedCustomer->restore();


                    $archivedCustomer->update([

                        'customer_group_id' =>
                            $validated[
                                'customer_group_id'
                            ] ?? null,

                        'first_name' =>
                            $validated[
                                'first_name'
                            ],

                        'last_name' =>
                            $validated[
                                'last_name'
                            ] ?? null,

                        'email' =>
                            $email,

                        'phone' =>
                            $phone,

                        'address' =>
                            $validated[
                                'address'
                            ] ?? null,

                        'credit_limit' =>
                            $customerGroup
                                ? (float)
                                    $customerGroup->credit_limit
                                : 0,

                        'customer_type' =>
                            $validated[
                                'customer_type'
                            ],

                        'status' =>
                            true,

                        'updated_by' =>
                            auth()->id(),

                    ]);


                    return $archivedCustomer->fresh();

                }
            );


        $this->activityLogger->log(

            'customers',

            'restore',

            'Restored customer: ' .
                $customer->displayName(),

            $customer,

            null,

            $customer->toArray()

        );


        return response()->json([

            'success' =>
                true,

            'message' =>
                'Existing archived customer restored successfully.',

            'data' => [

                'id' =>
                    $customer->id,

                'customer_code' =>
                    $customer->customer_code,

                'name' =>
                    $customer->displayName(),

            ],

            'restored' =>
                true,

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Generate Customer Code
    |--------------------------------------------------------------------------
    */

    $lastCustomer =
        Customer::withTrashed()
            ->where(
                'company_id',
                $this->companyId
            )
            ->latest(
                'id'
            )
            ->first();


    $nextCustomerNumber =
        $lastCustomer
            ? $lastCustomer->id + 1
            : 1;


    $customerCode =
        'CUS-' .
        str_pad(
            (string) $nextCustomerNumber,
            5,
            '0',
            STR_PAD_LEFT
        );


    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    $customer =
        DB::transaction(
            function () use (
                $validated,
                $customerGroup,
                $customerCode,
                $phone,
                $email
            ) {

                return Customer::create([

                    'company_id' =>
                        $this->companyId,

                    'customer_group_id' =>
                        $validated[
                            'customer_group_id'
                        ] ?? null,

                    'customer_code' =>
                        $customerCode,

                    'first_name' =>
                        $validated[
                            'first_name'
                        ],

                    'last_name' =>
                        $validated[
                            'last_name'
                        ] ?? null,

                    'email' =>
                        $email,

                    'phone' =>
                        $phone,

                    'address' =>
                        $validated[
                            'address'
                        ] ?? null,

                    'credit_limit' =>
                        $customerGroup
                            ? (float)
                                $customerGroup->credit_limit
                            : 0,

                    'current_balance' =>
                        0,

                    'customer_type' =>
                        $validated[
                            'customer_type'
                        ],

                    'loyalty_points' =>
                        0,

                    'status' =>
                        true,

                    'created_by' =>
                        auth()->id(),

                ]);

            }
        );


    /*
    |--------------------------------------------------------------------------
    | Activity Log
    |--------------------------------------------------------------------------
    */

    $this->activityLogger->log(

        'customers',

        'create',

        'Created customer: ' .
            $customer->displayName(),

        $customer,

        null,

        $customer->toArray()

    );


    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    return response()->json([

        'success' =>
            true,

        'message' =>
            'Customer created successfully.',

        'data' => [

            'id' =>
                $customer->id,

            'customer_code' =>
                $customer->customer_code,

            'name' =>
                $customer->displayName(),

        ],

        'restored' =>
            false,

    ]);

}

    /*
    |--------------------------------------------------------------------------
    | Store Terminal
    |--------------------------------------------------------------------------
    */

    /**
     * Store a terminal from the Sales Order modal.
     */
    public function storeTerminal(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('orders.create')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to create terminals.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([

                'branch_id' => [
                    'required',
                    'integer',
                ],

                'terminal_name' => [
                    'required',
                    'string',
                    'max:100',
                ],

                'terminal_code' => [
                    'required',
                    'string',
                    'max:50',
                ],

                'device_name' => [
                    'nullable',
                    'string',
                    'max:150',
                ],

                'ip_address' => [
                    'nullable',
                    'ip',
                ],

                'description' => [
                    'nullable',
                    'string',
                    'max:500',
                ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | Branch
        |--------------------------------------------------------------------------
        */

        $branch =
            Branch::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->find(
                    $validated['branch_id']
                );


        if (!$branch) {

            throw ValidationException::withMessages([

                'branch_id' =>
                    'The selected branch is invalid.',

            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Duplicate Code
        |--------------------------------------------------------------------------
        */

        $existingCode =
            Terminal::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->where(
                    'terminal_code',
                    $validated['terminal_code']
                )
                ->exists();


        if ($existingCode) {

            throw ValidationException::withMessages([

                'terminal_code' =>
                    'The terminal code is already in use.',

            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Create Terminal
        |--------------------------------------------------------------------------
        */

        try {

            $terminal =
                DB::transaction(
                    function () use (
                        $validated
                    ) {

                        return Terminal::create([

                            'company_id' =>
                                $this->companyId,

                            'branch_id' =>
                                $validated['branch_id'],

                            'terminal_code' =>
                                $validated['terminal_code'],

                            'terminal_name' =>
                                $validated['terminal_name'],

                            'description' =>
                                $validated['description']
                                    ?? null,

                            'device_name' =>
                                $validated['device_name']
                                    ?? null,

                            'ip_address' =>
                                $validated['ip_address']
                                    ?? null,

                            'status' =>
                                true,

                            'last_seen_at' =>
                                null,

                        ]);

                    }
                );


            return response()->json([

                'success' =>
                    true,

                'message' =>
                    'Terminal created successfully.',

                'data' => [

                    'id' =>
                        $terminal->id,

                    'terminal_code' =>
                        $terminal->terminal_code,

                    'terminal_name' =>
                        $terminal->terminal_name,

                    'name' =>
                        $terminal->displayName(),

                ],

            ], 201);

        }
        catch (\Throwable $e) {

            Log::error(
                'Failed to create terminal from Sales Order.',
                [

                    'company_id' =>
                        $this->companyId,

                    'branch_id' =>
                        $validated['branch_id'],

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
                    'Unable to create terminal. Please try again.',

            ], 500);

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Complete Order
    |--------------------------------------------------------------------------
    */

    /**
     * Complete a Draft/Held Sales Order.
     *
     * Completion:
     * - validates payment
     * - re-checks branch stock
     * - deducts stock
     * - creates stock movements
     * - updates payment/order status
     * - records completion audit
     */
    public function completeOrder(
        Request $request,
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('orders.update')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to complete sales orders.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([

                'amount_paid' => [

                    'required',

                    'numeric',

                    'min:0',

                ],

                'payment_method' => [

                    'required',

                    'string',

                    'max:100',

                ],

            ]);


        try {

            /*
            |--------------------------------------------------------------------------
            | Complete Transaction
            |--------------------------------------------------------------------------
            */

            $result =
                DB::transaction(
                    function () use (
                        $validated,
                        $id
                    ) {

                        /*
                        |--------------------------------------------------------------------------
                        | Order
                        |--------------------------------------------------------------------------
                        */

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
                                    'Sales order not found.',

                            ]);

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Status
                        |--------------------------------------------------------------------------
                        */

                        if (
                            ! in_array(
                                $order->order_status,
                                [
                                    'Draft',
                                    'Held',
                                ],
                                true
                            )
                        ) {

                            throw ValidationException::withMessages([

                                'order' =>
                                    'Only Draft or Held sales orders can be completed.',

                            ]);

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Amount Due
                        |--------------------------------------------------------------------------
                        */

                        $amountDue =
                            (float) (
                                $order->grand_total
                                ??
                                $order->total
                                ??
                                0
                            );


                        $amountPaid =
                            (float) (
                                $validated['amount_paid']
                                ?? 0
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | Payment Validation
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $amountPaid <
                            $amountDue
                        ) {

                            throw ValidationException::withMessages([

                                'amount_paid' =>
                                    'Amount paid cannot be less than the amount due.',

                            ]);

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Load Items
                        |--------------------------------------------------------------------------
                        */

                        $items =
                            OrderItem::query()
                                ->where(
                                    'order_id',
                                    $order->id
                                )
                                ->lockForUpdate()
                                ->get();


                        if (
                            $items->isEmpty()
                        ) {

                            throw ValidationException::withMessages([

                                'items' =>
                                    'This sales order has no items.',

                            ]);

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Capture Stock Changes
                        |--------------------------------------------------------------------------
                        */

                        $stockChanges = [];


                        foreach (
                            $items
                            as $item
                        ) {

                            /*
                            |--------------------------------------------------------------------------
                            | Product
                            |--------------------------------------------------------------------------
                            */

                            $product =
                                Product::query()
                                    ->where(
                                        'company_id',
                                        $this->companyId
                                    )
                                    ->where(
                                        'id',
                                        $item->product_id
                                    )
                                    ->where(
                                        'status',
                                        true
                                    )
                                    ->first();


                            if (! $product) {

                                throw ValidationException::withMessages([

                                    'items' =>
                                        'Product for order item "' .
                                        $item->product_name .
                                        '" is no longer available.',

                                ]);

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Branch Stock
                            |--------------------------------------------------------------------------
                            */

                            $stock =
                                ProductStock::query()
                                    ->where(
                                        'company_id',
                                        $this->companyId
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


                            if (! $stock) {

                                throw ValidationException::withMessages([

                                    'items' =>
                                        'No stock record exists for "' .
                                        $product->name .
                                        '" in the selected branch.',

                                ]);

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Quantity
                            |--------------------------------------------------------------------------
                            */

                            $quantity =
                                (float)
                                $item->quantity;


                            if (
                                $quantity <= 0
                            ) {

                                throw ValidationException::withMessages([

                                    'items' =>
                                        'Invalid quantity for "' .
                                        $product->name .
                                        '".',

                                ]);

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Available Stock
                            |--------------------------------------------------------------------------
                            */

                            $availableQuantity =
                                (float)
                                $stock->available_quantity;


                            /*
                            |--------------------------------------------------------------------------
                            | Stock Check
                            |--------------------------------------------------------------------------
                            */

                            if (
                                $quantity >
                                $availableQuantity
                            ) {

                                throw ValidationException::withMessages([

                                    'items' =>
                                        'Insufficient stock for "' .
                                        $product->name .
                                        '". Only ' .
                                        number_format(
                                            $availableQuantity,
                                            2
                                        ) .
                                        ' units are available in the selected branch.',

                                ]);

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Capture Before
                            |--------------------------------------------------------------------------
                            */

                            $stockBefore =
                                (float)
                                $stock->quantity;


                            /*
                            |--------------------------------------------------------------------------
                            | New Quantity
                            |--------------------------------------------------------------------------
                            */

                            $newQuantity =
                                $stockBefore
                                -
                                $quantity;


                            if (
                                $newQuantity < 0
                            ) {

                                throw ValidationException::withMessages([

                                    'items' =>
                                        'Stock cannot become negative for "' .
                                        $product->name .
                                        '".',

                                ]);

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Reserved Quantity
                            |--------------------------------------------------------------------------
                            */

                            $reservedQuantity =
                                (float)
                                $stock->reserved_quantity;


                            /*
                            |--------------------------------------------------------------------------
                            | New Available Quantity
                            |--------------------------------------------------------------------------
                            */

                            $newAvailableQuantity =
                                max(
                                    0,
                                    $newQuantity
                                    -
                                    $reservedQuantity
                                );


                            /*
                            |--------------------------------------------------------------------------
                            | Store Change
                            |--------------------------------------------------------------------------
                            */

                            $stockChanges[] = [

                                'item' =>
                                    $item,

                                'product' =>
                                    $product,

                                'stock' =>
                                    $stock,

                                'stock_before' =>
                                    $stockBefore,

                                'quantity' =>
                                    $quantity,

                                'new_quantity' =>
                                    $newQuantity,

                                'new_available_quantity' =>
                                    $newAvailableQuantity,

                            ];

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Apply Stock Changes
                        |--------------------------------------------------------------------------
                        */

                        foreach (
                            $stockChanges
                            as $change
                        ) {

                            $stock =
                                $change['stock'];


                            $stock->update([

                                'quantity' =>
                                    $change['new_quantity'],

                                'available_quantity' =>
                                    $change['new_available_quantity'],

                            ]);


                            /*
                            |--------------------------------------------------------------------------
                            | Stock Movement
                            |--------------------------------------------------------------------------
                            */

                            StockMovement::create([

                                'company_id' =>
                                    $this->companyId,

                                'branch_id' =>
                                    $order->branch_id,

                                'product_id' =>
                                    $change['item']->product_id,

                                'order_id' =>
                                    $order->id,

                                'reference_no' =>
                                    $order->order_no,

                                'unit_cost' =>
                                    (float)
                                    $change['product']->cost_price,

                                'quantity' =>
                                    $change['quantity'],

                                'stock_before' =>
                                    $change['stock_before'],

                                'balance_after' =>
                                    $change['new_quantity'],

                                'remarks' =>
                                    'Sales Order completed: ' .
                                    $order->order_no,

                                'created_by' =>
                                    auth()->id(),

                                'movement_type' =>
                                    'Sale',

                            ]);

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Change Given
                        |--------------------------------------------------------------------------
                        */

                        $changeGiven =
                            max(
                                $amountPaid -
                                $amountDue,
                                0
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | Balance
                        |--------------------------------------------------------------------------
                        */

                        $balance =
                            max(
                                $amountDue -
                                $amountPaid,
                                0
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | Capture Old Values
                        |--------------------------------------------------------------------------
                        */

                        $oldValues =
                            $order->toArray();


                        /*
                        |--------------------------------------------------------------------------
                        | Update Order
                        |--------------------------------------------------------------------------
                        */

                        $order->update([

                            'amount_paid' =>
                                $amountPaid,

                            'balance' =>
                                $balance,

                            'change_given' =>
                                $changeGiven,

                            'payment_status' =>
                                'Paid',

                            'order_status' =>
                                'Completed',

                            'completed_at' =>
                                now(),

                            'updated_by' =>
                                auth()->id(),

                        ]);


                        /*
                        |--------------------------------------------------------------------------
                        | Return
                        |--------------------------------------------------------------------------
                        */

                        return [

                            'order' =>
                                $order->fresh(),

                            'old_values' =>
                                $oldValues,

                            'stock_changes' =>
                                $stockChanges,

                        ];

                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'sales_orders',

                'Completed',

                'Completed sales order: ' .
                    $result['order']->order_no,

                $result['order'],

                $result['old_values'],

                $result['order']->toArray()

            );


            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'success' =>
                    true,

                'message' =>
                    'Sales order completed successfully.',

                'data' => [

                    'id' =>
                        $result['order']->id,

                    'order_no' =>
                        $result['order']->order_no,

                    'order_status' =>
                        $result['order']->order_status,

                    'payment_status' =>
                        $result['order']->payment_status,

                    'amount_paid' =>
                        (float)
                        $result['order']->amount_paid,

                    'balance' =>
                        (float)
                        $result['order']->balance,

                    'change_given' =>
                        (float)
                        $result['order']->change_given,

                    'completed_at' =>
                        $result['order']->completed_at,

                ],

            ]);

        }
        catch (ValidationException $e) {

            throw $e;

        }
        catch (\Throwable $e) {

            \Log::error(
                'Failed to complete sales order.',
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
                    'Unable to complete sales order. Please try again.',

            ], 500);

        }

    }

    /*
    |--------------------------------------------------------------------------
    | Receipt Order
    |--------------------------------------------------------------------------
    */

    /**
     * Load a completed Sales Order for receipt generation.
     */
    private function getReceiptOrder(
        int $id
    ): Order {

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
                    'Completed'
                )
                ->with([

                    'branch',

                    'terminal',

                    'customer',

                    'cashier',

                    'orderItems',

                ])
                ->first();


        if (! $order) {

            abort(
                404,
                'Completed sales order not found.'
            );

        }
       

                return $order;

            }

    /*
    |--------------------------------------------------------------------------
    | Receipt
    |--------------------------------------------------------------------------
    */

    /**
     * Display a printable Sales Order receipt.
     */
    public function receipt(
        int $id
    ) {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('orders.view')) {

            abort(
                403,
                'You do not have permission to view sales orders.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Order
        |--------------------------------------------------------------------------
        */

        $order =
            $this->getReceiptOrder(
                $id
            );

             /*
        |--------------------------------------------------------------------------
        | Receipt Settings
        |--------------------------------------------------------------------------
        */

        $receiptSettings =
            Setting::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->first();


        /*
        |--------------------------------------------------------------------------
        | Receipt View
        |--------------------------------------------------------------------------
        */

        return view(
            'sales.orders.receipt',
            compact(
                'order',
                'receiptSettings'
            )
        );

    }

    /*
    |--------------------------------------------------------------------------
    | Receipt PDF
    |--------------------------------------------------------------------------
    */

    /**
     * Download a completed Sales Order as PDF.
     */
    public function receiptPdf(
        int $id
    ) {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('orders.view')) {

            abort(
                403,
                'You do not have permission to view sales orders.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Order
        |--------------------------------------------------------------------------
        */

        $order =
            $this->getReceiptOrder(
                $id
            );

         /*
        |--------------------------------------------------------------------------
        | Receipt Settings
        |--------------------------------------------------------------------------
        */

        $receiptSettings =
            Setting::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->first();

        /*
        |--------------------------------------------------------------------------
        | Receipt Logo
        |--------------------------------------------------------------------------
        */

        $logoData =
            null;


        if (
            $receiptSettings?->print_logo &&
            filled(
                $order->company?->logo
            )
        ) {

            $logoPath =
                public_path(
                    'uploads/company/' .
                    ltrim(
                        $order->company->logo,
                        '/'
                    )
                );


            if (
                is_file(
                    $logoPath
                )
            ) {

                $mimeType =
                    mime_content_type(
                        $logoPath
                    );


                $logoData =
                    'data:' .
                    $mimeType .
                    ';base64,' .
                    base64_encode(
                        file_get_contents(
                            $logoPath
                        )
                    );

            }

        }

        /*
        |--------------------------------------------------------------------------
        | PDF
        |--------------------------------------------------------------------------
        */

        $pdf =
            Pdf::loadView(
                'sales.orders.receipt-pdf',
                compact(
                    'order',
                     'receiptSettings',
                    'logoData' 
                )
            );


        /*
        |--------------------------------------------------------------------------
        | Paper
        |--------------------------------------------------------------------------
        */

        $pdf->setPaper(
            'a4',
            'portrait'
        );


        /*
        |--------------------------------------------------------------------------
        | Download
        |--------------------------------------------------------------------------
        */

        return $pdf->download(
            'receipt-' .
            $order->order_no .
            '.pdf'
        );

    }



}