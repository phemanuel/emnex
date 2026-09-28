@extends('storefront.public.layouts.app')


@section('title', 'Order ' . $order->order_no)


@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | Fulfilment
    |--------------------------------------------------------------------------
    */

    $fulfilmentStatus =
        $order->fulfilment_status
        ?: 'Pending';


    $fulfilmentIndex =
        match($fulfilmentStatus) {

            'Processing' =>
                2,

            'Shipped' =>
                3,

            'Delivered' =>
                4,

            default =>
                1,

        };


    /*
    |--------------------------------------------------------------------------
    | Customer
    |--------------------------------------------------------------------------
    */

    $customerName =
        trim(
            ($order->customer?->first_name ?? '') .
            ' ' .
            ($order->customer?->last_name ?? '')
        );


    /*
    |--------------------------------------------------------------------------
    | Current Status Copy
    |--------------------------------------------------------------------------
    */

    $statusTitle =
        match($fulfilmentStatus) {

            'Processing' =>
                'Your order is being prepared',

            'Shipped' =>
                'Your order is on the way',

            'Delivered' =>
                'Your order has been delivered',

            default =>
                'Your order has been received',

        };


    $statusDescription =
        match($fulfilmentStatus) {

            'Processing' =>
                'Your order is currently being prepared for delivery.',

            'Shipped' =>
                'Your order has left for delivery and is on its way to you.',

            'Delivered' =>
                'Your order has completed its delivery journey.',

            default =>
                'Your payment was successful and your order has been received.',

        };


    $statusIcon =
        match($fulfilmentStatus) {

            'Processing' =>
                'bi-box-seam',

            'Shipped' =>
                'bi-truck',

            'Delivered' =>
                'bi-check2-circle',

            default =>
                'bi-bag-check',

        };

@endphp


