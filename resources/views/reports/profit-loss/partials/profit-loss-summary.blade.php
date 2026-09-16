<div class="profit-loss-section mb-4">

    <div class="card profit-loss-summary-card">

        {{-- -------------------------------------------------------------------
             Section Header
        -------------------------------------------------------------------- --}}

        <div class="profit-loss-summary-header">

            <div>
                <h6 class="profit-loss-summary-title mb-1">
                    Profit & Loss Summary
                </h6>

                <p class="profit-loss-summary-description mb-0">
                    Consolidated financial result for the selected reporting
                    period, including revenue, cost of goods and inventory losses.
                </p>
            </div>

        </div>


        {{-- -------------------------------------------------------------------
             Summary Body
        -------------------------------------------------------------------- --}}

        <div class="profit-loss-summary-body">

            {{-- ================================================================
                 REVENUE
            ================================================================= --}}

            <div class="profit-loss-summary-group">

                <div class="profit-loss-summary-group-header">
                    <div class="profit-loss-summary-group-title">
                        <span class="profit-loss-summary-group-icon">
                            <i class="bi bi-cash-stack"></i>
                        </span>

                        <span>Revenue</span>
                    </div>
                </div>


                <div class="profit-loss-summary-row">

                    <div class="profit-loss-summary-label">
                        Gross Revenue
                    </div>

                    <div
                        class="profit-loss-summary-value"
                        id="profitLossSummaryGrossRevenue"
                    >
                        ₦0.00
                    </div>

                </div>


                <div class="profit-loss-summary-row">

                    <div class="profit-loss-summary-label">
                        Less: Sales Returns
                    </div>

                    <div
                        class="profit-loss-summary-value profit-loss-value-negative"
                        id="profitLossSummarySalesReturns"
                    >
                        (₦0.00)
                    </div>

                </div>


                <div class="profit-loss-summary-row profit-loss-summary-subtotal">

                    <div class="profit-loss-summary-label fw-semibold">
                        Net Revenue
                    </div>

                    <div
                        class="profit-loss-summary-value fw-semibold"
                        id="profitLossSummaryNetRevenue"
                    >
                        ₦0.00
                    </div>

                </div>

            </div>


            {{-- ================================================================
                 COST OF GOODS SOLD
            ================================================================= --}}

            <div class="profit-loss-summary-group">

                <div class="profit-loss-summary-group-header">
                    <div class="profit-loss-summary-group-title">
                        <span class="profit-loss-summary-group-icon">
                            <i class="bi bi-box-seam"></i>
                        </span>

                        <span>Cost of Goods Sold</span>
                    </div>
                </div>


                <div class="profit-loss-summary-row">

                    <div class="profit-loss-summary-label">
                        Net Cost of Goods Sold
                    </div>

                    <div
                        class="profit-loss-summary-value profit-loss-value-negative"
                        id="profitLossSummaryNetCogs"
                    >
                        (₦0.00)
                    </div>

                </div>


                <div class="profit-loss-summary-row profit-loss-summary-result">

                    <div>

                        <div class="profit-loss-summary-label fw-semibold">
                            Gross Profit
                        </div>

                        <div class="profit-loss-summary-meta">
                            Net Revenue less Net COGS
                        </div>

                    </div>

                    <div class="text-end">

                        <div
                            class="profit-loss-summary-result-value"
                            id="profitLossSummaryGrossProfit"
                        >
                            ₦0.00
                        </div>

                        <div
                            class="profit-loss-summary-result-margin"
                            id="profitLossSummaryGrossMargin"
                        >
                            0.00% margin
                        </div>

                    </div>

                </div>

            </div>


            {{-- ================================================================
                 INVENTORY LOSSES
            ================================================================= --}}

            <div class="profit-loss-summary-group">

                <div class="profit-loss-summary-group-header">
                    <div class="profit-loss-summary-group-title">
                        <span class="profit-loss-summary-group-icon">
                            <i class="bi bi-exclamation-triangle"></i>
                        </span>

                        <span>Inventory Losses</span>
                    </div>
                </div>


                <div class="profit-loss-summary-row">

                    <div class="profit-loss-summary-label">
                        Damage Loss
                    </div>

                    <div
                        class="profit-loss-summary-value profit-loss-value-negative"
                        id="profitLossSummaryDamageLoss"
                    >
                        (₦0.00)
                    </div>

                </div>


                <div class="profit-loss-summary-row">

                    <div class="profit-loss-summary-label">
                        Expired Loss
                    </div>

                    <div
                        class="profit-loss-summary-value profit-loss-value-negative"
                        id="profitLossSummaryExpiredLoss"
                    >
                        (₦0.00)
                    </div>

                </div>


                <div class="profit-loss-summary-row profit-loss-summary-subtotal">

                    <div class="profit-loss-summary-label fw-semibold">
                        Total Inventory Losses
                    </div>

                    <div
                        class="profit-loss-summary-value fw-semibold profit-loss-value-negative"
                        id="profitLossSummaryInventoryLoss"
                    >
                        (₦0.00)
                    </div>

                </div>

            </div>


            {{-- ================================================================
                 FINAL RESULT
            ================================================================= --}}

            <div class="profit-loss-summary-final">

                <div class="profit-loss-summary-final-content">

                    <div class="profit-loss-summary-final-icon">
                        <i class="bi bi-bar-chart-line"></i>
                    </div>

                    <div>

                        <div class="profit-loss-summary-final-label">
                            Operating Result
                        </div>

                        <div class="profit-loss-summary-final-description">
                            Gross Profit less total inventory losses.
                        </div>

                    </div>

                </div>


                <div class="profit-loss-summary-final-value-wrapper">

                    <div
                        class="profit-loss-summary-final-value"
                        id="profitLossSummaryOperatingResult"
                    >
                        ₦0.00
                    </div>

                    <div
                        class="profit-loss-summary-final-margin"
                        id="profitLossSummaryOperatingMargin"
                    >
                        0.00% margin
                    </div>

                    <div
                        class="profit-loss-summary-final-status"
                        id="profitLossSummaryResultStatus"
                    >
                        Profit
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

