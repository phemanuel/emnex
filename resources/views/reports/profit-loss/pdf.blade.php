<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Profit & Loss Report</title>

    <style>
        @page {
            margin: 28px 30px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #1f2937;
            background: #ffffff;
        }

        .header {
            width: 100%;
            border-bottom: 2px solid #1f2937;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-left {
            width: 70%;
            vertical-align: top;
        }

        .header-right {
            width: 30%;
            text-align: right;
            vertical-align: top;
        }

        .report-title {
            margin: 0 0 4px;
            font-size: 18px;
            font-weight: bold;
            color: #111827;
        }

        .company-name {
            margin: 0 0 4px;
            font-size: 11px;
            font-weight: bold;
        }

        .report-subtitle {
            margin: 0;
            color: #6b7280;
            font-size: 8px;
        }

        .generated {
            color: #6b7280;
            font-size: 8px;
            line-height: 1.5;
        }

        .meta {
            width: 100%;
            margin-bottom: 16px;
            border-collapse: collapse;
        }

        .meta td {
            padding: 5px 7px;
            border: 1px solid #e5e7eb;
        }

        .meta-label {
            width: 18%;
            font-weight: bold;
            background: #f8fafc;
            color: #374151;
        }

        .section {
            margin-bottom: 16px;
        }

        .section-title {
            margin: 0 0 7px;
            padding: 7px 9px;
            background: #f3f4f6;
            border-left: 3px solid #111827;
            font-size: 10px;
            font-weight: bold;
            color: #111827;
        }

        table.report-table {
            width: 100%;
            border-collapse: collapse;
        }

        .report-table th {
            padding: 6px 7px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            text-align: left;
            font-size: 8px;
            font-weight: bold;
            color: #374151;
        }

        .report-table td {
            padding: 6px 7px;
            border: 1px solid #e5e7eb;
            font-size: 8px;
        }

        .amount {
            text-align: right;
            white-space: nowrap;
        }

        .strong {
            font-weight: bold;
        }

        .positive {
            font-weight: bold;
        }

        .negative {
            font-weight: bold;
        }

        .summary-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 7px;
            margin: -7px;
            width: calc(100% + 14px);
        }

        .summary-card {
            width: 25%;
            border: 1px solid #e5e7eb;
            padding: 9px;
            vertical-align: top;
        }

        .summary-label {
            color: #6b7280;
            font-size: 7px;
            margin-bottom: 4px;
        }

        .summary-value {
            color: #111827;
            font-size: 12px;
            font-weight: bold;
        }

        .summary-note {
            margin-top: 2px;
            color: #6b7280;
            font-size: 7px;
        }

        .two-column {
            width: 100%;
            border-collapse: collapse;
        }

        .two-column > tbody > tr > td {
            width: 50%;
            vertical-align: top;
        }

        .two-column > tbody > tr > td:first-child {
            padding-right: 7px;
        }

        .two-column > tbody > tr > td:last-child {
            padding-left: 7px;
        }

        .footer {
            margin-top: 18px;
            padding-top: 8px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 7px;
            text-align: center;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>

@php
    $stats = $report['stats'] ?? [];
    $revenue = $report['revenue'] ?? [];
    $costOfGoods = $report['cost_of_goods'] ?? [];
    $expenses = $report['expenses'] ?? [];
    $profit = $report['profit'] ?? [];
    $breakdown = $report['breakdown'] ?? [];
    $financialPosition = $report['financial_position'] ?? [];

    $dateFrom = $filters['date_from']
        ?? $report['filters']['date_from']
        ?? null;

    $dateTo = $filters['date_to']
        ?? $report['filters']['date_to']
        ?? null;

    $branchId = $filters['branch_id']
        ?? $report['filters']['branch_id']
        ?? null;

    $money = function ($value) {
        return number_format((float) ($value ?? 0), 2);
    };

    $percentage = function ($value) {
        return number_format((float) ($value ?? 0), 2) . '%';
    };
@endphp

<div class="header">
    <table class="header-table">
        <tr>
            <td class="header-left">
                @if(!empty($company?->name))
                    <div class="company-name">
                        {{ $company->name }}
                    </div>
                @endif

                <h1 class="report-title">
                    Profit &amp; Loss Report
                </h1>

                <p class="report-subtitle">
                    Revenue, cost of goods, inventory losses and profitability analysis
                </p>
            </td>

            <td class="header-right">
                <div class="generated">
                    Generated<br>
                    {{ now()->format('d M Y H:i') }}
                </div>
            </td>
        </tr>
    </table>
</div>

<table class="meta">
    <tr>
        <td class="meta-label">Reporting Period</td>
        <td>
            {{ $dateFrom ?: '—' }}
            &nbsp; to &nbsp;
            {{ $dateTo ?: '—' }}
        </td>

        <td class="meta-label">Branch</td>
        <td>
            {{ $branchId ? 'Branch #' . $branchId : 'All Branches' }}
        </td>
    </tr>
</table>

{{-- Summary --}}
<div class="section">

    <div class="section-title">
        Financial Summary
    </div>

    <table class="summary-grid">
        <tr>
            <td class="summary-card">
                <div class="summary-label">NET REVENUE</div>
                <div class="summary-value">
                    {{ $money($stats['net_revenue'] ?? 0) }}
                </div>
            </td>

            <td class="summary-card">
                <div class="summary-label">NET COGS</div>
                <div class="summary-value">
                    {{ $money($stats['net_cogs'] ?? 0) }}
                </div>
            </td>

            <td class="summary-card">
                <div class="summary-label">GROSS PROFIT</div>
                <div class="summary-value">
                    {{ $money($stats['gross_profit'] ?? 0) }}
                </div>
            </td>

            <td class="summary-card">
                <div class="summary-label">OPERATING RESULT</div>
                <div class="summary-value">
                    {{ $money($stats['operating_result'] ?? 0) }}
                </div>
            </td>
        </tr>
    </table>

</div>

{{-- Revenue + Cost of Goods --}}
<table class="two-column">
    <tr>

        <td>
            <div class="section">

                <div class="section-title">
                    Revenue
                </div>

                <table class="report-table">
                    <thead>
                        <tr>
                            <th>Metric</th>
                            <th class="amount">Amount</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Gross Revenue</td>
                            <td class="amount">
                                {{ $money($revenue['gross_revenue'] ?? 0) }}
                            </td>
                        </tr>

                        <tr>
                            <td>Sales Returns</td>
                            <td class="amount">
                                {{ $money($revenue['sales_returns'] ?? 0) }}
                            </td>
                        </tr>

                        <tr class="strong">
                            <td>Net Revenue</td>
                            <td class="amount">
                                {{ $money($revenue['net_revenue'] ?? 0) }}
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </td>

        <td>
            <div class="section">

                <div class="section-title">
                    Cost of Goods
                </div>

                <table class="report-table">
                    <thead>
                        <tr>
                            <th>Metric</th>
                            <th class="amount">Amount</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Gross COGS</td>
                            <td class="amount">
                                {{ $money($costOfGoods['gross_cogs'] ?? 0) }}
                            </td>
                        </tr>

                        <tr>
                            <td>Returned COGS</td>
                            <td class="amount">
                                {{ $money($costOfGoods['returned_cogs'] ?? 0) }}
                            </td>
                        </tr>

                        <tr class="strong">
                            <td>Net COGS</td>
                            <td class="amount">
                                {{ $money($costOfGoods['net_cogs'] ?? 0) }}
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </td>

    </tr>
</table>

{{-- Inventory Losses + Profit --}}
<table class="two-column">
    <tr>

        <td>
            <div class="section">

                <div class="section-title">
                    Inventory Losses
                </div>

                <table class="report-table">
                    <thead>
                        <tr>
                            <th>Loss Type</th>
                            <th class="amount">Amount</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Damage Loss</td>
                            <td class="amount">
                                {{ $money($expenses['damage_loss'] ?? 0) }}
                            </td>
                        </tr>

                        <tr>
                            <td>Expired Loss</td>
                            <td class="amount">
                                {{ $money($expenses['expired_loss'] ?? 0) }}
                            </td>
                        </tr>

                        <tr class="strong">
                            <td>Total Inventory Loss</td>
                            <td class="amount">
                                {{ $money($expenses['total'] ?? 0) }}
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </td>

        <td>
            <div class="section">

                <div class="section-title">
                    Profitability
                </div>

                <table class="report-table">
                    <thead>
                        <tr>
                            <th>Metric</th>
                            <th class="amount">Amount</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Gross Profit</td>
                            <td class="amount">
                                {{ $money($profit['gross_profit'] ?? 0) }}
                            </td>
                        </tr>

                        <tr>
                            <td>Gross Margin</td>
                            <td class="amount">
                                {{ $percentage($profit['gross_margin'] ?? 0) }}
                            </td>
                        </tr>

                        <tr>
                            <td>Operating Result</td>
                            <td class="amount">
                                {{ $money($profit['operating_result'] ?? 0) }}
                            </td>
                        </tr>

                        <tr>
                            <td>Operating Margin</td>
                            <td class="amount">
                                {{ $percentage($profit['operating_margin'] ?? 0) }}
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </td>

    </tr>
</table>

{{-- Breakdown --}}
<div class="section page-break">

    <div class="section-title">
        Profit &amp; Loss Breakdown
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th>Metric</th>
                <th class="amount">Amount</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>Gross Revenue</td>
                <td class="amount">
                    {{ $money($breakdown['gross_revenue'] ?? 0) }}
                </td>
            </tr>

            <tr>
                <td>Sales Returns</td>
                <td class="amount">
                    {{ $money($breakdown['sales_returns'] ?? 0) }}
                </td>
            </tr>

            <tr class="strong">
                <td>Net Revenue</td>
                <td class="amount">
                    {{ $money($breakdown['net_revenue'] ?? 0) }}
                </td>
            </tr>

            <tr>
                <td>Gross COGS</td>
                <td class="amount">
                    {{ $money($breakdown['gross_cogs'] ?? 0) }}
                </td>
            </tr>

            <tr>
                <td>Returned COGS</td>
                <td class="amount">
                    {{ $money($breakdown['returned_cogs'] ?? 0) }}
                </td>
            </tr>

            <tr class="strong">
                <td>Net COGS</td>
                <td class="amount">
                    {{ $money($breakdown['net_cogs'] ?? 0) }}
                </td>
            </tr>

            <tr class="strong">
                <td>Gross Profit</td>
                <td class="amount">
                    {{ $money($breakdown['gross_profit'] ?? 0) }}
                </td>
            </tr>

            <tr>
                <td>Damage Loss</td>
                <td class="amount">
                    {{ $money($breakdown['damage_loss'] ?? 0) }}
                </td>
            </tr>

            <tr>
                <td>Expired Loss</td>
                <td class="amount">
                    {{ $money($breakdown['expired_loss'] ?? 0) }}
                </td>
            </tr>

            <tr>
                <td>Inventory Loss</td>
                <td class="amount">
                    {{ $money($breakdown['inventory_loss'] ?? 0) }}
                </td>
            </tr>

            <tr class="strong">
                <td>Operating Result</td>
                <td class="amount">
                    {{ $money($breakdown['operating_result'] ?? 0) }}
                </td>
            </tr>
        </tbody>
    </table>

</div>

{{-- Financial Position --}}
<div class="section">

    <div class="section-title">
        Financial Position
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th>Metric</th>
                <th class="amount">Amount</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>Net Revenue</td>
                <td class="amount">
                    {{ $money($financialPosition['net_revenue'] ?? 0) }}
                </td>
            </tr>

            <tr>
                <td>Net Cost of Goods Sold</td>
                <td class="amount">
                    {{ $money($financialPosition['net_cogs'] ?? 0) }}
                </td>
            </tr>

            <tr class="strong">
                <td>Gross Profit</td>
                <td class="amount">
                    {{ $money($financialPosition['gross_profit'] ?? 0) }}
                </td>
            </tr>

            <tr>
                <td>Inventory Loss</td>
                <td class="amount">
                    {{ $money($financialPosition['inventory_loss'] ?? 0) }}
                </td>
            </tr>

            <tr class="strong">
                <td>Operating Result</td>
                <td class="amount">
                    {{ $money($financialPosition['operating_result'] ?? 0) }}
                </td>
            </tr>

            <tr>
                <td>Gross Margin</td>
                <td class="amount">
                    {{ $percentage($financialPosition['gross_margin'] ?? 0) }}
                </td>
            </tr>

            <tr>
                <td>Operating Margin</td>
                <td class="amount">
                    {{ $percentage($financialPosition['operating_margin'] ?? 0) }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        This Financial Position section is a management summary derived from the
        EMNEX Profit &amp; Loss report. It is not a formal balance sheet.
    </div>

</div>

</body>
</html>

