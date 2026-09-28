@extends('storefront.public.layouts.app')

@section('title', 'Order ' . $order->order_no)

@section('content')

<div class="sf-order-page">

    <div class="container">

        <div class="sf-order-shell">

            {{-- ======================================================
                ORDER HERO
            ======================================================= --}}
            <div class="sf-order-hero">

                <div class="sf-order-status-icon">
                    <i class="bi bi-check2"></i>
                </div>

                <div class="sf-order-hero-copy">

                    <span class="sf-order-eyebrow">
                        Payment confirmed
                    </span>

                    <h1>
                        Your order is confirmed
                    </h1>

                    <p>
                        Thanks
                        {{ $order->customer?->first_name }}.
                        We’ve received your order and payment successfully.
                    </p>

                </div>

            </div>


            {{-- ======================================================
                ORDER IDENTITY
            ======================================================= --}}
            <div class="sf-order-identity">

                <div>

                    <span class="sf-order-label">
                        Order number
                    </span>

                    <strong>
                        {{ $order->order_no }}
                    </strong>

                </div>


                <div>

                    <span class="sf-order-label">
                        Order date
                    </span>

                    <strong>
                        {{ $order->completed_at?->format('d M Y, g:i A') }}
                    </strong>

                </div>


                <div>

                    <span class="sf-order-label">
                        Payment status
                    </span>

                    <span class="sf-order-paid-badge">
                        <i class="bi bi-check-circle-fill"></i>
                        Paid
                    </span>

                </div>

            </div>


            <div class="row g-4">

                {{-- ==================================================
                    ORDER SUMMARY
                =================================================== --}}
                <div class="col-lg-8">

                    <div class="sf-order-card">

                        <div class="sf-order-card-header">

                            <div>

                                <span class="sf-order-section-kicker">
                                    Purchase
                                </span>

                                <h2>
                                    Order summary
                                </h2>

                            </div>

                            <span class="sf-order-item-count">
                                {{ $order->total_items }}
                                {{ $order->total_items == 1 ? 'item' : 'items' }}
                            </span>

                        </div>


                        <div class="sf-order-items">

                            @foreach($order->orderItems as $item)

                                <div class="sf-order-item">

                                    <div class="sf-order-item-info">

                                        <span class="sf-order-item-name">
                                            {{ $item->product_name }}
                                        </span>

                                        <span class="sf-order-item-meta">
                                            Qty:
                                            {{ number_format(
                                                (float) $item->quantity,
                                                0
                                            ) }}
                                            ·
                                            {{ $currencySymbol }}
                                            {{ number_format(
                                                (float) $item->unit_price,
                                                2
                                            ) }}
                                            each
                                        </span>

                                    </div>


                                    <div class="sf-order-item-total">

                                        {{ $currencySymbol }}
                                        {{ number_format(
                                            (float) $item->total,
                                            2
                                        ) }}

                                    </div>

                                </div>

                            @endforeach

                        </div>


                        <div class="sf-order-totals">

                            <div class="sf-order-total-row">

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

                                <div class="sf-order-total-row">

                                    <span>
                                        Discount
                                    </span>

                                    <strong class="sf-order-discount">
                                        -{{ $currencySymbol }}
                                        {{ number_format(
                                            (float) $order->discount,
                                            2
                                        ) }}
                                    </strong>

                                </div>

                            @endif


                            @if((float) $order->tax > 0)

                                <div class="sf-order-total-row">

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

                                <div class="sf-order-total-row">

                                    <span>
                                        Shipping
                                    </span>

                                    <strong>

                                        @if((float) $order->shipping_fee > 0)

                                            {{ $currencySymbol }}
                                            {{ number_format(
                                                (float) $order->shipping_fee,
                                                2
                                            ) }}

                                        @else

                                            Free

                                        @endif

                                    </strong>

                                </div>

                            @endif


                            <div class="sf-order-total-row grand">

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

                    </div>

                </div>


                {{-- ==================================================
                    CUSTOMER / PAYMENT
                =================================================== --}}
                <div class="col-lg-4">

                    @if($order->shipping_method)

                    <div class="sf-order-card sf-order-side-card mt-4">

                        <div class="sf-order-card-header compact">

                            <div>

                                <span class="sf-order-section-kicker">
                                    Delivery
                                </span>

                                <h2>
                                    Delivery details
                                </h2>

                            </div>

                        </div>


                        <div class="sf-order-detail-list">

                            {{-- LOCATION SHIPPING --}}
                            @if(
                                $order->shipping_method === 'location'
                            )

                                <div class="sf-order-detail-row">

                                    <span class="sf-order-detail-icon">
                                        <i class="bi bi-geo-alt"></i>
                                    </span>

                                    <div>

                                        <small>
                                            Delivery location
                                        </small>

                                        <strong>
                                            {{ $order->shipping_location_name ?: '—' }}
                                        </strong>

                                    </div>

                                </div>

                            @endif


                            {{-- MANUAL SHIPPING --}}
                            @if(
                                $order->shipping_method === 'manual'
                            )

                                <div class="sf-order-detail-row">

                                    <span class="sf-order-detail-icon">
                                        <i class="bi bi-house-door"></i>
                                    </span>

                                    <div>

                                        <small>
                                            Delivery address
                                        </small>

                                        <strong>

                                            @if($order->shipping_address)

                                                {{ $order->shipping_address }}

                                            @endif


                                            @if($order->shipping_city)

                                                @if($order->shipping_address)
                                                    <br>
                                                @endif

                                                {{ $order->shipping_city }}

                                            @endif


                                            @if($order->shipping_state)

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


                            {{-- DELIVERY FEE --}}
                            <div class="sf-order-detail-row">

                                <span class="sf-order-detail-icon">
                                    <i class="bi bi-truck"></i>
                                </span>

                                <div>

                                    <small>
                                        Delivery fee
                                    </small>

                                    <strong>

                                        @if((float) $order->shipping_fee > 0)

                                            {{ $currencySymbol }}
                                            {{ number_format(
                                                (float) $order->shipping_fee,
                                                2
                                            ) }}

                                        @else

                                            Free

                                        @endif

                                    </strong>

                                </div>

                            </div>


                            {{-- FULFILMENT STATUS --}}
                            @if($order->fulfilment_status)

                                <div class="sf-order-detail-row">

                                    <span class="sf-order-detail-icon">
                                        <i class="bi bi-box-seam"></i>
                                    </span>

                                    <div>

                                        <small>
                                            Order fulfilment
                                        </small>

                                        <strong>
                                            {{ $order->fulfilment_status }}
                                        </strong>

                                    </div>

                                </div>

                            @endif

                        </div>

                    </div>

                @endif


                    <div class="sf-order-card sf-order-side-card mt-4">

                        <div class="sf-order-payment-row">

                            <span class="sf-order-detail-icon">
                                <i class="bi bi-credit-card"></i>
                            </span>

                            <div>

                                <small>
                                    Payment
                                </small>

                                <strong>
                                    Paid successfully
                                </strong>

                            </div>

                            <span class="sf-order-mini-check">
                                <i class="bi bi-check2"></i>
                            </span>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ======================================================
                FOOTER ACTION
            ======================================================= --}}
            <div class="sf-order-footer">

                <a
                    href="{{ route(
                        'storefront.public.home',
                        [
                            'storefrontSlug' => $storefront->slug
                        ]
                    ) }}"
                    class="sf-order-store-link"
                >
                    <i class="bi bi-arrow-left"></i>
                    Continue shopping
                </a>

                <span>
                    Keep this page for your order reference.
                </span>

            </div>

        </div>

    </div>

