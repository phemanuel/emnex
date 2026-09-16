<div class="card inventory-report-card mb-4">

    <div class="card-header inventory-section-header">
        <div>
            <h5 class="inventory-section-title">
                Stock Valuation
            </h5>

            <p class="inventory-section-description">
                Current inventory valuation based on product cost and selling prices.
            </p>
        </div>
    </div>

    <div class="card-body">

        <div class="inventory-valuation-summary">

            <div class="inventory-valuation-item">
                <span>Cost Value</span>
                <strong id="inventoryValuationCost">₦0.00</strong>
            </div>

            <div class="inventory-valuation-item">
                <span>Retail Value</span>
                <strong id="inventoryValuationRetail">₦0.00</strong>
            </div>

            <div class="inventory-valuation-item">
                <span>Potential Profit</span>
                <strong id="inventoryValuationProfit">₦0.00</strong>
            </div>

        </div>

        <div class="table-responsive mt-4">

            <table class="table inventory-report-table mb-0">

                <thead>
                    <tr>
                        <th>Branch</th>
                        <th class="text-end">Units</th>
                        <th class="text-end">Stock Value</th>
                        <th class="text-end">Retail Value</th>
                        <th class="text-end">Potential Profit</th>
                    </tr>
                </thead>

                <tbody id="inventoryValuationTableBody">
                    <tr>
                        <td colspan="5" class="inventory-table-placeholder">
                            No valuation data available.
                        </td>
                    </tr>
                </tbody>

            </table>

        </div>

    </div>

</div>