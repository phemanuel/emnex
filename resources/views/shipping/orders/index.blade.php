@extends('layouts.app')


@section('title', 'Online Orders')


@section('content')

<div
    class="online-orders-page"
    id="onlineOrdersPage"
>

    {{-- ======================================================
        PAGE HEADER
    ======================================================= --}}
    <div class="online-orders-header">

        <div>

            <span class="online-orders-kicker">
                Shipping
            </span>

            <h1>
                Online Orders
            </h1>

            <p>
                Monitor paid storefront orders and manage their fulfilment.
            </p>

        </div>


        <div class="online-orders-header-actions">

            <a
                href="{{ route('shipping.setup') }}"
                class="btn btn-light online-orders-setup-btn"
            >
                <i class="bi bi-gear"></i>

                Shipping Setup
            </a>

        </div>

    </div>


    {{-- ======================================================
        SUMMARY
    ======================================================= --}}
    <div class="online-orders-summary">

        {{-- Pending --}}
        <a
            href="{{ route(
                'shipping.orders.index',
                ['fulfilment_status' => 'Pending']
            ) }}"
            class="
                online-orders-summary-card
                {{ request('fulfilment_status') === 'Pending' ? 'active' : '' }}
            "
        >

            <div class="online-orders-summary-icon pending">
                <i class="bi bi-clock-history"></i>
            </div>

            <div>

                <span>
                    Pending
                </span>

                <strong>
                    {{ number_format($summary['pending'] ?? 0) }}
                </strong>

            </div>

        </a>


        {{-- Processing --}}
        <a
            href="{{ route(
                'shipping.orders.index',
                ['fulfilment_status' => 'Processing']
            ) }}"
            class="
                online-orders-summary-card
                {{ request('fulfilment_status') === 'Processing' ? 'active' : '' }}
            "
        >

            <div class="online-orders-summary-icon processing">
                <i class="bi bi-box-seam"></i>
            </div>

            <div>

                <span>
                    Processing
                </span>

                <strong>
                    {{ number_format($summary['processing'] ?? 0) }}
                </strong>

            </div>

        </a>


        {{-- Shipped --}}
        <a
            href="{{ route(
                'shipping.orders.index',
                ['fulfilment_status' => 'Shipped']
            ) }}"
            class="
                online-orders-summary-card
                {{ request('fulfilment_status') === 'Shipped' ? 'active' : '' }}
            "
        >

            <div class="online-orders-summary-icon shipped">
                <i class="bi bi-truck"></i>
            </div>

            <div>

                <span>
                    Shipped
                </span>

                <strong>
                    {{ number_format($summary['shipped'] ?? 0) }}
                </strong>

            </div>

        </a>


        {{-- Delivered --}}
        <a
            href="{{ route(
                'shipping.orders.index',
                ['fulfilment_status' => 'Delivered']
            ) }}"
            class="
                online-orders-summary-card
                {{ request('fulfilment_status') === 'Delivered' ? 'active' : '' }}
            "
        >

            <div class="online-orders-summary-icon delivered">
                <i class="bi bi-check2-circle"></i>
            </div>

            <div>

                <span>
                    Delivered
                </span>

                <strong>
                    {{ number_format($summary['delivered'] ?? 0) }}
                </strong>

            </div>

        </a>

    </div>


    {{-- ======================================================
        MAIN CARD
    ======================================================= --}}
    <div class="online-orders-card">

        {{-- FILTERS --}}
        <form
            method="GET"
            action="{{ route('shipping.orders.index') }}"
            class="online-orders-filters"
            id="onlineOrdersFilters"
        >

            <div class="online-orders-search">

                <i class="bi bi-search"></i>

                <input
                    type="search"
                    name="search"
                    id="onlineOrdersSearch"
                    value="{{ request('search') }}"
                    placeholder="Search order, customer, phone or email"
                    autocomplete="off"
                >

            </div>


            <div class="online-orders-filter-grid">

                {{-- Fulfilment --}}
                <div class="online-orders-filter-field">

                    <label for="fulfilment_status">
                        Fulfilment
                    </label>

                    <select
                        name="fulfilment_status"
                        id="fulfilment_status"
                    >

                        <option value="">
                            All statuses
                        </option>

                        @foreach([
                            'Pending',
                            'Processing',
                            'Shipped',
                            'Delivered',
                        ] as $status)

                            <option
                                value="{{ $status }}"
                                @selected(
                                    request('fulfilment_status') === $status
                                )
                            >
                                {{ $status }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Payment --}}
                <div class="online-orders-filter-field">

                    <label for="payment_status">
                        Payment
                    </label>

                    <select
                        name="payment_status"
                        id="payment_status"
                    >

                        <option value="">
                            All payments
                        </option>

                        <option
                            value="Paid"
                            @selected(request('payment_status') === 'Paid')
                        >
                            Paid
                        </option>

                        <option
                            value="Pending"
                            @selected(request('payment_status') === 'Pending')
                        >
                            Pending
                        </option>

                    </select>

                </div>


                {{-- Shipping Method --}}
                <div class="online-orders-filter-field">

                    <label for="shipping_method">
                        Delivery
                    </label>

                    <select
                        name="shipping_method"
                        id="shipping_method"
                    >

                        <option value="">
                            All methods
                        </option>

                        <option
                            value="location"
                            @selected(request('shipping_method') === 'location')
                        >
                            Delivery location
                        </option>

                        <option
                            value="manual"
                            @selected(request('shipping_method') === 'manual')
                        >
                            Address delivery
                        </option>

                    </select>

                </div>


                {{-- Date From --}}
                <div class="online-orders-filter-field">

                    <label for="date_from">
                        From
                    </label>

                    <input
                        type="date"
                        name="date_from"
                        id="date_from"
                        value="{{ request('date_from') }}"
                    >

                </div>


                {{-- Date To --}}
                <div class="online-orders-filter-field">

                    <label for="date_to">
                        To
                    </label>

                    <input
                        type="date"
                        name="date_to"
                        id="date_to"
                        value="{{ request('date_to') }}"
                    >

                </div>

            </div>


            <div class="online-orders-filter-actions">

                <button
                    type="submit"
                    class="btn btn-dark"
                >
                    <i class="bi bi-funnel"></i>

                    Apply Filters
                </button>


                @if(
                    request()->filled('search') ||
                    request()->filled('fulfilment_status') ||
                    request()->filled('payment_status') ||
                    request()->filled('shipping_method') ||
                    request()->filled('date_from') ||
                    request()->filled('date_to')
                )

                    <a
                        href="{{ route('shipping.orders.index') }}"
                        class="btn btn-light"
                    >
                        Clear
                    </a>

                @endif

            </div>

        </form>


        {{-- ======================================================
            TABLE HEADER
        ======================================================= --}}
        <div class="online-orders-table-header">

            <div>

                <h2>
                    Orders
                </h2>

                <p>
                    {{ number_format($orders->total()) }}
                    {{ $orders->total() === 1 ? 'order' : 'orders' }}
                </p>

            </div>

        </div>


        {{-- ======================================================
            TABLE
        ======================================================= --}}
        <div class="online-orders-table-wrap">

            <table class="online-orders-table">

                <thead>

                    <tr>

                        <th>
                            Order
                        </th>

                        <th>
                            Customer
                        </th>

                        <th>
                            Date
                        </th>

                        <th>
                            Items
                        </th>

                        <th>
                            Delivery
                        </th>

                        <th class="text-end">
                            Shipping
                        </th>

                        <th class="text-end">
                            Total
                        </th>

                        <th>
                            Payment
                        </th>

                        <th>
                            Fulfilment
                        </th>

                        <th class="text-end">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($orders as $order)

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

                        @endphp


                        <tr>

                            {{-- ORDER --}}
                            <td>

                                <div class="online-orders-order">

                                    <a
                                        href="{{ route(
                                            'shipping.orders.show',
                                            $order
                                        ) }}"
                                        class="online-orders-order-no"
                                    >
                                        {{ $order->order_no }}
                                    </a>

                                    <span>
                                        Online
                                    </span>

                                </div>

                            </td>


                            {{-- CUSTOMER --}}
                            <td>

                                <div class="online-orders-customer">

                                    <strong>
                                        {{ $customerName ?: 'Guest customer' }}
                                    </strong>

                                    <span>
                                        {{ $order->customer?->phone
                                            ?: $order->customer?->email
                                            ?: '—'
                                        }}
                                    </span>

                                </div>

                            </td>


                            {{-- DATE --}}
                            <td>

                                <div class="online-orders-date">

                                    <strong>
                                        {{ $order->completed_at
                                            ?->format('d M Y')
                                            ?? '—'
                                        }}
                                    </strong>

                                    <span>
                                        {{ $order->completed_at
                                            ?->format('g:i A')
                                            ?? ''
                                        }}
                                    </span>

                                </div>

                            </td>


                            {{-- ITEMS --}}
                            <td>

                                <div class="online-orders-items-count">

                                    <strong>
                                        {{ number_format(
                                            (int) $order->total_items
                                        ) }}
                                    </strong>

                                    <span>
                                        {{ (int) $order->total_items === 1
                                            ? 'item'
                                            : 'items'
                                        }}
                                    </span>

                                </div>

                            </td>


                            {{-- DELIVERY --}}
                            <td>

                                <div class="online-orders-delivery">

                                    @if(
                                        $order->shipping_method === 'location'
                                    )

                                        <i class="bi bi-geo-alt"></i>

                                        <div>

                                            <strong>
                                                {{ $order->shipping_location_name
                                                    ?: 'Location delivery'
                                                }}
                                            </strong>

                                            <span>
                                                Delivery location
                                            </span>

                                        </div>

                                    @elseif(
                                        $order->shipping_method === 'manual'
                                    )

                                        <i class="bi bi-house-door"></i>

                                        <div>

                                            <strong>
                                                {{ $order->shipping_city
                                                    ?: $order->shipping_state
                                                    ?: 'Address delivery'
                                                }}
                                            </strong>

                                            <span>
                                                Customer address
                                            </span>

                                        </div>

                                    @else

                                        <span class="online-orders-muted">
                                            —
                                        </span>

                                    @endif

                                </div>

                            </td>


                            {{-- SHIPPING FEE --}}
                            <td class="text-end">

                                <strong class="online-orders-money">

                                    @if(
                                        !is_null($order->shipping_fee) &&
                                        (float) $order->shipping_fee > 0
                                    )

                                        {{ $currencySymbol }}
                                        {{ number_format(
                                            (float) $order->shipping_fee,
                                            2
                                        ) }}

                                    @elseif(
                                        !is_null($order->shipping_fee) &&
                                        $order->shipping_method
                                    )

                                        Free

                                    @else

                                        —

                                    @endif

                                </strong>

                            </td>


                            {{-- TOTAL --}}
                            <td class="text-end">

                                <strong class="online-orders-total">

                                    {{ $currencySymbol }}
                                    {{ number_format(
                                        (float) $order->grand_total,
                                        2
                                    ) }}

                                </strong>

                            </td>


                            {{-- PAYMENT --}}
                            <td>

                                @if($order->payment_status === 'Paid')

                                    <span class="online-orders-status paid">

                                        <i class="bi bi-check-circle-fill"></i>

                                        Paid

                                    </span>

                                @else

                                    <span class="online-orders-status payment-pending">

                                        <i class="bi bi-clock"></i>

                                        {{ $order->payment_status ?: 'Pending' }}

                                    </span>

                                @endif

                            </td>


                            {{-- FULFILMENT --}}
                            <td>

                                <span
                                    class="
                                        online-orders-status
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

                            </td>


                            {{-- ACTION --}}
                            <td class="text-end">

                                <a
                                    href="{{ route(
                                        'shipping.orders.show',
                                        $order
                                    ) }}"
                                    class="online-orders-view-btn"
                                    aria-label="View {{ $order->order_no }}"
                                >

                                    View

                                    <i class="bi bi-arrow-right"></i>

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="10"
                                class="online-orders-empty-cell"
                            >

                                <div class="online-orders-empty">

                                    <div class="online-orders-empty-icon">

                                        <i class="bi bi-bag-check"></i>

                                    </div>

                                    <h3>
                                        No online orders found
                                    </h3>

                                    @if(
                                        request()->filled('search') ||
                                        request()->filled('fulfilment_status') ||
                                        request()->filled('payment_status') ||
                                        request()->filled('shipping_method') ||
                                        request()->filled('date_from') ||
                                        request()->filled('date_to')
                                    )

                                        <p>
                                            No orders match the filters you selected.
                                        </p>

                                        <a
                                            href="{{ route(
                                                'shipping.orders.index'
                                            ) }}"
                                            class="btn btn-light"
                                        >
                                            Clear filters
                                        </a>

                                    @else

                                        <p>
                                            Paid storefront orders will appear here
                                            when customers complete checkout.
                                        </p>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- ======================================================
            PAGINATION
        ======================================================= --}}
        @if($orders->hasPages())

            <div class="online-orders-pagination">

                {{ $orders->withQueryString()->links() }}

            </div>

        @endif

    </div>

</div>


 <script src="{{ asset('assets/js/online-orders.js') }}"></script>
@endsection