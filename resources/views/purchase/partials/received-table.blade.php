@if($received->count())

    @foreach($received as $record)

        <tr>

            {{-- ======================================================
                Receipt
            ======================================================= --}}

            <td>

                <div class="fw-semibold">

                    {{ $record->receipt_number ?? '—' }}

                </div>


                @if($record->id)

                    <div class="small text-muted">

                        #{{ $record->id }}

                    </div>

                @endif

            </td>


            {{-- ======================================================
                Purchase Order
            ======================================================= --}}

            <td>

                <div class="fw-medium">

                    {{ $record->purchaseOrder?->order_number ?? '—' }}

                </div>

            </td>


            {{-- ======================================================
                Supplier
            ======================================================= --}}

            <td>

                {{ $record->supplier?->name ?? '—' }}

            </td>


            {{-- ======================================================
                Branch
            ======================================================= --}}

            <td>

                {{ $record->branch?->name ?? '—' }}

            </td>


            {{-- ======================================================
                Received Date
            ======================================================= --}}

            <td>

                {{ $record->received_date
                    ? \Illuminate\Support\Carbon::parse(
                        $record->received_date
                    )->format('d M Y')
                    : '—'
                }}

            </td>


            {{-- ======================================================
                Items
            ======================================================= --}}

            <td>

                <span class="fw-semibold">

                    {{ $record->items_count ?? 0 }}

                </span>

            </td>

            <td>

                <span class="fw-semibold">

                    {{ number_format(
                        (float) ($record->items_sum_total ?? 0),
                        2
                    ) }}

                </span>

            </td>


            {{-- ======================================================
                Status
            ======================================================= --}}

            <td>

                @php

                    $status =
                        strtolower(
                            $record->status ?? 'draft'
                        );

                @endphp


                <span
                    class="purchase-status-badge {{ $status }}"
                >

                    {{ ucfirst($status) }}

                </span>

            </td>


            {{-- ======================================================
                Action
            ======================================================= --}}

            <td class="text-end">

                <button
                    type="button"
                    class="btn btn-light btn-sm purchase-action-trigger"
                    data-type="received"
                    data-id="{{ $record->id }}"
                    data-reference="{{ $record->receipt_number ?? '' }}"
                >

                    <i class="bi bi-three-dots"></i>

                </button>

            </td>

        </tr>

    @endforeach

@else

    <tr>

        <td colspan="8">

            <div class="purchase-empty-state">

                <div class="purchase-empty-icon">

                    <i class="bi bi-box-seam"></i>

                </div>


                <div class="purchase-empty-title">

                    No goods received records found

                </div>


                <p class="purchase-empty-text">

                    Received stock records will appear here.

                </p>

            </div>

        </td>

    </tr>

@endif