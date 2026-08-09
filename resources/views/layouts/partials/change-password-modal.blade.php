{{-- =========================================================
     CHANGE PASSWORD MODAL
========================================================= --}}

<div
    class="modal fade"
    id="changePasswordModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered modal-sm">

        <div class="modal-content account-modal">


            {{-- Header --}}
            <div class="modal-header">

                <div>

                    <h5 class="modal-title">

                        Change Password

                    </h5>

                    <small class="text-muted">

                        Keep your account secure

                    </small>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>



            {{-- Form --}}
            <form id="changePasswordForm">

                @csrf


                <div class="modal-body">


                    {{-- Current Password --}}
                    <div class="mb-3">

                        <label
                            for="currentPassword"
                            class="form-label"
                        >

                            Current Password

                        </label>


                        <div class="input-group">

                            <input
                                type="password"
                                class="form-control"
                                id="currentPassword"
                                name="current_password"
                                required
                            >

                            <button
                                type="button"
                                class="btn btn-outline-secondary password-toggle"
                                data-target="currentPassword"
                            >

                                <i class="bi bi-eye"></i>

                            </button>

                        </div>

                    </div>



                    {{-- New Password --}}
                    <div class="mb-3">

                        <label
                            for="newPassword"
                            class="form-label"
                        >

                            New Password

                        </label>


                        <div class="input-group">

                            <input
                                type="password"
                                class="form-control"
                                id="newPassword"
                                name="password"
                                required
                            >

                            <button
                                type="button"
                                class="btn btn-outline-secondary password-toggle"
                                data-target="newPassword"
                            >

                                <i class="bi bi-eye"></i>

                            </button>

                        </div>

                    </div>



                    {{-- Confirm Password --}}
                    <div class="mb-0">

                        <label
                            for="confirmPassword"
                            class="form-label"
                        >

                            Confirm New Password

                        </label>


                        <div class="input-group">

                            <input
                                type="password"
                                class="form-control"
                                id="confirmPassword"
                                name="password_confirmation"
                                required
                            >

                            <button
                                type="button"
                                class="btn btn-outline-secondary password-toggle"
                                data-target="confirmPassword"
                            >

                                <i class="bi bi-eye"></i>

                            </button>

                        </div>

                    </div>


                </div>



                {{-- Footer --}}
                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >

                        Cancel

                    </button>


                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="changePasswordBtn"
                    >

                        <i class="bi bi-shield-check me-1"></i>

                        Update Password

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>