<?php

namespace App\Http\Controllers\Admin;

use App\Services\BusinessProfileService;
use Illuminate\Validation\ValidationException;

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
use App\Services\ProductImportService;
use App\Models\Storefront;
use App\Models\ProductImage;
use App\Services\ProductImageService;


class ProductController extends BaseController
{

    protected ActivityLogger $activityLogger;
    protected ProductImportService $productImportService;
    protected BusinessProfileService $businessProfileService;
    protected ProductImageService $productImageService;


    // public function __construct(ActivityLogger $activityLogger)
    // {
    //     parent::__construct();

    //     $this->activityLogger = $activityLogger;
    // }
    
    public function __construct(
        ActivityLogger $activityLogger,
        ProductImportService $productImportService,
        BusinessProfileService $businessProfileService,
        ProductImageService $productImageService
    ) {
        parent::__construct();

        $this->activityLogger =
            $activityLogger;

        $this->productImportService =
            $productImportService;

        $this->businessProfileService =
            $businessProfileService;

        $this->productImageService =
            $productImageService;
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

        $storefront = Storefront::query()
        ->where(
            'company_id',
            $this->companyId
        )
        ->where(
            'status',
            'Active'
        )
        ->first();

        $productFieldModes =
            $this->businessProfileService
                ->get(
                    $this->company,
                    'product.fields',
                    []
                );

        $productImageSettings = [

            'enabled' =>
                (bool) $this->businessProfileService
                    ->get(
                        $this->company,
                        'product.images.enabled',
                        true
                    ),

            'multiple' =>
                (bool) $this->businessProfileService
                    ->get(
                        $this->company,
                        'product.images.multiple',
                        false
                    ),

            'max_images' =>
                max(
                    1,
                    (int) $this->businessProfileService
                        ->get(
                            $this->company,
                            'product.images.max_images',
                            1
                        )
                ),

        ];

        $productStockSettings = [

            'default' =>
                $this->businessProfileService
                    ->productTracksStockByDefault(
                        $this->company
                    ),

            'changeable' =>
                $this->businessProfileService
                    ->productStockTrackingIsChangeable(
                        $this->company
                    ),

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

                'storefront' => $storefront,

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

                'productFieldModes' =>
                     $productFieldModes,

                'productImageSettings' =>
                    $productImageSettings,

                'tracksStockByDefault' =>
                    $this->businessProfileService
                        ->productTracksStockByDefault(
                            $this->company
                        ),

                'productStockSettings' =>
                      $productStockSettings,

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
                ],
                true
            );

        $currentBranchId =
            $user->branch_id;


        /*
        |--------------------------------------------------------------------------
        | Product Capabilities
        |--------------------------------------------------------------------------
        */

        $productFieldModes =
            (array) $this->businessProfileService
                ->get(
                    $this->company,
                    'product.fields',
                    []
                );


        $fieldVisible =
            fn (string $field): bool =>
                (
                    $productFieldModes[$field]
                    ?? 'optional'
                ) !== 'hidden';


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
        | Branch Scope
        |--------------------------------------------------------------------------
        |
        | Stock products:
        |     Must exist in the user's branch.
        |
        | Non-stock products:
        |     Do not require ProductStock and remain available to the branch.
        |
        */

