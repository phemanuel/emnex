
{{-- ==========================================================
    Refund Orders Modal
=========================================================== --}}

<div
    class="modal fade"
    id="refundOrdersModal"
    tabindex="-1"
    aria-labelledby="refundOrdersModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content">


            {{-- ==================================================
                Header
            =================================================== --}}

            <div class="modal-header">

                <div>

                    <h5
                        class="modal-title mb-1"
                        id="refundOrdersModalLabel"
                    >
                        Return / Refund Order
                    </h5>

                    <p class="text-muted small mb-0">

                        Select a completed or held order to view
                        its payments and process a refund.

                    </p>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            {{-- ==================================================
                Body
            =================================================== --}}

            <div class="modal-body p-0">
         
            {{-- ==================================================
                Filters
            =================================================== --}}

            <div class="p-4 border-bottom">

                <div class="row g-3">


                    {{-- ==================================================
                        Row 1
                    =================================================== --}}


                    {{-- Search --}}

                    <div class="col-lg-4">

                        <label
                            for="refundOrderSearch"
                            class="form-label"
                        >
                            Search
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-white">

                                <i class="bi bi-search"></i>

                            </span>

                            <input
                                type="text"
                                class="form-control"
                                id="refundOrderSearch"
                                placeholder="Order no., customer..."
                                autocomplete="off"
                            >

                        </div>

                    </div>


                    {{-- Branch --}}

                    <div class="col-lg-4">

                        <label
                            for="refundBranchFilter"
                            class="form-label"
                        >
                            Branch
                        </label>

                        <select
                            id="refundBranchFilter"
                            class="form-select"
                        >

                            <option value="">
                                All Branches
                            </option>

                            @foreach ($branches as $branch)

                                <option value="{{ $branch->id }}">
                                    {{ $branch->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Order Status --}}

                    <div class="col-lg-4">

                        <label
                            for="refundOrderStatus"
                            class="form-label"
                        >
                            Order Status
                        </label>

                        <select
                            class="form-select"
                            id="refundOrderStatus"
                        >

                            <option value="">
                                All
                            </option>

                            <option value="Completed">
                                Completed
                            </option>

                            <option value="Held">
                                Held
                            </option>

                        </select>

                    </div>


                    {{-- ==================================================
                        Row 2
                    =================================================== --}}


                    {{-- Payment Status --}}

                    <div class="col-lg-4">

                        <label
                            for="refundPaymentStatus"
                            class="form-label"
                        >
                            Payment Status
                        </label>

                        <select
                            class="form-select"
                            id="refundPaymentStatus"
                        >

                            <option value="">
                                All
                            </option>

                            <option value="Paid">
                                Paid
                            </option>

                            <option value="Partial">
                                Partial
                            </option>

                        </select>

                    </div>


                    {{-- Date From --}}

                    <div class="col-lg-4">

                        <label
                            for="refundDateFrom"
                            class="form-label"
                        >
                            From
                        </label>

                        <input
                            type="date"
                            class="form-control"
                            id="refundDateFrom"
                        >

                    </div>


                    {{-- Date To --}}

                    <div class="col-lg-4">

                        <label
                            for="refundDateTo"
                            class="form-label"
                        >
                            To
                        </label>

                        <input
                            type="date"
                            class="form-control"
                            id="refundDateTo"
                        >

                    </div>


                    {{-- ==================================================
                        Refresh
                    =================================================== --}}

                    <div class="col-12 d-flex justify-content-end">

                        <button
                            type="button"
                            class="btn btn-light border"
                            id="refreshRefundOrders"
                            title="Refresh"
                        >

                            <i class="bi bi-arrow-clockwise me-1"></i>

                            Refresh

                        </button>

                    </div>


                </div>

            </div>





                {{-- ==================================================
                    Orders Table
                =================================================== --}}

                <div class="table-responsive">

                    <table
                        class="table table-hover align-middle mb-0"
                        id="refundOrdersTable"
                    >

                        <thead class="table-light">

                            <tr>

                                <th class="ps-4">
                                    Order No.
                                </th>

                                <th>
                                    Invoice No.
                                </th>

                                <th>
                                    Customer
                                </th>
                               
                                <th>
                                    Branch
                                </th>

                                <th>
                                    Order Total
                                </th>

                                <th>
                                    Amount Paid
                                </th>

                                <th>
                                    Balance
                                </th>

                                <th>
                                    Order Status
                                </th>

                                <th>
                                    Payment Status
                                </th>

                                <th class="text-end pe-4">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody id="refundOrdersTableBody">

                            {{-- Populated by JavaScript --}}

                        </tbody>

                    </table>

                </div>


                {{-- ==================================================
                    Loading
                =================================================== --}}

                <div
                    id="refundOrdersLoading"
                    class="d-none"
                >

                    <div class="text-center py-5">

                        <div
                            class="spinner-border spinner-border-sm text-primary mb-3"
                            role="status"
                        >

                            <span class="visually-hidden">
                                Loading...
                            </span>

                        </div>

                        <div class="text-muted small">
                            Loading orders...
                        </div>

                    </div>

                </div>


                {{-- ==================================================
                    Empty State
                =================================================== --}}

                <div
                    id="refundOrdersEmpty"
                    class="d-none"
                >

                    <div class="text-center py-5 px-4">

                        <div class="emnex-empty-icon mx-auto mb-3">

                            <i class="bi bi-receipt"></i>

                        </div>

                        <h6 class="fw-semibold mb-1">
                            No refundable orders found
                        </h6>

                        <p class="text-muted small mb-0">

                            No completed or held orders with refundable
                            payments match your search or filters.

                        </p>

                    </div>

                </div>


                {{-- ==================================================
                    Error State
                =================================================== --}}

                <div
                    id="refundOrdersError"
                    class="d-none"
                >

                    <div class="text-center py-5 px-4">

                        <div class="emnex-empty-icon mx-auto mb-3">

                            <i class="bi bi-exclamation-triangle"></i>

                        </div>

                        <h6 class="fw-semibold mb-1">
                            Unable to load orders
                        </h6>

                        <p
                            class="text-muted small mb-3"
                            id="refundOrdersErrorMessage"
                        >
                            Something went wrong while loading orders.
                        </p>

                        <button
                            type="button"
                            class="btn btn-light btn-sm"
                            id="refundOrdersRetry"
                        >

                            <i class="bi bi-arrow-clockwise me-1"></i>

                            Try Again

                        </button>

                    </div>

                </div>

            </div>


            {{-- ==================================================
                Footer
            =================================================== --}}

            <div class="modal-footer">

                <div
                    class="text-muted small me-auto"
                    id="refundOrdersPaginationInfo"
                >
                    Showing 0 to 0 of 0 orders
                </div>


                <nav
                    aria-label="Refund orders pagination"
                >

                    <ul
                        class="pagination pagination-sm mb-0"
                        id="refundOrdersPagination"
                    >

                        {{-- Populated by JavaScript --}}

                    </ul>

                </nav>


                <button
                    type="button"
                    class="btn btn-light ms-2"
                    data-bs-dismiss="modal"
                >
                    Close
                </button>

            </div>

        </div>

    </div>

</div>

