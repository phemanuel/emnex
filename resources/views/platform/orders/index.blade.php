@extends('platform.layouts.app')

@section('title', 'Orders | EMNEX Control Center')
@section('page_context', 'Orders')

@section('content')

<section class="pc-page-heading pc-page-heading-split">

    <div>

        <span class="pc-kicker">
            Commerce
        </span>

        <h1>
            Orders
        </h1>

        <p>
            Follow sales flowing through EMNEX across POS,
            Online and Phone channels.
        </p>

    </div>

    <div class="pc-page-heading-stat">

        <span>
            Orders found
        </span>

        <strong>
            {{ number_format($orders->total()) }}
        </strong>

    </div>

</section>


<section class="pc-commerce-toolbar">

    <div class="pc-filter-label">

        <i class="bi bi-funnel"></i>

        <span>
            Sales channel
        </span>

    </div>


    <div class="pc-channel-filters">

        <a
            href="{{ route('platform.orders.index') }}"
            class="{{ !request('channel') ? 'active' : '' }}"
        >
            All
        </a>

        <a
            href="{{ route(
                'platform.orders.index',
                ['channel' => 'POS']
            ) }}"
            class="{{ request('channel') === 'POS' ? 'active' : '' }}"
        >
            POS
        </a>

        <a
            href="{{ route(
                'platform.orders.index',
                ['channel' => 'Online']
            ) }}"
            class="{{ request('channel') === 'Online' ? 'active' : '' }}"
        >
            Online
        </a>

        <a
            href="{{ route(
                'platform.orders.index',
                ['channel' => 'Phone']
            ) }}"
            class="{{ request('channel') === 'Phone' ? 'active' : '' }}"
        >
            Phone
        </a>

    </div>

</section>


<section class="pc-order-list">

    <div class="pc-order-list-header">

        <span>Order</span>
        <span>Company / Customer</span>
        <span>Channel</span>
        <span>Amount</span>
        <span>Payment</span>
        <span>Order state</span>
        <span>Date</span>

    </div>


    @forelse($orders as $order)

        @php

            $paymentClass =
                $order->payment_status === 'Paid'
                    ? 'paid'
                    : (
                        $order->payment_status === 'Pending'
                            ? 'pending'
                            : strtolower(
                                $order->payment_status
                            )
                    );

            $orderClass =
                strtolower(
                    $order->order_status
                );

        @endphp


        <article class="pc-order-list-row">

            <div class="pc-order-identity">

                <span class="pc-order-icon">
                    <i class="bi bi-receipt"></i>
                </span>

                <div>

                    <strong>
                        {{ $order->order_no }}
                    </strong>

                    <span>
                        Record #{{ $order->id }}
                    </span>

                </div>

            </div>


            <div class="pc-order-client">

                <strong>
                    {{ $order->company?->name ?? 'Unknown company' }}
                </strong>

                <span>

                    @if($order->customer)

                        {{ trim(
                            $order->customer->first_name
                            .
                            ' '
                            .
                            $order->customer->last_name
                        ) }}

                    @else

                        Walk-in customer

                    @endif

                </span>

            </div>


            <div>

                <span
                    class="pc-channel-badge {{ strtolower($order->sales_channel) }}"
                >
                    {{ $order->sales_channel }}
                </span>

            </div>


            <div class="pc-money-value">

                <strong>
                    ₦{{ number_format(
                        (float) $order->grand_total,
                        2
                    ) }}
                </strong>

            </div>


            <div>

                <span class="pc-status-pill {{ $paymentClass }}">
                    {{ $order->payment_status }}
                </span>

            </div>


            <div>

                <span class="pc-status-pill {{ $orderClass }}">
                    {{ $order->order_status }}
                </span>

            </div>


            <div class="pc-date-stack">

                <strong>
                    {{ $order->created_at?->format('d M Y') }}
                </strong>

                <span>
                    {{ $order->created_at?->format('H:i') }}
                </span>

            </div>

        </article>

    @empty

        <div class="pc-empty-state large">
            No orders match the current filter.
        </div>

    @endforelse

</section>


<div class="pc-pagination">
    {{ $orders->links() }}
</div>

@endsection