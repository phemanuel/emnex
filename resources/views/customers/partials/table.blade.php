<div class="customer-table-container">


    <table class="table customer-table align-middle">


        <thead>

            <tr>

                <th>
                    Customer
                </th>

                <th>
                    Code
                </th>

                <th>
                    Type
                </th>

                <th>
                    Phone
                </th>

                <th>
                    Loyalty Points
                </th>

                <th>
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


            @forelse($customers as $customer)


                <tr>


                    {{-- CUSTOMER --}}

                    <td>

                        <div class="d-flex align-items-center gap-3">


                            <div class="customer-avatar">

                                {{ strtoupper(
                                    substr(
                                        $customer->first_name ?? 'C',
                                        0,
                                        1
                                    )
                                ) }}

                            </div>


                            <div>

                                <div class="fw-semibold">

                                    {{ $customer->displayName() }}

                                </div>


                                @if($customer->email)

                                    <small class="text-muted">

                                        {{ $customer->email }}

                                    </small>

                                @endif

                            </div>


                        </div>

                    </td>


                    {{-- CODE --}}

                    <td>

                        <span class="fw-medium">

                            {{ $customer->customer_code }}

                        </span>

                    </td>


                    {{-- TYPE --}}

                    <td>

                        <span class="badge bg-light text-dark">

                            {{ $customer->customer_type ?? 'Walk-in' }}

                        </span>

                    </td>


                    {{-- PHONE --}}

                    <td>

                        {{ $customer->phone ?? '-' }}

                    </td>


                    {{-- LOYALTY --}}

                    <td>

                        <span class="fw-semibold">

                            {{ number_format(
                                $customer->loyalty_points ?? 0
                            ) }}

                        </span>

                    </td>


                    {{-- BALANCE --}}

                    <td>

                        <span
                            class="
                                fw-semibold
                                {{
                                    (float) $customer->current_balance > 0
                                        ? 'text-danger'
                                        : 'text-success'
                                }}
                            "
                        >

                            ₦{{ number_format(
                                (float) $customer->current_balance,
                                2
                            ) }}

                        </span>

                    </td>


                    {{-- STATUS --}}

                    <td>


                        @if($customer->status)

                            <span class="badge bg-success-subtle text-success">

                                Active

                            </span>

                        @else

                            <span class="badge bg-secondary-subtle text-secondary">

                                Inactive

                            </span>

                        @endif


                    </td>


                    {{-- ACTION --}}

                    <td class="text-end">


                        <div class="dropdown customer-actions">


                            <button
                                type="button"
                                class="btn btn-light btn-sm customer-action-trigger"
                                data-id="{{ $customer->id }}"
                                data-name="{{ $customer->displayName() }}"
                                data-status="{{ $customer->status ? '1' : '0' }}"
                                aria-expanded="false"
                            >    
                            <i class="bi bi-three-dots"></i>
                             </button>              

                        </div>


                    </td>


                </tr>


            @empty


                <tr>

                    <td
                        colspan="8"
                        class="text-center"
                    >

                        <div class="customer-empty-state">


                            <div class="customer-empty-icon">

                                <i class="bi bi-people"></i>

                            </div>


                            <h6>

                                No customers found

                            </h6>


                            <p class="text-muted mb-0">

                                Customers will appear here when they are added.

                            </p>


                        </div>

                    </td>

                </tr>

            @endforelse


        </tbody>


    </table>

</div>

{{-- ==========================================================
    CUSTOMER ACTION MENU
=========================================================== --}}

<div
    class="dropdown-menu customer-global-action-menu"
    id="customerGlobalActionMenu"
>

    @permission('customers.view')

        <button
            type="button"
            class="dropdown-item"
            data-action="view"
        >

            <i class="bi bi-eye me-2"></i>

            View Details

        </button>

    @endpermission


    @permission('customers.update')

        <button
            type="button"
            class="dropdown-item"
            data-action="edit"
        >

            <i class="bi bi-pencil me-2"></i>

            Edit

        </button>


        <div class="dropdown-divider"></div>


        <button
            type="button"
            class="dropdown-item"
            id="customerGlobalStatusAction"
            data-action="disable"
        >

            <i
                class="bi bi-pause-circle me-2"
                id="customerGlobalStatusIcon"
            ></i>

            <span id="customerGlobalStatusText">

                Disable

            </span>

        </button>

    @endpermission


    @permission('customers.delete')

        <div class="dropdown-divider"></div>

        <button
            type="button"
            class="dropdown-item text-danger"
            data-action="delete"
        >

            <i class="bi bi-trash me-2"></i>

            Delete

        </button>

    @endpermission

</div>

@if($customers instanceof \Illuminate\Pagination\LengthAwarePaginator)

    <div class="mt-3">

        {{ $customers->links() }}

    </div>

@endif