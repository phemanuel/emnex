<div class="table-responsive">

    <table class="table align-middle module-table mb-0">

        <thead>

            <tr>

                <th style="width:60px;">#</th>

                <th>Discount</th>

                <th>Type</th>

                <th>Value</th>

                <th>Automatic</th>

                <th>Validity</th>

                <th>Status</th>

                <th class="text-end" style="width:90px;">Action</th>

            </tr>

        </thead>

        <tbody>

        @forelse($discounts as $discount)

            <tr>

                <td>

                    {{ $discounts->firstItem() + $loop->index }}

                </td>

                <!-- Discount -->

                <td>

                    <div class="fw-semibold">

                        {{ $discount->name }}

                    </div>

                    <small class="text-muted">

                        Created
                        {{ $discount->created_at->format('d M Y') }}

                    </small>

                </td>

                <!-- Type -->

                <td>

                    @if($discount->type === 'Percentage')

                        <span class="badge bg-primary-subtle text-primary">

                            Percentage

                        </span>

                    @else

                        <span class="badge bg-info-subtle text-info">

                            Fixed

                        </span>

                    @endif

                </td>

                <!-- Value -->

                <td>

                    <strong>

                        {{ $discount->displayValue() }}

                    </strong>

                </td>

                <!-- Automatic -->

                <td>

                    @if($discount->is_automatic)

                        <span class="badge bg-success-subtle text-success">

                            Automatic

                        </span>

                    @else

                        <span class="badge bg-secondary-subtle text-secondary">

                            Manual

                        </span>

                    @endif

                </td>

                <!-- Validity -->

                <td>

                    <div>

                        {{ $discount->start_date->format('d M Y') }}

                    </div>

                    <small class="text-muted">

                        to

                        {{ $discount->end_date->format('d M Y') }}

                    </small>

                    <div class="mt-1">

                        @if($discount->isCurrent())

                            <span class="badge bg-success-subtle text-success">

                                Current

                            </span>

                        @else

                            <span class="badge bg-warning-subtle text-warning">

                                Expired / Upcoming

                            </span>

                        @endif

                    </div>

                </td>

                <!-- Status -->

                <td>

                    @if($discount->status)

                        <span class="badge bg-success">

                            Active

                        </span>

                    @else

                        <span class="badge bg-danger">

                            Inactive

                        </span>

                    @endif

                </td>

                <!-- Actions -->

                <td class="text-end">

                    <div class="dropdown">

                        <button
                            class="btn btn-light btn-sm"
                            data-bs-toggle="dropdown">

                            <i class="bi bi-three-dots-vertical"></i>

                        </button>

                        <ul class="dropdown-menu dropdown-menu-end">

                            <li>

                                <button
                                    class="dropdown-item btn-view"
                                    data-id="{{ $discount->id }}">

                                    <i class="bi bi-eye me-2"></i>

                                    View

                                </button>

                            </li>

                            <li>

                                <button
                                    class="dropdown-item btn-edit"
                                    data-id="{{ $discount->id }}">

                                    <i class="bi bi-pencil-square me-2"></i>

                                    Edit

                                </button>

                            </li>

                            <li>

                                <button
                                    class="dropdown-item btn-status"
                                    data-id="{{ $discount->id }}"
                                    data-status="{{ $discount->status }}">

                                    <i class="bi bi-arrow-repeat me-2"></i>

                                    {{ $discount->status ? 'Disable' : 'Enable' }}

                                </button>

                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li>

                                <button
                                    class="dropdown-item text-danger btn-delete"
                                    data-id="{{ $discount->id }}">

                                    <i class="bi bi-trash me-2"></i>

                                    Delete

                                </button>

                            </li>

                        </ul>

                    </div>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="8">

                    <div class="empty-state py-5 text-center">

                        <i class="bi bi-tags display-5 text-muted"></i>

                        <h5 class="mt-3">

                            No Discounts Found

                        </h5>

                        <p class="text-muted mb-0">

                            Create your first discount to get started.

                        </p>

                    </div>

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@if($discounts->hasPages())

<div class="card-footer">

    {{ $discounts->links() }}

</div>

@endif