@extends(
    'storefront.public.themes.boutique.layout'
)


@section(
    'title',
    'Shopping Bag | ' .
    $storefront->name
)


@section('content')


<section class="bq-cart-page">

    <div class="bq-shell">


        <div class="bq-breadcrumb">

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
                Shopping bag
            </span>

        </div>



        <div class="bq-cart-head">

            <div>

                <span class="bq-eyebrow">
                    Your order
                </span>

                <h1>
                    Shopping bag
                </h1>

            </div>


            <a
                href="{{ route(
                    'storefront.public.home',
                    $storefront->slug
                ) }}#shop"
                class="bq-section-link"
            >

                Continue shopping

                <i class="bi bi-arrow-right"></i>

            </a>

        </div>



        <div
            class="bq-cart"
            id="storefrontCartPage"
            data-currency-symbol="{{ $currencySymbol }}"
        >


            {{-- ITEMS --}}

            <div class="bq-cart__main">


                <div class="bq-cart__labels">

                    <span>
                        Product
                    </span>

                    <span>
                        Quantity
                    </span>

                    <span>
                        Total
                    </span>

                </div>


                <div
                    class="bq-cart__items"
                    id="storefrontCartItems"
                ></div>



                <div
                    class="bq-cart__empty"
                    id="storefrontEmptyCart"
                    hidden
                >

                    <i class="bi bi-bag"></i>

                    <h2>
                        Your bag is empty.
                    </h2>

                    <p>
                        Add something you like to get started.
                    </p>

                    <a
                        href="{{ route(
                            'storefront.public.home',
                            $storefront->slug
                        ) }}#shop"
                        class="bq-button bq-button--accent"
                    >
                        Start shopping
                    </a>

                </div>

            </div>



            {{-- SUMMARY --}}

            <aside
                class="bq-cart-summary"
                id="storefrontCartSummary"
            >

                <h2>
                    Order summary
                </h2>


                <div class="bq-cart-summary__row">

                    <span>
                        Items
                    </span>

                    <strong
                        id="cartSummaryItems"
                    >
                        0
                    </strong>

                </div>


                <div class="bq-cart-summary__row">

                    <span>
                        Delivery
                    </span>

                    <small>
                        Calculated at checkout
                    </small>

                </div>


                <div class="bq-cart-summary__total">

                    <span>
                        Subtotal
                    </span>

                    <strong
                        id="cartSummarySubtotal"
                    >
                        {{ $currencySymbol }}0.00
                    </strong>

                </div>



                <button
                    type="button"
                    class="bq-cart-summary__checkout"
                    id="storefrontCheckoutButton"
                    data-checkout-url="{{ route(
                        'storefront.public.checkout',
                        [
                            'storefrontSlug' =>
                                $storefront->slug
                        ]
                    ) }}"
                >

                    Checkout

                    <i class="bi bi-arrow-right"></i>

                </button>


                <p>

                    Prices and stock are confirmed again
                    before your order is submitted.

                </p>


                <div class="bq-cart-summary__secure">

                    <i class="bi bi-shield-check"></i>

                    Secure online checkout

                </div>

            </aside>

        </div>

    </div>

</section>


@endsection