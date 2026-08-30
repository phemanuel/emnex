<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Discount;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\DocumentSequence;
use App\Models\TaxRate;
use App\Services\ActivityLogger;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Branch;
use App\Models\ProductStock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class ProductController extends BaseController
{

    protected ActivityLogger $activityLogger;


    public function __construct(ActivityLogger $activityLogger)
    {
        parent::__construct();

        $this->activityLogger = $activityLogger;
    }
    /**
     * Display Products page.
     */
    
    public function index(): View
    {

        /*
        |--------------------------------------------------------------------------
        | Branch Access
        |--------------------------------------------------------------------------
        */

        $user =
            auth()->user();

        $role =
            $user->role?->code;

        $canManageAllBranches =
            in_array(
                $role,
                [
                    'owner',
                    'administrator',
                ]
            );

        $currentBranchId =
            $user->branch_id;


        /*
        |--------------------------------------------------------------------------
        | Product Query
        |--------------------------------------------------------------------------
        */

        $query =
            Product::forCompany(
                $this->companyId
            );


        /*
        |--------------------------------------------------------------------------
        | Branch Scope
        |--------------------------------------------------------------------------
        */

        if (!$canManageAllBranches) {

            $query->whereHas(
                'stocks',
                function ($stockQuery) use (
                    $currentBranchId
                ) {

                    $stockQuery->where(
                        'branch_id',
                        $currentBranchId
                    );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

        $products =

            (clone $query)

                ->with([
                    'category',
                    'unit',
                    'taxRate',
                    'discount',
                ])

                ->latest()

                ->paginate(10);


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $statsQuery =
            clone $query;


        $stats = [

            'total' =>

                (clone $statsQuery)
                    ->count(),


            'active' =>

                (clone $statsQuery)
                    ->where(
                        'status',
                        true
                    )
                    ->count(),


            'low_stock' =>

                (clone $statsQuery)
                    ->with('stocks')
                    ->get()
                    ->filter(
                        fn ($product) =>
                            $product->isLowStock()
                    )
                    ->count(),


            'out_of_stock' =>

                (clone $statsQuery)
                    ->with('stocks')
                    ->get()
                    ->filter(
                        fn ($product) =>
                            $product->isOutOfStock()
                    )
                    ->count(),

        ];


        /*
        |--------------------------------------------------------------------------
        | Supporting Data
        |--------------------------------------------------------------------------
        */

        return view(
            'products.index',
            [

                'products' =>
                    $products,

                'stats' =>
                    $stats,

                'categories' =>

                    ProductCategory::forCompany(
                        $this->companyId
                    )

                        ->active()

                        ->orderBy('name')

                        ->get(),

                'units' =>

                    Unit::forCompany(
                        $this->companyId
                    )

                        ->active()

                        ->orderBy('name')

                        ->get(),

                'taxRates' =>

                    TaxRate::forCompany(
                        $this->companyId
                    )

                        ->active()

                        ->orderBy('name')

                        ->get(),

                'discounts' =>

                    Discount::forCompany(
                        $this->companyId
                    )

                        ->active()

                        ->orderBy('name')

                        ->get(),

            ]
        );

    }

    /**
     * Product table (AJAX).
     */
   
    public function table(Request $request)
    {

        /*
        |--------------------------------------------------------------------------
        | Product Query
        |--------------------------------------------------------------------------
        */

        $productsQuery =

            Product::query()

                ->forCompany(
                    $this->companyId
                );


        /*
        |--------------------------------------------------------------------------
        | Branch Access
        |--------------------------------------------------------------------------
        */

        $user =
            auth()->user();

        $role =
            $user->role?->code;

        $canManageAllBranches =
            in_array(
                $role,
                [
                    'owner',
                    'administrator',
                ]
            );

        $currentBranchId =
            $user->branch_id;


        /*
        |--------------------------------------------------------------------------
        | Branch Scope
        |--------------------------------------------------------------------------
        |
        | Products are company master records, while branch availability
        | is represented through product_stocks.
        |
        */

        if (!$canManageAllBranches) {

            $productsQuery->whereHas(
                'stocks',
                function ($query) use (
                    $currentBranchId
                ) {

                    $query->where(
                        'branch_id',
                        $currentBranchId
                    );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Relationships
        |--------------------------------------------------------------------------
        */

        $productsQuery->with([
            'category',
            'unit',
            'taxRate',
            'discount',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        $productsQuery->when(
            $request->filled('search'),
            function ($query) use ($request) {

                $search =
                    trim(
                        $request->search
                    );


                $query->where(
                    function ($q) use ($search) {

                        $q->where(
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
                        )

                        ->orWhere(
                            'brand',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'manufacturer',
                            'like',
                            "%{$search}%"
                        );

                    }
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        $productsQuery->when(
            $request->status !== null &&
            $request->status !== '',
            function ($query) use ($request) {

                $query->where(
                    'status',
                    filter_var(
                        $request->status,
                        FILTER_VALIDATE_BOOLEAN
                    )
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $products =
            $productsQuery

                ->latest()

                ->paginate(10)

                ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return view(
            'products.partials.table',
            compact('products')
        );

    }



    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        if (! canAccess('products.create')) {

            return response()->json([

                'status' => false,

                'message' =>
                    'You do not have permission to create products.'

            ], 403);

        }


        try {

            $validated = $request->validate([

                'product_category_id' =>
                    ['required', 'exists:product_categories,id'],

                'unit_id' =>
                    ['required', 'exists:units,id'],

                'tax_rate_id' =>
                    ['nullable', 'exists:tax_rates,id'],

                'discount_id' =>
                    ['nullable', 'exists:discounts,id'],


                'product_code' =>
                    ['required', 'string', 'max:50'],

                'sku' =>
                    ['nullable', 'string', 'max:100'],

                'barcode' =>
                    ['nullable', 'string', 'max:100'],

                'qr_code' =>
                    ['nullable', 'string', 'max:100'],


                'name' =>
                    ['required', 'string', 'max:255'],

                'description' =>
                    ['nullable', 'string'],


                'brand' =>
                    ['nullable', 'string', 'max:150'],

                'manufacturer' =>
                    ['nullable', 'string', 'max:150'],


                'cost_price' =>
                    ['required', 'numeric', 'min:0'],

                'selling_price' =>
                    ['required', 'numeric', 'min:0'],


                'minimum_stock' =>
                    ['required', 'numeric', 'min:0'],

                'maximum_stock' =>
                    ['nullable', 'numeric', 'gte:minimum_stock'],


                /*
                |--------------------------------------------------------------------------
                | Opening Stock
                |--------------------------------------------------------------------------
                */

                'opening_stock' =>
                    ['nullable', 'numeric', 'min:0'],


                'weight' =>
                    ['nullable', 'numeric', 'min:0'],

                'expiry_date' =>
                    ['nullable', 'date'],


                'status' =>
                    ['nullable', 'boolean'],


                'image' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:2048',
                ],

            ]);


            /*
            |--------------------------------------------------------------------------
            | Opening Stock
            |--------------------------------------------------------------------------
            */

            $openingStock = (float) (
                $validated['opening_stock'] ?? 0
            );


            /*
            |--------------------------------------------------------------------------
            | Opening Stock Does Not Belong To Product
            |--------------------------------------------------------------------------
            */

            unset(
                $validated['opening_stock']
            );


            /*
            |--------------------------------------------------------------------------
            | Check Existing Product
            |--------------------------------------------------------------------------
            */

            $duplicate = $this->findDuplicateProduct(
                $validated,
                null,
                true
            );


            if ($duplicate) {

                /*
                |--------------------------------------------------------------------------
                | Restore Soft Deleted Product
                |--------------------------------------------------------------------------
                */

                if ($duplicate->trashed()) {

                    return DB::transaction(
                        function () use (
                            $request,
                            $validated,
                            $duplicate,
                            $openingStock
                        ) {

                            /*
                            |--------------------------------------------------------------------------
                            | Restore Product
                            |--------------------------------------------------------------------------
                            */

                            $duplicate->restore();


                            /*
                            |--------------------------------------------------------------------------
                            | Product Image
                            |--------------------------------------------------------------------------
                            */

                            if ($request->hasFile('image')) {

                                $this->deleteImage(
                                    $duplicate->image
                                );


                                $validated['image'] =
                                    $this->uploadImage(
                                        $request->file('image')
                                    );

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Product Values
                            |--------------------------------------------------------------------------
                            */

                            $validated['company_id'] =
                                $this->companyId;

                            $validated['status'] =
                                $request->boolean('status');


                            /*
                            |--------------------------------------------------------------------------
                            | Old Values
                            |--------------------------------------------------------------------------
                            */

                            $oldValues =
                                $duplicate->toArray();


                            /*
                            |--------------------------------------------------------------------------
                            | Update Product
                            |--------------------------------------------------------------------------
                            */

                            $duplicate->update(
                                $validated
                            );


                            /*
                            |--------------------------------------------------------------------------
                            | Find Head Office
                            |--------------------------------------------------------------------------
                            */

                            $headOffice =
                                Branch::query()

                                    ->where(
                                        'company_id',
                                        $this->companyId
                                    )

                                    ->where(
                                        'is_head_office',
                                        true
                                    )

                                    ->first();


                            if (! $headOffice) {

                                throw new \RuntimeException(
                                    'Head Office branch could not be found.'
                                );

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Create / Restore Head Office Stock
                            |--------------------------------------------------------------------------
                            */

                            $productStock =
                                ProductStock::firstOrNew([

                                    'company_id' =>
                                        $this->companyId,

                                    'branch_id' =>
                                        $headOffice->id,

                                    'product_id' =>
                                        $duplicate->id,

                                ]);


                            /*
                            |--------------------------------------------------------------------------
                            | Opening Stock
                            |--------------------------------------------------------------------------
                            */

                            $productStock->quantity =
                                $openingStock;

                            $productStock->reserved_quantity =
                                0;

                            $productStock->available_quantity =
                                $openingStock;

                            $productStock->reorder_level =
                                $validated['minimum_stock'] ?? 0;

                            $productStock->maximum_stock =
                                $validated['maximum_stock'] ?? null;


                            $productStock->save();


                            /*
                            |--------------------------------------------------------------------------
                            | Refresh Product
                            |--------------------------------------------------------------------------
                            */

                            $duplicate->refresh();


                            $newValues =
                                $duplicate->toArray();


                            /*
                            |--------------------------------------------------------------------------
                            | Activity Log
                            |--------------------------------------------------------------------------
                            */

                            $this->activityLogger->log(

                                'Products',

                                'Restored',

                                'Restored product: ' .
                                    $duplicate->name,

                                $duplicate,

                                $oldValues,

                                $newValues

                            );


                            return response()->json([

                                'success' =>
                                    true,

                                'type' =>
                                    'success',

                                'message' =>
                                    'Product restored successfully.',

                            ]);

                        }
                    );

                }


                return response()->json([

                    'success' =>
                        false,

                    'type' =>
                        'warning',

                    'message' =>
                        'A product with the same Product Code, SKU or Barcode already exists.',

                ]);

            }


            /*
            |--------------------------------------------------------------------------
            | Upload Image
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('image')) {

                $validated['image'] =
                    $this->uploadImage(
                        $request->file('image')
                    );

            }


            /*
            |--------------------------------------------------------------------------
            | Product Values
            |--------------------------------------------------------------------------
            */

            $validated['company_id'] =
                $this->companyId;

            $validated['product_code'] =
                $request->product_code;

            $validated['status'] =
                $request->boolean('status');


            /*
            |--------------------------------------------------------------------------
            | Create Product + Head Office Stock
            |--------------------------------------------------------------------------
            */

            DB::transaction(function () use (
                &$product,
                $validated,
                $openingStock
            ) {

                /*
                |--------------------------------------------------------------------------
                | Create Product
                |--------------------------------------------------------------------------
                */

                $product =
                    Product::create(
                        $validated
                    );


                /*
                |--------------------------------------------------------------------------
                | Find Head Office
                |--------------------------------------------------------------------------
                */

                $headOffice = Branch::query()
                    ->where('company_id', $this->companyId)
                    ->headOffice()
                    ->first();

                if (! $headOffice) {

                    throw new \RuntimeException(
                        'No Head Office branch has been configured for this company.'
                    );

                }                
                                /*
                |--------------------------------------------------------------------------
                | Create Head Office Stock
                |--------------------------------------------------------------------------
                */

                ProductStock::create([

                    'company_id' =>
                        $this->companyId,

                    'branch_id' =>
                        $headOffice->id,

                    'product_id' =>
                        $product->id,

                    'quantity' =>
                        $openingStock,

                    'reserved_quantity' =>
                        0,

                    'available_quantity' =>
                        $openingStock,

                    'reorder_level' =>
                        $validated['minimum_stock'] ?? 0,

                    'maximum_stock' =>
                        $validated['maximum_stock'] ?? null,

                ]);

            });


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'Products',

                'Created',

                'Created product: ' .
                    $product->name,

                $product

            );


            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'success' =>
                    true,

                'type' =>
                    'success',

                'message' =>
                    'Product created successfully.',

            ]);


        }
        catch (\Throwable $e) {

            \Log::error(
                'Product creation failed.',
                [

                    'company_id' =>
                        $this->companyId,

                    'error' =>
                        $e->getMessage(),

                ]
            );


            return response()->json([

                'success' =>
                    false,

                'type' =>
                    'danger',

                'message' =>
                    $e->getMessage(),

            ], 500);

        }
    }

    /**
     * Ensure related records belong to the current company.
     */
    private function validateRelationships(array $data): void
    {
        if (! ProductCategory::where('id', $data['product_category_id'])
            ->where('company_id', $this->companyId)
            ->exists()) {

            throw new \Exception('The selected category is invalid.');
        }

        if (! Unit::where('id', $data['unit_id'])
            ->where('company_id', $this->companyId)
            ->exists()) {

            throw new \Exception('The selected unit is invalid.');
        }

        if (
            !empty($data['tax_rate_id']) &&
            ! TaxRate::where('id', $data['tax_rate_id'])
                ->where('company_id', $this->companyId)
                ->exists()
        ) {

            throw new \Exception('The selected tax rate is invalid.');
        }

        if (
            !empty($data['discount_id']) &&
            ! Discount::where('id', $data['discount_id'])
                ->where('company_id', $this->companyId)
                ->exists()
        ) {

            throw new \Exception('The selected discount is invalid.');
        }
    }

    /**
     * Load product for editing.
     */
    public function edit(Product $product)
    {
        try {

            if ($product->company_id !== $this->companyId) {

                return response()->json([
                    'success' => false,
                    'type'    => 'danger',
                    'message' => 'Product not found.',
                ], 404);

            }

            return response()->json([

                'success' => true,

                'data' => [

                    'id' => $product->id,

                    'product_category_id' => $product->product_category_id,

                    'unit_id' => $product->unit_id,

                    'tax_rate_id' => $product->tax_rate_id,

                    'discount_id' => $product->discount_id,

                    'product_code' => $product->product_code,

                    'sku' => $product->sku,

                    'barcode' => $product->barcode,

                    'qr_code' => $product->qr_code,

                    'name' => $product->name,

                    'description' => $product->description,

                    'brand' => $product->brand,

                    'manufacturer' => $product->manufacturer,

                    'cost_price' => $product->cost_price,

                    'selling_price' => $product->selling_price,

                    'minimum_stock' => $product->minimum_stock,

                    'maximum_stock' => $product->maximum_stock,

                    'weight' => $product->weight,

                    'expiry_date' => optional($product->expiry_date)
                        ->format('Y-m-d'),

                    'status' => (bool) $product->status,

                    'image' => $product->image,

                    'image_url' => $product->imageUrl(),

                ],

            ]);

        } catch (\Throwable $e) {

            \Log::error('Product edit failed.', [
                'company_id' => $this->companyId,
                'product_id' => $product->id ?? null,
                'error'      => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'type'    => 'danger',
                'message' => 'Unable to load product.',
            ], 500);

        }
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        if (! canAccess('products.update')) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to update products.'
            ], 403);
        }
        try {

            /*
            |--------------------------------------------------------------------------
            | Company Validation
            |--------------------------------------------------------------------------
            */

            if ($product->company_id !== $this->companyId) {

                return response()->json([
                    'success' => false,
                    'type'    => 'danger',
                    'message' => 'Product not found.',
                ], 404);

            }

            /*
            |--------------------------------------------------------------------------
            | Validation
            |--------------------------------------------------------------------------
            */

            $validated = $request->validate([

                'product_category_id'   => ['required', 'exists:product_categories,id'],
                'unit_id'       => ['required', 'exists:units,id'],

                'tax_rate_id'   => ['nullable', 'exists:tax_rates,id'],
                'discount_id'   => ['nullable', 'exists:discounts,id'],

                'product_code'  => ['required', 'string', 'max:50'],
                'sku'           => ['nullable', 'string', 'max:100'],
                'barcode'       => ['nullable', 'string', 'max:100'],
                'qr_code'       => ['nullable', 'string', 'max:100'],

                'name'          => ['required', 'string', 'max:255'],
                'description'   => ['nullable', 'string'],

                'brand'         => ['nullable', 'string', 'max:150'],
                'manufacturer'  => ['nullable', 'string', 'max:150'],

                'cost_price'    => ['required', 'numeric', 'min:0'],
                'selling_price' => ['required', 'numeric', 'min:0'],

                'minimum_stock' => ['required', 'numeric', 'min:0'],
                'maximum_stock' => ['nullable', 'numeric', 'gte:minimum_stock'],

                'weight'        => ['nullable', 'numeric', 'min:0'],

                'expiry_date'   => ['nullable', 'date'],

                'status'        => ['nullable', 'boolean'],

                'image'         => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:2048',
                ],

            ]);

            /*
            |--------------------------------------------------------------------------
            | Validate Relationships
            |--------------------------------------------------------------------------
            */

            $this->validateRelationships($validated);

            /*
            |--------------------------------------------------------------------------
            | Duplicate Check
            |--------------------------------------------------------------------------
            */

            $duplicate = $this->findDuplicateProduct(
                $validated,
                $product->id
            );

            if ($duplicate) {

                return response()->json([
                    'success' => false,
                    'type'    => 'warning',
                    'message' => 'A product with the same Product Code, SKU or Barcode already exists.',
                ]);

            }

            /*
            |--------------------------------------------------------------------------
            | Image Upload
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('image')) {

                $this->deleteImage($product->image);

                $validated['image'] = $this->uploadImage(
                    $request->file('image')
                );

            }

            /*
            |--------------------------------------------------------------------------
            | Update Product
            |--------------------------------------------------------------------------
            */

            $validated['status'] = $request->boolean('status');

            $oldValues = $product->toArray();

            $product->update($validated);

            $newValues = $product->fresh()->toArray();

            /*
        |--------------------------------------------------------------------------
        | Synchronize Product Stock Limits
        |--------------------------------------------------------------------------
        */

        ProductStock::query()
            ->where(
                'company_id',
                $this->companyId
            )
            ->where(
                'product_id',
                $product->id
            )
            ->update([

                'reorder_level' =>
                    $product->minimum_stock,

                'maximum_stock' =>
                    $product->maximum_stock,

            ]);

            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(
                'Products',
                'Updated',
                'Updated product: ' . $product->name,
                $product,
                $oldValues,
                $newValues
            );

            return response()->json([
                'success' => true,
                'type'    => 'success',
                'message' => 'Product updated successfully.',
            ]);

        } catch (\Throwable $e) {

            \Log::error('Product update failed.', [
                'company_id' => $this->companyId,
                'product_id' => $product->id ?? null,
                'error'      => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'type'    => 'danger',
                'message' => 'Unable to update product.',
            ], 500);

        }
    }

    /**
     * Product details for inspector.
     */
    public function details(Product $product)
    {
        if (! canAccess('products.view')) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to view products.'
            ], 403);
        }

        try {

            /*
            |--------------------------------------------------------------------------
            | Company Validation
            |--------------------------------------------------------------------------
            */

            if ($product->company_id !== $this->companyId) {

                return response()->json([
                    'success' => false,
                    'type'    => 'danger',
                    'message' => 'Product not found.',
                ], 404);

            }

            $product->load([
                'category',
                'unit',
                'taxRate',
                'discount',
            ]);

            $stock = $product->totalStock();

            return response()->json([

                'success' => true,

                'data' => [

                    'id' => $product->id,

                    'image_url' => $product->imageUrl(),

                    'product_code' => $product->product_code,

                    'name' => $product->name,

                    'description' => $product->description,

                    'sku' => $product->sku,

                    'barcode' => $product->barcode,

                    'qr_code' => $product->qr_code,

                    'brand' => $product->brand,

                    'manufacturer' => $product->manufacturer,

                    'category' => optional($product->category)->name,

                    'unit' => optional($product->unit)->name,

                    'tax_rate' => optional($product->taxRate)->name,

                    'discount' => optional($product->discount)->name,

                    'cost_price' => number_format($product->cost_price, 2),

                    'selling_price' => number_format($product->selling_price, 2),

                    'profit_amount' => number_format(
                        $product->profitAmount(),
                        2
                    ),

                    'profit_margin' => number_format(
                        $product->profitMargin(),
                        2
                    ) . '%',

                    'stock' => number_format($stock, 2),

                    'minimum_stock' => number_format(
                        $product->minimum_stock,
                        2
                    ),

                    'maximum_stock' => $product->maximum_stock !== null
                        ? number_format($product->maximum_stock, 2)
                        : '-',

                    'stock_status' => $product->stockStatus(),

                    'stock_badge' => $product->stockBadge(),

                    'weight' => $product->weight
                        ? number_format($product->weight, 2)
                        : '-',

                    'expiry_date' => optional(
                        $product->expiry_date
                    )?->format('d M Y') ?? '-',

                    'expired' => $product->isExpired(),

                    'near_expiry' => $product->isNearExpiry(),

                    'status' => $product->status,

                    'created_at' => $product->created_at
                        ->format('d M Y h:i A'),

                    'updated_at' => $product->updated_at
                        ->format('d M Y h:i A'),

                ]

            ]);

        } catch (\Throwable $e) {

            \Log::error('Product details failed.', [

                'company_id' => $this->companyId,

                'product_id' => $product->id ?? null,

                'error' => $e->getMessage(),

            ]);

            return response()->json([

                'success' => false,

                'type' => 'danger',

                'message' => 'Unable to load product details.',

            ], 500);

        }
    }

    /**
     * Toggle product status.
     */
    public function toggleStatus(Product $product)
    {
        if (! canAccess('products.update')) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to update product status.'
            ], 403);
        }
        try {

            if ($product->company_id !== $this->companyId) {

                return response()->json([
                    'success' => false,
                    'type'    => 'danger',
                    'message' => 'Product not found.',
                ], 404);

            }

            $oldValues = $product->toArray();

            $product->update([
                'status' => ! $product->status,
            ]);

            $newValues = $product->fresh()->toArray();

            $action = $product->status
                ? 'Enabled'
                : 'Disabled';

            $this->activityLogger->log(
                'Products',
                $action,
                "{$action} product: {$product->name}",
                $product,
                $oldValues,
                $newValues
            );

            return response()->json([
                'success' => true,
                'type'    => 'success',
                'message' => "Product {$action} successfully.",
            ]);

        } catch (\Throwable $e) {

            \Log::error('Product status toggle failed.', [
                'company_id' => $this->companyId,
                'product_id' => $product->id ?? null,
                'error'      => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'type'    => 'danger',
                'message' => 'Unable to update product status.',
            ], 500);

        }
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product)
    {
        if (! canAccess('products.delete')) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to delete products.'
            ], 403);
        }
        try {

            if ($product->company_id !== $this->companyId) {

                return response()->json([
                    'success' => false,
                    'type'    => 'danger',
                    'message' => 'Product not found.',
                ], 404);

            }

            /*
            |--------------------------------------------------------------------------
            | Prevent deletion if referenced
            |--------------------------------------------------------------------------
            */

            if ($product->orderItems()->exists()) {

                return response()->json([
                    'success' => false,
                    'type'    => 'warning',
                    'message' => 'This product has sales records and cannot be deleted.',
                ]);

            }

            $oldValues = $product->toArray();

            $product->delete();

            $this->activityLogger->log(
                'Products',
                'Deleted',
                'Deleted product: ' . $product->name,
                $product,
                $oldValues,
                null
            );

            return response()->json([
                'success' => true,
                'type'    => 'success',
                'message' => 'Product deleted successfully.',
            ]);

        } catch (\Throwable $e) {

            \Log::error('Product deletion failed.', [
                'company_id' => $this->companyId,
                'product_id' => $product->id ?? null,
                'error'      => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'type'    => 'danger',
                'message' => 'Unable to delete product.',
            ], 500);

        }
    }

    /**
     * Find duplicate product.
     */
    private function findDuplicateProduct(
        array $data,
        ?int $ignoreId = null,
        bool $withTrashed = false
    ): ?Product {

        $query = $withTrashed
            ? Product::withTrashed()
            : Product::query();

        $query->where('company_id', $this->companyId);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        $query->where(function ($q) use ($data) {

            $q->where('product_code', $data['product_code']);

            if (!empty($data['sku'])) {
                $q->orWhere('sku', $data['sku']);
            }

            if (!empty($data['barcode'])) {
                $q->orWhere('barcode', $data['barcode']);
            }

        });

        return $query->first();
    }

    /*
    |--------------------------------------------------------------------------
    | Generate Next Product Code
    |--------------------------------------------------------------------------
    */

    public function nextCode()
    {


        /*
        |--------------------------------------------------------------------------
        | Get Document Sequence
        |--------------------------------------------------------------------------
        */


        $sequence = DocumentSequence::where(
                'company_id',
                $this->companyId
            )
            ->where(
                'document_type',
                'product'
            )
            ->first();



        if(!$sequence)
        {

            return response()->json([

                'success'=>false,

                'message'=>'Product document sequence not configured.'

            ]);

        }





        /*
        |--------------------------------------------------------------------------
        | Get Last Product Number
        |--------------------------------------------------------------------------
        */


        $lastProduct = Product::forCompany(
                $this->companyId
            )
            ->orderByDesc('id')
            ->first();





        $prefix = $sequence->prefix;


        $length = $sequence->number_length;





        if(!$lastProduct)
        {


            $nextNumber = 1;


        }
        else
        {


            /*
            |
            | Extract numeric part
            |
            | PRD000009 => 000009
            |
            */


            preg_match(
                '/(\d+)$/',
                $lastProduct->product_code,
                $matches
            );



            if(isset($matches[1]))
            {

                $nextNumber =
                    intval($matches[1]) + 1;

            }
            else
            {

                $nextNumber = 1;

            }


        }





        /*
        |--------------------------------------------------------------------------
        | Format Product Code
        |--------------------------------------------------------------------------
        */


        $code =
            $prefix .
            str_pad(
                $nextNumber,
                $length,
                '0',
                STR_PAD_LEFT
            );






        return response()->json([

            'success'=>true,

            'code'=>$code

        ]);

    }

    /**
     * Upload product image.
     */
    private function uploadImage($image): string
    {
        $filename = time() . '_' . uniqid() . '.' .
            $image->getClientOriginalExtension();

        $image->move(
            public_path('uploads/products'),
            $filename
        );

        return $filename;
    }

    /**
     * Delete product image.
     */
    private function deleteImage(?string $image): void
    {
        if (
            !$image ||
            !file_exists(public_path('uploads/products/' . $image))
        ) {
            return;
        }

        unlink(
            public_path('uploads/products/' . $image)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Update Maximum Stock
    |--------------------------------------------------------------------------
    */

    /**
     * Update product maximum stock.
     */
    public function updateMaximumStock(
        Request $request,
        Product $product
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('products.update')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to update products.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Company Validation
        |--------------------------------------------------------------------------
        */

        if (
            $product->company_id !==
            $this->companyId
        ) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Product not found.',

            ], 404);

        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([

                'maximum_stock' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

            ]);


        try {

            DB::transaction(

                function () use (
                    $product,
                    $validated
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | Product
                    |--------------------------------------------------------------------------
                    */

                    $oldValues =
                        $product->toArray();


                    $product->maximum_stock =
                        $validated[
                            'maximum_stock'
                        ];


                    $product->save();


                    /*
                    |--------------------------------------------------------------------------
                    | Product Stock
                    |--------------------------------------------------------------------------
                    |
                    | Keep ProductStock.maximum_stock synchronized
                    | with Product.maximum_stock.
                    |
                    */

                    ProductStock::query()
                        ->where(
                            'company_id',
                            $this->companyId
                        )
                        ->where(
                            'product_id',
                            $product->id
                        )
                        ->update([

                            'maximum_stock' =>
                                $validated[
                                    'maximum_stock'
                                ],

                        ]);


                    /*
                    |--------------------------------------------------------------------------
                    | Activity Log
                    |--------------------------------------------------------------------------
                    */

                    $newValues =
                        $product
                            ->fresh()
                            ->toArray();


                    $this->activityLogger->log(

                        'Products',

                        'Updated',

                        'Updated maximum stock for product: ' .
                            $product->name,

                        $product,

                        $oldValues,

                        $newValues

                    );

                }

            );


            return response()->json([

                'success' =>
                    true,

                'type' =>
                    'success',

                'message' =>
                    'Maximum stock updated successfully.',

            ]);

        }
        catch (\Throwable $e) {

            Log::error(
                'Maximum stock update failed.',
                [

                    'company_id' =>
                        $this->companyId,

                    'product_id' =>
                        $product->id,

                    'error' =>
                        $e->getMessage(),

                ]
            );


            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Unable to update maximum stock.',

            ], 500);

        }

    }




}

