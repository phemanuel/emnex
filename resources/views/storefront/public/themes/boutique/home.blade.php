@extends(
    'storefront.public.themes.boutique.layout'
)


@section(
    'title',
    $storefront->name . ' | Shop Online'
)


@section('content')


@php

    $heroProducts =
        $products
            ->take(2)
            ->values();

    $newArrivals =
        $products
            ->take(4);

@endphp



{{-- ================================================================
    HERO
================================================================ --}}

<section class="bq-hero">

    <div class="bq-shell">

        <div class="bq-hero__grid">


            {{-- COPY --}}

            <div class="bq-hero__content">

                <span class="bq-eyebrow">
                    {{ $storefront->name }}
                </span>

                <h1>
                    Curated for
                    <span>everyday style.</span>
                </h1>

                <p>

                    Modern finds, thoughtfully selected
                    and ready to shop online.

                </p>

                <div class="bq-hero__actions">

                    <a
                        href="#new"
                        class="bq-button bq-button--accent"
                    >

                        Shop new arrivals

                        <i class="bi bi-arrow-right"></i>

                    </a>

                    <a
                        href="#collections"
                        class="bq-button bq-button--ghost"
                    >
                        Browse collections
                    </a>

                </div>

            </div>



            {{-- PRODUCT VISUALS --}}

            <div
                class="
                    bq-hero__products
                    {{ $heroProducts->count() === 1
                        ? 'is-single'
                        : ''
                    }}
                "
            >

                @forelse(
                    $heroProducts
                    as $index => $heroProduct
                )

                    <a
                        href="{{ route(
                            'storefront.public.product',
                            [
                                'storefrontSlug' =>
                                    $storefront->slug,

                                'productCode' =>
                                    $heroProduct->product_code,
                            ]
                        ) }}"
                        class="
                            bq-hero-product
                            {{ $index === 0
                                ? 'bq-hero-product--primary'
                                : 'bq-hero-product--secondary'
                            }}
                        "
                    >

                        <div class="bq-hero-product__image">

                            <img
                                src="{{ $heroProduct->imageUrl() }}"
                                alt="{{ $heroProduct->name }}"
                            >

                        </div>

                        <div class="bq-hero-product__info">

                            <div>

                                <span>
                                    {{ $index === 0
                                        ? 'Featured'
                                        : 'New in'
                                    }}
                                </span>

                                <strong>
                                    {{ $heroProduct->name }}
                                </strong>

                            </div>

                            <span class="bq-hero-product__price">

                                {{ $currencySymbol }}{{ number_format(
                                    (float) $heroProduct->selling_price,
                                    2
                                ) }}

                            </span>

                        </div>

                    </a>

                @empty

                    <div class="bq-hero__empty">

                        <i class="bi bi-bag"></i>

                        <p>
                            Products coming soon.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</section>



{{-- ================================================================
    COLLECTIONS
================================================================ --}}

@if($categories->count())

<section
    class="bq-collections"
    id="collections"
>

    <div class="bq-shell">

        <div class="bq-section-heading">

            <div>

                <span class="bq-eyebrow">
                    Shop by
                </span>

                <h2>
                    Collections
                </h2>

            </div>

            <span class="bq-section-heading__meta">

                {{ $categories->count() }}

                {{ Str::plural(
                    'collection',
                    $categories->count()
                ) }}

            </span>

        </div>



        <div class="bq-collection-grid">

            @foreach(
                $categories->take(6)
                as $category
            )

                <a
                    href="{{ route(
                        'storefront.public.category',
                        [
                            'storefrontSlug' =>
                                $storefront->slug,

                            'categoryCode' =>
                                $category->category_code,
                        ]
                    ) }}"
                    class="bq-collection-card"
                >

                    <div>

                        <span class="bq-collection-card__label">
                            Collection
                        </span>

                        <strong>
                            {{ $category->name }}
                        </strong>

                    </div>

                    <i class="bi bi-arrow-up-right"></i>

                </a>

            @endforeach

        </div>

    </div>