</div>


<style>
.sf-order-page {
    min-height: 70vh;
    padding: 48px 0 72px;
    background:
        linear-gradient(
            180deg,
            #f8fafc 0%,
            #ffffff 100%
        );
}

.sf-order-shell {
    max-width: 1040px;
    margin: 0 auto;
}


/* ======================================================
   HERO
======================================================= */

.sf-order-hero {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 26px;
}

.sf-order-status-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 64px;
    background: #ecfdf3;
    color: #16a34a;
    font-size: 28px;
    box-shadow:
        inset 0 0 0 1px rgba(22, 163, 74, .08);
}

.sf-order-eyebrow {
    display: block;
    margin-bottom: 5px;
    color: #16a34a;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
}

.sf-order-hero h1 {
    margin: 0 0 6px;
    color: #0f172a;
    font-size: 30px;
    font-weight: 700;
    letter-spacing: -.03em;
}

.sf-order-hero p {
    margin: 0;
    color: #64748b;
    font-size: 14px;
    line-height: 1.7;
}


/* ======================================================
   IDENTITY STRIP
======================================================= */

.sf-order-identity {
    display: grid;
    grid-template-columns:
        repeat(3, minmax(0, 1fr));
    gap: 1px;
    margin-bottom: 28px;
    border: 1px solid #e8edf3;
    border-radius: 14px;
    overflow: hidden;
    background: #e8edf3;
}

.sf-order-identity > div {
    padding: 18px 20px;
    background: #ffffff;
}

.sf-order-label {
    display: block;
    margin-bottom: 6px;
    color: #94a3b8;
    font-size: 11px;
    font-weight: 600;
}

