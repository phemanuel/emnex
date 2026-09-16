<div class="profit-loss-section mb-4">

    <div class="card profit-loss-statement-card">

        {{-- -------------------------------------------------------------------
             Section Header
        -------------------------------------------------------------------- --}}

        <div class="profit-loss-statement-header">

            <div>
                <h6 class="profit-loss-statement-title mb-1">
                    Revenue
                </h6>

                <p class="profit-loss-statement-description mb-0">
                    Revenue generated from completed sales after accounting
                    for completed sales returns.
                </p>
            </div>

        </div>


        {{-- -------------------------------------------------------------------
             Revenue Statement
        -------------------------------------------------------------------- --}}

        <div class="profit-loss-statement-body">

            {{-- Gross Revenue --}}
            <div class="profit-loss-line-item">

                <div class="profit-loss-line-label">
                    <span class="profit-loss-line-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </span>

                    <div>
                        <div class="fw-medium">
                            Gross Revenue
                        </div>

                        <div class="profit-loss-line-description">
                            Total value of completed sales before returns.
                        </div>
                    </div>
                </div>

                <div
                    class="profit-loss-line-value"
                    id="profitLossRevenueGross"
                >
                    ₦0.00
                </div>

            </div>


            {{-- Sales Returns --}}
            <div class="profit-loss-line-item">

                <div class="profit-loss-line-label">

                    <span class="profit-loss-line-icon">
                        <i class="bi bi-arrow-return-left"></i>
                    </span>

                    <div>
                        <div class="fw-medium">
                            Less: Sales Returns
                        </div>

                        <div class="profit-loss-line-description">
                            Value refunded for completed customer returns.
                        </div>
                    </div>

                </div>

                <div
                    class="profit-loss-line-value profit-loss-value-negative"
                    id="profitLossRevenueReturns"
                >
                    (₦0.00)
                </div>

            </div>


            {{-- Divider --}}
            <div class="profit-loss-line-divider"></div>


            {{-- Net Revenue --}}
            <div class="profit-loss-line-item profit-loss-line-total">

                <div class="profit-loss-line-label">

                    <span class="profit-loss-line-icon">
                        <i class="bi bi-cash-stack"></i>
                    </span>

                    <div>
                        <div class="fw-semibold">
                            Net Revenue
                        </div>

                        <div class="profit-loss-line-description">
                            Gross revenue less completed sales returns.
                        </div>
                    </div>

                </div>

                <div
                    class="profit-loss-line-value profit-loss-value-total"
                    id="profitLossRevenueNet"
                >
                    ₦0.00
                </div>

            </div>

        </div>

    </div>

</div>

