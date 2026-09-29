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
        href="{{ asset('assets/css/storefront-boutique.css') }}"
    >

    @stack('styles')

</head>


<body class="bq-body">


{{-- ================================================================
    UTILITY BAR
================================================================ --}}

<div class="bq-utility">

    <div class="bq-shell bq-utility__inner">

        <span>
            Shop online with {{ $storefront->name }}
        </span>

        <div class="bq-utility__right">

            <span>
                <i class="bi bi-shield-check"></i>
                Secure checkout
            </span>

            @if($company->phone)

                <a href="tel:{{ $company->phone }}">
                    Need help?
                </a>

            @endif

        </div>

    </div>

</div>



{{-- ================================================================
    HEADER
================================================================ --}}

<header class="bq-header">

    <div class="bq-shell bq-header__inner">


        {{-- MOBILE MENU --}}

        <button
            type="button"
            class="bq-mobile-menu"
            id="storefrontMenuToggle"
            aria-label="Open menu"
        >
            <i class="bi bi-list"></i>
        </button>



        {{-- BRAND --}}

        <a
            href="{{ route(
                'storefront.public.home',
                $storefront->slug
            ) }}"
            class="bq-brand"
        >

            @if($company->logo)

                <img
                    src="{{ asset(
                        'uploads/company/' .
                        $company->logo
                    ) }}"
                    alt="{{ $storefront->name }}"
                    class="bq-brand__logo"
                >

            @endif

            <span class="bq-brand__name">
                {{ $storefront->name }}
            </span>

        </a>



        {{-- NAVIGATION --}}

        <nav
            class="bq-nav"
            id="storefrontNavigation"
        >

            <a
                href="{{ route(
                    'storefront.public.home',
                    $storefront->slug
                ) }}"
            >
                Shop
            </a>

            <a
                href="{{ route(
                    'storefront.public.home',
                    $storefront->slug
                ) }}#new"
            >
                New
            </a>

            <a
                href="{{ route(
                    'storefront.public.home',
                    $storefront->slug
                ) }}#collections"
            >
                Collections
            </a>

            <a
                href="{{ route(
                    'storefront.public.home',
                    $storefront->slug
                ) }}#shop"
            >
                All products
            </a>

        </nav>



        {{-- HEADER ACTIONS --}}

        <div class="bq-header__actions">


            {{-- SEARCH --}}

            <div class="bq-search-area sf-search-area">

                <div class="bq-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="search"
                        id="storefrontSearchInput"
                        placeholder="Search"
                        autocomplete="off"
                        aria-label="Search products"
                    >

                    <button
                        type="button"
                        class="bq-search__clear"
                        id="storefrontSearchClear"
                        aria-label="Clear search"
                    >
                        <i class="bi bi-x-lg"></i>
                    </button>

                </div>

                <div
                    class="bq-search-results"
                    id="storefrontSearchResults"
                ></div>

            </div>



            <button
                type="button"
                class="bq-mobile-search"
                id="storefrontMobileSearch"
                aria-label="Search products"
            >
                <i class="bi bi-search"></i>
            </button>



            {{-- BAG --}}

            <button
                type="button"
                class="bq-bag"
                id="storefrontCartButton"
                aria-label="Open shopping bag"
            >

                <i class="bi bi-bag"></i>

                <span>
                    Bag
                </span>

                <strong
                    id="storefrontCartCount"
                    class="bq-bag__count"
                >
                    0
                </strong>

            </button>

        </div>

    </div>

</header>



{{-- ================================================================
    PAGE CONTENT
================================================================ --}}

<main class="bq-main">

    @yield('content')

</main>



{{-- ================================================================
    FOOTER
================================================================ --}}

<footer
    class="bq-footer"
    id="bqContact"
>

    <div class="bq-shell">


        <div class="bq-footer__top">


            <div class="bq-footer__brand-block">

                <a
                    href="{{ route(
                        'storefront.public.home',
                        $storefront->slug
                    ) }}"
                    class="bq-footer__brand"
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
                    Discover what’s available and shop securely online.
                </p>

            </div>



            <div class="bq-footer__links">

                <div>

                    <span class="bq-footer__label">
                        Shop
                    </span>

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
                        ) }}#collections"
                    >
                        Collections
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



                <div>

                    <span class="bq-footer__label">
                        Your order
                    </span>

                    <a
                        href="{{ route(
                            'storefront.public.cart',
                            $storefront->slug
                        ) }}"
                    >
                        Shopping bag
                    </a>

                </div>



                <div>

                    <span class="bq-footer__label">
                        Contact
                    </span>

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

        </div>



        <div class="bq-footer__bottom">

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



{{-- ================================================================
    CART DRAWER
================================================================ --}}

<div
    class="bq-drawer-backdrop"
    id="storefrontCartBackdrop"
></div>


<aside
    class="bq-drawer"
    id="storefrontCartDrawer"
    aria-hidden="true"
>


    <div class="bq-drawer__header">

        <div>

            <span>
                Your bag
            </span>

            <h2>
                Shopping bag
            </h2>

        </div>

        <button
            type="button"
            class="bq-drawer__close"
            id="storefrontCartClose"
            aria-label="Close shopping bag"
        >
            <i class="bi bi-x-lg"></i>
        </button>

    </div>



    <div
        class="bq-drawer__items"
        id="storefrontDrawerItems"
    ></div>



    <div
        class="bq-drawer__empty"
        id="storefrontDrawerEmpty"
        hidden
    >

        <i class="bi bi-bag"></i>

        <h3>
            Your bag is empty
        </h3>

        <p>
            Add something you like and it’ll appear here.
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
        class="bq-drawer__footer"
        id="storefrontDrawerFooter"
    >

        <div class="bq-drawer__subtotal">

            <span>
                Subtotal
            </span>

            <strong
                id="storefrontDrawerSubtotal"
            >
                {{ $currencySymbol ?? ($company->currency_symbol ?: '₦') }}0.00
            </strong>

        </div>

        <p>
            Delivery is calculated during checkout.
        </p>

        <a
            href="{{ route(
                'storefront.public.cart',
                $storefront->slug
            ) }}"
            class="bq-drawer__checkout"
        >

            View bag

            <i class="bi bi-arrow-right"></i>

        </a>

    </div>

</aside>



{{-- ================================================================
    TOASTS
================================================================ --}}

<div
    class="bq-toast-stack"
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