</section>

@endif



{{-- ================================================================
    NEW ARRIVALS
================================================================ --}}

<section
    class="bq-new"
    id="new"
>

    <div class="bq-shell">


        <div class="bq-section-heading">

            <div>

                <span class="bq-eyebrow">
                    Recently added
                </span>

                <h2>
                    New arrivals
                </h2>

            </div>

            <a
                href="#shop"
                class="bq-section-link"
            >

                View all

                <i class="bi bi-arrow-right"></i>

            </a>

        </div>



        @if($newArrivals->count())

            <div class="bq-product-grid bq-product-grid--new">

                @foreach(
                    $newArrivals
                    as $product
                )

                    @include(
                        'storefront.public.themes.boutique.partials.product-card',
                        [
                            'product' =>
                                $product,

                            'storefront' =>
                                $storefront,

                            'currencySymbol' =>
                                $currencySymbol,
                        ]
                    )

                @endforeach

            </div>

        @else

            <div class="bq-empty">

                <i class="bi bi-bag"></i>

                <h3>
                    New products coming soon.
                </h3>

            </div>

        @endif

    </div>

</section>



{{-- ================================================================
    PROMO STRIP
================================================================ --}}

<section class="bq-promo">

    <div class="bq-shell bq-promo__inner">

        <div>

            <span class="bq-promo__eyebrow">
                Shop confidently
            </span>

            <h2>
                Find it. Love it. Make it yours.
            </h2>

        </div>

        <a
            href="#shop"
            class="bq-promo__link"
        >

            Explore all products

            <i class="bi bi-arrow-right"></i>

        </a>

    </div>

</section>



{{-- ================================================================
    SHOP ALL
================================================================ --}}

<section
    class="bq-shop"
    id="shop"
>

    <div class="bq-shell">


        <div class="bq-section-heading">

            <div>

                <span class="bq-eyebrow">
                    Browse everything
                </span>

                <h2>
                    Shop all
                </h2>

            </div>


            <span class="bq-section-heading__meta">

                {{ number_format(
                    $products->total()
                ) }}

                {{ Str::plural(
                    'item',
                    $products->total()
                ) }}

            </span>

        </div>



        @if($products->count())

            <div class="bq-product-grid">

                @foreach(
                    $products
                    as $product
                )

                    @include(
                        'storefront.public.themes.boutique.partials.product-card',
                        [
                            'product' =>
                                $product,

                            'storefront' =>
                                $storefront,

                            'currencySymbol' =>
                                $currencySymbol,
                        ]
                    )

                @endforeach

            </div>



            @if($products->hasPages())

                <div class="bq-pagination">

                    {{ $products->links() }}

                </div>

            @endif

        @else

            <div class="bq-empty">

                <i class="bi bi-bag"></i>

                <h3>
                    Nothing here yet.
                </h3>

                <p>
                    Check back soon for new products.
                </p>

            </div>

        @endif

    </div>

</section>



{{-- ================================================================
    BENEFITS
================================================================ --}}

<section class="bq-benefits">

    <div class="bq-shell bq-benefits__grid">


        <div class="bq-benefit">

            <i class="bi bi-shield-check"></i>

            <div>

                <strong>
                    Secure checkout
                </strong>

                <span>
                    Shop and pay securely online.
                </span>

            </div>

        </div>



        <div class="bq-benefit">

            <i class="bi bi-bag-check"></i>

            <div>

                <strong>
                    Current availability
                </strong>

                <span>
                    Shop products currently available.
                </span>

            </div>

        </div>



        <div class="bq-benefit">

            <i class="bi bi-headset"></i>

            <div>

                <strong>
                    Store support
                </strong>

                <span>
                    Need help? Contact the store.
                </span>

            </div>

        </div>

    </div>

</section>


@endsection