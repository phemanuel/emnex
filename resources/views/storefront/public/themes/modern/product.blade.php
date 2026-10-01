@extends(
    'storefront.public.themes.modern.layout'
)


@section(
    'title',
    $product->name .
    ' | ' .
    $storefront->name
)


@php

    /*
    |--------------------------------------------------------------------------
    | Product URL
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | Stock Behaviour
    |--------------------------------------------------------------------------
    */

    $tracksStock =
        $product->tracksStock();


    $isAvailable =
        !$tracksStock
        ||
        (
            $availableQuantity !== null
            &&
            $availableQuantity > 0
        );


    $lowStock =
        $tracksStock
        &&
        $isAvailable
        &&
        $availableQuantity <=
            (float) (
                $product->minimum_stock
                ?? 0
            );


    /*
    |--------------------------------------------------------------------------
    | Product Gallery
    |--------------------------------------------------------------------------
    */

    $galleryImages =
        $product->images;


    $primaryGalleryImage =
        $galleryImages
            ->firstWhere(
                'is_primary',
                true
            )
        ?? $galleryImages->first();


    $mainImageUrl =
        $primaryGalleryImage
            ? asset(
                'uploads/products/' .
                $primaryGalleryImage->image
            )
            : $product->imageUrl();


    $galleryCount =
        $galleryImages->count();

@endphp


@section('content')


{{-- ============================================================
    PRODUCT PAGE
============================================================= --}}

