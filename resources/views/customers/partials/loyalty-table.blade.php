{{-- ==========================================================
    LOYALTY TABLE
========================================================== --}}

<div class="table-responsive">


    <table class="table customer-table loyalty-table align-middle">


        <thead>

            <tr>

                <th>
                    Customer
                </th>

                <th>
                    Customer Code
                </th>

                <th>
                    Customer Type
                </th>

                <th>
                    Loyalty Points
                </th>

                <th>
                    Last Purchase
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

                        <span class="customer-code">

                            {{ $customer->customer_code }}

                        </span>

                    </td>


                    {{-- TYPE --}}

                    <td>

                        <span class="badge bg-light text-dark">

                            {{ $customer->customer_type ?? 'Walk-in' }}

                        </span>

                    </td>


                    {{-- LOYALTY POINTS --}}

                    <td>

                        <div class="loyalty-points">


                            <i class="bi bi-star-fill me-1"></i>


                            <strong>

                                {{ number_format(
                                    $customer->loyalty_points ?? 0
                                ) }}

                            </strong>


                            <small class="text-muted ms-1">

                                points

                            </small>


                        </div>

                    </td>


                    {{-- LAST PURCHASE --}}

                    <td>

                        @if($customer->last_purchase_date)

                            <span>

                                {{ \Carbon\Carbon::parse(
                                    $customer->last_purchase_date
                                )->format('d M Y') }}

                            </span>

                        @else

                            <span class="text-muted">

                                No purchase

                            </span>

                        @endif

                    </td>


                    {{-- STATUS --}}

                    <td>


                        @if($customer->status)

                            <span class="badge bg-success-subtle text-success">

                                Active

                            </span>

                        @else

                            <span class="badge bg-danger-subtle text-danger">

                                Inactive

                            </span>

                        @endif


                    </td>


                    {{-- ACTION --}}

                    <td class="text-end">


                        <div class="dropdown">


                            <button
                                type="button"
                                class="btn btn-light btn-sm"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >

                                <i class="bi bi-three-dots"></i>

                            </button>


                            <ul class="dropdown-menu dropdown-menu-end">


                                @permission('customers.view')

                                    <li>

                                        <button
                                            type="button"
                                            class="dropdown-item customer-view-btn"
                                            data-id="{{ $customer->id }}"
                                        >

                                            <i class="bi bi-eye me-2"></i>

                                            View Customer

                                        </button>

                                    </li>

                                @endpermission


                                @permission('customers.update')

                                    <li>

                                        <button
                                            type="button"
                                            class="dropdown-item customer-edit-btn"
                                            data-id="{{ $customer->id }}"
                                        >

                                            <i class="bi bi-pencil me-2"></i>

                                            Manage Customer

                                        </button>

                                    </li>

                                @endpermission


                            </ul>


                        </div>


                    </td>


                </tr>


            @empty


                <tr>

                    <td
                        colspan="7"
                        class="text-center py-5"
                    >


                        <div class="customer-empty-state">


                            <div class="customer-empty-icon">

                                <i class="bi bi-stars"></i>

                            </div>


                            <h6 class="mt-3 mb-1">

                                No loyalty records found

                            </h6>


                            <p class="text-muted mb-0">

                                Customer loyalty information will
                                appear here.

                            </p>


                        </div>


                    </td>

                </tr>


            @endforelse


        </tbody>


    </table>


</div>


{{-- ==========================================================
    PAGINATION
========================================================== --}}

@if($customers->hasPages())

    <div class="customer-pagination mt-3">

        {{ $customers->links() }}

    </div>

@endif