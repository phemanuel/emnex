@extends(
    'storefront.public.themes.marketplace.layout'
)


@section(
    'title',
    'Shopping Cart | ' .
    $storefront->name
)


@section('content')


<section class="marketplace-cart-page">

    <div class="marketplace-container">


        {{-- ====================================================
            BREADCRUMB
        ===================================================== --}}

        <div class="marketplace-breadcrumb">

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
                Shopping Cart
            </span>

        </div>



        {{-- ====================================================
            PAGE HEADING
        ===================================================== --}}

        <div class="marketplace-cart-heading">


            <div>

                <span class="marketplace-cart-heading-label">

                    <i class="bi bi-cart3"></i>

                    Your order

                </span>


                <h1>
                    Shopping cart
                </h1>


                <p>
                    Review your products and quantities
                    before continuing to checkout.
                </p>

            </div>



            <a
                href="{{ route(
                    'storefront.public.home',
                    $storefront->slug
                ) }}#shop"
                class="marketplace-cart-continue"
            >

                <i class="bi bi-arrow-left"></i>

                Continue shopping

            </a>

        </div>



        {{-- ====================================================
            CART SERVICE BAR
        ===================================================== --}}

        <div class="marketplace-cart-service-bar">


            <div>

                <i class="bi bi-box-seam"></i>

                <span>

                    <strong>
                        Live availability
                    </strong>

                    Stock checked before order submission

                </span>

            </div>



            <div>

                <i class="bi bi-shield-check"></i>

                <span>

                    <strong>
                        Secure checkout
                    </strong>

                    Protected online ordering

                </span>

            </div>



            <div>

                <i class="bi bi-credit-card"></i>

                <span>

                    <strong>
                        Online payment
                    </strong>

                    Complete payment securely

                </span>

            </div>

        </div>



        {{-- ====================================================
            CART
        ===================================================== --}}

        <div
            class="marketplace-cart-layout"
            id="storefrontCartPage"
            data-currency-symbol="{{ $currencySymbol }}"
        >


            {{-- =================================================
                ITEMS
            ================================================== --}}

            <div class="marketplace-cart-main">


                <div class="marketplace-cart-main-heading">


                    <div>

                        <span>
                            Cart items
                        </span>

                        <h2>
                            Products in your cart
                        </h2>

                    </div>


                    <span class="marketplace-cart-stock-label">

                        <i class="bi bi-check-circle"></i>

                        Availability checked at checkout

                    </span>

                </div>



                <div
                    id="storefrontCartItems"
                    class="marketplace-cart-items"
                ></div>



                {{-- Empty state --}}

                <div
                    id="storefrontEmptyCart"
                    class="marketplace-cart-empty-state"
                    hidden
                >


                    <span class="marketplace-cart-empty-icon">

                        <i class="bi bi-cart3"></i>

                    </span>


                    <h2>
                        Your cart is empty
                    </h2>


                    <p>
                        Browse the catalogue and add
                        products you want to order.
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



                {{-- Cart information --}}

                <div class="marketplace-cart-information">


                    <div>

                        <span>

                            <i class="bi bi-info-circle"></i>

                        </span>


                        <p>

                            Product prices and availability
                            are validated again when you
                            proceed to checkout.

                        </p>

                    </div>


                    <a
                        href="{{ route(
                            'storefront.public.home',
                            $storefront->slug
                        ) }}#shop"
                    >

                        Add more products

                        <i class="bi bi-plus-lg"></i>

                    </a>

                </div>

            </div>



            {{-- =================================================
                ORDER SUMMARY
            ================================================== --}}

            <aside
                class="marketplace-cart-summary"
                id="storefrontCartSummary"
            >


                <div class="marketplace-cart-summary-heading">

                    <span>
                        Order summary
                    </span>

                    <h2>
                        Cart total
                    </h2>

                </div>



                <div class="marketplace-cart-summary-body">


                    <div class="marketplace-cart-summary-row">

                        <span>
                            Items
                        </span>

                        <strong id="cartSummaryItems">
                            0
                        </strong>

                    </div>



                    <div class="marketplace-cart-summary-row">

                        <span>
                            Delivery
                        </span>

                        <small>
                            Calculated at checkout
                        </small>

                    </div>



                    <div class="marketplace-cart-summary-divider"></div>



                    <div class="marketplace-cart-summary-total">


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



                <button
                    type="button"
                    id="storefrontCheckoutButton"
                    class="marketplace-cart-checkout"
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
                            Continue securely
                        </small>

                        <strong>
                            Proceed to checkout
                        </strong>

                    </span>


                    <i class="bi bi-arrow-right"></i>

                </button>



                <div class="marketplace-cart-summary-security">


                    <i class="bi bi-shield-lock"></i>


                    <span>

                        <strong>
                            Secure checkout
                        </strong>

                        Your order will be verified
                        before payment.

                    </span>

                </div>



                <a
                    href="{{ route(
                        'storefront.public.home',
                        $storefront->slug
                    ) }}#shop"
                    class="marketplace-cart-summary-continue"
                >

                    <i class="bi bi-arrow-left"></i>

                    Continue shopping

                </a>

            </aside>

        </div>

    </div>

</section>


@endsection