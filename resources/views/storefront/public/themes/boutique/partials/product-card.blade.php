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


<article class="bq-card">


    {{-- IMAGE --}}

    <div class="bq-card__media">

        <a
            href="{{ $productUrl }}"
            class="bq-card__image"
        >

            <img
                src="{{ $product->imageUrl() }}"
                alt="{{ $product->name }}"
                loading="lazy"
            >

        </a>



        @if(
            $tracksStock
            &&
            !$isAvailable
        )

            <span class="bq-card__badge bq-card__badge--out">
                Sold out
            </span>

        @elseif($lowStock)

            <span class="bq-card__badge bq-card__badge--low">
                Low stock
            </span>

        @endif



        <button
            type="button"
            class="bq-card__quick-add"

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

            aria-label="Add {{ $product->name }} to bag"

            @disabled(!$isAvailable)
        >

            @if($isAvailable)

                <i class="bi bi-plus-lg"></i>

            @else

                <i class="bi bi-x-lg"></i>

            @endif

        </button>

    </div>



    {{-- INFORMATION --}}

    <div class="bq-card__body">


        <div class="bq-card__meta">

            @if($product->brand)

                <span>
                    {{ $product->brand }}
                </span>

            @elseif($product->category)

                <span>
                    {{ $product->category->name }}
                </span>

            @else

                <span>
                    {{ $storefront->name }}
                </span>

            @endif

        </div>



        <h3 class="bq-card__title">

            <a href="{{ $productUrl }}">
                {{ $product->name }}
            </a>

        </h3>



        <div class="bq-card__bottom">

            <strong class="bq-card__price">

                {{ $currencySymbol }}{{ number_format(
                    (float) $product->selling_price,
                    2
                ) }}

            </strong>


            <a
                href="{{ $productUrl }}"
                class="bq-card__view"
            >
                View
            </a>

        </div>

    </div>

</article>