{{-- ==========================================================
    SALES REPORT — KPI STATISTICS
========================================================== --}}

<section
    class="sales-report-section sales-report-stats-section"
    aria-labelledby="salesReportStatsHeading"
>

    <div class="sales-report-section-header">

        <div>
            <h2
                class="sales-report-section-title"
                id="salesReportStatsHeading"
            >
                Sales Overview
            </h2>

            <p class="sales-report-section-description">
                Key sales indicators for the selected period.
            </p>
        </div>

    </div>


    <div class="sales-report-stats-grid">

        {{-- ==================================================
            GROSS SALES
        =================================================== --}}
        <div class="sales-report-stat-card">

            <div class="sales-report-stat-top">

                <div class="sales-report-stat-icon sales-report-stat-icon-sales">
                    <i class="bi bi-cash-stack"></i>
                </div>

                <span class="sales-report-stat-label">
                    Gross Sales
                </span>

            </div>

            <div
                class="sales-report-stat-value"
                id="salesStatGrossSales"
            >
                ₦0.00
            </div>

            <div
                class="sales-report-stat-meta"
                id="salesStatGrossSalesMeta"
            >
                Before discounts and returns
            </div>

        </div>


        {{-- ==================================================
            NET SALES
        =================================================== --}}
        <div class="sales-report-stat-card sales-report-stat-card-primary">

            <div class="sales-report-stat-top">

                <div class="sales-report-stat-icon">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>

                <span class="sales-report-stat-label">
                    Net Sales
                </span>

            </div>

            <div
                class="sales-report-stat-value"
                id="salesStatNetSales"
            >
                ₦0.00
            </div>

            <div
                class="sales-report-stat-meta"
                id="salesStatNetSalesMeta"
            >
                After discounts and returns
            </div>

        </div>


        {{-- ==================================================
            TRANSACTIONS
        =================================================== --}}
        <div class="sales-report-stat-card">

            <div class="sales-report-stat-top">

                <div class="sales-report-stat-icon sales-report-stat-icon-orders">
                    <i class="bi bi-receipt"></i>
                </div>

                <span class="sales-report-stat-label">
                    Transactions
                </span>

            </div>

            <div
                class="sales-report-stat-value"
                id="salesStatTransactions"
            >
                0
            </div>

            <div
                class="sales-report-stat-meta"
                id="salesStatTransactionsMeta"
            >
                Completed sales
            </div>

        </div>


        {{-- ==================================================
            AVERAGE ORDER VALUE
        =================================================== --}}
        <div class="sales-report-stat-card">

            <div class="sales-report-stat-top">

                <div class="sales-report-stat-icon sales-report-stat-icon-average">
                    <i class="bi bi-calculator"></i>
                </div>

                <span class="sales-report-stat-label">
                    Average Order
                </span>

            </div>

            <div
                class="sales-report-stat-value"
                id="salesStatAverageOrder"
            >
                ₦0.00
            </div>

            <div
                class="sales-report-stat-meta"
                id="salesStatAverageOrderMeta"
            >
                Average transaction value
            </div>

        </div>


        {{-- ==================================================
            DISCOUNTS
        =================================================== --}}
        <div class="sales-report-stat-card">

            <div class="sales-report-stat-top">

                <div class="sales-report-stat-icon sales-report-stat-icon-discount">
                    <i class="bi bi-tag"></i>
                </div>

                <span class="sales-report-stat-label">
                    Discounts
                </span>

            </div>

            <div
                class="sales-report-stat-value"
                id="salesStatDiscounts"
            >
                ₦0.00
            </div>

            <div
                class="sales-report-stat-meta"
                id="salesStatDiscountsMeta"
            >
                Total discounts granted
            </div>

        </div>


        {{-- ==================================================
            TAX
        =================================================== --}}
        <div class="sales-report-stat-card">

            <div class="sales-report-stat-top">

                <div class="sales-report-stat-icon sales-report-stat-icon-tax">
                    <i class="bi bi-percent"></i>
                </div>

                <span class="sales-report-stat-label">
                    Tax
                </span>

            </div>

            <div
                class="sales-report-stat-value"
                id="salesStatTax"
            >
                ₦0.00
            </div>

            <div
                class="sales-report-stat-meta"
                id="salesStatTaxMeta"
            >
                Tax collected on sales
            </div>

        </div>


        {{-- ==================================================
            RETURNS
        =================================================== --}}
        <div class="sales-report-stat-card">

            <div class="sales-report-stat-top">

                <div class="sales-report-stat-icon sales-report-stat-icon-returns">
                    <i class="bi bi-arrow-return-left"></i>
                </div>

                <span class="sales-report-stat-label">
                    Returns
                </span>

            </div>

            <div
                class="sales-report-stat-value"
                id="salesStatReturns"
            >
                ₦0.00
            </div>

            <div
                class="sales-report-stat-meta"
                id="salesStatReturnsMeta"
            >
                Sales returned
            </div>

        </div>


        {{-- ==================================================
            PROFIT
        =================================================== --}}
        <div class="sales-report-stat-card">

            <div class="sales-report-stat-top">

                <div class="sales-report-stat-icon sales-report-stat-icon-profit">
                    <i class="bi bi-piggy-bank"></i>
                </div>

                <span class="sales-report-stat-label">
                    Profit
                </span>

            </div>

            <div
                class="sales-report-stat-value"
                id="salesStatProfit"
            >
                ₦0.00
            </div>

            <div
                class="sales-report-stat-meta"
                id="salesStatProfitMeta"
            >
                Based on available cost data
            </div>

        </div>

    </div>

</section>