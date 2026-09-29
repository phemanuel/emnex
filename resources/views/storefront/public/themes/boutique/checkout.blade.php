@extends(
    'storefront.public.themes.boutique.layout'
)


@section(
    'title',
    'Checkout | ' .
    $storefront->name
)


@section('content')


<section
    class="bq-checkout-page"
    id="storefrontCheckout"
    data-storefront-slug="{{ $storefront->slug }}"
    data-quote-url="{{ route(
        'storefront.public.checkout.quote',
        [
            'storefrontSlug' =>
                $storefront->slug
        ]
    ) }}"
    data-pay-url="{{ route(
        'storefront.public.checkout.initialize',
        [
            'storefrontSlug' =>
                $storefront->slug
        ]
    ) }}"
    data-cart-url="{{ route(
        'storefront.public.cart',
        [
            'storefrontSlug' =>
                $storefront->slug
        ]
    ) }}"
>


    <div class="bq-shell">


        {{-- HEADER --}}

        <div class="bq-checkout-head">

            <div>

                <a
                    href="{{ route(
                        'storefront.public.cart',
                        $storefront->slug
                    ) }}"
                    class="bq-checkout-head__back"
                >
                    <i class="bi bi-arrow-left"></i>
                    Back to bag
                </a>


                <span class="bq-eyebrow">
                    Secure checkout
                </span>

                <h1>
                    Complete your order
                </h1>

            </div>

        </div>



        <div
            class="bq-checkout-alert"
            id="checkoutAlert"
            hidden
        ></div>



        <div class="bq-checkout">


            {{-- FORM --}}

            <div class="bq-checkout__form">


                <form
                    id="storefrontCheckoutForm"
                    novalidate
                >

                    @csrf



                    {{-- CONTACT --}}

                    <section class="bq-checkout-card">

                        <div class="bq-checkout-card__head">

                            <span>
                                1
                            </span>

                            <div>

                                <h2>
                                    Contact details
                                </h2>

                                <p>
                                    For order updates and confirmation.
                                </p>

                            </div>

                        </div>



                        <div class="bq-checkout-fields">


                            <div class="bq-field">

                                <label for="first_name">
                                    First name
                                </label>

                                <input
                                    type="text"
                                    id="first_name"
                                    name="first_name"
                                    autocomplete="given-name"
                                    required
                                >

                            </div>



                            <div class="bq-field">

                                <label for="last_name">

                                    Last name

                                    <span>
                                        Optional
                                    </span>

                                </label>

                                <input
                                    type="text"
                                    id="last_name"
                                    name="last_name"
                                    autocomplete="family-name"
                                >

                            </div>



                            <div class="bq-field bq-field--wide">

                                <label for="email">
                                    Email address
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    autocomplete="email"
                                    required
                                >

                            </div>



                            <div class="bq-field bq-field--wide">

                                <label for="phone">
                                    Phone number
                                </label>

                                <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    autocomplete="tel"
                                    required
                                >

                            </div>

                        </div>

                    </section>



                    {{-- DELIVERY --}}

                    <section class="bq-checkout-card">

                        <div class="bq-checkout-card__head">

                            <span>
                                2
                            </span>

                            <div>

                                <h2>
                                    Delivery
                                </h2>

                                <p>
                                    Where should your order go?
                                </p>

                            </div>

                        </div>



                        @if(
                            $shippingSettings?->enabled &&
                            $shippingSettings->shipping_mode === 'location'
                        )

                            <div class="bq-checkout-fields">

                                <div class="bq-field bq-field--wide">

                                    <label for="shipping_location_id">
                                        Shipping location
                                    </label>


                                    <div class="bq-select-wrap">

                                        <select
                                            id="shipping_location_id"
                                            name="shipping_location_id"
                                            class="bq-select"
                                            required
                                        >

                                            <option value="">
                                                Select delivery location
                                            </option>


                                            @foreach(
                                                $shippingLocations
                                                as $location
                                            )

                                                <option
                                                    value="{{ $location->id }}"
                                                >

                                                    {{ $location->name }}

                                                    —

                                                    {{ $currencySymbol }}{{ number_format(
                                                        (float) $location->shipping_fee,
                                                        2
                                                    ) }}

                                                </option>

                                            @endforeach

                                        </select>

                                        <i class="bi bi-chevron-down"></i>

                                    </div>



                                    @if($shippingLocations->isEmpty())

                                        <small class="bq-field__help is-error">

                                            No shipping locations
                                            are currently available.

                                        </small>

                                    @endif

                                </div>

                            </div>

                        @else

                            <div class="bq-checkout-fields">

                                <div class="bq-field bq-field--wide">

                                    <label for="address">
                                        Street address
                                    </label>

                                    <textarea
                                        id="address"
                                        name="address"
                                        rows="3"
                                        autocomplete="street-address"
                                        required
                                    ></textarea>

                                </div>


                                <div class="bq-field">

                                    <label for="city">
                                        City
                                    </label>

                                    <input
                                        type="text"
                                        id="city"
                                        name="city"
                                        autocomplete="address-level2"
                                        required
                                    >

                                </div>


                                <div class="bq-field">

                                    <label for="state">
                                        State
                                    </label>

                                    <input
                                        type="text"
                                        id="state"
                                        name="state"
                                        autocomplete="address-level1"
                                        required
                                    >

                                </div>

                            </div>

                        @endif

                    </section>



                    {{-- PAYMENT --}}

                    <section class="bq-checkout-card">

                        <div class="bq-checkout-card__head">

                            <span>
                                3
                            </span>

                            <div>

                                <h2>
                                    Payment
                                </h2>

                                <p>
                                    Complete payment securely via Paystack.
                                </p>

                            </div>

                        </div>



                        <div class="bq-payment-option">

                            <div class="bq-payment-option__icon">

                                <i class="bi bi-credit-card"></i>

                            </div>

                            <div>

                                <strong>
                                    Online payment
                                </strong>

                                <span>
                                    Securely processed by Paystack
                                </span>

                            </div>

                            <i class="bi bi-check-circle-fill"></i>

                        </div>



                        <button
                            type="submit"
                            class="bq-checkout-pay"
                            id="checkoutPayButton"
                            disabled
                        >

                            <span class="shop-checkout-pay-text">
                                Pay securely
                            </span>

                            <i class="bi bi-arrow-right"></i>


                            <span
                                class="bq-checkout-pay__loader"
                                id="checkoutPayLoader"
                                hidden
                            >
                                Processing...
                            </span>

                        </button>

                    </section>

                </form>

            </div>



            {{-- SUMMARY --}}

            <aside class="bq-checkout-summary">


                <div class="bq-checkout-summary__head">

                    <div>

                        <span class="bq-eyebrow">
                            Your order
                        </span>

                        <h2>
                            Order summary
                        </h2>

                    </div>

                    <span id="checkoutItemCount">
                        0 items
                    </span>

                </div>



                <div
                    class="bq-checkout-summary__loading"
                    id="checkoutLoading"
                >
                    Checking your bag...
                </div>



                <div
                    class="bq-checkout-summary__items"
                    id="checkoutItems"
                    hidden
                ></div>



                <div
                    class="bq-checkout-summary__empty"
                    id="checkoutEmpty"
                    hidden
                >

                    <i class="bi bi-bag"></i>

                    <h3>
                        Your bag is empty
                    </h3>

                    <p>
                        Add something before checking out.
                    </p>

                </div>



                <div
                    class="bq-checkout-summary__totals"
                    id="checkoutTotals"
                    hidden
                >


                    <div>

                        <span>
                            Subtotal
                        </span>

                        <strong
                            id="checkoutSubtotal"
                        >
                            {{ $currencySymbol }}0.00
                        </strong>

                    </div>



                    <div
                        id="checkoutDiscountRow"
                        hidden
                    >

                        <span>
                            Discount
                        </span>

                        <strong
                            id="checkoutDiscount"
                        >
                            {{ $currencySymbol }}0.00
                        </strong>

                    </div>



                    <div
                        id="checkoutTaxRow"
                        hidden
                    >

                        <span>
                            Tax
                        </span>

                        <strong
                            id="checkoutTax"
                        >
                            {{ $currencySymbol }}0.00
                        </strong>

                    </div>



                    <div
                        id="checkoutShippingRow"
                        hidden
                    >

                        <span>
                            Shipping
                        </span>

                        <strong
                            id="checkoutShipping"
                        >
                            {{ $currencySymbol }}0.00
                        </strong>

                    </div>



                    <div class="bq-checkout-summary__total">

                        <span>
                            Total
                        </span>

                        <strong
                            id="checkoutGrandTotal"
                        >
                            {{ $currencySymbol }}0.00
                        </strong>

                    </div>

                </div>



                <div class="bq-checkout-summary__secure">

                    <i class="bi bi-lock"></i>

                    Secure checkout

                </div>

            </aside>

        </div>

    </div>

</section>


@endsection


@push('scripts')

<script
    src="{{ asset(
        'assets/js/storefront-checkout.js'
    ) }}"
    defer
></script>

@endpush