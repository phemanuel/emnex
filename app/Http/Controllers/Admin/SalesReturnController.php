<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Models\ProductStock;
use App\Models\SalesReturn;
use App\Models\SalesReturnPayment;
use App\Models\StockMovement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Services\ActivityLogger;

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


    /*
    |--------------------------------------------------------------------------
    | Process Refund
    |--------------------------------------------------------------------------
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

        if (! canAccess('sales.returns.create')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to process refunds.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Transaction
        |--------------------------------------------------------------------------
        */

        try {

            $result =
                DB::transaction(
                    function () use (
                        $request,
                        $id
                    ) {

                        /*
                        |--------------------------------------------------------------------------
                        | Order
                        |--------------------------------------------------------------------------
                        */

                        $orderQuery =
                            Order::query()
                                ->where(
                                    'company_id',
                                    $this->companyId
                                )
                                ->with([

                                    'orderItems.product',

                                    'payments',

                                    'invoice.invoiceItems',

                                ]);


                        if (
                            ! canManageAllBranches()
                        ) {

                            $orderQuery->where(
                                'branch_id',
                                currentBranchId()
                            );

                        }


                        $order =
                            $orderQuery->lockForUpdate()
                                ->find(
                                    $id
                                );


                        if (! $order) {

                            throw new \RuntimeException(
                                'Order not found.'
                            );

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Eligibility
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

                            throw new \RuntimeException(
                                'This order has already been processed or is not eligible for refund.'
                            );

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Completed Payments
                        |--------------------------------------------------------------------------
                        */

                        $payments =
                            $order->payments
                                ->where(
                                    'payment_status',
                                    'Completed'
                                );

                       
                        /*
                        |--------------------------------------------------------------------------
                        | Refund Amount
                        |--------------------------------------------------------------------------
                        |
                        | Full refunds return the actual amount charged on the order.
                        | Any change given to the customer is excluded from the refund.
                        |
                        */

                        $refundAmount =
                            (float)
                            $order->grand_total;


                        if (
                            $refundAmount <= 0
                        ) {

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

                        $salesReturn =
                            SalesReturn::create([

                                'company_id' =>
                                    $this->companyId,

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

                                'order_total' =>
                                    (float)
                                    $order->grand_total,

                                'amount_paid' =>
                                    (float)
                                    $order->amount_paid,

                                'balance' =>
                                    (float)
                                    $order->balance,

                                'refund_amount' =>
                                    $refundAmount,

                                'return_status' =>
                                    'Completed',

                                'return_date' =>
                                    now(),

                                'reference_no' =>
                                    $order->order_no,

                                'remarks' =>
                                    $request->input(
                                        'remarks',
                                        'Full refund processed for sales order: ' .
                                        $order->order_no
                                    ),

                                'processed_by' =>
                                    auth()->id(),

                                'created_by' =>
                                    auth()->id(),

                            ]);



           


                       /*                                                                         |
                        | -------------------------------------------------------------------------- |
                        | Refund Payments                                                            |
                        | -------------------------------------------------------------------------- |
                        |                                                                            |
                        | Record each completed payment against the sales return                     |
                        | before changing the original payment status to Refunded.                   |
                        |                                                                            |
                        | */                                                                         

                        $completedPayments =Payment::query()
                        ->where('company_id',$this->companyId)
                        ->where('order_id', $order->id)
                        ->where('payment_status','Completed')
                        ->lockForUpdate()
                        ->get();

                        if (
                        $completedPayments->isEmpty()
                        ) {
                        throw new \RuntimeException(
                            'This order has no completed payment available for refund.'
                        );

                        }

                         /*                                                                         |
                        | -------------------------------------------------------------------------- |
                        | Sales Return Payments                                                      |
                        | -------------------------------------------------------------------------- |
                        | */                                                                         

                        foreach (
                        $completedPayments as $payment
                        ) {


                        SalesReturnPayment::create([

                            'sales_return_id' =>
                                $salesReturn->id,

                            'payment_id' =>
                                $payment->id,

                            'amount' =>
                                $payment->amount,

                        ]);


                        }

                        /*                                                                         |
                        | -------------------------------------------------------------------------- |
                        | Payment Status                                                             |
                        | -------------------------------------------------------------------------- |
                        | */                                                                         

                        Payment::query()
                        ->where('company_id',$this->companyId)
                        ->where('order_id', $order->id)
                        ->where('payment_status','Completed')
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
                                $order->orderItems as $orderItem
                            ) {

                                if (
                                    ! $orderItem->product_id
                                ) {

                                    continue;

                                }


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
                                            $orderItem->product_id
                                        )
                                        ->lockForUpdate()
                                        ->first();


                                if (! $stock) {

                                    throw new \RuntimeException(
                                        'Stock record not found for product: ' .
                                        $orderItem->product_name
                                    );

                                }


                                $quantity =
                                    (float)
                                    $orderItem->quantity;


                                $stockBefore =
                                    (float)
                                    $stock->quantity;


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

                                    'unit_cost' =>
                                        $orderItem->product
                                            ?->cost_price
                                        ?? 0,

                                    'quantity' =>
                                        $quantity,

                                    'stock_before' =>
                                        $stockBefore,

                                    'balance_after' =>
                                        (float)
                                        $stock->quantity,

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

                        if (
                            $order->invoice
                        ) {

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

                'success' =>
                    true,

                'message' =>
                    'Refund processed successfully.',

                'data' => [

                    'id' =>
                        $result->id,

                    'return_number' =>
                        $result->return_number,

                    'refund_amount' =>
                        (float)
                        $result->refund_amount,

                ],

            ]);

        }
        catch (\Throwable $e) {

            report($e);


            return response()->json([

                'success' =>
                    false,

                'message' =>
                    $e->getMessage()
                    ?:
                    'Unable to process refund.',

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

                    'orderItems.product',

                    'branch',

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
        | Items
        |--------------------------------------------------------------------------
        */

        $items =
            $order->orderItems
                ->map(
                    function (
                        $item
                    ) {

                        return [

                            'id' =>
                                $item->id,

                            'product_id' =>
                                $item->product_id,

                            'product_name' =>
                                $item->product_name
                                ??
                                $item->product?->name
                                ??
                                '—',

                            'sku' =>
                                $item->product?->sku
                                ??
                                $item->sku
                                ??
                                '—',

                            'quantity' =>
                                (float)
                                $item->quantity,

                            'unit_price' =>
                                (float)
                                $item->unit_price,

                            'line_total' =>
                                (float)
                                (
                                    $item->line_total
                                    ??
                                    (
                                        $item->quantity *
                                        $item->unit_price
                                    )
                                ),

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