        if (!$canManageAllBranches) {

            $productsQuery->where(
                function ($query) use (
                    $currentBranchId
                ) {

                    $query
                        ->where(
                            'track_stock',
                            false
                        )

                        ->orWhereHas(
                            'stocks',
                            function ($stockQuery) use (
                                $currentBranchId
                            ) {

                                $stockQuery
                                    ->where(
                                        'company_id',
                                        $this->companyId
                                    )

                                    ->where(
                                        'branch_id',
                                        $currentBranchId
                                    );

                            }
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

            'stocks' =>
                function ($query) use (
                    $canManageAllBranches,
                    $currentBranchId
                ) {

                    $query->where(
                        'company_id',
                        $this->companyId
                    );


                    if (!$canManageAllBranches) {

                        $query->where(
                            'branch_id',
                            $currentBranchId
                        );

                    }

                },

        ]);


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        $productsQuery->when(
            $request->filled('search'),
            function ($query) use (
                $request,
                $fieldVisible
            ) {

                $search =
                    trim(
                        $request->search
                    );


                $query->where(
                    function ($q) use (
                        $search,
                        $fieldVisible
                    ) {

                        $q->where(
                            'name',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'product_code',
                            'like',
                            "%{$search}%"
                        );


                        if (
                            $fieldVisible(
                                'sku'
                            )
                        ) {

                            $q->orWhere(
                                'sku',
                                'like',
                                "%{$search}%"
                            );

                        }


                        if (
                            $fieldVisible(
                                'barcode'
                            )
                        ) {

                            $q->orWhere(
                                'barcode',
                                'like',
                                "%{$search}%"
                            );

                        }


                        if (
                            $fieldVisible(
                                'brand'
                            )
                        ) {

                            $q->orWhere(
                                'brand',
                                'like',
                                "%{$search}%"
                            );

                        }


                        if (
                            $fieldVisible(
                                'manufacturer'
                            )
                        ) {

                            $q->orWhere(
                                'manufacturer',
                                'like',
                                "%{$search}%"
                            );

                        }

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
            $request->status !== null
            &&
            $request->status !== '',
            function ($query) use (
                $request
            ) {

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
        | Storefront
        |--------------------------------------------------------------------------
        */

        $storefront =
            Storefront::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->where(
                    'status',
                    'Active'
                )
                ->first();


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
        | Stock Scope
        |--------------------------------------------------------------------------
        */

        $stockBranchId =
            !$canManageAllBranches
                ? $currentBranchId
                : null;


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return view(
            'products.partials.table',
            [

                'products' =>
                    $products,

                'storefront' =>
                    $storefront,

                'productFieldModes' =>
                    $productFieldModes,

                'stockBranchId' =>
                    $stockBranchId,

            ]
        );
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (!canAccess('products.create')) {

            return response()->json([
                'status' => false,
                'message' =>
                    'You do not have permission to create products.',
            ], 403);
        }


        try {

            /*
            |--------------------------------------------------------------------------
            | Validation
            |--------------------------------------------------------------------------
            */

            $validated =
                $request->validate(
                    $this->productValidationRules(
                        true
                    )
                );


            /*
            |--------------------------------------------------------------------------
            | Normalize Product Data
            |--------------------------------------------------------------------------
            */

            $validated =
                $this->normalizeProductData(
                    $validated
                );

            $validated['track_stock'] =
                $this->resolveProductTrackStock(
                    $request
                );


            /*
            |--------------------------------------------------------------------------
            | Validate Relationships
            |--------------------------------------------------------------------------
            */

            $this->validateRelationships(
                $validated
            );


            /*
            |--------------------------------------------------------------------------
            | Validate Stock Limits
            |--------------------------------------------------------------------------
            */

            $this->validateStockLimits(
                $validated
            );


            /*
            |--------------------------------------------------------------------------
            | Product Images
            |--------------------------------------------------------------------------
            |
            | Images do not belong directly in the Product create/update payload.
            |
            | They are handled separately by ProductImageService.
            |
            */

            $imagePayload =
                $this->extractProductImagePayload(
                    $validated
                );


            /*
            |--------------------------------------------------------------------------
            | Opening Stock
            |--------------------------------------------------------------------------
            */

            $openingStock =
                $validated['track_stock']
                    ? (float) (
                        $validated['opening_stock']
                        ?? 0
                    )
                    : 0;


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

            $duplicate =
                $this->findDuplicateProduct(
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
                            $openingStock,
                            $imagePayload
                        ) {

                            /*
                            |--------------------------------------------------------------------------
                            | Restore Product
                            |--------------------------------------------------------------------------
                            */

                            $duplicate->restore();


                            /*
                            |--------------------------------------------------------------------------
                            | Product Values
                            |--------------------------------------------------------------------------
                            */

                            $validated['company_id'] =
                                $this->companyId;

                            $validated['status'] =
                                $request->boolean(
                                    'status'
                                );


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


                            if (!$headOffice) {

                                throw new \RuntimeException(
                                    'Head Office branch could not be found.'
                                );
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Create / Restore Head Office Stock
                            |--------------------------------------------------------------------------
                            */

                            $this->syncProductStockState(
                                $duplicate,
                                $openingStock
                            );


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
                                $validated[
                                    'minimum_stock'
                                ] ?? 0;

                            $productStock->maximum_stock =
                                $validated[
                                    'maximum_stock'
                                ] ?? null;


                            $productStock->save();


                            /*
                            |--------------------------------------------------------------------------
                            | Product Gallery
                            |--------------------------------------------------------------------------
                            |
                            | Existing images are preserved.
                            |
                            | New uploads are added through ProductImageService.
                            |
                            */

                            $this->saveProductImages(
                                $duplicate,
                                $imagePayload['images'],
                                $imagePayload[
                                    'primary_index'
                                ]
                            );


                            /*
                            |--------------------------------------------------------------------------
                            | Existing Primary Image
                            |--------------------------------------------------------------------------
                            |
                            | Used when editing/restoring a product and the user chooses
                            | one of its existing gallery images as the cover image.
                            |
                            */

                            $this->setExistingPrimaryImage(
                                $duplicate,
                                $imagePayload[
                                    'primary_image_id'
                                ]
                            );


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

                                'Restored product: '
                                    . $duplicate->name,

                                $duplicate,

                                $oldValues,

                                $newValues
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
                                    'Product restored successfully.',

                            ]);
                        }
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Active Duplicate
                |--------------------------------------------------------------------------
                */

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
            | Product Values
            |--------------------------------------------------------------------------
            */

            $validated['company_id'] =
                $this->companyId;

            $validated['product_code'] =
                $request->product_code;

            $validated['status'] =
                $request->boolean(
                    'status'
                );


            /*
            |--------------------------------------------------------------------------
            | Create Product + Stock + Images
            |--------------------------------------------------------------------------
            */

            $product = null;


            DB::transaction(
                function () use (
                    &$product,
                    $validated,
                    $openingStock,
                    $imagePayload
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

                    $headOffice =
                        Branch::query()
                            ->where(
                                'company_id',
                                $this->companyId
                            )
                            ->headOffice()
                            ->first();


                    if (!$headOffice) {

                        throw new \RuntimeException(
                            'No Head Office branch has been configured for this company.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Create Head Office Stock
                    |--------------------------------------------------------------------------
                    */

                    $this->syncProductStockState(
                        $product,
                        $openingStock
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Product Images
                    |--------------------------------------------------------------------------
                    */

                    $this->saveProductImages(
                        $product,
                        $imagePayload['images'],
                        $imagePayload[
                            'primary_index'
                        ]
                    );
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'Products',

                'Created',

                'Created product: '
                    . $product->name,

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

        } catch (ValidationException $e) {

            /*
            |--------------------------------------------------------------------------
            | Allow Laravel To Return Normal 422 Validation Response
            |--------------------------------------------------------------------------
            */

            throw $e;

        } catch (\Throwable $e) {

            Log::error(
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
                    'Unable to create product.',

            ], 500);
        }
    }

    /**
     * Ensure related records belong to the current company.
     */
    private function validateRelationships(
        array $data
    ): void {

        /*
        |--------------------------------------------------------------------------
        | Category
        |--------------------------------------------------------------------------
        */

        if (
            ! ProductCategory::query()
                ->where(
                    'id',
                    $data['product_category_id']
                )
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->exists()
        ) {

            throw new \Exception(
                'The selected category is invalid.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Unit
        |--------------------------------------------------------------------------
        */

        if (
            array_key_exists(
                'unit_id',
                $data
            )
            &&
            $data['unit_id'] !== null
            &&
            ! Unit::query()
                ->where(
                    'id',
                    $data['unit_id']
                )
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->exists()
        ) {

            throw new \Exception(
                'The selected unit is invalid.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Tax Rate
        |--------------------------------------------------------------------------
        */

        if (
            array_key_exists(
                'tax_rate_id',
                $data
            )
            &&
            $data['tax_rate_id'] !== null
            &&
            ! TaxRate::query()
                ->where(
                    'id',
                    $data['tax_rate_id']
                )
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->exists()
        ) {

            throw new \Exception(
                'The selected tax rate is invalid.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Discount
        |--------------------------------------------------------------------------
        */

        if (
            array_key_exists(
                'discount_id',
                $data
            )
            &&
            $data['discount_id'] !== null
            &&
            ! Discount::query()
                ->where(
                    'id',
                    $data['discount_id']
                )
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->exists()
        ) {

            throw new \Exception(
                'The selected discount is invalid.'
            );
        }
    }
    /*
    |--------------------------------------------------------------------------
    | Product Validation Rules
    |--------------------------------------------------------------------------
    |
    | Product field visibility and requirement state come from the resolved
    | company business profile.
    |
    | Hidden fields are deliberately omitted from validation entirely.
    |
    | This means values submitted for fields that do not apply to the company
    | are not included in the validated product data.
    |
    */

    private function productValidationRules(
        bool $includeOpeningStock = false
    ): array {

        /*
        |--------------------------------------------------------------------------
        | Product Field Definitions
        |--------------------------------------------------------------------------
        */

        $definitions = [

            'product_category_id' => [
                'integer',
                'exists:product_categories,id',
            ],

            'unit_id' => [
                'integer',
                'exists:units,id',
            ],

            'tax_rate_id' => [
                'integer',
                'exists:tax_rates,id',
            ],

            'discount_id' => [
                'integer',
                'exists:discounts,id',
            ],

            'product_code' => [
                'string',
                'max:50',
            ],

            'sku' => [
                'string',
                'max:100',
            ],

            'barcode' => [
                'string',
                'max:100',
            ],

            'qr_code' => [
                'string',
                'max:100',
            ],

            'name' => [
                'string',
                'max:255',
            ],

            'description' => [
                'string',
            ],

            'brand' => [
                'string',
                'max:150',
            ],

            'manufacturer' => [
                'string',
                'max:150',
            ],

            'cost_price' => [
                'numeric',
                'min:0',
            ],

            'selling_price' => [
                'numeric',
                'min:0',
            ],

            'minimum_stock' => [
                'numeric',
                'min:0',
            ],

            'maximum_stock' => [
                'numeric',
                'min:0',
            ],

            'weight' => [
                'numeric',
                'min:0',
            ],

            'expiry_date' => [
                'date',
            ],

        ];


        /*
        |--------------------------------------------------------------------------
        | Opening Stock
        |--------------------------------------------------------------------------
        |
        | Opening stock only exists during Product creation.
        |
        */

        if ($includeOpeningStock) {

            $definitions['opening_stock'] = [
                'numeric',
                'min:0',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Build Capability-Aware Rules
        |--------------------------------------------------------------------------
        */

        $rules = [];


        foreach (
            $definitions as
            $field => $baseRules
        ) {

            $mode =
                $this->businessProfileService
                    ->productFieldMode(
                        $this->company,
                        $field
                    );


            /*
            |--------------------------------------------------------------------------
            | Hidden Field
            |--------------------------------------------------------------------------
            |
            | Hidden fields are not validated and therefore will not appear in
            | Laravel's validated payload.
            |
            */

            if (
                $mode ===
                BusinessProfileService::FIELD_HIDDEN
            ) {

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Required / Optional
            |--------------------------------------------------------------------------
            */

            $rules[$field] =
                array_merge(
                    [
                        $mode ===
                            BusinessProfileService::FIELD_REQUIRED
                            ? 'required'
                            : 'nullable',
                    ],
                    $baseRules
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Universal Product Status
        |--------------------------------------------------------------------------
        */

        $rules['status'] = [
            'nullable',
            'boolean',
        ];


        /*
        |--------------------------------------------------------------------------
        | Product Images
        |--------------------------------------------------------------------------
        */

        $imageMode =
            $this->businessProfileService
                ->productFieldMode(
                    $this->company,
                    'image'
                );


        $imageVisible =
            $imageMode !==
            BusinessProfileService::FIELD_HIDDEN;


        $imageRequired =
            $imageMode ===
            BusinessProfileService::FIELD_REQUIRED;


        $imagesEnabled =
            (bool) $this->businessProfileService
                ->get(
                    $this->company,
                    'product.images.enabled',
                    true
                );


        if (
            $imageVisible
            &&
            $imagesEnabled
        ) {

            /*
            |--------------------------------------------------------------------------
            | Gallery Capability
            |--------------------------------------------------------------------------
            */

            $multiple =
                (bool) $this->businessProfileService
                    ->get(
                        $this->company,
                        'product.images.multiple',
                        false
                    );


            $maxImages =
                max(
                    1,
                    (int) $this->businessProfileService
                        ->get(
                            $this->company,
                            'product.images.max_images',
                            1
                        )
                );


            if (!$multiple) {

                $maxImages = 1;
            }


            /*
            |--------------------------------------------------------------------------
            | Gallery Input
            |--------------------------------------------------------------------------
            |
            | On CREATE:
            |
            | If images are required, either the new images[] input OR the temporary
            | legacy image input may satisfy the requirement.
            |
            | On UPDATE:
            |
            | Images remain nullable because the Product may already have saved
            | gallery images and the user should not need to re-upload them.
            |
            */

            $rules['images'] = [

                $imageRequired
                && $includeOpeningStock
                    ? 'required_without:image'
                    : 'nullable',

                'array',

                'max:' . $maxImages,

            ];


            /*
            |--------------------------------------------------------------------------
            | Individual Gallery Images
            |--------------------------------------------------------------------------
            */

            $rules['images.*'] = [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ];


            /*
            |--------------------------------------------------------------------------
            | Temporary Legacy Single Image
            |--------------------------------------------------------------------------
            |
            | This stays only until we replace the current modal input with the
            | proper images[] gallery uploader.
            |
            */

            $rules['image'] = [

                $imageRequired
                && $includeOpeningStock
                    ? 'required_without:images'
                    : 'nullable',

                'image',

                'mimes:jpg,jpeg,png,webp',

                'max:2048',

            ];


            /*
            |--------------------------------------------------------------------------
            | New Primary Image
            |--------------------------------------------------------------------------
            |
            | Refers to the zero-based position inside the newly uploaded images[].
            |
            */

            $rules['primary_image_index'] = [
                'nullable',
                'integer',
                'min:0',
                'max:' . (
                    $maxImages - 1
                ),
            ];


            /*
            |--------------------------------------------------------------------------
            | Existing Primary Image
            |--------------------------------------------------------------------------
            |
            | The controller separately verifies that this image belongs to both
            | the current company and the current Product.
            |
            */

            $rules['primary_image_id'] = [
                'nullable',
                'integer',
                'min:1',
            ];
        }


        return $rules;
    }

   /*
    |--------------------------------------------------------------------------
    | Extract Product Image Payload
    |--------------------------------------------------------------------------
    |
    | Image-specific values must never be passed directly into Product::create()
    | or Product::update().
    |
    */

    private function extractProductImagePayload(
        array &$validated
    ): array {

        $images =
            $validated['images']
            ?? [];


        if (!is_array($images)) {

            $images =
                $images
                    ? [$images]
                    : [];
        }


        /*
        |--------------------------------------------------------------------------
        | Temporary Legacy Single Image
        |--------------------------------------------------------------------------
        */

        if (
            empty($images)
            &&
            isset($validated['image'])
        ) {

            $images = [
                $validated['image'],
            ];
        }


        $primaryImageIndex =
            isset(
                $validated[
                    'primary_image_index'
                ]
            )
                ? (int) $validated[
                    'primary_image_index'
                ]
                : null;


        $primaryImageId =
            isset(
                $validated[
                    'primary_image_id'
                ]
            )
                ? (int) $validated[
                    'primary_image_id'
                ]
                : null;


        if (
            $primaryImageIndex !== null
            &&
            $primaryImageId !== null
        ) {

            throw ValidationException::withMessages([
                'images' =>
                    'Select either a new primary image or an existing primary image, not both.',
            ]);
        }


        unset(
            $validated['images'],
            $validated['image'],
            $validated[
                'primary_image_index'
            ],
            $validated[
                'primary_image_id'
            ]
        );


        return [
            'images' =>
                $images,

            'primary_index' =>
                $primaryImageIndex,

            'primary_image_id' =>
                $primaryImageId,
        ];
    } 

    /*
    |--------------------------------------------------------------------------
    | Save Product Images
    |--------------------------------------------------------------------------
    */

    private function saveProductImages(
        Product $product,
        array $images,
        ?int $primaryIndex = null
    ): void {

        if (empty($images)) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Multi Image Profile
        |--------------------------------------------------------------------------
        */

        if (
            $this->productImageService
                ->allowsMultiple(
                    $product
                )
        ) {

            $this->productImageService
                ->storeUploadedImages(
                    $product,
                    $images,
                    $primaryIndex
                );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Single Image Profile
        |--------------------------------------------------------------------------
        */

        $this->productImageService
            ->replaceSingleImage(
                $product,
                $images[0]
            );
    }

    private function setExistingPrimaryImage(
        Product $product,
        ?int $productImageId
    ): void {

        if (!$productImageId) {
            return;
        }


        $productImage =
            ProductImage::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->where(
                    'product_id',
                    $product->id
                )
                ->where(
                    'id',
                    $productImageId
                )
                ->first();


        if (!$productImage) {

            throw ValidationException::withMessages([
                'primary_image_id' =>
                    'The selected primary image is invalid.',
            ]);
        }


        $this->productImageService
            ->setPrimary(
                $product,
                $productImage
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Validate Product Stock Limits
    |--------------------------------------------------------------------------
    */

    private function validateStockLimits(
        array $data
    ): void {

        /*
        |--------------------------------------------------------------------------
        | Non-Stock Product
        |--------------------------------------------------------------------------
        */

        if (
            array_key_exists(
                'track_stock',
                $data
            )
            &&
            !$data['track_stock']
        ) {

            return;

        }


        $minimumStock =
            isset(
                $data['minimum_stock']
            )
                ? (float)
                    $data['minimum_stock']
                : null;


        $maximumStock =
            isset(
                $data['maximum_stock']
            )
                ? (float)
                    $data['maximum_stock']
                : null;


        if (
            $minimumStock !== null
            &&
            $maximumStock !== null
            &&
            $maximumStock <
                $minimumStock
        ) {

            throw ValidationException::withMessages([

                'maximum_stock' =>
                    'Maximum stock must be greater than or equal to minimum stock.',

            ]);

        }
    }

    /*
    |--------------------------------------------------------------------------
    | Normalize Product Data
    |--------------------------------------------------------------------------
    */

    private function normalizeProductData(
        array $data
    ): array {

        /*
        |--------------------------------------------------------------------------
        | Minimum Stock
        |--------------------------------------------------------------------------
        |
        | minimum_stock is NOT NULL in the existing products table.
        |
        | When the field is visible and the user deliberately leaves it blank,
        | treat that as zero.
        |
        | If the field is hidden, leave it absent so an existing value is not
        | overwritten during update.
        |
        */

        if (
            $this->businessProfileService
                ->productFieldVisible(
                    $this->company,
                    'minimum_stock'
                )
            &&
            array_key_exists(
                'minimum_stock',
                $data
            )
        ) {

            $data['minimum_stock'] =
                (float) (
                    $data['minimum_stock']
                    ?? 0
                );
        }


        return $data;
    }

   /**
     * Load product for editing.
     */
    public function edit(Product $product)
    {
        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (!canAccess('products.update')) {

            return response()->json([
                'success' => false,
                'type' => 'danger',
                'message' =>
                    'You do not have permission to update products.',
            ], 403);
        }


        try {

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
                    'success' => false,
                    'type' => 'danger',
                    'message' => 'Product not found.',
                ], 404);
            }


            /*
            |--------------------------------------------------------------------------
            | Legacy Image Migration
            |--------------------------------------------------------------------------
            |
            | Older products may still have products.image but no corresponding
            | product_images record.
            |
            | This creates the gallery record without copying or re-uploading
            | the physical image.
            |
            */

            $this->productImageService
                ->ensureLegacyPrimary(
                    $product
                );


            /*
            |--------------------------------------------------------------------------
            | Load Product Gallery
            |--------------------------------------------------------------------------
            */

            $product->load(
                'images'
            );


            /*
            |--------------------------------------------------------------------------
            | Gallery Data
            |--------------------------------------------------------------------------
            */

            $images =
                $product->images
                    ->map(
                        function ($image) {

                            return [

                                'id' =>
                                    $image->id,

                                'image' =>
                                    $image->image,

                                'image_url' =>
                                    asset(
                                        'uploads/products/'
                                        . $image->image
                                    ),

                                'is_primary' =>
                                    (bool) $image->is_primary,

                                'sort_order' =>
                                    (int) $image->sort_order,

                            ];

                        }
                    )
                    ->values()
                    ->all();


            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'success' => true,

                'data' => [

                    'id' =>
                        $product->id,

                    'product_category_id' =>
                        $product->product_category_id,

                    'unit_id' =>
                        $product->unit_id,

                    'tax_rate_id' =>
                        $product->tax_rate_id,

                    'discount_id' =>
                        $product->discount_id,

                    'product_code' =>
                        $product->product_code,

                    'sku' =>
                        $product->sku,

                    'barcode' =>
                        $product->barcode,

                    'qr_code' =>
                        $product->qr_code,

                    'name' =>
                        $product->name,

                    'description' =>
                        $product->description,

                    'brand' =>
                        $product->brand,

                    'manufacturer' =>
                        $product->manufacturer,

                    'cost_price' =>
                        $product->cost_price,

                    'selling_price' =>
                        $product->selling_price,

                    'track_stock' =>
                         $product->tracksStock(),

                    'minimum_stock' =>
                        $product->minimum_stock,

                    'maximum_stock' =>
                        $product->maximum_stock,

                    'weight' =>
                        $product->weight,

                    'expiry_date' =>
                        optional(
                            $product->expiry_date
                        )->format(
                            'Y-m-d'
                        ),

                    'status' =>
                        (bool) $product->status,


                    /*
                    |--------------------------------------------------------------------------
                    | Legacy Cover
                    |--------------------------------------------------------------------------
                    |
                    | Keep these for compatibility with any existing code that
                    | still expects the Product's primary image directly.
                    |
                    */

                    'image' =>
                        $product->image,

                    'image_url' =>
                        $product->imageUrl(),


                    /*
                    |--------------------------------------------------------------------------
                    | Product Gallery
                    |--------------------------------------------------------------------------
                    */

                    'images' =>
                        $images,

                    'track_stock' =>
                        (bool) $product->track_stock,

                ],

            ]);

        } catch (\Throwable $e) {

            Log::error(
                'Product edit failed.',
                [

                    'company_id' =>
                        $this->companyId,

                    'product_id' =>
                        $product->id ?? null,

                    'error' =>
                        $e->getMessage(),

                ]
            );


            return response()->json([
                'success' => false,
                'type' => 'danger',
                'message' =>
                    'Unable to load product.',
            ], 500);
        }
    }
    /**
     * Update the specified product.
     */
    public function update(
        Request $request,
        Product $product
    ) {
        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (!canAccess('products.update')) {

            return response()->json([
                'status' => false,
                'message' =>
                    'You do not have permission to update products.',
            ], 403);
        }


        try {

            /*
            |--------------------------------------------------------------------------
            | Company Validation
            |--------------------------------------------------------------------------
            */

            if (
                $product->company_id
                !== $this->companyId
            ) {

                return response()->json([
                    'success' => false,
                    'type' => 'danger',
                    'message' => 'Product not found.',
                ], 404);
            }


            /*
            |--------------------------------------------------------------------------
            | Validation
            |--------------------------------------------------------------------------
            */

            $validated =
                $request->validate(
                    $this->productValidationRules()
                );


            /*
            |--------------------------------------------------------------------------
            | Normalize Product Data
            |--------------------------------------------------------------------------
            */

            $validated =
                $this->normalizeProductData(
                    $validated
                );

            $validated['track_stock'] =
            $this->resolveProductTrackStock(
                $request,
                $product
            );


            /*
            |--------------------------------------------------------------------------
            | Validate Relationships
            |--------------------------------------------------------------------------
            */

            $this->validateRelationships(
                $validated
            );


            /*
            |--------------------------------------------------------------------------
            | Validate Stock Limits
            |--------------------------------------------------------------------------
            */

            $this->validateStockLimits(
                $validated,
                $product
            );


            /*
            |--------------------------------------------------------------------------
            | Extract Product Images
            |--------------------------------------------------------------------------
            |
            | Gallery data must not be passed directly to Product::update().
            |
            */

            $imagePayload =
                $this->extractProductImagePayload(
                    $validated
                );


            /*
            |--------------------------------------------------------------------------
            | Duplicate Check
            |--------------------------------------------------------------------------
            */

            $duplicate =
                $this->findDuplicateProduct(
                    $validated,
                    $product->id
                );


            if ($duplicate) {

                return response()->json([
                    'success' => false,
                    'type' => 'warning',
                    'message' =>
                        'A product with the same Product Code, SKU or Barcode already exists.',
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $validated['status'] =
                $request->boolean(
                    'status'
                );


            /*
            |--------------------------------------------------------------------------
            | Old Values
            |--------------------------------------------------------------------------
            */

            $oldValues =
                $product->toArray();


            /*
            |--------------------------------------------------------------------------
            | Update Product + Stock + Images
            |--------------------------------------------------------------------------
            */

            DB::transaction(
                function () use (
                    $product,
                    $validated,
                    $imagePayload
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | Update Product
                    |--------------------------------------------------------------------------
                    */

                    $product->update(
                        $validated
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Synchronize Product Stock Limits
                    |--------------------------------------------------------------------------
                    */

                    $this->syncProductStockState(
                        $product
                    );
                    /*
                    |--------------------------------------------------------------------------
                    | Add New Product Images
                    |--------------------------------------------------------------------------
                    |
                    | For businesses that support multiple images, new uploads are
                    | added to the existing gallery.
                    |
                    | For single-image businesses, saveProductImages() replaces the
                    | existing image using ProductImageService.
                    |
                    */

                    $this->saveProductImages(
                        $product,
                        $imagePayload['images'],
                        $imagePayload[
                            'primary_index'
                        ]
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Existing Primary Image
                    |--------------------------------------------------------------------------
                    |
                    | If the user selected one of the already-saved gallery images
                    | as the new cover image, update it here.
                    |
                    */

                    $this->setExistingPrimaryImage(
                        $product,
                        $imagePayload[
                            'primary_image_id'
                        ]
                    );
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Refresh Product
            |--------------------------------------------------------------------------
            */

            $product->refresh();


            $newValues =
                $product->toArray();


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(
                'Products',
                'Updated',
                'Updated product: '
                    . $product->name,
                $product,
                $oldValues,
                $newValues
            );


            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'success' => true,
                'type' => 'success',
                'message' =>
                    'Product updated successfully.',
            ]);

        } catch (ValidationException $e) {

            /*
            |--------------------------------------------------------------------------
            | Laravel Validation Response
            |--------------------------------------------------------------------------
            */

            throw $e;

        } catch (\Throwable $e) {

            Log::error(
                'Product update failed.',
                [
                    'company_id' =>
                        $this->companyId,

                    'product_id' =>
                        $product->id ?? null,

                    'error' =>
                        $e->getMessage(),
                ]
            );


            return response()->json([
                'success' => false,
                'type' => 'danger',
                'message' =>
                    'Unable to update product.',
            ], 500);
        }
    }


    /**
     * Product details for inspector.
     */
    public function details(Product $product)
    {
        if (!canAccess('products.view')) {

            return response()->json([
                'success' => false,
                'message' =>
                    'You do not have permission to view products.',
            ], 403);
        }


        try {

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
                    'success' => false,
                    'type' => 'danger',
                    'message' => 'Product not found.',
                ], 404);
            }


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
                    ],
                    true
                );

            $currentBranchId =
                $user->branch_id;


            /*
            |--------------------------------------------------------------------------
            | Product Stock Behaviour
            |--------------------------------------------------------------------------
            */

            $tracksStock =
                $product->tracksStock();


            /*
            |--------------------------------------------------------------------------
            | Branch Product Access
            |--------------------------------------------------------------------------
            |
            | Stock items must belong to the user's branch.
            |
            | Non-stock items are company-level items and do not require a
            | ProductStock record.
            |
            */

            if (
                !$canManageAllBranches
                &&
                $tracksStock
            ) {

                $availableInBranch =
                    ProductStock::query()

                        ->where(
                            'company_id',
                            $this->companyId
                        )

                        ->where(
                            'branch_id',
                            $currentBranchId
                        )

                        ->where(
                            'product_id',
                            $product->id
                        )

                        ->exists();


                if (!$availableInBranch) {

                    return response()->json([
                        'success' => false,
                        'type' => 'danger',
                        'message' => 'Product not found.',
                    ], 404);
                }

            }


            /*
            |--------------------------------------------------------------------------
            | Business Profile Fields
            |--------------------------------------------------------------------------
            */

            $fieldVisible =
                fn (string $field): bool =>
                    $this->businessProfileService
                        ->productFieldVisible(
                            $this->company,
                            $field
                        );


            /*
            |--------------------------------------------------------------------------
            | Relationships
            |--------------------------------------------------------------------------
            */

            $relationships =
                [];


            if (
                $fieldVisible(
                    'product_category_id'
                )
            ) {

                $relationships[] =
                    'category';

            }


            if (
                $fieldVisible(
                    'unit_id'
                )
            ) {

                $relationships[] =
                    'unit';

            }


            if (
                $fieldVisible(
                    'tax_rate_id'
                )
            ) {

                $relationships[] =
                    'taxRate';

            }


            if (
                $fieldVisible(
                    'discount_id'
                )
            ) {

                $relationships[] =
                    'discount';

            }


            /*
            |--------------------------------------------------------------------------
            | Scoped Stock
            |--------------------------------------------------------------------------
            */

            if ($tracksStock) {

                $relationships['stocks'] =
                    function ($query) use (
                        $canManageAllBranches,
                        $currentBranchId
                    ) {

                        $query->where(
                            'company_id',
                            $this->companyId
                        );


                        if (!$canManageAllBranches) {

                            $query->where(
                                'branch_id',
                                $currentBranchId
                            );

                        }

                    };

            }


            if (!empty($relationships)) {

                $product->load(
                    $relationships
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Stock Quantity
            |--------------------------------------------------------------------------
            */

            $stock =
                $tracksStock
                    ? (float) $product
                        ->stocks
                        ->sum(
                            'quantity'
                        )
                    : null;


            /*
            |--------------------------------------------------------------------------
            | Stock Status
            |--------------------------------------------------------------------------
            */

            $stockStatus =
                'Not tracked';

            $stockBadge =
                'bg-secondary';


            if ($tracksStock) {

                $minimumStock =
                    (float) (
                        $product->minimum_stock
                        ?? 0
                    );


                if ($stock <= 0) {

                    $stockStatus =
                        'Out of Stock';

                    $stockBadge =
                        'stock-danger';

                }
                elseif (
                    $stock <=
                    $minimumStock
                ) {

                    $stockStatus =
                        'Low Stock';

                    $stockBadge =
                        'stock-warning';

                }
                else {

                    $stockStatus =
                        'In Stock';

                    $stockBadge =
                        'stock-success';

                }

            }


            /*
            |--------------------------------------------------------------------------
            | Universal Data
            |--------------------------------------------------------------------------
            */

            $data = [

                'id' =>
                    $product->id,

                'product_code' =>
                    $product->product_code,

                'name' =>
                    $product->name,

                'status' =>
                    (bool) $product->status,

                'tracks_stock' =>
                    $tracksStock,

                'stock_status' =>
                    $stockStatus,

                'stock_badge' =>
                    $stockBadge,

                'created_at' =>
                    optional(
                        $product->created_at
                    )?->format(
                        'd M Y h:i A'
                    ),

                'updated_at' =>
                    optional(
                        $product->updated_at
                    )?->format(
                        'd M Y h:i A'
                    ),

            ];


            /*
            |--------------------------------------------------------------------------
            | Image
            |--------------------------------------------------------------------------
            */

            if (
                $fieldVisible(
                    'image'
                )
            ) {

                $data['image_url'] =
                    $product->imageUrl();

            }


            /*
            |--------------------------------------------------------------------------
            | Description
            |--------------------------------------------------------------------------
            */

            if (
                $fieldVisible(
                    'description'
                )
            ) {

                $data['description'] =
                    $product->description;

            }


            /*
            |--------------------------------------------------------------------------
            | Identifiers
            |--------------------------------------------------------------------------
            */

            if ($fieldVisible('sku')) {

                $data['sku'] =
                    $product->sku;

            }


            if ($fieldVisible('barcode')) {

                $data['barcode'] =
                    $product->barcode;

            }


            if ($fieldVisible('qr_code')) {

                $data['qr_code'] =
                    $product->qr_code;

            }


            /*
            |--------------------------------------------------------------------------
            | Classification
            |--------------------------------------------------------------------------
            */

            if (
                $fieldVisible(
                    'product_category_id'
                )
            ) {

                $data['category'] =
                    $product
                        ->category
                        ?->name;

            }


            if (
                $fieldVisible(
                    'unit_id'
                )
            ) {

                $data['unit'] =
                    $product
                        ->unit
                        ?->name;

            }


            if (
                $fieldVisible(
                    'tax_rate_id'
                )
            ) {

                $data['tax_rate'] =
                    $product
                        ->taxRate
                        ?->name;

            }


            if (
                $fieldVisible(
                    'discount_id'
                )
            ) {

                $data['discount'] =
                    $product
                        ->discount
                        ?->name;

            }


            /*
            |--------------------------------------------------------------------------
            | Product Details
            |--------------------------------------------------------------------------
            */

            if ($fieldVisible('brand')) {

                $data['brand'] =
                    $product->brand;

            }


            if (
                $fieldVisible(
                    'manufacturer'
                )
            ) {

                $data['manufacturer'] =
                    $product->manufacturer;

            }


            /*
            |--------------------------------------------------------------------------
            | Pricing
            |--------------------------------------------------------------------------
            */

            if (
                $fieldVisible(
                    'cost_price'
                )
            ) {

                $data['cost_price'] =
                    number_format(
                        (float) $product->cost_price,
                        2
                    );

            }


            if (
                $fieldVisible(
                    'selling_price'
                )
            ) {

                $data['selling_price'] =
                    number_format(
                        (float) $product->selling_price,
                        2
                    );

            }


            if (
                $fieldVisible('cost_price')
                &&
                $fieldVisible('selling_price')
            ) {

                $data['profit_amount'] =
                    number_format(
                        $product->profitAmount(),
                        2
                    );


                $data['profit_margin'] =
                    number_format(
                        $product->profitMargin(),
                        2
                    )
                    . '%';

            }


            /*
            |--------------------------------------------------------------------------
            | Inventory
            |--------------------------------------------------------------------------
            */

            if ($tracksStock) {

                $data['stock'] =
                    number_format(
                        $stock,
                        2
                    );


                if (
                    $fieldVisible(
                        'minimum_stock'
                    )
                ) {

                    $data['minimum_stock'] =
                        $product->minimum_stock !== null
                            ? number_format(
                                (float)
                                $product->minimum_stock,
                                2
                            )
                            : '-';

                }


                if (
                    $fieldVisible(
                        'maximum_stock'
                    )
                ) {

                    $data['maximum_stock'] =
                        $product->maximum_stock !== null
                            ? number_format(
                                (float)
                                $product->maximum_stock,
                                2
                            )
                            : '-';

                }

            }


            /*
            |--------------------------------------------------------------------------
            | Weight
            |--------------------------------------------------------------------------
            */

            if (
                $fieldVisible(
                    'weight'
                )
            ) {

                $data['weight'] =
                    $product->weight !== null
                        ? number_format(
                            (float)
                            $product->weight,
                            2
                        )
                        : '-';

            }


            /*
            |--------------------------------------------------------------------------
            | Expiry
            |--------------------------------------------------------------------------
            */

            if (
                $fieldVisible(
                    'expiry_date'
                )
            ) {

                $data['expiry_date'] =
                    optional(
                        $product->expiry_date
                    )?->format(
                        'd M Y'
                    )
                    ?? '-';


                $data['expired'] =
                    $product->isExpired();


                $data['near_expiry'] =
                    $product->isNearExpiry();

            }


            return response()->json([

                'success' =>
                    true,

                'data' =>
                    $data,

            ]);

        }
        catch (\Throwable $e) {

            Log::error(
                'Product details failed.',
                [

                    'company_id' =>
                        $this->companyId,

                    'product_id' =>
                        $product->id
                        ?? null,

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
                    'Unable to load product details.',

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
        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (!canAccess('products.delete')) {

            return response()->json([
                'status' => false,
                'message' =>
                    'You do not have permission to delete products.',
            ], 403);
        }


        try {

            /*
            |--------------------------------------------------------------------------
            | Company Validation
            |--------------------------------------------------------------------------
            */

            if (
                $product->company_id
                !== $this->companyId
            ) {

                return response()->json([
                    'success' => false,
                    'type' => 'danger',
                    'message' => 'Product not found.',
                ], 404);
            }


            /*
            |--------------------------------------------------------------------------
            | Prevent Deletion If Referenced
            |--------------------------------------------------------------------------
            |
            | Products that already form part of sales history must remain
            | available for historical reporting and order records.
            |
            */

            if (
                $product
                    ->orderItems()
                    ->exists()
            ) {

                return response()->json([
                    'success' => false,
                    'type' => 'warning',
                    'message' =>
                        'This product has sales records and cannot be deleted.',
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Old Values
            |--------------------------------------------------------------------------
            */

            $oldValues =
                $product->toArray();


            /*
            |--------------------------------------------------------------------------
            | Soft Delete Product
            |--------------------------------------------------------------------------
            |
            | Do NOT delete product_images or physical image files here.
            |
            | The Product model uses SoftDeletes, and EMNEX supports restoring
            | previously deleted products.
            |
            | Keeping the gallery intact means the product can be restored with
            | all of its existing images still available.
            |
            */

            DB::transaction(
                function () use ($product) {

                    $product->delete();
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(
                'Products',
                'Deleted',
                'Deleted product: '
                    . $product->name,
                $product,
                $oldValues,
                null
            );


            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'success' => true,
                'type' => 'success',
                'message' =>
                    'Product deleted successfully.',
            ]);

        } catch (\Throwable $e) {

            Log::error(
                'Product deletion failed.',
                [
                    'company_id' =>
                        $this->companyId,

                    'product_id' =>
                        $product->id ?? null,

                    'error' =>
                        $e->getMessage(),
                ]
            );


            return response()->json([
                'success' => false,
                'type' => 'danger',
                'message' =>
                    'Unable to delete product.',
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

    /*
    |--------------------------------------------------------------------------
    | Product Import
    |--------------------------------------------------------------------------
    */

    /**
     * Download Excel import template.
     */
    public function downloadImportExcelTemplate()
    {
        abort_unless(
            canAccess('products.create'),
            403
        );

        return $this->productImportService
            ->downloadExcelTemplate();
    }


    /**
     * Download CSV import template.
     */
    public function downloadImportCsvTemplate()
    {
        abort_unless(
            canAccess('products.create'),
            403
        );

        return $this->productImportService
            ->downloadCsvTemplate();
    }

  
    /**
     * --------------------------------------------------------------------------
     * Preview Product Import
     * --------------------------------------------------------------------------
     */
    public function previewImport(Request $request)
    {
        abort_unless(canAccess('products.create'), 403);

        $validated = $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:10240',
            ],
        ]);

        try {

            $preview = $this->productImportService->preview(
                $validated['file'],
                $this->companyId
            );

            return response()->json([
                'success' => true,
                'data' => [
                    'summary' => $preview['summary'] ?? [
                        'total' => 0,
                        'valid' => 0,
                        'warnings' => 0,
                        'errors' => 0,
                        'can_import' => false,
                    ],
                    'rows' => $preview['rows'] ?? [],
                ],
            ]);

        } catch (ValidationException $e) {

            /*
            |--------------------------------------------------------------------------
            | Preserve ProductImportService validation errors
            |--------------------------------------------------------------------------
            |
            | ProductImportService already knows the actual problem with the
            | uploaded file — invalid headers, missing columns, invalid values,
            | duplicate SKU/barcode, missing relationships, etc.
            |
            | Do not replace those errors with a generic message.
            |
            */

            $errors = $e->errors();

            $message = collect($errors)
                ->flatten()
                ->filter()
                ->first();

            return response()->json([
                'success' => false,
                'message' => $message
                    ?? 'The uploaded product file could not be validated.',
                'errors' => $errors,
            ], 422);

        } catch (Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Unexpected Exception
            |--------------------------------------------------------------------------
            |
            | This is for genuine application/import failures rather than normal
            | validation failures. Log the exception but do not expose internal
            | exception details to the browser.
            |
            */

            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Unable to process the uploaded product file.',
                'errors' => [],
            ], 500);
        }
    }


    /**
     * Import validated products.
     */
    public function import(Request $request)
    {
        abort_unless(
            canAccess('products.create'),
            403
        );

        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:10240',
            ],
        ]);

        try {

            $result = $this->productImportService
                ->import(
                    $request->file('file'),
                    $this->companyId,
                    $request->user()
                );

            return response()->json([
                'success' => true,
                'message' => 'Products imported successfully.',
                'data' => $result,
            ]);

        } catch (\Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Delete an individual product gallery image.
     */
    public function destroyImage(
        Product $product,
        ProductImage $productImage
    ) {
        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (!canAccess('products.update')) {

            return response()->json([
                'success' => false,
                'type' => 'danger',
                'message' =>
                    'You do not have permission to update products.',
            ], 403);
        }


        try {

            /*
            |--------------------------------------------------------------------------
            | Product Company Validation
            |--------------------------------------------------------------------------
            */

            if (
                $product->company_id !==
                $this->companyId
            ) {

                return response()->json([
                    'success' => false,
                    'type' => 'danger',
                    'message' => 'Product not found.',
                ], 404);
            }


            /*
            |--------------------------------------------------------------------------
            | Image Ownership Validation
            |--------------------------------------------------------------------------
            */

            if (
                $productImage->company_id !==
                    $this->companyId
                ||
                $productImage->product_id !==
                    $product->id
            ) {

                return response()->json([
                    'success' => false,
                    'type' => 'danger',
                    'message' =>
                        'Product image not found.',
                ], 404);
            }


            /*
            |--------------------------------------------------------------------------
            | Required Image Protection
            |--------------------------------------------------------------------------
            |
            | If this business profile requires a product image, do not allow the
            | user to remove the final remaining gallery image.
            |
            */

            $imageRequired =
                $this->businessProfileService
                    ->productFieldRequired(
                        $this->company,
                        'image'
                    );


            $imageCount =
                ProductImage::query()
                    ->where(
                        'company_id',
                        $this->companyId
                    )
                    ->where(
                        'product_id',
                        $product->id
                    )
                    ->count();


            if (
                $imageRequired
                &&
                $imageCount <= 1
            ) {

                return response()->json([
                    'success' => false,
                    'type' => 'warning',
                    'message' =>
                        'This product must have at least one image.',
                ], 422);
            }


            /*
            |--------------------------------------------------------------------------
            | Delete Image
            |--------------------------------------------------------------------------
            |
            | ProductImageService also:
            |
            | - removes the physical file,
            | - assigns another image as primary when necessary,
            | - synchronizes products.image.
            |
            */

            $this->productImageService
                ->delete(
                    $product,
                    $productImage
                );


            /*
            |--------------------------------------------------------------------------
            | Refresh Gallery
            |--------------------------------------------------------------------------
            */

            $product->refresh();

            $product->load(
                'images'
            );


            $images =
                $product->images
                    ->map(
                        function ($image) {

                            return [

                                'id' =>
                                    $image->id,

                                'image' =>
                                    $image->image,

                                'image_url' =>
                                    asset(
                                        'uploads/products/'
                                        . $image->image
                                    ),

                                'is_primary' =>
                                    (bool) $image->is_primary,

                                'sort_order' =>
                                    (int) $image->sort_order,

                            ];

                        }
                    )
                    ->values()
                    ->all();


            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'success' => true,

                'type' => 'success',

                'message' =>
                    'Product image removed successfully.',

                'data' => [

                    'images' =>
                        $images,

                    'image' =>
                        $product->image,

                    'image_url' =>
                        $product->imageUrl(),

                ],

            ]);

        } catch (\Throwable $e) {

            Log::error(
                'Product image deletion failed.',
                [

                    'company_id' =>
                        $this->companyId,

                    'product_id' =>
                        $product->id ?? null,

                    'product_image_id' =>
                        $productImage->id ?? null,

                    'error' =>
                        $e->getMessage(),

                ]
            );


            return response()->json([
                'success' => false,
                'type' => 'danger',
                'message' =>
                    'Unable to remove product image.',
            ], 500);
        }
    }

    /**
     * Resolve whether a product should track inventory.
     */
    private function resolveProductTrackStock(
        Request $request,
        ?Product $product = null
    ): bool {

        $default =
            $this->businessProfileService
                ->productTracksStockByDefault(
                    $this->company
                );


        $changeable =
            $this->businessProfileService
                ->productStockTrackingIsChangeable(
                    $this->company
                );


        /*
        |--------------------------------------------------------------------------
        | Fixed Business Profile
        |--------------------------------------------------------------------------
        |
        | If the company profile does not allow users to change this behaviour,
        | ignore anything sent by the browser.
        |
        */

        if (!$changeable) {

            return (bool) $default;

        }


        /*
        |--------------------------------------------------------------------------
        | No Value Submitted
        |--------------------------------------------------------------------------
        |
        | Before the UI checkbox is added:
        |
        | Create -> use profile default.
        | Update -> preserve the product's current setting.
        |
        */

        if (
            !$request->has(
                'track_stock'
            )
        ) {

            return $product
                ? $product->tracksStock()
                : (bool) $default;

        }


        return $request->boolean(
            'track_stock'
        );
    }


    /**
     * Synchronize ProductStock with the Product's stock-tracking state.
     *
     * Passing an opening stock value means the Head Office quantity should be
     * initialized/reset. Passing null means existing quantities must be preserved.
     */
    private function syncProductStockState(
        Product $product,
        ?float $openingStock = null
    ): void {

        /*
        |--------------------------------------------------------------------------
        | Non-Stock Product
        |--------------------------------------------------------------------------
        */

        if (!$product->tracksStock()) {

            /*
            |--------------------------------------------------------------------------
            | Protect Existing Inventory
            |--------------------------------------------------------------------------
            |
            | Never silently convert a stocked Product into a non-stock Product.
            |
            */

            $hasInventory =
                ProductStock::query()

                    ->where(
                        'company_id',
                        $this->companyId
                    )

                    ->where(
                        'product_id',
                        $product->id
                    )

                    ->where(
                        function ($query) {

                            $query
                                ->where(
                                    'quantity',
                                    '!=',
                                    0
                                )

                                ->orWhere(
                                    'reserved_quantity',
                                    '!=',
                                    0
                                )

                                ->orWhere(
                                    'available_quantity',
                                    '!=',
                                    0
                                );

                        }
                    )

                    ->exists();


            if ($hasInventory) {

                throw ValidationException::withMessages([

                    'track_stock' =>
                        'Stock tracking cannot be disabled while this product still has inventory. Reduce all branch stock and reserved quantities to zero first.',

                ]);

            }


            /*
            |--------------------------------------------------------------------------
            | Remove Empty Stock State
            |--------------------------------------------------------------------------
            |
            | Historical orders and movements remain intact. These are only current
            | ProductStock rows whose quantities are all zero.
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

                ->delete();


            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Head Office
        |--------------------------------------------------------------------------
        */

        $headOffice =
            Branch::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->headOffice()

                ->first();


        if (!$headOffice) {

            throw new \RuntimeException(
                'No Head Office branch has been configured for this company.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Head Office Stock
        |--------------------------------------------------------------------------
        */

        $headOfficeStock =
            ProductStock::firstOrNew([

                'company_id' =>
                    $this->companyId,

                'branch_id' =>
                    $headOffice->id,

                'product_id' =>
                    $product->id,

            ]);


        /*
        |--------------------------------------------------------------------------
        | Initialize Quantity
        |--------------------------------------------------------------------------
        |
        | Create / restore passes openingStock.
        |
        | Normal update passes null so quantities are preserved.
        |
        */

        if (
            !$headOfficeStock->exists
            ||
            $openingStock !== null
        ) {

            $quantity =
                max(
                    0,
                    (float) (
                        $openingStock
                        ?? 0
                    )
                );


            $headOfficeStock->quantity =
                $quantity;


            $headOfficeStock->reserved_quantity =
                0;


            $headOfficeStock->available_quantity =
                $quantity;

        }


        /*
        |--------------------------------------------------------------------------
        | Stock Limits
        |--------------------------------------------------------------------------
        */

        $headOfficeStock->reorder_level =
            $product->minimum_stock
            ?? 0;


        $headOfficeStock->maximum_stock =
            $product->maximum_stock;


        $headOfficeStock->save();


        /*
        |--------------------------------------------------------------------------
        | Synchronize Existing Branch Limits
        |--------------------------------------------------------------------------
        |
        | Do not change quantities in other branches.
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

                'reorder_level' =>
                    $product->minimum_stock
                    ?? 0,

                'maximum_stock' =>
                    $product->maximum_stock,

            ]);
    }




}

