{{-- ==========================================================
    DELETE CONFIRMATION MODAL
=========================================================== --}}

<div
    class="modal fade"
    id="stockCountDeleteModal"
    tabindex="-1"
    aria-labelledby="stockCountDeleteModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg">

            <div class="modal-body text-center p-4">

                <div class="stock-count-delete-icon mb-3">

                    <i class="bi bi-trash3"></i>

                </div>

                <h5
                    class="fw-semibold"
                    id="stockCountDeleteModalLabel"
                >
                    Delete Stock Count?
                </h5>

                <p class="text-muted mb-4">

                    This draft Stock Count will be permanently
                    deleted. This action cannot be undone.

                </p>

                <div class="d-flex justify-content-center gap-2">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="button"
                        class="btn btn-danger"
                        id="confirmStockCountDelete"
                    >

                        <span
                            class="spinner-border spinner-border-sm d-none"
                            id="stockCountDeleteSpinner"
                            role="status"
                            aria-hidden="true"
                        ></span>

                        <i
                            class="bi bi-trash3"
                            id="stockCountDeleteIcon"
                        ></i>

                        Delete Stock Count

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>