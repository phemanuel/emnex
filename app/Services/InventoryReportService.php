<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductStock;
use App\Models\StockMovement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class InventoryReportService
{   
    
    public function export(array $filters, $user)
    {
        $report = $this->generate(
            $filters,
            $user
        );

        $format = strtolower(
            trim(
                $filters['format'] ?? 'xlsx'
            )
        );

        return match ($format) {
            'xlsx' => \Maatwebsite\Excel\Facades\Excel::download(
                new \App\Exports\Reports\Inventory\InventoryReportExport(
                    $report,
                    $filters
                ),
                'inventory-report-'
                    . now()->format('Y-m-d_H-i-s')
                    . '.xlsx'
            ),

            'csv' => (
                new \App\Exports\Reports\Inventory\InventoryCsvExport(
                    $report,
                    $filters
                )
            )->download(),

            'pdf' => \Barryvdh\DomPDF\Facade\Pdf::loadView(
                'reports.inventory.pdf',
                [
                    'report' => $report,
                    'filters' => $filters,
                ]
            )
                ->setPaper('a4', 'landscape')
                ->download(
                    'inventory-report-'
                    . now()->format('Y-m-d_H-i-s')
                    . '.pdf'
                ),

            default => throw new \InvalidArgumentException(
                'Invalid export format.'
            ),
        };
    }



    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */

    public function getFilters(int $companyId, $user): array
    {
        $canManageAllBranches = canManageAllBranches();

        $branchesQuery = Branch::query()
            ->where('company_id', $companyId)
            ->where('status', true)
            ->orderBy('name');

        if (! $canManageAllBranches) {
            $branchesQuery->where('id', currentBranchId());
        }

        $branches = $branchesQuery
            ->get(['id', 'name'])
            ->map(fn ($branch) => [
                'id' => $branch->id,
                'name' => $branch->name,
            ])
            ->values();

        $products = Product::query()
            ->where('company_id', $companyId)
            ->where('status', true)
            ->orderBy('name')
            ->get([
                'id',
                'product_category_id',
                'product_code',
                'sku',
                'barcode',
                'name',
            ])
            ->map(fn ($product) => [
                'id' => $product->id,
                'category_id' => $product->product_category_id,
                'product_code' => $product->product_code,
                'sku' => $product->sku,
                'barcode' => $product->barcode,
                'name' => $product->name,
            ])
            ->values();

        $categories = ProductCategory::query()
            ->where('company_id', $companyId)
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn ($category) => [
                'id' => $category->id,
                'name' => $category->name,
            ])
            ->values();

        $movementTypes = collect([
            'Opening Stock',
            'Purchase',
            'Sale',
            'Return',
            'Adjustment',
            'Transfer',
            'Damage',
            'Expired',
        ])->map(fn ($type) => [
            'value' => $type,
            'label' => $this->movementLabel($type),
        ])->values();

        $stockStatuses = collect([
            'in_stock',
            'low_stock',
            'out_of_stock',
        ])->map(fn ($status) => [
            'value' => $status,
            'label' => match ($status) {
                'in_stock' => 'In Stock',
                'low_stock' => 'Low Stock',
                'out_of_stock' => 'Out of Stock',
            },
        ])->values();

        return [
            'branches' => $branches,
            'products' => $products,
            'categories' => $categories,
            'movement_types' => $movementTypes,
            'stock_statuses' => $stockStatuses,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Generate Report
    |--------------------------------------------------------------------------
    */

    public function generate(array $filters, $user): array
    {
        $companyId = (int) $filters['company_id'];

        $dateFrom = ! empty($filters['date_from'])
            ? \Carbon\Carbon::parse($filters['date_from'])->startOfDay()
            : now()->startOfMonth()->startOfDay();

        $dateTo = ! empty($filters['date_to'])
            ? \Carbon\Carbon::parse($filters['date_to'])->endOfDay()
            : now()->endOfDay();

        /*
        |--------------------------------------------------------------------------
        | Current Inventory
        |--------------------------------------------------------------------------
        |
        | ProductStock is intentionally NOT date filtered.
        | It represents the current physical inventory state.
        |
        */

        $stockQuery = $this->stockQuery(
            $companyId,
            $filters,
            $user
        );

        $stats = $this->buildStats(
            clone $stockQuery,
            $companyId,
            $filters,
            $user,
            $dateFrom,
            $dateTo
        );

        $products = $this->buildProductPerformance(
            clone $stockQuery,
            $companyId,
            $filters,
            $user,
            $dateFrom,
            $dateTo
        );

        $categories = $this->buildCategoryPerformance(
            clone $stockQuery,
            $companyId,
            $filters,
            $user,
            $dateFrom,
            $dateTo
        );

        $lowStock = $this->buildLowStock(
            clone $stockQuery
        );

        $valuation = $this->buildValuation(
            clone $stockQuery
        );

        /*
        |--------------------------------------------------------------------------
        | Historical Movements
        |--------------------------------------------------------------------------
        */

        $movementQuery = $this->movementQuery(
            $companyId,
            $filters,
            $user,
            $dateFrom,
            $dateTo
        );

        $movementSummary = $this->buildMovementSummary(
            clone $movementQuery
        );

        $trend = $this->buildMovementTrend(
            clone $movementQuery,
            $dateFrom,
            $dateTo
        );

        $movements = $this->buildMovements(
            clone $movementQuery,
            $filters
        );

        $movementExportRows = $this->buildMovementExportRows( 
            clone $movementQuery 
            );

        return [
            'filters' => [
                'date_from' => $dateFrom->toDateString(),
                'date_to' => $dateTo->toDateString(),
            ],

            'stats' => $stats,

            'charts' => [
                'trend' => $trend,
            ],

            'products' => $products,

            'categories' => $categories,

            'movements' => [
                'summary' => $movementSummary,
                'rows' => $movements,
            ],

            'movement_export_rows' => $movementExportRows,

            'low_stock' => $lowStock,

            'valuation' => $valuation,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Current Stock Query
    |--------------------------------------------------------------------------
    */

    protected function stockQuery(
        int $companyId,
        array $filters,
        $user
    ): Builder {
        $query = ProductStock::query()
            ->where('product_stocks.company_id', $companyId)
            ->with([
                'product:id,company_id,product_category_id,product_code,sku,barcode,name,cost_price,selling_price',
                'product.category:id,name',
                'branch:id,name',
            ]);

        if (! canManageAllBranches()) {
            $query->where(
                'product_stocks.branch_id',
                currentBranchId()
            );
        } elseif (! empty($filters['branch_id'])) {
            $query->where(
                'product_stocks.branch_id',
                (int) $filters['branch_id']
            );
        }

        if (! empty($filters['product_id'])) {
            $query->where(
                'product_stocks.product_id',
                (int) $filters['product_id']
            );
        }

        if (! empty($filters['category_id'])) {
            $query->whereHas('product', function (Builder $productQuery) use ($filters) {
                $productQuery->where(
                    'product_category_id',
                    (int) $filters['category_id']
                );
            });
        }

        if (! empty($filters['stock_status'])) {
            match ($filters['stock_status']) {
                'low_stock' => $query
                    ->whereColumn(
                        'product_stocks.quantity',
                        '<=',
                        'product_stocks.reorder_level'
                    )
                    ->where('product_stocks.quantity', '>', 0),

                'out_of_stock' => $query
                    ->where('product_stocks.quantity', '<=', 0),

                'in_stock' => $query
                    ->where('product_stocks.quantity', '>', 0)
                    ->where(function (Builder $statusQuery) {
                        $statusQuery
                            ->whereColumn(
                                'product_stocks.quantity',
                                '>',
                                'product_stocks.reorder_level'
                            )
                            ->orWhere('product_stocks.reorder_level', '<=', 0);
                    }),

                default => null,
            };
        }

        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | Movement Query
    |--------------------------------------------------------------------------
    */

    protected function movementQuery(
        int $companyId,
        array $filters,
        $user,
        $dateFrom,
        $dateTo
    ): Builder {
        $query = StockMovement::query()
            ->where('stock_movements.company_id', $companyId)
            ->whereBetween(
                'stock_movements.created_at',
                [$dateFrom, $dateTo]
            )
            ->with([
                'product:id,product_category_id,product_code,sku,barcode,name',
                'product.category:id,name',
                'branch:id,name',
                'createdBy:id,first_name,last_name',
            ]);

        if (! canManageAllBranches()) {
            $query->where(
                'stock_movements.branch_id',
                currentBranchId()
            );
        } elseif (! empty($filters['branch_id'])) {
            $query->where(
                'stock_movements.branch_id',
                (int) $filters['branch_id']
            );
        }

        if (! empty($filters['product_id'])) {
            $query->where(
                'stock_movements.product_id',
                (int) $filters['product_id']
            );
        }

        if (! empty($filters['category_id'])) {
            $query->whereHas('product', function (Builder $productQuery) use ($filters) {
                $productQuery->where(
                    'product_category_id',
                    (int) $filters['category_id']
                );
            });
        }

        if (! empty($filters['movement_type'])) {
            $query->where(
                'stock_movements.movement_type',
                $filters['movement_type']
            );
        }

        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | Statistics
    |--------------------------------------------------------------------------
    */

    protected function buildStats(
        Builder $stockQuery,
        int $companyId,
        array $filters,
        $user,
        $dateFrom,
        $dateTo
    ): array {
        $stockRows = $stockQuery->get();

        $totalStockValue = 0;
        $availableStockValue = 0;
        $retailValue = 0;
        $totalUnits = 0;
        $totalProducts = 0;
        $lowStock = 0;
        $outOfStock = 0;

        foreach ($stockRows as $stock) {
            $product = $stock->product;

            if (! $product) {
                continue;
            }

            $quantity = (float) $stock->quantity;
            $availableQuantity = (float) $stock->available_quantity;

            $costPrice = (float) $product->cost_price;
            $sellingPrice = (float) $product->selling_price;

            $totalStockValue += $quantity * $costPrice;
            $availableStockValue += $availableQuantity * $costPrice;
            $retailValue += $quantity * $sellingPrice;

            $totalUnits += $quantity;
            $totalProducts++;

            if ($quantity <= 0) {
                $outOfStock++;
            } elseif (
                $quantity <= (float) $stock->reorder_level
            ) {
                $lowStock++;
            }
        }

        $movementCount = $this->movementQuery(
            $companyId,
            $filters,
            $user,
            $dateFrom,
            $dateTo
        )->count();

        return [
            'total_stock_value' => round($totalStockValue, 2),
            'available_stock_value' => round($availableStockValue, 2),
            'retail_value' => round($retailValue, 2),
            'potential_profit' => round(
                $retailValue - $totalStockValue,
                2
            ),
            'total_products' => $totalProducts,
            'total_units' => round($totalUnits, 2),
            'low_stock' => $lowStock,
            'out_of_stock' => $outOfStock,
            'stock_movements' => $movementCount,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Product Performance
    |--------------------------------------------------------------------------
    */

    protected function buildProductPerformance(
        Builder $stockQuery,
        int $companyId,
        array $filters,
        $user,
        $dateFrom,
        $dateTo
    ): array {
        $stocks = $stockQuery->get();

        $movementQuery = $this->movementQuery(
            $companyId,
            $filters,
            $user,
            $dateFrom,
            $dateTo
        );

        $movements = $movementQuery
            ->get([
                'product_id',
                'movement_type',
                'quantity',
            ])
            ->groupBy('product_id');

        return $stocks
            ->map(function ($stock) use ($movements) {
                $product = $stock->product;

                if (! $product) {
                    return null;
                }

                $productMovements = $movements->get(
                    $stock->product_id,
                    collect()
                );

                $stockIn = 0;
                $stockOut = 0;
                $adjustments = 0;
                $transfers = 0;

                foreach ($productMovements as $movement) {
                    $quantity = (float) $movement->quantity;

                    if ($this->isStockInType($movement->movement_type)) {
                        $stockIn += $quantity;
                    } elseif ($this->isStockOutType($movement->movement_type)) {
                        $stockOut += $quantity;
                    } elseif ($movement->movement_type === 'Adjustment') {
                        $adjustments += $quantity;
                    } elseif ($movement->movement_type === 'Transfer') {
                        $transfers += $quantity;
                    }
                }

                $quantity = (float) $stock->quantity;
                $costPrice = (float) $product->cost_price;
                $sellingPrice = (float) $product->selling_price;

                return [
                    'id' => $product->id,
                    'product_code' => $product->product_code,
                    'sku' => $product->sku,
                    'barcode' => $product->barcode,
                    'name' => $product->name,

                    'category' => $product->category?->name,

                    'branch_id' => $stock->branch_id,
                    'branch_name' => $stock->branch?->name,

                    'quantity' => round($quantity, 2),
                    'reserved_quantity' => round(
                        (float) $stock->reserved_quantity,
                        2
                    ),
                    'available_quantity' => round(
                        (float) $stock->available_quantity,
                        2
                    ),

                    'reorder_level' => round(
                        (float) $stock->reorder_level,
                        2
                    ),

                    'maximum_stock' => round(
                        (float) $stock->maximum_stock,
                        2
                    ),

                    'stock_value' => round(
                        $quantity * $costPrice,
                        2
                    ),

                    'retail_value' => round(
                        $quantity * $sellingPrice,
                        2
                    ),

                    'stock_in' => round($stockIn, 2),
                    'stock_out' => round($stockOut, 2),
                    'net_movement' => round(
                        $stockIn - $stockOut,
                        2
                    ),

                    'adjustments' => round($adjustments, 2),
                    'transfers' => round($transfers, 2),

                    'stock_status' => $this->stockStatus(
                        $stock
                    ),
                ];
            })
            ->filter()
            ->sortByDesc('stock_value')
            ->values()
            ->all();
    }

    /*
    |--------------------------------------------------------------------------
    | Category Performance
    |--------------------------------------------------------------------------
    */

    protected function buildCategoryPerformance(
        Builder $stockQuery,
        int $companyId,
        array $filters,
        $user,
        $dateFrom,
        $dateTo
    ): array {
        $stocks = $stockQuery
            ->with([
                'product.category:id,name',
            ])
            ->get();

        $movementQuery = $this->movementQuery(
            $companyId,
            $filters,
            $user,
            $dateFrom,
            $dateTo
        );

        $movements = $movementQuery
            ->with('product:id,product_category_id')
            ->get([
                'product_id',
                'movement_type',
                'quantity',
            ])
            ->groupBy(function ($movement) {
                return $movement->product?->product_category_id;
            });

        return $stocks
            ->groupBy(function ($stock) {
                return $stock->product?->product_category_id ?? 0;
            })
            ->map(function (Collection $categoryStocks, $categoryId) use ($movements) {
                $category = $categoryStocks
                    ->first()
                    ?->product
                    ?->category;

                $stockValue = 0;
                $retailValue = 0;
                $units = 0;
                $products = 0;

                foreach ($categoryStocks as $stock) {
                    $product = $stock->product;

                    if (! $product) {
                        continue;
                    }

                    $quantity = (float) $stock->quantity;

                    $stockValue +=
                        $quantity * (float) $product->cost_price;

                    $retailValue +=
                        $quantity * (float) $product->selling_price;

                    $units += $quantity;
                    $products++;
                }

                $stockIn = 0;
                $stockOut = 0;

                foreach (
                    $movements->get($categoryId, collect())
                    as $movement
                ) {
                    $quantity = (float) $movement->quantity;

                    if ($this->isStockInType($movement->movement_type)) {
                        $stockIn += $quantity;
                    } elseif ($this->isStockOutType($movement->movement_type)) {
                        $stockOut += $quantity;
                    }
                }

                return [
                    'id' => $categoryId ?: null,
                    'name' => $category?->name ?? 'Uncategorized',

                    'products' => $products,
                    'units' => round($units, 2),

                    'stock_value' => round($stockValue, 2),
                    'retail_value' => round($retailValue, 2),

                    'stock_in' => round($stockIn, 2),
                    'stock_out' => round($stockOut, 2),
                    'net_movement' => round(
                        $stockIn - $stockOut,
                        2
                    ),
                ];
            })
            ->sortByDesc('stock_value')
            ->values()
            ->all();
    }

    /*
    |--------------------------------------------------------------------------
    | Low Stock
    |--------------------------------------------------------------------------
    */

    protected function buildLowStock(
        Builder $stockQuery
    ): array {
        return $stockQuery
            ->where(function (Builder $query) {
                $query
                    ->where('product_stocks.quantity', '<=', 0)
                    ->orWhere(function (Builder $lowQuery) {
                        $lowQuery
                            ->where('product_stocks.quantity', '>', 0)
                            ->whereColumn(
                                'product_stocks.quantity',
                                '<=',
                                'product_stocks.reorder_level'
                            );
                    });
            })
            ->get()
            ->map(function ($stock) {
                $product = $stock->product;

                if (! $product) {
                    return null;
                }

                $quantity = (float) $stock->quantity;
                $reorderLevel = (float) $stock->reorder_level;

                return [
                    'id' => $product->id,
                    'product_code' => $product->product_code,
                    'sku' => $product->sku,
                    'name' => $product->name,
                    'category' => $product->category?->name,

                    'branch_id' => $stock->branch_id,
                    'branch_name' => $stock->branch?->name,

                    'quantity' => round($quantity, 2),
                    'available_quantity' => round(
                        (float) $stock->available_quantity,
                        2
                    ),

                    'reorder_level' => round(
                        $reorderLevel,
                        2
                    ),

                    'maximum_stock' => round(
                        (float) $stock->maximum_stock,
                        2
                    ),

                    'shortage' => round(
                        max($reorderLevel - $quantity, 0),
                        2
                    ),

                    'status' => $quantity <= 0
                        ? 'out_of_stock'
                        : 'low_stock',
                ];
            })
            ->filter()
            ->sortBy([
                ['status', 'desc'],
                ['quantity', 'asc'],
            ])
            ->values()
            ->all();
    }

    /*
    |--------------------------------------------------------------------------
    | Valuation
    |--------------------------------------------------------------------------
    */

    protected function buildValuation(
        Builder $stockQuery
    ): array {
        $rows = $stockQuery->get();

        $costValue = 0;
        $retailValue = 0;

        $byBranch = [];

        foreach ($rows as $stock) {
            $product = $stock->product;

            if (! $product) {
                continue;
            }

            $quantity = (float) $stock->quantity;

            $stockCost =
                $quantity * (float) $product->cost_price;

            $stockRetail =
                $quantity * (float) $product->selling_price;

            $costValue += $stockCost;
            $retailValue += $stockRetail;

            $branchId = $stock->branch_id;

            if (! isset($byBranch[$branchId])) {
                $byBranch[$branchId] = [
                    'branch_id' => $branchId,
                    'branch_name' => $stock->branch?->name,
                    'units' => 0,
                    'stock_value' => 0,
                    'retail_value' => 0,
                ];
            }

            $byBranch[$branchId]['units'] += $quantity;
            $byBranch[$branchId]['stock_value'] += $stockCost;
            $byBranch[$branchId]['retail_value'] += $stockRetail;
        }

        $branches = collect($byBranch)
            ->map(function ($branch) {
                return [
                    'branch_id' => $branch['branch_id'],
                    'branch_name' => $branch['branch_name'],
                    'units' => round($branch['units'], 2),
                    'stock_value' => round(
                        $branch['stock_value'],
                        2
                    ),
                    'retail_value' => round(
                        $branch['retail_value'],
                        2
                    ),
                    'potential_profit' => round(
                        $branch['retail_value']
                        - $branch['stock_value'],
                        2
                    ),
                ];
            })
            ->sortByDesc('stock_value')
            ->values()
            ->all();

        return [
            'cost_value' => round($costValue, 2),
            'retail_value' => round($retailValue, 2),
            'potential_profit' => round(
                $retailValue - $costValue,
                2
            ),
            'branches' => $branches,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Movement Summary
    |--------------------------------------------------------------------------
    */

    protected function buildMovementSummary(
        Builder $movementQuery
    ): array {
        $movements = $movementQuery->get([
            'movement_type',
            'quantity',
        ]);

        $stockIn = 0;
        $stockOut = 0;
        $adjustments = 0;
        $transfers = 0;

        foreach ($movements as $movement) {
            $quantity = (float) $movement->quantity;

            if ($this->isStockInType($movement->movement_type)) {
                $stockIn += $quantity;
            } elseif ($this->isStockOutType($movement->movement_type)) {
                $stockOut += $quantity;
            } elseif ($movement->movement_type === 'Adjustment') {
                $adjustments += $quantity;
            } elseif ($movement->movement_type === 'Transfer') {
                $transfers += $quantity;
            }
        }

        return [
            'stock_in' => round($stockIn, 2),
            'stock_out' => round($stockOut, 2),
            'net_movement' => round(
                $stockIn - $stockOut,
                2
            ),
            'adjustments' => round($adjustments, 2),
            'transfers' => round($transfers, 2),
            'total_movements' => $movements->count(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Movement Trend
    |--------------------------------------------------------------------------
    */

    protected function buildMovementTrend(
        Builder $movementQuery,
        $dateFrom,
        $dateTo
    ): array {
        $movements = $movementQuery
            ->get([
                'movement_type',
                'quantity',
                'created_at',
            ]);

        return $movements
            ->groupBy(function ($movement) {
                return $movement->created_at->format('Y-m-d');
            })
            ->sortKeys()
            ->map(function (Collection $dayMovements, $date) {
                $stockIn = 0;
                $stockOut = 0;
                $adjustments = 0;
                $transfers = 0;

                foreach ($dayMovements as $movement) {
                    $quantity = (float) $movement->quantity;

                    if ($this->isStockInType($movement->movement_type)) {
                        $stockIn += $quantity;
                    } elseif ($this->isStockOutType($movement->movement_type)) {
                        $stockOut += $quantity;
                    } elseif ($movement->movement_type === 'Adjustment') {
                        $adjustments += $quantity;
                    } elseif ($movement->movement_type === 'Transfer') {
                        $transfers += $quantity;
                    }
                }

                return [
                    'date' => $date,
                    'stock_in' => round($stockIn, 2),
                    'stock_out' => round($stockOut, 2),
                    'net_movement' => round(
                        $stockIn - $stockOut,
                        2
                    ),
                    'adjustments' => round($adjustments, 2),
                    'transfers' => round($transfers, 2),
                ];
            })
            ->values()
            ->all();
    }

    /*
    |--------------------------------------------------------------------------
    | Movement Rows
    |--------------------------------------------------------------------------
    */

    protected function buildMovements(
        Builder $movementQuery,
        array $filters
    ): array {
        $perPage = min(
            max((int) ($filters['per_page'] ?? 10), 1),
            100
        );

        $paginator = $movementQuery
            ->latest('created_at')
            ->paginate(
                $perPage,
                ['*'],
                'page',
                (int) ($filters['page'] ?? 1)
            );

        $rows = $paginator->getCollection()
            ->map(function ($movement) {
                $product = $movement->product;

                $user = $movement->createdBy;

                return [
                    'id' => $movement->id,

                    'reference_no' => $movement->reference_no,

                    'date' => optional(
                        $movement->created_at
                    )->format('Y-m-d'),

                    'time' => optional(
                        $movement->created_at
                    )->format('H:i'),

                    'movement_type' => $movement->movement_type,

                    'movement_label' => $this->movementLabel(
                        $movement->movement_type
                    ),

                    'direction' => $this->movementDirection(
                        $movement->movement_type
                    ),

                    'product_id' => $movement->product_id,

                    'product_name' => $product?->name,

                    'product_code' => $product?->product_code,

                    'sku' => $product?->sku,

                    'category' => $product?->category?->name,

                    'branch_id' => $movement->branch_id,

                    'branch_name' => $movement->branch?->name,

                    'quantity' => round(
                        (float) $movement->quantity,
                        2
                    ),

                    'unit_cost' => round(
                        (float) $movement->unit_cost,
                        2
                    ),

                    'stock_before' => round(
                        (float) $movement->stock_before,
                        2
                    ),

                    'stock_after' => round(
                        (float) $movement->balance_after,
                        2
                    ),

                    'remarks' => $movement->remarks,

                    'created_by' => $user
                        ? trim(
                            $user->last_name
                            . ' '
                            . $user->first_name
                        )
                        : null,
                ];
            })
            ->values();

        return [
            'data' => $rows->all(),

            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
            ],
        ];
    }
   
    /**
     * |--------------------------------------------------------------------------
     * | Movement Export Rows
     * |--------------------------------------------------------------------------
     */
    protected function buildMovementExportRows(
        Builder $movementQuery
    ): array {
        return $movementQuery
            ->latest('created_at')
            ->get()
            ->map(function ($movement) {
                $product = $movement->product;
                $user = $movement->createdBy;

                return [
                    'id' => $movement->id,

                    'reference_no' => $movement->reference_no,

                    'date' => optional(
                        $movement->created_at
                    )->format('Y-m-d'),

                    'time' => optional(
                        $movement->created_at
                    )->format('H:i'),

                    'movement_type' => $movement->movement_type,

                    'movement_label' => $this->movementLabel(
                        $movement->movement_type
                    ),

                    'direction' => $this->movementDirection(
                        $movement->movement_type
                    ),

                    'product_id' => $movement->product_id,

                    'product_name' => $product?->name,

                    'product_code' => $product?->product_code,

                    'sku' => $product?->sku,

                    'category' => $product?->category?->name,

                    'branch_id' => $movement->branch_id,

                    'branch_name' => $movement->branch?->name,

                    'quantity' => round(
                        (float) $movement->quantity,
                        2
                    ),

                    'unit_cost' => round(
                        (float) $movement->unit_cost,
                        2
                    ),

                    'stock_before' => round(
                        (float) $movement->stock_before,
                        2
                    ),

                    'stock_after' => round(
                        (float) $movement->balance_after,
                        2
                    ),

                    'remarks' => $movement->remarks,

                    'created_by' => $user
                        ? trim(
                            $user->last_name
                            . ' '
                            . $user->first_name
                        )
                        : null,
                ];
            })
            ->values()
            ->all();
    }



    /*
    |--------------------------------------------------------------------------
    | Stock Status
    |--------------------------------------------------------------------------
    */

    protected function stockStatus(ProductStock $stock): string
    {
        $quantity = (float) $stock->quantity;
        $reorderLevel = (float) $stock->reorder_level;

        if ($quantity <= 0) {
            return 'out_of_stock';
        }

        if ($quantity <= $reorderLevel) {
            return 'low_stock';
        }

        return 'in_stock';
    }

    /*
    |--------------------------------------------------------------------------
    | Movement Direction
    |--------------------------------------------------------------------------
    */

    protected function movementDirection(?string $type): string
    {
        if ($this->isStockInType($type)) {
            return 'in';
        }

        if ($this->isStockOutType($type)) {
            return 'out';
        }

        if ($type === 'Adjustment') {
            return 'adjustment';
        }

        if ($type === 'Transfer') {
            return 'transfer';
        }

        return 'other';
    }

    /*
    |--------------------------------------------------------------------------
    | Movement Type Helpers
    |--------------------------------------------------------------------------
    */

    protected function isStockInType(?string $type): bool
    {
        return in_array($type, [
            'Opening Stock',
            'Purchase',
            'Return',
        ], true);
    }

    protected function isStockOutType(?string $type): bool
    {
        return in_array($type, [
            'Sale',
            'Damage',
            'Expired',
        ], true);
    }

    /*
    |--------------------------------------------------------------------------
    | Movement Labels
    |--------------------------------------------------------------------------
    */

    protected function movementLabel(?string $type): string
    {
        return match ($type) {
            'Opening Stock' => 'Opening Stock',
            'Purchase' => 'Purchase',
            'Sale' => 'Sale',
            'Return' => 'Return',
            'Adjustment' => 'Stock Adjustment',
            'Transfer' => 'Stock Transfer',
            'Damage' => 'Damaged Stock',
            'Expired' => 'Expired Stock',
            default => $type ?: 'Unknown',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Export
    |--------------------------------------------------------------------------
    */

    
}