<div class="sf-track-page">

    <div class="container">

        <div class="sf-track-shell">


            {{-- ======================================================
                TOP NAVIGATION
            ======================================================= --}}
            <div class="sf-track-topbar">

                <a
                    href="{{ route(
                        'storefront.public.home',
                        [
                            'storefrontSlug' =>
                                $storefront->slug
                        ]
                    ) }}"
                    class="sf-track-back"
                >
                    <i class="bi bi-arrow-left"></i>

                    Back to store
                </a>


                <span class="sf-track-secure">
                    <i class="bi bi-shield-check"></i>

                    Secure order page
                </span>

            </div>



            {{-- ======================================================
                HERO
            ======================================================= --}}
            <section class="sf-track-hero">

                <div class="sf-track-hero-icon">

                    <i class="bi {{ $statusIcon }}"></i>

                </div>


                <div class="sf-track-hero-content">

                    <span class="sf-track-eyebrow">

                        @if($fulfilmentStatus === 'Delivered')

                            Delivery complete

                        @elseif($fulfilmentStatus === 'Shipped')

                            In transit

                        @elseif($fulfilmentStatus === 'Processing')

                            Preparing your order

                        @else

                            Payment confirmed

                        @endif

                    </span>


                    <h1>
                        {{ $statusTitle }}
                    </h1>


                    <p>
                        Hi {{ $order->customer?->first_name ?: 'there' }}.
                        {{ $statusDescription }}
                    </p>


                    <div class="sf-track-hero-meta">

                        <div>

                            <span>
                                Order
                            </span>

                            <strong>
                                {{ $order->order_no }}
                            </strong>

                        </div>


                        <div>

                            <span>
                                Placed
                            </span>

                            <strong>
                                {{ $order->completed_at
                                    ?->format('d M Y, g:i A')
                                    ?? '—'
                                }}
                            </strong>

                        </div>


                        <div>

                            <span>
                                Payment
                            </span>

                            <strong class="paid">
                                <i class="bi bi-check-circle-fill"></i>

                                {{ $order->payment_status ?: 'Paid' }}
                            </strong>

                        </div>

                    </div>

                </div>

            </section>



            {{-- ======================================================
                SHIPPING / FULFILMENT CYCLE
            ======================================================= --}}
            <section class="sf-track-progress-card">

                <div class="sf-track-section-heading">

                    <div>

                        <span>
                            Order progress
                        </span>

                        <h2>
                            Delivery journey
                        </h2>

                    </div>


                    <span
                        class="
                            sf-track-current-status
                            status-{{ strtolower($fulfilmentStatus) }}
                        "
                    >

                        @if($fulfilmentStatus === 'Processing')

                            <i class="bi bi-box-seam"></i>

                        @elseif($fulfilmentStatus === 'Shipped')

                            <i class="bi bi-truck"></i>

                        @elseif($fulfilmentStatus === 'Delivered')

                            <i class="bi bi-check2-circle"></i>

                        @else

                            <i class="bi bi-clock-history"></i>

                        @endif

                        {{ $fulfilmentStatus }}

                    </span>

                </div>


                <div class="sf-track-progress">

                    {{-- RECEIVED --}}
                    <div
                        class="
                            sf-track-progress-step
                            {{ $fulfilmentIndex >= 1 ? 'complete' : '' }}
                        "
                    >

                        <div class="sf-track-progress-marker">

                            <i class="bi bi-check2"></i>

                        </div>


                        <div class="sf-track-progress-copy">

                            <strong>
                                Received
                            </strong>

                            <span>
                                Order confirmed
                            </span>

                        </div>

                    </div>


                    <div
                        class="
                            sf-track-progress-line
                            {{ $fulfilmentIndex >= 2 ? 'complete' : '' }}
                        "
                    ></div>


                    {{-- PROCESSING --}}
                    <div
                        class="
                            sf-track-progress-step
                            {{ $fulfilmentIndex >= 2 ? 'complete' : '' }}
                            {{ $fulfilmentIndex === 2 ? 'current' : '' }}
                        "
                    >

                        <div class="sf-track-progress-marker">

                            @if($fulfilmentIndex >= 2)

                                <i class="bi bi-check2"></i>

                            @else

                                <span>2</span>

                            @endif

                        </div>


                        <div class="sf-track-progress-copy">

                            <strong>
                                Processing
                            </strong>

                            <span>
                                Preparing order
                            </span>

                        </div>

                    </div>


                    <div
                        class="
                            sf-track-progress-line
                            {{ $fulfilmentIndex >= 3 ? 'complete' : '' }}
                        "
                    ></div>


                    {{-- SHIPPED --}}
                    <div
                        class="
                            sf-track-progress-step
                            {{ $fulfilmentIndex >= 3 ? 'complete' : '' }}
                            {{ $fulfilmentIndex === 3 ? 'current' : '' }}
                        "
                    >

                        <div class="sf-track-progress-marker">

                            @if($fulfilmentIndex >= 3)

                                <i class="bi bi-check2"></i>

                            @else

                                <span>3</span>

                            @endif

                        </div>


                        <div class="sf-track-progress-copy">

                            <strong>
                                Shipped
                            </strong>

                            <span>

                                @if($order->shipped_at)

                                    {{ $order->shipped_at
                                        ->format('d M')
                                    }}

                                @else

                                    On the way

                                @endif

                            </span>

                        </div>

                    </div>


                    <div
                        class="
                            sf-track-progress-line
                            {{ $fulfilmentIndex >= 4 ? 'complete' : '' }}
                        "
                    ></div>


                    {{-- DELIVERED --}}
                    <div
                        class="
                            sf-track-progress-step
                            {{ $fulfilmentIndex >= 4 ? 'complete' : '' }}
                            {{ $fulfilmentIndex === 4 ? 'current' : '' }}
                        "
                    >

                        <div class="sf-track-progress-marker">

                            @if($fulfilmentIndex >= 4)

                                <i class="bi bi-check2"></i>

                            @else

                                <span>4</span>

                            @endif

                        </div>


                        <div class="sf-track-progress-copy">

                            <strong>
                                Delivered
                            </strong>

                            <span>

                                @if($order->delivered_at)

                                    {{ $order->delivered_at
                                        ->format('d M')
                                    }}

                                @else

                                    Final step

                                @endif

                            </span>

                        </div>

                    </div>

                </div>

            </section>



            {{-- ======================================================
                MAIN GRID
            ======================================================= --}}
            <div class="sf-track-grid">


                {{-- ==================================================
                    LEFT
                =================================================== --}}
                <div class="sf-track-main">


                    {{-- ORDER SUMMARY --}}
                    <section class="sf-track-card">

                        <div class="sf-track-card-header">

                            <div>

                                <span class="sf-track-card-kicker">
                                    Purchase
                                </span>

                                <h2>
                                    Order summary
                                </h2>

                            </div>


                            <span class="sf-track-item-count">

                                {{ $order->total_items }}

                                {{ $order->total_items == 1
                                    ? 'item'
                                    : 'items'
                                }}

                            </span>

                        </div>


                        <div class="sf-track-items">

                            @foreach($order->orderItems as $item)

                                <div class="sf-track-item">

                                    <div class="sf-track-item-copy">

                                        <strong>
                                            {{ $item->product_name }}
                                        </strong>


                                        <span>

                                            {{ number_format(
                                                (float) $item->quantity,
                                                0
                                            ) }}
                                            ×
                                            {{ $currencySymbol }}
                                            {{ number_format(
                                                (float) $item->unit_price,
                                                2
                                            ) }}

                                        </span>

                                    </div>


                                    <strong class="sf-track-item-price">

                                        {{ $currencySymbol }}
                                        {{ number_format(
                                            (float) $item->total,
                                            2
                                        ) }}

                                    </strong>

                                </div>

                            @endforeach

                        </div>


                        <div class="sf-track-totals">

                            <div class="sf-track-total-row">

                                <span>
                                    Subtotal
                                </span>

                                <strong>

                                    {{ $currencySymbol }}
                                    {{ number_format(
                                        (float) $order->subtotal,
                                        2
                                    ) }}

                                </strong>

                            </div>


                            @if((float) $order->discount > 0)

                                <div class="sf-track-total-row">

                                    <span>
                                        Discount
                                    </span>

                                    <strong class="discount">

                                        -{{ $currencySymbol }}
                                        {{ number_format(
                                            (float) $order->discount,
                                            2
                                        ) }}

                                    </strong>

                                </div>

                            @endif


                            @if((float) $order->tax > 0)

                                <div class="sf-track-total-row">

                                    <span>
                                        Tax
                                    </span>

                                    <strong>

                                        {{ $currencySymbol }}
                                        {{ number_format(
                                            (float) $order->tax,
                                            2
                                        ) }}

                                    </strong>

                                </div>

                            @endif


                            @if(
                                !is_null($order->shipping_fee) &&
                                $order->shipping_method
                            )

                                <div class="sf-track-total-row">

                                    <span>
                                        Shipping
                                    </span>

                                    <strong>

                                        @if(
                                            (float)
                                            $order->shipping_fee > 0
                                        )

                                            {{ $currencySymbol }}
                                            {{ number_format(
                                                (float)
                                                $order->shipping_fee,
                                                2
                                            ) }}

                                        @else

                                            Free

                                        @endif

                                    </strong>

                                </div>

                            @endif


                            <div class="sf-track-total-row grand">

                                <span>
                                    Total paid
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

                    </section>


                    {{-- ORDER REFERENCE --}}
                    <div class="sf-track-reference">

                        <i class="bi bi-info-circle"></i>

                        <p>
                            Keep this page for your order reference.
                            Your delivery progress will be updated here.
                        </p>

                    </div>

                </div>



                {{-- ==================================================
                    RIGHT
                =================================================== --}}
                <aside class="sf-track-side">


                    {{-- DELIVERY --}}
                    @if($order->shipping_method)

                        <section class="sf-track-card">

                            <div class="sf-track-card-header compact">

                                <div>

                                    <span class="sf-track-card-kicker">
                                        Delivery
                                    </span>

                                    <h2>
                                        Delivery details
                                    </h2>

                                </div>

                            </div>


                            <div class="sf-track-details">


                                @if(
                                    $order->shipping_method ===
                                    'location'
                                )

                                    <div class="sf-track-detail">

                                        <span class="sf-track-detail-icon">

                                            <i class="bi bi-geo-alt"></i>

                                        </span>


                                        <div>

                                            <small>
                                                Delivery location
                                            </small>

                                            <strong>
                                                {{ $order->shipping_location_name
                                                    ?: '—'
                                                }}
                                            </strong>

                                        </div>

                                    </div>

                                @endif



                                @if(
                                    $order->shipping_method ===
                                    'manual'
                                )

                                    <div class="sf-track-detail">

                                        <span class="sf-track-detail-icon">

                                            <i class="bi bi-house-door"></i>

                                        </span>


                                        <div>

                                            <small>
                                                Delivery address
                                            </small>

                                            <strong>

                                                @if(
                                                    $order->shipping_address
                                                )

                                                    {{ $order->shipping_address }}

                                                @endif


                                                @if(
                                                    $order->shipping_city
                                                )

                                                    @if(
                                                        $order->shipping_address
                                                    )
                                                        <br>
                                                    @endif

                                                    {{ $order->shipping_city }}

                                                @endif


                                                @if(
                                                    $order->shipping_state
                                                )

                                                    @if(
                                                        $order->shipping_address ||
                                                        $order->shipping_city
                                                    )
                                                        ,
                                                    @endif

                                                    {{ $order->shipping_state }}

                                                @endif

                                            </strong>

                                        </div>

                                    </div>

                                @endif



                                <div class="sf-track-detail">

                                    <span class="sf-track-detail-icon">

                                        <i class="bi bi-truck"></i>

                                    </span>


                                    <div>

                                        <small>
                                            Delivery fee
                                        </small>

                                        <strong>

                                            @if(
                                                (float)
                                                $order->shipping_fee > 0
                                            )

                                                {{ $currencySymbol }}
                                                {{ number_format(
                                                    (float)
                                                    $order->shipping_fee,
                                                    2
                                                ) }}

                                            @else

                                                Free

                                            @endif

                                        </strong>

                                    </div>

                                </div>



                                @if($order->tracking_reference)

                                    <div class="sf-track-detail">

                                        <span class="sf-track-detail-icon">

                                            <i class="bi bi-upc-scan"></i>

                                        </span>


                                        <div>

                                            <small>
                                                Tracking reference
                                            </small>

                                            <strong>
                                                {{ $order->tracking_reference }}
                                            </strong>

                                        </div>

                                    </div>

                                @endif


                            </div>

                        </section>

                    @endif



                    {{-- CUSTOMER --}}
                    <section class="sf-track-card">

                        <div class="sf-track-card-header compact">

                            <div>

                                <span class="sf-track-card-kicker">
                                    Customer
                                </span>

                                <h2>
                                    Contact details
                                </h2>

                            </div>

                        </div>


                        <div class="sf-track-details">

                            <div class="sf-track-detail">

                                <span class="sf-track-detail-icon">

                                    <i class="bi bi-person"></i>

                                </span>


                                <div>

                                    <small>
                                        Name
                                    </small>

                                    <strong>
                                        {{ $customerName ?: '—' }}
                                    </strong>

                                </div>

                            </div>


                            <div class="sf-track-detail">

                                <span class="sf-track-detail-icon">

                                    <i class="bi bi-envelope"></i>

                                </span>


                                <div>

                                    <small>
                                        Email
                                    </small>

                                    <strong>
                                        {{ $order->customer?->email ?: '—' }}
                                    </strong>

                                </div>

                            </div>


                            <div class="sf-track-detail">

                                <span class="sf-track-detail-icon">

                                    <i class="bi bi-telephone"></i>

                                </span>


                                <div>

                                    <small>
                                        Phone
                                    </small>

                                    <strong>
                                        {{ $order->customer?->phone ?: '—' }}
                                    </strong>

                                </div>

                            </div>

                        </div>

                    </section>



                    {{-- PAYMENT --}}
                    <section class="sf-track-payment-card">

                        <span class="sf-track-payment-icon">

                            <i class="bi bi-credit-card"></i>

                        </span>


                        <div>

                            <small>
                                Payment status
                            </small>

                            <strong>
                                Paid successfully
                            </strong>

                            <span>
                                {{ $currencySymbol }}
                                {{ number_format(
                                    (float) $order->grand_total,
                                    2
                                ) }}
                            </span>

                        </div>


                        <span class="sf-track-payment-check">

                            <i class="bi bi-check2"></i>

                        </span>

                    </section>

                </aside>

            </div>



            {{-- ======================================================
                FOOTER ACTION
            ======================================================= --}}
            <div class="sf-track-footer">

                <a
                    href="{{ route(
                        'storefront.public.home',
                        [
                            'storefrontSlug' =>
                                $storefront->slug
                        ]
                    ) }}"
                    class="sf-track-shop-btn"
                >

                    <i class="bi bi-arrow-left"></i>

                    Continue shopping

                </a>


                <span>
                    Order {{ $order->order_no }}
                </span>

            </div>

        </div>

    </div>

