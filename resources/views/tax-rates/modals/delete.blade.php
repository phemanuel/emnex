<!-- =====================================================
    DELETE TAX RATE MODAL
====================================================== -->

<div
    class="modal fade"
    id="deleteModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content emnex-modal">

            <!-- ==========================================
                Header
            =========================================== -->

            <div class="modal-header border-0">

                <div class="d-flex align-items-center">

                    <div class="modal-action-icon danger">

                        <i class="bi bi-trash3"></i>

                    </div>

                    <div class="ms-3">

                        <h5 class="modal-title mb-1">

                            Delete Tax Rate

                        </h5>

                        <small class="text-muted">

                            This action requires confirmation.

                        </small>

                    </div>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>

            <!-- ==========================================
                Body
            =========================================== -->

            <div class="modal-body">

                <input
                    type="hidden"
                    id="deleteTaxRateId"
                >

                <p class="mb-2">

                    You are about to permanently delete the following tax rate:

                </p>

                <div class="confirmation-card">

                    <h5
                        class="mb-0"
                        id="deleteTaxRateName"
                    >

                        VAT

                    </h5>

                </div>

                <div class="alert alert-danger mt-4 mb-0">

                    <div class="d-flex">

                        <i class="bi bi-exclamation-triangle-fill me-2"></i>

                        <div>

                            <strong>Warning</strong>

                            <div class="small mt-1">

                                This action cannot be undone. If this tax rate
                                is currently assigned to products, the deletion
                                may not be allowed.

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ==========================================
                Footer
            =========================================== -->

            <div class="modal-footer border-0">

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
                    id="confirmDeleteBtn"
                >

                    <i class="bi bi-trash3 me-1"></i>

                    Delete Tax Rate

                </button>

            </div>

        </div>

    </div>

</div>