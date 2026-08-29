<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Services\ActivityLogger;
use App\Models\Branch;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class InvoiceController extends BaseController
{

protected ActivityLogger $activityLogger;


    public function __construct(ActivityLogger $activityLogger)
    {
        parent::__construct();

        $this->activityLogger = $activityLogger;
    }
    
   /*
    |--------------------------------------------------------------------------
    | Invoice Index
    |--------------------------------------------------------------------------
    */

    /**
     * Display the Sales Invoices page.
     */
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        abort_unless(
            canAccess('invoices.view'),
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Branches
        |--------------------------------------------------------------------------
        */

        $branches =
            Branch::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->when(
                    ! canManageAllBranches(),
                    function ($query) {

                        $query->where(
                            'id',
                            currentBranchId()
                        );

                    }
                )
                ->orderBy(
                    'name'
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view(
            'sales.invoices.index',
            [

                'branches' =>
                    $branches,

            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Invoice Statistics
    |--------------------------------------------------------------------------
    */

    /**
     * Return Sales Invoice statistics.
     */
    public function stats(): JsonResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('invoices.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view sales invoices.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */

        $query =
            Invoice::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->whereHas(
                    'order',
                    function ($orderQuery) {

                        $orderQuery
                            ->whereIn(
                                'order_status',
                                [
                                    'Draft',
                                    'Held',
                                ]
                            )
                            ->where(
                                'company_id',
                                $this->companyId
                            );

                    }
                );


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
        | KPI Calculations
        |--------------------------------------------------------------------------
        */

        $draftCount =
            (clone $query)
                ->whereHas(
                    'order',
                    function ($orderQuery) {

                        $orderQuery->where(
                            'order_status',
                            'Draft'
                        );

                    }
                )
                ->count();


        $heldCount =
            (clone $query)
                ->whereHas(
                    'order',
                    function ($orderQuery) {

                        $orderQuery->where(
                            'order_status',
                            'Held'
                        );

                    }
                )
                ->count();


        $invoiceValue =
            (float)
            (clone $query)
                ->sum(
                    'grand_total'
                );


        $outstandingBalance =
            (float)
            (clone $query)
                ->sum(
                    'balance'
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

                'draft_count' =>
                    $draftCount,

                'held_count' =>
                    $heldCount,

                'invoice_value' =>
                    $invoiceValue,

                'outstanding_balance' =>
                    $outstandingBalance,

            ],

        ]);

    }

   /*
    |--------------------------------------------------------------------------
    | Invoice Table
    |--------------------------------------------------------------------------
    */

    /**
     * Return Sales Invoice table data.
     */
    public function table(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('invoices.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view sales invoices.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Query
        |--------------------------------------------------------------------------
        */

        $query =
            Invoice::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->whereHas(
                    'order',
                    function ($orderQuery) {

                        $orderQuery
                            ->whereIn(
                                'order_status',
                                [
                                    'Draft',
                                    'Held',
                                ]
                            )
                            ->where(
                                'company_id',
                                $this->companyId
                            );

                    }
                );


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

        $search =
            trim(
                (string)
                $request->input(
                    'search',
                    ''
                )
            );


        if ($search !== '') {

            $query->where(
                function ($query) use ($search) {

                    $query->where(
                        'invoice_no',
                        'like',
                        '%' . $search . '%'
                    )

                    ->orWhereHas(
                        'order',
                        function ($orderQuery) use ($search) {

                            $orderQuery->where(
                                'order_no',
                                'like',
                                '%' . $search . '%'
                            );

                        }
                    )

                    ->orWhereHas(
                        'customer',
                        function ($customerQuery) use ($search) {

                            $customerQuery
                                ->where(
                                    'customer_code',
                                    'like',
                                    '%' . $search . '%'
                                )
                                ->orWhere(
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


        /*
        |--------------------------------------------------------------------------
        | Branch Filter
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled(
                'branch_id'
            )
        ) {

            $query->where(
                'branch_id',
                $request->integer(
                    'branch_id'
                )
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Order Status Filter
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled(
                'order_status'
            )
        ) {

            $query->whereHas(
                'order',
                function ($orderQuery) use ($request) {

                    $orderQuery->where(
                        'order_status',
                        $request->input(
                            'order_status'
                        )
                    );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Payment Status Filter
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled(
                'payment_status'
            )
        ) {

            $query->where(
                'payment_status',
                $request->input(
                    'payment_status'
                )
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Date From
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled(
                'date_from'
            )
        ) {

            $query->whereDate(
                'invoice_date',
                '>=',
                $request->input(
                    'date_from'
                )
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Date To
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled(
                'date_to'
            )
        ) {

            $query->whereDate(
                'invoice_date',
                '<=',
                $request->input(
                    'date_to'
                )
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $perPage =
            min(
                max(
                    $request->integer(
                        'per_page',
                        10
                    ),
                    1
                ),
                100
            );


        $invoices =
            $query
                ->with([

                    'order',

                    'customer',

                    'branch',

                ])
                ->latest(
                    'id'
                )
                ->paginate(
                    $perPage
                );


        /*
        |--------------------------------------------------------------------------
        | Transform
        |--------------------------------------------------------------------------
        */

        $rows =
            $invoices->getCollection()
                ->map(
                    function (Invoice $invoice) {

                        $order =
                            $invoice->order;


                        return [

                            'id' =>
                                $invoice->id,

                            'invoice_no' =>
                                $invoice->invoice_no,

                            'order_id' =>
                                $order?->id,

                            'order_no' =>
                                $order?->order_no,

                            'customer' =>
                                $invoice->customer
                                    ? [
                                        'id' =>
                                            $invoice->customer->id,

                                        'name' =>
                                            $invoice->customer->displayName(),
                                    ]
                                    : null,

                            'branch' =>
                                $invoice->branch
                                    ? [
                                        'id' =>
                                            $invoice->branch->id,

                                        'name' =>
                                            $invoice->branch->name,
                                    ]
                                    : null,

                            'total' =>
                                (float)
                                (
                                    $invoice->grand_total
                                    ??
                                    $invoice->total
                                    ??
                                    0
                                ),

                            'amount_paid' =>
                                (float)
                                $invoice->amount_paid,

                            'balance' =>
                                (float)
                                $invoice->balance,

                            'payment_status' =>
                                $invoice->payment_status,

                            'order_status' =>
                                $order?->order_status,

                            'invoice_status' =>
                                $invoice->invoice_status,

                            'invoice_date' =>
                                $invoice->invoice_date,

                            'created_at' =>
                                $invoice->created_at,

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
                $rows,

            'pagination' => [

                'current_page' =>
                    $invoices->currentPage(),

                'last_page' =>
                    $invoices->lastPage(),

                'per_page' =>
                    $invoices->perPage(),

                'total' =>
                    $invoices->total(),

                'from' =>
                    $invoices->firstItem(),

                'to' =>
                    $invoices->lastItem(),

            ],

        ]);

    }

   /*
    |--------------------------------------------------------------------------
    | Details
    |--------------------------------------------------------------------------
    */

    /**
     * Return Sales Invoice details.
     */
    public function details(
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('invoices.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view invoices.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Query
        |--------------------------------------------------------------------------
        */

        $query =
            Invoice::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->with([

                    'order.orderItems.product',

                    'customer',

                    'branch',

                    'terminal',

                    'createdBy',

                    'updatedBy',

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
        | Invoice
        |--------------------------------------------------------------------------
        */

        $invoice =
            $query->find(
                $id
            );
  
        if (! $invoice) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Invoice not found.',

            ], 404);

        }


        /*
        |--------------------------------------------------------------------------
        | Related Order
        |--------------------------------------------------------------------------
        */

        $order =
            $invoice->order;


        /*
        |--------------------------------------------------------------------------
        | Completed Orders
        |--------------------------------------------------------------------------
        |
        | Completed orders are intentionally excluded from the
        | pending invoice module.
        |
        */

        if (
            $order?->order_status ===
            'Completed'
        ) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Completed orders are not available in the pending invoice module.',

            ], 404);

        }


        /*
        |--------------------------------------------------------------------------
        | Order Items
        |--------------------------------------------------------------------------
        */

        $items =
            $order?->orderItems
                ?->map(
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
                                (float)
                                $item->quantity,

                            'unit_price' =>
                                (float)
                                $item->unit_price,

                            'discount' =>
                                (float)
                                $item->discount,

                            'tax' =>
                                (float)
                                $item->tax,

                            'total' =>
                                (float)
                                $item->total,

                        ];

                    }
                )
                ->values()
                ??
                collect();


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'data' => [

                /*
                |--------------------------------------------------------------------------
                | Invoice
                |--------------------------------------------------------------------------
                */

                'id' =>
                    $invoice->id,

                'invoice_no' =>
                    $invoice->invoice_no,

                'invoice_date' =>
                    $invoice->invoice_date,


                /*
                |--------------------------------------------------------------------------
                | Order
                |--------------------------------------------------------------------------
                */

                'order' => $invoice->order
                    ? [

                        'id' =>
                            $invoice->order->id,

                        'order_no' =>
                            $invoice->order->order_no,

                        'order_status' =>
                            $invoice->order->order_status,

                        'payment_status' =>
                            $invoice->order->payment_status,

                        'sales_channel' =>
                            $invoice->order->sales_channel,

                    ]
                    : null,


                /*
                |--------------------------------------------------------------------------
                | Customer
                |--------------------------------------------------------------------------
                */

                'customer' => $invoice->customer
                    ? [

                        'id' =>
                            $invoice->customer->id,

                        'name' =>
                            $invoice->customer->displayName(),

                        'code' =>
                            $invoice->customer->customer_code,

                    ]
                    : null,


                /*
                |--------------------------------------------------------------------------
                | Branch
                |--------------------------------------------------------------------------
                */

                'branch' => $invoice->branch
                    ? [

                        'id' =>
                            $invoice->branch->id,

                        'name' =>
                            $invoice->branch->name,

                    ]
                    : null,


                /*
                |--------------------------------------------------------------------------
                | Terminal
                |--------------------------------------------------------------------------
                */

                'terminal' => $invoice->terminal
                    ? [

                        'id' =>
                            $invoice->terminal->id,

                        'name' =>
                            $invoice->terminal->displayName(),

                    ]
                    : null,


                /*
                |--------------------------------------------------------------------------
                | Financial Summary
                |--------------------------------------------------------------------------
                */

                'subtotal' =>
                    (float)
                    $invoice->subtotal,

                'discount' =>
                    (float)
                    $invoice->discount,

                'tax' =>
                    (float)
                    $invoice->tax,

                'total' =>
                    (float)
                    $invoice->total,

                'grand_total' =>
                    (float)
                    $invoice->grand_total,

                'amount_paid' =>
                    (float)
                    $invoice->amount_paid,

                'balance' =>
                    (float)
                    $invoice->balance,

                'change_given' =>
                    (float)
                    ($invoice->change_given ?? 0),


                /*
                |--------------------------------------------------------------------------
                | Item Summary
                |--------------------------------------------------------------------------
                */

                'total_items' =>
                    $invoice->order?->orderItems
                        ?->count()
                        ?? 0,

                'total_quantity' =>
                    (float)
                    (
                        $invoice->order?->orderItems
                            ?->sum('quantity')
                        ?? 0
                    ),


                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */

                'payment_status' =>
                    $invoice->payment_status,

                'invoice_status' =>
                    $invoice->invoice_status,

                'order_status' =>
                    $invoice->order?->order_status,

                'order_no' =>
                    $invoice->order?->order_no,

                'sales_channel' =>
                    $invoice->order?->sales_channel,


                /*
                |--------------------------------------------------------------------------
                | Remarks
                |--------------------------------------------------------------------------
                */

                'remarks' =>
                    $invoice->remarks,


                /*
                |--------------------------------------------------------------------------
                | Items
                |--------------------------------------------------------------------------
                */

                'items' =>
                    $invoice->order?->orderItems
                        ?->map(
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
                                        (float)
                                        $item->quantity,

                                    'unit_price' =>
                                        (float)
                                        $item->unit_price,

                                    'discount' =>
                                        (float)
                                        $item->discount,

                                    'tax' =>
                                        (float)
                                        $item->tax,

                                    'total' =>
                                        (float)
                                        $item->total,

                                ];

                            }
                        )
                        ->values()
                        ??
                        collect(),


                /*
                |--------------------------------------------------------------------------
                | Activity
                |--------------------------------------------------------------------------
                */

                'created_by' =>
                    $invoice->createdBy
                        ? [

                            'id' =>
                                $invoice->createdBy->id,

                            'name' =>
                                $invoice->createdBy->name
                                    ??
                                    trim(
                                        $invoice->createdBy->first_name .
                                        ' ' .
                                        (
                                            $invoice->createdBy->last_name
                                            ??
                                            ''
                                        )
                                    ),

                        ]
                        : null,

                'updated_by' =>
                    $invoice->updatedBy
                        ? [

                            'id' =>
                                $invoice->updatedBy->id,

                            'name' =>
                                $invoice->updatedBy->name
                                    ??
                                    trim(
                                        $invoice->updatedBy->first_name .
                                        ' ' .
                                        (
                                            $invoice->updatedBy->last_name
                                            ??
                                            ''
                                        )
                                    ),

                        ]
                        : null,

                'created_at' =>
                    $invoice->created_at,

                'updated_at' =>
                    $invoice->updated_at,

            ],

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Print
    |--------------------------------------------------------------------------
    */

    /**
     * Display a printable Sales Invoice.
     */
    public function print(
        int $id
    ): View {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        abort_unless(
            canAccess('invoices.view'),
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Query
        |--------------------------------------------------------------------------
        */

        $query =
            Invoice::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->with([

                    'order.orderItems.product',

                    'customer',

                    'branch',

                    'terminal',

                    'createdBy',

                    'updatedBy',

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
        | Invoice
        |--------------------------------------------------------------------------
        */

        $invoice =
            $query->findOrFail(
                $id
            );


        /*
        |--------------------------------------------------------------------------
        | Completed Orders
        |--------------------------------------------------------------------------
        |
        | Completed orders are intentionally excluded from the
        | pending invoice module.
        |
        */

        abort_if(
            $invoice->order?->order_status === 'Completed',
            404
        );


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view(
            'sales.invoices.print',
            compact(
                'invoice'
            )
        );

    }

}