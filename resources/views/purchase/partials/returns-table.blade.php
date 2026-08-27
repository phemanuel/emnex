@if($returns->count())

    @foreach($returns as $record)

        <tr>

            <td>

                <div class="fw-semibold">

                    {{ $record->return_number ?? '—' }}

                </div>

                @if(isset($record->id))

                    <div class="small text-muted">
                        #{{ $record->id }}
                    </div>

                @endif

            </td>


            <td>

                <div class="fw-medium">

                    {{ $record->supplier?->name ?? '—' }}

                </div>

            </td>


            <td>

                {{ $record->branch?->name ?? '—' }}

            </td>


            <td>

                {{ $record->return_date
                    ? \Illuminate\Support\Carbon::parse($record->return_date)->format('d M Y')
                    : '—'
                }}

            </td>


            <td>

                <span class="fw-semibold">

                    {{ number_format(
                        (float) ($record->items_sum_total ?? 0),
                        2
                    ) }}

                </span>

            </td>


            <td>

                @php

                    $status =
                        strtolower(
                            $record->status ?? 'pending'
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
            ====================================================== --}}

            <td class="text-end">

                @permission('purchases.view')

                    <button
                        type="button"
                        class="btn btn-light btn-sm purchase-return-view-btn"
                        data-id="{{ $record->id }}"
                        title="View Purchase Return"
                    >

                        <i class="bi bi-eye"></i>

                    </button>

                @endpermission

            </td>

        </tr>

    @endforeach

@else

    <tr>

        <td colspan="7">

            <div class="purchase-empty-state">

                <div class="purchase-empty-icon">

                    <i class="bi bi-arrow-return-left"></i>

                </div>

                <div class="purchase-empty-title">
                    No purchase returns found
                </div>

                <p class="purchase-empty-text">
                    Supplier purchase returns will appear here.
                </p>

            </div>

        </td>

    </tr>

@endif