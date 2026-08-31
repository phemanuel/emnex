<div
    class="modal fade pos-modal"
    id="posPaymentModal"
    tabindex="-1"
    aria-labelledby="posPaymentModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <div class="pos-modal-heading">

                    <div class="pos-modal-icon success">

                        <i class="bi bi-credit-card"></i>

                    </div>

                    <div>

                        <h5
                            class="modal-title"
                            id="posPaymentModalLabel"
                        >
                            Complete Payment
                        </h5>

                        <p class="text-muted small mb-0">
                            Select a payment method and complete the sale.
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


            <div class="modal-body">

                <div class="pos-payment-layout">


                    {{-- Total --}}

                    <div class="pos-payment-total">

                        <span>
                            Amount Due
                        </span>

                        <strong id="pos-payment-total">
                            ₦0.00
                        </strong>

                    </div>


                    {{-- Payment Methods --}}

                    <div class="pos-payment-methods">

                        <span class="pos-form-label">
                            Payment Method
                        </span>

                        <div class="pos-payment-method-grid">

                            <button
                                type="button"
                                class="pos-payment-method active"
                                data-payment-method="Cash"
                            >

                                <i class="bi bi-cash-stack"></i>

                                <span>
                                    Cash
                                </span>

                            </button>


                            <button
                                type="button"
                                class="pos-payment-method"
                                data-payment-method="Card"
                            >

                                <i class="bi bi-credit-card"></i>

                                <span>
                                    Card
                                </span>

                            </button>


                            <button
                                type="button"
                                class="pos-payment-method"
                                data-payment-method="Transfer"
                            >

                                <i class="bi bi-bank"></i>

                                <span>
                                    Transfer
                                </span>

                            </button>


                            <button
                                type="button"
                                class="pos-payment-method"
                                data-payment-method="Wallet"
                            >

                                <i class="bi bi-wallet2"></i>

                                <span>
                                    Wallet
                                </span>

                            </button>

                        </div>

                    </div>


                    {{-- Cash Fields --}}

                    <div
                        class="pos-payment-method-panel"
                        id="pos-cash-payment-panel"
                    >

                        <div class="row g-3">

                            <div class="col-md-6">

                                <label
                                    for="pos-payment-amount"
                                    class="form-label"
                                >
                                    Amount Received
                                </label>

                                <div class="pos-money-input">

                                    <span>
                                        ₦
                                    </span>

                                    <input
                                        type="number"
                                        class="form-control"
                                        id="pos-payment-amount"
                                        min="0"
                                        step="0.01"
                                        placeholder="0.00"
                                    >

                                </div>

                            </div>


                            <div class="col-md-6">

                                <label
                                    class="form-label"
                                >
                                    Change
                                </label>

                                <div
                                    class="pos-payment-change"
                                    id="pos-payment-change"
                                >
                                    ₦0.00
                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Non-cash Fields --}}

                    <div
                        class="pos-payment-method-panel d-none"
                        id="pos-other-payment-panel"
                    >

                        <label
                            for="pos-payment-reference"
                            class="form-label"
                        >
                            Reference No.
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="pos-payment-reference"
                            placeholder="Enter payment reference..."
                        >

                        <div
                            class="invalid-feedback"
                            data-error="reference_no"
                        ></div>

                    </div>


                    {{-- Payment Remarks --}}

                    <div class="pos-payment-remarks">

                        <label
                            for="pos-payment-remarks"
                            class="form-label"
                        >
                            Remarks
                        </label>

                        <textarea
                            class="form-control"
                            id="pos-payment-remarks"
                            rows="2"
                            placeholder="Optional payment remarks..."
                        ></textarea>

                    </div>

                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    class="btn btn-success"
                    id="pos-complete-payment"
                >

                    <i class="bi bi-check-circle me-1"></i>

                    Complete Sale

                </button>

            </div>

        </div>

    </div>

</div>