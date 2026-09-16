
<div class="profit-loss-section mb-4">

    <div class="card profit-loss-statement-card">

        {{-- -------------------------------------------------------------------
             Section Header
        -------------------------------------------------------------------- --}}

        <div class="profit-loss-statement-header">

            <div>
                <h6 class="profit-loss-statement-title mb-1">
                    Profitability
                </h6>

                <p class="profit-loss-statement-description mb-0">
                    Summary of gross profit and operating result after inventory
                    losses for the selected period.
                </p>
            </div>

        </div>


        {{-- -------------------------------------------------------------------
             Profitability Statement
        -------------------------------------------------------------------- --}}

        <div class="profit-loss-statement-body">

            {{-- Net Revenue --}}
            <div class="profit-loss-line-item">

                <div class="profit-loss-line-label">

                    <span class="profit-loss-line-icon">
                        <i class="bi bi-arrow-up-right-circle"></i>
                    </span>

                    <div>
                        <div class="fw-medium">
                            Net Revenue
                        </div>

                        <div class="profit-loss-line-description">
                            Revenue remaining after sales returns.
                        </div>
                    </div>

                </div>

                <div
                    class="profit-loss-line-value"
                    id="profitLossProfitNetRevenue"
                >
                    ₦0.00
                </div>

            </div>


            {{-- Net COGS --}}
            <div class="profit-loss-line-item">

                <div class="profit-loss-line-label">

                    <span class="profit-loss-line-icon">
                        <i class="bi bi-box-seam"></i>
                    </span>

                    <div>
                        <div class="fw-medium">
                            Net Cost of Goods Sold
                        </div>

                        <div class="profit-loss-line-description">
                            Historical cost of products sold after returned COGS.
                        </div>
                    </div>

                </div>

                <div
                    class="profit-loss-line-value profit-loss-value-negative"
                    id="profitLossProfitNetCogs"
                >
                    (₦0.00)
                </div>

            </div>


            {{-- Gross Profit Divider --}}
            <div class="profit-loss-line-divider"></div>


            {{-- Gross Profit --}}
            <div class="profit-loss-line-item profit-loss-line-total">

                <div class="profit-loss-line-label">

                    <span class="profit-loss-line-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </span>

                    <div>
                        <div class="fw-semibold">
                            Gross Profit
                        </div>

                        <div class="profit-loss-line-description">
                            Net revenue less net cost of goods sold.
                        </div>
                    </div>

                </div>

                <div
                    class="profit-loss-line-value profit-loss-value-total"
                    id="profitLossGrossProfit"
                >
                    ₦0.00
                </div>

            </div>


            {{-- Gross Margin --}}
            <div class="profit-loss-line-item">

                <div class="profit-loss-line-label">

                    <span class="profit-loss-line-icon">
                        <i class="bi bi-percent"></i>
                    </span>

                    <div>
                        <div class="fw-medium">
                            Gross Margin
                        </div>

                        <div class="profit-loss-line-description">
                            Gross profit expressed as a percentage of net revenue.
                        </div>
                    </div>

                </div>

                <div
                    class="profit-loss-line-value"
                    id="profitLossGrossMargin"
                >
                    0.00%
                </div>

            </div>


            {{-- Inventory Losses --}}
            <div class="profit-loss-line-item">

                <div class="profit-loss-line-label">

                    <span class="profit-loss-line-icon">
                        <i class="bi bi-exclamation-triangle"></i>
                    </span>

                    <div>
                        <div class="fw-medium">
                            Inventory Losses
                        </div>

                        <div class="profit-loss-line-description">
                            Damage and expired inventory written off during the period.
                        </div>
                    </div>

                </div>

                <div
                    class="profit-loss-line-value profit-loss-value-negative"
                    id="profitLossProfitInventoryLoss"
                >
                    (₦0.00)
                </div>

            </div>


            {{-- Operating Result Divider --}}
            <div class="profit-loss-line-divider"></div>


            {{-- Operating Result --}}
            <div class="profit-loss-line-item profit-loss-line-total">

                <div class="profit-loss-line-label">

                    <span class="profit-loss-line-icon">
                        <i class="bi bi-bar-chart-line"></i>
                    </span>

                    <div>
                        <div class="fw-semibold">
                            Operating Result
                        </div>

                        <div class="profit-loss-line-description">
                            Gross profit less inventory losses.
                        </div>
                    </div>

                </div>

                <div
                    class="profit-loss-line-value profit-loss-value-total"
                    id="profitLossOperatingResult"
                >
                    ₦0.00
                </div>

            </div>


            {{-- Operating Margin --}}
            <div class="profit-loss-line-item">

                <div class="profit-loss-line-label">

                    <span class="profit-loss-line-icon">
                        <i class="bi bi-percent"></i>
                    </span>

                    <div>
                        <div class="fw-medium">
                            Operating Margin
                        </div>

                        <div class="profit-loss-line-description">
                            Operating result expressed as a percentage of net revenue.
                        </div>
                    </div>

                </div>

                <div
                    class="profit-loss-line-value"
                    id="profitLossOperatingMargin"
                >
                    0.00%
                </div>

            </div>

        </div>

    </div>

</div>

