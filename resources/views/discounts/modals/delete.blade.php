<div
    class="modal fade"
    id="deleteModal"
    tabindex="-1"
    aria-labelledby="deleteModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <!-- Header -->

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="deleteModalLabel">

                    Delete Discount

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"></button>

            </div>

            <!-- Body -->

            <div class="modal-body text-center">

                <div class="confirmation-icon danger mb-3">

                    <i class="bi bi-trash"></i>

                </div>

                <h5 class="mb-3">

                    Delete this Discount?

                </h5>

                <p
                    class="text-muted mb-0"
                    id="deleteModalMessage">

                    This action will remove the discount from active use.
                    The record will be soft deleted and can be restored automatically if a discount with the same name is created again.

                </p>

            </div>

            <!-- Footer -->

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
                    id="confirmDeleteBtn">

                    <i class="bi bi-trash me-2"></i>

                    Delete Discount

                </button>

            </div>

        </div>

    </div>

</div>