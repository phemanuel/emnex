
/**
 * ============================================================================
 * EMNEX POS
 * Profit & Loss Report
 * ============================================================================
 */

window.ProfitLossReport = {

    /* ------------------------------------------------------------------------
     * State
     * --------------------------------------------------------------------- */

    state: {
        filters: {
            date_from: '',
            date_to: '',
            branch_id: '',
        },

        report: null,

        isLoading: false,

        charts: {
            trend: null,
            revenue: null,
            costs: null,
            profit: null,
        },
    },


    /* ------------------------------------------------------------------------
     * Elements
     * --------------------------------------------------------------------- */

    elements: {},


    /* ------------------------------------------------------------------------
     * Initialization
     * --------------------------------------------------------------------- */

    init() {

        this.cacheElements();

        if (!this.elements.pageContent) {
            return;
        }

        this.initializeComponents();
        this.bindEvents();
        this.initializeContext();

    },


    /* ------------------------------------------------------------------------
     * Cache Elements
     * --------------------------------------------------------------------- */

    cacheElements() {

        this.elements = {

            pageContent: document.getElementById('profitLossPageContent'),

            loadingState: document.getElementById('profitLossLoadingState'),
            emptyState: document.getElementById('profitLossEmptyState'),
            errorState: document.getElementById('profitLossErrorState'),
            errorMessage: document.getElementById('profitLossErrorMessage'),

            retryBtn: document.getElementById('profitLossRetryBtn'),
            emptyResetBtn: document.getElementById('profitLossEmptyResetBtn'),

            exportBtn: document.getElementById('profitLossExportBtn'),

            datePreset: document.getElementById('profitLossDatePreset'),
            dateFrom: document.getElementById('profitLossDateFrom'),
            dateTo: document.getElementById('profitLossDateTo'),
            branch: document.getElementById('profitLossBranch'),

            filterSummary: document.getElementById('profitLossFilterSummary'),
            dateSummary: document.getElementById('profitLossDateSummary'),
            branchSummary: document.getElementById('profitLossBranchSummary'),

            applyBtn: document.getElementById('profitLossApplyBtn'),
            resetBtn: document.getElementById('profitLossResetBtn'),


            /* KPI */

            statGrossRevenue: document.getElementById('profitLossStatGrossRevenue'),
            statSalesReturns: document.getElementById('profitLossStatSalesReturns'),
            statNetRevenue: document.getElementById('profitLossStatNetRevenue'),

            statGrossCogs: document.getElementById('profitLossStatGrossCogs'),
            statReturnedCogs: document.getElementById('profitLossStatReturnedCogs'),
            statNetCogs: document.getElementById('profitLossStatNetCogs'),

            statGrossProfit: document.getElementById('profitLossStatGrossProfit'),
            statGrossMargin: document.getElementById('profitLossStatGrossMargin'),

            statInventoryLoss: document.getElementById('profitLossStatInventoryLoss'),
            statDamageLoss: document.getElementById('profitLossStatDamageLoss'),
            statExpiredLoss: document.getElementById('profitLossStatExpiredLoss'),

            statOperatingResult: document.getElementById('profitLossStatOperatingResult'),
            statOperatingMargin: document.getElementById('profitLossStatOperatingMargin'),


            /* Revenue */

            revenueGross: document.getElementById('profitLossRevenueGross'),
            revenueReturns: document.getElementById('profitLossRevenueReturns'),
            revenueNet: document.getElementById('profitLossRevenueNet'),


            /* COGS */

            cogsGross: document.getElementById('profitLossCogsGross'),
            cogsReturned: document.getElementById('profitLossCogsReturned'),
            cogsNet: document.getElementById('profitLossCogsNet'),


            /* Inventory Losses */

            damageLoss: document.getElementById('profitLossDamageLoss'),
            expiredLoss: document.getElementById('profitLossExpiredLoss'),
            inventoryLoss: document.getElementById('profitLossInventoryLoss'),


            /* Profitability */

            profitNetRevenue: document.getElementById('profitLossProfitNetRevenue'),
            profitNetCogs: document.getElementById('profitLossProfitNetCogs'),
            grossProfit: document.getElementById('profitLossGrossProfit'),
            grossMargin: document.getElementById('profitLossGrossMargin'),
            profitInventoryLoss: document.getElementById('profitLossProfitInventoryLoss'),
            operatingResult: document.getElementById('profitLossOperatingResult'),
            operatingMargin: document.getElementById('profitLossOperatingMargin'),


            /* Profit & Loss Summary */

            summaryGrossRevenue: document.getElementById('profitLossSummaryGrossRevenue'),
            summarySalesReturns: document.getElementById('profitLossSummarySalesReturns'),
            summaryNetRevenue: document.getElementById('profitLossSummaryNetRevenue'),

            summaryNetCogs: document.getElementById('profitLossSummaryNetCogs'),
            summaryGrossProfit: document.getElementById('profitLossSummaryGrossProfit'),
            summaryGrossMargin: document.getElementById('profitLossSummaryGrossMargin'),

            summaryDamageLoss: document.getElementById('profitLossSummaryDamageLoss'),
            summaryExpiredLoss: document.getElementById('profitLossSummaryExpiredLoss'),
            summaryInventoryLoss: document.getElementById('profitLossSummaryInventoryLoss'),

            summaryOperatingResult: document.getElementById('profitLossSummaryOperatingResult'),
            summaryOperatingMargin: document.getElementById('profitLossSummaryOperatingMargin'),
            summaryResultStatus: document.getElementById('profitLossSummaryResultStatus'),


            /* Breakdown */

            breakdownNetRevenue: document.getElementById('profitLossBreakdownNetRevenue'),
            breakdownNetCogs: document.getElementById('profitLossBreakdownNetCogs'),
            breakdownGrossProfit: document.getElementById('profitLossBreakdownGrossProfit'),
            breakdownInventoryLoss: document.getElementById('profitLossBreakdownInventoryLoss'),
            breakdownOperatingResult: document.getElementById('profitLossBreakdownOperatingResult'),
            breakdownOperatingMargin: document.getElementById('profitLossBreakdownOperatingMargin'),


            /* Charts */

            trendChart: document.getElementById('profitLossTrendChart'),
            revenueChart: document.getElementById('profitLossRevenueChart'),
            costsChart: document.getElementById('profitLossCostsChart'),
            profitChart: document.getElementById('profitLossProfitChart'),

        };

    },


    /* ------------------------------------------------------------------------
     * Initialize Components
     * --------------------------------------------------------------------- */

    initializeComponents() {

        this.initializeDateRange();

        this.updateFilterSummary();

    },


    /* ------------------------------------------------------------------------
     * Bind Events
     * --------------------------------------------------------------------- */

    bindEvents() {

        this.elements.datePreset?.addEventListener(
            'change',
            () => this.handleDatePresetChange()
        );

        this.elements.dateFrom?.addEventListener(
            'change',
            () => this.handleManualDateChange()
        );

        this.elements.dateTo?.addEventListener(
            'change',
            () => this.handleManualDateChange()
        );

        this.elements.applyBtn?.addEventListener(
            'click',
            () => this.applyFilters()
        );

        this.elements.resetBtn?.addEventListener(
            'click',
            () => this.resetFilters()
        );

        this.elements.emptyResetBtn?.addEventListener(
            'click',
            () => this.resetFilters()
        );

        this.elements.retryBtn?.addEventListener(
            'click',
            () => this.loadReport()
        );
        /*
        |--------------------------------------------------------------------------
        | Export
        |--------------------------------------------------------------------------
        */

        this.elements.exportItems =
            document.querySelectorAll('[data-export-format]');

        this.elements.exportItems.forEach(item => {
            item.addEventListener('click', () => {
                const format = item.dataset.exportFormat;

                this.handleExport(format);
            });
        });


    },


    /* ------------------------------------------------------------------------
     * Context
     * --------------------------------------------------------------------- */

    initializeContext() {

        this.loadReport();

    },


    /* ------------------------------------------------------------------------
     * Date Handling
     * --------------------------------------------------------------------- */

    initializeDateRange() {

        const preset = this.elements.datePreset?.value || 'this_month';

        this.applyDatePreset(preset, false);

    },


    handleDatePresetChange() {

        const preset = this.elements.datePreset?.value || 'custom';

        if (preset === 'custom') {
            this.updateFilterSummary();
            return;
        }

        this.applyDatePreset(preset, false);

    },


    handleManualDateChange() {

        if (this.elements.datePreset) {
            this.elements.datePreset.value = 'custom';
        }

        this.updateFilterSummary();

    },


    applyDatePreset(preset, updateSummary = true) {

        const today = new Date();

        let from = new Date(today);
        let to = new Date(today);


        switch (preset) {

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


            case 'this_quarter': {

                const quarterStartMonth =
                    Math.floor(today.getMonth() / 3) * 3;

                from = new Date(
                    today.getFullYear(),
                    quarterStartMonth,
                    1
                );

                to = new Date(
                    today.getFullYear(),
                    quarterStartMonth + 3,
                    0
                );

                break;
            }


            case 'last_quarter': {

                const currentQuarterStart =
                    Math.floor(today.getMonth() / 3) * 3;

                from = new Date(
                    today.getFullYear(),
                    currentQuarterStart - 3,
                    1
                );

                to = new Date(
                    today.getFullYear(),
                    currentQuarterStart,
                    0
                );

                break;
            }


            case 'this_year':

                from = new Date(
                    today.getFullYear(),
                    0,
                    1
                );

                to = new Date(
                    today.getFullYear(),
                    11,
                    31
                );

                break;


            case 'last_year':

                from = new Date(
                    today.getFullYear() - 1,
                    0,
                    1
                );

                to = new Date(
                    today.getFullYear() - 1,
                    11,
                    31
                );

                break;


            case 'this_month':
            default:

                from = new Date(
                    today.getFullYear(),
                    today.getMonth(),
                    1
                );

                to = new Date(
                    today.getFullYear(),
                    today.getMonth() + 1,
                    0
                );

                break;

        }


        if (this.elements.dateFrom) {
            this.elements.dateFrom.value = this.formatDate(from);
        }

        if (this.elements.dateTo) {
            this.elements.dateTo.value = this.formatDate(to);
        }

        if (updateSummary) {
            this.updateFilterSummary();
        }

    },


    formatDate(date) {

        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');

        return `${year}-${month}-${day}`;

    },


    formatDisplayDate(value) {

        if (!value) {
            return '';
        }

        const date = new Date(`${value}T00:00:00`);

        if (Number.isNaN(date.getTime())) {
            return value;
        }

        return date.toLocaleDateString(undefined, {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
        });

    },


    /* ------------------------------------------------------------------------
     * Filters
     * --------------------------------------------------------------------- */

    collectFilters() {

        this.state.filters = {
            date_from: this.elements.dateFrom?.value || '',
            date_to: this.elements.dateTo?.value || '',
            branch_id: this.elements.branch?.value || '',
        };

        return {
            ...this.state.filters,
        };

    },


    updateFilterSummary() {

        if (this.elements.dateSummary) {

            const from = this.elements.dateFrom?.value;
            const to = this.elements.dateTo?.value;

            const dateText =
                from && to
                    ? `${this.formatDisplayDate(from)} - ${this.formatDisplayDate(to)}`
                    : 'Current Period';

            const textElement =
                this.elements.dateSummary.querySelector('span');

            if (textElement) {
                textElement.textContent = dateText;
            }

        }


        if (this.elements.branchSummary) {

            const selectedOption =
                this.elements.branch?.selectedOptions?.[0];

            const branchText =
                selectedOption?.textContent?.trim() || 'All Branches';

            const textElement =
                this.elements.branchSummary.querySelector('span');

            if (textElement) {
                textElement.textContent = branchText;
            }

        }

    },


    applyFilters() {

        this.collectFilters();
        this.updateFilterSummary();
        this.loadReport();

    },


    resetFilters() {

        if (this.elements.datePreset) {
            this.elements.datePreset.value = 'this_month';
        }

        if (this.elements.branch) {
            this.elements.branch.value = '';
        }

        this.applyDatePreset('this_month');

        this.collectFilters();
        this.loadReport();

    },


    /* ------------------------------------------------------------------------
     * Report Loading
     * --------------------------------------------------------------------- */

    async loadReport() {

        if (this.state.isLoading) {
            return;
        }

        this.state.isLoading = true;

        this.showLoadingState();

        try {

            const filters = this.collectFilters();

            const params = new URLSearchParams();

            Object.entries(filters).forEach(([key, value]) => {

                if (value !== '' && value !== null && value !== undefined) {
                    params.append(key, value);
                }

            });

            const url =
                `${window.profitLossReportConfig.dataUrl}?${params.toString()}`;

            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });


            if (!response.ok) {
                throw new Error(
                    `Request failed with status ${response.status}.`
                );
            }


            const result = await response.json();


            if (!result.success) {
                throw new Error(
                    result.message || 'Unable to load the report.'
                );
            }


            this.state.report = result.data || null;

            this.hideAllStates();


            if (!this.state.report) {
                this.showEmptyState();
                return;
            }


            this.renderReport(this.state.report);

        } catch (error) {

            console.error(
                'Profit & Loss Report:',
                error
            );

            this.showErrorState(
                error.message || 'Unable to load the report.'
            );

        } finally {

            this.state.isLoading = false;

        }

    },


    /* ------------------------------------------------------------------------
     * Render Report
     * --------------------------------------------------------------------- */

    renderReport(report) {

        const stats = report.stats || {};
        const revenue = report.revenue || {};
        const costOfGoods = report.cost_of_goods || {};
        const expenses = report.expenses || {};
        const profit = report.profit || {};
        const breakdown = report.breakdown || {};


        this.renderStats(stats);

        this.renderRevenue(revenue);

        this.renderCostOfGoods(costOfGoods);

        this.renderInventoryLosses(expenses);

        this.renderProfit(profit);

        this.renderSummary(
            stats,
            revenue,
            costOfGoods,
            expenses,
            profit
        );

        this.renderBreakdown(
            breakdown,
            profit,
            expenses
        );

        this.renderCharts(report.charts || {});

    },


    /* ------------------------------------------------------------------------
     * Stats
     * --------------------------------------------------------------------- */

    renderStats(stats) {

        this.setText(
            this.elements.statGrossRevenue,
            this.formatMoney(stats.gross_revenue)
        );

        this.setText(
            this.elements.statSalesReturns,
            this.formatNegativeMoney(stats.sales_returns)
        );

        this.setText(
            this.elements.statNetRevenue,
            this.formatMoney(stats.net_revenue)
        );

        this.setText(
            this.elements.statGrossCogs,
            this.formatNegativeMoney(stats.gross_cogs)
        );

        this.setText(
            this.elements.statReturnedCogs,
            this.formatMoney(stats.returned_cogs)
        );

        this.setText(
            this.elements.statNetCogs,
            this.formatNegativeMoney(stats.net_cogs)
        );

        this.setText(
            this.elements.statGrossProfit,
            this.formatResultMoney(stats.gross_profit)
        );

        this.setText(
            this.elements.statGrossMargin,
            this.formatPercent(stats.gross_margin)
        );

        this.setText(
            this.elements.statInventoryLoss,
            this.formatNegativeMoney(stats.inventory_loss)
        );

        this.setText(
            this.elements.statDamageLoss,
            this.formatNegativeMoney(stats.damage_loss)
        );

        this.setText(
            this.elements.statExpiredLoss,
            this.formatNegativeMoney(stats.expired_loss)
        );

        this.setText(
            this.elements.statOperatingResult,
            this.formatResultMoney(stats.operating_result)
        );

        this.setText(
            this.elements.statOperatingMargin,
            this.formatPercent(stats.operating_margin)
        );

    },


    /* ------------------------------------------------------------------------
     * Revenue
     * --------------------------------------------------------------------- */

    renderRevenue(revenue) {

        this.setText(
            this.elements.revenueGross,
            this.formatMoney(revenue.gross_revenue)
        );

        this.setText(
            this.elements.revenueReturns,
            this.formatNegativeMoney(revenue.sales_returns)
        );

        this.setText(
            this.elements.revenueNet,
            this.formatMoney(revenue.net_revenue)
        );

    },


    /* ------------------------------------------------------------------------
     * Cost of Goods
     * --------------------------------------------------------------------- */

    renderCostOfGoods(costOfGoods) {

        this.setText(
            this.elements.cogsGross,
            this.formatNegativeMoney(costOfGoods.gross_cogs)
        );

        this.setText(
            this.elements.cogsReturned,
            this.formatMoney(costOfGoods.returned_cogs)
        );

        this.setText(
            this.elements.cogsNet,
            this.formatNegativeMoney(costOfGoods.net_cogs)
        );

    },


    /* ------------------------------------------------------------------------
     * Inventory Losses
     * --------------------------------------------------------------------- */

    renderInventoryLosses(expenses) {

        this.setText(
            this.elements.damageLoss,
            this.formatNegativeMoney(expenses.damage_loss)
        );

        this.setText(
            this.elements.expiredLoss,
            this.formatNegativeMoney(expenses.expired_loss)
        );

        this.setText(
            this.elements.inventoryLoss,
            this.formatNegativeMoney(expenses.total)
        );

    },


    /* ------------------------------------------------------------------------
     * Profitability
     * --------------------------------------------------------------------- */

    renderProfit(profit) {

        this.setText(
            this.elements.profitNetRevenue,
            this.formatMoney(profit.net_revenue)
        );

        this.setText(
            this.elements.profitNetCogs,
            this.formatNegativeMoney(profit.net_cogs)
        );

        this.setText(
            this.elements.grossProfit,
            this.formatResultMoney(profit.gross_profit)
        );

        this.setText(
            this.elements.grossMargin,
            this.formatPercent(profit.gross_margin)
        );

        this.setText(
            this.elements.profitInventoryLoss,
            this.formatNegativeMoney(profit.inventory_loss)
        );

        this.setText(
            this.elements.operatingResult,
            this.formatResultMoney(profit.operating_result)
        );

        this.setText(
            this.elements.operatingMargin,
            this.formatPercent(profit.operating_margin)
        );

    },


    /* ------------------------------------------------------------------------
     * Profit & Loss Summary
     * --------------------------------------------------------------------- */

    renderSummary(stats, revenue, costOfGoods, expenses, profit) {

        this.setText(
            this.elements.summaryGrossRevenue,
            this.formatMoney(
                revenue.gross_revenue ?? stats.gross_revenue
            )
        );

        this.setText(
            this.elements.summarySalesReturns,
            this.formatNegativeMoney(
                revenue.sales_returns ?? stats.sales_returns
            )
        );

        this.setText(
            this.elements.summaryNetRevenue,
            this.formatMoney(
                revenue.net_revenue ?? stats.net_revenue
            )
        );


        this.setText(
            this.elements.summaryNetCogs,
            this.formatNegativeMoney(
                costOfGoods.net_cogs ?? stats.net_cogs
            )
        );

        this.setText(
            this.elements.summaryGrossProfit,
            this.formatResultMoney(
                profit.gross_profit ?? stats.gross_profit
            )
        );

        this.setText(
            this.elements.summaryGrossMargin,
            `${this.formatPercent(
                profit.gross_margin ?? stats.gross_margin
            )} margin`
        );


        this.setText(
            this.elements.summaryDamageLoss,
            this.formatNegativeMoney(
                expenses.damage_loss ?? stats.damage_loss
            )
        );

        this.setText(
            this.elements.summaryExpiredLoss,
            this.formatNegativeMoney(
                expenses.expired_loss ?? stats.expired_loss
            )
        );

        this.setText(
            this.elements.summaryInventoryLoss,
            this.formatNegativeMoney(
                expenses.total ?? stats.inventory_loss
            )
        );


        const operatingResult =
            profit.operating_result ??
            stats.operating_result ??
            0;

        const operatingMargin =
            profit.operating_margin ??
            stats.operating_margin ??
            0;


        this.setText(
            this.elements.summaryOperatingResult,
            this.formatResultMoney(operatingResult)
        );

        this.setText(
            this.elements.summaryOperatingMargin,
            `${this.formatPercent(operatingMargin)} margin`
        );


        this.updateResultStatus(operatingResult);

    },


    updateResultStatus(value) {

        if (!this.elements.summaryResultStatus) {
            return;
        }

        const numericValue = Number(value) || 0;

        this.elements.summaryResultStatus.textContent =
            numericValue < 0 ? 'Loss' : 'Profit';

        this.elements.summaryResultStatus.classList.toggle(
            'profit-loss-result-is-loss',
            numericValue < 0
        );

        this.elements.summaryResultStatus.classList.toggle(
            'profit-loss-result-is-profit',
            numericValue >= 0
        );

    },


    /* ------------------------------------------------------------------------
     * Breakdown
     * --------------------------------------------------------------------- */

    renderBreakdown(breakdown, profit, expenses) {

        this.setText(
            this.elements.breakdownNetRevenue,
            this.formatMoney(
                breakdown.net_revenue ?? profit.net_revenue
            )
        );

        this.setText(
            this.elements.breakdownNetCogs,
            this.formatNegativeMoney(
                breakdown.net_cogs ?? profit.net_cogs
            )
        );

        this.setText(
            this.elements.breakdownGrossProfit,
            this.formatResultMoney(
                breakdown.gross_profit ?? profit.gross_profit
            )
        );

        this.setText(
            this.elements.breakdownInventoryLoss,
            this.formatNegativeMoney(
                breakdown.inventory_loss ??
                expenses.total ??
                profit.inventory_loss
            )
        );

        this.setText(
            this.elements.breakdownOperatingResult,
            this.formatResultMoney(
                breakdown.operating_result ??
                profit.operating_result
            )
        );

        this.setText(
            this.elements.breakdownOperatingMargin,
            `${this.formatPercent(
                breakdown.operating_margin ??
                profit.operating_margin
            )} margin`
        );

    },


    /* ------------------------------------------------------------------------
     * Charts
     * --------------------------------------------------------------------- */

    renderCharts(charts) {

        if (
            typeof window.Chart === 'undefined'
        ) {
            console.warn(
                'Chart.js is not available. Profit & Loss charts were skipped.'
            );

            return;
        }


        this.destroyCharts();


        this.state.charts.trend =
            this.createLineChart(
                this.elements.trendChart,
                charts.trend || [],
                {
                    label: 'Profit & Loss Trend',
                    datasets: [
                        {
                            key: 'revenue',
                            label: 'Net Revenue',
                        },
                        {
                            key: 'cogs',
                            label: 'Net COGS',
                        },
                        {
                            key: 'operating_result',
                            label: 'Operating Result',
                        },
                    ],
                }
            );


        this.state.charts.revenue =
            this.createBarChart(
                this.elements.revenueChart,
                charts.revenue || [],
                {
                    datasets: [
                        {
                            key: 'gross_revenue',
                            label: 'Gross Revenue',
                        },
                        {
                            key: 'sales_returns',
                            label: 'Sales Returns',
                        },
                        {
                            key: 'net_revenue',
                            label: 'Net Revenue',
                        },
                    ],
                }
            );


        this.state.charts.costs =
            this.createBarChart(
                this.elements.costsChart,
                charts.costs || [],
                {
                    datasets: [
                        {
                            key: 'gross_cogs',
                            label: 'Gross COGS',
                        },
                        {
                            key: 'returned_cogs',
                            label: 'Returned COGS',
                        },
                        {
                            key: 'net_cogs',
                            label: 'Net COGS',
                        },
                    ],
                }
            );


        this.state.charts.profit =
            this.createBarChart(
                this.elements.profitChart,
                charts.profit || [],
                {
                    datasets: [
                        {
                            key: 'gross_profit',
                            label: 'Gross Profit',
                        },
                        {
                            key: 'inventory_loss',
                            label: 'Inventory Losses',
                        },
                        {
                            key: 'operating_result',
                            label: 'Operating Result',
                        },
                    ],
                }
            );

    },


    /* ------------------------------------------------------------------------
     * Chart Helpers
     * --------------------------------------------------------------------- */

    createLineChart(element, data, config) {

        if (!element || !Array.isArray(data) || !data.length) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Destroy Existing Chart
        |--------------------------------------------------------------------------
        */

        const existingChart = Chart.getChart(element);

        if (existingChart) {
            existingChart.destroy();
        }

        /*
        |--------------------------------------------------------------------------
        | Resolve Canvas
        |--------------------------------------------------------------------------
        */

        let canvas = element.querySelector('canvas');

        if (!canvas) {
            canvas = document.createElement('canvas');

            canvas.setAttribute(
                'aria-label',
                'Profit and Loss financial performance chart'
            );

            element.appendChild(canvas);
        }

        /*
        |--------------------------------------------------------------------------
        | Get Canvas Context
        |--------------------------------------------------------------------------
        */

        const context = canvas.getContext('2d');

        if (!context) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Chart Labels
        |--------------------------------------------------------------------------
        */

        const labels = data.map(item =>
            item.label ??
            item.date ??
            item.period ??
            ''
        );

        /*
        |--------------------------------------------------------------------------
        | Chart Datasets
        |--------------------------------------------------------------------------
        */

        const datasets = config.datasets.map(dataset => ({
            label: dataset.label,

            data: data.map(item =>
                Number(item[dataset.key] ?? 0)
            ),

            tension: 0.35,
            fill: false,
            pointRadius: 3,
            pointHoverRadius: 5,
            borderWidth: 2,
        }));

        /*
        |--------------------------------------------------------------------------
        | Create Chart
        |--------------------------------------------------------------------------
        */

        return new Chart(context, {
            type: 'line',

            data: {
                labels,
                datasets,
            },

            options: this.getChartOptions(),
        });
    },


    createBarChart(element, data, config) {

        if (!element || !Array.isArray(data) || !data.length) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Destroy Existing Chart
        |--------------------------------------------------------------------------
        */

        const existingChart = Chart.getChart(element);

        if (existingChart) {
            existingChart.destroy();
        }

        /*
        |--------------------------------------------------------------------------
        | Resolve Canvas
        |--------------------------------------------------------------------------
        */

        let canvas = element.querySelector('canvas');

        if (!canvas) {
            canvas = document.createElement('canvas');

            canvas.setAttribute(
                'aria-label',
                'Profit and Loss financial performance chart'
            );

            element.appendChild(canvas);
        }

        /*
        |--------------------------------------------------------------------------
        | Get Canvas Context
        |--------------------------------------------------------------------------
        */

        const context = canvas.getContext('2d');

        if (!context) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Chart Labels
        |--------------------------------------------------------------------------
        */

        const labels = data.map(item =>
            item.label ??
            item.date ??
            item.period ??
            ''
        );

        /*
        |--------------------------------------------------------------------------
        | Chart Datasets
        |--------------------------------------------------------------------------
        */

        const datasets = config.datasets.map(dataset => ({
            label: dataset.label,

            data: data.map(item =>
                Number(item[dataset.key] ?? 0)
            ),

            borderWidth: 1,

            borderRadius: 6,

            maxBarThickness: 42,
        }));

        /*
        |--------------------------------------------------------------------------
        | Create Chart
        |--------------------------------------------------------------------------
        */

        return new Chart(context, {
            type: 'bar',

            data: {
                labels,
                datasets,
            },

            options: this.getChartOptions(),
        });
    },




    getChartOptions() {

        return {

            responsive: true,

            maintainAspectRatio: false,

            interaction: {
                mode: 'index',
                intersect: false,
            },

            plugins: {

                legend: {
                    display: true,

                    position: 'bottom',

                    labels: {
                        usePointStyle: true,
                        boxWidth: 8,
                        padding: 16,
                        font: {
                            size: 11,
                        },
                    },
                },

                tooltip: {
                    callbacks: {
                        label: context => {

                            const value =
                                Number(context.raw) || 0;

                            return `${context.dataset.label}: ${this.formatMoney(value)}`;

                        },
                    },
                },

            },

            scales: {

                x: {
                    grid: {
                        display: false,
                    },

                    ticks: {
                        font: {
                            size: 10,
                        },
                    },
                },

                y: {
                    beginAtZero: true,

                    grid: {
                        color: 'rgba(15, 23, 42, 0.06)',
                    },

                    ticks: {
                        font: {
                            size: 10,
                        },

                        callback: value =>
                            this.formatCompactMoney(value),
                    },
                },

            },

        };

    },


    destroyCharts() {

        Object.keys(this.state.charts).forEach(key => {

            const chart = this.state.charts[key];

            if (
                chart &&
                typeof chart.destroy === 'function'
            ) {
                chart.destroy();
            }

            this.state.charts[key] = null;

        });

    },

   
    handleExport(format) {

        const allowedFormats = ['xlsx', 'csv', 'pdf'];

        if (!allowedFormats.includes(format)) {
            return;
        }

        const filters = this.collectFilters();

        const params = new URLSearchParams();

        Object.entries(filters).forEach(([key, value]) => {

            if (
                value !== null &&
                value !== undefined &&
                value !== ''
            ) {
                params.set(key, value);
            }

        });

        params.set('format', format);

        const exportUrl =
            `${window.profitLossReportConfig.exportUrl}?${params.toString()}`;

        window.location.href = exportUrl;
    },




    /* ------------------------------------------------------------------------
     * Loading / Empty / Error States
     * --------------------------------------------------------------------- */

    showLoadingState() {

        this.hideAllStates();

        if (this.elements.pageContent) {
            this.elements.pageContent.classList.add('d-none');
        }

        this.elements.loadingState?.classList.remove('d-none');

    },


    showEmptyState() {

        if (this.elements.pageContent) {
            this.elements.pageContent.classList.add('d-none');
        }

        this.elements.loadingState?.classList.add('d-none');
        this.elements.errorState?.classList.add('d-none');
        this.elements.emptyState?.classList.remove('d-none');

    },


    showErrorState(message) {

        if (this.elements.pageContent) {
            this.elements.pageContent.classList.add('d-none');
        }

        this.elements.loadingState?.classList.add('d-none');
        this.elements.emptyState?.classList.add('d-none');
        this.elements.errorState?.classList.remove('d-none');


        this.setText(
            this.elements.errorMessage,
            message
        );

    },


    hideAllStates() {

        this.elements.loadingState?.classList.add('d-none');
        this.elements.emptyState?.classList.add('d-none');
        this.elements.errorState?.classList.add('d-none');

        if (this.elements.pageContent) {
            this.elements.pageContent.classList.remove('d-none');
        }

    },


    /* ------------------------------------------------------------------------
     * Formatting
     * --------------------------------------------------------------------- */

    formatMoney(value) {

        const amount = Number(value) || 0;

        return new Intl.NumberFormat('en-NG', {
            style: 'currency',
            currency: 'NGN',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        }).format(amount);

    },


    formatNegativeMoney(value) {

        const amount = Number(value) || 0;

        if (amount === 0) {
            return this.formatMoney(0);
        }

        return `(${this.formatMoney(Math.abs(amount))})`;

    },


    formatResultMoney(value) {

        const amount = Number(value) || 0;

        if (amount < 0) {
            return `(${this.formatMoney(Math.abs(amount))})`;
        }

        return this.formatMoney(amount);

    },


    formatPercent(value) {

        const amount = Number(value) || 0;

        return `${amount.toFixed(2)}%`;

    },


    formatCompactMoney(value) {

        const amount = Number(value) || 0;

        const absolute = Math.abs(amount);

        if (absolute >= 1000000000) {
            return `₦${(amount / 1000000000).toFixed(1)}B`;
        }

        if (absolute >= 1000000) {
            return `₦${(amount / 1000000).toFixed(1)}M`;
        }

        if (absolute >= 1000) {
            return `₦${(amount / 1000).toFixed(1)}K`;
        }

        return `₦${amount.toFixed(0)}`;

    },


    setText(element, value) {

        if (!element) {
            return;
        }

        element.textContent = value ?? '';

    },


    /* ------------------------------------------------------------------------
     * Toast
     * --------------------------------------------------------------------- */

    showToast(message, type = 'info') {

        if (
            typeof window.showToast === 'function'
        ) {
            window.showToast(message, type);
            return;
        }


        console.info(
            `[Profit & Loss ${type}]`,
            message
        );

    },

};


/* ==========================================================================
   Initialize
   ========================================================================== */

document.addEventListener('DOMContentLoaded', () => {

    window.ProfitLossReport.init();

});

