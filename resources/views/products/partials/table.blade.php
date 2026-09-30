@php

    /*
    |--------------------------------------------------------------------------
    | Product Field Capabilities
    |--------------------------------------------------------------------------
    */

    $productFieldModes =
        $productFieldModes
        ?? [];


    $fieldVisible =
        fn (string $field) =>
            (
                $productFieldModes[$field]
                ?? 'optional'
            ) !== 'hidden';


    /*
    |--------------------------------------------------------------------------
    | Stock Behaviour
    |--------------------------------------------------------------------------
    */  

    $stockBranchId =
        $stockBranchId
        ?? null;


    /*
    |--------------------------------------------------------------------------
    | Dynamic Table Columns
    |--------------------------------------------------------------------------
    |
    | Product, Stock, Status and Action always exist.
    |
    */

    $tableColumnCount = 4;


    if (
        $fieldVisible(
            'product_category_id'
        )
    ) {
        $tableColumnCount++;
    }


    if (
        $fieldVisible(
            'cost_price'
        )
    ) {
        $tableColumnCount++;
    }


    if (
        $fieldVisible(
            'selling_price'
        )
    ) {
        $tableColumnCount++;
    }

@endphp


<div class="table-responsive product-table-wrapper">

    <table class="table product-table align-middle">


        {{-- =================================================
            TABLE HEADER
        ================================================= --}}

        <thead>

            <tr>

                <th>
                    Product
                </th>


                @if(
                    $fieldVisible(
                        'product_category_id'
                    )
                )

                    <th>
                        Category
                    </th>

                @endif


                @if(
                    $fieldVisible(
                        'cost_price'
                    )
                )

                    <th>
                        Cost Price
                    </th>

                @endif


                @if(
                    $fieldVisible(
                        'selling_price'
                    )
                )

                    <th>
                        Selling Price
                    </th>

                @endif


                <th>
                    Stock
                </th>


                <th>
                    Status
                </th>


                <th class="text-end">
                    Action
                </th>

            </tr>

        </thead>



        {{-- =================================================
            TABLE BODY
        ================================================= --}}

        <tbody>


            @forelse(
                $products as $product
            )

                @php

                    /*
                    |--------------------------------------------------------------------------
                    | Product Stock Behaviour
                    |--------------------------------------------------------------------------
                    */

                    $tracksStock =
                        $product->tracksStock();


                    /*
                    |--------------------------------------------------------------------------
                    | Scoped Stock
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

                    $minimumStock =
                        (float) (
                            $product->minimum_stock
                            ?? 0
                        );


                    $isOutOfStock =
                        $tracksStock
                        &&
                        $stock <= 0;


                    $isLowStock =
                        $tracksStock
                        &&
                        !$isOutOfStock
                        &&
                        $stock <=
                            $minimumStock;


                    /*
                    |--------------------------------------------------------------------------
                    | Stock Scope
                    |--------------------------------------------------------------------------
                    */

                    $stockScopeTitle =
                        $stockBranchId
                            ? 'Assigned branch stock'
                            : 'Company-wide stock';

                @endphp


                <tr>


                    {{-- =================================================
                        PRODUCT
                    ================================================= --}}

                    <td>

                        <div class="product-info">


                            @if(
                                $fieldVisible(
                                    'image'
                                )
                            )

                                <img
                                    src="{{ $product->imageUrl() }}"
                                    class="product-image"
                                    alt="{{ $product->name }}"
                                >

                            @endif


                            <div class="product-details">


                                <button
                                    type="button"
                                    class="product-name-btn"
                                    onclick="Products.openInspector(
                                        {{ $product->id }}
                                    )"
                                >
                                    {{ $product->name }}
                                </button>


                                <small>

                                    Code:
                                    {{ $product->product_code }}

                                </small>


                                @if(
                                    $fieldVisible(
                                        'sku'
                                    )
                                    &&
                                    $product->sku
                                )

                                    <small>

                                        SKU:
                                        {{ $product->sku }}

                                    </small>

                                @endif


                            </div>

                        </div>

                    </td>



                    {{-- =================================================
                        CATEGORY
                    ================================================= --}}

                    @if(
                        $fieldVisible(
                            'product_category_id'
                        )
                    )

                        <td>

                            <span class="product-category">

                                {{
                                    $product
                                        ->category
                                        ?->name
                                    ?? '-'
                                }}

                            </span>

                        </td>

                    @endif



                    {{-- =================================================
                        COST PRICE
                    ================================================= --}}

                    @if(
                        $fieldVisible(
                            'cost_price'
                        )
                    )

                        <td>

                            <strong class="product-price">

                                {{
                                    number_format(
                                        (float)
                                        $product
                                            ->cost_price,
                                        2
                                    )
                                }}

                            </strong>

                        </td>

                    @endif



                    {{-- =================================================
                        SELLING PRICE
                    ================================================= --}}

                    @if(
                        $fieldVisible(
                            'selling_price'
                        )
                    )

                        <td>

                            <strong class="product-price">

                                {{
                                    number_format(
                                        (float)
                                        $product
                                            ->selling_price,
                                        2
                                    )
                                }}

                            </strong>

                        </td>

                    @endif



                    {{-- =================================================
                        STOCK
                    ================================================= --}}

                    <td>

                        @if(!$tracksStock)

                            <div class="stock-wrapper">

                                <span>
                                    —
                                </span>

                                <span
                                    class="badge bg-secondary"
                                >
                                    Not tracked
                                </span>

                            </div>

                        @else

                            <div
                                class="stock-wrapper"
                                title="{{ $stockScopeTitle }}"
                            >

                                <span>

                                    {{
                                        number_format(
                                            $stock,
                                            2
                                        )
                                    }}

                                </span>


                                @if(
                                    $isOutOfStock
                                )

                                    <span
                                        class="badge stock-danger"
                                    >
                                        Out Of Stock
                                    </span>


                                @elseif(
                                    $isLowStock
                                )

                                    <span
                                        class="badge stock-warning"
                                    >
                                        Low Stock
                                    </span>


                                @else

                                    <span
                                        class="badge stock-success"
                                    >
                                        In Stock
                                    </span>

                                @endif

                            </div>

                        @endif

                    </td>



                    {{-- =================================================
                        STATUS
                    ================================================= --}}

                    <td>

                        @if(
                            $product->status
                        )

                            <span
                                class="badge status-active"
                            >
                                Active
                            </span>

                        @else

                            <span
                                class="badge status-inactive"
                            >
                                Inactive
                            </span>

                        @endif

                    </td>



                    {{-- =================================================
                        ACTIONS
                    ================================================= --}}

                    <td class="text-end">

                        <div class="dropdown">

                            <button
                                class="btn btn-sm action-btn"
                                type="button"
                                data-bs-toggle="dropdown"
                            >

                                <i
                                    class="bi bi-three-dots-vertical"
                                ></i>

                            </button>


                            <ul
                                class="dropdown-menu dropdown-menu-end"
                            >


                                {{-- View --}}

                                @permission('products.view')

                                    <li>

                                        <button
                                            type="button"
                                            class="dropdown-item"
                                            onclick="Products.openInspector(
                                                {{ $product->id }}
                                            )"
                                        >

                                            <i
                                                class="bi bi-eye me-2"
                                            ></i>

                                            View

                                        </button>

                                    </li>

                                @endpermission



                                {{-- Edit --}}

                                @permission('products.update')

                                    <li>

                                        <button
                                            type="button"
                                            class="dropdown-item"
                                            onclick="Products.edit(
                                                {{ $product->id }}
                                            )"
                                        >

                                            <i
                                                class="bi bi-pencil me-2"
                                            ></i>

                                            Edit

                                        </button>

                                    </li>

                                @endpermission



                                {{-- Storefront Actions --}}

                                @if(
                                    $storefront
                                    &&
                                    $product->status
                                )

                                    @php

                                        $productUrl =
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
                                            );

                                    @endphp


                                    <li>

                                        <a
                                            class="dropdown-item"
                                            href="{{ $productUrl }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >

                                            <i
                                                class="bi bi-box-arrow-up-right me-2"
                                            ></i>

                                            View Online

                                        </a>

                                    </li>


                                    <li>

                                        <button
                                            type="button"
                                            class="dropdown-item"
                                            onclick="Products.copyProductLink(
                                                @js($productUrl)
                                            )"
                                        >

                                            <i
                                                class="bi bi-link-45deg me-2"
                                            ></i>

                                            Copy Product Link

                                        </button>

                                    </li>

                                @endif



                                {{-- Enable / Disable --}}

                                @permission('products.update')

                                    <li>

                                        <button
                                            type="button"
                                            class="dropdown-item"
                                            onclick="Products.openStatusModal(
                                                {{ $product->id }},
                                                {{
                                                    $product->status
                                                        ? 'true'
                                                        : 'false'
                                                }}
                                            )"
                                        >

                                            <i
                                                class="bi bi-toggle-on me-2"
                                            ></i>

                                            {{
                                                $product->status
                                                    ? 'Disable'
                                                    : 'Enable'
                                            }}

                                        </button>

                                    </li>

                                @endpermission



                                {{-- Delete --}}

                                @permission('products.delete')

                                    <li>

                                        <hr
                                            class="dropdown-divider"
                                        >

                                    </li>


                                    <li>

                                        <button
                                            type="button"
                                            class="dropdown-item text-danger"
                                            onclick="Products.openDeleteModal(
                                                {{ $product->id }}
                                            )"
                                        >

                                            <i
                                                class="bi bi-trash me-2"
                                            ></i>

                                            Delete

                                        </button>

                                    </li>

                                @endpermission


                            </ul>

                        </div>

                    </td>


                </tr>


            @empty


                {{-- =================================================
                    EMPTY STATE
                ================================================= --}}

                <tr>

                    <td
                        colspan="{{ $tableColumnCount }}"
                    >

                        <div class="product-empty-state">

                            <i
                                class="bi bi-box-seam"
                            ></i>

                            <h5>
                                No products found
                            </h5>

                            <p>
                                Start by creating your first product.
                            </p>

                        </div>

                    </td>

                </tr>


            @endforelse


        </tbody>

    </table>

</div>



{{-- =================================================
    PAGINATION
================================================= --}}

@if(
    $products instanceof
    \Illuminate\Pagination\LengthAwarePaginator
)

    <div class="product-pagination">

        {{ $products->links() }}

    </div>

@endif