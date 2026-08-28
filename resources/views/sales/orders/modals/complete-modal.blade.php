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

            <div class="modal-header sales-order-complete-header">

                <div class="sales-order-complete-header-main">

                    <div class="sales-order-complete-header-icon">

                        <i class="bi bi-receipt-cutoff"></i>

                    </div>


                    <div class="sales-order-complete-header-content">

                        <div class="sales-order-complete-header-label">

                            Sales Order

                        </div>


                        <h5
                            class="modal-title sales-order-complete-header-title"
                            id="completeOrderModalTitle"
                        >
                            Complete Order
                        </h5>


                        <div
                            class="sales-order-complete-header-description"
                            id="completeOrderModalDescription"
                        >

                            Review the order and process payment.

                        </div>

                    </div>

                </div>


                <button
                    type="button"
                    class="btn-close sales-order-complete-header-close"
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

                        {{-- ==================================================
                            Order
                        =================================================== --}}

                        <div class="sales-order-complete-summary-item">

                            <div class="sales-order-complete-summary-icon">

                                <i class="bi bi-receipt"></i>

                            </div>


                            <div class="sales-order-complete-summary-content">

                                <span class="sales-order-complete-summary-label">
                                    Order
                                </span>


                                <strong
                                    id="completeOrderNumber"
                                    class="sales-order-complete-summary-value"
                                >
                                    —
                                </strong>

                            </div>

                        </div>


                        {{-- ==================================================
                            Customer
                        =================================================== --}}

                        <div class="sales-order-complete-summary-item">

                            <div class="sales-order-complete-summary-icon">

                                <i class="bi bi-person"></i>

                            </div>


                            <div class="sales-order-complete-summary-content">

                                <span class="sales-order-complete-summary-label">
                                    Customer
                                </span>


                                <strong
                                    id="completeOrderCustomer"
                                    class="sales-order-complete-summary-value"
                                >
                                    Walk-in Customer
                                </strong>

                            </div>

                        </div>


                        {{-- ==================================================
                            Items
                        =================================================== --}}

                        <div class="sales-order-complete-summary-item">

                            <div class="sales-order-complete-summary-icon">

                                <i class="bi bi-box-seam"></i>

                            </div>


                            <div class="sales-order-complete-summary-content">

                                <span class="sales-order-complete-summary-label">
                                    Items
                                </span>


                                <strong
                                    id="completeOrderItemCount"
                                    class="sales-order-complete-summary-value"
                                >
                                    0
                                </strong>

                            </div>

                        </div>


                        {{-- ==================================================
                            Amount Due
                        =================================================== --}}

                        <div class="sales-order-complete-summary-total">

                            <span class="sales-order-complete-summary-total-label">

                                Amount Due

                            </span>


                            <strong
                                id="completeOrderGrandTotal"
                                class="sales-order-complete-summary-total-value"
                            >

                                0.00

                            </strong>

                        </div>

                    </div>

                    {{-- ==================================================
                        Order Breakdown
                    =================================================== --}}

                    <div class="sales-order-complete-breakdown mt-3">

                        <div class="sales-order-complete-section-heading">

                            <div>

                                <div class="sales-order-complete-section-title">
                                    Order Breakdown
                                </div>

                                <div class="sales-order-complete-section-description">
                                    Items and charges included in this order
                                </div>

                            </div>

                        </div>


                        <div
                            id="completeOrderItems"
                            class="sales-order-complete-items"
                        ></div>


                        <div class="sales-order-complete-totals">

                            <div class="sales-order-complete-total-row">

                                <span>
                                    Subtotal
                                </span>

                                <strong id="completeOrderSubtotal">
                                    0.00
                                </strong>

                            </div>


                            <div class="sales-order-complete-total-row">

                                <span>
                                    Discount
                                </span>

                                <strong id="completeOrderDiscount">
                                    0.00
                                </strong>

                            </div>


                            <div class="sales-order-complete-total-row">

                                <span>
                                    Tax
                                </span>

                                <strong id="completeOrderTax">
                                    0.00
                                </strong>

                            </div>


                            <div
                                class="sales-order-complete-total-row sales-order-complete-grand-total"
                            >

                                <span>
                                    Grand Total
                                </span>

                                <strong id="completeOrderBreakdownTotal">
                                    0.00
                                </strong>

                            </div>

                        </div>

                    </div>


                    {{-- ==================================================
                        Payment
                    =================================================== --}}

                    <div class="sales-order-complete-payment mt-3">

                        {{-- ==================================================
                            Payment Header
                        =================================================== --}}

                        <div class="sales-order-complete-payment-header">

                            <div class="sales-order-complete-payment-heading">

                                <div class="sales-order-complete-payment-icon">

                                    <i class="bi bi-credit-card-2-front"></i>

                                </div>


                                <div>

                                    <div class="sales-order-complete-section-title">

                                        Payment

                                    </div>


                                    <div class="sales-order-complete-section-description">

                                        Select how the customer is paying for this order.

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- ==================================================
                            Payment Fields
                        =================================================== --}}

                        <div class="row g-3 mt-1">

                            {{-- ==================================================
                                Amount Due
                            =================================================== --}}

                            <div class="col-md-4">

                                <div class="sales-order-payment-field">

                                    <label
                                        class="sales-order-payment-label"
                                        for="completeOrderAmountDue"
                                    >
                                        Amount Due
                                    </label>


                                    <div class="sales-order-payment-input-wrap">

                                        <span class="sales-order-payment-input-prefix">

                                            ₦

                                        </span>


                                        <input
                                            type="text"
                                            class="form-control sales-order-payment-input sales-order-payment-input-readonly"
                                            id="completeOrderAmountDue"
                                            readonly
                                        >

                                    </div>

                                </div>

                            </div>


                            {{-- ==================================================
                                Amount Paid
                            =================================================== --}}

                            <div class="col-md-4">

                                <div class="sales-order-payment-field">

                                    <label
                                        class="sales-order-payment-label"
                                        for="completeOrderAmountPaid"
                                    >

                                        Amount Paid

                                        <span class="text-danger">*</span>

                                    </label>


                                    <div class="sales-order-payment-input-wrap">

                                        <span class="sales-order-payment-input-prefix">

                                            ₦

                                        </span>


                                        <input
                                            type="number"
                                            class="form-control sales-order-payment-input"
                                            id="completeOrderAmountPaid"
                                            name="amount_paid"
                                            min="0"
                                            step="0.01"
                                            value="0"
                                            required
                                        >

                                    </div>

                                </div>

                            </div>


                            {{-- ==================================================
                                Payment Method
                            =================================================== --}}

                            <div class="col-md-4">

                                <div class="sales-order-payment-field">

                                    <label
                                        class="sales-order-payment-label"
                                        for="completeOrderPaymentMethod"
                                    >

                                        Payment Method

                                        <span class="text-danger">*</span>

                                    </label>


                                    <div class="sales-order-payment-input-wrap">

                                        <span class="sales-order-payment-input-icon">

                                            <i class="bi bi-wallet2"></i>

                                        </span>


                                        <select
                                            class="form-select sales-order-payment-select"
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

                                <span class="sales-order-payment-preview-label">

                                    Amount Due

                                </span>


                                <strong
                                    id="completeOrderPreviewDue"
                                    class="sales-order-payment-preview-value"
                                >

                                    0.00

                                </strong>

                            </div>


                            <div class="sales-order-payment-preview-item">

                                <span class="sales-order-payment-preview-label">

                                    Amount Paid

                                </span>


                                <strong
                                    id="completeOrderPreviewPaid"
                                    class="sales-order-payment-preview-value"
                                >

                                    0.00

                                </strong>

                            </div>


                            <div class="sales-order-payment-preview-item">

                                <span class="sales-order-payment-preview-label">

                                    Balance

                                </span>


                                <strong
                                    id="completeOrderPreviewBalance"
                                    class="sales-order-payment-preview-value"
                                >

                                    0.00

                                </strong>

                            </div>


                            <div
                                class="sales-order-payment-preview-item sales-order-payment-preview-change"
                            >

                                <span class="sales-order-payment-preview-label">

                                    Change

                                </span>


                                <strong
                                    id="completeOrderPreviewChange"
                                    class="sales-order-payment-preview-value"
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