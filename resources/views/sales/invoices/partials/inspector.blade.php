
{{-- ==============================================================
    Invoice Inspector
=============================================================== --}}

<div
    class="offcanvas offcanvas-end invoice-inspector"
    tabindex="-1"
    id="invoiceInspector"
    aria-labelledby="invoiceInspectorLabel"
>

    {{-- ==========================================================
        Header
    =========================================================== --}}

    <div class="invoice-inspector-header">

        <div class="invoice-inspector-header-content">

            <div class="invoice-inspector-eyebrow">

                <i class="bi bi-receipt me-1"></i>

                Sales Invoice

            </div>


            <h5
                class="invoice-inspector-title"
                id="invoiceInspectorLabel"
            >
                —
            </h5>


            <div
                class="invoice-inspector-date"
                id="invoiceInspectorDate"
            >
                —
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

    <div class="offcanvas-body invoice-inspector-body">


        {{-- ======================================================
            Status
        ======================================================= --}}

        <div class="invoice-status-card mb-4">

            <div class="invoice-status-item">

                <div class="invoice-status-icon invoice-status-icon-order">

                    <i class="bi bi-receipt"></i>

                </div>

                <div class="invoice-status-content">

                    <div class="invoice-status-label">
                        Order Status
                    </div>

                    <div class="invoice-status-description">
                        Current sales order state
                    </div>

                </div>

                <span
                    id="invoiceInspectorOrderStatus"
                    class="badge invoice-status-badge"
                >
                    —
                </span>

            </div>


            <div class="invoice-status-divider"></div>


            <div class="invoice-status-item">

                <div class="invoice-status-icon invoice-status-icon-payment">

                    <i class="bi bi-wallet2"></i>

                </div>

                <div class="invoice-status-content">

                    <div class="invoice-status-label">
                        Payment Status
                    </div>

                    <div class="invoice-status-description">
                        Current payment state
                    </div>

                </div>

                <span
                    id="invoiceInspectorPaymentStatus"
                    class="badge invoice-status-badge"
                >
                    —
                </span>

            </div>

        </div>


        {{-- ======================================================
            Invoice Information
        ======================================================= --}}

        <div class="invoice-inspector-section mb-4">

            <div class="invoice-inspector-section-header">

                <div class="invoice-inspector-section-icon">

                    <i class="bi bi-file-earmark-text"></i>

                </div>

                <div>

                    <div class="invoice-inspector-section-title">
                        Invoice Information
                    </div>

                    <div class="invoice-inspector-section-description">
                        Reference and sales information
                    </div>

                </div>

            </div>


            <div class="invoice-info-card">

                <div class="invoice-info-grid">

                    <div class="invoice-info-item">

                        <span class="invoice-info-label">
                            Invoice No.
                        </span>

                        <strong
                            id="invoiceInspectorNumber"
                            class="invoice-info-value invoice-info-highlight"
                        >
                            —
                        </strong>

                    </div>


                    <div class="invoice-info-item">

                        <span class="invoice-info-label">
                            Order No.
                        </span>

                        <strong
                            id="invoiceInspectorOrderNumber"
                            class="invoice-info-value"
                        >
                            —
                        </strong>

                    </div>


                    <div class="invoice-info-item">

                        <span class="invoice-info-label">
                            Customer
                        </span>

                        <strong
                            id="invoiceInspectorCustomer"
                            class="invoice-info-value"
                        >
                            —
                        </strong>

                    </div>


                    <div class="invoice-info-item">

                        <span class="invoice-info-label">
                            Branch
                        </span>

                        <strong
                            id="invoiceInspectorBranch"
                            class="invoice-info-value"
                        >
                            —
                        </strong>

                    </div>


                    <div class="invoice-info-item">

                        <span class="invoice-info-label">
                            Terminal
                        </span>

                        <strong
                            id="invoiceInspectorTerminal"
                            class="invoice-info-value"
                        >
                            —
                        </strong>

                    </div>


                    <div class="invoice-info-item">

                        <span class="invoice-info-label">
                            Invoice Date
                        </span>

                        <strong
                            id="invoiceInspectorDate"
                            class="invoice-info-value"
                        >
                            —
                        </strong>

                    </div>

                </div>

            </div>

        </div>


        {{-- ======================================================
            Items
        ======================================================= --}}

        <div class="invoice-inspector-section mb-4">

            <div class="invoice-inspector-section-header">

                <div class="invoice-inspector-section-icon">

                    <i class="bi bi-box-seam"></i>

                </div>

                <div>

                    <div class="invoice-inspector-section-title">
                        Invoice Items
                    </div>

                    <div class="invoice-inspector-section-description">
                        Products included in this invoice
                    </div>

                </div>

            </div>


            <div
                id="invoiceInspectorItems"
                class="invoice-inspector-items"
            >

                <div class="invoice-items-empty">

                    <div class="invoice-items-empty-icon">

                        <i class="bi bi-box-seam"></i>

                    </div>

                    <div class="invoice-items-empty-title">
                        No items available
                    </div>

                    <div class="invoice-items-empty-text">
                        This invoice does not contain any products.
                    </div>

                </div>

            </div>

        </div>


        {{-- ======================================================
            Invoice Summary
        ======================================================= --}}

        <div class="invoice-summary-card mb-4">

            <div class="invoice-inspector-section-header mb-3">

                <div class="invoice-inspector-section-icon">

                    <i class="bi bi-calculator"></i>

                </div>

                <div>

                    <div class="invoice-inspector-section-title">
                        Invoice Summary
                    </div>

                    <div class="invoice-inspector-section-description">
                        Financial breakdown
                    </div>

                </div>

            </div>


            <div class="invoice-summary-row">

                <span>
                    Total Items
                </span>

                <strong id="invoiceInspectorItemCount">
                    0
                </strong>

            </div>


            <div class="invoice-summary-row">

                <span>
                    Total Quantity
                </span>

                <strong id="invoiceInspectorQuantity">
                    0
                </strong>

            </div>


            <div class="invoice-summary-divider"></div>


            <div class="invoice-summary-row">

                <span>
                    Subtotal
                </span>

                <strong id="invoiceInspectorSubtotal">
                    0.00
                </strong>

            </div>


            <div class="invoice-summary-row">

                <span>
                    Discount
                </span>

                <strong id="invoiceInspectorDiscount">
                    0.00
                </strong>

            </div>


            <div class="invoice-summary-row">

                <span>
                    Tax
                </span>

                <strong id="invoiceInspectorTax">
                    0.00
                </strong>

            </div>


            <div class="invoice-summary-divider"></div>


            <div class="invoice-summary-total">

                <span>
                    Grand Total
                </span>

                <strong id="invoiceInspectorTotal">
                    0.00
                </strong>

            </div>


            <div class="invoice-summary-row invoice-summary-paid">

                <span>
                    Amount Paid
                </span>

                <strong id="invoiceInspectorAmountPaid">
                    0.00
                </strong>

            </div>


            <div class="invoice-summary-row invoice-summary-balance">

                <span>
                    Balance
                </span>

                <strong id="invoiceInspectorBalance">
                    0.00
                </strong>

            </div>


            <div class="invoice-summary-row">

                <span>
                    Change Given
                </span>

                <strong id="invoiceInspectorChange">
                    0.00
                </strong>

            </div>

        </div>


        {{-- ======================================================
            Continue With Order
        ======================================================= --}}

        <div class="invoice-action-card mb-4">

            <div class="invoice-action-icon">

                <i class="bi bi-arrow-right-circle"></i>

            </div>


            <div class="invoice-action-content">

                <div class="invoice-action-title">
                    Continue with this order
                </div>

                <div class="invoice-action-description">
                    Open the related sales order to continue payment
                    or finalize the order.
                </div>


                <button
                    type="button"
                    class="btn btn-primary invoice-action-button"
                    id="invoiceGoToOrder"
                >

                    <i class="bi bi-arrow-right me-1"></i>

                    Go to Sales Order

                </button>

            </div>

        </div>


        {{-- ======================================================
            Remarks
        ======================================================= --}}

        <div class="invoice-inspector-section mb-4">

            <div class="invoice-inspector-section-header">

                <div class="invoice-inspector-section-icon">

                    <i class="bi bi-chat-left-text"></i>

                </div>

                <div>

                    <div class="invoice-inspector-section-title">
                        Remarks
                    </div>

                    <div class="invoice-inspector-section-description">
                        Additional invoice notes
                    </div>

                </div>

            </div>


            <div
                id="invoiceInspectorRemarks"
                class="invoice-remarks"
            >
                —
            </div>

        </div>


        {{-- ======================================================
            Activity
        ======================================================= --}}

        <div class="invoice-inspector-section">

            <div class="invoice-inspector-section-header">

                <div class="invoice-inspector-section-icon">

                    <i class="bi bi-clock-history"></i>

                </div>

                <div>

                    <div class="invoice-inspector-section-title">
                        Activity
                    </div>

                    <div class="invoice-inspector-section-description">
                        Invoice creation and update history
                    </div>

                </div>

            </div>


            <div class="invoice-activity-card">

                <div class="invoice-activity-item">

                    <div class="invoice-activity-icon">

                        <i class="bi bi-person"></i>

                    </div>

                    <div class="invoice-activity-content">

                        <span>
                            Created By
                        </span>

                        <strong id="invoiceInspectorCreatedBy">
                            —
                        </strong>

                    </div>

                </div>


                <div class="invoice-activity-item">

                    <div class="invoice-activity-icon">

                        <i class="bi bi-calendar3"></i>

                    </div>

                    <div class="invoice-activity-content">

                        <span>
                            Created
                        </span>

                        <strong id="invoiceInspectorCreatedAt">
                            —
                        </strong>

                    </div>

                </div>


                <div class="invoice-activity-item">

                    <div class="invoice-activity-icon">

                        <i class="bi bi-person-check"></i>

                    </div>

                    <div class="invoice-activity-content">

                        <span>
                            Updated By
                        </span>

                        <strong id="invoiceInspectorUpdatedBy">
                            —
                        </strong>

                    </div>

                </div>


                <div class="invoice-activity-item">

                    <div class="invoice-activity-icon">

                        <i class="bi bi-arrow-repeat"></i>

                    </div>

                    <div class="invoice-activity-content">

                        <span>
                            Updated
                        </span>

                        <strong id="invoiceInspectorUpdatedAt">
                            —
                        </strong>

                    </div>

                </div>

            </div>

        </div>


    </div>

</div>

