{{-- ==========================================================
    Supplier Status Confirmation Modal
========================================================== --}}

<div
    class="modal fade"
    id="supplierStatusModal"
    tabindex="-1"
    aria-labelledby="supplierStatusModalLabel"
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
                    id="supplierStatusIcon"
                    class="supplier-confirm-icon mb-3"
                >

                    <i class="bi bi-question-circle"></i>

                </div>


                <h5
                    id="supplierStatusTitle"
                    class="mb-2"
                >
                    Confirm Status Change
                </h5>


                <p
                    id="supplierStatusMessage"
                    class="fw-semibold mb-2"
                >
                    Are you sure you want to change this supplier's status?
                </p>


                <p
                    id="supplierStatusDescription"
                    class="text-muted small mb-4"
                >
                    The supplier's availability will be updated.
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
                        id="supplierStatusConfirmBtn"
                        class="btn btn-primary px-4"
                    >
                        Confirm
                    </button>

                </div>

            </div>

        </div>

    </div>

</div>