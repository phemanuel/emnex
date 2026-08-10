
const StockTransfer = {

    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    state: {

        currentPage: 1,

        loading: false,

        submitting: false,

        selectedProducts: [],

        destinationBranchId: null,

    },


    /*
    |--------------------------------------------------------------------------
    | Bootstrap Modals
    |--------------------------------------------------------------------------
    */

    transferModal: null,

    historyModal: null,


    /*
    |--------------------------------------------------------------------------
    | DOM Elements
    |--------------------------------------------------------------------------
    */

    elements: {},


    /*
    |--------------------------------------------------------------------------
    | Initialize
    |--------------------------------------------------------------------------
    */

    init() {

        this.cacheElements();

        this.initModals();

        this.bindEvents();

        this.loadTable(); 

        this.updateSelectionCounters(); 

        this.renderCart();

    },


    /*
    |--------------------------------------------------------------------------
    | Cache DOM Elements
    |--------------------------------------------------------------------------
    */

    cacheElements() {

        this.elements = {

            /*
            |------------------------------------------------------------------
            | Table
            |------------------------------------------------------------------
            */

            tableContainer:
                document.getElementById(
                    'stockTransferTableContainer'
                ),

            pagination:
                document.getElementById(
                    'stockTransferPagination'
                ),          


            /* |-------------------------------------------------------------------------- | Selection |-------------------------------------------------------------------------- */ 
            selectAll: 
            document.getElementById( 
                'selectAllTransferProducts' 
            ), 
            selectedProductsLabel: 
            document.getElementById( 
                'selectedProductsLabel' 
            ), 
            /* |-------------------------------------------------------------------------- | Cart |-------------------------------------------------------------------------- */ 
            cartContainer: 
            document.getElementById( 
                'stockTransferCart' 
            ), 
            cartEmpty: 
            document.getElementById( 'stockTransferCartEmpty' ), 

            cartCount: 
            document.getElementById( 'transferCartCount' ), 

            cartTotal: 
            document.getElementById( 'transferCartTotal' ), 

            clearCart: 
            document.getElementById( 'clearTransferCart' ), 

            proceedTransfer: 
            document.getElementById( 'proceedStockTransferBtn' ), 

            addSelectedToCart: 
            document.getElementById( 'addSelectedToCartBtn' ),

            transferItemsContainer:
            document.getElementById('transferItemsContainer'),

            transferModalTotalQuantity:
            document.getElementById('transferModalTotalQuantity'),

            transferModalProductCount:
            document.getElementById('transferModalProductCount'),


            /*
            |------------------------------------------------------------------
            | Filters
            |------------------------------------------------------------------
            */

            search:
                document.getElementById(
                    'transferSearch'
                ),

            category:
                document.getElementById(
                    'transferCategoryFilter'
                ),

            status:
                document.getElementById(
                    'transferStatusFilter'
                ),

            resetFilters:
                document.getElementById(
                    'resetTransferFilters'
                ),           


            /*
            |------------------------------------------------------------------
            | Transfer Modal
            |------------------------------------------------------------------
            */

            transferForm:
                document.getElementById(
                    'stockTransferForm'
                ),

            destinationBranch:
                document.getElementById(
                    'transferDestinationBranch'
                ),

            referenceNo:
                document.getElementById(
                    'transferReferenceNo'
                ),

            remarks:
                document.getElementById(
                    'transferRemarks'
                ),

            transferItemsContainer:
                document.getElementById(
                    'transferItemsContainer'
                ),

            submitTransfer:
                document.getElementById(
                    'submitStockTransferBtn'
                ),


            /*
            |------------------------------------------------------------------
            | History
            |------------------------------------------------------------------
            */

            historyContainer:
                document.getElementById(
                    'stockTransferHistoryContainer'
                ),

            historyProductName:
                document.getElementById(
                    'historyProductName'
                ),

            historyProductSku:
                document.getElementById(
                    'historyProductSku'
                ),


            /*
            |------------------------------------------------------------------
            | KPI
            |------------------------------------------------------------------
            */

            productCount:
                document.getElementById(
                    'transferProductCount'
                ),

            availableStock:
                document.getElementById(
                    'transferAvailableStock'
                ),

            lowStock:
                document.getElementById(
                    'transferLowStock'
                ),

            outStock:
                document.getElementById(
                    'transferOutStock'
                ),

        };

    },


    /*
    |--------------------------------------------------------------------------
    | Initialize Modals
    |--------------------------------------------------------------------------
    */

    initModals() {

        const transferModalElement =
            document.getElementById(
                'stockTransferModal'
            );

        const historyModalElement =
            document.getElementById(
                'stockTransferHistoryModal'
            );


        if (
            transferModalElement &&
            typeof bootstrap !== 'undefined'
        ) {

            this.transferModal =
                bootstrap.Modal.getOrCreateInstance(
                    transferModalElement
                );

        }


        if (
            historyModalElement &&
            typeof bootstrap !== 'undefined'
        ) {

            this.historyModal =
                bootstrap.Modal.getOrCreateInstance(
                    historyModalElement
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
        | Search
        |----------------------------------------------------------------------
        */

        if (this.elements.search) {

            let searchTimer = null;

            this.elements.search.addEventListener(
                'input',
                () => {

                    clearTimeout(searchTimer);

                    searchTimer = setTimeout(
                        () => {

                            this.state.currentPage = 1;

                            this.loadTable();

                        },
                        350
                    );

                }
            );

        }


        /*
        |----------------------------------------------------------------------
        | Category
        |----------------------------------------------------------------------
        */

        if (this.elements.category) {

            this.elements.category.addEventListener(
                'change',
                () => {

                    this.state.currentPage = 1;

                    this.loadTable();

                }
            );

        }


        /*
        |----------------------------------------------------------------------
        | Status
        |----------------------------------------------------------------------
        */

        if (this.elements.status) {

            this.elements.status.addEventListener(
                'change',
                () => {

                    this.state.currentPage = 1;

                    this.loadTable();

                }
            );

        }


        /*
        |----------------------------------------------------------------------
        | Reset Filters
        |----------------------------------------------------------------------
        */

        if (this.elements.resetFilters) {

            this.elements.resetFilters.addEventListener(
                'click',
                () => {

                    this.resetFilters();

                }
            );

        }


        /*
        |----------------------------------------------------------------------
        | Select All
        |----------------------------------------------------------------------
        */

        document.addEventListener(
            'change',
            (event) => {

                if ( event.target.matches( 
                    '#selectAllTransferProducts' ) 
                ) { 
                    this.toggleSelectAll( 
                    event.target.checked 
                ); 
                
                return; }


                if (
                    event.target.matches(
                        '.stock-transfer-checkbox'
                    )
                ) {

                    const checkbox =
                        event.target;

                    this.toggleProductSelection(
                        checkbox
                    );

                }

            }
        );


        /*
        |----------------------------------------------------------------------
        | Table Actions
        |----------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            (event) => {

                /*
                |--------------------------------------------------------------
                | Add Product
                |--------------------------------------------------------------
                */

                const addButton =
                    event.target.closest(
                        '.stock-transfer-add-btn'
                    );


                if (addButton) {

                    event.preventDefault();

                    this.addProductFromButton(
                        addButton
                    );

                    return;

                }


                /*
                |--------------------------------------------------------------
                | Remove Product From Cart
                |--------------------------------------------------------------
                */

                const removeButton =
                    event.target.closest(
                        '.transfer-cart-remove'
                    );


                if (removeButton) {

                    event.preventDefault();

                    this.removeProduct(
                        removeButton.dataset.id
                    );

                    return;

                }


                /*
                |--------------------------------------------------------------
                | History
                |--------------------------------------------------------------
                */

                const historyButton =
                    event.target.closest(
                        '.stock-transfer-history-btn'
                    );


                if (historyButton) {

                    event.preventDefault();

                    this.openHistoryModal(
                        historyButton.dataset.id
                    );

                    return;

                }


                /*
                |--------------------------------------------------------------
                | Pagination
                |--------------------------------------------------------------
                */

                const paginationLink =
                    event.target.closest(
                        '#stockTransferPagination a'
                    );


                if (paginationLink) {

                    event.preventDefault();

                    const url =
                        paginationLink.getAttribute(
                            'href'
                        );

                    if (url) {

                        this.loadTable(url);

                    }

                    return;

                }


                /*
                |--------------------------------------------------------------
                | Clear Cart
                |--------------------------------------------------------------
                */

                if (
                    event.target.closest(
                        '#clearTransferCart'
                    )
                ) {

                    event.preventDefault();

                    this.clearCart();

                    return;

                }

               /*
                |--------------------------------------------------------------------------
                | Add Selected Products To Cart
                |--------------------------------------------------------------------------
                */

                const addSelectedButton =
                    event.target.closest(
                        '#addSelectedToCartBtn'
                    );


                if (addSelectedButton) {

                    event.preventDefault();

                    this.addSelectedProductsToCart();

                    return;

                }


                /*
                |--------------------------------------------------------------
                | Proceed
                |--------------------------------------------------------------
                */

                if (
                    event.target.closest(
                        '#proceedStockTransferBtn'
                    )
                ) {

                    event.preventDefault();

                    this.openTransferModal();

                }

            }
        );


        /*
        |----------------------------------------------------------------------
        | Cart Quantity
        |----------------------------------------------------------------------
        */

       /*
|--------------------------------------------------------------------------
| Cart & Transfer Quantities
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'input',
    (event) => {

        /*
        |--------------------------------------------------------------------------
        | Cart Quantity
        |--------------------------------------------------------------------------
        */

        if (
                    event.target.matches(
                        '.transfer-cart-quantity'
                    )
                ) {

                    this.updateCartQuantity(
                        event.target
                    );

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Transfer Modal Quantity
                |--------------------------------------------------------------------------
                */

                if (
                    event.target.matches(
                        '.transfer-transfer-quantity'
                    )
                ) {

                    this.updateTransferQuantity(
                        event.target
                    );

                }

            }
        );

        /*
        |----------------------------------------------------------------------
        | Transfer Form
        |----------------------------------------------------------------------
        */

        if (this.elements.transferForm) {

            this.elements.transferForm.addEventListener(
                'submit',
                (event) => {

                    event.preventDefault();

                    this.submitTransfer();

                }
            );

        }


        /*
        |----------------------------------------------------------------------
        | Destination Branch
        |----------------------------------------------------------------------
        */

        if (this.elements.destinationBranch) {

            this.elements.destinationBranch.addEventListener(
                'change',
                () => {

                    this.state.destinationBranchId =
                        this.elements.destinationBranch.value ||
                        null;

                }
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Reset Filters
    |--------------------------------------------------------------------------
    */

    resetFilters() {

        if (this.elements.search) {

            this.elements.search.value = '';

        }


        if (this.elements.category) {

            this.elements.category.value = '';

        }


        if (this.elements.status) {

            this.elements.status.value = '';

        }


        this.state.currentPage = 1;

        this.loadTable();

    },


    /*
    |--------------------------------------------------------------------------
    | Load Table
    |--------------------------------------------------------------------------
    */

    async loadTable(url = null) {

        if (
            this.state.loading ||
            !this.elements.tableContainer
        ) {

            return;

        }


        this.state.loading = true;

        this.showTableLoading();


        try {

            let requestUrl = url;


            if (!requestUrl) {

                const params =
                    new URLSearchParams();


                const search =
                    this.elements.search?.value.trim();


                const category =
                    this.elements.category?.value;


                const status =
                    this.elements.status?.value;


                if (search) {

                    params.set(
                        'search',
                        search
                    );

                }


                if (category) {

                    params.set(
                        'category',
                        category
                    );

                }


                if (status) {

                    params.set(
                        'status',
                        status
                    );

                }


                params.set(
                    'page',
                    this.state.currentPage
                );


                const baseUrl =
                    window.STOCK_TRANSFER?.tableUrl;

                if (!baseUrl) {

                    throw new Error(
                        'Stock transfer table URL is not configured.'
                    );

                }

                requestUrl =
                    baseUrl +
                    '?' +
                    params.toString();

            }


            const response =
                await fetch(
                    requestUrl,
                    {
                        method: 'GET',

                        headers: {

                            'X-Requested-With':
                                'XMLHttpRequest',

                            'Accept':
                                'text/html',

                        },

                    }
                );


            if (!response.ok) {

                throw new Error(
                    `Server returned ${response.status}.`
                );

            }


            const html =
                await response.text();


            const table =
                this.extractTable(html);            


            const pagination =
                this.extractPagination(html);


            if (this.elements.tableContainer) {

                this.elements.tableContainer.innerHTML =
                    table;

            }


            if (this.elements.pagination) {

                this.elements.pagination.innerHTML =
                    pagination;

            }


            this.updateStateFromUrl(
                requestUrl
            );


            this.syncVisibleSelections(); 

            this.updateSelectAllState(); 

            this.updateSelectionCounters();
             
            this.updateKpis();

        }
        catch (error) {

            console.error(
                'Stock transfer table error:',
                error
            );


            this.elements.tableContainer.innerHTML = `

                <div class="stock-empty-state">

                    <i class="bi bi-exclamation-circle"></i>

                    <h6>
                        Unable to load stock
                    </h6>

                    <p>
                        ${this.escapeHtml(
                            error.message ||
                            'Please refresh the page and try again.'
                        )}
                    </p>

                </div>

            `;

        }
        finally {

            this.state.loading = false;

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Loading State
    |--------------------------------------------------------------------------
    */

    showTableLoading() {

        if (!this.elements.tableContainer) {

            return;

        }


        this.elements.tableContainer.innerHTML = `

            <div class="stock-transfer-loading">

                <div
                    class="spinner-border spinner-border-sm"
                    role="status"
                ></div>

                <span>
                    Loading stock...
                </span>

            </div>

        `;

    },


    /*
    |--------------------------------------------------------------------------
    | Extract Table
    |--------------------------------------------------------------------------
    */

    extractTable(html) {

        const parser =
            new DOMParser();


        const parsed =
            parser.parseFromString(
                html,
                'text/html'
            );


        const table =
            parsed.querySelector(
                'table'
            );


        if (table) {

            return table.outerHTML;

        }


        const tbody =
            parsed.querySelector(
                'tbody'
            );


        if (tbody) {

            return `
                <table class="table table-hover align-middle mb-0">
                    ${tbody.outerHTML}
                </table>
            `;

        }


        return html;

    },


    /*
    |--------------------------------------------------------------------------
    | Extract Pagination
    |--------------------------------------------------------------------------
    */

    extractPagination(html) {

        const parser =
            new DOMParser();


        const parsed =
            parser.parseFromString(
                html,
                'text/html'
            );


        const pagination =
            parsed.querySelector(
                '.pagination'
            );


        return pagination
            ? pagination.outerHTML
            : '';

    },


    /*
    |--------------------------------------------------------------------------
    | Update Page
    |--------------------------------------------------------------------------
    */

    updateStateFromUrl(url) {

        try {

            const parsed =
                new URL(
                    url,
                    window.location.origin
                );


            const page =
                parsed.searchParams.get(
                    'page'
                );


            if (page) {

                this.state.currentPage =
                    parseInt(
                        page,
                        10
                    );

            }

        }
        catch (error) {

            console.warn(
                'Unable to determine current page.',
                error
            );

        }

    },


 /*
|--------------------------------------------------------------------------
| Select All
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Select All
|--------------------------------------------------------------------------
*/

toggleSelectAll(checked) {

    const checkboxes =
        this.elements.tableContainer?.querySelectorAll(
            '.stock-transfer-checkbox'
        );


    if (!checkboxes || !checkboxes.length) {

        return;

    }


    checkboxes.forEach(
        (checkbox) => {

            checkbox.checked =
                checked;


            this.toggleProductSelection(
                checkbox,
                false
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Keep Select All visually synchronized
    |--------------------------------------------------------------------------
    */

    const selectAll =
        this.elements.selectAll;


    if (selectAll) {

        selectAll.checked =
            checked;

        selectAll.indeterminate =
            false;

    }


    /*
    |--------------------------------------------------------------------------
    | Update UI
    |--------------------------------------------------------------------------
    */

    this.updateSelectionCounters();

    this.renderCart();

},

/*
|--------------------------------------------------------------------------
| Toggle Product Selection
|--------------------------------------------------------------------------
*/

toggleProductSelection(checkbox, render = true) {

    if (!checkbox) {

        return;

    }


    const product =
        this.getProductFromCheckbox(
            checkbox
        );


    if (!product) {

        return;

    }


    const existingIndex =
        this.state.selectedProducts.findIndex(
            item =>
                String(item.stock_id) ===
                String(product.stock_id)
        );


    if (checkbox.checked) {

        if (existingIndex === -1) {

            this.state.selectedProducts.push(
                product
            );

        }

    }
    else {

        if (existingIndex !== -1) {

            this.state.selectedProducts.splice(
                existingIndex,
                1
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Update Selection Counter
    |--------------------------------------------------------------------------
    */

    this.updateSelectionCounters();


    /*
    |--------------------------------------------------------------------------
    | Update Select All State
    |--------------------------------------------------------------------------
    */

    this.updateSelectAllState();


    /*
    |--------------------------------------------------------------------------
    | Render Cart
    |--------------------------------------------------------------------------
    */

    if (render) {

        this.renderCart();

    }

},


    /*
    |--------------------------------------------------------------------------
    | Read Product From Checkbox
    |--------------------------------------------------------------------------
    */

   /*
|--------------------------------------------------------------------------
| Read Product From Checkbox
|--------------------------------------------------------------------------
*/

getProductFromCheckbox(checkbox) {

    if (!checkbox) {

        return null;

    }


    const row =
        checkbox.closest('tr');


    if (!row) {

        return null;

    }


    const dataset =
        checkbox.dataset;


    const available =
        parseFloat(
            dataset.available ||
            row.dataset.availableQuantity ||
            0
        );


    return {

        stock_id:
            dataset.stockId ||
            row.dataset.stockId,

        product_id:
            dataset.productId ||
            row.dataset.productId,

        name:
            dataset.productName ||
            row.dataset.productName ||
            this.getCellText(
                row,
                '.stock-transfer-product-name'
            ),

        sku:
            dataset.productSku ||
            row.dataset.productSku ||
            '',

        barcode:
            dataset.productBarcode ||
            row.dataset.productBarcode ||
            '',

        category:
            dataset.productCategory ||
            row.dataset.productCategory ||
            this.getCellText(
                row,
                'td:nth-child(3)'
            ),

        unit:
            dataset.productUnit ||
            row.dataset.productUnit ||
            '',

        image:
            dataset.image ||
            row.dataset.image ||
            row.querySelector(
                '.stock-transfer-product-image img'
            )?.getAttribute('src') ||
            '',

        available:
            available,

        quantity:
            1,

    };

},

/*
|--------------------------------------------------------------------------
| Add Selected Products To Cart
|--------------------------------------------------------------------------
*/

addSelectedProductsToCart() {

    const selectedProducts =
        this.state.selectedProducts;


    if (!selectedProducts.length) {

        showToast(
            'Please select at least one product.',
            'warning'
        );

        return;

    }


    selectedProducts.forEach(
        product => {

            if (
                !product.quantity ||
                parseFloat(product.quantity) <= 0
            ) {

                product.quantity = 1;

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Render Cart
    |--------------------------------------------------------------------------
    */

    this.renderCart();


    /*
    |--------------------------------------------------------------------------
    | Keep Selected Products Checked
    |--------------------------------------------------------------------------
    */

    this.syncVisibleSelections();


    /*
    |--------------------------------------------------------------------------
    | Update Selection Counters
    |--------------------------------------------------------------------------
    */

    this.updateSelectionCounters();


    /*
    |--------------------------------------------------------------------------
    | Open Transfer Modal
    |--------------------------------------------------------------------------
    */

    this.openTransferModal();

},

    /*
    |--------------------------------------------------------------------------
    | Add Product From Button
    |--------------------------------------------------------------------------
    */

    addProductFromButton(button) {

        const product =
            this.getProductFromButton(
                button
            );


        if (!product) {

            return;

        }


        const existing =
            this.state.selectedProducts.find(
                item =>
                    String(item.stock_id) ===
                    String(product.stock_id)
            );


        if (existing) {

            showToast(
                `${product.name} is already in the transfer cart.`,
                'warning'
            );

            return;

        }


        if (product.available <= 0) {

            showToast(
                `${product.name} has no available stock.`,
                'warning'
            );

            return;

        }


        this.state.selectedProducts.push(
            product
        );


        this.syncVisibleSelections();

        this.renderCart();


        showToast(
            `${product.name} added to transfer cart.`,
            'success'
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Read Product From Button
    |--------------------------------------------------------------------------
    */

    getProductFromButton(button) {

        if (!button) {

            return null;

        }


        const dataset =
            button.dataset;


        return {

            stock_id:
                dataset.stockId,

            product_id:
                dataset.productId,

            name:
                dataset.name || '-',

            sku:
                dataset.sku || '-',

            barcode:
                dataset.barcode || '-',

            category:
                dataset.category || '-',

            unit:
                dataset.unit || '-',

            image:
                dataset.image || '',

            available:
                parseFloat(
                    dataset.available || 0
                ),

            quantity:
                1,

        };

    },


    /*
    |--------------------------------------------------------------------------
    | Remove Product
    |--------------------------------------------------------------------------
    */

    removeProduct(stockId) { 
        this.state.selectedProducts = this.state.selectedProducts.filter( 
            product => String(product.stock_id) !== String(stockId) ); 
            this.syncVisibleSelections(); 
            this.updateSelectionCounters(); 
            this.renderCart(); },


    /*
    |--------------------------------------------------------------------------
    | Clear Cart
    |--------------------------------------------------------------------------
    */

    clearCart() { 
        if ( !this.state.selectedProducts.length ) 
            { return; 

            } this.state.selectedProducts = []; 
            this.syncVisibleSelections(); 
            this.updateSelectionCounters(); 
            this.renderCart(); 
        },


    /*
    |--------------------------------------------------------------------------
    | Update Cart Quantity
    |--------------------------------------------------------------------------
    */

    updateCartQuantity(input) {

        const stockId =
            input.dataset.id;


        const product =
            this.state.selectedProducts.find(
                item =>
                    String(item.stock_id) ===
                    String(stockId)
            );


        if (!product) {

            return;

        }


        let quantity =
            parseFloat(
                input.value
            );


        if (
            Number.isNaN(quantity) ||
            quantity <= 0
        ) {

            quantity = 1;

        }


        if (
            quantity >
            product.available
        ) {

            quantity =
                product.available;


            showToast(
                `Maximum available stock for ${product.name} is ${this.formatNumber(product.available)}.`,
                'warning'
            );

        }


        product.quantity =
            quantity;


        input.value =
            this.formatQuantity(
                quantity
            );


        this.renderCartSummary();

    },


    /*
    |--------------------------------------------------------------------------
    | Render Cart
    |--------------------------------------------------------------------------
    */

    renderCart() {

        const container =
            this.elements.cartContainer;


        if (!container) {

            return;

        }


        const products =
            this.state.selectedProducts;


        if (!products.length) {

            if (this.elements.cartEmpty) {

                this.elements.cartEmpty.classList.remove(
                    'd-none'
                );

            }


            container
                .querySelectorAll(
                    '.transfer-cart-item'
                )
                .forEach(
                    item =>
                        item.remove()
                );


            this.renderCartSummary();

            return;

        }


        if (this.elements.cartEmpty) {

            this.elements.cartEmpty.classList.add(
                'd-none'
            );

        }


        container
            .querySelectorAll(
                '.transfer-cart-item'
            )
            .forEach(
                item =>
                    item.remove()
            );


        products.forEach(
            (product) => {

                const item =
                    document.createElement(
                        'div'
                    );


                item.className =
                    'transfer-cart-item';


                item.dataset.id =
                    product.stock_id;


                item.innerHTML = `

                    <div class="transfer-cart-product">

                        <div class="transfer-cart-image">

                            ${
                                product.image
                                    ? `
                                        <img
                                            src="${this.escapeHtml(product.image)}"
                                            alt="${this.escapeHtml(product.name)}"
                                        >
                                    `
                                    : `
                                        <i class="bi bi-box"></i>
                                    `
                            }

                        </div>


                        <div class="transfer-cart-info">

                            <strong>
                                ${this.escapeHtml(product.name)}
                            </strong>

                            <small>
                                SKU:
                                ${this.escapeHtml(product.sku || '-')}
                            </small>

                            <small>
                                Available:
                                <strong>
                                    ${this.formatNumber(product.available)}
                                </strong>
                            </small>

                        </div>

                    </div>


                    <div class="transfer-cart-controls">

                        <div class="input-group input-group-sm">

                            <button
                                type="button"
                                class="btn btn-outline-secondary transfer-cart-minus"
                                data-id="${this.escapeHtml(product.stock_id)}"
                            >
                                <i class="bi bi-dash"></i>
                            </button>

                            <input
                                type="number"
                                class="form-control transfer-cart-quantity text-center"
                                data-id="${this.escapeHtml(product.stock_id)}"
                                value="${this.formatQuantity(product.quantity)}"
                                min="0.01"
                                max="${product.available}"
                                step="0.01"
                            >

                            <button
                                type="button"
                                class="btn btn-outline-secondary transfer-cart-plus"
                                data-id="${this.escapeHtml(product.stock_id)}"
                            >
                                <i class="bi bi-plus"></i>
                            </button>

                        </div>


                        <button
                            type="button"
                            class="btn btn-sm btn-outline-danger transfer-cart-remove"
                            data-id="${this.escapeHtml(product.stock_id)}"
                            title="Remove"
                        >
                            <i class="bi bi-trash"></i>
                        </button>

                    </div>

                `;


                container.appendChild(
                    item
                );

            }
        );


        this.bindCartButtons();

        this.renderCartSummary();

    },


    /*
    |--------------------------------------------------------------------------
    | Cart Buttons
    |--------------------------------------------------------------------------
    */

    bindCartButtons() {

        document
            .querySelectorAll(
                '.transfer-cart-minus'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            this.changeCartQuantity(
                                button.dataset.id,
                                -1
                            );

                        }
                    );

                }
            );


        document
            .querySelectorAll(
                '.transfer-cart-plus'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            this.changeCartQuantity(
                                button.dataset.id,
                                1
                            );

                        }
                    );

                }
            );

    },


    /*
    |--------------------------------------------------------------------------
    | Change Cart Quantity
    |--------------------------------------------------------------------------
    */

    changeCartQuantity(
        stockId,
        direction
    ) {

        const product =
            this.state.selectedProducts.find(
                item =>
                    String(item.stock_id) ===
                    String(stockId)
            );


        if (!product) {

            return;

        }


        let quantity =
            parseFloat(
                product.quantity
            ) || 1;


        quantity +=
            direction;


        if (quantity < 0.01) {

            quantity = 0.01;

        }


        if (
            quantity >
            product.available
        ) {

            quantity =
                product.available;

            showToast(
                `Cannot exceed available stock of ${this.formatNumber(product.available)}.`,
                'warning'
            );

        }


        product.quantity =
            quantity;


        this.renderCart();

    },


    /*
    |--------------------------------------------------------------------------
    | Render Cart Summary
    |--------------------------------------------------------------------------
    */

    renderCartSummary() {

    const count =
        this.state.selectedProducts.length;


    const total =
        this.state.selectedProducts.reduce(
            (
                sum,
                product
            ) => {

                return sum +
                    (
                        parseFloat(
                            product.quantity
                        ) || 0
                    );

            },
            0
        );


    /*
    |--------------------------------------------------------------------------
    | Transfer Cart Counter
    |--------------------------------------------------------------------------
    */

    if (this.elements.cartCount) {

        this.elements.cartCount.textContent =
            count;

    }


    /*
    |--------------------------------------------------------------------------
    | Cart Total
    |--------------------------------------------------------------------------
    */

    if (this.elements.cartTotal) {

        this.elements.cartTotal.textContent =
            this.formatNumber(
                total
            );

    }


    /*
    |--------------------------------------------------------------------------
    | Proceed Button
    |--------------------------------------------------------------------------
    */

    if (this.elements.proceedTransfer) {

        this.elements.proceedTransfer.disabled =
            count === 0;

    }


    /*
    |--------------------------------------------------------------------------
    | Selection Counter
    |--------------------------------------------------------------------------
    */

    this.updateSelectionCounters();

},

/*
|--------------------------------------------------------------------------
| Update Selection Counters
|--------------------------------------------------------------------------
*/

updateSelectionCounters() {

    const count =
        this.state.selectedProducts.length;


    /*
    |--------------------------------------------------------------------------
    | Products Selected Label
    |--------------------------------------------------------------------------
    */

    if (this.elements.selectedProductsLabel) {

        this.elements.selectedProductsLabel.textContent =
            `${count} ${count === 1 ? 'product' : 'products'} selected`;

    }


    /*
    |--------------------------------------------------------------------------
    | Transfer Cart Counter
    |--------------------------------------------------------------------------
    */

    if (this.elements.cartCount) {

        this.elements.cartCount.textContent =
            count;

    }


    /*
    |--------------------------------------------------------------------------
    | Add Selected Button
    |--------------------------------------------------------------------------
    */

    if (this.elements.addSelectedToCart) {

        this.elements.addSelectedToCart.disabled =
            count === 0;

    }

},

addProductFromButton(button) {

    const product =
        this.getProductFromButton(
            button
        );


    if (!product) {

        return;

    }


    const existing =
        this.state.selectedProducts.find(
            item =>
                String(item.stock_id) ===
                String(product.stock_id)
        );


    if (existing) {

        showToast(
            `${product.name} is already in the transfer cart.`,
            'warning'
        );

        return;

    }


    if (product.available <= 0) {

        showToast(
            `${product.name} has no available stock.`,
            'warning'
        );

        return;

    }


    this.state.selectedProducts.push(
        product
    );


    /*
    |--------------------------------------------------------------------------
    | Immediately update both counters
    |--------------------------------------------------------------------------
    */

    this.updateSelectionCounters();


    /*
    |--------------------------------------------------------------------------
    | Sync table checkbox
    |--------------------------------------------------------------------------
    */

    this.syncVisibleSelections();


    /*
    |--------------------------------------------------------------------------
    | Render Cart
    |--------------------------------------------------------------------------
    */

    this.renderCart();


    showToast(
        `${product.name} added to transfer cart.`,
        'success'
    );

},

    /*
    |--------------------------------------------------------------------------
    | Sync Visible Selections
    |--------------------------------------------------------------------------
    */

    /*
|--------------------------------------------------------------------------
| Sync Visible Selections
|--------------------------------------------------------------------------
*/

syncVisibleSelections() {

    if (!this.elements.tableContainer) {

        return;

    }


    const selectedIds =
        new Set(
            this.state.selectedProducts.map(
                product =>
                    String(
                        product.stock_id
                    )
            )
        );


    this.elements.tableContainer
        .querySelectorAll(
            '.stock-transfer-checkbox'
        )
        .forEach(
            checkbox => {

                checkbox.checked =
                    selectedIds.has(
                        String(
                            checkbox.dataset.stockId
                        )
                    );

            }
        );


    this.updateSelectAllState();

},


    /*
    |--------------------------------------------------------------------------
    | Select All State
    |--------------------------------------------------------------------------
    */

    /*
|--------------------------------------------------------------------------
| Select All State
|--------------------------------------------------------------------------
*/

updateSelectAllState() {

    const selectAll =
        this.elements.selectAll;


    if (!selectAll) {

        return;

    }


    const checkboxes =
        this.elements.tableContainer?.querySelectorAll(
            '.stock-transfer-checkbox'
        );


    if (!checkboxes || !checkboxes.length) {

        selectAll.checked = false;

        selectAll.indeterminate = false;

        return;

    }


    let checkedCount = 0;


    checkboxes.forEach(
        (checkbox) => {

            if (checkbox.checked) {

                checkedCount++;

            }

        }
    );


    if (
        checkedCount ===
        checkboxes.length
    ) {

        selectAll.checked = true;

        selectAll.indeterminate = false;

        return;

    }


    if (checkedCount === 0) {

        selectAll.checked = false;

        selectAll.indeterminate = false;

        return;

    }


    selectAll.checked = false;

    selectAll.indeterminate = true;

},


    /*
    |--------------------------------------------------------------------------
    | Open Transfer Modal
    |--------------------------------------------------------------------------
    */

    /*
|--------------------------------------------------------------------------
| Open Transfer Modal
|--------------------------------------------------------------------------
*/

openTransferModal() {

    if (
        !this.state.selectedProducts.length
    ) {

        showToast(
            'Please select at least one product to transfer.',
            'warning'
        );

        return;

    }


    if (
        !this.validateCart()
    ) {

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Render Current Selection
    |--------------------------------------------------------------------------
    */

    this.renderTransferItems();


    /*
    |--------------------------------------------------------------------------
    | Reset Destination
    |--------------------------------------------------------------------------
    */

    if (this.elements.destinationBranch) {

        this.elements.destinationBranch.value =
            '';

    }


    this.state.destinationBranchId =
        null;


    /*
    |--------------------------------------------------------------------------
    | Open Modal
    |--------------------------------------------------------------------------
    */

    if (this.transferModal) {

        this.transferModal.show();

    }

},

    /*
    |--------------------------------------------------------------------------
    | Validate Cart
    |--------------------------------------------------------------------------
    */

    validateCart() {

        for (
            const product
            of this.state.selectedProducts
        ) {

            const quantity =
                parseFloat(
                    product.quantity
                );


            const available =
                parseFloat(
                    product.available
                );


            if (
                !quantity ||
                quantity <= 0
            ) {

                showToast(
                    `Enter a valid quantity for ${product.name}.`,
                    'warning'
                );

                return false;

            }


            if (
                quantity >
                available
            ) {

                showToast(
                    `${product.name} exceeds available stock.`,
                    'warning'
                );

                return false;

            }

        }


        return true;

    },


    /*
|--------------------------------------------------------------------------
| Render Transfer Items
|--------------------------------------------------------------------------
*/

renderTransferItems() {

    const container =
        this.elements.transferItemsContainer;


    if (!container) {

        return;

    }


    const products =
        this.state.selectedProducts;


    /*
    |--------------------------------------------------------------------------
    | Product Count
    |--------------------------------------------------------------------------
    */

    console.log(
        'Selected products at counter:',
        products
    );

    console.log(
        'Selected product count:',
        products.length
    );

    console.log(
    'Counter element:',
    this.elements.transferModalProductCount
);

    const count =
        products.length;

    if (this.elements.transferModalProductCount) {

        this.elements.transferModalProductCount.textContent =
            `${count} ${count === 1 ? 'product' : 'products'}`;

    }
    


    /*
    |--------------------------------------------------------------------------
    | Total Quantity
    |--------------------------------------------------------------------------
    */

    const totalQuantity =
        products.reduce(
            (
                total,
                product
            ) => {

                return total +
                    (
                        parseFloat(
                            product.quantity
                        ) || 0
                    );

            },
            0
        );


    if (this.elements.transferModalTotalQuantity) {

        this.elements.transferModalTotalQuantity.textContent =
            this.formatNumber(
                totalQuantity
            );

    }


    /*
    |--------------------------------------------------------------------------
    | Empty State
    |--------------------------------------------------------------------------
    */

    if (!products.length) {

        container.innerHTML = `

            <div class="stock-empty-state">

                <i class="bi bi-box-seam"></i>

                <h6>
                    No products selected
                </h6>

                <p>
                    Select products from the stock table
                    before starting a transfer.
                </p>

            </div>

        `;

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Clear Existing Items
    |--------------------------------------------------------------------------
    */

    container.innerHTML = '';


    /*
    |--------------------------------------------------------------------------
    | Render Selected Products
    |--------------------------------------------------------------------------
    */

    products.forEach(
        (product) => {

            const available =
                parseFloat(
                    product.available
                ) || 0;


            let quantity =
                parseFloat(
                    product.quantity
                ) || 1;


            /*
            |--------------------------------------------------------------------------
            | Make Sure Quantity Never Exceeds Available Stock
            |--------------------------------------------------------------------------
            */

            if (quantity > available) {

                quantity =
                    available;

                product.quantity =
                    available;

            }


            if (quantity <= 0) {

                quantity = 1;

                if (available > 0) {

                    product.quantity =
                        1;

                }

            }


            const row =
                document.createElement(
                    'div'
                );


            row.className =
                'transfer-confirm-item';


            row.dataset.stockId =
                product.stock_id;


          
            row.innerHTML = `

                <div class="stock-transfer-review-image">

                    ${
                        product.image
                            ? `
                                <img
                                    src="${this.escapeHtml(product.image)}"
                                    alt="${this.escapeHtml(product.name || '')}"
                                >
                            `
                            : `
                                <i class="bi bi-box"></i>
                            `
                    }

                </div>


                <div class="stock-transfer-review-info">

                    <strong>
                        ${this.escapeHtml(
                            product.name || '-'
                        )}
                    </strong>


                    <small>
                        SKU:
                        <strong>
                            ${this.escapeHtml(
                                product.sku || '-'
                            )}
                        </strong>
                    </small>


                    <div class="stock-transfer-review-available">

                        <span>
                            Available
                        </span>

                        <strong>
                            ${this.formatNumber(
                                available
                            )}
                        </strong>

                    </div>


                    <div class="stock-transfer-review-quantity">

                        <label>
                            Transfer Qty
                        </label>

                        <input
                            type="number"
                            class="form-control transfer-transfer-quantity"
                            data-stock-id="${this.escapeHtml(product.stock_id)}"
                            value="${this.formatQuantity(quantity)}"
                            min="0.01"
                            max="${available}"
                            step="0.01"
                        >

                        <small class="text-muted d-block mt-1">
                            Max:
                            ${this.formatNumber(available)}
                        </small>

                    </div>

                </div>

            `;
            container.appendChild(
                row
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Update Summary
    |--------------------------------------------------------------------------
    */

    this.updateTransferModalSummary();

},


/*
|--------------------------------------------------------------------------
| Update Transfer Modal Summary
|--------------------------------------------------------------------------
*/

updateTransferModalSummary() {

    const products =
        this.state.selectedProducts;


    const count =
        products.length;


    const totalQuantity =
        products.reduce(
            (
                total,
                product
            ) => {

                return total +
                    (
                        parseFloat(
                            product.quantity
                        ) || 0
                    );

            },
            0
        );


    /*
    |--------------------------------------------------------------------------
    | Product Count
    |--------------------------------------------------------------------------
    */

    if (this.elements.transferModalProductCount) {

        this.elements.transferModalProductCount.textContent =
            `${count} ${count === 1 ? 'product' : 'products'}`;

    }


    /*
    |--------------------------------------------------------------------------
    | Total Quantity
    |--------------------------------------------------------------------------
    */

    if (this.elements.transferModalTotalQuantity) {

        this.elements.transferModalTotalQuantity.textContent =
            this.formatNumber(
                totalQuantity
            );

    }

},

/*
|--------------------------------------------------------------------------
| Update Transfer Quantity
|--------------------------------------------------------------------------
*/

updateTransferQuantity(input) {

    if (!input) {

        return;

    }


    const stockId =
        input.dataset.stockId;


    const product =
        this.state.selectedProducts.find(
            item =>
                String(item.stock_id) ===
                String(stockId)
        );


    if (!product) {

        return;

    }


    const available =
        parseFloat(
            product.available
        ) || 0;


    let quantity =
        parseFloat(
            input.value
        );


    /*
    |--------------------------------------------------------------------------
    | Invalid Quantity
    |--------------------------------------------------------------------------
    */

    if (
        Number.isNaN(quantity) ||
        quantity <= 0
    ) {

        quantity = 1;

    }


    /*
    |--------------------------------------------------------------------------
    | Maximum Available Quantity
    |--------------------------------------------------------------------------
    */

    if (
        quantity >
        available
    ) {

        quantity =
            available;


        showToast(
            `Maximum available stock for ${product.name} is ${this.formatNumber(available)}.`,
            'warning'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Update State
    |--------------------------------------------------------------------------
    */

    product.quantity =
        quantity;


    /*
    |--------------------------------------------------------------------------
    | Update Input
    |--------------------------------------------------------------------------
    */

    input.value =
        this.formatQuantity(
            quantity
        );


    /*
    |--------------------------------------------------------------------------
    | Update Modal Total
    |--------------------------------------------------------------------------
    */

    this.updateTransferModalSummary();

},


    /*
    |--------------------------------------------------------------------------
    | Submit Transfer
    |--------------------------------------------------------------------------
    */

    async submitTransfer() {

        if (this.state.submitting) {

            return;

        }


        if (
            !this.validateCart()
        ) {

            return;

        }


        const destination =
            this.elements.destinationBranch?.value;


        if (!destination) {

            showToast(
                'Please select a destination branch.',
                'warning'
            );

            return;

        }


        const button =
            this.elements.submitTransfer;


        const originalHtml =
            button?.innerHTML;


        this.state.submitting =
            true;


        try {

            if (button) {

                button.disabled = true;

                button.innerHTML = `

                    <span
                        class="spinner-border spinner-border-sm me-2"
                    ></span>

                    Transferring...

                `;

            }


            const payload = {

                branch_id:
                    destination,

                reference_no:
                    this.elements.referenceNo?.value ||
                    null,

                remarks:
                    this.elements.remarks?.value ||
                    null,

                products:
                    this.state.selectedProducts.map(
                        product => ({

                            stock_id:
                                product.stock_id,

                            product_id:
                                product.product_id,

                            quantity:
                                parseFloat(
                                    product.quantity
                                ),

                        })
                    ),

            };


            const response =
                await fetch(
                    this.transferUrl(),
                    {
                        method: 'POST',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'X-CSRF-TOKEN':
                                this.csrfToken(),

                            'X-Requested-With':
                                'XMLHttpRequest',

                            'Accept':
                                'application/json',

                        },

                        body:
                            JSON.stringify(
                                payload
                            ),

                    }
                );


            const data =
                await response.json();


            if (
                !response.ok ||
                !data.success
            ) {

                throw new Error(
                    data.message ||
                    'Stock transfer failed.'
                );

            }


            if (this.transferModal) {

                this.transferModal.hide();

            }


            showToast(
                data.message ||
                'Stock transferred successfully.',
                'success'
            );


            this.state.selectedProducts =
                [];


            this.state.destinationBranchId =
                null;


            this.resetTransferForm();

            this.renderCart();

            this.syncVisibleSelections();

            this.loadTable();

        }
        catch (error) {

            console.error(
                'Stock transfer error:',
                error
            );


            showToast(
                error.message ||
                'Unable to complete stock transfer.',
                'danger'
            );

        }
        finally {

            this.state.submitting =
                false;


            if (button) {

                button.disabled = false;

                button.innerHTML =
                    originalHtml;

            }

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Reset Transfer Form
    |--------------------------------------------------------------------------
    */

    resetTransferForm() {

        if (this.elements.transferForm) {

            this.elements.transferForm.reset();

        }


        if (this.elements.transferItemsContainer) {

            this.elements.transferItemsContainer.innerHTML =
                '';

        }


        this.state.destinationBranchId =
            null;

    },


    /*
    |--------------------------------------------------------------------------
    | Open History Modal
    |--------------------------------------------------------------------------
    */

    async openHistoryModal(productId) {

        if (!productId) {

            return;

        }


        this.showHistoryLoading();


        if (this.historyModal) {

            this.historyModal.show();

        }


        try {

            const response =
                await fetch(
                    this.historyUrl(
                        productId
                    ),
                    {
                        method: 'GET',

                        headers: {

                            'X-Requested-With':
                                'XMLHttpRequest',

                            'Accept':
                                'application/json',

                        },

                    }
                );


            const data =
                await response.json();


            if (
                !response.ok ||
                !data.success
            ) {

                throw new Error(
                    data.message ||
                    'Unable to load transfer history.'
                );

            }


            const product =
                data.data?.product ||
                {};


            if (
                this.elements.historyProductName
            ) {

                this.elements.historyProductName.textContent =
                    product.name || '-';

            }


            if (
                this.elements.historyProductSku
            ) {

                this.elements.historyProductSku.textContent =
                    product.sku || '-';

            }


            this.renderHistory(
                data.data?.history ||
                []
            );

        }
        catch (error) {

            console.error(
                'Transfer history error:',
                error
            );


            if (
                this.elements.historyContainer
            ) {

                this.elements.historyContainer.innerHTML = `

                    <div class="stock-empty-state">

                        <i class="bi bi-exclamation-circle"></i>

                        <h6>
                            Unable to load transfer history
                        </h6>

                        <p>
                            ${this.escapeHtml(
                                error.message ||
                                'Please try again.'
                            )}
                        </p>

                    </div>

                `;

            }

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Render History
    |--------------------------------------------------------------------------
    */

    renderHistory(history) {

        const container =
            this.elements.historyContainer;


        if (!container) {

            return;

        }


        if (!history.length) {

            container.innerHTML = `

                <div class="stock-empty-state">

                    <i class="bi bi-clock-history"></i>

                    <h6>
                        No transfer history
                    </h6>

                    <p>
                        No stock transfers have been recorded for this product.
                    </p>

                </div>

            `;

            return;

        }


        let rows = '';


        history.forEach(
            (item) => {

                rows += `

                    <tr>

                        <td>

                            <span class="badge bg-primary-subtle text-primary">

                                Transfer

                            </span>

                        </td>


                        <td>

                            ${this.escapeHtml(
                                item.from?.name ||
                                '-'
                            )}

                        </td>


                        <td>

                            ${this.escapeHtml(
                                item.to?.name ||
                                '-'
                            )}

                        </td>


                        <td>

                            <strong>

                                ${this.formatNumber(
                                    item.quantity
                                )}

                            </strong>

                        </td>


                        <td>

                            ${this.escapeHtml(
                                item.reference_no ||
                                '-'
                            )}

                        </td>


                        <td>

                            ${this.escapeHtml(
                                item.user ||
                                '-'
                            )}

                        </td>


                        <td>

                            ${this.escapeHtml(
                                item.date ||
                                '-'
                            )}

                        </td>


                        <td>

                            ${this.escapeHtml(
                                item.remarks ||
                                '-'
                            )}

                        </td>

                    </tr>

                `;

            }
        );


        container.innerHTML = `

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead>

                        <tr>

                            <th>
                                Type
                            </th>

                            <th>
                                From
                            </th>

                            <th>
                                To
                            </th>

                            <th>
                                Quantity
                            </th>

                            <th>
                                Reference
                            </th>

                            <th>
                                User
                            </th>

                            <th>
                                Date
                            </th>

                            <th>
                                Remarks
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        ${rows}

                    </tbody>

                </table>

            </div>

        `;

    },


    /*
    |--------------------------------------------------------------------------
    | History Loading
    |--------------------------------------------------------------------------
    */

    showHistoryLoading() {

        if (
            !this.elements.historyContainer
        ) {

            return;

        }


        this.elements.historyContainer.innerHTML = `

            <div class="stock-transfer-loading">

                <div
                    class="spinner-border spinner-border-sm"
                    role="status"
                ></div>

                <span>
                    Loading transfer history...
                </span>

            </div>

        `;

    },


    /*
    |--------------------------------------------------------------------------
    | KPI
    |--------------------------------------------------------------------------
    */

    updateKpis() {

        const table =
            this.elements.tableContainer;


        if (!table) {

            return;

        }


        const rows =
            table.querySelectorAll(
                'tbody tr'
            );


        let products = 0;

        let available = 0;

        let lowStock = 0;

        let outStock = 0;


        rows.forEach(
            row => {

                const checkbox =
                    row.querySelector(
                        '.transfer-product-checkbox'
                    );


                if (!checkbox) {

                    return;

                }


                products++;


                const quantity =
                    parseFloat(
                        checkbox.dataset.available ||
                        row.dataset.available ||
                        0
                    );


                available +=
                    quantity;


                const status =
                    (
                        checkbox.dataset.status ||
                        row.dataset.status ||
                        ''
                    ).toLowerCase();


                if (
                    status === 'low_stock'
                ) {

                    lowStock++;

                }


                if (
                    status === 'out_stock'
                ) {

                    outStock++;

                }

            }
        );


        if (this.elements.productCount) {

            this.elements.productCount.textContent =
                products;

        }


        if (this.elements.availableStock) {

            this.elements.availableStock.textContent =
                this.formatNumber(
                    available
                );

        }


        if (this.elements.lowStock) {

            this.elements.lowStock.textContent =
                lowStock;

        }


        if (this.elements.outStock) {

            this.elements.outStock.textContent =
                outStock;

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Get Cell Text
    |--------------------------------------------------------------------------
    */

    getCellText(row, selector) {

        const element =
            row.querySelector(
                selector
            );


        return element
            ? element.textContent.trim()
            : '';

    },


    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    */

    tableUrl() {

        return (
            window.STOCK_TRANSFER_TABLE_URL ||
            '/admin/stock-transfer/table'
        );

    },


    transferUrl() {

        return (
            window.STOCK_TRANSFER_TRANSFER_URL ||
            '/admin/stock-transfer/transfer'
        );

    },


    historyUrl(productId) {

        return (
            window.STOCK_TRANSFER_HISTORY_URL ||
            '/admin/stock-transfer/history/:id'
        ).replace(
            ':id',
            productId
        );

    },


    /*
    |--------------------------------------------------------------------------
    | CSRF
    |--------------------------------------------------------------------------
    */

    csrfToken() {

        const meta =
            document.querySelector(
                'meta[name="csrf-token"]'
            );


        return meta
            ? meta.getAttribute('content')
            : '';

    },


    /*
    |--------------------------------------------------------------------------
    | Formatting
    |--------------------------------------------------------------------------
    */

    formatNumber(value) {

        return new Intl.NumberFormat(
            'en-US',
            {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }
        ).format(
            parseFloat(value) || 0
        );

    },


    formatQuantity(value) {

        const number =
            parseFloat(value) || 0;


        return Number.isInteger(number)
            ? String(number)
            : number.toFixed(2);

    },


    /*
    |--------------------------------------------------------------------------
    | Escape HTML
    |--------------------------------------------------------------------------
    */

    escapeHtml(value) {

        const div =
            document.createElement(
                'div'
            );


        div.textContent =
            value ?? '';


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

        StockTransfer.init();

    }
);
