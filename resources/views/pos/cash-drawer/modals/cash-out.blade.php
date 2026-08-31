<div
    class="modal fade cash-drawer-modal"
    id="cashOutModal"
    tabindex="-1"
    aria-labelledby="cashOutModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div class="cash-modal-heading">

                    <div class="cash-modal-icon danger">
                        <i class="bi bi-arrow-up-circle"></i>
                    </div>

                    <div>

                        <h5
                            class="modal-title"
                            id="cashOutModalLabel"
                        >
                            Cash Out
                        </h5>

                        <p class="text-muted small mb-0">
                            Remove cash from the drawer.
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


            <form id="cash-out-form">

                <div class="modal-body">

                    <div class="cash-modal-field">

                        <label
                            for="cash_out_amount"
                            class="form-label"
                        >
                            Amount
                            <span class="text-danger">*</span>
                        </label>

                        <div class="cash-amount-input">

                            <span>₦</span>

                            <input
                                type="number"
                                class="form-control"
                                id="cash_out_amount"
                                name="amount"
                                min="0.01"
                                step="0.01"
                                required
                            >

                        </div>

                        <div
                            class="invalid-feedback"
                            data-error="amount"
                        ></div>

                    </div>


                    <div class="cash-modal-field">

                        <label
                            for="cash_out_reference_no"
                            class="form-label"
                        >
                            Reference No.
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="cash_out_reference_no"
                            name="reference_no"
                            placeholder="Optional reference..."
                        >

                        <div
                            class="invalid-feedback"
                            data-error="reference_no"
                        ></div>

                    </div>


                    <div class="cash-modal-field mb-0">

                        <label
                            for="cash_out_remarks"
                            class="form-label"
                        >
                            Remarks
                        </label>

                        <textarea
                            class="form-control"
                            id="cash_out_remarks"
                            name="remarks"
                            rows="3"
                            placeholder="Reason for cash out..."
                        ></textarea>

                        <div
                            class="invalid-feedback"
                            data-error="remarks"
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
                        id="cash-out-submit"
                    >
                        <i class="bi bi-arrow-up-circle"></i>
                        Record Cash Out
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

