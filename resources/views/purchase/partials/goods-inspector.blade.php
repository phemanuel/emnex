{{-- ==============================================================
    Goods Received Inspector
============================================================== --}}

<div
    class="offcanvas offcanvas-end"
    tabindex="-1"
    id="goodsReceivedInspector"
>

    <div class="offcanvas-header border-bottom">

        <div>

            <div class="text-muted small mb-1">
                Goods Received
            </div>

            <h5
                class="offcanvas-title fw-semibold"
                id="goodsReceivedInspectorLabel"
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
                id="inspectorGoodsReceivedStatus"
                class="badge bg-secondary-subtle text-secondary"
            >
                —
            </span>

        </div>


        <div class="purchase-inspector-card mb-4">

            <div class="purchase-inspector-grid">

                <div>

                    <span class="purchase-inspector-label">
                        Purchase Order
                    </span>

                    <strong id="inspectorGoodsReceivedOrder">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Supplier
                    </span>

                    <strong id="inspectorGoodsReceivedSupplier">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Branch
                    </span>

                    <strong id="inspectorGoodsReceivedBranch">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Received Date
                    </span>

                    <strong id="inspectorGoodsReceivedDate">
                        —
                    </strong>

                </div>

            </div>

        </div>


        <div class="mb-4">

            <div class="purchase-inspector-heading">
                Received Items
            </div>

            <div
                id="inspectorGoodsReceivedItems"
                class="purchase-inspector-items"
            >

                <div class="text-muted small">
                    No items available.
                </div>

            </div>

        </div>


        <div class="purchase-inspector-card mb-4">

            <div class="purchase-inspector-grid">

                <div>

                    <span class="purchase-inspector-label">
                        Total Items
                    </span>

                    <strong id="inspectorGoodsReceivedItemCount">
                        0
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Total Quantity
                    </span>

                    <strong id="inspectorGoodsReceivedQuantity">
                        0
                    </strong>

                </div>

            </div>

        </div>


        <div class="mb-4">

            <div class="purchase-inspector-heading">
                Notes
            </div>

            <div
                id="inspectorGoodsReceivedNotes"
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
                        Received By
                    </span>

                    <strong id="inspectorGoodsReceivedCreatedBy">
                        —
                    </strong>

                </div>


                <div>

                    <span>
                        Created
                    </span>

                    <strong id="inspectorGoodsReceivedCreatedAt">
                        —
                    </strong>

                </div>

            </div>

        </div>

    </div>

</div>