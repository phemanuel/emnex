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
        /**
         * |--------------------------------------------------------------------------
         * | Base Stock Query
         * |--------------------------------------------------------------------------
         */

        $stockQuery =
            ProductStock::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->whereHas(
                    'product',
                    function ($query) {

                        $query->where(
                            function ($productQuery) {

                                $productQuery
                                    ->where(
                                        'track_stock',
                                        true
                                    )
                                    ->orWhereNull(
                                        'track_stock'
                                    );

                            }
                        );

                    }
                );


        /**
         * |--------------------------------------------------------------------------
         * | Branch Access
         * |--------------------------------------------------------------------------
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


        /**
         * |--------------------------------------------------------------------------
         * | Statistics
         * |--------------------------------------------------------------------------
         */

        $stats = [

            'products' =>
                (clone $stockQuery)
                    ->distinct()
                    ->count(
                        'product_id'
                    ),

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


        /**
         * |--------------------------------------------------------------------------
         * | Filters
         * |--------------------------------------------------------------------------
         */

        $categories =
            ProductCategory::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->orderBy(
                    'name'
                )

                ->get();


        if (canManageAllBranches()) {

            $branches =
                Branch::query()

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

        } else {

            $branches =
                Branch::query()

                    ->where(
                        'company_id',
                        $this->companyId
                    )

                    ->whereKey(
                        currentBranchId()
                    )

                    ->get();

        }


        /**
         * |--------------------------------------------------------------------------
         * | Business Profile
         * |--------------------------------------------------------------------------
         */

        $showUnit =
            app(
                \App\Services\BusinessProfileService::class
            )
                ->productFieldVisible(
                    $this->company,
                    'unit_id'
                );


        /**
         * |--------------------------------------------------------------------------
         * | Relationships
         * |--------------------------------------------------------------------------
         */

        $relationships = [
            'product.category',
            'branch',
        ];


        if ($showUnit) {

            $relationships[] =
                'product.unit';

        }


        /**
         * |--------------------------------------------------------------------------
         * | Initial Table Data
         * |--------------------------------------------------------------------------
         */

        $stocks =
            (clone $stockQuery)

                ->with(
                    $relationships
                )

                ->latest()

                ->paginate(15);


        return view(
            'stock.index',
            compact(
                'stats',
                'categories',
                'branches',
                'stocks',
                'showUnit'
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
        /**
         * |--------------------------------------------------------------------------
         * | Permission
         * |--------------------------------------------------------------------------
         */

        if (!canAccess('inventory.view')) {

            return response()->json([
                'success' => false,
                'message' =>
                    'You do not have permission to view stock.',
            ], 403);

        }


        /**
         * |--------------------------------------------------------------------------
         * | Base Query
         * |--------------------------------------------------------------------------
         */

        $stocks =
            ProductStock::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->whereHas(
                    'product',
                    function ($query) {

                        $query->where(
                            function ($productQuery) {

                                $productQuery
                                    ->where(
                                        'track_stock',
                                        true
                                    )
                                    ->orWhereNull(
                                        'track_stock'
                                    );

                            }
                        );

                    }
                )

                ->with([
                    'product.category',
                    'branch',
                ]);


        /**
         * |--------------------------------------------------------------------------
         * | Branch Access
         * |--------------------------------------------------------------------------
         */

        if (!canManageAllBranches()) {

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


        /**
         * |--------------------------------------------------------------------------
         * | Search
         * |--------------------------------------------------------------------------
         */

        if ($request->filled('search')) {

            $search =
                $request->search;

            $stocks->whereHas(
                'product',
                function ($query) use ($search) {

                    $query->where(
                        function ($productQuery) use ($search) {

                            $productQuery
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
                                );

                        }
                    );

                }
            );

        }


        /**
         * |--------------------------------------------------------------------------
         * | Category Filter
         * |--------------------------------------------------------------------------
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


        /**
         * |--------------------------------------------------------------------------
         * | Stock Status
         * |--------------------------------------------------------------------------
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


        /**
         * |--------------------------------------------------------------------------
         * | Pagination
         * |--------------------------------------------------------------------------
         */

        $stocks =
            $stocks

                ->latest()

                ->paginate(15)

                ->withQueryString();


        /**
         * |--------------------------------------------------------------------------
         * | Render Table
         * |--------------------------------------------------------------------------
         */

        $html =
            view(
                'stock.partials.table',
                compact(
                    'stocks'
                )
            )
                ->render();


        return response()->json([
            'success' => true,

            'html' =>
                $html,

            'pagination' =>
                '',

            'stats' => [
                'total' =>
                    $stocks->total(),
            ],
        ]);
    }

    public function products(Request $request)
    {
        /**
         * |--------------------------------------------------------------------------
         * | Permission
         * |--------------------------------------------------------------------------
         */

        if (!canAccess('inventory.adjust_stock')) {

            return response()->json([
                'success' => false,
                'message' =>
                    'You do not have permission to adjust stock.',
            ], 403);

        }


        /**
         * |--------------------------------------------------------------------------
         * | Determine Branch Scope
         * |--------------------------------------------------------------------------
         */

        $branchId =
            null;


        if (!canManageAllBranches()) {

            $branchId =
                currentBranchId();

        } elseif ($request->filled('branch')) {

            $branchId =
                (int) $request->branch;

        }


        /**
         * |--------------------------------------------------------------------------
         * | Branch Assignment Validation
         * |--------------------------------------------------------------------------
         */

        if (
            !canManageAllBranches() &&
            !$branchId
        ) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Your account is not assigned to a branch.',
            ], 422);

        }


        /**
         * |--------------------------------------------------------------------------
         * | Validate Selected Branch
         * |--------------------------------------------------------------------------
         */

        if (
            canManageAllBranches() &&
            $branchId
        ) {

            $branchExists =
                Branch::query()

                    ->where(
                        'company_id',
                        $this->companyId
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
                        'Invalid branch selected.',
                ], 422);

            }

        }


        /**
         * |--------------------------------------------------------------------------
         * | Business Profile
         * |--------------------------------------------------------------------------
         */

        $showUnit =
            app(
                \App\Services\BusinessProfileService::class
            )
                ->productFieldVisible(
                    $this->company,
                    'unit_id'
                );


        /**
         * |--------------------------------------------------------------------------
         * | Relationships
         * |--------------------------------------------------------------------------
         */

        $relationships = [

            'category',

            'stocks' =>
                function ($stock) use ($branchId) {

                    if ($branchId !== null) {

                        $stock->where(
                            'branch_id',
                            $branchId
                        );

                    }

                    $stock->with(
                        'branch'
                    );

                },

        ];


        if ($showUnit) {

            $relationships[] =
                'unit';

        }


        /**
         * |--------------------------------------------------------------------------
         * | Base Product Query
         * |--------------------------------------------------------------------------
         */

        $query =
            Product::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    function ($productQuery) {

                        $productQuery
                            ->where(
                                'track_stock',
                                true
                            )
                            ->orWhereNull(
                                'track_stock'
                            );

                    }
                )

                ->with(
                    $relationships
                );


        /**
         * |--------------------------------------------------------------------------
         * | Branch Stock Scope
         * |--------------------------------------------------------------------------
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


        /**
         * |--------------------------------------------------------------------------
         * | Search
         * |--------------------------------------------------------------------------
         */

        if ($request->filled('search')) {

            $search =
                $request->search;

            $query->where(
                function ($q) use ($search) {

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

                }
            );

        }


        /**
         * |--------------------------------------------------------------------------
         * | Category
         * |--------------------------------------------------------------------------
         */

        if ($request->filled('category')) {

            $query->where(
                'product_category_id',
                $request->category
            );

        }


        /**
         * |--------------------------------------------------------------------------
         * | Stock Status
         * |--------------------------------------------------------------------------
         */

        if ($request->filled('status')) {

            $query->whereHas(
                'stocks',
                function ($stock) use (
                    $request,
                    $branchId
                ) {

                    if ($branchId !== null) {

                        $stock->where(
                            'branch_id',
                            $branchId
                        );

                    }


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


        /**
         * |--------------------------------------------------------------------------
         * | Pagination
         * |--------------------------------------------------------------------------
         */

        $products =
            $query

                ->latest()

                ->paginate(5);


        /**
         * |--------------------------------------------------------------------------
         * | Normalize Product Stock Data
         * |--------------------------------------------------------------------------
         */

        $data =
            collect(
                $products->items()
            )

                ->map(
                    function ($product) use (
                        $branchId,
                        $showUnit
                    ) {

                        $stock =
                            null;


                        if ($branchId !== null) {

                            $stock =
                                $product
                                    ->stocks

                                    ->where(
                                        'branch_id',
                                        $branchId
                                    )

                                    ->first();

                        }


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

                            'show_unit' =>
                                $showUnit,

                            'unit' =>
                                $showUnit
                                    ? $product->unit
                                    : null,


                            'branch_id' =>
                                $stock
                                    ? (int) $stock->branch_id
                                    : null,

                            'branch' =>
                                $stock?->branch,


                            'stock' =>
                                $stock
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


                            'stock_quantity' =>
                                $stock?->quantity
                                ?? 0,

                            'reserved_quantity' =>
                                $stock?->reserved_quantity
                                ?? 0,

                            'available_quantity' =>
                                $stock?->available_quantity
                                ?? 0,

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

                'total' =>
                    $products->total(),

            ],
        ]);
    }
   /**
     * |--------------------------------------------------------------------------
     * | Stock Details
     * |--------------------------------------------------------------------------
     */
    public function details($id)
    {
        /**
         * |--------------------------------------------------------------------------
         * | Permission
         * |--------------------------------------------------------------------------
         */

        if (!canAccess('inventory.view')) {

            return response()->json([
                'success' => false,
                'message' =>
                    'You do not have permission to view stock details.',
            ], 403);

        }


        /**
         * |--------------------------------------------------------------------------
         * | Business Profile
         * |--------------------------------------------------------------------------
         */

        $showUnit =
            app(
                \App\Services\BusinessProfileService::class
            )
                ->productFieldVisible(
                    $this->company,
                    'unit_id'
                );


        /**
         * |--------------------------------------------------------------------------
         * | Relationships
         * |--------------------------------------------------------------------------
         */

        $relationships = [
            'product.category',
            'branch',
        ];


        if ($showUnit) {

            $relationships[] =
                'product.unit';

        }


        /**
         * |--------------------------------------------------------------------------
         * | Stock Query
         * |--------------------------------------------------------------------------
         */

        $stockQuery =
            ProductStock::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->whereHas(
                    'product',
                    function ($query) {

                        $query->where(
                            function ($productQuery) {

                                $productQuery
                                    ->where(
                                        'track_stock',
                                        true
                                    )
                                    ->orWhereNull(
                                        'track_stock'
                                    );

                            }
                        );

                    }
                )

                ->with(
                    $relationships
                );


        /**
         * |--------------------------------------------------------------------------
         * | Branch Access
         * |--------------------------------------------------------------------------
         */

        if (!canManageAllBranches()) {

            $stockQuery->where(
                'branch_id',
                currentBranchId()
            );

        }


        /**
         * |--------------------------------------------------------------------------
         * | Stock Record
         * |--------------------------------------------------------------------------
         */

        $stock =
            $stockQuery
                ->findOrFail(
                    $id
                );


        /**
         * |--------------------------------------------------------------------------
         * | Stock Movements
         * |--------------------------------------------------------------------------
         */

        $movements =
            StockMovement::query()

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
                    'user',
                ])

                ->latest()

                ->limit(10)

                ->get();


        /**
         * |--------------------------------------------------------------------------
         * | Response
         * |--------------------------------------------------------------------------
         */

        return response()->json([

            'success' =>
                true,

            'data' => [

                'id' =>
                    $stock->id,


                'product' => [

                    'name' =>
                        $stock->product?->name
                        ?? '-',

                    'selling_price' =>
                        $stock->product?->selling_price
                        ?? 0,

                    'sku' =>
                        $stock->product?->sku,

                    'barcode' =>
                        $stock->product?->barcode,

                    'image' =>
                        $stock->product?->image,

                    'category' => [

                        'name' =>
                            $stock
                                ->product
                                ?->category
                                ?->name
                            ?? '-',

                    ],

                    'show_unit' =>
                        $showUnit,

                    'unit' =>
                        $showUnit
                            ? [
                                'name' =>
                                    $stock
                                        ->product
                                        ?->unit
                                        ?->name
                                    ?? '-',
                            ]
                            : null,

                ],


                'branch' => [

                    'name' =>
                        $stock->branch?->name
                        ?? '-',

                ],


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


                'movements' =>
                    $movements->map(
                        function ($movement) {

                            return [

                                'movement_type' =>
                                    $movement->movement_type,

                                'quantity' =>
                                    $movement->quantity,

                                'stock_before' =>
                                    $movement->stock_before,

                                'stock_after' =>
                                    $movement->balance_after,

                                'user' => [

                                    'name' =>
                                        $movement
                                            ->user
                                            ?->name
                                        ?? 'System',

                                ],

                            ];

                        }
                    ),

            ],

        ]);
    }
   
    /**
     * Adjustment Filters
     */
    public function adjustmentFilters()
    {
        /**
         * |--------------------------------------------------------------------------
         * | Permission
         * |--------------------------------------------------------------------------
         */

        if (!canAccess('inventory.adjust_stock')) {

            return response()->json([
                'success' => false,
                'message' =>
                    'You do not have permission to adjust stock.',
            ], 403);

        }


        /**
         * |--------------------------------------------------------------------------
         * | Categories
         * |--------------------------------------------------------------------------
         */

        $categories =
            ProductCategory::query()

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
                    'name',
                ]);


        /**
         * |--------------------------------------------------------------------------
         * | Branches
         * |--------------------------------------------------------------------------
         */

        $branches =
            collect();


        if (canManageAllBranches()) {

            $branches =
                Branch::query()

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
                        'name',
                    ]);

        }


        return response()->json([
            'success' =>
                true,

            'categories' =>
                $categories,

            'branches' =>
                $branches,

            'can_manage_all_branches' =>
                canManageAllBranches(),

            'current_branch_id' =>
                currentBranchId(),
        ]);
    }
   
    /**
     * |--------------------------------------------------------------------------
     * | Store Stock Adjustment
     * |--------------------------------------------------------------------------
     */
    public function store(Request $request)
    {
        /**
         * |--------------------------------------------------------------------------
         * | Permission
         * |--------------------------------------------------------------------------
         */

        if (!canAccess('inventory.adjust_stock')) {

            return response()->json([
                'success' => false,
                'message' =>
                    'You do not have permission to adjust stock.',
            ], 403);

        }


        /**
         * |--------------------------------------------------------------------------
         * | Validation
         * |--------------------------------------------------------------------------
         */

        $validated =
            $request->validate([

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

                    \Illuminate\Validation\Rule::in([
                        'Adjustment In',
                        'Adjustment Out',
                        'Damage',
                        'Expired',
                    ]),
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


        /**
         * |--------------------------------------------------------------------------
         * | Determine Branch
         * |--------------------------------------------------------------------------
         */

        if (canManageAllBranches()) {

            if (empty($validated['branch_id'])) {

                return response()->json([
                    'success' => false,
                    'message' =>
                        'Please select a branch.',
                ], 422);

            }


            $branchId =
                (int) $validated['branch_id'];

        } else {

            $branchId =
                currentBranchId();


            if (!$branchId) {

                return response()->json([
                    'success' => false,
                    'message' =>
                        'Your account is not assigned to a branch.',
                ], 422);

            }

        }


        /**
         * |--------------------------------------------------------------------------
         * | Verify Branch Belongs To Company
         * |--------------------------------------------------------------------------
         */

        $branchExists =
            Branch::query()

                ->where(
                    'company_id',
                    $this->companyId
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
                    'Invalid branch selected.',
            ], 422);

        }


        /**
         * |--------------------------------------------------------------------------
         * | Get Product
         * |--------------------------------------------------------------------------
         */

        $product =
            Product::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'id',
                    $validated['product_id']
                )

                ->first();


        if (!$product) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Invalid product selected.',
            ], 422);

        }


        /**
         * |--------------------------------------------------------------------------
         * | Stock Tracking Validation
         * |--------------------------------------------------------------------------
         */

        if (!$product->tracksStock()) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Stock cannot be adjusted for a product that does not track inventory.',
            ], 422);

        }


        /**
         * |--------------------------------------------------------------------------
         * | Historical Unit Cost
         * |--------------------------------------------------------------------------
         */

        $unitCost =
            (float) (
                $product->cost_price
                ?? 0
            );


        /**
         * |--------------------------------------------------------------------------
         * | Transaction
         * |--------------------------------------------------------------------------
         */

        return DB::transaction(
            function () use (
                $validated,
                $branchId,
                $unitCost
            ) {

                /**
                 * |--------------------------------------------------------------------------
                 * | Get Stock Record
                 * |--------------------------------------------------------------------------
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
                            $validated['product_id']
                        )

                        ->lockForUpdate()

                        ->first();


                /**
                 * |--------------------------------------------------------------------------
                 * | Stock Record Must Already Exist
                 * |--------------------------------------------------------------------------
                 */

                if (!$stock) {

                    return response()->json([
                        'success' => false,
                        'message' =>
                            'No stock record exists for this product at the selected branch.',
                    ], 422);

                }


                /**
                 * |--------------------------------------------------------------------------
                 * | Current Quantity
                 * |--------------------------------------------------------------------------
                 */

                $oldQuantity =
                    (float) $stock->quantity;


                /**
                 * |--------------------------------------------------------------------------
                 * | Determine Adjustment Direction
                 * |--------------------------------------------------------------------------
                 */

                $quantity =
                    (float) $validated['quantity'];


                if (
                    $validated['type']
                    ===
                    'Adjustment In'
                ) {

                    $newQuantity =
                        $oldQuantity
                        +
                        $quantity;

                } else {

                    $newQuantity =
                        $oldQuantity
                        -
                        $quantity;

                }


                /**
                 * |--------------------------------------------------------------------------
                 * | Prevent Negative Stock
                 * |--------------------------------------------------------------------------
                 */

                if ($newQuantity < 0) {

                    return response()->json([
                        'success' => false,
                        'message' =>
                            'Insufficient stock quantity.',
                    ], 422);

                }


                /**
                 * |--------------------------------------------------------------------------
                 * | Protect Reserved Stock
                 * |--------------------------------------------------------------------------
                 */

                $reservedQuantity =
                    (float) (
                        $stock->reserved_quantity
                        ?? 0
                    );


                if (
                    $newQuantity <
                    $reservedQuantity
                ) {

                    return response()->json([
                        'success' => false,
                        'message' =>
                            'This adjustment would reduce stock below the reserved quantity.',
                    ], 422);

                }


                /**
                 * |--------------------------------------------------------------------------
                 * | Available Quantity
                 * |--------------------------------------------------------------------------
                 */

                $availableQuantity =
                    $newQuantity
                    -
                    $reservedQuantity;


                /**
                 * |--------------------------------------------------------------------------
                 * | Update Stock
                 * |--------------------------------------------------------------------------
                 */

                $stock->update([

                    'quantity' =>
                        $newQuantity,

                    'available_quantity' =>
                        $availableQuantity,

                    'last_stock_update' =>
                        now(),

                ]);


                /**
                 * |--------------------------------------------------------------------------
                 * | Create Stock Movement
                 * |--------------------------------------------------------------------------
                 */

                StockMovement::create([

                    'company_id' =>
                        $this->companyId,

                    'branch_id' =>
                        $branchId,

                    'product_id' =>
                        $validated['product_id'],

                    'user_id' =>
                        auth()->id(),

                    'movement_type' =>
                        $validated['type'],

                    'quantity' =>
                        $quantity,

                    'unit_cost' =>
                        $unitCost,

                    'stock_before' =>
                        $oldQuantity,

                    'balance_after' =>
                        $newQuantity,

                    'remarks' =>
                        $validated['reason']
                        ?? null,

                ]);


                /**
                 * |--------------------------------------------------------------------------
                 * | Activity Log
                 * |--------------------------------------------------------------------------
                 */

                $this
                    ->activityLogger
                    ->log(

                        'Stock',

                        'Updated',

                        'Stock adjusted for product ID '
                            . $validated['product_id']
                            . ' at branch ID '
                            . $branchId,

                        $stock,

                        [
                            'quantity' =>
                                $oldQuantity,
                        ],

                        [
                            'quantity' =>
                                $newQuantity,
                        ]

                    );


                return response()->json([
                    'success' =>
                        true,

                    'message' =>
                        'Stock adjusted successfully.',
                ]);

            }
        );
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