</div>


<style>

/*
|--------------------------------------------------------------------------
| PAGE
|--------------------------------------------------------------------------
*/

.sf-track-page {
    min-height: 75vh;
    padding: 38px 0 72px;
    background:
        linear-gradient(
            180deg,
            #f6f8fb 0%,
            #ffffff 54%
        );
}


.sf-track-shell {
    max-width: 1080px;
    margin: 0 auto;
}



/*
|--------------------------------------------------------------------------
| TOP BAR
|--------------------------------------------------------------------------
*/

.sf-track-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    margin-bottom: 20px;
}


.sf-track-back,
.sf-track-secure {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 11px;
    font-weight: 600;
}


.sf-track-back {
    color: #64748b;
    text-decoration: none;
}


.sf-track-back:hover {
    color: #0f172a;
}


.sf-track-secure {
    color: #94a3b8;
}



/*
|--------------------------------------------------------------------------
| HERO
|--------------------------------------------------------------------------
*/

.sf-track-hero {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 20px;
    padding: 28px;
    border: 1px solid #e7ebf0;
    border-radius: 20px;
    background: #ffffff;
    box-shadow:
        0 14px 45px rgba(15, 23, 42, .045);
}


.sf-track-hero-icon {
    width: 58px;
    height: 58px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 58px;
    background: #ecfdf3;
    color: #15803d;
    font-size: 24px;
}


