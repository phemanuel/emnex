<div
    class="modal fade cash-drawer-modal"
    id="openDrawerModal"
    tabindex="-1"
    aria-labelledby="openDrawerModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div class="cash-modal-heading">

                    <div class="cash-modal-icon primary">
                        <i class="bi bi-box-arrow-in-right"></i>
                    </div>

                    <div>

                        <h5
                            class="modal-title"
                            id="openDrawerModalLabel"
                        >
                            Open Cash Drawer
                        </h5>

                        <p class="text-muted small mb-0">
                            Start a new cash drawer session.
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


            <form id="open-drawer-form">

                <div class="modal-body">

                    <div class="cash-modal-field">

                        <label
                            for="opening_balance"
                            class="form-label"
                        >
                            Opening Balance
                            <span class="text-danger">*</span>
                        </label>

                        <div class="cash-amount-input">

                            <span>₦</span>

                            <input
                                type="number"
                                class="form-control"
                                id="opening_balance"
                                name="opening_balance"
                                min="0"
                                step="0.01"
                                value="0.00"
                                required
                            >

                        </div>

                        <div
                            class="invalid-feedback"
                            data-error="opening_balance"
                        ></div>

                    </div>


                    <div class="cash-modal-field mb-0">

                        <label
                            for="opening_remarks"
                            class="form-label"
                        >
                            Opening Remarks
                        </label>

                        <textarea
                            class="form-control"
                            id="opening_remarks"
                            name="opening_remarks"
                            rows="3"
                            placeholder="Optional opening remarks..."
                        ></textarea>

                        <div
                            class="invalid-feedback"
                            data-error="opening_remarks"
                        ></div>

                    </div>

                </div>


                <div class="modal-footer">
                    <input
                        type="hidden"
                        id="open-drawer-branch-id"
                        name="branch_id"
                        value="{{ $currentBranch?->id }}"
                    >

                    <input
                        type="hidden"
                        id="open-drawer-terminal-id"
                        name="terminal_id"
                        value="{{ $currentTerminal?->id }}"
                    >

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
                        id="open-drawer-submit"
                    >
                        <i class="bi bi-box-arrow-in-right"></i>
                        Open Drawer
                    </button>                    

                </div>

            </form>

        </div>

    </div>

</div>