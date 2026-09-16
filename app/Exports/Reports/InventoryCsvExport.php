<?php

namespace App\Exports\Reports;

use Illuminate\Support\Str;

class InventoryCsvExport
{
    protected array $report;

    protected array $filters;

    public function __construct(
        array $report,
        array $filters
    ) {
        $this->report = $report;
        $this->filters = $filters;
    }

    /**
     * |--------------------------------------------------------------------------
     * | Download
     * |--------------------------------------------------------------------------
     */
    public function download()
    {
        $filename =
            'inventory-report-'
            . now()->format('Y-m-d_H-i-s')
            . '.csv';

        return response()->streamDownload(
            function () {
                $handle = fopen('php://output', 'w');

                /*
                 * UTF-8 without BOM.
                 */
                $this->writeSummary($handle);

                $this->writeProducts($handle);

                $this->writeCategories($handle);

                $this->writeMovements($handle);

                $this->writeLowStock($handle);

                $this->writeValuation($handle);

                fclose($handle);
            },
            $filename,
            [
                'Content-Type' =>
                    'text/csv; charset=UTF-8',
                'Cache-Control' =>
                    'no-store, no-cache',
            ]
        );
    }

    /**
     * |--------------------------------------------------------------------------
     * | Summary
     * |--------------------------------------------------------------------------
     */
    protected function writeSummary($handle): void
    {
        $stats = $this->report['stats'] ?? [];

        $dateFrom =
            $this->filters['date_from']
            ?? '—';

        $dateTo =
            $this->filters['date_to']
            ?? '—';

        $this->section(
            $handle,
            'INVENTORY SUMMARY'
        );

        fputcsv(
            $handle,
            [
                'Reporting Period',
                $dateFrom . ' to ' . $dateTo,
            ]
        );

        fputcsv(
            $handle,
            [
                'Metric',
                'Value',
            ]
        );

        fputcsv(
            $handle,
            [
                'Total Stock Value',
                $stats['total_stock_value'] ?? 0,
            ]
        );

        fputcsv(
            $handle,
            [
                'Available Stock Value',
                $stats['available_stock_value'] ?? 0,
            ]
        );

        fputcsv(
            $handle,
            [
                'Retail Value',
                $stats['retail_value'] ?? 0,
            ]
        );

        fputcsv(
            $handle,
            [
                'Potential Profit',
                $stats['potential_profit'] ?? 0,
            ]
        );

        fputcsv(
            $handle,
            [
                'Total Products',
                $stats['total_products'] ?? 0,
            ]
        );

        fputcsv(
            $handle,
            [
                'Total Units',
                $stats['total_units'] ?? 0,
            ]
        );

        fputcsv(
            $handle,
            [
                'Low Stock',
                $stats['low_stock'] ?? 0,
            ]
        );

        fputcsv(
            $handle,
            [
                'Out of Stock',
                $stats['out_of_stock'] ?? 0,
            ]
        );

        fputcsv(
            $handle,
            [
                'Stock Movements',
                $stats['stock_movements'] ?? 0,
            ]
        );

        fputcsv($handle, []);
    }

    /**
     * |--------------------------------------------------------------------------
     * | Products
     * |--------------------------------------------------------------------------
     */
    protected function writeProducts($handle): void
    {
        $this->section(
            $handle,
            'PRODUCT PERFORMANCE'
        );

        fputcsv($handle, [
            'Product',
            'Product Code',
            'SKU',
            'Barcode',
            'Category',
            'Branch',
            'Quantity',
            'Reserved',
            'Available',
            'Reorder Level',
            'Maximum Stock',
            'Stock Value',
            'Retail Value',
            'Stock In',
            'Stock Out',
            'Net Movement',
            'Adjustments',
            'Transfers',
            'Status',
        ]);

        foreach (
            ($this->report['products'] ?? [])
            as $product
        ) {
            fputcsv($handle, [
                $product['name'] ?? '—',
                $product['product_code'] ?? '—',
                $product['sku'] ?? '—',
                $product['barcode'] ?? '—',
                $product['category'] ?? '—',
                $product['branch_name'] ?? '—',
                $product['quantity'] ?? 0,
                $product['reserved_quantity'] ?? 0,
                $product['available_quantity'] ?? 0,
                $product['reorder_level'] ?? 0,
                $product['maximum_stock'] ?? 0,
                $product['stock_value'] ?? 0,
                $product['retail_value'] ?? 0,
                $product['stock_in'] ?? 0,
                $product['stock_out'] ?? 0,
                $product['net_movement'] ?? 0,
                $product['adjustments'] ?? 0,
                $product['transfers'] ?? 0,
                $product['stock_status'] ?? '—',
            ]);
        }

        fputcsv($handle, []);
    }