.sf-track-hero-content {
    flex: 1;
    min-width: 0;
}


.sf-track-eyebrow {
    display: block;
    margin-bottom: 6px;
    color: #16a34a;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .09em;
    text-transform: uppercase;
}


.sf-track-hero h1 {
    margin: 0 0 7px;
    color: #0f172a;
    font-size: 26px;
    font-weight: 750;
    letter-spacing: -.035em;
}


.sf-track-hero p {
    max-width: 660px;
    margin: 0;
    color: #64748b;
    font-size: 13px;
    line-height: 1.7;
}


.sf-track-hero-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 28px;
    margin-top: 22px;
    padding-top: 20px;
    border-top: 1px solid #edf1f5;
}


.sf-track-hero-meta > div {
    min-width: 120px;
}


.sf-track-hero-meta span {
    display: block;
    margin-bottom: 4px;
    color: #94a3b8;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: .04em;
    text-transform: uppercase;
}


.sf-track-hero-meta strong {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #0f172a;
    font-size: 12px;
    font-weight: 700;
}


.sf-track-hero-meta strong.paid {
    color: #15803d;
}



/*
|--------------------------------------------------------------------------
| PROGRESS CARD
|--------------------------------------------------------------------------
*/

.sf-track-progress-card {
    margin-bottom: 22px;
    padding: 24px 26px 28px;
    border: 1px solid #e7ebf0;
    border-radius: 18px;
    background: #ffffff;
    box-shadow:
        0 10px 35px rgba(15, 23, 42, .035);
}


