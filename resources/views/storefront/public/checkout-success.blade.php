@extends('storefront.public.layouts.app')


@section('content')

<main
    class="shop-order-result"
    data-clear-storefront-cart="true"
>

    <div class="shop-order-result-card">

        <div class="shop-order-result-icon success">

            <i class="bi bi-check-lg"></i>

        </div>


        <span class="shop-order-result-kicker">
            Payment confirmed
        </span>


        <h1>
            Your order is in.
        </h1>


        <p>
            Thank you, {{ $order->customer?->first_name }}.
            Your payment has been confirmed and your order is now being processed.
        </p>


        <div class="shop-order-result-details">

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
                    {{ $currencySymbol }}
                    {{ number_format(
                        (float) $order->grand_total,
                        2
                    ) }}
                </strong>

            </div>

        </div>


        <a
            href="{{ route(
                'storefront.public.home',
                [
                    'storefrontSlug' =>
                        $storefront->slug
                ]
            ) }}"
            class="shop-order-result-button"
        >
            Continue shopping
        </a>

    </div>

</main>


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