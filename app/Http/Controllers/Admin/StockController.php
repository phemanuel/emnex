<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\ProductStock;
use App\Models\ProductCategory;
use App\Models\Branch;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ActivityLogger;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Auth;


class StockController extends BaseController
{

    protected ActivityLogger $activityLogger;


    public function __construct(ActivityLogger $activityLogger)
    {
        parent::__construct();

        $this->activityLogger = $activityLogger;
    }
    /*
    |--------------------------------------------------------------------------
    | Stock Page
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {

        /*
        |--------------------------------------------------------------------------
        | Base Stock Query
        |--------------------------------------------------------------------------
        */

        $stockQuery = ProductStock::query()

            ->where(
                'company_id',
                companyId()
            );

        /*
        |--------------------------------------------------------------------------
        | Branch Access
        |--------------------------------------------------------------------------
        */

        if (!canManageAllBranches()) {

            $stockQuery->where(
                'branch_id',
                currentBranchId()
            );

        } elseif ($request->filled('branch')) {

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

            'products' =>

                (clone $stockQuery)
                    ->count(),


            'available' =>

                (clone $stockQuery)
                    ->where(
                        'quantity',
                        '>',
                        0
                    )
                    ->count(),


            'low' =>

                (clone $stockQuery)
                    ->whereColumn(
                        'quantity',
                        '<=',
                        'reorder_level'
                    )
                    ->where(
                        'quantity',
                        '>',
                        0
                    )
                    ->count(),


            'out' =>

                (clone $stockQuery)
                    ->where(
                        'quantity',
                        '<=',
                        0
                    )
                    ->count(),

        ];

        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */

        $categories = ProductCategory::query()

            ->where(
                'company_id',
                companyId()
            )

            ->orderBy(
                'name'
            )

            ->get();


        if (canManageAllBranches()) {

            $branches = Branch::query()

                ->where(
                    'company_id',
                    companyId()
                )

                ->where(
                    'status',
                    true
                )

                ->orderBy(
                    'name'
                )

                ->get();

        } else {

            $branches = Branch::query()

                ->where(
                    'company_id',
                    companyId()
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


        return view(

            'stock.index',

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
    | Stock Table
    |--------------------------------------------------------------------------
    */

    public function table(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('stock.view')) {

            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to view stock.'
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

        } elseif ($request->filled('branch')) {

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

            $search = $request->search;

            $stocks->whereHas(
                'product',
                function ($query) use ($search) {

                    $query->where(
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
        | Stock Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            switch ($request->status) {

                case 'low':

                    $stocks

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

                    break;


                case 'out':

                    $stocks->where(
                        'quantity',
                        '<=',
                        0
                    );

                    break;

            }

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
        | Render Table
        |--------------------------------------------------------------------------
        */

        $html = view(
            'stock.partials.table',
            compact('stocks')
        )->render();


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'html' => $html,

            'pagination' => '',

            'stats' => [

                'total' => $stocks->total(),

            ],

        ]);
    }
    

    public function products(Request $request)
    {
        if (! canAccess('stock.view')) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to view stock products.'
            ], 403);
        }
        /*
        |--------------------------------------------------------------------------
        | Determine Branch Scope
        |--------------------------------------------------------------------------
        */

        $branchId = null;

        if (!canManageAllBranches()) {

            $branchId = currentBranchId();

        } elseif ($request->filled('branch')) {

            $branchId = (int) $request->branch;

        }


        /*
        |--------------------------------------------------------------------------
        | Branch Assignment Validation
        |--------------------------------------------------------------------------
        */

        if (!canManageAllBranches() && !$branchId) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Your account is not assigned to a branch.'

            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Validate Selected Branch
        |--------------------------------------------------------------------------
        */

        if (
            canManageAllBranches() &&
            $branchId
        ) {

            $branchExists = Branch::query()

                ->where(
                    'company_id',
                    companyId()
                )

                ->where(
                    'id',
                    $branchId
                )

                ->where(
                    'status',
                    true
                )

                ->exists();


            if (!$branchExists) {

                return response()->json([

                    'success' => false,

                    'message' =>
                        'Invalid branch selected.'

                ], 422);

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Base Product Query
        |--------------------------------------------------------------------------
        */

        $query = Product::query()

            ->where(
                'company_id',
                companyId()
            )

            ->with([

                'category',

                'unit',

                /*
                |--------------------------------------------------------------------------
                | Load Branch Stock
                |--------------------------------------------------------------------------
                */

                'stocks' => function ($stock) use ($branchId) {

                    if ($branchId !== null) {

                        $stock->where(
                            'branch_id',
                            $branchId
                        );

                    }

                    $stock->with('branch');

                },

            ]);


        /*
        |--------------------------------------------------------------------------
        | Branch Stock Scope
        |--------------------------------------------------------------------------
        |
        | When a branch is selected, only products having a stock
        | record for that branch are returned.
        |
        */

        if ($branchId !== null) {

            $query->whereHas(

                'stocks',

                function ($stock) use ($branchId) {

                    $stock->where(
                        'branch_id',
                        $branchId
                    );

                }

            );

        }


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
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
                );

            });

        }


