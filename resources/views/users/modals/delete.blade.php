<div class="modal fade"
     id="deleteUserModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header border-0">

                <h5 class="modal-title text-danger">

                    <i class="bi bi-trash3-fill me-2"></i>

                    Delete User

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <div class="text-center">

                    <div class="mb-3">

                        <i class="bi bi-exclamation-triangle-fill text-warning"
                           style="font-size:3rem;"></i>

                    </div>

                    <h5>

                        Are you sure?

                    </h5>

                    <p class="text-muted mb-2">

                        You are about to delete

                    </p>

                    <h6
                        id="deleteUserName"
                        class="fw-bold">

                    </h6>

                    <p class="text-danger mt-3 mb-0">

                        This action cannot be undone.

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
                    id="confirmDeleteUser">

                    <i class="bi bi-trash3 me-1"></i>

                    Delete User

                </button>

            </div>

        </div>

    </div>

</div>