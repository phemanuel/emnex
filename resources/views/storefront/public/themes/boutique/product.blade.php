@extends(
    'storefront.public.themes.boutique.layout'
)


@section(
    'title',
    $product->name .
    ' | ' .
    $storefront->name
)


@section('content')


@php

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



<section class="bq-product-page">

    <div class="bq-shell">


        {{-- BREADCRUMB --}}

        <div class="bq-breadcrumb">

            <a
                href="{{ route(
                    'storefront.public.home',
                    $storefront->slug
                ) }}"
            >
                Home
            </a>


            @if($product->category)

                <i class="bi bi-chevron-right"></i>

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


            <i class="bi bi-chevron-right"></i>

            <span>
                {{ $product->name }}
            </span>

        </div>



        {{-- PRODUCT --}}

        <div class="bq-product">


            {{-- IMAGE --}}

            <div
                class="bq-product__visual"
                data-product-gallery
            >

                <div class="bq-product__image">

                    <img
                        id="storefrontProductMainImage"
                        src="{{ $mainImageUrl }}"
                        alt="{{ $product->name }}"
                    >


                    @if(
                        $tracksStock
                        &&
                        !$isAvailable
                    )

                        <span class="bq-product__badge bq-product__badge--out">
                            Sold out
                        </span>

                    @elseif($lowStock)

                        <span class="bq-product__badge bq-product__badge--low">
                            Low stock
                        </span>

                    @endif

                </div>


                {{-- GALLERY THUMBNAILS --}}

                @if($galleryCount > 1)

                    <div
                        class="bq-product__thumbnails"
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
                                    bq-product__thumbnail

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



            {{-- INFORMATION --}}

            <div class="bq-product__content">


                <div class="bq-product__header">


                    @if($product->brand)

                        <span class="bq-product__brand">
                            {{ $product->brand }}
                        </span>

                    @elseif($product->category)

                        <span class="bq-product__brand">
                            {{ $product->category->name }}
                        </span>

                    @endif


                    <h1>
                        {{ $product->name }}
                    </h1>


                    <div class="bq-product__code">

                        <span>
                            {{ $product->product_code }}
                        </span>

                        @if($product->sku)

                            <span>
                                SKU {{ $product->sku }}
                            </span>

                        @endif

                    </div>


                    <div class="bq-product__price">

                        {{ $currencySymbol }}{{ number_format(
                            (float) $product->selling_price,
                            2
                        ) }}

                    </div>

                </div>



                {{-- STOCK / AVAILABILITY --}}

                <div
                    class="
                        bq-product__stock

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



                {{-- DESCRIPTION --}}

                @if($product->description)

                    <div class="bq-product__description">

                        {!! nl2br(
                            e(
                                $product->description
                            )
                        ) !!}

                    </div>

                @endif



                {{-- PURCHASE --}}

                <div class="bq-product__buy">


                    @if($isAvailable)

                        <div class="bq-product__buy-row">


                            <div class="bq-product__quantity">

                                <button
                                    type="button"
                                    data-quantity-minus
                                    aria-label="Decrease quantity"
                                >
                                    <i class="bi bi-dash"></i>
                                </button>


                                <input
                                    type="number"
                                    id="productQuantity"
                                    value="1"
                                    min="1"

                                    @if($tracksStock)
                                        max="{{ $availableQuantity }}"
                                    @endif

                                    inputmode="numeric"
                                    aria-label="Quantity"
                                >


                                <button
                                    type="button"
                                    data-quantity-plus
                                    aria-label="Increase quantity"
                                >
                                    <i class="bi bi-plus"></i>
                                </button>

                            </div>



                            <button
                                type="button"
                                class="bq-product__add"

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

                                Add to bag

                                <i class="bi bi-bag-plus"></i>

                            </button>

                        </div>


                    @else

                        <button
                            type="button"
                            class="bq-product__add"
                            disabled
                        >
                            Currently unavailable
                        </button>

                    @endif

                </div>



                {{-- SERVICE POINTS --}}

                <div class="bq-product__services">

                    <div>

                        <i class="bi bi-shield-check"></i>

                        <span>

                            <strong>
                                Secure checkout
                            </strong>

                            Pay securely online.

                        </span>

                    </div>


                    @if($tracksStock)

                        <div>

                            <i class="bi bi-bag-check"></i>

                            <span>

                                <strong>
                                    Current availability
                                </strong>

                                Stock is checked again at checkout.

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



                {{-- DETAILS --}}

                @if(
                    $product->category ||
                    $product->brand ||
                    $product->manufacturer
                )

                    <div class="bq-product__details">

                        <h2>
                            Product details
                        </h2>


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
                                                $product->category->category_code,
                                        ]
                                    ) }}"
                                >
                                    {{ $product->category->name }}
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

                    </div>

                @endif

            </div>

        </div>

    </div>

</section>



{{-- RELATED PRODUCTS --}}

@if($relatedProducts->count())

    <section class="bq-related">

        <div class="bq-shell">


            <div class="bq-section-heading">

                <div>

                    <span class="bq-eyebrow">
                        You may also like
                    </span>

                    <h2>
                        More to explore
                    </h2>

                </div>

            </div>



            <div class="bq-product-grid">

                @foreach(
                    $relatedProducts
                    as $relatedProduct
                )

                    @include(
                        'storefront.public.themes.boutique.partials.product-card',
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