@extends(
    'storefront.public.themes.boutique.layout'
)


@section(
    'title',
    'Payment Not Confirmed | ' .
    $storefront->name
)


@section('content')


<section class="bq-result bq-result--failed">

    <div class="bq-shell">


        <div class="bq-result__card">


            <div class="bq-result__icon">

                <i class="bi bi-x-lg"></i>

            </div>


            <span class="bq-eyebrow">
                Payment not confirmed
            </span>


            <h1>
                We couldn’t complete your order.
            </h1>


            <p>
                {{ $message }}
            </p>



            <div class="bq-result__notice">

                <i class="bi bi-bag"></i>

                <div>

                    <strong>
                        Your shopping bag is still available.
                    </strong>

                    <span>
                        Review your order or try payment again.
                    </span>

                </div>

            </div>



            <div class="bq-result__actions">

                <a
                    href="{{ route(
                        'storefront.public.checkout',
                        [
                            'storefrontSlug' =>
                                $storefront->slug
                        ]
                    ) }}"
                    class="bq-button bq-button--accent"
                >

                    Try again

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
                    class="bq-button bq-button--ghost"
                >
                    Return to bag
                </a>

            </div>



            @if(
                $company &&
                (
                    $company->phone ||
                    $company->email
                )
            )

                <div class="bq-result__support">

                    <span>
                        Need help?
                    </span>


                    @if($company->phone)

                        <a href="tel:{{ $company->phone }}">

                            <i class="bi bi-telephone"></i>

                            {{ $company->phone }}

                        </a>

                    @endif


                    @if($company->email)

                        <a href="mailto:{{ $company->email }}">

                            <i class="bi bi-envelope"></i>

                            {{ $company->email }}

                        </a>

                    @endif

                </div>

            @endif

        </div>

    </div>

</section>


@endsection