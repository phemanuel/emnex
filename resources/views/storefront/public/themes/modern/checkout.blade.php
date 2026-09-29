@extends(
    'storefront.public.themes.modern.layout'
)


@section(
    'title',
    'Checkout | ' .
    $storefront->name
)


@section('content')


<section
    class="modern-checkout-page"
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

    <div class="modern-container">


        {{-- ====================================================
            BREADCRUMB
        ===================================================== --}}

        <div class="modern-breadcrumb">

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
            CHECKOUT HEADER
        ===================================================== --}}

        <div class="modern-checkout-header">

            <div>

                <span class="modern-checkout-eyebrow">

                    <i class="bi bi-lock"></i>

                    Secure checkout

                </span>


                <h1>
                    Complete your order
                </h1>


                <p>
                    Enter your contact and delivery details,
                    then continue securely to payment.
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
                class="modern-checkout-back"
            >

                <i class="bi bi-arrow-left"></i>

                Back to cart

            </a>

        </div>



        {{-- ====================================================
            CHECKOUT PROGRESS
        ===================================================== --}}

        <div class="modern-checkout-progress">


            <div class="modern-progress-step is-complete">

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


            <div class="modern-progress-line is-complete"></div>


            <div class="modern-progress-step is-active">

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


            <div class="modern-progress-line"></div>


            <div class="modern-progress-step">

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
            class="modern-checkout-alert"
            id="checkoutAlert"
            hidden
        ></div>



        {{-- ====================================================
            CHECKOUT GRID
        ===================================================== --}}

        <div class="modern-checkout-layout">


            {{-- =================================================
                CUSTOMER / DELIVERY
            ================================================== --}}

            <div class="modern-checkout-details">


                <form
                    id="storefrontCheckoutForm"
                    class="modern-checkout-form"
                    novalidate
                >

                    @csrf



                    {{-- =========================================
                        CONTACT
                    ========================================== --}}

                    <section class="modern-checkout-card">


                        <div class="modern-checkout-card-heading">

                            <span class="modern-checkout-card-number">
                                01
                            </span>


                            <div>

                                <h2>
                                    Contact information
                                </h2>


                                <p>
                                    We’ll use these details for
                                    your order and payment updates.
                                </p>

                            </div>

                        </div>



                        <div class="modern-checkout-fields">


                            <div class="modern-checkout-field">

                                <label for="first_name">

                                    First name

                                    <span>
                                        Required
                                    </span>

                                </label>


                                <div class="modern-checkout-input">

                                    <i class="bi bi-person"></i>


                                    <input
                                        type="text"
                                        id="first_name"
                                        name="first_name"
                                        autocomplete="given-name"
                                        placeholder="Enter your first name"
                                        required
                                    >

                                </div>

                            </div>



                            <div class="modern-checkout-field">

                                <label for="last_name">

                                    Last name

                                    <span class="is-optional">
                                        Optional
                                    </span>

                                </label>


                                <div class="modern-checkout-input">

                                    <i class="bi bi-person"></i>


                                    <input
                                        type="text"
                                        id="last_name"
                                        name="last_name"
                                        autocomplete="family-name"
                                        placeholder="Enter your last name"
                                    >

                                </div>

                            </div>



                            <div class="modern-checkout-field">

                                <label for="email">

                                    Email address

                                    <span>
                                        Required
                                    </span>

                                </label>


                                <div class="modern-checkout-input">

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



                            <div class="modern-checkout-field">

                                <label for="phone">

                                    Phone number

                                    <span>
                                        Required
                                    </span>

                                </label>


                                <div class="modern-checkout-input">

                                    <i class="bi bi-telephone"></i>


                                    <input
                                        type="tel"
                                        id="phone"
                                        name="phone"
                                        autocomplete="tel"
                                        placeholder="Enter your phone number"
                                        required
                                    >

                                </div>

                            </div>

                        </div>

                    </section>



                    {{-- =========================================
                        DELIVERY
                    ========================================== --}}

                    <section class="modern-checkout-card">


                        <div class="modern-checkout-card-heading">

                            <span class="modern-checkout-card-number">
                                02
                            </span>


                            <div>

                                <h2>
                                    Delivery information
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
                            $shippingSettings->shipping_mode
                                === 'location'
                        )


                            {{-- =================================
                                PREDEFINED LOCATION
                            ================================== --}}

                            <div class="modern-checkout-location">


                                <div class="modern-checkout-location-icon">

                                    <i class="bi bi-geo-alt"></i>

                                </div>


                                <div class="modern-checkout-location-content">


                                    <label for="shipping_location_id">
                                        Delivery location
                                    </label>


                                    <p>
                                        Select your area to calculate
                                        the correct delivery fee.
                                    </p>


                                    <div class="modern-checkout-select">

                                        <select
                                            id="shipping_location_id"
                                            name="shipping_location_id"
                                            required
                                        >

                                            <option value="">
                                                Choose delivery location
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
                                                        (float)
                                                        $location->shipping_fee,
                                                        2
                                                    ) }}

                                                </option>

                                            @endforeach

                                        </select>


                                        <i class="bi bi-chevron-down"></i>

                                    </div>



                                    @if($shippingLocations->isEmpty())

                                        <div class="modern-checkout-location-message is-error">

                                            <i class="bi bi-exclamation-circle"></i>

                                            <span>
                                                There are currently no
                                                delivery locations available.
                                            </span>

                                        </div>


                                    @else

                                        <div class="modern-checkout-location-message">

                                            <i class="bi bi-info-circle"></i>

                                            <span>
                                                Your delivery fee will be
                                                added to the order summary.
                                            </span>

                                        </div>

                                    @endif

                                </div>

                            </div>



                        @else


                            {{-- =================================
                                MANUAL ADDRESS
                            ================================== --}}

                            <div class="modern-checkout-fields">


                                <div class="modern-checkout-field is-wide">

                                    <label for="address">

                                        Street address

                                        <span>
                                            Required
                                        </span>

                                    </label>


                                    <div class="modern-checkout-input is-textarea">

                                        <i class="bi bi-geo-alt"></i>


                                        <textarea
                                            id="address"
                                            name="address"
                                            rows="3"
                                            autocomplete="street-address"
                                            placeholder="Enter your delivery address"
                                            required
                                        ></textarea>

                                    </div>

                                </div>



                                <div class="modern-checkout-field">

                                    <label for="city">

                                        City

                                        <span>
                                            Required
                                        </span>

                                    </label>


                                    <div class="modern-checkout-input">

                                        <i class="bi bi-buildings"></i>


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



                                <div class="modern-checkout-field">

                                    <label for="state">

                                        State

                                        <span>
                                            Required
                                        </span>

                                    </label>


                                    <div class="modern-checkout-input">

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

                    <section class="modern-checkout-card">


                        <div class="modern-checkout-card-heading">

                            <span class="modern-checkout-card-number">
                                03
                            </span>


                            <div>

                                <h2>
                                    Payment
                                </h2>


                                <p>
                                    You’ll continue to the secure
                                    payment page to complete your order.
                                </p>

                            </div>

                        </div>



                        <div class="modern-payment-method">

                            <span class="modern-payment-method-icon">

                                <i class="bi bi-credit-card"></i>

                            </span>


                            <div>

                                <strong>
                                    Secure online payment
                                </strong>


                                <p>
                                    Complete your payment securely
                                    through Paystack.
                                </p>

                            </div>


                            <span class="modern-payment-method-check">

                                <i class="bi bi-check-lg"></i>

                            </span>

                        </div>



                        <div class="modern-checkout-security">

                            <div>

                                <i class="bi bi-shield-lock"></i>

                                <span>

                                    <strong>
                                        Protected checkout
                                    </strong>

                                    Payment is completed on a
                                    secure payment page.

                                </span>

                            </div>


                            <div>

                                <i class="bi bi-box-check"></i>

                                <span>

                                    <strong>
                                        Final validation
                                    </strong>

                                    Stock and pricing are checked
                                    before payment starts.

                                </span>

                            </div>

                        </div>



                        {{-- =====================================
                            PAY BUTTON
                        ====================================== --}}

                        <button
                            type="submit"
                            class="modern-checkout-pay"
                            id="checkoutPayButton"
                            disabled
                        >


                            <span
                                class="
                                    modern-checkout-pay-text
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
                                class="modern-checkout-pay-loader"
                                id="checkoutPayLoader"
                                hidden
                            >

                                <span class="modern-checkout-spinner"></span>

                                Preparing secure payment...

                            </span>

                        </button>

                    </section>

                </form>

            </div>



            {{-- =================================================
                ORDER SUMMARY
            ================================================== --}}

            <aside class="modern-checkout-summary">

                <div class="modern-checkout-summary-card">


                    {{-- Heading --}}

                    <div class="modern-checkout-summary-heading">

                        <div>

                            <span>
                                Your order
                            </span>

                            <h2>
                                Order summary
                            </h2>

                        </div>


                        <span
                            class="modern-checkout-item-count"
                            id="checkoutItemCount"
                        >
                            0 items
                        </span>

                    </div>



                    {{-- Loading --}}

                    <div
                        class="modern-checkout-loading"
                        id="checkoutLoading"
                    >

                        <span class="modern-checkout-spinner"></span>


                        <div>

                            <strong>
                                Checking your cart
                            </strong>

                            <small>
                                Confirming price and availability...
                            </small>

                        </div>

                    </div>



                    {{-- =========================================
                        ITEMS

                        Checkout JS generates:
                        .shop-checkout-item
                        .shop-checkout-item-image
                        .shop-checkout-item-info
                        .shop-checkout-item-price
                    ========================================== --}}

                    <div
                        class="modern-checkout-items"
                        id="checkoutItems"
                        hidden
                    ></div>



                    {{-- Empty --}}

                    <div
                        class="modern-checkout-empty"
                        id="checkoutEmpty"
                        hidden
                    >

                        <span>

                            <i class="bi bi-bag"></i>

                        </span>


                        <h3>
                            Your cart is empty
                        </h3>


                        <p>
                            Add some products before
                            continuing to checkout.
                        </p>


                        <a
                            href="{{ route(
                                'storefront.public.home',
                                [
                                    'storefrontSlug' =>
                                        $storefront->slug
                                ]
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
                        class="modern-checkout-totals"
                        id="checkoutTotals"
                        hidden
                    >


                        <div class="modern-checkout-total-row">

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
                            class="modern-checkout-total-row is-discount"
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
                            class="modern-checkout-total-row"
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
                            class="modern-checkout-total-row"
                            id="checkoutShippingRow"
                            hidden
                        >

                            <span>
                                Delivery
                            </span>


                            <strong
                                id="checkoutShipping"
                            >
                                {{ $currencySymbol }}0.00
                            </strong>

                        </div>



                        <div class="modern-checkout-total-divider"></div>



                        <div class="modern-checkout-grand-total">

                            <div>

                                <span>
                                    Total
                                </span>

                                <small>
                                    Amount payable
                                </small>

                            </div>


                            <strong
                                id="checkoutGrandTotal"
                            >
                                {{ $currencySymbol }}0.00
                            </strong>

                        </div>

                    </div>



                    {{-- =========================================
                        SUMMARY FOOTER
                    ========================================== --}}

                    <div class="modern-checkout-summary-footer">


                        <div>

                            <i class="bi bi-lock"></i>

                            <span>
                                Secure checkout
                            </span>

                        </div>


                        <a
                            href="{{ route(
                                'storefront.public.cart',
                                [
                                    'storefrontSlug' =>
                                        $storefront->slug
                                ]
                            ) }}"
                        >

                            <i class="bi bi-pencil"></i>

                            Edit cart

                        </a>

                    </div>

                </div>



                {{-- =============================================
                    HELP CARD
                ============================================== --}}

                <div class="modern-checkout-help">

                    <span>

                        <i class="bi bi-question-circle"></i>

                    </span>


                    <div>

                        <strong>
                            Need help?
                        </strong>


                        <p>
                            Review your contact and delivery
                            details carefully before payment.
                        </p>


                        @if($company->phone)

                            <a href="tel:{{ $company->phone }}">

                                Contact store

                                <i class="bi bi-arrow-right"></i>

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