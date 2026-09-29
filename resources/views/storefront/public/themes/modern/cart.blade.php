@extends(
    'storefront.public.themes.modern.layout'
)


@section(
    'title',
    'Your Cart | ' .
    $storefront->name
)


@section('content')


{{-- ============================================================
    CART PAGE
============================================================= --}}

<section class="modern-cart-page">

    <div class="modern-container">


        {{-- ====================================================
            BREADCRUMB
        ===================================================== --}}

        <div class="modern-breadcrumb">

            <a
                href="{{ route(
                    'storefront.public.home',
                    $storefront->slug
                ) }}"
            >
                Home
            </a>

            <i class="bi bi-chevron-right"></i>

            <span>
                Your cart
            </span>

        </div>



        {{-- ====================================================
            PAGE HEADING
        ===================================================== --}}

        <div class="modern-cart-page-heading">

            <div>

                <span class="modern-cart-page-eyebrow">
                    Shopping cart
                </span>

                <h1>
                    Review your items
                </h1>

                <p>
                    Check your quantities before continuing
                    to checkout.
                </p>

            </div>


            <a
                href="{{ route(
                    'storefront.public.home',
                    $storefront->slug
                ) }}#shop"
                class="modern-cart-continue"
            >

                <i class="bi bi-arrow-left"></i>

                Continue shopping

            </a>

        </div>



        {{-- ====================================================
            CHECKOUT PROGRESS
        ===================================================== --}}

        <div class="modern-checkout-progress">

            <div class="modern-progress-step is-active">

                <span>
                    <i class="bi bi-bag-check"></i>
                </span>

                <div>

                    <small>
                        Step 1
                    </small>

                    <strong>
                        Cart
                    </strong>

                </div>

            </div>


            <div class="modern-progress-line"></div>


            <div class="modern-progress-step">

                <span>
                    <i class="bi bi-person"></i>
                </span>

                <div>

                    <small>
                        Step 2
                    </small>

                    <strong>
                        Details
                    </strong>

                </div>

            </div>


            <div class="modern-progress-line"></div>


            <div class="modern-progress-step">

                <span>
                    <i class="bi bi-credit-card"></i>
                </span>

                <div>

                    <small>
                        Step 3
                    </small>

                    <strong>
                        Payment
                    </strong>

                </div>

            </div>

        </div>



        {{-- ====================================================
            CART LAYOUT
        ===================================================== --}}

        <div
            class="modern-cart-layout"
            id="storefrontCartPage"
            data-currency-symbol="{{ $currencySymbol }}"
        >


            {{-- ================================================
                CART ITEMS
            ================================================= --}}

            <div class="modern-cart-main">


                <div class="modern-cart-items-header">

                    <div>

                        <span>
                            Your selection
                        </span>

                        <h2>
                            Cart items
                        </h2>

                    </div>


                    <span class="modern-cart-stock-note">

                        <i class="bi bi-box-seam"></i>

                        Live stock

                    </span>

                </div>



                {{-- JS renders cart items here --}}

                <div
                    id="storefrontCartItems"
                    class="modern-cart-items"
                ></div>



                {{-- ============================================
                    EMPTY CART
                ============================================= --}}

                <div
                    id="storefrontEmptyCart"
                    class="modern-cart-page-empty"
                    hidden
                >

                    <span class="modern-cart-page-empty-icon">

                        <i class="bi bi-bag"></i>

                    </span>


                    <span class="modern-cart-page-empty-label">
                        Your cart
                    </span>


                    <h2>
                        Your cart is empty.
                    </h2>


                    <p>
                        Find something you like and add it
                        to your cart to get started.
                    </p>


                    <a
                        href="{{ route(
                            'storefront.public.home',
                            $storefront->slug
                        ) }}#shop"
                    >

                        Browse products

                        <i class="bi bi-arrow-right"></i>

                    </a>

                </div>



                {{-- ============================================
                    CART SUPPORT
                ============================================= --}}

                <div class="modern-cart-support">


                    <div>

                        <span>

                            <i class="bi bi-arrow-repeat"></i>

                        </span>


                        <div>

                            <strong>
                                Change your mind?
                            </strong>

                            <p>
                                Adjust quantities or remove
                                items before checkout.
                            </p>

                        </div>

                    </div>



                    <div>

                        <span>

                            <i class="bi bi-shield-check"></i>

                        </span>


                        <div>

                            <strong>
                                Availability checked
                            </strong>

                            <p>
                                Prices and stock are validated
                                again during checkout.
                            </p>

                        </div>

                    </div>

                </div>

            </div>



            {{-- ================================================
                ORDER SUMMARY
            ================================================= --}}

            <aside
                class="modern-order-summary"
                id="storefrontCartSummary"
            >


                <div class="modern-order-summary-head">

                    <span>
                        Order summary
                    </span>

                    <h2>
                        Your total
                    </h2>

                </div>



                <div class="modern-order-summary-body">


                    {{-- Items --}}

                    <div class="modern-summary-row">

                        <span>
                            Items
                        </span>

                        <strong
                            id="cartSummaryItems"
                        >
                            0
                        </strong>

                    </div>



                    {{-- Delivery --}}

                    <div class="modern-summary-row">

                        <span>
                            Delivery
                        </span>

                        <small>
                            Calculated at checkout
                        </small>

                    </div>



                    <div class="modern-summary-divider"></div>



                    {{-- Subtotal --}}

                    <div class="modern-summary-total">

                        <div>

                            <span>
                                Subtotal
                            </span>

                            <small>
                                Before delivery
                            </small>

                        </div>


                        <strong
                            id="cartSummarySubtotal"
                        >
                            {{ $currencySymbol }}0.00
                        </strong>

                    </div>

                </div>



                {{-- Checkout --}}

                <button
                    type="button"
                    id="storefrontCheckoutButton"
                    class="modern-checkout-button"
                    data-checkout-url="{{ route(
                        'storefront.public.checkout',
                        [
                            'storefrontSlug' =>
                                $storefront->slug
                        ]
                    ) }}"
                >

                    <span>

                        <small>
                            Ready to order?
                        </small>

                        <strong>
                            Proceed to checkout
                        </strong>

                    </span>


                    <i class="bi bi-arrow-right"></i>

                </button>



                {{-- Security --}}

                <div class="modern-summary-security">

                    <i class="bi bi-lock"></i>

                    <span>

                        <strong>
                            Secure checkout
                        </strong>

                        Your payment is completed through
                        a protected payment process.

                    </span>

                </div>



                {{-- Continue Shopping --}}

                <a
                    href="{{ route(
                        'storefront.public.home',
                        $storefront->slug
                    ) }}#shop"
                    class="modern-summary-continue"
                >

                    Continue shopping

                </a>

            </aside>

        </div>

    </div>

</section>


@endsection