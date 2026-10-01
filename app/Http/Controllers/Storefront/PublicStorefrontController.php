<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Storefront;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\StorefrontThemeService;

class PublicStorefrontController extends Controller
{
     public function __construct(
        protected StorefrontThemeService $themeService
    ) {
    }
    /**
     * |--------------------------------------------------------------------------
     * Storefront Homepage
     * |--------------------------------------------------------------------------
     */
   public function home(
        Request $request,
        string $storefrontSlug
    ): View {

        $storefront =
            $this->getStorefront(
                $storefrontSlug
            );


        /*
        |--------------------------------------------------------------------------
        | Friendly Storefront Status Page
        |--------------------------------------------------------------------------
        */

        if (
            $unavailable =
                $this->storefrontUnavailableView(
                    $storefront
                )
        ) {

            return $unavailable;

        }


        /*
        |--------------------------------------------------------------------------
        | Head Office
        |--------------------------------------------------------------------------
        */

        $headOffice =
            $this->getHeadOffice(
                $storefront->company_id
            );

        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories =
            ProductCategory::query()
                ->forCompany(
                    $storefront->company_id
                )
                ->active()
                ->whereNull('parent_id')
                ->with([
                    'children' =>
                        function ($query) {

                            $query
                                ->active()
                                ->orderBy(
                                    'sort_order'
                                )
                                ->orderBy(
                                    'name'
                                );

                        },
                ])
                ->orderBy(
                    'sort_order'
                )
                ->orderBy(
                    'name'
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

        $products =
            $this->productQuery(
                $storefront,
                $headOffice
            )
            ->latest('id')
            ->paginate(20)
            ->withQueryString();


       return view(
            $this->themeService->view(
                $storefront,
                'home'
            ),
            [
                'storefront' =>
                    $storefront,

                'company' =>
                    $storefront->company,

                'headOffice' =>
                    $headOffice,

                'categories' =>
                    $categories,

                'products' =>
                    $products,

                'currencySymbol' =>
                    $this->currencySymbol(
                        $storefront
                    ),
            ]
        );

    }


    /**
     * |--------------------------------------------------------------------------
     * Category Page
     * |--------------------------------------------------------------------------
     */
    public function category(
        string $storefrontSlug,
        string $categoryCode
    ): View {

        $storefront =
            $this->getStorefront(
                $storefrontSlug
            );


        if (
            $unavailable =
                $this->storefrontUnavailableView(
                    $storefront
                )
        ) {

            return $unavailable;

        }


        $headOffice =
            $this->getHeadOffice(
                $storefront->company_id
            );    


        /*
        |--------------------------------------------------------------------------
        | Category
        |--------------------------------------------------------------------------
        */

        $category =
            ProductCategory::query()
                ->forCompany(
                    $storefront->company_id
                )
                ->active()
                ->with([
                    'children' =>
                        function ($query) {

                            $query
                                ->active()
                                ->orderBy(
                                    'sort_order'
                                )
                                ->orderBy(
                                    'name'
                                );

                        },

                    'parent',
                ])
                ->where(
                    'category_code',
                    $categoryCode
                )
                ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Current Category + Direct Child Categories
        |--------------------------------------------------------------------------
        */

        $categoryIds =
            collect([
                $category->id,
            ])
            ->merge(
                $category
                    ->children
                    ->pluck('id')
            )
            ->unique()
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Category Products
        |--------------------------------------------------------------------------
        */

        $products =
            $this->productQuery(
                $storefront,
                $headOffice
            )
            ->whereIn(
                'product_category_id',
                $categoryIds
            )
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();


        return view(
            $this->themeService->view(
                $storefront,
                'category'
            ),
            [
                'storefront' =>
                    $storefront,

                'company' =>
                    $storefront->company,

                'headOffice' =>
                    $headOffice,

                'category' =>
                    $category,

                'products' =>
                    $products,

                'currencySymbol' =>
                    $this->currencySymbol(
                        $storefront
                    ),
            ]
        );

    }


    /**
     * |--------------------------------------------------------------------------
     * Product Details
     * |--------------------------------------------------------------------------
     */
    public function product(
        string $storefrontSlug,
        string $productCode
    ): View {

        $storefront =
            $this->getStorefront(
                $storefrontSlug
            );


        if (
            $unavailable =
                $this->storefrontUnavailableView(
                    $storefront
                )
        ) {

            return $unavailable;

        }


        $headOffice =
            $this->getHeadOffice(
                $storefront->company_id
            );


        /*
        |--------------------------------------------------------------------------
        | Product
        |--------------------------------------------------------------------------
        */

        $product =
            $this->productQuery(
                $storefront,
                $headOffice
            )
            ->with([
                'images',
            ])
            ->where(
                'product_code',
                $productCode
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Stock Behaviour
        |--------------------------------------------------------------------------
        */

        $tracksStock =
            $product->tracksStock();


        $stock =
            $tracksStock
                ? $product
                    ->stocks
                    ->first()
                : null;


        $availableQuantity =
            $tracksStock
                ? (float) (
                    $stock?->available_quantity
                    ?? 0
                )
                : null;


        $isAvailable =
            !$tracksStock
            ||
            $availableQuantity > 0;


        /*
        |--------------------------------------------------------------------------
        | Related Products
        |--------------------------------------------------------------------------
        */

        $relatedProducts =
            collect();


        if (
            $product
                ->product_category_id
        ) {

            $relatedProducts =
                $this->productQuery(
                    $storefront,
                    $headOffice
                )
                ->where(
                    'product_category_id',
                    $product
                        ->product_category_id
                )
                ->where(
                    'id',
                    '!=',
                    $product->id
                )
                ->orderBy('name')
                ->limit(4)
                ->get();

        }


        return view(
            $this->themeService->view(
                $storefront,
                'product'
            ),
            [

                'storefront' =>
                    $storefront,

                'company' =>
                    $storefront->company,

                'headOffice' =>
                    $headOffice,

                'product' =>
                    $product,

                'stock' =>
                    $stock,

                'tracksStock' =>
                    $tracksStock,

                'availableQuantity' =>
                    $availableQuantity,

                'isAvailable' =>
                    $isAvailable,

                'relatedProducts' =>
                    $relatedProducts,

                'currencySymbol' =>
                    $this->currencySymbol(
                        $storefront
                    ),

            ]
        );

    }

    /**
     * |--------------------------------------------------------------------------
     * Product Search
     * |--------------------------------------------------------------------------
     */
    public function search(
        Request $request,
        string $storefrontSlug
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Validate Search
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([
                'q' => [
                    'required',
                    'string',
                    'max:100',
                ],
            ]);


        $queryString =
            trim(
                $validated['q']
            );


        /*
        |--------------------------------------------------------------------------
        | Storefront
        |--------------------------------------------------------------------------
        */

        $storefront =
            $this->getStorefront(
                $storefrontSlug
            );


        /*
        |--------------------------------------------------------------------------
        | Search must only work on Active Storefronts
        |--------------------------------------------------------------------------
        */

        if (
            !$storefront ||
            $storefront->status !==
            'Active'
        ) {

            return response()->json(
                [
                    'success' =>
                        false,

                    'message' =>
                        'This Storefront is currently unavailable.',

                    'data' =>
                        [],
                ],
                403
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Head Office
        |--------------------------------------------------------------------------
        */

        $headOffice =
            $this->getHeadOffice(
                $storefront->company_id
            );


        /*
        |--------------------------------------------------------------------------
        | Search Products
        |--------------------------------------------------------------------------
        */

        $products =
            $this->productQuery(
                $storefront,
                $headOffice
            )
            ->where(
                function (
                    Builder $query
                ) use (
                    $queryString
                ) {

                    $search =
                        '%' .
                        $queryString .
                        '%';


                    $query
                        ->where(
                            'name',
                            'like',
                            $search
                        )
                        ->orWhere(
                            'product_code',
                            'like',
                            $search
                        )
                        ->orWhere(
                            'sku',
                            'like',
                            $search
                        )
                        ->orWhere(
                            'barcode',
                            'like',
                            $search
                        )
                        ->orWhere(
                            'brand',
                            'like',
                            $search
                        );

                }
            )
            ->orderBy('name')
            ->limit(8)
            ->get();


        $currencySymbol =
            $this->currencySymbol(
                $storefront
            );


        /*
        |--------------------------------------------------------------------------
        | JSON Result
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' =>
                true,

            'data' =>
                $products
                    ->map(
                        function (
                            Product $product
                        ) use (
                            $storefront,
                            $currencySymbol
                        ) {

                            /*
                            |--------------------------------------------------------------------------
                            | Stock Behaviour
                            |--------------------------------------------------------------------------
                            */

                            $tracksStock =
                                $product->tracksStock();


                            $stock =
                                $tracksStock
                                    ? $product
                                        ->stocks
                                        ->first()
                                    : null;


                            $availableQuantity =
                                $tracksStock
                                    ? (float) (
                                        $stock
                                            ?->available_quantity
                                        ?? 0
                                    )
                                    : null;


                            $isAvailable =
                                !$tracksStock
                                ||
                                $availableQuantity > 0;


                            return [

                                'id' =>
                                    $product->id,

                                'product_code' =>
                                    $product
                                        ->product_code,

                                'name' =>
                                    $product->name,

                                'brand' =>
                                    $product->brand,

                                'price' =>
                                    (float)
                                    $product
                                        ->selling_price,

                                'formatted_price' =>
                                    $currencySymbol .
                                    number_format(
                                        (float)
                                        $product
                                            ->selling_price,
                                        2
                                    ),

                                'image_url' =>
                                    $product
                                        ->imageUrl(),

                                /*
                                |--------------------------------------------------------------------------
                                | Stock Information
                                |--------------------------------------------------------------------------
                                */

                                'tracks_stock' =>
                                    $tracksStock,

                                'available_quantity' =>
                                    $availableQuantity,

                                'in_stock' =>
                                    $isAvailable,

                                'url' =>
                                    route(
                                        'storefront.public.product',
                                        [
                                            'storefrontSlug' =>
                                                $storefront
                                                    ->slug,

                                            'productCode' =>
                                                $product
                                                    ->product_code,
                                        ]
                                    ),

                            ];

                        }
                    )
                    ->values(),
        ]);

    }


