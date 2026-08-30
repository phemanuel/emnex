<div
    class="modal fade"
    id="refundOrderItemsModal"
    tabindex="-1"
    aria-labelledby="refundOrderItemsModalLabel"
    aria-hidden="true"
>

    <div
        class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable returns-items-modal-dialog"
    >

        <div class="modal-content">

            {{-- Header --}}

            <div class="modal-header">

                <div>

                    <h5
                        class="modal-title"
                        id="refundOrderItemsModalLabel"
                    >
                        Order Items
                    </h5>

                    <p
                        class="text-muted small mb-0"
                        id="refundOrderItemsSubtitle"
                    >
                        —
                    </p>

                    <span class="text-muted small" id="refundOrderItemsBranch" > 
                        <i class="bi bi-shop me-1"></i> — 
                    </span>

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
            ================================================== --}}

            <div class="modal-body">


                {{-- ==================================================
                    Order Summary
                =================================================== --}}

                <div class="order-items-summary mb-4">

                    <div class="row g-3">


                        {{-- Total Items --}}

                        <div class="col-md-4">

                            <div class="order-items-summary-card">

                                <span class="text-muted small">
                                    Total Items
                                </span>

                                <strong
                                    id="refundOrderItemsTotalItems"
                                >
                                    0
                                </strong>

                            </div>

                        </div>


                        {{-- Total Amount --}}

                       
                        <div class="col-md-4">

                            <div class="order-items-summary-card">

                                <span class="text-muted small">
                                    Total Amount
                                </span>

                                <strong
                                    id="refundOrderItemsTotalAmount"
                                >
                                    {{ \App\Helpers\CurrencyHelper::symbol() }}0.00
                                </strong>

                            </div>

                        </div>


                        {{-- Amount Paid --}}

                        <div class="col-md-4">

                            <div class="order-items-summary-card">

                                <span class="text-muted small">
                                    Amount Paid
                                </span>

                                <strong
                                    id="refundOrderItemsAmountPaid"
                                >
                                    {{ \App\Helpers\CurrencyHelper::symbol() }}0.00
                                </strong>

                            </div>

                        </div>


                        {{-- Balance --}}

                        <div class="col-md-4">

                            <div class="order-items-summary-card">

                                <span class="text-muted small">
                                    Balance
                                </span>

                                <strong
                                    id="refundOrderItemsBalance"
                                >
                                    {{ \App\Helpers\CurrencyHelper::symbol() }}0.00
                                </strong>

                            </div>

                        </div>




                        {{-- Payment Status --}}

                        <div class="col-md-4">

                            <div class="order-items-summary-card">

                                <span class="text-muted small d-block">
                                    Payment Status
                                </span>

                                <span
                                    id="refundOrderItemsPaymentStatus"
                                    class="badge"
                                >
                                    —
                                </span>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ==================================================
                    Loading
                =================================================== --}}

                <div
                    id="refundOrderItemsLoading"
                    class="text-center py-5 d-none"
                >

                    <div
                        class="spinner-border text-primary"
                        role="status"
                    >

                        <span class="visually-hidden">
                            Loading...
                        </span>

                    </div>

                    <div class="text-muted small mt-2">
                        Loading order items...
                    </div>

                </div>


                {{-- ==================================================
                    Empty State
                =================================================== --}}

                <div
                    id="refundOrderItemsEmpty"
                    class="text-center py-5 d-none"
                >

                    <i class="bi bi-box-seam fs-2 text-muted"></i>

                    <p class="text-muted mt-2 mb-0">
                        No items found for this order.
                    </p>

                </div>


                {{-- ==================================================
                    Items Table
                =================================================== --}}

                <div
                    id="refundOrderItemsContainer"
                    class="table-responsive"
                >

                    <table class="table align-middle mb-0">

                        <thead>

                            <tr>

                                <th>
                                    Product
                                </th>

                                <th>
                                    SKU
                                </th>

                                <th class="text-center">
                                    Qty
                                </th>

                                <th class="text-end">
                                    Unit Price
                                </th>

                                <th class="text-end">
                                    Total
                                </th>

                            </tr>

                        </thead>

                        <tbody
                            id="refundOrderItemsTableBody"
                        ></tbody>

                    </table>

                </div>

            </div>



            {{-- Footer --}}

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