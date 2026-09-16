<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\ProductStock;
use App\Models\SalesReturn;
use App\Models\SalesReturnItem;
use App\Models\SalesReturnPayment;
use App\Models\StockMovement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Services\ActivityLogger;
use App\Services\DocumentNumberService;

class SalesReturnController extends BaseController
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
     * Display the Sales Returns / Refunds module.
     */
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('sales.returns.view')) {

            abort(
                403,
                'You do not have permission to view sales returns.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Branches
        |--------------------------------------------------------------------------
        */

        $branches =
            $this->company
                ->branches()
                ->when(
                    ! canManageAllBranches(),
                    function ($query) {

                        $query->where(
                            'id',
                            currentBranchId()
                        );

                    }
                )
                ->orderBy('name')
                ->get();


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view(
            'sales.returns.index',
            compact(
                'branches'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Table
    |--------------------------------------------------------------------------
    */

    /**
     * Return Sales Returns / Refunds table data.
     */
    public function table(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('sales.returns.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view sales returns.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Query
        |--------------------------------------------------------------------------
        */

        $query =
            SalesReturn::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->with([

                    'order.invoice',

                    'customer',

                    'branch',

                    'processedBy',

                ]);


        /*
        |--------------------------------------------------------------------------
        | Branch Access
        |--------------------------------------------------------------------------
        */

        if (
            ! canManageAllBranches()
        ) {

            $query->where(
                'branch_id',
                currentBranchId()
            );

        }


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
                    $request->input('search')
                );


            $query->where(
                function ($q) use ($search) {

                    $q->where(
                        'return_number',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'reference_no',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhereHas(
                        'order',
                        function ($orderQuery) use ($search) {

                            $orderQuery->where(
                                'order_no',
                                'like',
                                "%{$search}%"
                            );

                        }
                    )

                    ->orWhereHas(
                        'customer',
                        function ($customerQuery) use ($search) {

                            $customerQuery->where(
                                'first_name',
                                'like',
                                "%{$search}%"
                            )

                            ->orWhere(
                                'last_name',
                                'like',
                                "%{$search}%"
                            );

                        }
                    );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Return Status
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('return_status')
        ) {

            $query->where(
                'return_status',
                $request->input('return_status')
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Branch Filter
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('branch_id')
        ) {

            $query->where(
                'branch_id',
                $request->input('branch_id')
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Date Range
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('date_from')
        ) {

            $query->whereDate(
                'created_at',
                '>=',
                $request->input('date_from')
            );

        }


        if (
            $request->filled('date_to')
        ) {

            $query->whereDate(
                'created_at',
                '<=',
                $request->input('date_to')
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $perPage =
            max(
                1,
                min(
                    100,
                    (int)
                    $request->input(
                        'per_page',
                        15
                    )
                )
            );


        $returns =
            $query
                ->latest('created_at')
                ->latest('id')
                ->paginate(
                    $perPage
                );


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $statsQuery =
            clone $query;


        $stats = [

            'total_returns' =>
                (clone $statsQuery)
                    ->count(),

            'completed_returns' =>
                (clone $statsQuery)
                    ->where(
                        'return_status',
                        'Completed'
                    )
                    ->count(),

            'total_refunded' =>
                (float)
                (clone $statsQuery)
                    ->where(
                        'return_status',
                        'Completed'
                    )
                    ->sum('refund_amount'),

        ];


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'data' => [

                'returns' =>
                    $returns
                        ->map(
                            function ($return) {

                                return [

                                    'id' =>
                                        $return->id,

                                    'return_number' =>
                                        $return->return_number,

                                    'order' => $return->order
                                        ? [

                                            'order_no' =>
                                                $return->order->order_no,

                                            'invoice_no' =>
                                                $return->order
                                                    ->invoice
                                                    ?->invoice_no,

                                        ]
                                        : null,

                                    'customer' =>
                                        $return->customer
                                            ? $return->customer
                                                ->displayName()
                                            : 'Walk-in Customer',

                                    'refund_amount' =>
                                        (float)
                                        $return->refund_amount,

                                    'return_status' =>
                                        $return->return_status,
                                    
                                    'order_status' => 
                                        $return->order?->order_status,

                                    'return_date' =>
                                        $return->created_at,

                                    'branch' =>
                                        $return->branch?->name,

                                    'reference_no' =>
                                        $return->reference_no,
                                    
                                    'processed_by' =>
                                        $return->processedBy
                                            ? trim(
                                                $return->processedBy->first_name .
                                                ' ' .
                                                $return->processedBy->last_name
                                            )
                                            : null,



                                ];

                            }
                        )
                        ->values(),

                'pagination' => [

                    'current_page' =>
                        $returns->currentPage(),

                    'last_page' =>
                        $returns->lastPage(),

                    'per_page' =>
                        $returns->perPage(),

                    'total' =>
                        $returns->total(),

                ],

                'stats' =>
                    $stats,

            ],

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Orders
    |--------------------------------------------------------------------------
    */

    /**
     * Return completed and held orders eligible for refund.
     */
    public function orders(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('sales.returns.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view sales returns.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Query
        |--------------------------------------------------------------------------
        */

        $query =
            Order::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->whereIn(
                    'order_status',
                    [

                        'Completed',

                        'Held',

                    ]
                )
                ->whereHas(
                    'payments',
                    function ($paymentQuery) {

                        $paymentQuery->where(
                            'payment_status',
                            'Completed'
                        );

                    }
                )
                ->with([

                    'customer',

                    'branch',

                    'invoice',

                    'payments' => function ($paymentQuery) {

                        $paymentQuery->where(
                            'payment_status',
                            'Completed'
                        );

                    },

                ]);


        /*
        |--------------------------------------------------------------------------
        | Branch Access
        |--------------------------------------------------------------------------
        */

        if (
            ! canManageAllBranches()
        ) {

            $query->where(
                'branch_id',
                currentBranchId()
            );

        }


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
                    $request->input('search')
                );


            $query->where(
                function ($q) use ($search) {

                    $q->where(
                        'order_no',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhereHas(
                        'customer',
                        function ($customerQuery) use ($search) {

                            $customerQuery->where(
                                'first_name',
                                'like',
                                "%{$search}%"
                            )

                            ->orWhere(
                                'last_name',
                                'like',
                                "%{$search}%"
                            );

                        }
                    );

                }
            );

        }


         /*                                                                         |
        | -------------------------------------------------------------------------- |
        | Order Status                                                               |
        | -------------------------------------------------------------------------- |
        | */                                                                         

        if (
        $request->filled('order_status')
        ) {


        $query->where(
            'order_status',
            $request->input('order_status')
        );


        }

        /*                                                                         |
        | -------------------------------------------------------------------------- |
        | Payment Status                                                             |
        | -------------------------------------------------------------------------- |
        | */                                                                        

        if (
        $request->filled('payment_status')
        ) {


        $query->where(
            'payment_status',
            $request->input('payment_status')
        );


        }

        /*                                                                         |
        | -------------------------------------------------------------------------- |
        | Branch Filter                                                              |
        | -------------------------------------------------------------------------- |
        | */                                                                         

        if (
        $request->filled('branch_id')
        ) {


        $query->where(
            'branch_id',
            $request->input('branch_id')
        );


        }

        /*                                                                         |
        | -------------------------------------------------------------------------- |
        | Date From                                                                  |
        | -------------------------------------------------------------------------- |
        | */                                                                         

        if (
        $request->filled('date_from')
        ) {


        $query->whereDate(
            'created_at',
            '>=',
            $request->input('date_from')
        );


        }

        /*                                                                         |
        | -------------------------------------------------------------------------- |
        | Date To                                                                    |
        | -------------------------------------------------------------------------- |
        | */                                                                         

        if (
        $request->filled('date_to')
        ) {

        $query->whereDate(
            'created_at',
            '<=',
            $request->input('date_to')
        );


        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $perPage =
            max(
                1,
                min(
                    100,
                    (int)
                    $request->input(
                        'per_page',
                        15
                    )
                )
            );


        $orders =
            $query
                ->latest('id')
                ->paginate(
                    $perPage
                );


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'data' => [

                'orders' =>
                    $orders
                        ->map(
                            function ($order) {

                                return [

                                    'id' =>
                                        $order->id,

                                    'order_no' =>
                                        $order->order_no,

                                    'invoice_no' =>
                                        $order->invoice?->invoice_no,

                                    'customer' =>
                                        $order->customer
                                            ? $order->customer
                                                ->displayName()
                                            : 'Walk-in Customer',

                                    'branch_name' =>
                                        $order->branch?->name,

                                    'order_status' =>
                                        $order->order_status,

                                    'payment_status' =>
                                        $order->payment_status,

                                    'grand_total' =>
                                        (float)
                                        $order->grand_total,

                                    'amount_paid' =>
                                        (float)
                                        $order->amount_paid,

                                    'balance' =>
                                        (float)
                                        $order->balance,

                                    'payment_count' =>
                                        $order->payments->count(),

                                ];

                            }
                        )
                        ->values(),

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

            ],

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Payments
    |--------------------------------------------------------------------------
    */

    /**
     * Return completed payments associated with an order.
     */
    public function payments(
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('sales.returns.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view sales returns.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Order
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

                    'invoice',

                    'payments' => function ($paymentQuery) {

                        $paymentQuery
                            ->where(
                                'payment_status',
                                'Completed'
                            )
                            ->latest('payment_date')
                            ->latest('id');

                    },

                ]);


        /*
        |--------------------------------------------------------------------------
        | Branch Access
        |--------------------------------------------------------------------------
        */

        if (
            ! canManageAllBranches()
        ) {

            $query->where(
                'branch_id',
                currentBranchId()
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Order
        |--------------------------------------------------------------------------
        */

        $order =
            $query->find(
                $id
            );


        if (! $order) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Order not found.',

            ], 404);

        }


        /*
        |--------------------------------------------------------------------------
        | Eligible Order
        |--------------------------------------------------------------------------
        */

        if (
            ! in_array(
                $order->order_status,
                [

                    'Completed',

                    'Held',

                ],
                true
            )
        ) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'This order is not eligible for refund.',

            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Payment Total
        |--------------------------------------------------------------------------
        */

        $amountPaid =
            (float)
            $order->payments->sum(
                'amount'
            );


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'data' => [

                'order' => [

                    'id' =>
                        $order->id,

                    'order_no' =>
                        $order->order_no,

                    'invoice_no' =>
                        $order->invoice?->invoice_no,

                    'order_status' =>
                        $order->order_status,

                    'payment_status' =>
                        $order->payment_status,

                    'grand_total' =>
                        (float)
                        $order->grand_total,

                    'amount_paid' =>
                        (float)
                        $order->amount_paid,

                    'balance' =>
                        (float)
                        $order->balance,

                    'discount' =>
                        (float) $order->discount,

                    'tax' =>
                        (float) $order->tax,

                    'change_given' =>
                        (float) $order->change_given,

                    'customer' =>
                        $order->customer
                            ? $order->customer->displayName()
                            : 'Walk-in Customer',

                    'branch' =>
                        $order->branch?->name,

                    'terminal' =>
                        $order->terminal
                            ? $order->terminal->displayName()
                            : null,

                ],

                'payments' =>
                    $order->payments
                        ->map(
                            function ($payment) {

                                return [

                                    'id' =>
                                        $payment->id,

                                    'payment_number' =>
                                        $payment->payment_number,

                                    'payment_method' =>
                                        $payment->payment_method,

                                    'payment_status' =>
                                        $payment->payment_status,

                                    'amount' =>
                                        (float)
                                        $payment->amount,

                                    'payment_date' =>
                                        $payment->payment_date,

                                    'reference_no' =>
                                        $payment->reference_no,

                                    'transaction_reference' =>
                                        $payment->transaction_reference,

                                ];

                            }
                        )
                        ->values(),

                'total_paid' =>
                    $amountPaid,

            ],

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Details
    |--------------------------------------------------------------------------
    */

    /**
     * Return Sales Return details.
     */
    public function details(
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('sales.returns.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view sales returns.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Query
        |--------------------------------------------------------------------------
        */

        $query =
            SalesReturn::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->with([

                    'order.invoice',

                    'customer',

                    'branch',

                    'processedBy',

                    'payments.payment',

                    'terminal',

                ]);


        /*
        |--------------------------------------------------------------------------
        | Branch Access
        |--------------------------------------------------------------------------
        */

        if (
            ! canManageAllBranches()
        ) {

            $query->where(
                'branch_id',
                currentBranchId()
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Return
        |--------------------------------------------------------------------------
        */

        $return =
            $query->find(
                $id
            );


        if (! $return) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Sales return not found.',

            ], 404);

        }


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'data' => [

                'id' =>
                    $return->id,

                'return_number' =>
                    $return->return_number,

                'return_status' =>
                    $return->return_status,

                'refund_amount' =>
                    (float)
                    $return->refund_amount,

                'return_date' =>
                    $return->return_date,

                'reference_no' =>
                    $return->reference_no,

                'remarks' =>
                    $return->remarks,

                'order' => $return->order
                    ? [

                        'id' =>
                            $return->order->id,

                        'order_no' =>
                            $return->order->order_no,

                        'invoice_no' =>
                            $return->order
                                ->invoice
                                ?->invoice_no,

                        'order_status' =>
                            $return->order->order_status,

                        'payment_status' =>
                            $return->order->payment_status,

                        'grand_total' =>
                            (float)
                            $return->order->grand_total,

                        'amount_paid' =>
                            (float)
                            $return->order->amount_paid,

                        'balance' =>
                            (float)
                            $return->order->balance,

                    ]
                    : null,

                'customer' => $return->customer
                    ? [

                        'id' =>
                            $return->customer->id,

                        'name' =>
                            $return->customer->displayName(),

                        'code' =>
                            $return->customer->customer_code,

                    ]
                    : null,

                'branch' => $return->branch
                    ? [

                        'id' =>
                            $return->branch->id,

                        'name' =>
                            $return->branch->name,

                    ]
                    : null,

                'terminal' => $return->terminal 
                    ? [ 
                        'id' => 
                            $return->terminal->id, 

                        'name' => 
                            $return->terminal->displayName(), 
                        ] 
                        : null,

                'processed_by' =>
                    $return->processedBy
                        ? trim(
                            $return->processedBy->first_name .
                            ' ' .
                            $return->processedBy->last_name
                        )
                        : null,                

                'created_at' =>
                    $return->created_at,

                'updated_at' =>
                    $return->updated_at,

            ],

        ]);

    }


   /**
     * |--------------------------------------------------------------------------
     * | Process Refund
     * |--------------------------------------------------------------------------
     */

    /**
     * Process a full refund for an order.
     */
    public function process(
        Request $request,
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (!canAccess('sales.returns.create')) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to process refunds.',
            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | Transaction
        |--------------------------------------------------------------------------
        */

        try {

            $result = DB::transaction(
                function () use ($request, $id) {

                    /*
                    |--------------------------------------------------------------------------
                    | Order
                    |--------------------------------------------------------------------------
                    */

                    $orderQuery = Order::query()
                        ->where(
                            'company_id',
                            $this->companyId
                        )
                        ->with([
                            'orderItems.product',
                            'payments',
                            'invoice.invoiceItems',
                        ]);

                    if (!canManageAllBranches()) {
                        $orderQuery->where(
                            'branch_id',
                            currentBranchId()
                        );
                    }

                    $order = $orderQuery
                        ->lockForUpdate()
                        ->find($id);

                    if (!$order) {
                        throw new \RuntimeException(
                            'Order not found.'
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Eligibility
                    |--------------------------------------------------------------------------
                    */

                    if (!in_array(
                        $order->order_status,
                        [
                            'Completed',
                            'Held',
                        ],
                        true
                    )) {
                        throw new \RuntimeException(
                            'This order has already been processed or is not eligible for refund.'
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Order Items
                    |--------------------------------------------------------------------------
                    */

                    if ($order->orderItems->isEmpty()) {
                        throw new \RuntimeException(
                            'This order has no items available for refund.'
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Completed Payments
                    |--------------------------------------------------------------------------
                    */

                    $completedPayments = Payment::query()
                        ->where(
                            'company_id',
                            $this->companyId
                        )
                        ->where(
                            'order_id',
                            $order->id
                        )
                        ->where(
                            'payment_status',
                            'Completed'
                        )
                        ->lockForUpdate()
                        ->get();

                    if ($completedPayments->isEmpty()) {
                        throw new \RuntimeException(
                            'This order has no completed payment available for refund.'
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Refund Amount
                    |--------------------------------------------------------------------------
                    |
                    | Full refunds return the actual amount charged
                    | on the order.
                    |
                    | Any change given to the customer is excluded
                    | from the refund.
                    |
                    */

                    $refundAmount = (float) $order->grand_total;

                    if ($refundAmount <= 0) {
                        throw new \RuntimeException(
                            'This order has no amount available for refund.'
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Return Number
                    |--------------------------------------------------------------------------
                    */

                    $returnNumber =
                        'RET-' .
                        str_pad(
                            (string) (
                                SalesReturn::query()
                                    ->where(
                                        'company_id',
                                        $this->companyId
                                    )
                                    ->lockForUpdate()
                                    ->count() + 1
                            ),
                            6,
                            '0',
                            STR_PAD_LEFT
                        );

                    /*
                    |--------------------------------------------------------------------------
                    | Sales Return
                    |--------------------------------------------------------------------------
                    */

                    $salesReturn = SalesReturn::create([
                        'company_id' => $this->companyId,

                        'branch_id' =>
                            $order->branch_id,

                        'terminal_id' =>
                            $order->terminal_id,

                        'order_id' =>
                            $order->id,

                        'invoice_id' =>
                            $order->invoice?->id,

                        'customer_id' =>
                            $order->customer_id,

                        'return_number' =>
                            $returnNumber,

                        'return_type' =>
                            'Completed',

                        'order_total' =>
                            (float) $order->grand_total,

                        'amount_paid' =>
                            (float) $order->amount_paid,

                        'balance' =>
                            (float) $order->balance,

                        'refund_amount' =>
                            $refundAmount,

                        'refund_method' =>
                            $completedPayments
                                ->pluck('payment_method')
                                ->unique()
                                ->count() === 1
                                ? $completedPayments
                                    ->first()
                                    ->payment_method
                                : 'Multiple',

                        'return_status' =>
                            'Completed',

                        'reason' =>
                            'Full refund',

                        'remarks' =>
                            $request->input(
                                'remarks',
                                'Full refund processed for sales order: ' .
                                $order->order_no
                            ),

                        'processed_by' =>
                            auth()->id(),

                        'processed_at' =>
                            now(),

                        'created_by' =>
                            auth()->id(),

                        'updated_by' =>
                            auth()->id(),
                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | Sales Return Items
                    |--------------------------------------------------------------------------
                    |
                    | A full refund returns every order item.
                    |
                    | We snapshot the original OrderItem values so
                    | historical return reporting remains independent
                    | of future Product changes.
                    |
                    */

                    foreach ($order->orderItems as $orderItem) {

                        if (!$orderItem->product_id) {
                            continue;
                        }

                        $quantity =
                            (float) $orderItem->quantity;

                        if ($quantity <= 0) {
                            continue;
                        }

                        SalesReturnItem::create([
                            'company_id' =>
                                $this->companyId,

                            'sales_return_id' =>
                                $salesReturn->id,

                            'order_item_id' =>
                                $orderItem->id,

                            'product_id' =>
                                $orderItem->product_id,

                            'product_name' =>
                                $orderItem->product_name,

                            'product_barcode' =>
                                $orderItem->product_barcode,

                            'quantity' =>
                                $quantity,

                            'unit_price' =>
                                (float) $orderItem->unit_price,

                            'unit_cost' =>
                                (float) $orderItem->unit_cost,

                            'discount' =>
                                (float) $orderItem->discount,

                            'tax' =>
                                (float) $orderItem->tax,

                            'total' =>
                                (float) $orderItem->total,
                        ]);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Refund Payments
                    |--------------------------------------------------------------------------
                    |
                    | Record each completed payment against the sales
                    | return before changing the original payment status.
                    |
                    */

                    foreach ($completedPayments as $payment) {

                        SalesReturnPayment::create([
                            'sales_return_id' =>
                                $salesReturn->id,

                            'payment_id' =>
                                $payment->id,

                            'amount' =>
                                (float) $payment->amount,
                        ]);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Payment Status
                    |--------------------------------------------------------------------------
                    */

                    Payment::query()
                        ->where(
                            'company_id',
                            $this->companyId
                        )
                        ->where(
                            'order_id',
                            $order->id
                        )
                        ->where(
                            'payment_status',
                            'Completed'
                        )
                        ->update([
                            'payment_status' =>
                                'Refunded',

                            'updated_at' =>
                                now(),
                        ]);

                    /*
                    |--------------------------------------------------------------------------
                    | Stock
                    |--------------------------------------------------------------------------
                    |
                    | Only Completed orders return stock.
                    |
                    */

                    if (
                        $order->order_status ===
                        'Completed'
                    ) {

                        foreach (
                            $order->orderItems
                            as $orderItem
                        ) {

                            if (!$orderItem->product_id) {
                                continue;
                            }

                            $stock = ProductStock::query()
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
                                    $orderItem->product_id
                                )
                                ->lockForUpdate()
                                ->first();

                            if (!$stock) {
                                throw new \RuntimeException(
                                    'Stock record not found for product: ' .
                                    $orderItem->product_name
                                );
                            }

                            $quantity =
                                (float) $orderItem->quantity;

                            $stockBefore =
                                (float) $stock->quantity;

                            $stock->quantity =
                                $stockBefore +
                                $quantity;

                            $stock->syncAvailableQuantity();

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
                                    $orderItem->product_id,

                                'order_id' =>
                                    $order->id,

                                'reference_no' =>
                                    $salesReturn->return_number,

                                /*
                                * Use the historical cost captured
                                * on the original OrderItem.
                                */
                                'unit_cost' =>
                                    (float) $orderItem->unit_cost,

                                'quantity' =>
                                    $quantity,

                                'stock_before' =>
                                    $stockBefore,

                                'balance_after' =>
                                    (float) $stock->quantity,

                                'remarks' =>
                                    'Stock returned from sales refund: ' .
                                    $order->order_no,

                                'created_by' =>
                                    auth()->id(),

                                'movement_type' =>
                                    'Return',
                            ]);
                        }
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Order
                    |--------------------------------------------------------------------------
                    */

                    $order->order_status =
                        'Refunded';

                    $order->payment_status =
                        'Refunded';

                    $order->amount_paid =
                        0;

                    $order->balance =
                        0;

                    $order->change_given =
                        0;

                    $order->updated_by =
                        auth()->id();

                    $order->save();

                    /*
                    |--------------------------------------------------------------------------
                    | Invoice
                    |--------------------------------------------------------------------------
                    */

                    if ($order->invoice) {

                        $invoice =
                            $order->invoice;

                        $invoice->payment_status =
                            'Refunded';

                        $invoice->invoice_status =
                            'Refunded';

                        $invoice->amount_paid =
                            0;

                        $invoice->balance =
                            0;

                        $invoice->updated_by =
                            auth()->id();

                        $invoice->save();
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Activity Log
                    |--------------------------------------------------------------------------
                    */

                    $this->activityLogger->log(
                        'sales_returns',
                        'create',
                        'Full refund processed for sales order: ' .
                            $order->order_no,
                        $salesReturn,
                        null,
                        [
                            'return_number' =>
                                $salesReturn->return_number,

                            'order_id' =>
                                $order->id,

                            'refund_amount' =>
                                $refundAmount,

                            'return_type' =>
                                'Full',
                        ]
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | Result
                    |--------------------------------------------------------------------------
                    */

                    return $salesReturn;
                }
            );

            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'success' => true,

                'message' =>
                    'Refund processed successfully.',

                'data' => [
                    'id' =>
                        $result->id,

                    'return_number' =>
                        $result->return_number,

                    'refund_amount' =>
                        (float) $result->refund_amount,
                ],
            ]);

        } catch (\Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,

                'message' =>
                    $e->getMessage()
                    ?:
                    'Unable to process refund.',
            ], 422);
        }
    }
    /**
     * --------------------------------------------------------------------------
     * Process Partial Return
     * --------------------------------------------------------------------------
     *
     * Processes selected quantities from an existing sales order.
     *
     * Rules:
     * - Only quantities that have not already been returned may be returned.
     * - Historical OrderItem financial snapshots are used.
     * - OrderItem.unit_cost is used for returned COGS.
     * - SalesReturnItem records the exact returned quantities.
     * - SalesReturnPayment records how the refund relates to original payments.
     * - Original Payment records are not marked Refunded for a partial return.
     * - The order remains Completed until every item has been fully returned.
     * - Once every item is fully returned, the order becomes Refunded.
     *
     */
    public function processPartial(
        Request $request,
        int $id
    ): JsonResponse {
        if (!canAccess('sales.returns.create')) {
            abort(403);
        }

        $validated = $request->validate([
            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.order_item_id' => [
                'required',
                'integer',
                'distinct',
            ],

            'items.*.quantity' => [
                'required',
                'numeric',
                'gt:0',
            ],

            'remarks' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $user = $request->user();

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Find and lock order
            |--------------------------------------------------------------------------
            */

            $orderQuery = Order::query()
                ->where('company_id', $this->companyId)
                ->whereIn('order_status', [
                    'Completed',
                    'Held',
                ])
                ->with([
                    'orderItems',
                    'payments',
                    'invoice',
                ])
                ->lockForUpdate();

            if (!canManageAllBranches()) {
                $orderQuery->where(
                    'branch_id',
                    currentBranchId()
                );
            }

            $order = $orderQuery->find($id);

            if (!$order) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'The selected order could not be found or is not eligible for a return.',
                ], 404);
            }

            /*
            |--------------------------------------------------------------------------
            | Requested OrderItem IDs
            |--------------------------------------------------------------------------
            */

            $requestedItemIds = collect(
                $validated['items']
            )
                ->pluck('order_item_id')
                ->map(fn ($itemId) => (int) $itemId)
                ->values();

            /*
            |--------------------------------------------------------------------------
            | Verify that every requested item belongs to this order
            |--------------------------------------------------------------------------
            */

            $orderItems = $order->orderItems
                ->whereIn('id', $requestedItemIds)
                ->keyBy('id');

            if (
                $orderItems->count()
                !==
                $requestedItemIds->count()
            ) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'One or more selected items do not belong to this order.',
                ], 422);
            }

            /*
            |--------------------------------------------------------------------------
            | Lock selected OrderItems
            |--------------------------------------------------------------------------
            */

            $lockedOrderItems = OrderItem::query()
                ->where('company_id', $this->companyId)
                ->where('order_id', $order->id)
                ->whereIn('id', $requestedItemIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if (
                $lockedOrderItems->count()
                !==
                $requestedItemIds->count()
            ) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'One or more selected items could not be locked for processing.',
                ], 422);
            }

            /*
            |--------------------------------------------------------------------------
            | Completed payments
            |--------------------------------------------------------------------------
            */

            $completedPayments = $order->payments
                ->where(
                    'payment_status',
                    'Completed'
                )
                ->values();

            if ($completedPayments->isEmpty()) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'This order does not have any completed payments available for refund.',
                ], 422);
            }

            /*
            |--------------------------------------------------------------------------
            | Existing returned quantities
            |--------------------------------------------------------------------------
            |
            | This prevents a customer from returning more units than were
            | originally sold, even when multiple partial returns are processed.
            |
            */

            $returnedQuantities = SalesReturnItem::query()
                ->where('company_id', $this->companyId)
                ->whereIn(
                    'order_item_id',
                    $requestedItemIds
                )
                ->whereHas(
                    'salesReturn',
                    function ($query) use ($order) {
                        $query
                            ->where(
                                'company_id',
                                $this->companyId
                            )
                            ->where(
                                'order_id',
                                $order->id
                            )
                            ->where(
                                'return_status',
                                'Completed'
                            );
                    }
                )
                ->selectRaw(
                    'order_item_id, SUM(quantity) as returned_quantity'
                )
                ->groupBy('order_item_id')
                ->pluck(
                    'returned_quantity',
                    'order_item_id'
                );

            /*
            |--------------------------------------------------------------------------
            | Prepare return calculations
            |--------------------------------------------------------------------------
            */

            $returnItems = [];

            $returnAmount = 0.00;
            $returnedCogs = 0.00;
            $totalReturnQuantity = 0.00;

            foreach ($validated['items'] as $requestedItem) {

                $orderItemId = (int) $requestedItem[
                    'order_item_id'
                ];

                $requestedQuantity = round(
                    (float) $requestedItem['quantity'],
                    2
                );

                $orderItem = $lockedOrderItems->get(
                    $orderItemId
                );

                if (!$orderItem) {
                    throw new \RuntimeException(
                        'One or more selected order items could not be found.'
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Original quantity
                |--------------------------------------------------------------------------
                */

                $originalQuantity = round(
                    (float) $orderItem->quantity,
                    2
                );

                /*
                |--------------------------------------------------------------------------
                | Previously returned quantity
                |--------------------------------------------------------------------------
                */

                $alreadyReturned = round(
                    (float) (
                        $returnedQuantities[$orderItemId] ?? 0
                    ),
                    2
                );

                /*
                |--------------------------------------------------------------------------
                | Remaining quantity
                |--------------------------------------------------------------------------
                */

                $availableQuantity = round(
                    max(
                        0,
                        $originalQuantity - $alreadyReturned
                    ),
                    2
                );

                if ($availableQuantity <= 0) {
                    throw new \RuntimeException(
                        sprintf(
                            '"%s" has already been fully returned.',
                            $orderItem->product_name
                        )
                    );
                }

                if (
                    $requestedQuantity
                    >
                    $availableQuantity
                ) {
                    throw new \RuntimeException(
                        sprintf(
                            'The requested return quantity for "%s" exceeds the available quantity of %s.',
                            $orderItem->product_name,
                            number_format(
                                $availableQuantity,
                                2
                            )
                        )
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Proportional financial calculation
                |--------------------------------------------------------------------------
                */

                $ratio = $originalQuantity > 0
                    ? $requestedQuantity / $originalQuantity
                    : 0;

                $returnDiscount = round(
                    (float) $orderItem->discount * $ratio,
                    2
                );

                $returnTax = round(
                    (float) $orderItem->tax * $ratio,
                    2
                );

                $returnTotal = round(
                    (float) $orderItem->total * $ratio,
                    2
                );

                /*
                |--------------------------------------------------------------------------
                | Historical unit cost
                |--------------------------------------------------------------------------
                */

                $unitCost = round(
                    (float) $orderItem->unit_cost,
                    2
                );

                $itemReturnedCogs = round(
                    $requestedQuantity * $unitCost,
                    2
                );

                /*
                |--------------------------------------------------------------------------
                | Accumulate totals
                |--------------------------------------------------------------------------
                */

                $returnAmount = round(
                    $returnAmount + $returnTotal,
                    2
                );

                $returnedCogs = round(
                    $returnedCogs + $itemReturnedCogs,
                    2
                );

                $totalReturnQuantity = round(
                    $totalReturnQuantity + $requestedQuantity,
                    2
                );

                /*
                |--------------------------------------------------------------------------
                | Prepare SalesReturnItem snapshot
                |--------------------------------------------------------------------------
                */

                $returnItems[] = [
                    'company_id' => $this->companyId,

                    'order_item_id' => $orderItem->id,

                    'product_id' => $orderItem->product_id,

                    'product_name' => $orderItem->product_name,

                    'product_barcode' =>
                        $orderItem->product_barcode,

                    'quantity' => $requestedQuantity,

                    'unit_price' =>
                        (float) $orderItem->unit_price,

                    'unit_cost' => $unitCost,

                    'discount' => $returnDiscount,

                    'tax' => $returnTax,

                    'total' => $returnTotal,
                ];
            }

            if ($returnAmount <= 0) {
                throw new \RuntimeException(
                    'The selected return amount must be greater than zero.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Calculate remaining refundable amounts per payment
            |--------------------------------------------------------------------------
            |
            | A payment may already have been used by an earlier partial return.
            | We therefore subtract existing SalesReturnPayment amounts from
            | each original payment before allocating this refund.
            |
            */

            $paymentIds = $completedPayments
                ->pluck('id')
                ->values();

            $previousRefunds = SalesReturnPayment::query()
                ->whereIn(
                    'payment_id',
                    $paymentIds
                )
                ->whereHas(
                    'salesReturn',
                    function ($query) {
                        $query
                            ->where(
                                'company_id',
                                $this->companyId
                            )
                            ->where(
                                'return_status',
                                'Completed'
                            );
                    }
                )
                ->selectRaw(
                    'payment_id, SUM(amount) as refunded_amount'
                )
                ->groupBy('payment_id')
                ->pluck(
                    'refunded_amount',
                    'payment_id'
                );

            /*
            |--------------------------------------------------------------------------
            | Determine available refundable payment amount
            |--------------------------------------------------------------------------
            */

            $remainingPaymentAmounts = [];

            $totalRefundableAmount = 0.00;

            foreach ($completedPayments as $payment) {

                $originalPaymentAmount = round(
                    (float) $payment->amount,
                    2
                );

                $previouslyRefunded = round(
                    (float) (
                        $previousRefunds[$payment->id] ?? 0
                    ),
                    2
                );

                $remainingAmount = round(
                    max(
                        0,
                        $originalPaymentAmount
                        -
                        $previouslyRefunded
                    ),
                    2
                );

                $remainingPaymentAmounts[
                    $payment->id
                ] = $remainingAmount;

                $totalRefundableAmount = round(
                    $totalRefundableAmount
                    +
                    $remainingAmount,
                    2
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Validate refund against remaining paid amount
            |--------------------------------------------------------------------------
            */

            if (
                $returnAmount
                >
                $totalRefundableAmount
            ) {
                throw new \RuntimeException(
                    sprintf(
                        'The selected return amount of %s exceeds the remaining refundable amount of %s for this order.',
                        number_format(
                            $returnAmount,
                            2
                        ),
                        number_format(
                            $totalRefundableAmount,
                            2
                        )
                    )
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Determine refund method
            |--------------------------------------------------------------------------
            */

            $refundMethod = $completedPayments->count() === 1
                ? $completedPayments->first()->payment_method
                : 'Multiple';

            
            /*
            |--------------------------------------------------------------------------
            | Return Number
            |--------------------------------------------------------------------------
            */

            $returnNumber =
                'RET-' .
                str_pad(
                    (string) (
                        SalesReturn::query()
                            ->where(
                                'company_id',
                                $this->companyId
                            )
                            ->lockForUpdate()
                            ->count() + 1
                    ),
                    6,
                    '0',
                    STR_PAD_LEFT
                );

            /*
            |--------------------------------------------------------------------------
            | Create SalesReturn
            |--------------------------------------------------------------------------
            */

            $salesReturn = SalesReturn::create([
                'company_id' => $this->companyId,

                'branch_id' => $order->branch_id,

                'terminal_id' => $order->terminal_id,

                'order_id' => $order->id,

                'invoice_id' => $order->invoice?->id,

                'customer_id' => $order->customer_id,

                'return_number' => $returnNumber,

                /*
                * return_type describes the processing state/type
                * already established by the existing schema.
                */
                'return_type' => 'Completed',

                'order_total' =>
                    (float) $order->grand_total,

                'amount_paid' =>
                    (float) $order->amount_paid,

                'balance' =>
                    (float) $order->balance,

                'refund_amount' => $returnAmount,

                'refund_method' => $refundMethod,

                'return_status' => 'Completed',

                'reason' => 'Partial return',

                'remarks' =>
                    $validated['remarks'] ?? null,

                'processed_by' => $user?->id,

                'processed_at' => now(),

                'created_by' => $user?->id,

                'updated_by' => $user?->id,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Create SalesReturnItem records
            |--------------------------------------------------------------------------
            */

            foreach ($returnItems as $returnItem) {
                $salesReturn->items()->create(
                    $returnItem
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Allocate refund against original payments
            |--------------------------------------------------------------------------
            */

            $remainingRefund = $returnAmount;

            foreach ($completedPayments as $payment) {

                if ($remainingRefund <= 0) {
                    break;
                }

                $availablePaymentRefund = round(
                    (float) (
                        $remainingPaymentAmounts[
                            $payment->id
                        ] ?? 0
                    ),
                    2
                );

                if ($availablePaymentRefund <= 0) {
                    continue;
                }

                $refundForPayment = round(
                    min(
                        $remainingRefund,
                        $availablePaymentRefund
                    ),
                    2
                );

                if ($refundForPayment <= 0) {
                    continue;
                }

                SalesReturnPayment::create([
                    'sales_return_id' =>
                        $salesReturn->id,

                    'payment_id' =>
                        $payment->id,

                    'amount' =>
                        $refundForPayment,
                ]);

                $remainingRefund = round(
                    $remainingRefund
                    -
                    $refundForPayment,
                    2
                );
            }

            if ($remainingRefund > 0) {
                throw new \RuntimeException(
                    'Unable to allocate the complete refund amount against the original payments.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Restore stock
            |--------------------------------------------------------------------------
            */

            foreach ($returnItems as $returnItem) {

                $productStock = ProductStock::query()
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
                        $returnItem['product_id']
                    )
                    ->lockForUpdate()
                    ->first();

                if (!$productStock) {
                    throw new \RuntimeException(
                        sprintf(
                            'Stock record not found for "%s".',
                            $returnItem['product_name']
                        )
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Stock before
                |--------------------------------------------------------------------------
                */

                $stockBefore = round(
                    (float) $productStock->quantity,
                    2
                );

                /*
                |--------------------------------------------------------------------------
                | Restore returned quantity
                |--------------------------------------------------------------------------
                */

                $newStockQuantity = round(
                    $stockBefore
                    +
                    (float) $returnItem['quantity'],
                    2
                );

                $productStock->quantity =
                    $newStockQuantity;

                $productStock->save();

                /*
                |--------------------------------------------------------------------------
                | Stock movement
                |--------------------------------------------------------------------------
                */

                StockMovement::create([
                    'company_id' =>
                        $this->companyId,

                    'branch_id' =>
                        $order->branch_id,

                    'product_id' =>
                        $returnItem['product_id'],

                    'order_id' =>
                        $order->id,

                    'reference_no' =>
                        $salesReturn->return_number,

                    /*
                    * Historical cost from OrderItem.
                    */
                    'unit_cost' =>
                        $returnItem['unit_cost'],

                    'quantity' =>
                        $returnItem['quantity'],

                    'stock_before' =>
                        $stockBefore,

                    'balance_after' =>
                        $newStockQuantity,

                    'movement_type' =>
                        'Return',

                    'remarks' => sprintf(
                        'Partial return for sales order %s.',
                        $order->order_no
                    ),

                    'created_by' =>
                        $user?->id,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Determine whether the complete order has now been returned
            |--------------------------------------------------------------------------
            */

            $allOrderItemIds = $order->orderItems
                ->pluck('id');

            $allReturnedQuantities = SalesReturnItem::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->whereIn(
                    'order_item_id',
                    $allOrderItemIds
                )
                ->whereHas(
                    'salesReturn',
                    function ($query) use ($order) {
                        $query
                            ->where(
                                'company_id',
                                $this->companyId
                            )
                            ->where(
                                'order_id',
                                $order->id
                            )
                            ->where(
                                'return_status',
                                'Completed'
                            );
                    }
                )
                ->selectRaw(
                    'order_item_id, SUM(quantity) as returned_quantity'
                )
                ->groupBy('order_item_id')
                ->pluck(
                    'returned_quantity',
                    'order_item_id'
                );

            $fullyReturned = true;

            foreach ($order->orderItems as $orderItem) {

                $soldQuantity = round(
                    (float) $orderItem->quantity,
                    2
                );

                $returnedQuantity = round(
                    (float) (
                        $allReturnedQuantities[
                            $orderItem->id
                        ] ?? 0
                    ),
                    2
                );

                if (
                    $returnedQuantity
                    <
                    $soldQuantity
                ) {
                    $fullyReturned = false;

                    break;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Fully returned order
            |--------------------------------------------------------------------------
            */

            if ($fullyReturned) {

                $order->update([
                    'order_status' => 'Refunded',

                    'payment_status' => 'Refunded',

                    'amount_paid' => 0,

                    'balance' => 0,

                    'change_given' => 0,

                    'updated_by' => $user?->id,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Mark original payments refunded
                |--------------------------------------------------------------------------
                |
                | At this point the entire order has been returned, so the
                | original payment records can follow the existing full-return
                | workflow.
                |
                */

                foreach ($completedPayments as $payment) {
                    $payment->update([
                        'payment_status' => 'Refunded',
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Update invoice
                |--------------------------------------------------------------------------
                */

                if ($order->invoice) {
                    $order->invoice->update([
                        'status' => 'Refunded',
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(
                'sales_returns',
                'partial_return',
                sprintf(
                    'Processed partial return %s for sales order %s. Refund amount: %s. Returned quantity: %s.',
                    $salesReturn->return_number,
                    $order->order_no,
                    number_format(
                        $returnAmount,
                        2
                    ),
                    number_format(
                        $totalReturnQuantity,
                        2
                    )
                ),
                $salesReturn,
                null,
                [
                    'refund_amount' =>
                        $returnAmount,

                    'returned_cogs' =>
                        $returnedCogs,

                    'returned_quantity' =>
                        $totalReturnQuantity,

                    'fully_returned' =>
                        $fullyReturned,
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | Commit
            |--------------------------------------------------------------------------
            */

            DB::commit();

            return response()->json([
                'success' => true,

                'message' => $fullyReturned
                    ? 'The selected items were returned successfully and the order is now fully refunded.'
                    : 'The selected items were returned successfully.',

                'data' => [
                    'return_id' =>
                        $salesReturn->id,

                    'return_number' =>
                        $salesReturn->return_number,

                    'refund_amount' =>
                        $returnAmount,

                    'returned_quantity' =>
                        $totalReturnQuantity,

                    'returned_cogs' =>
                        $returnedCogs,

                    'fully_returned' =>
                        $fullyReturned,
                ],
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            report($e);

            return response()->json([
                'success' => false,

                'message' =>
                    $e->getMessage()
                    ?: 'Unable to process the partial return.',
            ], 422);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Receipt
    |--------------------------------------------------------------------------
    */

    /**
     * Display the Sales Return / Refund receipt.
     */
    public function receipt(
        int $id
    ): View {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('sales.returns.view')) {

            abort(
                403,
                'You do not have permission to view sales returns.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Query
        |--------------------------------------------------------------------------
        */

        $query =
            SalesReturn::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->with([

                    'company',

                    'branch',

                    'terminal',

                    'order.invoice',

                    'customer',

                    'processedBy',

                ]);


        /*
        |--------------------------------------------------------------------------
        | Branch Access
        |--------------------------------------------------------------------------
        */

        if (
            ! canManageAllBranches()
        ) {

            $query->where(
                'branch_id',
                currentBranchId()
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Return
        |--------------------------------------------------------------------------
        */

        $return =
            $query->findOrFail(
                $id
            );


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view(
            'sales.returns.receipt',
            compact(
                'return'
            )
        );

    }


   /*
    |--------------------------------------------------------------------------
    | Order Items
    |--------------------------------------------------------------------------
    */

    /**
     * Return order items for refund review.
     */
    public function orderItems(
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('sales.returns.view')) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to view sales returns.',
            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | Order
        |--------------------------------------------------------------------------
        */

        $query = Order::query()
            ->where(
                'company_id',
                $this->companyId
            )
            ->with([
                'orderItems.product',
                'branch',
                'invoice',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Branch Access
        |--------------------------------------------------------------------------
        */

        if (! canManageAllBranches()) {
            $query->where(
                'branch_id',
                currentBranchId()
            );
        }

        $order = $query->find($id);

        if (! $order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.',
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | Returned Quantities
        |--------------------------------------------------------------------------
        |
        | Only completed returns reduce the quantity available for another
        | return. Pending, cancelled, and failed returns are ignored.
        |
        */

        $returnedQuantities = SalesReturnItem::query()
            ->where(
                'company_id',
                $this->companyId
            )
            ->whereIn(
                'order_item_id',
                $order->orderItems->pluck('id')
            )
            ->whereHas('salesReturn', function ($query) use ($order) {
                $query
                    ->where(
                        'company_id',
                        $this->companyId
                    )
                    ->where(
                        'order_id',
                        $order->id
                    )
                    ->where(
                        'return_status',
                        'Completed'
                    );
            })
            ->selectRaw(
                'order_item_id, SUM(quantity) as returned_quantity'
            )
            ->groupBy('order_item_id')
            ->pluck(
                'returned_quantity',
                'order_item_id'
            );

        /*
        |--------------------------------------------------------------------------
        | Items
        |--------------------------------------------------------------------------
        */

        $items = $order->orderItems
            ->map(function ($item) use ($returnedQuantities) {

                $soldQuantity = (float) $item->quantity;

                $returnedQuantity = (float) (
                    $returnedQuantities[$item->id] ?? 0
                );

                $availableQuantity = max(
                    0,
                    $soldQuantity - $returnedQuantity
                );

                return [
                    'id' => $item->id,

                    'product_id' => $item->product_id,

                    'product_name' =>
                        $item->product_name
                        ?? $item->product?->name
                        ?? '—',

                    'sku' =>
                        $item->product?->sku
                        ?? $item->sku
                        ?? '—',

                    'quantity' =>
                        $soldQuantity,

                    'returned_quantity' =>
                        $returnedQuantity,

                    'available_quantity' =>
                        $availableQuantity,

                    'unit_price' =>
                        (float) $item->unit_price,

                    'discount' =>
                        (float) $item->discount,

                    'tax' =>
                        (float) $item->tax,

                    'line_total' =>
                        (float) (
                            $item->line_total
                            ??
                            $item->total
                            ??
                            (
                                $item->quantity
                                * $item->unit_price
                            )
                        ),
                ];
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,

            'data' => [

                'order' => [
                    'id' =>
                        $order->id,

                    'order_no' =>
                        $order->order_no,

                    'invoice_no' =>
                        $order->invoice?->invoice_no,

                    'branch_name' =>
                        $order->branch?->name,

                    'grand_total' =>
                        (float) $order->grand_total,

                    'amount_paid' =>
                        (float) $order->amount_paid,

                    'balance' =>
                        (float) $order->balance,

                    'payment_status' =>
                        $order->payment_status,
                ],

                'items' =>
                    $items,
            ],
        ]);
    }



}