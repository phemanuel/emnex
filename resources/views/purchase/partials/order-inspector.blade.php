{{-- ==============================================================
    Purchase Order Inspector
============================================================== --}}

<div
    class="offcanvas offcanvas-end"
    tabindex="-1"
    id="purchaseOrderInspector"
    aria-labelledby="purchaseOrderInspectorLabel"
>

    <div class="offcanvas-header border-bottom">

        <div>

            <div class="text-muted small mb-1">
                Purchase Order
            </div>

            <h5
                class="offcanvas-title fw-semibold"
                id="purchaseOrderInspectorLabel"
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


    <div class="offcanvas-body">

        {{-- ==================================================
            Status
        ================================================== --}}

        <div
            class="d-flex align-items-center justify-content-between mb-4"
        >

            <span class="text-muted small">
                Status
            </span>

            <span
                id="inspectorPurchaseOrderStatus"
                class="badge bg-secondary-subtle text-secondary"
            >
                —
            </span>

        </div>


        {{-- ==================================================
            Summary
        ================================================== --}}

        <div class="purchase-inspector-card mb-4">

            <div class="purchase-inspector-grid">

                <div>

                    <span class="purchase-inspector-label">
                        Supplier
                    </span>

                    <strong
                        id="inspectorPurchaseOrderSupplier"
                    >
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Branch
                    </span>

                    <strong
                        id="inspectorPurchaseOrderBranch"
                    >
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Order Date
                    </span>

                    <strong
                        id="inspectorPurchaseOrderDate"
                    >
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Expected Delivery
                    </span>

                    <strong
                        id="inspectorPurchaseOrderExpectedDate"
                    >
                        —
                    </strong>

                </div>

            </div>

        </div>


        {{-- ==================================================
            Items
        ================================================== --}}

        <div class="mb-4">

            <div class="purchase-inspector-heading">
                Order Items
            </div>

            <div
                id="inspectorPurchaseOrderItems"
                class="purchase-inspector-items"
            >

                <div class="text-muted small">
                    No items available.
                </div>

            </div>

        </div>


        {{-- ==================================================
            Totals
        ================================================== --}}

        <div class="purchase-inspector-card mb-4">

            <div class="purchase-summary-row">

                <span>
                    Subtotal
                </span>

                <strong id="inspectorPurchaseOrderSubtotal">
                    0.00
                </strong>

            </div>


            <div class="purchase-summary-row">

                <span>
                    Discount
                </span>

                <strong id="inspectorPurchaseOrderDiscount">
                    0.00
                </strong>

            </div>


            <div class="purchase-summary-row">

                <span>
                    Tax
                </span>

                <strong id="inspectorPurchaseOrderTax">
                    0.00
                </strong>

            </div>


            <div class="purchase-summary-row purchase-summary-total">

                <span>
                    Total
                </span>

                <strong id="inspectorPurchaseOrderTotal">
                    0.00
                </strong>

            </div>

        </div>


        {{-- ==================================================
            Notes
        ================================================== --}}

        <div class="mb-4">

            <div class="purchase-inspector-heading">
                Notes
            </div>

            <div
                id="inspectorPurchaseOrderNotes"
                class="text-muted small"
            >
                —
            </div>

        </div>


        {{-- ==================================================
            Audit
        ================================================== --}}

        <div class="purchase-inspector-card">

            <div class="purchase-inspector-heading">
                Activity
            </div>

            <div class="purchase-inspector-meta">

                <div>

                    <span>
                        Created By
                    </span>

                    <strong id="inspectorPurchaseOrderCreatedBy">
                        —
                    </strong>

                </div>


                <div>

                    <span>
                        Created
                    </span>

                    <strong id="inspectorPurchaseOrderCreatedAt">
                        —
                    </strong>

                </div>


                <div>

                    <span>
                        Updated By
                    </span>

                    <strong id="inspectorPurchaseOrderUpdatedBy">
                        —
                    </strong>

                </div>

            </div>

        </div>

    </div>

</div>