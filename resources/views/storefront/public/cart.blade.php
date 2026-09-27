@extends('storefront.public.layouts.app')


@section(
    'title',
    'Shopping Bag | ' .
    $storefront->name
)


@section('content')


<section class="shop-cart-page">

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

            <span>/</span>

            <span>
                Shopping Bag
            </span>

        </div>


        <div class="shop-cart-heading">

            <div>

                <span>
                    Your selection
                </span>

                <h1>
                    Shopping Bag
                </h1>

            </div>


            <a
                href="{{ route(
                    'storefront.public.home',
                    $storefront->slug
                ) }}#shop"
            >
                Continue shopping

                <i class="bi bi-arrow-right"></i>
            </a>

        </div>


        <div
            class="shop-cart-layout"
            id="storefrontCartPage"
            data-currency-symbol="{{ $currencySymbol }}"
        >


            <div class="shop-cart-main">


                <div
                    id="storefrontCartItems"
                    class="shop-cart-items"
                ></div>


                <div
                    id="storefrontEmptyCart"
                    class="shop-cart-empty"
                    hidden
                >

                    <i class="bi bi-bag"></i>

                    <h2>
                        Your bag is empty.
                    </h2>

                    <p>
                        Find something you love and add it here.
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


            </div>


            <aside
                class="shop-order-summary"
                id="storefrontCartSummary"
            >

                <span class="shop-order-summary-label">
                    Summary
                </span>

                <h2>
                    Your order
                </h2>


                <div class="shop-summary-line">

                    <span>
                        Items
                    </span>

                    <strong
                        id="cartSummaryItems"
                    >
                        0
                    </strong>

                </div>


                <div class="shop-summary-line">

                    <span>
                        Delivery
                    </span>

                    <small>
                        Calculated at checkout
                    </small>

                </div>


                <div class="shop-summary-total">

                    <span>
                        Subtotal
                    </span>

                    <strong
                        id="cartSummarySubtotal"
                    >
                        {{ $currencySymbol }}0.00
                    </strong>

                </div>


                <button
                    type="button"
                    id="storefrontCheckoutButton"
                    class="shop-checkout-button"
                    data-checkout-url="{{ route(
                        'storefront.public.checkout',
                        [
                            'storefrontSlug' => $storefront->slug
                        ]
                    ) }}"
                >
                    Proceed to checkout
                </button>


                <p class="shop-summary-note">

                    Prices and availability are confirmed
                    again before your order is submitted.

                </p>

            </aside>


        </div>

    </div>

</section>


@endsection