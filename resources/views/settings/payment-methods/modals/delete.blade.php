<!-- ===========================================
    Delete Payment Method Modal
=========================================== -->

<div class="modal fade"
     id="deletePaymentMethodModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-danger text-white">

                <h5 class="modal-title">

                    <i class="bi bi-trash me-2"></i>

                    Delete Payment Method

                </h5>

                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>

            </div>



            <div class="modal-body">

                <div class="text-center py-2">

                    <i class="bi bi-exclamation-triangle-fill
                              text-danger
                              display-3">
                    </i>

                    <h5 class="mt-3">

                        Delete Payment Method?

                    </h5>

                    <p class="text-muted mb-0">

                        This action will soft delete this payment method.

                    </p>

                </div>

            </div>



            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal">

                    Cancel

                </button>

                <button
                    type="button"
                    class="btn btn-danger"
                    id="confirmDeletePaymentMethod">

                    <i class="bi bi-trash me-2"></i>

                    Delete

                </button>

            </div>

        </div>

    </div>

</div>