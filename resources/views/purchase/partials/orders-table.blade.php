@if($orders->count())

    @foreach($orders as $order)

        <tr>

            <td>

                <div class="fw-semibold">

                    {{ $order->order_number ?? '—' }}

                </div>

                @if(isset($order->id))

                    <div class="small text-muted">
                        #{{ $order->id }}
                    </div>

                @endif

            </td>


            <td>

                <div class="fw-medium">

                    {{ $order->supplier?->name ?? '—' }}

                </div>

            </td>


            <td>

                {{ $order->branch?->name ?? '—' }}

            </td>


            <td>

                {{ $order->order_date
                    ? \Illuminate\Support\Carbon::parse($order->order_date)->format('d M Y')
                    : '—'
                }}

            </td>


            <td>

                <span class="fw-semibold">

                    {{ number_format(
                        (float) ($order->total_amount ?? 0),
                        2
                    ) }}

                </span>

            </td>


            <td>

                @php

                    $status =
                        strtolower(
                            $order->status ?? 'pending'
                        );

                @endphp

                <span
                    class="purchase-status-badge {{ $status }}"
                >

                    {{ ucfirst($status) }}

                </span>

            </td>


           <td class="text-end">

                <button
                    type="button"
                    class="btn btn-light btn-sm purchase-action-trigger"
                    data-type="order"
                    data-id="{{ $order->id }}"
                    data-reference="{{ $order->order_number ?? '' }}"
                    data-status="{{ strtolower($order->status ?? 'draft') }}"
                >

                    <i class="bi bi-three-dots"></i>

                </button>

            </td>

        </tr>

    @endforeach

@else

    <tr>

        <td
            colspan="7"
        >

            <div class="purchase-empty-state">

                <div class="purchase-empty-icon">

                    <i class="bi bi-cart3"></i>

                </div>

                <div class="purchase-empty-title">
                    No purchase orders found
                </div>

                <p class="purchase-empty-text">
                    Purchase orders matching your filters will appear here.
                </p>

            </div>

        </td>

    </tr>

@endif