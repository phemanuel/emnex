@extends('layouts.app')


@section('title', 'Online Order ' . $order->order_no)  



@section('content')

@php

    $fulfilmentStatus =
        $order->fulfilment_status
        ?: 'Pending';


    $fulfilmentClass =
        match($fulfilmentStatus) {

            'Processing' =>
                'processing',

            'Shipped' =>
                'shipped',

            'Delivered' =>
                'delivered',

            default =>
                'pending',

        };


    $customerName =
        trim(
            ($order->customer?->first_name ?? '') .
            ' ' .
            ($order->customer?->last_name ?? '')
        );


    $nextStatus =
        match($fulfilmentStatus) {

            'Pending' =>
                'Processing',

            'Processing' =>
                'Shipped',

            'Shipped' =>
                'Delivered',

            default =>
                null,

        };


    $nextActionLabel =
        match($fulfilmentStatus) {

            'Pending' =>
                'Start Processing',

            'Processing' =>
                'Mark as Shipped',

            'Shipped' =>
                'Mark as Delivered',

            default =>
                null,

        };


    $nextActionIcon =
        match($fulfilmentStatus) {

            'Pending' =>
                'bi-box-seam',

            'Processing' =>
                'bi-truck',

            'Shipped' =>
                'bi-check2-circle',

            default =>
                'bi-check2',

        };

@endphp


<div
    class="online-order-show-page"
    id="onlineOrderShowPage"
