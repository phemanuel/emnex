<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>EMNEX POS - Sales Report</title>

    <style>
        @page {
            margin: 28px 30px 35px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            font-size: 8px;
            line-height: 1.4;
            color: #1f2937;
        }

        h1,
        h2,
        h3,
        p {
            margin: 0;
        }

        .report-header {
            border-bottom: 2px solid #111827;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }

        .company-name {
            font-size: 17px;
            font-weight: bold;
            color: #111827;
        }

        .report-title {
            margin-top: 3px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: .8px;
        }

        .report-period {
            margin-top: 4px;
            font-size: 8px;
            color: #6b7280;
        }

        .section {
            margin-bottom: 18px;
        }

        .section-title {
            font-size: 10px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 7px;
            padding-bottom: 4px;
            border-bottom: 1px solid #d1d5db;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-table td {
            width: 25%;
            padding: 8px;
            border: 1px solid #e5e7eb;
            vertical-align: top;
        }

        .stat-label {
            display: block;
            color: #6b7280;
            font-size: 7px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .stat-value {
            display: block;
            margin-top: 3px;
            font-size: 12px;
            font-weight: bold;
            color: #111827;
        }

        .filters-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }

        .filters-table td {
            padding: 4px 6px;
            border: 1px solid #e5e7eb;
        }

        .filter-label {
            width: 12%;
            font-weight: bold;
            color: #6b7280;
            background: #f9fafb;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .report-table th {
            padding: 5px 4px;
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            color: #374151;
            font-size: 7px;
            font-weight: bold;
            text-align: left;
        }

        .report-table td {
            padding: 5px 4px;
            border: 1px solid #e5e7eb;
            font-size: 7px;
            vertical-align: top;
            word-wrap: break-word;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .muted {
            color: #6b7280;
        }

        .positive {
            color: #047857;
        }

        .negative {
            color: #b91c1c;
        }

        .page-break {
            page-break-before: always;
        }

        .no-break {
            page-break-inside: avoid;
        }

        .footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 7px;
            color: #9ca3af;
        }

        .small-note {
            margin-top: 5px;
            color: #6b7280;
            font-size: 7px;
        }
    </style>
</head>

<body>

    <div class="footer">
        EMNEX POS — Sales Report
    </div>

    {{-- ================================================================
        HEADER
    ================================================================= --}}

    <div class="report-header">
        <div class="company-name">
            {{ $company->name ?? 'EMNEX POS' }}
        </div>

        <div class="report-title">
            Sales Report
        </div>

        <div class="report-period">
            Reporting Period:
            {{ $filters['date_from'] ?? '—' }}
            to
            {{ $filters['date_to'] ?? '—' }}
        </div>
    </div>

    {{-- ================================================================
        APPLIED FILTERS
    ================================================================= --}}

    <div class="section">
        <div class="section-title">
            Applied Filters
        </div>

        <table class="filters-table">
            <tr>
                <td class="filter-label">Branch</td>
                <td>
                    {{ $filters['branch_id'] ?? 'All Branches' }}
                </td>

                <td class="filter-label">Salesperson</td>
                <td>
                    {{ $filters['cashier_id'] ?? 'All Salespersons' }}
                </td>
            </tr>

            <tr>
                <td class="filter-label">Payment</td>
                <td>
                    {{ $filters['payment_method'] ?? 'All Payments' }}
                </td>

                <td class="filter-label">Channel</td>
                <td>
                    {{ $filters['sales_channel'] ?? 'All Channels' }}
                </td>
            </tr>

            <tr>
                <td class="filter-label">Customer</td>
                <td>
                    {{ $filters['customer_id'] ?? 'All Customers' }}
                </td>

                <td class="filter-label">Category</td>
                <td>
                    {{ $filters['category_id'] ?? 'All Categories' }}
                </td>
            </tr>

            <tr>
                <td class="filter-label">Product</td>
                <td colspan="3">
                    {{ $filters['product_id'] ?? 'All Products' }}
                </td>
            </tr>
        </table>
    </div>

    {{-- ================================================================
        SUMMARY
    ================================================================= --}}

    <div class="section">
        <div class="section-title">
            Sales Summary
        </div>

        <table class="summary-table">
            <tr>
                <td>
                    <span class="stat-label">Gross Sales</span>
                    <span class="stat-value">
                        {{ number_format((float) ($report['stats']['gross_sales'] ?? 0), 2) }}
                    </span>
                </td>

                <td>
                    <span class="stat-label">Net Sales</span>
                    <span class="stat-value">
                        {{ number_format((float) ($report['stats']['net_sales'] ?? 0), 2) }}
                    </span>
                </td>

                <td>
                    <span class="stat-label">Transactions</span>
                    <span class="stat-value">
                        {{ number_format((int) ($report['stats']['transactions'] ?? 0)) }}
                    </span>
                </td>

                <td>
                    <span class="stat-label">Average Order</span>
                    <span class="stat-value">
                        {{ number_format((float) ($report['stats']['average_order'] ?? 0), 2) }}
                    </span>
                </td>
            </tr>

            <tr>
                <td>
                    <span class="stat-label">Discounts</span>
                    <span class="stat-value">
                        {{ number_format((float) ($report['stats']['discounts'] ?? 0), 2) }}
                    </span>
                </td>

                <td>
                    <span class="stat-label">Tax</span>
                    <span class="stat-value">
                        {{ number_format((float) ($report['stats']['tax'] ?? 0), 2) }}
                    </span>
                </td>

                <td>
                    <span class="stat-label">Returns</span>
                    <span class="stat-value">
                        {{ number_format((float) ($report['stats']['returns'] ?? 0), 2) }}
                    </span>
                </td>

                <td>
                    <span class="stat-label">Profit</span>
                    <span class="stat-value">
                        {{ number_format((float) ($report['stats']['profit'] ?? 0), 2) }}
                    </span>
                </td>
            </tr>
        </table>
    </div>

    {{-- ================================================================
        SALES TREND
    ================================================================= --}}

    <!-- <div class="section">
        <div class="section-title">
            Sales Trend
        </div>

        <table class="report-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th class="text-right">Transactions</th>
                    <th class="text-right">Sales</th>
                </tr>
            </thead>

            <tbody>
                @forelse (($report['charts']['trend'] ?? []) as $row)
                    <tr>
                        <td>
                            {{ $row['date'] ?? $row['label'] ?? '—' }}
                        </td>

                        <td class="text-right">
                            {{ number_format((int) ($row['transactions'] ?? $row['count'] ?? 0)) }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($row['sales'] ?? $row['total'] ?? 0), 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center muted">
                            No sales trend data available.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div> -->

    {{-- ================================================================
        PRODUCT PERFORMANCE
    ================================================================= --}}

    <div class="section page-break">
        <div class="section-title">
            Product Performance
        </div>

        <table class="report-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th class="text-right">Units Sold</th>
                    <th class="text-right">Revenue</th>
                    <th class="text-right">COGS</th>
                    <th class="text-right">Gross Profit</th>
                    <th class="text-right">Margin</th>
                </tr>
            </thead>

            <tbody>
                @forelse (($report['products'] ?? []) as $product)
                    <tr>
                        <td>
                            {{ $product['product_name'] ?? $product['name'] ?? '—' }}
                        </td>

                        <td>
                            {{ $product['category'] ?? $product['category_name'] ?? '—' }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($product['units_sold'] ?? 0)) }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($product['revenue'] ?? 0), 2) }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($product['cogs'] ?? 0), 2) }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($product['gross_profit'] ?? 0), 2) }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($product['margin'] ?? 0), 2) }}%
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center muted">
                            No product performance data available.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ================================================================
        CATEGORY PERFORMANCE
    ================================================================= --}}

    <div class="section">
        <div class="section-title">
            Category Performance
        </div>

        <table class="report-table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th class="text-right">Products</th>
                    <th class="text-right">Units Sold</th>
                    <th class="text-right">Orders</th>
                    <th class="text-right">Gross Sales</th>
                    <th class="text-right">Discount</th>
                    <th class="text-right">Net Sales</th>
                    <th class="text-right">% of Sales</th>
                </tr>
            </thead>

            <tbody>
                @forelse (($report['categories'] ?? []) as $category)
                    <tr>
                        <td>
                            {{ $category['category'] ?? $category['name'] ?? '—' }}
                        </td>

                        <td class="text-right">
                            {{ number_format((int) ($category['products'] ?? 0)) }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($category['units_sold'] ?? 0)) }}
                        </td>

                        <td class="text-right">
                            {{ number_format((int) ($category['orders'] ?? 0)) }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($category['gross_sales'] ?? 0), 2) }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($category['discount'] ?? 0), 2) }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($category['net_sales'] ?? 0), 2) }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($category['percentage'] ?? 0), 2) }}%
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center muted">
                            No category performance data available.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ================================================================
        PAYMENT PERFORMANCE
    ================================================================= --}}

    <div class="section">
        <div class="section-title">
            Payment Performance
        </div>

        <table class="report-table">
            <thead>
                <tr>
                    <th>Payment Method</th>
                    <th class="text-right">Transactions</th>
                    <th class="text-right">Amount</th>
                    <th class="text-right">% of Sales</th>
                </tr>
            </thead>

            <tbody>
                @forelse (($report['payments'] ?? []) as $payment)
                    <tr>
                        <td>
                            {{ $payment['payment_method'] ?? $payment['method'] ?? '—' }}
                        </td>

                        <td class="text-right">
                            {{ number_format((int) ($payment['transactions'] ?? 0)) }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($payment['amount'] ?? 0), 2) }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($payment['percentage'] ?? $payment['percent'] ?? 0), 2) }}%
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center muted">
                            No payment performance data available.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ================================================================
        SALESPERSON PERFORMANCE
    ================================================================= --}}

    <div class="section page-break">
        <div class="section-title">
            Salesperson Performance
        </div>

        <table class="report-table">
            <thead>
                <tr>
                    <th>Salesperson</th>
                    <th class="text-right">Transactions</th>
                    <th class="text-right">Quantity</th>
                    <th class="text-right">Average Sale</th>
                    <th class="text-right">Sales</th>
                    <th class="text-right">Share</th>
                </tr>
            </thead>

            <tbody>
                @forelse (($report['cashiers'] ?? []) as $cashier)
                    <tr>
                        <td>
                            {{ $cashier['cashier'] ?? $cashier['name'] ?? '—' }}
                        </td>

                        <td class="text-right">
                            {{ number_format((int) ($cashier['transactions'] ?? 0)) }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($cashier['quantity'] ?? 0)) }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($cashier['average_sale'] ?? $cashier['average_order'] ?? 0), 2) }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($cashier['sales'] ?? $cashier['total'] ?? 0), 2) }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($cashier['share'] ?? $cashier['percentage'] ?? 0), 2) }}%
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center muted">
                            No salesperson performance data available.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ================================================================
        CUSTOMER PERFORMANCE
    ================================================================= --}}

    <div class="section">
        <div class="section-title">
            Customer Performance
        </div>

        <table class="report-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th class="text-right">Transactions</th>
                    <th class="text-right">Items</th>
                    <th class="text-right">Sales</th>
                    <th class="text-right">Average Order</th>
                </tr>
            </thead>

            <tbody>
                @forelse (($report['customers'] ?? []) as $customer)
                    <tr>
                        <td>
                            {{ $customer['customer'] ?? $customer['name'] ?? $customer['customer_name'] ?? 'Walk-in Customer' }}
                        </td>

                        <td class="text-right">
                            {{ number_format((int) ($customer['transactions'] ?? 0)) }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($customer['quantity'] ?? $customer['items'] ?? 0)) }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($customer['total'] ?? $customer['sales'] ?? 0), 2) }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($customer['average_order'] ?? 0), 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center muted">
                            No customer performance data available.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ================================================================
        TRANSACTIONS
    ================================================================= --}}

    <div class="section page-break">
        <div class="section-title">
            Transactions
        </div>

        <table class="report-table">
            <thead>
                <tr>
                    <th>Order No.</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Salesperson</th>
                    <th>Branch</th>
                    <th>Payment</th>
                    <th class="text-right">Gross</th>
                    <th class="text-right">Discount</th>
                    <th class="text-right">Tax</th>
                    <th class="text-right">Total</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse (($report['transactions']['data'] ?? $report['transactions'] ?? []) as $transaction)
                    <tr>
                        <td>
                            {{ $transaction['order_no'] ?? '—' }}
                        </td>

                        <td>
                            {{ $transaction['date'] ?? $transaction['completed_at'] ?? '—' }}
                        </td>

                        <td>
                            {{ $transaction['customer'] ?? 'Walk-in Customer' }}
                        </td>

                        <td>
                            {{ $transaction['cashier'] ?? $transaction['salesperson'] ?? '—' }}
                        </td>

                        <td>
                            {{ $transaction['branch'] ?? '—' }}
                        </td>

                        <td>
                            {{ $transaction['payment'] ?? $transaction['payment_method'] ?? '—' }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($transaction['gross'] ?? $transaction['gross_sales'] ?? 0), 2) }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($transaction['discount'] ?? 0), 2) }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($transaction['tax'] ?? 0), 2) }}
                        </td>

                        <td class="text-right">
                            {{ number_format((float) ($transaction['total'] ?? 0), 2) }}
                        </td>

                        <td>
                            {{ $transaction['status'] ?? '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center muted">
                            No transactions available.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if (isset($report['transactions']['total']))
            <div class="small-note">
                Total transactions:
                {{ number_format((int) $report['transactions']['total']) }}
            </div>
        @endif
    </div>

</body>
</html>