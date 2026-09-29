@extends(
    'storefront.public.themes.modern.layout'
)


@section(
    'title',
    $storefront->name . ' | Shop Online'
)


@section('content')


{{-- ============================================================
    MODERN HERO
============================================================= --}}

<section class="modern-home-hero">

    <div class="modern-container">

        <div class="modern-home-hero-panel">


            {{-- =================================================
                HERO COPY
            ================================================== --}}

            <div class="modern-home-hero-copy">


                <span class="modern-home-badge">

                    <i class="bi bi-lightning-charge-fill"></i>

                    Shop online

                </span>


                <h1>

                    Everything you need.

                    <span>
                        One simple cart.
                    </span>

                </h1>


                <p>

                    Discover what’s available at
                    {{ $storefront->name }},
                    add your favourites and complete
                    your order online.

                </p>


                <div class="modern-home-actions">


                    <a
                        href="#shop"
                        class="modern-home-primary"
                    >

                        Shop products

                        <i class="bi bi-arrow-right"></i>

                    </a>


                    <a
                        href="#new"
                        class="modern-home-secondary"
                    >

                        See what’s new

                    </a>

                </div>



                {{-- Trust / Service Points --}}

                <div class="modern-home-proof">


                    <div>

                        <i class="bi bi-box-seam"></i>

                        <span>

                            <strong>
                                Live
                            </strong>

                            availability

                        </span>

                    </div>


                    <div>

                        <i class="bi bi-shield-check"></i>

                        <span>

                            <strong>
                                Secure
                            </strong>

                            checkout

                        </span>

                    </div>


                    <div>

                        <i class="bi bi-credit-card"></i>

                        <span>

                            <strong>
                                Easy
                            </strong>

                            payment

                        </span>

                    </div>

                </div>

            </div>



            {{-- =================================================
                PRODUCT MOSAIC
            ================================================== --}}

            <div class="modern-home-mosaic">


                @if($products->count())


                    @foreach(
                        $products->take(3)
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
                                modern-mosaic-card
                                modern-mosaic-card-{{ $index + 1 }}
                            "
                        >


                            <div class="modern-mosaic-image">

                                <img
                                    src="{{ $heroProduct->imageUrl() }}"
                                    alt="{{ $heroProduct->name }}"
                                >

                            </div>


                            <div class="modern-mosaic-copy">


                                <span>

                                    {{ $heroProduct->brand
                                        ?: (
                                            $heroProduct->category?->name
                                            ?: 'Product'
                                        )
                                    }}

                                </span>


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


                            <span class="modern-mosaic-arrow">

                                <i class="bi bi-arrow-up-right"></i>

                            </span>

                        </a>

                    @endforeach


                @else

                    <div class="modern-mosaic-empty">

                        <span>

                            <i class="bi bi-box-seam"></i>

                        </span>


                        <strong>
                            Products coming soon
                        </strong>


                        <small>
                            This store is getting ready.
                        </small>

                    </div>

                @endif

            </div>

        </div>

    </div>

</section>



{{-- ============================================================
    COMMERCE BENEFITS STRIP
============================================================= --}}

<section class="modern-commerce-strip">

    <div class="modern-container">

        <div class="modern-commerce-strip-grid">


            <div class="modern-commerce-strip-item">

                <span>

                    <i class="bi bi-search"></i>

                </span>


                <div>

                    <strong>
                        Find it quickly
                    </strong>

                    <small>
                        Search products instantly.
                    </small>

                </div>

            </div>



            <div class="modern-commerce-strip-item">

                <span>

                    <i class="bi bi-bag-plus"></i>

                </span>


                <div>

                    <strong>
                        Add to cart
                    </strong>

                    <small>
                        Build your order as you browse.
                    </small>

                </div>

            </div>



            <div class="modern-commerce-strip-item">

                <span>

                    <i class="bi bi-box-seam"></i>

                </span>


                <div>

                    <strong>
                        Live availability
                    </strong>

                    <small>
                        See what is currently in stock.
                    </small>

                </div>

            </div>



            <div class="modern-commerce-strip-item">

                <span>

                    <i class="bi bi-shield-lock"></i>

                </span>


                <div>

                    <strong>
                        Secure payment
                    </strong>

                    <small>
                        Complete your order safely.
                    </small>

                </div>

            </div>

        </div>

    </div>

</section>



{{-- ============================================================
    NEW ARRIVALS
============================================================= --}}

<section
    class="modern-home-new"
    id="new"
>

    <div class="modern-container">


        <div class="modern-home-section-head">


            <div>

                <span>
                    Recently added
                </span>

                <h2>
                    Fresh picks
                </h2>


                <p>
                    Take a look at some of the latest
                    products in the store.
                </p>

            </div>


            <a href="#shop">

                View all

                <i class="bi bi-arrow-right"></i>

            </a>

        </div>



        @if($products->count())

            <div class="modern-product-grid">

                @foreach(
                    $products->take(8)
                    as $product
                )

                    @include(
                        'storefront.public.themes.modern.partials.product-card',
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

            <div class="modern-products-empty">

                <span>

                    <i class="bi bi-box-seam"></i>

                </span>


                <h3>
                    Nothing here yet
                </h3>


                <p>
                    Products will appear here once
                    they become available.
                </p>

            </div>

        @endif

    </div>

</section>



{{-- ============================================================
    SHOPPING EXPERIENCE
============================================================= --}}

<section class="modern-home-experience">

    <div class="modern-container">

        <div class="modern-experience-panel">


            <div class="modern-experience-copy">


                <span>
                    Shopping, simplified
                </span>


                <h2>
                    From shelf to checkout in a few clicks.
                </h2>


                <p>
                    A straightforward way to shop
                    {{ $storefront->name }} online.
                </p>

            </div>



            <div class="modern-experience-steps">


                <div>

                    <span>
                        01
                    </span>

                    <strong>
                        Browse
                    </strong>

                    <small>
                        Discover available products.
                    </small>

                </div>


                <i class="bi bi-arrow-right"></i>


                <div>

                    <span>
                        02
                    </span>

                    <strong>
                        Add
                    </strong>

                    <small>
                        Build your cart.
                    </small>

                </div>


                <i class="bi bi-arrow-right"></i>


                <div>

                    <span>
                        03
                    </span>

                    <strong>
                        Checkout
                    </strong>

                    <small>
                        Complete your order.
                    </small>

                </div>

            </div>

        </div>

    </div>

</section>



{{-- ============================================================
    ALL PRODUCTS
============================================================= --}}

<section
    class="modern-home-catalogue"
    id="shop"
>

    <div class="modern-container">


        <div class="modern-catalogue-header">


            <div>

                <span>
                    Store catalogue
                </span>


                <h2>
                    Shop all products
                </h2>


                <p>
                    Browse everything currently
                    available online.
                </p>

            </div>



            <!-- <div class="modern-catalogue-count">


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

            </div> -->

        </div>



        @if($products->count())

            <div class="modern-product-grid">

                @foreach(
                    $products
                    as $product
                )

                    @include(
                        'storefront.public.themes.modern.partials.product-card',
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

                <div class="modern-pagination">

                    {{ $products->links() }}

                </div>

            @endif


        @else

            <div class="modern-products-empty">


                <span>

                    <i class="bi bi-bag"></i>

                </span>


                <h3>
                    No products available
                </h3>


                <p>
                    Check back soon for new products.
                </p>

            </div>

        @endif

    </div>

</section>



{{-- ============================================================
    FLOATING CATEGORIES
============================================================= --}}

@if($categories->count())


    {{-- Floating Trigger --}}

    <button
        type="button"
        class="modern-floating-category-trigger"
        id="floatingCategoryTrigger"
        aria-label="Browse product categories"
    >

        <span class="modern-floating-category-trigger-icon">

            <i class="bi bi-grid-fill"></i>

        </span>


        <span class="modern-floating-category-trigger-copy">

            <small>
                Browse
            </small>

            <strong>
                Categories
            </strong>

        </span>


        <span class="modern-floating-category-trigger-arrow">

            <i class="bi bi-chevron-left"></i>

        </span>

    </button>



    {{-- Floating Panel --}}

    <aside
        class="modern-floating-category-panel"
        id="floatingCategoryPanel"
        aria-hidden="true"
    >


        <div class="modern-floating-category-header">


            <div>

                <span>
                    Find what you need
                </span>

                <h2>
                    Shop categories
                </h2>

            </div>


            <button
                type="button"
                id="floatingCategoryClose"
                class="modern-floating-category-close"
                aria-label="Close categories"
            >

                <i class="bi bi-x-lg"></i>

            </button>

        </div>



        <div class="modern-floating-category-intro">

            <span>

                <i class="bi bi-grid"></i>

            </span>


            <p>

                Jump directly into a section of
                {{ $storefront->name }}.

            </p>

        </div>



        <div class="modern-floating-category-list">

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
                    class="modern-floating-category-item"
                >


                    <span class="modern-floating-category-number">

                        {{ str_pad(
                            $index + 1,
                            2,
                            '0',
                            STR_PAD_LEFT
                        ) }}

                    </span>



                    <span class="modern-floating-category-name">


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



                    <span class="modern-floating-category-open">

                        <i class="bi bi-arrow-up-right"></i>

                    </span>

                </a>

            @endforeach

        </div>



        <div class="modern-floating-category-footer">


            <span>

                <strong>
                    {{ $categories->count() }}
                </strong>

                {{ \Illuminate\Support\Str::plural(
                    'category',
                    $categories->count()
                ) }}

            </span>


            <small>
                {{ $storefront->name }}
            </small>

        </div>

    </aside>



    {{-- Backdrop --}}

    <div
        class="modern-floating-category-backdrop"
        id="floatingCategoryBackdrop"
    ></div>


@endif


@endsection