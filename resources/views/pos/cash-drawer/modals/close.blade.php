<div
    class="modal fade cash-drawer-modal"
    id="closeDrawerModal"
    tabindex="-1"
    aria-labelledby="closeDrawerModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div class="cash-modal-heading">

                    <div class="cash-modal-icon danger">
                        <i class="bi bi-box-arrow-right"></i>
                    </div>

                    <div>

                        <h5
                            class="modal-title"
                            id="closeDrawerModalLabel"
                        >
                            Close Cash Drawer
                        </h5>

                        <p class="text-muted small mb-0">
                            Count the physical cash before closing the drawer.
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


            <form id="close-drawer-form">

                <div class="modal-body">

                    <div class="drawer-close-summary">

                        <div class="drawer-close-summary-heading">
                            Reconciliation Summary
                        </div>

                        <div class="drawer-close-row">

                            <span>
                                Expected Balance
                            </span>

                            <strong id="close-expected-balance">
                                ₦0.00
                            </strong>

                        </div>

                        <div class="drawer-close-row">

                            <span>
                                Cash Sales
                            </span>

                            <strong id="close-cash-sales">
                                ₦0.00
                            </strong>

                        </div>

                    </div>


                    <div class="cash-modal-field">

                        <label
                            for="actual_balance"
                            class="form-label"
                        >
                            Actual Cash Count
                            <span class="text-danger">*</span>
                        </label>

                        <div class="cash-amount-input">

                            <span>₦</span>

                            <input
                                type="number"
                                class="form-control"
                                id="actual_balance"
                                name="actual_balance"
                                min="0"
                                step="0.01"
                                required
                            >

                        </div>

                        <div class="form-text">
                            Enter the physical cash currently in the drawer.
                        </div>

                        <div
                            class="invalid-feedback"
                            data-error="actual_balance"
                        ></div>

                    </div>


                    <div
                        class="variance-preview d-none"
                        id="variance-preview"
                    >

                        <div>

                            <span>
                                Variance
                            </span>

                            <strong id="variance-preview-value">
                                ₦0.00
                            </strong>

                        </div>

                    </div>


                    <div class="cash-modal-field mb-0">

                        <label
                            for="closing_remarks"
                            class="form-label"
                        >
                            Closing Remarks
                        </label>

                        <textarea
                            class="form-control"
                            id="closing_remarks"
                            name="closing_remarks"
                            rows="3"
                            placeholder="Optional closing remarks..."
                        ></textarea>

                        <div
                            class="invalid-feedback"
                            data-error="closing_remarks"
                        ></div>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn cash-modal-cancel"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn cash-modal-danger"
                        id="close-drawer-submit"
                    >
                        <i class="bi bi-box-arrow-right"></i>
                        Close Drawer
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

