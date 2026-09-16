<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Inventory Report</title>

    <style>
        @page {
            margin: 28px 24px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            font-size: 8px;
            color: #1f2937;
        }

        .report-header {
            margin-bottom: 20px;
        }

        .report-title {
            margin: 0 0 4px;
            font-size: 18px;
            font-weight: bold;
        }

        .report-subtitle {
            margin: 0;
            color: #6b7280;
            font-size: 9px;
        }

        .section {
            margin-top: 18px;
        }

        .section-title {
            margin: 0 0 7px;
            padding-bottom: 5px;
            border-bottom: 1px solid #d1d5db;
            font-size: 11px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        th {
            padding: 5px 4px;
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            font-size: 7px;
            font-weight: bold;
            text-align: left;
        }

        td {
            padding: 4px;
            border: 1px solid #e5e7eb;
            vertical-align: top;
            font-size: 7px;
        }

        .number {
            text-align: right;
        }

        .summary-table {
            width: 60%;
        }

        .summary-table th,
        .summary-table td {
            font-size: 8px;
        }

        .muted {
            color: #6b7280;
        }

        .page-break {
            page-break-before: always;
        }

        .avoid-break {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

    @php
        $stats = $report['stats'] ?? [];
        $products = $report['products'] ?? [];
        $categories = $report['categories'] ?? [];
        $movements = $report['movement_export_rows'] ?? [];
        $lowStock = $report['low_stock'] ?? [];
        $valuation = $report['valuation'] ?? [];

        $dateFrom = $filters['date_from'] ?? '—';
        $dateTo = $filters['date_to'] ?? '—';
    @endphp

    {{-- Header --}}
    <div class="report-header">
        <h1 class="report-title">
            Inventory Report
        </h1>

        <p class="report-subtitle">
            Reporting Period:
            {{ $dateFrom }}
            to
            {{ $dateTo }}
        </p>

        <p class="report-subtitle">
            Generated:
            {{ now()->format('Y-m-d H:i:s') }}
        </p>
    </div>

    {{-- Summary --}}
    <div class="section">
        <h2 class="section-title">
            Inventory Summary
        </h2>

        <table class="summary-table">
            <thead>
                <tr>
                    <th>Metric</th>
                    <th>Value</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>Total Stock Value</td>
                    <td class="number">
                        {{ number_format((float) ($stats['total_stock_value'] ?? 0), 2) }}
                    </td>
                </tr>

                <tr>
                    <td>Available Stock Value</td>
                    <td class="number">
                        {{ number_format((float) ($stats['available_stock_value'] ?? 0), 2) }}
                    </td>
                </tr>

                <tr>
                    <td>Retail Value</td>
                    <td class="number">
                        {{ number_format((float) ($stats['retail_value'] ?? 0), 2) }}
                    </td>
                </tr>

                <tr>
                    <td>Potential Profit</td>
                    <td class="number">
                        {{ number_format((float) ($stats['potential_profit'] ?? 0), 2) }}
                    </td>
                </tr>

                <tr>
                    <td>Total Products</td>
                    <td class="number">
                        {{ number_format((int) ($stats['total_products'] ?? 0)) }}
                    </td>
                </tr>

                <tr>
                    <td>Total Units</td>
                    <td class="number">
                        {{ number_format((float) ($stats['total_units'] ?? 0), 2) }}
                    </td>
                </tr>

                <tr>
                    <td>Low Stock</td>
                    <td class="number">
                        {{ number_format((int) ($stats['low_stock'] ?? 0)) }}
                    </td>
                </tr>

                <tr>
                    <td>Out of Stock</td>
                    <td class="number">
                        {{ number_format((int) ($stats['out_of_stock'] ?? 0)) }}
                    </td>
                </tr>

                <tr>
                    <td>Stock Movements</td>
                    <td class="number">
                        {{ number_format((int) ($stats['stock_movements'] ?? 0)) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Product Performance --}}
    <div class="section page-break">
        <h2 class="section-title">
            Product Performance
        </h2>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Code</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Branch</th>
                    <th>Qty</th>
                    <th>Available</th>
                    <th>Stock Value</th>
                    <th>Retail Value</th>
                    <th>Stock In</th>
                    <th>Stock Out</th>
                    <th>Net</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product['name'] ?? '—' }}</td>
                        <td>{{ $product['product_code'] ?? '—' }}</td>
                        <td>{{ $product['sku'] ?? '—' }}</td>
                        <td>{{ $product['category'] ?? '—' }}</td>
                        <td>{{ $product['branch_name'] ?? '—' }}</td>
                        <td class="number">
                            {{ number_format((float) ($product['quantity'] ?? 0), 2) }}
                        </td>
                        <td class="number">
                            {{ number_format((float) ($product['available_quantity'] ?? 0), 2) }}
                        </td>
                        <td class="number">
                            {{ number_format((float) ($product['stock_value'] ?? 0), 2) }}
                        </td>
                        <td class="number">
                            {{ number_format((float) ($product['retail_value'] ?? 0), 2) }}
                        </td>
                        <td class="number">
                            {{ number_format((float) ($product['stock_in'] ?? 0), 2) }}
                        </td>
                        <td class="number">
                            {{ number_format((float) ($product['stock_out'] ?? 0), 2) }}
                        </td>
                        <td class="number">
                            {{ number_format((float) ($product['net_movement'] ?? 0), 2) }}
                        </td>
                        <td>
                            {{ $product['stock_status'] ?? '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="13" class="muted">
                            No product data available.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Category Performance --}}
    <div class="section page-break">
        <h2 class="section-title">
            Category Performance
        </h2>

        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Products</th>
                    <th>Units</th>
                    <th>Stock Value</th>
                    <th>Retail Value</th>
                    <th>Stock In</th>
                    <th>Stock Out</th>
                    <th>Net Movement</th>
                </tr>
            </thead>

            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>
                            {{ $category['name'] ?? 'Uncategorized' }}
                        </td>

                        <td class="number">
                            {{ number_format((int) ($category['products'] ?? 0)) }}
                        </td>

                        <td class="number">
                            {{ number_format((float) ($category['units'] ?? 0), 2) }}
                        </td>

                        <td class="number">
                            {{ number_format((float) ($category['stock_value'] ?? 0), 2) }}
                        </td>

                        <td class="number">
                            {{ number_format((float) ($category['retail_value'] ?? 0), 2) }}
                        </td>

                        <td class="number">
                            {{ number_format((float) ($category['stock_in'] ?? 0), 2) }}
                        </td>

                        <td class="number">
                            {{ number_format((float) ($category['stock_out'] ?? 0), 2) }}
                        </td>

                        <td class="number">
                            {{ number_format((float) ($category['net_movement'] ?? 0), 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="muted">
                            No category data available.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Stock Movements --}}
    <div class="section page-break">
        <h2 class="section-title">
            Stock Movements
        </h2>

        <table>
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Movement</th>
                    <th>Direction</th>
                    <th>Product</th>
                    <th>Code</th>
                    <th>Category</th>
                    <th>Branch</th>
                    <th>Qty</th>
                    <th>Unit Cost</th>
                    <th>Before</th>
                    <th>After</th>
                    <th>Created By</th>
                </tr>
            </thead>

            <tbody>
                @forelse($movements as $movement)
                    <tr>
                        <td>{{ $movement['reference_no'] ?? '—' }}</td>
                        <td>{{ $movement['date'] ?? '—' }}</td>
                        <td>{{ $movement['time'] ?? '—' }}</td>
                        <td>
                            {{ $movement['movement_label']
                                ?? $movement['movement_type']
                                ?? '—' }}
                        </td>
                        <td>{{ $movement['direction'] ?? '—' }}</td>
                        <td>{{ $movement['product_name'] ?? '—' }}</td>
                        <td>{{ $movement['product_code'] ?? '—' }}</td>
                        <td>{{ $movement['category'] ?? '—' }}</td>
                        <td>{{ $movement['branch_name'] ?? '—' }}</td>
                        <td class="number">
                            {{ number_format((float) ($movement['quantity'] ?? 0), 2) }}
                        </td>
                        <td class="number">
                            {{ number_format((float) ($movement['unit_cost'] ?? 0), 2) }}
                        </td>
                        <td class="number">
                            {{ number_format((float) ($movement['stock_before'] ?? 0), 2) }}
                        </td>
                        <td class="number">
                            {{ number_format((float) ($movement['stock_after'] ?? 0), 2) }}
                        </td>
                        <td>{{ $movement['created_by'] ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="14" class="muted">
                            No stock movements available.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Low Stock --}}
    <div class="section page-break">
        <h2 class="section-title">
            Low Stock
        </h2>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Code</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Branch</th>
                    <th>Quantity</th>
                    <th>Available</th>
                    <th>Reorder Level</th>
                    <th>Maximum Stock</th>
                    <th>Shortage</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($lowStock as $row)
                    <tr>
                        <td>{{ $row['name'] ?? '—' }}</td>
                        <td>{{ $row['product_code'] ?? '—' }}</td>
                        <td>{{ $row['sku'] ?? '—' }}</td>
                        <td>{{ $row['category'] ?? '—' }}</td>
                        <td>{{ $row['branch_name'] ?? '—' }}</td>
                        <td class="number">
                            {{ number_format((float) ($row['quantity'] ?? 0), 2) }}
                        </td>
                        <td class="number">
                            {{ number_format((float) ($row['available_quantity'] ?? 0), 2) }}
                        </td>
                        <td class="number">
                            {{ number_format((float) ($row['reorder_level'] ?? 0), 2) }}
                        </td>
                        <td class="number">
                            {{ number_format((float) ($row['maximum_stock'] ?? 0), 2) }}
                        </td>
                        <td class="number">
                            {{ number_format((float) ($row['shortage'] ?? 0), 2) }}
                        </td>
                        <td>
                            {{ ($row['status'] ?? '') === 'out_of_stock'
                                ? 'Out of Stock'
                                : 'Low Stock' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="muted">
                            No low-stock products available.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Valuation --}}
    <div class="section page-break">
        <h2 class="section-title">
            Stock Valuation
        </h2>

        <table class="summary-table">
            <thead>
                <tr>
                    <th>Metric</th>
                    <th>Value</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>Cost Value</td>
                    <td class="number">
                        {{ number_format((float) ($valuation['cost_value'] ?? 0), 2) }}
                    </td>
                </tr>

                <tr>
                    <td>Retail Value</td>
                    <td class="number">
                        {{ number_format((float) ($valuation['retail_value'] ?? 0), 2) }}
                    </td>
                </tr>

                <tr>
                    <td>Potential Profit</td>
                    <td class="number">
                        {{ number_format((float) ($valuation['potential_profit'] ?? 0), 2) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <h3 class="section-title">
            Valuation by Branch
        </h3>

        <table>
            <thead>
                <tr>
                    <th>Branch</th>
                    <th>Units</th>
                    <th>Stock Value</th>
                    <th>Retail Value</th>
                    <th>Potential Profit</th>
                </tr>
            </thead>

            <tbody>
                @forelse(($valuation['branches'] ?? []) as $branch)
                    <tr>
                        <td>
                            {{ $branch['branch_name'] ?? '—' }}
                        </td>

                        <td class="number">
                            {{ number_format((float) ($branch['units'] ?? 0), 2) }}
                        </td>

                        <td class="number">
                            {{ number_format((float) ($branch['stock_value'] ?? 0), 2) }}
                        </td>

                        <td class="number">
                            {{ number_format((float) ($branch['retail_value'] ?? 0), 2) }}
                        </td>

                        <td class="number">
                            {{ number_format((float) ($branch['potential_profit'] ?? 0), 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="muted">
                            No branch valuation data available.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>
</html>

