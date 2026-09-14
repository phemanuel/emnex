(function () {
    'use strict';

    /* ==========================================================
       EMNEX POS — SALES REPORT
       ----------------------------------------------------------
       File:
       public/assets/js/modules/sales-report.js

       Purpose:
       Frontend controller for the Sales Report workspace.

       Responsibilities:
       - Filter management
       - AJAX report loading
       - KPI rendering
       - Chart rendering
       - Product/category/payment/cashier/customer tables
       - Transaction table
       - Transaction inspector
       - Pagination
       - Export handling
       - Loading / empty / error states

       Notes:
       - Uses Fetch API only.
       - No jQuery.
       - Uses Chart.js when available.
       - Keeps all module state inside SalesReport.
    ========================================================== */


    /* ==========================================================
       SALES REPORT MODULE
    ========================================================== */

    window.SalesReport = {

        /* ------------------------------------------------------
           ELEMENT CACHE
        ------------------------------------------------------ */
        elements: {},


        /* ------------------------------------------------------
           MODULE STATE
        ------------------------------------------------------ */
        state: {

            initialized: false,

            loading: false,

            currentPage: 1,

            perPage: 25,

            totalTransactions: 0,

            lastResponse: null,

            filters: {},

            charts: {
                trend: null,
                payment: null,
                category: null
            },

            inspectorModal: null,

            currency: 'NGN',

            currencySymbol: '₦'

        },


        /* ======================================================
           INITIALIZATION
        ====================================================== */

        init: function () {

            if (this.state.initialized) {
                return;
            }

            this.cacheElements();

            if (!this.elements.page) {
                return;
            }

            this.initializeComponents();

            this.bindEvents();

            this.initializeContext();

            this.state.initialized = true;

        },


        /* ======================================================
           CACHE ELEMENTS
        ====================================================== */

        cacheElements: function () {

            this.elements = {

                /* ------------------------------------------------
                   PAGE
                ------------------------------------------------ */
                page: document.getElementById('sales-report-page'),

                content: document.getElementById('salesReportContent'),

                data: document.getElementById('salesReportData'),

                loading: document.getElementById('salesReportLoading'),

                empty: document.getElementById('salesReportEmpty'),

                error: document.getElementById('salesReportError'),

                errorMessage: document.getElementById(
                    'salesReportErrorMessage'
                ),


                /* ------------------------------------------------
                   FILTERS
                ------------------------------------------------ */
                datePreset: document.getElementById(
                    'salesReportDatePreset'
                ),

                dateFrom: document.getElementById(
                    'salesReportDateFrom'
                ),

                dateTo: document.getElementById(
                    'salesReportDateTo'
                ),

                branch: document.getElementById(
                    'salesReportBranch'
                ),

                cashier: document.getElementById(
                    'salesReportCashier'
                ),

                paymentMethod: document.getElementById(
                    'salesReportPaymentMethod'
                ),

                salesChannel: document.getElementById(
                    'salesReportSalesChannel'
                ),

                customer: document.getElementById(
                    'salesReportCustomer'
                ),

                category: document.getElementById(
                    'salesReportCategory'
                ),

                product: document.getElementById(
                    'salesReportProduct'
                ),

                applyFilters: document.getElementById(
                    'salesReportApplyFilters'
                ),

                resetFilters: document.getElementById(
                    'salesReportResetFilters'
                ),

                emptyReset: document.getElementById(
                    'salesReportEmptyReset'
                ),

                retry: document.getElementById(
                    'salesReportRetry'
                ),


                /* ------------------------------------------------
                   EXPORT
                ------------------------------------------------ */
                exportButton: document.getElementById(
                    'salesReportExportBtn'
                ),

                exportItems: document.querySelectorAll(
                    '#sales-report-page [data-export-format]'
                ),


                /* ------------------------------------------------
                   KPI
                ------------------------------------------------ */
                statGrossSales: document.getElementById(
                    'salesStatGrossSales'
                ),

                statNetSales: document.getElementById(
                    'salesStatNetSales'
                ),

                statTransactions: document.getElementById(
                    'salesStatTransactions'
                ),

                statAverageOrder: document.getElementById(
                    'salesStatAverageOrder'
                ),

                statDiscounts: document.getElementById(
                    'salesStatDiscounts'
                ),

                statTax: document.getElementById(
                    'salesStatTax'
                ),

                statReturns: document.getElementById(
                    'salesStatReturns'
                ),

                statProfit: document.getElementById(
                    'salesStatProfit'
                ),

                statGrossSalesMeta: document.getElementById(
                    'salesStatGrossSalesMeta'
                ),

                statNetSalesMeta: document.getElementById(
                    'salesStatNetSalesMeta'
                ),

                statTransactionsMeta: document.getElementById(
                    'salesStatTransactionsMeta'
                ),

                statAverageOrderMeta: document.getElementById(
                    'salesStatAverageOrderMeta'
                ),

                statDiscountsMeta: document.getElementById(
                    'salesStatDiscountsMeta'
                ),

                statTaxMeta: document.getElementById(
                    'salesStatTaxMeta'
                ),

                statReturnsMeta: document.getElementById(
                    'salesStatReturnsMeta'
                ),

                statProfitMeta: document.getElementById(
                    'salesStatProfitMeta'
                ),


                /* ------------------------------------------------
                   CHARTS
                ------------------------------------------------ */
                trendChart: document.getElementById(
                    'salesTrendChart'
                ),

                paymentChart: document.getElementById(
                    'salesPaymentChart'
                ),

                categoryChart: document.getElementById(
                    'salesCategoryChart'
                ),

                chartTrendTotal: document.getElementById(
                    'salesChartTrendTotal'
                ),


                /* ------------------------------------------------
                   PRODUCT TABLE
                ------------------------------------------------ */
                productsCount: document.getElementById(
                    'salesProductsCount'
                ),

                productsBody: document.getElementById(
                    'product-performance-body'
                ),


                /* ------------------------------------------------
                   CATEGORY TABLE
                ------------------------------------------------ */
                categoriesBody: document.getElementById(
                    'salesCategoriesTableBody'
                ),


                /* ------------------------------------------------
                   PAYMENT TABLE
                ------------------------------------------------ */
                paymentsBody: document.getElementById(
                    'salesPaymentsTableBody'
                ),


                /* ------------------------------------------------
                   CASHIER TABLE
                ------------------------------------------------ */
                cashiersBody: document.getElementById(
                    'salesCashiersTableBody'
                ),


                /* ------------------------------------------------
                   CUSTOMER TABLE
                ------------------------------------------------ */
                customersBody: document.getElementById(
                    'salesCustomersTableBody'
                ),


                /* ------------------------------------------------
                   TRANSACTIONS
                ------------------------------------------------ */
                transactionsCount: document.getElementById(
                    'salesTransactionsCount'
                ),

                transactionsBody: document.getElementById(
                    'salesTransactionsTableBody'
                ),

                transactionsPagination: document.getElementById(
                    'salesTransactionsPagination'
                ),

                paginationInfo: document.querySelector(
                    '#salesTransactionsPagination .sales-report-pagination-info'
                ),

                paginationControls: document.querySelector(
                    '#salesTransactionsPagination .sales-report-pagination-controls'
                ),


                /* ------------------------------------------------
                   INSPECTOR
                ------------------------------------------------ */
                inspectorModal: document.getElementById(
                    'salesTransactionInspectorModal'
                ),

                inspectorLoading: document.getElementById(
                    'salesInspectorLoading'
                ),

                inspectorContent: document.getElementById(
                    'salesInspectorContent'
                ),

                inspectorOrderNo: document.getElementById(
                    'salesInspectorOrderNo'
                ),

                inspectorDate: document.getElementById(
                    'salesInspectorDate'
                ),

                inspectorStatus: document.getElementById(
                    'salesInspectorStatus'
                ),

                inspectorCustomer: document.getElementById(
                    'salesInspectorCustomer'
                ),

                inspectorCashier: document.getElementById(
                    'salesInspectorCashier'
                ),

                inspectorBranch: document.getElementById(
                    'salesInspectorBranch'
                ),

                inspectorTerminal: document.getElementById(
                    'salesInspectorTerminal'
                ),

                inspectorItemsBody: document.getElementById(
                    'salesInspectorItemsBody'
                ),

                inspectorPaymentMethod: document.getElementById(
                    'salesInspectorPaymentMethod'
                ),

                inspectorPaymentReference: document.getElementById(
                    'salesInspectorPaymentReference'
                ),

                inspectorAmountPaid: document.getElementById(
                    'salesInspectorAmountPaid'
                ),

                inspectorGross: document.getElementById(
                    'salesInspectorGross'
                ),

                inspectorDiscount: document.getElementById(
                    'salesInspectorDiscount'
                ),

                inspectorTax: document.getElementById(
                    'salesInspectorTax'
                ),

                inspectorTotal: document.getElementById(
                    'salesInspectorTotal'
                )

            };

        },


        /* ======================================================
           COMPONENT INITIALIZATION
        ====================================================== */

        initializeComponents: function () {

            /* --------------------------------------------------
               Bootstrap modal
            -------------------------------------------------- */
            if (
                this.elements.inspectorModal &&
                typeof bootstrap !== 'undefined' &&
                bootstrap.Modal
            ) {

                this.state.inspectorModal =
                    bootstrap.Modal.getOrCreateInstance(
                        this.elements.inspectorModal
                    );

            }


            /* --------------------------------------------------
               Date fields are controlled by preset
            -------------------------------------------------- */
            this.handleDatePreset(
                this.elements.datePreset
                    ? this.elements.datePreset.value
                    : 'this_month'
            );

        },


        /* ======================================================
           EVENT BINDING
        ====================================================== */

        bindEvents: function () {

            var self = this;


            /* --------------------------------------------------
               Apply filters
            -------------------------------------------------- */
            if (this.elements.applyFilters) {

                this.elements.applyFilters.addEventListener(
                    'click',
                    function () {
                        self.state.currentPage = 1;
                        self.applyFilters();
                    }
                );

            }


            /* --------------------------------------------------
               Reset filters
            -------------------------------------------------- */
            if (this.elements.resetFilters) {

                this.elements.resetFilters.addEventListener(
                    'click',
                    function () {
                        self.resetFilters();
                    }
                );

            }


            if (this.elements.emptyReset) {

                this.elements.emptyReset.addEventListener(
                    'click',
                    function () {
                        self.resetFilters();
                    }
                );

            }


            /* --------------------------------------------------
               Retry
            -------------------------------------------------- */
            if (this.elements.retry) {

                this.elements.retry.addEventListener(
                    'click',
                    function () {
                        self.loadReport();
                    }
                );

            }


            /* --------------------------------------------------
               Date preset
            -------------------------------------------------- */
            if (this.elements.datePreset) {

                this.elements.datePreset.addEventListener(
                    'change',
                    function () {

                        self.handleDatePreset(
                            this.value
                        );

                    }
                );

            }


            /* --------------------------------------------------
               Manual date changes
            -------------------------------------------------- */
            if (this.elements.dateFrom) {

                this.elements.dateFrom.addEventListener(
                    'change',
                    function () {

                        if (self.elements.datePreset) {
                            self.elements.datePreset.value = 'custom';
                        }

                    }
                );

            }


            if (this.elements.dateTo) {

                this.elements.dateTo.addEventListener(
                    'change',
                    function () {

                        if (self.elements.datePreset) {
                            self.elements.datePreset.value = 'custom';
                        }

                    }
                );

            }


            /* --------------------------------------------------
               Export
            -------------------------------------------------- */
            if (this.elements.exportItems) {

                this.elements.exportItems.forEach(
                    function (item) {

                        item.addEventListener(
                            'click',
                            function () {

                                var format =
                                    this.getAttribute(
                                        'data-export-format'
                                    );

                                self.exportReport(format);

                            }
                        );

                    }
                );

            }


            /* --------------------------------------------------
               Transaction inspector buttons
            -------------------------------------------------- */
            if (this.elements.transactionsBody) {

                this.elements.transactionsBody.addEventListener(
                    'click',
                    function (event) {

                        var button =
                            event.target.closest(
                                '[data-transaction-id]'
                            );

                        if (!button) {
                            return;
                        }

                        var transactionId =
                            button.getAttribute(
                                'data-transaction-id'
                            );

                        if (!transactionId) {
                            return;
                        }

                        self.openInspector(
                            transactionId
                        );

                    }
                );

            }


            /* --------------------------------------------------
               Pagination
            -------------------------------------------------- */
            if (this.elements.paginationControls) {

                this.elements.paginationControls.addEventListener(
                    'click',
                    function (event) {

                        var button =
                            event.target.closest(
                                '[data-page]'
                            );

                        if (!button) {
                            return;
                        }

                        event.preventDefault();

                        var page =
                            parseInt(
                                button.getAttribute(
                                    'data-page'
                                ),
                                10
                            );

                        if (!page || page < 1) {
                            return;
                        }

                        self.state.currentPage = page;

                        self.loadReport();

                    }
                );

            }

        },


        /* ======================================================
           CONTEXT INITIALIZATION
        ====================================================== */

        initializeContext: function () {

            this.collectFilters();

            this.loadReport();

        },


        /* ======================================================
           DATE PRESET HANDLING
        ====================================================== */

        handleDatePreset: function (preset) {

            if (
                !this.elements.dateFrom ||
                !this.elements.dateTo
            ) {
                return;
            }

            if (preset === 'custom') {
                this.elements.dateFrom.disabled = false;
                this.elements.dateTo.disabled = false;
                return;
            }

            var range =
                this.getPresetDateRange(preset);

            if (!range) {
                return;
            }

            this.elements.dateFrom.value =
                range.from;

            this.elements.dateTo.value =
                range.to;

            this.elements.dateFrom.disabled = true;
            this.elements.dateTo.disabled = true;

        },


        /* ======================================================
           PRESET DATE RANGE
        ====================================================== */

        getPresetDateRange: function (preset) {

            var now = new Date();

            var start = new Date(now);
            var end = new Date(now);


            switch (preset) {

                case 'today':

                    break;


                case 'yesterday':

                    start.setDate(
                        start.getDate() - 1
                    );

                    end.setDate(
                        end.getDate() - 1
                    );

                    break;


                case 'this_week': {

                    var day =
                        now.getDay();

                    var mondayOffset =
                        day === 0 ? -6 : 1 - day;

                    start.setDate(
                        now.getDate() + mondayOffset
                    );

                    end = new Date(start);

                    end.setDate(
                        start.getDate() + 6
                    );

                    break;
                }


                case 'last_week': {

                    var currentDay =
                        now.getDay();

                    var currentMondayOffset =
                        currentDay === 0
                            ? -6
                            : 1 - currentDay;

                    start.setDate(
                        now.getDate() +
                        currentMondayOffset -
                        7
                    );

                    end = new Date(start);

                    end.setDate(
                        start.getDate() + 6
                    );

                    break;
                }


                case 'this_month':

                    start = new Date(
                        now.getFullYear(),
                        now.getMonth(),
                        1
                    );

                    end = new Date(
                        now.getFullYear(),
                        now.getMonth() + 1,
                        0
                    );

                    break;


                case 'last_month':

                    start = new Date(
                        now.getFullYear(),
                        now.getMonth() - 1,
                        1
                    );

                    end = new Date(
                        now.getFullYear(),
                        now.getMonth(),
                        0
                    );

                    break;


                case 'this_quarter': {

                    var quarter =
                        Math.floor(
                            now.getMonth() / 3
                        );

                    start = new Date(
                        now.getFullYear(),
                        quarter * 3,
                        1
                    );

                    end = new Date(
                        now.getFullYear(),
                        quarter * 3 + 3,
                        0
                    );

                    break;
                }


                case 'this_year':

                    start = new Date(
                        now.getFullYear(),
                        0,
                        1
                    );

                    end = new Date(
                        now.getFullYear(),
                        11,
                        31
                    );

                    break;


                default:
                    return null;

            }


            return {
                from: this.formatDate(start),
                to: this.formatDate(end)
            };

        },


        /* ======================================================
           DATE FORMAT
        ====================================================== */

        formatDate: function (date) {

            var year =
                date.getFullYear();

            var month =
                String(
                    date.getMonth() + 1
                ).padStart(2, '0');

            var day =
                String(
                    date.getDate()
                ).padStart(2, '0');

            return year + '-' + month + '-' + day;

        },


        /* ======================================================
           COLLECT FILTERS
        ====================================================== */

        collectFilters: function () {

            this.state.filters = {

                date_from:
                    this.elements.dateFrom
                        ? this.elements.dateFrom.value
                        : '',

                date_to:
                    this.elements.dateTo
                        ? this.elements.dateTo.value
                        : '',

                branch_id:
                    this.elements.branch
                        ? this.elements.branch.value
                        : '',

                cashier_id:
                    this.elements.cashier
                        ? this.elements.cashier.value
                        : '',

                payment_method_id:
                    this.elements.paymentMethod
                        ? this.elements.paymentMethod.value
                        : '',

                sales_channel:
                    this.elements.salesChannel
                        ? this.elements.salesChannel.value
                        : '',

                customer_id:
                    this.elements.customer
                        ? this.elements.customer.value
                        : '',

                category_id:
                    this.elements.category
                        ? this.elements.category.value
                        : '',

                product_id:
                    this.elements.product
                        ? this.elements.product.value
                        : '',

                per_page:
                    this.state.perPage,

                page:
                    this.state.currentPage

            };

            return this.state.filters;

        },


        /* ======================================================
           APPLY FILTERS
        ====================================================== */

        applyFilters: function () {

            this.collectFilters();

            this.loadReport();

        },


        /* ======================================================
           RESET FILTERS
        ====================================================== */

        resetFilters: function () {

            if (this.elements.datePreset) {
                this.elements.datePreset.value =
                    'this_month';
            }

            if (this.elements.branch) {
                this.elements.branch.value = '';
            }

            if (this.elements.cashier) {
                this.elements.cashier.value = '';
            }

            if (this.elements.paymentMethod) {
                this.elements.paymentMethod.value = '';
            }

            if (this.elements.salesChannel) {
                this.elements.salesChannel.value = '';
            }

            if (this.elements.customer) {
                this.elements.customer.value = '';
            }

            if (this.elements.category) {
                this.elements.category.value = '';
            }

            if (this.elements.product) {
                this.elements.product.value = '';
            }

            this.handleDatePreset('this_month');

            this.state.currentPage = 1;

            this.collectFilters();

            this.loadReport();

        },


        /* ======================================================
           LOAD REPORT
        ====================================================== */

        loadReport: async function () {

            if (this.state.loading) {
                return;
            }

            this.state.loading = true;

            this.collectFilters();

            this.showLoadingState();

            var url =
                this.elements.page.getAttribute(
                    'data-report-url'
                );

            try {

                var query =
                    new URLSearchParams(
                        this.state.filters
                    );

                var response =
                    await fetch(
                        url + '?' + query.toString(),
                        {
                            method: 'GET',

                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },

                            credentials: 'same-origin'
                        }
                    );


                if (!response.ok) {

                    var errorPayload =
                        await this.parseResponse(
                            response
                        );

                    throw new Error(
                        errorPayload.message ||
                        'Unable to load the sales report.'
                    );

                }


                var data =
                    await response.json();


                this.state.lastResponse = data;

                this.renderReport(data);

            } catch (error) {

                console.error(
                    'Sales Report Error:',
                    error
                );

                this.showErrorState(
                    error.message ||
                    'Unable to load the sales report.'
                );

            } finally {

                this.state.loading = false;

                this.setLoadingButton(
                    false
                );

            }

        },


        /* ======================================================
           PARSE RESPONSE
        ====================================================== */

        parseResponse: async function (response) {

            try {

                return await response.json();

            } catch (error) {

                return {
                    message:
                        'The server returned an invalid response.'
                };

            }

        },


        /* ======================================================
           RENDER REPORT
        ====================================================== */

        renderReport: function (response) {

            var payload =
                response && response.data
                    ? response.data
                    : response;


            if (!payload) {

                this.showEmptyState();

                return;
            }


            var hasData =
                this.hasReportData(payload);


            if (!hasData) {

                this.destroyCharts();

                this.renderEmptyTables();

                this.showEmptyState();

                return;
            }


            this.showDataState();

            this.renderStats(
                payload.stats || payload.summary || {}
            );

            this.renderCharts(
                payload.charts || {}
            );

            this.renderProducts(
                payload.products || []
            );

            this.renderCategories(
                payload.categories || []
            );

            this.renderPayments(
                payload.payments || []
            );

            this.renderCashiers(
                payload.cashiers || []
            );

            this.renderCustomers(
                payload.customers || []
            );

            this.renderTransactions(
                payload.transactions || {}
            );

        },


        /* ======================================================
           DETERMINE WHETHER DATA EXISTS
        ====================================================== */

        hasReportData: function (payload) {

            var stats =
                payload.stats ||
                payload.summary ||
                {};

            var transactions =
                payload.transactions ||
                {};

            var transactionData =
                Array.isArray(transactions)
                    ? transactions
                    : (
                        transactions.data ||
                        []
                    );


            if (
                Number(
                    stats.transactions ||
                    stats.transaction_count ||
                    stats.orders ||
                    0
                ) > 0
            ) {
                return true;
            }


            if (transactionData.length > 0) {
                return true;
            }


            if (
                Array.isArray(payload.products) &&
                payload.products.length > 0
            ) {
                return true;
            }


            if (
                Array.isArray(payload.categories) &&
                payload.categories.length > 0
            ) {
                return true;
            }


            if (
                Array.isArray(payload.payments) &&
                payload.payments.length > 0
            ) {
                return true;
            }


            if (
                Array.isArray(payload.cashiers) &&
                payload.cashiers.length > 0
            ) {
                return true;
            }


            if (
                Array.isArray(payload.customers) &&
                payload.customers.length > 0
            ) {
                return true;
            }


            return false;

        },


        /* ======================================================
           RENDER STATISTICS
        ====================================================== */

        renderStats: function (stats) {

            var grossSales =
                this.firstValue(
                    stats.gross_sales,
                    stats.grossSales,
                    stats.gross,
                    0
                );

            var netSales =
                this.firstValue(
                    stats.net_sales,
                    stats.netSales,
                    stats.total_sales,
                    stats.totalSales,
                    0
                );

            var transactions =
                this.firstValue(
                    stats.transactions,
                    stats.transaction_count,
                    stats.orders,
                    stats.order_count,
                    0
                );

            var averageOrder =
                this.firstValue(
                    stats.average_order_value,
                    stats.averageOrderValue,
                    stats.average_order,
                    stats.averageOrder,
                    0
                );

            var discounts =
                this.firstValue(
                    stats.discounts,
                    stats.discount_total,
                    stats.discountTotal,
                    0
                );

            var tax =
                this.firstValue(
                    stats.tax,
                    stats.tax_total,
                    stats.taxTotal,
                    0
                );

            var returns =
                this.firstValue(
                    stats.returns,
                    stats.return_total,
                    stats.returnTotal,
                    0
                );

            var profit =
                this.firstValue(
                    stats.profit,
                    stats.gross_profit,
                    stats.grossProfit,
                    null
                );


            this.setText(
                this.elements.statGrossSales,
                this.formatCurrency(grossSales)
            );

            this.setText(
                this.elements.statNetSales,
                this.formatCurrency(netSales)
            );

            this.setText(
                this.elements.statTransactions,
                this.formatNumber(transactions)
            );

            this.setText(
                this.elements.statAverageOrder,
                this.formatCurrency(averageOrder)
            );

            this.setText(
                this.elements.statDiscounts,
                this.formatCurrency(discounts)
            );

            this.setText(
                this.elements.statTax,
                this.formatCurrency(tax)
            );

            this.setText(
                this.elements.statReturns,
                this.formatCurrency(returns)
            );


            if (
                profit === null ||
                profit === undefined
            ) {

                this.setText(
                    this.elements.statProfit,
                    '—'
                );

                this.setText(
                    this.elements.statProfitMeta,
                    'Cost data unavailable'
                );

            } else {

                this.setText(
                    this.elements.statProfit,
                    this.formatCurrency(profit)
                );

                this.setText(
                    this.elements.statProfitMeta,
                    'Based on available cost data'
                );

            }


            if (
                this.elements.chartTrendTotal
            ) {

                this.elements.chartTrendTotal.textContent =
                    this.formatCurrency(netSales);

            }

        },


        /* ======================================================
           RENDER CHARTS
        ====================================================== */

        renderCharts: function (charts) {

            if (
                typeof Chart === 'undefined'
            ) {

                console.warn(
                    'Chart.js is not loaded. Sales charts cannot be rendered.'
                );

                return;

            }


            this.renderTrendChart(
                charts.trend ||
                charts.sales_trend ||
                charts.salesTrend ||
                {}
            );


            this.renderPaymentChart(
                charts.payments ||
                charts.payment ||
                charts.payment_performance ||
                []
            );


            this.renderCategoryChart(
                charts.categories ||
                charts.category ||
                charts.category_performance ||
                []
            );

        },


        /* ======================================================
           SALES TREND CHART
        ====================================================== */

        renderTrendChart: function (chartData) {

            if (!this.elements.trendChart) {
                return;
            }

            var labels =
                chartData.labels ||
                [];

            var values =
                chartData.values ||
                chartData.data ||
                [];


            if (
                !Array.isArray(labels) ||
                !Array.isArray(values)
            ) {

                labels = [];
                values = [];

            }


            this.destroyChart('trend');


            this.state.charts.trend =
                new Chart(
                    this.elements.trendChart,
                    {
                        type: 'line',

                        data: {

                            labels: labels,

                            datasets: [
                                {
                                    label: 'Net Sales',

                                    data: values,

                                    tension: 0.35,

                                    borderWidth: 2,

                                    pointRadius: 2,

                                    pointHoverRadius: 4,

                                    fill: true
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
                                    display: false
                                },

                                tooltip: {

                                    callbacks: {

                                        label: function (context) {

                                            return (
                                                ' ' +
                                                context.dataset.label +
                                                ': ' +
                                                this.formatCurrency(
                                                    context.parsed.y
                                                )
                                            );

                                        }.bind(this)

                                    }

                                }

                            },

                            scales: {

                                x: {

                                    grid: {
                                        display: false
                                    },

                                    ticks: {
                                        color: '#8a9099',
                                        font: {
                                            size: 10
                                        }
                                    }

                                },

                                y: {

                                    beginAtZero: true,

                                    grid: {
                                        color: '#eef0f3'
                                    },

                                    ticks: {

                                        color: '#8a9099',

                                        font: {
                                            size: 10
                                        },

                                        callback: function (value) {

                                            return this.formatCompactCurrency(
                                                value
                                            );

                                        }.bind(this)

                                    }

                                }

                            }

                        }

                    }
                );

        },


        /* ======================================================
           PAYMENT CHART
        ====================================================== */

        renderPaymentChart: function (chartData) {

            if (!this.elements.paymentChart) {
                return;
            }

            var labels = [];
            var values = [];


            if (Array.isArray(chartData)) {

                chartData.forEach(
                    function (item) {

                        labels.push(
                            item.label ||
                            item.name ||
                            item.payment_method ||
                            'Unknown'
                        );

                        values.push(
                            Number(
                                item.value ??
                                item.amount ??
                                item.total ??
                                0
                            )
                        );

                    }
                );

            } else {

                labels =
                    chartData.labels ||
                    [];

                values =
                    chartData.values ||
                    chartData.data ||
                    [];

            }


            this.destroyChart('payment');


            this.state.charts.payment =
                new Chart(
                    this.elements.paymentChart,
                    {
                        type: 'doughnut',

                        data: {

                            labels: labels,

                            datasets: [
                                {
                                    data: values,

                                    borderWidth: 0,

                                    hoverOffset: 4
                                }
                            ]

                        },

                        options: {

                            responsive: true,

                            maintainAspectRatio: false,

                            cutout: '68%',

                            plugins: {

                                legend: {

                                    position: 'bottom',

                                    labels: {
                                        usePointStyle: true,
                                        pointStyle: 'circle',
                                        padding: 14,
                                        color: '#666c75',
                                        font: {
                                            size: 10
                                        }
                                    }

                                }

                            }

                        }

                    }
                );

        },


        /* ======================================================
           CATEGORY CHART
        ====================================================== */

        renderCategoryChart: function (chartData) {

            if (!this.elements.categoryChart) {
                return;
            }

            var labels = [];
            var values = [];


            if (Array.isArray(chartData)) {

                chartData.forEach(
                    function (item) {

                        labels.push(
                            item.label ||
                            item.name ||
                            item.category ||
                            'Unknown'
                        );

                        values.push(
                            Number(
                                item.value ??
                                item.amount ??
                                item.net_sales ??
                                item.netSales ??
                                0
                            )
                        );

                    }
                );

            } else {

                labels =
                    chartData.labels ||
                    [];

                values =
                    chartData.values ||
                    chartData.data ||
                    [];

            }


            this.destroyChart('category');


            this.state.charts.category =
                new Chart(
                    this.elements.categoryChart,
                    {
                        type: 'bar',

                        data: {

                            labels: labels,

                            datasets: [
                                {
                                    label: 'Net Sales',

                                    data: values,

                                    borderRadius: 5,

                                    borderSkipped: false,

                                    maxBarThickness: 30
                                }
                            ]

                        },

                        options: {

                            responsive: true,

                            maintainAspectRatio: false,

                            plugins: {

                                legend: {
                                    display: false
                                }

                            },

                            scales: {

                                x: {

                                    grid: {
                                        display: false
                                    },

                                    ticks: {
                                        color: '#8a9099',
                                        font: {
                                            size: 9
                                        }
                                    }

                                },

                                y: {

                                    beginAtZero: true,

                                    grid: {
                                        color: '#eef0f3'
                                    },

                                    ticks: {

                                        color: '#8a9099',

                                        font: {
                                            size: 9
                                        },

                                        callback: function (value) {

                                            return this.formatCompactCurrency(
                                                value
                                            );

                                        }.bind(this)

                                    }

                                }

                            }

                        }

                    }
                );

        },


      
        /* ======================================================
        PRODUCT TABLE
        ====================================================== */
        renderProducts: function (products) {            

            if (!this.elements.productsBody) {
                return;
            }

            if (!Array.isArray(products) || products.length === 0) {
                this.elements.productsBody.innerHTML =
                    this.emptyTableRow(
                        7,
                        'No product performance data available.'
                    );

                this.setText(
                    this.elements.productsCount,
                    '0 products'
                );

                return;
            }

            this.elements.productsBody.innerHTML =
                products.map(
                    function (product) {

                        const unitsSold = Number(
                            product.units_sold ??
                            product.quantity ??
                            0
                        );

                        const revenue = Number(
                            product.revenue ??
                            0
                        );

                        const cogs = Number(
                            product.cogs ??
                            0
                        );

                        const grossProfit = Number(
                            product.gross_profit ??
                            0
                        );

                        const margin = Number(
                            product.margin ??
                            0
                        );

                        return `
                            <tr>

                                <td>
                                    <strong>
                                        ${this.escapeHtml(
                                            product.name ||
                                            product.product_name ||
                                            'Unknown Product'
                                        )}
                                    </strong>
                                </td>

                                <td>
                                    ${this.escapeHtml(
                                        product.category ||
                                        product.category_name ||
                                        '—'
                                    )}
                                </td>

                                <td class="text-end">
                                    ${this.formatNumber(
                                        unitsSold
                                    )}
                                </td>

                                <td class="text-end">
                                    ${this.formatCurrency(
                                        revenue
                                    )}
                                </td>

                                <td class="text-end">
                                    ${this.formatCurrency(
                                        cogs
                                    )}
                                </td>

                                <td class="text-end">
                                    <strong>
                                        ${this.formatCurrency(
                                            grossProfit
                                        )}
                                    </strong>
                                </td>

                                <td class="text-end">
                                    <span class="badge ${
                                        margin >= 0
                                            ? 'text-bg-success'
                                            : 'text-bg-danger'
                                    }">
                                        ${margin.toFixed(2)}%
                                    </span>
                                </td>

                            </tr>
                        `;

                    }.bind(this)
                ).join('');

            this.setText(
                this.elements.productsCount,
                this.formatNumber(products.length) +
                ' products'
            );
        },



        /* ======================================================
           CATEGORY TABLE
        ====================================================== */

        renderCategories: function (categories) {

            if (!this.elements.categoriesBody) {
                return;
            }

            if (
                !Array.isArray(categories) ||
                categories.length === 0
            ) {

                this.elements.categoriesBody.innerHTML =
                    this.emptyTableRow(
                        8,
                        'No category performance data available.'
                    );

                return;

            }


            this.elements.categoriesBody.innerHTML =
                categories.map(
                    function (category) {

                        return `
                            <tr>
                                <td>
                                    <strong>
                                        ${this.escapeHtml(
                                            category.name ||
                                            category.category_name ||
                                            category.category ||
                                            'Unknown Category'
                                        )}
                                    </strong>
                                </td>

                                <td class="text-end">
                                    ${this.formatNumber(
                                        category.products ??
                                        category.product_count ??
                                        0
                                    )}
                                </td>

                                <td class="text-end">
                                    ${this.formatNumber(
                                        category.units_sold ??
                                        category.quantity ??
                                        0
                                    )}
                                </td>

                                <td class="text-end">
                                    ${this.formatNumber(
                                        category.orders ??
                                        category.transactions ??
                                        0
                                    )}
                                </td>

                                <td class="text-end">
                                    ${this.formatCurrency(
                                        category.gross_sales ??
                                        category.grossSales ??
                                        category.gross ??
                                        0
                                    )}
                                </td>

                                <td class="text-end">
                                    ${this.formatCurrency(
                                        category.discount ??
                                        category.discounts ??
                                        0
                                    )}
                                </td>

                                <td class="text-end">
                                    <strong>
                                        ${this.formatCurrency(
                                            category.net_sales ??
                                            category.netSales ??
                                            category.total ??
                                            0
                                        )}
                                    </strong>
                                </td>

                                <td class="text-end">
                                    ${this.formatPercentage(
                                        category.sales_percentage ??
                                        category.percentage ??
                                        category.share ??
                                        0
                                    )}
                                </td>
                            </tr>
                        `;

                    }.bind(this)
                ).join('');

        },


        /* ======================================================
           PAYMENT TABLE
        ====================================================== */

        renderPayments: function (payments) {

            if (!this.elements.paymentsBody) {
                return;
            }

            if (
                !Array.isArray(payments) ||
                payments.length === 0
            ) {

                this.elements.paymentsBody.innerHTML =
                    this.emptyTableRow(
                        4,
                        'No payment performance data available.'
                    );

                return;

            }


            this.elements.paymentsBody.innerHTML =
                payments.map(
                    function (payment) {

                        return `
                            <tr>

                                <td>
                                    <strong>
                                        ${this.escapeHtml(
                                            payment.name ||
                                            payment.payment_method ||
                                            payment.payment_method_name ||
                                            'Unknown'
                                        )}
                                    </strong>
                                </td>

                                <td class="text-end">
                                    ${this.formatNumber(
                                        payment.transactions ??
                                        payment.transaction_count ??
                                        payment.orders ??
                                        0
                                    )}
                                </td>

                                <td class="text-end">
                                    <strong>
                                        ${this.formatCurrency(
                                            payment.amount ??
                                            payment.total ??
                                            payment.value ??
                                            0
                                        )}
                                    </strong>
                                </td>

                                <td class="text-end">
                                    ${this.formatPercentage(
                                        payment.percentage ??
                                        payment.share ??
                                        payment.sales_percentage ??
                                        0
                                    )}
                                </td>

                            </tr>
                        `;

                    }.bind(this)
                ).join('');

        },


        /* ======================================================
           CASHIER TABLE
        ====================================================== */

        renderCashiers: function (cashiers) {

            if (!this.elements.cashiersBody) {
                return;
            }

            if (
                !Array.isArray(cashiers) ||
                cashiers.length === 0
            ) {

                this.elements.cashiersBody.innerHTML =
                    this.emptyTableRow(
                        5,
                        'No cashier performance data available.'
                    );

                return;

            }


            this.elements.cashiersBody.innerHTML =
                cashiers.map(
                    function (cashier) {

                        return `
                            <tr>
                                
                                <td>
                                    <div class="salesperson-name">
                                        <strong>
                                            ${this.escapeHtml(
                                                cashier.name ||
                                                cashier.cashier_name ||
                                                this.buildName(
                                                    cashier.first_name,
                                                    cashier.last_name
                                                ) ||
                                                'Unknown Salesperson'
                                            )}
                                        </strong>

                                        ${
                                            cashier.role
                                                ? `
                                                    <div class="salesperson-role">
                                                        ${this.escapeHtml(cashier.role)}
                                                    </div>
                                                `
                                                : ''
                                        }
                                    </div>
                                </td>



                                <td class="text-end">
                                    ${this.formatNumber(
                                        cashier.transactions ??
                                        cashier.transaction_count ??
                                        cashier.orders ??
                                        0
                                    )}
                                </td>

                                <td class="text-end">
                                    <strong>
                                        ${this.formatCurrency(
                                            cashier.sales ??
                                            cashier.net_sales ??
                                            cashier.total ??
                                            0
                                        )}
                                    </strong>
                                </td>

                                <td class="text-end">
                                    ${this.formatCurrency(
                                        cashier.average_sale ??
                                        cashier.average_order ??
                                        cashier.average_order_value ??
                                        0
                                    )}
                                </td>

                                <td class="text-end">
                                    ${this.formatPercentage(
                                        cashier.share ??
                                        cashier.percentage ??
                                        0
                                    )}
                                </td>

                            </tr>
                        `;

                    }.bind(this)
                ).join('');

        },

      
    /* ======================================================
    CUSTOMER TABLE
    ====================================================== */
    renderCustomers: function (customers) {

        if (!this.elements.customersBody) {
            return;
        }

        if (
            !Array.isArray(customers) ||
            customers.length === 0
        ) {
            this.elements.customersBody.innerHTML =
                this.emptyTableRow(
                    5,
                    'No customer performance data available.'
                );

            return;
        }

        this.elements.customersBody.innerHTML =
            customers.map(
                function (customer) {

                    const customerName =
                        customer.customer ||
                        customer.name ||
                        customer.customer_name ||
                        'Walk-in Customer';

                    const transactions =
                        Number(
                            customer.transactions ??
                            customer.transaction_count ??
                            customer.orders ??
                            0
                        );

                    const items =
                        Number(
                            customer.items ??
                            customer.items_sold ??
                            customer.quantity ??
                            0
                        );

                    const sales =
                        Number(
                            customer.sales ??
                            customer.net_sales ??
                            customer.total ??
                            0
                        );

                    const averageOrder =
                        Number(
                            customer.average_order ??
                            customer.average_order_value ??
                            0
                        );

                    return `
                        <tr>
                            <td>
                                <strong>
                                    ${this.escapeHtml(customerName)}
                                </strong>
                            </td>

                            <td class="text-end">
                                ${this.formatNumber(transactions)}
                            </td>

                            <td class="text-end">
                                ${this.formatNumber(items)}
                            </td>

                            <td class="text-end">
                                <strong>
                                    ${this.formatCurrency(sales)}
                                </strong>
                            </td>

                            <td class="text-end">
                                ${this.formatCurrency(averageOrder)}
                            </td>
                        </tr>
                    `;
                }.bind(this)
            ).join('');
    },



        /* ======================================================
           TRANSACTION TABLE
        ====================================================== */

        renderTransactions: function (transactions) {

            var rows = [];
            var currentPage = this.state.currentPage;
            var total = 0;
            var perPage = this.state.perPage;


            if (Array.isArray(transactions)) {

                rows = transactions;

                total = rows.length;

            } else {

                rows =
                    transactions.data ||
                    transactions.items ||
                    [];

                currentPage =
                    transactions.current_page ||
                    transactions.currentPage ||
                    currentPage;

                total =
                    transactions.total ??
                    rows.length;

                perPage =
                    transactions.per_page ||
                    transactions.perPage ||
                    perPage;

            }


            this.state.currentPage =
                currentPage;

            this.state.totalTransactions =
                total;

            this.state.perPage =
                perPage;


            if (!this.elements.transactionsBody) {
                return;
            }


            if (
                !Array.isArray(rows) ||
                rows.length === 0
            ) {

                this.elements.transactionsBody.innerHTML =
                    this.emptyTableRow(
                        12,
                        'No transactions found for the selected filters.'
                    );

                this.setText(
                    this.elements.transactionsCount,
                    '0 transactions'
                );

                this.renderPagination(
                    0,
                    0,
                    perPage
                );

                return;

            }


            this.elements.transactionsBody.innerHTML =
                rows.map(
                    function (transaction) {

                        var id =
                            transaction.id ||
                            transaction.order_id ||
                            '';


                        var status =
                            transaction.status ||
                            transaction.order_status ||
                            'Completed';


                        return `
                            <tr>

                                <td>
                                    <strong>
                                        ${this.escapeHtml(
                                            transaction.order_no ||
                                            transaction.order_number ||
                                            '—'
                                        )}
                                    </strong>
                                </td>

                                <td>
                                    ${this.escapeHtml(
                                        transaction.date ||
                                        transaction.order_date ||
                                        transaction.created_at ||
                                        '—'
                                    )}
                                </td>

                                <td>
                                    ${this.escapeHtml(
                                        transaction.customer ||
                                        transaction.customer_name ||
                                        'Walk-in Customer'
                                    )}
                                </td>

                                <td>
                                    ${this.escapeHtml(
                                        transaction.cashier ||
                                        transaction.cashier_name ||
                                        '—'
                                    )}
                                </td>

                                <td>
                                    ${this.escapeHtml(
                                        transaction.branch ||
                                        transaction.branch_name ||
                                        '—'
                                    )}
                                </td>

                                <td>
                                    ${this.escapeHtml(
                                        transaction.payment_method ||
                                        transaction.payment ||
                                        '—'
                                    )}
                                </td>

                                <td class="text-end">
                                    ${this.formatCurrency(
                                        transaction.gross_sales ??
                                        transaction.gross ??
                                        0
                                    )}
                                </td>

                                <td class="text-end">
                                    ${this.formatCurrency(
                                        transaction.discount ??
                                        transaction.discounts ??
                                        0
                                    )}
                                </td>

                                <td class="text-end">
                                    ${this.formatCurrency(
                                        transaction.tax ??
                                        0
                                    )}
                                </td>

                                <td class="text-end">
                                    <strong>
                                        ${this.formatCurrency(
                                            transaction.total ??
                                            transaction.net_sales ??
                                            transaction.netSales ??
                                            0
                                        )}
                                    </strong>
                                </td>

                                <td>
                                    ${this.renderStatusBadge(status)}
                                </td>

                                <td class="text-end">

                                    ${
                                        id
                                            ? `
                                                <button
                                                    type="button"
                                                    class="sales-report-inspect-btn"
                                                    data-transaction-id="${this.escapeAttribute(id)}"
                                                    title="View transaction"
                                                    aria-label="View transaction"
                                                >
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            `
                                            : '—'
                                    }

                                </td>

                            </tr>
                        `;

                    }.bind(this)
                ).join('');


            this.setText(
                this.elements.transactionsCount,
                this.formatNumber(total) +
                ' transaction' +
                (Number(total) === 1 ? '' : 's')
            );


            var first =
                total === 0
                    ? 0
                    : ((currentPage - 1) * perPage) + 1;

            var last =
                Math.min(
                    currentPage * perPage,
                    total
                );


            if (this.elements.paginationInfo) {

                this.elements.paginationInfo.textContent =
                    'Showing ' +
                    first +
                    '–' +
                    last +
                    ' of ' +
                    this.formatNumber(total) +
                    ' transactions';

            }


            this.renderPagination(
                currentPage,
                total,
                perPage
            );

        },


        /* ======================================================
           PAGINATION
        ====================================================== */

        renderPagination: function (
            currentPage,
            total,
            perPage
        ) {

            if (!this.elements.paginationControls) {
                return;
            }

            var totalPages =
                Math.ceil(
                    Number(total) /
                    Number(perPage || 1)
                );


            if (totalPages <= 1) {

                this.elements.paginationControls.innerHTML =
                    '';

                return;

            }


            var html = '';

            var previousPage =
                Math.max(
                    currentPage - 1,
                    1
                );

            var nextPage =
                Math.min(
                    currentPage + 1,
                    totalPages
                );


            html += `
                <button
                    type="button"
                    class="btn btn-sm page-link"
                    data-page="${previousPage}"
                    ${currentPage <= 1 ? 'disabled' : ''}
                    aria-label="Previous page"
                >
                    <i class="bi bi-chevron-left"></i>
                </button>
            `;


            var startPage =
                Math.max(
                    1,
                    currentPage - 2
                );

            var endPage =
                Math.min(
                    totalPages,
                    currentPage + 2
                );


            if (startPage > 1) {

                html += `
                    <button
                        type="button"
                        class="btn btn-sm page-link"
                        data-page="1"
                    >
                        1
                    </button>
                `;

                if (startPage > 2) {

                    html += `
                        <span class="page-link border-0 bg-transparent">
                            …
                        </span>
                    `;

                }

            }


            for (
                var page = startPage;
                page <= endPage;
                page++
            ) {

                html += `
                    <button
                        type="button"
                        class="btn btn-sm page-link ${page === currentPage ? 'active' : ''}"
                        data-page="${page}"
                    >
                        ${page}
                    </button>
                `;

            }


            if (endPage < totalPages) {

                if (endPage < totalPages - 1) {

                    html += `
                        <span class="page-link border-0 bg-transparent">
                            …
                        </span>
                    `;

                }

                html += `
                    <button
                        type="button"
                        class="btn btn-sm page-link"
                        data-page="${totalPages}"
                    >
                        ${totalPages}
                    </button>
                `;

            }


            html += `
                <button
                    type="button"
                    class="btn btn-sm page-link"
                    data-page="${nextPage}"
                    ${currentPage >= totalPages ? 'disabled' : ''}
                    aria-label="Next page"
                >
                    <i class="bi bi-chevron-right"></i>
                </button>
            `;


            this.elements.paginationControls.innerHTML =
                html;

        },


        /* ======================================================
           OPEN TRANSACTION INSPECTOR
        ====================================================== */

        openInspector: async function (transactionId) {

            if (!transactionId) {
                return;
            }


            this.resetInspector();

            this.showInspectorLoading();


            if (this.state.inspectorModal) {
                this.state.inspectorModal.show();
            }


            var baseUrl =
                this.elements.page.getAttribute(
                    'data-report-url'
                );


            var url =
                new URL(
                    baseUrl,
                    window.location.origin
                );


            url.searchParams.set(
                'transaction_id',
                transactionId
            );


            url.searchParams.set(
                'details',
                '1'
            );


            try {

                var response =
                    await fetch(
                        url.toString(),
                        {
                            method: 'GET',

                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },

                            credentials: 'same-origin'
                        }
                    );


                if (!response.ok) {

                    var payload =
                        await this.parseResponse(
                            response
                        );

                    throw new Error(
                        payload.message ||
                        'Unable to load transaction details.'
                    );

                }


                var data =
                    await response.json();


                var transaction =
                    data.data?.transaction ||
                    data.transaction ||
                    data.data ||
                    data;


                this.renderInspector(
                    transaction
                );


            } catch (error) {

                console.error(
                    'Sales Transaction Inspector Error:',
                    error
                );

                this.showInspectorError(
                    error.message ||
                    'Unable to load transaction details.'
                );

            } finally {

                this.hideInspectorLoading();

            }

        },


        /* ======================================================
           RENDER INSPECTOR
        ====================================================== */

        renderInspector: function (transaction) {

            if (!transaction) {
                return;
            }


            this.setText(
                this.elements.inspectorOrderNo,
                transaction.order_no ||
                transaction.order_number ||
                '—'
            );


            this.setText(
                this.elements.inspectorDate,
                transaction.date ||
                transaction.order_date ||
                transaction.created_at ||
                '—'
            );


            this.renderInspectorStatus(
                transaction.status ||
                transaction.order_status ||
                'Completed'
            );


            this.setText(
                this.elements.inspectorCustomer,
                transaction.customer ||
                transaction.customer_name ||
                'Walk-in Customer'
            );


            this.setText(
                this.elements.inspectorCashier,
                transaction.cashier ||
                transaction.cashier_name ||
                '—'
            );


            this.setText(
                this.elements.inspectorBranch,
                transaction.branch ||
                transaction.branch_name ||
                '—'
            );


            this.setText(
                this.elements.inspectorTerminal,
                transaction.terminal ||
                transaction.terminal_name ||
                '—'
            );


            this.setText(
                this.elements.inspectorPaymentMethod,
                transaction.payment_method ||
                transaction.payment ||
                '—'
            );


            this.setText(
                this.elements.inspectorPaymentReference,
                transaction.payment_reference ||
                transaction.reference_no ||
                transaction.reference ||
                '—'
            );


            this.setText(
                this.elements.inspectorAmountPaid,
                this.formatCurrency(
                    transaction.amount_paid ??
                    transaction.paid_amount ??
                    transaction.total ??
                    0
                )
            );


            this.setText(
                this.elements.inspectorGross,
                this.formatCurrency(
                    transaction.gross_sales ??
                    transaction.gross ??
                    0
                )
            );


            this.setText(
                this.elements.inspectorDiscount,
                this.formatCurrency(
                    transaction.discount ??
                    transaction.discounts ??
                    0
                )
            );


            this.setText(
                this.elements.inspectorTax,
                this.formatCurrency(
                    transaction.tax ??
                    0
                )
            );


            this.setText(
                this.elements.inspectorTotal,
                this.formatCurrency(
                    transaction.total ??
                    transaction.net_sales ??
                    0
                )
            );


            this.renderInspectorItems(
                transaction.items ||
                transaction.order_items ||
                []
            );


            this.hideInspectorLoading();

        },


        /* ======================================================
           INSPECTOR ITEMS
        ====================================================== */

        renderInspectorItems: function (items) {

            if (!this.elements.inspectorItemsBody) {
                return;
            }


            if (
                !Array.isArray(items) ||
                items.length === 0
            ) {

                this.elements.inspectorItemsBody.innerHTML =
                    `
                        <tr>
                            <td
                                colspan="6"
                                class="text-center text-muted"
                            >
                                No items available.
                            </td>
                        </tr>
                    `;

                return;

            }


            this.elements.inspectorItemsBody.innerHTML =
                items.map(
                    function (item) {

                        return `
                            <tr>

                                <td>
                                    <strong>
                                        ${this.escapeHtml(
                                            item.product ||
                                            item.product_name ||
                                            item.name ||
                                            'Unknown Product'
                                        )}
                                    </strong>
                                </td>

                                <td class="text-end">
                                    ${this.formatNumber(
                                        item.quantity ??
                                        item.qty ??
                                        0
                                    )}
                                </td>

                                <td class="text-end">
                                    ${this.formatCurrency(
                                        item.unit_price ??
                                        item.price ??
                                        0
                                    )}
                                </td>

                                <td class="text-end">
                                    ${this.formatCurrency(
                                        item.discount ??
                                        0
                                    )}
                                </td>

                                <td class="text-end">
                                    ${this.formatCurrency(
                                        item.tax ??
                                        0
                                    )}
                                </td>

                                <td class="text-end">
                                    <strong>
                                        ${this.formatCurrency(
                                            item.total ??
                                            item.line_total ??
                                            0
                                        )}
                                    </strong>
                                </td>

                            </tr>
                        `;

                    }.bind(this)
                ).join('');

        },


        /* ======================================================
           INSPECTOR STATUS
        ====================================================== */

        renderInspectorStatus: function (status) {

            if (!this.elements.inspectorStatus) {
                return;
            }


            var normalized =
                String(status || '')
                    .toLowerCase()
                    .replace(/[\s_-]+/g, '');


            var className =
                'sales-report-status-badge ';


            if (normalized === 'completed') {

                className +=
                    'sales-report-status-completed';

            } else if (
                normalized === 'pending' ||
                normalized === 'held'
            ) {

                className +=
                    'sales-report-status-pending';

            } else if (
                normalized === 'cancelled' ||
                normalized === 'canceled'
            ) {

                className +=
                    'sales-report-status-cancelled';

            } else if (
                normalized === 'refunded' ||
                normalized === 'returned'
            ) {

                className +=
                    'sales-report-status-refunded';

            } else {

                className +=
                    'sales-report-status-pending';

            }


            this.elements.inspectorStatus.className =
                className;

            this.elements.inspectorStatus.textContent =
                status || '—';

        },


        /* ======================================================
           INSPECTOR RESET
        ====================================================== */

        resetInspector: function () {

            var fields = [
                this.elements.inspectorOrderNo,
                this.elements.inspectorDate,
                this.elements.inspectorCustomer,
                this.elements.inspectorCashier,
                this.elements.inspectorBranch,
                this.elements.inspectorTerminal,
                this.elements.inspectorPaymentMethod,
                this.elements.inspectorPaymentReference
            ];


            fields.forEach(
                function (element) {

                    if (element) {
                        element.textContent = '—';
                    }

                }
            );


            this.setText(
                this.elements.inspectorAmountPaid,
                '₦0.00'
            );

            this.setText(
                this.elements.inspectorGross,
                '₦0.00'
            );

            this.setText(
                this.elements.inspectorDiscount,
                '₦0.00'
            );

            this.setText(
                this.elements.inspectorTax,
                '₦0.00'
            );

            this.setText(
                this.elements.inspectorTotal,
                '₦0.00'
            );


            if (this.elements.inspectorItemsBody) {

                this.elements.inspectorItemsBody.innerHTML =
                    `
                        <tr>
                            <td
                                colspan="6"
                                class="text-center"
                            >
                                Loading items...
                            </td>
                        </tr>
                    `;

            }


            if (this.elements.inspectorStatus) {

                this.elements.inspectorStatus.className =
                    'badge';

                this.elements.inspectorStatus.textContent =
                    '—';

            }

        },


        /* ======================================================
           INSPECTOR LOADING
        ====================================================== */

        showInspectorLoading: function () {

            if (this.elements.inspectorLoading) {
                this.elements.inspectorLoading.classList.remove(
                    'd-none'
                );
            }

            if (this.elements.inspectorContent) {
                this.elements.inspectorContent.classList.add(
                    'd-none'
                );
            }

        },


        hideInspectorLoading: function () {

            if (this.elements.inspectorLoading) {
                this.elements.inspectorLoading.classList.add(
                    'd-none'
                );
            }

            if (this.elements.inspectorContent) {
                this.elements.inspectorContent.classList.remove(
                    'd-none'
                );
            }

        },


        /* ======================================================
           INSPECTOR ERROR
        ====================================================== */

        showInspectorError: function (message) {

            if (this.elements.inspectorContent) {

                this.elements.inspectorContent.classList.remove(
                    'd-none'
                );

                this.elements.inspectorContent.innerHTML =
                    `
                        <div class="sales-report-error">
                            <div class="sales-report-error-icon">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>

                            <h3>
                                Unable to load transaction
                            </h3>

                            <p>
                                ${this.escapeHtml(message)}
                            </p>
                        </div>
                    `;

            }

        },


        /* ======================================================
           EXPORT REPORT
        ====================================================== */

        exportReport: function (format) {

            if (!format) {
                return;
            }


            var url =
                this.elements.page.getAttribute(
                    'data-export-url'
                );


            if (!url) {
                return;
            }


            this.collectFilters();


            var params =
                new URLSearchParams(
                    this.state.filters
                );


            params.set(
                'format',
                format
            );


            var exportUrl =
                url +
                '?' +
                params.toString();


            window.location.href =
                exportUrl;

        },


        /* ======================================================
           LOADING STATE
        ====================================================== */

        showLoadingState: function () {

            if (this.elements.loading) {
                this.elements.loading.classList.remove(
                    'd-none'
                );
            }

            if (this.elements.data) {
                this.elements.data.classList.add(
                    'd-none'
                );
            }

            if (this.elements.empty) {
                this.elements.empty.classList.add(
                    'd-none'
                );
            }

            if (this.elements.error) {
                this.elements.error.classList.add(
                    'd-none'
                );
            }

            this.setLoadingButton(true);

        },


        /* ======================================================
           DATA STATE
        ====================================================== */

        showDataState: function () {

            if (this.elements.loading) {
                this.elements.loading.classList.add(
                    'd-none'
                );
            }

            if (this.elements.data) {
                this.elements.data.classList.remove(
                    'd-none'
                );
            }

            if (this.elements.empty) {
                this.elements.empty.classList.add(
                    'd-none'
                );
            }

            if (this.elements.error) {
                this.elements.error.classList.add(
                    'd-none'
                );
            }

        },


        /* ======================================================
           EMPTY STATE
        ====================================================== */

        showEmptyState: function () {

            if (this.elements.loading) {
                this.elements.loading.classList.add(
                    'd-none'
                );
            }

            if (this.elements.data) {
                this.elements.data.classList.add(
                    'd-none'
                );
            }

            if (this.elements.empty) {
                this.elements.empty.classList.remove(
                    'd-none'
                );
            }

            if (this.elements.error) {
                this.elements.error.classList.add(
                    'd-none'
                );
            }

        },


        /* ======================================================
           ERROR STATE
        ====================================================== */

        showErrorState: function (message) {

            if (this.elements.loading) {
                this.elements.loading.classList.add(
                    'd-none'
                );
            }

            if (this.elements.data) {
                this.elements.data.classList.add(
                    'd-none'
                );
            }

            if (this.elements.empty) {
                this.elements.empty.classList.add(
                    'd-none'
                );
            }

            if (this.elements.error) {
                this.elements.error.classList.remove(
                    'd-none'
                );
            }

            this.setText(
                this.elements.errorMessage,
                message
            );

        },


        /* ======================================================
           EMPTY TABLES
        ====================================================== */

        renderEmptyTables: function () {

            if (this.elements.productsBody) {
                this.elements.productsBody.innerHTML =
                    this.emptyTableRow(
                        7,
                        'No product performance data available.'
                    );
            }

            if (this.elements.categoriesBody) {
                this.elements.categoriesBody.innerHTML =
                    this.emptyTableRow(
                        8,
                        'No category performance data available.'
                    );
            }

            if (this.elements.paymentsBody) {
                this.elements.paymentsBody.innerHTML =
                    this.emptyTableRow(
                        4,
                        'No payment performance data available.'
                    );
            }

            if (this.elements.cashiersBody) {
                this.elements.cashiersBody.innerHTML =
                    this.emptyTableRow(
                        5,
                        'No cashier performance data available.'
                    );
            }

            if (this.elements.customersBody) {
                this.elements.customersBody.innerHTML =
                    this.emptyTableRow(
                        5,
                        'No customer performance data available.'
                    );
            }

            if (this.elements.transactionsBody) {
                this.elements.transactionsBody.innerHTML =
                    this.emptyTableRow(
                        12,
                        'No transactions found.'
                    );
            }

        },


        /* ======================================================
           TABLE EMPTY ROW
        ====================================================== */

        emptyTableRow: function (
            colspan,
            message
        ) {

            return `
                <tr class="sales-report-table-placeholder">
                    <td colspan="${colspan}">
                        <div class="sales-report-inline-empty">
                            <i class="bi bi-inbox"></i>
                            <span>
                                ${this.escapeHtml(message)}
                            </span>
                        </div>
                    </td>
                </tr>
            `;

        },


        /* ======================================================
           STATUS BADGE
        ====================================================== */

        renderStatusBadge: function (status) {

            var normalized =
                String(status || '')
                    .toLowerCase()
                    .replace(/[\s_-]+/g, '');


            var className =
                'sales-report-status-badge ';


            if (normalized === 'completed') {

                className +=
                    'sales-report-status-completed';

            } else if (
                normalized === 'pending' ||
                normalized === 'held'
            ) {

                className +=
                    'sales-report-status-pending';

            } else if (
                normalized === 'cancelled' ||
                normalized === 'canceled'
            ) {

                className +=
                    'sales-report-status-cancelled';

            } else if (
                normalized === 'refunded' ||
                normalized === 'returned'
            ) {

                className +=
                    'sales-report-status-refunded';

            } else {

                className +=
                    'sales-report-status-pending';

            }


            return `
                <span class="${className}">
                    ${this.escapeHtml(
                        status || '—'
                    )}
                </span>
            `;

        },


        /* ======================================================
           DESTROY ONE CHART
        ====================================================== */

        destroyChart: function (name) {

            if (
                this.state.charts[name] &&
                typeof this.state.charts[name].destroy === 'function'
            ) {

                this.state.charts[name].destroy();

                this.state.charts[name] = null;

            }

        },


        /* ======================================================
           DESTROY ALL CHARTS
        ====================================================== */

        destroyCharts: function () {

            this.destroyChart('trend');

            this.destroyChart('payment');

            this.destroyChart('category');

        },


        /* ======================================================
           BUTTON LOADING
        ====================================================== */

        setLoadingButton: function (loading) {

            var button =
                this.elements.applyFilters;


            if (!button) {
                return;
            }


            if (loading) {

                if (
                    !button.dataset.originalHtml
                ) {

                    button.dataset.originalHtml =
                        button.innerHTML;

                }

                button.disabled = true;

                button.classList.add(
                    'is-loading'
                );

                button.innerHTML =
                    `
                        <span
                            class="spinner-border spinner-border-sm"
                            aria-hidden="true"
                        ></span>

                        Loading...
                    `;

            } else {

                button.disabled = false;

                button.classList.remove(
                    'is-loading'
                );

                if (
                    button.dataset.originalHtml
                ) {

                    button.innerHTML =
                        button.dataset.originalHtml;

                }

            }

        },


        /* ======================================================
           NUMBER FORMAT
        ====================================================== */

        formatNumber: function (value) {

            var number =
                Number(value || 0);


            return new Intl.NumberFormat(
                'en-NG',
                {
                    maximumFractionDigits: 0
                }
            ).format(number);

        },


        /* ======================================================
           CURRENCY FORMAT
        ====================================================== */

        formatCurrency: function (value) {

            if (
                value === null ||
                value === undefined ||
                value === ''
            ) {
                value = 0;
            }


            var number =
                Number(value);


            if (!Number.isFinite(number)) {
                number = 0;
            }


            return new Intl.NumberFormat(
                'en-NG',
                {
                    style: 'currency',
                    currency: this.state.currency,
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }
            ).format(number);

        },


        /* ======================================================
           COMPACT CURRENCY
        ====================================================== */

        formatCompactCurrency: function (value) {

            var number =
                Number(value || 0);


            if (Math.abs(number) >= 1000000000) {

                return (
                    '₦' +
                    (number / 1000000000)
                        .toFixed(1) +
                    'B'
                );

            }


            if (Math.abs(number) >= 1000000) {

                return (
                    '₦' +
                    (number / 1000000)
                        .toFixed(1) +
                    'M'
                );

            }


            if (Math.abs(number) >= 1000) {

                return (
                    '₦' +
                    (number / 1000)
                        .toFixed(1) +
                    'K'
                );

            }


            return (
                '₦' +
                this.formatNumber(number)
            );

        },


        /* ======================================================
           PERCENTAGE FORMAT
        ====================================================== */

        formatPercentage: function (value) {

            var number =
                Number(value || 0);


            return (
                number.toFixed(1) +
                '%'
            );

        },


        /* ======================================================
           FIRST AVAILABLE VALUE
        ====================================================== */

        firstValue: function () {

            var args =
                Array.prototype.slice.call(
                    arguments
                );


            for (
                var i = 0;
                i < args.length;
                i++
            ) {

                if (
                    args[i] !== undefined &&
                    args[i] !== null
                ) {

                    return args[i];

                }

            }


            return null;

        },


        /* ======================================================
           BUILD NAME
        ====================================================== */

        buildName: function (
            firstName,
            lastName
        ) {

            return (
                String(firstName || '') +
                ' ' +
                String(lastName || '')
            ).trim();

        },


        /* ======================================================
           SET TEXT
        ====================================================== */

        setText: function (
            element,
            value
        ) {

            if (!element) {
                return;
            }

            element.textContent =
                value === undefined ||
                value === null
                    ? ''
                    : value;

        },


        /* ======================================================
           HTML ESCAPE
        ====================================================== */

        escapeHtml: function (value) {

            if (
                value === null ||
                value === undefined
            ) {
                return '';
            }


            var div =
                document.createElement('div');

            div.textContent =
                String(value);

            return div.innerHTML;

        },


        /* ======================================================
           ATTRIBUTE ESCAPE
        ====================================================== */

        escapeAttribute: function (value) {

            return this.escapeHtml(value)
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');

        }

    };


    /* ==========================================================
       AUTO INITIALIZATION
    ========================================================== */

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            window.SalesReport.init();

        }
    );


})();