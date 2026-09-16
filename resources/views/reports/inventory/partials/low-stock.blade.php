<div class="card inventory-report-card mb-4">

    <div class="card-header inventory-section-header">
        <div>
            <h5 class="inventory-section-title">
                Low & Out of Stock
            </h5>

            <p class="inventory-section-description">
                Products requiring attention based on branch-level stock thresholds.
            </p>
        </div>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table inventory-report-table mb-0">

                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Branch</th>
                        <th class="text-end">Current Stock</th>
                        <th class="text-end">Available</th>
                        <th class="text-end">Reorder Level</th>
                        <th class="text-end">Maximum</th>
                        <th class="text-end">Shortage</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody id="inventoryLowStockTableBody">
                    <tr>
                        <td colspan="9" class="inventory-table-placeholder">
                            No low-stock products found.
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>

    </div>

</div>