>

    {{-- ======================================================
        PAGE HEADER
    ======================================================= --}}
    <div class="online-order-show-header">

        <div>

            <a
                href="{{ route('shipping.orders.index') }}"
                class="online-order-show-back"
            >
                <i class="bi bi-arrow-left"></i>

                Online Orders
            </a>


            <div class="online-order-show-title-row">

                <div>

                    <span class="online-order-show-kicker">
                        Storefront order
                    </span>

                    <h1>
                        {{ $order->order_no }}
                    </h1>

                </div>


                <span
                    class="
                        online-order-status-badge
                        {{ $fulfilmentClass }}
                    "
                >

                    @switch($fulfilmentStatus)

                        @case('Processing')

                            <i class="bi bi-box-seam"></i>

                            @break


                        @case('Shipped')

                            <i class="bi bi-truck"></i>

                            @break


                        @case('Delivered')

                            <i class="bi bi-check2-circle"></i>

                            @break


                        @default

                            <i class="bi bi-clock-history"></i>

                    @endswitch

                    {{ $fulfilmentStatus }}

                </span>

            </div>


            <p>
                Review the order, delivery information and fulfilment progress.
            </p>

        </div>

    </div>


    {{-- ======================================================
        FLASH MESSAGES
    ======================================================= --}}
    @if(session('success'))

        <div class="online-order-alert success">

            <i class="bi bi-check-circle"></i>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    @if($errors->any())

        <div class="online-order-alert error">

            <i class="bi bi-exclamation-circle"></i>

            <div>

                @foreach($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        </div>

    @endif


    {{-- ======================================================
        ORDER META
    ======================================================= --}}
    <div class="online-order-meta-grid">

        <div class="online-order-meta-card">

            <span>
                Order date
            </span>

            <strong>
                {{ $order->completed_at
                    ?->format('d M Y, g:i A')
                    ?? '—'
                }}
            </strong>

        </div>


        <div class="online-order-meta-card">

            <span>
                Payment
            </span>

            <strong class="online-order-payment-paid">

                @if($order->payment_status === 'Paid')

                    <i class="bi bi-check-circle-fill"></i>

                @endif

                {{ $order->payment_status ?: 'Pending' }}

            </strong>

        </div>


        <div class="online-order-meta-card">

            <span>
                Items
            </span>

            <strong>
                {{ number_format(
                    (int) $order->total_items
                ) }}

                {{ (int) $order->total_items === 1
                    ? 'item'
                    : 'items'
                }}
            </strong>

        </div>


        <div class="online-order-meta-card">

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


    <div class="row g-4">

        {{-- ==================================================
            LEFT COLUMN
        =================================================== --}}
        <div class="col-xl-8">

            {{-- ==================================================
                ORDER ITEMS
            =================================================== --}}
            <section class="online-order-card">

                <div class="online-order-card-header">

                    <div>

                        <span class="online-order-section-kicker">
                            Purchase
                        </span>

                        <h2>
                            Order items
                        </h2>

                    </div>


                    <span class="online-order-item-count">

                        {{ number_format(
                            (int) $order->total_items
                        ) }}

                        {{ (int) $order->total_items === 1
                            ? 'item'
                            : 'items'
                        }}

                    </span>

                </div>


                <div class="online-order-items">

                    @foreach($order->orderItems as $item)

                        <div class="online-order-item">

                            <div class="online-order-item-main">

                                <div>

                                    <strong class="online-order-item-name">
                                        {{ $item->product_name }}
                                    </strong>

                                    <span class="online-order-item-meta">

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

                            </div>


                            <strong class="online-order-item-total">

                                {{ $currencySymbol }}
                                {{ number_format(
                                    (float) $item->total,
                                    2
                                ) }}

                            </strong>

                        </div>

                    @endforeach

                </div>


                {{-- TOTALS --}}
                <div class="online-order-totals">

                    <div class="online-order-total-row">

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

                        <div class="online-order-total-row">

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

                        <div class="online-order-total-row">

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

                        <div class="online-order-total-row">

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


                    <div class="online-order-total-row grand">

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


            {{-- ==================================================
                DELIVERY DETAILS
            =================================================== --}}
            @if($order->shipping_method)

                <section class="online-order-card mt-4">

                    <div class="online-order-card-header">

                        <div>

                            <span class="online-order-section-kicker">
                                Shipping
                            </span>

                            <h2>
                                Delivery details
                            </h2>

                        </div>

                    </div>


                    <div class="online-order-delivery-content">

                        @if(
                            $order->shipping_method === 'location'
                        )

                            <div class="online-order-detail-row">

                                <span class="online-order-detail-icon">

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
                            $order->shipping_method === 'manual'
                        )

                            <div class="online-order-detail-row">

                                <span class="online-order-detail-icon">

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


                        <div class="online-order-detail-row">

                            <span class="online-order-detail-icon">

                                <i class="bi bi-truck"></i>

                            </span>


                            <div>

                                <small>
                                    Shipping fee
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


                        @if($order->tracking_reference)

                            <div class="online-order-detail-row">

                                <span class="online-order-detail-icon">

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


                        @if($order->shipping_notes)

                            <div class="online-order-detail-row">

                                <span class="online-order-detail-icon">

                                    <i class="bi bi-journal-text"></i>

                                </span>


                                <div>

                                    <small>
                                        Shipping notes
                                    </small>

                                    <strong class="online-order-notes">
                                        {{ $order->shipping_notes }}
                                    </strong>

                                </div>

                            </div>

                        @endif

                    </div>

                </section>

            @endif


            {{-- ==================================================
                FULFILMENT TIMELINE
            =================================================== --}}
            <section class="online-order-card mt-4">

                <div class="online-order-card-header">

                    <div>

                        <span class="online-order-section-kicker">
                            Progress
                        </span>

                        <h2>
                            Fulfilment timeline
                        </h2>

                    </div>

                </div>


                <div class="online-order-timeline">

                    {{-- ORDER RECEIVED --}}
                    <div class="online-order-timeline-item complete">

                        <span class="online-order-timeline-marker">

                            <i class="bi bi-check2"></i>

                        </span>


                        <div>

                            <strong>
                                Order received
                            </strong>

                            <span>
                                {{ $order->completed_at
                                    ?->format('d M Y, g:i A')
                                    ?? 'Completed'
                                }}
                            </span>

                        </div>

                    </div>


                    {{-- PROCESSING --}}
                    <div
                        class="
                            online-order-timeline-item
                            {{ in_array(
                                $fulfilmentStatus,
                                [
                                    'Processing',
                                    'Shipped',
                                    'Delivered'
                                ],
                                true
                            ) ? 'complete' : 'pending' }}
                        "
                    >

                        <span class="online-order-timeline-marker">

                            @if(
                                in_array(
                                    $fulfilmentStatus,
                                    [
                                        'Processing',
                                        'Shipped',
                                        'Delivered'
                                    ],
                                    true
                                )
                            )

                                <i class="bi bi-check2"></i>

                            @else

                                <i class="bi bi-circle"></i>

                            @endif

                        </span>


                        <div>

                            <strong>
                                Processing
                            </strong>

                            <span>
                                Preparing the order for dispatch
                            </span>

                        </div>

                    </div>


                    {{-- SHIPPED --}}
                    <div
                        class="
                            online-order-timeline-item
                            {{ in_array(
                                $fulfilmentStatus,
                                [
                                    'Shipped',
                                    'Delivered'
                                ],
                                true
                            ) ? 'complete' : 'pending' }}
                        "
                    >

                        <span class="online-order-timeline-marker">

                            @if(
                                in_array(
                                    $fulfilmentStatus,
                                    [
                                        'Shipped',
                                        'Delivered'
                                    ],
                                    true
                                )
                            )

                                <i class="bi bi-check2"></i>

                            @else

                                <i class="bi bi-circle"></i>

                            @endif

                        </span>


                        <div>

                            <strong>
                                Shipped
                            </strong>

                            <span>

                                @if($order->shipped_at)

                                    {{ $order->shipped_at
                                        ->format('d M Y, g:i A')
                                    }}

                                @else

                                    Awaiting dispatch

                                @endif

                            </span>

                        </div>

                    </div>


                    {{-- DELIVERED --}}
                    <div
                        class="
                            online-order-timeline-item
                            {{ $fulfilmentStatus === 'Delivered'
                                ? 'complete'
                                : 'pending'
                            }}
                        "
                    >

                        <span class="online-order-timeline-marker">

                            @if(
                                $fulfilmentStatus ===
                                'Delivered'
                            )

                                <i class="bi bi-check2"></i>

                            @else

                                <i class="bi bi-circle"></i>

                            @endif

                        </span>


                        <div>

                            <strong>
                                Delivered
                            </strong>

                            <span>

                                @if($order->delivered_at)

                                    {{ $order->delivered_at
                                        ->format('d M Y, g:i A')
                                    }}

                                @else

                                    Awaiting delivery

                                @endif

                            </span>

                        </div>

                    </div>

                </div>

            </section>

        </div>


        {{-- ==================================================
            RIGHT COLUMN
        =================================================== --}}
        <div class="col-xl-4">

            {{-- ==================================================
                CUSTOMER
            =================================================== --}}
            <section class="online-order-card">

                <div class="online-order-card-header compact">

                    <div>

                        <span class="online-order-section-kicker">
                            Customer
                        </span>

                        <h2>
                            Customer details
                        </h2>

                    </div>

                </div>


                <div class="online-order-detail-list">

                    <div class="online-order-detail-row">

                        <span class="online-order-detail-icon">

                            <i class="bi bi-person"></i>

                        </span>


                        <div>

                            <small>
                                Name
                            </small>

                            <strong>
                                {{ $customerName ?: 'Guest customer' }}
                            </strong>

                        </div>

                    </div>


                    <div class="online-order-detail-row">

                        <span class="online-order-detail-icon">

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


                    <div class="online-order-detail-row">

                        <span class="online-order-detail-icon">

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


            {{-- ==================================================
                PAYMENT / INVOICE
            =================================================== --}}
            <section class="online-order-card mt-4">

                <div class="online-order-card-header compact">

                    <div>

                        <span class="online-order-section-kicker">
                            Payment
                        </span>

                        <h2>
                            Payment details
                        </h2>

                    </div>

                </div>


                <div class="online-order-detail-list">

                    <div class="online-order-detail-row">

                        <span class="online-order-detail-icon">

                            <i class="bi bi-credit-card"></i>

                        </span>


                        <div>

                            <small>
                                Payment status
                            </small>

                            <strong class="online-order-payment-paid">
                                {{ $order->payment_status ?: '—' }}
                            </strong>

                        </div>

                    </div>


                    <div class="online-order-detail-row">

                        <span class="online-order-detail-icon">

                            <i class="bi bi-cash-stack"></i>

                        </span>


                        <div>

                            <small>
                                Amount paid
                            </small>

                            <strong>

                                {{ $currencySymbol }}
                                {{ number_format(
                                    (float) $order->amount_paid,
                                    2
                                ) }}

                            </strong>

                        </div>

                    </div>


                    @if($order->invoice)

                        <div class="online-order-detail-row">

                            <span class="online-order-detail-icon">

                                <i class="bi bi-receipt"></i>

                            </span>


                            <div>

                                <small>
                                    Invoice
                                </small>

                                <strong>
                                    {{ $order->invoice->invoice_no }}
                                </strong>

                            </div>

                        </div>

                    @endif

                </div>

            </section>


            {{-- ==================================================
                FULFILMENT ACTION
            =================================================== --}}
            <section class="online-order-card mt-4">

                <div class="online-order-card-header compact">

                    <div>

                        <span class="online-order-section-kicker">
                            Fulfilment
                        </span>

                        <h2>
                            Manage order
                        </h2>

                    </div>

                </div>


                <div class="online-order-fulfilment-panel">

                    <div class="online-order-current-status">

                        <span>
                            Current status
                        </span>


                        <strong
                            class="
                                online-order-status-badge
                                {{ $fulfilmentClass }}
                            "
                        >
                            {{ $fulfilmentStatus }}
                        </strong>

                    </div>


                    @if($fulfilmentStatus !== 'Delivered')

                        <form
                            method="POST"
                            action="{{ route(
                                'shipping.orders.fulfilment',
                                $order
                            ) }}"
                            id="onlineOrderFulfilmentForm"
                        >

                            @csrf
                            @method('PATCH')


                            <input
                                type="hidden"
                                name="fulfilment_status"
                                id="onlineOrderNextStatus"
                                value="{{ $nextStatus }}"
                            >


                            @if(
                                $fulfilmentStatus ===
                                'Processing'
                            )

                                <div class="online-order-form-field">

                                    <label for="tracking_reference">
                                        Tracking reference
                                    </label>

                                    <input
                                        type="text"
                                        name="tracking_reference"
                                        id="tracking_reference"
                                        value="{{ old(
                                            'tracking_reference',
                                            $order->tracking_reference
                                        ) }}"
                                        maxlength="190"
                                        placeholder="Optional tracking or dispatch reference"
                                    >

                                </div>

                            @endif


                            <div class="online-order-form-field">

                                <label for="shipping_notes">
                                    Shipping notes
                                </label>

                                <textarea
                                    name="shipping_notes"
                                    id="shipping_notes"
                                    rows="4"
                                    maxlength="2000"
                                    placeholder="Add an optional internal note about this order"
                                >{{ old(
                                    'shipping_notes',
                                    $order->shipping_notes
                                ) }}</textarea>

                            </div>


                            <button
                                type="button"
                                class="online-order-primary-action"
                                id="onlineOrderUpdateButton"
                                data-bs-toggle="modal"
                                data-bs-target="#onlineOrderStatusModal"
                                data-next-status="{{ $nextStatus }}"
                            >

                                <i class="bi {{ $nextActionIcon }}"></i>

                                {{ $nextActionLabel }}

                            </button>

                        </form>

                    @else

                        <div class="online-order-complete-state">

                            <span>

                                <i class="bi bi-check2-circle"></i>

                            </span>


                            <div>

                                <strong>
                                    Order delivered
                                </strong>

                                <p>
                                    This order has completed its fulfilment journey.
                                </p>

                            </div>

                        </div>

                    @endif

                </div>

            </section>

        </div>

    </div>

