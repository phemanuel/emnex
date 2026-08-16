{{-- ==============================================================
    Purchase Return Inspector
============================================================== --}}

<div
    class="offcanvas offcanvas-end"
    tabindex="-1"
    id="purchaseReturnInspector"
>

    <div class="offcanvas-header border-bottom">

        <div>

            <div class="text-muted small mb-1">
                Purchase Return
            </div>

            <h5
                class="offcanvas-title fw-semibold"
                id="purchaseReturnInspectorLabel"
            >
                —
            </h5>

        </div>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
        ></button>

    </div>


    <div class="offcanvas-body">

        <div
            class="d-flex align-items-center justify-content-between mb-4"
        >

            <span class="text-muted small">
                Status
            </span>

            <span
                id="inspectorPurchaseReturnStatus"
                class="badge bg-secondary-subtle text-secondary"
            >
                —
            </span>

        </div>


        <div class="purchase-inspector-card mb-4">

            <div class="purchase-inspector-grid">

                <div>

                    <span class="purchase-inspector-label">
                        Supplier
                    </span>

                    <strong id="inspectorPurchaseReturnSupplier">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Branch
                    </span>

                    <strong id="inspectorPurchaseReturnBranch">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Purchase Order
                    </span>

                    <strong id="inspectorPurchaseReturnOrder">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Return Date
                    </span>

                    <strong id="inspectorPurchaseReturnDate">
                        —
                    </strong>

                </div>

            </div>

        </div>


        <div class="mb-4">

            <div class="purchase-inspector-heading">
                Returned Items
            </div>

            <div
                id="inspectorPurchaseReturnItems"
                class="purchase-inspector-items"
            >

                <div class="text-muted small">
                    No items available.
                </div>

            </div>

        </div>


        <div class="purchase-inspector-card mb-4">

            <div class="purchase-summary-row">

                <span>
                    Total Quantity
                </span>

                <strong id="inspectorPurchaseReturnQuantity">
                    0
                </strong>

            </div>


            <div class="purchase-summary-row purchase-summary-total">

                <span>
                    Total Value
                </span>

                <strong id="inspectorPurchaseReturnTotal">
                    0.00
                </strong>

            </div>

        </div>


        <div class="mb-4">

            <div class="purchase-inspector-heading">
                Reason / Notes
            </div>

            <div
                id="inspectorPurchaseReturnNotes"
                class="text-muted small"
            >
                —
            </div>

        </div>


        <div class="purchase-inspector-card">

            <div class="purchase-inspector-heading">
                Activity
            </div>

            <div class="purchase-inspector-meta">

                <div>

                    <span>
                        Processed By
                    </span>

                    <strong id="inspectorPurchaseReturnCreatedBy">
                        —
                    </strong>

                </div>


                <div>

                    <span>
                        Created
                    </span>

                    <strong id="inspectorPurchaseReturnCreatedAt">
                        —
                    </strong>

                </div>

            </div>

        </div>

    </div>

</div>