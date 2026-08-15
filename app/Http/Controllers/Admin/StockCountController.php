<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Branch;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\StockCount;
use App\Models\StockCountItem;
use App\Models\StockMovement;
use App\Services\DocumentNumberService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Services\ActivityLogger;

class StockCountController extends BaseController
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
     * Display the Stock Count page.
     */
    public function index()
    {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('inventory.stock_count')) {

            abort(
                403,
                'You do not have permission to access Stock Count.'
            );

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


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return view(
            'stock-count.index',
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
     * Return the Stock Count table.
     */
    public function table(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('inventory.stock_count')) {

            return response()->json([

                'status' =>
                    false,

                'message' =>
                    'You do not have permission to view Stock Counts.',

            ], 403);

        }


        try {

            /*
            |--------------------------------------------------------------------------
            | Query
            |--------------------------------------------------------------------------
            */

            $query =
                StockCount::query()

                    ->where(
                        'company_id',
                        $this->companyId
                    )

                    ->with([

                        'branch:id,name',

                        'createdBy:id,first_name,last_name',

                    ]);


            /*
            |--------------------------------------------------------------------------
            | Search
            |--------------------------------------------------------------------------
            */

            if (
                $request->filled(
                    'search'
                )
            ) {

                $search =
                    trim(
                        $request->search
                    );


                $query->where(
                    function ($q) use (
                        $search
                    ) {

                        $q->where(
                            'reference_no',
                            'like',
                            '%' . $search . '%'
                        )

                        ->orWhere(
                            'notes',
                            'like',
                            '%' . $search . '%'
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
                    $request->branch_id
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Status Filter
            |--------------------------------------------------------------------------
            */

            if (
                $request->filled(
                    'status'
                )
            ) {

                $query->where(
                    'status',
                    $request->status
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Date Filter
            |--------------------------------------------------------------------------
            */

            if (
                $request->filled(
                    'date_from'
                )
            ) {

                $query->whereDate(
                    'count_date',
                    '>=',
                    $request->date_from
                );

            }


            if (
                $request->filled(
                    'date_to'
                )
            ) {

                $query->whereDate(
                    'count_date',
                    '<=',
                    $request->date_to
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Ordering
            |--------------------------------------------------------------------------
            */

            $query->latest(
                'id'
            );


            /*
            |--------------------------------------------------------------------------
            | Pagination
            |--------------------------------------------------------------------------
            */

            $perPage =
                (int) (
                    $request->per_page
                    ?? 10
                );


            $perPage =
                min(
                    max(
                        $perPage,
                        5
                    ),
                    100
                );


            $counts =
                $query->paginate(
                    $perPage
                );


            /*
            |--------------------------------------------------------------------------
            | Transform
            |--------------------------------------------------------------------------
            */

            $data =
                $counts->getCollection()
                    ->map(
                        function (
                            StockCount $count
                        ) {

                            $creatorName =
                                $count->createdBy
                                    ? trim(
                                        $count->createdBy->first_name
                                        . ' '
                                        . $count->createdBy->last_name
                                    )
                                    : 'System';


                            return [

                                'id' =>
                                    $count->id,

                                'reference_no' =>
                                    $count->reference_no,

                                'branch' =>
                                    $count->branch?->name
                                    ?? '—',

                                'count_date' =>
                                    $count->count_date
                                        ? $count->count_date
                                            ->format('d M Y')
                                        : '—',

                                'status' =>
                                    $count->status,

                                'created_by' =>
                                    $creatorName,

                                'created_at' =>
                                    $count->created_at
                                        ? $count->created_at
                                            ->format('d M Y H:i')
                                        : '—',

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
                        $counts->currentPage(),

                    'last_page' =>
                        $counts->lastPage(),

                    'per_page' =>
                        $counts->perPage(),

                    'total' =>
                        $counts->total(),

                    'from' =>
                        $counts->firstItem(),

                    'to' =>
                        $counts->lastItem(),

                ],

            ]);

        } catch (\Throwable $e) {

            \Log::error(
                'Stock Count table loading failed.',
                [

                    'company_id' =>
                        $this->companyId,

                    'error' =>
                        $e->getMessage(),

                ]
            );


            return response()->json([

                'status' =>
                    false,

                'message' =>
                    'Unable to load Stock Counts.',

            ], 500);

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Details
    |--------------------------------------------------------------------------
    */

    /**
     * Return Stock Count details.
     */
    public function details(
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('inventory.stock_count')) {

            return response()->json([

                'status' =>
                    false,

                'message' =>
                    'You do not have permission to view Stock Counts.',

            ], 403);

        }


        try {

            /*
            |--------------------------------------------------------------------------
            | Query
            |--------------------------------------------------------------------------
            */

            $stockCount =
                StockCount::query()

                    ->where(
                        'company_id',
                        $this->companyId
                    )

                    ->where(
                        'id',
                        $id
                    )

                    ->with([

                        'branch:id,name',

                        'createdBy:id,first_name,last_name',

                        'completedBy:id,first_name,last_name',

                        'items' => function ($query) {

                            $query->orderBy(
                                'id'
                            );

                        },

                        'items.product' => function ($query) {

                            $query->withTrashed();

                        },

                        'items.product.category:id,name',

                        'items.product.unit:id,name',

                    ])

                    ->first();


            /*
            |--------------------------------------------------------------------------
            | Not Found
            |--------------------------------------------------------------------------
            */

            if (! $stockCount) {

                return response()->json([

                    'status' =>
                        false,

                    'message' =>
                        'Stock Count not found.',

                ], 404);

            }


            /*
            |--------------------------------------------------------------------------
            | Creator
            |--------------------------------------------------------------------------
            */

            $creatorName =
                $stockCount->createdBy
                    ? trim(
                        $stockCount->createdBy->first_name
                        . ' '
                        . $stockCount->createdBy->last_name
                    )
                    : 'System';


            /*
            |--------------------------------------------------------------------------
            | Completed By
            |--------------------------------------------------------------------------
            */

            $completedByName =
                $stockCount->completedBy
                    ? trim(
                        $stockCount->completedBy->first_name
                        . ' '
                        . $stockCount->completedBy->last_name
                    )
                    : null;


            /*
            |--------------------------------------------------------------------------
            | Items
            |--------------------------------------------------------------------------
            */

            $items =
                $stockCount->items
                    ->map(
                        function (
                            StockCountItem $item
                        ) {

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
                                        ?? 'Deleted Product',

                                    'product_code' =>
                                        $item->product?->product_code
                                        ?? '—',

                                    'sku' =>
                                        $item->product?->sku
                                        ?? '—',

                                    'barcode' =>
                                        $item->product?->barcode
                                        ?? '—',

                                    'category' =>
                                        $item->product?->category?->name
                                        ?? '—',

                                    'unit' =>
                                        $item->product?->unit?->name
                                        ?? '—',

                                ],

                                'system_quantity' =>
                                    (float)
                                    $item->system_quantity,

                                'counted_quantity' =>
                                    (float)
                                    $item->counted_quantity,

                                'variance' =>
                                    (float)
                                    $item->variance,

                                'unit_cost' =>
                                    (float)
                                    $item->unit_cost,

                                'variance_value' =>
                                    $item->varianceValue(),

                                'notes' =>
                                    $item->notes,

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

                'data' => [

                    'id' =>
                        $stockCount->id,

                    'reference_no' =>
                        $stockCount->reference_no,

                    'branch' => [

                        'id' =>
                            $stockCount->branch?->id,

                        'name' =>
                            $stockCount->branch?->name
                            ?? '—',

                    ],

                    'count_date' =>
                        $stockCount->count_date
                            ? $stockCount->count_date
                                ->format('Y-m-d')
                            : null,

                    'status' =>
                        $stockCount->status,

                    'notes' =>
                        $stockCount->notes,

                    'created_by' =>
                        $creatorName,

                    'completed_by' =>
                        $completedByName,

                    'completed_at' =>
                        $stockCount->completed_at
                            ? $stockCount->completed_at
                                ->format('d M Y H:i')
                            : null,

                    'item_count' =>
                        $stockCount->items->count(),

                    'variance_item_count' =>
                        $stockCount->varianceItemCount(),

                    'positive_variance' =>
                        $stockCount->positiveVariance(),

                    'negative_variance' =>
                        $stockCount->negativeVariance(),

                    'items' =>
                        $items,

                ],

            ]);

        } catch (\Throwable $e) {

            \Log::error(
                'Stock Count details loading failed.',
                [

                    'company_id' =>
                        $this->companyId,

                    'stock_count_id' =>
                        $id,

                    'error' =>
                        $e->getMessage(),

                ]
            );


            return response()->json([

                'status' =>
                    false,

                'message' =>
                    'Unable to load Stock Count details.',

            ], 500);

        }

    }

   

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    /**
     * Create a Stock Count.
     */
    public function store(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('inventory.stock_count')) {

            return response()->json([

                'status' =>
                    false,

                'message' =>
                    'You do not have permission to create Stock Counts.',

            ], 403);

        }


        try {

            /*
            |--------------------------------------------------------------------------
            | Validation
            |--------------------------------------------------------------------------
            */

            $validated =
                $request->validate([

                    'branch_id' => [

                        'required',

                        'integer',

                        'exists:branches,id',

                    ],

                    'count_date' => [

                        'required',

                        'date',

                    ],

                    'notes' => [

                        'nullable',

                        'string',

                    ],

                ]);


            /*
            |--------------------------------------------------------------------------
            | Branch Validation
            |--------------------------------------------------------------------------
            */

            $branch =
                Branch::query()

                    ->where(
                        'company_id',
                        $this->companyId
                    )

                    ->where(
                        'id',
                        $validated['branch_id']
                    )

                    ->where(
                        'status',
                        true
                    )

                    ->first();


            if (! $branch) {

                return response()->json([

                    'status' =>
                        false,

                    'message' =>
                        'The selected branch does not belong to your company.',

                ], 422);

            }


            /*
            |--------------------------------------------------------------------------
            | Check Branch Stock
            |--------------------------------------------------------------------------
            |
            | A Stock Count should only be created for a branch that
            | already has stock records.
            |
            | Company stock is branch-specific, therefore we check
            | ProductStock using both company_id and branch_id.
            |
            */

            $hasStock =
                ProductStock::query()

                    ->where(
                        'company_id',
                        $this->companyId
                    )

                    ->where(
                        'branch_id',
                        $validated['branch_id']
                    )

                    ->exists();


            if (! $hasStock) {

                return response()->json([

                    'status' =>
                        false,

                    'message' =>
                        'This branch has no stock available for counting. Please transfer or add stock to the branch before creating a Stock Count.',

                ], 422);

            }


            /*
            |--------------------------------------------------------------------------
            | Prevent Duplicate Active Stock Count
            |--------------------------------------------------------------------------
            |
            | A branch should not have multiple unfinished stock counts
            | at the same time.
            |
            */

            $existingCount =
                StockCount::query()

                    ->where(
                        'company_id',
                        $this->companyId
                    )

                    ->where(
                        'branch_id',
                        $validated['branch_id']
                    )

                    ->whereIn(
                        'status',
                        [
                            'Draft',
                            'In Progress',
                        ]
                    )

                    ->exists();


            if ($existingCount) {

                return response()->json([

                    'status' =>
                        false,

                    'message' =>
                        'This branch already has an active Stock Count. Please complete or delete the existing count before creating another one.',

                ], 422);

            }


            /*
            |--------------------------------------------------------------------------
            | Document Number
            |--------------------------------------------------------------------------
            */

            $referenceNo =
                DocumentNumberService::generate(
                    'stock_count',
                    $this->companyId
                );


            /*
            |--------------------------------------------------------------------------
            | Save
            |--------------------------------------------------------------------------
            */

            $stockCount =
                DB::transaction(
                    function () use (
                        $validated,
                        $referenceNo
                    ) {

                        return StockCount::create([

                            'company_id' =>
                                $this->companyId,

                            'branch_id' =>
                                $validated['branch_id'],

                            'reference_no' =>
                                $referenceNo,

                            'count_date' =>
                                $validated['count_date'],

                            'status' =>
                                'Draft',

                            'notes' =>
                                $validated['notes']
                                ?? null,

                            'created_by' =>
                                auth()->id(),

                        ]);

                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'Stock Count',

                'Created',

                'Created stock count ' .
                    $stockCount->reference_no,

                $stockCount,

                null,

                $stockCount->toArray()

            );


            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'status' =>
                    true,

                'message' =>
                    'Stock Count created successfully.',

                'data' => [

                    'id' =>
                        $stockCount->id,

                    'reference_no' =>
                        $stockCount->reference_no,

                ],

            ]);

        } catch (
            ValidationException $e
        ) {

            throw $e;

        } catch (\Throwable $e) {

            \Log::error(
                'Stock Count creation failed.',
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

                'message' =>
                    'Unable to create Stock Count.',

            ], 500);

        }

    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    /**
     * Update a Stock Count.
     */
    public function update(
        Request $request,
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('inventory.stock_count')) {

            return response()->json([

                'status' =>
                    false,

                'message' =>
                    'You do not have permission to update Stock Counts.',

            ], 403);

        }


        try {

            /*
            |--------------------------------------------------------------------------
            | Query
            |--------------------------------------------------------------------------
            */

            $stockCount =
                StockCount::query()

                    ->where(
                        'company_id',
                        $this->companyId
                    )

                    ->where(
                        'id',
                        $id
                    )

                    ->first();


            if (! $stockCount) {

                return response()->json([

                    'status' =>
                        false,

                    'message' =>
                        'Stock Count not found.',

                ], 404);

            }


            /*
            |--------------------------------------------------------------------------
            | Status Validation
            |--------------------------------------------------------------------------
            */

            if (! $stockCount->canEdit()) {

                return response()->json([

                    'status' =>
                        false,

                    'message' =>
                        'This Stock Count can no longer be edited.',

                ], 422);

            }


            /*
            |--------------------------------------------------------------------------
            | Validation
            |--------------------------------------------------------------------------
            */

            $validated =
                $request->validate([

                    'branch_id' => [

                        'required',

                        'integer',

                        'exists:branches,id',

                    ],

                    'count_date' => [

                        'required',

                        'date',

                    ],

                    'notes' => [

                        'nullable',

                        'string',

                    ],

                ]);


            /*
            |--------------------------------------------------------------------------
            | Branch Validation
            |--------------------------------------------------------------------------
            */

            $branch =
                Branch::query()

                    ->where(
                        'company_id',
                        $this->companyId
                    )

                    ->where(
                        'id',
                        $validated['branch_id']
                    )

                    ->where(
                        'status',
                        true
                    )

                    ->first();


            if (! $branch) {

                return response()->json([

                    'status' =>
                        false,

                    'message' =>
                        'The selected branch does not belong to your company.',

                ], 422);

            }


            /*
            |--------------------------------------------------------------------------
            | Old Values
            |--------------------------------------------------------------------------
            */

            $oldValues =
                $stockCount->toArray();


            /*
            |--------------------------------------------------------------------------
            | Save
            |--------------------------------------------------------------------------
            */

            $stockCount->update([

                'branch_id' =>
                    $validated['branch_id'],

                'count_date' =>
                    $validated['count_date'],

                'notes' =>
                    $validated['notes']
                    ?? null,

            ]);


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'Stock Count',

                'Updated',

                'Updated stock count ' .
                    $stockCount->reference_no,

                $stockCount,

                $oldValues,

                $stockCount->fresh()
                    ->toArray()

            );


            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'status' =>
                    true,

                'message' =>
                    'Stock Count updated successfully.',

            ]);

        } catch (
            ValidationException $e
        ) {

            throw $e;

        } catch (\Throwable $e) {

            \Log::error(
                'Stock Count update failed.',
                [

                    'company_id' =>
                        $this->companyId,

                    'stock_count_id' =>
                        $id,

                    'error' =>
                        $e->getMessage(),

                ]
            );


            return response()->json([

                'status' =>
                    false,

                'message' =>
                    'Unable to update Stock Count.',

            ], 500);

        }

    }   

    /*
    |--------------------------------------------------------------------------
    | Destroy
    |--------------------------------------------------------------------------
    */

    /**
     * Delete a Stock Count.
     */
    public function destroy(
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('inventory.stock_count')) {

            return response()->json([

                'status' =>
                    false,

                'message' =>
                    'You do not have permission to delete Stock Counts.',

            ], 403);

        }


        try {

            /*
            |--------------------------------------------------------------------------
            | Query
            |--------------------------------------------------------------------------
            */

            $stockCount =
                StockCount::query()

                    ->where(
                        'company_id',
                        $this->companyId
                    )

                    ->where(
                        'id',
                        $id
                    )

                    ->first();


            if (! $stockCount) {

                return response()->json([

                    'status' =>
                        false,

                    'message' =>
                        'Stock Count not found.',

                ], 404);

            }


            /*
            |--------------------------------------------------------------------------
            | Only Draft Can Be Deleted
            |--------------------------------------------------------------------------
            */

            if (
                ! $stockCount->isDraft()
            ) {

                return response()->json([

                    'status' =>
                        false,

                    'message' =>
                        'Only draft Stock Counts can be deleted.',

                ], 422);

            }


            /*
            |--------------------------------------------------------------------------
            | Old Values
            |--------------------------------------------------------------------------
            */

            $oldValues =
                $stockCount->toArray();


            /*
            |--------------------------------------------------------------------------
            | Delete Items
            |--------------------------------------------------------------------------
            */

            DB::transaction(
                function () use (
                    $stockCount
                ) {

                    $stockCount->items()
                        ->delete();

                    $stockCount->delete();

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'Stock Count',

                'Deleted',

                'Deleted stock count ' .
                    $oldValues['reference_no'],

                $stockCount,

                $oldValues,

                null

            );


            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'status' =>
                    true,

                'message' =>
                    'Stock Count deleted successfully.',

            ]);

        } catch (\Throwable $e) {

            \Log::error(
                'Stock Count deletion failed.',
                [

                    'company_id' =>
                        $this->companyId,

                    'stock_count_id' =>
                        $id,

                    'error' =>
                        $e->getMessage(),

                ]
            );


            return response()->json([

                'status' =>
                    false,

                'message' =>
                    'Unable to delete Stock Count.',

            ], 500);

        }

    }

    /**
     * Start a Stock Count.
     */
    public function start(
        int $id
    ): JsonResponse {

        if (! canAccess('inventory.stock_count')) {

            return response()->json([

                'status' =>
                    false,

                'message' =>
                    'You do not have permission to start Stock Counts.',

            ], 403);

        }


        try {

            $stockCount =
                StockCount::query()

                    ->where(
                        'company_id',
                        $this->companyId
                    )

                    ->where(
                        'id',
                        $id
                    )

                    ->first();


            if (! $stockCount) {

                return response()->json([

                    'status' =>
                        false,

                    'message' =>
                        'Stock Count not found.',

                ], 404);

            }


            if (! $stockCount->isDraft()) {

                return response()->json([

                    'status' =>
                        false,

                    'message' =>
                        'Only Draft Stock Counts can be started.',

                ], 422);

            }


            $stockCount =
                DB::transaction(
                    function () use (
                        $stockCount
                    ) {

                        $stocks =
                            ProductStock::query()

                                ->where(
                                    'company_id',
                                    $this->companyId
                                )

                                ->where(
                                    'branch_id',
                                    $stockCount->branch_id
                                )

                                ->with('product')

                                ->get();


                        if ($stocks->isEmpty()) {

                            throw new \RuntimeException(
                                'This branch has no stock available for counting.'
                            );

                        }


                        foreach ($stocks as $stock) {

                            StockCountItem::create([

                                'stock_count_id' =>
                                    $stockCount->id,

                                'product_id' =>
                                    $stock->product_id,

                                'system_quantity' =>
                                    $stock->quantity,

                                'counted_quantity' =>
                                    0,

                                'variance' =>
                                    0,

                                'unit_cost' =>
                                    $stock->product?->cost_price
                                    ?? 0,

                                'notes' =>
                                    null,

                            ]);

                        }


                        $stockCount->update([

                            'status' =>
                                'In Progress',

                        ]);


                        return $stockCount->fresh();

                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'Stock Count',

                'Started',

                'Started stock count ' .
                    $stockCount->reference_no,

                $stockCount,

                [

                    'status' =>
                        'Draft',

                ],

                [

                    'status' =>
                        'In Progress',

                ]

            );


            return response()->json([

                'status' =>
                    true,

                'message' =>
                    'Stock Count started successfully.',

                'data' => [

                    'id' =>
                        $stockCount->id,

                    'reference_no' =>
                        $stockCount->reference_no,

                    'status' =>
                        $stockCount->status,

                ],

            ]);

        } catch (\Throwable $e) {

            \Log::error(
                'Stock Count start failed.',
                [

                    'company_id' =>
                        $this->companyId,

                    'stock_count_id' =>
                        $id,

                    'error' =>
                        $e->getMessage(),

                ]
            );


            return response()->json([

                'status' =>
                    false,

                'message' =>
                    $e->getMessage()
                    ?: 'Unable to start Stock Count.',

            ], 500);

        }

    }

}