{{-- ==============================================================
        Supplier Confirmation Modal
    ============================================================== --}}

    <div
        class="modal fade"
        id="supplierConfirmModal"
        tabindex="-1"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content border-0 shadow-lg">

                <div class="modal-body p-4">

                    <div class="text-center">

                        <div
                            id="supplierConfirmIcon"
                            class="supplier-confirm-icon mb-3"
                        >
                            <i class="bi bi-question-circle"></i>
                        </div>

                        <h5
                            id="supplierConfirmTitle"
                            class="fw-semibold mb-2"
                        >
                            Confirm Action
                        </h5>

                        <p
                            id="supplierConfirmMessage"
                            class="mb-1"
                        >
                            Are you sure?
                        </p>

                        <p
                            id="supplierConfirmDescription"
                            class="text-muted small mb-4"
                        >
                            This action cannot be undone.
                        </p>

                        <div class="d-flex justify-content-center gap-2">

                            <button
                                type="button"
                                class="btn btn-light border"
                                data-bs-dismiss="modal"
                            >
                                Cancel
                            </button>

                            <button
                                type="button"
                                class="btn btn-danger"
                                id="supplierConfirmBtn"
                            >
                                Confirm
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
