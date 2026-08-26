<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use App\Models\GoodsReceived;
use App\Models\GoodsReceivedItem;
use App\Models\Product;
use App\Models\User;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnItem;
use App\Models\Supplier;
use App\Services\ActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\DocumentNumberService;
use App\Models\ProductStock;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;




class PurchaseController extends BaseController
{
    protected ActivityLogger $activityLogger;


    public function __construct(ActivityLogger $activityLogger)
    {
        parent::__construct();

        $this->activityLogger = $activityLogger;
    }
    /**
     * Purchase Management Index.
     */
    public function index()
    {
        if (! canAccess('purchases.view')) {

            abort(403);

        }


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
                ->orderBy('name')
                ->get();


        /*
        |--------------------------------------------------------------------------
        | Suppliers
        |--------------------------------------------------------------------------
        */

        $suppliers =
            Supplier::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->where(
                    'status',
                    true
                )
                ->orderBy('name')
                ->get();


        /*
        |--------------------------------------------------------------------------
        | Purchase Order Statistics
        |--------------------------------------------------------------------------
        */

        $purchaseOrderStatsQuery =
            PurchaseOrder::query()
                ->where(
                    'company_id',
                    $this->companyId
                );


        $purchaseOrderStats = [

            'total' =>
                (clone $purchaseOrderStatsQuery)
                    ->count(),

            'pending' =>
                (clone $purchaseOrderStatsQuery)
                    ->where(
                        'status',
                        'Pending'
                    )
                    ->count(),

            'approved' =>
                (clone $purchaseOrderStatsQuery)
                    ->where(
                        'status',
                        'Approved'
                    )
                    ->count(),

            'total_value' =>
                (float) (
                    (clone $purchaseOrderStatsQuery)
                        ->sum('total')
                ),

        ];


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view(
            'purchase.index',
            compact(
                'branches',
                'suppliers',
                'purchaseOrderStats'
            )
        );
    }
    /*
    |--------------------------------------------------------------------------
    | Supplier Options
    |--------------------------------------------------------------------------
    */

    /**
     * Return active suppliers for Purchase forms.
     */
    public function supplierOptions(): JsonResponse
    {
        if (! canAccess('purchases.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view suppliers.',

            ], 403);

        }

        $suppliers =
            Supplier::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->where(
                    'status',
                    true
                )
                ->orderBy('name')
                ->get([
                    'id',
                    'supplier_code',
                    'name',
                ]);

