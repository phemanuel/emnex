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
                        (float) ($record->total_amount ?? 0),
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


            <td class="text-end">

                <button
                    type="button"
                    class="btn btn-light btn-sm purchase-action-trigger"
                    data-type="return"
                    data-id="{{ $record->id }}"
                    data-reference="{{ $record->return_number ?? '' }}"
                >

                    <i class="bi bi-three-dots"></i>

                </button>

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