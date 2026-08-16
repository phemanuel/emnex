{{-- ==========================================================
    Supplier Delete Confirmation Modal
========================================================== --}}

<div
    class="modal fade"
    id="supplierDeleteModal"
    tabindex="-1"
    aria-labelledby="supplierDeleteModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow-sm">


            {{-- ==========================================================
                Header
            ========================================================== --}}

            <div class="modal-header border-0 pb-0">

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            {{-- ==========================================================
                Body
            ========================================================== --}}

            <div class="modal-body text-center px-4 pb-4">

                <div
                    id="supplierDeleteIcon"
                    class="supplier-confirm-icon mb-3"
                >

                    <i class="bi bi-trash"></i>

                </div>


                <h5
                    id="supplierDeleteTitle"
                    class="mb-2"
                >
                    Delete Supplier
                </h5>


                <p
                    id="supplierDeleteMessage"
                    class="fw-semibold mb-2"
                >
                    Are you sure you want to delete this supplier?
                </p>


                <p
                    id="supplierDeleteDescription"
                    class="text-muted small mb-4"
                >
                    The supplier will be removed from the active supplier list.
                </p>


                <div class="d-flex justify-content-center gap-2">

                    <button
                        type="button"
                        class="btn btn-light px-4"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>


                    <button
                        type="button"
                        id="supplierDeleteConfirmBtn"
                        class="btn btn-danger px-4"
                    >
                        Delete Supplier
                    </button>

                </div>

            </div>

        </div>

    </div>

</div>