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

    $lowStock =
        $inStock
        &&
        $available <=
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


<article class="modern-product-card">


    {{-- Product Image --}}

    <div class="modern-product-media">

        <a
            href="{{ $productUrl }}"
            class="modern-product-image"
        >

            <img
                src="{{ $product->imageUrl() }}"
                alt="{{ $product->name }}"
                loading="lazy"
            >

        </a>



        {{-- Status --}}

        <div class="modern-product-badges">

            @if(!$inStock)

                <span class="modern-product-badge is-out">

                    Sold out

                </span>

            @elseif($lowStock)

                <span class="modern-product-badge is-low">

                    Low stock

                </span>

            @else

                <span class="modern-product-badge is-available">

                    Available

                </span>

            @endif

        </div>



        {{-- View Product --}}

        <a
            href="{{ $productUrl }}"
            class="modern-product-open"
            aria-label="View {{ $product->name }}"
        >

            <i class="bi bi-arrow-up-right"></i>

        </a>

    </div>



    {{-- Product Content --}}

    <div class="modern-product-content">


        <div class="modern-product-type">

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
                    Product
                </span>

            @endif

        </div>



        <h3 class="modern-product-name">

            <a href="{{ $productUrl }}">

                {{ $product->name }}

            </a>

        </h3>



        @if(
            $product->brand
            &&
            $product->category
        )

            <span class="modern-product-category">

                {{ $product->category->name }}

            </span>

        @endif



        <div class="modern-product-purchase">


            <div class="modern-product-price">

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



            <button
                type="button"
                class="modern-product-add"
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

                    <i class="bi bi-plus-lg"></i>

                    <span>
                        Add
                    </span>


                @else

                    <span>
                        Sold out
                    </span>

                @endif

            </button>

        </div>

    </div>

</article>