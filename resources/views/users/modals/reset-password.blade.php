<div class="modal fade"
     id="resetPasswordModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    <i class="bi bi-key-fill me-2 text-warning"></i>

                    Reset Password

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <div class="text-center mb-4">

                    <i class="bi bi-shield-lock-fill text-warning"
                       style="font-size:3rem;"></i>

                </div>

                <p class="text-center">

                    You are about to reset the password for

                    <strong id="resetUserName"></strong>

                </p>

                <p class="text-muted text-center">

                    A secure temporary password will be generated.
                    The user will be required to change it at their next login.

                </p>

                <div
                    id="generatedPasswordWrapper"
                    class="d-none mt-4">

                    <label class="form-label fw-semibold">

                        Temporary Password

                    </label>

                    <div class="input-group">

                        <input
                            type="text"
                            id="generatedPassword"
                            class="form-control fw-bold"
                            readonly>

                        <button
                            class="btn btn-outline-primary"
                            type="button"
                            id="copyPassword">

                            <i class="bi bi-copy"></i>

                            Copy

                        </button>

                    </div>

                    <small class="text-danger mt-2 d-block">

                        This password will only be shown once.
                        Copy it before closing this window.

                    </small>

                </div>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal">

                    Close

                </button>

                <button
                    type="button"
                    class="btn btn-warning"
                    id="confirmResetPassword">

                    <i class="bi bi-key-fill me-1"></i>

                    Reset Password

                </button>

            </div>

        </div>

    </div>

</div>