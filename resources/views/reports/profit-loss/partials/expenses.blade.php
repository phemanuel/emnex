<div class="profit-loss-section mb-4">

    <div class="card profit-loss-statement-card">

        {{-- -------------------------------------------------------------------
             Section Header
        -------------------------------------------------------------------- --}}

        <div class="profit-loss-statement-header">

            <div>
                <h6 class="profit-loss-statement-title mb-1">
                    Inventory Losses
                </h6>

                <p class="profit-loss-statement-description mb-0">
                    Inventory value lost through damaged and expired stock
                    during the selected period.
                </p>
            </div>

        </div>


        {{-- -------------------------------------------------------------------
             Inventory Loss Statement
        -------------------------------------------------------------------- --}}

        <div class="profit-loss-statement-body">

            {{-- Damage Loss --}}
            <div class="profit-loss-line-item">

                <div class="profit-loss-line-label">

                    <span class="profit-loss-line-icon">
                        <i class="bi bi-box2"></i>
                    </span>

                    <div>
                        <div class="fw-medium">
                            Damage Loss
                        </div>

                        <div class="profit-loss-line-description">
                            Historical cost of inventory written off as damaged.
                        </div>
                    </div>

                </div>

                <div
                    class="profit-loss-line-value profit-loss-value-negative"
                    id="profitLossDamageLoss"
                >
                    (₦0.00)
                </div>

            </div>


            {{-- Expired Loss --}}
            <div class="profit-loss-line-item">

                <div class="profit-loss-line-label">

                    <span class="profit-loss-line-icon">
                        <i class="bi bi-calendar-x"></i>
                    </span>

                    <div>
                        <div class="fw-medium">
                            Expired Loss
                        </div>

                        <div class="profit-loss-line-description">
                            Historical cost of inventory written off as expired.
                        </div>
                    </div>

                </div>

                <div
                    class="profit-loss-line-value profit-loss-value-negative"
                    id="profitLossExpiredLoss"
                >
                    (₦0.00)
                </div>

            </div>


            {{-- Divider --}}
            <div class="profit-loss-line-divider"></div>


            {{-- Total Inventory Loss --}}
            <div class="profit-loss-line-item profit-loss-line-total">

                <div class="profit-loss-line-label">

                    <span class="profit-loss-line-icon">
                        <i class="bi bi-exclamation-triangle"></i>
                    </span>

                    <div>
                        <div class="fw-semibold">
                            Total Inventory Loss
                        </div>

                        <div class="profit-loss-line-description">
                            Total value of damaged and expired inventory.
                        </div>
                    </div>

                </div>

                <div
                    class="profit-loss-line-value profit-loss-value-total profit-loss-value-negative"
                    id="profitLossInventoryLoss"
                >
                    (₦0.00)
                </div>

            </div>

        </div>

    </div>

</div>

