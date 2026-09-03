<!-- /*
|--------------------------------------------------------------------------
| Financial Overview
|--------------------------------------------------------------------------
*/ -->

<div class="cash-drawer-section-heading">

    <div>

        <h6 class="cash-drawer-section-title">
            Financial Overview
        </h6>

        <p class="cash-drawer-section-description">
            Current cash position and drawer activity.
        </p>

    </div>

</div>


<div class="row row-cols-5 g-3 mb-4">

    <!-- {{-- 
    |--------------------------------------------------------------------------
    | Opening Balance
    |--------------------------------------------------------------------------
    --}} -->

    <div class="col">

        <div class="cash-drawer-kpi-card">

            <div class="cash-drawer-kpi-top">

                <div class="cash-drawer-kpi-icon">

                    <i class="bi bi-wallet2"></i>

                </div>

                <span class="cash-drawer-kpi-label">
                    Opening Balance
                </span>

            </div>

            <div
                class="cash-drawer-kpi-value"
                id="kpi-opening-balance"
            >
                ₦0.00
            </div>

            <div class="cash-drawer-kpi-caption">
                Starting drawer balance
            </div>

        </div>

    </div>

    <!-- 
    {{-- 
    |--------------------------------------------------------------------------
    | My Cash Sales
    |--------------------------------------------------------------------------
    --}} -->

    <div class="col">

        <div class="cash-drawer-kpi-card">

            <div class="cash-drawer-kpi-top">

                <div class="cash-drawer-kpi-icon sales">

                    <i class="bi bi-cart-check"></i>

                </div>

                <span class="cash-drawer-kpi-label">
                    My Cash Sales
                </span>

            </div>

            <div
                class="cash-drawer-kpi-value"
                id="kpi-cash-sales"
            >
                ₦0.00
            </div>

            <div
                id="cashSalesInfo"
                class="cash-drawer-kpi-info"
            >
                No cash sales yet
            </div>

            <div class="cash-drawer-kpi-caption">
                Cash received from your sales
            </div>

        </div>

    </div>


    <!-- {{-- 
    |--------------------------------------------------------------------------
    | Other Cash Sales
    |--------------------------------------------------------------------------
    --}} -->

    <div class="col">

        <div class="cash-drawer-kpi-card">

            <div class="cash-drawer-kpi-top">

                <div class="cash-drawer-kpi-icon">

                    <i class="bi bi-people"></i>

                </div>

                <span class="cash-drawer-kpi-label">
                    Other Cash Sales
                </span>

            </div>

            <div
                class="cash-drawer-kpi-value"
                id="kpi-other-cash-sales"
            >
                ₦0.00
            </div>

            <div
                id="otherCashSalesInfo"
                class="cash-drawer-kpi-info"
            >
                No other cash sales
            </div>

            <div class="cash-drawer-kpi-caption">
                Other users on this terminal today
            </div>

        </div>

    </div>
<!-- 

    {{-- 
    |--------------------------------------------------------------------------
    | Cash In
    |--------------------------------------------------------------------------
    --}} -->

    <div class="col">

        <div class="cash-drawer-kpi-card">

            <div class="cash-drawer-kpi-top">

                <div class="cash-drawer-kpi-icon cash-in">

                    <i class="bi bi-arrow-down-circle"></i>

                </div>

                <span class="cash-drawer-kpi-label">
                    Cash In
                </span>

            </div>

            <div
                class="cash-drawer-kpi-value"
                id="kpi-cash-in"
            >
                ₦0.00
            </div>

            <div class="cash-drawer-kpi-caption">
                Additional cash received
            </div>

        </div>

    </div>
<!-- 

    {{-- 
    |--------------------------------------------------------------------------
    | Cash Out
    |--------------------------------------------------------------------------
    --}} -->

    <div class="col">

        <div class="cash-drawer-kpi-card">

            <div class="cash-drawer-kpi-top">

                <div class="cash-drawer-kpi-icon cash-out">

                    <i class="bi bi-arrow-up-circle"></i>

                </div>

                <span class="cash-drawer-kpi-label">
                    Cash Out
                </span>

            </div>

            <div
                class="cash-drawer-kpi-value"
                id="kpi-cash-out"
            >
                ₦0.00
            </div>

            <div class="cash-drawer-kpi-caption">
                Cash removed from drawer
            </div>

        </div>

    </div>

</div>