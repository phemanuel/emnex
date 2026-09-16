<div class="profit-loss-section mb-4">

    <div class="card profit-loss-breakdown-card">

        {{-- -------------------------------------------------------------------
             Section Header
        -------------------------------------------------------------------- --}}

        <div class="profit-loss-breakdown-header">

            <div>
                <h6 class="profit-loss-breakdown-title mb-1">
                    Financial Breakdown
                </h6>

                <p class="profit-loss-breakdown-description mb-0">
                    Consolidated view of revenue, cost of goods, inventory losses
                    and profitability for the selected period.
                </p>
            </div>

        </div>


        {{-- -------------------------------------------------------------------
             Breakdown Body
        -------------------------------------------------------------------- --}}

        <div class="profit-loss-breakdown-body">

            <div class="row g-3">

                {{-- Revenue --}}
                <div class="col-12 col-md-6 col-xl-3">

                    <div class="profit-loss-breakdown-item">

                        <div class="profit-loss-breakdown-item-header">

                            <span class="profit-loss-breakdown-item-icon">
                                <i class="bi bi-cash-stack"></i>
                            </span>

                            <span class="profit-loss-breakdown-item-label">
                                Net Revenue
                            </span>

                        </div>

                        <div
                            class="profit-loss-breakdown-item-value"
                            id="profitLossBreakdownNetRevenue"
                        >
                            ₦0.00
                        </div>

                        <div class="profit-loss-breakdown-item-meta">
                            Gross revenue less sales returns
                        </div>

                    </div>

                </div>


                {{-- Net COGS --}}
                <div class="col-12 col-md-6 col-xl-3">

                    <div class="profit-loss-breakdown-item">

                        <div class="profit-loss-breakdown-item-header">

                            <span class="profit-loss-breakdown-item-icon">
                                <i class="bi bi-box-seam"></i>
                            </span>

                            <span class="profit-loss-breakdown-item-label">
                                Net COGS
                            </span>

                        </div>

                        <div
                            class="profit-loss-breakdown-item-value profit-loss-value-negative"
                            id="profitLossBreakdownNetCogs"
                        >
                            (₦0.00)
                        </div>

                        <div class="profit-loss-breakdown-item-meta">
                            Cost of goods sold after returned COGS
                        </div>

                    </div>

                </div>


                {{-- Gross Profit --}}
                <div class="col-12 col-md-6 col-xl-3">

                    <div class="profit-loss-breakdown-item">

                        <div class="profit-loss-breakdown-item-header">

                            <span class="profit-loss-breakdown-item-icon">
                                <i class="bi bi-graph-up-arrow"></i>
                            </span>

                            <span class="profit-loss-breakdown-item-label">
                                Gross Profit
                            </span>

                        </div>

                        <div
                            class="profit-loss-breakdown-item-value"
                            id="profitLossBreakdownGrossProfit"
                        >
                            ₦0.00
                        </div>

                        <div class="profit-loss-breakdown-item-meta">
                            Net revenue less net COGS
                        </div>

                    </div>

                </div>


                {{-- Inventory Loss --}}
                <div class="col-12 col-md-6 col-xl-3">

                    <div class="profit-loss-breakdown-item">

                        <div class="profit-loss-breakdown-item-header">

                            <span class="profit-loss-breakdown-item-icon">
                                <i class="bi bi-exclamation-triangle"></i>
                            </span>

                            <span class="profit-loss-breakdown-item-label">
                                Inventory Losses
                            </span>

                        </div>

                        <div
                            class="profit-loss-breakdown-item-value profit-loss-value-negative"
                            id="profitLossBreakdownInventoryLoss"
                        >
                            (₦0.00)
                        </div>

                        <div class="profit-loss-breakdown-item-meta">
                            Damage and expired inventory
                        </div>

                    </div>

                </div>


                {{-- Operating Result --}}
                <div class="col-12">

                    <div class="profit-loss-breakdown-result">

                        <div class="profit-loss-breakdown-result-content">

                            <div class="profit-loss-breakdown-result-icon">
                                <i class="bi bi-bar-chart-line"></i>
                            </div>

                            <div>

                                <div class="profit-loss-breakdown-result-label">
                                    Operating Result
                                </div>

                                <div class="profit-loss-breakdown-result-description">
                                    Gross profit after inventory losses for the
                                    selected reporting period.
                                </div>

                            </div>

                        </div>

                        <div class="text-end">

                            <div
                                class="profit-loss-breakdown-result-value"
                                id="profitLossBreakdownOperatingResult"
                            >
                                ₦0.00
                            </div>

                            <div
                                class="profit-loss-breakdown-result-margin"
                                id="profitLossBreakdownOperatingMargin"
                            >
                                0.00% margin
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

