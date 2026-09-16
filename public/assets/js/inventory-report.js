/* ==========================================================================
   EMNEX Inventory Report
   ========================================================================== */

window.InventoryReport = {

    state: {
        filters: {},
        report: null,
        currentPage: 1,
        perPage: 10,
        movementTrendChart: null,
        initialized: false
    },

    elements: {},

    /*
    |--------------------------------------------------------------------------
    | Init
    |--------------------------------------------------------------------------
    */

    init() {
        if (this.state.initialized) {
            return;
        }

        this.cacheElements();
        this.bindEvents();
        this.initializeContext();

        this.state.initialized = true;

        this.loadReport();
    },

    /*
    |--------------------------------------------------------------------------
    | Cache Elements
    |--------------------------------------------------------------------------
    */

    cacheElements() {
        this.elements = {

            page: document.getElementById('inventoryReportPage'),
            content: document.getElementById('inventoryReportContent'),

            loading: document.getElementById('inventoryReportLoading'),
            empty: document.getElementById('inventoryReportEmpty'),
            error: document.getElementById('inventoryReportError'),
            errorMessage: document.getElementById('inventoryReportErrorMessage'),

            dateFrom: document.getElementById('inventoryDateFrom'),
            dateTo: document.getElementById('inventoryDateTo'),
            datePreset: document.getElementById('inventoryDatePreset'),

            branch: document.getElementById('inventoryBranch'),
            product: document.getElementById('inventoryProduct'),
            category: document.getElementById('inventoryCategory'),
            movementType: document.getElementById('inventoryMovementType'),
            stockStatus: document.getElementById('inventoryStockStatus'),

            applyBtn: document.getElementById('inventoryApplyBtn'),
            resetBtn: document.getElementById('inventoryResetBtn'),
            emptyReset: document.getElementById('inventoryEmptyReset'),
            retryBtn: document.getElementById('inventoryRetryBtn'),
            exportBtn: document.getElementById('inventoryExportBtn'),

            filterSummary: document.getElementById('inventoryFilterSummary'),

            statStockValue: document.getElementById('inventoryStatStockValue'),
            statAvailableValue: document.getElementById('inventoryStatAvailableValue'),
            statRetailValue: document.getElementById('inventoryStatRetailValue'),
            statProducts: document.getElementById('inventoryStatProducts'),
            statUnits: document.getElementById('inventoryStatUnits'),
            statLowStock: document.getElementById('inventoryStatLowStock'),
            statOutOfStock: document.getElementById('inventoryStatOutOfStock'),
            statMovements: document.getElementById('inventoryStatMovements'),

            movementTrendChart: document.getElementById('inventoryMovementTrendChart'),
            trendEmpty: document.getElementById('inventoryTrendEmpty'),

            productsTable: document.getElementById('inventoryProductsTableBody'),
            categoriesTable: document.getElementById('inventoryCategoriesTableBody'),
            movementsTable: document.getElementById('inventoryMovementsTableBody'),
            lowStockTable: document.getElementById('inventoryLowStockTableBody'),
            valuationTable: document.getElementById('inventoryValuationTableBody'),

            movementIn: document.getElementById('inventoryMovementIn'),
            movementOut: document.getElementById('inventoryMovementOut'),
            movementNet: document.getElementById('inventoryMovementNet'),

            movementsPagination: document.getElementById('inventoryMovementsPagination'),

            valuationCost: document.getElementById('inventoryValuationCost'),
            valuationRetail: document.getElementById('inventoryValuationRetail'),
            valuationProfit: document.getElementById('inventoryValuationProfit'),

            inspector: document.getElementById('inventoryMovementInspector'),
            inspectorReference: document.getElementById('inventoryInspectorReference'),
            inspectorDate: document.getElementById('inventoryInspectorDate'),
            inspectorProduct: document.getElementById('inventoryInspectorProduct'),
            inspectorBranch: document.getElementById('inventoryInspectorBranch'),
            inspectorType: document.getElementById('inventoryInspectorType'),
            inspectorDirection: document.getElementById('inventoryInspectorDirection'),
            inspectorQuantity: document.getElementById('inventoryInspectorQuantity'),
            inspectorUnitCost: document.getElementById('inventoryInspectorUnitCost'),
            inspectorBefore: document.getElementById('inventoryInspectorBefore'),
            inspectorAfter: document.getElementById('inventoryInspectorAfter'),
            inspectorCreatedBy: document.getElementById('inventoryInspectorCreatedBy'),
            inspectorRemarks: document.getElementById('inventoryInspectorRemarks')
        };
    },

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

    bindEvents() {

        this.elements.applyBtn?.addEventListener('click', () => {
            this.state.currentPage = 1;
            this.loadReport();
        });

        this.elements.resetBtn?.addEventListener('click', () => {
            this.resetFilters();
        });

        this.elements.emptyReset?.addEventListener('click', () => {
            this.resetFilters();
        });

        this.elements.retryBtn?.addEventListener('click', () => {
            this.loadReport();
        });

        document
        .querySelectorAll('[data-export-format]')
        .forEach((item) => {

            item.addEventListener('click', () => {

                const format =
                    item.dataset.exportFormat;

                this.exportReport(format);
            });

        });

        this.elements.datePreset?.addEventListener('change', () => {
            this.applyDatePreset();
        });

        this.elements.dateFrom?.addEventListener('change', () => {
            this.setCustomDateRange();
        });

        this.elements.dateTo?.addEventListener('change', () => {
            this.setCustomDateRange();
        });

        this.elements.category?.addEventListener('change', () => {
            this.filterProductsByCategory();
        });

        this.elements.movementsPagination?.addEventListener(
            'click',
            (event) => {
                const button = event.target.closest(
                    '[data-inventory-page]'
                );

                if (!button) {
                    return;
                }

                event.preventDefault();

                const page = parseInt(
                    button.dataset.inventoryPage,
                    10
                );

                if (!Number.isNaN(page)) {
                    this.state.currentPage = page;
                    this.loadReport();
                }
            }
        );

        this.elements.movementsTable?.addEventListener(
            'click',
            (event) => {
                const button = event.target.closest(
                    '[data-inventory-inspect]'
                );

                if (!button) {
                    return;
                }

                const index = parseInt(
                    button.dataset.inventoryInspect,
                    10
                );

                const movement =
                    this.state.report?.movements?.rows?.data?.[index];

                if (movement) {
                    this.openMovementInspector(movement);
                }
            }
        );
    },

    /*
    |--------------------------------------------------------------------------
    | Context
    |--------------------------------------------------------------------------
    */

    initializeContext() {
        this.setDefaultDates();
        this.filterProductsByCategory();
    },

    /*
    |--------------------------------------------------------------------------
    | Dates
    |--------------------------------------------------------------------------
    */

    setDefaultDates() {
        const now = new Date();

        const firstDay = new Date(
            now.getFullYear(),
            now.getMonth(),
            1
        );

        this.elements.dateFrom.value =
            this.formatDate(firstDay);

        this.elements.dateTo.value =
            this.formatDate(now);

        this.elements.datePreset.value = 'this_month';
    },

    applyDatePreset() {

        const preset = this.elements.datePreset.value;

        if (preset === 'custom') {
            return;
        }

        const today = new Date();

        let from;
        let to = today;

        switch (preset) {

            case 'this_month':
                from = new Date(
                    today.getFullYear(),
                    today.getMonth(),
                    1
                );
                break;

            case 'last_month':
                from = new Date(
                    today.getFullYear(),
                    today.getMonth() - 1,
                    1
                );

                to = new Date(
                    today.getFullYear(),
                    today.getMonth(),
                    0
                );
                break;

            case 'this_year':
                from = new Date(
                    today.getFullYear(),
                    0,
                    1
                );
                break;

            case 'last_30_days':
                from = new Date(today);
                from.setDate(
                    today.getDate() - 29
                );
                break;

            case 'last_90_days':
                from = new Date(today);
                from.setDate(
                    today.getDate() - 89
                );
                break;

            default:
                return;
        }

        this.elements.dateFrom.value =
            this.formatDate(from);

        this.elements.dateTo.value =
            this.formatDate(to);
    },

    setCustomDateRange() {
        this.elements.datePreset.value = 'custom';
    },

    formatDate(date) {
        const year = date.getFullYear();
        const month = String(
            date.getMonth() + 1
        ).padStart(2, '0');

        const day = String(
            date.getDate()
        ).padStart(2, '0');

        return `${year}-${month}-${day}`;
    },

    /*
    |--------------------------------------------------------------------------
    | Product / Category
    |--------------------------------------------------------------------------
    */

    filterProductsByCategory() {

        const categoryId =
            this.elements.category.value;

        Array.from(
            this.elements.product.options
        ).forEach((option, index) => {

            if (index === 0) {
                option.hidden = false;
                return;
            }

            const optionCategory =
                option.dataset.categoryId || '';

            option.hidden =
                Boolean(categoryId)
                && optionCategory !== categoryId;

            if (option.hidden && option.selected) {
                this.elements.product.value = '';
            }
        });
    },

    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */

    collectFilters() {

        return {
            date_from: this.elements.dateFrom.value,
            date_to: this.elements.dateTo.value,

            branch_id: this.elements.branch.value,
            product_id: this.elements.product.value,
            category_id: this.elements.category.value,

            movement_type:
                this.elements.movementType.value,

            stock_status:
                this.elements.stockStatus.value,

            page: this.state.currentPage,
            per_page: this.state.perPage
        };
    },

     /*
    |--------------------------------------------------------------------------
    | Load Report
    |--------------------------------------------------------------------------
    */

    async loadReport(page = 1) {

        this.showLoading();

        const filters = this.collectFilters();

        this.state.filters = filters;

        try {

            const params = new URLSearchParams();

            Object.entries(filters).forEach(
                ([key, value]) => {

                    if (
                        value !== null
                        && value !== undefined
                        && value !== ''
                    ) {
                        params.append(key, value);
                    }
                }
            );

            params.set('page', page);

            const response = await fetch(
                `${window.InventoryReportConfig.dataUrl}?${params.toString()}`,
                {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }
            );

            const result = await response.json();

            if (!response.ok || !result.success) {

                throw new Error(
                    result.message
                    || 'Unable to load inventory report.'
                );
            }

            this.state.report = result.data;

            this.renderReport();

        } catch (error) {

            console.error(
                'Inventory Report Error:',
                error
            );

            this.showError(
                error.message
                || 'Unable to load inventory report.'
            );
        }
    },
    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    renderReport() {

        const report = this.state.report;

        if (!report) {
            this.showEmpty();
            return;
        }

        this.hideStates();

        this.renderStats(report.stats || {});
        this.renderTrend(report.charts?.trend || []);
        this.renderProducts(report.products || []);
        this.renderCategories(report.categories || []);
        this.renderMovements(report.movements || {});
        this.renderLowStock(report.low_stock || []);
        this.renderValuation(report.valuation || {});

        this.updateFilterSummary();
    },

    /*
    |--------------------------------------------------------------------------
    | Stats
    |--------------------------------------------------------------------------
    */

    renderStats(stats) {

        this.setText(
            this.elements.statStockValue,
            this.formatCurrency(stats.total_stock_value)
        );

        this.setText(
            this.elements.statAvailableValue,
            this.formatCurrency(stats.available_stock_value)
        );

        this.setText(
            this.elements.statRetailValue,
            this.formatCurrency(stats.retail_value)
        );

        this.setText(
            this.elements.statProducts,
            this.formatNumber(stats.total_products)
        );

        this.setText(
            this.elements.statUnits,
            this.formatNumber(stats.total_units)
        );

        this.setText(
            this.elements.statLowStock,
            this.formatNumber(stats.low_stock)
        );

        this.setText(
            this.elements.statOutOfStock,
            this.formatNumber(stats.out_of_stock)
        );

        this.setText(
            this.elements.statMovements,
            this.formatNumber(stats.stock_movements)
        );
    },

    /*
    |--------------------------------------------------------------------------
    | Trend
    |--------------------------------------------------------------------------
    */

    renderTrend(data) {

        if (!this.elements.movementTrendChart) {
            return;
        }

        if (
            !Array.isArray(data)
            || data.length === 0
        ) {
            this.elements.movementTrendChart
                .classList.add('d-none');

            this.elements.trendEmpty
                ?.classList.remove('d-none');

            this.destroyTrendChart();

            return;
        }

        this.elements.movementTrendChart
            .classList.remove('d-none');

        this.elements.trendEmpty
            ?.classList.add('d-none');

        if (
            typeof Chart === 'undefined'
        ) {
            return;
        }

        this.destroyTrendChart();

        this.state.movementTrendChart =
            new Chart(
                this.elements.movementTrendChart,
                {
                    type: 'line',

                    data: {
                        labels: data.map(
                            row => this.formatChartDate(row.date)
                        ),

                        datasets: [
                            {
                                label: 'Stock In',
                                data: data.map(
                                    row => Number(row.stock_in || 0)
                                ),
                                tension: 0.35,
                                borderWidth: 2,
                                pointRadius: 2,
                                fill: false
                            },
                            {
                                label: 'Stock Out',
                                data: data.map(
                                    row => Number(row.stock_out || 0)
                                ),
                                tension: 0.35,
                                borderWidth: 2,
                                pointRadius: 2,
                                fill: false
                            }
                        ]
                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false,

                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },

                        plugins: {
                            legend: {
                                position: 'top',
                                align: 'end'
                            }
                        },

                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },

                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                }
            );
    },

    destroyTrendChart() {

        if (
            this.state.movementTrendChart
        ) {
            this.state.movementTrendChart.destroy();

            this.state.movementTrendChart = null;
        }
    },

    /*
    |--------------------------------------------------------------------------
    | Products
    |--------------------------------------------------------------------------
    */

    renderProducts(products) {

        if (!products.length) {

            this.elements.productsTable.innerHTML =
                this.placeholderRow(
                    10,
                    'No product data available.'
                );

            return;
        }

        this.elements.productsTable.innerHTML =
            products.map(product => {

                return `
                    <tr>
                        <td>
                            <div class="inventory-product-name">
                                ${this.escapeHtml(product.name || '—')}
                            </div>

                            <div class="inventory-product-meta">
                                ${this.escapeHtml(
                                    product.sku
                                    || product.product_code
                                    || ''
                                )}
                            </div>
                        </td>

                        <td>
                            ${this.escapeHtml(
                                product.category || 'Uncategorized'
                            )}
                        </td>

                        <td>
                            ${this.escapeHtml(
                                product.branch_name || '—'
                            )}
                        </td>

                        <td class="text-end">
                            ${this.formatNumber(product.quantity)}
                        </td>

                        <td class="text-end">
                            ${this.formatNumber(product.available_quantity)}
                        </td>

                        <td class="text-end">
                            ${this.formatNumber(product.stock_in)}
                        </td>

                        <td class="text-end">
                            ${this.formatNumber(product.stock_out)}
                        </td>

                        <td class="text-end">
                            ${this.formatCurrency(product.stock_value)}
                        </td>

                        <td>
                            ${this.statusBadge(
                                product.stock_status
                            )}
                        </td>

                        <td class="text-end">
                            <button
                                type="button"
                                class="btn btn-sm btn-light"
                                title="View product"
                                disabled
                            >
                                <i class="bi bi-arrow-up-right"></i>
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
    },

    /*
    |--------------------------------------------------------------------------
    | Categories
    |--------------------------------------------------------------------------
    */

    renderCategories(categories) {

        if (!categories.length) {

            this.elements.categoriesTable.innerHTML =
                this.placeholderRow(
                    8,
                    'No category data available.'
                );

            return;
        }

        this.elements.categoriesTable.innerHTML =
            categories.map(category => {

                return `
                    <tr>
                        <td>
                            <div class="inventory-product-name">
                                ${this.escapeHtml(
                                    category.name || 'Uncategorized'
                                )}
                            </div>
                        </td>

                        <td class="text-end">
                            ${this.formatNumber(
                                category.products
                            )}
                        </td>

                        <td class="text-end">
                            ${this.formatNumber(
                                category.units
                            )}
                        </td>

                        <td class="text-end">
                            ${this.formatNumber(
                                category.stock_in
                            )}
                        </td>

                        <td class="text-end">
                            ${this.formatNumber(
                                category.stock_out
                            )}
                        </td>

                        <td class="text-end">
                            ${this.formatNumber(
                                category.net_movement
                            )}
                        </td>

                        <td class="text-end">
                            ${this.formatCurrency(
                                category.stock_value
                            )}
                        </td>

                        <td class="text-end">
                            ${this.formatCurrency(
                                category.retail_value
                            )}
                        </td>
                    </tr>
                `;
            }).join('');
    },

    /**
     * |--------------------------------------------------------------------------
     * | Movements
     * |--------------------------------------------------------------------------
     */
    renderMovements(movements) {

        const rows =
            movements.rows?.data || [];

        const summary =
            movements.summary || {};

        this.setText(
            this.elements.movementIn,
            this.formatNumber(summary.stock_in)
        );

        this.setText(
            this.elements.movementOut,
            this.formatNumber(summary.stock_out)
        );

        this.setText(
            this.elements.movementNet,
            this.formatNumber(summary.net_movement)
        );

        if (!rows.length) {

            this.elements.movementsTable.innerHTML =
                this.placeholderRow(
                    11,
                    'No stock movements available.'
                );

            this.elements.movementsPagination.innerHTML = '';

            return;
        }

        this.elements.movementsTable.innerHTML =
            rows.map((movement, index) => {

                return `
                    <tr>

                        <td>
                            ${this.escapeHtml(
                                movement.date || '—'
                            )}

                            <div class="inventory-product-meta">
                                ${this.escapeHtml(
                                    movement.time || ''
                                )}
                            </div>
                        </td>

                        <td>
                            ${this.escapeHtml(
                                movement.reference_no || '—'
                            )}
                        </td>

                        <td>
                            <div class="inventory-product-name">
                                ${this.escapeHtml(
                                    movement.product_name || '—'
                                )}
                            </div>

                            <div class="inventory-product-meta">
                                ${this.escapeHtml(
                                    movement.sku ||
                                    movement.product_code ||
                                    ''
                                )}
                            </div>
                        </td>

                        <td>
                            ${this.escapeHtml(
                                movement.branch_name || '—'
                            )}
                        </td>

                        <td>
                            ${this.escapeHtml(
                                movement.movement_label ||
                                movement.movement_type ||
                                '—'
                            )}
                        </td>

                        <td>
                            ${this.directionBadge(
                                movement.direction
                            )}
                        </td>

                        <td class="text-end">
                            ${this.formatNumber(
                                movement.quantity
                            )}
                        </td>

                        <td class="text-end">
                            ${this.formatNumber(
                                movement.stock_before
                            )}
                        </td>

                        <td class="text-end">
                            ${this.formatNumber(
                                movement.stock_after
                            )}
                        </td>

                        <td>
                            ${this.escapeHtml(
                                movement.created_by || '—'
                            )}
                        </td>

                        <td class="text-end">
                            <button
                                type="button"
                                class="btn btn-sm btn-light"
                                data-inventory-inspect="${index}"
                                title="View movement"
                            >
                                <i class="bi bi-eye"></i>
                            </button>
                        </td>

                    </tr>
                `;

            }).join('');

        this.renderMovementPagination(
            movements.rows?.pagination || {}
        );
    },

     /*
    |--------------------------------------------------------------------------
    | Movement Pagination
    |--------------------------------------------------------------------------
    */

    renderMovementPagination(pagination) {

        if (
            !pagination
            || pagination.last_page <= 1
        ) {
            this.elements.movementsPagination.innerHTML = '';

            return;
        }

        let html = `
            <nav aria-label="Inventory movement pagination">
                <ul class="pagination pagination-sm mb-0">
        `;

        const current =
            Number(pagination.current_page || 1);

        const last =
            Number(pagination.last_page || 1);

        if (current > 1) {

            html += `
                <li class="page-item">
                    <a
                        href="#"
                        class="page-link"
                        data-inventory-page="${current - 1}"
                    >
                        Previous
                    </a>
                </li>
            `;
        }

        for (
            let page = 1;
            page <= last;
            page++
        ) {

            html += `
                <li class="page-item ${page === current ? 'active' : ''}">
                    <a
                        href="#"
                        class="page-link"
                        data-inventory-page="${page}"
                    >
                        ${page}
                    </a>
                </li>
            `;
        }

        if (current < last) {

            html += `
                <li class="page-item">
                    <a
                        href="#"
                        class="page-link"
                        data-inventory-page="${current + 1}"
                    >
                        Next
                    </a>
                </li>
            `;
        }

        html += `
                </ul>
            </nav>
        `;

        this.elements.movementsPagination.innerHTML = html;

        this.elements.movementsPagination
            .querySelectorAll('[data-inventory-page]')
            .forEach((link) => {

                link.addEventListener('click', (event) => {

                    event.preventDefault();

                    const page =
                        Number(
                            link.dataset.inventoryPage
                        );

                    if (!page || page === current) {
                        return;
                    }

                    this.loadReport(page);

                });

            });

    },

    /*
    |--------------------------------------------------------------------------
    | Low Stock
    |--------------------------------------------------------------------------
    */

    renderLowStock(rows) {

        if (!rows.length) {

            this.elements.lowStockTable.innerHTML =
                this.placeholderRow(
                    9,
                    'No low-stock products found.'
                );

            return;
        }

        this.elements.lowStockTable.innerHTML =
            rows.map(row => {

                return `
                    <tr>
                        <td>
                            <div class="inventory-product-name">
                                ${this.escapeHtml(row.name || '—')}
                            </div>

                            <div class="inventory-product-meta">
                                ${this.escapeHtml(
                                    row.sku
                                    || row.product_code
                                    || ''
                                )}
                            </div>
                        </td>

                        <td>
                            ${this.escapeHtml(
                                row.category || 'Uncategorized'
                            )}
                        </td>

                        <td>
                            ${this.escapeHtml(
                                row.branch_name || '—'
                            )}
                        </td>

                        <td class="text-end">
                            ${this.formatNumber(row.quantity)}
                        </td>

                        <td class="text-end">
                            ${this.formatNumber(
                                row.available_quantity
                            )}
                        </td>

                        <td class="text-end">
                            ${this.formatNumber(
                                row.reorder_level
                            )}
                        </td>

                        <td class="text-end">
                            ${this.formatNumber(
                                row.maximum_stock
                            )}
                        </td>

                        <td class="text-end">
                            ${this.formatNumber(
                                row.shortage
                            )}
                        </td>

                        <td>
                            ${this.statusBadge(row.status)}
                        </td>
                    </tr>
                `;
            }).join('');
    },

    /*
    |--------------------------------------------------------------------------
    | Valuation
    |--------------------------------------------------------------------------
    */

    renderValuation(valuation) {

        this.setText(
            this.elements.valuationCost,
            this.formatCurrency(
                valuation.cost_value
            )
        );

        this.setText(
            this.elements.valuationRetail,
            this.formatCurrency(
                valuation.retail_value
            )
        );

        this.setText(
            this.elements.valuationProfit,
            this.formatCurrency(
                valuation.potential_profit
            )
        );

        const branches =
            valuation.branches || [];

        if (!branches.length) {

            this.elements.valuationTable.innerHTML =
                this.placeholderRow(
                    5,
                    'No valuation data available.'
                );

            return;
        }

        this.elements.valuationTable.innerHTML =
            branches.map(branch => {

                return `
                    <tr>
                        <td>
                            ${this.escapeHtml(
                                branch.branch_name || '—'
                            )}
                        </td>

                        <td class="text-end">
                            ${this.formatNumber(
                                branch.units
                            )}
                        </td>

                        <td class="text-end">
                            ${this.formatCurrency(
                                branch.stock_value
                            )}
                        </td>

                        <td class="text-end">
                            ${this.formatCurrency(
                                branch.retail_value
                            )}
                        </td>

                        <td class="text-end">
                            ${this.formatCurrency(
                                branch.potential_profit
                            )}
                        </td>
                    </tr>
                `;
            }).join('');
    },

    /*
    |--------------------------------------------------------------------------
    | Inspector
    |--------------------------------------------------------------------------
    */

    openMovementInspector(movement) {

        this.setText(
            this.elements.inspectorReference,
            movement.reference_no || '—'
        );

        this.setText(
            this.elements.inspectorDate,
            `${movement.date || '—'} ${movement.time || ''}`
        );

        this.setText(
            this.elements.inspectorProduct,
            movement.product_name || '—'
        );

        this.setText(
            this.elements.inspectorBranch,
            movement.branch_name || '—'
        );

        this.setText(
            this.elements.inspectorType,
            movement.movement_label
            || movement.movement_type
            || '—'
        );

        this.setText(
            this.elements.inspectorDirection,
            this.directionLabel(
                movement.direction
            )
        );

        this.setText(
            this.elements.inspectorQuantity,
            this.formatNumber(
                movement.quantity
            )
        );

        this.setText(
            this.elements.inspectorUnitCost,
            this.formatCurrency(
                movement.unit_cost
            )
        );

        this.setText(
            this.elements.inspectorBefore,
            this.formatNumber(
                movement.stock_before
            )
        );

        this.setText(
            this.elements.inspectorAfter,
            this.formatNumber(
                movement.stock_after
            )
        );

        this.setText(
            this.elements.inspectorCreatedBy,
            movement.created_by || '—'
        );

        this.setText(
            this.elements.inspectorRemarks,
            movement.remarks || '—'
        );

        if (
            typeof bootstrap !== 'undefined'
            && this.elements.inspector
        ) {
            bootstrap.Modal
                .getOrCreateInstance(
                    this.elements.inspector
                )
                .show();
        }
    },

    /*
    |--------------------------------------------------------------------------
    | Export
    |--------------------------------------------------------------------------
    */

    exportReport(format) {

        const filters =
            this.collectFilters();

        const normalizedFormat =
            String(format || '').trim().toLowerCase();

        if (
            !['xlsx', 'csv', 'pdf']
                .includes(normalizedFormat)
        ) {
            this.showToast(
                'Invalid export format.',
                'warning'
            );

            return;
        }

        const params =
            new URLSearchParams();

        Object.entries(filters).forEach(
            ([key, value]) => {

                if (
                    value !== null
                    && value !== undefined
                    && value !== ''
                ) {
                    params.append(key, value);
                }

            }
        );

        params.set(
            'format',
            normalizedFormat
        );

        window.location.href =
            `${window.InventoryReportConfig.exportUrl}?${params.toString()}`;
    },
    /*
    |--------------------------------------------------------------------------
    | Reset
    |--------------------------------------------------------------------------
    */

    resetFilters() {

        this.elements.branch.value = '';
        this.elements.product.value = '';
        this.elements.category.value = '';
        this.elements.movementType.value = '';
        this.elements.stockStatus.value = '';

        this.elements.datePreset.value =
            'this_month';

        this.setDefaultDates();
        this.filterProductsByCategory();

        this.state.currentPage = 1;

        this.loadReport();
    },

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    showLoading() {

        this.elements.loading
            ?.classList.remove('d-none');

        this.elements.content
            ?.classList.add('d-none');

        this.elements.empty
            ?.classList.add('d-none');

        this.elements.error
            ?.classList.add('d-none');
    },

    showEmpty() {

        this.elements.loading
            ?.classList.add('d-none');

        this.elements.content
            ?.classList.add('d-none');

        this.elements.empty
            ?.classList.remove('d-none');

        this.elements.error
            ?.classList.add('d-none');
    },

    showError(message) {

        this.elements.loading
            ?.classList.add('d-none');

        this.elements.content
            ?.classList.add('d-none');

        this.elements.empty
            ?.classList.add('d-none');

        this.elements.error
            ?.classList.remove('d-none');

        this.setText(
            this.elements.errorMessage,
            message
        );
    },

    hideStates() {

        this.elements.loading
            ?.classList.add('d-none');

        this.elements.empty
            ?.classList.add('d-none');

        this.elements.error
            ?.classList.add('d-none');

        this.elements.content
            ?.classList.remove('d-none');
    },

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    updateFilterSummary() {

        const branchText =
            this.elements.branch.selectedOptions[0]?.text
            || 'All Branches';

        const from =
            this.elements.dateFrom.value || '—';

        const to =
            this.elements.dateTo.value || '—';

        this.setText(
            this.elements.filterSummary,
            `${branchText} · ${from} to ${to}`
        );
    },

    statusBadge(status) {

        const labels = {
            in_stock: 'In Stock',
            low_stock: 'Low Stock',
            out_of_stock: 'Out of Stock'
        };

        const classes = {
            in_stock: 'inventory-status-in-stock',
            low_stock: 'inventory-status-low-stock',
            out_of_stock: 'inventory-status-out-of-stock'
        };

        return `
            <span class="inventory-status-badge ${classes[status] || ''}">
                ${labels[status] || 'Unknown'}
            </span>
        `;
    },

    directionBadge(direction) {

        const labels = {
            in: 'Stock In',
            out: 'Stock Out',
            adjustment: 'Adjustment',
            transfer: 'Transfer',
            other: 'Other'
        };

        const classes = {
            in: 'inventory-direction-in',
            out: 'inventory-direction-out',
            adjustment: 'inventory-direction-adjustment',
            transfer: 'inventory-direction-transfer'
        };

        return `
            <span class="inventory-direction-badge ${classes[direction] || ''}">
                ${labels[direction] || 'Other'}
            </span>
        `;
    },

    directionLabel(direction) {

        const labels = {
            in: 'Stock In',
            out: 'Stock Out',
            adjustment: 'Adjustment',
            transfer: 'Transfer',
            other: 'Other'
        };

        return labels[direction] || 'Other';
    },

    placeholderRow(columns, message) {

        return `
            <tr>
                <td
                    colspan="${columns}"
                    class="inventory-table-placeholder"
                >
                    ${this.escapeHtml(message)}
                </td>
            </tr>
        `;
    },

    formatCurrency(value) {

        const number =
            Number(value || 0);

        return new Intl.NumberFormat(
            'en-NG',
            {
                style: 'currency',
                currency: 'NGN',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }
        ).format(number);
    },

    formatNumber(value) {

        return new Intl.NumberFormat(
            'en-NG',
            {
                minimumFractionDigits: 0,
                maximumFractionDigits: 2
            }
        ).format(
            Number(value || 0)
        );
    },

    formatChartDate(value) {

        if (!value) {
            return '';
        }

        const date =
            new Date(`${value}T00:00:00`);

        if (Number.isNaN(date.getTime())) {
            return value;
        }

        return date.toLocaleDateString(
            'en-GB',
            {
                day: '2-digit',
                month: 'short'
            }
        );
    },

    setText(element, value) {

        if (element) {
            element.textContent =
                value ?? '';
        }
    },

    escapeHtml(value) {

        const div =
            document.createElement('div');

        div.textContent =
            value ?? '';

        return div.innerHTML;
    },

    showToast(message, type = 'info') {

        if (
            typeof window.showToast === 'function'
        ) {
            window.showToast(
                message,
                type
            );

            return;
        }

        console[type === 'error' ? 'error' : 'log'](
            message
        );
    }
};

/*
|--------------------------------------------------------------------------
| Initialize
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    () => {
        window.InventoryReport.init();
    }
);