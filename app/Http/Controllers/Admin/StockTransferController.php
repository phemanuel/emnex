<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Branch;
use App\Models\ProductCategory;
use App\Models\ProductStock;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\DocumentNumberService;
use App\Services\ActivityLogger;

class StockTransferController extends BaseController
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

    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Head Office
        |--------------------------------------------------------------------------
        */

        $headOffice = Branch::where('company_id', $this->companyId)
            ->where('is_head_office', true)
            ->where('status', 1)
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories = ProductCategory::where('company_id', $this->companyId)
            ->where('status', 1)
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Destination Branches
        |--------------------------------------------------------------------------
        */

        $branches = Branch::where('company_id', $this->companyId)
            ->where('status', 1)
            ->where('id', '!=', $headOffice->id)
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Head Office Stock
        |--------------------------------------------------------------------------
        */

        $stocks = ProductStock::with([
            'product.category',
            'product.unit',
            'branch',
        ])
            ->where('company_id', $this->companyId)
            ->where('branch_id', $headOffice->id)
            ->paginate(15);


        /*
        |--------------------------------------------------------------------------
        | Stock Transfer KPIs
        |--------------------------------------------------------------------------
        */

        $stockQuery = ProductStock::where('company_id', $this->companyId)
            ->where('branch_id', $headOffice->id);


        /*
        | Total transferable products
        */

        $transferProductCount = (clone $stockQuery)
            ->count();


        /*
        | Total available stock
        */

        $transferAvailableStock = (clone $stockQuery)
            ->sum('available_quantity');


        /*
        | Low stock
        |
        | Available quantity is greater than zero
        | but has reached the reorder level.
        */

        $transferLowStock = (clone $stockQuery)
            ->where('available_quantity', '>', 0)
            ->whereColumn('available_quantity', '<=', 'reorder_level')
            ->count();


        /*
        | Out of stock
        */

        $transferOutStock = (clone $stockQuery)
            ->where('available_quantity', '<=', 0)
            ->count();


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view('stock-transfer.index', compact(
            'headOffice',
            'categories',
            'branches',
            'stocks',

            'transferProductCount',
            'transferAvailableStock',
            'transferLowStock',
            'transferOutStock'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Table
    |--------------------------------------------------------------------------
    |
    | AJAX table endpoint.
    |
    */

    public function table(Request $request)
    {
        if (! canAccess('inventory.transfer_stock')) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Head Office
        |--------------------------------------------------------------------------
        */

        $headOffice = Branch::query()

            ->where(
                'company_id',
                $this->companyId
            )

            ->headOffice()

            ->where(
                'status',
                true
            )

            ->first();


        if (! $headOffice) {

            return response()->json([

                'status' => false,

                'message' =>
                    'No Head Office branch has been configured for this company.'

            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Stock Query
        |--------------------------------------------------------------------------
        */

        $stocks = ProductStock::query()

            ->where(
                'company_id',
                $this->companyId
            )

            ->where(
                'branch_id',
                $headOffice->id
            )

            ->with([
                'product.category',
                'product.unit',
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


            $stocks->whereHas(
                'product',
                function ($query) use ($search) {

                    $query->where(function ($query) use ($search) {

                        $query

                            ->where(
                                'name',
                                'like',
                                "%{$search}%"
                            )

                            ->orWhere(
                                'product_code',
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
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Category
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

                case 'in_stock':

                    $stocks->where(
                        'available_quantity',
                        '>',
                        0
                    );

                    break;


                case 'low_stock':

                    $stocks

                        ->where(
                            'available_quantity',
                            '>',
                            0
                        )

                        ->whereColumn(
                            'available_quantity',
                            '<=',
                            'reorder_level'
                        );

                    break;


                case 'out_stock':

                    $stocks->where(
                        'available_quantity',
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

            ->latest('id')

            ->paginate(15)

            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return view(
            'stock-transfer.partials.table',
            compact('stocks')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Details
    |--------------------------------------------------------------------------
    |
    | Loads one Head Office stock record when the user adds a product
    | to the transfer cart.
    |
    */

    public function details(int $stock)
    {
        if (! canAccess('inventory.transfer_stock')) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Head Office
        |--------------------------------------------------------------------------
        */

        $headOffice = Branch::query()

            ->where(
                'company_id',
                $this->companyId
            )

            ->headOffice()

            ->where(
                'status',
                true
            )

            ->first();


        if (! $headOffice) {

            return response()->json([

                'status' => false,

                'message' =>
                    'No Head Office branch has been configured for this company.'

            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Stock
        |--------------------------------------------------------------------------
        */

        $productStock = ProductStock::query()

            ->where(
                'id',
                $stock
            )

            ->where(
                'company_id',
                $this->companyId
            )

            ->where(
                'branch_id',
                $headOffice->id
            )

            ->with([
                'product.category',
                'product.unit',
                'branch',
            ])

            ->first();


        if (! $productStock) {

            return response()->json([

                'status' => false,

                'message' =>
                    'The selected stock record could not be found.'

            ], 404);

        }


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'status' => true,

            'data' => [

                'stock_id' =>
                    $productStock->id,

                'product_id' =>
                    $productStock->product_id,

                'branch_id' =>
                    $productStock->branch_id,

                'product' => [

                    'id' =>
                        $productStock->product->id,

                    'name' =>
                        $productStock->product->name,

                    'product_code' =>
                        $productStock->product->product_code,

                    'sku' =>
                        $productStock->product->sku,

                    'barcode' =>
                        $productStock->product->barcode,

                    'category' =>
                        $productStock->product->category?->name,

                    'unit' =>
                        $productStock->product->unit?->name,

                    'image_url' =>
                        $productStock->product->imageUrl(),

                    'cost_price' =>
                        (float) $productStock->product->cost_price,

                    'selling_price' =>
                        (float) $productStock->product->selling_price,

                ],

                'source_branch' => [

                    'id' =>
                        $headOffice->id,

                    'name' =>
                        $headOffice->name,

                ],

                'quantity' =>
                    (float) $productStock->quantity,

                'reserved_quantity' =>
                    (float) $productStock->reserved_quantity,

                'available_quantity' =>
                    (float) $productStock->available_quantity,

                'reorder_level' =>
                    (float) $productStock->reorder_level,

                'maximum_stock' =>
                    $productStock->maximum_stock !== null
                        ? (float) $productStock->maximum_stock
                        : null,

            ],

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Transfer Multiple Products
    |--------------------------------------------------------------------------
    |
    | Expected request:
    |
    | destination_branch_id
    | items[0][stock_id]
    | items[0][product_id]
    | items[0][quantity]
    |
    | items[1][stock_id]
    | items[1][product_id]
    | items[1][quantity]
    |
    */

    public function transfer(Request $request)
    {
        if (! canAccess('inventory.transfer_stock')) {

            return response()->json([

                'status' => false,

                'message' =>
                    'You do not have permission to transfer stock.'

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'destination_branch_id' => [
                'required',
                'integer',
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

            'items.*.stock_id' => [
                'required',
                'integer',
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

        ]);


        try {

            return DB::transaction(

                function () use ($validated) {

                    /*
                    |--------------------------------------------------------------------------
                    | Find Head Office
                    |--------------------------------------------------------------------------
                    */

                    $headOffice = Branch::query()

                        ->where(
                            'company_id',
                            $this->companyId
                        )

                        ->headOffice()

                        ->where(
                            'status',
                            true
                        )

                        ->lockForUpdate()

                        ->first();


                    if (! $headOffice) {

                        throw new \RuntimeException(
                            'No Head Office branch has been configured for this company.'
                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Destination Branch
                    |--------------------------------------------------------------------------
                    */

                    $destinationBranch = Branch::query()

                        ->where(
                            'company_id',
                            $this->companyId
                        )

                        ->where(
                            'id',
                            $validated['destination_branch_id']
                        )

                        ->where(
                            'status',
                            true
                        )

                        ->first();


                    if (! $destinationBranch) {

                        throw new \RuntimeException(
                            'The selected destination branch is invalid.'
                        );

                    }


                    if (
                        $destinationBranch->id ===
                        $headOffice->id
                    ) {

                        throw new \RuntimeException(
                            'Stock cannot be transferred to the Head Office.'
                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Prevent Duplicate Items
                    |--------------------------------------------------------------------------
                    |
                    | The same stock record should not appear twice in the
                    | transfer cart.
                    |
                    */

                    $items =
                        collect(
                            $validated['items']
                        );


                    $duplicateStockIds =
                        $items

                            ->groupBy(
                                'stock_id'
                            )

                            ->filter(
                                fn ($group) =>
                                    $group->count() > 1
                            );


                    if (
                        $duplicateStockIds->isNotEmpty()
                    ) {

                        throw new \RuntimeException(
                            'A product appears more than once in the transfer list.'
                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Reference Number
                    |--------------------------------------------------------------------------
                    */

                    $referenceNo =
                        $validated['reference_no']
                        ??
                        'TRF-' .
                        now()->format('YmdHis') .
                        '-' .
                        strtoupper(
                            Str::random(6)
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Transfer Results
                    |--------------------------------------------------------------------------
                    */

                    $transferredItems = [];


                    /*
                    |--------------------------------------------------------------------------
                    | Process Every Product
                    |--------------------------------------------------------------------------
                    */

                    foreach (
                        $items as $item
                    ) {

                        $stockId =
                            (int) $item['stock_id'];

                        $productId =
                            (int) $item['product_id'];

                        $quantity =
                            (float) $item['quantity'];


                        /*
                        |--------------------------------------------------------------------------
                        | Find Source Stock
                        |--------------------------------------------------------------------------
                        |
                        | The stock is always required to belong to the
                        | company's Head Office.
                        |
                        */

                        $sourceStock =
                            ProductStock::query()

                                ->where(
                                    'id',
                                    $stockId
                                )

                                ->where(
                                    'company_id',
                                    $this->companyId
                                )

                                ->where(
                                    'branch_id',
                                    $headOffice->id
                                )

                                ->where(
                                    'product_id',
                                    $productId
                                )

                                ->with([
                                    'product',
                                ])

                                ->lockForUpdate()

                                ->first();


                        if (! $sourceStock) {

                            throw new \RuntimeException(

                                'One of the selected stock records ' .
                                'could not be found in Head Office.'

                            );

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Live Available Quantity
                        |--------------------------------------------------------------------------
                        */

                        $available =
                            (float)
                            $sourceStock->available_quantity;


                        /*
                        |--------------------------------------------------------------------------
                        | Quantity Check
                        |--------------------------------------------------------------------------
                        */

                        if ($quantity > $available) {

                            throw new \RuntimeException(

                                'Insufficient stock for ' .
                                $sourceStock->product->name .
                                '. Available stock: ' .
                                number_format(
                                    $available,
                                    2
                                ) .
                                '. Requested: ' .
                                number_format(
                                    $quantity,
                                    2
                                ) .
                                '.'

                            );

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Source Before
                        |--------------------------------------------------------------------------
                        */

                        $sourceBefore =
                            (float)
                            $sourceStock->quantity;


                        /*
                        |--------------------------------------------------------------------------
                        | Destination Stock
                        |--------------------------------------------------------------------------
                        */

                        $destinationStock =
                            ProductStock::query()

                                ->where(
                                    'company_id',
                                    $this->companyId
                                )

                                ->where(
                                    'branch_id',
                                    $destinationBranch->id
                                )

                                ->where(
                                    'product_id',
                                    $productId
                                )

                                ->lockForUpdate()

                                ->first();


                        /*
                        |--------------------------------------------------------------------------
                        | Create Destination Stock
                        |--------------------------------------------------------------------------
                        */

                        if (! $destinationStock) {

                            $destinationStock =
                                new ProductStock();


                            $destinationStock->company_id =
                                $this->companyId;


                            $destinationStock->branch_id =
                                $destinationBranch->id;


                            $destinationStock->product_id =
                                $productId;


                            $destinationStock->quantity =
                                0;


                            $destinationStock->reserved_quantity =
                                0;


                            $destinationStock->available_quantity =
                                0;


                            $destinationStock->reorder_level =
                                $sourceStock->reorder_level;


                            $destinationStock->maximum_stock =
                                $sourceStock->maximum_stock;


                            $destinationStock->save();

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Destination Before
                        |--------------------------------------------------------------------------
                        */

                        $destinationBefore =
                            (float)
                            $destinationStock->quantity;


                        /*
                        |--------------------------------------------------------------------------
                        | Deduct Source Stock
                        |--------------------------------------------------------------------------
                        */

                        $sourceStock->quantity =
                            $sourceBefore -
                            $quantity;


                        $sourceStock->available_quantity =
                            max(
                                0,
                                (float)
                                $sourceStock->quantity -
                                (float)
                                $sourceStock->reserved_quantity
                            );


                        $sourceStock->save();


                        /*
                        |--------------------------------------------------------------------------
                        | Add Destination Stock
                        |--------------------------------------------------------------------------
                        */

                        $destinationStock->quantity =
                            $destinationBefore +
                            $quantity;


                        $destinationStock->available_quantity =
                            max(
                                0,
                                (float)
                                $destinationStock->quantity -
                                (float)
                                $destinationStock->reserved_quantity
                            );


                        $destinationStock->save();


                        /*
                        |--------------------------------------------------------------------------
                        | Product Cost
                        |--------------------------------------------------------------------------
                        */

                        $unitCost =
                            (float)
                            (
                                $sourceStock->product
                                    ?->cost_price
                                ?? 0
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | Source Movement
                        |--------------------------------------------------------------------------
                        */

                        StockMovement::create([

                            'company_id' =>
                                $this->companyId,

                            'branch_id' =>
                                $headOffice->id,

                            'product_id' =>
                                $productId,

                            'movement_type' =>
                                'Transfer Out',

                            'order_id' =>
                                null,

                            'reference_no' =>
                                $referenceNo,

                            'unit_cost' =>
                                $unitCost,

                            'quantity' =>
                                $quantity,

                            'stock_before' =>
                                $sourceBefore,

                            'balance_after' =>
                                (float)
                                $sourceStock->quantity,

                            'remarks' =>
                                $validated['remarks']
                                ?? null,

                            'created_by' =>
                                auth()->id(),

                        ]);


                        /*
                        |--------------------------------------------------------------------------
                        | Destination Movement
                        |--------------------------------------------------------------------------
                        */

                        StockMovement::create([

                            'company_id' =>
                                $this->companyId,

                            'branch_id' =>
                                $destinationBranch->id,

                            'product_id' =>
                                $productId,

                            'movement_type' =>
                                'Transfer In',

                            'order_id' =>
                                null,

                            'reference_no' =>
                                $referenceNo,

                            'unit_cost' =>
                                $unitCost,

                            'quantity' =>
                                $quantity,

                            'stock_before' =>
                                $destinationBefore,

                            'balance_after' =>
                                (float)
                                $destinationStock->quantity,

                            'remarks' =>
                                $validated['remarks']
                                ?? null,

                            'created_by' =>
                                auth()->id(),

                        ]);


                        /*
                        |--------------------------------------------------------------------------
                        | Store Result
                        |--------------------------------------------------------------------------
                        */

                        $transferredItems[] = [

                            'stock_id' =>
                                $sourceStock->id,

                            'product_id' =>
                                $productId,

                            'product_name' =>
                                $sourceStock->product->name,

                            'quantity' =>
                                $quantity,

                            'source_balance' =>
                                (float)
                                $sourceStock->quantity,

                            'destination_balance' =>
                                (float)
                                $destinationStock->quantity,

                        ];

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Activity Log
                    |--------------------------------------------------------------------------
                    */

                    $this->activityLogger->log(

                        'Inventory',

                        'Stock Transferred',

                        'Transferred ' .
                            count($transferredItems) .
                            ' product(s) from ' .
                            $headOffice->name .
                            ' to ' .
                            $destinationBranch->name .
                            '. Reference: ' .
                            $referenceNo,

                        $headOffice,

                        null,

                        [

                            'reference_no' =>
                                $referenceNo,

                            'source_branch_id' =>
                                $headOffice->id,

                            'destination_branch_id' =>
                                $destinationBranch->id,

                            'items' =>
                                $transferredItems,

                        ]

                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Response
                    |--------------------------------------------------------------------------
                    */

                    return response()->json([

                        'status' =>
                            true,

                        'success' =>
                            true,

                        'type' =>
                            'success',

                        'message' =>
                            count($transferredItems) .
                            ' product(s) transferred successfully.',

                        'data' => [

                            'reference_no' =>
                                $referenceNo,

                            'source_branch' => [

                                'id' =>
                                    $headOffice->id,

                                'name' =>
                                    $headOffice->name,

                            ],

                            'destination_branch' => [

                                'id' =>
                                    $destinationBranch->id,

                                'name' =>
                                    $destinationBranch->name,

                            ],

                            'items' =>
                                $transferredItems,

                        ],

                    ]);

                }
            );

        }
        catch (\Throwable $e) {

            \Log::error(

                'Stock transfer failed.',

                [

                    'company_id' =>
                        $this->companyId,

                    'user_id' =>
                        auth()->id(),

                    'error' =>
                        $e->getMessage(),

                ]

            );


            return response()->json([

                'status' =>
                    false,

                'success' =>
                    false,

                'type' =>
                    'danger',

                'message' =>
                    $e->getMessage(),

            ], 422);

        }
    }      



/*
|--------------------------------------------------------------------------
| Stock Movement
|--------------------------------------------------------------------------
*/

public function stockMovement()
{
    /*
    |--------------------------------------------------------------------------
    | Permission
    |--------------------------------------------------------------------------
    */

    if (! canAccess('inventory.transfer_stock')) {

        abort(
            403,
            'You do not have permission to view stock movements.'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Branches
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | Movement Types
    |--------------------------------------------------------------------------
    */

    $movementTypes = StockMovement::query()

        ->where(
            'company_id',
            $this->companyId
        )

        ->whereNotNull(
            'movement_type'
        )

        ->distinct()

        ->orderBy(
            'movement_type'
        )

        ->pluck(
            'movement_type'
        );


    /*
    |--------------------------------------------------------------------------
    | Initial Movement Query
    |--------------------------------------------------------------------------
    */

    $movementQuery = StockMovement::query()

        ->where(
            'company_id',
            $this->companyId
        );


    /*
    |--------------------------------------------------------------------------
    | KPIs
    |--------------------------------------------------------------------------
    */

    $totalMovements = (clone $movementQuery)
        ->count();


    $totalProducts = (clone $movementQuery)

        ->whereNotNull(
            'product_id'
        )

        ->distinct(
            'product_id'
        )

        ->count(
            'product_id'
        );


    $totalQuantity = (clone $movementQuery)
        ->sum('quantity');


    $totalBranches = (clone $movementQuery)

        ->whereNotNull(
            'branch_id'
        )

        ->distinct(
            'branch_id'
        )

        ->count(
            'branch_id'
        );


    /*
    |--------------------------------------------------------------------------
    | Initial Movements
    |--------------------------------------------------------------------------
    */

    $movements = (clone $movementQuery)

        ->with([
            'product:id,name,sku',
            'branch:id,name',
            'createdBy:id,first_name,last_name',
        ])

        ->latest(
            'created_at'
        )

        ->paginate(
            15
        );


    /*
    |--------------------------------------------------------------------------
    | View
    |--------------------------------------------------------------------------
    */

    return view(
        'stock-transfer.movement.index',
        compact(

            'branches',

            'movementTypes',

            'movements',

            'totalMovements',

            'totalProducts',

            'totalQuantity',

            'totalBranches'

        )
    );
}


/*
|--------------------------------------------------------------------------
| Stock Movement Table
|--------------------------------------------------------------------------
*/

public function stockMovementTable(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | Permission
    |--------------------------------------------------------------------------
    */

    if (! canAccess('inventory.transfer_stock')) {

        abort(
            403,
            'You do not have permission to view stock movements.'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Query
    |--------------------------------------------------------------------------
    */

    $query = StockMovement::query()

        ->where(
            'company_id',
            $this->companyId
        )

        ->with([
            'product:id,name,sku',
            'branch:id,name',
            'createdBy:id,first_name,last_name',
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
                $request->input('search')
            );


        $query->where(
            function ($q) use ($search) {

                $q->where(
                    'reference_no',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'movement_type',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhereHas(
                    'product',
                    function ($productQuery) use ($search) {

                        $productQuery->where(
                            'name',
                            'like',
                            '%' . $search . '%'
                        )

                        ->orWhere(
                            'sku',
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
    | Movement Type
    |--------------------------------------------------------------------------
    */

    if (
        $request->filled('movement_type')
    ) {

        $query->where(
            'movement_type',
            $request->input('movement_type')
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
            $request->input('branch_id')
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
                (int) $request->input(
                    'per_page',
                    15
                ),
                1
            ),
            100
        );


    $movements =
        $query

            ->latest(
                'created_at'
            )

            ->paginate(
                $perPage
            );


    /*
    |--------------------------------------------------------------------------
    | KPIs
    |--------------------------------------------------------------------------
    |
    | These are recalculated from the filtered query so the dashboard
    | reflects the currently selected search/filter criteria.
    |
    */

    $filteredQuery = StockMovement::query()

        ->where(
            'company_id',
            $this->companyId
        );


    /*
    |--------------------------------------------------------------------------
    | Apply Search To KPI Query
    |--------------------------------------------------------------------------
    */

    if (
        $request->filled('search')
    ) {

        $search =
            trim(
                $request->input('search')
            );


        $filteredQuery->where(
            function ($q) use ($search) {

                $q->where(
                    'reference_no',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'movement_type',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhereHas(
                    'product',
                    function ($productQuery) use ($search) {

                        $productQuery->where(
                            'name',
                            'like',
                            '%' . $search . '%'
                        )

                        ->orWhere(
                            'sku',
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
    | Apply Movement Type To KPI Query
    |--------------------------------------------------------------------------
    */

    if (
        $request->filled('movement_type')
    ) {

        $filteredQuery->where(
            'movement_type',
            $request->input('movement_type')
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Apply Branch To KPI Query
    |--------------------------------------------------------------------------
    */

    if (
        $request->filled('branch_id')
    ) {

        $filteredQuery->where(
            'branch_id',
            $request->input('branch_id')
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Calculate KPIs
    |--------------------------------------------------------------------------
    */

    $kpis = [

        'total_movements' =>
            (clone $filteredQuery)
                ->count(),

        'total_products' =>
            (clone $filteredQuery)
                ->whereNotNull(
                    'product_id'
                )
                ->distinct(
                    'product_id'
                )
                ->count(
                    'product_id'
                ),

        'total_quantity' =>
            (clone $filteredQuery)
                ->sum(
                    'quantity'
                ),

        'total_branches' =>
            (clone $filteredQuery)
                ->whereNotNull(
                    'branch_id'
                )
                ->distinct(
                    'branch_id'
                )
                ->count(
                    'branch_id'
                ),

    ];


    /*
    |--------------------------------------------------------------------------
    | Transform Rows
    |--------------------------------------------------------------------------
    */

    $data =
        $movements
            ->getCollection()
            ->map(
                function ($movement) {

                    return [

                        'id' =>
                            $movement->id,

                        'reference_no' =>
                            $movement->reference_no,

                        'movement_type' =>
                            $movement->movement_type,

                        'quantity' =>
                            $movement->quantity,

                        'date' =>
                            $movement->created_at,

                        'product' => [

                            'id' =>
                                $movement->product?->id,

                            'name' =>
                                $movement->product?->name,

                            'sku' =>
                                $movement->product?->sku,

                        ],

                        'branch' => [

                            'id' =>
                                $movement->branch?->id,

                            'name' =>
                                $movement->branch?->name,

                        ],

                        'created_by' => [

                            'id' =>
                                $movement->createdBy?->id,

                            'name' =>
                                $movement->createdBy
                                    ? trim(
                                        $movement->createdBy->first_name
                                        . ' '
                                        . $movement->createdBy->last_name
                                    )
                                    : 'System',

                        ],

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

        'status' =>
            true,

        'data' =>
            $data,

        'pagination' => [

            'current_page' =>
                $movements->currentPage(),

            'last_page' =>
                $movements->lastPage(),

            'per_page' =>
                $movements->perPage(),

            'total' =>
                $movements->total(),

        ],

        'kpis' =>
            $kpis,

    ]);

}


/*
|--------------------------------------------------------------------------
| Stock Movement Details
|--------------------------------------------------------------------------
*/
public function stockMovementDetails($id)
{

    /*
    |--------------------------------------------------------------------------
    | Permission
    |--------------------------------------------------------------------------
    */

    if (! canAccess('inventory.transfer_stock')) {

        abort(
            403,
            'You do not have permission to view stock movement details.'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Selected Movement
    |--------------------------------------------------------------------------
    */

    $movement = StockMovement::query()

        ->where(
            'company_id',
            $this->companyId
        )

        ->where(
            'id',
            $id
        )

        ->with([

                'product:id,name,sku,product_category_id,unit_id',

                'product.category:id,name',

                'product.unit:id,name',

                'branch:id,name',

                'createdBy:id,first_name,last_name',

            ])

        ->first();


    /*
    |--------------------------------------------------------------------------
    | Not Found
    |--------------------------------------------------------------------------
    */

    if (! $movement) {

        return response()->json([

            'status' =>
                false,

            'message' =>
                'Stock movement not found.',

        ], 404);

    }


    /*
    |--------------------------------------------------------------------------
    | Created By
    |--------------------------------------------------------------------------
    */

    $creatorName =
        $movement->createdBy

            ? trim(
                $movement->createdBy->first_name
                . ' '
                . $movement->createdBy->last_name
            )

            : 'System';


    /*
    |--------------------------------------------------------------------------
    | Source / Destination Branch
    |--------------------------------------------------------------------------
    |
    | Transfer movements normally exist as a pair:
    |
    | Transfer Out -> source branch
    | Transfer In  -> destination branch
    |
    | Both records share the same reference_no.
    |
    */

    $sourceBranch = null;

    $destinationBranch = null;


    /*
    |--------------------------------------------------------------------------
    | Resolve Transfer Route
    |--------------------------------------------------------------------------
    */

    if (
        $movement->reference_no &&
        in_array(
            $movement->movement_type,
            [
                'Transfer',
                'Transfer In',
                'Transfer Out',
            ],
            true
        )
    ) {

        $transferMovements =
            StockMovement::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'reference_no',
                    $movement->reference_no
                )

                ->whereIn(
                    'movement_type',
                    [
                        'Transfer',
                        'Transfer In',
                        'Transfer Out',
                    ]
                )

                ->with(
                    'branch:id,name'
                )

                ->get();


        /*
        |--------------------------------------------------------------------------
        | Transfer Out = Source
        |--------------------------------------------------------------------------
        */

        $transferOut =
            $transferMovements->first(
                function ($item) {

                    return $item->movement_type ===
                        'Transfer Out';

                }
            );


        /*
        |--------------------------------------------------------------------------
        | Transfer In = Destination
        |--------------------------------------------------------------------------
        */

        $transferIn =
            $transferMovements->first(
                function ($item) {

                    return $item->movement_type ===
                        'Transfer In';

                }
            );


        /*
        |--------------------------------------------------------------------------
        | Source Branch
        |--------------------------------------------------------------------------
        */

        if ($transferOut?->branch) {

            $sourceBranch = [

                'id' =>
                    $transferOut->branch->id,

                'name' =>
                    $transferOut->branch->name,

            ];

        }


        /*
        |--------------------------------------------------------------------------
        | Destination Branch
        |--------------------------------------------------------------------------
        */

        if ($transferIn?->branch) {

            $destinationBranch = [

                'id' =>
                    $transferIn->branch->id,

                'name' =>
                    $transferIn->branch->name,

            ];

        }


        /*
        |--------------------------------------------------------------------------
        | Fallback
        |--------------------------------------------------------------------------
        |
        | If the movement data does not contain explicit
        | Transfer In / Transfer Out records, use the
        | selected movement's branch where appropriate.
        |
        */

        if (
            ! $sourceBranch &&
            $movement->movement_type === 'Transfer Out' &&
            $movement->branch
        ) {

            $sourceBranch = [

                'id' =>
                    $movement->branch->id,

                'name' =>
                    $movement->branch->name,

            ];

        }


        if (
            ! $destinationBranch &&
            $movement->movement_type === 'Transfer In' &&
            $movement->branch
        ) {

            $destinationBranch = [

                'id' =>
                    $movement->branch->id,

                'name' =>
                    $movement->branch->name,

            ];

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Branch
    |--------------------------------------------------------------------------
    |
    | Keep the selected movement's branch as a generic
    | branch value for non-transfer movements.
    |
    */

    $branch = [

        'id' =>
            $movement->branch?->id,

        'name' =>
            $movement->branch?->name
            ?? '-',

    ];


    /*
    |--------------------------------------------------------------------------
    | Details
    |--------------------------------------------------------------------------
    */

    $details = [

        /*
        |--------------------------------------------------------------------------
        | Movement ID
        |--------------------------------------------------------------------------
        */

        'id' =>
            $movement->id,


        /*
        |--------------------------------------------------------------------------
        | Reference
        |--------------------------------------------------------------------------
        */

        'reference_no' =>
            $movement->reference_no
            ?? '-',


        /*
        |--------------------------------------------------------------------------
        | Movement Type
        |--------------------------------------------------------------------------
        */

        'movement_type' =>
            $movement->movement_type
            ?? '-',


        /*
        |--------------------------------------------------------------------------
        | Date
        |--------------------------------------------------------------------------
        */

        'created_at' =>
            $movement->created_at,


        /*
        |--------------------------------------------------------------------------
        | Generic Branch
        |--------------------------------------------------------------------------
        */

        'branch' =>
            $branch,


        /*
        |--------------------------------------------------------------------------
        | Transfer Source
        |--------------------------------------------------------------------------
        */

        'source_branch' =>
            $sourceBranch,


        /*
        |--------------------------------------------------------------------------
        | Transfer Destination
        |--------------------------------------------------------------------------
        */

        'destination_branch' =>
            $destinationBranch,


        /*
        |--------------------------------------------------------------------------
        | Created By
        |--------------------------------------------------------------------------
        */

        'created_by' => [

            'id' =>
                $movement->createdBy?->id,

            'name' =>
                $creatorName,

        ],


        /*
        |--------------------------------------------------------------------------
        | Product
        |--------------------------------------------------------------------------
        */

        'product' => [

            'id' =>
                $movement->product?->id,

            'name' =>
                $movement->product?->name
                ?? '-',

            'sku' =>
                $movement->product?->sku
                ?? '-',

            'category' =>
                $movement->product?->category?->name
                ?? '-',

            'unit' =>
                $movement->product?->unit?->name
                ?? '-',

        ],


        /*
        |--------------------------------------------------------------------------
        | Quantity
        |--------------------------------------------------------------------------
        */

        'quantity' =>
            (float) (
                $movement->quantity
                ?? 0
            ),


        /*
        |--------------------------------------------------------------------------
        | Balance After
        |--------------------------------------------------------------------------
        */

        'balance_after' =>
            (float) (
                $movement->balance_after
                ?? 0
            ),


        /*
        |--------------------------------------------------------------------------
        | Unit Cost
        |--------------------------------------------------------------------------
        */

        'unit_cost' =>
            (float) (
                $movement->unit_cost
                ?? 0
            ),


        /*
        |--------------------------------------------------------------------------
        | Remarks
        |--------------------------------------------------------------------------
        */

        'remarks' =>
            $movement->remarks
            ?? '',

    ];


    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    return response()->json([

        'status' =>
            true,

        'data' =>
            $details,

    ]);

}

}