<section class="modern-product-page">

    <div class="modern-container">


        {{-- Breadcrumb --}}

        <div class="modern-breadcrumb">

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


        {{-- ====================================================
            MAIN PRODUCT AREA
        ===================================================== --}}

        <div class="modern-product-detail">


            {{-- ================================================
                PRODUCT VISUAL
            ================================================= --}}

            <div
                class="modern-product-gallery"
                data-product-gallery
            >


                <div class="modern-product-main-image">


                    {{-- Availability Badge --}}

                    <div class="modern-product-image-status">

                        @if(!$tracksStock)

                            <span class="is-in">

                                <i class="bi bi-check-circle"></i>

                                Available

                            </span>

                        @elseif(!$isAvailable)

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
                        id="storefrontProductMainImage"
                        src="{{ $mainImageUrl }}"
                        alt="{{ $product->name }}"
                    >

                </div>


                {{-- ============================================
                    THUMBNAILS
                ============================================= --}}

                @if($galleryCount > 1)

                    <div
                        class="modern-product-gallery-thumbnails"
                        aria-label="Product images"
                    >

                        @foreach($galleryImages as $image)

                            @php

                                $imageUrl =
                                    asset(
                                        'uploads/products/' .
                                        $image->image
                                    );


                                $isActive =
                                    $primaryGalleryImage
                                    &&
                                    $primaryGalleryImage->id ===
                                        $image->id;

                            @endphp


                            <button
                                type="button"
                                class="
                                    modern-product-gallery-thumbnail

                                    {{ $isActive
                                        ? 'is-active'
                                        : ''
                                    }}
                                "
                                data-product-gallery-thumb
                                data-image="{{ $imageUrl }}"
                                data-image-alt="{{ $product->name }}"
                                aria-label="View image {{ $loop->iteration }}"
                                aria-pressed="{{ $isActive ? 'true' : 'false' }}"
                            >

                                <img
                                    src="{{ $imageUrl }}"
                                    alt=""
                                    loading="lazy"
                                >

                            </button>

                        @endforeach

                    </div>

                @endif


                {{-- Image Footer --}}

                <div class="modern-product-image-footer">

                    <span>

                        <i class="bi bi-images"></i>

                        {{ $galleryCount > 1
                            ? $galleryCount . ' product images'
                            : 'Product image'
                        }}

                    </span>


                    <span>

                        {{ $product->product_code }}

                    </span>

                </div>

            </div>


            {{-- ================================================
                PURCHASE PANEL
            ================================================= --}}

            <div class="modern-product-purchase-panel">


                {{-- Product Identity --}}

                <div class="modern-product-heading">


                    @if($product->brand)

                        <span class="modern-product-brand">

                            {{ $product->brand }}

                        </span>

                    @elseif($product->category)

                        <span class="modern-product-brand">

                            {{ $product->category->name }}

                        </span>

                    @endif


                    <h1>
                        {{ $product->name }}
                    </h1>


                    <div class="modern-product-reference">


                        <span>

                            Product code

                            <strong>
                                {{ $product->product_code }}
                            </strong>

                        </span>


                        @if($product->sku)

                            <span class="modern-product-reference-divider">
                                •
                            </span>


                            <span>

                                SKU

                                <strong>
                                    {{ $product->sku }}
                                </strong>

                            </span>

                        @endif

                    </div>

                </div>


                {{-- Price --}}

                <div class="modern-product-price-block">

                    <span>
                        Price
                    </span>

                    <strong>

                        {{ $currencySymbol }}{{ number_format(
                            (float) $product->selling_price,
                            2
                        ) }}

                    </strong>

                </div>


                {{-- ============================================
                    AVAILABILITY
                ============================================= --}}

                <div
                    class="
                        modern-product-stock-box

                        @if(!$tracksStock)
                            is-in
                        @elseif(!$isAvailable)
                            is-out
                        @elseif($lowStock)
                            is-low
                        @else
                            is-in
                        @endif
                    "
                >

                    <span class="modern-product-stock-icon">

                        @if(!$tracksStock)

                            <i class="bi bi-check-lg"></i>

                        @elseif(!$isAvailable)

                            <i class="bi bi-x-lg"></i>

                        @elseif($lowStock)

                            <i class="bi bi-exclamation-lg"></i>

                        @else

                            <i class="bi bi-check-lg"></i>

                        @endif

                    </span>


                    <div>

                        <strong>

                            @if(!$tracksStock)

                                Available to order

                            @elseif(!$isAvailable)

                                Currently unavailable

                            @elseif($lowStock)

                                Limited stock available

                            @else

                                Available to order

                            @endif

                        </strong>


                        <p>

                            @if(!$tracksStock)

                                This item can be ordered directly online.

                            @elseif(!$isAvailable)

                                This product cannot currently
                                be added to your cart.

                            @elseif($lowStock)

                                Only a limited quantity is
                                currently available online.

                            @else

                                This product is currently
                                available for online ordering.

                            @endif

                        </p>

                    </div>

                </div>


                {{-- Short Description --}}

                @if($product->description)

                    <div class="modern-product-intro">

                        <p>

                            {{ \Illuminate\Support\Str::limit(
                                $product->description,
                                220
                            ) }}

                        </p>

                    </div>

                @endif


                {{-- ============================================
                    BUY AREA
                ============================================= --}}

                @if($isAvailable)

                    <div class="modern-product-buy-box">


                        <div class="modern-product-quantity-block">

                            <label for="productQuantity">
                                Quantity
                            </label>


                            <div class="modern-product-quantity">

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

                                    @if($tracksStock)
                                        max="{{ $availableQuantity }}"
                                    @endif
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


                        <button
                            type="button"
                            class="modern-product-add-to-cart"

                            data-cart-add

                            data-product-id="{{ $product->id }}"

                            data-product-code="{{ $product->product_code }}"

                            data-product-name="{{ $product->name }}"

                            data-product-price="{{ (float) $product->selling_price }}"

                            data-product-image="{{ $product->imageUrl() }}"

                            data-product-url="{{ $productUrl }}"

                            data-product-tracks-stock="{{ $tracksStock ? '1' : '0' }}"

                            data-product-stock="{{ $tracksStock
                                ? $availableQuantity
                                : ''
                            }}"

                            data-quantity-source="productQuantity"
                        >

                            <span class="modern-product-add-icon">

                                <i class="bi bi-bag-plus"></i>

                            </span>


                            <span>

                                <small>
                                    Add to cart
                                </small>

                                <strong>

                                    {{ $currencySymbol }}{{ number_format(
                                        (float) $product->selling_price,
                                        2
                                    ) }}

                                </strong>

                            </span>


                            <i class="bi bi-arrow-right"></i>

                        </button>

                    </div>


                @else

                    <button
                        type="button"
                        class="
                            modern-product-add-to-cart
                            is-disabled
                        "
                        disabled
                    >

                        <span class="modern-product-add-icon">

                            <i class="bi bi-bag-x"></i>

                        </span>


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


                {{-- ============================================
                    SHOPPING ASSURANCES
                ============================================= --}}

                <div class="modern-product-assurances">


                    <div>

                        <span>

                            <i class="bi bi-shield-lock"></i>

                        </span>


                        <div>

                            <strong>
                                Secure checkout
                            </strong>

                            <small>
                                Protected payment process
                            </small>

                        </div>

                    </div>


                    @if($tracksStock)

                        <div>

                            <span>

                                <i class="bi bi-box-seam"></i>

                            </span>


                            <div>

                                <strong>
                                    Live inventory
                                </strong>

                                <small>
                                    Current online availability
                                </small>

                            </div>

                        </div>

                    @else

                        <div>

                            <span>

                                <i class="bi bi-bag-check"></i>

                            </span>


                            <div>

                                <strong>
                                    Available to order
                                </strong>

                                <small>
                                    Order directly through the store
                                </small>

                            </div>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</section>


