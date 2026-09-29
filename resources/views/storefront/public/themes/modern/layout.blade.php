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
            $storefront->slug
        ) }}"
    >

    <meta
        name="storefront-cart-url"
        content="{{ route(
            'storefront.public.cart',
            $storefront->slug
        ) }}"
    >

    <meta
        name="storefront-currency-symbol"
        content="{{ $currencySymbol ?? ($company->currency_symbol ?: '₦') }}"
    >

    <title>
        @yield('title', $storefront->name)
    </title>

    <link
        rel="icon"
        type="image/svg+xml"
        href="{{ asset('assets/images/favicon.svg') }}"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <link
        rel="stylesheet"
        href="{{ asset('assets/css/storefront-modern.css') }}"
    >

    @stack('styles')

</head>


<body class="modern-store-body">


{{-- ============================================================
    HEADER
============================================================= --}}

<header class="modern-header">

    <div class="modern-container">

        <div class="modern-header-main">


            {{-- Mobile Menu --}}

            <button
                type="button"
                class="modern-mobile-menu"
                id="storefrontMenuToggle"
                aria-label="Open menu"
            >
                <i class="bi bi-list"></i>
            </button>


            {{-- Brand --}}

            <a
                href="{{ route(
                    'storefront.public.home',
                    $storefront->slug
                ) }}"
                class="modern-brand"
            >

                @if($company->logo)

                    <span class="modern-brand-logo">

                        <img
                            src="{{ asset(
                                'uploads/company/' .
                                $company->logo
                            ) }}"
                            alt="{{ $storefront->name }}"
                        >

                    </span>

                @else

                    <span class="modern-brand-fallback">

                        {{ strtoupper(
                            substr(
                                $storefront->name,
                                0,
                                1
                            )
                        ) }}

                    </span>

                @endif


                <span class="modern-brand-copy">

                    <strong>
                        {{ $storefront->name }}
                    </strong>

                    <small>
                        Online Store
                    </small>

                </span>

            </a>


            {{-- Search --}}

            <div class="modern-search-area sf-search-area">

                <div class="modern-search-box">

                    <i class="bi bi-search"></i>

                    <input
                        type="search"
                        id="storefrontSearchInput"
                        placeholder="Search for products..."
                        autocomplete="off"
                    >

                    <button
                        type="button"
                        id="storefrontSearchClear"
                        class="modern-search-clear"
                        aria-label="Clear search"
                    >
                        <i class="bi bi-x-lg"></i>
                    </button>

                </div>


                <div
                    class="modern-search-results"
                    id="storefrontSearchResults"
                ></div>

            </div>


            {{-- Header Actions --}}

            <div class="modern-header-actions">

                <button
                    type="button"
                    class="modern-mobile-search"
                    id="storefrontMobileSearch"
                    aria-label="Search"
                >
                    <i class="bi bi-search"></i>
                </button>


                <button
                    type="button"
                    class="modern-cart-button"
                    id="storefrontCartButton"
                >

                    <span class="modern-cart-icon">
                        <i class="bi bi-bag"></i>
                    </span>


                    <span class="modern-cart-label">

                        <small>
                            My cart
                        </small>

                        <strong>
                            View bag
                        </strong>

                    </span>


                    <span
                        id="storefrontCartCount"
                        class="modern-cart-count"
                    >
                        0
                    </span>

                </button>

            </div>

        </div>


        {{-- Navigation --}}

        <nav
            class="modern-navigation"
            id="storefrontNavigation"
        >

            <div class="modern-navigation-links">

                <a
                    href="{{ route(
                        'storefront.public.home',
                        $storefront->slug
                    ) }}"
                >
                    Home
                </a>

<!-- 
                <a
                    href="{{ route(
                        'storefront.public.home',
                        $storefront->slug
                    ) }}#categories"
                >
                    Categories
                </a> -->


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
                    Shop all
                </a>


                <a href="#modernContact">
                    Contact
                </a>

            </div>


            <div class="modern-navigation-note">

                <span>
                    <i class="bi bi-shield-check"></i>
                    Secure checkout
                </span>

                <span>
                    <i class="bi bi-box-seam"></i>
                    Live availability
                </span>

            </div>

        </nav>

    </div>

