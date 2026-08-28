{{-- ==============================================================
    Invoice Inspector
=============================================================== --}}

<div
    class="offcanvas offcanvas-end"
    tabindex="-1"
    id="invoiceInspector"
    aria-labelledby="invoiceInspectorLabel"
>

    {{-- ==========================================================
        Header
    =========================================================== --}}

    <div class="offcanvas-header border-bottom">

        <div>

            <div class="text-muted small mb-1">
                Invoice
            </div>

            <h5
                class="offcanvas-title fw-semibold"
                id="invoiceInspectorLabel"
            >
                —
            </h5>

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

    <div class="offcanvas-body">

        {{-- Status --}}

        <div class="d-flex align-items-center justify-content-between mb-4">

            <div>

                <div class="text-muted small">
                    Order Status
                </div>

                <div class="small text-muted">
                    Current sales order state
                </div>

            </div>

            <span
                id="invoiceInspectorOrderStatus"
                class="badge bg-secondary-subtle text-secondary"
            >
                —
            </span>

        </div>


        {{-- Payment Status --}}

        <div class="d-flex align-items-center justify-content-between mb-4">

            <div>

                <div class="text-muted small">
                    Payment Status
                </div>

                <div class="small text-muted">
                    Current payment state
                </div>

            </div>

            <span
                id="invoiceInspectorPaymentStatus"
                class="badge bg-secondary-subtle text-secondary"
            >
                —
            </span>

        </div>


        {{-- Invoice Information --}}

        <div class="purchase-inspector-card mb-4">

            <div class="purchase-inspector-grid">

                <div>

                    <span class="purchase-inspector-label">
                        Invoice No.
                    </span>

                    <strong id="invoiceInspectorNumber">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Order No.
                    </span>

                    <strong id="invoiceInspectorOrderNumber">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Customer
                    </span>

                    <strong id="invoiceInspectorCustomer">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Branch
                    </span>

                    <strong id="invoiceInspectorBranch">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Terminal
                    </span>

                    <strong id="invoiceInspectorTerminal">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Invoice Date
                    </span>

                    <strong id="invoiceInspectorDate">
                        —
                    </strong>

                </div>

            </div>

        </div>


        {{-- Items --}}

        <div class="purchase-inspector-section">

            <div class="purchase-inspector-section-header">

                <div class="purchase-inspector-section-icon">

                    <i class="bi bi-box-seam"></i>

                </div>

                <div>

                    <div class="purchase-inspector-section-title">
                        Invoice Items
                    </div>

                    <div class="purchase-inspector-section-description">
                        Products included in this invoice
                    </div>

                </div>

            </div>


            <div
                id="invoiceInspectorItems"
                class="purchase-inspector-items"
            >

                <div class="purchase-inspector-items-empty">

                    <div class="purchase-inspector-items-empty-icon">

                        <i class="bi bi-box-seam"></i>

                    </div>

                    <div class="purchase-inspector-items-empty-title">
                        No items available
                    </div>

                    <div class="purchase-inspector-items-empty-text">
                        This invoice does not contain any products.
                    </div>

                </div>

            </div>

        </div>


        {{-- Summary --}}

        <div class="purchase-inspector-card mb-4">

            <div class="purchase-inspector-heading mb-3">
                Invoice Summary
            </div>


            <div class="purchase-summary-row">

                <span>
                    Total Items
                </span>

                <strong id="invoiceInspectorItemCount">
                    0
                </strong>

            </div>


            <div class="purchase-summary-row">

                <span>
                    Total Quantity
                </span>

                <strong id="invoiceInspectorQuantity">
                    0
                </strong>

            </div>


            <div class="purchase-summary-row">

                <span>
                    Subtotal
                </span>

                <strong id="invoiceInspectorSubtotal">
                    0.00
                </strong>

            </div>


            <div class="purchase-summary-row">

                <span>
                    Discount
                </span>

                <strong id="invoiceInspectorDiscount">
                    0.00
                </strong>

            </div>


            <div class="purchase-summary-row">

                <span>
                    Tax
                </span>

                <strong id="invoiceInspectorTax">
                    0.00
                </strong>

            </div>


            <div class="purchase-summary-row purchase-summary-total">

                <span>
                    Grand Total
                </span>

                <strong id="invoiceInspectorTotal">
                    0.00
                </strong>

            </div>


            <div class="purchase-summary-row">

                <span>
                    Amount Paid
                </span>

                <strong id="invoiceInspectorAmountPaid">
                    0.00
                </strong>

            </div>


            <div class="purchase-summary-row">

                <span>
                    Balance
                </span>

                <strong id="invoiceInspectorBalance">
                    0.00
                </strong>

            </div>


            <div class="purchase-summary-row">

                <span>
                    Change Given
                </span>

                <strong id="invoiceInspectorChange">
                    0.00
                </strong>

            </div>

        </div>


        {{-- Finalization --}}

        <div class="border rounded-3 p-3 mb-4">

            <div class="d-flex align-items-start gap-3">

                <div class="text-primary">

                    <i class="bi bi-arrow-right-circle fs-5"></i>

                </div>

                <div class="flex-grow-1">

                    <div class="fw-semibold mb-1">
                        Continue with this order
                    </div>

                    <div class="text-muted small mb-3">
                        Payments and order finalization are handled
                        from the Sales Orders module.
                    </div>

                    <button
                        type="button"
                        class="btn btn-primary btn-sm"
                        id="invoiceGoToOrder"
                    >

                        <i class="bi bi-arrow-right me-1"></i>

                        Go to Sales Order

                    </button>

                </div>

            </div>

        </div>


        {{-- Remarks --}}

        <div class="mb-4">

            <div class="purchase-inspector-heading mb-3">
                Remarks
            </div>

            <div
                id="invoiceInspectorRemarks"
                class="text-muted small"
            >
                —
            </div>

        </div>


        {{-- Activity --}}

        <div class="purchase-inspector-card">

            <div class="purchase-inspector-heading mb-3">
                Activity
            </div>

            <div class="purchase-inspector-meta">

                <div>

                    <span>
                        Created By
                    </span>

                    <strong id="invoiceInspectorCreatedBy">
                        —
                    </strong>

                </div>


                <div>

                    <span>
                        Created
                    </span>

                    <strong id="invoiceInspectorCreatedAt">
                        —
                    </strong>

                </div>


                <div>

                    <span>
                        Updated By
                    </span>

                    <strong id="invoiceInspectorUpdatedBy">
                        —
                    </strong>

                </div>


                <div>

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