@php

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


    $available =
        $tracksStock
            ? (float) (
                $stock?->available_quantity
                ?? 0
            )
            : null;


    $isAvailable =
        !$tracksStock
        ||
        $available > 0;


    $lowStock =
        $tracksStock
        &&
        $isAvailable
        &&
        $available <=
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

@endphp


<article class="marketplace-product-card">


    {{-- ========================================================
        IMAGE
    ========================================================= --}}

    <div class="marketplace-product-media">


        <a
            href="{{ $productUrl }}"
            class="marketplace-product-image"
        >

            <img
                src="{{ $product->imageUrl() }}"
                alt="{{ $product->name }}"
                loading="lazy"
            >

        </a>


        {{-- Availability --}}

        <div class="marketplace-product-status">


            @if(!$tracksStock)

                <span class="is-in">

                    Available

                </span>


            @elseif(!$isAvailable)

                <span class="is-out">

                    Sold out

                </span>


            @elseif($lowStock)

                <span class="is-low">

                    Low stock

                </span>


            @else

                <span class="is-in">

                    In stock

                </span>

            @endif

        </div>


        {{-- Quick open --}}

        <a
            href="{{ $productUrl }}"
            class="marketplace-product-view"
            aria-label="View {{ $product->name }}"
        >

            <i class="bi bi-arrow-up-right"></i>

        </a>

    </div>


    {{-- ========================================================
        INFORMATION
    ========================================================= --}}

    <div class="marketplace-product-body">


        <div class="marketplace-product-meta">


            @if($product->brand)

                <span class="marketplace-product-brand">

                    {{ $product->brand }}

                </span>


            @elseif($product->category)

                <span class="marketplace-product-brand">

                    {{ $product->category->name }}

                </span>


            @else

                <span class="marketplace-product-brand">

                    Product

                </span>

            @endif


            <small>

                {{ $product->product_code }}

            </small>

        </div>


        <h3 class="marketplace-product-name">

            <a href="{{ $productUrl }}">

                {{ $product->name }}

            </a>

        </h3>


        @if(
            $product->category
            &&
            $product->brand
        )

            <span class="marketplace-product-category">

                {{ $product->category->name }}

            </span>

        @endif


        {{-- Price --}}

        <div class="marketplace-product-price">

            <strong>

                {{ $currencySymbol }}{{ number_format(
                    (float)
                    $product->selling_price,
                    2
                ) }}

            </strong>

        </div>


        {{-- ====================================================
            ACTION
        ===================================================== --}}

        <div class="marketplace-product-actions">


            <a
                href="{{ $productUrl }}"
                class="marketplace-product-details"
            >

                Details

            </a>


            <button
                type="button"
                class="marketplace-product-add"

                data-cart-add

                data-product-id="{{ $product->id }}"

                data-product-code="{{ $product->product_code }}"

                data-product-name="{{ $product->name }}"

                data-product-price="{{ (float) $product->selling_price }}"

                data-product-image="{{ $product->imageUrl() }}"

                data-product-url="{{ $productUrl }}"

                data-product-tracks-stock="{{ $tracksStock ? '1' : '0' }}"

                data-product-stock="{{ $tracksStock
                    ? $available
                    : ''
                }}"

                @disabled(!$isAvailable)
            >


                @if($isAvailable)

                    <i class="bi bi-cart-plus"></i>

                    <span>
                        Add
                    </span>


                @else

                    <span>
                        Unavailable
                    </span>

                @endif

            </button>

        </div>

    </div>

</article>