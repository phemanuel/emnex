<!-- =====================================================
    ENABLE / DISABLE TAX RATE MODAL
====================================================== -->

<div
    class="modal fade"
    id="statusModal"
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

                    <div
                        class="modal-action-icon"
                        id="statusModalIcon"
                    >

                        <i
                            class="bi bi-power"
                            id="statusModalIconClass"
                        ></i>

                    </div>

                    <div class="ms-3">

                        <h5
                            class="modal-title mb-1"
                            id="statusModalTitle"
                        >

                            Change Status

                        </h5>

                        <small class="text-muted">

                            Confirm this action.

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
                    id="statusTaxRateId"
                >

                <p class="mb-2">

                    You are about to

                    <strong id="statusActionText">

                        Disable

                    </strong>

                    the tax rate:

                </p>

                <div class="confirmation-card">

                    <h5
                        class="mb-0"
                        id="statusTaxRateName"
                    >

                        VAT

                    </h5>

                </div>

                <div
                    class="alert alert-warning mt-4 mb-0"
                    id="statusAlert"
                >

                    This action can be reversed at any time.

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
                    class="btn btn-warning"
                    id="confirmStatusBtn"
                >

                    <i class="bi bi-check-circle me-1"></i>

                    Confirm

                </button>

            </div>

        </div>

    </div>

</div>