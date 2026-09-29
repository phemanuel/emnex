@extends(
    'storefront.public.themes.marketplace.layout'
)


@section(
    'title',
    $product->name .
    ' | ' .
    $storefront->name
)


@php

    $inStock =
        $availableQuantity > 0;


    $lowStock =
        $inStock
        &&
        $availableQuantity <=
            (float) $product->minimum_stock;


    $productUrl =
        route(
            'storefront.public.product',
            [
                'storefrontSlug' =>
                    $storefront->slug,

                'productCode' =>
                    $product->product_code,
            ]
        );

@endphp


@section('content')


{{-- ============================================================
    BREADCRUMB
============================================================= --}}

<section class="marketplace-product-breadcrumb-section">

    <div class="marketplace-container">

        <div class="marketplace-breadcrumb">

            <a
                href="{{ route(
                    'storefront.public.home',
                    $storefront->slug
                ) }}"
            >
                Home
            </a>


            <i class="bi bi-chevron-right"></i>


            @if($product->category)

                <a
                    href="{{ route(
                        'storefront.public.category',
                        [
                            'storefrontSlug' =>
                                $storefront->slug,

                            'categoryCode' =>
                                $product
                                    ->category
                                    ->category_code,
                        ]
                    ) }}"
                >
                    {{ $product->category->name }}
                </a>


                <i class="bi bi-chevron-right"></i>

            @endif


            <span>
                {{ $product->name }}
            </span>

        </div>

    </div>

</section>



{{-- ============================================================
    PRODUCT MAIN
============================================================= --}}

