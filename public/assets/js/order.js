/*
|--------------------------------------------------------------------------
| Sales Orders
|--------------------------------------------------------------------------
*/

const OrderModule = {

    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    state: {

        mode:
            'create',

        ordersPage:
            1,

        selectedOrder:
            null,

        orderCustomerModalInstance:
            null,

        orderTerminalModalInstance:
            null,

        orderItems:
            [],

        products:
            [],

        orderPayment: {

            amountPaid:
                0,

        },

        orderTotals: {

            subtotal:
                0,

            discount:
                0,

            tax:
                0,

            total:
                0,

            grandTotal:
                0,

            amountPaid:
                0,

            balance:
                0,

            change:
                0,

            totalItems:
                0,

            totalQuantity:
                0,

            orderInspectorInstance:
                null,

        },

        editingOrderId:
            null,

    },

    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    elements: {},


    /*
    |--------------------------------------------------------------------------
    | Bootstrap Components
    |--------------------------------------------------------------------------
    */

    orderModalInstance:
        null,

    orderInspectorInstance:
        null,


    /*
    |--------------------------------------------------------------------------
    | Initialize
    |--------------------------------------------------------------------------
    */

    init()
    {

        this.cacheElements();

        this.initializeComponents();

        this.bindEvents();

        this.loadInitialData();

    },


    /*
    |--------------------------------------------------------------------------
    | Cache Elements
    |--------------------------------------------------------------------------
    */

    cacheElements()
    {

        /*
        |----------------------------------------------------------------------
        | Page
        |----------------------------------------------------------------------
        */

        this.elements.newOrderBtn =
            document.getElementById(
                'newOrderBtn'
            );


        /*
        |----------------------------------------------------------------------
        | KPI
        |----------------------------------------------------------------------
        */

        this.elements.ordersTotal =
            document.getElementById(
                'ordersTotal'
            );

        this.elements.ordersDraft =
            document.getElementById(
                'ordersDraft'
            );

        this.elements.ordersCompleted =
            document.getElementById(
                'ordersCompleted'
            );

        this.elements.ordersSalesValue =
            document.getElementById(
                'ordersSalesValue'
            );

        /*
        |--------------------------------------------------------------------------
        | Sales Order Global Action Menu
        |--------------------------------------------------------------------------
        */

        this.elements.salesOrderActionMenu =
            document.getElementById(
                'salesOrderActionMenu'
            );


        /*
        |----------------------------------------------------------------------
        | Orders Table
        |----------------------------------------------------------------------
        */

        this.elements.ordersTable =
            document.getElementById(
                'ordersTable'
            );


        this.elements.ordersPagination =
            document.getElementById(
                'ordersPagination'
            );


        /*
        |----------------------------------------------------------------------
        | Orders Filters
        |----------------------------------------------------------------------
        */

        this.elements.ordersSearch =
            document.getElementById(
                'ordersSearch'
            );

        this.elements.ordersCustomerFilter =
            document.getElementById(
                'ordersCustomerFilter'
            );

        this.elements.ordersBranchFilter =
            document.getElementById(
                'ordersBranchFilter'
            );

        this.elements.ordersStatusFilter =
            document.getElementById(
                'ordersStatusFilter'
            );

        this.elements.ordersPaymentStatusFilter =
            document.getElementById(
                'ordersPaymentStatusFilter'
            );

        this.elements.ordersDateFrom =
            document.getElementById(
                'ordersDateFrom'
            );

        this.elements.ordersDateTo =
            document.getElementById(
                'ordersDateTo'
            );

        this.elements.ordersReset =
            document.getElementById(
                'ordersReset'
            );

        this.elements.ordersRefresh =
            document.getElementById(
                'ordersRefresh'
            );


        /*
        |----------------------------------------------------------------------
        | Order Modal
        |----------------------------------------------------------------------
        */

        this.elements.orderModal =
            document.getElementById(
                'orderModal'
            );

        this.elements.orderForm =
            document.getElementById(
                'orderForm'
            );

        this.elements.orderId =
            document.getElementById(
                'orderId'
            );

        this.elements.orderModalLabel =
            document.getElementById(
                'orderModalLabel'
            );

        this.elements.orderModalDescription =
            document.getElementById(
                'orderModalDescription'
            );

        this.elements.orderCustomer =
            document.getElementById(
                'orderCustomer'
            );

        this.elements.orderBranch =
            document.getElementById(
                'orderBranch'
            );

        this.elements.orderTerminal =
            document.getElementById(
                'orderTerminal'
            );

        this.elements.orderSalesChannel =
            document.getElementById(
                'orderSalesChannel'
            );

        this.elements.orderDate =
            document.getElementById(
                'orderDate'
            );

        this.elements.orderItemsTable =
            document.getElementById(
                'orderItemsTable'
            );

        this.elements.orderItems =
            document.getElementById(
                'orderItems'
            );

        this.elements.orderEmptyItems =
            document.getElementById(
                'orderEmptyItems'
            );

        this.elements.addOrderItemBtn =
            document.getElementById(
                'addOrderItemBtn'
            );

        this.elements.orderRemarks =
            document.getElementById(
                'orderRemarks'
            );

        this.elements.orderSubtotal =
            document.getElementById(
                'orderSubtotal'
            );

        this.elements.orderDiscount =
            document.getElementById(
                'orderDiscount'
            );

        this.elements.orderTax =
            document.getElementById(
                'orderTax'
            );

        this.elements.orderTotal =
            document.getElementById(
                'orderTotal'
            );

        this.elements.orderAmountPaid =
            document.getElementById(
                'orderAmountPaid'
            );

        this.elements.orderBalance =
            document.getElementById(
                'orderBalance'
            );

        this.elements.orderChange =
            document.getElementById(
                'orderChange'
            );

        this.elements.orderSubmitBtn =
            document.getElementById(
                'orderSubmitBtn'
            );

        this.elements.orderSubmitText =
            document.getElementById(
                'orderSubmitText'
            );

        this.elements.orderSubmitSpinner =
            document.getElementById(
                'orderSubmitSpinner'
            );

        this.elements.orderCreateTerminalWrap =
            document.getElementById(
                'orderCreateTerminalWrap'
            );


        this.elements.createTerminalFromOrderBtn =
            document.getElementById(
                'createTerminalFromOrderBtn'
            );

        /*
        |--------------------------------------------------------------------------
        | Complete Order Modal
        |--------------------------------------------------------------------------
        */

        this.elements.completeOrderModal =
            document.getElementById(
                'completeOrderModal'
            );

        this.elements.completeOrderForm =
            document.getElementById(
                'completeOrderForm'
            );

        this.elements.completeOrderId =
            document.getElementById(
                'completeOrderId'
            );

        this.elements.completeOrderNumber =
            document.getElementById(
                'completeOrderNumber'
            );

        this.elements.completeOrderCustomer =
            document.getElementById(
                'completeOrderCustomer'
            );

        this.elements.completeOrderItems =
            document.getElementById(
                'completeOrderItems'
            );

        this.elements.completeOrderGrandTotal =
            document.getElementById(
                'completeOrderGrandTotal'
            );

        this.elements.completeOrderAmountDue =
            document.getElementById(
                'completeOrderAmountDue'
            );

        this.elements.completeOrderAmountPaid =
            document.getElementById(
                'completeOrderAmountPaid'
            );

        this.elements.completeOrderPaymentMethod =
            document.getElementById(
                'completeOrderPaymentMethod'
            );

        this.elements.completeOrderPaymentPreview =
            document.getElementById(
                'completeOrderPaymentPreview'
            );

        this.elements.completeOrderPreviewDue =
            document.getElementById(
                'completeOrderPreviewDue'
            );

        this.elements.completeOrderPreviewPaid =
            document.getElementById(
                'completeOrderPreviewPaid'
            );

        this.elements.completeOrderPreviewBalance =
            document.getElementById(
                'completeOrderPreviewBalance'
            );

        this.elements.completeOrderPreviewChange =
            document.getElementById(
                'completeOrderPreviewChange'
            );

        this.elements.completeOrderWarning =
            document.getElementById(
                'completeOrderWarning'
            );

        this.elements.completeOrderWarningText =
            document.getElementById(
                'completeOrderWarningText'
            );

        this.elements.completeOrderSubmitBtn =
            document.getElementById(
                'completeOrderSubmitBtn'
            );

        this.elements.completeOrderSubmitText =
            document.getElementById(
                'completeOrderSubmitText'
            );

        this.elements.completeOrderSubmitSpinner =
            document.getElementById(
                'completeOrderSubmitSpinner'
            );

        /*
        |--------------------------------------------------------------------------
        | Quick Customer
        |--------------------------------------------------------------------------
        */

        this.elements.createCustomerFromOrderBtn =
            document.getElementById(
                'createCustomerFromOrderBtn'
            );


        this.elements.orderCustomerModal =
            document.getElementById(
                'orderCustomerModal'
            );

        this.elements.orderCustomerForm =
            document.getElementById(
                'orderCustomerForm'
            );

        this.elements.orderCustomerFirstName =
            document.getElementById(
                'orderCustomerFirstName'
            );

        this.elements.orderCustomerLastName =
            document.getElementById(
                'orderCustomerLastName'
            );

        this.elements.orderCustomerPhone =
            document.getElementById(
                'orderCustomerPhone'
            );

        this.elements.orderCustomerEmail =
            document.getElementById(
                'orderCustomerEmail'
            );

        this.elements.orderCustomerType =
            document.getElementById(
                'orderCustomerType'
            );

        this.elements.orderCustomerGroup =
            document.getElementById(
                'orderCustomerGroup'
            );

        this.elements.orderCustomerAddress =
            document.getElementById(
                'orderCustomerAddress'
            );

        this.elements.orderCustomerCreditLimit =
            document.getElementById(
                'orderCustomerCreditLimit'
            );

        this.elements.orderCustomerSubmitBtn =
            document.getElementById(
                'orderCustomerSubmitBtn'
            );

        this.elements.orderCustomerSubmitText =
            document.getElementById(
                'orderCustomerSubmitText'
            );

        this.elements.orderCustomerSubmitSpinner =
            document.getElementById(
                'orderCustomerSubmitSpinner'
            );


        /*
        |--------------------------------------------------------------------------
        | Quick Terminal
        |--------------------------------------------------------------------------
        */

        this.elements.orderTerminalModal =
            document.getElementById(
                'orderTerminalModal'
            );

        this.elements.orderTerminalForm =
            document.getElementById(
                'orderTerminalForm'
            );

        this.elements.orderTerminalBranchId =
            document.getElementById(
                'orderTerminalBranchId'
            );

        this.elements.orderTerminalBranchName =
            document.getElementById(
                'orderTerminalBranchName'
            );

        this.elements.orderTerminalName =
            document.getElementById(
                'orderTerminalName'
            );

        this.elements.orderTerminalCode =
            document.getElementById(
                'orderTerminalCode'
            );

        this.elements.orderTerminalDeviceName =
            document.getElementById(
                'orderTerminalDeviceName'
            );

        this.elements.orderTerminalIpAddress =
            document.getElementById(
                'orderTerminalIpAddress'
            );

        this.elements.orderTerminalDescription =
            document.getElementById(
                'orderTerminalDescription'
            );

        this.elements.orderTerminalSubmitBtn =
            document.getElementById(
                'orderTerminalSubmitBtn'
            );

        this.elements.orderTerminalSubmitText =
            document.getElementById(
                'orderTerminalSubmitText'
            );

        this.elements.orderTerminalSubmitSpinner =
            document.getElementById(
                'orderTerminalSubmitSpinner'
            );


        /*
        |----------------------------------------------------------------------
        | Order Inspector
        |----------------------------------------------------------------------
        */

        this.elements.orderInspector =
            document.getElementById(
                'orderInspector'
            );

        this.elements.orderInspectorLabel =
            document.getElementById(
                'orderInspectorLabel'
            );

        this.elements.inspectorOrderStatus =
            document.getElementById(
                'inspectorOrderStatus'
            );

        this.elements.inspectorOrderPaymentStatus =
            document.getElementById(
                'inspectorOrderPaymentStatus'
            );

        this.elements.inspectorOrderCustomer =
            document.getElementById(
                'inspectorOrderCustomer'
            );

        this.elements.inspectorOrderBranch =
            document.getElementById(
                'inspectorOrderBranch'
            );

        this.elements.inspectorOrderTerminal =
            document.getElementById(
                'inspectorOrderTerminal'
            );

        this.elements.inspectorOrderSalesChannel =
            document.getElementById(
                'inspectorOrderSalesChannel'
            );

        this.elements.inspectorOrderDate =
            document.getElementById(
                'inspectorOrderDate'
            );

        this.elements.inspectorOrderCashier =
            document.getElementById(
                'inspectorOrderCashier'
            );

        this.elements.inspectorOrderItems =
            document.getElementById(
                'inspectorOrderItems'
            );

        this.elements.inspectorOrderItemCount =
            document.getElementById(
                'inspectorOrderItemCount'
            );

        this.elements.inspectorOrderQuantity =
            document.getElementById(
                'inspectorOrderQuantity'
            );

        this.elements.inspectorOrderSubtotal =
            document.getElementById(
                'inspectorOrderSubtotal'
            );

        this.elements.inspectorOrderDiscount =
            document.getElementById(
                'inspectorOrderDiscount'
            );

        this.elements.inspectorOrderTax =
            document.getElementById(
                'inspectorOrderTax'
            );

        this.elements.inspectorOrderTotal =
            document.getElementById(
                'inspectorOrderTotal'
            );

        this.elements.inspectorOrderAmountPaid =
            document.getElementById(
                'inspectorOrderAmountPaid'
            );

        this.elements.inspectorOrderBalance =
            document.getElementById(
                'inspectorOrderBalance'
            );

        this.elements.inspectorOrderChange =
            document.getElementById(
                'inspectorOrderChange'
            );

        this.elements.inspectorOrderRemarks =
            document.getElementById(
                'inspectorOrderRemarks'
            );

        this.elements.inspectorOrderCreatedBy =
            document.getElementById(
                'inspectorOrderCreatedBy'
            );

        this.elements.inspectorOrderCreatedAt =
            document.getElementById(
                'inspectorOrderCreatedAt'
            );

        this.elements.inspectorOrderUpdatedBy =
            document.getElementById(
                'inspectorOrderUpdatedBy'
            );

        this.elements.inspectorOrderUpdatedAt =
            document.getElementById(
                'inspectorOrderUpdatedAt'
            );

        this.elements.inspectorOrderCompletedAt =
            document.getElementById(
                'inspectorOrderCompletedAt'
            );

    },


    /*
    |--------------------------------------------------------------------------
    | Initialize Components
    |--------------------------------------------------------------------------
    */

    initializeComponents()
    {

        /*
        |----------------------------------------------------------------------
        | Order Modal
        |----------------------------------------------------------------------
        */

        if (
            this.elements.orderModal
        ) {

            this.orderModalInstance =
                bootstrap.Modal.getOrCreateInstance(
                    this.elements.orderModal
                );

        }

        /*
        |--------------------------------------------------------------------------
        | Quick Customer Modal
        |--------------------------------------------------------------------------
        */

        if (
            this.elements.orderCustomerModal
        ) {

            this.orderCustomerModalInstance =
                bootstrap.Modal.getOrCreateInstance(
                    this.elements.orderCustomerModal
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Quick Terminal Modal
        |--------------------------------------------------------------------------
        */

        if (
            this.elements.orderTerminalModal
        ) {

            this.orderTerminalModalInstance =
                bootstrap.Modal.getOrCreateInstance(
                    this.elements.orderTerminalModal
                );

        }

        /*
        |--------------------------------------------------------------------------
        | Complete Order Modal
        |--------------------------------------------------------------------------
        */

        if (
            this.elements.completeOrderModal
        ) {

            this.completeOrderModalInstance =
                bootstrap.Modal.getOrCreateInstance(
                    this.elements.completeOrderModal
                );

        }


       /*
        |--------------------------------------------------------------------------
        | Order Inspector
        |--------------------------------------------------------------------------
        */

        if (
            this.elements.orderInspector
        ) {

            this.orderInspectorInstance =
                bootstrap.Offcanvas.getOrCreateInstance(
                    this.elements.orderInspector
                );

        }
        /*
        |--------------------------------------------------------------------------
        | Order Action Dropdowns
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '#ordersTable [data-bs-toggle="dropdown"]'
            )
            .forEach(
                element => {

                    new bootstrap.Dropdown(
                        element,
                        {
                            container:
                                'body'
                        }
                    );

                }
            );

    },


    /*
    |--------------------------------------------------------------------------
    | Bind Events
    |--------------------------------------------------------------------------
    */

    bindEvents()
    {

        /*
        |----------------------------------------------------------------------
        | New Order
        |----------------------------------------------------------------------
        */

        this.elements.newOrderBtn?.addEventListener(
            'click',
            () => {

                this.openCreateOrder();

            }
        );

    /*
        |--------------------------------------------------------------------------
        | Sales Order Action Trigger
        |--------------------------------------------------------------------------
        */

        this.elements.ordersTable?.addEventListener(
            'click',
            event => {

                const trigger =
                    event.target.closest(
                        '.sales-order-action-trigger'
                    );


                if (!trigger) {

                    return;

                }


                event.preventDefault();


                event.stopPropagation();


                this.openOrderActionMenu(
                    trigger
                );

            }
        );

        /*
        |--------------------------------------------------------------------------
        | Global Order Action Menu Actions
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | Order Action Menu
        |--------------------------------------------------------------------------
        */

        this.elements.salesOrderActionMenu?.addEventListener(
            'click',
            event => {

                const button =
                    event.target.closest(
                        '[data-order-action]'
                    );


                if (!button) {

                    return;

                }


                const action =
                    button.dataset.orderAction;


                const orderId =
                    this.state.actionOrderId;


                this.closeOrderActionMenu();


                if (!orderId) {

                    return;

                }


                if (
                    action === 'view'
                ) {

                    this.openInspector(
                        orderId
                    );

                    return;

                }


                if (
                    action === 'edit'
                ) {

                    this.openEditOrder(
                        orderId
                    );

                    return;

                }


                if (
                    action === 'complete'
                ) {

                    this.openCompleteOrder(
                        orderId
                    );

                    return;

                }


                if (
                    action === 'delete'
                ) {

                    this.confirmDeleteOrder(
                        orderId
                    );

                }

            }
        );
        /*
        |--------------------------------------------------------------------------
        | Close Global Action Menu
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            event => {

                if (
                    event.target.closest(
                        '.sales-order-action-trigger'
                    )
                ) {

                    return;

                }


                if (
                    event.target.closest(
                        '#salesOrderActionMenu'
                    )
                ) {

                    return;

                }


                this.closeOrderActionMenu();

            }
        );

        /*
        |--------------------------------------------------------------------------
        | Complete Order Payment Preview
        |--------------------------------------------------------------------------
        */

        this.elements.completeOrderAmountPaid?.addEventListener(
            'input',
            () => {

                this.updateCompleteOrderPaymentPreview();

            }
        );


        /*
        |----------------------------------------------------------------------
        | Add Order Item
        |----------------------------------------------------------------------
        */

        this.elements.addOrderItemBtn?.addEventListener(
            'click',
            () => {

                this.addOrderItem();

            }
        );

        /*
        |--------------------------------------------------------------------------
        | Product Picker
        |--------------------------------------------------------------------------
        */

        this.elements.orderItems?.addEventListener(
            'focusin',
            event => {

                const input =
                    event.target.closest(
                        '.sales-order-product-input'
                    );


                if (!input) {

                    return;

                }


                const combobox =
                    input.closest(
                        '.sales-order-product-combobox'
                    );


                if (!combobox) {

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Open Picker
                |--------------------------------------------------------------------------
                */

                combobox.classList.add(
                    'is-open'
                );


                /*
                |--------------------------------------------------------------------------
                | Initial Search
                |--------------------------------------------------------------------------
                */

                this.searchOrderProducts(
                    input.dataset.itemId,
                    input.value
                );

            }
        );


        this.elements.orderItems?.addEventListener(
            'input',
            event => {

                const input =
                    event.target.closest(
                        '.sales-order-product-input'
                    );


                if (!input) {

                    return;

                }


                const combobox =
                    input.closest(
                        '.sales-order-product-combobox'
                    );


                if (combobox) {

                    combobox.classList.add(
                        'is-open'
                    );

                }


                this.searchOrderProducts(
                    input.dataset.itemId,
                    input.value
                );

            }
        );


        this.elements.orderItems?.addEventListener(
            'click',
            event => {

                /*
                |--------------------------------------------------------------------------
                | Product Result
                |--------------------------------------------------------------------------
                */

                const result =
                    event.target.closest(
                        '.sales-order-product-result'
                    );


                if (!result) {

                    return;

                }


                this.selectOrderProductFromPicker(
                    result.dataset.itemId,
                    result.dataset.productId
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Close Product Pickers
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            event => {

                if (
                    event.target.closest(
                        '.sales-order-product-combobox'
                    )
                ) {

                    return;

                }


                document
                    .querySelectorAll(
                        '.sales-order-product-combobox.is-open'
                    )
                    .forEach(
                        combobox => {

                            combobox.classList.remove(
                                'is-open'
                            );

                        }
                    );

            }
        );

        /*
        |--------------------------------------------------------------------------
        | Branch Change
        |--------------------------------------------------------------------------
        */

        this.elements.orderBranch?.addEventListener(
            'change',
            () => {

                const branchId =
                    this.elements.orderBranch.value;


                /*
                |--------------------------------------------------------------------------
                | Clear Terminal
                |--------------------------------------------------------------------------
                */

                if (
                    this.elements.orderTerminal
                ) {

                    this.elements.orderTerminal.value =
                        '';

                }


                this.loadTerminals(
                    branchId
                );

            }
        );

        /*
        |--------------------------------------------------------------------------
        | Create Terminal
        |--------------------------------------------------------------------------
        */

        this.elements.createTerminalFromOrderBtn?.addEventListener(
            'click',
            event => {

                event.preventDefault();

                this.openCreateTerminal();

            }
        );

        /*
        |--------------------------------------------------------------------------
        | Create Customer
        |--------------------------------------------------------------------------
        */

        this.elements.createCustomerFromOrderBtn?.addEventListener(
            'click',
            event => {

                event.preventDefault();


                this.openCreateCustomer();

            }
        );

        /*
        |--------------------------------------------------------------------------
        | Quick Terminal Form
        |--------------------------------------------------------------------------
        */

        this.elements.orderTerminalForm?.addEventListener(
            'submit',
            event => {

                event.preventDefault();

                event.stopPropagation();

                this.saveTerminal();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Quick Customer Form
        |--------------------------------------------------------------------------
        */

        this.elements.orderCustomerForm?.addEventListener(
            'submit',
            event => {

                event.preventDefault();

                event.stopPropagation();

                this.saveCustomer();

            }
        );

        /*
        |----------------------------------------------------------------------
        | Order Form
        |----------------------------------------------------------------------
        */

        this.elements.orderForm?.addEventListener(
            'submit',
            event => {

                event.preventDefault();

                this.saveOrder();

            }
        );

        /*
        |--------------------------------------------------------------------------
        | Order Item Events
        |--------------------------------------------------------------------------
        */

        this.elements.orderItems?.addEventListener(
            'change',
            event => {

                if (
                    event.target.matches(
                        '.order-item-product'
                    )
                ) {

                    this.selectOrderProduct(
                        event.target
                    );

                }

            }
        );


        this.elements.orderItems?.addEventListener(
            'input',
            event => {

                if (
                    event.target.matches(
                        '.order-item-quantity'
                    ) ||
                    event.target.matches(
                        '.order-item-price'
                    ) ||
                    event.target.matches(
                        '.order-item-discount'
                    ) ||
                    event.target.matches(
                        '.order-item-tax'
                    )
                ) {

                    this.updateOrderItem(
                        event.target
                    );

                }

            }
        );


        this.elements.orderItems?.addEventListener(
            'click',
            event => {

                const button =
                    event.target.closest(
                        '.order-item-remove'
                    );


                if (!button) {

                    return;

                }


                this.removeOrderItem(
                    button.dataset.itemId
                );

            }
        );


        /*
        |----------------------------------------------------------------------
        | Dynamic Order Actions
        |----------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            event => {

                const button =
                    event.target.closest(
                        '.order-view-btn'
                    );


                if (!button) {

                    return;

                }


                event.preventDefault();


                const id =
                    button.dataset.id;


                if (!id) {

                    return;

                }


                this.openOrderInspector(
                    id
                );

            }
        );


        /*
        |----------------------------------------------------------------------
        | Pagination
        |----------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            event => {

                const button =
                    event.target.closest(
                        '[data-order-page]'
                    );


                if (!button) {

                    return;

                }


                event.preventDefault();


                const page =
                    parseInt(
                        button.dataset.orderPage,
                        10
                    );


                if (!page) {

                    return;

                }


                this.loadOrders(
                    page
                );

            }
        );


        /*
        |----------------------------------------------------------------------
        | Search
        |----------------------------------------------------------------------
        */

        this.bindSearch(
            this.elements.ordersSearch,
            () => {

                this.state.ordersPage =
                    1;

                this.loadOrders(
                    1
                );

            }
        );


        /*
        |----------------------------------------------------------------------
        | Filters
        |----------------------------------------------------------------------
        */

        this.bindFilter(
            this.elements.ordersCustomerFilter,
            () => {

                this.state.ordersPage =
                    1;

                this.loadOrders(
                    1
                );

            }
        );


        this.bindFilter(
            this.elements.ordersBranchFilter,
            () => {

                this.state.ordersPage =
                    1;

                this.loadOrders(
                    1
                );

            }
        );


        this.bindFilter(
            this.elements.ordersStatusFilter,
            () => {

                this.state.ordersPage =
                    1;

                this.loadOrders(
                    1
                );

            }
        );


        this.bindFilter(
            this.elements.ordersPaymentStatusFilter,
            () => {

                this.state.ordersPage =
                    1;

                this.loadOrders(
                    1
                );

            }
        );


        this.bindFilter(
            this.elements.ordersDateFrom,
            () => {

                this.state.ordersPage =
                    1;

                this.loadOrders(
                    1
                );

            }
        );


        this.bindFilter(
            this.elements.ordersDateTo,
            () => {

                this.state.ordersPage =
                    1;

                this.loadOrders(
                    1
                );

            }
        );


        /*
        |----------------------------------------------------------------------
        | Reset Filters
        |----------------------------------------------------------------------
        */

        this.elements.ordersReset?.addEventListener(
            'click',
            () => {

                if (
                    this.elements.ordersSearch
                ) {

                    this.elements.ordersSearch.value =
                        '';

                }


                if (
                    this.elements.ordersCustomerFilter
                ) {

                    this.elements.ordersCustomerFilter.value =
                        '';

                }


                if (
                    this.elements.ordersBranchFilter
                ) {

                    this.elements.ordersBranchFilter.value =
                        '';

                }


                if (
                    this.elements.ordersStatusFilter
                ) {

                    this.elements.ordersStatusFilter.value =
                        '';

                }


                if (
                    this.elements.ordersPaymentStatusFilter
                ) {

                    this.elements.ordersPaymentStatusFilter.value =
                        '';

                }


                if (
                    this.elements.ordersDateFrom
                ) {

                    this.elements.ordersDateFrom.value =
                        '';

                }


                if (
                    this.elements.ordersDateTo
                ) {

                    this.elements.ordersDateTo.value =
                        '';

                }


                this.state.ordersPage =
                    1;


                this.loadOrders(
                    1
                );

            }
        );


        /*
        |----------------------------------------------------------------------
        | Refresh
        |----------------------------------------------------------------------
        */

        this.elements.ordersRefresh?.addEventListener(
            'click',
            () => {

                this.loadOrders(
                    this.state.ordersPage ||
                    1
                );

            }
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Initial Data
    |--------------------------------------------------------------------------
    */

    /*
|--------------------------------------------------------------------------
| Load Initial Data
|--------------------------------------------------------------------------
*/

async loadInitialData()
{

    await Promise.allSettled([

        this.loadCustomers(),

        this.loadCustomerGroups(),

        this.loadBranches(),

        this.loadTerminals(),

        this.loadProducts(),

        this.loadOrders(),

    ]);

},


    /*
|--------------------------------------------------------------------------
| Load Orders
|--------------------------------------------------------------------------
*/

/**
 * Load Sales Orders table.
 */
async loadOrders(
    page = 1
)
{

    if (
        !this.elements.ordersTable
    ) {

        return;

    }


    this.state.ordersPage =
        page;


    const params =
        new URLSearchParams();


    params.set(
        'page',
        page
    );


    this.appendValue(
        params,
        'search',
        this.elements.ordersSearch
    );


    this.appendValue(
        params,
        'customer_id',
        this.elements.ordersCustomerFilter
    );


    this.appendValue(
        params,
        'branch_id',
        this.elements.ordersBranchFilter
    );


    this.appendValue(
        params,
        'order_status',
        this.elements.ordersStatusFilter
    );


    this.appendValue(
        params,
        'payment_status',
        this.elements.ordersPaymentStatusFilter
    );


    this.appendValue(
        params,
        'date_from',
        this.elements.ordersDateFrom
    );


    this.appendValue(
        params,
        'date_to',
        this.elements.ordersDateTo
    );


    this.showTableLoading(
        this.elements.ordersTable
    );


    try {

        const response =
            await fetch(
                `/sales/orders/table?${params.toString()}`,
                {
                    headers: {

                        'Accept':
                            'application/json'

                    }
                }
            );


        const result =
            await response.json();


        if (
            !response.ok ||
            !result.success
        ) {

            throw new Error(
                result.message ??
                'Unable to load sales orders.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Table
        |--------------------------------------------------------------------------
        */

        this.elements.ordersTable.innerHTML =
            result.html ?? '';


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        if (
            this.elements.ordersPagination
        ) {

            this.elements.ordersPagination.innerHTML =
                result.pagination ?? '';

        }


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        this.updateOrderStats(
            result.stats
        );

    }
    catch (error) {

        console.error(
            'Failed to load sales orders:',
            error
        );


        this.showTableError(
            this.elements.ordersTable,
            error.message
        );

    }

},

/*
|--------------------------------------------------------------------------
| Open Order Action Menu
|--------------------------------------------------------------------------
*/

openOrderActionMenu(
    trigger
)
{

    const menu =
        this.elements.salesOrderActionMenu;


    if (
        !menu ||
        !trigger
    ) {

        return;

    }


    const orderId =
        trigger.dataset.orderId;


    const orderStatus =
        trigger.dataset.orderStatus;


    if (!orderId) {

        return;

    }


    this.state.actionOrderId =
        orderId;


    this.state.actionOrderStatus =
        orderStatus;


    const editButton =
        menu.querySelector(
            '[data-order-action="edit"]'
        );


    const completeButton =
        menu.querySelector(
            '[data-order-action="complete"]'
        );


    const deleteButton =
        menu.querySelector(
            '[data-order-action="delete"]'
        );


    const canModify =
        [
            'Draft',
            'Held'
        ].includes(
            orderStatus
        );


    editButton?.classList.toggle(
        'd-none',
        !canModify
    );


    completeButton?.classList.toggle(
        'd-none',
        !canModify
    );


    deleteButton?.classList.toggle(
        'd-none',
        !canModify
    );


    menu.classList.add(
        'is-open'
    );


    menu.setAttribute(
        'aria-hidden',
        'false'
    );


    const rect =
        trigger.getBoundingClientRect();


    const menuWidth =
        menu.offsetWidth;


    const menuHeight =
        menu.offsetHeight;


    let left =
        rect.right -
        menuWidth;


    let top =
        rect.bottom +
        5;


    if (
        left < 8
    ) {

        left = 8;

    }


    if (
        left +
        menuWidth >
        window.innerWidth -
        8
    ) {

        left =
            window.innerWidth -
            menuWidth -
            8;

    }


    if (
        top +
        menuHeight >
        window.innerHeight -
        8
    ) {

        top =
            rect.top -
            menuHeight -
            5;

    }


    if (
        top < 8
    ) {

        top = 8;

    }


    menu.style.left =
        `${left}px`;


    menu.style.top =
        `${top}px`;

},

/*
|--------------------------------------------------------------------------
| Open Complete Order Modal
|--------------------------------------------------------------------------
*/

/**
 * Open the Complete Order modal.
 */
async openCompleteOrder(
    id
)
{

    if (!id) {

        return;

    }


    const modal =
        this.elements.completeOrderModal;


    if (!modal) {

        console.error(
            'Complete Order modal not found.'
        );

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Reset Form
    |--------------------------------------------------------------------------
    */

    this.elements.completeOrderForm?.reset();


    /*
    |--------------------------------------------------------------------------
    | Reset Payment Preview
    |--------------------------------------------------------------------------
    */

    this.setText(
        'completeOrderAmountDue',
        '0.00'
    );


    this.setText(
        'completeOrderPreviewDue',
        '0.00'
    );


    this.setText(
        'completeOrderPreviewPaid',
        '0.00'
    );


    this.setText(
        'completeOrderPreviewBalance',
        '0.00'
    );


    this.setText(
        'completeOrderPreviewChange',
        '0.00'
    );


    this.elements.completeOrderWarning
        ?.classList.add(
            'd-none'
        );


    /*
    |--------------------------------------------------------------------------
    | Store Order ID
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.completeOrderId
    ) {

        this.elements.completeOrderId.value =
            id;

    }


    /*
    |--------------------------------------------------------------------------
    | Loading State
    |--------------------------------------------------------------------------
    */

    this.setCompleteOrderLoading(
        true
    );


    /*
    |--------------------------------------------------------------------------
    | Show Modal
    |--------------------------------------------------------------------------
    */

    this.completeOrderModalInstance?.show();


    try {

        const response =
            await fetch(
                `/sales/orders/${id}/details`,
                {

                    headers: {

                        'Accept':
                            'application/json',

                        'X-Requested-With':
                            'XMLHttpRequest'

                    }

                }
            );


        const result =
            await response.json();


        if (
            !response.ok ||
            !result.success
        ) {

            throw new Error(
                result.message ??
                'Unable to load sales order.'
            );

        }


        const order =
            result.data;


        /*
        |--------------------------------------------------------------------------
        | Status Check
        |--------------------------------------------------------------------------
        */

        if (
            ![
                'Draft',
                'Held'
            ].includes(
                order.order_status
            )
        ) {

            this.completeOrderModalInstance?.hide();


            this.notify(
                'This sales order cannot be completed.',
                'warning'
            );


            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Populate
        |--------------------------------------------------------------------------
        */

        this.setText(
            'completeOrderNumber',
            order.order_no ??
            '—'
        );


        this.setText(
            'completeOrderCustomer',
            order.customer?.name ??
            'Walk-in Customer'
        );


        this.setText(
            'completeOrderItems',
            order.total_items ??
            0
        );


        this.setText(
            'completeOrderGrandTotal',
            this.formatMoney(
                order.grand_total ??
                order.total ??
                0
            )
        );


       if (
            this.elements.completeOrderAmountDue
        ) {

            this.elements.completeOrderAmountDue.value =
                this.formatMoney(
                    order.grand_total ??
                    order.total ??
                    0
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Store Amount Due
        |--------------------------------------------------------------------------
        */

        this.state.completeOrderAmountDue =
            parseFloat(
                order.grand_total ??
                order.total ??
                0
            ) || 0;


        /*
        |--------------------------------------------------------------------------
        | Default Amount Paid
        |--------------------------------------------------------------------------
        */

        if (
            this.elements.completeOrderAmountPaid
        ) {

            this.elements.completeOrderAmountPaid.value =
                '0';

        }


        /*
        |--------------------------------------------------------------------------
        | Payment Preview
        |--------------------------------------------------------------------------
        */

        this.updateCompleteOrderPaymentPreview();


    }
    catch (error) {

        console.error(
            'Complete Order loading error:',
            error
        );


        this.completeOrderModalInstance?.hide();


        this.notify(
            error.message ??
            'Unable to load the sales order.',
            'error'
        );

    }
    finally {

        this.setCompleteOrderLoading(
            false
        );

    }

},

/*
|--------------------------------------------------------------------------
| Complete Order Loading
|--------------------------------------------------------------------------
*/

/**
 * Toggle Complete Order loading state.
 */
setCompleteOrderLoading(
    loading
)
{

    const button =
        this.elements.completeOrderSubmitBtn;


    const text =
        this.elements.completeOrderSubmitText;


    const spinner =
        this.elements.completeOrderSubmitSpinner;


    if (button) {

        button.disabled =
            loading;

    }


    text?.classList.toggle(
        'd-none',
        loading
    );


    spinner?.classList.toggle(
        'd-none',
        !loading
    );

},

/*
|--------------------------------------------------------------------------
| Update Complete Order Payment Preview
|--------------------------------------------------------------------------
*/

/**
 * Update payment balance and change preview.
 */
updateCompleteOrderPaymentPreview()
{

    const amountDue =
        parseFloat(
            this.state.completeOrderAmountDue
        ) || 0;


    const amountPaid =
        parseFloat(
            this.elements.completeOrderAmountPaid?.value
        ) || 0;


    const balance =
        Math.max(
            amountDue -
            amountPaid,
            0
        );


    const change =
        Math.max(
            amountPaid -
            amountDue,
            0
        );


    this.setText(
        'completeOrderPreviewDue',
        this.formatMoney(
            amountDue
        )
    );


    this.setText(
        'completeOrderPreviewPaid',
        this.formatMoney(
            amountPaid
        )
    );


    this.setText(
        'completeOrderPreviewBalance',
        this.formatMoney(
            balance
        )
    );


    this.setText(
        'completeOrderPreviewChange',
        this.formatMoney(
            change
        )
    );

},
/*
|--------------------------------------------------------------------------
| Close Order Action Menu
|--------------------------------------------------------------------------
*/

closeOrderActionMenu()
{

    const menu =
        this.elements.salesOrderActionMenu;


    if (!menu) {

        return;

    }


    menu.classList.remove(
        'is-open'
    );


    menu.setAttribute(
        'aria-hidden',
        'true'
    );


    menu.innerHTML =
        '';

},

/*
|--------------------------------------------------------------------------
| Open Create Order
|--------------------------------------------------------------------------
*/

/**
 * Open the Sales Order modal for a new order.
 */
openCreateOrder()
{

    this.state.mode =
        'create';

    this.state.orderPayment = {

        amountPaid:
            0,

    };


    this.state.editingOrderId =
        null;


    this.state.orderItems =
        [];


    /*
    |--------------------------------------------------------------------------
    | Reset Form
    |--------------------------------------------------------------------------
    */

    this.elements.orderForm?.reset();


    /*
    |--------------------------------------------------------------------------
    | Reset Hidden ID
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.orderId
    ) {

        this.elements.orderId.value =
            '';

    }


    /*
    |--------------------------------------------------------------------------
    | Default Sales Channel
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.orderSalesChannel
    ) {

        this.elements.orderSalesChannel.value =
            'POS';

    }


    /*
    |--------------------------------------------------------------------------
    | Reset Items
    |--------------------------------------------------------------------------
    */

    this.renderOrderItems();


    /*
    |--------------------------------------------------------------------------
    | Reset Totals
    |--------------------------------------------------------------------------
    */

    this.updateOrderTotals();


    /*
    |--------------------------------------------------------------------------
    | Modal Title
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.orderModalLabel
    ) {

        this.elements.orderModalLabel.textContent =
            'Create Sales Order';

    }


    if (
        this.elements.orderModalDescription
    ) {

        this.elements.orderModalDescription.textContent =
            'Create a new customer sales order.';

    }


    if (
        this.elements.orderSubmitText
    ) {

        this.elements.orderSubmitText.textContent =
            'Create Order';

    }


    /*
    |--------------------------------------------------------------------------
    | Show Modal
    |--------------------------------------------------------------------------
    */

    this.orderModalInstance?.show();

},

/*
|--------------------------------------------------------------------------
| Open Order Inspector
|--------------------------------------------------------------------------
*/

/**
 * Open the Sales Order inspector.
 */
async openInspector(
    id
)
{

    if (!id) {

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Inspector Instance
    |--------------------------------------------------------------------------
    */

    if (
        !this.orderInspectorInstance
    ) {

        console.error(
            'Sales Order inspector instance not initialized.'
        );

        return;

    }


  /*
|--------------------------------------------------------------------------
| Show Inspector
|--------------------------------------------------------------------------
*/

this.orderInspectorInstance.show();


    try {

        const response =
            await fetch(
                `/sales/orders/${id}/details`,
                {

                    method:
                        'GET',

                    headers: {

                        'Accept':
                            'application/json',

                        'X-Requested-With':
                            'XMLHttpRequest'

                    }

                }
            );


        const result =
            await response.json();


        if (
            !response.ok ||
            !result.success
        ) {

            throw new Error(
                result.message ??
                'Unable to load sales order.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Populate
        |--------------------------------------------------------------------------
        */

        this.populateOrderInspector(
            result.data
        );

    }
    catch (error) {

        console.error(
            'Sales Order Inspector Error:',
            error
        );


        this.notify(
            error.message ??
            'Unable to load sales order.',
            'error'
        );

    }

},

/*
|--------------------------------------------------------------------------
| Populate Order Inspector
|--------------------------------------------------------------------------
*/

/**
 * Populate the Sales Order inspector.
 */
populateOrderInspector(
    order
)
{

    if (!order) {

        return;

    }


    this.setInspectorText(
        'inspectorOrderNumber',
        order.order_no ?? '—'
    );


    this.setInspectorText(
        'inspectorOrderCustomer',
        order.customer?.name ??
        'Walk-in Customer'
    );


    this.setInspectorText(
        'inspectorOrderBranch',
        order.branch?.name ??
        '—'
    );


    this.setInspectorText(
        'inspectorOrderTerminal',
        order.terminal?.name ??
        '—'
    );


    this.setInspectorText(
        'inspectorOrderCashier',
        order.cashier?.name ??
        '—'
    );


    this.setInspectorText(
        'inspectorOrderSalesChannel',
        order.sales_channel ??
        '—'
    );


    this.setInspectorText(
        'inspectorOrderStatus',
        order.order_status ??
        '—'
    );


    this.setInspectorText(
        'inspectorOrderPaymentStatus',
        order.payment_status ??
        '—'
    );


    this.setInspectorText(
        'inspectorOrderTotalItems',
        order.total_items ??
        0
    );


    this.setInspectorText(
        'inspectorOrderTotalQuantity',
        order.total_quantity ??
        0
    );


    this.setInspectorText(
        'inspectorOrderSubtotal',
        this.formatMoney(
            order.subtotal ?? 0
        )
    );


    this.setInspectorText(
        'inspectorOrderDiscount',
        this.formatMoney(
            order.discount ?? 0
        )
    );


    this.setInspectorText(
        'inspectorOrderTax',
        this.formatMoney(
            order.tax ?? 0
        )
    );


    this.setInspectorText(
        'inspectorOrderTotal',
        this.formatMoney(
            order.grand_total ??
            order.total ??
            0
        )
    );


    this.setInspectorText(
        'inspectorOrderPaid',
        this.formatMoney(
            order.amount_paid ?? 0
        )
    );


    this.setInspectorText(
        'inspectorOrderBalance',
        this.formatMoney(
            order.balance ?? 0
        )
    );


    this.setInspectorText(
        'inspectorOrderChange',
        this.formatMoney(
            order.change_given ?? 0
        )
    );


    this.setInspectorText(
        'inspectorOrderRemarks',
        order.remarks ??
        '—'
    );


    this.populateOrderInspectorItems(
        order.items ?? []
    );

},

/*
|--------------------------------------------------------------------------
| Populate Order Inspector Items
|--------------------------------------------------------------------------
*/

/**
 * Populate order items in the Sales Order inspector.
 */
populateOrderInspectorItems(
    items = []
)
{

    const container =
        this.elements.inspectorOrderItems;


    if (!container) {

        return;

    }


    if (
        !items ||
        !items.length
    ) {

        container.innerHTML = `

            <div class="text-center text-muted py-4">

                <i class="bi bi-box-seam d-block mb-2"></i>

                <div class="small">
                    No items found for this order.
                </div>

            </div>

        `;

        return;

    }


    container.innerHTML =
        items
            .map(
                item => {

                    const quantity =
                        parseFloat(
                            item.quantity
                        ) || 0;


                    const unitPrice =
                        parseFloat(
                            item.unit_price
                        ) || 0;


                    const total =
                        parseFloat(
                            item.total
                        ) || 0;


                    return `

                        <div class="sales-order-inspector-item">

                            <div class="sales-order-inspector-item-main">

                                <div class="sales-order-inspector-item-name">

                                    ${this.escapeHtml(
                                        item.product_name ??
                                        'Unknown Product'
                                    )}

                                </div>


                                ${
                                    item.product_barcode
                                        ? `
                                            <div class="sales-order-inspector-item-meta">

                                                ${this.escapeHtml(
                                                    item.product_barcode
                                                )}

                                            </div>
                                        `
                                        : ''
                                }

                            </div>


                            <div class="sales-order-inspector-item-qty">

                                ${quantity}

                                ×

                                ${this.formatMoney(
                                    unitPrice
                                )}

                            </div>


                            <div class="sales-order-inspector-item-total">

                                ${this.formatMoney(
                                    total
                                )}

                            </div>

                        </div>

                    `;

                }
            )
            .join('');

},

/*
|--------------------------------------------------------------------------
| Inspector Text
|--------------------------------------------------------------------------
*/

/**
 * Set text inside an inspector element.
 */
setInspectorText(
    id,
    value
)
{

    const element =
        document.getElementById(
            id
        );


    if (!element) {

        return;

    }


    element.textContent =
        value ?? '—';

},

/*
|--------------------------------------------------------------------------
| Open Edit Order
|--------------------------------------------------------------------------
*/

/**
 * Open an existing Draft/Held order for editing.
 */
async openEditOrder(
    id
)
{

    if (!id) {

        return;

    }


    try {

        /*
    |--------------------------------------------------------------------------
    | Save Request
    |--------------------------------------------------------------------------
    */

    const isEdit =
        this.state.mode === 'edit' &&
        this.state.editingOrderId;


    const url =
        isEdit
            ? `/sales/orders/${this.state.editingOrderId}`
            : '/sales/orders';


    const method =
        isEdit
            ? 'PUT'
            : 'POST';


    const response =
        await fetch(
            url,
            {

                method,

                headers: {

                    'Accept':
                        'application/json',

                    'X-Requested-With':
                        'XMLHttpRequest',

                    'X-CSRF-TOKEN':
                        document
                            .querySelector(
                                'meta[name="csrf-token"]'
                            )
                            ?.getAttribute(
                                'content'
                            )

                },

                body:
                    formData

            }
        );


        const result =
            await response.json();


        if (
            !response.ok ||
            !result.success
        ) {

            throw new Error(
                result.message ??
                'Unable to load sales order.'
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        this.notify(
            result.message ??
            (
                isEdit
                    ? 'Sales order updated successfully.'
                    : 'Sales order created successfully.'
            ),
            'success'
        );


        this.orderModalInstance?.hide();


        this.state.orderItems =
            [];


        this.state.editingOrderId =
            null;


        this.state.mode =
            'create';


        await this.loadOrders(
            this.state.ordersPage ||
            1
        );


        const order =
            result.data;


        /*
        |--------------------------------------------------------------------------
        | Status Protection
        |--------------------------------------------------------------------------
        */

        if (
            ![
                'Draft',
                'Held'
            ].includes(
                order.order_status
            )
        ) {

            this.notify(
                'This sales order can no longer be edited.',
                'warning'
            );

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Edit State
        |--------------------------------------------------------------------------
        */

        this.state.mode =
            'edit';


        this.state.editingOrderId =
            order.id;


        /*
        |--------------------------------------------------------------------------
        | Header Fields
        |--------------------------------------------------------------------------
        */

        if (
            this.elements.orderCustomer
        ) {

            this.elements.orderCustomer.value =
                order.customer?.id ??
                '';

        }


        if (
            this.elements.orderBranch
        ) {

            this.elements.orderBranch.value =
                order.branch?.id ??
                '';

        }


        /*
        |--------------------------------------------------------------------------
        | Load Branch Terminals
        |--------------------------------------------------------------------------
        */

        await this.loadTerminals(
            order.branch?.id ??
            null
        );


        if (
            this.elements.orderTerminal
        ) {

            this.elements.orderTerminal.value =
                order.terminal?.id ??
                '';

        }


        if (
            this.elements.orderSalesChannel
        ) {

            this.elements.orderSalesChannel.value =
                order.sales_channel ??
                'POS';

        }


        if (
            this.elements.orderRemarks
        ) {

            this.elements.orderRemarks.value =
                order.remarks ??
                '';

        }


        /*
        |--------------------------------------------------------------------------
        | Order Items
        |--------------------------------------------------------------------------
        */

        this.state.orderItems =
            (
                order.items ??
                []
            )
                .map(
                    item => ({

                        id:
                            item.id ??
                            this.generateOrderItemId(),

                        product_id:
                            item.product_id,

                        product_name:
                            item.product_name,

                        product_code:
                            item.product_code ??
                            '',

                        product_barcode:
                            item.product_barcode ??
                            '',

                        quantity:
                            parseFloat(
                                item.quantity
                            ) || 0,

                        unit_price:
                            parseFloat(
                                item.unit_price
                            ) || 0,

                        discount_amount:
                            parseFloat(
                                item.discount ??
                                item.discount_amount
                            ) || 0,

                        tax_amount:
                            parseFloat(
                                item.tax ??
                                item.tax_amount
                            ) || 0,

                        line_total:
                            parseFloat(
                                item.total ??
                                item.line_total
                            ) || 0

                    })
                );


        /*
        |--------------------------------------------------------------------------
        | Render
        |--------------------------------------------------------------------------
        */

        this.renderOrderItems();


        this.updateOrderTotals();


        /*
        |--------------------------------------------------------------------------
        | Update Modal Title
        |--------------------------------------------------------------------------
        */

        if (
            this.elements.orderModalTitle
        ) {

            this.elements.orderModalTitle.textContent =
                'Edit Sales Order';

        }


        /*
        |--------------------------------------------------------------------------
        | Show Modal
        |--------------------------------------------------------------------------
        */

        this.orderModalInstance?.show();

    }
    catch (error) {

        console.error(
            'Sales Order edit error:',
            error
        );


        this.notify(
            error.message ??
            'Unable to load sales order.',
            'error'
        );

    }

},

/*
|--------------------------------------------------------------------------
| Confirm Delete Order
|--------------------------------------------------------------------------
*/

/**
 * Open the delete confirmation for a Sales Order.
 */
confirmDeleteOrder(
    id
)
{

    if (!id) {

        return;

    }


    this.state.confirmationAction =
        'delete';


    this.state.confirmationType =
        'order';


    this.state.globalActionId =
        id;


    /*
    |--------------------------------------------------------------------------
    | Confirmation Modal
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.confirmationModal
    ) {

        this.elements.confirmationModalInstance?.show();

    }

},

/*
|--------------------------------------------------------------------------
| Delete Order
|--------------------------------------------------------------------------
*/

/**
 * Delete a Draft/Held Sales Order.
 */
async deleteOrder(
    id
)
{

    if (!id) {

        return;

    }


    try {

        const response =
            await fetch(
                `/sales/orders/${id}`,
                {

                    method:
                        'DELETE',

                    headers: {

                        'Accept':
                            'application/json',

                        'X-Requested-With':
                            'XMLHttpRequest',

                        'X-CSRF-TOKEN':
                            document
                                .querySelector(
                                    'meta[name="csrf-token"]'
                                )
                                ?.getAttribute(
                                    'content'
                                )

                    }

                }
            );


        const result =
            await response.json();


        if (
            response.status === 422
        ) {

            this.notify(
                result.message ??
                'This sales order cannot be deleted.',
                'warning'
            );

            return;

        }


        if (
            !response.ok ||
            !result.success
        ) {

            throw new Error(
                result.message ??
                'Unable to delete sales order.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Close Confirmation
        |--------------------------------------------------------------------------
        */

        this.confirmationModalInstance?.hide();


        /*
        |--------------------------------------------------------------------------
        | Refresh Table
        |--------------------------------------------------------------------------
        */

        await this.loadOrders(
            this.state.ordersPage ||
            1
        );


        this.notify(
            result.message ??
            'Sales order deleted successfully.',
            'success'
        );

    }
    catch (error) {

        console.error(
            'Sales Order delete error:',
            error
        );


        this.notify(
            error.message ??
            'Unable to delete sales order.',
            'error'
        );

    }

},

/*
|--------------------------------------------------------------------------
| Generate Order Item ID
|--------------------------------------------------------------------------
*/

generateOrderItemId()
{

    return `
        new-${Date.now()}-
        ${Math.random()
            .toString(36)
            .slice(2, 8)}
    `.replace(
        /\s+/g,
        ''
    );

},


/*
|--------------------------------------------------------------------------
| Open Quick Terminal Modal
|--------------------------------------------------------------------------
*/

/**
 * Open terminal creation modal for the selected branch.
 */
openCreateTerminal()
{

    const branchId =
        this.elements.orderBranch?.value ??
        '';


    if (!branchId) {

        this.notify(
            'Select a branch before creating a terminal.',
            'warning'
        );

        return;

    }


    const branch =
        this.elements.orderBranch
            ?.selectedOptions?.[0];


    /*
    |--------------------------------------------------------------------------
    | Reset Form
    |--------------------------------------------------------------------------
    */

    this.elements.orderTerminalForm?.reset();


    /*
    |--------------------------------------------------------------------------
    | Set Branch
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.orderTerminalBranchId
    ) {

        this.elements.orderTerminalBranchId.value =
            branchId;

    }


    if (
        this.elements.orderTerminalBranchName
    ) {

        this.elements.orderTerminalBranchName.value =
            branch?.textContent?.trim() ??
            '';

    }


    this.orderTerminalModalInstance?.show();

},

/*
|--------------------------------------------------------------------------
| Open Quick Customer Modal
|--------------------------------------------------------------------------
*/

/**
 * Open customer creation modal.
 */
openCreateCustomer()
{

    this.elements.orderCustomerForm?.reset();


    if (
        this.elements.orderCustomerType
    ) {

        this.elements.orderCustomerType.value =
            'Retail';

    }


    if (
        this.elements.orderCustomerCreditLimit
    ) {

        this.elements.orderCustomerCreditLimit.value =
            '0';

    }


    this.orderCustomerModalInstance?.show();

},

/*
|--------------------------------------------------------------------------
| Add Order Item
|--------------------------------------------------------------------------
*/

/**
 * Add a product to the Sales Order.
 */
addOrderItem()
{

    if (
        !this.state.products ||
        !this.state.products.length
    ) {

        this.notify(
            'No products are available.',
            'warning'
        );

        return;

    }


    this.state.orderItems.push({

        id:
            this.generateItemId(),

        product_id:
            '',

        product_name:
            '',

        product_code:
            '',

        quantity:
            1,

        unit_price:
            0,

        discount_amount:
            0,

        tax_amount:
            0,

        line_total:
            0,

    });


    this.renderOrderItems();


    this.updateOrderTotals();

},

/*
|--------------------------------------------------------------------------
| Generate Item ID
|--------------------------------------------------------------------------
*/

generateItemId()
{

    return (
        'item_' +
        Date.now() +
        '_' +
        Math.random()
            .toString(36)
            .substring(
                2,
                8
            )
    );

},

/*
|--------------------------------------------------------------------------
| Render Order Items
|--------------------------------------------------------------------------
*/

/**
 * Render Sales Order item rows.
 */
renderOrderItems()
{

    const container =
        this.elements.orderItems;


    if (!container) {

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Empty State
    |--------------------------------------------------------------------------
    */

    if (
        !this.state.orderItems.length
    ) {

        container.innerHTML = `

            <tr id="orderEmptyItems">

                <td
                    colspan="7"
                    class="text-center text-muted py-5"
                >

                    <i
                        class="bi bi-box-seam fs-4 d-block mb-2"
                    ></i>

                    No products selected.

                </td>

            </tr>

        `;

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Rows
    |--------------------------------------------------------------------------
    */

    container.innerHTML =
        this.state.orderItems
            .map(
                (item, index) => {

                    return `

                        <tr
                            data-order-item-id="${item.id}"
                        >

                            <td>

                                <div
                                    class="sales-order-product-combobox"
                                    data-item-id="${item.id}"
                                >

                                    <div class="sales-order-product-input-wrap">

                                        <i class="bi bi-search"></i>

                                        <input
                                            type="text"
                                            class="form-control form-control-sm sales-order-product-input"
                                            data-item-id="${item.id}"
                                            value="${
                                                item.product_id
                                                    ? this.escapeHtml(
                                                        item.product_code
                                                            ? `${item.product_code} — ${item.product_name}`
                                                            : item.product_name
                                                    )
                                                    : ''
                                            }"
                                            placeholder="Search product..."
                                            autocomplete="off"
                                        >

                                        <i class="bi bi-chevron-down sales-order-product-chevron"></i>

                                    </div>


                                    <div
                                        class="sales-order-product-results"
                                        data-item-id="${item.id}"
                                    >

                                        <div class="sales-order-product-result-empty">

                                            <i class="bi bi-search"></i>

                                            <span>
                                                Type to search products
                                            </span>

                                        </div>

                                    </div>


                                    <div
                                        class="small text-muted mt-1 order-item-code"
                                        data-item-id="${item.id}"
                                    >

                                        ${this.escapeHtml(
                                            item.product_code ?? ''
                                        )}

                                    </div>

                                </div>

                            </td>


                            <td>

                                <input
                                    type="number"
                                    class="form-control form-control-sm text-end order-item-quantity"
                                    data-item-id="${item.id}"
                                    value="${item.quantity}"
                                    min="0.01"
                                    step="0.01"
                                >

                            </td>


                            <td>

                                <input
                                    type="number"
                                    class="form-control form-control-sm text-end order-item-price"
                                    data-item-id="${item.id}"
                                    value="${item.unit_price}"
                                    min="0"
                                    step="0.01"
                                >

                            </td>


                            <td>

                                <input
                                    type="number"
                                    class="form-control form-control-sm text-end order-item-discount"
                                    data-item-id="${item.id}"
                                    value="${item.discount_amount}"
                                    min="0"
                                    step="0.01"
                                >

                            </td>


                            <td>

                                <input
                                    type="number"
                                    class="form-control form-control-sm text-end order-item-tax"
                                    data-item-id="${item.id}"
                                    value="${item.tax_amount}"
                                    min="0"
                                    step="0.01"
                                >

                            </td>


                            <td class="text-end">

                                <span
                                    class="fw-semibold order-item-total"
                                    data-item-id="${item.id}"
                                >
                                    ${this.formatMoney(
                                        item.line_total
                                    )}
                                </span>

                            </td>


                            <td class="text-end">

                                <button
                                    type="button"
                                    class="btn btn-light btn-sm text-danger order-item-remove"
                                    data-item-id="${item.id}"
                                    title="Remove"
                                >

                                    <i class="bi bi-trash"></i>

                                </button>

                            </td>

                        </tr>

                    `;

                }
            )
            .join('');

},

/*
|--------------------------------------------------------------------------
| Search Order Products
|--------------------------------------------------------------------------
*/

/**
 * Search products from the Order product field.
 */
searchOrderProducts(
    itemId,
    searchTerm
)
{

    const combobox =
        this.elements.orderItems.querySelector(
            `.sales-order-product-combobox[data-item-id="${itemId}"]`
        );


    if (!combobox) {

        return;

    }


    const results =
        combobox.querySelector(
            '.sales-order-product-results'
        );


    if (!results) {

        return;

    }


    const term =
        String(
            searchTerm ?? ''
        )
            .trim()
            .toLowerCase();


    /*
    |--------------------------------------------------------------------------
    | No Search
    |--------------------------------------------------------------------------
    */

    if (!term) {

        results.innerHTML = `

            <div class="sales-order-product-result-empty">

                <i class="bi bi-search"></i>

                <span>
                    Type to search products
                </span>

            </div>

        `;

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    const matches =
        this.state.products
            .filter(
                product => {

                    const name =
                        String(
                            product.name ?? ''
                        )
                            .toLowerCase();


                    const code =
                        String(
                            product.product_code ?? ''
                        )
                            .toLowerCase();


                    const sku =
                        String(
                            product.sku ?? ''
                        )
                            .toLowerCase();


                    return (
                        name.includes(term) ||
                        code.includes(term) ||
                        sku.includes(term)
                    );

                }
            )
            .slice(
                0,
                20
            );


    /*
    |--------------------------------------------------------------------------
    | No Results
    |--------------------------------------------------------------------------
    */

    if (!matches.length) {

        results.innerHTML = `

            <div class="sales-order-product-result-empty">

                <i class="bi bi-search"></i>

                <span>
                    No products found
                </span>

            </div>

        `;

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Results
    |--------------------------------------------------------------------------
    */

    results.innerHTML =
        matches
            .map(
                product => {

                    const code =
                        product.product_code ??
                        product.sku ??
                        '';


                    return `

                        <button
                            type="button"
                            class="sales-order-product-result"
                            data-item-id="${itemId}"
                            data-product-id="${product.id}"
                        >

                            <span class="sales-order-product-result-info">

                                <span class="sales-order-product-result-name">

                                    ${this.escapeHtml(
                                        product.name
                                    )}

                                </span>


                                ${
                                    code
                                        ? `
                                            <span class="sales-order-product-result-code">
                                                ${this.escapeHtml(
                                                    code
                                                )}
                                            </span>
                                        `
                                        : ''
                                }

                            </span>


                            <span class="sales-order-product-result-price">

                                ${this.formatMoney(
                                    product.selling_price ?? 0
                                )}

                            </span>

                        </button>

                    `;

                }
            )
            .join('');

},

/*
|--------------------------------------------------------------------------
| Select Order Product
|--------------------------------------------------------------------------
*/

/**
 * Select a product from the searchable Order product field.
 */
selectOrderProductFromPicker(
    itemId,
    productId
)
{

    const item =
        this.state.orderItems.find(
            row =>
                row.id === itemId
        );


    if (!item) {

        return;

    }


    const product =
        this.state.products.find(
            row =>
                String(
                    row.id
                ) ===
                String(
                    productId
                )
        );


    if (!product) {

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Product
    |--------------------------------------------------------------------------
    */

    item.product_id =
        product.id;


    item.product_name =
        product.name;


    item.product_code =
        product.product_code ??
        product.sku ??
        '';


    /*
    |--------------------------------------------------------------------------
    | Selling Price
    |--------------------------------------------------------------------------
    */

    item.unit_price =
        parseFloat(
            product.selling_price
        ) || 0;


    /*
    |--------------------------------------------------------------------------
    | Preserve Existing Values
    |--------------------------------------------------------------------------
    */

    item.quantity =
        parseFloat(
            item.quantity
        ) || 1;


    item.discount_amount =
        parseFloat(
            item.discount_amount
        ) || 0;


    item.tax_amount =
        parseFloat(
            item.tax_amount
        ) || 0;


    /*
    |--------------------------------------------------------------------------
    | Calculate Line Total
    |--------------------------------------------------------------------------
    */

    item.line_total =
        Math.max(

            (
                item.quantity *
                item.unit_price
            )
            -
            item.discount_amount
            +
            item.tax_amount,

            0

        );


    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    this.renderOrderItems();


    this.updateOrderTotals();

},
/*
|--------------------------------------------------------------------------
| Select Order Product
|--------------------------------------------------------------------------
*/

/**
 * Populate an order item from the selected product.
 */
selectOrderProduct(
    select
)
{

    const itemId =
        select.dataset.itemId;


    const item =
        this.state.orderItems.find(
            row =>
                row.id === itemId
        );


    if (!item) {

        return;

    }


    const product =
        this.state.products.find(
            row =>
                String(row.id) ===
                String(select.value)
        );


    if (!product) {

        item.product_id =
            '';

        item.product_name =
            '';

        item.product_code =
            '';

        item.unit_price =
            0;

        this.renderOrderItems();

        this.updateOrderTotals();

        return;

    }


    item.product_id =
        product.id;


    item.product_name =
        product.name;


    item.product_code =
        product.product_code ??
        '';


    /*
    |--------------------------------------------------------------------------
    | Selling Price
    |--------------------------------------------------------------------------
    |
    | This expects products() to eventually return selling_price.
    |
    */

    item.unit_price =
        parseFloat(
            product.selling_price ??
            0
        ) || 0;


    item.discount_amount =
        0;


    item.tax_amount =
        0;


    this.renderOrderItems();


    this.updateOrderTotals();

},

/*
|--------------------------------------------------------------------------
| Update Order Item
|--------------------------------------------------------------------------
*/

/**
 * Update quantity, price, discount, or tax for an order item.
 */
updateOrderItem(
    input
)
{

    const itemId =
        input.dataset.itemId;


    const item =
        this.state.orderItems.find(
            row =>
                row.id === itemId
        );


    if (!item) {

        return;

    }


    if (
        input.classList.contains(
            'order-item-quantity'
        )
    ) {

        item.quantity =
            Math.max(
                parseFloat(
                    input.value
                ) || 0,
                0
            );

    }


    if (
        input.classList.contains(
            'order-item-price'
        )
    ) {

        item.unit_price =
            Math.max(
                parseFloat(
                    input.value
                ) || 0,
                0
            );

    }


    if (
        input.classList.contains(
            'order-item-discount'
        )
    ) {

        item.discount_amount =
            Math.max(
                parseFloat(
                    input.value
                ) || 0,
                0
            );

    }


    if (
        input.classList.contains(
            'order-item-tax'
        )
    ) {

        item.tax_amount =
            Math.max(
                parseFloat(
                    input.value
                ) || 0,
                0
            );

    }


    /*
    |--------------------------------------------------------------------------
    | Calculate Line Total
    |--------------------------------------------------------------------------
    */

    const gross =
        item.quantity *
        item.unit_price;


    item.line_total =
        Math.max(
            gross -
            item.discount_amount +
            item.tax_amount,
            0
        );


    const totalElement =
        this.elements.orderItems.querySelector(
            `.order-item-total[data-item-id="${itemId}"]`
        );


    if (totalElement) {

        totalElement.textContent =
            this.formatMoney(
                item.line_total
            );

    }


    this.updateOrderTotals();

},

/*
|--------------------------------------------------------------------------
| Remove Order Item
|--------------------------------------------------------------------------
*/

/**
 * Remove an item from the Sales Order.
 */
removeOrderItem(
    itemId
)
{

    this.state.orderItems =
        this.state.orderItems.filter(
            item =>
                item.id !== itemId
        );


    this.renderOrderItems();


    this.updateOrderTotals();

},

/*
|--------------------------------------------------------------------------
| Update Order Totals
|--------------------------------------------------------------------------
*/

/**
 * Calculate and display Sales Order totals.
 */
updateOrderTotals()
{

    let subtotal =
        0;

    let discount =
        0;

    let tax =
        0;

    let totalQuantity =
        0;


    /*
    |--------------------------------------------------------------------------
    | Calculate Lines
    |--------------------------------------------------------------------------
    */

    this.state.orderItems.forEach(
        item => {

            subtotal +=
                (
                    (parseFloat(
                        item.quantity
                    ) || 0) *
                    (parseFloat(
                        item.unit_price
                    ) || 0)
                );


            discount +=
                parseFloat(
                    item.discount_amount
                ) || 0;


            tax +=
                parseFloat(
                    item.tax_amount
                ) || 0;


            totalQuantity +=
                parseFloat(
                    item.quantity
                ) || 0;

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Grand Total
    |--------------------------------------------------------------------------
    */

    const grandTotal =
        Math.max(
            subtotal -
            discount +
            tax,
            0
        );


    /*
    |--------------------------------------------------------------------------
    | Payment
    |--------------------------------------------------------------------------
    */

    const amountPaid =
        parseFloat(
            this.state.orderPayment?.amountPaid ??
            0
        ) || 0;


    const balance =
        Math.max(
            grandTotal -
            amountPaid,
            0
        );


    const change =
        Math.max(
            amountPaid -
            grandTotal,
            0
        );


    /*
    |--------------------------------------------------------------------------
    | Store Totals
    |--------------------------------------------------------------------------
    */

    this.state.orderTotals = {

        subtotal,

        discount,

        tax,

        total:
            grandTotal,

        grandTotal,

        amountPaid,

        balance,

        change,

        totalItems:
            this.state.orderItems.length,

        totalQuantity,

    };


    /*
    |--------------------------------------------------------------------------
    | Display
    |--------------------------------------------------------------------------
    */

    this.setText(
        'orderSubtotal',
        this.formatMoney(
            subtotal
        )
    );


    this.setText(
        'orderDiscount',
        this.formatMoney(
            discount
        )
    );


    this.setText(
        'orderTax',
        this.formatMoney(
            tax
        )
    );


    this.setText(
        'orderTotal',
        this.formatMoney(
            grandTotal
        )
    );


    this.setText(
        'orderAmountPaid',
        this.formatMoney(
            amountPaid
        )
    );


    this.setText(
    'orderBalance',
    this.formatMoney(
        balance
    )
);


this.setText(
    'orderChange',
    this.formatMoney(
        change
    )
);

},


/*
|--------------------------------------------------------------------------
| Update Order Stats
|--------------------------------------------------------------------------
*/

/**
 * Update Sales Orders KPI cards.
 */
updateOrderStats(
    stats
)
{

    if (!stats) {

        return;

    }


    this.setText(
        'ordersTotal',
        stats.total ??
        0
    );


    this.setText(
        'ordersDraft',
        stats.draft ??
        0
    );


    this.setText(
        'ordersCompleted',
        stats.completed ??
        0
    );


    this.setText(
        'ordersSalesValue',
        this.formatMoney(
            stats.sales_value ??
            0
        )
    );

},


/*
|--------------------------------------------------------------------------
| Load Customers
|--------------------------------------------------------------------------
*/

/**
 * Load customers for Sales Orders.
 */
async loadCustomers()
{

    const select =
        this.elements.orderCustomer;


    if (!select) {

        return;

    }


    try {

        const response =
            await fetch(
                '/sales/orders/customers',
                {
                    headers: {

                        'Accept':
                            'application/json'

                    }
                }
            );


        const result =
            await response.json();


        if (
            !response.ok ||
            !result.success
        ) {

            throw new Error(
                result.message ??
                'Unable to load customers.'
            );

        }


        this.populateSelect(
            select,
            result.data ?? [],
            'Walk-in Customer',
            'name'
        );

    }
    catch (error) {

        console.error(
            'Failed to load Sales Order customers:',
            error
        );

    }

},

/*
|--------------------------------------------------------------------------
| Load Customer Groups
|--------------------------------------------------------------------------
*/

/**
 * Load existing customer groups for the quick customer modal.
 */
async loadCustomerGroups()
{

    const select =
        this.elements.orderCustomerGroup;


    if (!select) {

        return;

    }


    try {

        const response =
            await fetch(
                '/sales/orders/customer-groups',
                {
                    headers: {

                        'Accept':
                            'application/json',

                        'X-Requested-With':
                            'XMLHttpRequest'

                    }

                }
            );


        const result =
            await response.json();


        if (
            !response.ok ||
            !result.success
        ) {

            throw new Error(
                result.message ??
                'Unable to load customer groups.'
            );

        }


        this.populateSelect(
            select,
            result.data ?? [],
            'No Group',
            'name'
        );

    }
    catch (error) {

        console.error(
            'Failed to load customer groups:',
            error
        );


        select.innerHTML = `

            <option value="">
                No Group
            </option>

        `;

    }

},

/*
|--------------------------------------------------------------------------
| Load Terminals
|--------------------------------------------------------------------------
*/

/**
 * Load active terminals for the selected branch.
 */
async loadTerminals(
    branchId = null
)
{

    const select =
        this.elements.orderTerminal;


    if (!select) {

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | No Branch
    |--------------------------------------------------------------------------
    */

    if (!branchId) {

        select.innerHTML = `

            <option value="">
                Select branch first
            </option>

        `;


        this.hideCreateTerminalLink();


        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Loading
    |--------------------------------------------------------------------------
    */

    select.innerHTML = `

        <option value="">
            Loading terminals...
        </option>

    `;


    try {

        const response =
            await fetch(
                `/sales/orders/terminals?branch_id=${encodeURIComponent(branchId)}`,
                {
                    headers: {

                        'Accept':
                            'application/json',

                        'X-Requested-With':
                            'XMLHttpRequest'

                    }

                }
            );


        const result =
            await response.json();


        if (
            !response.ok ||
            !result.success
        ) {

            throw new Error(
                result.message ??
                'Unable to load terminals.'
            );

        }


        const terminals =
            result.data ?? [];


        /*
        |--------------------------------------------------------------------------
        | Populate
        |--------------------------------------------------------------------------
        */

        this.populateSelect(
            select,
            terminals,
            terminals.length
                ? 'Select terminal'
                : 'No terminals available',
            'name'
        );


        /*
        |--------------------------------------------------------------------------
        | Create Terminal Link
        |--------------------------------------------------------------------------
        */

        if (
            terminals.length
        ) {

            this.hideCreateTerminalLink();

        }
        else {

            this.showCreateTerminalLink();

        }

    }
    catch (error) {

        console.error(
            'Failed to load Sales Order terminals:',
            error
        );


        select.innerHTML = `

            <option value="">
                No terminals available
            </option>

        `;


        this.showCreateTerminalLink();

    }

},


/*
|--------------------------------------------------------------------------
| Load Branches
|--------------------------------------------------------------------------
*/

/**
 * Load branches for Sales Orders.
 */
async loadBranches()
{

    const select =
        this.elements.orderBranch;


    if (!select) {

        return;

    }


    try {

        const response =
            await fetch(
                '/sales/orders/branches',
                {
                    headers: {

                        'Accept':
                            'application/json'

                    }
                }
            );


        const result =
            await response.json();


        if (
            !response.ok ||
            !result.success
        ) {

            throw new Error(
                result.message ??
                'Unable to load branches.'
            );

        }


        this.populateSelect(
            select,
            result.data ?? [],
            'Select branch',
            'name'
        );

    }
    catch (error) {

        console.error(
            'Failed to load Sales Order branches:',
            error
        );

    }

},


/*
|--------------------------------------------------------------------------
| Load Products
|--------------------------------------------------------------------------
*/

/**
 * Load products for Sales Orders.
 */
async loadProducts()
{

    try {

        const response =
            await fetch(
                '/sales/orders/products',
                {
                    headers: {

                        'Accept':
                            'application/json'

                    }
                }
            );


        const result =
            await response.json();


        if (
            !response.ok ||
            !result.success
        ) {

            throw new Error(
                result.message ??
                'Unable to load products.'
            );

        }


        this.state.products =
            result.data ?? [];

    }
    catch (error) {

        console.error(
            'Failed to load Sales Order products:',
            error
        );


        this.state.products =
            [];

    }

},

/*
|--------------------------------------------------------------------------
| Save Customer
|--------------------------------------------------------------------------
*/

/**
 * Submit quick customer creation.
 */
async saveCustomer()
{

    const form =
        this.elements.orderCustomerForm;


    if (!form) {

        return;

    }


    this.clearValidation(
        form
    );


    const formData =
        new FormData(
            form
        );


    const submitButton =
        this.elements.orderCustomerSubmitBtn;


    const submitText =
        this.elements.orderCustomerSubmitText;


    const submitSpinner =
        this.elements.orderCustomerSubmitSpinner;


    if (submitButton) {

        submitButton.disabled =
            true;

    }


    submitText?.classList.add(
        'd-none'
    );


    submitSpinner?.classList.remove(
        'd-none'
    );


    try {

        const response =
            await fetch(
                '/sales/orders/customers',
                {

                    method:
                        'POST',

                    headers: {

                        'Accept':
                            'application/json',

                        'X-Requested-With':
                            'XMLHttpRequest',

                        'X-CSRF-TOKEN':
                            document
                                .querySelector(
                                    'meta[name="csrf-token"]'
                                )
                                ?.getAttribute(
                                    'content'
                                )

                    },

                    body:
                        formData

                }
            );


        const result =
            await response.json();


        if (
            response.status === 422
        ) {

            this.displayValidationErrors(
                form,
                result.errors ?? {}
            );


            const firstError =
                Object.values(
                    result.errors ?? {}
                )
                    .flat()
                    .find(
                        message =>
                            message
                    );


            this.notify(
                firstError ??
                'Please correct the highlighted fields.',
                'error'
            );


            return;

        }


        if (
            !response.ok ||
            !result.success
        ) {

            throw new Error(
                result.message ??
                'Unable to create customer.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Refresh Customers
        |--------------------------------------------------------------------------
        */

        await this.loadCustomers();


        /*
        |--------------------------------------------------------------------------
        | Select New Customer
        |--------------------------------------------------------------------------
        */

        if (
            result.data?.id &&
            this.elements.orderCustomer
        ) {

            this.elements.orderCustomer.value =
                String(
                    result.data.id
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Close Mini Modal
        |--------------------------------------------------------------------------
        */

        this.orderCustomerModalInstance?.hide();


        /*
        |--------------------------------------------------------------------------
        | Notification
        |--------------------------------------------------------------------------
        */

        this.notify(
            result.message ??
            'Customer created successfully.',
            'success'
        );

    }
    catch (error) {

        console.error(
            'Customer creation failed:',
            error
        );


        this.notify(
            error.message ??
            'Unable to create customer.',
            'error'
        );

    }
    finally {

        submitButton &&
            (
                submitButton.disabled =
                    false
            );


        submitText?.classList.remove(
            'd-none'
        );


        submitSpinner?.classList.add(
            'd-none'
        );

    }

},

/*
|--------------------------------------------------------------------------
| Save Terminal
|--------------------------------------------------------------------------
*/

/**
 * Submit quick terminal creation.
 */
async saveTerminal()
{

    const form =
        this.elements.orderTerminalForm;


    if (!form) {

        return;

    }


    this.clearValidation(
        form
    );


    const branchId =
        this.elements.orderTerminalBranchId
            ?.value ??
        '';


    if (!branchId) {

        this.notify(
            'Select a branch before creating a terminal.',
            'warning'
        );

        return;

    }


    const formData =
        new FormData(
            form
        );


    const submitButton =
        this.elements.orderTerminalSubmitBtn;


    const submitText =
        this.elements.orderTerminalSubmitText;


    const submitSpinner =
        this.elements.orderTerminalSubmitSpinner;


    if (submitButton) {

        submitButton.disabled =
            true;

    }


    submitText?.classList.add(
        'd-none'
    );


    submitSpinner?.classList.remove(
        'd-none'
    );


    try {

        const response =
            await fetch(
                '/sales/orders/terminals',
                {

                    method:
                        'POST',

                    headers: {

                        'Accept':
                            'application/json',

                        'X-Requested-With':
                            'XMLHttpRequest',

                        'X-CSRF-TOKEN':
                            document
                                .querySelector(
                                    'meta[name="csrf-token"]'
                                )
                                ?.getAttribute(
                                    'content'
                                )

                    },

                    body:
                        formData

                }
            );


        const result =
            await response.json();


        if (
            response.status === 422
        ) {

            this.displayValidationErrors(
                form,
                result.errors ?? {}
            );


            const firstError =
                Object.values(
                    result.errors ?? {}
                )
                    .flat()
                    .find(
                        message =>
                            message
                    );


            this.notify(
                firstError ??
                'Please correct the highlighted fields.',
                'error'
            );


            return;

        }


        if (
            !response.ok ||
            !result.success
        ) {

            throw new Error(
                result.message ??
                'Unable to create terminal.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Close Modal
        |--------------------------------------------------------------------------
        */

        this.orderTerminalModalInstance?.hide();


        /*
        |--------------------------------------------------------------------------
        | Refresh Branch Terminals
        |--------------------------------------------------------------------------
        */

        await this.loadTerminals(
            branchId
        );


        /*
        |--------------------------------------------------------------------------
        | Select New Terminal
        |--------------------------------------------------------------------------
        */

        if (
            result.data?.id &&
            this.elements.orderTerminal
        ) {

            this.elements.orderTerminal.value =
                String(
                    result.data.id
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Notification
        |--------------------------------------------------------------------------
        */

        this.notify(
            result.message ??
            'Terminal created successfully.',
            'success'
        );

    }
    catch (error) {

        console.error(
            'Terminal creation failed:',
            error
        );


        this.notify(
            error.message ??
            'Unable to create terminal.',
            'error'
        );

    }
    finally {

        submitButton &&
            (
                submitButton.disabled =
                    false
            );


        submitText?.classList.remove(
            'd-none'
        );


        submitSpinner?.classList.add(
            'd-none'
        );

    }

},


/*
|--------------------------------------------------------------------------
| Populate Select
|--------------------------------------------------------------------------
*/

/**
 * Populate a select element.
 */
populateSelect(
    select,
    items,
    placeholder,
    labelKey = null
)
{

    if (!select) {

        return;

    }


    const currentValue =
        select.value;


    select.innerHTML =
        '';


    const placeholderOption =
        document.createElement(
            'option'
        );


    placeholderOption.value =
        '';


    placeholderOption.textContent =
        placeholder;


    select.appendChild(
        placeholderOption
    );


    items.forEach(
        item => {

            const option =
                document.createElement(
                    'option'
                );


            option.value =
                item.id;


            option.textContent =
                labelKey
                    ? (
                        item[labelKey] ??
                        ''
                    )
                    : (
                        item.name ??
                        item.display_name ??
                        item.label ??
                        ''
                    );


            select.appendChild(
                option
            );

        }
    );


    if (
        currentValue
    ) {

        select.value =
            currentValue;

    }

},




    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    bindSearch(
        element,
        callback
    )
    {

        if (!element) {

            return;

        }


        let timer = null;


        element.addEventListener(
            'input',
            () => {

                clearTimeout(
                    timer
                );


                timer =
                    setTimeout(
                        callback,
                        300
                    );

            }
        );

    },


    bindFilter(
        element,
        callback
    )
    {

        if (!element) {

            return;

        }


        element.addEventListener(
            'change',
            callback
        );

    },


    appendValue(
        params,
        key,
        element
    )
    {

        if (
            !element
        ) {

            return;

        }


        const value =
            element.value;


        if (
            value !== ''
        ) {

            params.set(
                key,
                value
            );

        }

    },


    setText(
        id,
        value
    )
    {

        const element =
            document.getElementById(
                id
            );


        if (element) {

            element.textContent =
                value;

        }

    },


    formatMoney(
        value
    )
    {

        return Number(
            value ?? 0
        ).toLocaleString(
            'en-NG',
            {
                minimumFractionDigits:
                    2,

                maximumFractionDigits:
                    2
            }
        );

    },


    formatQuantity(
        value
    )
    {

        return Number(
            value ?? 0
        ).toLocaleString(
            'en-NG',
            {
                minimumFractionDigits:
                    0,

                maximumFractionDigits:
                    2
            }
        );

    },


    escapeHtml(
        value
    )
    {

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
| Table Loading
|--------------------------------------------------------------------------
*/

/**
 * Display Sales Orders table loading state.
 */
showTableLoading(
    container
)
{

    if (!container) {

        return;

    }


    container.innerHTML = `

        <tr>

            <td
                colspan="9"
                class="text-center text-muted py-5"
            >

                <div
                    class="spinner-border spinner-border-sm me-2"
                ></div>

                Loading sales orders...

            </td>

        </tr>

    `;

},
/*
|--------------------------------------------------------------------------
| Table Error
|--------------------------------------------------------------------------
*/

/**
 * Display Sales Orders table error state.
 */
showTableError(
    container,
    message
)
{

    if (!container) {

        return;

    }


    container.innerHTML = `

        <tr>

            <td
                colspan="9"
                class="text-center text-danger py-5"
            >

                <i class="bi bi-exclamation-circle me-1"></i>

                ${this.escapeHtml(
                    message ??
                    'Unable to load sales orders.'
                )}

            </td>

        </tr>

    `;

},

/*
|--------------------------------------------------------------------------
| Save Order
|--------------------------------------------------------------------------
*/

/**
 * Submit Sales Order.
 */
async saveOrder()
{

    const form =
        this.elements.orderForm;


    if (!form) {

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Clear Validation
    |--------------------------------------------------------------------------
    */

    this.clearValidation(
        form
    );


    /*
    |--------------------------------------------------------------------------
    | Validate Basic Information
    |--------------------------------------------------------------------------
    */

    const branchId =
        this.elements.orderBranch?.value ??
        '';


    const salesChannel =
        this.elements.orderSalesChannel?.value ??
        '';


    if (!branchId) {

        this.notify(
            'Please select a branch.',
            'warning'
        );

        return;

    }


    if (!salesChannel) {

        this.notify(
            'Please select a sales channel.',
            'warning'
        );

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Order Items
    |--------------------------------------------------------------------------
    */

    const items =
        this.state.orderItems.filter(
            item => {

                return (
                    item.product_id &&
                    (
                        parseFloat(
                            item.quantity
                        ) || 0
                    ) > 0
                );

            }
        );


    if (!items.length) {

        this.notify(
            'Add at least one product to the order.',
            'warning'
        );

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Validate Item Values
    |--------------------------------------------------------------------------
    */

    const invalidItem =
        items.find(
            item => {

                const quantity =
                    parseFloat(
                        item.quantity
                    ) || 0;


                const unitPrice =
                    parseFloat(
                        item.unit_price
                    ) || 0;


                const discount =
                    parseFloat(
                        item.discount_amount
                    ) || 0;


                return (
                    quantity <= 0 ||
                    unitPrice < 0 ||
                    discount < 0
                );

            }
        );


    if (invalidItem) {

        this.notify(
            'One or more order items contain invalid values.',
            'error'
        );

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Loading State
    |--------------------------------------------------------------------------
    */

    const submitButton =
        this.elements.orderSubmitBtn;


    const submitText =
        this.elements.orderSubmitText;


    const submitSpinner =
        this.elements.orderSubmitSpinner;


    if (submitButton) {

        submitButton.disabled =
            true;

    }


    submitText?.classList.add(
        'd-none'
    );


    submitSpinner?.classList.remove(
        'd-none'
    );


    /*
    |--------------------------------------------------------------------------
    | Build Form Data
    |--------------------------------------------------------------------------
    */

    const formData =
        new FormData();


    formData.append(
        'branch_id',
        branchId
    );


    formData.append(
        'sales_channel',
        salesChannel
    );


    formData.append(
        'customer_id',
        this.elements.orderCustomer?.value ??
        ''
    );


    formData.append(
        'terminal_id',
        this.elements.orderTerminal?.value ??
        ''
    );


    formData.append(
        'remarks',
        this.elements.orderRemarks?.value ??
        ''
    );


    /*
    |--------------------------------------------------------------------------
    | Items
    |--------------------------------------------------------------------------
    */

    items.forEach(
        (item, index) => {

            formData.append(
                `items[${index}][product_id]`,
                item.product_id
            );


            formData.append(
                `items[${index}][quantity]`,
                parseFloat(
                    item.quantity
                ) || 0
            );


            formData.append(
                `items[${index}][unit_price]`,
                parseFloat(
                    item.unit_price
                ) || 0
            );


            formData.append(
                `items[${index}][discount_amount]`,
                parseFloat(
                    item.discount_amount
                ) || 0
            );


            formData.append(
                `items[${index}][tax_amount]`,
                parseFloat(
                    item.tax_amount
                ) || 0
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Submit
    |--------------------------------------------------------------------------
    */

    try {

        const response =
            await fetch(
                '/sales/orders',
                {

                    method:
                        'POST',

                    headers: {

                        'Accept':
                            'application/json',

                        'X-Requested-With':
                            'XMLHttpRequest',

                        'X-CSRF-TOKEN':
                            document
                                .querySelector(
                                    'meta[name="csrf-token"]'
                                )
                                ?.getAttribute(
                                    'content'
                                )

                    },

                    body:
                        formData

                }
            );


        const result =
            await response.json();


        /*
        |--------------------------------------------------------------------------
        | Validation Errors
        |--------------------------------------------------------------------------
        */

        if (
            response.status === 422
        ) {

            console.error(
                'Sales Order validation failed:',
                result.errors ?? {}
            );


            this.displayValidationErrors(
                form,
                result.errors ?? {}
            );


            const firstError =
                Object.values(
                    result.errors ?? {}
                )
                    .flat()
                    .find(
                        message =>
                            message
                    );


            this.notify(
                firstError ??
                result.message ??
                'Please correct the highlighted fields.',
                'error'
            );


            return;

        }


        /*
        |--------------------------------------------------------------------------
        | General Error
        |--------------------------------------------------------------------------
        */

        if (
            !response.ok ||
            !result.success
        ) {

            throw new Error(
                result.message ??
                'Unable to create sales order.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        this.notify(
            result.message ??
            'Sales order created successfully.',
            'success'
        );


        /*
        |--------------------------------------------------------------------------
        | Close Modal
        |--------------------------------------------------------------------------
        */

        this.orderModalInstance?.hide();


        /*
        |--------------------------------------------------------------------------
        | Refresh Orders
        |--------------------------------------------------------------------------
        */

        await this.loadOrders(
            this.state.ordersPage ||
            1
        );

    }
    catch (error) {

        console.error(
            'Sales Order submission failed:',
            error
        );


        this.notify(
            error.message ??
            'Unable to create sales order.',
            'error'
        );

    }
    finally {

        if (submitButton) {

            submitButton.disabled =
                false;

        }


        submitText?.classList.remove(
            'd-none'
        );


        submitSpinner?.classList.add(
            'd-none'
        );

    }

},

/*
|--------------------------------------------------------------------------
| Clear Validation
|--------------------------------------------------------------------------
*/

/**
 * Clear validation states from a form.
 */
clearValidation(
    form
)
{

    if (!form) {

        return;

    }


    form
        .querySelectorAll(
            '.is-invalid'
        )
        .forEach(
            element => {

                element.classList.remove(
                    'is-invalid'
                );

            }
        );


    form
        .querySelectorAll(
            '.invalid-feedback'
        )
        .forEach(
            element => {

                element.remove();

            }
        );

},

/*
|--------------------------------------------------------------------------
| Display Validation Errors
|--------------------------------------------------------------------------
*/

/**
 * Display Laravel validation errors on form fields.
 */
displayValidationErrors(
    form,
    errors
)
{

    if (
        !form ||
        !errors
    ) {

        return;

    }


    Object.entries(
        errors
    ).forEach(
        ([field, messages]) => {

            const message =
                Array.isArray(
                    messages
                )
                    ? messages[0]
                    : messages;


            /*
            |--------------------------------------------------------------------------
            | Resolve Field
            |--------------------------------------------------------------------------
            */

            let input =
                form.querySelector(
                    `[name="${field}"]`
                );


            /*
            |--------------------------------------------------------------------------
            | Nested Item Fields
            |--------------------------------------------------------------------------
            */

            if (!input) {

                const normalizedField =
                    field.replace(
                        /\./g,
                        ']['
                    );


                input =
                    form.querySelector(
                        `[name^="items["][name*="${field.split('.').pop()}"]`
                    );

            }


            if (
                input
            ) {

                input.classList.add(
                    'is-invalid'
                );


                let feedback =
                    input.parentElement
                        ?.querySelector(
                            '.invalid-feedback'
                        );


                if (!feedback) {

                    feedback =
                        document.createElement(
                            'div'
                        );


                    feedback.className =
                        'invalid-feedback';


                    input.parentElement?.appendChild(
                        feedback
                    );

                }


                feedback.textContent =
                    message;

            }

        }
    );

},

/*
|--------------------------------------------------------------------------
| Notify
|--------------------------------------------------------------------------
*/

/**
 * Display a notification.
 */
notify(
    message,
    type = 'info'
)
{

    if (!message) {

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Resolve Notification Container
    |--------------------------------------------------------------------------
    */

    let container =
        document.getElementById(
            'toastContainer'
        );


    if (!container) {

        container =
            document.createElement(
                'div'
            );


        container.id =
            'toastContainer';


        container.className =
            'toast-container position-fixed top-0 end-0 p-3';


        container.style.zIndex =
            '1100';


        document.body.appendChild(
            container
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Toast
    |--------------------------------------------------------------------------
    */

    const toast =
        document.createElement(
            'div'
        );


    const typeClasses = {

        success:
            'text-bg-success',

        error:
            'text-bg-danger',

        warning:
            'text-bg-warning',

        info:
            'text-bg-dark',

    };


    toast.className =
        `toast align-items-center border-0 ${
            typeClasses[type] ??
            typeClasses.info
        }`;


    toast.setAttribute(
        'role',
        'alert'
    );


    toast.setAttribute(
        'aria-live',
        'assertive'
    );


    toast.setAttribute(
        'aria-atomic',
        'true'
    );


    toast.innerHTML = `

        <div class="d-flex">

            <div class="toast-body">

                ${this.escapeHtml(
                    String(message)
                )}

            </div>


            <button
                type="button"
                class="btn-close btn-close-white me-2 m-auto"
                data-bs-dismiss="toast"
                aria-label="Close"
            ></button>

        </div>

    `;


    container.appendChild(
        toast
    );


    /*
    |--------------------------------------------------------------------------
    | Bootstrap Toast
    |--------------------------------------------------------------------------
    */

    const instance =
        bootstrap.Toast.getOrCreateInstance(
            toast,
            {
                delay:
                    4000
            }
        );


    instance.show();


    /*
    |--------------------------------------------------------------------------
    | Cleanup
    |--------------------------------------------------------------------------
    */

    toast.addEventListener(
        'hidden.bs.toast',
        () => {

            toast.remove();

        }
    );

},

/*
|--------------------------------------------------------------------------
| Show Create Terminal Link
|--------------------------------------------------------------------------
*/

showCreateTerminalLink()
{

    this.elements
        .orderCreateTerminalWrap
        ?.classList.remove(
            'd-none'
        );

},


/*
|--------------------------------------------------------------------------
| Hide Create Terminal Link
|--------------------------------------------------------------------------
*/

hideCreateTerminalLink()
{

    this.elements
        .orderCreateTerminalWrap
        ?.classList.add(
            'd-none'
        );

},



};


/*
|--------------------------------------------------------------------------
| Initialize Order Module
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    () => {

        OrderModule.init();

    }
);