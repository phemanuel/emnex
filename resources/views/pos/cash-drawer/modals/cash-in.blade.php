<div
    class="modal fade cash-drawer-modal"
    id="cashInModal"
    tabindex="-1"
    aria-labelledby="cashInModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div class="cash-modal-heading">

                    <div class="cash-modal-icon success">
                        <i class="bi bi-arrow-down-circle"></i>
                    </div>

                    <div>

                        <h5
                            class="modal-title"
                            id="cashInModalLabel"
                        >
                            Cash In
                        </h5>

                        <p class="text-muted small mb-0">
                            Add cash to the drawer.
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


            <form id="cash-in-form">

                <div class="modal-body">

                    <div class="cash-modal-field">

                        <label
                            for="cash_in_amount"
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
                                id="cash_in_amount"
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
                            for="cash_in_reference_no"
                            class="form-label"
                        >
                            Reference No.
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="cash_in_reference_no"
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
                            for="cash_in_remarks"
                            class="form-label"
                        >
                            Remarks
                        </label>

                        <textarea
                            class="form-control"
                            id="cash_in_remarks"
                            name="remarks"
                            rows="3"
                            placeholder="Reason for cash in..."
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
                        class="btn cash-modal-primary"
                        id="cash-in-submit"
                    >
                        <i class="bi bi-arrow-down-circle"></i>
                        Record Cash In
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

