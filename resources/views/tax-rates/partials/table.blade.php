<!-- =====================================================
    TAX RATES TABLE
====================================================== -->

<div class="table-responsive">

    <table class="table align-middle emnex-table mb-0">

        <thead>

            <tr>

                <th width="80">

                    #

                </th>

                <th>

                    Tax Name

                </th>

                <th width="150">

                    Rate (%)

                </th>

                <th width="130">

                    Status

                </th>

                <th width="160">

                    Created

                </th>

                <th width="90" class="text-end">

                    Action

                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($taxRates as $taxRate)

            <tr>

                <td>

                    {{ $loop->iteration + ($taxRates->firstItem() - 1) }}

                </td>

                <td>

                    <div class="fw-semibold">

                        {{ $taxRate->name }}

                    </div>

                </td>

                <td>

                    <span class="badge bg-primary-subtle text-primary">

                        {{ number_format($taxRate->rate, 2) }}%

                    </span>

                </td>

                <td>

                    @if($taxRate->status)

                        <span class="badge bg-success">

                            Active

                        </span>

                    @else

                        <span class="badge bg-danger">

                            Inactive

                        </span>
                    @endif

                </td>

                <td>

                    {{ $taxRate->created_at->format('d M Y') }}

                </td>

                <td class="text-end">

                    <div class="dropdown">

                        <button
                            class="btn btn-sm btn-light"
                            data-bs-toggle="dropdown"
                        >

                            <i class="bi bi-three-dots-vertical"></i>

                        </button>

                        <ul class="dropdown-menu dropdown-menu-end">

                            <li>

                                @permission('tax_rates.view')

                                    <button
                                        class="dropdown-item"
                                        onclick="TaxRates.openInspector({{ $taxRate->id }})"
                                    >

                                        <i class="bi bi-eye"></i>

                                        View

                                    </button>

                                @endpermission

                            </li>


                            <li>

                                @permission('tax_rates.edit')

                                    <button
                                        class="dropdown-item"
                                        onclick="TaxRates.edit({{ $taxRate->id }})"
                                    >

                                        <i class="bi bi-pencil"></i>

                                        Edit

                                    </button>

                                @endpermission

                            </li>


                            <li>

                                @permission('tax_rates.toggle_status')

                                    @if($taxRate->status)

                                        <button
                                            class="dropdown-item text-warning"
                                            onclick="TaxRates.openStatusModal(
                                                {{ $taxRate->id }},
                                                'Disable',
                                                '{{ $taxRate->name }}'
                                            )"
                                        >

                                            <i class="bi bi-power"></i>

                                            Disable

                                        </button>

                                    @else

                                        <button
                                            class="dropdown-item text-success"
                                            onclick="TaxRates.openStatusModal(
                                                {{ $taxRate->id }},
                                                'Enable',
                                                '{{ $taxRate->name }}'
                                            )"
                                        >

                                            <i class="bi bi-check-circle"></i>

                                            Enable

                                        </button>

                                    @endif

                                @endpermission

                            </li>


                            @permission('tax_rates.delete')

                                <li>

                                    <hr class="dropdown-divider">

                                </li>


                                <li>

                                    <button
                                        class="dropdown-item text-danger"
                                        onclick="TaxRates.openDeleteModal(
                                            {{ $taxRate->id }},
                                            '{{ $taxRate->name }}'
                                        )"
                                    >

                                        <i class="bi bi-trash"></i>

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

                <td colspan="6">

                    <div class="empty-state py-5">

                        <i class="bi bi-percent display-5 text-muted"></i>

                        <h5 class="mt-3">

                            No Tax Rates Found

                        </h5>

                        <p class="text-muted mb-4">

                            Click <strong>New Tax Rate</strong> to create your first tax rate.

                        </p>

                        <button
                            class="btn btn-primary"
                            onclick="TaxRates.openCreateModal()"
                        >

                            <i class="bi bi-plus-circle me-1"></i>

                            New Tax Rate

                        </button>

                    </div>

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@if($taxRates->hasPages())

<div class="card-footer">

    {{ $taxRates->links() }}

</div>

@endif