.sf-order-identity strong {
    display: block;
    color: #0f172a;
    font-size: 13px;
}

.sf-order-paid-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #15803d;
    font-size: 12px;
    font-weight: 700;
}


/* ======================================================
   CARDS
======================================================= */

.sf-order-card {
    border: 1px solid #e8edf3;
    border-radius: 16px;
    background: #ffffff;
    box-shadow:
        0 8px 30px rgba(15, 23, 42, .04);
    overflow: hidden;
}

.sf-order-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    padding: 22px 24px;
    border-bottom: 1px solid #eef2f6;
}

.sf-order-card-header.compact {
    padding-bottom: 18px;
}

.sf-order-section-kicker {
    display: block;
    margin-bottom: 4px;
    color: #94a3b8;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.sf-order-card-header h2 {
    margin: 0;
    color: #0f172a;
    font-size: 16px;
    font-weight: 700;
}

.sf-order-item-count {
    padding: 6px 10px;
    border-radius: 999px;
    background: #f1f5f9;
    color: #475569;
    font-size: 11px;
    font-weight: 600;
}


/* ======================================================
   ITEMS
======================================================= */

.sf-order-items {
    padding: 0 24px;
}

.sf-order-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 18px 0;
    border-bottom: 1px solid #eef2f6;
}

.sf-order-item:last-child {
    border-bottom: 0;
}

.sf-order-item-name {
    display: block;
    margin-bottom: 5px;
    color: #0f172a;
    font-size: 13px;
    font-weight: 700;
}

.sf-order-item-meta {
    color: #94a3b8;
    font-size: 11px;
}

.sf-order-item-total {
    flex-shrink: 0;
    color: #0f172a;
    font-size: 13px;
    font-weight: 700;
}


/* ======================================================
   TOTALS
======================================================= */

.sf-order-totals {
    padding: 18px 24px 24px;
    border-top: 1px solid #eef2f6;
    background: #fbfcfe;
}

.sf-order-total-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 5px 0;
    color: #64748b;
    font-size: 12px;
}

.sf-order-total-row strong {
    color: #334155;
}

.sf-order-total-row.grand {
    margin-top: 10px;
    padding-top: 14px;
    border-top: 1px solid #e8edf3;
    color: #0f172a;
    font-size: 14px;
}

.sf-order-total-row.grand strong {
    color: #0f172a;
    font-size: 18px;
}

.sf-order-discount {
    color: #15803d !important;
}


/* ======================================================
   DETAIL SIDE
======================================================= */

.sf-order-detail-list {
    padding: 10px 22px 20px;
}

.sf-order-detail-row,
.sf-order-payment-row {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 13px 0;
}

.sf-order-detail-row + .sf-order-detail-row {
    border-top: 1px solid #f0f3f7;
}

.sf-order-detail-icon {
    width: 34px;
    height: 34px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 34px;
    background: #f1f5f9;
    color: #475569;
    font-size: 14px;
}

.sf-order-detail-row small,
.sf-order-payment-row small {
    display: block;
    margin-bottom: 3px;
    color: #94a3b8;
    font-size: 10px;
}

.sf-order-detail-row strong,
.sf-order-payment-row strong {
    display: block;
    color: #0f172a;
    font-size: 12px;
    line-height: 1.5;
    word-break: break-word;
}

.sf-order-payment-row {
    align-items: center;
    padding: 18px 20px;
}

.sf-order-payment-row > div {
    flex: 1;
}

.sf-order-mini-check {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ecfdf3;
    color: #16a34a;
    font-size: 14px;
}


/* ======================================================
   FOOTER
======================================================= */

.sf-order-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-top: 26px;
    color: #94a3b8;
    font-size: 11px;
}

.sf-order-store-link {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: #0f172a;
    text-decoration: none;
    font-size: 12px;
    font-weight: 700;
}

.sf-order-store-link:hover {
    color: #2563eb;
}


/* ======================================================
   RESPONSIVE
======================================================= */

@media (max-width: 767.98px) {

    .sf-order-page {
        padding: 30px 0 48px;
    }

    .sf-order-hero {
        align-items: flex-start;
    }

    .sf-order-status-icon {
        width: 52px;
        height: 52px;
        flex-basis: 52px;
        font-size: 22px;
    }

    .sf-order-hero h1 {
        font-size: 24px;
    }

    .sf-order-identity {
        grid-template-columns: 1fr;
    }

    .sf-order-card-header,
    .sf-order-items,
    .sf-order-totals {
        padding-left: 18px;
        padding-right: 18px;
    }

    .sf-order-item {
        align-items: flex-start;
    }

    .sf-order-footer {
        align-items: flex-start;
        flex-direction: column;
    }

}
</style>

@endsection