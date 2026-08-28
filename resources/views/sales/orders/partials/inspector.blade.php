{{-- ==============================================================
    Sales Order Inspector
============================================================== --}}

<div
    class="offcanvas offcanvas-end"
    tabindex="-1"
    id="orderInspector"
    aria-labelledby="orderInspectorLabel"
>

    {{-- ==========================================================
        Header
    =========================================================== --}}

    <div class="offcanvas-header border-bottom">

        <div>

            <div class="text-muted small mb-1">
                Sales Order
            </div>

            <h5
                class="offcanvas-title fw-semibold"
                id="orderInspectorLabel"
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


        {{-- ======================================================
            Status
        ======================================================= --}}

        <div
            class="d-flex align-items-center justify-content-between mb-4"
        >

            <div>

                <div class="text-muted small">
                    Order Status
                </div>

                <div class="small text-muted">
                    Current order state
                </div>

            </div>


            <span
                id="inspectorOrderStatus"
                class="badge bg-secondary-subtle text-secondary"
            >
                —
            </span>

        </div>


        {{-- ======================================================
            Payment Status
        ======================================================= --}}

        <div
            class="d-flex align-items-center justify-content-between mb-4"
        >

            <div>

                <div class="text-muted small">
                    Payment Status
                </div>

                <div class="small text-muted">
                    Current payment state
                </div>

            </div>


            <span
                id="inspectorOrderPaymentStatus"
                class="badge bg-secondary-subtle text-secondary"
            >
                —
            </span>

        </div>


        {{-- ======================================================
            Order Information
        ======================================================= --}}

        <div class="purchase-inspector-card mb-4">

            <div class="purchase-inspector-grid">

                <div>

                    <span class="purchase-inspector-label">
                        Customer
                    </span>

                    <strong
                        id="inspectorOrderCustomer"
                    >
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Branch
                    </span>

                    <strong
                        id="inspectorOrderBranch"
                    >
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Terminal
                    </span>

                    <strong
                        id="inspectorOrderTerminal"
                    >
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Sales Channel
                    </span>

                    <strong
                        id="inspectorOrderSalesChannel"
                    >
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Order Date
                    </span>

                    <strong
                        id="inspectorOrderDate"
                    >
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Cashier
                    </span>

                    <strong
                        id="inspectorOrderCashier"
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

                    <div class="purchase-inspector-section-description">
                        Products included in this sales order
                    </div>

                </div>

            </div>


            <div
                id="inspectorOrderItems"
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
                        This order does not contain any products.
                    </div>

                </div>

            </div>

        </div>


        {{-- ======================================================
            Order Summary
        ======================================================= --}}

        <div class="purchase-inspector-card mb-4">

            <div class="purchase-inspector-heading mb-3">
                Order Summary
            </div>


            <div class="purchase-summary-row">

                <span>
                    Total Items
                </span>

                <strong
                    id="inspectorOrderItemCount"
                >
                    0
                </strong>

            </div>


            <div class="purchase-summary-row">

                <span>
                    Total Quantity
                </span>

                <strong
                    id="inspectorOrderQuantity"
                >
                    0
                </strong>

            </div>


            <div class="purchase-summary-row">

                <span>
                    Subtotal
                </span>

                <strong
                    id="inspectorOrderSubtotal"
                >
                    0.00
                </strong>

            </div>


            <div class="purchase-summary-row">

                <span>
                    Discount
                </span>

                <strong
                    id="inspectorOrderDiscount"
                >
                    0.00
                </strong>

            </div>


            <div class="purchase-summary-row">

                <span>
                    Tax
                </span>

                <strong
                    id="inspectorOrderTax"
                >
                    0.00
                </strong>

            </div>


            <div
                class="purchase-summary-row purchase-summary-total"
            >

                <span>
                    Grand Total
                </span>

                <strong
                    id="inspectorOrderTotal"
                >
                    0.00
                </strong>

            </div>


            <div class="purchase-summary-row">

                <span>
                    Amount Paid
                </span>

                <strong
                    id="inspectorOrderAmountPaid"
                >
                    0.00
                </strong>

            </div>


            <div class="purchase-summary-row">

                <span>
                    Balance
                </span>

                <strong
                    id="inspectorOrderBalance"
                >
                    0.00
                </strong>

            </div>


            <div class="purchase-summary-row">

                <span>
                    Change Given
                </span>

                <strong
                    id="inspectorOrderChange"
                >
                    0.00
                </strong>

            </div>

        </div>


        {{-- ======================================================
            Remarks
        ======================================================= --}}

        <div class="mb-4">

            <div class="purchase-inspector-heading mb-3">
                Remarks
            </div>


            <div
                id="inspectorOrderRemarks"
                class="text-muted small"
            >
                —
            </div>

        </div>


        {{-- ======================================================
            Activity
        ======================================================= --}}

        <div class="purchase-inspector-card">

            <div class="purchase-inspector-heading mb-3">
                Activity
            </div>


            <div class="purchase-inspector-meta">

                <div>

                    <span>
                        Created By
                    </span>

                    <strong
                        id="inspectorOrderCreatedBy"
                    >
                        —
                    </strong>

                </div>


                <div>

                    <span>
                        Created
                    </span>

                    <strong
                        id="inspectorOrderCreatedAt"
                    >
                        —
                    </strong>

                </div>


                <div>

                    <span>
                        Updated By
                    </span>

                    <strong
                        id="inspectorOrderUpdatedBy"
                    >
                        —
                    </strong>

                </div>


                <div>

                    <span>
                        Updated
                    </span>

                    <strong
                        id="inspectorOrderUpdatedAt"
                    >
                        —
                    </strong>

                </div>


                <div>

                    <span>
                        Completed
                    </span>

                    <strong
                        id="inspectorOrderCompletedAt"
                    >
                        —
                    </strong>

                </div>

            </div>

        </div>

    </div>

</div>