        return response()->json([

            'success' =>
                true,

            'data' =>
                $suppliers,

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Branch Options
    |--------------------------------------------------------------------------
    */

    /**
     * Return company branches for Purchase forms.
     */
    public function branchOptions(): JsonResponse
    {
        if (! canAccess('purchases.view')) {

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
                ->orderBy('name')
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
    | Product Options
    |--------------------------------------------------------------------------
    */

    /**
     * Return active products for Purchase forms.
     */
    public function productOptions(): JsonResponse
    {
        if (! canAccess('purchases.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view products.',

            ], 403);

        }

        $products =
            Product::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->where(
                    'status',
                    true
                )
                ->orderBy('name')
                ->get([
                    'id',
                    'product_code',
                    'sku',
                    'name',
                    'cost_price',
                    'selling_price',
                ]);

        return response()->json([

            'success' =>
                true,

            'data' =>
                $products,

        ]);
    }

   /*
    |--------------------------------------------------------------------------
    | Purchase Orders
    |--------------------------------------------------------------------------
    */

    /**
     * Return Purchase Orders table.
     */
    public function orderTable(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('purchases.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view purchase orders.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Query
        |--------------------------------------------------------------------------
        */

        $query =
            PurchaseOrder::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->with([
                    'supplier',
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


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search =
                trim(
                    $request->search
                );


            if ($search !== '') {

                $query->where(
                    function ($q) use ($search) {

                        $q->where(
                            'order_number',
                            'like',
                            "%{$search}%"
                        );


                        $q->orWhereHas(
                            'supplier',
                            function ($supplier) use ($search) {

                                $supplier->where(
                                    'company_id',
                                    $this->companyId
                                );

                                $supplier->where(
                                    'name',
                                    'like',
                                    "%{$search}%"
                                );

                            }
                        );


                        $q->orWhereHas(
                            'branch',
                            function ($branch) use ($search) {

                                $branch->where(
                                    'company_id',
                                    $this->companyId
                                );

                                $branch->where(
                                    'name',
                                    'like',
                                    "%{$search}%"
                                );

                            }
                        );

                    }
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Branch Filter
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('branch_id') &&
            canManageAllBranches()
        ) {

            $query->where(
                'branch_id',
                $request->branch_id
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Supplier Filter
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('supplier_id')
        ) {

            $query->where(
                'supplier_id',
                $request->supplier_id
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('status')
        ) {

            $status =
                strtolower(
                    trim(
                        $request->status
                    )
                );


            $statusMap = [

                'draft' =>
                    'Draft',

                'pending' =>
                    'Pending',

                'approved' =>
                    'Approved',

                'cancelled' =>
                    'Cancelled',

                'completed' =>
                    'Completed',

            ];


            if (
                isset(
                    $statusMap[$status]
                )
            ) {

                $query->where(
                    'status',
                    $statusMap[$status]
                );

            }

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
                'order_date',
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
                'order_date',
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
        | Table HTML
        |--------------------------------------------------------------------------
        */

        $html =
            view(
                'purchase.partials.orders-table',
                compact(
                    'orders'
                )
            )->render();


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | Important:
        | Statistics follow the same active filters.
        |--------------------------------------------------------------------------
        */

        $statsQuery =
            clone $query;


        $stats = [

            'total' =>
                (clone $statsQuery)
                    ->count(),

            'pending' =>
                (clone $statsQuery)
                    ->where(
                        'status',
                        'Pending'
                    )
                    ->count(),

            'approved' =>
                (clone $statsQuery)
                    ->where(
                        'status',
                        'Approved'
                    )
                    ->count(),

            'total_value' =>
                (float) (
                    (clone $statsQuery)
                        ->sum('total')
                ),

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


   /**
     * Store Purchase Order.
     */
    public function storeOrder(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('purchases.create')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to create purchase orders.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([

                'branch_id' =>
                    [
                        'required',
                        'integer',
                    ],

                'supplier_id' =>
                    [
                        'required',
                        'integer',
                    ],

                'order_date' =>
                    [
                        'required',
                        'date',
                    ],

                'expected_date' =>
                    [
                        'nullable',
                        'date',
                        'after_or_equal:order_date',
                    ],

                'discount' =>
                    [
                        'nullable',
                        'numeric',
                        'min:0',
                    ],

                'tax' =>
                    [
                        'nullable',
                        'numeric',
                        'min:0',
                    ],

                'shipping' =>
                    [
                        'nullable',
                        'numeric',
                        'min:0',
                    ],

                'notes' =>
                    [
                        'nullable',
                        'string',
                        'max:2000',
                    ],

                'items' =>
                    [
                        'required',
                        'array',
                        'min:1',
                    ],

                'items.*.product_id' =>
                    [
                        'required',
                        'integer',
                    ],

                'items.*.quantity' =>
                    [
                        'required',
                        'numeric',
                        'gt:0',
                    ],

                'items.*.unit_cost' =>
                    [
                        'required',
                        'numeric',
                        'min:0',
                    ],

                'items.*.discount' =>
                    [
                        'nullable',
                        'numeric',
                        'min:0',
                    ],

                'items.*.tax' =>
                    [
                        'nullable',
                        'numeric',
                        'min:0',
                    ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | Validate Branch
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


        if (! $branch) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Selected branch is invalid.',

            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Validate Supplier
        |--------------------------------------------------------------------------
        */

        $supplier =
            Supplier::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->where(
                    'status',
                    true
                )
                ->find(
                    $validated['supplier_id']
                );


        if (! $supplier) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Selected supplier is invalid or inactive.',

            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Validate Products
        |--------------------------------------------------------------------------
        */

        $productIds =
            collect(
                $validated['items']
            )
            ->pluck('product_id')
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
                ->keyBy('id');


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
        | Create / Restore Order
        |--------------------------------------------------------------------------
        */

        $order =
            DB::transaction(
                function () use (
                    $validated,
                    $products
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | Calculate Items
                    |--------------------------------------------------------------------------
                    */

                    $subtotal = 0;

                    $items = [];


                    foreach (
                        $validated['items']
                        as $item
                    ) {

                        $quantity =
                            (float) $item['quantity'];


                        $unitCost =
                            (float) $item['unit_cost'];


                        $discount =
                            (float) (
                                $item['discount']
                                ?? 0
                            );


                        $tax =
                            (float) (
                                $item['tax']
                                ?? 0
                            );


                        $lineSubtotal =
                            $quantity *
                            $unitCost;


                        $lineTotal =
                            $lineSubtotal -
                            $discount +
                            $tax;


                        if (
                            $lineTotal < 0
                        ) {

                            $lineTotal = 0;

                        }


                        $subtotal +=
                            $lineSubtotal;


                        $items[] = [

                            'product_id' =>
                                $item['product_id'],

                            'quantity' =>
                                $quantity,

                            'unit_cost' =>
                                $unitCost,

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

                    $discount =
                        (float) (
                            $validated['discount']
                            ?? 0
                        );


                    $tax =
                        (float) (
                            $validated['tax']
                            ?? 0
                        );


                    $shipping =
                        (float) (
                            $validated['shipping']
                            ?? 0
                        );


                    $total =
                        $subtotal -
                        $discount +
                        $tax +
                        $shipping;


                    if (
                        $total < 0
                    ) {

                        $total = 0;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Generate Order Number
                    |--------------------------------------------------------------------------
                    */

                    $orderNumber =
                        $this->generatePurchaseOrderNumber();


                    /*
                    |--------------------------------------------------------------------------
                    | Find Soft Deleted Order
                    |--------------------------------------------------------------------------
                    */

                    $deletedOrder =
                        PurchaseOrder::withTrashed()
                            ->where(
                                'company_id',
                                $this->companyId
                            )
                            ->where(
                                'order_number',
                                $orderNumber
                            )
                            ->whereNotNull(
                                'deleted_at'
                            )
                            ->first();


                    /*
                    |--------------------------------------------------------------------------
                    | Restore Existing Order
                    |--------------------------------------------------------------------------
                    */

                    if ($deletedOrder) {

                        $deletedOrder->restore();


                        /*
                        |--------------------------------------------------------------------------
                        | Update Order
                        |--------------------------------------------------------------------------
                        */

                        $deletedOrder->update([

                            'branch_id' =>
                                $validated['branch_id'],

                            'supplier_id' =>
                                $validated['supplier_id'],

                            'order_date' =>
                                $validated['order_date'],

                            'expected_date' =>
                                $validated['expected_date']
                                ?? null,

                            'status' =>
                                'Draft',

                            'subtotal' =>
                                $subtotal,

                            'discount' =>
                                $discount,

                            'tax' =>
                                $tax,

                            'shipping' =>
                                $shipping,

                            'total' =>
                                $total,

                            'notes' =>
                                $validated['notes']
                                ?? null,

                            'created_by' =>
                                auth()->id(),

                        ]);


                        /*
                        |--------------------------------------------------------------------------
                        | Remove Existing Items
                        |--------------------------------------------------------------------------
                        */

                        $deletedOrder->items()->delete();


                        /*
                        |--------------------------------------------------------------------------
                        | Create New Items
                        |--------------------------------------------------------------------------
                        */

                        foreach (
                            $items
                            as $item
                        ) {

                            $deletedOrder
                                ->items()
                                ->create(
                                    $item
                                );

                        }


                        return $deletedOrder->fresh();

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Create New Order
                    |--------------------------------------------------------------------------
                    */

                    $order =
                        PurchaseOrder::create([

                            'company_id' =>
                                $this->companyId,

                            'branch_id' =>
                                $validated['branch_id'],

                            'supplier_id' =>
                                $validated['supplier_id'],

                            'order_number' =>
                                $orderNumber,

                            'order_date' =>
                                $validated['order_date'],

                            'expected_date' =>
                                $validated['expected_date']
                                ?? null,

                            'status' =>
                                'Draft',

                            'subtotal' =>
                                $subtotal,

                            'discount' =>
                                $discount,

                            'tax' =>
                                $tax,

                            'shipping' =>
                                $shipping,

                            'total' =>
                                $total,

                            'notes' =>
                                $validated['notes']
                                ?? null,

                            'created_by' =>
                                auth()->id(),

                        ]);


                    /*
                    |--------------------------------------------------------------------------
                    | Create Items
                    |--------------------------------------------------------------------------
                    */

                    foreach (
                        $items
                        as $item
                    ) {

                        $order->items()->create(
                            $item
                        );

                    }


                    return $order;

                }
            );


        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        $this->activityLogger->log(

            'purchases',

            'create',

            'Created purchase order: ' .
                $order->order_number,

            $order,

            null,

            $order->toArray()

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
                'Purchase order created successfully.',

            'data' =>
                $order,

        ]);

    }

    /*
|--------------------------------------------------------------------------
| Purchase Order Details
|--------------------------------------------------------------------------
*/

public function orderDetails(
    int $id
): JsonResponse {

    /*
    |--------------------------------------------------------------------------
    | Permission
    |--------------------------------------------------------------------------
    */

    if (! canAccess('purchases.view')) {

        return response()->json([

            'success' =>
                false,

            'message' =>
                'You do not have permission to view purchase order details.',

        ], 403);

    }


    /*
    |--------------------------------------------------------------------------
    | Purchase Order
    |--------------------------------------------------------------------------
    */

    $order =
        PurchaseOrder::query()

            ->where(
                'company_id',
                $this->companyId
            )

            ->with([
                'supplier',
                'branch',
                'creator',
                'approver',
                'items',
            ])

            ->findOrFail(
                $id
            );


    /*
    |--------------------------------------------------------------------------
    | Products
    |--------------------------------------------------------------------------
    */

    $productIds =
        $order
            ->items
            ->pluck(
                'product_id'
            )
            ->filter()
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

            ->get()

            ->keyBy(
                'id'
            );


    /*
    |--------------------------------------------------------------------------
    | Order Items
    |--------------------------------------------------------------------------
    */

    $items =
        $order
            ->items
            ->map(
                function ($item) use ($products) {

                    $product =
                        $products->get(
                            $item->product_id
                        );


                    return [

                        'id' =>
                            $item->id,

                        'product_id' =>
                            $item->product_id,

                        /*
                        |--------------------------------------------------------------------------
                        | Inspector expects "product"
                        |--------------------------------------------------------------------------
                        */

                        'product' =>
                            $product?->name
                            ?? 'Unknown Product',

                        'product_code' =>
                            $product?->product_code
                            ?? null,

                        'quantity' =>
                            (float) (
                                $item->quantity
                                ?? 0
                            ),

                        'unit_cost' =>
                            (float) (
                                $item->unit_cost
                                ?? 0
                            ),

                        'total' =>
                            (float) (
                                $item->total
                                ?? (
                                    (float) $item->quantity *
                                    (float) $item->unit_cost
                                )
                            ),

                    ];

                }
            )
            ->values();


    /*
    |--------------------------------------------------------------------------
    | User Names
    |--------------------------------------------------------------------------
    */

    $createdBy =
        $order->creator
            ? trim(
                ($order->creator->first_name ?? '') .
                ' ' .
                ($order->creator->last_name ?? '')
            )
            : '—';

    $approvedBy =
        $order->approver
            ? trim(
                ($order->approver->first_name ?? '') .
                ' ' .
                ($order->approver->last_name ?? '')
            )
            : '—';
    


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
            | Header
            |--------------------------------------------------------------------------
            */

            'id' =>
                $order->id,

            'order_number' =>
                $order->order_number,

            'status' =>
                $order->status,


            /*
            |--------------------------------------------------------------------------
            | Supplier / Branch
            |--------------------------------------------------------------------------
            */

            'supplier' =>
                $order->supplier?->name
                ?? '—',

            'branch' =>
                $order->branch?->name
                ?? '—',


            /*
            |--------------------------------------------------------------------------
            | Dates
            |--------------------------------------------------------------------------
            */

            'order_date' =>
                $order->order_date?->format(
                    'Y-m-d'
                ),

            'expected_date' =>
                $order->expected_date?->format(
                    'Y-m-d'
                ),


            /*
            |--------------------------------------------------------------------------
            | Items
            |--------------------------------------------------------------------------
            */

            'items' =>
                $items,

            'item_count' =>
                $items->count(),


            /*
            |--------------------------------------------------------------------------
            | Financial Summary
            |--------------------------------------------------------------------------
            */

            'subtotal' =>
                (float) $order->subtotal,

            'discount' =>
                (float) $order->discount,

            'tax' =>
                (float) $order->tax,

            'shipping' =>
                (float) $order->shipping,

            'total' =>
                (float) $order->total,


            /*
            |--------------------------------------------------------------------------
            | Notes
            |--------------------------------------------------------------------------
            */

            'notes' =>
                $order->notes
                ?? null,


            /*
            |--------------------------------------------------------------------------
            | Activity
            |--------------------------------------------------------------------------
            */

            'created_by' =>
                $createdBy,

            'created_at' =>
                $order->created_at
                    ?->toISOString(),

            'approved_by' =>
                $approvedBy,

            'approved_at' =>
                $order->approved_at
                    ?->toISOString(),

            'updated_at' =>
                $order->updated_at
                    ?->toISOString(),

        ],

    ]);

}
    /*
    |--------------------------------------------------------------------------
    | Purchase Order Number
    |--------------------------------------------------------------------------
    */

    /**
     * Generate Purchase Order number.
     */
    private function generatePurchaseOrderNumber(): string
    {
        $prefix =
            'PO-' .
            now()->format('Ym') .
            '-';


        /*
        |--------------------------------------------------------------------------
        | Find Latest Order Including Soft Deleted
        |--------------------------------------------------------------------------
        */

        $lastOrder =
            PurchaseOrder::withTrashed()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->where(
                    'order_number',
                    'like',
                    $prefix . '%'
                )
                ->latest('id')
                ->first();


        /*
        |--------------------------------------------------------------------------
        | Determine Next Number
        |--------------------------------------------------------------------------
        */

        $nextNumber = 1;


        if ($lastOrder) {

            $lastNumber =
                (int) str_replace(
                    $prefix,
                    '',
                    $lastOrder->order_number
                );


            $nextNumber =
                $lastNumber + 1;

        }


        /*
        |--------------------------------------------------------------------------
        | Return Order Number
        |--------------------------------------------------------------------------
        */

        return $prefix .
            str_pad(
                $nextNumber,
                5,
                '0',
                STR_PAD_LEFT
            );
    }

    /**
     * Update Purchase Order.
     */
    public function updateOrder(
        Request $request,
        int $id
    ): JsonResponse {

        if (! canAccess('purchases.update')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to update purchase orders.',

            ], 403);

        }

        $order =
            PurchaseOrder::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->find($id);

        if (!$order) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Purchase order not found.',

            ], 404);

        }

        if ($order->isApproved()) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Approved purchase orders cannot be edited.',

            ], 422);

        }

        $validated =
            $request->validate([

                'branch_id' =>
                    [
                        'required',
                        'integer',
                    ],

                'supplier_id' =>
                    [
                        'required',
                        'integer',
                    ],

                'order_date' =>
                    [
                        'required',
                        'date',
                    ],

                'expected_date' =>
                    [
                        'nullable',
                        'date',
                        'after_or_equal:order_date',
                    ],

                'discount' =>
                    [
                        'nullable',
                        'numeric',
                        'min:0',
                    ],

                'tax' =>
                    [
                        'nullable',
                        'numeric',
                        'min:0',
                    ],

                'shipping' =>
                    [
                        'nullable',
                        'numeric',
                        'min:0',
                    ],

                'notes' =>
                    [
                        'nullable',
                        'string',
                        'max:2000',
                    ],

                'items' =>
                    [
                        'required',
                        'array',
                        'min:1',
                    ],

                'items.*.product_id' =>
                    [
                        'required',
                        'integer',
                    ],

                'items.*.quantity' =>
                    [
                        'required',
                        'numeric',
                        'gt:0',
                    ],

                'items.*.unit_cost' =>
                    [
                        'required',
                        'numeric',
                        'min:0',
                    ],

                'items.*.discount' =>
                    [
                        'nullable',
                        'numeric',
                        'min:0',
                    ],

                'items.*.tax' =>
                    [
                        'nullable',
                        'numeric',
                        'min:0',
                    ],

            ]);

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

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Selected branch is invalid.',

            ], 422);

        }

        $supplier =
            Supplier::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->where(
                    'status',
                    true
                )
                ->find(
                    $validated['supplier_id']
                );

        if (!$supplier) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Selected supplier is invalid or inactive.',

            ], 422);

        }

        $productIds =
            collect(
                $validated['items']
            )
            ->pluck('product_id')
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
                ->keyBy('id');

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

        $oldValues =
            $order
                ->load('items')
                ->toArray();

        DB::transaction(
            function () use (
                $validated,
                $order
            ) {

                $subtotal = 0;

                $items = [];

                foreach (
                    $validated['items']
                    as $item
                ) {

                    $quantity =
                        (float) $item['quantity'];

                    $unitCost =
                        (float) $item['unit_cost'];

                    $discount =
                        (float) (
                            $item['discount']
                            ?? 0
                        );

                    $tax =
                        (float) (
                            $item['tax']
                            ?? 0
                        );

                    $lineSubtotal =
                        $quantity *
                        $unitCost;

                    $lineTotal =
                        $lineSubtotal -
                        $discount +
                        $tax;

                    if ($lineTotal < 0) {

                        $lineTotal = 0;

                    }

                    $subtotal +=
                        $lineSubtotal;

                    $items[] = [

                        'product_id' =>
                            $item['product_id'],

                        'quantity' =>
                            $quantity,

                        'unit_cost' =>
                            $unitCost,

                        'discount' =>
                            $discount,

                        'tax' =>
                            $tax,

                        'total' =>
                            $lineTotal,

                    ];

                }

                $discount =
                    (float) (
                        $validated['discount']
                        ?? 0
                    );

                $tax =
                    (float) (
                        $validated['tax']
                        ?? 0
                    );

                $shipping =
                    (float) (
                        $validated['shipping']
                        ?? 0
                    );

                $total =
                    $subtotal -
                    $discount +
                    $tax +
                    $shipping;

                if ($total < 0) {

                    $total = 0;

                }

                $order->update([

                    'branch_id' =>
                        $validated['branch_id'],

                    'supplier_id' =>
                        $validated['supplier_id'],

                    'order_date' =>
                        $validated['order_date'],

                    'expected_date' =>
                        $validated['expected_date']
                        ?? null,

                    'subtotal' =>
                        $subtotal,

                    'discount' =>
                        $discount,

                    'tax' =>
                        $tax,

                    'shipping' =>
                        $shipping,

                    'total' =>
                        $total,

                    'notes' =>
                        $validated['notes']
                        ?? null,

                ]);

                $order->items()->delete();

                foreach (
                    $items
                    as $item
                ) {

                    $order->items()->create(
                        $item
                    );

                }

            }
        );

        $order->refresh();

        $this->activityLogger->log(

            'purchases',

            'update',

            'Updated purchase order: ' .
                $order->order_number,

            $order,

            $oldValues,

            $order->load('items')->toArray()

        );

        return response()->json([

            'success' =>
                true,

            'message' =>
                'Purchase order updated successfully.',

            'data' =>
                $order,

        ]);
    }


   /**
     * Delete Purchase Order.
     */
    public function destroyOrder(
        int $id
    ): JsonResponse {

        if (! canAccess('purchases.delete')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to delete purchase orders.',

            ], 403);

        }


