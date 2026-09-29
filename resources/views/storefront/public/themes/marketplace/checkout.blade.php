@extends(
    'storefront.public.themes.marketplace.layout'
)


@section(
    'title',
    'Checkout | ' .
    $storefront->name
)


@section('content')


<section
    class="marketplace-checkout-page"
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

    <div class="marketplace-container">


        {{-- ====================================================
            BREADCRUMB
        ===================================================== --}}

        <div class="marketplace-breadcrumb">

            <a
                href="{{ route(
                    'storefront.public.home',
                    $storefront->slug
                ) }}"
            >
                Home
            </a>


            <i class="bi bi-chevron-right"></i>


            <a
                href="{{ route(
                    'storefront.public.cart',
                    [
                        'storefrontSlug' =>
                            $storefront->slug
                    ]
                ) }}"
            >
                Cart
            </a>


            <i class="bi bi-chevron-right"></i>


            <span>
                Checkout
            </span>

        </div>



        {{-- ====================================================
            PAGE HEADING
        ===================================================== --}}

        <div class="marketplace-checkout-heading">


            <div>

                <span class="marketplace-checkout-label">

                    <i class="bi bi-shield-lock"></i>

                    Secure checkout

                </span>


                <h1>
                    Complete your order
                </h1>


                <p>
                    Enter your details, confirm delivery
                    information and continue to secure payment.
                </p>

            </div>



            <a
                href="{{ route(
                    'storefront.public.cart',
                    [
                        'storefrontSlug' =>
                            $storefront->slug
                    ]
                ) }}"
                class="marketplace-checkout-back"
            >

                <i class="bi bi-arrow-left"></i>

                Back to cart

            </a>

        </div>



        {{-- ====================================================
            CHECKOUT STEPS
        ===================================================== --}}

        <div class="marketplace-checkout-progress">


            <div class="marketplace-checkout-step is-complete">

                <span>

                    <i class="bi bi-check-lg"></i>

                </span>


                <div>

                    <small>
                        Step 1
                    </small>

                    <strong>
                        Cart
                    </strong>

                </div>

            </div>



            <div class="marketplace-checkout-step-line is-complete"></div>



            <div class="marketplace-checkout-step is-active">

                <span>
                    2
                </span>


                <div>

                    <small>
                        Step 2
                    </small>

                    <strong>
                        Details
                    </strong>

                </div>

            </div>



            <div class="marketplace-checkout-step-line"></div>



            <div class="marketplace-checkout-step">

                <span>
                    3
                </span>


                <div>

                    <small>
                        Step 3
                    </small>

                    <strong>
                        Payment
                    </strong>

                </div>

            </div>

        </div>



        {{-- ====================================================
            ALERT
        ===================================================== --}}

        <div
            class="marketplace-checkout-alert"
            id="checkoutAlert"
            hidden
        ></div>



        {{-- ====================================================
            CHECKOUT LAYOUT
        ===================================================== --}}

        <div class="marketplace-checkout-layout">


            {{-- =================================================
                FORM
            ================================================== --}}

            <div class="marketplace-checkout-main">


                <form
                    id="storefrontCheckoutForm"
                    class="marketplace-checkout-form"
                    novalidate
                >

                    @csrf



                    {{-- =========================================
                        CONTACT INFORMATION
                    ========================================== --}}

                    <section class="marketplace-checkout-card">


                        <div class="marketplace-checkout-card-heading">


                            <span class="marketplace-checkout-card-number">
                                01
                            </span>


                            <div>

                                <span>
                                    Customer information
                                </span>

                                <h2>
                                    Contact details
                                </h2>


                                <p>
                                    We need these details to
                                    process your order.
                                </p>

                            </div>

                        </div>



                        <div class="marketplace-checkout-fields">


                            <div class="marketplace-checkout-field">


                                <label for="first_name">

                                    First name

                                    <span>
                                        Required
                                    </span>

                                </label>


                                <div class="marketplace-checkout-input">

                                    <i class="bi bi-person"></i>


                                    <input
                                        type="text"
                                        id="first_name"
                                        name="first_name"
                                        autocomplete="given-name"
                                        placeholder="First name"
                                        required
                                    >

                                </div>

                            </div>



                            <div class="marketplace-checkout-field">


                                <label for="last_name">

                                    Last name

                                    <span class="is-optional">
                                        Optional
                                    </span>

                                </label>


                                <div class="marketplace-checkout-input">

                                    <i class="bi bi-person"></i>


                                    <input
                                        type="text"
                                        id="last_name"
                                        name="last_name"
                                        autocomplete="family-name"
                                        placeholder="Last name"
                                    >

                                </div>

                            </div>



                            <div class="marketplace-checkout-field">


                                <label for="email">

                                    Email address

                                    <span>
                                        Required
                                    </span>

                                </label>


                                <div class="marketplace-checkout-input">

                                    <i class="bi bi-envelope"></i>


                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        autocomplete="email"
                                        placeholder="you@example.com"
                                        required
                                    >

                                </div>

                            </div>



                            <div class="marketplace-checkout-field">


                                <label for="phone">

                                    Phone number

                                    <span>
                                        Required
                                    </span>

                                </label>


                                <div class="marketplace-checkout-input">

                                    <i class="bi bi-telephone"></i>


                                    <input
                                        type="tel"
                                        id="phone"
                                        name="phone"
                                        autocomplete="tel"
                                        placeholder="Phone number"
                                        required
                                    >

                                </div>

                            </div>

                        </div>

                    </section>



                    {{-- =========================================
                        DELIVERY
                    ========================================== --}}

                    <section class="marketplace-checkout-card">


                        <div class="marketplace-checkout-card-heading">


                            <span class="marketplace-checkout-card-number">
                                02
                            </span>


                            <div>

                                <span>
                                    Fulfilment
                                </span>

                                <h2>
                                    Delivery details
                                </h2>


                                <p>
                                    Tell us where your order
                                    should be delivered.
                                </p>

                            </div>

                        </div>



                        @if(
                            $shippingSettings?->enabled
                            &&
                            $shippingSettings->shipping_mode === 'location'
                        )


                            {{-- =================================
                                LOCATION BASED SHIPPING
                            ================================== --}}

                            <div class="marketplace-shipping-location">


                                <div class="marketplace-shipping-location-head">


                                    <span>

                                        <i class="bi bi-geo-alt"></i>

                                    </span>


                                    <div>

                                        <strong>
                                            Select delivery location
                                        </strong>


                                        <p>
                                            Delivery cost will be
                                            calculated from your
                                            selected location.
                                        </p>

                                    </div>

                                </div>



                                <div class="marketplace-checkout-field is-wide">


                                    <label for="shipping_location_id">

                                        Delivery location

                                        <span>
                                            Required
                                        </span>

                                    </label>


                                    <div class="marketplace-checkout-select">

                                        <select
                                            id="shipping_location_id"
                                            name="shipping_location_id"
                                            required
                                        >

                                            <option value="">
                                                Select location
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
                                                        (float) $location->fee,
                                                        2
                                                    ) }}

                                                </option>

                                            @endforeach

                                        </select>


                                        <i class="bi bi-chevron-down"></i>

                                    </div>



                                    @if(!$shippingLocations->count())

                                        <p class="marketplace-shipping-message is-error">

                                            <i class="bi bi-exclamation-circle"></i>

                                            No delivery locations are
                                            currently available.

                                        </p>

                                    @else

                                        <p class="marketplace-shipping-message">

                                            <i class="bi bi-info-circle"></i>

                                            Select a location to calculate
                                            the delivery fee and final total.

                                        </p>

                                    @endif

                                </div>

                            </div>


                        @else


                            {{-- =================================
                                MANUAL ADDRESS
                            ================================== --}}

                            <div class="marketplace-checkout-fields">


                                <div class="marketplace-checkout-field is-wide">


                                    <label for="address">

                                        Delivery address

                                        <span>
                                            Required
                                        </span>

                                    </label>


                                    <div class="marketplace-checkout-input is-textarea">

                                        <i class="bi bi-geo-alt"></i>


                                        <textarea
                                            id="address"
                                            name="address"
                                            autocomplete="street-address"
                                            placeholder="Street address"
                                            required
                                        ></textarea>

                                    </div>

                                </div>



                                <div class="marketplace-checkout-field">


                                    <label for="city">

                                        City

                                        <span>
                                            Required
                                        </span>

                                    </label>


                                    <div class="marketplace-checkout-input">

                                        <i class="bi bi-building"></i>


                                        <input
                                            type="text"
                                            id="city"
                                            name="city"
                                            autocomplete="address-level2"
                                            placeholder="City"
                                            required
                                        >

                                    </div>

                                </div>



                                <div class="marketplace-checkout-field">


                                    <label for="state">

                                        State

                                        <span>
                                            Required
                                        </span>

                                    </label>


                                    <div class="marketplace-checkout-input">

                                        <i class="bi bi-map"></i>


                                        <input
                                            type="text"
                                            id="state"
                                            name="state"
                                            autocomplete="address-level1"
                                            placeholder="State"
                                            required
                                        >

                                    </div>

                                </div>

                            </div>

                        @endif

                    </section>



                    {{-- =========================================
                        PAYMENT
                    ========================================== --}}

                    <section class="marketplace-checkout-card">


                        <div class="marketplace-checkout-card-heading">


                            <span class="marketplace-checkout-card-number">
                                03
                            </span>


                            <div>

                                <span>
                                    Payment
                                </span>

                                <h2>
                                    Secure online payment
                                </h2>


                                <p>
                                    Your order will be created
                                    before you are redirected
                                    to payment.
                                </p>

                            </div>

                        </div>



                        <div class="marketplace-payment-method">


                            <span class="marketplace-payment-method-icon">

                                <i class="bi bi-credit-card"></i>

                            </span>


                            <div>

                                <strong>
                                    Paystack
                                </strong>


                                <p>
                                    Continue to the secure payment
                                    page to complete your order.
                                </p>

                            </div>


                            <span class="marketplace-payment-method-check">

                                <i class="bi bi-check-lg"></i>

                            </span>

                        </div>



                        <div class="marketplace-checkout-security">


                            <div>

                                <i class="bi bi-shield-check"></i>


                                <span>

                                    <strong>
                                        Protected checkout
                                    </strong>

                                    Payment is completed securely.

                                </span>

                            </div>



                            <div>

                                <i class="bi bi-box-seam"></i>


                                <span>

                                    <strong>
                                        Final validation
                                    </strong>

                                    Stock and totals are
                                    checked before payment.

                                </span>

                            </div>

                        </div>



                        <button
                            type="submit"
                            id="checkoutPayButton"
                            class="marketplace-checkout-pay"
                            disabled
                        >


                            <span
                                class="
                                    marketplace-checkout-pay-text
                                    shop-checkout-pay-text
                                "
                            >


                                <span>

                                    <small>
                                        Secure payment
                                    </small>

                                    <strong>
                                        Continue to payment
                                    </strong>

                                </span>


                                <i class="bi bi-arrow-right"></i>

                            </span>



                            <span
                                class="marketplace-checkout-pay-loader"
                                id="checkoutPayLoader"
                                hidden
                            >

                                <span class="marketplace-checkout-spinner"></span>

                                Processing order...

                            </span>

                        </button>

                    </section>

                </form>

            </div>



            {{-- =================================================
                ORDER SUMMARY
            ================================================== --}}

            <aside class="marketplace-checkout-summary">


                <div class="marketplace-checkout-summary-card">


                    <div class="marketplace-checkout-summary-heading">


                        <div>

                            <span>
                                Your order
                            </span>

                            <h2>
                                Order summary
                            </h2>

                        </div>


                        <span
                            class="marketplace-checkout-item-count"
                            id="checkoutItemCount"
                        >
                            0 items
                        </span>

                    </div>



                    {{-- Loading --}}

                    <div
                        class="marketplace-checkout-loading"
                        id="checkoutLoading"
                    >

                        <span class="marketplace-checkout-spinner"></span>


                        <div>

                            <strong>
                                Checking your cart
                            </strong>

                            <small>
                                Confirming prices and availability.
                            </small>

                        </div>

                    </div>



                    {{-- Items inserted by JS --}}

                    <div
                        class="marketplace-checkout-items"
                        id="checkoutItems"
                    ></div>



                    {{-- Empty --}}

                    <div
                        class="marketplace-checkout-empty"
                        id="checkoutEmpty"
                        hidden
                    >

                        <span>

                            <i class="bi bi-cart3"></i>

                        </span>


                        <h3>
                            Your cart is empty
                        </h3>


                        <p>
                            Add products before
                            continuing to checkout.
                        </p>


                        <a
                            href="{{ route(
                                'storefront.public.home',
                                $storefront->slug
                            ) }}#shop"
                        >

                            Browse products

                            <i class="bi bi-arrow-right"></i>

                        </a>

                    </div>



                    {{-- =========================================
                        TOTALS
                    ========================================== --}}

                    <div
                        class="marketplace-checkout-totals"
                        id="checkoutTotals"
                        hidden
                    >


                        <div class="marketplace-checkout-total-row">

                            <span>
                                Subtotal
                            </span>

                            <strong id="checkoutSubtotal">
                                {{ $currencySymbol }}0.00
                            </strong>

                        </div>



                        <div
                            class="
                                marketplace-checkout-total-row
                                is-discount
                            "
                            id="checkoutDiscountRow"
                            hidden
                        >

                            <span>
                                Discount
                            </span>

                            <strong id="checkoutDiscount">
                                {{ $currencySymbol }}0.00
                            </strong>

                        </div>



                        <div
                            class="marketplace-checkout-total-row"
                            id="checkoutTaxRow"
                            hidden
                        >

                            <span>
                                Tax
                            </span>

                            <strong id="checkoutTax">
                                {{ $currencySymbol }}0.00
                            </strong>

                        </div>



                        <div
                            class="marketplace-checkout-total-row"
                            id="checkoutShippingRow"
                            hidden
                        >

                            <span>
                                Delivery
                            </span>

                            <strong id="checkoutShipping">
                                {{ $currencySymbol }}0.00
                            </strong>

                        </div>



                        <div class="marketplace-checkout-total-divider"></div>



                        <div class="marketplace-checkout-grand-total">


                            <div>

                                <span>
                                    Total
                                </span>

                                <small>
                                    Amount payable
                                </small>

                            </div>


                            <strong id="checkoutGrandTotal">
                                {{ $currencySymbol }}0.00
                            </strong>

                        </div>

                    </div>



                    <div class="marketplace-checkout-summary-footer">


                        <span>

                            <i class="bi bi-shield-lock"></i>

                            Secure checkout

                        </span>


                        <a
                            href="{{ route(
                                'storefront.public.cart',
                                [
                                    'storefrontSlug' =>
                                        $storefront->slug
                                ]
                            ) }}"
                        >

                            Edit cart

                        </a>

                    </div>

                </div>



                {{-- =================================================
                    SUPPORT
                ================================================== --}}

                <div class="marketplace-checkout-help">


                    <span>

                        <i class="bi bi-headset"></i>

                    </span>


                    <div>

                        <strong>
                            Need help with your order?
                        </strong>


                        <p>
                            Contact the store if you need
                            assistance before completing payment.
                        </p>


                        @if($company->phone)

                            <a
                                href="tel:{{ $company->phone }}"
                            >

                                <i class="bi bi-telephone"></i>

                                {{ $company->phone }}

                            </a>

                        @endif

                    </div>

                </div>

            </aside>

        </div>

    </div>

</section>



<script
    src="{{ asset(
        'assets/js/storefront-checkout.js'
    ) }}"
    defer
></script>


@endsection