<div class="card inventory-report-card mb-4">

    <div class="card-header inventory-section-header">
        <div>
            <h5 class="inventory-section-title">
                Stock Movements
            </h5>

            <p class="inventory-section-description">
                Detailed inventory movement history for the selected period.
            </p>
        </div>

        <div class="inventory-movement-summary" id="inventoryMovementSummary">
            <span>
                In: <strong id="inventoryMovementIn">0</strong>
            </span>

            <span>
                Out: <strong id="inventoryMovementOut">0</strong>
            </span>

            <span>
                Net: <strong id="inventoryMovementNet">0</strong>
            </span>
        </div>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table inventory-report-table mb-0">

                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Reference</th>
                        <th>Product</th>
                        <th>Branch</th>
                        <th>Type</th>
                        <th>Direction</th>
                        <th class="text-end">Quantity</th>
                        <th class="text-end">Before</th>
                        <th class="text-end">After</th>
                        <th>Created By</th>
                        <th class="text-end"></th>
                    </tr>
                </thead>

                <tbody id="inventoryMovementsTableBody">
                    <tr>
                        <td colspan="11" class="inventory-table-placeholder">
                            No stock movements available.
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>

        <div
            class="inventory-pagination"
            id="inventoryMovementsPagination"
        ></div>

    </div>

</div>