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

    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/favicon.svg') }}">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <link
        rel="stylesheet"
        href="{{ asset('assets/css/storefront-public.css') }}"
    >

     <link
        rel="stylesheet"
        href="{{ asset('assets/css/storefront-checkout.css') }}"
    >

    @stack('styles')

</head>


<body class="shop-body">


{{-- ============================================================
    ANNOUNCEMENT
============================================================= --}}

<div class="shop-announcement">

    <div class="shop-shell shop-announcement-inner">

        <span>
            Shop online from
            <strong>{{ $storefront->name }}</strong>
        </span>

        <div class="shop-announcement-right">

            <span>
                <i class="bi bi-shield-check"></i>
                Secure shopping
            </span>

            @if($company->phone)

                <a href="tel:{{ $company->phone }}">
                    Need help?
                </a>

            @endif

        </div>

    </div>

</div>


{{-- ============================================================
    HEADER
============================================================= --}}

<header class="shop-header">

    <div class="shop-shell shop-header-main">


        <button
            type="button"
            class="shop-mobile-menu"
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
            class="shop-logo"
        >

            @if($company->logo)

                <img
                    src="{{ asset('uploads/company/'.$company->logo) }}"
                    alt="{{ $storefront->name }}"
                    class="shop-logo-image"
                >

            @endif

            <span>
                {{ $storefront->name }}
            </span>

        </a>


        {{-- Search --}}

        <div class="shop-search-wrap">

            <div class="shop-search">

                <i class="bi bi-search"></i>

                <input
                    type="search"
                    id="storefrontSearchInput"
                    placeholder="Search products, brands and more"
                    autocomplete="off"
                >

                <button
                    type="button"
                    id="storefrontSearchClear"
                    class="shop-search-clear"
                    aria-label="Clear search"
                >
                    <i class="bi bi-x-lg"></i>
                </button>

            </div>

            <div
                class="shop-search-results"
                id="storefrontSearchResults"
            ></div>

        </div>


        {{-- Header Actions --}}

        <div class="shop-header-actions">

            <button
                type="button"
                class="shop-header-action shop-mobile-search"
                id="storefrontMobileSearch"
                aria-label="Search"
            >
                <i class="bi bi-search"></i>
            </button>


            <button
                type="button"
                class="shop-bag-button"
                id="storefrontCartButton"
            >

                <span>
                    Bag
                </span>

                <i class="bi bi-bag"></i>

                <strong
                    id="storefrontCartCount"
                    class="shop-bag-count"
                >
                    0
                </strong>

            </button>

        </div>

    </div>


    {{-- Navigation --}}

    <nav
        class="shop-navigation"
        id="storefrontNavigation"
    >

        <div class="shop-shell shop-navigation-inner">

            <a
                href="{{ route(
                    'storefront.public.home',
                    $storefront->slug
                ) }}"
            >
                Home
            </a>

            <a
                href="{{ route(
                    'storefront.public.home',
                    $storefront->slug
                ) }}#new"
            >
                New In
            </a>

            <!-- <a
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
                ) }}#shop"
            >
                Shop All
            </a>

            <a href="#shopContact">
                Contact
            </a>

        </div>

    </nav>

</header>


{{-- ============================================================
    CONTENT
============================================================= --}}

<main class="shop-main">

    @yield('content')

</main>


{{-- ============================================================
    FOOTER
============================================================= --}}

<footer
    class="shop-footer"
    id="shopContact"
>

    <div class="shop-shell">

        <div class="shop-footer-grid">


            <div class="shop-footer-about">

                <h3>
                    {{ $storefront->name }}
                </h3>

                <p>
                    Browse our products and shop conveniently online.
                </p>

            </div>


            <div class="shop-footer-column">

                <strong>
                    Explore
                </strong>

                <a
                    href="{{ route(
                        'storefront.public.home',
                        $storefront->slug
                    ) }}#new"
                >
                    New In
                </a>

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
                    ) }}#shop"
                >
                    Shop All
                </a>

            </div>


            <div class="shop-footer-column">

                <strong>
                    Your Order
                </strong>

                <a
                    href="{{ route(
                        'storefront.public.cart',
                        $storefront->slug
                    ) }}"
                >
                    Shopping Bag
                </a>

            </div>


            <div class="shop-footer-column">

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


        <div class="shop-footer-bottom">

            <span>
                © {{ date('Y') }}
                {{ $storefront->name }}
            </span>

            <span>
                Powered by EMNEX
            </span>

        </div>

    </div>

</footer>


{{-- ============================================================
    CART DRAWER
============================================================= --}}

<div
    class="shop-drawer-backdrop"
    id="storefrontCartBackdrop"
></div>


<aside
    class="shop-cart-drawer"
    id="storefrontCartDrawer"
    aria-hidden="true"
>

    <div class="shop-cart-drawer-header">

        <div>

            <span>
                Your selection
            </span>

            <h2>
                Shopping Bag
            </h2>

        </div>


        <button
            type="button"
            id="storefrontCartClose"
            class="shop-cart-close"
            aria-label="Close cart"
        >
            <i class="bi bi-x-lg"></i>
        </button>

    </div>


    <div
        class="shop-cart-drawer-items"
        id="storefrontDrawerItems"
    ></div>


    <div
        class="shop-cart-drawer-empty"
        id="storefrontDrawerEmpty"
        hidden
    >

        <i class="bi bi-bag"></i>

        <h3>
            Your bag is empty
        </h3>

        <p>
            Add something you love.
        </p>

    </div>


    <div
        class="shop-cart-drawer-footer"
        id="storefrontDrawerFooter"
    >

        <div class="shop-cart-subtotal">

            <span>
                Subtotal
            </span>

            <strong
                id="storefrontDrawerSubtotal"
            >
                ₦0.00
            </strong>

        </div>


        <a
            href="{{ route(
                'storefront.public.cart',
                $storefront->slug
            ) }}"
            class="shop-view-bag"
        >
            View shopping bag
        </a>

    </div>

</aside>


{{-- ============================================================
    TOASTS
============================================================= --}}

<div
    class="shop-toast-stack"
    id="storefrontToastStack"
></div>


<script
    src="{{ asset('assets/js/storefront-public.js') }}"
></script>

@stack('scripts')

</body>

</html>