{{-- ==========================================================
    SALES REPORT — TRANSACTION INSPECTOR
========================================================== --}}

<div
    class="modal fade"
    id="salesTransactionInspectorModal"
    tabindex="-1"
    aria-labelledby="salesTransactionInspectorModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-scrollable modal-xl">

        <div class="modal-content sales-report-inspector-modal">

            {{-- ==================================================
                HEADER
            =================================================== --}}
            <div class="modal-header">

                <div>

                    <div class="sales-report-inspector-eyebrow">
                        <i class="bi bi-receipt"></i>
                        Transaction Details
                    </div>

                    <h5
                        class="modal-title"
                        id="salesTransactionInspectorModalLabel"
                    >
                        Sale Details
                    </h5>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            {{-- ==================================================
                BODY
            =================================================== --}}
            <div class="modal-body">

                <div
                    class="sales-report-inspector-loading d-none"
                    id="salesInspectorLoading"
                >
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">
                            Loading transaction...
                        </span>
                    </div>

                    <span>
                        Loading transaction details...
                    </span>
                </div>


                <div
                    class="sales-report-inspector-content"
                    id="salesInspectorContent"
                >

                    {{-- ------------------------------------------
                        TRANSACTION SUMMARY
                    ------------------------------------------- --}}
                    <div class="sales-inspector-summary">

                        <div class="sales-inspector-summary-item">

                            <span class="sales-inspector-label">
                                Order Number
                            </span>

                            <strong id="salesInspectorOrderNo">
                                —
                            </strong>

                        </div>

                        <div class="sales-inspector-summary-item">

                            <span class="sales-inspector-label">
                                Date
                            </span>

                            <strong id="salesInspectorDate">
                                —
                            </strong>

                        </div>

                        <div class="sales-inspector-summary-item">

                            <span class="sales-inspector-label">
                                Status
                            </span>

                            <span
                                class="badge"
                                id="salesInspectorStatus"
                            >
                                —
                            </span>

                        </div>

                    </div>


                    {{-- ------------------------------------------
                        CUSTOMER / STAFF / LOCATION
                    ------------------------------------------- --}}
                    <div class="sales-inspector-info-grid">

                        <div class="sales-inspector-info-card">

                            <span class="sales-inspector-label">
                                Customer
                            </span>

                            <strong id="salesInspectorCustomer">
                                —
                            </strong>

                        </div>

                        <div class="sales-inspector-info-card">

                            <span class="sales-inspector-label">
                                Cashier
                            </span>

                            <strong id="salesInspectorCashier">
                                —
                            </strong>

                        </div>

                        <div class="sales-inspector-info-card">

                            <span class="sales-inspector-label">
                                Branch
                            </span>

                            <strong id="salesInspectorBranch">
                                —
                            </strong>

                        </div>

                        <div class="sales-inspector-info-card">

                            <span class="sales-inspector-label">
                                Terminal
                            </span>

                            <strong id="salesInspectorTerminal">
                                —
                            </strong>

                        </div>

                    </div>


                    {{-- ------------------------------------------
                        ITEMS
                    ------------------------------------------- --}}
                    <div class="sales-inspector-section">

                        <div class="sales-inspector-section-header">

                            <h6>
                                Items
                            </h6>

                        </div>

                        <div class="table-responsive">

                            <table class="table sales-report-table">

                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-end">Qty</th>
                                        <th class="text-end">Unit Price</th>
                                        <th class="text-end">Discount</th>
                                        <th class="text-end">Tax</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>

                                <tbody id="salesInspectorItemsBody">

                                    <tr>
                                        <td colspan="6" class="text-center">
                                            No items available.
                                        </td>
                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>


                    {{-- ------------------------------------------
                        PAYMENT
                    ------------------------------------------- --}}
                    <div class="sales-inspector-section">

                        <div class="sales-inspector-section-header">

                            <h6>
                                Payment
                            </h6>

                        </div>

                        <div class="sales-inspector-payment-grid">

                            <div>
                                <span class="sales-inspector-label">
                                    Payment Method
                                </span>

                                <strong id="salesInspectorPaymentMethod">
                                    —
                                </strong>
                            </div>

                            <div>
                                <span class="sales-inspector-label">
                                    Reference
                                </span>

                                <strong id="salesInspectorPaymentReference">
                                    —
                                </strong>
                            </div>

                            <div>
                                <span class="sales-inspector-label">
                                    Amount Paid
                                </span>

                                <strong id="salesInspectorAmountPaid">
                                    ₦0.00
                                </strong>
                            </div>

                        </div>

                    </div>


                    {{-- ------------------------------------------
                        TOTALS
                    ------------------------------------------- --}}
                    <div class="sales-inspector-totals">

                        <div class="sales-inspector-total-row">
                            <span>Gross Sales</span>
                            <strong id="salesInspectorGross">
                                ₦0.00
                            </strong>
                        </div>

                        <div class="sales-inspector-total-row">
                            <span>Discount</span>
                            <strong id="salesInspectorDiscount">
                                ₦0.00
                            </strong>
                        </div>

                        <div class="sales-inspector-total-row">
                            <span>Tax</span>
                            <strong id="salesInspectorTax">
                                ₦0.00
                            </strong>
                        </div>

                        <div class="sales-inspector-total-row sales-inspector-total-final">
                            <span>Total</span>
                            <strong id="salesInspectorTotal">
                                ₦0.00
                            </strong>
                        </div>

                    </div>

                </div>

            </div>


            {{-- ==================================================
                FOOTER
            =================================================== --}}
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