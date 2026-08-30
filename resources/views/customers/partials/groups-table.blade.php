<div class="table-responsive">


    <table class="table customer-table align-middle">


        <thead>

            <tr>

                <th>
                    Group
                </th>

                <th>
                    Code
                </th>

                <th>
                    Discount
                </th>

                <th>
                    Credit Limit
                </th>

                <th>
                    Customers
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


            @forelse($groups as $group)


                <tr>


                    {{-- GROUP --}}

                    <td>

                        <div class="d-flex align-items-center gap-3">


                            <div class="customer-group-avatar">

                                <i class="bi bi-people"></i>

                            </div>


                            <div>

                                <div class="fw-semibold">

                                    {{ $group->name }}

                                </div>


                                @if($group->description)

                                    <small class="text-muted">

                                        {{ \Illuminate\Support\Str::limit(
                                            $group->description,
                                            60
                                        ) }}

                                    </small>

                                @endif

                            </div>


                        </div>

                    </td>


                    {{-- CODE --}}

                    <td>

                        <span class="fw-medium">

                            {{ $group->code }}

                        </span>

                    </td>


                    {{-- DISCOUNT --}}

                    <td>

                        <span class="fw-semibold">

                            {{ number_format(
                                $group->discount_percentage,
                                2
                            ) }}%

                        </span>

                    </td>


                    {{-- CREDIT LIMIT --}}

                  
                    <td>

                        {{ \App\Helpers\CurrencyHelper::format(
                            $group->credit_limit
                        ) }}

                    </td>




                    {{-- CUSTOMER COUNT --}}

                    <td>

                        <span class="badge bg-light text-dark">

                            {{ $group->customers_count ?? 0 }}

                        </span>

                    </td>


                    {{-- STATUS --}}

                    <td>


                        @if($group->status)

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


                                {{-- VIEW --}}

                                @permission('customer_groups.view')

                                    <li>

                                        <button
                                            type="button"
                                            class="dropdown-item customer-group-view-btn"
                                            data-id="{{ $group->id }}"
                                        >

                                            <i class="bi bi-eye me-2"></i>

                                            View Details

                                        </button>

                                    </li>

                                @endpermission


                                {{-- EDIT --}}

                                @permission('customer_groups.update')

                                    <li>

                                        <button
                                            type="button"
                                            class="dropdown-item customer-group-edit-btn"
                                            data-id="{{ $group->id }}"
                                        >

                                            <i class="bi bi-pencil me-2"></i>

                                            Edit

                                        </button>

                                    </li>

                                @endpermission


                                @if($group->status)

                                    {{-- DISABLE --}}

                                    @permission('customer_groups.update')

                                        <li>

                                            <button
                                                type="button"
                                                class="dropdown-item customer-group-disable-btn text-warning"
                                                data-id="{{ $group->id }}"
                                                data-name="{{ $group->name }}"
                                            >

                                                <i class="bi bi-pause-circle me-2"></i>

                                                Disable

                                            </button>

                                        </li>

                                    @endpermission

                                @else

                                    {{-- ENABLE --}}

                                    @permission('customer_groups.update')

                                        <li>

                                            <button
                                                type="button"
                                                class="dropdown-item customer-group-enable-btn text-success"
                                                data-id="{{ $group->id }}"
                                                data-name="{{ $group->name }}"
                                            >

                                                <i class="bi bi-check-circle me-2"></i>

                                                Enable

                                            </button>

                                        </li>

                                    @endpermission

                                @endif


                                {{-- DELETE --}}

                                @permission('customer_groups.delete')

                                    <li>

                                        <hr class="dropdown-divider">

                                    </li>


                                    <li>

                                        <button
                                            type="button"
                                            class="dropdown-item customer-group-delete-btn text-danger"
                                            data-id="{{ $group->id }}"
                                            data-name="{{ $group->name }}"
                                        >

                                            <i class="bi bi-trash me-2"></i>

                                            Delete

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
                        class="text-center"
                    >

                        <div class="customer-empty-state">


                            <div class="customer-empty-icon">

                                <i class="bi bi-people"></i>

                            </div>


                            <h6>

                                No customer groups found

                            </h6>


                            <p class="text-muted mb-0">

                                Customer groups will appear here when they are created.

                            </p>


                        </div>

                    </td>

                </tr>

            @endforelse


        </tbody>


    </table>

</div>


@if($groups instanceof \Illuminate\Pagination\LengthAwarePaginator)

    <div class="mt-3">

        {{ $groups->links() }}

    </div>

@endif