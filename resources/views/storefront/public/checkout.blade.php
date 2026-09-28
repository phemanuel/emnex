@extends('storefront.public.layouts.app')


@section('content')

<main
    class="shop-checkout"
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

    <div class="shop-checkout-shell">

        <header class="shop-checkout-heading">

            <a
                href="{{ route(
                    'storefront.public.cart',
                    [
                        'storefrontSlug' =>
                            $storefront->slug
                    ]
                ) }}"
                class="shop-checkout-back"
            >
                <i class="bi bi-arrow-left"></i>
                Back to bag
            </a>


            <span class="shop-checkout-kicker">
                Secure checkout
            </span>


            <h1>
                Complete your order
            </h1>

        </header>


        <div
            class="shop-checkout-alert"
            id="checkoutAlert"
            hidden
        ></div>


        <div class="shop-checkout-grid">

            {{-- Customer details --}}
            <section class="shop-checkout-details">

                <form
                    id="storefrontCheckoutForm"
                    novalidate
                >

                    @csrf


                    <div class="shop-checkout-section-heading">

                        <span>
                            01
                        </span>

                        <div>
                            <h2>
                                Contact details
                            </h2>

                            <p>
                                Where should we send your order updates?
                            </p>
                        </div>

                    </div>


                    <div class="shop-checkout-fields">

                        <div class="shop-field">

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


                        <div class="shop-field">

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


                        <div class="shop-field shop-field-wide">

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


                        <div class="shop-field shop-field-wide">

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


                    <div class="shop-checkout-divider"></div>


                    <div class="shop-checkout-section-heading">

                        <span>
                            02
                        </span>

                        <div>

                            <h2>
                                Delivery
                            </h2>

                            <p>
                                Tell us where this order should go.
                            </p>

                        </div>

                    </div>


                    @if(
                        $shippingSettings?->enabled &&
                        $shippingSettings->shipping_mode === 'location'
                    )

                        {{-- ======================================================
                            PREDEFINED SHIPPING LOCATION
                        ======================================================= --}}

                        <div class="shop-checkout-fields">

                            <div class="shop-field shop-field-wide shop-shipping-field">

                                <label for="shipping_location_id">
                                    Shipping location
                                </label>

                                <div class="shop-shipping-select-wrap">

                                    <i class="bi bi-geo-alt shop-shipping-select-icon"></i>

                                    <select
                                        id="shipping_location_id"
                                        name="shipping_location_id"
                                        class="shop-shipping-select"
                                        required
                                    >

                                        <option value="">
                                            Select your delivery location
                                        </option>

                                        @foreach($shippingLocations as $location)

                                            <option value="{{ $location->id }}">

                                                {{ $location->name }}
                                                —
                                                {{ $currencySymbol }}{{ number_format(
                                                    (float) $location->shipping_fee,
                                                    2
                                                ) }}

                                            </option>

                                        @endforeach

                                    </select>

                                    <i class="bi bi-chevron-down shop-shipping-chevron"></i>

                                </div>


                                @if($shippingLocations->isEmpty())

                                    <small class="shop-shipping-help text-danger">

                                        <i class="bi bi-exclamation-circle"></i>

                                        There are currently no shipping locations available.

                                    </small>

                                @else

                                    <small class="shop-shipping-help">

                                        <i class="bi bi-info-circle"></i>

                                        Select the area where your order should be delivered.

                                    </small>

                                @endif

                            </div>

                        </div>

                    @else

                        {{-- ======================================================
                            MANUAL ADDRESS / SHIPPING DISABLED
                        ======================================================= --}}

                        <div class="shop-checkout-fields">

                            <div class="shop-field shop-field-wide">

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


                            <div class="shop-field">

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


                            <div class="shop-field">

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


                    <div class="shop-checkout-security">

                        <i class="bi bi-lock"></i>

                        <div>
                            <strong>
                                Secure payment
                            </strong>

                            <span>
                                You’ll continue to Paystack to complete your payment.
                            </span>
                        </div>

                    </div>


                    <button
                        type="submit"
                        class="shop-checkout-pay"
                        id="checkoutPayButton"
                        disabled
                    >

                        <span
                            class="shop-checkout-pay-text"
                        >
                            Pay securely
                        </span>

                        <span
                            class="shop-checkout-pay-loader"
                            id="checkoutPayLoader"
                            hidden
                        >
                            <span
                                class="spinner-border spinner-border-sm"
                                aria-hidden="true"
                            ></span>

                            Preparing payment...
                        </span>

                    </button>

                </form>

            </section>


            {{-- Order summary --}}
            <aside class="shop-checkout-summary">

                <div class="shop-checkout-summary-inner">

                    <div class="shop-checkout-summary-heading">

                        <div>

                            <span>
                                Your order
                            </span>

                            <h2>
                                Bag summary
                            </h2>

                        </div>


                        <span
                            id="checkoutItemCount"
                            class="shop-checkout-count"
                        >
                            0 items
                        </span>

                    </div>


                    <div
                        class="shop-checkout-loading"
                        id="checkoutLoading"
                    >

                        <div
                            class="spinner-border spinner-border-sm"
                            role="status"
                        ></div>

                        <span>
                            Checking your bag...
                        </span>

                    </div>


                    <div
                        class="shop-checkout-items"
                        id="checkoutItems"
                        hidden
                    ></div>


                    <div
                        class="shop-checkout-empty"
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

                        <a
                            href="{{ route(
                                'storefront.public.home',
                                [
                                    'storefrontSlug' =>
                                        $storefront->slug
                                ]
                            ) }}"
                        >
                            Continue shopping
                        </a>

                    </div>


                    <div
                        class="shop-checkout-totals"
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

                            <strong id="checkoutShipping">
                                {{ $currencySymbol }}0.00
                            </strong>
                        </div>


                        <div class="shop-checkout-total">

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

                </div>

            </aside>

        </div>

    </div>

</main>


<script
    src="{{ asset('assets/js/storefront-checkout.js') }}"
    defer
></script>

@endsection