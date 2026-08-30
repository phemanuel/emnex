
/*
|--------------------------------------------------------------------------
| EMNEX POS
| Sales Returns & Refunds
|--------------------------------------------------------------------------
|
| Module:
| Sales Returns
|
| Handles:
| - Returns table
| - KPI statistics
| - Refundable orders
| - Order payments
| - Refund confirmation
| - Refund processing
| - Return inspector
| - Refund receipt
|
|--------------------------------------------------------------------------
*/

const SalesReturns = {

    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    state: {

        returnsPage: 1,

        returnsPerPage: 15,

        ordersPage: 1,

        ordersPerPage: 15,

        activeReturnId: null,

        selectedOrderId: null,

        selectedOrder: null,

        selectedPayments: [],

        refundAmount: 0,

        ordersSearchTimer: null,

        returnsSearchTimer: null,

        isLoadingReturns: false,

        isLoadingOrders: false,

        isProcessingRefund: false,

    },


    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    elements: {},


    /*
    |--------------------------------------------------------------------------
    | Bootstrap Instances
    |--------------------------------------------------------------------------
    */

    modals: {

        refundOrders: null,

        orderPayments: null,

        confirmation: null,

    },


    inspector: null,


    /*
    |--------------------------------------------------------------------------
    | Init
    |--------------------------------------------------------------------------
    */

    init() {

        this.cacheElements();

        this.initializeComponents();

        this.bindEvents();

        this.loadReturns();

    },


    /*
    |--------------------------------------------------------------------------
    | Cache Elements
    |--------------------------------------------------------------------------
    */

    cacheElements() {

        /*
        |----------------------------------------------------------------------
        | KPI
        |----------------------------------------------------------------------
        */

        this.elements.totalReturns =
            document.getElementById(
                'totalReturns'
            );

        this.elements.completedReturns =
            document.getElementById(
                'completedReturns'
            );

        this.elements.pendingReturns =
            document.getElementById(
                'pendingReturns'
            );

        this.elements.totalRefundedAmount =
            document.getElementById(
                'totalRefundedAmount'
            );


        /*
        |----------------------------------------------------------------------
        | Returns Table
        |----------------------------------------------------------------------
        */

        this.elements.returnsTableContainer =
            document.getElementById(
                'returns-table-container'
            );


        this.elements.returnsTableLoading =
            document.getElementById(
                'returnsTableLoading'
            );


        this.elements.returnsTableBody =
            document.getElementById(
                'returnsTableBody'
            );


        this.elements.returnsTableEmpty =
            document.getElementById(
                'returnsTableEmpty'
            );


        this.elements.returnsTableError =
            document.getElementById(
                'returnsTableError'
            );


        this.elements.returnsTableErrorMessage =
            document.getElementById(
                'returnsTableErrorMessage'
            );


        this.elements.returnsTableRetry =
            document.getElementById(
                'returnsTableRetry'
            );


        this.elements.returnsPagination =
            document.getElementById(
                'returnsPagination'
            );


        this.elements.returnsSearch =
            document.getElementById(
                'returnsSearch'
            );


        this.elements.returnsStatusFilter =
            document.getElementById(
                'returnsStatusFilter'
            );


        this.elements.returnsBranchFilter =
            document.getElementById(
                'returnsBranchFilter'
            );


        this.elements.returnsDateFrom =
            document.getElementById(
                'returnsDateFrom'
            );


        this.elements.returnsDateTo =
            document.getElementById(
                'returnsDateTo'
            );


        this.elements.returnsTableInfo =
            document.getElementById(
                'returnsTableInfo'
            );


        this.elements.clearReturnsFilters =
            document.getElementById(
                'clearReturnsFilters'
            );

        /*
        |----------------------------------------------------------------------
        | Refund Orders Modal
        |----------------------------------------------------------------------
        */

        this.elements.openRefundOrdersButton =
            document.getElementById(
                'openRefundOrdersButton'
            );

        this.elements.refundOrdersModal =
            document.getElementById(
                'refundOrdersModal'
            );

        this.elements.refundOrderSearch =
            document.getElementById(
                'refundOrderSearch'
            );

        this.elements.refundOrderStatus =
            document.getElementById(
                'refundOrderStatus'
            );

        this.elements.refundPaymentStatus =
            document.getElementById(
                'refundPaymentStatus'
            );
  
        this.elements.refundBranchFilter =
            document.getElementById(
                'refundBranchFilter'
            );      

        this.elements.refundDateFrom =
            document.getElementById(
                'refundDateFrom'
            );

        this.elements.refundDateTo =
            document.getElementById(
                'refundDateTo'
            );

        this.elements.refundOrdersTable =
            document.getElementById(
                'refundOrdersTable'
            );

        this.elements.refundOrdersTableBody =
            document.getElementById(
                'refundOrdersTableBody'
            );

        this.elements.refundOrdersLoading =
            document.getElementById(
                'refundOrdersLoading'
            );

        this.elements.refundOrdersEmpty =
            document.getElementById(
                'refundOrdersEmpty'
            );

        this.elements.refundOrdersError =
            document.getElementById(
                'refundOrdersError'
            );

        this.elements.refundOrdersErrorMessage =
            document.getElementById(
                'refundOrdersErrorMessage'
            );

        this.elements.refundOrdersRetry =
            document.getElementById(
                'refundOrdersRetry'
            );

        this.elements.refundOrdersPaginationInfo =
            document.getElementById(
                'refundOrdersPaginationInfo'
            );

        this.elements.refundOrdersPagination =
            document.getElementById(
                'refundOrdersPagination'
            );
        
        this.elements.refreshRefundOrders =
            document.getElementById(
                'refreshRefundOrders'
            );

        this.elements.refundOrderItemsModal =
            document.getElementById(
                'refundOrderItemsModal'
            );


        this.elements.refundOrderItemsSubtitle =
            document.getElementById(
                'refundOrderItemsSubtitle'
            );


        this.elements.refundOrderItemsLoading =
            document.getElementById(
                'refundOrderItemsLoading'
            );


        this.elements.refundOrderItemsEmpty =
            document.getElementById(
                'refundOrderItemsEmpty'
            );


        this.elements.refundOrderItemsContainer =
            document.getElementById(
                'refundOrderItemsContainer'
            );


        this.elements.refundOrderItemsTableBody =
            document.getElementById(
                'refundOrderItemsTableBody'
            );        


        /*
        |--------------------------------------------------------------------------
        | Refund Order Items Summary
        |--------------------------------------------------------------------------
        */

        this.elements.refundOrderItemsTotalItems =
            document.getElementById(
                'refundOrderItemsTotalItems'
            );


        this.elements.refundOrderItemsTotalAmount =
            document.getElementById(
                'refundOrderItemsTotalAmount'
            );


        this.elements.refundOrderItemsAmountPaid =
            document.getElementById(
                'refundOrderItemsAmountPaid'
            );


        this.elements.refundOrderItemsBalance =
            document.getElementById(
                'refundOrderItemsBalance'
            );


        this.elements.refundOrderItemsPaymentStatus =
            document.getElementById(
                'refundOrderItemsPaymentStatus'
            );

        this.elements.refundOrderItemsBranch =
            document.getElementById(
                'refundOrderItemsBranch'
            );

        /*
        |----------------------------------------------------------------------
        | Order Payments Modal
        |----------------------------------------------------------------------
        */

        this.elements.orderPaymentsModal =
            document.getElementById(
                'orderPaymentsModal'
            );

        this.elements.orderPaymentsSubtitle =
            document.getElementById(
                'orderPaymentsSubtitle'
            );

        this.elements.refundOrderNumber =
            document.getElementById(
                'refundOrderNumber'
            );

        this.elements.refundInvoiceNumber =
            document.getElementById(
                'refundInvoiceNumber'
            );

        this.elements.refundCustomer =
            document.getElementById(
                'refundCustomer'
            );

        this.elements.orderPaymentOrderStatus =
            document.getElementById(
                'orderPaymentOrderStatus'
            );

        this.elements.orderPaymentPaymentStatus =
            document.getElementById(
                'orderPaymentPaymentStatus'
            );

        this.elements.refundBranch =
            document.getElementById(
                'refundBranch'
            );

        this.elements.refundOrderTotal =
            document.getElementById(
                'refundOrderTotal'
            );

        this.elements.refundAmountPaid =
            document.getElementById(
                'refundAmountPaid'
            );

        this.elements.refundBalance =
            document.getElementById(
                'refundBalance'
            );

        this.elements.orderPaymentsTable =
            document.getElementById(
                'orderPaymentsTable'
            );

        this.elements.orderPaymentsTableBody =
            document.getElementById(
                'orderPaymentsTableBody'
            );

        this.elements.orderPaymentsLoading =
            document.getElementById(
                'orderPaymentsLoading'
            );

        this.elements.orderPaymentsEmpty =
            document.getElementById(
                'orderPaymentsEmpty'
            );

        this.elements.totalRefundAmount =
            document.getElementById(
                'totalRefundAmount'
            );

        this.elements.processRefundButton =
            document.getElementById(
                'processRefundButton'
            );

        this.elements.refundDiscount =
            document.getElementById(
                'refundDiscount'
            );

        this.elements.refundTax =
            document.getElementById(
                'refundTax'
            );

        this.elements.refundChangeGiven =
            document.getElementById(
                'refundChangeGiven'
            );


        /*
        |----------------------------------------------------------------------
        | Confirmation Modal
        |----------------------------------------------------------------------
        */

        this.elements.refundConfirmationModal =
            document.getElementById(
                'refundConfirmationModal'
            );

        this.elements.confirmationOrderNumber =
            document.getElementById(
                'confirmationOrderNumber'
            );

        this.elements.confirmationOrderStatus =
            document.getElementById(
                'confirmationOrderStatus'
            );

        this.elements.confirmationRefundAmount =
            document.getElementById(
                'confirmationRefundAmount'
            );

        this.elements.confirmProcessRefundButton =
            document.getElementById(
                'confirmProcessRefundButton'
            );


        /*
        |----------------------------------------------------------------------
        | Inspector
        |----------------------------------------------------------------------
        */

        this.elements.returnInspector =
            document.getElementById(
                'returnInspector'
            );

        this.elements.returnInspectorStatus =
            document.getElementById(
                'returnInspectorStatus'
            );

        this.elements.returnInspectorNumber =
            document.getElementById(
                'returnInspectorNumber'
            );

        this.elements.returnInspectorOrderNumber =
            document.getElementById(
                'returnInspectorOrderNumber'
            );

        this.elements.returnInspectorInvoiceNumber =
            document.getElementById(
                'returnInspectorInvoiceNumber'
            );

        this.elements.returnInspectorCustomer =
            document.getElementById(
                'returnInspectorCustomer'
            );

        this.elements.returnInspectorBranch =
            document.getElementById(
                'returnInspectorBranch'
            );

        this.elements.returnInspectorTerminal =
            document.getElementById(
                'returnInspectorTerminal'
            );

        this.elements.returnInspectorOrderTotal =
            document.getElementById(
                'returnInspectorOrderTotal'
            );

        this.elements.returnInspectorAmountPaid =
            document.getElementById(
                'returnInspectorAmountPaid'
            );

        this.elements.returnInspectorRefundAmount =
            document.getElementById(
                'returnInspectorRefundAmount'
            );

        this.elements.returnInspectorBalance =
            document.getElementById(
                'returnInspectorBalance'
            );

        this.elements.returnInspectorOrderStatus =
            document.getElementById(
                'returnInspectorOrderStatus'
            );

        this.elements.returnInspectorPaymentStatus =
            document.getElementById(
                'returnInspectorPaymentStatus'
            );

        this.elements.returnInspectorPayments =
            document.getElementById(
                'returnInspectorPayments'
            );

        this.elements.returnInspectorRemarks =
            document.getElementById(
                'returnInspectorRemarks'
            );

        this.elements.returnInspectorProcessedBy =
            document.getElementById(
                'returnInspectorProcessedBy'
            );

        this.elements.returnInspectorCreatedAt =
            document.getElementById(
                'returnInspectorCreatedAt'
            );

        this.elements.returnInspectorUpdatedAt =
            document.getElementById(
                'returnInspectorUpdatedAt'
            );

        this.elements.returnInspectorPrintReceipt =
            document.getElementById(
                'returnInspectorPrintReceipt'
            );

    },


    /*
    |--------------------------------------------------------------------------
    | Initialize Bootstrap Components
    |--------------------------------------------------------------------------
    */

    initializeComponents() {

        if (
            this.elements.refundOrdersModal
            &&
            typeof bootstrap !== 'undefined'
        ) {

            this.modals.refundOrders =
                bootstrap.Modal.getOrCreateInstance(
                    this.elements.refundOrdersModal
                );

        }


        if (
            this.elements.orderPaymentsModal
            &&
            typeof bootstrap !== 'undefined'
        ) {

            this.modals.orderPayments =
                bootstrap.Modal.getOrCreateInstance(
                    this.elements.orderPaymentsModal
                );

        }

       
        /*
        |--------------------------------------------------------------------------
        | Refund Order Items Modal
        |--------------------------------------------------------------------------
        */

        if (
            this.elements.refundOrderItemsModal
            &&
            typeof bootstrap !== 'undefined'
        ) {

            this.modals.refundOrderItems =
                bootstrap.Modal.getOrCreateInstance(
                    this.elements.refundOrderItemsModal
                );

        }
       
        this.elements.refundOrderItemsModal.addEventListener(
            'shown.bs.modal',
            () => {

                this.elements.refundOrderItemsModal.style.zIndex =
                    '1065';


                const backdrops =
                    document.querySelectorAll(
                        '.modal-backdrop'
                    );


                if (
                    backdrops.length
                ) {

                    backdrops[
                        backdrops.length - 1
                    ].style.zIndex =
                        '1060';

                }

            }
        );




        if (
            this.elements.refundConfirmationModal
            &&
            typeof bootstrap !== 'undefined'
        ) {

            this.modals.confirmation =
                bootstrap.Modal.getOrCreateInstance(
                    this.elements.refundConfirmationModal
                );

        }


        if (
            this.elements.returnInspector
            &&
            typeof bootstrap !== 'undefined'
        ) {

            this.inspector =
                bootstrap.Offcanvas.getOrCreateInstance(
                    this.elements.returnInspector
                );

        }

        

    },


    /*
    |--------------------------------------------------------------------------
    | Bind Events
    |--------------------------------------------------------------------------
    */

    bindEvents() {

        /*
        |----------------------------------------------------------------------
        | Open Refund Orders
        |----------------------------------------------------------------------
        */

        this.elements.openRefundOrdersButton
            ?.addEventListener(
                'click',
                () => {

                    this.openRefundOrdersModal();

                }
            );

        /*
        |--------------------------------------------------------------------------
        | Returns Retry
        |--------------------------------------------------------------------------
        */

        this.elements.returnsTableRetry
            ?.addEventListener(
                'click',
                () => {

                    this.loadReturns();

                }
            );


        /*
        |----------------------------------------------------------------------
        | Returns Pagination
        |----------------------------------------------------------------------
        */

        this.elements.returnsPagination
            ?.addEventListener(
                'click',
                (event) => {

                    const button =
                        event.target.closest(
                            '[data-page]'
                        );

                    if (!button) {

                        return;

                    }

                    const page =
                        parseInt(
                            button.dataset.page,
                            10
                        );

                    if (
                        !Number.isInteger(page)
                        ||
                        page < 1
                    ) {

                        return;

                    }

                    this.state.returnsPage =
                        page;

                    this.loadReturns();

                }
            );



    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    this.elements.returnsSearch
        ?.addEventListener(
            'input',
            () => {

                clearTimeout(
                    this.searchTimer
                );


                this.searchTimer =
                    setTimeout(
                        () => {

                            this.state.returnsPage =
                                1;


                            this.loadReturns();

                        },
                        400
                    );

            }
        );


    /*
    |--------------------------------------------------------------------------
    | Return Status
    |--------------------------------------------------------------------------
    */

    this.elements.returnsStatusFilter
        ?.addEventListener(
            'change',
            () => {

                this.state.returnsPage =
                    1;


                this.loadReturns();

            }
        );


    /*
    |--------------------------------------------------------------------------
    | Branch
    |--------------------------------------------------------------------------
    */

    this.elements.returnsBranchFilter
        ?.addEventListener(
            'change',
            () => {

                this.state.returnsPage =
                    1;


                this.loadReturns();

            }
        );


    /*
    |--------------------------------------------------------------------------
    | Date From
    |--------------------------------------------------------------------------
    */

    this.elements.returnsDateFrom
        ?.addEventListener(
            'change',
            () => {

                this.state.returnsPage =
                    1;


                this.loadReturns();

            }
        );


    /*
    |--------------------------------------------------------------------------
    | Date To
    |--------------------------------------------------------------------------
    */

    this.elements.returnsDateTo
        ?.addEventListener(
            'change',
            () => {

                this.state.returnsPage =
                    1;


                this.loadReturns();

            }
        );


    /*
    |--------------------------------------------------------------------------
    | Clear Filters
    |--------------------------------------------------------------------------
    */

    this.elements.clearReturnsFilters
        ?.addEventListener(
            'click',
            () => {

                if (
                    this.elements.returnsSearch
                ) {

                    this.elements.returnsSearch.value =
                        '';

                }


                if (
                    this.elements.returnsStatusFilter
                ) {

                    this.elements.returnsStatusFilter.value =
                        '';

                }


                if (
                    this.elements.returnsBranchFilter
                ) {

                    this.elements.returnsBranchFilter.value =
                        '';

                }


                if (
                    this.elements.returnsDateFrom
                ) {

                    this.elements.returnsDateFrom.value =
                        '';

                }


                if (
                    this.elements.returnsDateTo
                ) {

                    this.elements.returnsDateTo.value =
                        '';

                }


                this.state.returnsPage =
                    1;


                this.loadReturns();

            }
        );

      
        /*
        |--------------------------------------------------------------------------
        | Refund Orders Filters
        |--------------------------------------------------------------------------
        */

        this.elements.refundOrderSearch?.addEventListener(
            'input',
            () => {

                clearTimeout(
                    this.state.refundOrderSearchTimer
                );


                this.state.refundOrderSearchTimer =
                    setTimeout(
                        () => {

                            this.state.ordersPage = 1;

                            this.loadRefundOrders();

                        },
                        300
                    );

            }
        );


        this.elements.refundBranchFilter?.addEventListener(
            'change',
            () => {

                this.state.ordersPage = 1;

                this.loadRefundOrders();

            }
        );


        this.elements.refundOrderStatus?.addEventListener(
            'change',
            () => {

                this.state.ordersPage = 1;

                this.loadRefundOrders();

            }
        );


        this.elements.refundPaymentStatus?.addEventListener(
            'change',
            () => {

                this.state.ordersPage = 1;

                this.loadRefundOrders();

            }
        );


        this.elements.refundDateFrom?.addEventListener(
            'change',
            () => {

                this.state.ordersPage = 1;

                this.loadRefundOrders();

            }
        );


        this.elements.refundDateTo?.addEventListener(
            'change',
            () => {

                this.state.ordersPage = 1;

                this.loadRefundOrders();

            }
        );

  
        this.elements.refreshRefundOrders?.addEventListener(
            'click',
            () => {

                /*
                |--------------------------------------------------------------------------
                | Reset Filters
                |--------------------------------------------------------------------------
                */

                if (
                    this.elements.refundOrderSearch
                ) {

                    this.elements.refundOrderSearch.value =
                        '';

                }


                if (
                    this.elements.refundBranchFilter
                ) {

                    this.elements.refundBranchFilter.value =
                        '';

                }


                if (
                    this.elements.refundOrderStatus
                ) {

                    this.elements.refundOrderStatus.value =
                        '';

                }


                if (
                    this.elements.refundPaymentStatus
                ) {

                    this.elements.refundPaymentStatus.value =
                        '';

                }


                if (
                    this.elements.refundDateFrom
                ) {

                    this.elements.refundDateFrom.value =
                        '';

                }


                if (
                    this.elements.refundDateTo
                ) {

                    this.elements.refundDateTo.value =
                        '';

                }


                /*
                |--------------------------------------------------------------------------
                | Reset Pagination
                |--------------------------------------------------------------------------
                */

                this.state.ordersPage =
                    1;


                /*
                |--------------------------------------------------------------------------
                | Reload
                |--------------------------------------------------------------------------
                */

                this.loadRefundOrders();

            }
        );

        /*
        |--------------------------------------------------------------------------
        | Open Refund Orders
        |--------------------------------------------------------------------------
        */

        this.elements.openRefundOrdersButton
            ?.addEventListener(
                'click',
                () => {

                    this.openRefundOrdersModal();

                }
            );

        this.elements.refundOrdersTableBody?.addEventListener(
            'click',
            (event) => {

                const button =
                    event.target.closest(
                        '[data-action="view-refund-order-items"]'
                    );


                if (!button) {

                    return;

                }


                const orderId =
                    button.dataset.id;


                if (!orderId) {

                    return;

                }


                this.loadRefundOrderItems(
                    orderId
                );

            }
        );
      
        /*
        |--------------------------------------------------------------------------
        | View Refund Order Items
        |--------------------------------------------------------------------------
        */

        this.elements.refundOrdersTableBody?.addEventListener(
            'click',
            (event) => {

                const button =
                    event.target.closest(
                        '[data-action="view-refund-order-items"]'
                    );


                if (!button) {

                    return;

                }


                const orderId =
                    button.dataset.id;


                if (!orderId) {

                    return;

                }


                this.loadRefundOrderItems(
                    orderId
                );

            }
        );



        /*
        |----------------------------------------------------------------------
        | Refund Orders Pagination
        |----------------------------------------------------------------------
        */

        this.elements.refundOrdersPagination
            ?.addEventListener(
                'click',
                (event) => {

                    const button =
                        event.target.closest(
                            '[data-page]'
                        );

                    if (!button) {

                        return;

                    }

                    const page =
                        parseInt(
                            button.dataset.page,
                            10
                        );

                    if (
                        !Number.isInteger(page)
                        ||
                        page < 1
                    ) {

                        return;

                    }

                    this.state.ordersPage =
                        page;

                    this.loadRefundOrders();

                }
            );


        /*
        |----------------------------------------------------------------------
        | Retry
        |----------------------------------------------------------------------
        */

        this.elements.refundOrdersRetry
            ?.addEventListener(
                'click',
                () => {

                    this.loadRefundOrders();

                }
            );


        /*
        |----------------------------------------------------------------------
        | Process Refund
        |----------------------------------------------------------------------
        */

        this.elements.processRefundButton
            ?.addEventListener(
                'click',
                () => {

                    this.openConfirmation();

                }
            );


        /*
        |----------------------------------------------------------------------
        | Confirm Refund
        |----------------------------------------------------------------------
        */

        this.elements.confirmProcessRefundButton
            ?.addEventListener(
                'click',
                () => {

                    this.processRefund();

                }
            );


        /*
        |----------------------------------------------------------------------
        | Print Receipt
        |----------------------------------------------------------------------
        */

        this.elements.returnInspectorPrintReceipt
            ?.addEventListener(
                'click',
                () => {

                    this.printReceipt();

                }
            );


        /*
        |----------------------------------------------------------------------
        | Dynamic Return Actions
        |----------------------------------------------------------------------
        */

        this.elements.returnsTableBody
            ?.addEventListener(
                'click',
                (event) => {

                    const action =
                        event.target.closest(
                            '[data-return-action]'
                        );

                    if (!action) {

                        return;

                    }

                    const id =
                        parseInt(
                            action.dataset.returnId,
                            10
                        );

                    if (!id) {

                        return;

                    }

                    const type =
                        action.dataset.returnAction;

                    if (
                        type === 'view'
                    ) {

                        this.openInspector(
                            id
                        );

                    }

                }
            );

    },
  
   /*
    |--------------------------------------------------------------------------
    | Load Returns
    |--------------------------------------------------------------------------
    */

    async loadReturns() {

        if (
            this.state.isLoadingReturns
        ) {

            return;

        }


        this.state.isLoadingReturns =
            true;


        this.showReturnsLoading();


        try {

            const params =
                new URLSearchParams({

                    page:
                        this.state.returnsPage,

                    per_page:
                        this.state.returnsPerPage,

                });


            /*
            |--------------------------------------------------------------------------
            | Search
            |--------------------------------------------------------------------------
            */

            const search =
                this.elements.returnsSearch
                    ?.value
                    ?.trim();


            if (
                search
            ) {

                params.set(
                    'search',
                    search
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Return Status
            |--------------------------------------------------------------------------
            */

            const status =
                this.elements.returnsStatusFilter
                    ?.value
                    ?.trim();


            if (
                status
            ) {

                params.set(
                    'status',
                    status
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Branch
            |--------------------------------------------------------------------------
            */

            const branchId =
                this.elements.returnsBranchFilter
                    ?.value
                    ?.trim();


            if (
                branchId
            ) {

                params.set(
                    'branch_id',
                    branchId
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Date From
            |--------------------------------------------------------------------------
            */

            const dateFrom =
                this.elements.returnsDateFrom
                    ?.value
                    ?.trim();


            if (
                dateFrom
            ) {

                params.set(
                    'date_from',
                    dateFrom
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Date To
            |--------------------------------------------------------------------------
            */

            const dateTo =
                this.elements.returnsDateTo
                    ?.value
                    ?.trim();


            if (
                dateTo
            ) {

                params.set(
                    'date_to',
                    dateTo
                );

            }


            /*
            |--------------------------------------------------------------------------
            | URL
            |--------------------------------------------------------------------------
            */

            const url =
                `/sales/returns/table?${params.toString()}`;


            console.log(
                'Sales Returns: Loading table...',
                url
            );


            const response =
                await fetch(
                    url,
                    {

                        method:
                            'GET',

                        headers: {

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',

                        },

                        credentials:
                            'same-origin',

                    }
                );


            console.log(
                'Sales Returns: Response received.',
                response.status,
                response.statusText
            );


            const result =
                await this.parseResponse(
                    response
                );


            /*
            |--------------------------------------------------------------------------
            | Validate Response
            |--------------------------------------------------------------------------
            */

            if (
                !response.ok
            ) {

                throw new Error(
                    result?.message
                    ||
                    `Unable to load sales returns. HTTP ${response.status}.`
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Support Existing Response Patterns
            |--------------------------------------------------------------------------
            */

            const success =
                result?.success
                ??
                result?.status
                ??
                false;


            if (
                success !== true
                &&
                success !== 1
                &&
                success !== 'success'
            ) {

                throw new Error(
                    result?.message
                    ||
                    'Unable to load sales returns.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Data
            |--------------------------------------------------------------------------
            */

            const data =
                result?.data
                ||
                {};


            /*
            |--------------------------------------------------------------------------
            | Returns
            |--------------------------------------------------------------------------
            */

            const returns =
                Array.isArray(
                    data.returns
                )
                    ? data.returns
                    : [];


            console.log(
                'Sales Returns: Number of returns:',
                returns.length
            );


            /*
            |--------------------------------------------------------------------------
            | Render Table
            |--------------------------------------------------------------------------
            */

            this.renderReturns(
                returns
            );


            /*
            |--------------------------------------------------------------------------
            | Pagination
            |--------------------------------------------------------------------------
            */

            this.renderReturnsPagination(
                data.pagination
                ||
                {}
            );


            /*
            |--------------------------------------------------------------------------
            | KPIs
            |--------------------------------------------------------------------------
            */

            this.updateKpis(
                data.stats
                ||
                {}
            );

        }
        catch (error) {

            console.error(
                'Sales Returns: Failed to load table.',
                error
            );


            this.renderReturnsError(
                error?.message
                ||
                'Unable to load sales returns.'
            );

        }
        finally {

            this.state.isLoadingReturns =
                false;

        }

    },
    /*
    |--------------------------------------------------------------------------
    | Render Returns
    |--------------------------------------------------------------------------
    */

    renderReturns(
        returns
    ) {

        if (
            !this.elements.returnsTableBody
        ) {

            return;

        }


        this.hideElement(
            this.elements.returnsTableLoading
        );


        this.hideElement(
            this.elements.returnsTableError
        );


        if (
            !returns.length
        ) {

            this.elements.returnsTableBody.innerHTML =
                '';


            this.hideElement(
                this.elements.returnsTableBody
            );


            this.showElement(
                this.elements.returnsTableEmpty
            );


            return;

        }


        this.hideElement(
            this.elements.returnsTableEmpty
        );


        this.showElement(
            this.elements.returnsTableBody
        );


        this.elements.returnsTableBody.innerHTML =
            returns
                .map(
                    (item) => {

                        return `

                            <tr>

                                <td class="ps-4">

                                    <button
                                        type="button"
                                        class="btn btn-link text-decoration-none p-0 fw-semibold"
                                        data-return-action="view"
                                        data-return-id="${item.id}"
                                    >

                                        ${this.escapeHtml(
                                            item.return_number || '—'
                                        )}

                                    </button>

                                </td>


                                <td>

                                    ${this.escapeHtml(
                                        item.order?.order_no || '—'
                                    )}

                                </td>


                                <td>

                                    ${this.escapeHtml(
                                        item.customer || 'Walk-in Customer'
                                    )}

                                </td>


                                 <td>
                                    ${this.statusBadge(
                                        item.order_status
                                    )}
                                </td>


                                <td>

                                    ${this.formatCurrency(
                                        item.refund_amount
                                    )}

                                </td>
                             
                                <td>
                                    ${this.statusBadge(
                                        item.return_status
                                    )}
                                </td>
                               


                                <td>

                                    ${this.escapeHtml(
                                        item.processed_by || '—'
                                    )}

                                </td>


                                <td>

                                    ${this.formatDateTime(
                                        item.return_date
                                    )}

                                </td>


                                <td class="text-end pe-4">

                                    <div class="dropdown">

                                        <button
                                            type="button"
                                            class="btn btn-light btn-sm"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        >

                                            <i class="bi bi-three-dots"></i>

                                        </button>


                                        <ul class="dropdown-menu dropdown-menu-end">

                                            <li>

                                                <button
                                                    type="button"
                                                    class="dropdown-item"
                                                    data-return-action="view"
                                                    data-return-id="${item.id}"
                                                >

                                                    <i class="bi bi-eye me-2"></i>

                                                    View Details

                                                </button>

                                            </li>

                                        </ul>

                                    </div>

                                </td>

                            </tr>

                        `;

                    }
                )
                .join('');

    },


    /*
    |--------------------------------------------------------------------------
    | KPI
    |--------------------------------------------------------------------------
    */

    updateKpis(
        stats
    ) {

        const totalReturns =
            Number(
                stats.total_returns || 0
            );


        const completedReturns =
            Number(
                stats.completed_returns || 0
            );


        const totalRefunded =
            Number(
                stats.total_refunded || 0
            );


        const pendingReturns =
            Math.max(
                0,
                totalReturns -
                completedReturns
            );


        if (
            this.elements.totalReturns
        ) {

            this.elements.totalReturns.textContent =
                this.formatNumber(
                    totalReturns
                );

        }


        if (
            this.elements.completedReturns
        ) {

            this.elements.completedReturns.textContent =
                this.formatNumber(
                    completedReturns
                );

        }


        if (
            this.elements.pendingReturns
        ) {

            this.elements.pendingReturns.textContent =
                this.formatNumber(
                    pendingReturns
                );

        }


        if (
            this.elements.totalRefundedAmount
        ) {

            this.elements.totalRefundedAmount.textContent =
                this.formatCurrency(
                    totalRefunded
                );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Returns Pagination
    |--------------------------------------------------------------------------
    */

    renderReturnsPagination(
        pagination
    ) {

        if (
            !this.elements.returnsPagination
        ) {

            return;

        }


        const currentPage =
            Number(
                pagination.current_page || 1
            );


        const lastPage =
            Number(
                pagination.last_page || 1
            );


        if (
            lastPage <= 1
        ) {

            this.elements.returnsPagination.innerHTML =
                '';

            return;

        }


        this.elements.returnsPagination.innerHTML =
            this.buildPagination(
                currentPage,
                lastPage
            );

    },


    /*
    |--------------------------------------------------------------------------
    | Refund Orders Modal
    |--------------------------------------------------------------------------
    */

    openRefundOrdersModal() {

        this.resetRefundOrdersState();


        if (
            this.modals.refundOrders
        ) {

            this.modals.refundOrders.show();

        }


        this.loadRefundOrders();

    },


    /*
    |--------------------------------------------------------------------------
    | Reset Refund Orders
    |--------------------------------------------------------------------------
    */

    resetRefundOrdersState() {

        this.state.ordersPage =
            1;


        if (
            this.elements.refundOrderSearch
        ) {

            this.elements.refundOrderSearch.value =
                '';

        }


        if (
            this.elements.refundOrderStatus
        ) {

            this.elements.refundOrderStatus.value =
                '';

        }


        if (
            this.elements.refundPaymentStatus
        ) {

            this.elements.refundPaymentStatus.value =
                '';

        }


        if (
            this.elements.refundDateFrom
        ) {

            this.elements.refundDateFrom.value =
                '';

        }


        if (
            this.elements.refundDateTo
        ) {

            this.elements.refundDateTo.value =
                '';

        }


        this.hideElement(
            this.elements.refundOrdersEmpty
        );


        this.hideElement(
            this.elements.refundOrdersError
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Load Refund Orders
    |--------------------------------------------------------------------------
    */

    async loadRefundOrders() {

        if (
            this.state.isLoadingOrders
        ) {

            return;

        }


        this.state.isLoadingOrders =
            true;


        this.showRefundOrdersLoading();


        try {

            const params =
                new URLSearchParams({

                    page:
                        this.state.ordersPage,

                    per_page:
                        this.state.ordersPerPage,

                });


            const search =
                this.elements.refundOrderSearch
                    ?.value
                    ?.trim();


            if (search) {

                params.set(
                    'search',
                    search
                );

            }


            const orderStatus =
                this.elements.refundOrderStatus
                    ?.value;


            if (orderStatus) {

                params.set(
                    'order_status',
                    orderStatus
                );

            }


            const paymentStatus =
                this.elements.refundPaymentStatus
                    ?.value;


            if (paymentStatus) {

                params.set(
                    'payment_status',
                    paymentStatus
                );  
                
            }

            const branchId =
                this.elements.refundBranchFilter
                    ?.value
                    ?.trim();


            if (branchId) {

                params.set(
                    'branch_id',
                    branchId
                );

            }

            const dateFrom =
                this.elements.refundDateFrom
                    ?.value;


            if (dateFrom) {

                params.set(
                    'date_from',
                    dateFrom
                );

            }


            const dateTo =
                this.elements.refundDateTo
                    ?.value;


            if (dateTo) {

                params.set(
                    'date_to',
                    dateTo
                );

            }


            const response =
                await fetch(
                    `/sales/returns/orders?${params.toString()}`,
                    {

                        method:
                            'GET',

                        headers: {

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',

                        },

                        credentials:
                            'same-origin',

                    }
                );


            const result =
                await this.parseResponse(
                    response
                );


            if (
                !response.ok
                ||
                !result.success
            ) {

                throw new Error(
                    result.message
                    ||
                    'Unable to load refundable orders.'
                );

            }


            const data =
                result.data || {};
      

            this.renderRefundOrders(
                data.orders || []
            );


            this.renderRefundOrdersPagination(
                data.pagination || {}
            );

        }
        catch (error) {

            console.error(
                'Refund Orders:',
                error
            );


            this.showRefundOrdersError(
                error.message
                ||
                'Unable to load refundable orders.'
            );

        }
        finally {

            this.state.isLoadingOrders =
                false;

            this.hideRefundOrdersLoading();

        }

    },
  
    
    /*
    |--------------------------------------------------------------------------
    | Populate Refund Order Items
    |--------------------------------------------------------------------------
    */

    populateRefundOrderItems(
        data
    ) {

        const order =
            data.order || {};


        const items =
            Array.isArray(
                data.items
            )
                ? data.items
                : [];
        
              
            /*
            |--------------------------------------------------------------------------
            | Order Summary
            |--------------------------------------------------------------------------
            */

            const totalItems =
                items.reduce(
                    (
                        total,
                        item
                    ) => {

                        return total +
                            Number(
                                item.quantity || 0
                            );

                    },
                    0
                );


            this.setText(
                this.elements.refundOrderItemsTotalItems,
                totalItems
            );


            this.setText(
                this.elements.refundOrderItemsTotalAmount,
                this.formatCurrency(
                    order.grand_total || 0
                )
            );


            this.setText(
                this.elements.refundOrderItemsAmountPaid,
                this.formatCurrency(
                    order.amount_paid || 0
                )
            );


            this.setText(
                this.elements.refundOrderItemsBalance,
                this.formatCurrency(
                    order.balance || 0
                )
            );


            this.setBadge(
                this.elements.refundOrderItemsPaymentStatus,
                order.payment_status
            );


        /*
        |--------------------------------------------------------------------------
        | Subtitle
        |--------------------------------------------------------------------------
        */

        this.setText(
            this.elements.refundOrderItemsSubtitle,
            order.order_no
                ? `Items for ${order.order_no}`
                : 'Order items'
        );

       
        this.setText(
            this.elements.refundOrderItemsBranch,
            order.branch_name
                ||
                '—'
        );




        /*
        |--------------------------------------------------------------------------
        | Empty State
        |--------------------------------------------------------------------------
        */

        if (
            !items.length
        ) {

            this.hideElement(
                this.elements.refundOrderItemsContainer
            );


            this.showElement(
                this.elements.refundOrderItemsEmpty
            );


            return;

        }


        this.showElement(
            this.elements.refundOrderItemsContainer
        );


        this.hideElement(
            this.elements.refundOrderItemsEmpty
        );


        /*
        |--------------------------------------------------------------------------
        | Table Body
        |--------------------------------------------------------------------------
        */

        if (
            !this.elements.refundOrderItemsTableBody
        ) {

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Render Items
        |--------------------------------------------------------------------------
        */

        this.elements.refundOrderItemsTableBody.innerHTML =
            items
                .map(
                    item => `

                        <tr>

                            <td>

                                <div class="fw-semibold">

                                    ${item.product_name || '—'}

                                </div>

                            </td>


                            <td>

                                <span class="text-muted">

                                    ${item.sku || '—'}

                                </span>

                            </td>


                            <td class="text-center">

                                ${item.quantity ?? 0}

                            </td>


                            <td class="text-end">

                                ${this.formatCurrency(
                                    item.unit_price
                                )}

                            </td>


                            <td class="text-end fw-semibold">

                                ${this.formatCurrency(
                                    item.line_total
                                )}

                            </td>

                        </tr>

                    `
                )
                .join('');

    },



    /*
    |--------------------------------------------------------------------------
    | Load Refund Order Items
    |--------------------------------------------------------------------------
    */

    async loadRefundOrderItems(
        orderId
    ) {

        this.state.selectedOrderId =
            orderId;


        /*
        |--------------------------------------------------------------------------
        | Show Loading
        |--------------------------------------------------------------------------
        */

        this.showRefundOrderItemsLoading();


        this.hideElement(
            this.elements.refundOrderItemsEmpty
        );


        /*
        |--------------------------------------------------------------------------
        | Open Modal
        |--------------------------------------------------------------------------
        */

        if (
            this.modals.refundOrderItems
        ) {

            this.modals.refundOrderItems.show();

        }


        try {

            /*
            |--------------------------------------------------------------------------
            | Request
            |--------------------------------------------------------------------------
            */

            const response =
                await fetch(
                    `/sales/returns/orders/${orderId}/items`,
                    {

                        method:
                            'GET',

                        headers: {

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',

                        },

                        credentials:
                            'same-origin',

                    }
                );


            const result =
                await this.parseResponse(
                    response
                );


            /*
            |--------------------------------------------------------------------------
            | Validate Response
            |--------------------------------------------------------------------------
            */

            if (
                !response.ok
                ||
                !result.success
            ) {

                throw new Error(
                    result.message
                    ||
                    'Unable to load order items.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Data
            |--------------------------------------------------------------------------
            */

            const data =
                result.data || {};


            /*
            |--------------------------------------------------------------------------
            | Populate
            |--------------------------------------------------------------------------
            */

            this.populateRefundOrderItems(
                data
            );

        }
        catch (error) {

            console.error(
                'Refund Order Items:',
                error
            );


            this.showToast(
                error.message
                ||
                'Unable to load order items.',
                'danger'
            );


            if (
                this.modals.refundOrderItems
            ) {

                this.modals.refundOrderItems.hide();

            }

        }
        finally {

            this.hideRefundOrderItemsLoading();

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Render Refund Orders
    |--------------------------------------------------------------------------
    */

    renderRefundOrders(
        orders
    ) {
      

        this.hideElement(
            this.elements.refundOrdersError
        );


        if (
            !orders.length
        ) {

            this.elements.refundOrdersTableBody.innerHTML =
                '';

            this.showElement(
                this.elements.refundOrdersEmpty
            );

            return;

        }


        this.hideElement(
            this.elements.refundOrdersEmpty
        );


        this.elements.refundOrdersTableBody.innerHTML =
            orders
                .map(
                    (order) => {

                        return `

                            <tr>

                                <td class="ps-4">

                                    <strong>

                                        ${this.escapeHtml(
                                            order.order_no || '—'
                                        )}

                                    </strong>

                                </td>


                                <td>

                                    ${this.escapeHtml(
                                        order.invoice_no || '—'
                                    )}

                                </td>


                                <td>

                                    ${this.escapeHtml(
                                        order.customer || 'Walk-in Customer'
                                    )}

                                </td>

                                
                                <td>

                                    <span class="fw-medium">

                                        ${this.escapeHtml(
                                            order.branch_name
                                            ||
                                            '—'
                                        )}

                                    </span>

                                </td>


                                <td>

                                    ${this.formatCurrency(
                                        order.grand_total
                                    )}

                                </td>


                                <td>

                                    ${this.formatCurrency(
                                        order.amount_paid
                                    )}

                                </td>


                                <td>

                                    ${this.formatCurrency(
                                        order.balance
                                    )}

                                </td>


                                <td>

                                    ${this.statusBadge(
                                        order.order_status
                                    )}

                                </td>


                                <td>

                                    ${this.statusBadge(
                                        order.payment_status
                                    )}

                                </td>

                                
                                <td class="text-end pe-4">

                                    <div class="d-inline-flex align-items-center gap-2">

                                        <button
                                            type="button"
                                            class="btn btn-light border btn-sm"
                                            data-order-action="items"
                                            data-order-id="${order.id}"
                                            title="View Items"
                                        >

                                            <i class="bi bi-box-seam me-1"></i>

                                            View Items

                                        </button>

                                        <button
                                            type="button"
                                            class="btn btn-primary btn-sm"
                                            data-order-action="payments"
                                            data-order-id="${order.id}"
                                            title="Process Refund"
                                        >

                                            <i class="bi bi-arrow-counterclockwise me-1"></i>

                                            Refund

                                        </button>

                                    </div>

                                </td>



                            </tr>

                        `;

                    }
                )
                .join('');


        this.bindRefundOrderActions();

    },
    
    /*
    |--------------------------------------------------------------------------
    | Refund Order Actions
    |--------------------------------------------------------------------------
    */

    bindRefundOrderActions() {

        const buttons =
            this.elements.refundOrdersTableBody
                ?.querySelectorAll(
                    '[data-order-action]'
                );


        buttons?.forEach(
            (button) => {

                button.addEventListener(
                    'click',
                    () => {

                        const id =
                            parseInt(
                                button.dataset.orderId,
                                10
                            );


                        if (!id) {

                            return;

                        }


                        const action =
                            button.dataset.orderAction;


                       
                        /*
                        |--------------------------------------------------------------------------
                        | View Items
                        |--------------------------------------------------------------------------
                        */

                        if (
                            action === 'items'
                        ) {

                            console.log(
                                'View Items clicked:',
                                id
                            );


                            console.log(
                                'Refund Items Modal:',
                                this.elements.refundOrderItemsModal
                            );


                            console.log(
                                'Refund Items Modal Instance:',
                                this.modals.refundOrderItems
                            );


                            this.loadRefundOrderItems(
                                id
                            );

                            return;

                        }




                        /*
                        |--------------------------------------------------------------------------
                        | Payments / Refund
                        |--------------------------------------------------------------------------
                        */

                        if (
                            action === 'payments'
                        ) {

                            this.loadOrderPayments(
                                id
                            );

                        }

                    }
                );

            }
        );

    },

    /*
    |--------------------------------------------------------------------------
    | Order Payments
    |--------------------------------------------------------------------------
    */

    async loadOrderPayments(
        orderId
    ) {

        this.state.selectedOrderId =
            orderId;


        this.showOrderPaymentsLoading();


        this.hideElement(
            this.elements.orderPaymentsEmpty
        );


        if (
            this.modals.orderPayments
        ) {

            this.modals.orderPayments.show();

        }


        try {

            const response =
                await fetch(
                    `/sales/returns/orders/${orderId}/payments`,
                    {

                        method:
                            'GET',

                        headers: {

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',

                        },

                        credentials:
                            'same-origin',

                    }
                );


            const result =
                await this.parseResponse(
                    response
                );


            if (
                !response.ok
                ||
                !result.success
            ) {

                throw new Error(
                    result.message
                    ||
                    'Unable to load order payments.'
                );

            }


            const data =
                result.data || {};

                
                console.log(
                    'Refund Order Payment Data:',
                    data
                );

                console.log(
                    'Refund Order:',
                    data.order
                );




            this.state.selectedOrder =
                data.order || null;


            this.state.selectedPayments =
                data.payments || [];


            this.state.refundAmount =
                Number(
                    data.total_paid || 0
                );


            this.populateOrderPayments(
                data
            );

        }
        catch (error) {

            console.error(
                'Order Payments:',
                error
            );


            this.showToast(
                error.message
                ||
                'Unable to load order payments.',
                'danger'
            );


            if (
                this.modals.orderPayments
            ) {

                this.modals.orderPayments.hide();

            }

        }
        finally {

            this.hideOrderPaymentsLoading();

        }

    },
    


    /*
    |--------------------------------------------------------------------------
    | Populate Order Payments
    |--------------------------------------------------------------------------
    */

    populateOrderPayments(
        data
    ) {

        const order =
            data.order || {};

        const payments =
            data.payments || [];


        this.setText(
            this.elements.orderPaymentsSubtitle,
            order.order_no
                ? `Review payments for ${order.order_no} before processing the refund.`
                : 'Review payments before processing the refund.'
        );


        this.setText(
            this.elements.refundOrderNumber,
            order.order_no
        );


        this.setText(
            this.elements.refundInvoiceNumber,
            order.invoice_no
        );


        this.setText(
            this.elements.refundCustomer,
            order.customer
        );
       

       this.setBadge(
            this.elements.orderPaymentOrderStatus,
            order.order_status
        );


        this.setBadge(
            this.elements.orderPaymentPaymentStatus,
            order.payment_status
        );


        this.setText(
            this.elements.refundBranch,
            order.branch
        );


        /*
        |--------------------------------------------------------------------------
        | Financial Summary
        |--------------------------------------------------------------------------
        */

        this.setText(
            this.elements.refundOrderTotal,
            this.formatCurrency(
                order.grand_total
            )
        );


      
        this.setText(
            this.elements.refundDiscount,
            Number(
                order.discount || 0
            )
        );


        this.setText(
            this.elements.refundTax,
            Number(
                order.tax || 0
            )
        );




        this.setText(
            this.elements.refundAmountPaid,
            this.formatCurrency(
                order.amount_paid
            )
        );


        this.setText(
            this.elements.refundChangeGiven,
            this.formatCurrency(
                order.change_given || 0
            )
        );


        this.setText(
            this.elements.refundBalance,
            this.formatCurrency(
                order.balance
            )
        );

        this.setText(
            this.elements.totalRefundAmount,
            this.formatCurrency(
                data.total_paid || 0
            )
        );


        this.renderPayments(
            payments
        );


        if (
            this.elements.processRefundButton
        ) {

            this.elements.processRefundButton.disabled =
                !payments.length;

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Render Payments
    |--------------------------------------------------------------------------
    */

    renderPayments(
        payments
    ) {

        if (
            !payments.length
        ) {

            this.elements.orderPaymentsTableBody.innerHTML =
                '';


            this.showElement(
                this.elements.orderPaymentsEmpty
            );

            return;

        }


        this.hideElement(
            this.elements.orderPaymentsEmpty
        );


        this.elements.orderPaymentsTableBody.innerHTML =
            payments
                .map(
                    (payment) => {

                        const reference =
                            payment.reference_no
                            ||
                            payment.transaction_reference
                            ||
                            '—';


                        return `

                            <tr>

                                <td>

                                    ${this.escapeHtml(
                                        payment.payment_number || '—'
                                    )}

                                </td>


                                <td>

                                    ${this.escapeHtml(
                                        payment.payment_method || '—'
                                    )}

                                </td>


                                <td>

                                    ${this.escapeHtml(
                                        reference
                                    )}

                                </td>


                                <td>

                                    ${this.formatCurrency(
                                        payment.amount
                                    )}

                                </td>


                                <td>

                                    ${this.statusBadge(
                                        payment.payment_status
                                    )}

                                </td>


                                <td>

                                    ${this.formatDateTime(
                                        payment.payment_date
                                    )}

                                </td>

                            </tr>

                        `;

                    }
                )
                .join('');

    },


    /*
    |--------------------------------------------------------------------------
    | Confirmation
    |--------------------------------------------------------------------------
    */

    openConfirmation() {

        if (
            !this.state.selectedOrder
            ||
            !this.state.selectedOrderId
        ) {

            this.showToast(
                'Please select an order first.',
                'warning'
            );

            return;

        }


        const order =
            this.state.selectedOrder;


        const refundAmount =
            this.state.refundAmount;


        this.setText(
            this.elements.confirmationOrderNumber,
            order.order_no
        );


        this.setText(
            this.elements.confirmationOrderStatus,
            order.order_status
        );


        this.setText(
            this.elements.confirmationRefundAmount,
            this.formatCurrency(
                refundAmount
            )
        );


        if (
            this.modals.confirmation
        ) {

            this.modals.confirmation.show();

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Process Refund
    |--------------------------------------------------------------------------
    */

    async processRefund() {

        if (
            this.state.isProcessingRefund
        ) {

            return;

        }


        const orderId =
            this.state.selectedOrderId;


        if (!orderId) {

            this.showToast(
                'No order selected for refund.',
                'warning'
            );

            return;

        }


        this.state.isProcessingRefund =
            true;


        this.setRefundButtonLoading(
            true
        );


        try {

            const response =
                await fetch(
                    `/sales/returns/orders/${orderId}/process`,
                    {

                        method:
                            'POST',

                        headers: {

                            'Accept':
                                'application/json',

                            'Content-Type':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',

                            'X-CSRF-TOKEN':
                                this.getCsrfToken(),

                        },

                        credentials:
                            'same-origin',

                        body:
                            JSON.stringify({

                                remarks:
                                    `Full refund processed for sales order: ${this.state.selectedOrder?.order_no || ''}`,

                            }),

                    }
                );


            const result =
                await this.parseResponse(
                    response
                );


            if (
                !response.ok
                ||
                !result.success
            ) {

                throw new Error(
                    result.message
                    ||
                    'Unable to process refund.'
                );

            }


            if (
                this.modals.confirmation
            ) {

                this.modals.confirmation.hide();

            }


            if (
                this.modals.orderPayments
            ) {

                this.modals.orderPayments.hide();

            }


            if (
                this.modals.refundOrders
            ) {

                this.modals.refundOrders.hide();

            }


            this.showToast(
                result.message
                ||
                'Refund processed successfully.',
                'success'
            );


            this.state.selectedOrderId =
                null;


            this.state.selectedOrder =
                null;


            this.state.selectedPayments =
                [];


            this.state.refundAmount =
                0;


            this.state.returnsPage =
                1;


            await this.loadReturns();

        }
        catch (error) {

            console.error(
                'Process Refund:',
                error
            );


            this.showToast(
                error.message
                ||
                'Unable to process refund.',
                'danger'
            );

        }
        finally {

            this.state.isProcessingRefund =
                false;


            this.setRefundButtonLoading(
                false
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Return Inspector
    |--------------------------------------------------------------------------
    */

    async openInspector(
        id
    ) {

        this.state.activeReturnId =
            id;


        this.resetInspector();


        if (
            this.inspector
        ) {

            this.inspector.show();

        }


        try {

            const response =
                await fetch(
                    `/sales/returns/${id}/details`,
                    {

                        method:
                            'GET',

                        headers: {

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',

                        },

                        credentials:
                            'same-origin',

                    }
                );


            const result =
                await this.parseResponse(
                    response
                );


            if (
                !response.ok
                ||
                !result.success
            ) {

                throw new Error(
                    result.message
                    ||
                    'Unable to load return details.'
                );

            }


            this.populateInspector(
                result.data || {}
            );

        }
        catch (error) {

            console.error(
                'Return Inspector:',
                error
            );


            this.showToast(
                error.message
                ||
                'Unable to load return details.',
                'danger'
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Populate Inspector
    |--------------------------------------------------------------------------
    */

    populateInspector(
        data
    ) {

        const order =
            data.order || {};


        const customer =
            data.customer || null;


        const branch =
            data.branch || null;


        this.setBadge(
            this.elements.returnInspectorStatus,
            data.return_status
        );


        this.setText(
            this.elements.returnInspectorNumber,
            data.return_number
        );


        this.setText(
            this.elements.returnInspectorOrderNumber,
            order.order_no
        );


        this.setText(
            this.elements.returnInspectorInvoiceNumber,
            order.invoice_no
        );


        this.setText(
            this.elements.returnInspectorCustomer,
            customer?.name
            ||
            'Walk-in Customer'
        );


        this.setText(
            this.elements.returnInspectorBranch,
            branch?.name
        );


        /*
        |----------------------------------------------------------------------
        | Terminal
        |----------------------------------------------------------------------
        |
        | The details() controller currently does not return terminal data.
        | Therefore the inspector remains "—" until the controller exposes it.
        |
        */

        this.setText(
            this.elements.returnInspectorTerminal,
            data.terminal?.name
            ||
            data.terminal
            ||
            '—'
        );


        this.setText(
            this.elements.returnInspectorOrderTotal,
            this.formatCurrency(
                order.grand_total
            )
        );


        this.setText(
            this.elements.returnInspectorAmountPaid,
            this.formatCurrency(
                order.amount_paid
            )
        );


        this.setText(
            this.elements.returnInspectorRefundAmount,
            this.formatCurrency(
                data.refund_amount
            )
        );


        this.setText(
            this.elements.returnInspectorBalance,
            this.formatCurrency(
                order.balance
            )
        );


        this.setBadge(
            this.elements.returnInspectorOrderStatus,
            order.order_status
        );


        this.setBadge(
            this.elements.returnInspectorPaymentStatus,
            order.payment_status
        );


        this.renderInspectorPayments(
            data
        );


        this.setText(
            this.elements.returnInspectorRemarks,
            data.remarks
            ||
            '—'
        );


        this.setText(
            this.elements.returnInspectorProcessedBy,
            data.processed_by
            ||
            '—'
        );


        this.setText(
            this.elements.returnInspectorCreatedAt,
            this.formatDateTime(
                data.created_at
            )
        );


        this.setText(
            this.elements.returnInspectorUpdatedAt,
            this.formatDateTime(
                data.updated_at
            )
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Inspector Payments
    |--------------------------------------------------------------------------
    */

    renderInspectorPayments(
        data
    ) {

        /*
        |----------------------------------------------------------------------
        | Current details() endpoint returns return items, not payment records.
        |
        | Until the controller exposes refunded payment data, we display the
        | refund summary as the available payment activity.
        |----------------------------------------------------------------------
        */

        const container =
            this.elements.returnInspectorPayments;


        if (!container) {

            return;

        }


        const amount =
            Number(
                data.refund_amount || 0
            );


        if (
            amount <= 0
        ) {

            container.innerHTML = `

                <div class="text-muted small">

                    No refunded payments.

                </div>

            `;

            return;

        }


        container.innerHTML = `

            <div class="border rounded p-3">

                <div class="d-flex align-items-center justify-content-between">

                    <div>

                        <div class="fw-semibold">
                            Full Refund
                        </div>

                        <div class="text-muted small">
                            All completed order payments were refunded.
                        </div>

                    </div>


                    <strong>
                        ${this.formatCurrency(amount)}
                    </strong>

                </div>

            </div>

        `;

    },


    /*
    |--------------------------------------------------------------------------
    | Reset Inspector
    |--------------------------------------------------------------------------
    */

    resetInspector() {

        const textElements = [

            this.elements.returnInspectorNumber,

            this.elements.returnInspectorOrderNumber,

            this.elements.returnInspectorInvoiceNumber,

            this.elements.returnInspectorCustomer,

            this.elements.returnInspectorBranch,

            this.elements.returnInspectorTerminal,

            this.elements.returnInspectorProcessedBy,

            this.elements.returnInspectorCreatedAt,

            this.elements.returnInspectorUpdatedAt,

        ];


        textElements.forEach(
            (element) => {

                this.setText(
                    element,
                    '—'
                );

            }
        );


   
        this.setText(
            this.elements.returnInspectorOrderTotal,
            `${window.EmnexSettings.currencySymbol}0.00`
        );


        this.setText(
            this.elements.returnInspectorAmountPaid,
            `${window.EmnexSettings.currencySymbol}0.00`
        );


        this.setText(
            this.elements.returnInspectorRefundAmount,
            `${window.EmnexSettings.currencySymbol}0.00`
        );


        this.setText(
            this.elements.returnInspectorBalance,
            `${window.EmnexSettings.currencySymbol}0.00`
        );



        this.setBadge(
            this.elements.returnInspectorStatus,
            null
        );


        this.setBadge(
            this.elements.returnInspectorOrderStatus,
            null
        );


        this.setBadge(
            this.elements.returnInspectorPaymentStatus,
            null
        );


        this.setText(
            this.elements.returnInspectorRemarks,
            '—'
        );


        if (
            this.elements.returnInspectorPayments
        ) {

            this.elements.returnInspectorPayments.innerHTML = `

                <div class="text-muted small">

                    Loading refund information...

                </div>

            `;

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Print Receipt
    |--------------------------------------------------------------------------
    */

    printReceipt() {

        const id =
            this.state.activeReturnId;


        if (!id) {

            this.showToast(
                'No return selected.',
                'warning'
            );

            return;

        }


        const url =
            `/sales/returns/${id}/receipt`;


        window.open(
            url,
            '_blank'
        );

    },


   /*
    |--------------------------------------------------------------------------
    | Show Returns Loading
    |--------------------------------------------------------------------------
    */

    showReturnsLoading() {

        this.hideElement(
            this.elements.returnsTableBody
        );


        this.hideElement(
            this.elements.returnsTableEmpty
        );


        this.hideElement(
            this.elements.returnsTableError
        );


        this.showElement(
            this.elements.returnsTableLoading
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Show Refund Orders Loading
    |--------------------------------------------------------------------------
    */

    showRefundOrdersLoading() {

        const tbody =
            this.elements.refundOrdersTableBody;


        if (!tbody) {

            return;

        }


        tbody.innerHTML = `

            <tr>

                <td
                    colspan="100%"
                    class="text-center py-5"
                >

                    <div
                        class="spinner-border text-primary"
                        role="status"
                    >

                        <span class="visually-hidden">
                            Loading...
                        </span>

                    </div>

                    <div class="text-muted small mt-2">

                        Loading orders...

                    </div>

                </td>

            </tr>

        `;

    },

    hideRefundOrdersLoading() {

        this.hideElement(
            this.elements.refundOrdersLoading
        );

    },


    showOrderPaymentsLoading() {

        this.showElement(
            this.elements.orderPaymentsLoading
        );


        this.elements.orderPaymentsTableBody.innerHTML =
            '';

    },


    hideOrderPaymentsLoading() {

        this.hideElement(
            this.elements.orderPaymentsLoading
        );

    },   

    /*
    |--------------------------------------------------------------------------
    | Show Refund Order Items Loading
    |--------------------------------------------------------------------------
    */

    showRefundOrderItemsLoading() {

        this.showElement(
            this.elements.refundOrderItemsLoading
        );


        this.hideElement(
            this.elements.refundOrderItemsContainer
        );


        this.hideElement(
            this.elements.refundOrderItemsEmpty
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Hide Refund Order Items Loading
    |--------------------------------------------------------------------------
    */

    hideRefundOrderItemsLoading() {

        this.hideElement(
            this.elements.refundOrderItemsLoading
        );

    },


    showRefundOrdersError(
        message
    ) {

        this.hideElement(
            this.elements.refundOrdersEmpty
        );


        this.hideElement(
            this.elements.refundOrdersLoading
        );


        if (
            this.elements.refundOrdersErrorMessage
        ) {

            this.elements.refundOrdersErrorMessage.textContent =
                message;

        }


        this.showElement(
            this.elements.refundOrdersError
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Render Returns Error
    |--------------------------------------------------------------------------
    */

    renderReturnsError(
        message
    ) {

        this.hideElement(
            this.elements.returnsTableLoading
        );


        this.hideElement(
            this.elements.returnsTableBody
        );


        this.hideElement(
            this.elements.returnsTableEmpty
        );


        if (
            this.elements.returnsTableErrorMessage
        ) {

            this.elements.returnsTableErrorMessage.textContent =
                message
                ||
                'Unable to load sales returns.';

        }


        this.showElement(
            this.elements.returnsTableError
        );

    },

    /*
    |--------------------------------------------------------------------------
    | Refund Orders Pagination
    |--------------------------------------------------------------------------
    */

    renderRefundOrdersPagination(
        pagination
    ) {

        const currentPage =
            Number(
                pagination.current_page || 1
            );


        const lastPage =
            Number(
                pagination.last_page || 1
            );


        const total =
            Number(
                pagination.total || 0
            );


        const perPage =
            Number(
                pagination.per_page || 15
            );


        const from =
            total > 0
                ? (
                    (currentPage - 1) *
                    perPage
                ) + 1
                : 0;


        const to =
            total > 0
                ? Math.min(
                    currentPage * perPage,
                    total
                )
                : 0;


        if (
            this.elements.refundOrdersPaginationInfo
        ) {

            this.elements.refundOrdersPaginationInfo.textContent =
                `Showing ${from} to ${to} of ${total} orders`;

        }


        if (
            !this.elements.refundOrdersPagination
        ) {

            return;

        }


        if (
            lastPage <= 1
        ) {

            this.elements.refundOrdersPagination.innerHTML =
                '';

            return;

        }


        this.elements.refundOrdersPagination.innerHTML =
            this.buildPagination(
                currentPage,
                lastPage
            );

    },


    /*
    |--------------------------------------------------------------------------
    | Pagination Builder
    |--------------------------------------------------------------------------
    */

    buildPagination(
        currentPage,
        lastPage
    ) {

        let html =
            '';


        html += `

            <button
                type="button"
                class="btn btn-sm btn-light me-1 ${currentPage <= 1 ? 'disabled' : ''}"
                data-page="${currentPage - 1}"
                ${currentPage <= 1 ? 'disabled' : ''}
            >

                <i class="bi bi-chevron-left"></i>

            </button>

        `;


        const start =
            Math.max(
                1,
                currentPage - 2
            );


        const end =
            Math.min(
                lastPage,
                currentPage + 2
            );


        for (
            let page = start;
            page <= end;
            page++
        ) {

            html += `

                <button
                    type="button"
                    class="btn btn-sm ${page === currentPage ? 'btn-primary' : 'btn-light'} me-1"
                    data-page="${page}"
                >

                    ${page}

                </button>

            `;

        }


        html += `

            <button
                type="button"
                class="btn btn-sm btn-light"
                data-page="${currentPage + 1}"
                ${currentPage >= lastPage ? 'disabled' : ''}
            >

                <i class="bi bi-chevron-right"></i>

            </button>

        `;


        return html;

    },


    /*
    |--------------------------------------------------------------------------
    | Badge
    |--------------------------------------------------------------------------
    */

    statusBadge(
        status
    ) {

        if (!status) {

            return '<span class="badge bg-light text-muted">—</span>';

        }


        const normalized =
            String(
                status
            )
            .toLowerCase();


        let className =
            'bg-light text-dark';


        if (
            normalized === 'completed'
            ||
            normalized === 'paid'
            ||
            normalized === 'refunded'
        ) {

            className =
                'bg-success-subtle text-success';

        }
        else if (
            normalized === 'pending'
            ||
            normalized === 'partial'
            ||
            normalized === 'held'
        ) {

            className =
                'bg-warning-subtle text-warning-emphasis';

        }
        else if (
            normalized === 'cancelled'
            ||
            normalized === 'failed'
            ||
            normalized === 'rejected'
        ) {

            className =
                'bg-danger-subtle text-danger';

        }


        return `

            <span class="badge ${className}">

                ${this.escapeHtml(
                    status
                )}

            </span>

        `;

    },


    /*
    |--------------------------------------------------------------------------
    | Set Badge
    |--------------------------------------------------------------------------
    */

    setBadge(
        element,
        value
    ) {

        if (!element) {

            return;

        }


        element.className =
            'badge';


        if (!value) {

            element.textContent =
                '—';

            return;

        }


        const normalized =
            String(
                value
            )
            .toLowerCase();


        if (
            normalized === 'completed'
            ||
            normalized === 'paid'
            ||
            normalized === 'refunded'
        ) {

            element.classList.add(
                'bg-success-subtle',
                'text-success'
            );

        }
        else if (
            normalized === 'pending'
            ||
            normalized === 'partial'
            ||
            normalized === 'held'
        ) {

            element.classList.add(
                'bg-warning-subtle',
                'text-warning-emphasis'
            );

        }
        else if (
            normalized === 'cancelled'
            ||
            normalized === 'failed'
            ||
            normalized === 'rejected'
        ) {

            element.classList.add(
                'bg-danger-subtle',
                'text-danger'
            );

        }
        else {

            element.classList.add(
                'bg-light',
                'text-dark'
            );

        }


        element.textContent =
            value;

    },


    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    */

    formatCurrency(
        amount
    ) {

        const value =
            Number(
                amount || 0
            );


        return new Intl.NumberFormat(
            'en-NG',
            {

                style:
                    'currency',

                currency:
                    'NGN',

                minimumFractionDigits:
                    2,

                maximumFractionDigits:
                    2,

            }
        ).format(
            value
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Number
    |--------------------------------------------------------------------------
    */

    formatNumber(
        number
    ) {

        return new Intl.NumberFormat(
            'en-NG'
        ).format(
            Number(
                number || 0
            )
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Date
    |--------------------------------------------------------------------------
    */

    formatDateTime(
        value
    ) {

        if (!value) {

            return '—';

        }


        const date =
            new Date(
                value
            );


        if (
            Number.isNaN(
                date.getTime()
            )
        ) {

            return '—';

        }


        return new Intl.DateTimeFormat(
            'en-NG',
            {

                day:
                    '2-digit',

                month:
                    'short',

                year:
                    'numeric',

                hour:
                    '2-digit',

                minute:
                    '2-digit',

            }
        ).format(
            date
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Text Helper
    |--------------------------------------------------------------------------
    */

    setText(
        element,
        value
    ) {

        if (!element) {

            return;

        }


        element.textContent =
            value === null
            ||
            value === undefined
            ||
            value === ''
                ? '—'
                : value;

    },


    /*
    |--------------------------------------------------------------------------
    | Show Element
    |--------------------------------------------------------------------------
    */

    showElement(
        element
    ) {

        element?.classList.remove(
            'd-none'
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Hide Element
    |--------------------------------------------------------------------------
    */

    hideElement(
        element
    ) {

        element?.classList.add(
            'd-none'
        );

    },


    /*
    |--------------------------------------------------------------------------
    | CSRF
    |--------------------------------------------------------------------------
    */

    getCsrfToken() {

        const meta =
            document.querySelector(
                'meta[name="csrf-token"]'
            );


        return meta?.getAttribute(
            'content'
        )
        ||
        '';

    },


    /*
    |--------------------------------------------------------------------------
    | Response Parser
    |--------------------------------------------------------------------------
    */

    async parseResponse(
        response
    ) {

        const contentType =
            response.headers.get(
                'content-type'
            )
            ||
            '';


        if (
            contentType.includes(
                'application/json'
            )
        ) {

            return response.json();

        }


        const text =
            await response.text();


        throw new Error(
            text
            ||
            `Request failed with status ${response.status}.`
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Refund Button Loading
    |--------------------------------------------------------------------------
    */

    setRefundButtonLoading(
        loading
    ) {

        const button =
            this.elements.confirmProcessRefundButton;


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
                    class="spinner-border spinner-border-sm me-2"
                    role="status"
                ></span>

                Processing...

            `;

        }
        else {

            button.disabled =
                false;


            button.innerHTML =
                button.dataset.originalHtml
                ||
                `

                    <i class="bi bi-arrow-counterclockwise me-2"></i>

                    Yes, Process Refund

                `;

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Toast
    |--------------------------------------------------------------------------
    */

    showToast(
        message,
        type = 'success'
    ) {

        if (
            typeof window.showToast ===
            'function'
        ) {

            window.showToast(
                message,
                type
            );

            return;

        }


        /*
        |----------------------------------------------------------------------
        | Bootstrap fallback
        |----------------------------------------------------------------------
        */

        const containerId =
            'emnexSalesReturnsToastContainer';


        let container =
            document.getElementById(
                containerId
            );


        if (!container) {

            container =
                document.createElement(
                    'div'
                );


            container.id =
                containerId;


            container.className =
                'toast-container position-fixed top-0 end-0 p-3';


            container.style.zIndex =
                '1090';


            document.body.appendChild(
                container
            );

        }


        const toast =
            document.createElement(
                'div'
            );


        toast.className =
            'toast align-items-center border-0';


        toast.setAttribute(
            'role',
            'alert'
        );


        const bg =
            type === 'danger'
                ? 'text-bg-danger'
                : type === 'warning'
                    ? 'text-bg-warning'
                    : 'text-bg-success';


        toast.classList.add(
            bg
        );


        toast.innerHTML = `

            <div class="d-flex">

                <div class="toast-body">

                    ${this.escapeHtml(
                        message
                    )}

                </div>


                <button
                    type="button"
                    class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast"
                ></button>

            </div>

        `;


        container.appendChild(
            toast
        );


        const instance =
            bootstrap.Toast.getOrCreateInstance(
                toast,
                {
                    delay:
                        4000
                }
            );


        instance.show();


        toast.addEventListener(
            'hidden.bs.toast',
            () => {

                toast.remove();

            }
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Escape HTML
    |--------------------------------------------------------------------------
    */

    escapeHtml(
        value
    ) {

        const div =
            document.createElement(
                'div'
            );


        div.textContent =
            value === null
            ||
            value === undefined
                ? ''
                : String(
                    value
                );


        return div.innerHTML;

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
        
        SalesReturns.init();       

    }
);



