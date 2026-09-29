@extends(
    'storefront.public.themes.marketplace.layout'
)


@section(
    'title',
    $storefront->name . ' | Shop Online'
)


@section('content')


{{-- ============================================================
    MARKETPLACE CATEGORY RAIL
============================================================= --}}

@if($categories->count())

<section class="marketplace-category-rail">

    <div class="marketplace-container">

        <div class="marketplace-category-rail-inner">


            <div class="marketplace-category-rail-label">

                <span>

                    <i class="bi bi-grid-fill"></i>

                </span>


                <strong>
                    Categories
                </strong>

            </div>



            <div class="marketplace-category-rail-links">

                @foreach(
                    $categories->take(8)
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
                    >

                        {{ $category->name }}

                    </a>

                @endforeach

            </div>


            @if($categories->count() > 8)

                <a
                    href="#marketplaceCategories"
                    class="marketplace-category-rail-more"
                >

                    More

                    <i class="bi bi-chevron-down"></i>

                </a>

            @endif

        </div>

    </div>

</section>

@endif



{{-- ============================================================
    MARKETPLACE HERO
============================================================= --}}

<section class="marketplace-hero">

    <div class="marketplace-container">

        <div class="marketplace-hero-grid">


            {{-- =================================================
                MAIN PROMO
            ================================================== --}}

            <div class="marketplace-hero-main">


                <div class="marketplace-hero-content">


                    <span class="marketplace-hero-label">

                        <i class="bi bi-lightning-charge-fill"></i>

                        Shop what’s available now

                    </span>


                    <h1>

                        Find it.

                        <span>
                            Add it.
                        </span>

                        Get your order started.

                    </h1>


                    <p>

                        Browse products from
                        {{ $storefront->name }},
                        check live availability and
                        complete your order online.

                    </p>


                    <div class="marketplace-hero-actions">

                        <a
                            href="#shop"
                            class="marketplace-hero-primary"
                        >

                            Start shopping

                            <i class="bi bi-arrow-right"></i>

                        </a>


                        <a
                            href="#marketplaceCategories"
                            class="marketplace-hero-secondary"
                        >

                            Browse categories

                        </a>

                    </div>


                    <div class="marketplace-hero-stats">


                        <div>

                            <strong>

                                {{ number_format(
                                    $products->total()
                                ) }}

                            </strong>

                            <span>

                                {{ \Illuminate\Support\Str::plural(
                                    'product',
                                    $products->total()
                                ) }}

                            </span>

                        </div>


                        <div>

                            <strong>
                                Live
                            </strong>

                            <span>
                                stock visibility
                            </span>

                        </div>


                        <div>

                            <strong>
                                Secure
                            </strong>

                            <span>
                                online checkout
                            </span>

                        </div>

                    </div>

                </div>

            </div>



            {{-- =================================================
                PRODUCT PROMO GRID
            ================================================== --}}

            <div class="marketplace-hero-products">


                @if($products->count())


                    @foreach(
                        $products->take(4)
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
                                marketplace-hero-product
                                marketplace-hero-product-{{ $index + 1 }}
                            "
                        >


                            <div class="marketplace-hero-product-image">

                                <img
                                    src="{{ $heroProduct->imageUrl() }}"
                                    alt="{{ $heroProduct->name }}"
                                >

                            </div>


                            <div class="marketplace-hero-product-content">


                                @if($heroProduct->brand)

                                    <span>
                                        {{ $heroProduct->brand }}
                                    </span>

                                @elseif($heroProduct->category)

                                    <span>
                                        {{ $heroProduct->category->name }}
                                    </span>

                                @endif


                                <strong>
                                    {{ $heroProduct->name }}
                                </strong>


                                <small>

                                    {{ $currencySymbol }}{{ number_format(
                                        (float)
                                        $heroProduct->selling_price,
                                        2
                                    ) }}

                                </small>

                            </div>


                            <i class="bi bi-arrow-up-right"></i>

                        </a>

                    @endforeach


                @else

                    <div class="marketplace-hero-empty">

                        <i class="bi bi-box-seam"></i>

                        <strong>
                            Products coming soon
                        </strong>

                        <span>
                            Check back for available products.
                        </span>

                    </div>

                @endif

            </div>

        </div>

    </div>

</section>



{{-- ============================================================
    SHOPPING FEATURES
============================================================= --}}

<section class="marketplace-service-strip">

    <div class="marketplace-container">

        <div class="marketplace-service-grid">


            <div class="marketplace-service-item">

                <span>

                    <i class="bi bi-search"></i>

                </span>


                <div>

                    <strong>
                        Search quickly
                    </strong>

                    <small>
                        Find products instantly.
                    </small>

                </div>

            </div>



            <div class="marketplace-service-item">

                <span>

                    <i class="bi bi-box-seam"></i>

                </span>


                <div>

                    <strong>
                        Live availability
                    </strong>

                    <small>
                        Shop current online stock.
                    </small>

                </div>

            </div>



            <div class="marketplace-service-item">

                <span>

                    <i class="bi bi-cart-plus"></i>

                </span>


                <div>

                    <strong>
                        Easy cart
                    </strong>

                    <small>
                        Add and adjust quantities.
                    </small>

                </div>

            </div>



            <div class="marketplace-service-item">

                <span>

                    <i class="bi bi-shield-check"></i>

                </span>


                <div>

                    <strong>
                        Secure checkout
                    </strong>

                    <small>
                        Complete your order online.
                    </small>

                </div>

            </div>

        </div>

    </div>

</section>



{{-- ============================================================
    CATEGORIES
============================================================= --}}

@if($categories->count())

<section
    class="marketplace-categories"
    id="marketplaceCategories"
>

    <div class="marketplace-container">


        <div class="marketplace-section-heading">


            <div>

                <span>
                    Shop by department
                </span>

                <h2>
                    Browse categories
                </h2>

            </div>


            <small>

                {{ $categories->count() }}

                {{ \Illuminate\Support\Str::plural(
                    'category',
                    $categories->count()
                ) }}

            </small>

        </div>



        <div class="marketplace-category-grid">

            @foreach(
                $categories
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
                    class="marketplace-category-card"
                >


                    <span class="marketplace-category-icon">

                        {{ strtoupper(
                            mb_substr(
                                $category->name,
                                0,
                                1
                            )
                        ) }}

                    </span>


                    <span class="marketplace-category-card-copy">

                        <strong>
                            {{ $category->name }}
                        </strong>


                        @if($category->children->count())

                            <small>

                                {{ $category->children->count() }}

                                {{ \Illuminate\Support\Str::plural(
                                    'section',
                                    $category->children->count()
                                ) }}

                            </small>

                        @else

                            <small>
                                Browse products
                            </small>

                        @endif

                    </span>


                    <i class="bi bi-chevron-right"></i>

                </a>

            @endforeach

        </div>

    </div>

</section>

@endif



{{-- ============================================================
    NEW ARRIVALS
============================================================= --}}

<section
    class="marketplace-new-arrivals"
    id="new"
>

    <div class="marketplace-container">


        <div class="marketplace-section-heading">


            <div>

                <span>
                    Just added
                </span>

                <h2>
                    New arrivals
                </h2>

            </div>


            <a href="#shop">

                View all products

                <i class="bi bi-arrow-right"></i>

            </a>

        </div>



        @if($products->count())

            <div class="marketplace-product-grid marketplace-product-grid-featured">

                @foreach(
                    $products->take(6)
                    as $product
                )

                    @include(
                        'storefront.public.themes.marketplace.partials.product-card',
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

            <div class="marketplace-empty">

                <span>

                    <i class="bi bi-box-seam"></i>

                </span>


                <h3>
                    No products yet
                </h3>


                <p>
                    Products will appear here
                    when they become available.
                </p>

            </div>

        @endif

    </div>

</section>



{{-- ============================================================
    MARKETPLACE PROMO BAND
============================================================= --}}

<section class="marketplace-shopping-band">

    <div class="marketplace-container">

        <div class="marketplace-shopping-band-inner">


            <div class="marketplace-shopping-band-copy">

                <span>
                    Fast catalogue shopping
                </span>


                <h2>
                    Browse more. Scroll less.
                </h2>


                <p>
                    A product-first shopping experience
                    built to help you find what you need quickly.
                </p>

            </div>



            <div class="marketplace-shopping-band-actions">


                <div>

                    <i class="bi bi-search"></i>

                    <span>

                        <strong>
                            Search
                        </strong>

                        Find products

                    </span>

                </div>


                <i class="bi bi-arrow-right"></i>


                <div>

                    <i class="bi bi-cart-plus"></i>

                    <span>

                        <strong>
                            Add
                        </strong>

                        Build cart

                    </span>

                </div>


                <i class="bi bi-arrow-right"></i>


                <div>

                    <i class="bi bi-credit-card"></i>

                    <span>

                        <strong>
                            Pay
                        </strong>

                        Checkout securely

                    </span>

                </div>

            </div>

        </div>

    </div>

</section>



{{-- ============================================================
    ALL PRODUCTS
============================================================= --}}

<section
    class="marketplace-catalogue"
    id="shop"
>

    <div class="marketplace-container">


        <div class="marketplace-catalogue-heading">


            <div>

                <span>
                    Full catalogue
                </span>

                <h2>
                    All products
                </h2>


                <p>
                    Browse everything currently
                    available in the online store.
                </p>

            </div>



            <div class="marketplace-catalogue-meta">

                <strong>

                    {{ number_format(
                        $products->total()
                    ) }}

                </strong>


                <span>

                    {{ \Illuminate\Support\Str::plural(
                        'item',
                        $products->total()
                    ) }}

                </span>

            </div>

        </div>



        @if($products->count())

            <div class="marketplace-product-grid">

                @foreach(
                    $products
                    as $product
                )

                    @include(
                        'storefront.public.themes.marketplace.partials.product-card',
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

                <div class="marketplace-pagination">

                    {{ $products->links() }}

                </div>

            @endif


        @else

            <div class="marketplace-empty">

                <span>

                    <i class="bi bi-cart-x"></i>

                </span>


                <h3>
                    No products available
                </h3>


                <p>
                    Check back soon for new stock.
                </p>

            </div>

        @endif

    </div>

</section>


@endsection