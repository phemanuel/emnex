<div class="table-responsive">


    <table class="table low-stock-table align-middle">


        <thead>

            <tr>


                <th>
                    Product
                </th>


                <th>
                    SKU
                </th>


                <th>
                    Category
                </th>


                <th>
                    Branch
                </th>


                <th>
                    Current Stock
                </th>


                <th>
                    Reorder Level
                </th>


                <th>
                    Shortage
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


        @forelse($stocks as $stock)


            @php

                $quantity =
                    (float) $stock->quantity;

                $reorderLevel =
                    (float) $stock->reorder_level;

                $shortage =
                    max(
                        0,
                        $reorderLevel - $quantity
                    );

            @endphp


            <tr>


                {{-- ==================================================
                PRODUCT
                =================================================== --}}


                <td>


                    <div class="d-flex align-items-center gap-3">


                        <div class="low-stock-product-avatar">


                            @if(
                                $stock->product?->image
                            )


                                <img
                                    src="{{ asset(
                                        'uploads/products/' .
                                        $stock->product->image
                                    ) }}"
                                    alt="{{ $stock->product->name }}"
                                >


                            @else


                                <i class="bi bi-box-seam"></i>


                            @endif


                        </div>


                        <div>


                            <div class="fw-semibold">


                                {{ $stock->product?->name ?? '-' }}


                            </div>


                            <small class="text-muted">


                                {{ $stock->product?->barcode ?? '-' }}


                            </small>


                        </div>


                    </div>


                </td>



                {{-- ==================================================
                SKU
                =================================================== --}}


                <td>


                    {{ $stock->product?->sku ?? '-' }}


                </td>



                {{-- ==================================================
                CATEGORY
                =================================================== --}}


                <td>


                    {{ $stock->product?->category?->name ?? '-' }}


                </td>



                {{-- ==================================================
                BRANCH
                =================================================== --}}


                <td>


                    {{ $stock->branch?->name ?? '-' }}


                </td>



                {{-- ==================================================
                CURRENT STOCK
                =================================================== --}}


                <td>


                    <strong
                        class="{{ $quantity <= 0
                            ? 'text-danger'
                            : 'text-warning'
                        }}"
                    >


                        {{ number_format(
                            $quantity,
                            2
                        ) }}


                    </strong>


                </td>



                {{-- ==================================================
                REORDER LEVEL
                =================================================== --}}


                <td>


                    {{ number_format(
                        $reorderLevel,
                        2
                    ) }}


                </td>



                {{-- ==================================================
                SHORTAGE
                =================================================== --}}


                <td>


                    <strong class="text-danger">


                        {{ number_format(
                            $shortage,
                            2
                        ) }}


                    </strong>


                </td>



                {{-- ==================================================
                STATUS
                =================================================== --}}


                <td>


                    @if(
                        $quantity <= 0
                    )


                        <span class="badge bg-danger-subtle text-danger">


                            <i class="bi bi-x-circle me-1"></i>


                            Out Of Stock


                        </span>


                    @else


                        <span class="badge bg-warning-subtle text-warning">


                            <i class="bi bi-exclamation-triangle me-1"></i>


                            Low Stock


                        </span>


                    @endif


                </td>



                {{-- ==================================================
                ACTION
                =================================================== --}}


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


                            @permission('inventory.view')


                                <li>


                                    <button
                                        type="button"
                                        class="dropdown-item low-stock-view-btn"
                                        data-id="{{ $stock->id }}"
                                    >


                                        <i class="bi bi-eye me-2"></i>


                                        View Details


                                    </button>


                                </li>


                            @endpermission



                            {{-- ADJUST STOCK --}}


                            @permission('inventory.adjust_stock')


                                <li>

                                    <a
                                        href="{{ route('stock.index') }}"
                                        class="dropdown-item"
                                    >

                                        <i class="bi bi-sliders me-2"></i>

                                        Adjust Stock

                                    </a>

                                </li>


                            @endpermission


                        </ul>


                    </div>


                </td>


            </tr>


        @empty


            <tr>


                <td
                    colspan="9"
                    class="text-center"
                >


                    <div class="low-stock-empty-state">


                        <div class="low-stock-empty-icon">


                            <i class="bi bi-check-circle"></i>


                        </div>


                        <h6>

                            No Low Stock Items

                        </h6>


                        <p>

                            All products are currently above their reorder levels.

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
=========================================================== --}}


@if(
    $stocks->hasPages()
)


    <div class="low-stock-pagination mt-3">


        {{ $stocks->links() }}


    </div>


@endif