</header>



{{-- ============================================================
    PAGE CONTENT
============================================================= --}}

<main class="modern-main">

    @yield('content')

</main>



{{-- ============================================================
    FOOTER
============================================================= --}}

<footer
    class="modern-footer"
    id="modernContact"
>

    <div class="modern-container">

        <div class="modern-footer-grid">


            <div class="modern-footer-about">

                <a
                    href="{{ route(
                        'storefront.public.home',
                        $storefront->slug
                    ) }}"
                    class="modern-footer-brand"
                >

                    @if($company->logo)

                        <img
                            src="{{ asset(
                                'uploads/company/' .
                                $company->logo
                            ) }}"
                            alt="{{ $storefront->name }}"
                        >

                    @endif


                    <strong>
                        {{ $storefront->name }}
                    </strong>

                </a>


                <p>
                    Browse products, check availability
                    and order online from
                    {{ $storefront->name }}.
                </p>

            </div>


            <div class="modern-footer-column">

                <strong>
                    Shop
                </strong>

                <a
                    href="{{ route(
                        'storefront.public.home',
                        $storefront->slug
                    ) }}#categories"
                >
                    Categories
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

            </div>


            <div class="modern-footer-column">

                <strong>
                    Your order
                </strong>

                <a
                    href="{{ route(
                        'storefront.public.cart',
                        $storefront->slug
                    ) }}"
                >
                    Shopping cart
                </a>

            </div>


            <div class="modern-footer-column">

                <strong>
                    Contact
                </strong>

                @if($company->phone)

                    <a href="tel:{{ $company->phone }}">
                        {{ $company->phone }}
                    </a>

                @endif


                @if($company->email)

                    <a href="mailto:{{ $company->email }}">
                        {{ $company->email }}
                    </a>

                @endif

            </div>

        </div>


        <div class="modern-footer-bottom">

            <span>
                © {{ date('Y') }}
                {{ $storefront->name }}
            </span>

            <span>
                Powered by
                <strong>EMNEX</strong>
            </span>

        </div>

    </div>

</footer>



{{-- ============================================================
    CART DRAWER
============================================================= --}}

<div
    class="modern-cart-backdrop"
    id="storefrontCartBackdrop"
></div>


<aside
    class="modern-cart-drawer"
    id="storefrontCartDrawer"
    aria-hidden="true"
>

    <div class="modern-cart-drawer-header">

        <div>

            <span>
                My cart
            </span>

            <h2>
                Your items
            </h2>

        </div>


        <button
            type="button"
            id="storefrontCartClose"
            class="modern-cart-close"
            aria-label="Close cart"
        >
            <i class="bi bi-x-lg"></i>
        </button>

    </div>


    <div
        class="modern-cart-drawer-items"
        id="storefrontDrawerItems"
    ></div>


    <div
        class="modern-cart-empty"
        id="storefrontDrawerEmpty"
        hidden
    >

        <span class="modern-cart-empty-icon">
            <i class="bi bi-bag"></i>
        </span>

        <h3>
            Your cart is empty
        </h3>

        <p>
            Browse the store and add something you like.
        </p>


        <a
            href="{{ route(
                'storefront.public.home',
                $storefront->slug
            ) }}#shop"
        >
            Start shopping
        </a>

    </div>


    <div
        class="modern-cart-drawer-footer"
        id="storefrontDrawerFooter"
    >

        <div class="modern-cart-subtotal">

            <span>
                Subtotal
            </span>

            <strong
                id="storefrontDrawerSubtotal"
            >
                {{ $currencySymbol ?? '₦' }}0.00
            </strong>

        </div>


        <p>
            Delivery and other charges are calculated
            during checkout.
        </p>


        <a
            href="{{ route(
                'storefront.public.cart',
                $storefront->slug
            ) }}"
            class="modern-cart-view"
        >
            View cart

            <i class="bi bi-arrow-right"></i>
        </a>

    </div>

</aside>



{{-- ============================================================
    TOAST
============================================================= --}}

<div
    class="modern-toast-stack"
    id="storefrontToastStack"
></div>



<script
    src="{{ asset(
        'assets/js/storefront-public.js'
    ) }}"
></script>

@stack('scripts')


</body>
</html>