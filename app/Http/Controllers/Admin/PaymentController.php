<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class PaymentController extends BaseController
{
    protected ActivityLogger $activityLogger;


    public function __construct(ActivityLogger $activityLogger)
    {
        parent::__construct();

        $this->activityLogger = $activityLogger;
    }
     /*                                                                         |
    | -------------------------------------------------------------------------- |
    | Index                                                                      |
    | -------------------------------------------------------------------------- |
    | */                                                                         

    /**

    * Display the Payments module.
    */
    public function index(): mixed
    {

     /*                                                                         |
    | -------------------------------------------------------------------------- |
    | Permission                                                                 |
    | -------------------------------------------------------------------------- |
    | */                                                                         

    if (! canAccess('payments.view')) {

    
    abort(
        403,
        'You do not have permission to view payments.'
    );
    

    }

    /*                                                                         |
    | -------------------------------------------------------------------------- |
    | Branches                                                                   |
    | -------------------------------------------------------------------------- |
    | */                                                                         

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
    

     /*                                                                         |
    | -------------------------------------------------------------------------- |
    | Payment Statistics                                                         |
    | -------------------------------------------------------------------------- |
    | */                                                                         

    $paymentsQuery = Payment::query()->where('company_id',$this->companyId)
    ->when(! canManageAllBranches(),
    function ($query) {    
                $query->where(
                    'branch_id',
                    currentBranchId()
                );

            }
        );
    

     /*                                                                         |
    | -------------------------------------------------------------------------- |
    | KPI Statistics                                                             |
    | -------------------------------------------------------------------------- |
    | */                                                                         

    $paymentTotalCount = (clone $paymentsQuery)->count();

    $paymentCompletedCount = (clone $paymentsQuery)
    ->where('payment_status','Completed')
    ->count();

    $paymentPendingCount = (clone $paymentsQuery)
    ->where('payment_status','Pending')
    ->count();

    $paymentTotalAmount = (clone $paymentsQuery)
    ->where('payment_status','Completed')
    ->sum('amount');

    /*                                                                         |
    | -------------------------------------------------------------------------- |
    | View                                                                       |
    | -------------------------------------------------------------------------- |
    | */                                                                         

    return view('sales.payments.index',compact(
        'branches',
        'paymentTotalCount',
        'paymentCompletedCount',
        'paymentPendingCount',
        'paymentTotalAmount'
        )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Table
    |--------------------------------------------------------------------------
    */

    /**
     * Return Payments table data.
     */
    public function table(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('payments.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view payments.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Query
        |--------------------------------------------------------------------------
        */

        $query =
            Payment::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->with([

                    'order.invoice',

                    'customer',

                    'branch',

                    'terminal',

                    'receivedBy',

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
                        'payment_number',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'reference_no',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'transaction_reference',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'payment_method',
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
        | Payment Status
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('payment_status')
        ) {

            $query->where(
                'payment_status',
                $request->input('payment_status')
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Payment Method
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('payment_method')
        ) {

            $query->where(
                'payment_method',
                $request->input('payment_method')
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
                'payment_date',
                '>=',
                $request->input('date_from')
            );

        }


        if (
            $request->filled('date_to')
        ) {

            $query->whereDate(
                'payment_date',
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


        $payments =
            $query
                ->latest('payment_date')
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

            'total_count' =>
                (clone $statsQuery)
                    ->count(),

            'completed_count' =>
                (clone $statsQuery)
                    ->where(
                        'payment_status',
                        'Completed'
                    )
                    ->count(),

            'pending_count' =>
                (clone $statsQuery)
                    ->where(
                        'payment_status',
                        'Pending'
                    )
                    ->count(),

            'total_amount' =>
                (float)
                (clone $statsQuery)
                    ->where(
                        'payment_status',
                        'Completed'
                    )
                    ->sum('amount'),

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

                'payments' =>
                    $payments
                    ->map(
                    function ($payment) {
                    
                                return [

                                    'id' =>
                                        $payment->id,


                                    'payment_number' =>
                                        $payment->payment_number,


                                    /*
                                    |--------------------------------------------------------------------------
                                    | Order
                                    |--------------------------------------------------------------------------
                                    */

                                    'order_no' =>
                                        $payment->order?->order_no,

                                    'order_status' =>
                                        $payment->order?->order_status,

                                    'order_total' =>
                                        (float)
                                        (
                                            $payment->order?->grand_total
                                            ?? 0
                                        ),

                                    'amount_paid' =>
                                        (float)
                                        (
                                            $payment->order?->amount_paid
                                            ?? 0
                                        ),

                                    'balance' =>
                                        (float)
                                        (
                                            $payment->order?->balance
                                            ?? 0
                                        ),


                                    /*
                                    |--------------------------------------------------------------------------
                                    | Customer
                                    |--------------------------------------------------------------------------
                                    */

                                    'customer' =>
                                        $payment->customer
                                            ? $payment->customer->displayName()
                                            : 'Walk-in Customer',


                                    /*
                                    |--------------------------------------------------------------------------
                                    | Payment
                                    |--------------------------------------------------------------------------
                                    */

                                    'payment_method' =>
                                        $payment->payment_method,

                                    'payment_status' =>
                                        $payment->payment_status,

                                    'amount' =>
                                        (float)
                                        $payment->amount,

                                    'payment_date' =>
                                        $payment->payment_date,


                                    /*
                                    |--------------------------------------------------------------------------
                                    | Location
                                    |--------------------------------------------------------------------------
                                    */

                                    'branch' =>
                                        $payment->branch?->name,

                                    'terminal' =>
                                        $payment->terminal
                                            ? $payment->terminal->displayName()
                                            : null,


                                    /*
                                    |--------------------------------------------------------------------------
                                    | Reference
                                    |--------------------------------------------------------------------------
                                    */

                                    'reference_no' =>
                                        $payment->reference_no,

                                ];

                            }
                        )
                        ->values(),


                'pagination' => [

                    'current_page' =>
                        $payments->currentPage(),

                    'last_page' =>
                        $payments->lastPage(),

                    'per_page' =>
                        $payments->perPage(),

                    'total' =>
                        $payments->total(),

                ],

                'stats' =>
                    $stats,

            ],

        ]);

    }


    /*                                                                         |
    | -------------------------------------------------------------------------- |
    | Details                                                                    |
    | -------------------------------------------------------------------------- |
    | */                                                                         

    /**

    * Return Payment details.
    */
    public function details(
    int $id
    ): JsonResponse {

     /*                                                                         |
    | -------------------------------------------------------------------------- |
    | Permission                                                                 |
    | -------------------------------------------------------------------------- |
    | */                                                                         

    if (! canAccess('payments.view')) {

    
    return response()->json([

        'success' =>
            false,

        'message' =>
            'You do not have permission to view payments.',

    ], 403);
    

    }

     /*                                                                         |
    | -------------------------------------------------------------------------- |
    | Query                                                                      |
    | -------------------------------------------------------------------------- |
    | */                                                                         

    $query =
    Payment::query()
    ->where(
    'company_id',
    $this->companyId
    )
    ->with([

    
            'order.invoice',

            'customer',

            'branch',

            'terminal',

            'receivedBy',

        ]);
    

    /*                                                                         |
    | -------------------------------------------------------------------------- |
    | Branch Access                                                              |
    | -------------------------------------------------------------------------- |
    | */                                                                         

    if (
    ! canManageAllBranches()
    ) {

    
    $query->where(
        'branch_id',
        currentBranchId()
    );
    

    }

     /*                                                                         |
    | -------------------------------------------------------------------------- |
    | Payment                                                                    |
    | -------------------------------------------------------------------------- |
    | */                                                                         

    $payment =
    $query->find(
    $id
    );

    if (! $payment) {

    
    return response()->json([

        'success' =>
            false,

        'message' =>
            'Payment not found.',

    ], 404);
    

    }

     /*                                                                         |
    | -------------------------------------------------------------------------- |
    | Order                                                                      |
    | -------------------------------------------------------------------------- |
    | */                                                                         

    $order =
    $payment->order;

     /*                                                                         |
    | -------------------------------------------------------------------------- |
    | Response                                                                   |
    | -------------------------------------------------------------------------- |
    | */                                                                         

    return response()->json([

    
    'success' =>
        true,

    'data' => [

        /*
        |--------------------------------------------------------------------------
        | Payment
        |--------------------------------------------------------------------------
        */

        'id' =>
            $payment->id,

        'payment_number' =>
            $payment->payment_number,

        'payment_method' =>
            $payment->payment_method,

        'payment_status' =>
            $payment->payment_status,

        'payment_date' =>
            $payment->payment_date,

        'amount' =>
            (float)
            $payment->amount,

        'reference_no' =>
            $payment->reference_no,

        'transaction_reference' =>
            $payment->transaction_reference,

        'payment_gateway' =>
            $payment->payment_gateway,

        'remarks' =>
            $payment->remarks,


        /*
        |--------------------------------------------------------------------------
        | Order
        |--------------------------------------------------------------------------
        */

        'order' => $order
            ? [

                'id' =>
                    $order->id,

                'order_no' =>
                    $order->order_no,

                'invoice_no' =>
                    $order->invoice?->invoice_no,

                'order_status' =>
                    $order->order_status,

                'order_total' =>
                    (float)
                    $order->grand_total,

                'amount_paid' =>
                    (float)
                    $order->amount_paid,

                'balance' =>
                    (float)
                    $order->balance,

            ]
            : null,


        /*
        |--------------------------------------------------------------------------
        | Customer
        |--------------------------------------------------------------------------
        */

        'customer' => $payment->customer
            ? [

                'id' =>
                    $payment->customer->id,

                'name' =>
                    $payment->customer->displayName(),

                'code' =>
                    $payment->customer->customer_code,

            ]
            : null,


        /*
        |--------------------------------------------------------------------------
        | Branch
        |--------------------------------------------------------------------------
        */

        'branch' => $payment->branch
            ? [

                'id' =>
                    $payment->branch->id,

                'name' =>
                    $payment->branch->name,

            ]
            : null,

        
        /*
        |--------------------------------------------------------------------------
        | Terminal
        |--------------------------------------------------------------------------
        */

        'terminal' => $payment->terminal
            ? [

                'id' =>
                    $payment->terminal->id,

                'name' =>
                    $payment->terminal->displayName(),

            ]
            : null,


        /*
        |--------------------------------------------------------------------------
        | Received By
        |--------------------------------------------------------------------------
        */

        'received_by' => $payment->receivedBy
            ? [

                'id' =>
                    $payment->receivedBy->id,

                'name' =>
                    $payment->receivedBy->name
                        ??
                        trim(
                            $payment->receivedBy->first_name .
                            ' ' .
                            (
                                $payment->receivedBy->last_name
                                ??
                                ''
                            )
                        ),

            ]
            : null,


        /*
        |--------------------------------------------------------------------------
        | Activity
        |--------------------------------------------------------------------------
        */

        'created_at' =>
            $payment->created_at,

        'updated_at' =>
            $payment->updated_at,

    ],
    

    ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Receipt
    |--------------------------------------------------------------------------
    */

    /**
     * Display Payment receipt.
     */
    public function receipt(
        int $id
    ): mixed {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('payments.view')) {

            abort(
                403,
                'You do not have permission to view payments.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Query
        |--------------------------------------------------------------------------
        */

        $query =
            Payment::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->with([

                    'order.invoice',

                    'customer',

                    'branch',

                    'terminal',

                    'receivedBy',

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
        | Payment
        |--------------------------------------------------------------------------
        */

        $payment =
            $query->find(
                $id
            );


        if (! $payment) {

            abort(
                404,
                'Payment not found.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Receipt Settings
        |--------------------------------------------------------------------------
        */

        $receiptSettings =
            $this->company
                ->receiptSettings;


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view(
            'sales.payments.receipt',
            compact(
                'payment',
                'receiptSettings'
            )
        );

    }
}