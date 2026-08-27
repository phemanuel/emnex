{{-- ==============================================================
    Sales Orders Table
============================================================== --}}

@if($orders->count())

    @foreach($orders as $record)

        <tr>

            {{-- ==================================================
                Order
            =================================================== --}}

            <td>

                <div class="fw-semibold">

                    {{ $record->order_no }}

                </div>

                <div class="small text-muted">

                    {{ strtoupper($record->sales_channel ?? 'POS') }}

                </div>

            </td>


            {{-- ==================================================
                Customer
            =================================================== --}}

            <td>

                @if($record->customer)

                    <div class="fw-semibold">

                        {{ $record->customer->displayName() }}

                    </div>

                    <div class="small text-muted">

                        {{ $record->customer->customer_code }}

                    </div>

                @else

                    <span class="text-muted">
                        Walk-in Customer
                    </span>

                @endif

            </td>


            {{-- ==================================================
                Branch
            =================================================== --}}

            <td>

                <span class="text-body">

                    {{ $record->branch?->name ?? '—' }}

                </span>

            </td>


            {{-- ==================================================
                Date
            =================================================== --}}

            <td>

                <div class="fw-semibold">

                    {{ optional($record->created_at)->format('d M Y') }}

                </div>

                <div class="small text-muted">

                    {{ optional($record->created_at)->format('h:i A') }}

                </div>

            </td>


            {{-- ==================================================
                Items
            =================================================== --}}

            <td class="text-end">

                <span class="fw-semibold">

                    {{ number_format((int) ($record->total_items ?? 0)) }}

                </span>

                <div class="small text-muted">

                    {{ number_format((float) ($record->total_quantity ?? 0), 2) }}
                    qty

                </div>

            </td>


            {{-- ==================================================
                Total
            =================================================== --}}

            <td class="text-end">

                <span class="fw-semibold">

                    {{ number_format(
                        (float) ($record->grand_total ?? 0),
                        2
                    ) }}

                </span>

            </td>


            {{-- ==================================================
                Payment Status
            =================================================== --}}

            <td>

                @php

                    $paymentStatus =
                        $record->payment_status;

                    $paymentClass =
                        match ($paymentStatus) {

                            'Paid' =>
                                'bg-success-subtle text-success',

                            'Partial' =>
                                'bg-warning-subtle text-warning',

                            'Refunded' =>
                                'bg-danger-subtle text-danger',

                            default =>
                                'bg-secondary-subtle text-secondary',

                        };

                @endphp

                <span
                    class="badge {{ $paymentClass }}"
                >
                    {{ $paymentStatus ?? 'Pending' }}
                </span>

            </td>


            {{-- ==================================================
                Order Status
            =================================================== --}}

            <td>

                @php

                    $orderStatus =
                        $record->order_status;

                    $statusClass =
                        match ($orderStatus) {

                            'Completed' =>
                                'bg-success-subtle text-success',

                            'Held' =>
                                'bg-warning-subtle text-warning',

                            'Cancelled',
                            'Refunded' =>
                                'bg-danger-subtle text-danger',

                            'Draft' =>
                                'bg-secondary-subtle text-secondary',

                            default =>
                                'bg-secondary-subtle text-secondary',

                        };

                @endphp

                <span
                    class="badge {{ $statusClass }}"
                >
                    {{ $orderStatus ?? 'Draft' }}
                </span>

            </td>


            {{-- ==================================================
                Action
            =================================================== --}}

           <td class="text-end">

                <button
                    type="button"
                    class="btn btn-sm btn-light border sales-order-action-trigger"
                    data-order-id="{{ $record->id }}"
                    data-order-status="{{ $record->order_status }}"
                    title="Actions"
                    aria-label="Actions"
                >

                    <i class="bi bi-three-dots"></i>

                </button>

            </td>

    @endforeach

@else

    <tr>

        <td
            colspan="9"
            class="text-center text-muted py-5"
        >

            <div class="mb-2">

                <i class="bi bi-receipt fs-3"></i>

            </div>

            <div class="fw-semibold">
                No sales orders found.
            </div>

            <div class="small">
                Sales orders matching your filters will appear here.
            </div>

        </td>

    </tr>

@endif