    /**
     * |--------------------------------------------------------------------------
     * | Categories
     * |--------------------------------------------------------------------------
     */
    protected function writeCategories($handle): void
    {
        $this->section(
            $handle,
            'CATEGORY PERFORMANCE'
        );

        fputcsv($handle, [
            'Category',
            'Products',
            'Units',
            'Stock Value',
            'Retail Value',
            'Stock In',
            'Stock Out',
            'Net Movement',
        ]);

        foreach (
            ($this->report['categories'] ?? [])
            as $category
        ) {
            fputcsv($handle, [
                $category['name'] ?? 'Uncategorized',
                $category['products'] ?? 0,
                $category['units'] ?? 0,
                $category['stock_value'] ?? 0,
                $category['retail_value'] ?? 0,
                $category['stock_in'] ?? 0,
                $category['stock_out'] ?? 0,
                $category['net_movement'] ?? 0,
            ]);
        }

        fputcsv($handle, []);
    }

    /**
     * |--------------------------------------------------------------------------
     * | Movements
     * |--------------------------------------------------------------------------
     */
    protected function writeMovements($handle): void
    {
        $this->section(
            $handle,
            'STOCK MOVEMENTS'
        );

        fputcsv($handle, [
            'Reference',
            'Date',
            'Time',
            'Movement',
            'Direction',
            'Product',
            'Product Code',
            'SKU',
            'Category',
            'Branch',
            'Quantity',
            'Unit Cost',
            'Stock Before',
            'Stock After',
            'Remarks',
            'Created By',
        ]);

        foreach (
            ($this->report['movement_export_rows'] ?? [])
            as $movement
        ) {
            fputcsv($handle, [
                $movement['reference_no'] ?? '—',
                $movement['date'] ?? '—',
                $movement['time'] ?? '—',
                $movement['movement_label']
                    ?? $movement['movement_type']
                    ?? '—',
                $movement['direction'] ?? '—',
                $movement['product_name'] ?? '—',
                $movement['product_code'] ?? '—',
                $movement['sku'] ?? '—',
                $movement['category'] ?? '—',
                $movement['branch_name'] ?? '—',
                $movement['quantity'] ?? 0,
                $movement['unit_cost'] ?? 0,
                $movement['stock_before'] ?? 0,
                $movement['stock_after'] ?? 0,
                $movement['remarks'] ?? '—',
                $movement['created_by'] ?? '—',
            ]);
        }

        fputcsv($handle, []);
    }

    /**
     * |--------------------------------------------------------------------------
     * | Low Stock
     * |--------------------------------------------------------------------------
     */
    protected function writeLowStock($handle): void
    {
        $this->section(
            $handle,
            'LOW STOCK'
        );

        fputcsv($handle, [
            'Product',
            'Product Code',
            'SKU',
            'Category',
            'Branch',
            'Quantity',
            'Available',
            'Reorder Level',
            'Maximum Stock',
            'Shortage',
            'Status',
        ]);

        foreach (
            ($this->report['low_stock'] ?? [])
            as $row
        ) {
            fputcsv($handle, [
                $row['name'] ?? '—',
                $row['product_code'] ?? '—',
                $row['sku'] ?? '—',
                $row['category'] ?? '—',
                $row['branch_name'] ?? '—',
                $row['quantity'] ?? 0,
                $row['available_quantity'] ?? 0,
                $row['reorder_level'] ?? 0,
                $row['maximum_stock'] ?? 0,
                $row['shortage'] ?? 0,
                $row['status'] === 'out_of_stock'
                    ? 'Out of Stock'
                    : 'Low Stock',
            ]);
        }

        fputcsv($handle, []);
    }

    /**
     * |--------------------------------------------------------------------------
     * | Valuation
     * |--------------------------------------------------------------------------
     */
    protected function writeValuation($handle): void
    {
        $valuation =
            $this->report['valuation']
            ?? [];

        $this->section(
            $handle,
            'STOCK VALUATION'
        );

        fputcsv($handle, [
            'Metric',
            'Value',
        ]);

        fputcsv($handle, [
            'Cost Value',
            $valuation['cost_value'] ?? 0,
        ]);

        fputcsv($handle, [
            'Retail Value',
            $valuation['retail_value'] ?? 0,
        ]);

        fputcsv($handle, [
            'Potential Profit',
            $valuation['potential_profit'] ?? 0,
        ]);

        fputcsv($handle, []);

        fputcsv($handle, [
            'Branch',
            'Units',
            'Stock Value',
            'Retail Value',
            'Potential Profit',
        ]);

        foreach (
            ($valuation['branches'] ?? [])
            as $branch
        ) {
            fputcsv($handle, [
                $branch['branch_name'] ?? '—',
                $branch['units'] ?? 0,
                $branch['stock_value'] ?? 0,
                $branch['retail_value'] ?? 0,
                $branch['potential_profit'] ?? 0,
            ]);
        }
    }

    /**
     * |--------------------------------------------------------------------------
     * | Section
     * |--------------------------------------------------------------------------
     */
    protected function section(
        $handle,
        string $title
    ): void {
        fputcsv($handle, [$title]);
    }
}