.sf-track-section-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    margin-bottom: 28px;
}


.sf-track-section-heading > div > span {
    display: block;
    margin-bottom: 3px;
    color: #94a3b8;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
}


.sf-track-section-heading h2 {
    margin: 0;
    color: #0f172a;
    font-size: 15px;
    font-weight: 700;
}


.sf-track-current-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 10px;
    border-radius: 999px;
    font-size: 10px;
    font-weight: 700;
}


.sf-track-current-status.status-pending {
    background: #fff7ed;
    color: #c2410c;
}


.sf-track-current-status.status-processing {
    background: #eff6ff;
    color: #2563eb;
}


.sf-track-current-status.status-shipped {
    background: #f5f3ff;
    color: #7c3aed;
}


.sf-track-current-status.status-delivered {
    background: #ecfdf3;
    color: #15803d;
}



/*
|--------------------------------------------------------------------------
| PROGRESS CYCLE
|--------------------------------------------------------------------------
*/

.sf-track-progress {
    display: grid;
    grid-template-columns:
        auto 1fr auto 1fr auto 1fr auto;
    align-items: start;
}


.sf-track-progress-step {
    position: relative;
    min-width: 90px;
    text-align: center;
}


.sf-track-progress-marker {
    width: 34px;
    height: 34px;
    margin: 0 auto 10px;
    border: 1px solid #dbe2ea;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
    color: #94a3b8;
    font-size: 11px;
    font-weight: 700;
}