</div>


{{-- ======================================================
    STATUS CONFIRMATION MODAL
======================================================= --}}
@if($fulfilmentStatus !== 'Delivered')

    <div
        class="modal fade"
        id="onlineOrderStatusModal"
        tabindex="-1"
        aria-labelledby="onlineOrderStatusModalLabel"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content online-order-status-modal">

                <div class="modal-header">

                    <div>

                        <span class="online-order-modal-kicker">
                            Update fulfilment
                        </span>

                        <h5
                            class="modal-title"
                            id="onlineOrderStatusModalLabel"
                        >
                            Confirm status change
                        </h5>

                    </div>


                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>

                </div>


                <div class="modal-body">

                    <div class="online-order-modal-icon">

                        <i class="bi {{ $nextActionIcon }}"></i>

                    </div>


                    <p>

                        Change order

                        <strong>
                            {{ $order->order_no }}
                        </strong>

                        from

                        <strong>
                            {{ $fulfilmentStatus }}
                        </strong>

                        to

                        <strong>
                            {{ $nextStatus }}
                        </strong>?

                    </p>


                    @if(
                        $nextStatus ===
                        'Shipped'
                    )

                        <div class="online-order-modal-note">

                            <i class="bi bi-info-circle"></i>

                            <span>
                                The shipped date will be recorded automatically.
                            </span>

                        </div>

                    @elseif(
                        $nextStatus ===
                        'Delivered'
                    )

                        <div class="online-order-modal-note">

                            <i class="bi bi-info-circle"></i>

                            <span>
                                The delivery date will be recorded automatically.
                            </span>

                        </div>

                    @endif

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>


                    <button
                        type="button"
                        class="btn btn-dark"
                        id="onlineOrderConfirmStatusButton"
                    >

                        <span class="online-order-confirm-label">

                            {{ $nextActionLabel }}

                        </span>


                        <span
                            class="spinner-border spinner-border-sm d-none"
                            id="onlineOrderStatusSpinner"
                            role="status"
                            aria-hidden="true"
                        ></span>

                    </button>

                </div>

            </div>

        </div>

    </div>

@endif

<script src="{{ asset('assets/js/online-order-show.js') }}"></script>
@endsection


    
