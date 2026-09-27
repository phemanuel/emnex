@extends('storefront.public.layouts.app')


@section('content')

<main class="shop-order-result">

    <div class="shop-order-result-card">

        <div class="shop-order-result-icon failed">

            <i class="bi bi-x-lg"></i>

        </div>


        <span class="shop-order-result-kicker">
            Payment not confirmed
        </span>


        <h1>
            We couldn’t complete the order.
        </h1>


        <p>
            {{ $message }}
        </p>


        @if($storefront)

            <div class="shop-order-result-actions">

                <a
                    href="{{ route(
                        'storefront.public.checkout',
                        [
                            'storefrontSlug' =>
                                $storefront->slug
                        ]
                    ) }}"
                    class="shop-order-result-button"
                >
                    Try again
                </a>


                <a
                    href="{{ route(
                        'storefront.public.cart',
                        [
                            'storefrontSlug' =>
                                $storefront->slug
                        ]
                    ) }}"
                    class="shop-order-result-link"
                >
                    Return to bag
                </a>

            </div>

        @endif

    </div>

</main>

@endsection