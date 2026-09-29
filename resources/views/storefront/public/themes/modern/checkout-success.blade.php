@extends(
    'storefront.public.themes.modern.layout'
)


@section(
    'title',
    'Order Confirmed | ' .
    $storefront->name
)


@section('content')


<section
    class="modern-order-result-page"
    data-clear-storefront-cart="true"
>

    <div class="modern-container">


        <div class="modern-order-result-shell">


            {{-- =================================================
                SUCCESS VISUAL
            ================================================== --}}

            <div class="modern-order-result-visual is-success">


                <div class="modern-order-result-icon">

                    <i class="bi bi-check-lg"></i>

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


                <span class="modern-order-result-eyebrow is-success">

                    <i class="bi bi-check-circle-fill"></i>

                    Payment confirmed

                </span>


                <h1>
                    Your order is confirmed.
                </h1>


                <p class="modern-order-result-message">

                    Thank you{{ $order->customer?->first_name
                        ? ', ' . $order->customer->first_name
                        : ''
                    }}.

                    Your payment has been confirmed and
                    {{ $storefront->name }} has received
                    your order.

                </p>



                {{-- =============================================
                    ORDER SUMMARY
                ============================================== --}}

                <div class="modern-order-confirmation-card">


                    <div class="modern-order-confirmation-heading">

                        <div>

                            <span>
                                Order details
                            </span>

                            <h2>
                                Confirmation
                            </h2>

                        </div>


                        <span class="modern-order-confirmed-badge">

                            <i class="bi bi-check-lg"></i>

                            Confirmed

                        </span>

                    </div>



                    <div class="modern-order-confirmation-grid">


                        <div>

                            <span>
                                Order number
                            </span>

                            <strong>
                                {{ $order->order_no }}
                            </strong>

                        </div>



                        <div>

                            <span>
                                Amount paid
                            </span>

                            <strong>

                                {{ $currencySymbol }}{{ number_format(
                                    (float) $order->grand_total,
                                    2
                                ) }}

                            </strong>

                        </div>

                    </div>

                </div>



                {{-- =============================================
                    WHAT HAPPENS NEXT
                ============================================== --}}

                <div class="modern-order-next">


                    <div class="modern-order-next-heading">

                        <span>
                            What happens next?
                        </span>

                        <h2>
                            Your order is now being processed.
                        </h2>

                    </div>



                    <div class="modern-order-next-steps">


                        <div class="modern-order-next-step is-complete">

                            <span>

                                <i class="bi bi-check-lg"></i>

                            </span>


                            <div>

                                <strong>
                                    Payment received
                                </strong>

                                <small>
                                    Your payment was successfully confirmed.
                                </small>

                            </div>

                        </div>



                        <div class="modern-order-next-line"></div>



                        <div class="modern-order-next-step is-current">

                            <span>

                                <i class="bi bi-box-seam"></i>

                            </span>


                            <div>

                                <strong>
                                    Order processing
                                </strong>

                                <small>
                                    The store can now prepare your order.
                                </small>

                            </div>

                        </div>



                        <div class="modern-order-next-line"></div>



                        <div class="modern-order-next-step">

                            <span>

                                <i class="bi bi-truck"></i>

                            </span>


                            <div>

                                <strong>
                                    Fulfilment
                                </strong>

                                <small>
                                    Your order will move through its
                                    fulfilment process.
                                </small>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- =============================================
                    ACTION
                ============================================== --}}

                <div class="modern-order-result-actions">


                    <a
                        href="{{ route(
                            'storefront.public.home',
                            [
                                'storefrontSlug' =>
                                    $storefront->slug
                            ]
                        ) }}"
                        class="modern-order-result-primary"
                    >

                        Continue shopping

                        <i class="bi bi-arrow-right"></i>

                    </a>

                </div>



                {{-- =============================================
                    SECURITY NOTE
                ============================================== --}}

                <div class="modern-order-result-note">

                    <i class="bi bi-shield-check"></i>


                    <span>

                        <strong>
                            Payment complete
                        </strong>

                        You do not need to make another
                        payment for this order.

                    </span>

                </div>

            </div>

        </div>

    </div>

</section>



<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        if (
            window.PublicStorefront &&
            typeof window.PublicStorefront.clearCart === 'function'
        ) {

            window.PublicStorefront.clearCart();

        }

    }
);

</script>


@endsection