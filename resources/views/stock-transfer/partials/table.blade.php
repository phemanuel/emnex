@if ($stocks->count())

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0 stock-transfer-table">

            <thead>

                <tr>

                    {{-- Select All --}}

                    <th class="stock-transfer-select-column">

                        <div class="form-check">

                            <input
                                type="checkbox"
                                class="form-check-input"
                                id="selectAllTransferProducts"
                                aria-label="Select all products"
                            >

                        </div>

                    </th>


                    <th>
                        Product
                    </th>


                    <th>
                        Category
                    </th>


                    <th>
                        SKU
                    </th>


                    <th>
                        Head Office
                    </th>


                    <th>
                        Available
                    </th>


                    <th>
                        Reorder Level
                    </th>


                    <th>
                        Status
                    </th>


                    <!-- <th class="text-end">
                        Actions
                    </th> -->

                </tr>

            </thead>


            <tbody>

                @foreach ($stocks as $stock)

                    @php

                        $available =
                            (float) $stock->available_quantity;

                        $reorderLevel =
                            (float) $stock->reorder_level;

                        if ($available <= 0) {

                            $status = 'out_stock';

                            $statusLabel =
                                'Out of Stock';

                            $statusClass =
                                'danger';

                        } elseif (
                            $reorderLevel > 0 &&
                            $available <= $reorderLevel
                        ) {

                            $status = 'low_stock';

                            $statusLabel =
                                'Low Stock';

                            $statusClass =
                                'warning';

                        } else {

                            $status = 'in_stock';

                            $statusLabel =
                                'In Stock';

                            $statusClass =
                                'success';

                        }

                    @endphp


                    <tr
                        data-stock-id="{{ $stock->id }}"
                        data-product-id="{{ $stock->product_id }}"
                        data-product-name="{{ $stock->product?->name }}"
                        data-product-sku="{{ $stock->product?->sku }}"
                        data-available-quantity="{{ $available }}"
                        data-reorder-level="{{ $reorderLevel }}"
                    >

                        {{-- ==================================================
                            SELECT
                        =================================================== --}}

                        <td>

                            <div class="form-check">

                                <input
                                    type="checkbox"
                                    class="form-check-input stock-transfer-checkbox"
                                    value="{{ $stock->id }}"
                                    data-stock-id="{{ $stock->id }}"
                                    data-product-id="{{ $stock->product_id }}"
                                    data-product-name="{{ $stock->product?->name }}"
                                    data-product-sku="{{ $stock->product?->sku }}"
                                    data-available="{{ $available }}"
                                    data-reorder-level="{{ $reorderLevel }}"
                                    @disabled($available <= 0)
                                >

                            </div>

                        </td>


                        {{-- ==================================================
                            PRODUCT
                        =================================================== --}}

                        <td>

                            <div class="stock-transfer-product-cell">

                                <div class="stock-transfer-product-image">

                                    @if ($stock->product?->imageUrl())

                                        <img
                                            src="{{ $stock->product->imageUrl() }}"
                                            alt="{{ $stock->product->name }}"
                                        >

                                    @else

                                        <i class="bi bi-box"></i>

                                    @endif

                                </div>


                                <div>

                                    <div class="stock-transfer-product-name">

                                        {{ $stock->product?->name ?? '-' }}

                                    </div>

                                    @if ($stock->product?->brand)

                                        <div class="stock-transfer-product-meta">

                                            {{ $stock->product->brand }}

                                        </div>

                                    @endif

                                </div>

                            </div>

                        </td>


                        {{-- ==================================================
                            CATEGORY
                        =================================================== --}}

                        <td>

                            <span class="text-muted">

                                {{ $stock->product?->category?->name ?? '-' }}

                            </span>

                        </td>


                        {{-- ==================================================
                            SKU
                        =================================================== --}}

                        <td>

                            <span class="stock-transfer-code">

                                {{ $stock->product?->sku ?? '-' }}

                            </span>

                        </td>


                        {{-- ==================================================
                            HEAD OFFICE STOCK
                        =================================================== --}}

                        <td>

                            <span class="fw-semibold">

                                {{ number_format(
                                    (float) $stock->quantity,
                                    2
                                ) }}

                            </span>

                        </td>


                        {{-- ==================================================
                            AVAILABLE
                        =================================================== --}}

                        <td>

                            <span class="fw-semibold">

                                {{ number_format(
                                    $available,
                                    2
                                ) }}

                            </span>

                        </td>


                        {{-- ==================================================
                            REORDER LEVEL
                        =================================================== --}}

                        <td>

                            <span class="text-muted">

                                {{ number_format(
                                    $reorderLevel,
                                    2
                                ) }}

                            </span>

                        </td>


                        {{-- ==================================================
                            STATUS
                        =================================================== --}}

                        <td>

                            <span
                                class="badge text-bg-{{ $statusClass }}"
                            >

                                {{ $statusLabel }}

                            </span>

                        </td>


                        {{-- ==================================================
                            ACTIONS
                        =================================================== --}}

                        <!-- <td class="text-end">

                            <div class="dropdown">

                                <button
                                    type="button"
                                    class="btn btn-sm btn-light"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >

                                    <i class="bi bi-three-dots"></i>

                                </button>


                                <ul class="dropdown-menu dropdown-menu-end">

                                    <li>

                                        <button
                                            type="button"
                                            class="dropdown-item stock-transfer-history-btn"
                                            data-id="{{ $stock->product_id }}"
                                        >

                                            <i class="bi bi-clock-history me-2"></i>

                                            Transfer History

                                        </button>

                                    </li>

                                </ul>

                            </div>

                        </td> -->

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

@else

    <div class="stock-empty-state">

        <div class="stock-empty-state-icon">

            <i class="bi bi-box-seam"></i>

        </div>

        <h6>
            No transferable stock found
        </h6>

        <p>
            There are no Head Office products matching your current filters.
        </p>

    </div>

@endif