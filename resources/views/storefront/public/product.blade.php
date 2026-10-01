@extends('storefront.public.layouts.app')


@section(
    'title',
    $product->name .
    ' | ' .
    $storefront->name
)


@section('content')


<section class="shop-product-page">

    <div class="shop-shell">


        <div class="shop-breadcrumb">

            <a
                href="{{ route(
                    'storefront.public.home',
                    $storefront->slug
                ) }}"
            >
                Home
            </a>


            @if($product->category)

                <span>/</span>

                <a
                    href="{{ route(
                        'storefront.public.category',
                        [
                            'storefrontSlug' =>
                                $storefront->slug,

                            'categoryCode' =>
                                $product->category->category_code,
                        ]
                    ) }}"
                >
                    {{ $product->category->name }}
                </a>

            @endif


            <span>/</span>

            <span>
                {{ $product->name }}
            </span>

        </div>


        <div class="shop-product-detail-grid">


            {{-- ============================================================
                PRODUCT GALLERY
            ============================================================= --}}

            @php

                /*
                |--------------------------------------------------------------------------
                | Gallery Images
                |--------------------------------------------------------------------------
                |
                | images() is already ordered by sort_order in the Product model.
                |
                */

                $galleryImages =
                    $product->images;


                /*
                |--------------------------------------------------------------------------
                | Primary Gallery Image
                |--------------------------------------------------------------------------
                */

                $primaryGalleryImage =
                    $galleryImages
                        ->firstWhere(
                            'is_primary',
                            true
                        )
                    ?? $galleryImages->first();


                /*
                |--------------------------------------------------------------------------
                | Initial Main Image
                |--------------------------------------------------------------------------
                |
                | Fall back to the existing Product image helper so legacy products
                | without relational gallery records still work normally.
                |
                */

                $mainImageUrl =
                    $primaryGalleryImage
                        ? asset(
                            'uploads/products/' .
                            $primaryGalleryImage->image
                        )
                        : $product->imageUrl();

            @endphp


            <div
                class="shop-product-detail-visual"
                data-product-gallery
            >

                {{-- MAIN IMAGE --}}

                <div class="shop-product-detail-image">

                    <img
                        id="storefrontProductMainImage"
                        src="{{ $mainImageUrl }}"
                        alt="{{ $product->name }}"
                    >

                </div>


                {{-- THUMBNAILS --}}

                @if($galleryImages->count() > 1)

                    <div
                        class="shop-product-gallery-thumbnails"
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
                                    $primaryGalleryImage &&
                                    $primaryGalleryImage->id ===
                                    $image->id;

                            @endphp


                            <button
                                type="button"
                                class="
                                    shop-product-gallery-thumbnail
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

            </div>


            {{-- Product Details --}}

            <div class="shop-product-detail-info">


                @if($product->brand)

                    <span class="shop-product-detail-brand">

                        {{ $product->brand }}

                    </span>

                @endif


                <h1>
                    {{ $product->name }}
                </h1>


                <div class="shop-product-code">

                    {{ $product->product_code }}

                    @if($product->sku)

                        <span>•</span>

                        SKU {{ $product->sku }}

                    @endif

                </div>


                <div class="shop-product-detail-price">

                    {{ $currencySymbol }}{{ number_format(
                        (float) $product->selling_price,
                        2
                    ) }}

                </div>


                {{-- ============================================================
                    PRODUCT AVAILABILITY
                ============================================================= --}}

                @php

                    /*
                    |--------------------------------------------------------------------------
                    | Stock Behaviour
                    |--------------------------------------------------------------------------
                    |
                    | Non-stock products such as services do not require a ProductStock
                    | record and therefore must not be treated as unavailable.
                    |
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

                @endphp


                <div
                    class="
                        shop-product-detail-stock
                        {{ $isAvailable
                            ? 'is-in'
                            : 'is-out'
                        }}
                    "
                >

                    <span></span>


                    @if(!$tracksStock)

                        Available to order

                    @elseif($isAvailable)

                        Available

                    @else

                        Currently unavailable

                    @endif

                </div>


                {{-- ============================================================
                    DESCRIPTION
                ============================================================= --}}

                @if($product->description)

                    <div class="shop-product-description">

                        {!! nl2br(
                            e(
                                $product->description
                            )
                        ) !!}

                    </div>

                @endif


                {{-- ============================================================
                    PURCHASE ACTION
                ============================================================= --}}

                @if($isAvailable)

                    <div class="shop-product-buy">


                        <div class="shop-product-quantity">

                            <button
                                type="button"
                                data-quantity-minus
                            >
                                −
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
                            >
                                +
                            </button>

                        </div>


                        <button
                            type="button"
                            class="shop-add-to-bag"

                            data-cart-add

                            data-product-id="{{ $product->id }}"

                            data-product-code="{{ $product->product_code }}"

                            data-product-name="{{ $product->name }}"

                            data-product-price="{{ (float) $product->selling_price }}"

                            data-product-image="{{ $product->imageUrl() }}"

                            data-product-url="{{ route(
                                'storefront.public.product',
                                [
                                    'storefrontSlug' =>
                                        $storefront->slug,

                                    'productCode' =>
                                        $product->product_code,
                                ]
                            ) }}"

                            data-product-tracks-stock="{{ $tracksStock ? '1' : '0' }}"

                            data-product-stock="{{ $tracksStock
                                ? $availableQuantity
                                : ''
                            }}"

                            data-quantity-source="productQuantity"
                        >
                            Add to bag
                        </button>

                    </div>


                @else

                    <button
                        type="button"
                        class="shop-add-to-bag"
                        disabled
                    >
                        Currently unavailable
                    </button>

                @endif


                {{-- ============================================================
                    PRODUCT ASSURANCE
                ============================================================= --}}

                <div class="shop-product-assurance">


                    <div>

                        <i class="bi bi-shield-check"></i>

                        <span>

                            <strong>
                                Secure checkout
                            </strong>

                            Protected ordering experience.

                        </span>

                    </div>


                    @if($tracksStock)

                        <div>

                            <i class="bi bi-box-seam"></i>

                            <span>

                                <strong>
                                    Live availability
                                </strong>

                                Availability reflects current store stock.

                            </span>

                        </div>

                    @else

                        <div>

                            <i class="bi bi-bag-check"></i>

                            <span>

                                <strong>
                                    Available to order
                                </strong>

                                This item can be ordered directly online.

                            </span>

                        </div>

                    @endif


                </div>


                <div class="shop-product-meta">


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


                </div>


            </div>

        </div>

    </div>

</section>


@if($relatedProducts->count())

<section class="shop-related">

    <div class="shop-shell">


        <div class="shop-section-heading shop-section-heading-line">

            <div>

                <span>
                    More to explore
                </span>

                <h2>
                    You may also like
                </h2>

            </div>

        </div>


        <div class="shop-product-grid">

            @foreach(
                $relatedProducts
                as $relatedProduct
            )

                @include(
                    'storefront.public.partials.product-card',
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