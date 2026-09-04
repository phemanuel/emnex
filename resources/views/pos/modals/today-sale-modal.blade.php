<div
    class="modal fade pos-modal"
    id="posTodaysSalesModal"
    tabindex="-1"
    aria-labelledby="posTodaysSalesModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-xl">


    <div class="modal-content">

        <div class="modal-header">

            <div class="pos-modal-heading">

                <div class="pos-modal-icon">

                    <i class="bi bi-bar-chart-line"></i>

                </div>

                <div>

                    <h5
                        class="modal-title"
                        id="posTodaysSalesModalLabel"
                    >
                        Today's Sales
                    </h5>

                    <p class="text-muted small mb-0">
                        Today's completed sales and payment summary.
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


       <div class="modal-body pos-todays-sales-modal-body">

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
                            id="pos-todays-sales-total"
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
                            id="pos-todays-sales-transaction-count"
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
                            id="pos-todays-sales-average"
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
                            id="pos-todays-sales-cash-total"
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

                    <strong id="pos-todays-sales-cash">
                        ₦0.00
                    </strong>

                </div>


                <div class="pos-sales-history-breakdown-item">

                    <span>
                        Card
                    </span>

                    <strong id="pos-todays-sales-card">
                        ₦0.00
                    </strong>

                </div>


                <div class="pos-sales-history-breakdown-item">

                    <span>
                        Transfer
                    </span>

                    <strong id="pos-todays-sales-transfer">
                        ₦0.00
                    </strong>

                </div>


                <div class="pos-sales-history-breakdown-item">

                    <span>
                        Wallet
                    </span>

                    <strong id="pos-todays-sales-wallet">
                        ₦0.00
                    </strong>

                </div>

            </div>


            {{-- 
            |--------------------------------------------------------------------------
            | Search
            |--------------------------------------------------------------------------
            --}}

            <div class="pos-modal-search mb-3">

                <i class="bi bi-search"></i>

                <input
                    type="search"
                    class="form-control"
                    id="pos-todays-sales-search"
                    placeholder="Search order number or customer..."
                    autocomplete="off"
                >

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
                                Time
                            </th>

                            <th class="text-end">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody
                        id="pos-todays-sales-body"
                    >

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-5 text-muted"
                            >
                                Loading today's sales...
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>


            <div
                id="pos-todays-sales-pagination"
                class="mt-3"
            ></div>

        </div>


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
