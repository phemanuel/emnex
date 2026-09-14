{{-- ==========================================================
    SALES REPORT — FILTERS
=========================================================== --}}

<div class="sales-report-filter-card">

    {{-- ======================================================
        HEADER
    ======================================================= --}}

    <div class="sales-report-filter-header">

        <div class="sales-report-filter-title-wrap">

            <div class="sales-report-filter-icon">
                <i class="bi bi-funnel"></i>
            </div>

            <div>
                <h2 class="sales-report-filter-title">
                    Report Filters
                </h2>

                <p class="sales-report-filter-description">
                    Refine the sales data displayed in this report.
                </p>
            </div>

        </div>

        <button
            type="button"
            class="btn btn-link sales-report-clear-btn"
            id="salesReportResetFilters"
        >
            <i class="bi bi-arrow-counterclockwise"></i>
            Reset
        </button>

    </div>


    {{-- ======================================================
        FILTER BODY
    ======================================================= --}}

    <div class="sales-report-filter-body">


        {{-- ==================================================
            DATE PRESET
        =================================================== --}}

        <div class="sales-report-filter-group sales-report-date-preset-group">

            <label
                for="salesReportDatePreset"
                class="sales-report-filter-label"
            >
                Date Range
            </label>

            <select
                class="form-select sales-report-filter-control"
                id="salesReportDatePreset"
                name="date_preset"
            >

                <option value="today">
                    Today
                </option>

                <option value="yesterday">
                    Yesterday
                </option>

                <option value="this_week">
                    This Week
                </option>

                <option value="last_week">
                    Last Week
                </option>

                <option value="this_month" selected>
                    This Month
                </option>

                <option value="last_month">
                    Last Month
                </option>

                <option value="this_quarter">
                    This Quarter
                </option>

                <option value="this_year">
                    This Year
                </option>

                <option value="custom">
                    Custom Range
                </option>

            </select>

        </div>


        {{-- ==================================================
            DATE FROM
        =================================================== --}}

        <div class="sales-report-filter-group">

            <label
                for="salesReportDateFrom"
                class="sales-report-filter-label"
            >
                From
            </label>

            <input
                type="date"
                class="form-control sales-report-filter-control"
                id="salesReportDateFrom"
                name="date_from"
            >

        </div>


        {{-- ==================================================
            DATE TO
        =================================================== --}}

        <div class="sales-report-filter-group">

            <label
                for="salesReportDateTo"
                class="sales-report-filter-label"
            >
                To
            </label>

            <input
                type="date"
                class="form-control sales-report-filter-control"
                id="salesReportDateTo"
                name="date_to"
            >

        </div>


        {{-- ==================================================
            BRANCH
        =================================================== --}}

        <div class="sales-report-filter-group">

            <label
                for="salesReportBranch"
                class="sales-report-filter-label"
            >
                Branch
            </label>

            <select
                class="form-select sales-report-filter-control"
                id="salesReportBranch"
                name="branch_id"
            >

                <option value="">
                    All Branches
                </option>

                @foreach(($filters['branches'] ?? []) as $branch)

                    <option value="{{ $branch['id'] }}">
                        {{ $branch['name'] }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- ==================================================
            CASHIER
        =================================================== --}}

        <div class="sales-report-filter-group">

            <label
                for="salesReportCashier"
                class="sales-report-filter-label"
            >
                Cashier
            </label>

            <select
                class="form-select sales-report-filter-control"
                id="salesReportCashier"
                name="cashier_id"
            >

                <option value="">
                    All Cashiers
                </option>

                @foreach(($filters['cashiers'] ?? []) as $cashier)

                    <option
                        value="{{ $cashier['id'] }}"
                        data-branch-id="{{ $cashier['branch_id'] ?? '' }}"
                    >
                        {{ $cashier['name'] }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- ==================================================
            PAYMENT METHOD
        =================================================== --}}

        <div class="sales-report-filter-group">

            <label
                for="salesReportPaymentMethod"
                class="sales-report-filter-label"
            >
                Payment Method
            </label>

            <select
                class="form-select sales-report-filter-control"
                id="salesReportPaymentMethod"
                name="payment_method"
            >

                <option value="">
                    All Payment Methods
                </option>

                @foreach(($filters['payment_methods'] ?? []) as $paymentMethod)

                    <option value="{{ $paymentMethod['value'] }}">
                        {{ $paymentMethod['label'] }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- ==================================================
            SALES CHANNEL
        =================================================== --}}

        <div class="sales-report-filter-group">

            <label
                for="salesReportSalesChannel"
                class="sales-report-filter-label"
            >
                Sales Channel
            </label>

            <select
                class="form-select sales-report-filter-control"
                id="salesReportSalesChannel"
                name="sales_channel"
            >

                <option value="">
                    All Channels
                </option>

                @foreach(($filters['sales_channels'] ?? []) as $channel)

                    <option value="{{ $channel['value'] }}">
                        {{ $channel['label'] }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- ==================================================
            CUSTOMER
        =================================================== --}}

        <div class="sales-report-filter-group sales-report-customer-filter-group">

            <label
                for="salesReportCustomer"
                class="sales-report-filter-label"
            >
                Customer
            </label>

            <select
                class="form-select sales-report-filter-control sales-report-customer-select"
                id="salesReportCustomer"
                name="customer_id"
            >

                <option value="">
                    All Customers
                </option>

                @foreach(($filters['customers'] ?? []) as $customer)

                    <option
                        value="{{ $customer['id'] }}"
                        data-branch-id="{{ $customer['branch_id'] ?? '' }}"
                    >
                        {{ $customer['name'] }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- ==================================================
            CATEGORY
        =================================================== --}}

        <div class="sales-report-filter-group">

            <label
                for="salesReportCategory"
                class="sales-report-filter-label"
            >
                Category
            </label>

            <select
                class="form-select sales-report-filter-control"
                id="salesReportCategory"
                name="category_id"
            >

                <option value="">
                    All Categories
                </option>

                @foreach(($filters['categories'] ?? []) as $category)

                    <option value="{{ $category['id'] }}">
                        {{ $category['name'] }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- ==================================================
            PRODUCT
        =================================================== --}}

        <div class="sales-report-filter-group">

            <label
                for="salesReportProduct"
                class="sales-report-filter-label"
            >
                Product
            </label>

            <select
                class="form-select sales-report-filter-control"
                id="salesReportProduct"
                name="product_id"
            >

                <option value="">
                    All Products
                </option>

                @foreach(($filters['products'] ?? []) as $product)

                    <option value="{{ $product['id'] }}">
                        {{ $product['name'] }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- ==================================================
            APPLY
        =================================================== --}}

        <div class="sales-report-filter-actions">

            <button
                type="button"
                class="btn sales-report-apply-btn"
                id="salesReportApplyFilters"
            >
                <i class="bi bi-search"></i>
                Apply Filters
            </button>

        </div>

    </div>

</div>