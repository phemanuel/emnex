<div class="cashier-home-content">

    {{--
    |--------------------------------------------------------------------------
    | Welcome Header
    |--------------------------------------------------------------------------
    --}}

    <section class="cashier-dashboard-header">

        <div class="cashier-dashboard-header-main">

            <span class="cashier-dashboard-eyebrow">
                CASHIER WORKSPACE
            </span>

            <h2>
                Welcome back,
                {{ $user?->first_name ?? 'Cashier' }}
            </h2>

            <p>
                Monitor today's performance and access your cashier
                operations from one place.
            </p>

        </div>

        <div class="cashier-dashboard-context">

            <div class="cashier-context-item">

                <span class="cashier-context-icon">
                    <i class="bi bi-calendar3"></i>
                </span>

                <div>

                    <small>
                        Date
                    </small>

                    <strong id="cashier-current-date">
                        —
                    </strong>

                </div>

            </div>

            <div class="cashier-context-divider"></div>

            <div class="cashier-context-item">

                <span class="cashier-context-icon">
                    <i class="bi bi-clock"></i>
                </span>

                <div>

                    <small>
                        Current Time
                    </small>

                    <strong id="cashier-current-time">
                        —
                    </strong>

                </div>

            </div>


            </div>


    </section>


    {{--
    |--------------------------------------------------------------------------
    | Dashboard Grid
    |--------------------------------------------------------------------------
    --}}

    <section class="cashier-dashboard-grid">

        {{--
        |--------------------------------------------------------------------------
        | Performance Panel
        |--------------------------------------------------------------------------
        --}}

        <div class="cashier-performance-panel">

            <div class="cashier-panel-heading">

                <div>

                    <span class="cashier-panel-eyebrow">
                        TODAY
                    </span>

                    <h5>
                        Performance
                    </h5>

                    <p>
                        Your current cashier activity for today.
                    </p>

                </div>

                <span class="cashier-panel-status">
                    <span></span>
                    Live
                </span>

            </div>


            {{-- KPI Grid --}}

            <div class="cashier-kpi-grid">

                {{-- Total Sales --}}

                <div class="cashier-kpi-card cashier-kpi-card-primary">

                    <div class="cashier-kpi-top">

                        <div class="cashier-kpi-icon sales">
                            <i class="bi bi-currency-exchange"></i>
                        </div>

                        <span>
                            Total Sales
                        </span>

                    </div>

                    <strong id="cashier-kpi-sales">
                        ₦0.00
                    </strong>

                    <small>
                        Today's completed sales
                    </small>

                </div>


                {{-- Transactions --}}

                <div class="cashier-kpi-card">

                    <div class="cashier-kpi-top">

                        <div class="cashier-kpi-icon transactions">
                            <i class="bi bi-receipt"></i>
                        </div>

                        <span>
                            Transactions
                        </span>

                    </div>

                    <strong id="cashier-kpi-transactions">
                        0
                    </strong>

                    <small>
                        Completed transactions
                    </small>

                </div>


                {{-- Cash Sales --}}

                <div class="cashier-kpi-card">

                    <div class="cashier-kpi-top">

                        <div class="cashier-kpi-icon cash">
                            <i class="bi bi-cash-stack"></i>
                        </div>

                        <span>
                            Cash Sales
                        </span>

                    </div>

                    <strong id="cashier-kpi-cash-sales">
                        ₦0.00
                    </strong>

                    <small>
                        Cash collected today
                    </small>

                </div>


                {{-- Card Sales --}}

                <div class="cashier-kpi-card">

                    <div class="cashier-kpi-top">

                        <div class="cashier-kpi-icon card">
                            <i class="bi bi-credit-card-2-front"></i>
                        </div>

                        <span>
                            Card Sales
                        </span>

                    </div>

                    <strong id="cashier-kpi-card-sales">
                        ₦0.00
                    </strong>

                    <small>
                        Card payments today
                    </small>

                </div>


                {{-- Transfer Sales --}}

                <div class="cashier-kpi-card">

                    <div class="cashier-kpi-top">

                        <div class="cashier-kpi-icon transfer">
                            <i class="bi bi-bank"></i>
                        </div>

                        <span>
                            Transfer Sales
                        </span>

                    </div>

                    <strong id="cashier-kpi-transfer-sales">
                        ₦0.00
                    </strong>

                    <small>
                        Bank transfers today
                    </small>

                </div>


                {{-- Wallet Sales --}}

                <div class="cashier-kpi-card">

                    <div class="cashier-kpi-top">

                        <div class="cashier-kpi-icon wallet">
                            <i class="bi bi-wallet2"></i>
                        </div>

                        <span>
                            Wallet Sales
                        </span>

                    </div>

                    <strong id="cashier-kpi-wallet-sales">
                        ₦0.00
                    </strong>

                    <small>
                        Wallet payments today
                    </small>

                </div>


                {{-- Drawer Balance --}}

                <div class="cashier-kpi-card">

                    <div class="cashier-kpi-top">

                        <div class="cashier-kpi-icon drawer">
                            <i class="bi bi-safe2"></i>
                        </div>

                        <span>
                            Drawer Balance
                        </span>

                    </div>

                    <strong id="cashier-kpi-drawer">
                        ₦0.00
                    </strong>

                    <small>
                        Current expected balance
                    </small>

                </div>


                {{-- Expected Submission --}}

                <div class="cashier-kpi-card cashier-kpi-card-highlight">

                    <div class="cashier-kpi-top">

                        <div class="cashier-kpi-icon submission">
                            <i class="bi bi-wallet-fill"></i>
                        </div>

                        <span>
                            Expected Submission
                        </span>

                    </div>

                    <strong id="cashier-kpi-submission">
                        ₦0.00
                    </strong>

                    <small>
                        Expected at drawer close
                    </small>

                </div>

            </div>

        </div>


        {{--
        |--------------------------------------------------------------------------
        | Operations Panel
        |--------------------------------------------------------------------------
        --}}

        <aside class="cashier-operations-panel">

            <div class="cashier-panel-heading">

                <div>

                    <span class="cashier-panel-eyebrow">
                        OPERATIONS
                    </span>                   

                    <p>
                        Your most important cashier tools.
                    </p>

                </div>

            </div>


            {{-- POS --}}

            <button
                type="button"
                class="cashier-operation-card cashier-operation-pos"
                data-cashier-page="{{ route('pos.index') }}"
            >

                <div class="cashier-operation-icon">
                    <i class="bi bi-cart-plus"></i>
                </div>

                <div class="cashier-operation-content">

                    <span>
                        POINT OF SALE
                    </span>

                    <h4>
                        POS
                    </h4>

                    <p>
                        Start a new sale and process customer payments.
                    </p>

                </div>

                <div class="cashier-operation-arrow">
                    <i class="bi bi-arrow-up-right"></i>
                </div>

            </button>


            {{-- Cash Drawer --}}

            <button
                type="button"
                class="cashier-operation-card cashier-operation-drawer"
                data-cashier-page="{{ route('cash-drawer.index') }}"
            >

                <div class="cashier-operation-icon">
                    <i class="bi bi-safe2"></i>
                </div>

                <div class="cashier-operation-content">

                    <span>
                        CASH MANAGEMENT
                    </span>

                    <h4>
                        Cash Drawer
                    </h4>

                    <p>
                        Monitor, reconcile and manage your drawer session.
                    </p>

                </div>

                <div class="cashier-operation-arrow">
                    <i class="bi bi-arrow-up-right"></i>
                </div>

            </button>


            {{--
            |--------------------------------------------------------------------------
            | Drawer Status
            |--------------------------------------------------------------------------
            --}}

            <!-- <div class="cashier-drawer-status-card">

                <div class="cashier-drawer-status-header">

                    <div>

                        <span class="cashier-panel-eyebrow">
                            CURRENT DRAWER
                        </span>

                        <h6>
                            Cash Session
                        </h6>

                    </div>

                    <span class="cashier-drawer-status-badge">
                        <span></span>
                        Open
                    </span>

                </div>

                <div class="cashier-drawer-status-value">

                    <strong id="cashier-kpi-drawer-status">
                        ₦0.00
                    </strong>

                    <span>
                        Expected balance
                    </span>

                </div>

                <div class="cashier-drawer-status-footer">

                    <span>
                        <i class="bi bi-shield-check"></i>
                        Session active
                    </span>

                    <i class="bi bi-arrow-right"></i>

                </div>

            </div> -->

        </aside>

    </section>

</div>