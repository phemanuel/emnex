<div
    class="modal fade"
    id="editBranchModal"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <form id="editBranchForm">

                @csrf

                <div class="modal-header">

                    <h5 class="modal-title">

                        <i class="bi bi-pencil-square me-2"></i>

                        Edit Branch

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <input
                        type="hidden"
                        id="edit_branch_id">

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label class="form-label">

                                Branch Name

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="edit_name">

                            <div
                                class="invalid-feedback"
                                data-error="edit_name">
                            </div>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">

                                Branch Code

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="edit_branch_code">

                            <div
                                class="invalid-feedback"
                                data-error="edit_branch_code">
                            </div>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">

                                Email

                            </label>

                            <input
                                type="email"
                                class="form-control"
                                name="edit_email">

                            <div
                                class="invalid-feedback"
                                data-error="edit_email">
                            </div>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">

                                Phone

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="edit_phone">

                            <div
                                class="invalid-feedback"
                                data-error="edit_phone">
                            </div>

                        </div>

                        <div class="col-12">

                            <label class="form-label">

                                Address

                            </label>

                            <textarea
                                class="form-control"
                                rows="3"
                                name="edit_address"></textarea>

                            <div
                                class="invalid-feedback"
                                data-error="edit_address">
                            </div>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">

                                Status

                            </label>

                            <select
                                class="form-select"
                                name="edit_status">

                                <option value="1">

                                    Active

                                </option>

                                <option value="0">

                                    Disabled

                                </option>

                            </select>

                        </div>

                        <div class="col-md-6 d-flex align-items-end">

                            <div class="form-check">

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="edit_is_head_office"
                                    value="1">

                                <label class="form-check-label">

                                    Head Office

                                </label>

                            </div>

                        </div>

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
                        type="submit"
                        class="btn btn-primary">

                        <i class="bi bi-check-lg me-1"></i>

                        Save Changes

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>