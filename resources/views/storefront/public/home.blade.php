@extends('storefront.public.layouts.app')


@section(
    'title',
    $storefront->name . ' | Shop Online'
)


@section('content')


{{-- ============================================================
    HERO
============================================================= --}}

<section class="shop-hero">

    <div class="shop-shell">

        <div class="shop-hero-grid">


            <div class="shop-hero-copy">

                <span class="shop-eyebrow">
                    Now online
                </span>


                <h1>

                    Find your
                    <em>next favourite.</em>

                </h1>


                <p>

                    Discover what
                    {{ $storefront->name }}
                    has in store and order directly online.

                </p>


                <a
                    href="#shop"
                    class="shop-hero-link"
                >

                    Shop the collection

                    <i class="bi bi-arrow-right"></i>

                </a>

            </div>


            <div class="shop-hero-feature">


                @if($products->count())

                    @php
                        $heroProduct =
                            $products->first();
                    @endphp


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
                        class="shop-featured-product"
                    >

                        <div class="shop-featured-image">

                            <img
                                src="{{ $heroProduct->imageUrl() }}"
                                alt="{{ $heroProduct->name }}"
                            >

                        </div>


                        <div class="shop-featured-info">

                            <span>
                                Featured
                            </span>

                            <strong>
                                {{ $heroProduct->name }}
                            </strong>

                            <small>

                                {{ $currencySymbol }}{{ number_format(
                                    (float) $heroProduct->selling_price,
                                    2
                                ) }}

                            </small>

                        </div>

                    </a>


                @else

                    <div class="shop-feature-placeholder">

                        <i class="bi bi-bag"></i>

                        <span>
                            Products coming soon
                        </span>

                    </div>

                @endif


            </div>


        </div>

    </div>

</section>



{{-- ============================================================
    NEW ARRIVALS
============================================================= --}}

<section
    class="shop-new-section"
    id="new"
>

    <div class="shop-shell">


        <div class="shop-section-heading shop-section-heading-line">

            <div>

                <span>
                    01 / New
                </span>

                <h2>
                    Recently added
                </h2>

            </div>


            <a href="#shop">

                See everything

                <i class="bi bi-arrow-right"></i>

            </a>

        </div>


        @if($products->count())

            <div class="shop-new-grid">

                @foreach(
                    $products->take(4)
                    as $product
                )

                    @include(
                        'storefront.public.partials.product-card',
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

        @endif


    </div>

</section>


{{-- ============================================================
    EDITORIAL MESSAGE
============================================================= --}}

<section class="shop-story-section">

    <div class="shop-shell">

        <div class="shop-story">


            <span>
                Shop confidently
            </span>


            <h2>

                What you see is what
                <em>we currently have.</em>

            </h2>


            <p>

                Browse available products and place your order
                without the guesswork.

            </p>


            <a href="#shop">

                Explore the store

                <i class="bi bi-arrow-down"></i>

            </a>


        </div>

    </div>

</section>


{{-- ============================================================
    ALL PRODUCTS
============================================================= --}}

<section
    class="shop-all-section"
    id="shop"
>

    <div class="shop-shell">


        <div class="shop-section-heading shop-section-heading-line">

            <div>

                <span>
                    02 / Catalogue
                </span>

                <h2>
                    Shop all
                </h2>

            </div>


            <p>

                {{ number_format(
                    $products->total()
                ) }}

                {{ Str::plural(
                    'item',
                    $products->total()
                ) }}

            </p>

        </div>


        @if($products->count())

            <div class="shop-product-grid">

                @foreach(
                    $products as $product
                )

                    @include(
                        'storefront.public.partials.product-card',
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

                <div class="shop-pagination">

                    {{ $products->links() }}

                </div>

            @endif


        @else

            <div class="shop-empty">

                <span>
                    Empty shelf
                </span>

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

@if($categories->count())

    {{-- Floating Category Trigger --}}

    <button
        type="button"
        class="shop-floating-category-trigger"
        id="floatingCategoryTrigger"
        aria-label="Browse categories"
    >

        <span>
            Categories
        </span>

        <i class="bi bi-grid"></i>

    </button>


    {{-- Floating Category Panel --}}

    <aside
        class="shop-floating-category-panel"
        id="floatingCategoryPanel"
        aria-hidden="true"
    >

        <div class="shop-floating-category-header">

            <div>

                <span>
                    Browse
                </span>

                <h3>
                    Categories
                </h3>

            </div>


            <button
                type="button"
                id="floatingCategoryClose"
                aria-label="Close categories"
            >

                <i class="bi bi-x-lg"></i>

            </button>

        </div>


        <div class="shop-floating-category-list">

            @foreach(
                $categories
                as $index => $category
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
                    class="shop-floating-category-item"
                >

                    <span class="shop-floating-category-number">

                        {{ str_pad(
                            $index + 1,
                            2,
                            '0',
                            STR_PAD_LEFT
                        ) }}

                    </span>


                    <span class="shop-floating-category-name">

                        {{ $category->name }}

                    </span>


                    <i class="bi bi-arrow-up-right"></i>

                </a>

            @endforeach

        </div>


        <div class="shop-floating-category-footer">

            {{ $categories->count() }}

            {{ Str::plural(
                'category',
                $categories->count()
            ) }}

        </div>

    </aside>


    {{-- Optional Backdrop --}}

    <div
        class="shop-floating-category-backdrop"
        id="floatingCategoryBackdrop"
    ></div>

@endif

@endsection