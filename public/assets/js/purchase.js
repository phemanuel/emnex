/*
|--------------------------------------------------------------------------
| EMNEX POS - Purchase Management
|--------------------------------------------------------------------------
|
| Handles:
|
| - Purchase Orders
| - Goods Received
| - Purchase Returns
|
| Single combined Purchasing workspace.
|
*/


const Purchase = {


    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    searchTimer:
        null,

    activeTab:
        'orders',

    ordersPage:
        1,

    goodsReceivedPage:
        1,

    returnsPage:
        1,

    selectedOrder:
        null,

    selectedGoodsReceived:
        null,

    selectedReturn:
        null,

    orderItems:
        [],

    receivedItems:
        [],

    returnItems:
        [],

    editingOrderId:
        null,

    editingGoodsReceivedId:
        null,

    editingReturnId:
        null,

    confirmationAction:
        null,

    confirmationType:
        null,

    globalActionId:
        null,

    globalActionType:
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
        |--------------------------------------------------------------------------
        | Main
        |--------------------------------------------------------------------------
        */

        this.elements =
        {

            /*
            |--------------------------------------------------------------------------
            | Tabs
            |--------------------------------------------------------------------------
            */

            tabs:
                document.querySelectorAll(
                    '[data-purchase-tab]'
                ),

            newPurchaseOrderBtn:
                document.getElementById(
                    'newPurchaseOrderBtn'
                ),

            purchaseOrderModal:
                document.getElementById(
                    'purchaseOrderModal'
                ),


            /*
            |--------------------------------------------------------------------------
            | Orders
            |--------------------------------------------------------------------------
            */

            ordersTable:
                document.getElementById(
                    'purchaseOrdersTable'
                ),

            ordersPagination:
                document.getElementById(
                    'purchaseOrdersPagination'
                ),

            ordersSearch:
                document.getElementById(
                    'purchaseOrdersSearch'
                ),

            ordersSupplierFilter:
                document.getElementById(
                    'purchaseOrdersSupplierFilter'
                ),

            ordersBranchFilter:
                document.getElementById(
                    'purchaseOrdersBranchFilter'
                ),

            ordersStatusFilter:
                document.getElementById(
                    'purchaseOrdersStatusFilter'
                ),

            ordersDateFrom:
                document.getElementById(
                    'purchaseOrdersDateFrom'
                ),

            ordersDateTo:
                document.getElementById(
                    'purchaseOrdersDateTo'
                ),


            /*
            |--------------------------------------------------------------------------
            | Goods Received
            |--------------------------------------------------------------------------
            */

            goodsReceivedTable:
                document.getElementById(
                    'goodsReceivedTable'
                ),

            goodsReceivedPagination:
                document.getElementById(
                    'goodsReceivedPagination'
                ),

            goodsReceivedSearch:
                document.getElementById(
                    'goodsReceivedSearch'
                ),

            goodsReceivedSupplierFilter:
                document.getElementById(
                    'goodsReceivedSupplierFilter'
                ),

            goodsReceivedBranchFilter:
                document.getElementById(
                    'goodsReceivedBranchFilter'
                ),

            goodsReceivedStatusFilter:
                document.getElementById(
                    'goodsReceivedStatusFilter'
                ),

            goodsReceivedDateFrom:
                document.getElementById(
                    'goodsReceivedDateFrom'
                ),

            goodsReceivedDateTo:
                document.getElementById(
                    'goodsReceivedDateTo'
                ),


            /*
            |--------------------------------------------------------------------------
            | Purchase Returns
            |--------------------------------------------------------------------------
            */

            returnsTable:
                document.getElementById(
                    'purchaseReturnsTable'
                ),

            returnsPagination:
                document.getElementById(
                    'purchaseReturnsPagination'
                ),

            returnsSearch:
                document.getElementById(
                    'purchaseReturnsSearch'
                ),

            returnsSupplierFilter:
                document.getElementById(
                    'purchaseReturnsSupplierFilter'
                ),

            returnsBranchFilter:
                document.getElementById(
                    'purchaseReturnsBranchFilter'
                ),

            returnsStatusFilter:
                document.getElementById(
                    'purchaseReturnsStatusFilter'
                ),

            returnsDateFrom:
                document.getElementById(
                    'purchaseReturnsDateFrom'
                ),

            returnsDateTo:
                document.getElementById(
                    'purchaseReturnsDateTo'
                ),


            /*
            |--------------------------------------------------------------------------
            | Order Modal
            |--------------------------------------------------------------------------
            */

            addPurchaseOrderItemBtn:
                document.getElementById(
                    'addPurchaseOrderItemBtn'
                ),

            purchaseOrderItems:
                document.getElementById(
                    'purchaseOrderItems'
                ),

            purchaseOrderEmptyItems:
                document.getElementById(
                    'purchaseOrderEmptyItems'
                ),

            orderModal:
                document.getElementById(
                    'purchaseOrderModal'
                ),

            orderForm:
                document.getElementById(
                    'purchaseOrderForm'
                ),

            orderId:
                document.getElementById(
                    'purchaseOrderId'
                ),

            orderSupplier:
                document.getElementById(
                    'purchaseOrderSupplier'
                ),

            orderBranch:
                document.getElementById(
                    'purchaseOrderBranch'
                ),

            orderDate:
                document.getElementById(
                    'purchaseOrderDate'
                ),

            orderExpectedDate:
                document.getElementById(
                    'purchaseOrderExpectedDate'
                ),

            orderNotes:
                document.getElementById(
                    'purchaseOrderNotes'
                ),

            orderItemsContainer:
                document.getElementById(
                    'purchaseOrderItems'
                ),

            orderSubtotal:
                document.getElementById(
                    'purchaseOrderSubtotal'
                ),

            orderTax:
                document.getElementById(
                    'purchaseOrderTax'
                ),

            orderDiscount:
                document.getElementById(
                    'purchaseOrderDiscount'
                ),

            orderTotal:
                document.getElementById(
                    'purchaseOrderTotal'
                ),


            /*
            |--------------------------------------------------------------------------
            | Goods Received Modal
            |--------------------------------------------------------------------------
            */

            goodsReceivedModal:
                document.getElementById(
                    'goodsReceivedModal'
                ),

            goodsReceivedForm:
                document.getElementById(
                    'goodsReceivedForm'
                ),

            goodsReceivedId:
                document.getElementById(
                    'goodsReceivedId'
                ),

            goodsReceivedOrder:
                document.getElementById(
                    'goodsReceivedOrder'
                ),

            goodsReceivedSupplier:
                document.getElementById(
                    'goodsReceivedSupplier'
                ),

            goodsReceivedBranch:
                document.getElementById(
                    'goodsReceivedBranch'
                ),

            goodsReceivedDate:
                document.getElementById(
                    'goodsReceivedDate'
                ),

            goodsReceivedReference:
                document.getElementById(
                    'goodsReceivedReference'
                ),

            goodsReceivedNotes:
                document.getElementById(
                    'goodsReceivedNotes'
                ),

            goodsReceivedItemsContainer:
                document.getElementById(
                    'goodsReceivedItems'
                ),

            goodsReceivedTotal:
                document.getElementById(
                    'goodsReceivedTotal'
                ),


            /*
            |--------------------------------------------------------------------------
            | Return Modal
            |--------------------------------------------------------------------------
            */

            returnModal:
                document.getElementById(
                    'purchaseReturnModal'
                ),

            returnForm:
                document.getElementById(
                    'purchaseReturnForm'
                ),

            returnId:
                document.getElementById(
                    'purchaseReturnId'
                ),

            returnOrder:
                document.getElementById(
                    'purchaseReturnOrder'
                ),

            returnSupplier:
                document.getElementById(
                    'purchaseReturnSupplier'
                ),

            returnBranch:
                document.getElementById(
                    'purchaseReturnBranch'
                ),

            returnDate:
                document.getElementById(
                    'purchaseReturnDate'
                ),

            returnReference:
                document.getElementById(
                    'purchaseReturnReference'
                ),

            returnReason:
                document.getElementById(
                    'purchaseReturnReason'
                ),

            returnNotes:
                document.getElementById(
                    'purchaseReturnNotes'
                ),

            returnItemsContainer:
                document.getElementById(
                    'purchaseReturnItems'
                ),

            returnTotal:
                document.getElementById(
                    'purchaseReturnTotal'
                ),


            /*
            |--------------------------------------------------------------------------
            | Order Inspector
            |--------------------------------------------------------------------------
            */

            orderInspector:
                document.getElementById(
                    'purchaseOrderInspector'
                ),

            orderInspectorContent:
                document.getElementById(
                    'purchaseOrderInspectorContent'
                ),


            /*
            |--------------------------------------------------------------------------
            | Goods Received Inspector
            |--------------------------------------------------------------------------
            */

            goodsReceivedInspector:
                document.getElementById(
                    'goodsReceivedInspector'
                ),

            goodsReceivedInspectorContent:
                document.getElementById(
                    'goodsReceivedInspectorContent'
                ),


            /*
            |--------------------------------------------------------------------------
            | Return Inspector
            |--------------------------------------------------------------------------
            */

            returnInspector:
                document.getElementById(
                    'purchaseReturnInspector'
                ),

            returnInspectorContent:
                document.getElementById(
                    'purchaseReturnInspectorContent'
                ),


            /*
            |--------------------------------------------------------------------------
            | Confirmation
            |--------------------------------------------------------------------------
            */

            confirmModal:
                document.getElementById(
                    'purchaseConfirmModal'
                ),

            confirmIcon:
                document.getElementById(
                    'purchaseConfirmIcon'
                ),

            confirmTitle:
                document.getElementById(
                    'purchaseConfirmTitle'
                ),

            confirmMessage:
                document.getElementById(
                    'purchaseConfirmMessage'
                ),

            confirmDescription:
                document.getElementById(
                    'purchaseConfirmDescription'
                ),

            confirmButton:
                document.getElementById(
                    'purchaseConfirmBtn'
                ),

            /*
            |--------------------------------------------------------------------------
            | Purchase Action Menu
            |--------------------------------------------------------------------------
            */

            purchaseActionMenu:
                document.getElementById(
                    'purchaseActionMenu'
                ),

            purchaseActionView:
                document.getElementById(
                    'purchaseActionView'
                ),

            purchaseActionEdit:
                document.getElementById(
                    'purchaseActionEdit'
                ),

            purchaseActionToggle:
                document.getElementById(
                    'purchaseActionToggle'
                ),

            purchaseActionDelete:
                document.getElementById(
                    'purchaseActionDelete'
                ),


            /*
            |--------------------------------------------------------------------------
            | Global Action Menu
            |--------------------------------------------------------------------------
            */

            globalActionMenu:
                document.getElementById(
                    'purchaseGlobalActionMenu'
                ),

        };

    },


    /*
    |--------------------------------------------------------------------------
    | Initialize Components
    |--------------------------------------------------------------------------
    */

    initializeComponents()
    {

        /*
        |--------------------------------------------------------------------------
        | Bootstrap Modals
        |--------------------------------------------------------------------------
        */

        if (
            this.elements.orderModal
        ) {

            this.orderModalInstance =
                bootstrap.Modal.getOrCreateInstance(
                    this.elements.orderModal
                );

        }


        if (
            this.elements.goodsReceivedModal
        ) {

            this.goodsReceivedModalInstance =
                bootstrap.Modal.getOrCreateInstance(
                    this.elements.goodsReceivedModal
                );

        }


        if (
            this.elements.returnModal
        ) {

            this.returnModalInstance =
                bootstrap.Modal.getOrCreateInstance(
                    this.elements.returnModal
                );

        }


        if (
            this.elements.confirmModal
        ) {

            this.confirmModalInstance =
                bootstrap.Modal.getOrCreateInstance(
                    this.elements.confirmModal
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Bootstrap Offcanvas
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


        if (
            this.elements.goodsReceivedInspector
        ) {

            this.goodsReceivedInspectorInstance =
                bootstrap.Offcanvas.getOrCreateInstance(
                    this.elements.goodsReceivedInspector
                );

        }


        if (
            this.elements.returnInspector
        ) {

            this.returnInspectorInstance =
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

    bindEvents()
    {

        /*
        |--------------------------------------------------------------------------
        | Tabs
        |--------------------------------------------------------------------------
        */

        this.elements.tabs?.forEach(
            tab => {

                tab.addEventListener(
                    'click',
                    event => {

                        event.preventDefault();

                        const target =
                            tab.dataset.purchaseTab;

                        this.switchTab(
                            target
                        );

                    }
                );

            }
        );


        if (
                this.elements.newPurchaseOrderBtn
            ) {

                this.elements.newPurchaseOrderBtn
                    .addEventListener(
                        'click',
                        () => {

                            this.openCreateOrder();

                        }
                    );

            }

        if (
            this.elements.addPurchaseOrderItemBtn
        ) {

            this.elements.addPurchaseOrderItemBtn.addEventListener(
                'click',
                () => {

                    this.addPurchaseOrderItem();

                }
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        this.bindSearch(
            this.elements.ordersSearch,
            () => {

                this.ordersPage = 1;

                this.loadOrders();

            }
        );


        this.bindSearch(
            this.elements.goodsReceivedSearch,
            () => {

                this.goodsReceivedPage = 1;

                this.loadGoodsReceived();

            }
        );


        this.bindSearch(
            this.elements.returnsSearch,
            () => {

                this.returnsPage = 1;

                this.loadReturns();

            }
        );       


        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */

        this.bindFilter(
            this.elements.ordersSupplierFilter,
            () => this.loadOrders()
        );

        this.bindFilter(
            this.elements.ordersBranchFilter,
            () => this.loadOrders()
        );

        this.bindFilter(
            this.elements.ordersStatusFilter,
            () => this.loadOrders()
        );

        this.bindFilter(
            this.elements.ordersDateFrom,
            () => this.loadOrders()
        );

        this.bindFilter(
            this.elements.ordersDateTo,
            () => this.loadOrders()
        );


        this.bindFilter(
            this.elements.goodsReceivedSupplierFilter,
            () => this.loadGoodsReceived()
        );

        this.bindFilter(
            this.elements.goodsReceivedBranchFilter,
            () => this.loadGoodsReceived()
        );

        this.bindFilter(
            this.elements.goodsReceivedStatusFilter,
            () => this.loadGoodsReceived()
        );


        this.bindFilter(
            this.elements.returnsSupplierFilter,
            () => this.loadReturns()
        );

        this.bindFilter(
            this.elements.returnsBranchFilter,
            () => this.loadReturns()
        );

        this.bindFilter(
            this.elements.returnsStatusFilter,
            () => this.loadReturns()
        );


        /*
        |--------------------------------------------------------------------------
        | Forms
        |--------------------------------------------------------------------------
        */

        this.elements.orderForm?.addEventListener(
            'submit',
            event => {

                event.preventDefault();

                this.saveOrder();

            }
        );


        this.elements.goodsReceivedForm?.addEventListener(
            'submit',
            event => {

                event.preventDefault();

                this.saveGoodsReceived();

            }
        );


        this.elements.returnForm?.addEventListener(
            'submit',
            event => {

                event.preventDefault();

                this.saveReturn();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Confirmation
        |--------------------------------------------------------------------------
        */

        this.elements.confirmButton?.addEventListener(
            'click',
            () => {

                this.executeConfirmation();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Dynamic Table Actions
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            event => {

                const action =
                    event.target.closest(
                        '[data-purchase-action]'
                    );

                if (!action) {
                    return;
                }

                event.preventDefault();

                this.handleAction(
                    action
                );

            }
        );       


        /*
        |--------------------------------------------------------------------------
        | Dynamic Pagination
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            event => {

                const button =
                    event.target.closest(
                        '[data-purchase-page]'
                    );

                if (!button) {
                    return;
                }

                event.preventDefault();

                const page =
                    parseInt(
                        button.dataset.purchasePage,
                        10
                    );

                if (!page) {
                    return;
                }

                const type =
                    button.dataset.purchasePagination;

                if (
                    type === 'orders'
                ) {

                    this.loadOrders(
                        page
                    );

                }

                else if (
                    type === 'goods-received'
                ) {

                    this.loadGoodsReceived(
                        page
                    );

                }

                else if (
                    type === 'returns'
                ) {

                    this.loadReturns(
                        page
                    );

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Add Item Buttons
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            event => {

                if (
                    event.target.closest(
                        '#addPurchaseOrderItem'
                    )
                ) {

                    this.addOrderItem();

                }


                if (
                    event.target.closest(
                        '#addGoodsReceivedItem'
                    )
                ) {

                    this.addReceivedItem();

                }


                if (
                    event.target.closest(
                        '#addPurchaseReturnItem'
                    )
                ) {

                    this.addReturnItem();

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Global Action Menu
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            event => {

                const trigger =
                    event.target.closest(
                        '[data-purchase-global-action]'
                    );

                if (!trigger) {
                    return;
                }

                this.openGlobalActionMenu(
                    trigger
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Purchase Action Menu
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            event => {

                const trigger =
                    event.target.closest(
                        '.purchase-action-trigger'
                    );


                if (!trigger) {

                    return;

                }


                event.preventDefault();

                event.stopPropagation();


                const type =
                    trigger.dataset.type;


                const id =
                    Number(
                        trigger.dataset.id
                    );


                const reference =
                    trigger.dataset.reference ?? '';


                if (!type || !id) {

                    return;

                }


                this.openPurchaseActionMenu(
                    trigger,
                    type,
                    id,
                    reference
                );

            }
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Load Initial Data
    |--------------------------------------------------------------------------
    */

    async loadInitialData()
    {

        await Promise.allSettled([

            this.loadSuppliers(),

            this.loadBranches(),

            this.loadProducts(),

            this.loadOrders(),

        ]);

    },


    /*
    |--------------------------------------------------------------------------
    | Bind Search
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

        element.addEventListener(
            'input',
            () => {

                clearTimeout(
                    this.searchTimer
                );

                this.searchTimer =
                    setTimeout(
                        callback,
                        350
                    );

            }
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Bind Filter
    |--------------------------------------------------------------------------
    */

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

    /*
            |--------------------------------------------------------------------------
            | Purchase Order Item Events
            |--------------------------------------------------------------------------
            */

            bindPurchaseOrderItemEvents() {

                document
                    .querySelectorAll(
                        '.purchase-order-product'
                    )
                    .forEach(
                        select => {

                            select.addEventListener(
                                'change',
                                event => {

                                    const index =
                                        Number(
                                            event.target.dataset.index
                                        );


                                    const productId =
                                        event.target.value;


                                    this.orderItems[
                                        index
                                    ].product_id =
                                        productId
                                            ? Number(
                                                productId
                                            )
                                            : null;


                                    const product =
                                        this.products.find(
                                            product =>
                                                Number(
                                                    product.id
                                                ) ===
                                                Number(
                                                    productId
                                                )
                                        );


                                    if (product) {

                                        this.orderItems[
                                            index
                                        ].unit_cost =
                                            parseFloat(
                                                product.cost_price
                                            ) || 0;

                                    }


                                    this.calculatePurchaseOrderItem(
                                        index
                                    );

                                }
                            );

                        }
                    );


                document
                    .querySelectorAll(
                        '.purchase-order-quantity'
                    )
                    .forEach(
                        input => {

                            input.addEventListener(
                                'input',
                                event => {

                                    const index =
                                        Number(
                                            event.target.dataset.index
                                        );


                                    this.orderItems[
                                        index
                                    ].quantity =
                                        parseFloat(
                                            event.target.value
                                        ) || 0;


                                    this.calculatePurchaseOrderItem(
                                        index
                                    );

                                }
                            );

                        }
                    );


                document
                    .querySelectorAll(
                        '.purchase-order-unit-cost'
                    )
                    .forEach(
                        input => {

                            input.addEventListener(
                                'input',
                                event => {

                                    const index =
                                        Number(
                                            event.target.dataset.index
                                        );


                                    this.orderItems[
                                        index
                                    ].unit_cost =
                                        parseFloat(
                                            event.target.value
                                        ) || 0;


                                    this.calculatePurchaseOrderItem(
                                        index
                                    );

                                }
                            );

                        }
                    );


                document
                    .querySelectorAll(
                        '.purchase-order-remove-item'
                    )
                    .forEach(
                        button => {

                            button.addEventListener(
                                'click',
                                event => {

                                    const index =
                                        Number(
                                            event.currentTarget.dataset.index
                                        );


                                    this.orderItems.splice(
                                        index,
                                        1
                                    );


                                    this.renderPurchaseOrderItems();

                                }
                            );

                        }
                    );


               /*
            |--------------------------------------------------------------------------
            | Product Search
            |--------------------------------------------------------------------------
            */

            document
                .querySelectorAll(
                    '.purchase-order-product-search'
                )
                .forEach(
                    input => {

                        /*
                        |--------------------------------------------------------------------------
                        | Focus
                        |--------------------------------------------------------------------------
                        */

                        input.addEventListener(
                            'focus',
                            event => {

                                const index =
                                    Number(
                                        event.target.dataset.index
                                    );


                                const value =
                                    event.target.value
                                        ?.trim();


                                /*
                                |--------------------------------------------------------------------------
                                | If already searching, keep search results
                                |--------------------------------------------------------------------------
                                */

                                if (value) {

                                    this.searchPurchaseOrderProducts(
                                        index,
                                        value
                                    );

                                    return;

                                }


                                /*
                                |--------------------------------------------------------------------------
                                | Show limited initial products
                                |--------------------------------------------------------------------------
                                */

                                this.showInitialPurchaseOrderProducts(
                                    index
                                );

                            }
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | Search
                        |--------------------------------------------------------------------------
                        */

                        input.addEventListener(
                            'input',
                            event => {

                                const index =
                                    Number(
                                        event.target.dataset.index
                                    );


                                this.searchPurchaseOrderProducts(
                                    index,
                                    event.target.value
                                );

                            }
                        );

                    }
                );
              /*
                |--------------------------------------------------------------------------
                | Product Selection
                |--------------------------------------------------------------------------
                */

                const productItems =
                    this.elements.purchaseOrderItems;


                if (productItems) {

                    productItems.addEventListener(
                        'click',
                        event => {

                            const button =
                                event.target.closest(
                                    '.purchase-product-option'
                                );


                            if (!button) {

                                return;

                            }


                            event.preventDefault();


                            const index =
                                Number(
                                    button.dataset.index
                                );


                            const productId =
                                Number(
                                    button.dataset.productId
                                );


                            this.selectPurchaseOrderProduct(
                                index,
                                productId
                            );

                        }
                    );

                }

                /*
            |--------------------------------------------------------------------------
            | Clear Product
            |--------------------------------------------------------------------------
            */

            document
                .querySelectorAll(
                    '.purchase-product-clear'
                )
                .forEach(
                    button => {

                        button.addEventListener(
                            'click',
                            event => {

                                event.preventDefault();


                                const index =
                                    Number(
                                        event.currentTarget
                                            .dataset
                                            .index
                                    );


                                this.clearPurchaseOrderProduct(
                                    index
                                );

                            }
                        );

                    }
                );

            },


    /*
    |--------------------------------------------------------------------------
    | Switch Tab
    |--------------------------------------------------------------------------
    */

    switchTab(
        tab
    )
    {

        this.activeTab =
            tab;


        this.elements.tabs?.forEach(
            button => {

                button.classList.toggle(
                    'active',
                    button.dataset.purchaseTab === tab
                );

            }
        );


        document
            .querySelectorAll(
                '[data-purchase-panel]'
            )
            .forEach(
                panel => {

                    panel.classList.toggle(
                        'd-none',
                        panel.dataset.purchasePanel !== tab
                    );

                }
            );


        if (
            tab === 'orders'
        ) {

            this.loadOrders();

        }

        else if (
            tab === 'goods-received'
        ) {

            this.loadGoodsReceived();

        }

        else if (
            tab === 'returns'
        ) {

            this.loadReturns();

        }

    },

    /*
    |--------------------------------------------------------------------------
    | Add Purchase Order Item
    |--------------------------------------------------------------------------
    */

    addPurchaseOrderItem() {

        const item = {

            product_id:
                null,

            quantity:
                1,

            unit_cost:
                0,

            discount:
                0,

            tax:
                0,

            total:
                0,

        };


        this.orderItems.push(
            item
        );


        this.renderPurchaseOrderItems();

    },


    /*
|--------------------------------------------------------------------------
| Render Purchase Order Items
|--------------------------------------------------------------------------
*/

renderPurchaseOrderItems() {

    const tbody =
        this.elements.purchaseOrderItems;


    if (!tbody) {

        return;

    }


    tbody.innerHTML = '';


    if (
        !this.orderItems.length
    ) {

        tbody.innerHTML = `

            <tr id="purchaseOrderEmptyItems">

                <td
                    colspan="5"
                    class="text-center text-muted py-4"
                >

                    <i
                        class="bi bi-box-seam fs-4 d-block mb-2"
                    ></i>

                    No products added yet.

                </td>

            </tr>

        `;


        this.calculatePurchaseOrderTotals();

        return;

    }


    this.orderItems.forEach(
        (item, index) => {

            const row =
                document.createElement(
                    'tr'
                );


            row.dataset.index =
                index;


            const selectedProduct =
                this.products?.find(
                    product =>
                        Number(
                            product.id
                        ) ===
                        Number(
                            item.product_id
                        )
                );


            const productLabel =
                selectedProduct
                    ? (
                        selectedProduct.product_code
                            ? selectedProduct.product_code +
                              ' - ' +
                              selectedProduct.name
                            : selectedProduct.name
                    )
                    : '';


            row.innerHTML = `

                <td>

                    <div
                        class="position-relative purchase-product-picker"
                    >

                        <div
                            class="input-group input-group-sm"
                        >

                            <span
                                class="input-group-text bg-white"
                            >

                                <i
                                    class="bi bi-search text-muted"
                                ></i>

                            </span>


                            <input
                                type="text"
                                class="form-control purchase-order-product-search"
                                data-index="${index}"
                                value="${this.escapeHtml(
                                    productLabel
                                )}"
                                placeholder="Search product..."
                                autocomplete="off"
                            >


                            <button
                                type="button"
                                class="btn btn-outline-secondary purchase-product-clear"
                                data-index="${index}"
                                title="Clear product"
                            >

                                <i class="bi bi-x"></i>

                            </button>

                        </div>


                        <input
                            type="hidden"
                            class="purchase-order-product"
                            data-index="${index}"
                            value="${item.product_id ?? ''}"
                        >


                        <div
                            class="purchase-product-results shadow-sm"
                            data-index="${index}"
                        ></div>

                    </div>

                </td>


                <td>

                    <input
                        type="number"
                        class="form-control form-control-sm text-end purchase-order-quantity"
                        data-index="${index}"
                        min="0.01"
                        step="0.01"
                        value="${item.quantity ?? 1}"
                    >

                </td>


                <td>

                    <input
                        type="number"
                        class="form-control form-control-sm text-end purchase-order-unit-cost"
                        data-index="${index}"
                        min="0"
                        step="0.01"
                        value="${item.unit_cost ?? 0}"
                    >

                </td>


                <td>

                    <strong
                        class="purchase-order-item-total"
                    >
                        ${this.formatMoney(
                            item.total ?? 0
                        )}
                    </strong>

                </td>


                <td class="text-end">

                    <button
                        type="button"
                        class="btn btn-sm btn-light text-danger purchase-order-remove-item"
                        data-index="${index}"
                        title="Remove"
                    >

                        <i class="bi bi-trash"></i>

                    </button>

                </td>

            `;


            tbody.appendChild(
                row
            );

        }
    );


    this.bindPurchaseOrderItemEvents();

    this.calculatePurchaseOrderTotals();

},

/*
|--------------------------------------------------------------------------
| Search Purchase Order Products
|--------------------------------------------------------------------------
*/

searchPurchaseOrderProducts(
    index,
    search = ''
) {

    const results =
        this.elements.purchaseOrderItems
            ?.querySelector(
                `.purchase-product-results[data-index="${index}"]`
            );


    if (!results) {

        return;

    }


    const term =
        String(
            search
        )
        .trim()
        .toLowerCase();


    /*
    |--------------------------------------------------------------------------
    | Do not display products until user searches
    |--------------------------------------------------------------------------
    */

    if (!term) {

        results.innerHTML = '';

        results.classList.remove(
            'show'
        );

        return;

    }


    const products =
        Array.isArray(
            this.products
        )
            ? this.products
            : [];


    /*
    |--------------------------------------------------------------------------
    | Filter
    |--------------------------------------------------------------------------
    */

    const filtered =
        products
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


                    const barcode =
                        String(
                            product.barcode ?? ''
                        )
                        .toLowerCase();


                    return (
                        name.includes(term) ||
                        code.includes(term) ||
                        sku.includes(term) ||
                        barcode.includes(term)
                    );

                }
            )
            .slice(
                0,
                10
            );


    /*
    |--------------------------------------------------------------------------
    | No Results
    |--------------------------------------------------------------------------
    */

    if (!filtered.length) {

        results.innerHTML = `

            <div
                class="purchase-product-no-results"
            >

                <i
                    class="bi bi-search me-1"
                ></i>

                No products found for
                "<strong>${this.escapeHtml(
                    search
                )}</strong>"

            </div>

        `;


        results.classList.add(
            'show'
        );


        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Render Results
    |--------------------------------------------------------------------------
    */

    results.innerHTML =
        filtered
            .map(
                product => {

                    const selected =
                        Number(
                            this.orderItems[index]
                                ?.product_id
                        ) ===
                        Number(
                            product.id
                        );


                    const productName =
                        product.name ??
                        'Unnamed Product';


                    const productCode =
                        product.product_code ??
                        '';


                    const sku =
                        product.sku ??
                        '';


                    return `

                        <button
                            type="button"
                            class="purchase-product-option ${
                                selected
                                    ? 'active'
                                    : ''
                            }"
                            data-index="${index}"
                            data-product-id="${product.id}"
                        >

                            <div
                                class="purchase-product-option-name"
                            >

                                ${this.escapeHtml(
                                    productName
                                )}

                            </div>


                            <div
                                class="purchase-product-option-meta"
                            >

                                ${
                                    productCode
                                        ? `
                                            <span>
                                                ${this.escapeHtml(
                                                    productCode
                                                )}
                                            </span>
                                        `
                                        : ''
                                }


                                ${
                                    sku
                                        ? `
                                            <span>
                                                SKU:
                                                ${this.escapeHtml(
                                                    sku
                                                )}
                                            </span>
                                        `
                                        : ''
                                }


                                ${
                                    product.cost_price !==
                                    undefined
                                        ? `
                                            <span>
                                                ${this.formatMoney(
                                                    product.cost_price
                                                )}
                                            </span>
                                        `
                                        : ''
                                }

                            </div>

                        </button>

                    `;

                }
            )
            .join('');


    /*
    |--------------------------------------------------------------------------
    | Show Results
    |--------------------------------------------------------------------------
    */

    results.classList.add(
        'show'
    );

},


/*
|--------------------------------------------------------------------------
| Select Purchase Order Product
|--------------------------------------------------------------------------
*/

selectPurchaseOrderProduct(
    index,
    productId
) {

    const product =
        this.products?.find(
            product =>
                Number(
                    product.id
                ) ===
                Number(
                    productId
                )
        );


    if (!product) {

        return;

    }


    const item =
        this.orderItems[index];


    if (!item) {

        return;

    }


    item.product_id =
        Number(
            product.id
        );


    item.unit_cost =
        parseFloat(
            product.cost_price
        ) || 0;


    item.total =
        (
            parseFloat(
                item.quantity
            ) || 0
        ) *
        item.unit_cost;


    this.renderPurchaseOrderItems();

},

/*
|--------------------------------------------------------------------------
| Clear Purchase Order Product
|--------------------------------------------------------------------------
*/

clearPurchaseOrderProduct(
    index
) {

    const item =
        this.orderItems[index];


    if (!item) {

        return;

    }


    item.product_id =
        null;


    item.unit_cost =
        0;


    item.total =
        0;


    this.renderPurchaseOrderItems();

},

    /*
    |--------------------------------------------------------------------------
    | Product Options
    |--------------------------------------------------------------------------
    */

    getProductOptions(
        selectedId = null
    ) {

        if (
            !Array.isArray(
                this.products
            )
        ) {

            return '';

        }


        return this.products
            .map(
                product => {

                    const selected =
                        Number(
                            selectedId
                        ) === Number(
                            product.id
                        )
                            ? 'selected'
                            : '';


                    return `

                        <option
                            value="${product.id}"
                            ${selected}
                        >
                            ${this.escapeHtml(
                                product.product_code
                                    ? product.product_code +
                                    ' - ' +
                                    product.name
                                    : product.name
                            )}
                        </option>

                    `;

                }
            )
            .join('');

    },

    /*
    |--------------------------------------------------------------------------
    | Calculate Purchase Order Item
    |--------------------------------------------------------------------------
    */

    calculatePurchaseOrderItem(
        index
    ) {

        const item =
            this.orderItems[index];


        if (!item) {

            return;

        }


        const quantity =
            parseFloat(
                item.quantity
            ) || 0;


        const unitCost =
            parseFloat(
                item.unit_cost
            ) || 0;


        /*
        |--------------------------------------------------------------------------
        | Calculate Item Total
        |--------------------------------------------------------------------------
        */

        item.total =
            quantity *
            unitCost;


        /*
        |--------------------------------------------------------------------------
        | Update Row Amount
        |--------------------------------------------------------------------------
        */

        const row =
            this.elements.purchaseOrderItems
                ?.querySelector(
                    `tr[data-index="${index}"]`
                );


        if (row) {

            const totalElement =
                row.querySelector(
                    '.purchase-order-item-total'
                );


            if (totalElement) {

                totalElement.textContent =
                    this.formatMoney(
                        item.total
                    );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Update Order Totals
        |--------------------------------------------------------------------------
        */

        this.calculatePurchaseOrderTotals();

    },

    /*
    |--------------------------------------------------------------------------
    | Calculate Purchase Order Totals
    |--------------------------------------------------------------------------
    */

    calculatePurchaseOrderTotals() {

        let subtotal =
            0;


        /*
        |--------------------------------------------------------------------------
        | Calculate Subtotal
        |--------------------------------------------------------------------------
        */

        this.orderItems.forEach(
            item => {

                const quantity =
                    parseFloat(
                        item.quantity
                    ) || 0;


                const unitCost =
                    parseFloat(
                        item.unit_cost
                    ) || 0;


                item.total =
                    quantity *
                    unitCost;


                subtotal +=
                    item.total;

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Discount
        |--------------------------------------------------------------------------
        */

        const discount =
            parseFloat(
                this.elements.orderDiscount?.value
            ) || 0;


        /*
        |--------------------------------------------------------------------------
        | Tax
        |--------------------------------------------------------------------------
        */

        const tax =
            0;


        /*
        |--------------------------------------------------------------------------
        | Total
        |--------------------------------------------------------------------------
        */

        const total =
            Math.max(
                0,
                subtotal -
                discount +
                tax
            );


        /*
        |--------------------------------------------------------------------------
        | Update Subtotal
        |--------------------------------------------------------------------------
        */

        if (
            this.elements.orderSubtotal
        ) {

            this.elements.orderSubtotal.textContent =
                this.formatMoney(
                    subtotal
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Update Tax
        |--------------------------------------------------------------------------
        */

        if (
            this.elements.orderTax
        ) {

            this.elements.orderTax.textContent =
                this.formatMoney(
                    tax
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Update Total
        |--------------------------------------------------------------------------
        */

        if (
            this.elements.orderTotal
        ) {

            this.elements.orderTotal.textContent =
                this.formatMoney(
                    total
                );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Load Suppliers
    |--------------------------------------------------------------------------
    */

    async loadSuppliers()
    {

        /*
        |--------------------------------------------------------------------------
        | The supplier list is loaded from the established
        | supplier endpoint.
        |--------------------------------------------------------------------------
        */

        try {

            const response =
                await fetch(
                    '/purchase/suppliers/options',
                    {
                        headers: {
                            'Accept':
                                'application/json'
                        }
                    }
                );


            if (
                !response.ok
            ) {
                return;
            }


            const result =
                await response.json();


            if (
                !result.success
            ) {
                return;
            }


            const suppliers =
                result.data ?? [];


            this.populateSelect(
                this.elements.ordersSupplierFilter,
                suppliers,
                'All Suppliers'
            );


            this.populateSelect(
                this.elements.goodsReceivedSupplierFilter,
                suppliers,
                'All Suppliers'
            );


            this.populateSelect(
                this.elements.returnsSupplierFilter,
                suppliers,
                'All Suppliers'
            );


            this.populateSelect(
                this.elements.orderSupplier,
                suppliers,
                'Select Supplier'
            );


            this.populateSelect(
                this.elements.goodsReceivedSupplier,
                suppliers,
                'Select Supplier'
            );


            this.populateSelect(
                this.elements.returnSupplier,
                suppliers,
                'Select Supplier'
            );

        }
        catch (error) {

            console.error(
                'Supplier loading failed:',
                error
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Load Branches
    |--------------------------------------------------------------------------
    */

    async loadBranches()
    {

        try {

            const response =
                await fetch(
                    '/purchase/branches/options',
                    {
                        headers: {
                            'Accept':
                                'application/json'
                        }
                    }
                );


            if (
                !response.ok
            ) {
                return;
            }


            const result =
                await response.json();


            if (
                !result.success
            ) {
                return;
            }


            const branches =
                result.data ?? [];


            this.populateSelect(
                this.elements.ordersBranchFilter,
                branches,
                'All Branches'
            );


            this.populateSelect(
                this.elements.goodsReceivedBranchFilter,
                branches,
                'All Branches'
            );


            this.populateSelect(
                this.elements.orderBranch,
                branches,
                'Select Branch'
            );


            this.populateSelect(
                this.elements.goodsReceivedBranch,
                branches,
                'Select Branch'
            );


            this.populateSelect(
                this.elements.returnBranch,
                branches,
                'Select Branch'
            );

        }
        catch (error) {

            console.error(
                'Branch loading failed:',
                error
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Load Products
    |--------------------------------------------------------------------------
    */

    async loadProducts()
    {

        try {

            const response =
                await fetch(
                    '/purchase/products/options',
                    {
                        headers: {
                            'Accept':
                                'application/json'
                        }
                    }
                );


            if (
                !response.ok
            ) {
                return;
            }


            const result =
                await response.json();


            if (
                !result.success
            ) {
                return;
            }


            this.products =
                result.data ?? [];

        }
        catch (error) {

            console.error(
                'Product loading failed:',
                error
            );

            this.products =
                [];

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Populate Select
    |--------------------------------------------------------------------------
    */

    populateSelect(
        select,
        items,
        placeholder
    )
    {

        if (!select) {
            return;
        }


        const currentValue =
            select.value;


        select.innerHTML =
            '';


        const option =
            document.createElement(
                'option'
            );

        option.value =
            '';

        option.textContent =
            placeholder;

        select.appendChild(
            option
        );


        items.forEach(
            item => {

                const itemOption =
                    document.createElement(
                        'option'
                    );

                itemOption.value =
                    item.id;

                itemOption.textContent =
                    item.name ??
                    item.display_name ??
                    item.label ??
                    item.supplier_name ??
                    item.branch_name;

                select.appendChild(
                    itemOption
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
    | Load Purchase Orders
    |--------------------------------------------------------------------------
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


        this.ordersPage =
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
            'supplier_id',
            this.elements.ordersSupplierFilter
        );


        this.appendValue(
            params,
            'branch_id',
            this.elements.ordersBranchFilter
        );


        this.appendValue(
            params,
            'status',
            this.elements.ordersStatusFilter
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
                    `/purchase/orders/table?${params.toString()}`,
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
                    'Unable to load purchase orders.'
                );

            }


            this.elements.ordersTable.innerHTML =
                result.html ?? '';


            if (
                this.elements.ordersPagination
            ) {

                this.elements.ordersPagination.innerHTML =
                    result.pagination ?? '';

            }


            this.updateOrderStats(
                result.stats
            );

        }
        catch (error) {

            this.showTableError(
                this.elements.ordersTable,
                error.message
            );

        }

    },

    /*
    |--------------------------------------------------------------------------
    | Open Purchase Action Menu
    |--------------------------------------------------------------------------
    */

    openPurchaseActionMenu(
        trigger,
        type,
        id,
        reference = ''
    ) {

        const menu =
            this.elements.purchaseActionMenu;


        if (!menu) {

            console.error(
                'Purchase action menu not found.'
            );

            return;

        }


        this.globalActionId =
            id;


        this.globalActionType =
            type;


        /*
        |--------------------------------------------------------------------------
        | Position
        |--------------------------------------------------------------------------
        */

        const rect =
            trigger.getBoundingClientRect();


        menu.style.position =
            'fixed';


        menu.style.top =
            `${rect.bottom + 5}px`;


        menu.style.left =
            `${rect.right - menu.offsetWidth}px`;


        /*
        |--------------------------------------------------------------------------
        | Show
        |--------------------------------------------------------------------------
        */

        menu.classList.add(
            'show'
        );


        /*
        |--------------------------------------------------------------------------
        | Correct Horizontal Position
        |--------------------------------------------------------------------------
        */

        const menuRect =
            menu.getBoundingClientRect();


        if (
            menuRect.right >
            window.innerWidth
        ) {

            menu.style.left =
                `${window.innerWidth - menuRect.width - 10}px`;

        }


        /*
        |--------------------------------------------------------------------------
        | Correct Vertical Position
        |--------------------------------------------------------------------------
        */

        if (
            menuRect.bottom >
            window.innerHeight
        ) {

            menu.style.top =
                `${rect.top - menuRect.height - 5}px`;

        }

    },

    /*
|--------------------------------------------------------------------------
| Close Purchase Action Menu
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'click',
    event => {

        const menu =
            this.elements.purchaseActionMenu;


        if (!menu) {

            return;

        }


        if (
            event.target.closest(
                '.purchase-action-trigger'
            )
        ) {

            return;

        }


        if (
            event.target.closest(
                '#purchaseActionMenu'
            )
        ) {

            return;

        }


        menu.classList.remove(
            'show'
        );

    }
);

    /*
    |--------------------------------------------------------------------------
    | Open Create Purchase Order
    |--------------------------------------------------------------------------
    */

    openCreateOrder()
    {

        this.editingOrderId =
            null;

        this.selectedOrder =
            null;

        this.orderItems =
            [];


        this.resetOrderForm();


        const modalElement =
            this.elements.purchaseOrderModal;


        if (!modalElement) {

            console.error(
                'Purchase Order modal not found.'
            );

            return;

        }


        const modal =
            bootstrap.Modal.getOrCreateInstance(
                modalElement
            );


        modal.show();

    },


    /*
    |--------------------------------------------------------------------------
    | Load Goods Received
    |--------------------------------------------------------------------------
    */

    async loadGoodsReceived(
        page = 1
    )
    {

        if (
            !this.elements.goodsReceivedTable
        ) {
            return;
        }


        this.goodsReceivedPage =
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
            this.elements.goodsReceivedSearch
        );


        this.appendValue(
            params,
            'supplier_id',
            this.elements.goodsReceivedSupplierFilter
        );


        this.appendValue(
            params,
            'branch_id',
            this.elements.goodsReceivedBranchFilter
        );


        this.appendValue(
            params,
            'status',
            this.elements.goodsReceivedStatusFilter
        );


        this.appendValue(
            params,
            'date_from',
            this.elements.goodsReceivedDateFrom
        );


        this.appendValue(
            params,
            'date_to',
            this.elements.goodsReceivedDateTo
        );


        this.showTableLoading(
            this.elements.goodsReceivedTable
        );


        try {

            const response =
                await fetch(
                    `/purchase/goods-received/table?${params.toString()}`,
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
                    'Unable to load goods received.'
                );

            }


            this.elements.goodsReceivedTable.innerHTML =
                result.html ?? '';


            if (
                this.elements.goodsReceivedPagination
            ) {

                this.elements.goodsReceivedPagination.innerHTML =
                    result.pagination ?? '';

            }


            this.updateGoodsReceivedStats(
                result.stats
            );

        }
        catch (error) {

            this.showTableError(
                this.elements.goodsReceivedTable,
                error.message
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Load Purchase Returns
    |--------------------------------------------------------------------------
    */

    async loadReturns(
        page = 1
    )
    {

        if (
            !this.elements.returnsTable
        ) {
            return;
        }


        this.returnsPage =
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
            this.elements.returnsSearch
        );


        this.appendValue(
            params,
            'supplier_id',
            this.elements.returnsSupplierFilter
        );


        this.appendValue(
            params,
            'branch_id',
            this.elements.returnsBranchFilter
        );


        this.appendValue(
            params,
            'status',
            this.elements.returnsStatusFilter
        );


        this.appendValue(
            params,
            'date_from',
            this.elements.returnsDateFrom
        );


        this.appendValue(
            params,
            'date_to',
            this.elements.returnsDateTo
        );


        this.showTableLoading(
            this.elements.returnsTable
        );


        try {

            const response =
                await fetch(
                    `/purchase/returns/table?${params.toString()}`,
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
                    'Unable to load purchase returns.'
                );

            }


            this.elements.returnsTable.innerHTML =
                result.html ?? '';


            if (
                this.elements.returnsPagination
            ) {

                this.elements.returnsPagination.innerHTML =
                    result.pagination ?? '';

            }


            this.updateReturnStats(
                result.stats
            );

        }
        catch (error) {

            this.showTableError(
                this.elements.returnsTable,
                error.message
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Append Value
    |--------------------------------------------------------------------------
    */

    appendValue(
        params,
        key,
        element
    )
    {

        if (
            element?.value
        ) {

            params.set(
                key,
                element.value
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Update Order Stats
    |--------------------------------------------------------------------------
    */

    updateOrderStats(
        stats
    )
    {

        if (!stats) {
            return;
        }


        this.setText(
            'purchaseOrderCount',
            stats.orders ??
            stats.total ??
            0
        );


        this.setText(
            'purchaseOrderPending',
            stats.pending ??
            0
        );


        this.setText(
            'purchaseOrderApproved',
            stats.approved ??
            0
        );


        this.setText(
            'purchaseOrderValue',
            this.formatMoney(
                stats.value ??
                stats.total_value ??
                0
            )
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Update Goods Received Stats
    |--------------------------------------------------------------------------
    */

    updateGoodsReceivedStats(
        stats
    )
    {

        if (!stats) {
            return;
        }


        this.setText(
            'goodsReceivedCount',
            stats.received ??
            stats.total ??
            0
        );


        this.setText(
            'goodsReceivedPending',
            stats.pending ??
            0
        );


        this.setText(
            'goodsReceivedCompleted',
            stats.completed ??
            0
        );


        this.setText(
            'goodsReceivedValue',
            this.formatMoney(
                stats.value ??
                stats.total_value ??
                0
            )
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Update Return Stats
    |--------------------------------------------------------------------------
    */

    updateReturnStats(
        stats
    )
    {

        if (!stats) {
            return;
        }


        this.setText(
            'purchaseReturnCount',
            stats.returns ??
            stats.total ??
            0
        );


        this.setText(
            'purchaseReturnPending',
            stats.pending ??
            0
        );


        this.setText(
            'purchaseReturnCompleted',
            stats.completed ??
            0
        );


        this.setText(
            'purchaseReturnValue',
            this.formatMoney(
                stats.value ??
                stats.total_value ??
                0
            )
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Handle Action
    |--------------------------------------------------------------------------
    */

    handleAction(
        element
    )
    {

        const action =
            element.dataset.purchaseAction;


        const id =
            element.dataset.id;


        if (!action) {
            return;
        }


        switch (
            action
        ) {

            case 'view-order':

                this.openOrderInspector(
                    id
                );

                break;


            case 'edit-order':

                this.openOrderModal(
                    id
                );

                break;


            case 'delete-order':

                this.openConfirmation(
                    'delete-order',
                    id
                );

                break;


            case 'approve-order':

                this.openConfirmation(
                    'approve-order',
                    id
                );

                break;


            case 'view-goods-received':

                this.openGoodsReceivedInspector(
                    id
                );

                break;


            case 'edit-goods-received':

                this.openGoodsReceivedModal(
                    id
                );

                break;


            case 'delete-goods-received':

                this.openConfirmation(
                    'delete-goods-received',
                    id
                );

                break;


            case 'view-return':

                this.openReturnInspector(
                    id
                );

                break;


            case 'edit-return':

                this.openReturnModal(
                    id
                );

                break;


            case 'delete-return':

                this.openConfirmation(
                    'delete-return',
                    id
                );

                break;


            case 'process-return':

                this.openConfirmation(
                    'process-return',
                    id
                );

                break;


            case 'receive-order':

                this.openGoodsReceivedModal(
                    null,
                    id
                );

                break;

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Open Order Inspector
    |--------------------------------------------------------------------------
    */

    async openOrderInspector(
        id
    )
    {

        if (
            !this.orderInspectorInstance
        ) {
            return;
        }


        this.showInspectorLoading(
            this.elements.orderInspectorContent
        );


        this.orderInspectorInstance.show();


        try {

            const response =
                await fetch(
                    `/purchase/orders/${id}/details`,
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
                    'Unable to load purchase order.'
                );

            }


            this.renderOrderInspector(
                result.data
            );

        }
        catch (error) {

            this.showInspectorError(
                this.elements.orderInspectorContent,
                error.message
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Render Order Inspector
    |--------------------------------------------------------------------------
    */

    renderOrderInspector(
        order
    )
    {

        const items =
            order.items ?? [];


        const itemsHtml =
            items.map(
                item => `

                    <div class="d-flex justify-content-between
                        align-items-start py-3 border-bottom">

                        <div>

                            <div class="fw-semibold">

                                ${this.escapeHtml(
                                    item.product_name ??
                                    item.product?.name ??
                                    '—'
                                )}

                            </div>

                            <div class="text-muted small">

                                Qty:
                                ${this.formatNumber(
                                    item.quantity
                                )}

                                ×

                                ${this.formatMoney(
                                    item.unit_cost
                                )}

                            </div>

                        </div>

                        <div class="fw-semibold">

                            ${this.formatMoney(
                                item.total ??
                                (
                                    Number(item.quantity ?? 0) *
                                    Number(item.unit_cost ?? 0)
                                )
                            )}

                        </div>

                    </div>

                `
            )
            .join('');


        this.elements.orderInspectorContent.innerHTML = `

            <div class="p-4">

                <div class="mb-4">

                    <div class="text-muted small mb-1">
                        Purchase Order
                    </div>

                    <h4 class="fw-semibold mb-1">

                        ${this.escapeHtml(
                            order.order_no ??
                            order.purchase_order_no ??
                            '—'
                        )}

                    </h4>

                    <span class="badge ${this.statusBadge(
                        order.status
                    )}">

                        ${this.escapeHtml(
                            order.status_label ??
                            order.status ??
                            '—'
                        )}

                    </span>

                </div>


                <div class="row g-3 mb-4">

                    ${this.inspectorInfo(
                        'Supplier',
                        order.supplier?.name ??
                        order.supplier_name
                    )}

                    ${this.inspectorInfo(
                        'Branch',
                        order.branch?.name ??
                        order.branch_name
                    )}

                    ${this.inspectorInfo(
                        'Order Date',
                        order.order_date
                    )}

                    ${this.inspectorInfo(
                        'Expected Date',
                        order.expected_date
                    )}

                </div>


                <div class="mb-4">

                    <h6 class="fw-semibold mb-2">
                        Order Items
                    </h6>

                    ${itemsHtml || `
                        <div class="text-muted small py-3">
                            No items found.
                        </div>
                    `}

                </div>


                <div class="border rounded-3 p-3">

                    <div class="d-flex justify-content-between mb-2">

                        <span class="text-muted">
                            Subtotal
                        </span>

                        <span>
                            ${this.formatMoney(
                                order.subtotal
                            )}
                        </span>

                    </div>


                    <div class="d-flex justify-content-between mb-2">

                        <span class="text-muted">
                            Tax
                        </span>

                        <span>
                            ${this.formatMoney(
                                order.tax
                            )}
                        </span>

                    </div>


                    <div class="d-flex justify-content-between
                        fw-semibold pt-2 border-top">

                        <span>
                            Total
                        </span>

                        <span>
                            ${this.formatMoney(
                                order.total
                            )}
                        </span>

                    </div>

                </div>

            </div>

        `;

    },


    /*
    |--------------------------------------------------------------------------
    | Open Goods Received Inspector
    |--------------------------------------------------------------------------
    */

    async openGoodsReceivedInspector(
        id
    )
    {

        if (
            !this.goodsReceivedInspectorInstance
        ) {
            return;
        }


        this.showInspectorLoading(
            this.elements.goodsReceivedInspectorContent
        );


        this.goodsReceivedInspectorInstance.show();


        try {

            const response =
                await fetch(
                    `/purchase/goods-received/${id}/details`,
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
                    'Unable to load goods received.'
                );

            }


            this.renderGoodsReceivedInspector(
                result.data
            );

        }
        catch (error) {

            this.showInspectorError(
                this.elements.goodsReceivedInspectorContent,
                error.message
            );

        }

    },

    /*
|--------------------------------------------------------------------------
| Show Initial Purchase Order Products
|--------------------------------------------------------------------------
*/

showInitialPurchaseOrderProducts(
    index
) {

    const results =
        this.elements.purchaseOrderItems
            ?.querySelector(
                `.purchase-product-results[data-index="${index}"]`
            );


    if (!results) {

        return;

    }


    const products =
        Array.isArray(
            this.products
        )
            ? this.products
            : [];


    /*
    |--------------------------------------------------------------------------
    | Limit initial products
    |--------------------------------------------------------------------------
    */

    const initialProducts =
        products.slice(
            0,
            5
        );


    if (!initialProducts.length) {

        results.innerHTML = `

            <div
                class="purchase-product-no-results"
            >

                <i
                    class="bi bi-box-seam me-1"
                ></i>

                No products available.

            </div>

        `;

        results.classList.add(
            'show'
        );

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    results.innerHTML =
        initialProducts
            .map(
                product => {

                    const productName =
                        product.name ??
                        'Unnamed Product';


                    const productCode =
                        product.product_code ??
                        '';


                    const sku =
                        product.sku ??
                        '';


                    return `

                        <button
                            type="button"
                            class="purchase-product-option"
                            data-index="${index}"
                            data-product-id="${product.id}"
                        >

                            <div
                                class="purchase-product-option-name"
                            >

                                ${this.escapeHtml(
                                    productName
                                )}

                            </div>


                            <div
                                class="purchase-product-option-meta"
                            >

                                ${
                                    productCode
                                        ? `
                                            <span>
                                                ${this.escapeHtml(
                                                    productCode
                                                )}
                                            </span>
                                        `
                                        : ''
                                }


                                ${
                                    sku
                                        ? `
                                            <span>
                                                SKU:
                                                ${this.escapeHtml(
                                                    sku
                                                )}
                                            </span>
                                        `
                                        : ''
                                }


                                ${
                                    product.cost_price !==
                                    undefined
                                        ? `
                                            <span>
                                                ${this.formatMoney(
                                                    product.cost_price
                                                )}
                                            </span>
                                        `
                                        : ''
                                }

                            </div>

                        </button>

                    `;

                }
            )
            .join('');


    results.classList.add(
        'show'
    );

},


    /*
    |--------------------------------------------------------------------------
    | Render Goods Received Inspector
    |--------------------------------------------------------------------------
    */

    renderGoodsReceivedInspector(
        record
    )
    {

        const items =
            record.items ?? [];


        this.elements.goodsReceivedInspectorContent.innerHTML = `

            <div class="p-4">

                <div class="mb-4">

                    <div class="text-muted small">
                        Goods Received
                    </div>

                    <h4 class="fw-semibold">

                        ${this.escapeHtml(
                            record.receipt_no ??
                            record.reference_no ??
                            '—'
                        )}

                    </h4>

                    <span class="badge ${this.statusBadge(
                        record.status
                    )}">

                        ${this.escapeHtml(
                            record.status_label ??
                            record.status ??
                            '—'
                        )}

                    </span>

                </div>


                <div class="row g-3 mb-4">

                    ${this.inspectorInfo(
                        'Purchase Order',
                        record.purchase_order?.order_no ??
                        record.purchase_order_no
                    )}

                    ${this.inspectorInfo(
                        'Supplier',
                        record.supplier?.name ??
                        record.supplier_name
                    )}

                    ${this.inspectorInfo(
                        'Branch',
                        record.branch?.name ??
                        record.branch_name
                    )}

                    ${this.inspectorInfo(
                        'Received Date',
                        record.received_date
                    )}

                </div>


                <div>

                    <h6 class="fw-semibold mb-3">
                        Received Items
                    </h6>

                    ${items.map(
                        item => `

                            <div class="d-flex justify-content-between
                                py-3 border-bottom">

                                <div>

                                    <div class="fw-semibold">

                                        ${this.escapeHtml(
                                            item.product_name ??
                                            item.product?.name ??
                                            '—'
                                        )}

                                    </div>

                                    <div class="small text-muted">

                                        Received:
                                        ${this.formatNumber(
                                            item.quantity
                                        )}

                                    </div>

                                </div>

                                <div class="fw-semibold">

                                    ${this.formatMoney(
                                        item.total ??
                                        (
                                            Number(item.quantity ?? 0) *
                                            Number(item.unit_cost ?? 0)
                                        )
                                    )}

                                </div>

                            </div>

                        `
                    ).join('')}

                </div>


                <div class="d-flex justify-content-between
                    fw-semibold mt-4">

                    <span>Total</span>

                    <span>
                        ${this.formatMoney(
                            record.total
                        )}
                    </span>

                </div>

            </div>

        `;

    },


    /*
    |--------------------------------------------------------------------------
    | Open Return Inspector
    |--------------------------------------------------------------------------
    */

    async openReturnInspector(
        id
    )
    {

        if (
            !this.returnInspectorInstance
        ) {
            return;
        }


        this.showInspectorLoading(
            this.elements.returnInspectorContent
        );


        this.returnInspectorInstance.show();


        try {

            const response =
                await fetch(
                    `/purchase/returns/${id}/details`,
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
                    'Unable to load purchase return.'
                );

            }


            this.renderReturnInspector(
                result.data
            );

        }
        catch (error) {

            this.showInspectorError(
                this.elements.returnInspectorContent,
                error.message
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Render Return Inspector
    |--------------------------------------------------------------------------
    */

    renderReturnInspector(
        record
    )
    {

        const items =
            record.items ?? [];


        this.elements.returnInspectorContent.innerHTML = `

            <div class="p-4">

                <div class="mb-4">

                    <div class="text-muted small">
                        Purchase Return
                    </div>

                    <h4 class="fw-semibold">

                        ${this.escapeHtml(
                            record.return_no ??
                            record.reference_no ??
                            '—'
                        )}

                    </h4>

                    <span class="badge ${this.statusBadge(
                        record.status
                    )}">

                        ${this.escapeHtml(
                            record.status_label ??
                            record.status ??
                            '—'
                        )}

                    </span>

                </div>


                <div class="row g-3 mb-4">

                    ${this.inspectorInfo(
                        'Purchase Order',
                        record.purchase_order?.order_no ??
                        record.purchase_order_no
                    )}

                    ${this.inspectorInfo(
                        'Supplier',
                        record.supplier?.name ??
                        record.supplier_name
                    )}

                    ${this.inspectorInfo(
                        'Branch',
                        record.branch?.name ??
                        record.branch_name
                    )}

                    ${this.inspectorInfo(
                        'Return Date',
                        record.return_date
                    )}

                </div>


                <div>

                    <h6 class="fw-semibold mb-3">
                        Returned Items
                    </h6>

                    ${items.map(
                        item => `

                            <div class="d-flex justify-content-between
                                py-3 border-bottom">

                                <div>

                                    <div class="fw-semibold">

                                        ${this.escapeHtml(
                                            item.product_name ??
                                            item.product?.name ??
                                            '—'
                                        )}

                                    </div>

                                    <div class="small text-muted">

                                        Qty:
                                        ${this.formatNumber(
                                            item.quantity
                                        )}

                                    </div>

                                </div>

                                <div class="fw-semibold">

                                    ${this.formatMoney(
                                        item.total ??
                                        (
                                            Number(item.quantity ?? 0) *
                                            Number(item.unit_cost ?? 0)
                                        )
                                    )}

                                </div>

                            </div>

                        `
                    ).join('')}

                </div>


                <div class="d-flex justify-content-between
                    fw-semibold mt-4">

                    <span>Total</span>

                    <span>
                        ${this.formatMoney(
                            record.total
                        )}
                    </span>

                </div>

            </div>

        `;

    },


    /*
    |--------------------------------------------------------------------------
    | Open Order Modal
    |--------------------------------------------------------------------------
    */

    async openOrderModal(
        id = null
    )
    {

        this.resetOrderForm();


        if (!id) {

            this.editingOrderId =
                null;

            this.setOrderModalTitle(
                'Create Purchase Order'
            );

            this.orderModalInstance?.show();

            return;

        }


        try {

            const response =
                await fetch(
                    `/purchase/orders/${id}/details`,
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
                    'Unable to load purchase order.'
                );

            }


            const order =
                result.data;


            this.editingOrderId =
                id;


            this.populateOrderForm(
                order
            );


            this.setOrderModalTitle(
                'Edit Purchase Order'
            );


            this.orderModalInstance?.show();

        }
        catch (error) {

            this.notify(
                error.message,
                'error'
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Populate Order Form
    |--------------------------------------------------------------------------
    */

    populateOrderForm(
        order
    )
    {

        this.setValue(
            this.elements.orderId,
            order.id
        );

        this.setValue(
            this.elements.orderSupplier,
            order.supplier_id
        );

        this.setValue(
            this.elements.orderBranch,
            order.branch_id
        );

        this.setValue(
            this.elements.orderDate,
            order.order_date
        );

        this.setValue(
            this.elements.orderExpectedDate,
            order.expected_date
        );

        this.setValue(
            this.elements.orderReference,
            order.reference_no
        );

        this.setValue(
            this.elements.orderNotes,
            order.notes
        );


        this.orderItems =
            (order.items ?? []).map(
                item => ({

                    id:
                        item.id ?? null,

                    product_id:
                        item.product_id,

                    quantity:
                        Number(
                            item.quantity ?? 0
                        ),

                    unit_cost:
                        Number(
                            item.unit_cost ?? 0
                        ),

                    tax_rate:
                        Number(
                            item.tax_rate ?? 0
                        ),

                    discount:
                        Number(
                            item.discount ?? 0
                        ),

                })
            );


        this.renderOrderItems();

    },


    /*
    |--------------------------------------------------------------------------
    | Reset Order Form
    |--------------------------------------------------------------------------
    */

    resetOrderForm()
    {

        this.elements.orderForm?.reset();


        this.editingOrderId =
            null;


        this.orderItems =
            [];


        if (
            this.elements.orderItemsContainer
        ) {

            this.elements.orderItemsContainer.innerHTML =
                '';

        }


        this.clearValidation(
            this.elements.orderForm
        );


        this.updateOrderTotals();

    },


    /*
    |--------------------------------------------------------------------------
    | Add Order Item
    |--------------------------------------------------------------------------
    */

    addOrderItem()
    {

        this.orderItems.push({

            id:
                null,

            product_id:
                '',

            quantity:
                1,

            unit_cost:
                0,

            tax_rate:
                0,

            discount:
                0,

        });


        this.renderOrderItems();

    },


    /*
    |--------------------------------------------------------------------------
    | Render Order Items
    |--------------------------------------------------------------------------
    */

    renderOrderItems()
    {

        if (
            !this.elements.orderItemsContainer
        ) {
            return;
        }


        this.elements.orderItemsContainer.innerHTML =
            '';


        this.orderItems.forEach(
            (item, index) => {

                const row =
                    document.createElement(
                        'div'
                    );


                row.className =
                    'purchase-item-row border rounded-3 p-3 mb-3';


                row.dataset.index =
                    index;


                row.innerHTML = `

                    <div class="row g-3 align-items-end">

                        <div class="col-lg-5">

                            <label class="form-label">
                                Product
                            </label>

                            <select
                                class="form-select"
                                data-order-field="product_id"
                                data-index="${index}"
                            >

                                <option value="">
                                    Select Product
                                </option>

                                ${this.products.map(
                                    product => `

                                        <option
                                            value="${product.id}"
                                            ${String(product.id) === String(item.product_id)
                                                ? 'selected'
                                                : ''
                                            }
                                        >

                                            ${this.escapeHtml(
                                                product.name ??
                                                product.display_name
                                            )}

                                        </option>

                                    `
                                ).join('')}

                            </select>

                        </div>


                        <div class="col-lg-2">

                            <label class="form-label">
                                Quantity
                            </label>

                            <input
                                type="number"
                                min="0.01"
                                step="0.01"
                                class="form-control"
                                value="${item.quantity}"
                                data-order-field="quantity"
                                data-index="${index}"
                            >

                        </div>


                        <div class="col-lg-2">

                            <label class="form-label">
                                Unit Cost
                            </label>

                            <input
                                type="number"
                                min="0"
                                step="0.01"
                                class="form-control"
                                value="${item.unit_cost}"
                                data-order-field="unit_cost"
                                data-index="${index}"
                            >

                        </div>


                        <div class="col-lg-2">

                            <label class="form-label">
                                Total
                            </label>

                            <div
                                class="form-control bg-light"
                                data-order-item-total="${index}"
                            >
                                ${this.formatMoney(
                                    this.itemTotal(item)
                                )}
                            </div>

                        </div>


                        <div class="col-lg-1">

                            <button
                                type="button"
                                class="btn btn-outline-danger"
                                data-remove-order-item="${index}"
                            >

                                <i class="bi bi-trash"></i>

                            </button>

                        </div>

                    </div>

                `;


                this.elements.orderItemsContainer.appendChild(
                    row
                );

            }
        );


        this.bindOrderItemEvents();

        this.updateOrderTotals();

    },


    /*
    |--------------------------------------------------------------------------
    | Bind Order Item Events
    |--------------------------------------------------------------------------
    */

    bindOrderItemEvents()
    {

        this.elements.orderItemsContainer
            ?.querySelectorAll(
                '[data-order-field]'
            )
            .forEach(
                field => {

                    field.addEventListener(
                        'input',
                        () => {

                            this.updateOrderItem(
                                field
                            );

                        }
                    );


                    field.addEventListener(
                        'change',
                        () => {

                            this.updateOrderItem(
                                field
                            );

                        }
                    );

                }
            );


        this.elements.orderItemsContainer
            ?.querySelectorAll(
                '[data-remove-order-item]'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            const index =
                                Number(
                                    button.dataset.removeOrderItem
                                );


                            this.orderItems.splice(
                                index,
                                1
                            );


                            this.renderOrderItems();

                        }
                    );

                }
            );

    },


    /*
    |--------------------------------------------------------------------------
    | Update Order Item
    |--------------------------------------------------------------------------
    */

    updateOrderItem(
        field
    )
    {

        const index =
            Number(
                field.dataset.index
            );


        const property =
            field.dataset.orderField;


        if (
            !this.orderItems[index]
        ) {
            return;
        }


        this.orderItems[index][property] =
            property === 'product_id'
                ? field.value
                : Number(
                    field.value || 0
                );


        const totalElement =
            this.elements.orderItemsContainer
                ?.querySelector(
                    `[data-order-item-total="${index}"]`
                );


        if (totalElement) {

            totalElement.textContent =
                this.formatMoney(
                    this.itemTotal(
                        this.orderItems[index]
                    )
                );

        }


        this.updateOrderTotals();

    },


    /*
|--------------------------------------------------------------------------
| Save Purchase Order
|--------------------------------------------------------------------------
*/

async saveOrder()
{

    this.clearValidation(
        this.elements.orderForm
    );


    /*
    |--------------------------------------------------------------------------
    | Validate Items
    |--------------------------------------------------------------------------
    */

    if (
        this.orderItems.length === 0
    ) {

        this.notify(
            'Add at least one product to the purchase order.',
            'error'
        );

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Form Data
    |--------------------------------------------------------------------------
    */

    const formData =
        new FormData(
            this.elements.orderForm
        );

    /*
    |--------------------------------------------------------------------------
    | Purchase Order Items
    |--------------------------------------------------------------------------
    */

    this.orderItems.forEach(
        (item, index) => {

            formData.append(
                `items[${index}][product_id]`,
                item.product_id ?? ''
            );


            formData.append(
                `items[${index}][quantity]`,
                item.quantity ?? 0
            );


            formData.append(
                `items[${index}][unit_cost]`,
                item.unit_cost ?? 0
            );


            formData.append(
                `items[${index}][total]`,
                item.total ?? 0
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Edit Mode
    |--------------------------------------------------------------------------
    */

    const isEdit =
        !!this.editingOrderId;


    const url =
        isEdit
            ? `/purchase/orders/${this.editingOrderId}`
            : '/purchase/orders';


    if (isEdit) {

        formData.append(
            '_method',
            'PUT'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CSRF Token
    |--------------------------------------------------------------------------
    */

    const csrfToken =
        document
            .querySelector(
                'meta[name="csrf-token"]'
            )
            ?.getAttribute(
                'content'
            );


    /*
    |--------------------------------------------------------------------------
    | Request
    |--------------------------------------------------------------------------
    */

    try {

        this.setButtonLoading(
            this.elements.orderForm
                ?.querySelector(
                    '[type="submit"]'
                ),
            true
        );


        const response =
            await fetch(
                url,
                {
                    method:
                        'POST',

                    headers: {

                        'Accept':
                            'application/json',

                        'X-CSRF-TOKEN':
                            csrfToken,

                    },

                    body:
                        formData
                }
            );


        const result =
            await response.json();


        /*
        |--------------------------------------------------------------------------
        | Handle Error
        |--------------------------------------------------------------------------
        */

        if (
            !response.ok ||
            !result.success
        ) {

            this.handleFormError(
                result,
                this.elements.orderForm
            );

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Close Modal
        |--------------------------------------------------------------------------
        */

        this.orderModalInstance?.hide();


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        this.notify(
            result.message ??
            'Purchase order saved successfully.',
            'success'
        );


        /*
        |--------------------------------------------------------------------------
        | Refresh Orders
        |--------------------------------------------------------------------------
        */

        await this.loadOrders(
            1
        );

    }
    catch (error) {

        console.error(
            'Purchase Order Save Error:',
            error
        );


        this.notify(
            error.message ??
            'Unable to save purchase order.',
            'error'
        );

    }
    finally {

        this.setButtonLoading(
            this.elements.orderForm
                ?.querySelector(
                    '[type="submit"]'
                ),
            false
        );

    }

},


    /*
    |--------------------------------------------------------------------------
    | Open Goods Received Modal
    |--------------------------------------------------------------------------
    */

    async openGoodsReceivedModal(
        id = null,
        orderId = null
    )
    {

        this.resetGoodsReceivedForm();


        if (
            orderId
        ) {

            this.setValue(
                this.elements.goodsReceivedOrder,
                orderId
            );

        }


        if (!id) {

            this.editingGoodsReceivedId =
                null;

            this.setModalTitle(
                this.elements.goodsReceivedModal,
                'Record Goods Received'
            );

            this.goodsReceivedModalInstance?.show();

            return;

        }


        try {

            const response =
                await fetch(
                    `/purchase/goods-received/${id}/details`,
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
                    'Unable to load goods received.'
                );

            }


            this.editingGoodsReceivedId =
                id;


            this.populateGoodsReceivedForm(
                result.data
            );


            this.setModalTitle(
                this.elements.goodsReceivedModal,
                'Edit Goods Received'
            );


            this.goodsReceivedModalInstance?.show();

        }
        catch (error) {

            this.notify(
                error.message,
                'error'
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Reset Goods Received Form
    |--------------------------------------------------------------------------
    */

    resetGoodsReceivedForm()
    {

        this.elements.goodsReceivedForm?.reset();


        this.editingGoodsReceivedId =
            null;


        this.receivedItems =
            [];


        if (
            this.elements.goodsReceivedItemsContainer
        ) {

            this.elements.goodsReceivedItemsContainer.innerHTML =
                '';

        }


        this.clearValidation(
            this.elements.goodsReceivedForm
        );


        this.updateGoodsReceivedTotal();

    },


    /*
    |--------------------------------------------------------------------------
    | Populate Goods Received Form
    |--------------------------------------------------------------------------
    */

    populateGoodsReceivedForm(
        record
    )
    {

        this.setValue(
            this.elements.goodsReceivedId,
            record.id
        );

        this.setValue(
            this.elements.goodsReceivedOrder,
            record.purchase_order_id
        );

        this.setValue(
            this.elements.goodsReceivedSupplier,
            record.supplier_id
        );

        this.setValue(
            this.elements.goodsReceivedBranch,
            record.branch_id
        );

        this.setValue(
            this.elements.goodsReceivedDate,
            record.received_date
        );

        this.setValue(
            this.elements.goodsReceivedReference,
            record.reference_no
        );

        this.setValue(
            this.elements.goodsReceivedNotes,
            record.notes
        );


        this.receivedItems =
            record.items ?? [];


        this.renderReceivedItems();

    },


    /*
    |--------------------------------------------------------------------------
    | Add Received Item
    |--------------------------------------------------------------------------
    */

    addReceivedItem()
    {

        this.receivedItems.push({

            id:
                null,

            product_id:
                '',

            quantity:
                1,

            unit_cost:
                0,

        });


        this.renderReceivedItems();

    },


    /*
    |--------------------------------------------------------------------------
    | Render Received Items
    |--------------------------------------------------------------------------
    */

    renderReceivedItems()
    {

        if (
            !this.elements.goodsReceivedItemsContainer
        ) {
            return;
        }


        this.elements.goodsReceivedItemsContainer.innerHTML =
            '';


        this.receivedItems.forEach(
            (item, index) => {

                const row =
                    document.createElement(
                        'div'
                    );


                row.className =
                    'purchase-item-row border rounded-3 p-3 mb-3';


                row.innerHTML = `

                    <div class="row g-3 align-items-end">

                        <div class="col-lg-6">

                            <label class="form-label">
                                Product
                            </label>

                            <select
                                class="form-select"
                                data-received-field="product_id"
                                data-index="${index}"
                            >

                                <option value="">
                                    Select Product
                                </option>

                                ${this.products.map(
                                    product => `

                                        <option
                                            value="${product.id}"
                                            ${String(product.id) === String(item.product_id)
                                                ? 'selected'
                                                : ''
                                            }
                                        >

                                            ${this.escapeHtml(
                                                product.name ??
                                                product.display_name
                                            )}

                                        </option>

                                    `
                                ).join('')}

                            </select>

                        </div>


                        <div class="col-lg-2">

                            <label class="form-label">
                                Quantity
                            </label>

                            <input
                                type="number"
                                min="0.01"
                                step="0.01"
                                class="form-control"
                                value="${item.quantity ?? 0}"
                                data-received-field="quantity"
                                data-index="${index}"
                            >

                        </div>


                        <div class="col-lg-2">

                            <label class="form-label">
                                Unit Cost
                            </label>

                            <input
                                type="number"
                                min="0"
                                step="0.01"
                                class="form-control"
                                value="${item.unit_cost ?? 0}"
                                data-received-field="unit_cost"
                                data-index="${index}"
                            >

                        </div>


                        <div class="col-lg-2">

                            <button
                                type="button"
                                class="btn btn-outline-danger w-100"
                                data-remove-received-item="${index}"
                            >

                                <i class="bi bi-trash"></i>

                            </button>

                        </div>

                    </div>

                `;


                this.elements.goodsReceivedItemsContainer.appendChild(
                    row
                );

            }
        );


        this.elements.goodsReceivedItemsContainer
            .querySelectorAll(
                '[data-received-field]'
            )
            .forEach(
                field => {

                    field.addEventListener(
                        'input',
                        () => {

                            this.updateReceivedItem(
                                field
                            );

                        }
                    );


                    field.addEventListener(
                        'change',
                        () => {

                            this.updateReceivedItem(
                                field
                            );

                        }
                    );

                }
            );


        this.elements.goodsReceivedItemsContainer
            .querySelectorAll(
                '[data-remove-received-item]'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            const index =
                                Number(
                                    button.dataset.removeReceivedItem
                                );


                            this.receivedItems.splice(
                                index,
                                1
                            );


                            this.renderReceivedItems();

                        }
                    );

                }
            );


        this.updateGoodsReceivedTotal();

    },


    /*
    |--------------------------------------------------------------------------
    | Update Received Item
    |--------------------------------------------------------------------------
    */

    updateReceivedItem(
        field
    )
    {

        const index =
            Number(
                field.dataset.index
            );


        const property =
            field.dataset.receivedField;


        if (
            !this.receivedItems[index]
        ) {
            return;
        }


        this.receivedItems[index][property] =
            property === 'product_id'
                ? field.value
                : Number(
                    field.value || 0
                );


        this.updateGoodsReceivedTotal();

    },


    /*
    |--------------------------------------------------------------------------
    | Save Goods Received
    |--------------------------------------------------------------------------
    */

    async saveGoodsReceived()
    {

        this.clearValidation(
            this.elements.goodsReceivedForm
        );


        if (
            this.receivedItems.length === 0
        ) {

            this.notify(
                'Add at least one received product.',
                'error'
            );

            return;

        }


        const formData =
            new FormData(
                this.elements.goodsReceivedForm
            );


        formData.append(
            'items',
            JSON.stringify(
                this.receivedItems
            )
        );


        const isEdit =
            !!this.editingGoodsReceivedId;


        const url =
            isEdit
                ? `/purchase/goods-received/${this.editingGoodsReceivedId}`
                : '/purchase/goods-received';


        if (isEdit) {

            formData.append(
                '_method',
                'PUT'
            );

        }


        try {

            const response =
                await fetch(
                    url,
                    {
                        method:
                            'POST',

                        body:
                            formData,

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

                this.handleFormError(
                    result,
                    this.elements.goodsReceivedForm
                );

                return;

            }


            this.goodsReceivedModalInstance?.hide();


            this.notify(
                result.message ??
                'Goods received saved successfully.',
                'success'
            );


            await this.loadGoodsReceived(
                1
            );

        }
        catch (error) {

            this.notify(
                error.message,
                'error'
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Open Purchase Return Modal
    |--------------------------------------------------------------------------
    */

    async openReturnModal(
        id = null
    )
    {

        this.resetReturnForm();


        if (!id) {

            this.editingReturnId =
                null;

            this.setModalTitle(
                this.elements.returnModal,
                'Create Purchase Return'
            );

            this.returnModalInstance?.show();

            return;

        }


        try {

            const response =
                await fetch(
                    `/purchase/returns/${id}/details`,
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
                    'Unable to load purchase return.'
                );

            }


            this.editingReturnId =
                id;


            this.populateReturnForm(
                result.data
            );


            this.setModalTitle(
                this.elements.returnModal,
                'Edit Purchase Return'
            );


            this.returnModalInstance?.show();

        }
        catch (error) {

            this.notify(
                error.message,
                'error'
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Reset Return Form
    |--------------------------------------------------------------------------
    */

    resetReturnForm()
    {

        this.elements.returnForm?.reset();


        this.editingReturnId =
            null;


        this.returnItems =
            [];


        if (
            this.elements.returnItemsContainer
        ) {

            this.elements.returnItemsContainer.innerHTML =
                '';

        }


        this.clearValidation(
            this.elements.returnForm
        );


        this.updateReturnTotal();

    },


    /*
    |--------------------------------------------------------------------------
    | Populate Return Form
    |--------------------------------------------------------------------------
    */

    populateReturnForm(
        record
    )
    {

        this.setValue(
            this.elements.returnId,
            record.id
        );

        this.setValue(
            this.elements.returnOrder,
            record.purchase_order_id
        );

        this.setValue(
            this.elements.returnSupplier,
            record.supplier_id
        );

        this.setValue(
            this.elements.returnBranch,
            record.branch_id
        );

        this.setValue(
            this.elements.returnDate,
            record.return_date
        );

        this.setValue(
            this.elements.returnReference,
            record.reference_no
        );

        this.setValue(
            this.elements.returnReason,
            record.reason
        );

        this.setValue(
            this.elements.returnNotes,
            record.notes
        );


        this.returnItems =
            record.items ?? [];


        this.renderReturnItems();

    },


    /*
    |--------------------------------------------------------------------------
    | Add Return Item
    |--------------------------------------------------------------------------
    */

    addReturnItem()
    {

        this.returnItems.push({

            id:
                null,

            product_id:
                '',

            quantity:
                1,

            unit_cost:
                0,

        });


        this.renderReturnItems();

    },


    /*
    |--------------------------------------------------------------------------
    | Render Return Items
    |--------------------------------------------------------------------------
    */

    renderReturnItems()
    {

        if (
            !this.elements.returnItemsContainer
        ) {
            return;
        }


        this.elements.returnItemsContainer.innerHTML =
            '';


        this.returnItems.forEach(
            (item, index) => {

                const row =
                    document.createElement(
                        'div'
                    );


                row.className =
                    'purchase-item-row border rounded-3 p-3 mb-3';


                row.innerHTML = `

                    <div class="row g-3 align-items-end">

                        <div class="col-lg-6">

                            <label class="form-label">
                                Product
                            </label>

                            <select
                                class="form-select"
                                data-return-field="product_id"
                                data-index="${index}"
                            >

                                <option value="">
                                    Select Product
                                </option>

                                ${this.products.map(
                                    product => `

                                        <option
                                            value="${product.id}"
                                            ${String(product.id) === String(item.product_id)
                                                ? 'selected'
                                                : ''
                                            }
                                        >

                                            ${this.escapeHtml(
                                                product.name ??
                                                product.display_name
                                            )}

                                        </option>

                                    `
                                ).join('')}

                            </select>

                        </div>


                        <div class="col-lg-2">

                            <label class="form-label">
                                Quantity
                            </label>

                            <input
                                type="number"
                                min="0.01"
                                step="0.01"
                                class="form-control"
                                value="${item.quantity ?? 0}"
                                data-return-field="quantity"
                                data-index="${index}"
                            >

                        </div>


                        <div class="col-lg-2">

                            <label class="form-label">
                                Unit Cost
                            </label>

                            <input
                                type="number"
                                min="0"
                                step="0.01"
                                class="form-control"
                                value="${item.unit_cost ?? 0}"
                                data-return-field="unit_cost"
                                data-index="${index}"
                            >

                        </div>


                        <div class="col-lg-2">

                            <button
                                type="button"
                                class="btn btn-outline-danger w-100"
                                data-remove-return-item="${index}"
                            >

                                <i class="bi bi-trash"></i>

                            </button>

                        </div>

                    </div>

                `;


                this.elements.returnItemsContainer.appendChild(
                    row
                );

            }
        );


        this.elements.returnItemsContainer
            .querySelectorAll(
                '[data-return-field]'
            )
            .forEach(
                field => {

                    field.addEventListener(
                        'input',
                        () => {

                            this.updateReturnItem(
                                field
                            );

                        }
                    );


                    field.addEventListener(
                        'change',
                        () => {

                            this.updateReturnItem(
                                field
                            );

                        }
                    );

                }
            );


        this.elements.returnItemsContainer
            .querySelectorAll(
                '[data-remove-return-item]'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            const index =
                                Number(
                                    button.dataset.removeReturnItem
                                );


                            this.returnItems.splice(
                                index,
                                1
                            );


                            this.renderReturnItems();

                        }
                    );

                }
            );


        this.updateReturnTotal();

    },


    /*
    |--------------------------------------------------------------------------
    | Update Return Item
    |--------------------------------------------------------------------------
    */

    updateReturnItem(
        field
    )
    {

        const index =
            Number(
                field.dataset.index
            );


        const property =
            field.dataset.returnField;


        if (
            !this.returnItems[index]
        ) {
            return;
        }


        this.returnItems[index][property] =
            property === 'product_id'
                ? field.value
                : Number(
                    field.value || 0
                );


        this.updateReturnTotal();

    },


    /*
    |--------------------------------------------------------------------------
    | Save Purchase Return
    |--------------------------------------------------------------------------
    */

    async saveReturn()
    {

        this.clearValidation(
            this.elements.returnForm
        );


        if (
            this.returnItems.length === 0
        ) {

            this.notify(
                'Add at least one product to the return.',
                'error'
            );

            return;

        }


        const formData =
            new FormData(
                this.elements.returnForm
            );


        formData.append(
            'items',
            JSON.stringify(
                this.returnItems
            )
        );


        const isEdit =
            !!this.editingReturnId;


        const url =
            isEdit
                ? `/purchase/returns/${this.editingReturnId}`
                : '/purchase/returns';


        if (isEdit) {

            formData.append(
                '_method',
                'PUT'
            );

        }


        try {

            const response =
                await fetch(
                    url,
                    {
                        method:
                            'POST',

                        body:
                            formData,

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

                this.handleFormError(
                    result,
                    this.elements.returnForm
                );

                return;

            }


            this.returnModalInstance?.hide();


            this.notify(
                result.message ??
                'Purchase return saved successfully.',
                'success'
            );


            await this.loadReturns(
                1
            );

        }
        catch (error) {

            this.notify(
                error.message,
                'error'
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Update Order Totals
    |--------------------------------------------------------------------------
    */

    updateOrderTotals()
    {

        let subtotal =
            0;

        let tax =
            0;

        let discount =
            0;


        this.orderItems.forEach(
            item => {

                const base =
                    Number(item.quantity ?? 0) *
                    Number(item.unit_cost ?? 0);


                subtotal +=
                    base;


                discount +=
                    Number(item.discount ?? 0);


                tax +=
                    Number(item.tax_rate ?? 0) > 0
                        ? (
                            base *
                            Number(item.tax_rate) /
                            100
                        )
                        : 0;

            }
        );


        const total =
            subtotal +
            tax -
            discount;


        this.setText(
            'purchaseOrderSubtotal',
            this.formatMoney(
                subtotal
            )
        );


        this.setText(
            'purchaseOrderTax',
            this.formatMoney(
                tax
            )
        );


        this.setText(
            'purchaseOrderDiscount',
            this.formatMoney(
                discount
            )
        );


        this.setText(
            'purchaseOrderTotal',
            this.formatMoney(
                total
            )
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Update Goods Received Total
    |--------------------------------------------------------------------------
    */

    updateGoodsReceivedTotal()
    {

        const total =
            this.receivedItems.reduce(
                (
                    sum,
                    item
                ) => {

                    return sum +
                        (
                            Number(
                                item.quantity ?? 0
                            ) *
                            Number(
                                item.unit_cost ?? 0
                            )
                        );

                },
                0
            );


        this.setText(
            'goodsReceivedTotal',
            this.formatMoney(
                total
            )
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Update Return Total
    |--------------------------------------------------------------------------
    */

    updateReturnTotal()
    {

        const total =
            this.returnItems.reduce(
                (
                    sum,
                    item
                ) => {

                    return sum +
                        (
                            Number(
                                item.quantity ?? 0
                            ) *
                            Number(
                                item.unit_cost ?? 0
                            )
                        );

                },
                0
            );


        this.setText(
            'purchaseReturnTotal',
            this.formatMoney(
                total
            )
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Item Total
    |--------------------------------------------------------------------------
    */

    itemTotal(
        item
    )
    {

        return (
            Number(
                item.quantity ?? 0
            ) *
            Number(
                item.unit_cost ?? 0
            )
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Confirmation
    |--------------------------------------------------------------------------
    */

    openConfirmation(
        action,
        id
    )
    {

        this.confirmationAction =
            action;

        this.globalActionId =
            id;


        const config =
            this.confirmationConfig(
                action
            );


        this.elements.confirmTitle.textContent =
            config.title;


        this.elements.confirmMessage.textContent =
            config.message;


        this.elements.confirmDescription.textContent =
            config.description;


        this.elements.confirmIcon.innerHTML =
            `<i class="bi ${config.icon}"></i>`;


        this.elements.confirmButton.className =
            `btn ${config.buttonClass}`;


        this.elements.confirmButton.textContent =
            config.button;


        this.confirmModalInstance?.show();

    },


    /*
    |--------------------------------------------------------------------------
    | Confirmation Configuration
    |--------------------------------------------------------------------------
    */

    confirmationConfig(
        action
    )
    {

        const configs =
        {

            'delete-order':
            {

                title:
                    'Delete Purchase Order',

                message:
                    'Are you sure you want to delete this purchase order?',

                description:
                    'This action cannot be undone.',

                icon:
                    'bi-trash',

                button:
                    'Delete',

                buttonClass:
                    'btn-danger',

            },


            'approve-order':
            {

                title:
                    'Approve Purchase Order',

                message:
                    'Approve this purchase order?',

                description:
                    'The purchase order will move into the approved state.',

                icon:
                    'bi-check-circle',

                button:
                    'Approve',

                buttonClass:
                    'btn-success',

            },


            'delete-goods-received':
            {

                title:
                    'Delete Goods Received',

                message:
                    'Are you sure you want to delete this goods received record?',

                description:
                    'Stock effects must be handled according to the record state.',

                icon:
                    'bi-trash',

                button:
                    'Delete',

                buttonClass:
                    'btn-danger',

            },


            'delete-return':
            {

                title:
                    'Delete Purchase Return',

                message:
                    'Are you sure you want to delete this purchase return?',

                description:
                    'This action cannot be undone.',

                icon:
                    'bi-trash',

                button:
                    'Delete',

                buttonClass:
                    'btn-danger',

            },


            'process-return':
            {

                title:
                    'Process Purchase Return',

                message:
                    'Process this purchase return?',

                description:
                    'Processing the return will update the related stock.',

                icon:
                    'bi-arrow-return-left',

                button:
                    'Process Return',

                buttonClass:
                    'btn-warning',

            },

        };


        return configs[action]
            ??
            {

                title:
                    'Confirm Action',

                message:
                    'Are you sure you want to continue?',

                description:
                    'Please confirm this action.',

                icon:
                    'bi-question-circle',

                button:
                    'Confirm',

                buttonClass:
                    'btn-danger',

            };

    },


    /*
    |--------------------------------------------------------------------------
    | Execute Confirmation
    |--------------------------------------------------------------------------
    */

    async executeConfirmation()
    {

        const action =
            this.confirmationAction;


        const id =
            this.globalActionId;


        if (
            !action ||
            !id
        ) {
            return;
        }


        try {

            let url =
                '';

            let method =
                'POST';


            switch (
                action
            ) {

                case 'delete-order':

                    url =
                        `/purchase/orders/${id}`;

                    method =
                        'DELETE';

                    break;


                case 'approve-order':

                    url =
                        `/purchase/orders/${id}/approve`;

                    method =
                        'PATCH';

                    break;


                case 'delete-goods-received':

                    url =
                        `/purchase/goods-received/${id}`;

                    method =
                        'DELETE';

                    break;


                case 'delete-return':

                    url =
                        `/purchase/returns/${id}`;

                    method =
                        'DELETE';

                    break;


                case 'process-return':

                    url =
                        `/purchase/returns/${id}/process`;

                    method =
                        'PATCH';

                    break;

            }


            const response =
                await fetch(
                    url,
                    {
                        method,

                        headers: {
                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                this.csrfToken()
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
                    'Action could not be completed.'
                );

            }


            this.confirmModalInstance?.hide();


            this.notify(
                result.message ??
                'Action completed successfully.',
                'success'
            );


            if (
                action.includes(
                    'order'
                )
            ) {

                await this.loadOrders(
                    this.ordersPage
                );

            }

            else if (
                action.includes(
                    'goods-received'
                )
            ) {

                await this.loadGoodsReceived(
                    this.goodsReceivedPage
                );

            }

            else {

                await this.loadReturns(
                    this.returnsPage
                );

            }

        }
        catch (error) {

            this.notify(
                error.message,
                'error'
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Global Action Menu
    |--------------------------------------------------------------------------
    */

    openGlobalActionMenu(
        trigger
    )
    {

        if (
            !this.elements.globalActionMenu
        ) {
            return;
        }


        this.globalActionId =
            trigger.dataset.id;


        this.globalActionType =
            trigger.dataset.type;


        const rect =
            trigger.getBoundingClientRect();


        const menu =
            this.elements.globalActionMenu;


        menu.classList.remove(
            'd-none'
        );


        menu.style.position =
            'fixed';


        menu.style.top =
            `${rect.bottom + 6}px`;


        menu.style.left =
            `${Math.max(
                8,
                rect.right - menu.offsetWidth
            )}px`;


        menu.style.zIndex =
            '2000';

    },


    /*
    |--------------------------------------------------------------------------
    | Close Global Action Menu
    |--------------------------------------------------------------------------
    */

    closeGlobalActionMenu()
    {

        this.elements.globalActionMenu
            ?.classList.add(
                'd-none'
            );

    },


    /*
    |--------------------------------------------------------------------------
    | Show Table Loading
    |--------------------------------------------------------------------------
    */

    showTableLoading(
        element
    )
    {

        if (!element) {
            return;
        }


        element.innerHTML = `

            <div class="text-center py-5">

                <div
                    class="spinner-border spinner-border-sm text-secondary"
                    role="status"
                ></div>

                <div class="small text-muted mt-2">
                    Loading...
                </div>

            </div>

        `;

    },


    /*
    |--------------------------------------------------------------------------
    | Show Table Error
    |--------------------------------------------------------------------------
    */

    showTableError(
        element,
        message
    )
    {

        if (!element) {
            return;
        }


        element.innerHTML = `

            <div class="alert alert-danger border-0 m-3">

                <i class="bi bi-exclamation-triangle me-2"></i>

                ${this.escapeHtml(
                    message
                )}

            </div>

        `;

    },


    /*
    |--------------------------------------------------------------------------
    | Show Inspector Loading
    |--------------------------------------------------------------------------
    */

    showInspectorLoading(
        element
    )
    {

        if (!element) {
            return;
        }


        element.innerHTML = `

            <div class="d-flex align-items-center
                justify-content-center p-5">

                <div
                    class="spinner-border text-secondary"
                    role="status"
                ></div>

            </div>

        `;

    },


    /*
    |--------------------------------------------------------------------------
    | Show Inspector Error
    |--------------------------------------------------------------------------
    */

    showInspectorError(
        element,
        message
    )
    {

        if (!element) {
            return;
        }


        element.innerHTML = `

            <div class="p-4">

                <div class="alert alert-danger border-0">

                    <i class="bi bi-exclamation-triangle me-2"></i>

                    ${this.escapeHtml(
                        message
                    )}

                </div>

            </div>

        `;

    },


    /*
    |--------------------------------------------------------------------------
    | Set Text
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | Set Value
    |--------------------------------------------------------------------------
    */

    setValue(
        element,
        value
    )
    {

        if (
            element
        ) {

            element.value =
                value ??
                '';

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Set Modal Title
    |--------------------------------------------------------------------------
    */

    setModalTitle(
        modal,
        title
    )
    {

        const element =
            modal?.querySelector(
                '.modal-title'
            );


        if (element) {

            element.textContent =
                title;

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Set Order Modal Title
    |--------------------------------------------------------------------------
    */

    setOrderModalTitle(
        title
    )
    {

        this.setModalTitle(
            this.elements.orderModal,
            title
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Set Button Loading
    |--------------------------------------------------------------------------
    */

    setButtonLoading(
        button,
        loading
    )
    {

        if (!button) {
            return;
        }


        if (
            loading
        ) {

            button.dataset.originalText =
                button.innerHTML;


            button.disabled =
                true;


            button.innerHTML = `

                <span
                    class="spinner-border spinner-border-sm me-1"
                    role="status"
                ></span>

                Saving...

            `;

        }
        else {

            button.disabled =
                false;


            if (
                button.dataset.originalText
            ) {

                button.innerHTML =
                    button.dataset.originalText;

            }

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Clear Validation
    |--------------------------------------------------------------------------
    */

    clearValidation(
        form
    )
    {

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
            '.invalid-feedback.dynamic'
        ).forEach(
            element => {

                element.remove();

            }
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Handle Form Error
    |--------------------------------------------------------------------------
    */

    handleFormError(
        result,
        form
    )
    {

        if (
            result.errors
        ) {

            Object.entries(
                result.errors
            ).forEach(
                (
                    [
                        field,
                        messages
                    ]
                ) => {

                    const input =
                        form?.querySelector(
                            `[name="${field}"]`
                        );


                    if (!input) {
                        return;
                    }


                    input.classList.add(
                        'is-invalid'
                    );


                    const feedback =
                        document.createElement(
                            'div'
                        );


                    feedback.className =
                        'invalid-feedback dynamic';


                    feedback.textContent =
                        Array.isArray(messages)
                            ? messages[0]
                            : messages;


                    input.parentElement
                        ?.appendChild(
                            feedback
                        );

                }
            );

        }


        this.notify(
            result.message ??
            'Please check the form and try again.',
            'error'
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Inspector Information
    |--------------------------------------------------------------------------
    */

    inspectorInfo(
        label,
        value
    )
    {

        return `

            <div class="col-6">

                <div class="text-muted small mb-1">
                    ${this.escapeHtml(
                        label
                    )}
                </div>

                <div class="fw-medium">

                    ${this.escapeHtml(
                        value ??
                        '—'
                    )}

                </div>

            </div>

        `;

    },


    /*
    |--------------------------------------------------------------------------
    | Status Badge
    |--------------------------------------------------------------------------
    */

    statusBadge(
        status
    )
    {

        const value =
            String(
                status ??
                ''
            ).toLowerCase();


        if (
            [
                'approved',
                'completed',
                'received',
                'processed',
                'active'
            ].includes(
                value
            )
        ) {

            return 'bg-success-subtle text-success';

        }


        if (
            [
                'pending',
                'draft',
                'processing'
            ].includes(
                value
            )
        ) {

            return 'bg-warning-subtle text-warning-emphasis';

        }


        if (
            [
                'cancelled',
                'rejected',
                'returned',
                'inactive'
            ].includes(
                value
            )
        ) {

            return 'bg-danger-subtle text-danger';

        }


        return 'bg-secondary-subtle text-secondary';

    },


    /*
    |--------------------------------------------------------------------------
    | Format Money
    |--------------------------------------------------------------------------
    */

    formatMoney(
        value
    )
    {

        const amount =
            Number(
                value ?? 0
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
            amount
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Format Number
    |--------------------------------------------------------------------------
    */

    formatNumber(
        value
    )
    {

        return new Intl.NumberFormat(
            'en-NG',
            {
                minimumFractionDigits:
                    0,

                maximumFractionDigits:
                    2,
            }
        ).format(
            Number(
                value ?? 0
            )
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Escape HTML
    |--------------------------------------------------------------------------
    */

    escapeHtml(
        value
    )
    {

        const div =
            document.createElement(
                'div'
            );


        div.textContent =
            value ??
            '';


        return div.innerHTML;

    },


    /*
    |--------------------------------------------------------------------------
    | CSRF Token
    |--------------------------------------------------------------------------
    */

    csrfToken()
    {

        return document
            .querySelector(
                'meta[name="csrf-token"]'
            )
            ?.getAttribute(
                'content'
            ) ?? '';

    },


    /*
    |--------------------------------------------------------------------------
    | Notification
    |--------------------------------------------------------------------------
    */

    notify(
        message,
        type = 'success'
    )
    {

        /*
        |--------------------------------------------------------------------------
        | Use the existing EMNEX toast implementation
        | when available.
        |--------------------------------------------------------------------------
        */

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


        if (
            typeof window.toast ===
            'function'
        ) {

            window.toast(
                message,
                type
            );

            return;

        }


        console[
            type === 'error'
                ? 'error'
                : 'log'
        ](
            message
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Close Modal
    |--------------------------------------------------------------------------
    */

    closeModal(
        instance
    )
    {

        instance?.hide();

    },


    /*
    |--------------------------------------------------------------------------
    | Generic Modal Reset
    |--------------------------------------------------------------------------
    */

    resetModal(
        form,
        itemsContainer
    )
    {

        form?.reset();

        if (
            itemsContainer
        ) {

            itemsContainer.innerHTML =
                '';

        }

    },

};


/*
|--------------------------------------------------------------------------
| Document Ready
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    () => {

        Purchase.init();

    }
);