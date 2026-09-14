{{-- ==========================================================
    SALES REPORT — CHARTS
========================================================== --}}

<section
    class="sales-report-section sales-report-charts-section"
    aria-labelledby="salesReportChartsHeading"
>

    <div class="sales-report-section-header">

        <div>
            <h2
                class="sales-report-section-title"
                id="salesReportChartsHeading"
            >
                Sales Performance
            </h2>

            <p class="sales-report-section-description">
                Visualize sales activity and performance across the
                selected reporting period.
            </p>
        </div>

    </div>


    <div class="sales-report-charts-grid">

        {{-- ==================================================
            SALES TREND
        =================================================== --}}
        <div class="sales-report-chart-card sales-report-chart-card-large">

            <div class="sales-report-chart-header">

                <div>
                    <h3 class="sales-report-chart-title">
                        Sales Trend
                    </h3>

                    <p class="sales-report-chart-description">
                        Sales performance over time.
                    </p>
                </div>

                <div class="sales-report-chart-summary">
                    <span>Net Sales</span>
                    <strong id="salesChartTrendTotal">
                        ₦0.00
                    </strong>
                </div>

            </div>

            <div class="sales-report-chart-body">
                <canvas id="salesTrendChart"></canvas>
            </div>

        </div>


        {{-- ==================================================
            PAYMENT PERFORMANCE
        =================================================== --}}
        <div class="sales-report-chart-card">

            <div class="sales-report-chart-header">

                <div>
                    <h3 class="sales-report-chart-title">
                        Payment Performance
                    </h3>

                    <p class="sales-report-chart-description">
                        Sales distribution by payment method.
                    </p>
                </div>

            </div>

            <div class="sales-report-chart-body sales-report-chart-body-donut">
                <canvas id="salesPaymentChart"></canvas>
            </div>

        </div>


        {{-- ==================================================
            CATEGORY PERFORMANCE
        =================================================== --}}
        <div class="sales-report-chart-card">

            <div class="sales-report-chart-header">

                <div>
                    <h3 class="sales-report-chart-title">
                        Category Performance
                    </h3>

                    <p class="sales-report-chart-description">
                        Sales contribution by product category.
                    </p>
                </div>

            </div>

            <div class="sales-report-chart-body">
                <canvas id="salesCategoryChart"></canvas>
            </div>

        </div>

    </div>

</section>