@extends('platform.layouts.app')

@section('title', 'Payments | EMNEX Control Center')
@section('page_context', 'Payments')

@section('content')

<section class="pc-page-heading pc-page-heading-split">

    <div>

        <span class="pc-kicker">
            Commerce
        </span>

        <h1>
            Payments
        </h1>

        <p>
            Review payment activity across every company,
            order and payment channel in EMNEX.
        </p>

    </div>

    <div class="pc-page-heading-stat">

        <span>
            Payment records
        </span>

        <strong>
            {{ number_format($payments->total()) }}
        </strong>

    </div>

</section>


<section class="pc-payment-list">

    <div class="pc-payment-list-header">

        <span>Payment</span>
        <span>Company / Order</span>
        <span>Amount</span>
        <span>Method</span>
        <span>Gateway</span>
        <span>Status</span>
        <span>Date</span>

    </div>


    @forelse($payments as $payment)

        @php

            $statusClass =
                strtolower(
                    $payment->payment_status
                );

        @endphp


        <article class="pc-payment-row">

            <div class="pc-payment-identity">

                <span class="pc-payment-icon">
                    <i class="bi bi-credit-card-2-front"></i>
                </span>

                <div>

                    <strong>
                        {{ $payment->payment_number ?? 'Payment #' . $payment->id }}
                    </strong>

                    <span title="{{ $payment->transaction_reference }}">

                        {{ $payment->transaction_reference
                            ? \Illuminate\Support\Str::limit(
                                $payment->transaction_reference,
                                28
                            )
                            : 'No transaction reference'
                        }}

                    </span>

                </div>

            </div>


            <div class="pc-payment-client">

                <strong>
                    {{ $payment->company?->name ?? 'Unknown company' }}
                </strong>

                <span>
                    {{ $payment->order?->order_no ?? 'No order' }}
                </span>

            </div>


            <div class="pc-money-value">

                <strong>
                    ₦{{ number_format(
                        (float) $payment->amount,
                        2
                    ) }}
                </strong>

            </div>


            <div>

                <span class="pc-method-badge">
                    {{ $payment->payment_method }}
                </span>

            </div>


            <div class="pc-payment-gateway">

                @if($payment->payment_gateway)

                    <strong>
                        {{ $payment->payment_gateway }}
                    </strong>

                @else

                    <span>
                        —
                    </span>

                @endif

            </div>


            <div>

                <span class="pc-status-pill {{ $statusClass }}">
                    {{ $payment->payment_status }}
                </span>

            </div>


            <div class="pc-date-stack">

                <strong>

                    @if($payment->payment_date)

                        {{ $payment->payment_date instanceof \Carbon\CarbonInterface
                            ? $payment->payment_date->format('d M Y')
                            : \Carbon\Carbon::parse(
                                $payment->payment_date
                            )->format('d M Y')
                        }}

                    @else

                        {{ $payment->created_at?->format('d M Y') }}

                    @endif

                </strong>


                <span>

                    @if($payment->payment_date)

                        {{ $payment->payment_date instanceof \Carbon\CarbonInterface
                            ? $payment->payment_date->format('H:i')
                            : \Carbon\Carbon::parse(
                                $payment->payment_date
                            )->format('H:i')
                        }}

                    @else

                        {{ $payment->created_at?->format('H:i') }}

                    @endif

                </span>

            </div>

        </article>

    @empty

        <div class="pc-empty-state large">
            No payments have been recorded yet.
        </div>

    @endforelse

</section>


<div class="pc-pagination">
    {{ $payments->links() }}
</div>

@endsection