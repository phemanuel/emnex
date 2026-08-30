{{-- ==============================================================
STOCK TRANSFER HISTORY TABLE
================================================================= --}}

@if (
isset($transfers) &&
$transfers->count()
)

<div class="table-responsive">

    <table class="table st-history-table align-middle mb-0">

        <thead>

            <tr>

                <th>
                    Reference
                </th>

                <th>
                    Destination
                </th>

                <th>
                    Products
                </th>

                <th>
                    Quantity
                </th>

                <th>
                    Date
                </th>

                <th>
                    Created By
                </th>

                <th class="text-end">
                    Action
                </th>

            </tr>

        </thead>


        <tbody>

            @foreach ($transfers as $transfer)

                <tr>

                    {{-- ==================================================
                        REFERENCE
                    =================================================== --}}

                    <td>

                        <div class="st-history-reference">

                            <span class="st-history-reference-icon">

                                <i class="bi bi-arrow-left-right"></i>

                            </span>

                            <div>

                                <strong>
                                    {{ $transfer->reference_no ?? '-' }}
                                </strong>

                                <small>
                                    Transfer
                                </small>

                            </div>

                        </div>

                    </td>


                    {{-- ==================================================
                        DESTINATION
                    =================================================== --}}

                    <td>

                        <div class="st-history-branch">

                            <span class="st-history-branch-icon">

                                <i class="bi bi-building"></i>

                            </span>

                            <div>

                                <strong>
                                    {{ $transfer->destination_branch_name ?? '-' }}
                                </strong>

                                <small>
                                    From Head Office
                                </small>

                            </div>

                        </div>

                    </td>


                    {{-- ==================================================
                        PRODUCTS
                    =================================================== --}}

                    <td>

                        <span class="st-history-count-badge">

                            {{ $transfer->product_count ?? 0 }}

                            {{
                                ($transfer->product_count ?? 0) == 1
                                    ? 'product'
                                    : 'products'
                            }}

                        </span>

                    </td>


                    {{-- ==================================================
                        QUANTITY
                    =================================================== --}}

                    <td>

                        <strong class="st-history-quantity">

                            {{
                                number_format(
                                    $transfer->total_quantity ?? 0,
                                    2
                                )
                            }}

                        </strong>

                    </td>


                    {{-- ==================================================
                        DATE
                    =================================================== --}}

                    <td>

                        <div class="st-history-date">

                            <strong>
                                {{
                                    optional(
                                        $transfer->created_at
                                    )->format('d M Y')
                                }}
                            </strong>

                            <small>
                                {{
                                    optional(
                                        $transfer->created_at
                                    )->format('h:i A')
                                }}
                            </small>

                        </div>

                    </td>


                    {{-- ==================================================
                        CREATED BY
                    =================================================== --}}

                    <td>

                        <div class="st-history-user">

                            <span class="st-history-user-avatar">

                                {{
                                    strtoupper(
                                        substr(
                                            $transfer->creator_name ?? 'U',
                                            0,
                                            1
                                        )
                                    )
                                }}

                            </span>

                            <span>
                                {{ $transfer->creator_name ?? 'System' }}
                            </span>

                        </div>

                    </td>


                    {{-- ==================================================
                        ACTION
                    =================================================== --}}

                    <td class="text-end">

                        <button
                            type="button"
                            class="btn btn-sm st-history-view-btn"
                            data-movement-id="{{ $transfer->id }}"
                        >
                            <i class="bi bi-eye me-1"></i>
                            View
                        </button>

                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</div>


@else


{{-- ==============================================================
    EMPTY STATE
================================================================= --}}

<div class="st-history-empty">

    <div class="st-history-empty-icon">

        <i class="bi bi-clock-history"></i>

    </div>

    <h5>
        No Transfer History
    </h5>

    <p>
        No stock transfers have been recorded yet.
    </p>

    <a
        href="{{ route('stock-transfer.index') }}"
        class="btn btn-primary"
    >

        <i class="bi bi-arrow-left me-2"></i>

        Back to Stock Transfer

    </a>

</div>


@endif