    /**
     * |--------------------------------------------------------------------------
     * Cart Page
     * |--------------------------------------------------------------------------
     *
     * Cart contents currently live in localStorage.
     *
     * Prices and quantities will be validated again from
     * the POS database during checkout.
     */
    public function cart(
        string $storefrontSlug
    ): View {

        $storefront =
            $this->getStorefront(
                $storefrontSlug
            );


        if (
            $unavailable =
                $this->storefrontUnavailableView(
                    $storefront
                )
        ) {

            return $unavailable;

        }


        return view(
            $this->themeService->view(
                $storefront,
                'cart'
            ),
            [
                'storefront' =>
                    $storefront,

                'company' =>
                    $storefront->company,

                'currencySymbol' =>
                    $this->currencySymbol(
                        $storefront
                    ),
            ]
        );

    }


    /**
     * |--------------------------------------------------------------------------
     * Get Storefront
     * |--------------------------------------------------------------------------
     *
     * We intentionally do NOT filter by status here.
     *
     * Setup and Disabled Storefronts must still resolve so
     * that we can display a friendly unavailable page.
     */
    protected function getStorefront(
        string $slug
    ): ?Storefront {

        return Storefront::query()
            ->with('company')
            ->where(
                'slug',
                $slug
            )
            ->first();

    }


