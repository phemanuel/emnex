<div class="cashier-home-content">


    {{--
    |--------------------------------------------------------------------------
    | Welcome
    |--------------------------------------------------------------------------
    --}}

    <section class="cashier-welcome">

        <span class="cashier-eyebrow">
            CASHIER OPERATIONS
        </span>

        <h2>
            Welcome back,
            {{ $user?->first_name ?? 'Cashier' }}
        </h2>

        <p>
            Manage your cash drawer and process sales from your cashier workspace.
        </p>

    </section>


    {{--
    |--------------------------------------------------------------------------
    | Today's Performance
    |--------------------------------------------------------------------------
    --}}

    <section class="cashier-section">


        <div class="cashier-section-heading">

            <h6>
                Today's Performance
            </h6>

            <p>
                Your current cashier activity for today.
            </p>

        </div>


        <div class="row g-3">


            {{-- Total Sales --}}

            <div class="col-xl-3 col-md-6">

                <div class="cashier-kpi-card">

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

            </div>


            {{-- Transactions --}}

            <div class="col-xl-3 col-md-6">

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

            </div>


            {{-- Cash Sales --}}

            <div class="col-xl-3 col-md-6">

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
                        Cash sales for today
                    </small>

                </div>

            </div>


            {{-- Drawer Balance --}}

            <div class="col-xl-3 col-md-6">

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

            </div>


        </div>

    </section>


    {{--
    |--------------------------------------------------------------------------
    | Quick Actions
    |--------------------------------------------------------------------------
    --}}

    <section class="cashier-section">


        <div class="cashier-section-heading">

            <h6>
                Quick Actions
            </h6>

            <p>
                Access your main cashier operations.
            </p>

        </div>


        <div class="cashier-actions-grid">


            {{-- Cash Drawer --}}

            <button
                type="button"
                class="cashier-action-card cashier-action-drawer"
                data-cashier-page="{{ route('cash-drawer.index') }}"
            >

                <div class="cashier-action-icon">

                    <i class="bi bi-cash-stack"></i>

                </div>


                <div class="cashier-action-content">

                    <span class="cashier-action-eyebrow">
                        CASH MANAGEMENT
                    </span>

                    <h4>
                        Cash Drawer
                    </h4>

                    <p>
                        Open, monitor, reconcile and manage
                        your current cash drawer session.
                    </p>

                </div>


                <span class="cashier-action-arrow">

                    <i class="bi bi-arrow-right"></i>

                </span>

            </button>


            {{-- New Sale --}}

            <button
                type="button"
                class="cashier-action-card cashier-action-sale"
                data-cashier-page="{{ route('pos.index') }}"
            >

                <div class="cashier-action-icon">

                    <i class="bi bi-cart-plus"></i>

                </div>


                <div class="cashier-action-content">

                    <span class="cashier-action-eyebrow">
                        POINT OF SALE
                    </span>

                    <h4>
                        New Sale
                    </h4>

                    <p>
                        Start a new transaction, add products,
                        apply approved adjustments and process payment.
                    </p>

                </div>


                <span class="cashier-action-arrow">

                    <i class="bi bi-arrow-right"></i>

                </span>

            </button>


        </div>

    </section>


</div>