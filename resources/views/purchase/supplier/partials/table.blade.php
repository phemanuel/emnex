<div class="table-responsive supplier-table-scroll">

    <table class="table align-middle supplier-table mb-0">

        <thead>

            <tr>

                <th>
                    Supplier
                </th>

                <th>
                    Contact
                </th>

                <th>
                    Payment Terms
                </th>

                <th class="text-end">
                    Credit Limit
                </th>

                <th class="text-end">
                    Balance
                </th>

                <th>
                    Status
                </th>

                <th class="text-end">
                    Action
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($suppliers as $supplier)

                <tr>

                    {{-- ==================================================
                        Supplier
                    =================================================== --}}

                    <td>

                        <div class="d-flex align-items-center gap-3">

                            <div class="supplier-avatar">

                                {{ strtoupper(
                                    mb_substr(
                                        $supplier->name,
                                        0,
                                        1
                                    )
                                ) }}

                            </div>

                            <div>

                                <div class="fw-semibold text-dark">

                                    {{ $supplier->name }}

                                </div>

                                <div class="small text-muted">

                                    {{ $supplier->supplier_code }}

                                </div>

                            </div>

                        </div>

                    </td>


                    {{-- ==================================================
                        Contact
                    =================================================== --}}

                    <td>

                        <div class="supplier-contact-cell">

                            @if($supplier->contact_person)

                                <div class="fw-medium">

                                    {{ $supplier->contact_person }}

                                </div>

                            @endif

                            @if($supplier->phone)

                                <div class="small text-muted">

                                    {{ $supplier->phone }}

                                </div>

                            @elseif($supplier->email)

                                <div class="small text-muted">

                                    {{ $supplier->email }}

                                </div>

                            @else

                                <span class="text-muted">
                                    —
                                </span>

                            @endif

                        </div>

                    </td>


                    {{-- ==================================================
                        Payment Terms
                    =================================================== --}}

                    <td>

                        @if($supplier->payment_terms)

                            <span class="supplier-payment-term">

                                {{ $supplier->payment_terms }}

                            </span>

                        @else

                            <span class="text-muted">
                                —
                            </span>

                        @endif

                    </td>


                    {{-- ==================================================
                        Credit Limit
                    =================================================== --}}

                    <td class="text-end">

                        <span class="fw-medium">

                            {{ number_format(
                                (float) $supplier->credit_limit,
                                2
                            ) }}

                        </span>

                    </td>


                    {{-- ==================================================
                        Current Balance
                    =================================================== --}}

                    <td class="text-end">

                        <span
                            class="
                                fw-semibold
                                {{ $supplier->current_balance > 0
                                    ? 'text-danger'
                                    : 'text-muted'
                                }}
                            "
                        >

                            {{ number_format(
                                (float) $supplier->current_balance,
                                2
                            ) }}

                        </span>

                    </td>


                    {{-- ==================================================
                        Status
                    =================================================== --}}

                    <td>

                        @if($supplier->status)

                            <span class="supplier-status supplier-status-active">

                                <span class="supplier-status-dot"></span>

                                Active

                            </span>

                        @else

                            <span class="supplier-status supplier-status-inactive">

                                <span class="supplier-status-dot"></span>

                                Inactive

                            </span>

                        @endif

                    </td>


                    {{-- ==================================================
                        Action
                    =================================================== --}}

                    <td class="text-end">

                        <button
                            type="button"
                            class="btn btn-light btn-sm supplier-action-trigger"
                            data-supplier-id="{{ $supplier->id }}"
                            data-supplier-name="{{ $supplier->name }}"
                            data-status="{{ $supplier->status ? 1 : 0 }}"
                            aria-label="Supplier actions"
                        >

                            <i class="bi bi-three-dots"></i>

                        </button>

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="7"
                        class="text-center py-5"
                    >

                        <div class="supplier-empty-state">

                            <div class="supplier-empty-icon">

                                <i class="bi bi-truck"></i>

                            </div>

                            <h6 class="fw-semibold mb-1">
                                No suppliers found
                            </h6>

                            <p class="text-muted small mb-0">

                                Try adjusting your search or filters,
                                or add a new supplier.

                            </p>

                        </div>

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>