<div class="card inventory-report-card mb-4">

    <div class="card-header inventory-section-header">
        <div>
            <h5 class="inventory-section-title">
                Stock Movement Trend
            </h5>

            <p class="inventory-section-description">
                Stock entering and leaving inventory during the selected period.
            </p>
        </div>
    </div>

    <div class="card-body">

        <div class="inventory-chart-container">
            <canvas id="inventoryMovementTrendChart"></canvas>
        </div>

        <div
            id="inventoryTrendEmpty"
            class="inventory-chart-empty d-none"
        >
            <i class="bi bi-bar-chart"></i>
            <span>No movement data available for this period.</span>
        </div>

    </div>

</div>