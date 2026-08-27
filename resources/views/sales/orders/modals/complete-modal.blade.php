{{-- ==============================================================
    Complete Sales Order Modal
============================================================== --}}

<div
    class="modal fade"
    id="completeOrderModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div
        class="modal-dialog modal-dialog-centered modal-lg"
    >

        <div class="modal-content border-0 shadow-lg">

            {{-- ==================================================
                Header
            =================================================== --}}

            <div class="modal-header">

                <div>

                    <div class="text-muted small mb-1">
                        Sales Order
                    </div>

                    <h5
                        class="modal-title fw-semibold"
                        id="completeOrderModalTitle"
                    >
                        Complete Order
                    </h5>

                    <div
                        class="text-muted small"
                        id="completeOrderModalDescription"
                    >
                        Review the order and process payment.
                    </div>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <form
                id="completeOrderForm"
            >

                <input
                    type="hidden"
                    id="completeOrderId"
                >


                <div class="modal-body">

                    {{-- ==================================================
                        Order Summary
                    =================================================== --}}

                    <div class="sales-order-complete-summary">

                        <div class="sales-order-complete-summary-main">

                            <div class="small text-muted">
                                Order
                            </div>

                            <div
                                class="fw-semibold"
                                id="completeOrderNumber"
                            >
                                —
                            </div>

                        </div>


                        <div class="sales-order-complete-summary-item">

                            <span class="small text-muted">
                                Customer
                            </span>

                            <strong
                                id="completeOrderCustomer"
                            >
                                Walk-in Customer
                            </strong>

                        </div>


                        <div class="sales-order-complete-summary-item">

                            <span class="small text-muted">
                                Items
                            </span>

                            <strong
                                id="completeOrderItems"
                            >
                                0
                            </strong>

                        </div>


                        <div class="sales-order-complete-summary-total">

                            <span>
                                Amount Due
                            </span>

                            <strong id="completeOrderGrandTotal">
                                0.00
                            </strong>

                        </div>

                    </div>


                    {{-- ==================================================
                        Payment
                    =================================================== --}}

                    <div class="purchase-form-section mt-3">

                        <div class="purchase-form-section-title mb-3">

                            <i class="bi bi-credit-card me-2"></i>

                            Payment

                        </div>


                        <div class="row g-3">

                            {{-- Amount Due --}}

                            <div class="col-md-4">

                                <label
                                    class="form-label"
                                    for="completeOrderAmountDue"
                                >
                                    Amount Due
                                </label>

                                <input
                                    type="text"
                                    class="form-control bg-light"
                                    id="completeOrderAmountDue"
                                    readonly
                                >

                            </div>


                            {{-- Amount Paid --}}

                            <div class="col-md-4">

                                <label
                                    class="form-label"
                                    for="completeOrderAmountPaid"
                                >
                                    Amount Paid
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="number"
                                    class="form-control"
                                    id="completeOrderAmountPaid"
                                    name="amount_paid"
                                    min="0"
                                    step="0.01"
                                    value="0"
                                    required
                                >

                            </div>


                            {{-- Payment Method --}}

                            <div class="col-md-4">

                                <label
                                    class="form-label"
                                    for="completeOrderPaymentMethod"
                                >
                                    Payment Method
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    class="form-select"
                                    id="completeOrderPaymentMethod"
                                    name="payment_method"
                                    required
                                >

                                    <option value="">
                                        Select payment method
                                    </option>

                                    <option value="Cash">
                                        Cash
                                    </option>

                                    <option value="Card">
                                        Card
                                    </option>

                                    <option value="Bank Transfer">
                                        Bank Transfer
                                    </option>

                                    <option value="Mobile Money">
                                        Mobile Money
                                    </option>

                                </select>

                            </div>

                        </div>


                        {{-- ==================================================
                            Payment Result
                        =================================================== --}}

                        <div
                            class="sales-order-payment-preview mt-3"
                            id="completeOrderPaymentPreview"
                        >

                            <div class="sales-order-payment-preview-item">

                                <span>
                                    Amount Due
                                </span>

                                <strong
                                    id="completeOrderPreviewDue"
                                >
                                    0.00
                                </strong>

                            </div>


                            <div class="sales-order-payment-preview-item">

                                <span>
                                    Amount Paid
                                </span>

                                <strong
                                    id="completeOrderPreviewPaid"
                                >
                                    0.00
                                </strong>

                            </div>


                            <div class="sales-order-payment-preview-item">

                                <span>
                                    Balance
                                </span>

                                <strong
                                    id="completeOrderPreviewBalance"
                                >
                                    0.00
                                </strong>

                            </div>


                            <div class="sales-order-payment-preview-item">

                                <span>
                                    Change
                                </span>

                                <strong
                                    id="completeOrderPreviewChange"
                                >
                                    0.00
                                </strong>

                            </div>

                        </div>

                    </div>


                    {{-- ==================================================
                        Warning
                    =================================================== --}}

                    <div
                        class="alert alert-warning d-none mt-3"
                        id="completeOrderWarning"
                    >

                        <i class="bi bi-exclamation-triangle me-2"></i>

                        <span id="completeOrderWarningText"></span>

                    </div>

                </div>


                {{-- ==================================================
                    Footer
                =================================================== --}}

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light border"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>


                    <button
                        type="submit"
                        class="btn btn-success"
                        id="completeOrderSubmitBtn"
                    >

                        <span id="completeOrderSubmitText">

                            <i class="bi bi-check2-circle me-1"></i>

                            Complete Order

                        </span>


                        <span
                            class="spinner-border spinner-border-sm d-none"
                            id="completeOrderSubmitSpinner"
                        ></span>

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>