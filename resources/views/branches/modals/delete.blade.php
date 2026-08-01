<div
    class="modal fade"
    id="deleteBranchModal"
    tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    <i class="bi bi-trash text-danger me-2"></i>

                    Delete Branch

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body text-center">

                <i class="bi bi-exclamation-triangle-fill text-danger display-4"></i>

                <h5 class="mt-3">

                    Delete this branch?

                </h5>

                <p>

                    You are about to delete

                    <strong id="deleteBranchName"></strong>

                </p>

                <p class="text-muted mb-0">

                    This action can be restored later because branches are soft deleted.

                </p>

            </div>

            <div class="modal-footer">

                <button
                    class="btn btn-light"
                    data-bs-dismiss="modal">

                    Cancel

                </button>

                <button
                    class="btn btn-danger"
                    id="confirmDeleteBranch">

                    <i class="bi bi-trash"></i>

                    Delete Branch

                </button>

            </div>

        </div>

    </div>

</div>