.sf-track-progress-step.complete
.sf-track-progress-marker {
    border-color: #0f172a;
    background: #0f172a;
    color: #ffffff;
}


.sf-track-progress-step.current
.sf-track-progress-marker {
    box-shadow:
        0 0 0 5px rgba(15, 23, 42, .07);
}


.sf-track-progress-copy strong {
    display: block;
    margin-bottom: 3px;
    color: #64748b;
    font-size: 11px;
    font-weight: 700;
}


.sf-track-progress-step.complete
.sf-track-progress-copy strong {
    color: #0f172a;
}


.sf-track-progress-copy span {
    display: block;
    color: #94a3b8;
    font-size: 9px;
}


.sf-track-progress-line {
    height: 2px;
    margin-top: 16px;
    background: #e5eaf0;
}


.sf-track-progress-line.complete {
    background: #0f172a;
}



/*
|--------------------------------------------------------------------------
| MAIN GRID
|--------------------------------------------------------------------------
*/

.sf-track-grid {
    display: grid;
    grid-template-columns:
        minmax(0, 1.7fr)
        minmax(300px, .85fr);
    gap: 22px;
}


.sf-track-main,
.sf-track-side {
    min-width: 0;
}


.sf-track-side {
    display: flex;
    flex-direction: column;
    gap: 18px;
}



/*
|--------------------------------------------------------------------------
| CARDS
|--------------------------------------------------------------------------
*/

.sf-track-card {
    border: 1px solid #e7ebf0;
    border-radius: 17px;
    background: #ffffff;
    box-shadow:
        0 8px 30px rgba(15, 23, 42, .035);
    overflow: hidden;
}


