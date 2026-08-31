<div
    class="modal fade pos-modal"
    id="posApprovalModal"
    tabindex="-1"
    aria-labelledby="posApprovalModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div class="pos-modal-heading">

                    <div class="pos-modal-icon warning">

                        <i class="bi bi-shield-lock"></i>

                    </div>

                    <div>

                        <h5
                            class="modal-title"
                            id="posApprovalModalLabel"
                        >
                            Approval Required
                        </h5>

                        <p class="text-muted small mb-0">

                            An authorized user must approve this adjustment.

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

                <div class="pos-approval-action">

                    <span class="pos-approval-action-label">
                        Requested Action
                    </span>

                    <strong id="pos-approval-action">
                        Discount
                    </strong>

                </div>


                <div class="pos-approval-field">

                    <label
                        for="pos-approval-user"
                        class="form-label"
                    >
                        Approver
                    </label>

                    <select
                        class="form-select"
                        id="pos-approval-user"
                    >

                        <option value="">
                            Select approver
                        </option>

                    </select>

                    <div
                        class="invalid-feedback"
                        data-error="approver_id"
                    ></div>

                </div>


                <div class="pos-approval-field">

                    <label
                        for="pos-approval-password"
                        class="form-label"
                    >
                        Password
                    </label>

                    <div class="pos-password-input">

                        <input
                            type="password"
                            class="form-control"
                            id="pos-approval-password"
                            placeholder="Enter approval password"
                            autocomplete="off"
                        >

                        <button
                            type="button"
                            class="pos-password-toggle"
                            id="pos-approval-password-toggle"
                            aria-label="Show password"
                        >

                            <i class="bi bi-eye"></i>

                        </button>

                    </div>

                    <div
                        class="invalid-feedback"
                        data-error="password"
                    ></div>

                </div>


                <div class="pos-approval-notice">

                    <i class="bi bi-info-circle"></i>

                    <span>

                        The approval will be recorded against this sale.

                    </span>

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
                    class="btn btn-primary"
                    id="pos-approval-submit"
                >

                    <i class="bi bi-shield-check me-1"></i>

                    Approve & Continue

                </button>

            </div>

        </div>

    </div>

</div>