{{-- ==========================================================
    STOCK COUNT INSPECTOR
=========================================================== --}}

<div
    class="offcanvas offcanvas-end stock-count-inspector"
    tabindex="-1"
    id="stockCountInspector"
    aria-labelledby="stockCountInspectorLabel"
>

    <div class="offcanvas-header border-bottom">

        <div class="d-flex align-items-center gap-2">

            <span class="stock-count-inspector-icon">

                <i class="bi bi-clipboard2-check"></i>

            </span>

            <div>

                <h5
                    class="offcanvas-title fw-semibold mb-0"
                    id="stockCountInspectorLabel"
                >
                    Stock Count
                </h5>

                <div
                    class="small text-muted"
                    id="stockCountInspectorReference"
                >
                    —
                </div>

            </div>

        </div>


        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>

    </div>


    {{-- ==========================================================
        INSPECTOR ACTIONS
    =========================================================== --}}

    <div
        class="border-bottom px-3 py-3"
        id="stockCountInspectorActions"
    >

        {{-- Start Count --}}

        <button
            type="button"
            class="btn btn-primary w-100 d-none"
            id="stockCountStartButton"
        >

            <i class="bi bi-play-circle me-2"></i>

            Start Count

        </button>


        {{-- Continue Counting --}}

        <button
            type="button"
            class="btn btn-success w-100 d-none mt-2"
            id="stockCountContinueButton"
        >

            <i class="bi bi-clipboard2-check me-2"></i>

            Continue Counting

        </button>

    </div>

    <div class="d-flex align-items-center gap-2">
    </div>

    <div class="offcanvas-body">

        {{-- Loading --}}

        <div
            id="stockCountInspectorLoading"
            class="stock-count-inspector-state"
        >

            <div
                class="spinner-border text-primary mb-3"
                role="status"
            >

                <span class="visually-hidden">
                    Loading...
                </span>

            </div>

            <div class="fw-semibold">
                Loading Stock Count...
            </div>

            <div class="small text-muted mt-1">
                Please wait.
            </div>

        </div>


        {{-- Error --}}

        <div
            id="stockCountInspectorError"
            class="stock-count-inspector-state d-none"
        >

            <div class="stock-count-state-icon text-danger">

                <i class="bi bi-exclamation-triangle"></i>

            </div>

            <div
                class="fw-semibold"
                id="stockCountInspectorErrorTitle"
            >
                Unable to load Stock Count
            </div>

            <div
                class="small text-muted mt-1"
                id="stockCountInspectorErrorMessage"
            >
                Something went wrong.
            </div>

        </div>


        {{-- Content --}}

        <div
            id="stockCountInspectorContent"
            class="d-none"
        >

            {{-- Summary --}}

            <div class="stock-count-inspector-summary mb-4">

                <div>

                    <span>
                        Status
                    </span>

                    <strong
                        id="stockCountInspectorStatus"
                    >
                        —
                    </strong>

                </div>

                <div>

                    <span>
                        Count Date
                    </span>

                    <strong
                        id="stockCountInspectorDate"
                    >
                        —
                    </strong>

                </div>

            </div>


            {{-- Details --}}

            <div class="stock-count-detail-section">

                <div class="stock-count-detail-section-title">

                    <i class="bi bi-info-circle"></i>

                    Count Information

                </div>


                <div class="stock-count-detail-grid">

                    <div>

                        <span>
                            Reference
                        </span>

                        <strong
                            id="stockCountInspectorReferenceValue"
                        >
                            —
                        </strong>

                    </div>


                    <div>

                        <span>
                            Branch
                        </span>

                        <strong
                            id="stockCountInspectorBranch"
                        >
                            —
                        </strong>

                    </div>


                    <div>

                        <span>
                            Created By
                        </span>

                        <strong
                            id="stockCountInspectorCreatedBy"
                        >
                            —
                        </strong>

                    </div>


                    <div>

                        <span>
                            Created
                        </span>

                        <strong
                            id="stockCountInspectorCreatedAt"
                        >
                            —
                        </strong>

                    </div>


                    <div>

                        <span>
                            Completed By
                        </span>

                        <strong
                            id="stockCountInspectorCompletedBy"
                        >
                            —
                        </strong>

                    </div>


                    <div>

                        <span>
                            Completed
                        </span>

                        <strong
                            id="stockCountInspectorCompletedAt"
                        >
                            —
                        </strong>

                    </div>

                </div>

            </div>


            {{-- Summary statistics --}}

            <div class="stock-count-detail-section">

                <div class="stock-count-detail-section-title">

                    <i class="bi bi-bar-chart"></i>

                    Count Summary

                </div>


                <div class="row g-2">

                    <div class="col-6">

                        <div class="stock-count-mini-stat">

                            <span>
                                Items
                            </span>

                            <strong
                                id="stockCountInspectorItemCount"
                            >
                                0
                            </strong>

                        </div>

                    </div>


                    <div class="col-6">

                        <div class="stock-count-mini-stat">

                            <span>
                                Variances
                            </span>

                            <strong
                                id="stockCountInspectorVarianceCount"
                            >
                                0
                            </strong>

                        </div>

                    </div>


                    <div class="col-6">

                        <div class="stock-count-mini-stat">

                            <span>
                                Positive
                            </span>

                            <strong
                                id="stockCountInspectorPositiveVariance"
                            >
                                0
                            </strong>

                        </div>

                    </div>


                    <div class="col-6">

                        <div class="stock-count-mini-stat">

                            <span>
                                Negative
                            </span>

                            <strong
                                id="stockCountInspectorNegativeVariance"
                            >
                                0
                            </strong>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Notes --}}

            <div class="stock-count-detail-section">

                <div class="stock-count-detail-section-title">

                    <i class="bi bi-chat-left-text"></i>

                    Notes

                </div>

                <div
                    class="stock-count-notes"
                    id="stockCountInspectorNotes"
                >
                    —
                </div>

            </div>


            {{-- Items --}}

            <div class="stock-count-detail-section">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div class="stock-count-detail-section-title mb-0">

                        <i class="bi bi-box-seam"></i>

                        Count Items

                    </div>

                    <span
                        class="badge bg-light text-dark"
                        id="stockCountInspectorItemsBadge"
                    >
                        0
                    </span>

                </div>


                <div
                    id="stockCountInspectorItems"
                    class="stock-count-inspector-items"
                ></div>

            </div>

        </div>

    </div>

</div>
