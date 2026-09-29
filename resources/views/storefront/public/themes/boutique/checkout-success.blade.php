@extends(
    'storefront.public.themes.boutique.layout'
)


@section(
    'title',
    'Order Confirmed | ' .
    $storefront->name
)


@section('content')


<section
    class="bq-result bq-result--success"
    data-clear-storefront-cart="true"
>

    <div class="bq-shell">


        <div class="bq-result__card">


            <div class="bq-result__icon">

                <i class="bi bi-check-lg"></i>

            </div>


            <span class="bq-eyebrow">
                Payment confirmed
            </span>


            <h1>
                Your order is confirmed.
            </h1>


            <p>

                Thank you{{ $order->customer?->first_name
                    ? ', ' . $order->customer->first_name
                    : ''
                }}.

                Your payment has been confirmed
                and your order is now being processed.

            </p>



            <div class="bq-result__details">


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



            <div class="bq-result__actions">

                <a
                    href="{{ route(
                        'storefront.public.home',
                        $storefront->slug
                    ) }}#shop"
                    class="bq-button bq-button--accent"
                >

                    Continue shopping

                    <i class="bi bi-arrow-right"></i>

                </a>

            </div>

        </div>

    </div>

</section>


@endsection


@push('scripts')

<script>

window.addEventListener(
    'load',
    function () {

        if (
            window.PublicStorefront &&
            typeof window.PublicStorefront.clearCart ===
                'function'
        ) {

            window.PublicStorefront.clearCart();

        }

    }
);

</script>

@endpush