<section class="marketplace-product-page">

    <div class="marketplace-container">

        <div class="marketplace-product-layout">


            {{-- =================================================
                IMAGE PANEL
            ================================================== --}}

            <div class="marketplace-product-gallery">


                <div class="marketplace-product-image-panel">


                    <div class="marketplace-product-image-status">


                        @if(!$inStock)

                            <span class="is-out">

                                <i class="bi bi-x-circle"></i>

                                Sold out

                            </span>


                        @elseif($lowStock)

                            <span class="is-low">

                                <i class="bi bi-exclamation-circle"></i>

                                Low stock

                            </span>


                        @else

                            <span class="is-in">

                                <i class="bi bi-check-circle"></i>

                                In stock

                            </span>

                        @endif

                    </div>



                    <img
                        src="{{ $product->imageUrl() }}"
                        alt="{{ $product->name }}"
                    >

                </div>



                <div class="marketplace-product-image-footer">


                    <span>

                        <i class="bi bi-image"></i>

                        Product image

                    </span>


                    <span>
                        {{ $product->product_code }}
                    </span>

                </div>

            </div>



            {{-- =================================================
                PRODUCT INFORMATION
            ================================================== --}}

            <div class="marketplace-product-info">


                <div class="marketplace-product-info-top">


                    @if($product->brand)

                        <span class="marketplace-product-brand-label">
                            {{ $product->brand }}
                        </span>

                    @elseif($product->category)

                        <span class="marketplace-product-brand-label">
                            {{ $product->category->name }}
                        </span>

                    @endif



                    <h1>
                        {{ $product->name }}
                    </h1>



                    <div class="marketplace-product-identifiers">


                        <span>

                            Code:

                            <strong>
                                {{ $product->product_code }}
                            </strong>

                        </span>


                        @if($product->sku)

                            <span>

                                SKU:

                                <strong>
                                    {{ $product->sku }}
                                </strong>

                            </span>

                        @endif

                    </div>

                </div>



                {{-- Price --}}

                <div class="marketplace-product-price-block">

                    <small>
                        Price
                    </small>


                    <strong>

                        {{ $currencySymbol }}{{ number_format(
                            (float) $product->selling_price,
                            2
                        ) }}

                    </strong>

                </div>



                {{-- Availability --}}

                <div
                    class="
                        marketplace-product-availability

                        {{ !$inStock
                            ? 'is-out'
                            : (
                                $lowStock
                                    ? 'is-low'
                                    : 'is-in'
                            )
                        }}
                    "
                >

                    <span>

                        @if(!$inStock)

                            <i class="bi bi-x-lg"></i>

                        @elseif($lowStock)

                            <i class="bi bi-exclamation-lg"></i>

                        @else

                            <i class="bi bi-check-lg"></i>

                        @endif

                    </span>


                    <div>


                        <strong>

                            @if(!$inStock)

                                Currently unavailable

                            @elseif($lowStock)

                                Limited quantity available

                            @else

                                Available online

                            @endif

                        </strong>


                        <small>

                            @if(!$inStock)

                                This item cannot currently
                                be added to your cart.

                            @elseif($lowStock)

                                Stock is currently limited.

                            @else

                                Ready to add to your cart.

                            @endif

                        </small>

                    </div>

                </div>



                {{-- Description Preview --}}

                @if($product->description)

                    <div class="marketplace-product-description-preview">

                        <p>

                            {{ \Illuminate\Support\Str::limit(
                                $product->description,
                                250
                            ) }}

                        </p>

                    </div>

                @endif



                {{-- Product Metadata --}}

                <div class="marketplace-product-meta-table">


                    @if($product->category)

                        <div>

                            <span>
                                Category
                            </span>


                            <a
                                href="{{ route(
                                    'storefront.public.category',
                                    [
                                        'storefrontSlug' =>
                                            $storefront->slug,

                                        'categoryCode' =>
                                            $product
                                                ->category
                                                ->category_code,
                                    ]
                                ) }}"
                            >

                                {{ $product->category->name }}

                                <i class="bi bi-arrow-up-right"></i>

                            </a>

                        </div>

                    @endif



                    @if($product->brand)

                        <div>

                            <span>
                                Brand
                            </span>

                            <strong>
                                {{ $product->brand }}
                            </strong>

                        </div>

                    @endif



                    @if($product->manufacturer)

                        <div>

                            <span>
                                Manufacturer
                            </span>

                            <strong>
                                {{ $product->manufacturer }}
                            </strong>

                        </div>

                    @endif



                    <div>

                        <span>
                            Availability
                        </span>


                        <strong
                            class="
                                {{ $inStock
                                    ? 'is-in'
                                    : 'is-out'
                                }}
                            "
                        >

                            {{ $inStock
                                ? 'In stock'
                                : 'Unavailable'
                            }}

                        </strong>

                    </div>

                </div>

            </div>



            {{-- =================================================
                BUY BOX
            ================================================== --}}

            <aside class="marketplace-product-buy-box">


                <span class="marketplace-buy-box-label">
                    Order this product
                </span>


                <div class="marketplace-buy-box-price">

                    <small>
                        Price
                    </small>


                    <strong>

                        {{ $currencySymbol }}{{ number_format(
                            (float) $product->selling_price,
                            2
                        ) }}

                    </strong>

                </div>



                @if($inStock)


                    <div class="marketplace-buy-stock is-in">

                        <i class="bi bi-check-circle-fill"></i>

                        <span>

                            <strong>
                                In stock
                            </strong>

                            Available for online ordering

                        </span>

                    </div>



                    {{-- Quantity --}}

                    <div class="marketplace-buy-quantity">


                        <label for="productQuantity">
                            Quantity
                        </label>


                        <div class="marketplace-buy-quantity-control">


                            <button
                                type="button"
                                data-quantity-minus
                                aria-label="Decrease quantity"
                            >

                                <i class="bi bi-dash-lg"></i>

                            </button>



                            <input
                                type="number"
                                id="productQuantity"
                                value="1"
                                min="1"
                                max="{{ $availableQuantity }}"
                            >



                            <button
                                type="button"
                                data-quantity-plus
                                aria-label="Increase quantity"
                            >

                                <i class="bi bi-plus-lg"></i>

                            </button>

                        </div>

                    </div>



                    {{-- Add to cart --}}

                    <button
                        type="button"
                        class="marketplace-buy-button"

                        data-cart-add

                        data-product-id="{{ $product->id }}"

                        data-product-code="{{ $product->product_code }}"

                        data-product-name="{{ $product->name }}"

                        data-product-price="{{ (float) $product->selling_price }}"

                        data-product-image="{{ $product->imageUrl() }}"

                        data-product-url="{{ $productUrl }}"

                        data-product-stock="{{ $availableQuantity }}"

                        data-quantity-source="productQuantity"
                    >

                        <i class="bi bi-cart-plus"></i>


                        <span>

                            <small>
                                Add to cart
                            </small>

                            <strong>
                                Add item
                            </strong>

                        </span>


                        <i class="bi bi-arrow-right"></i>

                    </button>


                @else


                    <div class="marketplace-buy-stock is-out">

                        <i class="bi bi-x-circle-fill"></i>

                        <span>

                            <strong>
                                Sold out
                            </strong>

                            Currently unavailable online

                        </span>

                    </div>



                    <button
                        type="button"
                        class="
                            marketplace-buy-button
                            is-disabled
                        "
                        disabled
                    >

                        <i class="bi bi-cart-x"></i>


                        <span>

                            <small>
                                Product unavailable
                            </small>

                            <strong>
                                Sold out
                            </strong>

                        </span>

                    </button>

                @endif



                {{-- Shopping reassurance --}}

                <div class="marketplace-buy-benefits">


                    <div>

                        <i class="bi bi-shield-check"></i>

                        <span>

                            <strong>
                                Secure checkout
                            </strong>

                            Protected online ordering

                        </span>

                    </div>



                    <div>

                        <i class="bi bi-box-seam"></i>

                        <span>

                            <strong>
                                Live availability
                            </strong>

                            Current online stock

                        </span>

                    </div>



                    <div>

                        <i class="bi bi-credit-card"></i>

                        <span>

                            <strong>
                                Online payment
                            </strong>

                            Secure payment process

                        </span>

                    </div>

                </div>

            </aside>

        </div>

    </div>

