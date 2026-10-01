@php

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


    $isLowStock =
        $tracksStock
        &&
        $available > 0
        &&
        $available <=
            (float) (
                $product->minimum_stock
                ?? 0
            );


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


<article class="shop-product">


    <a
        href="{{ $productUrl }}"
        class="shop-product-image"
    >

        <img
            src="{{ $product->imageUrl() }}"
            alt="{{ $product->name }}"
            loading="lazy"
        >


        @if(
            $tracksStock &&
            !$isAvailable
        )

            <span class="shop-product-status is-out">
                Sold out
            </span>

        @elseif($isLowStock)

            <span class="shop-product-status is-low">
                Low stock
            </span>

        @endif

    </a>


    <div class="shop-product-info">


        <div class="shop-product-info-main">


            @if($product->brand)

                <span class="shop-product-brand">
                    {{ $product->brand }}
                </span>

            @endif


            <h3>

                <a href="{{ $productUrl }}">
                    {{ $product->name }}
                </a>

            </h3>


            @if($product->category)

                <span class="shop-product-category">
                    {{ $product->category->name }}
                </span>

            @endif

        </div>


        <div class="shop-product-price">

            {{ $currencySymbol }}{{ number_format(
                (float) $product->selling_price,
                2
            ) }}

        </div>


        <div class="shop-product-action-row">


            <span
                class="
                    shop-product-availability
                    {{ $isAvailable
                        ? 'is-in'
                        : 'is-out'
                    }}
                "
            >

                @if(!$tracksStock)

                    Available to order

                @elseif($isAvailable)

                    Available

                @else

                    Unavailable

                @endif

            </span>


            <button
                type="button"
                class="shop-product-add"
                data-cart-add
                data-product-id="{{ $product->id }}"
                data-product-code="{{ $product->product_code }}"
                data-product-name="{{ $product->name }}"
                data-product-price="{{ (float) $product->selling_price }}"
                data-product-image="{{ $product->imageUrl() }}"
                data-product-url="{{ $productUrl }}"
                data-product-tracks-stock="{{ $tracksStock ? '1' : '0' }}"
                data-product-stock="{{ $tracksStock ? $available : '' }}"
                @disabled(!$isAvailable)
            >

                @if($isAvailable)

                    Add +

                @else

                    Sold out

                @endif

            </button>

        </div>


    </div>

</article>