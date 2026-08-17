{{-- ==============================================================
    Purchase Order Inspector
============================================================== --}}

<div
    class="offcanvas offcanvas-end purchase-order-inspector"
    tabindex="-1"
    id="purchaseOrderInspector"
    aria-labelledby="purchaseOrderInspectorLabel"
>

    {{-- ==========================================================
        Header
    =========================================================== --}}

    <div class="offcanvas-header purchase-inspector-header">

        <div class="purchase-inspector-header-content">

            <div class="purchase-inspector-eyebrow">

                <i class="bi bi-receipt me-1"></i>

                Purchase Order

            </div>

            <h5
                class="offcanvas-title purchase-inspector-title"
                id="purchaseOrderInspectorLabel"
            >
                —
            </h5>

            <div
                class="purchase-inspector-subtitle"
                id="purchaseOrderInspectorSubtitle"
            >
                Purchase order details
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
        Body
    =========================================================== --}}

    <div class="offcanvas-body purchase-inspector-body">


        {{-- ======================================================
            Status / Quick Summary
        ======================================================= --}}

        <div class="purchase-inspector-top-card">

            <div>

                <div class="purchase-inspector-label">
                    Status
                </div>

                <span
                    id="inspectorPurchaseOrderStatus"
                    class="purchase-inspector-status"
                >
                    —
                </span>

            </div>


            <!-- <div class="purchase-inspector-reference">

                <div class="purchase-inspector-label">
                    Order ID
                </div>

                <strong
                    id="inspectorPurchaseOrderId"
                >
                    —
                </strong>

            </div> -->

        </div>


        {{-- ======================================================
            Supplier / Branch
        ======================================================= --}}

        <div class="purchase-inspector-section">

            <div class="purchase-inspector-section-header">

                <div class="purchase-inspector-section-icon">

                    <i class="bi bi-building"></i>

                </div>

                <div>

                    <div class="purchase-inspector-section-title">
                        Supplier & Branch
                    </div>

                    <div class="purchase-inspector-section-description">
                        Purchasing and receiving information
                    </div>

                </div>

            </div>


            <div class="purchase-inspector-info-grid">

                <div class="purchase-inspector-info-item">

                    <span class="purchase-inspector-label">
                        Supplier
                    </span>

                    <strong
                        id="inspectorPurchaseOrderSupplier"
                        class="purchase-inspector-value"
                    >
                        —
                    </strong>

                </div>


                <div class="purchase-inspector-info-item">

                    <span class="purchase-inspector-label">
                        Receiving Branch
                    </span>

                    <strong
                        id="inspectorPurchaseOrderBranch"
                        class="purchase-inspector-value"
                    >
                        —
                    </strong>

                </div>

            </div>

        </div>


        {{-- ======================================================
            Dates
        ======================================================= --}}

        <div class="purchase-inspector-section">

            <div class="purchase-inspector-section-header">

                <div class="purchase-inspector-section-icon">

                    <i class="bi bi-calendar3"></i>

                </div>

                <div>

                    <div class="purchase-inspector-section-title">
                        Order Schedule
                    </div>

                    <div class="purchase-inspector-section-description">
                        Order and expected delivery dates
                    </div>

                </div>

            </div>


            <div class="purchase-inspector-info-grid">

                <div class="purchase-inspector-info-item">

                    <span class="purchase-inspector-label">
                        Order Date
                    </span>

                    <strong
                        id="inspectorPurchaseOrderDate"
                        class="purchase-inspector-value"
                    >
                        —
                    </strong>

                </div>


                <div class="purchase-inspector-info-item">

                    <span class="purchase-inspector-label">
                        Expected Delivery
                    </span>

                    <strong
                        id="inspectorPurchaseOrderExpectedDate"
                        class="purchase-inspector-value"
                    >
                        —
                    </strong>

                </div>

            </div>

        </div>


        {{-- ======================================================
            Order Items
        ======================================================= --}}

        <div class="purchase-inspector-section">

            <div class="purchase-inspector-section-header">

                <div class="purchase-inspector-section-icon">

                    <i class="bi bi-box-seam"></i>

                </div>

                <div>

                    <div class="purchase-inspector-section-title">
                        Order Items
                    </div>

                    <div
                        class="purchase-inspector-section-description"
                        id="inspectorPurchaseOrderItemCount"
                    >
                        —
                    </div>

                </div>

            </div>


            <div
                id="inspectorPurchaseOrderItems"
                class="purchase-inspector-items"
            >

                <div class="purchase-inspector-empty">

                    <i class="bi bi-box-seam"></i>

                    <span>
                        No items available.
                    </span>

                </div>

            </div>

        </div>


        {{-- ======================================================
            Financial Summary
        ======================================================= --}}

        <div class="purchase-inspector-section">

            <div class="purchase-inspector-section-header">

                <div class="purchase-inspector-section-icon">

                    <i class="bi bi-calculator"></i>

                </div>

                <div>

                    <div class="purchase-inspector-section-title">
                        Financial Summary
                    </div>

                    <div class="purchase-inspector-section-description">
                        Purchase order value
                    </div>

                </div>

            </div>


            <div class="purchase-inspector-total-card">


                <div class="purchase-inspector-total-row">

                    <span>
                        Subtotal
                    </span>

                    <strong
                        id="inspectorPurchaseOrderSubtotal"
                    >
                        0.00
                    </strong>

                </div>


                <div class="purchase-inspector-total-row">

                    <span>
                        Tax
                    </span>

                    <strong
                        id="inspectorPurchaseOrderTax"
                    >
                        0.00
                    </strong>

                </div>


                <div class="purchase-inspector-total-divider"></div>


                <div class="purchase-inspector-grand-total">

                    <span>
                        Total
                    </span>

                    <strong
                        id="inspectorPurchaseOrderTotal"
                    >
                        0.00
                    </strong>

                </div>

            </div>

        </div>


        {{-- ======================================================
            Notes
        ======================================================= --}}

        <div class="purchase-inspector-section">

            <div class="purchase-inspector-section-header">

                <div class="purchase-inspector-section-icon">

                    <i class="bi bi-chat-left-text"></i>

                </div>

                <div>

                    <div class="purchase-inspector-section-title">
                        Notes
                    </div>

                    <div class="purchase-inspector-section-description">
                        Additional information
                    </div>

                </div>

            </div>


            <div
                id="inspectorPurchaseOrderNotes"
                class="purchase-inspector-notes"
            >
                —
            </div>

        </div>


        {{-- ======================================================
            Activity
        ======================================================= --}}

        <div class="purchase-inspector-section">

            <div class="purchase-inspector-section-header">

                <div class="purchase-inspector-section-icon">

                    <i class="bi bi-clock-history"></i>

                </div>

                <div>

                    <div class="purchase-inspector-section-title">
                        Activity
                    </div>

                    <div class="purchase-inspector-section-description">
                        Order history
                    </div>

                </div>

            </div>


            <div class="purchase-inspector-activity">


                <div class="purchase-inspector-activity-item">

                    <div class="purchase-inspector-activity-icon">

                        <i class="bi bi-person"></i>

                    </div>

                    <div>

                        <span class="purchase-inspector-label">
                            Created By
                        </span>

                        <strong
                            id="inspectorPurchaseOrderCreatedBy"
                        >
                            —
                        </strong>

                    </div>

                </div>


                <div class="purchase-inspector-activity-item">

                    <div class="purchase-inspector-activity-icon">

                        <i class="bi bi-calendar-plus"></i>

                    </div>

                    <div>

                        <span class="purchase-inspector-label">
                            Created
                        </span>

                        <strong
                            id="inspectorPurchaseOrderCreatedAt"
                        >
                            —
                        </strong>

                    </div>

                </div>


                <div class="purchase-inspector-activity-item">

                    <div class="purchase-inspector-activity-icon">

                        <i class="bi bi-person-check"></i>

                    </div>

                    <div>

                        <span class="purchase-inspector-label">
                            Approved By
                        </span>

                        <strong
                            id="inspectorPurchaseOrderApprovedBy"
                        >
                            —
                        </strong>

                    </div>

                </div>


                <div class="purchase-inspector-activity-item">

                    <div class="purchase-inspector-activity-icon">

                        <i class="bi bi-check2-circle"></i>

                    </div>

                    <div>

                        <span class="purchase-inspector-label">
                            Approved At
                        </span>

                        <strong
                            id="inspectorPurchaseOrderApprovedAt"
                        >
                            —
                        </strong>

                    </div>

                </div>


                <div class="purchase-inspector-activity-item">

                    <div class="purchase-inspector-activity-icon">

                        <i class="bi bi-pencil-square"></i>

                    </div>

                    <div>

                        <span class="purchase-inspector-label">
                            Last Updated
                        </span>

                        <strong
                            id="inspectorPurchaseOrderUpdatedAt"
                        >
                            —
                        </strong>

                    </div>

                </div>


                <div class="purchase-inspector-activity-item">

                    <div class="purchase-inspector-activity-icon">

                        <i class="bi bi-person-gear"></i>

                    </div>

                    <!-- <div>

                        <span class="purchase-inspector-label">
                            Updated By
                        </span>

                        <strong
                            id="inspectorPurchaseOrderUpdatedBy"
                        >
                            —
                        </strong>

                    </div> -->

                </div>

            </div>

        </div>

    </div>

</div>

