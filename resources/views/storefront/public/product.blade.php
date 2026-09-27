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


            {{-- Product Visual --}}

            <div class="shop-product-detail-visual">

                <div class="shop-product-detail-image">

                    <img
                        src="{{ $product->imageUrl() }}"
                        alt="{{ $product->name }}"
                    >

                </div>

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


                <div
                    class="
                        shop-product-detail-stock
                        {{ $availableQuantity > 0
                            ? 'is-in'
                            : 'is-out'
                        }}
                    "
                >

                    <span></span>

                    {{ $availableQuantity > 0
                        ? 'Available'
                        : 'Currently unavailable'
                    }}

                </div>


                @if($product->description)

                    <div class="shop-product-description">

                        {!! nl2br(
                            e(
                                $product->description
                            )
                        ) !!}

                    </div>

                @endif


                @if($availableQuantity > 0)

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
                                max="{{ $availableQuantity }}"
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
                            data-product-stock="{{ $availableQuantity }}"
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


                    <div>

                        <i class="bi bi-box-seam"></i>

                        <span>

                            <strong>
                                Live availability
                            </strong>

                            Availability reflects current store stock.

                        </span>

                    </div>


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