{{-- ============================================================
    PRODUCT INFORMATION
============================================================= --}}

<section class="modern-product-information">

    <div class="modern-container">

        <div class="modern-product-information-grid">


            {{-- ================================================
                DESCRIPTION
            ================================================= --}}

            <div class="modern-product-description-card">


                <div class="modern-product-section-title">

                    <span>
                        Product information
                    </span>

                    <h2>
                        About this product
                    </h2>

                </div>


                @if($product->description)

                    <div class="modern-product-description-text">

                        {!! nl2br(
                            e(
                                $product->description
                            )
                        ) !!}

                    </div>


                @else

                    <div class="modern-product-description-empty">

                        <i class="bi bi-file-text"></i>

                        <p>

                            No additional description has
                            been provided for this product.

                        </p>

                    </div>

                @endif

            </div>


            {{-- ================================================
                PRODUCT DETAILS
            ================================================= --}}

            <aside class="modern-product-spec-card">


                <div class="modern-product-section-title">

                    <span>
                        Details
                    </span>

                    <h2>
                        Product details
                    </h2>

                </div>


                <div class="modern-product-spec-list">


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
                                modern-product-spec-stock

                                {{ $isAvailable
                                    ? 'is-in'
                                    : 'is-out'
                                }}
                            "
                        >

                            @if(!$tracksStock)

                                Available to order

                            @elseif($isAvailable)

                                In stock

                            @else

                                Unavailable

                            @endif

                        </strong>

                    </div>

                </div>

            </aside>

        </div>

    </div>

</section>


{{-- ============================================================
    SHOPPING SUPPORT STRIP
============================================================= --}}

<section class="modern-product-support">

    <div class="modern-container">

        <div class="modern-product-support-grid">


            <div class="modern-product-support-item">

                <span>

                    <i class="bi bi-search"></i>

                </span>


                <div>

                    <strong>
                        Browse easily
                    </strong>

                    <p>
                        Search the store and quickly find
                        what you need.
                    </p>

                </div>

            </div>


            <div class="modern-product-support-item">

                <span>

                    <i class="bi bi-bag-check"></i>

                </span>


                <div>

                    <strong>
                        Build your cart
                    </strong>

                    <p>
                        Add available items and adjust
                        quantities before checkout.
                    </p>

                </div>

            </div>


            <div class="modern-product-support-item">

                <span>

                    <i class="bi bi-credit-card"></i>

                </span>


                <div>

                    <strong>
                        Checkout securely
                    </strong>

                    <p>
                        Complete your order through the
                        secure online checkout.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>


{{-- ============================================================
    RELATED PRODUCTS
============================================================= --}}

@if($relatedProducts->count())

    <section class="modern-related-products">

        <div class="modern-container">


            <div class="modern-home-section-head">

                <div>

                    <span>
                        Keep browsing
                    </span>

                    <h2>
                        You may also like
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


            <div class="modern-product-grid">

                @foreach(
                    $relatedProducts
                    as $relatedProduct
                )

                    @include(
                        'storefront.public.themes.modern.partials.product-card',
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