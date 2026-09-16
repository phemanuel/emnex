<div class="profit-loss-charts mb-4">

    {{-- -----------------------------------------------------------------------
         Chart Section Header
    ------------------------------------------------------------------------ --}}

    <div class="d-flex align-items-center justify-content-between gap-3 mb-3">

        <div>
            <h6 class="mb-1 fw-semibold">
                Financial Performance
            </h6>

            <p class="text-muted small mb-0">
                Visual overview of revenue, costs and profitability for the
                selected period.
            </p>
        </div>

    </div>


    {{-- -----------------------------------------------------------------------
         Profit & Loss Trend
    ------------------------------------------------------------------------ --}}

    <div class="card profit-loss-chart-card mb-3">
        <div class="card-body">

            <div class="profit-loss-chart-header">
                <div>
                    <h6 class="profit-loss-chart-title mb-1">
                        Profit & Loss Trend
                    </h6>

                    <p class="profit-loss-chart-description mb-0">
                        Revenue, cost of goods and operating result across the
                        selected period.
                    </p>
                </div>
            </div>

            <div
                class="profit-loss-chart-container"
                id="profitLossTrendChart"
            >
                <div class="profit-loss-chart-empty d-none">
                    <i class="bi bi-bar-chart-line"></i>

                    <span>
                        No trend data available.
                    </span>
                </div>
            </div>

        </div>
    </div>


    {{-- -----------------------------------------------------------------------
         Revenue & Cost Charts
    ------------------------------------------------------------------------ --}}

    <div class="row g-3">

        {{-- Revenue Composition --}}
        <div class="col-12 col-xl-6">

            <div class="card profit-loss-chart-card h-100">
                <div class="card-body">

                    <div class="profit-loss-chart-header">
                        <div>
                            <h6 class="profit-loss-chart-title mb-1">
                                Revenue
                            </h6>

                            <p class="profit-loss-chart-description mb-0">
                                Gross revenue, sales returns and net revenue.
                            </p>
                        </div>
                    </div>

                    <div
                        class="profit-loss-chart-container profit-loss-chart-container-sm"
                        id="profitLossRevenueChart"
                    >
                        <div class="profit-loss-chart-empty d-none">
                            <i class="bi bi-cash-stack"></i>

                            <span>
                                No revenue data available.
                            </span>
                        </div>
                    </div>

                </div>
            </div>

        </div>


        {{-- Cost of Goods --}}
        <div class="col-12 col-xl-6">

            <div class="card profit-loss-chart-card h-100">
                <div class="card-body">

                    <div class="profit-loss-chart-header">
                        <div>
                            <h6 class="profit-loss-chart-title mb-1">
                                Cost of Goods
                            </h6>

                            <p class="profit-loss-chart-description mb-0">
                                Gross COGS, returned COGS and net COGS.
                            </p>
                        </div>
                    </div>

                    <div
                        class="profit-loss-chart-container profit-loss-chart-container-sm"
                        id="profitLossCostsChart"
                    >
                        <div class="profit-loss-chart-empty d-none">
                            <i class="bi bi-box-seam"></i>

                            <span>
                                No cost data available.
                            </span>
                        </div>
                    </div>

                </div>
            </div>

        </div>


        {{-- Profit Breakdown --}}
        <div class="col-12">

            <div class="card profit-loss-chart-card">
                <div class="card-body">

                    <div class="profit-loss-chart-header">
                        <div>
                            <h6 class="profit-loss-chart-title mb-1">
                                Profit Breakdown
                            </h6>

                            <p class="profit-loss-chart-description mb-0">
                                Gross profit, inventory losses and operating
                                result.
                            </p>
                        </div>
                    </div>

                    <div
                        class="profit-loss-chart-container"
                        id="profitLossProfitChart"
                    >
                        <div class="profit-loss-chart-empty d-none">
                            <i class="bi bi-graph-up-arrow"></i>

                            <span>
                                No profit data available.
                            </span>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>

