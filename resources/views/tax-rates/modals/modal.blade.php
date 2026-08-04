<!-- =====================================================
    CREATE / EDIT TAX RATE MODAL
====================================================== -->

<div
    class="modal fade"
    id="taxRateModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content emnex-modal">

            <!-- ==========================================
                Header
            =========================================== -->

            <div class="modal-header border-0">

                <div>

                    <h4
                        class="modal-title fw-bold mb-1"
                        id="taxRateModalTitle"
                    >

                        New Tax Rate

                    </h4>

                    <p class="text-muted mb-0">

                        Create or update company tax rates.

                    </p>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>

            <!-- ==========================================
                Form
            =========================================== -->

            <form id="taxRateForm">

                <input
                    type="hidden"
                    id="taxRateId"
                >

                <div class="modal-body">

                    <div class="row g-4">

                        <!-- ==========================
                            Tax Name
                        =========================== -->

                        <div class="col-md-8">

                            <label class="form-label">

                                Tax Name

                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="taxRateName"
                                name="name"
                                placeholder="e.g. VAT"
                                maxlength="100"
                                required
                            >

                        </div>

                        <!-- ==========================
                            Rate
                        =========================== -->

                        <div class="col-md-4">

                            <label class="form-label">

                                Tax Rate (%)

                                <span class="text-danger">*</span>

                            </label>

                            <div class="input-group">

                                <input
                                    type="number"
                                    class="form-control"
                                    id="taxRateValue"
                                    name="rate"
                                    min="0"
                                    max="100"
                                    step="0.01"
                                    placeholder="0.00"
                                    required
                                >

                                <span class="input-group-text">

                                    %

                                </span>

                            </div>

                        </div>

                        <!-- ==========================
                            Preview Card
                        =========================== -->

                        <div class="col-12">

                            <div class="tax-preview-card">

                                <div class="tax-preview-icon">

                                    <i class="bi bi-percent"></i>

                                </div>

                                <div>

                                    <small class="text-muted d-block">

                                        Preview

                                    </small>

                                    <h5
                                        class="mb-1"
                                        id="taxPreviewName"
                                    >

                                        Tax Name

                                    </h5>

                                    <span
                                        class="badge bg-primary"
                                        id="taxPreviewRate"
                                    >

                                        0.00%

                                    </span>

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
                        type="submit"
                        class="btn btn-primary"
                        id="saveTaxRateBtn"
                    >

                        <i class="bi bi-check-circle me-1"></i>

                        Save Tax Rate

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>