<div class="profit-loss-section mb-4">

    <div class="card profit-loss-statement-card">

        {{-- -------------------------------------------------------------------
             Section Header
        -------------------------------------------------------------------- --}}

        <div class="profit-loss-statement-header">

            <div>
                <h6 class="profit-loss-statement-title mb-1">
                    Cost of Goods Sold
                </h6>

                <p class="profit-loss-statement-description mb-0">
                    Historical product cost associated with completed sales,
                    adjusted for returned goods.
                </p>
            </div>

        </div>


        {{-- -------------------------------------------------------------------
             COGS Statement
        -------------------------------------------------------------------- --}}

        <div class="profit-loss-statement-body">

            {{-- Gross COGS --}}
            <div class="profit-loss-line-item">

                <div class="profit-loss-line-label">

                    <span class="profit-loss-line-icon">
                        <i class="bi bi-box-seam"></i>
                    </span>

                    <div>
                        <div class="fw-medium">
                            Gross COGS
                        </div>

                        <div class="profit-loss-line-description">
                            Historical cost of products included in completed sales.
                        </div>
                    </div>

                </div>

                <div
                    class="profit-loss-line-value"
                    id="profitLossCogsGross"
                >
                    ₦0.00
                </div>

            </div>


            {{-- Returned COGS --}}
            <div class="profit-loss-line-item">

                <div class="profit-loss-line-label">

                    <span class="profit-loss-line-icon">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </span>

                    <div>
                        <div class="fw-medium">
                            Less: Returned COGS
                        </div>

                        <div class="profit-loss-line-description">
                            Historical cost recovered from completed sales returns.
                        </div>
                    </div>

                </div>

                <div
                    class="profit-loss-line-value profit-loss-value-negative"
                    id="profitLossCogsReturned"
                >
                    (₦0.00)
                </div>

            </div>


            {{-- Divider --}}
            <div class="profit-loss-line-divider"></div>


            {{-- Net COGS --}}
            <div class="profit-loss-line-item profit-loss-line-total">

                <div class="profit-loss-line-label">

                    <span class="profit-loss-line-icon">
                        <i class="bi bi-boxes"></i>
                    </span>

                    <div>
                        <div class="fw-semibold">
                            Net COGS
                        </div>

                        <div class="profit-loss-line-description">
                            Gross COGS less the cost of returned goods.
                        </div>
                    </div>

                </div>

                <div
                    class="profit-loss-line-value profit-loss-value-total"
                    id="profitLossCogsNet"
                >
                    ₦0.00
                </div>

            </div>

        </div>

    </div>

</div>