        $order =
            PurchaseOrder::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->find($id);


        if (!$order) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Purchase order not found.',

            ], 404);

        }


        $order->delete();


        return response()->json([

            'success' =>
                true,

            'message' =>
                'Purchase order deleted successfully.',

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Submit Purchase Order for Approval
    |--------------------------------------------------------------------------
    */
   
    public function submitOrder(
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('purchases.update')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to submit purchase orders for approval.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Find Order
        |--------------------------------------------------------------------------
        */

        $order =
            PurchaseOrder::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->with([
                    'items',
                    'supplier',
                    'branch',
                ])
                ->find($id);


        if (!$order) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Purchase order not found.',

            ], 404);

        }


        /*
        |--------------------------------------------------------------------------
        | Validate Status
        |--------------------------------------------------------------------------
        */

        if (
            strtolower(
                trim(
                    (string) $order->status
                )
            ) !== 'draft'
        ) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Only draft purchase orders can be submitted for approval.',

            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Validate Items
        |--------------------------------------------------------------------------
        */

        if (
            $order->items->isEmpty()
        ) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'A purchase order must contain at least one item before submission.',

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
        | Submit Order
        |--------------------------------------------------------------------------
        */

        $order->status =
            'Pending';

        $order->save();


        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        $this->activityLogger->log(

            'purchases',

            'submit',

            'Submitted purchase order for approval: ' .
                $order->order_number,

            $order,

            $oldValues,

            $order->fresh()->toArray()

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
                'Purchase order submitted for approval successfully.',

            'data' =>
                $order->fresh(),

        ]);

    }

    /**
     * Approve Purchase Order.
     */
    public function approveOrder(
        int $id
    ): JsonResponse {

        if (! canAccess('purchases.approve')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to approve purchase orders.',

            ], 403);

        }

        $order =
            PurchaseOrder::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->with([
                    'items',
                    'supplier',
                    'branch',
                ])
                ->find($id);

        if (!$order) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Purchase order not found.',

            ], 404);

        }

       /*
        |--------------------------------------------------------------------------
        | Validate Status
        |--------------------------------------------------------------------------
        */

        if (
            strtolower(
                trim(
                    (string) $order->status
                )
            ) !== 'pending'
        ) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Only pending purchase orders can be approved.',

            ], 422);

        }

        if ($order->items->isEmpty()) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'A purchase order must contain at least one item before approval.',

            ], 422);

        }

        $oldValues =
            $order->toArray();

        $order->update([

            'status' =>
                'approved',

            'approved_by' =>
                auth()->id(),

            'approved_at' =>
                now(),

        ]);

        $this->activityLogger->log(

            'purchases',

            'approve',

            'Approved purchase order: ' .
                $order->order_number,

            $order,

            $oldValues,

            $order->fresh()->toArray()

        );

        return response()->json([

            'success' =>
                true,

            'message' =>
                'Purchase order approved successfully.',

            'data' =>
                $order->fresh(),

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Cancel Purchase Order
    |--------------------------------------------------------------------------
    */

    public function cancelOrder(
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('purchases.update')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to cancel purchase orders.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Find Order
        |--------------------------------------------------------------------------
        */

        $order =
            PurchaseOrder::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->find($id);


        if (!$order) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Purchase order not found.',

            ], 404);

        }


        /*
        |--------------------------------------------------------------------------
        | Validate Status
        |--------------------------------------------------------------------------
        */

        if (
            strtolower(
                trim(
                    (string) $order->status
                )
            ) !== 'pending'
        ) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Only pending purchase orders can be cancelled.',

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
        | Cancel Order
        |--------------------------------------------------------------------------
        */

        $order->update([

            'status' =>
                'cancelled',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        $this->activityLogger->log(

            'purchases',

            'cancel',

            'Cancelled purchase order: ' .
                $order->order_number,

            $order,

            $oldValues,

            $order->fresh()->toArray()

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
                'Purchase order cancelled successfully.',

            'data' =>
                $order->fresh(),

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Goods Received
    |--------------------------------------------------------------------------
    */

    /**
     * Return Goods Received table.
     */
    public function receivedTable(
        Request $request
    ): JsonResponse {

        if (! canAccess('purchases.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view goods received.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */

       $query =
        GoodsReceived::query()
            ->where(
                'company_id',
                $this->companyId
            )
            ->with([
                'supplier',
                'branch',
                'purchaseOrder',
            ])
            ->withCount(
                'items'
            )
            ->withSum(
                'items',
                'total'
            );

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search =
                trim(
                    $request->search
                );


            $query->where(

                function ($q) use ($search) {

                    /*
                    |----------------------------------------------------------
                    | Receipt Number
                    |----------------------------------------------------------
                    */

                    $q->where(
                        'receipt_number',
                        'like',
                        "%{$search}%"
                    );


                    /*
                    |----------------------------------------------------------
                    | Supplier
                    |----------------------------------------------------------
                    */

                    $q->orWhereHas(

                        'supplier',

                        function ($supplier) use ($search) {

                            $supplier->where(
                                'company_id',
                                $this->companyId
                            );

                            $supplier->where(
                                'name',
                                'like',
                                "%{$search}%"
                            );

                        }

                    );


                    /*
                    |----------------------------------------------------------
                    | Purchase Order
                    |----------------------------------------------------------
                    */

                    $q->orWhereHas(

                        'purchaseOrder',

                        function ($order) use ($search) {

                            $order->where(
                                'company_id',
                                $this->companyId
                            );

                            $order->where(
                                'order_number',
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
        | Branch
        |--------------------------------------------------------------------------
        */

        if ($request->filled('branch_id')) {

            $query->where(
                'branch_id',
                $request->branch_id
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Supplier
        |--------------------------------------------------------------------------
        */

        if ($request->filled('supplier_id')) {

            $query->where(
                'supplier_id',
                $request->supplier_id
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Received Date
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_from')) {

            $query->whereDate(
                'received_date',
                '>=',
                $request->date_from
            );

        }


        if ($request->filled('date_to')) {

            $query->whereDate(
                'received_date',
                '<=',
                $request->date_to
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $received =
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
                'purchase.partials.received-table',
                compact(
                    'received'
                )
            )->render();


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $statsQuery =
            GoodsReceived::query()
                ->where(
                    'company_id',
                    $this->companyId
                );


        /*
        |--------------------------------------------------------------------------
        | Total Received
        |--------------------------------------------------------------------------
        */

        $total =
            (clone $statsQuery)
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Pending
        |--------------------------------------------------------------------------
        */

        $pending =
            (clone $statsQuery)
                ->where(
                    'status',
                    'Pending'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Completed
        |--------------------------------------------------------------------------
        */

        $completed =
            (clone $statsQuery)
                ->where(
                    'status',
                    'Completed'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Received Value
        |--------------------------------------------------------------------------
        */

        $totalValue =
            GoodsReceivedItem::query()
                ->whereHas(

                    'goodsReceived',

                    function ($query) {

                        $query->where(
                            'company_id',
                            $this->companyId
                        );

                    }

                )
                ->sum('total');


        $stats = [

            'total' =>
                $total,

            'pending' =>
                $pending,

            'completed' =>
                $completed,

            'total_value' =>
                (float) $totalValue,

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
                $received
                    ->links()
                    ->render(),

            'stats' =>
                $stats,

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Goods Received Details
    |--------------------------------------------------------------------------
    */

    /**
     * Return Goods Received details.
     */
    public function receivedDetails(
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('purchases.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view goods received.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Goods Received
        |--------------------------------------------------------------------------
        */

        $goodsReceived =
            GoodsReceived::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->with([
                    'supplier',
                    'branch',
                    'purchaseOrder',
                    'receivedBy',
                    'items.product',
                ])
                ->find($id);


        if (!$goodsReceived) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Goods received record not found.',

            ], 404);

        }


        /*
        |--------------------------------------------------------------------------
        | Items
        |--------------------------------------------------------------------------
        */

        $items =
            $goodsReceived->items->map(
                function ($item) {

                    return [

                        'id' =>
                            $item->id,

                        'purchase_order_item_id' =>
                            $item->purchase_order_item_id,

                        'product_id' =>
                            $item->product_id,

                        'product_name' =>
                            $item->product?->name
                                ?? 'Unknown Product',

                        'product_code' =>
                            $item->product?->product_code
                                ?? $item->product?->sku
                                ?? '—',

                        'ordered_quantity' =>
                            (float)
                            $item->ordered_quantity,

                        'received_quantity' =>
                            (float)
                            $item->received_quantity,

                        'unit_cost' =>
                            (float)
                            $item->unit_cost,

                        'total' =>
                            (float)
                            $item->total,

                    ];

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

            'data' => [

                'id' =>
                    $goodsReceived->id,

                'receipt_number' =>
                    $goodsReceived->receipt_number,

                'received_date' =>
                    $goodsReceived->received_date
                        ? $goodsReceived->received_date->format(
                            'Y-m-d'
                        )
                        : null,

                'created_at' =>
                    $goodsReceived->created_at
                        ? $goodsReceived->created_at->toIso8601String()
                        : null,

                'status' =>
                    $goodsReceived->status,

                'notes' =>
                    $goodsReceived->notes,
                'received_by' =>
                    $goodsReceived->receivedBy
                        ? trim(
                            $goodsReceived->receivedBy->first_name .
                            ' ' .
                            $goodsReceived->receivedBy->last_name
                        )
                        : '—',

                'supplier' => [

                    'id' =>
                        $goodsReceived->supplier?->id,

                    'name' =>
                        $goodsReceived->supplier?->name
                            ?? '—',

                ],

                'branch' => [

                    'id' =>
                        $goodsReceived->branch?->id,

                    'name' =>
                        $goodsReceived->branch?->name
                            ?? '—',

                ],

                'purchase_order' => [

                    'id' =>
                        $goodsReceived->purchaseOrder?->id,

                    'order_number' =>
                        $goodsReceived->purchaseOrder?->order_number
                            ?? '—',

                    'status' =>
                        $goodsReceived->purchaseOrder?->status
                            ?? '—',

                ],

                'items' =>
                    $items,

                'total' =>
                    (float)
                    $goodsReceived->items->sum(
                        'total'
                    ),

            ],

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Goods Received
    |--------------------------------------------------------------------------
    */

    /**
     * Return Goods Received table.
     */
    public function received(
        Request $request
    ): JsonResponse {

        if (! canAccess('purchases.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view goods received.',

            ], 403);

        }

        $query =
            GoodsReceived::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->with([
                    'supplier',
                    'branch',
                ]);

        if ($request->filled('search')) {

            $search =
                trim(
                    $request->search
                );

            $query->where(
                function ($q) use ($search) {

                    $q->where(
                        'reference_no',
                        'like',
                        "%{$search}%"
                    );

                    $q->orWhereHas(
                        'supplier',
                        function ($supplier) use ($search) {

                            $supplier->where(
                                'company_id',
                                $this->companyId
                            );

                            $supplier->where(
                                'name',
                                'like',
                                "%{$search}%"
                            );

                        }
                    );

                }
            );

        }

        if ($request->filled('branch_id')) {

            $query->where(
                'branch_id',
                $request->branch_id
            );

        }

        if ($request->filled('supplier_id')) {

            $query->where(
                'supplier_id',
                $request->supplier_id
            );

        }

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }

        if ($request->filled('date_from')) {

            $query->whereDate(
                'received_date',
                '>=',
                $request->date_from
            );

        }

        if ($request->filled('date_to')) {

            $query->whereDate(
                'received_date',
                '<=',
                $request->date_to
            );

        }

        $received =
            $query
                ->latest('id')
                ->paginate(15)
                ->withQueryString();

        $html =
            view(
                'purchase.partials.received-table',
                compact(
                    'received'
                )
            )->render();

        $statsQuery =
            GoodsReceived::query()
                ->where(
                    'company_id',
                    $this->companyId
                );

        $stats = [

            'total' =>
                (clone $statsQuery)->count(),

            'pending' =>
                (clone $statsQuery)
                    ->where(
                        'status',
                        'pending'
                    )
                    ->count(),

            'completed' =>
                (clone $statsQuery)
                    ->where(
                        'status',
                        'completed'
                    )
                    ->count(),

            'total_value' =>
                (float) (
                    (clone $statsQuery)
                        ->sum('total_amount')
                ),

        ];

        return response()->json([

            'success' =>
                true,

            'html' =>
                $html,

            'pagination' =>
                $received
                    ->links()
                    ->render(),

            'stats' =>
                $stats,

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Goods Received - Purchase Orders
    |--------------------------------------------------------------------------
    */

    /**
     * Return approved purchase orders available for goods receiving.
     */
    public function receivedPurchaseOrders(): JsonResponse
    {        
        if (! canAccess('purchases.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view purchase orders.',

            ], 403);

        }       


        $orders =
            PurchaseOrder::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'status',
                    'Approved'
                )

                ->with([
                    'supplier',
                    'branch',
                ])

                ->latest('id')

                ->get();


        return response()->json([

            'success' =>
                true,

            'data' =>
                $orders->map(
                    function ($order) {

                        return [

                            'id' =>
                                $order->id,

                            'order_number' =>
                                $order->order_number,

                            'supplier_id' =>
                                $order->supplier_id,

                            'supplier_name' =>
                                $order->supplier?->name,

                            'branch_id' =>
                                $order->branch_id,

                            'branch_name' =>
                                $order->branch?->name,

                            'order_date' =>
                                $order->order_date,

                            'total' =>
                                $order->total,

                        ];

                    }
                )->values(),

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Purchase Order Receiving Details
    |--------------------------------------------------------------------------
    */

    /**
     * Return Purchase Order details for Goods Received.
     */
    public function orderReceivingDetails(
        int $id
    ): JsonResponse {

        if (! canAccess('purchases.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to receive goods.',

            ], 403);

        }


        $order =
            PurchaseOrder::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->where(
                    'status',
                    'Approved'
                )
                ->with([
                    'supplier',
                    'branch',
                    'items.product',
                ])
                ->find($id);


        if (!$order) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Approved purchase order not found.',

            ], 404);

        }


        /*
        |--------------------------------------------------------------------------
        | Previously Received Quantities
        |--------------------------------------------------------------------------
        */

        $receivedQuantities =
            GoodsReceivedItem::query()
                ->whereHas(
                    'goodsReceived',
                    function ($query) use ($order) {

                        $query->where(
                            'company_id',
                            $this->companyId
                        );

                        $query->where(
                            'purchase_order_id',
                            $order->id
                        );

                        $query->whereNotIn(
                            'status',
                            [
                                'Cancelled',
                            ]
                        );

                    }
                )
                ->selectRaw(
                    'purchase_order_item_id, SUM(received_quantity) as received_quantity'
                )
                ->groupBy(
                    'purchase_order_item_id'
                )
                ->pluck(
                    'received_quantity',
                    'purchase_order_item_id'
                );


        /*
    |--------------------------------------------------------------------------
    | Items
    |--------------------------------------------------------------------------
    */

    $items =
        $order->items
            ->map(
                function ($item) use (
                    $receivedQuantities,
                    $order
                ) {

                    $ordered =
                        (float) $item->quantity;


                    $previouslyReceived =
                        (float) (
                            $receivedQuantities[
                                $item->id
                            ] ?? 0
                        );


                    $remaining =
                        max(
                            $ordered -
                            $previouslyReceived,
                            0
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Product Stock
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
                            ->first();


                    $currentStock =
                        (float) (
                            $stock?->quantity ?? 0
                        );


                    $maximumStock =
                        (float) (
                            $stock?->maximum_stock ?? 0
                        );


                    return [

                        'id' =>
                            $item->id,

                        'product_id' =>
                            $item->product_id,

                        'product' => [

                            'id' =>
                                $item->product?->id,

                            'name' =>
                                $item->product?->name
                                ?? '—',

                            'code' =>
                                $item->product?->product_code
                                ?? '—',

                        ],

                        'ordered_quantity' =>
                            $ordered,

                        'previously_received' =>
                            $previouslyReceived,

                        'remaining_quantity' =>
                            $remaining,

                        'current_stock' =>
                            $currentStock,

                        'maximum_stock' =>
                            $maximumStock,

                        'unit_cost' =>
                            (float) $item->unit_cost,

                        'total' =>
                            (float) $item->total,

                    ];

                }
            )
            ->values();


        return response()->json([

            'success' =>
                true,

            'data' => [

                'id' =>
                    $order->id,

                'order_number' =>
                    $order->order_number,

                'supplier' => [

                    'id' =>
                        $order->supplier?->id,

                    'name' =>
                        $order->supplier?->name
                        ?? '—',

                ],

                'supplier_id' =>
                    $order->supplier_id,

                'branch' => [

                    'id' =>
                        $order->branch?->id,

                    'name' =>
                        $order->branch?->name
                        ?? '—',

                ],

                'branch_id' =>
                    $order->branch_id,

                'order_date' =>
                    $order->order_date?->format(
                        'Y-m-d'
                    ),

                'status' =>
                    $order->status,

                'items' =>
                    $items,

            ],

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Purchase Returns
    |--------------------------------------------------------------------------
    */

    /**
     * Return Purchase Returns table.
     */
    public function returns(
        Request $request
    ): JsonResponse {

        if (! canAccess('purchases.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view purchase returns.',

            ], 403);

        }

        $query =
            PurchaseReturn::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->with([
                    'supplier',
                    'branch',
                ]);

        if ($request->filled('search')) {

            $search =
                trim(
                    $request->search
                );

            $query->where(
                function ($q) use ($search) {

                    $q->where(
                        'return_number',
                        'like',
                        "%{$search}%"
                    );

                    $q->orWhereHas(
                        'supplier',
                        function ($supplier) use ($search) {

                            $supplier->where(
                                'company_id',
                                $this->companyId
                            );

                            $supplier->where(
                                'name',
                                'like',
                                "%{$search}%"
                            );

                        }
                    );

                }
            );

        }

        if ($request->filled('branch_id')) {

            $query->where(
                'branch_id',
                $request->branch_id
            );

        }

        if ($request->filled('supplier_id')) {

            $query->where(
                'supplier_id',
                $request->supplier_id
            );

        }

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }

        if ($request->filled('date_from')) {

            $query->whereDate(
                'return_date',
                '>=',
                $request->date_from
            );

        }

        if ($request->filled('date_to')) {

            $query->whereDate(
                'return_date',
                '<=',
                $request->date_to
            );

        }

        $returns =
            $query
                ->latest('id')
                ->paginate(15)
                ->withQueryString();

        $html =
            view(
                'purchase.partials.returns-table',
                compact(
                    'returns'
                )
            )->render();

        $statsQuery =
            PurchaseReturn::query()
                ->where(
                    'company_id',
                    $this->companyId
                );

        $stats = [

            'total' =>
                (clone $statsQuery)->count(),

            'pending' =>
                (clone $statsQuery)
                    ->where(
                        'status',
                        'pending'
                    )
                    ->count(),

            'completed' =>
                (clone $statsQuery)
                    ->where(
                        'status',
                        'completed'
                    )
                    ->count(),

            'total_value' =>
                (float) (
                    (clone $statsQuery)
                        ->sum('total_amount')
                ),

        ];

        return response()->json([

            'success' =>
                true,

            'html' =>
                $html,

            'pagination' =>
                $returns
                    ->links()
                    ->render(),

            'stats' =>
                $stats,

        ]);
    }

    /**
     * Store Goods Received.
     */
    public function storeReceived(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('purchases.create')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to receive goods.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([

                'purchase_order_id' =>
                    [
                        'required',
                        'integer',
                        'exists:purchase_orders,id',
                    ],

                'received_date' =>
                    [
                        'required',
                        'date',
                    ],

                'notes' =>
                    [
                        'nullable',
                        'string',
                    ],

                'items' =>
                    [
                        'required',
                        'array',
                        'min:1',
                    ],

                'items.*.purchase_order_item_id' =>
                    [
                        'required',
                        'integer',
                        'exists:purchase_order_items,id',
                    ],

                'items.*.product_id' =>
                    [
                        'required',
                        'integer',
                        'exists:products,id',
                    ],

                'items.*.received_quantity' =>
                    [
                        'required',
                        'numeric',
                        'gt:0',
                    ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | Transaction
        |--------------------------------------------------------------------------
        */

        try {

            return DB::transaction(

                function () use ($validated) {

                    /*
                    |--------------------------------------------------------------------------
                    | Purchase Order
                    |--------------------------------------------------------------------------
                    */

                    $order =
                        PurchaseOrder::query()
                            ->where(
                                'company_id',
                                $this->companyId
                            )
                            ->with([
                                'supplier',
                                'branch',
                                'items.product',
                            ])
                            ->lockForUpdate()
                            ->find(
                                $validated['purchase_order_id']
                            );


                    if (!$order) {

                        throw ValidationException::withMessages([

                            'purchase_order_id' =>
                                'Purchase order not found.',

                        ]);

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Approved Order Check
                    |--------------------------------------------------------------------------
                    */

                    if (
                        strtolower(
                            (string) $order->status
                        ) !== 'approved'
                    ) {

                        throw ValidationException::withMessages([

                            'purchase_order_id' =>
                                'Only approved purchase orders can be received.',

                        ]);

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Branch
                    |--------------------------------------------------------------------------
                    */

                    $branchId =
                        $order->branch_id;


                    /*
                    |--------------------------------------------------------------------------
                    | Generate Receipt Number
                    |--------------------------------------------------------------------------
                    */

                    $receiptNumber =
                        DocumentNumberService::generate(
                            'goods_received',
                            $this->companyId
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Prepare Order Items
                    |--------------------------------------------------------------------------
                    */

                    $orderItems =
                        $order->items
                            ->keyBy('id');


                    /*
                    |--------------------------------------------------------------------------
                    | Validate Requested Items
                    |--------------------------------------------------------------------------
                    */

                    $receivedItems = [];

                    $receivedTotal = 0;


                    foreach (
                        $validated['items']
                        as $item
                    ) {

                        $purchaseOrderItemId =
                            (int)
                            $item[
                                'purchase_order_item_id'
                            ];


                        $productId =
                            (int)
                            $item[
                                'product_id'
                            ];


                        $receivedQuantity =
                            (float)
                            $item[
                                'received_quantity'
                            ];


                        /*
                        |--------------------------------------------------------------------------
                        | Purchase Order Item Exists
                        |--------------------------------------------------------------------------
                        */

                        $orderItem =
                            $orderItems->get(
                                $purchaseOrderItemId
                            );


                        if (!$orderItem) {

                            throw ValidationException::withMessages([

                                'items' =>
                                    'One or more items do not belong to this purchase order.',

                            ]);

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Product Must Match PO Item
                        |--------------------------------------------------------------------------
                        */

                        if (
                            (int) $orderItem->product_id
                            !== $productId
                        ) {

                            throw ValidationException::withMessages([

                                'items' =>
                                    'The selected product does not match the purchase order item.',

                            ]);

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Previously Received
                        |--------------------------------------------------------------------------
                        */

                        $previouslyReceived =
                            (float)
                            GoodsReceivedItem::query()
                                ->where(
                                    'purchase_order_item_id',
                                    $purchaseOrderItemId
                                )
                                ->whereHas(
                                    'goodsReceived',
                                    function ($query) {

                                        $query->where(
                                            'company_id',
                                            $this->companyId
                                        );

                                    }
                                )
                                ->sum(
                                    'received_quantity'
                                );


                        /*
                        |--------------------------------------------------------------------------
                        | Remaining Quantity
                        |--------------------------------------------------------------------------
                        */

                        $orderedQuantity =
                            (float)
                            $orderItem->quantity;


                        $remainingQuantity =
                            max(
                                0,
                                $orderedQuantity -
                                $previouslyReceived
                            );


                        if (
                            $receivedQuantity >
                            $remainingQuantity
                        ) {

                            throw ValidationException::withMessages([

                                'items' =>
                                    sprintf(
                                        'You cannot receive %s units of %s. Only %s units remain.',
                                        number_format(
                                            $receivedQuantity,
                                            2
                                        ),
                                        $orderItem->product?->name
                                            ?? 'this product',
                                        number_format(
                                            $remainingQuantity,
                                            2
                                        )
                                    ),

                            ]);

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Product Stock
                        |--------------------------------------------------------------------------
                        |
                        | Lock the stock row so two simultaneous receiving
                        | transactions cannot exceed maximum_stock.
                        |
                        */

                        $stock =
                            ProductStock::query()
                                ->where(
                                    'company_id',
                                    $this->companyId
                                )
                                ->where(
                                    'branch_id',
                                    $branchId
                                )
                                ->where(
                                    'product_id',
                                    $productId
                                )
                                ->lockForUpdate()
                                ->first();


                        /*
                        |--------------------------------------------------------------------------
                        | Create Stock Record If Missing
                        |--------------------------------------------------------------------------
                        */

                        if (!$stock) {

                            $stock =
                                ProductStock::create([

                                    'company_id' =>
                                        $this->companyId,

                                    'branch_id' =>
                                        $branchId,

                                    'product_id' =>
                                        $productId,

                                    'quantity' =>
                                        0,

                                    'reserved_quantity' =>
                                        0,

                                    'available_quantity' =>
                                        0,

                                    'reorder_level' =>
                                        0,

                                    'maximum_stock' =>
                                        0,

                                ]);

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Maximum Stock Validation
                        |--------------------------------------------------------------------------
                        */

                        $currentQuantity =
                            (float)
                            $stock->quantity;


                        $maximumStock =
                            (float)
                            $stock->maximum_stock;


                        $newQuantity =
                            $currentQuantity +
                            $receivedQuantity;


                        if (
                            $maximumStock > 0 &&
                            $newQuantity > $maximumStock
                        ) {

                            $allowedQuantity =
                                max(
                                    0,
                                    $maximumStock -
                                    $currentQuantity
                                );


                            throw ValidationException::withMessages([

                                'items' =>
                                    sprintf(
                                        '%s cannot receive %s units. Current stock is %s and maximum stock is %s. You can receive only %s more units. Increase the maximum stock before receiving more.',
                                        $orderItem->product?->name
                                            ?? 'This product',
                                        number_format(
                                            $receivedQuantity,
                                            2
                                        ),
                                        number_format(
                                            $currentQuantity,
                                            2
                                        ),
                                        number_format(
                                            $maximumStock,
                                            2
                                        ),
                                        number_format(
                                            $allowedQuantity,
                                            2
                                        )
                                    ),

                            ]);

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Calculate Total
                        |--------------------------------------------------------------------------
                        */

                        $unitCost =
                            (float)
                            $orderItem->unit_cost;


                        $itemTotal =
                            $receivedQuantity *
                            $unitCost;


                        $receivedTotal +=
                            $itemTotal;


                        /*
                        |--------------------------------------------------------------------------
                        | Store Prepared Item
                        |--------------------------------------------------------------------------
                        */

                        $receivedItems[] = [

                            'purchase_order_item_id' =>
                                $purchaseOrderItemId,

                            'product_id' =>
                                $productId,

                            'ordered_quantity' =>
                                $orderedQuantity,

                            'received_quantity' =>
                                $receivedQuantity,

                            'unit_cost' =>
                                $unitCost,

                            'total' =>
                                $itemTotal,

                            'stock' =>
                                $stock,

                            'stock_before' =>
                                $currentQuantity,

                            'stock_after' =>
                                $newQuantity,

                        ];

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Create Goods Received Header
                    |--------------------------------------------------------------------------
                    */

                    $goodsReceived =
                        GoodsReceived::create([

                            'company_id' =>
                                $this->companyId,

                            'branch_id' =>
                                $branchId,

                            'purchase_order_id' =>
                                $order->id,

                            'supplier_id' =>
                                $order->supplier_id,

                            'receipt_number' =>
                                $receiptNumber,

                            'received_date' =>
                                $validated['received_date'],

                            'status' =>
                                'Completed',

                            'notes' =>
                                $validated['notes']
                                    ?? null,

                            'received_by' =>
                                auth()->id(),

                        ]);


                    /*
                    |--------------------------------------------------------------------------
                    | Create Items + Update Inventory
                    |--------------------------------------------------------------------------
                    */

                    foreach (
                        $receivedItems
                        as $item
                    ) {

                        /*
                        |--------------------------------------------------------------------------
                        | Goods Received Item
                        |--------------------------------------------------------------------------
                        */

                        GoodsReceivedItem::create([

                            'goods_received_id' =>
                                $goodsReceived->id,

                            'purchase_order_item_id' =>
                                $item[
                                    'purchase_order_item_id'
                                ],

                            'product_id' =>
                                $item[
                                    'product_id'
                                ],

                            'ordered_quantity' =>
                                $item[
                                    'ordered_quantity'
                                ],

                            'received_quantity' =>
                                $item[
                                    'received_quantity'
                                ],

                            'unit_cost' =>
                                $item[
                                    'unit_cost'
                                ],

                            'total' =>
                                $item[
                                    'total'
                                ],

                        ]);


                        /*
                        |--------------------------------------------------------------------------
                        | Update Product Stock
                        |--------------------------------------------------------------------------
                        */

                        $stock =
                            $item['stock'];


                        $stock->quantity =
                            $item['stock_after'];


                        $stock->available_quantity =
                            max(
                                0,
                                (float) $stock->quantity -
                                (float) $stock->reserved_quantity
                            );


                        $stock->save();


                        /*
                        |--------------------------------------------------------------------------
                        | Stock Movement
                        |--------------------------------------------------------------------------
                        */

                        StockMovement::create([

                            'company_id' =>
                                $this->companyId,

                            'branch_id' =>
                                $branchId,

                            'product_id' =>
                                $item[
                                    'product_id'
                                ],

                            'order_id' =>
                                null,

                            'reference_no' =>
                                $receiptNumber,

                            'unit_cost' =>
                                $item[
                                    'unit_cost'
                                ],

                            'quantity' =>
                                $item[
                                    'received_quantity'
                                ],

                            'stock_before' =>
                                $item[
                                    'stock_before'
                                ],

                            'balance_after' =>
                                $item[
                                    'stock_after'
                                ],

                            'remarks' =>
                                'Goods received against purchase order ' .
                                $order->order_number,

                            'created_by' =>
                                auth()->id(),

                            'movement_type' =>
                                'Purchase',

                        ]);

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Determine Purchase Order Status
                    |--------------------------------------------------------------------------
                    */

                    $allReceived =
                        true;


                    /*
                    | Reload previously received quantities
                    */

                    $receivedByItem =
                        GoodsReceivedItem::query()
                            ->whereHas(
                                'goodsReceived',
                                function ($query) use ($order) {

                                    $query->where(
                                        'purchase_order_id',
                                        $order->id
                                    );

                                }
                            )
                            ->selectRaw(
                                'purchase_order_item_id, SUM(received_quantity) as received_quantity'
                            )
                            ->groupBy(
                                'purchase_order_item_id'
                            )
                            ->pluck(
                                'received_quantity',
                                'purchase_order_item_id'
                            );


                    foreach (
                        $order->items
                        as $orderItem
                    ) {

                        $ordered =
                            (float)
                            $orderItem->quantity;


                        $received =
                            (float)
                            (
                                $receivedByItem[
                                    $orderItem->id
                                ]
                                ?? 0
                            );


                        if (
                            $received <
                            $ordered
                        ) {

                            $allReceived =
                                false;

                            break;

                        }

                    }


                    $order->status =
                        $allReceived
                            ? 'Completed'
                            : 'Approved';


                    $order->save();


                    /*
                    |--------------------------------------------------------------------------
                    | Activity Log
                    |--------------------------------------------------------------------------
                    */

                    $this->activityLogger->log(

                        'purchases',

                        'create',

                        'Created goods received: ' .
                            $goodsReceived->receipt_number,

                        $goodsReceived,

                        null,

                        $goodsReceived->toArray()

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
                            'Goods received successfully and inventory has been updated.',

                        'data' => [

                            'id' =>
                                $goodsReceived->id,

                            'receipt_number' =>
                                $goodsReceived->receipt_number,

                            'purchase_order_id' =>
                                $order->id,

                            'purchase_order_number' =>
                                $order->order_number,

                            'received_total' =>
                                $receivedTotal,

                            'status' =>
                                $goodsReceived->status,

                            'purchase_order_status' =>
                                $order->status,

                        ],

                    ]);

                }

            );

        }
        catch (ValidationException $e) {

            throw $e;

        }
        catch (\Throwable $e) {

            Log::error(
                'Failed to store goods received.',
                [
                    'company_id' =>
                        $this->companyId,

                    'purchase_order_id' =>
                        $request->purchase_order_id,

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
                    'Unable to receive goods. Please try again.',

            ], 500);

        }

    }

    /*
    |--------------------------------------------------------------------------
    | Purchase Return - Purchase Orders
    |--------------------------------------------------------------------------
    */

    /**
     * Return purchase orders that have received goods available for return.
     */
    public function returnPurchaseOrders(): JsonResponse
    {
        if (! canAccess('purchases.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view purchase orders.',

            ], 403);

        }


        $receivedPurchaseOrderIds =
            GoodsReceived::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->whereNotNull(
                    'purchase_order_id'
                )
                ->select(
                    'purchase_order_id'
                )
                ->distinct();


        $orders =
            PurchaseOrder::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->whereIn(
                    'id',
                    $receivedPurchaseOrderIds
                )
                ->with([
                    'supplier',
                    'branch',
                ])
                ->latest('id')
                ->get();


        return response()->json([

            'success' =>
                true,

            'data' =>
                $orders->map(
                    function ($order) {

                        return [

                            'id' =>
                                $order->id,

                            'order_number' =>
                                $order->order_number,

                            'supplier_id' =>
                                $order->supplier_id,

                            'supplier_name' =>
                                $order->supplier?->name
                                    ?? 'Unknown Supplier',

                            'branch_id' =>
                                $order->branch_id,

                            'branch_name' =>
                                $order->branch?->name
                                    ?? 'Unknown Branch',

                        ];

                    }
                )->values(),

        ]);
    }

    /*
|--------------------------------------------------------------------------
| Purchase Return - Purchase Order Items
|--------------------------------------------------------------------------
*/

/**
 * Return products received against a purchase order
 * that are still available for return.
 */
public function returnPurchaseOrderItems(
    int $id
): JsonResponse {

    /*
    |--------------------------------------------------------------------------
    | Permission
    |--------------------------------------------------------------------------
    */

    if (! canAccess('purchases.view')) {

        return response()->json([

            'success' =>
                false,

            'message' =>
                'You do not have permission to view purchase return items.',

        ], 403);

    }


    /*
    |--------------------------------------------------------------------------
    | Purchase Order
    |--------------------------------------------------------------------------
    */

    $order =
        PurchaseOrder::query()
            ->where(
                'company_id',
                $this->companyId
            )
            ->find($id);


    if (!$order) {

        return response()->json([

            'success' =>
                false,

            'message' =>
                'Purchase order not found.',

        ], 404);

    }


    /*
    |--------------------------------------------------------------------------
    | Goods Received Items
    |--------------------------------------------------------------------------
    |
    | Only products that were actually received against this
    | purchase order are eligible for return.
    |
    */

    $receivedItems =
        GoodsReceivedItem::query()
            ->whereHas(
                'goodsReceived',
                function ($query) use ($order) {

                    $query->where(
                        'company_id',
                        $this->companyId
                    );

                    $query->where(
                        'purchase_order_id',
                        $order->id
                    );

                    $query->where(
                        'status',
                        'Completed'
                    );

                }
            )
            ->with([
                'product',
                'goodsReceived',
            ])
            ->get();


    /*
    |--------------------------------------------------------------------------
    | Already Returned Quantities
    |--------------------------------------------------------------------------
    */

    $returnedQuantities =
        PurchaseReturnItem::query()
            ->whereHas(
                'purchaseReturn',
                function ($query) use ($order) {

                    $query->where(
                        'company_id',
                        $this->companyId
                    );

                    $query->where(
                        'purchase_order_id',
                        $order->id
                    );

                    $query->whereNotIn(
                        'status',
                        [
                            'Cancelled',
                        ]
                    );

                }
            )
            ->selectRaw(
                'goods_received_item_id,
                 SUM(quantity) as returned_quantity'
            )
            ->groupBy(
                'goods_received_item_id'
            )
            ->pluck(
                'returned_quantity',
                'goods_received_item_id'
            );


    /*
    |--------------------------------------------------------------------------
    | Prepare Returnable Items
    |--------------------------------------------------------------------------
    */

    $items =
        $receivedItems
            ->map(
                function ($receivedItem) use (
                    $returnedQuantities
                ) {

                    $receivedQuantity =
                        (float)
                        $receivedItem->received_quantity;


                    $returnedQuantity =
                        (float)
                        (
                            $returnedQuantities[
                                $receivedItem->id
                            ]
                            ?? 0
                        );


                    $availableQuantity =
                        max(
                            $receivedQuantity -
                            $returnedQuantity,
                            0
                        );


                    if (
                        $availableQuantity <= 0
                    ) {

                        return null;

                    }


                    return [

                        'goods_received_item_id' =>
                            $receivedItem->id,

                        'product_id' =>
                            $receivedItem->product_id,

                        'product_name' =>
                            $receivedItem->product?->name
                                ?? 'Unknown Product',

                        'product_code' =>
                            $receivedItem->product?->product_code
                                ?? $receivedItem->product?->sku
                                ?? '—',

                        'received_quantity' =>
                            $receivedQuantity,

                        'returned_quantity' =>
                            $returnedQuantity,

                        'available_return_quantity' =>
                            $availableQuantity,

                        'unit_cost' =>
                            (float)
                            $receivedItem->unit_cost,

                        'received_date' =>
                            $receivedItem->goodsReceived?->received_date,

                        'received_at' =>
                            $receivedItem->goodsReceived?->created_at
                                ? $receivedItem->goodsReceived->created_at->toIso8601String()
                                : null,

                    ];

                }
            )
            ->filter()
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
            $items,

    ]);

}

/*
|--------------------------------------------------------------------------
| Store Purchase Return
|--------------------------------------------------------------------------
*/

/**
 * Store Purchase Return.
 */
public function storeReturn(
    Request $request
): JsonResponse {

    /*
    |--------------------------------------------------------------------------
    | Permission
    |--------------------------------------------------------------------------
    */

    if (! canAccess('purchases.create')) {

        return response()->json([

            'success' =>
                false,

            'message' =>
                'You do not have permission to process purchase returns.',

        ], 403);

    }


    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    $validated =
        $request->validate([

            'supplier_id' => [
                'required',
                'integer',
                'exists:suppliers,id',
            ],

            'branch_id' => [
                'required',
                'integer',
                'exists:branches,id',
            ],

            'purchase_order_id' => [
                'required',
                'integer',
                'exists:purchase_orders,id',
            ],

            'return_date' => [
                'required',
                'date',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.goods_received_item_id' => [
                'required',
                'integer',
                'exists:goods_received_items,id',
            ],

            'items.*.product_id' => [
                'required',
                'integer',
                'exists:products,id',
            ],

            'items.*.quantity' => [
                'required',
                'numeric',
                'gt:0',
            ],

            'items.*.reason' => [
                'nullable',
                'string',
                'max:500',
            ],

        ]);


    /*
    |--------------------------------------------------------------------------
    | Transaction
    |--------------------------------------------------------------------------
    */

    try {

        return DB::transaction(

            function () use ($validated) {

                /*
                |--------------------------------------------------------------------------
                | Purchase Order
                |--------------------------------------------------------------------------
                */

                $order =
                    PurchaseOrder::query()
                        ->where(
                            'company_id',
                            $this->companyId
                        )
                        ->with([
                            'supplier',
                            'branch',
                        ])
                        ->lockForUpdate()
                        ->find(
                            $validated['purchase_order_id']
                        );


                if (!$order) {

                    throw ValidationException::withMessages([

                        'purchase_order_id' =>
                            'Purchase order not found.',

                    ]);

                }


                /*
                |--------------------------------------------------------------------------
                | Supplier Validation
                |--------------------------------------------------------------------------
                */

                if (
                    (int) $order->supplier_id !==
                    (int) $validated['supplier_id']
                ) {

                    throw ValidationException::withMessages([

                        'supplier_id' =>
                            'The selected supplier does not belong to this purchase order.',

                    ]);

                }


                /*
                |--------------------------------------------------------------------------
                | Branch Validation
                |--------------------------------------------------------------------------
                */

                if (
                    (int) $order->branch_id !==
                    (int) $validated['branch_id']
                ) {

                    throw ValidationException::withMessages([

                        'branch_id' =>
                            'The selected branch does not belong to this purchase order.',

                    ]);

                }


                /*
                |--------------------------------------------------------------------------
                | Generate Return Number
                |--------------------------------------------------------------------------
                */

                $returnNumber =
                    DocumentNumberService::generate(
                        'purchase_return',
                        $this->companyId
                    );


                /*
                |--------------------------------------------------------------------------
                | Prepare Items
                |--------------------------------------------------------------------------
                */

                $returnItems = [];

                $returnTotal = 0;


                foreach (
                    $validated['items']
                    as $item
                ) {

                    $goodsReceivedItemId =
                        (int)
                        $item[
                            'goods_received_item_id'
                        ];


                    $productId =
                        (int)
                        $item[
                            'product_id'
                        ];


                    $returnQuantity =
                        (float)
                        $item[
                            'quantity'
                        ];


                    /*
                    |--------------------------------------------------------------------------
                    | Goods Received Item
                    |--------------------------------------------------------------------------
                    */

                    $goodsReceivedItem =
                        GoodsReceivedItem::query()
                            ->whereHas(
                                'goodsReceived',
                                function ($query) use ($order) {

                                    $query->where(
                                        'company_id',
                                        $this->companyId
                                    );

                                    $query->where(
                                        'purchase_order_id',
                                        $order->id
                                    );

                                    $query->where(
                                        'branch_id',
                                        $order->branch_id
                                    );

                                }
                            )
                            ->with([
                                'goodsReceived',
                                'product',
                            ])
                            ->lockForUpdate()
                            ->find(
                                $goodsReceivedItemId
                            );


                    if (!$goodsReceivedItem) {

                        throw ValidationException::withMessages([

                            'items' =>
                                'One or more selected goods received items do not belong to this purchase order.',

                        ]);

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Product Validation
                    |--------------------------------------------------------------------------
                    */

                    if (
                        (int) $goodsReceivedItem->product_id !==
                        $productId
                    ) {

                        throw ValidationException::withMessages([

                            'items' =>
                                'The selected product does not match the goods received item.',

                        ]);

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Received Quantity
                    |--------------------------------------------------------------------------
                    */

                    $receivedQuantity =
                        (float)
                        $goodsReceivedItem->received_quantity;


                    /*
                    |--------------------------------------------------------------------------
                    | Previously Returned
                    |--------------------------------------------------------------------------
                    */

                    $previouslyReturned =
                        PurchaseReturnItem::query()
                            ->where(
                                'goods_received_item_id',
                                $goodsReceivedItem->id
                            )
                            ->whereHas(
                                'purchaseReturn',
                                function ($query) {

                                    $query->where(
                                        'company_id',
                                        $this->companyId
                                    );

                                    $query->whereNotIn(
                                        'status',
                                        [
                                            'Cancelled',
                                        ]
                                    );

                                }
                            )
                            ->sum(
                                'quantity'
                            );


                    $previouslyReturned =
                        (float)
                        $previouslyReturned;


                    /*
                    |--------------------------------------------------------------------------
                    | Available Return Quantity
                    |--------------------------------------------------------------------------
                    */

                    $availableReturnQuantity =
                        max(
                            $receivedQuantity -
                            $previouslyReturned,
                            0
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Validate Return Quantity
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $returnQuantity >
                        $availableReturnQuantity
                    ) {

                        throw ValidationException::withMessages([

                            'items' =>
                                sprintf(
                                    '%s cannot be returned in the quantity requested. Received: %s, Already returned: %s, Available to return: %s.',
                                    $goodsReceivedItem->product?->name
                                        ?? 'This product',
                                    number_format(
                                        $receivedQuantity,
                                        2
                                    ),
                                    number_format(
                                        $previouslyReturned,
                                        2
                                    ),
                                    number_format(
                                        $availableReturnQuantity,
                                        2
                                    )
                                ),

                        ]);

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Product Stock
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
                                $productId
                            )
                            ->lockForUpdate()
                            ->first();


                    if (!$stock) {

                        throw ValidationException::withMessages([

                            'items' =>
                                sprintf(
                                    'Stock record for %s was not found.',
                                    $goodsReceivedItem->product?->name
                                        ?? 'this product'
                                ),

                        ]);

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Current Stock
                    |--------------------------------------------------------------------------
                    */

                    $currentStock =
                        (float)
                        $stock->quantity;


                    /*
                    |--------------------------------------------------------------------------
                    | Stock Availability
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $returnQuantity >
                        $currentStock
                    ) {

                        throw ValidationException::withMessages([

                            'items' =>
                                sprintf(
                                    '%s cannot be returned because current stock is only %s.',
                                    $goodsReceivedItem->product?->name
                                        ?? 'This product',
                                    number_format(
                                        $currentStock,
                                        2
                                    )
                                ),

                        ]);

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Unit Cost
                    |--------------------------------------------------------------------------
                    */

                    $unitCost =
                        (float)
                        $goodsReceivedItem->unit_cost;


                    /*
                    |--------------------------------------------------------------------------
                    | Item Total
                    |--------------------------------------------------------------------------
                    */

                    $itemTotal =
                        $returnQuantity *
                        $unitCost;


                    $returnTotal +=
                        $itemTotal;


                    /*
                    |--------------------------------------------------------------------------
                    | Prepare Item
                    |--------------------------------------------------------------------------
                    */

                    $returnItems[] = [

                        'goods_received_item_id' =>
                            $goodsReceivedItem->id,

                        'product_id' =>
                            $productId,

                        'quantity' =>
                            $returnQuantity,

                        'unit_cost' =>
                            $unitCost,

                        'total' =>
                            $itemTotal,

                        'stock' =>
                            $stock,

                        'stock_before' =>
                            $currentStock,

                        'stock_after' =>
                            $currentStock -
                            $returnQuantity,

                    ];

                }


                /*
                |--------------------------------------------------------------------------
                | Create Purchase Return Header
                |--------------------------------------------------------------------------
                */

                $purchaseReturn =
                    PurchaseReturn::create([

                        'company_id' =>
                            $this->companyId,

                        'branch_id' =>
                            $order->branch_id,

                        'supplier_id' =>
                            $order->supplier_id,

                        'purchase_order_id' =>
                            $order->id,

                        'return_number' =>
                            $returnNumber,

                        'return_date' =>
                            $validated['return_date'],

                        'status' =>
                            'Completed',

                        'notes' =>
                            $validated['notes']
                                ?? null,

                        'created_by' =>
                            auth()->id(),

                        'reason' =>
                            $item['reason']
                                ?? null,

                    ]);


                /*
                |--------------------------------------------------------------------------
                | Create Return Items + Update Inventory
                |--------------------------------------------------------------------------
                */

                foreach (
                    $returnItems
                    as $item
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | Purchase Return Item
                    |--------------------------------------------------------------------------
                    */

                    PurchaseReturnItem::create([

                        'purchase_return_id' =>
                            $purchaseReturn->id,

                        'goods_received_item_id' =>
                            $item[
                                'goods_received_item_id'
                            ],

                        'product_id' =>
                            $item[
                                'product_id'
                            ],

                        'quantity' =>
                            $item[
                                'quantity'
                            ],

                        'unit_cost' =>
                            $item[
                                'unit_cost'
                            ],

                        'total' =>
                            $item[
                                'total'
                            ],

                    ]);


                    /*
                    |--------------------------------------------------------------------------
                    | Product Stock
                    |--------------------------------------------------------------------------
                    */

                    $stock =
                        $item['stock'];


                    $stock->quantity =
                        $item['stock_after'];


                    $stock->available_quantity =
                        max(
                            0,
                            (float) $stock->quantity -
                            (float) $stock->reserved_quantity
                        );


                    $stock->save();


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
                            $item[
                                'product_id'
                            ],

                        'order_id' =>
                            null,

                        'reference_no' =>
                            $returnNumber,

                        'unit_cost' =>
                            $item[
                                'unit_cost'
                            ],

                        'quantity' =>
                            -$item[
                                'quantity'
                            ],

                        'stock_before' =>
                            $item[
                                'stock_before'
                            ],

                        'balance_after' =>
                            $item[
                                'stock_after'
                            ],

                        'remarks' =>
                            'Purchase return against purchase order ' .
                            $order->order_number,

                        'created_by' =>
                            auth()->id(),

                        'movement_type' =>
                            'Purchase',

                    ]);

                }


                /*
                |--------------------------------------------------------------------------
                | Activity Log
                |--------------------------------------------------------------------------
                */

                $this->activityLogger->log(

                    'purchases',

                    'create',

                    'Created purchase return: ' .
                        $purchaseReturn->return_number,

                    $purchaseReturn,

                    null,

                    $purchaseReturn->toArray()

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
                        'Purchase return processed successfully and inventory has been updated.',

                    'data' => [

                        'id' =>
                            $purchaseReturn->id,

                        'return_number' =>
                            $purchaseReturn->return_number,

                        'purchase_order_id' =>
                            $order->id,

                        'purchase_order_number' =>
                            $order->order_number,

                        'returned_total' =>
                            $returnTotal,

                        'status' =>
                            $purchaseReturn->status,

                    ],

                ]);

            }

        );

    }
    catch (ValidationException $e) {

        throw $e;

    }
    catch (\Throwable $e) {

        Log::error(
            'Failed to store purchase return.',
            [

                'company_id' =>
                    $this->companyId,

                'purchase_order_id' =>
                    $request->purchase_order_id,

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
                'Unable to process purchase return. Please try again.',

        ], 500);

    }

}

/*
|--------------------------------------------------------------------------
| Purchase Returns
|--------------------------------------------------------------------------
*/

/**
 * Return Purchase Returns table.
 */
public function returnTable(
    Request $request
): JsonResponse {

    /*
    |--------------------------------------------------------------------------
    | Permission
    |--------------------------------------------------------------------------
    */

    if (! canAccess('purchases.view')) {

        return response()->json([

            'success' =>
                false,

            'message' =>
                'You do not have permission to view purchase returns.',

        ], 403);

    }


    /*
    |--------------------------------------------------------------------------
    | Base Query
    |--------------------------------------------------------------------------
    */

    $query =
        PurchaseReturn::query()
            ->where(
                'company_id',
                $this->companyId
            )
            ->with([
                'supplier',
                'branch',
                'purchaseOrder',
                'createdBy',
            ])
            ->withCount(
                'items'
            )
            ->withSum(
                'items',
                'total'
            );


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
                |--------------------------------------------------------------
                | Return Number
                |--------------------------------------------------------------
                */

                $q->where(
                    'return_number',
                    'like',
                    "%{$search}%"
                );


                /*
                |--------------------------------------------------------------
                | Supplier
                |--------------------------------------------------------------
                */

                $q->orWhereHas(

                    'supplier',

                    function ($supplier) use (
                        $search
                    ) {

                        $supplier->where(
                            'company_id',
                            $this->companyId
                        );

                        $supplier->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );

                    }

                );


                /*
                |--------------------------------------------------------------
                | Purchase Order
                |--------------------------------------------------------------
                */

                $q->orWhereHas(

                    'purchaseOrder',

                    function ($order) use (
                        $search
                    ) {

                        $order->where(
                            'company_id',
                            $this->companyId
                        );

                        $order->where(
                            'order_number',
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
    | Supplier
    |--------------------------------------------------------------------------
    */

    if (
        $request->filled('supplier_id')
    ) {

        $query->where(
            'supplier_id',
            $request->supplier_id
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
    | Status
    |--------------------------------------------------------------------------
    */

    if (
        $request->filled('status')
    ) {

        $query->where(
            'status',
            $request->status
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Return Date
    |--------------------------------------------------------------------------
    */

    if (
        $request->filled('date_from')
    ) {

        $query->whereDate(
            'return_date',
            '>=',
            $request->date_from
        );

    }


    if (
        $request->filled('date_to')
    ) {

        $query->whereDate(
            'return_date',
            '<=',
            $request->date_to
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    $returns =
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
            'purchase.partials.returns-table',
            compact(
                'returns'
            )
        )->render();


    /*
    |--------------------------------------------------------------------------
    | Statistics
    |--------------------------------------------------------------------------
    */

    $statsQuery =
        PurchaseReturn::query()
            ->where(
                'company_id',
                $this->companyId
            );


    /*
    |--------------------------------------------------------------------------
    | Total Returns
    |--------------------------------------------------------------------------
    */

    $total =
        (clone $statsQuery)
            ->count();


    /*
    |--------------------------------------------------------------------------
    | Pending
    |--------------------------------------------------------------------------
    */

    $pending =
        (clone $statsQuery)
            ->where(
                'status',
                'Pending'
            )
            ->count();


    /*
    |--------------------------------------------------------------------------
    | Completed
    |--------------------------------------------------------------------------
    */

    $completed =
        (clone $statsQuery)
            ->where(
                'status',
                'Completed'
            )
            ->count();


    /*
    |--------------------------------------------------------------------------
    | Return Value
    |--------------------------------------------------------------------------
    */

    $totalValue =
        PurchaseReturnItem::query()
            ->whereHas(

                'purchaseReturn',

                function ($query) {

                    $query->where(
                        'company_id',
                        $this->companyId
                    );

                }

            )
            ->sum(
                'total'
            );


    $stats = [

        'total' =>
            $total,

        'pending' =>
            $pending,

        'completed' =>
            $completed,

        'total_value' =>
            (float) $totalValue,

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
            $returns
                ->links()
                ->render(),

        'stats' =>
            $stats,

    ]);

}



}