        /*
        |--------------------------------------------------------------------------
        | Category
        |--------------------------------------------------------------------------
        */

        if ($request->filled('category')) {

            $query->where(
                'product_category_id',
                $request->category
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Stock Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->whereHas(

                'stocks',

                function ($stock) use (
                    $request,
                    $branchId
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | Branch Scope
                    |--------------------------------------------------------------------------
                    */

                    if ($branchId !== null) {

                        $stock->where(
                            'branch_id',
                            $branchId
                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Stock Status
                    |--------------------------------------------------------------------------
                    */

                    switch ($request->status) {

                        case 'in_stock':

                            $stock->where(
                                'quantity',
                                '>',
                                0
                            );

                            break;


                        case 'low_stock':

                            $stock

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

                            break;


                        case 'out_stock':

                            $stock->where(
                                'quantity',
                                '<=',
                                0
                            );

                            break;

                    }

                }

            );

        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $products = $query

            ->latest()

            ->paginate(5);


        /*
        |--------------------------------------------------------------------------
        | Normalize Product Stock Data
        |--------------------------------------------------------------------------
        |
        | Instead of making JavaScript guess which stock belongs to
        | the selected branch, expose a dedicated stock object.
        |
        */  
        // if ($branchId !== null) {

        //     $debugStock = ProductStock::query()
        //         ->where('company_id', companyId())
        //         ->where('branch_id', $branchId)
        //         ->where('product_id', 1)
        //         ->first();

        //     \Log::info('STOCK DEBUG', [
        //         'branch_id' => $branchId,
        //         'product_id' => 1,
        //         'stock' => $debugStock?->toArray(),
        //     ]);

        // }      

        $data = collect($products->items())

            ->map(function ($product) use ($branchId) {

                /*
                |--------------------------------------------------------------------------
                | Resolve Exact Branch Stock
                |--------------------------------------------------------------------------
                */

                $stock = null;

                if ($branchId !== null) {

                    $stock = $product->stocks
                        ->where(
                            'branch_id',
                            $branchId
                        )
                        ->first();

                }


                /*
                |--------------------------------------------------------------------------
                | Return Product
                |--------------------------------------------------------------------------
                */

                return [

                    'id' =>
                        $product->id,

                    'product_code' =>
                        $product->product_code,

                    'sku' =>
                        $product->sku,

                    'barcode' =>
                        $product->barcode,

                    'name' =>
                        $product->name,

                    'image' =>
                        $product->image,

                    'selling_price' =>
                        $product->selling_price,

                    'category' =>
                        $product->category,

                    'unit' =>
                        $product->unit,


                    /*
                    |--------------------------------------------------------------------------
                    | Branch
                    |--------------------------------------------------------------------------
                    */

                    'branch_id' =>
                        $stock
                            ? (int) $stock->branch_id
                            : null,

                    'branch' =>
                        $stock?->branch,


                    /*
                    |--------------------------------------------------------------------------
                    | Stock
                    |--------------------------------------------------------------------------
                    */

                    'stock' => $stock
                        ? [

                            'id' =>
                                $stock->id,

                            'company_id' =>
                                $stock->company_id,

                            'branch_id' =>
                                $stock->branch_id,

                            'product_id' =>
                                $stock->product_id,

                            'quantity' =>
                                $stock->quantity,

                            'reserved_quantity' =>
                                $stock->reserved_quantity,

                            'available_quantity' =>
                                $stock->available_quantity,

                            'reorder_level' =>
                                $stock->reorder_level,

                            'maximum_stock' =>
                                $stock->maximum_stock,

                        ]
                        : null,


                    /*
                    |--------------------------------------------------------------------------
                    | Direct Quantity
                    |--------------------------------------------------------------------------
                    |
                    | This makes the current stock immediately available to
                    | the frontend without requiring JavaScript to traverse
                    | relationships.
                    |
                    */

                    'stock_quantity' =>
                        $stock?->quantity ?? 0,

                    'reserved_quantity' =>
                        $stock?->reserved_quantity ?? 0,

                    'available_quantity' =>
                        $stock?->available_quantity ?? 0,

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

            'data' => $data,

            'pagination' => [

                'current_page' =>
                    $products->currentPage(),

                'last_page' =>
                    $products->lastPage(),

                'total' =>
                    $products->total(),

            ],

        ]);
    }

   /*
    |--------------------------------------------------------------------------
    | Stock Details
    |--------------------------------------------------------------------------
    */

    public function details($id)
    {
        if (! canAccess('stock.view')) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to view stock details.'
            ], 403);
        }
        
        $stockQuery = ProductStock::query()

            ->where(
                'company_id',
                $this->companyId
            )

            ->with([

                'product.category',

                'branch',

            ]);


        /*
        |--------------------------------------------------------------------------
        | Branch Access
        |--------------------------------------------------------------------------
        */

        if (!canManageAllBranches()) {

            $stockQuery->where(
                'branch_id',
                currentBranchId()
            );

        }


        $stock = $stockQuery->findOrFail($id);


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


        return response()->json([

            'success' => true,

            'data' => [

                'id' => $stock->id,

                'product' => [

                    'name' =>
                        $stock->product->name,

                    'sku' =>
                        $stock->product->sku,

                    'barcode' =>
                        $stock->product->barcode,

                    'image' =>
                        $stock->product->image,

                    'category' => [

                        'name' =>
                            $stock->product->category->name ?? '-',

                    ],

                    'unit' => [

                        'name' =>
                            $stock->product->unit->name ?? '-',

                    ],

                ],

                'branch' => [

                    'name' =>
                        $stock->branch->name ?? '-',

                ],

                'quantity' =>
                    $stock->quantity,

                'reserved_quantity' =>
                    $stock->reserved_quantity,

                'available_quantity' =>
                    $stock->available_quantity,

                'reorder_level' =>
                    $stock->reorder_level,

                'movements' =>

                    $movements->map(function ($movement) {

                        return [

                            'movement_type' =>
                                $movement->movement_type,

                            'quantity' =>
                                $movement->quantity,

                            'stock_before' =>
                                $movement->stock_before,

                            'stock_after' =>
                                $movement->stock_after,

                            'user' => [

                                'name' =>
                                    $movement->user->name ?? 'System',

                            ],

                        ];

                    }),

            ],

        ]);
    }    
   
   
    /**
     * Adjustment Filters
     */
    public function adjustmentFilters()
    {
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

            ->where(
                'status',
                true
            )

            ->orderBy(
                'name'
            )

            ->get([
                'id',
                'name'
            ]);


        /*
        |--------------------------------------------------------------------------
        | Branches
        |--------------------------------------------------------------------------
        |
        | Owner / Administrator:
        | Can select any active company branch.
        |
        | Branch-level users:
        | Branch selection is not required because the backend
        | automatically uses currentBranchId().
        |
        */

        $branches = collect();


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

                ->get([
                    'id',
                    'name'
                ]);

        }


        return response()->json([

            'success' => true,

            'categories' => $categories,

            'branches' => $branches,

            'can_manage_all_branches' =>
                canManageAllBranches(),

            'current_branch_id' =>
                currentBranchId(),

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Store Stock Adjustment
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        if (! canAccess('stock.update')) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to adjust stock.'
            ], 403);
        }