    /**
     * |--------------------------------------------------------------------------
     * Storefront Availability View
     * |--------------------------------------------------------------------------
     */
   protected function storefrontUnavailableView(
        ?Storefront $storefront
    ): ?View {

        /*
        |--------------------------------------------------------------------------
        | Storefront Does Not Exist
        |--------------------------------------------------------------------------
        */

        if (!$storefront) {

            return view(
                'storefront.public.unavailable',
                [
                    'storefront' =>
                        null,

                    'company' =>
                        null,

                    'statusType' =>
                        'not-created',

                    'title' =>
                        'This store is not available yet',

                    'message' =>
                        'The online store you are trying to visit has not been set up or is not currently available. Please check the link and try again later.',
                ]
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Storefront Setup
        |--------------------------------------------------------------------------
        */

        if (
            $storefront->status ===
            'Setup'
        ) {

            return view(
                'storefront.public.unavailable',
                [
                    'storefront' =>
                        $storefront,

                    'company' =>
                        $storefront->company,

                    'statusType' =>
                        'setup',

                    'title' =>
                        'We’re getting this store ready',

                    'message' =>
                        'This online store is currently being set up. Please check back soon.',
                ]
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Storefront Disabled
        |--------------------------------------------------------------------------
        */

        if (
            $storefront->status ===
            'Disabled'
        ) {

            return view(
                'storefront.public.unavailable',
                [
                    'storefront' =>
                        $storefront,

                    'company' =>
                        $storefront->company,

                    'statusType' =>
                        'disabled',

                    'title' =>
                        'Store temporarily unavailable',

                    'message' =>
                        'This online store is currently unavailable. Please check back later.',
                ]
            );

        }


        return null;

    }


    /**
     * |--------------------------------------------------------------------------
     * Get Head Office
     * |--------------------------------------------------------------------------
     *
     * Storefront inventory always comes from Head Office.
     */
    protected function getHeadOffice(
        int $companyId
    ): Branch {

        return Branch::query()
            ->where(
                'company_id',
                $companyId
            )
            ->where(
                'is_head_office',
                true
            )
            ->where(
                'status',
                true
            )
            ->firstOrFail();

    }


    /**
     * |--------------------------------------------------------------------------
     * Base Public Product Query
     * |--------------------------------------------------------------------------
     *
     * Products remain POS products.
     *
     * The Storefront only loads the stock record belonging
     * to the company's Head Office.
     */
    protected function productQuery(
        Storefront $storefront,
        Branch $headOffice
    ): Builder {

        return Product::query()
            ->forCompany(
                $storefront->company_id
            )
            ->active()
            ->with([
                'category',

                'stocks' =>
                    function (
                        $query
                    ) use (
                        $storefront,
                        $headOffice
                    ) {

                        $query
                            ->where(
                                'company_id',
                                $storefront
                                    ->company_id
                            )
                            ->where(
                                'branch_id',
                                $headOffice
                                    ->id
                            );

                    },
            ]);

    }


    /**
     * |--------------------------------------------------------------------------
     * Store Currency Symbol
     * |--------------------------------------------------------------------------
     */
    protected function currencySymbol(
        Storefront $storefront
    ): string {

        return
            $storefront
                ->company
                ->currency_symbol
            ?: '₦';

    }
}