@extends(
    'storefront.public.themes.marketplace.layout'
)


@section(
    'title',
    'Payment Unsuccessful | ' .
    $storefront->name
)


@section('content')


<section class="marketplace-order-result-page">

    <div class="marketplace-container">

        <div class="marketplace-order-result-shell">


            {{-- =================================================
                STATUS
            ================================================== --}}

            <div class="marketplace-order-result-status is-failed">


                <span class="marketplace-order-result-icon">

                    <i class="bi bi-x-lg"></i>

                </span>


                <div>

                    <span>
                        Payment not confirmed
                    </span>

                    <h1>
                        We couldn’t complete your order
                    </h1>

                </div>

            </div>



            {{-- =================================================
                MESSAGE
            ================================================== --}}

            <div class="marketplace-order-result-intro">

                <p>
                    {{ $message }}
                </p>

            </div>



            {{-- =================================================
                CART STATUS
            ================================================== --}}

            <div class="marketplace-payment-failed-card">


                <span>

                    <i class="bi bi-cart-check"></i>

                </span>


                <div>

                    <strong>
                        Your cart is still available
                    </strong>


                    <p>
                        Your products have not been removed.
                        You can review your cart or restart
                        the checkout process.
                    </p>

                </div>

            </div>



            {{-- =================================================
                NEXT OPTIONS
            ================================================== --}}

            <div class="marketplace-payment-options">


                <div class="marketplace-payment-options-heading">

                    <span>
                        Next steps
                    </span>

                    <h2>
                        What would you like to do?
                    </h2>

                </div>



                <div class="marketplace-payment-options-grid">


                    <div>


                        <span>

                            <i class="bi bi-arrow-repeat"></i>

                        </span>


                        <div>

                            <strong>
                                Try checkout again
                            </strong>


                            <small>
                                Return to checkout and restart
                                the payment process.
                            </small>

                        </div>

                    </div>



                    <div>


                        <span>

                            <i class="bi bi-cart3"></i>

                        </span>


                        <div>

                            <strong>
                                Review your cart
                            </strong>


                            <small>
                                Check products and quantities
                                before trying again.
                            </small>

                        </div>

                    </div>

                </div>

            </div>



            {{-- =================================================
                ACTIONS
            ================================================== --}}

            <div class="marketplace-order-result-actions">


                <a
                    href="{{ route(
                        'storefront.public.checkout',
                        [
                            'storefrontSlug' =>
                                $storefront->slug
                        ]
                    ) }}"
                    class="marketplace-order-result-primary"
                >

                    Try checkout again

                    <i class="bi bi-arrow-right"></i>

                </a>



                <a
                    href="{{ route(
                        'storefront.public.cart',
                        [
                            'storefrontSlug' =>
                                $storefront->slug
                        ]
                    ) }}"
                    class="marketplace-order-result-secondary"
                >

                    <i class="bi bi-cart3"></i>

                    Review cart

                </a>

            </div>



            {{-- =================================================
                NOTE
            ================================================== --}}

            <div class="marketplace-order-result-note">

                <i class="bi bi-info-circle"></i>


                <span>

                    <strong>
                        Payment status
                    </strong>

                    An order is treated as successfully
                    paid only after payment confirmation.

                </span>

            </div>

        </div>

    </div>

</section>


@endsection