<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >


    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >


    <meta
        name="storefront-slug"
        content="{{ $storefront->slug }}"
    >


    <meta
        name="storefront-search-url"
        content="{{ route(
            'storefront.public.search',
            [
                'storefrontSlug' =>
                    $storefront->slug
            ]
        ) }}"
    >


    <meta
        name="storefront-cart-url"
        content="{{ route(
            'storefront.public.cart',
            [
                'storefrontSlug' =>
                    $storefront->slug
            ]
        ) }}"
    >


    <meta
        name="storefront-currency-symbol"
        content="{{ $currencySymbol }}"
    >


    <title>
        @yield(
            'title',
            $storefront->name
        )
    </title>


    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    <link
        rel="stylesheet"
        href="{{ asset(
            'assets/css/storefront-marketplace.css'
        ) }}"
    >


    @stack('styles')

</head>


<body class="marketplace-store-body">


{{-- ============================================================
    TOP UTILITY BAR
============================================================= --}}

<div class="marketplace-utility-bar">

    <div class="marketplace-container">

        <div class="marketplace-utility-inner">


            <div class="marketplace-utility-left">

                <span>

                    <i class="bi bi-shop"></i>

                    {{ $storefront->name }}

                </span>

            </div>


            <div class="marketplace-utility-right">

                <span>

                    <i class="bi bi-shield-check"></i>

                    Secure checkout

                </span>


                <span>

                    <i class="bi bi-box-seam"></i>

                    Live availability

                </span>


                @if($company->phone)

                    <a
                        href="tel:{{ $company->phone }}"
                    >

                        <i class="bi bi-telephone"></i>

                        {{ $company->phone }}

                    </a>

                @endif

            </div>

        </div>

    </div>

</div>



{{-- ============================================================
    MAIN HEADER
============================================================= --}}

<header class="marketplace-header">

    <div class="marketplace-container">


        <div class="marketplace-header-main">


            {{-- Mobile Menu --}}

            <button
                type="button"
                class="marketplace-mobile-menu"
                id="storefrontMenuToggle"
                aria-label="Open navigation"
            >

                <i class="bi bi-list"></i>

            </button>



            {{-- Brand --}}

            <a
                href="{{ route(
                    'storefront.public.home',
                    $storefront->slug
                ) }}"
                class="marketplace-brand"
            >


                @if($company->logo)

                    <span class="marketplace-brand-logo">

                        <img
                            src="{{ asset('uploads/company/'.
                                $company->logo
                            ) }}"
                            alt="{{ $storefront->name }}"
                        >

                    </span>


                @else

                    <span class="marketplace-brand-fallback">

                        {{ strtoupper(
                            mb_substr(
                                $storefront->name,
                                0,
                                1
                            )
                        ) }}

                    </span>

                @endif


                <span class="marketplace-brand-copy">

                    <strong>
                        {{ $storefront->name }}
                    </strong>

                    <small>
                        Online Marketplace
                    </small>

                </span>

            </a>



            {{-- =================================================
                SEARCH
            ================================================== --}}

            <div class="marketplace-search-area sf-search-area">


                <div class="marketplace-search-box">


                    <span class="marketplace-search-prefix">

                        <i class="bi bi-search"></i>

                    </span>


                    <input
                        type="search"
                        id="storefrontSearchInput"
                        placeholder="Search products, brands or product codes..."
                        autocomplete="off"
                    >


                    <button
                        type="button"
                        id="storefrontSearchClear"
                        class="marketplace-search-clear"
                        aria-label="Clear search"
                    >

                        <i class="bi bi-x-lg"></i>

                    </button>


                    <span class="marketplace-search-action">

                        Search

                    </span>

                </div>



                <div
                    class="marketplace-search-results"
                    id="storefrontSearchResults"
                ></div>

            </div>



            {{-- =================================================
                HEADER ACTIONS
            ================================================== --}}

            <div class="marketplace-header-actions">


                <button
                    type="button"
                    class="marketplace-mobile-search"
                    id="storefrontMobileSearch"
                    aria-label="Search products"
                >

                    <i class="bi bi-search"></i>

                </button>



                <a
                    href="{{ route(
                        'storefront.public.home',
                        $storefront->slug
                    ) }}#shop"
                    class="marketplace-shop-action"
                >

                    <span>

                        <i class="bi bi-grid"></i>

                    </span>


                    <span>

                        <small>
                            Browse
                        </small>

                        <strong>
                            Products
                        </strong>

                    </span>

                </a>



                <button
                    type="button"
                    class="marketplace-cart-button"
                    id="storefrontCartButton"
                >

                    <span class="marketplace-cart-icon">

                        <i class="bi bi-cart3"></i>

                    </span>


                    <span class="marketplace-cart-copy">

                        <small>
                            My cart
                        </small>

                        <strong>
                            View items
                        </strong>

                    </span>


                    <span
                        class="marketplace-cart-count"
                        id="storefrontCartCount"
                    >
                        0
                    </span>

                </button>

            </div>

        </div>



        {{-- ====================================================
            MARKETPLACE NAVIGATION
        ===================================================== --}}

        <nav
            class="marketplace-navigation"
            id="storefrontNavigation"
        >


            <div class="marketplace-navigation-main">


                <a
                    href="{{ route(
                        'storefront.public.home',
                        $storefront->slug
                    ) }}"
                    class="marketplace-nav-home"
                >

                    <i class="bi bi-house-door"></i>

                    Home

                </a>


                <a
                    href="{{ route(
                        'storefront.public.home',
                        $storefront->slug
                    ) }}#new"
                >
                    New arrivals
                </a>


                <a
                    href="{{ route(
                        'storefront.public.home',
                        $storefront->slug
                    ) }}#shop"
                >
                    All products
                </a>


                <a href="#marketplaceContact">
                    Contact
                </a>

            </div>



            <div class="marketplace-navigation-meta">

                <span>

                    <i class="bi bi-lightning-charge-fill"></i>

                    Quick shopping

                </span>

            </div>

        </nav>

    </div>