.sf-track-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    padding: 20px 22px;
    border-bottom: 1px solid #edf1f5;
}


.sf-track-card-header.compact {
    padding-top: 18px;
    padding-bottom: 17px;
}


.sf-track-card-kicker {
    display: block;
    margin-bottom: 3px;
    color: #94a3b8;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
}


.sf-track-card-header h2 {
    margin: 0;
    color: #0f172a;
    font-size: 15px;
    font-weight: 700;
}


.sf-track-item-count {
    padding: 6px 9px;
    border-radius: 999px;
    background: #f1f5f9;
    color: #64748b;
    font-size: 10px;
    font-weight: 700;
}



/*
|--------------------------------------------------------------------------
| ITEMS
|--------------------------------------------------------------------------
*/

.sf-track-items {
    padding: 0 22px;
}


.sf-track-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    padding: 17px 0;
    border-bottom: 1px solid #eef2f6;
}


.sf-track-item:last-child {
    border-bottom: 0;
}


.sf-track-item-copy strong {
    display: block;
    margin-bottom: 4px;
    color: #0f172a;
    font-size: 12px;
    font-weight: 700;
}


.sf-track-item-copy span {
    color: #94a3b8;
    font-size: 10px;
}


.sf-track-item-price {
    flex-shrink: 0;
    color: #0f172a;
    font-size: 12px;
    font-weight: 700;
}



/*
|--------------------------------------------------------------------------
| TOTALS
|--------------------------------------------------------------------------
*/

.sf-track-totals {
    padding: 17px 22px 21px;
    border-top: 1px solid #edf1f5;
    background: #fbfcfe;
}


.sf-track-total-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    padding: 5px 0;
    color: #64748b;
    font-size: 11px;
}


.sf-track-total-row strong {
    color: #334155;
}


.sf-track-total-row strong.discount {
    color: #15803d;
}


.sf-track-total-row.grand {
    margin-top: 9px;
    padding-top: 14px;
    border-top: 1px solid #e5eaf0;
    color: #0f172a;
    font-size: 13px;
    font-weight: 700;
}


.sf-track-total-row.grand strong {
    color: #0f172a;
    font-size: 18px;
}



/*
|--------------------------------------------------------------------------
| DETAILS
|--------------------------------------------------------------------------
*/

.sf-track-details {
    padding: 8px 20px 17px;
}


.sf-track-detail {
    display: flex;
    align-items: flex-start;
    gap: 11px;
    padding: 13px 0;
}


.sf-track-detail + .sf-track-detail {
    border-top: 1px solid #f0f3f7;
}


.sf-track-detail-icon {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 34px;
    background: #f1f5f9;
    color: #475569;
    font-size: 13px;
}


.sf-track-detail > div {
    min-width: 0;
}


.sf-track-detail small {
    display: block;
    margin-bottom: 3px;
    color: #94a3b8;
    font-size: 9px;
}


.sf-track-detail strong {
    display: block;
    color: #0f172a;
    font-size: 11px;
    font-weight: 650;
    line-height: 1.55;
    word-break: break-word;
}



/*
|--------------------------------------------------------------------------
| PAYMENT
|--------------------------------------------------------------------------
*/

.sf-track-payment-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 18px 20px;
    border: 1px solid #bbf7d0;
    border-radius: 15px;
    background: #f7fef9;
}


.sf-track-payment-icon {
    width: 38px;
    height: 38px;
    border-radius: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 38px;
    background: #dcfce7;
    color: #15803d;
    font-size: 15px;
}


.sf-track-payment-card > div {
    flex: 1;
    min-width: 0;
}


.sf-track-payment-card small {
    display: block;
    margin-bottom: 2px;
    color: #6b8f76;
    font-size: 9px;
}


.sf-track-payment-card strong {
    display: block;
    color: #166534;
    font-size: 11px;
    font-weight: 700;
}


.sf-track-payment-card div > span {
    display: block;
    margin-top: 2px;
    color: #4d7c5e;
    font-size: 10px;
}


