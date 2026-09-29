@extends(
    'storefront.public.themes.modern.layout'
)


@section(
    'title',
    'Payment Unsuccessful | ' .
    ($storefront?->name ?? 'Store')
)


@section('content')


<section class="modern-order-result-page">

    <div class="modern-container">


        <div class="modern-order-result-shell">


            {{-- =================================================
                FAILED VISUAL
            ================================================== --}}

            <div class="modern-order-result-visual is-failed">


                <div class="modern-order-result-icon">

                    <i class="bi bi-x-lg"></i>

                </div>


                <div class="modern-order-result-rings">

                    <span></span>
                    <span></span>
                    <span></span>

                </div>

            </div>



            {{-- =================================================
                RESULT CONTENT
            ================================================== --}}

            <div class="modern-order-result-content">


                <span class="modern-order-result-eyebrow is-failed">

                    <i class="bi bi-exclamation-circle-fill"></i>

                    Payment not confirmed

                </span>


                <h1>
                    We couldn’t complete your order.
                </h1>


                <p class="modern-order-result-message">

                    {{ $message }}

                </p>



                {{-- =============================================
                    INFORMATION CARD
                ============================================== --}}

                <div class="modern-payment-failed-card">


                    <span class="modern-payment-failed-icon">

                        <i class="bi bi-credit-card"></i>

                    </span>


                    <div>

                        <strong>
                            Your cart is still available
                        </strong>


                        <p>
                            Your items have not been removed.
                            You can review your cart or try
                            the checkout process again.
                        </p>

                    </div>

                </div>



                {{-- =============================================
                    POSSIBLE NEXT STEPS
                ============================================== --}}

                <div class="modern-payment-help">


                    <div class="modern-payment-help-heading">

                        <span>
                            What can you do?
                        </span>

                        <h2>
                            Try one of these options.
                        </h2>

                    </div>



                    <div class="modern-payment-help-grid">


                        <div>

                            <span>

                                <i class="bi bi-arrow-repeat"></i>

                            </span>


                            <div>

                                <strong>
                                    Try payment again
                                </strong>

                                <small>
                                    Return to checkout and restart
                                    the secure payment process.
                                </small>

                            </div>

                        </div>



                        <div>

                            <span>

                                <i class="bi bi-bag-check"></i>

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



                {{-- =============================================
                    ACTIONS
                ============================================== --}}

                @if($storefront)

                    <div class="modern-order-result-actions">


                        <a
                            href="{{ route(
                                'storefront.public.checkout',
                                [
                                    'storefrontSlug' =>
                                        $storefront->slug
                                ]
                            ) }}"
                            class="modern-order-result-primary"
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
                            class="modern-order-result-secondary"
                        >

                            <i class="bi bi-bag"></i>

                            Review cart

                        </a>

                    </div>

                @endif



                {{-- =============================================
                    PAYMENT NOTE
                ============================================== --}}

                <div class="modern-order-result-note">

                    <i class="bi bi-info-circle"></i>


                    <span>

                        <strong>
                            Payment status
                        </strong>

                        An order is only treated as successfully
                        paid after payment confirmation.

                    </span>

                </div>

            </div>

        </div>

    </div>

</section>


@endsection