@extends(
    'storefront.public.themes.marketplace.layout'
)


@section(
    'title',
    'Order Confirmed | ' .
    $storefront->name
)


@section('content')


<section
    class="marketplace-order-result-page"
    data-clear-storefront-cart="true"
>

    <div class="marketplace-container">

        <div class="marketplace-order-result-shell">


            {{-- =================================================
                STATUS
            ================================================== --}}

            <div class="marketplace-order-result-status is-success">


                <span class="marketplace-order-result-icon">

                    <i class="bi bi-check-lg"></i>

                </span>


                <div>

                    <span>
                        Payment confirmed
                    </span>

                    <h1>
                        Order successfully placed
                    </h1>

                </div>

            </div>



            {{-- =================================================
                INTRO
            ================================================== --}}

            <div class="marketplace-order-result-intro">

                <p>

                    Thank you@if($order->customer?->first_name),
                        {{ $order->customer->first_name }}
                    @endif.

                    Your payment has been confirmed and
                    {{ $storefront->name }} has received
                    your order.

                </p>

            </div>



            {{-- =================================================
                ORDER DETAILS
            ================================================== --}}

            <div class="marketplace-order-confirmation">


                <div class="marketplace-order-confirmation-heading">


                    <div>

                        <span>
                            Order confirmation
                        </span>

                        <h2>
                            Order details
                        </h2>

                    </div>


                    <span class="marketplace-order-confirmed-badge">

                        <i class="bi bi-check-circle-fill"></i>

                        Confirmed

                    </span>

                </div>



                <div class="marketplace-order-confirmation-grid">


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
                            Payment status
                        </span>

                        <strong class="is-success">
                            Paid
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



                    <div>

                        <span>
                            Order status
                        </span>

                        <strong>
                            Processing
                        </strong>

                    </div>

                </div>

            </div>



            {{-- =================================================
                NEXT STEPS
            ================================================== --}}

            <div class="marketplace-order-next">


                <div class="marketplace-order-next-heading">

                    <span>
                        What happens next
                    </span>

                    <h2>
                        Your order is being processed
                    </h2>

                </div>



                <div class="marketplace-order-next-grid">


                    <div class="is-complete">


                        <span>

                            <i class="bi bi-check-lg"></i>

                        </span>


                        <div>

                            <strong>
                                Payment received
                            </strong>

                            <small>
                                Your payment has been confirmed.
                            </small>

                        </div>

                    </div>



                    <div class="is-active">


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



                    <div>


                        <span>

                            <i class="bi bi-truck"></i>

                        </span>


                        <div>

                            <strong>
                                Fulfilment
                            </strong>

                            <small>
                                Your order will continue through
                                the fulfilment process.
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
                        'storefront.public.home',
                        [
                            'storefrontSlug' =>
                                $storefront->slug
                        ]
                    ) }}#shop"
                    class="marketplace-order-result-primary"
                >

                    Continue shopping

                    <i class="bi bi-arrow-right"></i>

                </a>


                <a
                    href="{{ route(
                        'storefront.public.home',
                        [
                            'storefrontSlug' =>
                                $storefront->slug
                        ]
                    ) }}"
                    class="marketplace-order-result-secondary"
                >

                    Back to store

                </a>

            </div>



            {{-- =================================================
                NOTE
            ================================================== --}}

            <div class="marketplace-order-result-note">

                <i class="bi bi-shield-check"></i>


                <span>

                    <strong>
                        Payment complete
                    </strong>

                    No additional payment is required
                    for this order.

                </span>

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