/**
 * ============================================================================
 * EMNEX POS - CASH DRAWER
 * ============================================================================
 */

const CashDrawer = {

    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    state: {

        currentDrawer: null,

        transactionPage: 1,

        historyPage: 1,

        transactionSearch: '',

        transactionType: '',

        historySearch: '',

        selectedTransaction: null,

        selectedDrawer: null,

        confirmationAction: null,

        confirmationType: null,

        transactionSearchTimer: null,

        historySearchTimer: null,

    },


    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    elements: {},


    /*
    |--------------------------------------------------------------------------
    | Modals
    |--------------------------------------------------------------------------
    */

    modals: {},


    /*
    |--------------------------------------------------------------------------
    | Init
    |--------------------------------------------------------------------------
    */

    init() {

        this.cacheElements();

        this.initializeComponents();

        this.bindEvents();

        this.loadCurrentDrawer();

        this.loadTransactions();

        this.loadHistory();

    },


    /*
    |--------------------------------------------------------------------------
    | Cache Elements
    |--------------------------------------------------------------------------
    */

    cacheElements() {

        this.elements = {

            drawerStatusBadge:
                document.getElementById(
                    'drawer-status-badge'
                ),

            openDrawerBtn:
                document.getElementById(
                    'open-drawer-btn'
                ),

            refreshDrawerBtn:
                document.getElementById(
                    'refresh-drawer-btn'
                ),

            closeDrawerBtn:
                document.getElementById(
                    'close-drawer-btn'
                ),

            cashInBtn:
                document.getElementById(
                    'cash-in-btn'
                ),

            cashOutBtn:
                document.getElementById(
                    'cash-out-btn'
                ),


            drawerTerminalName:
                document.getElementById(
                    'drawer-terminal-name'
                ),

            drawerBranchName:
                document.getElementById(
                    'drawer-branch-name'
                ),

            drawerOpenedBy:
                document.getElementById(
                    'drawer-opened-by'
                ),

            drawerOpenedAt:
                document.getElementById(
                    'drawer-opened-at'
                ),

            drawerOpeningBalance:
                document.getElementById(
                    'drawer-opening-balance'
                ),


            kpiOpeningBalance:
                document.getElementById(
                    'kpi-opening-balance'
                ),

            kpiCashSales:
                document.getElementById(
                    'kpi-cash-sales'
                ),

            cashSalesInfo:
                document.getElementById(
                    'cashSalesInfo'
                ),

            kpiOtherCashSales:
                document.getElementById(
                    'kpi-other-cash-sales'
                ),

            otherCashSalesInfo:
                document.getElementById(
                    'otherCashSalesInfo'
                ),

            kpiCashIn:
                document.getElementById(
                    'kpi-cash-in'
                ),

            kpiCashOut:
                document.getElementById(
                    'kpi-cash-out'
                ),

            kpiCashRefunds:
                document.getElementById(
                    'kpi-cash-refunds'
                ),

            kpiExpectedBalance:
                document.getElementById(
                    'kpi-expected-balance'
                ),

            kpiCurrentBalance:
                document.getElementById(
                    'kpi-current-balance'
                ),

            heroCurrentBalance:
                document.getElementById(
                    'hero-current-balance'
                ),


            cashActionsCard:
                document.getElementById(
                    'cash-actions-card'
                ),


            transactionTypeFilter:
                document.getElementById(
                    'transaction-type-filter'
                ),

            transactionSearch:
                document.getElementById(
                    'transaction-search'
                ),

            transactionBody:
                document.getElementById(
                    'cash-drawer-transactions-body'
                ),

            transactionPagination:
                document.getElementById(
                    'transactions-pagination'
                ),


            historySearch:
                document.getElementById(
                    'drawer-history-search'
                ),

            historyBody:
                document.getElementById(
                    'cash-drawer-history-body'
                ),

            historyPagination:
                document.getElementById(
                    'drawer-history-pagination'
                ),


            /*
            |--------------------------------------------------------------------------
            | Open Drawer Form
            |--------------------------------------------------------------------------
            */
           openDrawerBranchId:
                document.getElementById(
                    'open-drawer-branch-id'
                ),

            openDrawerTerminalId:
                document.getElementById(
                    'open-drawer-terminal-id'
                ),

            openDrawerForm:
                document.getElementById(
                    'open-drawer-form'
                ),

            openingBalance:
                document.getElementById(
                    'opening_balance'
                ),

            openingRemarks:
                document.getElementById(
                    'opening_remarks'
                ),

            openDrawerSubmit:
                document.getElementById(
                    'open-drawer-submit'
                ),


            /*
            |--------------------------------------------------------------------------
            | Cash In Form
            |--------------------------------------------------------------------------
            */

            cashInForm:
                document.getElementById(
                    'cash-in-form'
                ),

            cashInAmount:
                document.getElementById(
                    'cash_in_amount'
                ),

            cashInReference:
                document.getElementById(
                    'cash_in_reference_no'
                ),

            cashInRemarks:
                document.getElementById(
                    'cash_in_remarks'
                ),

            cashInSubmit:
                document.getElementById(
                    'cash-in-submit'
                ),


            /*
            |--------------------------------------------------------------------------
            | Cash Out Form
            |--------------------------------------------------------------------------
            */

            cashOutForm:
                document.getElementById(
                    'cash-out-form'
                ),

            cashOutAmount:
                document.getElementById(
                    'cash_out_amount'
                ),

            cashOutReference:
                document.getElementById(
                    'cash_out_reference_no'
                ),

            cashOutRemarks:
                document.getElementById(
                    'cash_out_remarks'
                ),

            cashOutSubmit:
                document.getElementById(
                    'cash-out-submit'
                ),


            /*
            |--------------------------------------------------------------------------
            | Close Drawer Form
            |--------------------------------------------------------------------------
            */

            closeDrawerForm:
                document.getElementById(
                    'close-drawer-form'
                ),

            closeExpectedBalance:
                document.getElementById(
                    'close-expected-balance'
                ),

            closeCashSales:
                document.getElementById(
                    'close-cash-sales'
                ),

            actualBalance:
                document.getElementById(
                    'actual_balance'
                ),

            variancePreview:
                document.getElementById(
                    'variance-preview'
                ),

            variancePreviewValue:
                document.getElementById(
                    'variance-preview-value'
                ),

            closingRemarks:
                document.getElementById(
                    'closing_remarks'
                ),

            closeDrawerSubmit:
                document.getElementById(
                    'close-drawer-submit'
                ),


            /*
            |--------------------------------------------------------------------------
            | Transaction Inspector
            |--------------------------------------------------------------------------
            */

            transactionInspectorNumber:
                document.getElementById(
                    'transaction-inspector-number'
                ),

            inspectorTransactionType:
                document.getElementById(
                    'inspector-transaction-type'
                ),

            inspectorAmount:
                document.getElementById(
                    'inspector-amount'
                ),

            inspectorBalanceBefore:
                document.getElementById(
                    'inspector-balance-before'
                ),

            inspectorBalanceAfter:
                document.getElementById(
                    'inspector-balance-after'
                ),

            inspectorReference:
                document.getElementById(
                    'inspector-reference'
                ),

            inspectorCreatedBy:
                document.getElementById(
                    'inspector-created-by'
                ),

            inspectorCreatedAt:
                document.getElementById(
                    'inspector-created-at'
                ),

            inspectorRemarks:
                document.getElementById(
                    'inspector-remarks'
                ),


            /*
            |--------------------------------------------------------------------------
            | Drawer Inspector
            |--------------------------------------------------------------------------
            */

            drawerInspectorStatus:
                document.getElementById(
                    'drawer-inspector-status'
                ),

            historyOpeningBalance:
                document.getElementById(
                    'history-opening-balance'
                ),

            historyCashSales:
                document.getElementById(
                    'history-cash-sales'
                ),

            historyCashIn:
                document.getElementById(
                    'history-cash-in'
                ),

            historyCashOut:
                document.getElementById(
                    'history-cash-out'
                ),

            historyExpectedBalance:
                document.getElementById(
                    'history-expected-balance'
                ),

            historyActualBalance:
                document.getElementById(
                    'history-actual-balance'
                ),

            historyVariance:
                document.getElementById(
                    'history-variance'
                ),

            historyOpenedBy:
                document.getElementById(
                    'history-opened-by'
                ),

            historyOpenedAt:
                document.getElementById(
                    'history-opened-at'
                ),

            historyClosedBy:
                document.getElementById(
                    'history-closed-by'
                ),

            historyClosedAt:
                document.getElementById(
                    'history-closed-at'
                ),

            historyClosingRemarks:
                document.getElementById(
                    'history-closing-remarks'
                ),


            /*
            |--------------------------------------------------------------------------
            | Confirmation
            |--------------------------------------------------------------------------
            */

            confirmationIcon:
                document.getElementById(
                    'confirmation-icon'
                ),

            confirmationTitle:
                document.getElementById(
                    'confirmation-title'
                ),

            confirmationMessage:
                document.getElementById(
                    'confirmation-message'
                ),

            confirmationSubmit:
                document.getElementById(
                    'confirmation-submit'
                ),

        };

    },


    /*
    |--------------------------------------------------------------------------
    | Bootstrap Components
    |--------------------------------------------------------------------------
    */

    initializeComponents() {

        this.modals = {

            openDrawer:
                this.getModal(
                    'openDrawerModal'
                ),

            cashIn:
                this.getModal(
                    'cashInModal'
                ),

            cashOut:
                this.getModal(
                    'cashOutModal'
                ),

            closeDrawer:
                this.getModal(
                    'closeDrawerModal'
                ),

            confirmation:
                this.getModal(
                    'cashDrawerConfirmationModal'
                ),

        };

        this.transactionInspector =
            this.getOffcanvas(
                'cashDrawerTransactionInspector'
            );

        this.drawerInspector =
            this.getOffcanvas(
                'cashDrawerInspector'
            );

    },


    getModal(id) {

        const element =
            document.getElementById(id);

        if (!element) {
            return null;
        }

        return bootstrap.Modal.getOrCreateInstance(
            element
        );

    },


    getOffcanvas(id) {

        const element =
            document.getElementById(id);

        if (!element) {
            return null;
        }

        return bootstrap.Offcanvas.getOrCreateInstance(
            element
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

    bindEvents() {

        this.elements.openDrawerBtn?.addEventListener(
            'click',
            () => this.openDrawerModal()
        );

        this.elements.refreshDrawerBtn?.addEventListener(
            'click',
            () => this.refresh()
        );

        this.elements.closeDrawerBtn?.addEventListener(
            'click',
            () => this.openCloseDrawerModal()
        );

        this.elements.cashInBtn?.addEventListener(
            'click',
            () => this.openCashInModal()
        );

        this.elements.cashOutBtn?.addEventListener(
            'click',
            () => this.openCashOutModal()
        );


        this.elements.openDrawerForm?.addEventListener(
            'submit',
            (event) => {

                event.preventDefault();

                this.submitOpenDrawer();

            }
        );


        this.elements.cashInForm?.addEventListener(
            'submit',
            (event) => {

                event.preventDefault();

                this.submitCashIn();

            }
        );


        this.elements.cashOutForm?.addEventListener(
            'submit',
            (event) => {

                event.preventDefault();

                this.submitCashOut();

            }
        );


        this.elements.closeDrawerForm?.addEventListener(
            'submit',
            (event) => {

                event.preventDefault();

                this.submitCloseDrawer();

            }
        );


        this.elements.actualBalance?.addEventListener(
            'input',
            () => this.updateVariancePreview()
        );


        this.elements.transactionTypeFilter?.addEventListener(
            'change',
            () => {

                this.state.transactionType =
                    this.elements.transactionTypeFilter.value;

                this.state.transactionPage = 1;

                this.loadTransactions();

            }
        );


        this.elements.transactionSearch?.addEventListener(
            'input',
            () => {

                clearTimeout(
                    this.state.transactionSearchTimer
                );

                this.state.transactionSearchTimer =
                    setTimeout(() => {

                        this.state.transactionSearch =
                            this.elements.transactionSearch.value
                                .trim();

                        this.state.transactionPage = 1;

                        this.loadTransactions();

                    }, 400);

            }
        );


        this.elements.historySearch?.addEventListener(
            'input',
            () => {

                clearTimeout(
                    this.state.historySearchTimer
                );

                this.state.historySearchTimer =
                    setTimeout(() => {

                        this.state.historySearch =
                            this.elements.historySearch.value
                                .trim();

                        this.state.historyPage = 1;

                        this.loadHistory();

                    }, 400);

            }
        );


        this.elements.confirmationSubmit?.addEventListener(
            'click',
            () => this.executeConfirmation()
        );

    },


/*
|--------------------------------------------------------------------------
| Current Drawer
|--------------------------------------------------------------------------
*/

/**
 * Load current cash drawer.
 */
async loadCurrentDrawer() {

    try {

        const response =
            await this.request(
                CashDrawerConfig.urls.current,
                'GET'
            );

        /*
        |--------------------------------------------------------------------------
        | Store Complete Current Drawer Response
        |--------------------------------------------------------------------------
        */

        this.state.currentDrawer = {

            drawer:
                response.drawer
                ?? null,

            terminal:
                response.terminal
                ?? null,

            branch:
                response.branch
                ?? null,

            kpis:
                response.kpis
                ?? null,

        };

        /*
        |--------------------------------------------------------------------------
        | Render
        |--------------------------------------------------------------------------
        */

        this.renderCurrentDrawer();

    } catch (error) {

        console.error(
            'Failed to load current cash drawer:',
            error
        );

        /*
        |--------------------------------------------------------------------------
        | Do NOT Reset Existing Drawer
        |--------------------------------------------------------------------------
        |
        | A failed request must not destroy already loaded
        | drawer information.
        |
        */

        if (
            this.state.currentDrawer?.drawer
        ) {

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | No Existing Drawer
        |--------------------------------------------------------------------------
        */

        this.state.currentDrawer = {

            drawer: null,

            terminal: null,

            branch: null,

            kpis: null,

        };

        this.renderCurrentDrawer();
    }
},

/*
|--------------------------------------------------------------------------
| Render Current Drawer
|--------------------------------------------------------------------------
*/

/**
 * Render current cash drawer.
 */
renderCurrentDrawer() {

    const state =
        this.state.currentDrawer;

    /*
    |--------------------------------------------------------------------------
    | Waiting For Drawer Response
    |--------------------------------------------------------------------------
    |
    | Do not reset the UI while the current drawer request
    | has not yet populated the state.
    |
    */

    if (state === null || state === undefined) {

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | No Current Drawer
    |--------------------------------------------------------------------------
    |
    | At this point the API has responded and explicitly
    | confirmed that there is no open drawer.
    |
    */

    if (!state.drawer) {

        this.setDrawerClosedState();

        this.resetKpis();

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Drawer Data
    |--------------------------------------------------------------------------
    */

    const drawer =
        state.drawer;

    const terminal =
        state.terminal;

    const branch =
        state.branch;

    const kpis =
        state.kpis ?? {};

    /*
    |--------------------------------------------------------------------------
    | Drawer State
    |--------------------------------------------------------------------------
    */

    this.setDrawerOpenState();

    /*
    |--------------------------------------------------------------------------
    | Terminal
    |--------------------------------------------------------------------------
    */

    this.setText(
        this.elements.drawerTerminalName,
        terminal?.name
        ?? '—'
    );

    /*
    |--------------------------------------------------------------------------
    | Branch
    |--------------------------------------------------------------------------
    */

    this.setText(
        this.elements.drawerBranchName,
        branch?.name
        ?? '—'
    );

    /*
    |--------------------------------------------------------------------------
    | Opened By
    |--------------------------------------------------------------------------
    */

    this.setText(
        this.elements.drawerOpenedBy,
        drawer.opened_by
        ?? '—'
    );

    /*
    |--------------------------------------------------------------------------
    | Opened At
    |--------------------------------------------------------------------------
    */

    this.setText(
        this.elements.drawerOpenedAt,
        this.formatDateTime(
            drawer.opened_at
        )
    );

    /*
    |--------------------------------------------------------------------------
    | Opening Balance
    |--------------------------------------------------------------------------
    */

    this.setMoney(
        this.elements.drawerOpeningBalance,
        drawer.opening_balance
        ?? kpis.opening_balance
        ?? 0
    );

    this.setMoney(
        this.elements.heroCurrentBalance,
        kpis.current_balance
            ?? kpis.expected_balance
            ?? 0
    );

    /*
    |--------------------------------------------------------------------------
    | KPIs
    |--------------------------------------------------------------------------
    */

    this.updateKpis(
        kpis
    );
},

/*
|--------------------------------------------------------------------------
| Drawer State
|--------------------------------------------------------------------------
*/

/**
 * Set drawer open state.
 */
setDrawerOpenState() {

    if (
        this.elements.drawerStatusBadge
    ) {

        this.elements.drawerStatusBadge.textContent =
            'Open';

        this.elements.drawerStatusBadge.className =
            'badge bg-success-subtle text-success';

    }

    this.toggle(

        this.elements.openDrawerBtn,

        false

    );

    this.toggle(

        this.elements.refreshDrawerBtn,

        true

    );

    this.toggle(

        this.elements.closeDrawerBtn,

        true

    );

    if (
        this.elements.cashInBtn
    ) {

        this.elements.cashInBtn.disabled =
            false;

    }

    if (
        this.elements.cashOutBtn
    ) {

        this.elements.cashOutBtn.disabled =
            false;

    }

},


   

    setDrawerClosedState() {

        if (this.elements.drawerStatusBadge) {

            this.elements.drawerStatusBadge.textContent =
                'Closed';

            this.elements.drawerStatusBadge.className =
                'badge bg-secondary-subtle text-secondary';

        }


        this.toggle(
            this.elements.openDrawerBtn,
            true
        );

        this.toggle(
            this.elements.refreshDrawerBtn,
            false
        );

        this.toggle(
            this.elements.closeDrawerBtn,
            false
        );


        if (this.elements.cashInBtn) {

            this.elements.cashInBtn.disabled =
                true;

        }

        if (this.elements.cashOutBtn) {

            this.elements.cashOutBtn.disabled =
                true;

        }


        // this.setText(
        //     this.elements.drawerTerminalName,
        //     '—'
        // );

        // this.setText(
        //     this.elements.drawerBranchName,
        //     '—'
        // );

        this.setText(
            this.elements.drawerOpenedBy,
            '—'
        );

        this.setText(
            this.elements.drawerOpenedAt,
            '—'
        );

        this.setMoney(
            this.elements.drawerOpeningBalance,
            0
        );

    },



    /*
|--------------------------------------------------------------------------
| KPIs
|--------------------------------------------------------------------------
*/

/**
 * Update cash drawer KPIs.
 */
updateKpis(drawer) {

    /*
    |--------------------------------------------------------------------------
    | Opening Balance
    |--------------------------------------------------------------------------
    */

    this.setMoney(
        this.elements.kpiOpeningBalance,
        drawer.opening_balance
            ?? 0
    );


    /*
    |--------------------------------------------------------------------------
    | Cash Sales Breakdown
    |--------------------------------------------------------------------------
    |
    | The backend currently returns all cash sales in
    | cash_sales_breakdown, grouped by created_by.
    |
    */

    const cashSalesBreakdown =
        drawer.cash_sales_breakdown
        ?? [];


    /*
    |--------------------------------------------------------------------------
    | Current User
    |--------------------------------------------------------------------------
    */

    const currentUserId =
        Number(
            CashDrawerConfig.userId
            ?? 0
        );


    /*
    |--------------------------------------------------------------------------
    | My Cash Sales
    |--------------------------------------------------------------------------
    */

    const myCashSales =
        cashSalesBreakdown
            .filter(
                item =>
                    Number(
                        item.user_id
                    ) === currentUserId
            )
            .reduce(
                (
                    total,
                    item
                ) =>
                    total +
                    Number(
                        item.amount
                        ?? 0
                    ),
                0
            );


    this.setMoney(
        this.elements.kpiCashSales,
        myCashSales
    );


    /*
    |--------------------------------------------------------------------------
    | Cash Sales Information
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.cashSalesInfo
    ) {

        this.elements.cashSalesInfo.textContent =
            myCashSales > 0
                ? 'Sales made by you'
                : 'No cash sales yet';

    }


    /*
    |--------------------------------------------------------------------------
    | Other Cash Sales
    |--------------------------------------------------------------------------
    */

    const otherCashSales =
        cashSalesBreakdown
            .filter(
                item =>
                    Number(
                        item.user_id
                    ) !== currentUserId
            );


    const otherCashSalesTotal =
        otherCashSales
            .reduce(
                (
                    total,
                    item
                ) =>
                    total +
                    Number(
                        item.amount
                        ?? 0
                    ),
                0
            );


    this.setMoney(
        this.elements.kpiOtherCashSales,
        otherCashSalesTotal
    );


    /*
    |--------------------------------------------------------------------------
    | Other Cash Sales Information
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.otherCashSalesInfo
    ) {

        if (
            !otherCashSales.length
        ) {

            this.elements.otherCashSalesInfo.textContent =
                'No other cash sales';

        } else {

            const userText =
                otherCashSales
                    .map(
                        item => {

                            const name =
                                item.user_name
                                || 'Unknown user';

                            return `${name} ${this.formatMoney(
                                item.amount
                            )}`;

                        }
                    )
                    .join(
                        ' · '
                    );


            this.elements.otherCashSalesInfo.textContent =
                userText;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Cash In
    |--------------------------------------------------------------------------
    */

    this.setMoney(
        this.elements.kpiCashIn,
        drawer.cash_in
            ?? 0
    );


    /*
    |--------------------------------------------------------------------------
    | Cash Out
    |--------------------------------------------------------------------------
    */

    this.setMoney(
        this.elements.kpiCashOut,
        drawer.cash_out
            ?? 0
    );


    /*
    |--------------------------------------------------------------------------
    | Cash Refunds
    |--------------------------------------------------------------------------
    */

    this.setMoney(
        this.elements.kpiCashRefunds,
        drawer.cash_refunds
            ?? 0
    );


    /*
    |--------------------------------------------------------------------------
    | Expected Balance
    |--------------------------------------------------------------------------
    */

    this.setMoney(
        this.elements.kpiExpectedBalance,
        drawer.expected_balance
            ?? 0
    );


    /*
    |--------------------------------------------------------------------------
    | Current Cash Balance
    |--------------------------------------------------------------------------
    */

    this.setMoney(
        this.elements.kpiCurrentBalance,
        drawer.current_balance
            ?? drawer.expected_balance
            ?? 0
    );

},

    /**
     * Reset cash drawer KPIs.
     */
    resetKpis() {

        const fields = [

            this.elements.kpiOpeningBalance,

            this.elements.kpiCashSales,

            this.elements.kpiCashIn,

            this.elements.kpiCashOut,

            this.elements.kpiCashRefunds,

            this.elements.kpiExpectedBalance,

            this.elements.kpiCurrentBalance,

        ];

        fields.forEach(
            element => {

                this.setMoney(
                    element,
                    0
                );

            }
        );

        /*
        |--------------------------------------------------------------------------
        | Cash Sales Information
        |--------------------------------------------------------------------------
        */

        if (this.elements.cashSalesInfo) {

            this.elements.cashSalesInfo.textContent =
                'No cash sales yet';

        }

    },


    resetKpis() {

        const fields = [

            this.elements.kpiOpeningBalance,
            this.elements.kpiCashSales,
            this.elements.kpiCashIn,
            this.elements.kpiCashOut,
            this.elements.kpiCashRefunds,
            this.elements.kpiExpectedBalance,
            this.elements.kpiCurrentBalance,

        ];

        fields.forEach(
            element => this.setMoney(element, 0)
        );

    },


   openDrawerModal() {

    console.log('OPEN DRAWER BUTTON CLICKED');

    console.log(
        'Modal element:',
        document.getElementById('openDrawerModal')
    );

    console.log(
        'Modal instance:',
        this.modals.openDrawer
    );


    this.clearFormErrors(
        this.elements.openDrawerForm
    );

    this.elements.openDrawerForm?.reset();

    if (this.elements.openingBalance) {

        this.elements.openingBalance.value =
            '0.00';

    }

    this.modals.openDrawer?.show();

},


    /*
    |--------------------------------------------------------------------------
    | Submit Open Drawer
    |--------------------------------------------------------------------------
    */

    async submitOpenDrawer() {

        this.clearFormErrors(
            this.elements.openDrawerForm
        );


        const data =
            this.formData(
                this.elements.openDrawerForm
            );


        this.setButtonLoading(
            this.elements.openDrawerSubmit,
            true,
            'Opening...'
        );


        try {

            await this.request(
                CashDrawerConfig.urls.open,
                'POST',
                data
            );


            this.modals.openDrawer?.hide();


            this.showSuccess(
                'Cash drawer opened successfully.'
            );


            await this.refresh();


        } catch (error) {

            this.handleRequestError(
                error,
                this.elements.openDrawerForm
            );


        } finally {

            this.setButtonLoading(
                this.elements.openDrawerSubmit,
                false
            );

        }

    },




    /*
    |--------------------------------------------------------------------------
    | Cash In
    |--------------------------------------------------------------------------
    */

    openCashInModal() {

        if (!this.state.currentDrawer) {

            this.showError(
                'Open a cash drawer before recording cash in.'
            );

            return;

        }


        this.clearFormErrors(
            this.elements.cashInForm
        );

        this.elements.cashInForm?.reset();

        this.modals.cashIn?.show();

    },


    async submitCashIn() {

        this.clearFormErrors(
            this.elements.cashInForm
        );


        const data =
            this.formData(
                this.elements.cashInForm
            );


        this.setButtonLoading(
            this.elements.cashInSubmit,
            true,
            'Recording...'
        );


        try {

            await this.request(
                CashDrawerConfig.urls.cashIn,
                'POST',
                data
            );


            this.modals.cashIn?.hide();

            this.showSuccess(
                'Cash in recorded successfully.'
            );


            await this.refresh();

        } catch (error) {

            this.handleRequestError(
                error,
                this.elements.cashInForm
            );

        } finally {

            this.setButtonLoading(
                this.elements.cashInSubmit,
                false
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Cash Out
    |--------------------------------------------------------------------------
    */

    openCashOutModal() {

        if (!this.state.currentDrawer) {

            this.showError(
                'Open a cash drawer before recording cash out.'
            );

            return;

        }


        this.clearFormErrors(
            this.elements.cashOutForm
        );

        this.elements.cashOutForm?.reset();

        this.modals.cashOut?.show();

    },


    async submitCashOut() {

        this.clearFormErrors(
            this.elements.cashOutForm
        );


        const data =
            this.formData(
                this.elements.cashOutForm
            );


        this.setButtonLoading(
            this.elements.cashOutSubmit,
            true,
            'Recording...'
        );


        try {

            await this.request(
                CashDrawerConfig.urls.cashOut,
                'POST',
                data
            );


            this.modals.cashOut?.hide();

            this.showSuccess(
                'Cash out recorded successfully.'
            );


            await this.refresh();

        } catch (error) {

            this.handleRequestError(
                error,
                this.elements.cashOutForm
            );

        } finally {

            this.setButtonLoading(
                this.elements.cashOutSubmit,
                false
            );

        }

    },


    /*
|--------------------------------------------------------------------------
| Close Drawer
|--------------------------------------------------------------------------
*/

/**
 * Open close drawer modal.
 */
openCloseDrawerModal() {

    const state =
        this.state.currentDrawer;


    /*
    |--------------------------------------------------------------------------
    | Current Drawer
    |--------------------------------------------------------------------------
    */

    const drawer =
        state?.drawer
        ?? null;


    /*
    |--------------------------------------------------------------------------
    | Current KPIs
    |--------------------------------------------------------------------------
    */

    const kpis =
        state?.kpis
        ?? {};


    /*
    |--------------------------------------------------------------------------
    | Drawer Validation
    |--------------------------------------------------------------------------
    */

    if (!drawer) {

        this.showError(
            'There is no open cash drawer to close.'
        );

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Clear Previous Errors
    |--------------------------------------------------------------------------
    */

    this.clearFormErrors(
        this.elements.closeDrawerForm
    );


    /*
    |--------------------------------------------------------------------------
    | Reset Form
    |--------------------------------------------------------------------------
    */

    this.elements.closeDrawerForm?.reset();


    /*
    |--------------------------------------------------------------------------
    | Expected Balance
    |--------------------------------------------------------------------------
    */

    const expected =
        Number(
            kpis.expected_balance
            ?? kpis.current_balance
            ?? 0
        );


    /*
    |--------------------------------------------------------------------------
    | Cash Sales
    |--------------------------------------------------------------------------
    */

    const cashSales =
        Number(
            kpis.cash_sales
            ?? 0
        );


    /*
    |--------------------------------------------------------------------------
    | Populate Summary
    |--------------------------------------------------------------------------
    */

    this.setMoney(
        this.elements.closeExpectedBalance,
        expected
    );


    this.setMoney(
        this.elements.closeCashSales,
        cashSales
    );


    /*
    |--------------------------------------------------------------------------
    | Reset Actual Balance
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.actualBalance
    ) {

        this.elements.actualBalance.value =
            '';

    }


    /*
    |--------------------------------------------------------------------------
    | Reset Variance Preview
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.variancePreview
    ) {

        this.elements.variancePreview.classList.add(
            'd-none'
        );

        this.elements.variancePreview.classList.remove(
            'alert-success',
            'alert-danger',
            'alert-warning'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Show Modal
    |--------------------------------------------------------------------------
    */

    this.modals.closeDrawer?.show();

},


  updateVariancePreview() {

    const state =
        this.state.currentDrawer;


    const kpis =
        state?.kpis
        ?? {};


    if (!state?.drawer) {

        return;

    }


    const actual =
        parseFloat(
            this.elements.actualBalance?.value
        );


    if (Number.isNaN(actual)) {

        this.elements.variancePreview?.classList.add(
            'd-none'
        );

        return;

    }


    const expected =
        Number(
            kpis.expected_balance
            ?? kpis.current_balance
            ?? 0
        );


    const variance =
        actual - expected;


        this.elements.variancePreview?.classList.remove(
            'd-none'
        );


        this.setMoney(
            this.elements.variancePreviewValue,
            variance
        );


        if (this.elements.variancePreview) {

            this.elements.variancePreview.classList.remove(
                'alert-success',
                'alert-danger',
                'alert-warning'
            );


            if (variance === 0) {

                this.elements.variancePreview.classList.add(
                    'alert-success'
                );

            } else if (variance < 0) {

                this.elements.variancePreview.classList.add(
                    'alert-danger'
                );

            } else {

                this.elements.variancePreview.classList.add(
                    'alert-warning'
                );

            }

        }

    },


    /*
|--------------------------------------------------------------------------
| Submit Close Drawer
|--------------------------------------------------------------------------
*/

async submitCloseDrawer() {

    this.clearFormErrors(
        this.elements.closeDrawerForm
    );


    /*
    |--------------------------------------------------------------------------
    | Current Drawer
    |--------------------------------------------------------------------------
    */

    const drawer =
        this.state.currentDrawer?.drawer;


    if (!drawer?.id) {

        this.showError(
            'Unable to identify the current cash drawer.'
        );

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Form Data
    |--------------------------------------------------------------------------
    */

    const data =
        this.formData(
            this.elements.closeDrawerForm
        );


    /*
    |--------------------------------------------------------------------------
    | Close URL
    |--------------------------------------------------------------------------
    */

    const url =
        CashDrawerConfig.urls.close.replace(
            '__ID__',
            String(drawer.id)
        );


    console.log(
        'Current drawer:',
        drawer
    );

    console.log(
        'Drawer ID:',
        drawer.id
    );

    console.log(
        'Close URL:',
        url
    );


    /*
    |--------------------------------------------------------------------------
    | Loading
    |--------------------------------------------------------------------------
    */

    this.setButtonLoading(
        this.elements.closeDrawerSubmit,
        true,
        'Closing...'
    );


    try {

        await this.request(
            url,
            'POST',
            data
        );


        this.modals.closeDrawer?.hide();

        this.showSuccess(
            'Cash drawer closed successfully.'
        );

        await this.refresh();

    } catch (error) {

        this.handleRequestError(
            error,
            this.elements.closeDrawerForm
        );

    } finally {

        this.setButtonLoading(
            this.elements.closeDrawerSubmit,
            false
        );

    }

},

    /*
    |--------------------------------------------------------------------------
    | Transactions
    |--------------------------------------------------------------------------
    */

    async loadTransactions() {

        const params =
            new URLSearchParams({

                page:
                    this.state.transactionPage,

                search:
                    this.state.transactionSearch,

                transaction_type:
                    this.state.transactionType,

            });


        try {

            const response =
                await this.request(
                    `${CashDrawerConfig.urls.transactions}?${params.toString()}`,
                    'GET'
                );


            const transactions =
                response.data
                ?? response.transactions
                ?? [];


            const pagination =
                response.pagination
                ?? response.meta
                ?? null;


            this.renderTransactions(
                transactions
            );


            this.renderPagination(
                this.elements.transactionPagination,
                pagination,
                'transaction'
            );

        } catch (error) {

            this.renderTableError(
                this.elements.transactionBody,
                8,
                'Unable to load transactions.'
            );

        }

    },


    renderTransactions(transactions) {

        if (!transactions.length) {

            this.elements.transactionBody.innerHTML = `

                <tr>

                    <td
                        colspan="8"
                        class="text-center py-5 text-muted"
                    >

                        No transactions found.

                    </td>

                </tr>

            `;

            return;

        }


        this.elements.transactionBody.innerHTML =
            transactions.map(
                transaction =>
                    this.transactionRow(
                        transaction
                    )
            ).join('');


        this.elements.transactionBody
            .querySelectorAll(
                '[data-transaction-id]'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            this.openTransactionInspector(
                                button.dataset.transactionId
                            );

                        }
                    );

                }
            );

    },


    transactionRow(transaction) {

        const type =
            transaction.transaction_type
            ?? transaction.type
            ?? '—';


        const amount =
            parseFloat(
                transaction.amount ?? 0
            );


        const balanceAfter =
            transaction.balance_after
            ?? 0;


        return `

            <tr>                

                <td>

                    ${this.transactionTypeBadge(type)}

                </td>

                <td>

                    ${this.escape(
                        transaction.reference_no
                        ?? '—'
                    )}

                </td>

                <td>

                    <span class="fw-semibold">

                        ${this.formatMoney(
                            amount
                        )}

                    </span>

                </td>

                <td>

                    ${this.formatMoney(
                        balanceAfter
                    )}

                </td>

                <td>

                    ${this.escape(
                        transaction.created_by?.name
                        ?? transaction.created_by_name
                        ?? '—'
                    )}

                </td>

                <td>

                    ${this.escape(
                        this.formatDateTime(
                            transaction.created_at
                        )
                    )}

                </td>

                <td class="text-end">

                    <button
                        type="button"
                        class="btn btn-sm btn-light"
                        data-transaction-id="${this.escape(
                            transaction.id
                        )}"
                    >

                        <i class="bi bi-eye"></i>

                    </button>

                </td>

            </tr>

        `;

    },


    transactionTypeBadge(type) {

        let classes =
            'bg-secondary-subtle text-secondary';


        if (type === 'Sale') {

            classes =
                'bg-success-subtle text-success';

        }

        if (type === 'Cash In') {

            classes =
                'bg-primary-subtle text-primary';

        }

        if (type === 'Cash Out') {

            classes =
                'bg-danger-subtle text-danger';

        }

        if (type === 'Refund') {

            classes =
                'bg-warning-subtle text-warning';

        }


        return `

            <span class="badge ${classes}">

                ${this.escape(type)}

            </span>

        `;

    },


    /*
    |--------------------------------------------------------------------------
    | Transaction Inspector
    |--------------------------------------------------------------------------
    */

    async openTransactionInspector(id) {

        try {

            const url =
                CashDrawerConfig.urls
                    .transactionDetails
                    .replace(
                        '__ID__',
                        id
                    );


            const response =
                await this.request(
                    url,
                    'GET'
                );


            const transaction =
                response.data
                ?? response.transaction;


            this.state.selectedTransaction =
                transaction;


            this.populateTransactionInspector(
                transaction
            );


            this.transactionInspector?.show();

        } catch (error) {

            this.showError(
                'Unable to load transaction details.'
            );

        }

    },


    populateTransactionInspector(transaction) {

        if (!transaction) {
            return;
        }


        this.setText(
            this.elements.transactionInspectorNumber,
            transaction.transaction_no
            ?? transaction.id
            ?? '—'
        );


        this.setText(
            this.elements.inspectorTransactionType,
            transaction.transaction_type
            ?? transaction.type
            ?? '—'
        );


        this.setMoney(
            this.elements.inspectorAmount,
            transaction.amount
        );


        this.setMoney(
            this.elements.inspectorBalanceBefore,
            transaction.balance_before
        );


        this.setMoney(
            this.elements.inspectorBalanceAfter,
            transaction.balance_after
        );


        this.setText(
            this.elements.inspectorReference,
            transaction.reference_no
            ?? '—'
        );


        this.setText(
            this.elements.inspectorCreatedBy,
            transaction.created_by?.name
            ?? transaction.created_by_name
            ?? '—'
        );


        this.setText(
            this.elements.inspectorCreatedAt,
            this.formatDateTime(
                transaction.created_at
            )
        );


        this.setText(
            this.elements.inspectorRemarks,
            transaction.remarks
            ?? '—'
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Drawer History
    |--------------------------------------------------------------------------
    */

    async loadHistory() {

        const params =
            new URLSearchParams({

                page:
                    this.state.historyPage,

                search:
                    this.state.historySearch,

            });


        try {

            const response =
                await this.request(
                    `${CashDrawerConfig.urls.history}?${params.toString()}`,
                    'GET'
                );


            const history =
                response.data
                ?? response.drawers
                ?? response.history
                ?? [];


            const pagination =
                response.pagination
                ?? response.meta
                ?? null;


            this.renderHistory(
                history
            );


            this.renderPagination(
                this.elements.historyPagination,
                pagination,
                'history'
            );

        } catch (error) {

            this.renderTableError(
                this.elements.historyBody,
                9,
                'Unable to load drawer history.'
            );

        }

    },


    renderHistory(history) {

        if (!history.length) {

            this.elements.historyBody.innerHTML = `

                <tr>

                    <td
                        colspan="9"
                        class="text-center py-5 text-muted"
                    >

                        No drawer history found.

                    </td>

                </tr>

            `;

            return;

        }


        this.elements.historyBody.innerHTML =
            history.map(
                drawer =>
                    this.historyRow(
                        drawer
                    )
            ).join('');


        this.elements.historyBody
            .querySelectorAll(
                '[data-drawer-id]'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            this.openDrawerInspector(
                                button.dataset.drawerId
                            );

                        }
                    );

                }
            );

    },


    historyRow(drawer) {

        return `

            

                <td>

                    ${this.escape(
                        drawer.opened_by?.name
                        ?? drawer.opened_by_name
                        ?? '—'
                    )}

                </td>

                <td>

                    ${this.escape(
                        this.formatDateTime(
                            drawer.opened_at
                        )
                    )}

                </td>

                <td>

                    ${this.formatMoney(
                        drawer.opening_balance
                    )}

                </td>

                <td>

                    ${this.formatMoney(
                        drawer.expected_balance
                    )}

                </td>

                <td>

                    ${this.formatMoney(
                        drawer.actual_balance
                    )}

                </td>

                <td>

                    ${this.formatMoney(
                        drawer.variance
                    )}

                </td>

                <td>

                    ${this.statusBadge(
                        drawer.status
                    )}

                </td>

                <td class="text-end">

                    <button
                        type="button"
                        class="btn btn-sm btn-light"
                        data-drawer-id="${this.escape(
                            drawer.id
                        )}"
                    >

                        <i class="bi bi-eye"></i>

                    </button>

                </td>

            </tr>

        `;

    },


    /*
    |--------------------------------------------------------------------------
    | Drawer Inspector
    |--------------------------------------------------------------------------
    */

    async openDrawerInspector(id) {

        try {

            const url =
                CashDrawerConfig.urls
                    .details
                    .replace(
                        '__ID__',
                        id
                    );


            const response =
                await this.request(
                    url,
                    'GET'
                );


            const drawer =
                response.data
                ?? response.drawer;


            this.state.selectedDrawer =
                drawer;


            this.populateDrawerInspector(
                drawer
            );


            this.drawerInspector?.show();

        } catch (error) {

            this.showError(
                'Unable to load drawer details.'
            );

        }

    },


    populateDrawerInspector(drawer) {

        if (!drawer) {
            return;
        }


        this.setText(
            this.elements.drawerInspectorStatus,
            drawer.status ?? '—'
        );


        this.setMoney(
            this.elements.historyOpeningBalance,
            drawer.opening_balance
        );


        this.setMoney(
            this.elements.historyCashSales,
            drawer.cash_sales
        );


        this.setMoney(
            this.elements.historyCashIn,
            drawer.cash_in
        );


        this.setMoney(
            this.elements.historyCashOut,
            drawer.cash_out
        );


        this.setMoney(
            this.elements.historyExpectedBalance,
            drawer.expected_balance
        );


        this.setMoney(
            this.elements.historyActualBalance,
            drawer.actual_balance
        );


        this.setMoney(
            this.elements.historyVariance,
            drawer.variance
        );


        this.setText(
            this.elements.historyOpenedBy,
            drawer.opened_by?.name
            ?? drawer.opened_by_name
            ?? '—'
        );


        this.setText(
            this.elements.historyOpenedAt,
            this.formatDateTime(
                drawer.opened_at
            )
        );


        this.setText(
            this.elements.historyClosedBy,
            drawer.closed_by?.name
            ?? drawer.closed_by_name
            ?? '—'
        );


        this.setText(
            this.elements.historyClosedAt,
            this.formatDateTime(
                drawer.closed_at
            )
        );


        this.setText(
            this.elements.historyClosingRemarks,
            drawer.closing_remarks
            ?? '—'
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    renderPagination(
        container,
        pagination,
        type
    ) {

        if (!container) {
            return;
        }


        if (!pagination) {

            container.innerHTML = '';

            return;

        }


        const currentPage =
            pagination.current_page
            ?? pagination.currentPage
            ?? 1;


        const lastPage =
            pagination.last_page
            ?? pagination.lastPage
            ?? 1;


        if (lastPage <= 1) {

            container.innerHTML = '';

            return;

        }


        let html = `

            <div class="d-flex align-items-center justify-content-between">

                <small class="text-muted">

                    Page ${currentPage} of ${lastPage}

                </small>

                <div class="btn-group btn-group-sm">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-page="${currentPage - 1}"
                        ${currentPage <= 1 ? 'disabled' : ''}
                    >

                        <i class="bi bi-chevron-left"></i>

                    </button>

                    <button
                        type="button"
                        class="btn btn-light"
                        data-page="${currentPage + 1}"
                        ${currentPage >= lastPage ? 'disabled' : ''}
                    >

                        <i class="bi bi-chevron-right"></i>

                    </button>

                </div>

            </div>

        `;


        container.innerHTML = html;


        container
            .querySelectorAll(
                '[data-page]'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            const page =
                                parseInt(
                                    button.dataset.page,
                                    10
                                );


                            if (type === 'transaction') {

                                this.state.transactionPage =
                                    page;

                                this.loadTransactions();

                            } else {

                                this.state.historyPage =
                                    page;

                                this.loadHistory();

                            }

                        }
                    );

                }
            );

    },


    /*
    |--------------------------------------------------------------------------
    | Confirmation
    |--------------------------------------------------------------------------
    */

    confirm(
        type,
        title,
        message,
        action
    ) {

        this.state.confirmationType =
            type;

        this.state.confirmationAction =
            action;


        this.setText(
            this.elements.confirmationTitle,
            title
        );


        this.setText(
            this.elements.confirmationMessage,
            message
        );


        if (type === 'danger') {

            this.elements.confirmationIcon?.classList.remove(
                'bi-exclamation-circle'
            );

            this.elements.confirmationIcon?.classList.add(
                'bi-exclamation-triangle'
            );

            this.elements.confirmationSubmit?.classList.remove(
                'btn-primary'
            );

            this.elements.confirmationSubmit?.classList.add(
                'btn-danger'
            );

        } else {

            this.elements.confirmationIcon?.classList.remove(
                'bi-exclamation-triangle'
            );

            this.elements.confirmationIcon?.classList.add(
                'bi-exclamation-circle'
            );

            this.elements.confirmationSubmit?.classList.remove(
                'btn-danger'
            );

            this.elements.confirmationSubmit?.classList.add(
                'btn-primary'
            );

        }


        this.modals.confirmation?.show();

    },


    async executeConfirmation() {

        const action =
            this.state.confirmationAction;


        if (typeof action !== 'function') {

            this.modals.confirmation?.hide();

            return;

        }


        this.setButtonLoading(
            this.elements.confirmationSubmit,
            true,
            'Processing...'
        );


        try {

            await action();

            this.modals.confirmation?.hide();

        } finally {

            this.setButtonLoading(
                this.elements.confirmationSubmit,
                false
            );

            this.state.confirmationAction =
                null;

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Refresh
    |--------------------------------------------------------------------------
    */

    async refresh() {

        await Promise.all([

            this.loadCurrentDrawer(),

            this.loadTransactions(),

            this.loadHistory(),

        ]);

    },


    /*
    |--------------------------------------------------------------------------
    | HTTP
    |--------------------------------------------------------------------------
    */

    async request(
        url,
        method = 'GET',
        data = null
    ) {

        const options = {

            method,

            headers: {

                'Accept':
                    'application/json',

                'X-CSRF-TOKEN':
                    document.querySelector(
                        'meta[name="csrf-token"]'
                    )?.getAttribute('content'),

            },

        };


        if (
            data
            && method !== 'GET'
        ) {

            options.body = data;

        }


        const response =
            await fetch(
                url,
                options
            );


        let result = {};

        try {

            result =
                await response.json();

        } catch (error) {

            result = {};

        }


        if (!response.ok) {

            const error =
                new Error(
                    result.message
                    ?? 'Request failed.'
                );


            error.status =
                response.status;

            error.errors =
                result.errors
                ?? {};


            throw error;

        }


        return result;

    },


    /*
    |--------------------------------------------------------------------------
    | Form Data
    |--------------------------------------------------------------------------
    */

    formData(form) {

        if (!form) {

            return new FormData();

        }


        return new FormData(form);

    },


    /*
    |--------------------------------------------------------------------------
    | Error Handling
    |--------------------------------------------------------------------------
    */

    handleRequestError(
        error,
        form = null
    ) {

        if (
            error.errors
            && Object.keys(error.errors).length
        ) {

            this.renderFormErrors(
                form,
                error.errors
            );

            return;

        }


        this.showError(
            error.message
            ?? 'Something went wrong.'
        );

    },


    renderFormErrors(
        form,
        errors
    ) {

        if (!form) {
            return;
        }


        Object.entries(errors)
            .forEach(
                ([field, messages]) => {

                    const input =
                        form.querySelector(
                            `[name="${field}"]`
                        );


                    if (!input) {
                        return;
                    }


                    input.classList.add(
                        'is-invalid'
                    );


                    const feedback =
                        form.querySelector(
                            `[data-error="${field}"]`
                        );


                    if (feedback) {

                        feedback.textContent =
                            Array.isArray(messages)
                                ? messages[0]
                                : messages;

                    }

                }
            );

    },


    clearFormErrors(form) {

        if (!form) {
            return;
        }


        form.querySelectorAll(
            '.is-invalid'
        ).forEach(
            element => {

                element.classList.remove(
                    'is-invalid'
                );

            }
        );


        form.querySelectorAll(
            '.invalid-feedback'
        ).forEach(
            element => {

                element.textContent = '';

            }
        );

    },


    /*
    |--------------------------------------------------------------------------
    | UI Helpers
    |--------------------------------------------------------------------------
    */

    setText(
        element,
        value
    ) {

        if (element) {

            element.textContent =
                value ?? '—';

        }

    },


    setMoney(
        element,
        value
    ) {

        if (element) {

            element.textContent =
                this.formatMoney(
                    value
                );

        }

    },


    formatMoney(value) {

        const amount =
            parseFloat(
                value ?? 0
            );


        return new Intl.NumberFormat(
            'en-NG',
            {
                style: 'currency',
                currency: 'NGN',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }
        ).format(
            Number.isNaN(amount)
                ? 0
                : amount
        );

    },


    formatDateTime(value) {

        if (!value) {
            return '—';
        }


        const date =
            new Date(value);


        if (Number.isNaN(date.getTime())) {

            return value;

        }


        return new Intl.DateTimeFormat(
            'en-NG',
            {
                dateStyle: 'medium',
                timeStyle: 'short',
            }
        ).format(date);

    },


    statusBadge(status) {

        const value =
            status ?? '—';


        let classes =
            'bg-secondary-subtle text-secondary';


        if (value === 'Open') {

            classes =
                'bg-success-subtle text-success';

        }


        if (value === 'Closed') {

            classes =
                'bg-secondary-subtle text-secondary';

        }


        return `

            <span class="badge ${classes}">

                ${this.escape(value)}

            </span>

        `;

    },


    toggle(
        element,
        show
    ) {

        if (!element) {
            return;
        }


        element.classList.toggle(
            'd-none',
            !show
        );

    },


    setButtonLoading(
        button,
        loading,
        text = 'Processing...'
    ) {

        if (!button) {
            return;
        }


        if (loading) {

            button.dataset.originalHtml =
                button.innerHTML;

            button.disabled =
                true;

            button.innerHTML = `

                <span
                    class="spinner-border spinner-border-sm me-1"
                    role="status"
                ></span>

                ${text}

            `;

        } else {

            button.disabled =
                false;

            if (button.dataset.originalHtml) {

                button.innerHTML =
                    button.dataset.originalHtml;

            }

        }

    },


    renderTableError(
        body,
        colspan,
        message
    ) {

        if (!body) {
            return;
        }


        body.innerHTML = `

            <tr>

                <td
                    colspan="${colspan}"
                    class="text-center py-5 text-danger"
                >

                    ${this.escape(message)}

                </td>

            </tr>

        `;

    },


    escape(value) {

        const div =
            document.createElement(
                'div'
            );


        div.textContent =
            value ?? '';


        return div.innerHTML;

    },


    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */

    showSuccess(message) {

        if (
            typeof showToast === 'function'
        ) {

            showToast(
                message,
                'success'
            );

            return;

        }


        console.log(
            message
        );

    },


    showError(message) {

        if (
            typeof showToast === 'function'
        ) {

            showToast(
                message,
                'danger'
            );

            return;

        }


        console.error(
            message
        );

    },

};


/*
|--------------------------------------------------------------------------
| Initialize
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    () => {

        CashDrawer.init();

    }
);