<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use App\Models\GoodsReceived;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseReturn;
use App\Models\Supplier;
use App\Services\ActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PurchaseController extends BaseController
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
     * Display Purchasing workspace.
     */
    public function index(): \Illuminate\View\View
    {
        if (! canAccess('purchases.view')) {

            abort(403);

        }

        $branches =
            Branch::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->orderBy('name')
                ->get();

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

        return view(
            'purchase.index',
            compact(
                'branches',
                'suppliers'
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

        if (! canAccess('purchases.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view purchase orders.',

            ], 403);

        }

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
        | Date Range
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_from')) {

            $query->whereDate(
                'order_date',
                '>=',
                $request->date_from
            );

        }

        if ($request->filled('date_to')) {

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

        $statsQuery =
            PurchaseOrder::query()
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
     * Return Purchase Order details.
     */
    public function orderDetails(
        int $id
    ): JsonResponse {

        if (! canAccess('purchases.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view purchase orders.',

            ], 403);

        }

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
                    'items.product',
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

        return response()->json([

            'success' =>
                true,

           'data' => [

                'id' =>
                    $order->id,

                'order_number' =>
                    $order->order_number,

                'order_date' =>
                    $order->order_date?->format('Y-m-d'),

                'expected_date' =>
                    $order->expected_date?->format('Y-m-d'),

                'status' =>
                    $order->status,

                'supplier' =>
                    $order->supplier?->name
                    ?? '—',

                'supplier_id' =>
                    $order->supplier_id,

                'branch' =>
                    $order->branch?->name
                    ?? '—',

                'branch_id' =>
                    $order->branch_id,

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

                'notes' =>
                    $order->notes
                    ?? '—',

                'created_by' =>
                    $order->creator
                        ? trim(
                            $order->creator->first_name .
                            ' ' .
                            $order->creator->last_name
                        )
                        : '—',

                'created_at' =>
                    $order->created_at?->format(
                        'Y-m-d H:i:s'
                    ),

                // 'updated_by' =>
                //     $order->updater?->name
                //     ?? '—',

                'updated_at' =>
                    $order->updated_at?->format(
                        'Y-m-d H:i:s'
                    ),

               'approved_by' =>
                    $order->approver
                        ? trim(
                            $order->approver->first_name .
                            ' ' .
                            $order->approver->last_name
                        )
                        : '—',

                'approved_at' =>
                    $order->approved_at?->format(
                        'Y-m-d H:i:s'
                    ),

                'items' =>
                    $order->items
                        ->map(
                            function ($item) {

                                return [

                                    'id' =>
                                        $item->id,

                                    'product_id' =>
                                        $item->product_id,

                                    'product' =>
                                        $item->product?->name
                                        ?? '—',

                                    'product_code' =>
                                        $item->product?->product_code
                                        ?? '—',

                                    'quantity' =>
                                        (float) $item->quantity,

                                    'unit_cost' =>
                                        (float) $item->unit_cost,

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

        if (!$order->isDraft()) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Only draft purchase orders can be approved.',

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
                'Approved',

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
}