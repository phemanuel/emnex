{{-- 
|--------------------------------------------------------------------------
| Sales History Modal
|--------------------------------------------------------------------------
--}}

<div
    class="modal fade pos-modal"
    id="posSalesHistoryModal"
    tabindex="-1"
    aria-labelledby="posSalesHistoryModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered modal-xl">

        <div class="modal-content">


            {{-- 
            |--------------------------------------------------------------------------
            | Header
            |--------------------------------------------------------------------------
            --}}

            <div class="modal-header">

                <div class="pos-modal-heading">

                    <div class="pos-modal-icon">

                        <i class="bi bi-clock-history"></i>

                    </div>

                    <div>

                        <h5
                            class="modal-title"
                            id="posSalesHistoryModalLabel"
                        >
                            Sales History
                        </h5>

                        <p class="text-muted small mb-0">
                            View your completed sales and payment history.
                        </p>

                    </div>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            {{-- 
            |--------------------------------------------------------------------------
            | Body
            |--------------------------------------------------------------------------
            --}}

            <div class="modal-body pos-sales-history-modal-body">


                {{-- 
                |--------------------------------------------------------------------------
                | Summary
                |--------------------------------------------------------------------------
                --}}

                <div class="row g-3 mb-4">

                    <div class="col-xl-3 col-md-6">

                        <div class="pos-sales-history-stat">

                            <span class="pos-sales-history-stat-label">
                                Total Sales
                            </span>

                            <strong
                                id="pos-history-total-sales"
                                class="pos-sales-history-stat-value"
                            >
                                ₦0.00
                            </strong>

                        </div>

                    </div>


                    <div class="col-xl-3 col-md-6">

                        <div class="pos-sales-history-stat">

                            <span class="pos-sales-history-stat-label">
                                Transactions
                            </span>

                            <strong
                                id="pos-history-transaction-count"
                                class="pos-sales-history-stat-value"
                            >
                                0
                            </strong>

                        </div>

                    </div>


                    <div class="col-xl-3 col-md-6">

                        <div class="pos-sales-history-stat">

                            <span class="pos-sales-history-stat-label">
                                Average Sale
                            </span>

                            <strong
                                id="pos-history-average-sale"
                                class="pos-sales-history-stat-value"
                            >
                                ₦0.00
                            </strong>

                        </div>

                    </div>


                    <div class="col-xl-3 col-md-6">

                        <div class="pos-sales-history-stat">

                            <span class="pos-sales-history-stat-label">
                                Cash Sales
                            </span>

                            <strong
                                id="pos-history-cash-sales"
                                class="pos-sales-history-stat-value"
                            >
                                ₦0.00
                            </strong>

                        </div>

                    </div>

                </div>


                {{-- 
                |--------------------------------------------------------------------------
                | Payment Breakdown
                |--------------------------------------------------------------------------
                --}}

                <div class="pos-sales-history-breakdown mb-4">

                    <div class="pos-sales-history-breakdown-item">

                        <span>
                            Cash
                        </span>

                        <strong id="pos-history-cash">
                            ₦0.00
                        </strong>

                    </div>


                    <div class="pos-sales-history-breakdown-item">

                        <span>
                            Card
                        </span>

                        <strong id="pos-history-card">
                            ₦0.00
                        </strong>

                    </div>


                    <div class="pos-sales-history-breakdown-item">

                        <span>
                            Transfer
                        </span>

                        <strong id="pos-history-transfer">
                            ₦0.00
                        </strong>

                    </div>


                    <div class="pos-sales-history-breakdown-item">

                        <span>
                            Wallet
                        </span>

                        <strong id="pos-history-wallet">
                            ₦0.00
                        </strong>

                    </div>

                </div>


                {{-- 
                |--------------------------------------------------------------------------
                | Filters
                |--------------------------------------------------------------------------
                --}}

                <div class="row g-3 mb-3">


                    {{-- 
                    |--------------------------------------------------------------------------
                    | Search
                    |--------------------------------------------------------------------------
                    --}}

                    <div class="col-md-5">

                        <label
                            for="pos-sales-history-search"
                            class="form-label"
                        >
                            Search
                        </label>

                        <div class="pos-modal-search">

                            <i class="bi bi-search"></i>

                            <input
                                type="search"
                                class="form-control"
                                id="pos-sales-history-search"
                                placeholder="Search order number or customer..."
                                autocomplete="off"
                            >

                        </div>

                    </div>


                    {{-- 
                    |--------------------------------------------------------------------------
                    | Date From
                    |--------------------------------------------------------------------------
                    --}}

                    <div class="col-md-2">

                        <label
                            for="pos-sales-history-date-from"
                            class="form-label"
                        >
                            Date From
                        </label>

                        <input
                            type="date"
                            class="form-control"
                            id="pos-sales-history-date-from"
                        >

                    </div>


                    {{-- 
                    |--------------------------------------------------------------------------
                    | Date To
                    |--------------------------------------------------------------------------
                    --}}

                    <div class="col-md-2">

                        <label
                            for="pos-sales-history-date-to"
                            class="form-label"
                        >
                            Date To
                        </label>

                        <input
                            type="date"
                            class="form-control"
                            id="pos-sales-history-date-to"
                        >

                    </div>


                    {{-- 
                    |--------------------------------------------------------------------------
                    | Reset
                    |--------------------------------------------------------------------------
                    --}}

                    <div class="col-md-3 d-flex align-items-end">

                        <button
                            type="button"
                            class="btn btn-dark px-3"
                            id="pos-sales-history-reset"
                        >
                            <i class="bi bi-arrow-counterclockwise me-1"></i>
                            Reset
                        </button>

                    </div>


                </div>


                {{-- 
                |--------------------------------------------------------------------------
                | Sales Table
                |--------------------------------------------------------------------------
                --}}

                <div class="table-responsive">

                    <table
                        class="table align-middle mb-0 pos-sales-history-table"
                    >

                        <thead>

                            <tr>

                                <th>
                                    Order
                                </th>

                                <th>
                                    Customer
                                </th>

                                <th>
                                    Cashier
                                </th>

                                <th>
                                    Payment
                                </th>

                                <th>
                                    Total
                                </th>

                                <th>
                                    Date
                                </th>

                                <th class="text-end">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody
                            id="pos-sales-history-body"
                        >

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center py-5 text-muted"
                                >
                                    Loading sales...
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>


                {{-- 
                |--------------------------------------------------------------------------
                | Pagination
                |--------------------------------------------------------------------------
                --}}

                <div
                    id="pos-sales-history-pagination"
                    class="mt-3"
                ></div>


            </div>


            {{-- 
            |--------------------------------------------------------------------------
            | Footer
            |--------------------------------------------------------------------------
            --}}

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal"
                >
                    Close
                </button>

            </div>


        </div>

    </div>

</div>