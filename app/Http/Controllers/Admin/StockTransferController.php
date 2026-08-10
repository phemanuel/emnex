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

class StockTransferController extends BaseController
{
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
                                'Transfer',

                            'order_id' =>
                                null,

                            'reference_no' =>
                                $referenceNo,

                            'unit_cost' =>
                                $unitCost,

                            'quantity' =>
                                -$quantity,

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
                                'Transfer',

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
    | Transfer History
    |--------------------------------------------------------------------------
    */

    public function history(
        Request $request,
        int $product
    ) {
        if (! canAccess('inventory.transfer_stock')) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Verify Product Belongs To Company
        |--------------------------------------------------------------------------
        */

        $productStock =
            ProductStock::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'product_id',
                    $product
                )

                ->with([
                    'product.category',
                    'product.unit',
                ])

                ->first();


        if (! $productStock) {

            return response()->json([

                'status' =>
                    false,

                'message' =>
                    'Product stock could not be found.'

            ], 404);

        }


        /*
        |--------------------------------------------------------------------------
        | Transfer Movements
        |--------------------------------------------------------------------------
        */

        $movements =
            StockMovement::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'product_id',
                    $product
                )

                ->where(
                    'movement_type',
                    'Transfer'
                )

                ->with([
                    'branch',
                    'creator',
                ]);


        /*
        |--------------------------------------------------------------------------
        | Branch Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('branch')) {

            $movements->where(
                'branch_id',
                $request->branch
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Date From
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_from')) {

            $movements->whereDate(
                'created_at',
                '>=',
                $request->date_from
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Date To
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_to')) {

            $movements->whereDate(
                'created_at',
                '<=',
                $request->date_to
            );

        }


        $movements =
            $movements

                ->latest('id')

                ->get();


        /*
        |--------------------------------------------------------------------------
        | Group By Transfer Reference
        |--------------------------------------------------------------------------
        |
        | Every product transfer creates two movements:
        |
        | 1. Negative movement at source.
        | 2. Positive movement at destination.
        |
        | Both share the same reference number.
        |
        */

        $history = [];


        foreach (
            $movements->groupBy('reference_no')
            as $referenceNo => $transferMovements
        ) {

            $source =
                $transferMovements->first(
                    fn ($movement) =>
                        (float) $movement->quantity < 0
                );


            $destination =
                $transferMovements->first(
                    fn ($movement) =>
                        (float) $movement->quantity > 0
                );


            if (
                ! $source ||
                ! $destination
            ) {

                continue;

            }


            $history[] = [

                'id' =>
                    $source->id,

                'reference_no' =>
                    $referenceNo,

                'date' =>
                    $source->created_at
                        ?->format(
                            'd M Y, h:i A'
                        ),

                'from' => [

                    'id' =>
                        $source->branch_id,

                    'name' =>
                        $source->branch?->name ?? '-',

                ],

                'to' => [

                    'id' =>
                        $destination->branch_id,

                    'name' =>
                        $destination->branch?->name ?? '-',

                ],

                'quantity' =>
                    abs(
                        (float)
                        $source->quantity
                    ),

                'stock_before' =>
                    (float)
                    $source->stock_before,

                'balance_after' =>
                    (float)
                    $destination->balance_after,

                'user' =>
                    $source->creator?->name ?? '-',

                'remarks' =>
                    $source->remarks,

            ];

        }


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

            'data' => [

                'product' => [

                    'id' =>
                        $productStock->product->id,

                    'name' =>
                        $productStock->product->name,

                    'product_code' =>
                        $productStock->product->product_code,

                    'sku' =>
                        $productStock->product->sku,

                    'category' =>
                        $productStock->product->category?->name,

                    'unit' =>
                        $productStock->product->unit?->name,

                    'image_url' =>
                        $productStock->product->imageUrl(),

                ],

                'history' =>
                    $history,

            ],

        ]);
    }
}