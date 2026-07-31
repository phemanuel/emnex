<div
    class="modal fade"
    id="createBranchModal"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <form id="createBranchForm">

                @csrf

                <div class="modal-header">

                    <h5 class="modal-title">

                        <i class="bi bi-building-add me-2"></i>

                        Create Branch

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label class="form-label">
                                Branch Name
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="name">

                            <div
                                class="invalid-feedback"
                                data-error="name">
                            </div>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">
                                Branch Code
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="branch_code">

                            <div
                                class="invalid-feedback"
                                data-error="branch_code">
                            </div>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                class="form-control"
                                name="email">

                            <div
                                class="invalid-feedback"
                                data-error="email">
                            </div>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">
                                Phone
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="phone">

                            <div
                                class="invalid-feedback"
                                data-error="phone">
                            </div>

                        </div>

                        <div class="col-12">

                            <label class="form-label">
                                Address
                            </label>

                            <textarea
                                rows="3"
                                class="form-control"
                                name="address"></textarea>

                            <div
                                class="invalid-feedback"
                                data-error="address">
                            </div>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">

                                Branch Status

                            </label>

                            <select
                                class="form-select"
                                name="status">

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
                                    value="1"
                                    name="is_head_office">

                                <label
                                    class="form-check-label">

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

                        Create Branch

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>