</header>



{{-- ============================================================
    PAGE CONTENT
============================================================= --}}

<main class="marketplace-main">

    @yield('content')

</main>



{{-- ============================================================
    FOOTER
============================================================= --}}

<footer
    class="marketplace-footer"
    id="marketplaceContact"
>

    <div class="marketplace-container">


        <div class="marketplace-footer-top">


            <div class="marketplace-footer-brand">


                <div class="marketplace-footer-brand-row">


                    @if($company->logo)

                        <span>

                            <img
                                src="{{ asset(
                                    $company->logo
                                ) }}"
                                alt="{{ $storefront->name }}"
                            >

                        </span>

                    @endif


                    <strong>
                        {{ $storefront->name }}
                    </strong>

                </div>


                <p>

                    Browse available products,
                    add what you need to your cart
                    and complete your order online.

                </p>

            </div>



            <div class="marketplace-footer-column">

                <strong>
                    Shop
                </strong>


                <a
                    href="{{ route(
                        'storefront.public.home',
                        $storefront->slug
                    ) }}#new"
                >
                    New arrivals
                </a>


                <a
                    href="{{ route(
                        'storefront.public.home',
                        $storefront->slug
                    ) }}#shop"
                >
                    All products
                </a>


                <a
                    href="{{ route(
                        'storefront.public.cart',
                        [
                            'storefrontSlug' =>
                                $storefront->slug
                        ]
                    ) }}"
                >
                    Shopping cart
                </a>

            </div>



            <div class="marketplace-footer-column">

                <strong>
                    Shopping
                </strong>


                <span>
                    Live stock availability
                </span>


                <span>
                    Secure online checkout
                </span>


                <span>
                    Online payment
                </span>

            </div>



            <div class="marketplace-footer-column">

                <strong>
                    Contact
                </strong>


                @if($company->phone)

                    <a
                        href="tel:{{ $company->phone }}"
                    >
                        {{ $company->phone }}
                    </a>

                @endif


                @if($company->email)

                    <a
                        href="mailto:{{ $company->email }}"
                    >
                        {{ $company->email }}
                    </a>

                @endif

            </div>

        </div>



        <div class="marketplace-footer-bottom">

            <span>

                © {{ date('Y') }}
                {{ $storefront->name }}

            </span>


            <span>

                Powered by

                <strong>
                    EMNEX
                </strong>

            </span>

        </div>

    </div>

</footer>



{{-- ============================================================
    CART BACKDROP
============================================================= --}}

<div
    class="marketplace-cart-backdrop"
    id="storefrontCartBackdrop"
></div>



{{-- ============================================================
    CART DRAWER
============================================================= --}}

<aside
    class="marketplace-cart-drawer"
    id="storefrontCartDrawer"
    aria-label="Shopping cart"
>


    <div class="marketplace-cart-drawer-header">


        <div>

            <span>
                Your cart
            </span>

            <h2>
                Shopping cart
            </h2>

        </div>


        <button
            type="button"
            id="storefrontCartClose"
            class="marketplace-cart-close"
            aria-label="Close cart"
        >

            <i class="bi bi-x-lg"></i>

        </button>

    </div>



    <div
        class="marketplace-cart-drawer-items"
        id="storefrontDrawerItems"
    ></div>



    {{-- Empty cart --}}

    <div
        class="marketplace-cart-empty"
        id="storefrontDrawerEmpty"
        hidden
    >

        <span>

            <i class="bi bi-cart3"></i>

        </span>


        <h3>
            Your cart is empty
        </h3>


        <p>
            Add products to your cart
            to get started.
        </p>


        <a
            href="{{ route(
                'storefront.public.home',
                $storefront->slug
            ) }}#shop"
        >
            Browse products
        </a>

    </div>



    {{-- Drawer footer --}}

    <div
        class="marketplace-cart-drawer-footer"
        id="storefrontDrawerFooter"
    >


        <div class="marketplace-cart-drawer-summary">

            <span>
                Subtotal
            </span>

            <strong>

                {{ $currencySymbol }}

                <span id="storefrontDrawerSubtotal">
                    0.00
                </span>

            </strong>

        </div>


        <p>

            Delivery, tax and other applicable
            charges are confirmed at checkout.

        </p>


        <a
            href="{{ route(
                'storefront.public.cart',
                [
                    'storefrontSlug' =>
                        $storefront->slug
                ]
            ) }}"
            class="marketplace-cart-view"
        >

            View cart

            <i class="bi bi-arrow-right"></i>

        </a>

    </div>

</aside>



{{-- ============================================================
    TOASTS
============================================================= --}}

<div
    class="marketplace-toast-stack"
    id="storefrontToastStack"
></div>



<script
    src="{{ asset(
        'assets/js/storefront-public.js'
    ) }}"
    defer
></script>


@stack('scripts')

</body>

</html>