</section>



{{-- ============================================================
    PRODUCT DETAILS
============================================================= --}}

<section class="marketplace-product-details">

    <div class="marketplace-container">

        <div class="marketplace-product-details-grid">


            {{-- Description --}}

            <div class="marketplace-product-details-card">


                <div class="marketplace-details-heading">

                    <span>
                        Product information
                    </span>

                    <h2>
                        Description
                    </h2>

                </div>


                @if($product->description)

                    <div class="marketplace-product-description">

                        {!! nl2br(
                            e(
                                $product->description
                            )
                        ) !!}

                    </div>


                @else

                    <div class="marketplace-details-empty">

                        <i class="bi bi-file-text"></i>

                        <span>
                            No additional description
                            has been provided.
                        </span>

                    </div>

                @endif

            </div>



            {{-- Specifications --}}

            <aside class="marketplace-product-specifications">


                <div class="marketplace-details-heading">

                    <span>
                        Product data
                    </span>

                    <h2>
                        Details
                    </h2>

                </div>



                <div class="marketplace-specification-list">


                    <div>

                        <span>
                            Product code
                        </span>

                        <strong>
                            {{ $product->product_code }}
                        </strong>

                    </div>



                    @if($product->sku)

                        <div>

                            <span>
                                SKU
                            </span>

                            <strong>
                                {{ $product->sku }}
                            </strong>

                        </div>

                    @endif



                    @if($product->category)

                        <div>

                            <span>
                                Category
                            </span>

                            <strong>
                                {{ $product->category->name }}
                            </strong>

                        </div>

                    @endif



                    @if($product->brand)

                        <div>

                            <span>
                                Brand
                            </span>

                            <strong>
                                {{ $product->brand }}
                            </strong>

                        </div>

                    @endif



                    @if($product->manufacturer)

                        <div>

                            <span>
                                Manufacturer
                            </span>

                            <strong>
                                {{ $product->manufacturer }}
                            </strong>

                        </div>

                    @endif



                    <div>

                        <span>
                            Stock status
                        </span>


                        <strong
                            class="
                                marketplace-spec-stock

                                {{ $inStock
                                    ? 'is-in'
                                    : 'is-out'
                                }}
                            "
                        >

                            {{ $inStock
                                ? 'Available'
                                : 'Unavailable'
                            }}

                        </strong>

                    </div>

                </div>

            </aside>

        </div>

    </div>

</section>



{{-- ============================================================
    RELATED PRODUCTS
============================================================= --}}

@if($relatedProducts->count())

<section class="marketplace-related-products">

    <div class="marketplace-container">


        <div class="marketplace-section-heading">


            <div>

                <span>
                    More in this department
                </span>

                <h2>
                    Related products
                </h2>

            </div>


            @if($product->category)

                <a
                    href="{{ route(
                        'storefront.public.category',
                        [
                            'storefrontSlug' =>
                                $storefront->slug,

                            'categoryCode' =>
                                $product
                                    ->category
                                    ->category_code,
                        ]
                    ) }}"
                >

                    View category

                    <i class="bi bi-arrow-right"></i>

                </a>

            @endif

        </div>



        <div class="marketplace-product-grid">

            @foreach(
                $relatedProducts
                as $relatedProduct
            )

                @include(
                    'storefront.public.themes.marketplace.partials.product-card',
                    [
                        'product' =>
                            $relatedProduct,

                        'storefront' =>
                            $storefront,

                        'currencySymbol' =>
                            $currencySymbol,
                    ]
                )

            @endforeach

        </div>

    </div>

</section>

@endif


@endsection