.sf-track-payment-check {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #16a34a;
    color: #ffffff;
    font-size: 13px;
}



/*
|--------------------------------------------------------------------------
| REFERENCE
|--------------------------------------------------------------------------
*/

.sf-track-reference {
    display: flex;
    align-items: flex-start;
    gap: 9px;
    margin-top: 16px;
    padding: 13px 15px;
    border-radius: 12px;
    background: #f8fafc;
    color: #64748b;
}


.sf-track-reference i {
    margin-top: 2px;
}


.sf-track-reference p {
    margin: 0;
    font-size: 10px;
    line-height: 1.6;
}



/*
|--------------------------------------------------------------------------
| FOOTER
|--------------------------------------------------------------------------
*/

.sf-track-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-top: 26px;
}


.sf-track-shop-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 11px 15px;
    border: 1px solid #dbe2ea;
    border-radius: 10px;
    background: #ffffff;
    color: #0f172a;
    font-size: 11px;
    font-weight: 700;
    text-decoration: none;
    transition:
        border-color .18s ease,
        background .18s ease;
}


.sf-track-shop-btn:hover {
    border-color: #cbd5e1;
    background: #f8fafc;
    color: #0f172a;
}


.sf-track-footer > span {
    color: #94a3b8;
    font-size: 10px;
}



/*
|--------------------------------------------------------------------------
| TABLET
|--------------------------------------------------------------------------
*/

@media (max-width: 991.98px) {

    .sf-track-grid {
        grid-template-columns: 1fr;
    }


    .sf-track-side {
        display: grid;
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }


    .sf-track-payment-card {
        grid-column: 1 / -1;
    }

}



/*
|--------------------------------------------------------------------------
| MOBILE
|--------------------------------------------------------------------------
*/

@media (max-width: 767.98px) {

    .sf-track-page {
        padding: 24px 0 44px;
    }


    .sf-track-shell {
        padding-left: 2px;
        padding-right: 2px;
    }


    .sf-track-topbar {
        align-items: flex-start;
        flex-direction: column;
        gap: 9px;
    }


    .sf-track-hero {
        padding: 20px;
        gap: 14px;
    }


    .sf-track-hero-icon {
        width: 48px;
        height: 48px;
        flex-basis: 48px;
        border-radius: 13px;
        font-size: 20px;
    }


    .sf-track-hero h1 {
        font-size: 21px;
    }


    .sf-track-hero-meta {
        gap: 16px 24px;
    }


    .sf-track-progress-card {
        padding: 20px 18px;
    }


    .sf-track-section-heading {
        align-items: flex-start;
        flex-direction: column;
        margin-bottom: 22px;
    }


    /*
    |--------------------------------------------------------------------------
    | Mobile timeline instead of horizontal stepper
    |--------------------------------------------------------------------------
    */

    .sf-track-progress {
        display: block;
    }


    .sf-track-progress-step {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        min-width: 0;
        text-align: left;
    }


    .sf-track-progress-marker {
        margin: 0;
        flex: 0 0 32px;
        width: 32px;
        height: 32px;
    }


    .sf-track-progress-copy {
        padding-top: 2px;
        padding-bottom: 19px;
    }


    .sf-track-progress-line {
        width: 2px;
        height: 18px;
        margin:
            -18px 0 0
            15px;
    }


    .sf-track-progress-copy strong {
        font-size: 11px;
    }


    .sf-track-side {
        display: flex;
    }


    .sf-track-card-header,
    .sf-track-items,
    .sf-track-totals {
        padding-left: 18px;
        padding-right: 18px;
    }


    .sf-track-item {
        align-items: flex-start;
    }


    .sf-track-footer {
        align-items: flex-start;
        flex-direction: column;
    }


    .sf-track-shop-btn {
        width: 100%;
        justify-content: center;
    }

}

</style>

@endsection