@php

    $stock =
        $product
            ->stocks
            ->first();

    $available =
        (float) (
            $stock?->available_quantity
            ?? 0
        );

    $inStock =
        $available > 0;

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


        @if(!$inStock)

            <span class="shop-product-status is-out">

                Sold out

            </span>

        @elseif(
            $available <=
            (float) $product->minimum_stock
        )

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
                data-product-stock="{{ $available }}"
                @disabled(!$inStock)
            >

                @if($inStock)

                    Add +

                @else

                    Sold out

                @endif

            </button>

        </div>


    </div>

</article>