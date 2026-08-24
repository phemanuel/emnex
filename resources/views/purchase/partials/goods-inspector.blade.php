{{-- ==============================================================
    Goods Received Inspector
============================================================== --}}

<div
    class="offcanvas offcanvas-end emnex-inspector"
    tabindex="-1"
    id="goodsReceivedInspector"
>

    {{-- ==========================================================
        Header
    =========================================================== --}}

    <div class="offcanvas-header emnex-inspector-header">

        <div class="min-w-0">

            <div class="emnex-inspector-eyebrow">
                Goods Received
            </div>

            <div class="d-flex align-items-center gap-2">

                <h5
                    class="offcanvas-title emnex-inspector-title text-truncate"
                    id="goodsReceivedInspectorLabel"
                >
                    —
                </h5>

            </div>

        </div>


        <button
            type="button"
            class="btn-close flex-shrink-0"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>

    </div>


    {{-- ==========================================================
        Body
    =========================================================== --}}

    <div class="offcanvas-body emnex-inspector-body">

        {{-- ======================================================
            Status
        ======================================================= --}}

        <div class="emnex-inspector-status-row">

            <div>

                <div class="emnex-inspector-label">
                    Receipt Status
                </div>

                <div class="small text-muted">
                    Current processing status
                </div>

            </div>


            <span
                id="inspectorGoodsReceivedStatus"
                class="badge bg-secondary-subtle text-secondary emnex-status-badge"
            >
                —
            </span>

        </div>


        {{-- ======================================================
            Receipt Summary
        ======================================================= --}}

        <div class="emnex-inspector-section">

            <div class="emnex-inspector-section-title">
                Receipt Information
            </div>


            <div class="emnex-detail-grid">

                <div class="emnex-detail-card">

                    <span class="emnex-detail-label">
                        Purchase Order
                    </span>

                    <strong
                        id="inspectorGoodsReceivedOrder"
                        class="emnex-detail-value"
                    >
                        —
                    </strong>

                </div>


                <div class="emnex-detail-card">

                    <span class="emnex-detail-label">
                        Supplier
                    </span>

                    <strong
                        id="inspectorGoodsReceivedSupplier"
                        class="emnex-detail-value"
                    >
                        —
                    </strong>

                </div>


                <div class="emnex-detail-card">

                    <span class="emnex-detail-label">
                        Branch
                    </span>

                    <strong
                        id="inspectorGoodsReceivedBranch"
                        class="emnex-detail-value"
                    >
                        —
                    </strong>

                </div>


                <div class="emnex-detail-card">

                    <span class="emnex-detail-label">
                        Received Date
                    </span>

                    <strong
                        id="inspectorGoodsReceivedDate"
                        class="emnex-detail-value"
                    >
                        —
                    </strong>

                </div>

            </div>

        </div>


        {{-- ======================================================
            Received Items
        ======================================================= --}}

        <div class="emnex-inspector-section">

            <div
                class="d-flex align-items-center justify-content-between mb-3"
            >

                <div>

                    <div class="emnex-inspector-section-title mb-1">
                        Received Items
                    </div>

                    <div class="small text-muted">
                        Products included in this receipt
                    </div>

                </div>

            </div>


            <div
                id="inspectorGoodsReceivedItems"
                class="emnex-received-items"
            >

                <div class="emnex-empty-state">

                    <div class="emnex-empty-icon">

                        <i class="bi bi-box-seam"></i>

                    </div>

                    <div class="fw-semibold">
                        No items available
                    </div>

                    <div class="small text-muted">
                        Receipt items will appear here.
                    </div>

                </div>

            </div>

        </div>


        {{-- ======================================================
            Summary
        ======================================================= --}}

        <div class="emnex-inspector-section">

            <div class="emnex-inspector-section-title mb-3">
                Receipt Summary
            </div>


            <div class="emnex-summary-grid">

                <div class="emnex-summary-card">

                    <div class="emnex-summary-icon">

                        <i class="bi bi-box-seam"></i>

                    </div>

                    <div>

                        <span class="emnex-summary-label">
                            Total Items
                        </span>

                        <strong
                            id="inspectorGoodsReceivedItemCount"
                            class="emnex-summary-value"
                        >
                            0
                        </strong>

                    </div>

                </div>


                <div class="emnex-summary-card">

                    <div class="emnex-summary-icon">

                        <i class="bi bi-stack"></i>

                    </div>

                    <div>

                        <span class="emnex-summary-label">
                            Total Quantity
                        </span>

                        <strong
                            id="inspectorGoodsReceivedQuantity"
                            class="emnex-summary-value"
                        >
                            0
                        </strong>

                    </div>

                </div>

            </div>

        </div>


        {{-- ======================================================
            Notes
        ======================================================= --}}

        <div class="emnex-inspector-section">

            <div class="emnex-inspector-section-title mb-3">
                Notes
            </div>


            <div
                id="inspectorGoodsReceivedNotes"
                class="emnex-notes-box"
            >
                —
            </div>

        </div>


        {{-- ======================================================
            Activity
        ======================================================= --}}

        <div class="emnex-inspector-section">

            <div class="emnex-inspector-section-title mb-3">
                Activity
            </div>


            <div class="emnex-activity-card">

                <div class="emnex-activity-item">

                    <div class="emnex-activity-icon">

                        <i class="bi bi-person-check"></i>

                    </div>


                    <div class="flex-grow-1 min-w-0">

                        <span class="emnex-activity-label">
                            Received By
                        </span>

                        <strong
                            id="inspectorGoodsReceivedCreatedBy"
                            class="emnex-activity-value"
                        >
                            —
                        </strong>

                    </div>

                </div>


                <div class="emnex-activity-divider"></div>


                <div class="emnex-activity-item">

                    <div class="emnex-activity-icon">

                        <i class="bi bi-clock-history"></i>

                    </div>


                    <div class="flex-grow-1 min-w-0">

                        <span class="emnex-activity-label">
                            Created
                        </span>

                        <strong
                            id="inspectorGoodsReceivedCreatedAt"
                            class="emnex-activity-value"
                        >
                            —
                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>