        $validated = $request->validate([

            'product_id' => [

                'required',

                'integer',

            ],

            'branch_id' => [

                'nullable',

                'integer',

            ],

            'type' => [

                'required',

                'string',

                'max:50',

            ],

            'quantity' => [

                'required',

                'numeric',

                'min:0.01',

            ],

            'reason' => [

                'nullable',

                'string',

                'max:255',

            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Determine Branch
        |--------------------------------------------------------------------------
        |
        | Owner / Administrator:
        | Use the submitted branch.
        |
        | Branch-level users:
        | Completely ignore submitted branch_id and force
        | the authenticated user's assigned branch.
        |
        */

        if (canManageAllBranches()) {

            if (empty($validated['branch_id'])) {

                return response()->json([

                    'success' => false,

                    'message' =>
                        'Please select a branch.'

                ], 422);

            }


            $branchId =
                $validated['branch_id'];

        }
        else {

            $branchId =
                currentBranchId();


            if (!$branchId) {

                return response()->json([

                    'success' => false,

                    'message' =>
                        'Your account is not assigned to a branch.'

                ], 422);

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Verify Branch Belongs To Company
        |--------------------------------------------------------------------------
        */

        $branchExists = Branch::query()

            ->where(
                'company_id',
                companyId()
            )

            ->where(
                'id',
                $branchId
            )

            ->where(
                'status',
                true
            )

            ->exists();


        if (!$branchExists) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Invalid branch selected.'

            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Verify Product Belongs To Company
        |--------------------------------------------------------------------------
        */

        $productExists = Product::query()

            ->where(
                'company_id',
                companyId()
            )

            ->where(
                'id',
                $validated['product_id']
            )

            ->exists();


        if (!$productExists) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Invalid product selected.'

            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Transaction
        |--------------------------------------------------------------------------
        */

        return DB::transaction(function () use (
            $validated,
            $branchId
        ) {

            /*
            |--------------------------------------------------------------------------
            | Get Stock Record
            |--------------------------------------------------------------------------
            */

            $stock = ProductStock::query()

                ->where(
                    'company_id',
                    companyId()
                )

                ->where(
                    'branch_id',
                    $branchId
                )

                ->where(
                    'product_id',
                    $validated['product_id']
                )

                ->first();


            /*
            |--------------------------------------------------------------------------
            | Create Stock Record If It Does Not Exist
            |--------------------------------------------------------------------------
            */

            if (!$stock) {

                $stock = ProductStock::create([

                    'company_id' =>
                        companyId(),

                    'branch_id' =>
                        $branchId,

                    'product_id' =>
                        $validated['product_id'],

                    'quantity' =>
                        0,

                    'reserved_quantity' =>
                        0,

                    'available_quantity' =>
                        0,

                    'reorder_level' =>
                        0,

                ]);

            }


            /*
            |--------------------------------------------------------------------------
            | Capture Old Quantity
            |--------------------------------------------------------------------------
            */

            $oldQuantity =
                $stock->quantity;


            /*
            |--------------------------------------------------------------------------
            | Determine Adjustment Direction
            |--------------------------------------------------------------------------
            */

            $increaseTypes = [

                'Opening Stock',

                'Adjustment In',

                'Purchase',

                'Customer Return',

                'Transfer In',

            ];


            if (
                in_array(
                    $validated['type'],
                    $increaseTypes,
                    true
                )
            ) {

                $newQuantity =
                    $oldQuantity
                    +
                    $validated['quantity'];

            }
            else {

                $newQuantity =
                    $oldQuantity
                    -
                    $validated['quantity'];

            }


            /*
            |--------------------------------------------------------------------------
            | Prevent Negative Stock
            |--------------------------------------------------------------------------
            */

            if ($newQuantity < 0) {

                return response()->json([

                    'success' => false,

                    'message' =>
                        'Insufficient stock quantity.'

                ], 422);

            }


            /*
            |--------------------------------------------------------------------------
            | Update Stock
            |--------------------------------------------------------------------------
            */

            $stock->update([

                'quantity' =>
                    $newQuantity,

                'available_quantity' =>
                    $newQuantity
                    -
                    $stock->reserved_quantity,

                'last_stock_update' =>
                    now(),

            ]);


            /*
            |--------------------------------------------------------------------------
            | Create Stock Movement
            |--------------------------------------------------------------------------
            */

            StockMovement::create([

                'company_id' =>
                    companyId(),

                'branch_id' =>
                    $branchId,

                'product_id' =>
                    $validated['product_id'],

                'user_id' =>
                    auth()->id(),

                'movement_type' =>
                    $validated['type'],

                'quantity' =>
                    $validated['quantity'],

                'stock_before' =>
                    $oldQuantity,

                'balance_after' =>
                    $newQuantity,

                'remarks' =>
                    $validated['reason'] ?? null,

            ]);


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'Stock',

                'Updated',

                'Stock adjusted for product ID '
                    . $validated['product_id']
                    . ' at branch ID '
                    . $branchId,

                $stock,

                [

                    'quantity' =>
                        $oldQuantity

                ],

                [

                    'quantity' =>
                        $newQuantity

                ]

            );


            return response()->json([

                'success' => true,

                'message' =>
                    'Stock adjusted successfully.'

            ]);

        });
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Adjustment
    |--------------------------------------------------------------------------
    */

    public function edit(
        int $id
    )
    {

        //

    }



    /*
    |--------------------------------------------------------------------------
    | Update Adjustment
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        int $id
    )
    {

        //

    }



    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function destroy(
        int $id
    )
    {

        //

    }



    /*
    |--------------------------------------------------------------------------
    | Query Builder
    |--------------------------------------------------------------------------
    */

    private function stockQuery( ?Request $request = null)
    {

        return ProductStock::query()

            ->where(
                'company_id',
                $this->companyId
            )


            ->with([

                'product.category',

                'product.unit',

                'branch'

            ])


            ->when(
                $request?->search,
                function($query) use ($request){

                    $query->whereHas(
                        'product',
                        function($q) use ($request){

                            $q->where(
                                'name',
                                'like',
                                "%{$request->search}%"
                            )

                            ->orWhere(
                                'sku',
                                'like',
                                "%{$request->search}%"
                            )

                            ->orWhere(
                                'barcode',
                                'like',
                                "%{$request->search}%"
                            );

                        }
                    );

                }
            )


            ->when(
                $request?->branch,
                function($query) use ($request){

                    $query->where(
                        'branch_id',
                        $request->branch
                    );

                }
            )


            ->when(
                $request?->status,
                function($query) use ($request){


                    if(
                        $request->status === 'low_stock'
                    ){

                        $query->lowStock();

                    }


                    if(
                        $request->status === 'out_stock'
                    ){

                        $query->outOfStock();

                    }


                    if(
                        $request->status === 'in_stock'
                    ){

                        $query->whereColumn(
                            'quantity',
                            '>',
                            'reorder_level'
                        );

                    }


                }
            );


    }


}