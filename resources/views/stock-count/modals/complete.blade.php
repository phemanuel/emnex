{{-- ==========================================================
    COMPLETE STOCK COUNT CONFIRMATION
=========================================================== --}}

<div
    class="modal fade"
    id="stockCountCompleteModal"
    tabindex="-1"
    aria-labelledby="stockCountCompleteModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg">

            <div class="modal-body text-center p-4">

                <div class="stock-count-complete-icon mb-3">

                    <i class="bi bi-check2-circle"></i>

                </div>

                <h5
                    class="fw-semibold"
                    id="stockCountCompleteModalLabel"
                >
                    Complete Stock Count?
                </h5>

                <p class="text-muted mb-4">

                    All physical quantities have been entered.
                    Completing this count will update the branch
                    stock based on the counted quantities.

                    <br>

                    <strong>
                        This action cannot be undone.
                    </strong>

                </p>

                <div class="d-flex justify-content-center gap-2">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="button"
                        class="btn btn-success"
                        id="confirmStockCountComplete"
                    >

                        <span
                            class="spinner-border spinner-border-sm d-none"
                            id="stockCountCompleteSpinner"
                            role="status"
                            aria-hidden="true"
                        ></span>

                        <i
                            class="bi bi-check2-circle"
                            id="stockCountCompleteIcon"
                        ></i>

                        Complete Counting

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>