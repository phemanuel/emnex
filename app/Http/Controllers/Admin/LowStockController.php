<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Branch;
use App\Models\ProductCategory;
use App\Models\ProductStock;
use App\Models\StockMovement;
use Illuminate\Http\Request;


class LowStockController extends BaseController
{

    /*
    |--------------------------------------------------------------------------
    | Low Stock Index
    |--------------------------------------------------------------------------
    |
    | Displays the Low Stock management page.
    |
    */


    public function index(Request $request)
    {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('inventory.low_stock')) {

            abort(
                403,
                'You do not have permission to view low stock.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */

        $stockQuery = ProductStock::query()

            ->where(
                'company_id',
                $this->companyId
            )

            ->whereColumn(
                'quantity',
                '<=',
                'reorder_level'
            )

            ->where(
                'quantity',
                '>',
                0
            );


        /*
        |--------------------------------------------------------------------------
        | Branch Access
        |--------------------------------------------------------------------------
        */

        if (! canManageAllBranches()) {

            $stockQuery->where(
                'branch_id',
                currentBranchId()
            );

        }
        elseif ($request->filled('branch')) {

            $stockQuery->where(
                'branch_id',
                $request->branch
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $stats = [

            /*
            |--------------------------------------------------------------------------
            | Total Low Stock
            |--------------------------------------------------------------------------
            */

            'total' =>

                (clone $stockQuery)
                    ->count(),


            /*
            |--------------------------------------------------------------------------
            | Critical Stock
            |--------------------------------------------------------------------------
            |
            | Critical means the current quantity is at or below
            | 25% of the reorder level.
            |
            */

            'critical' =>

                (clone $stockQuery)

                    ->whereColumn(
                        'quantity',
                        '<=',
                        'reorder_level'
                    )

                    ->whereRaw(
                        'quantity <= (reorder_level * 0.25)'
                    )

                    ->count(),


            /*
            |--------------------------------------------------------------------------
            | Total Quantity
            |--------------------------------------------------------------------------
            */

            'quantity' =>

                (clone $stockQuery)
                    ->sum('quantity'),


            /*
            |--------------------------------------------------------------------------
            | Estimated Reorder Value
            |--------------------------------------------------------------------------
            |
            | Reorder quantity:
            |
            | Maximum Stock - Current Quantity
            |
            | Reorder value:
            |
            | Reorder Quantity × Product Cost Price
            |
            */

            'value' =>

                (clone $stockQuery)

                    ->with('product:id,cost_price')

                    ->get()

                    ->sum(
                        function ($stock) {

                            $reorderQuantity = max(
                                0,
                                (float) $stock->maximum_stock -
                                (float) $stock->quantity
                            );


                            return $reorderQuantity *
                                (float) (
                                    $stock->product?->cost_price ?? 0
                                );

                        }
                    ),

        ];


        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories = ProductCategory::query()

            ->where(
                'company_id',
                $this->companyId
            )

            ->orderBy(
                'name'
            )

            ->get();


        /*
        |--------------------------------------------------------------------------
        | Branches
        |--------------------------------------------------------------------------
        */

        if (canManageAllBranches()) {

            $branches = Branch::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'status',
                    true
                )

                ->orderBy(
                    'name'
                )

                ->get();

        }
        else {

            $branches = Branch::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->whereKey(
                    currentBranchId()
                )

                ->get();

        }


        /*
        |--------------------------------------------------------------------------
        | Initial Table Data
        |--------------------------------------------------------------------------
        */

        $stocks = (clone $stockQuery)

            ->with([

                'product.category',

                'product.unit',

                'branch',

            ])

            ->latest()

            ->paginate(15);


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view(

            'low-stock.index',

            compact(

                'stats',

                'categories',

                'branches',

                'stocks'

            )

        );

    }

    /*
    |--------------------------------------------------------------------------
    | Low Stock Table
    |--------------------------------------------------------------------------
    */

    public function table(Request $request)
    {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('inventory.low_stock')) {

            return response()->json([

                'success' => false,

                'message' =>
                    'You do not have permission to view low stock.',

            ], 403);

        }


        /*
    |--------------------------------------------------------------------------
    | Base Query
    |--------------------------------------------------------------------------
    */

    $stocks = ProductStock::query()

        ->where(
            'company_id',
            $this->companyId
        )

        ->with([

            'product.category',

            'product.unit',

            'branch',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Branch Access
        |--------------------------------------------------------------------------
        */

        if (! canManageAllBranches()) {

            $stocks->where(
                'branch_id',
                currentBranchId()
            );

        }
        elseif ($request->filled('branch')) {

            $stocks->where(
                'branch_id',
                $request->branch
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


            $stocks->whereHas(

                'product',

                function ($query) use ($search) {

                    $query->where(

                        function ($query) use ($search) {

                            $query

                                ->where(
                                    'name',
                                    'like',
                                    "%{$search}%"
                                )

                                ->orWhere(
                                    'sku',
                                    'like',
                                    "%{$search}%"
                                )

                                ->orWhere(
                                    'barcode',
                                    'like',
                                    "%{$search}%"
                                )

                                ->orWhere(
                                    'product_code',
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
        | Category Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('category')) {

            $stocks->whereHas(

                'product',

                function ($query) use ($request) {

                    $query->where(

                        'product_category_id',

                        $request->category

                    );

                }

            );

        }


        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            switch ($request->status) {


                /*
                |--------------------------------------------------------------------------
                | Low Stock
                |--------------------------------------------------------------------------
                */

                case 'low':

                    $stocks

                        ->where(
                            'quantity',
                            '>',
                            0
                        )

                        ->whereColumn(
                            'quantity',
                            '<=',
                            'reorder_level'
                        );

                    break;


                /*
                |--------------------------------------------------------------------------
                | Out Of Stock
                |--------------------------------------------------------------------------
                */

                case 'out':

                    $stocks->where(
                        'quantity',
                        '<=',
                        0
                    );

                    break;

            }

        }
        else {

            /*
            |--------------------------------------------------------------------------
            | All Status
            |--------------------------------------------------------------------------
            |
            | The Low Stock page should show:
            |
            | - Low Stock
            | - Out Of Stock
            |
            | Normal stock must not appear.
            |
            */

            $stocks->where(function ($query) {

                $query

                    ->where(function ($query) {

                        $query

                            ->where(
                                'quantity',
                                '>',
                                0
                            )

                            ->whereColumn(
                                'quantity',
                                '<=',
                                'reorder_level'
                            );

                    })

                    ->orWhere(
                        'quantity',
                        '<=',
                        0
                    );

            });

        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $stocks = $stocks

            ->latest()

            ->paginate(15)

            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Table HTML
        |--------------------------------------------------------------------------
        */

        $html = view(

            'low-stock.partials.table',

            compact(
                'stocks'
            )

        )->render();


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'html' => $html,

            'pagination' =>
                $stocks->links()->render(),

            'stats' => [

                'total' =>
                    $stocks->total(),

            ],

        ]);

    }
/*
    |--------------------------------------------------------------------------
    | Low Stock Details
    |--------------------------------------------------------------------------
    |
    | Returns the selected stock record for the inspector.
    |
    */


    public function details($id)
    {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('inventory.low_stock')) {

            return response()->json([

                'success' => false,

                'message' =>
                    'You do not have permission to view low stock details.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */

        $stockQuery = ProductStock::query()

        ->where(
            'company_id',
            $this->companyId
        )

        ->whereColumn(
            'quantity',
            '<=',
            'reorder_level'
        )

        ->where(
            'quantity',
            '>',
            0
        );


        /*
        |--------------------------------------------------------------------------
        | Branch Access
        |--------------------------------------------------------------------------
        */

        if (! canManageAllBranches()) {

            $stockQuery->where(
                'branch_id',
                currentBranchId()
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Stock
        |--------------------------------------------------------------------------
        */

        $stock =
            $stockQuery->findOrFail(
                $id
            );


        /*
        |--------------------------------------------------------------------------
        | Movement History
        |--------------------------------------------------------------------------
        */

        $movements = StockMovement::query()

            ->where(
                'company_id',
                $this->companyId
            )

            ->where(
                'product_id',
                $stock->product_id
            )

            ->where(
                'branch_id',
                $stock->branch_id
            )

            ->with([
                'user'
            ])

            ->latest()

            ->limit(10)

            ->get();


        /*
        |--------------------------------------------------------------------------
        | Reorder Information
        |--------------------------------------------------------------------------
        */

        $currentQuantity =
            (float) $stock->quantity;


        $reorderLevel =
            (float) $stock->reorder_level;


        $maximumStock =
            (float) $stock->maximum_stock;


        $stockGap =
            max(
                0,
                $reorderLevel -
                $currentQuantity
            );


        $reorderQuantity =
            max(
                0,
                $maximumStock -
                $currentQuantity
            );


        $costPrice =
            (float) (
                $stock->product?->cost_price ?? 0
            );


        $estimatedReorderValue =
            $reorderQuantity *
            $costPrice;


        /*
        |--------------------------------------------------------------------------
        | Severity
        |--------------------------------------------------------------------------
        */

        if (
            $reorderLevel > 0 &&
            $currentQuantity <=
            ($reorderLevel * 0.25)
        ) {

            $severity =
                'Critical';

        }
        else {

            $severity =
                'Low Stock';

        }


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'data' => [

                /*
                |--------------------------------------------------------------------------
                | Stock ID
                |--------------------------------------------------------------------------
                */

                'id' =>
                    $stock->id,


                /*
                |--------------------------------------------------------------------------
                | Product
                |--------------------------------------------------------------------------
                */

                'product' => [

                    'id' =>
                        $stock->product_id,

                    'name' =>
                        $stock->product->name ?? '-',

                    'sku' =>
                        $stock->product->sku ?? '-',

                    'product_code' =>
                        $stock->product->product_code ?? '-',

                    'barcode' =>
                        $stock->product->barcode ?? '-',

                    'image' =>
                        $stock->product->image ?? null,

                    'cost_price' =>
                        $costPrice,

                    'selling_price' =>
                        (float) (
                            $stock->product?->selling_price ?? 0
                        ),

                    'category' => [

                        'name' =>
                            $stock->product
                                ->category
                                ->name ?? '-',

                    ],

                    'unit' => [

                        'name' =>
                            $stock->product
                                ->unit
                                ->name ?? '-',

                    ],

                ],


                /*
                |--------------------------------------------------------------------------
                | Branch
                |--------------------------------------------------------------------------
                */

                'branch' => [

                    'id' =>
                        $stock->branch_id,

                    'name' =>
                        $stock->branch->name ?? '-',

                ],


                /*
                |--------------------------------------------------------------------------
                | Stock
                |--------------------------------------------------------------------------
                */

                'quantity' =>
                    $currentQuantity,

                'reserved_quantity' =>
                    (float) $stock->reserved_quantity,

                'available_quantity' =>
                    (float) $stock->available_quantity,

                'reorder_level' =>
                    $reorderLevel,

                'maximum_stock' =>
                    $maximumStock,


                /*
                |--------------------------------------------------------------------------
                | Reorder
                |--------------------------------------------------------------------------
                */

                'stock_gap' =>
                    $stockGap,

                'reorder_quantity' =>
                    $reorderQuantity,

                'estimated_reorder_value' =>
                    $estimatedReorderValue,


                /*
                |--------------------------------------------------------------------------
                | Severity
                |--------------------------------------------------------------------------
                */

                'severity' =>
                    $severity,


                /*
                |--------------------------------------------------------------------------
                | Movements
                |--------------------------------------------------------------------------
                */

                'movements' =>

                    $movements->map(

                        function ($movement) {

                            return [

                                'movement_type' =>
                                    $movement->movement_type,

                                'quantity' =>
                                    (float)
                                    $movement->quantity,

                                'stock_before' =>
                                    (float)
                                    $movement->stock_before,

                                'stock_after' =>
                                    (float)
                                    $movement->stock_after,

                                'reference_no' =>
                                    $movement->reference_no,

                                'remarks' =>
                                    $movement->remarks,

                                'user' => [

                                    'name' =>
                                        $movement
                                            ->user
                                            ->name
                                            ?? 'System',

                                ],

                                'created_at' =>
                                    $movement->created_at
                                        ?->format(
                                            'd M Y, h:i A'
                                        ),

                            ];

                        }

                    ),

            ],

        ]);

    }

}