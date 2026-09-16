<div class="row g-3 mb-4" id="profitLossStats">

    {{-- -----------------------------------------------------------------------
         Gross Revenue
    ------------------------------------------------------------------------ --}}

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card profit-loss-stat-card h-100">
            <div class="card-body">

                <div class="d-flex align-items-start justify-content-between gap-3">

                    <div class="min-w-0">
                        <div class="profit-loss-stat-label">
                            Gross Revenue
                        </div>

                        <div
                            class="profit-loss-stat-value"
                            id="profitLossStatGrossRevenue"
                        >
                            ₦0.00
                        </div>

                        <div class="profit-loss-stat-meta">
                            Completed sales before returns
                        </div>
                    </div>

                    <div class="profit-loss-stat-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- -----------------------------------------------------------------------
         Sales Returns
    ------------------------------------------------------------------------ --}}

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card profit-loss-stat-card h-100">
            <div class="card-body">

                <div class="d-flex align-items-start justify-content-between gap-3">

                    <div class="min-w-0">
                        <div class="profit-loss-stat-label">
                            Sales Returns
                        </div>

                        <div
                            class="profit-loss-stat-value"
                            id="profitLossStatSalesReturns"
                        >
                            ₦0.00
                        </div>

                        <div class="profit-loss-stat-meta">
                            Completed customer returns
                        </div>
                    </div>

                    <div class="profit-loss-stat-icon">
                        <i class="bi bi-arrow-return-left"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- -----------------------------------------------------------------------
         Net Revenue
    ------------------------------------------------------------------------ --}}

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card profit-loss-stat-card h-100">
            <div class="card-body">

                <div class="d-flex align-items-start justify-content-between gap-3">

                    <div class="min-w-0">
                        <div class="profit-loss-stat-label">
                            Net Revenue
                        </div>

                        <div
                            class="profit-loss-stat-value"
                            id="profitLossStatNetRevenue"
                        >
                            ₦0.00
                        </div>

                        <div class="profit-loss-stat-meta">
                            Revenue after sales returns
                        </div>
                    </div>

                    <div class="profit-loss-stat-icon">
                        <i class="bi bi-cash-stack"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- -----------------------------------------------------------------------
         Gross COGS
    ------------------------------------------------------------------------ --}}

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card profit-loss-stat-card h-100">
            <div class="card-body">

                <div class="d-flex align-items-start justify-content-between gap-3">

                    <div class="min-w-0">
                        <div class="profit-loss-stat-label">
                            Cost of Goods Sold
                        </div>

                        <div
                            class="profit-loss-stat-value"
                            id="profitLossStatGrossCogs"
                        >
                            ₦0.00
                        </div>

                        <div class="profit-loss-stat-meta">
                            Historical cost of sold products
                        </div>
                    </div>

                    <div class="profit-loss-stat-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- -----------------------------------------------------------------------
         Returned COGS
    ------------------------------------------------------------------------ --}}

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card profit-loss-stat-card h-100">
            <div class="card-body">

                <div class="d-flex align-items-start justify-content-between gap-3">

                    <div class="min-w-0">
                        <div class="profit-loss-stat-label">
                            Returned COGS
                        </div>

                        <div
                            class="profit-loss-stat-value"
                            id="profitLossStatReturnedCogs"
                        >
                            ₦0.00
                        </div>

                        <div class="profit-loss-stat-meta">
                            Cost recovered from returns
                        </div>
                    </div>

                    <div class="profit-loss-stat-icon">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- -----------------------------------------------------------------------
         Net COGS
    ------------------------------------------------------------------------ --}}

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card profit-loss-stat-card h-100">
            <div class="card-body">

                <div class="d-flex align-items-start justify-content-between gap-3">

                    <div class="min-w-0">
                        <div class="profit-loss-stat-label">
                            Net COGS
                        </div>

                        <div
                            class="profit-loss-stat-value"
                            id="profitLossStatNetCogs"
                        >
                            ₦0.00
                        </div>

                        <div class="profit-loss-stat-meta">
                            COGS after returned goods
                        </div>
                    </div>

                    <div class="profit-loss-stat-icon">
                        <i class="bi bi-boxes"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- -----------------------------------------------------------------------
         Gross Profit
    ------------------------------------------------------------------------ --}}

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card profit-loss-stat-card h-100">
            <div class="card-body">

                <div class="d-flex align-items-start justify-content-between gap-3">

                    <div class="min-w-0">
                        <div class="profit-loss-stat-label">
                            Gross Profit
                        </div>

                        <div
                            class="profit-loss-stat-value"
                            id="profitLossStatGrossProfit"
                        >
                            ₦0.00
                        </div>

                        <div
                            class="profit-loss-stat-meta"
                            id="profitLossStatGrossMargin"
                        >
                            0.00% margin
                        </div>
                    </div>

                    <div class="profit-loss-stat-icon">
                        <i class="bi bi-bar-chart-line"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- -----------------------------------------------------------------------
         Inventory Loss
    ------------------------------------------------------------------------ --}}

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card profit-loss-stat-card h-100">
            <div class="card-body">

                <div class="d-flex align-items-start justify-content-between gap-3">

                    <div class="min-w-0">
                        <div class="profit-loss-stat-label">
                            Inventory Losses
                        </div>

                        <div
                            class="profit-loss-stat-value"
                            id="profitLossStatInventoryLoss"
                        >
                            ₦0.00
                        </div>

                        <div class="profit-loss-stat-meta">
                            Damage and expired stock
                        </div>
                    </div>

                    <div class="profit-loss-stat-icon">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- -----------------------------------------------------------------------
         Operating Result
    ------------------------------------------------------------------------ --}}

    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card profit-loss-stat-card h-100">
            <div class="card-body">

                <div class="d-flex align-items-start justify-content-between gap-3">

                    <div class="min-w-0">
                        <div class="profit-loss-stat-label">
                            Operating Result
                        </div>

                        <div
                            class="profit-loss-stat-value"
                            id="profitLossStatOperatingResult"
                        >
                            ₦0.00
                        </div>

                        <div
                            class="profit-loss-stat-meta"
                            id="profitLossStatOperatingMargin"
                        >
                            0.00% margin
                        </div>
                    </div>

                    <div class="profit-loss-stat-icon">
                        <i class="bi bi-activity"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- -----------------------------------------------------------------------
         Damage Loss
    ------------------------------------------------------------------------ --}}

    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card profit-loss-stat-card h-100">
            <div class="card-body">

                <div class="d-flex align-items-start justify-content-between gap-3">

                    <div class="min-w-0">
                        <div class="profit-loss-stat-label">
                            Damage Loss
                        </div>

                        <div
                            class="profit-loss-stat-value"
                            id="profitLossStatDamageLoss"
                        >
                            ₦0.00
                        </div>

                        <div class="profit-loss-stat-meta">
                            Cost of damaged inventory
                        </div>
                    </div>

                    <div class="profit-loss-stat-icon">
                        <i class="bi bi-box2"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- -----------------------------------------------------------------------
         Expired Loss
    ------------------------------------------------------------------------ --}}

    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card profit-loss-stat-card h-100">
            <div class="card-body">

                <div class="d-flex align-items-start justify-content-between gap-3">

                    <div class="min-w-0">
                        <div class="profit-loss-stat-label">
                            Expired Loss
                        </div>

                        <div
                            class="profit-loss-stat-value"
                            id="profitLossStatExpiredLoss"
                        >
                            ₦0.00
                        </div>

                        <div class="profit-loss-stat-meta">
                            Cost of expired inventory
                        </div>
                    </div>

                    <div class="profit-loss-stat-icon">
                        <i class="bi bi-calendar-x"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

