 /**
 * ============================================================================
 * EMNEX POS - MODERN POINT OF SALE
 * ============================================================================
 */

const POS = {

    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    state: {

        productsPage: 1,

        productsSearch: '',

        categoryId: '',

        productsPagination: null,

        categories: [],

        products: [],

        cart: [],

        selectedCustomer: null,

        selectedDiscount: null,

        selectedTaxRate: null,

        discounts: [],

        taxRates: [],

        heldSales: [],

        heldSalesPage: 1,

        heldSalesSearch: '',

        selectedProduct: null,

        selectedPaymentMethod: 'Cash',

        paymentAmount: 0,

        paymentReference: '',

        paymentRemarks: '',

        currentOrder: null,

        selectedOrderId: null,

        searchTimer: null,

        customerSearchTimer: null,

        heldSearchTimer: null,

        isSaving: false,

        salesHistoryPage: 1,

        salesHistorySearch: '',

        salesHistoryTimer: null,

    },


    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    elements: {},


    /*
    |--------------------------------------------------------------------------
    | Modals / Inspector
    |--------------------------------------------------------------------------
    */

    modals: {},

    productInspector: null,


   /*
    |--------------------------------------------------------------------------
    | Init
    |--------------------------------------------------------------------------
    */

    async init() {

        this.cacheElements();

        this.initializeComponents();

        this.bindEvents();

        this.initializeContext();

        /*
        |--------------------------------------------------------------------------
        | Fullscreen
        |--------------------------------------------------------------------------
        |
        | Fullscreen is owned by the cashier shell.
        | Do not initialize it again when this page is loaded
        | inside the cashier shell iframe.
        |
        */

        if (
            window.self === window.top
        ) {

            this.initializeFullscreen();

        }


        await Promise.all([

            this.loadCategories(),

            this.loadProducts(),

            this.loadDiscounts(),

            this.loadTaxRates(),

        ]);

    },

    /*
    |--------------------------------------------------------------------------
    | Cache Elements
    |--------------------------------------------------------------------------
    */

    cacheElements() {

        this.elements = {

            /*
            |--------------------------------------------------------------------------
            | Fullscreen
            |--------------------------------------------------------------------------
            */

            fullscreenOverlay:
                document.getElementById(
                    'pos-fullscreen-overlay'
                ),

            enterFullscreenButton:
                document.getElementById(
                    'pos-enter-fullscreen'
                ),

            /*
            |--------------------------------------------------------------------------
            | Context
            |--------------------------------------------------------------------------
            */

            branchName:
                document.getElementById(
                    'pos-branch-name'
                ),

            terminalName:
                document.getElementById(
                    'pos-terminal-name'
                ),

            cashierName:
                document.getElementById(
                    'pos-cashier-name'
                ),

            drawerStatus:
                document.getElementById(
                    'pos-drawer-status'
                ),


            /*
            |--------------------------------------------------------------------------
            | Product Search
            |--------------------------------------------------------------------------
            */

            productSearch:
                document.getElementById(
                    'pos-product-search'
                ),

            productSearchClear:
                document.getElementById(
                    'pos-product-search-clear'
                ),

            barcodeButton:
                document.getElementById(
                    'pos-barcode-btn'
                ),

            refreshProducts:
                document.getElementById(
                    'pos-refresh-products'
                ),

            searchResults:
                document.getElementById(
                    'pos-search-results'
                ),


            /*
            |--------------------------------------------------------------------------
            | Categories
            |--------------------------------------------------------------------------
            */

            categoryList:
                document.getElementById(
                    'pos-category-list'
                ),

            categoryPrev:
                document.getElementById(
                    'pos-category-prev'
                ),

            categoryNext:
                document.getElementById(
                    'pos-category-next'
                ),


            /*
            |--------------------------------------------------------------------------
            | Products
            |--------------------------------------------------------------------------
            */

            productGrid:
                document.getElementById(
                    'pos-product-grid'
                ),

            productPagination:
                document.getElementById(
                    'pos-product-pagination'
                ),


            /*
            |--------------------------------------------------------------------------
            | Sale Header
            |--------------------------------------------------------------------------
            */

            heldSalesButton:
                document.getElementById(
                    'pos-held-sales-btn'
                ),

            heldSalesCount:
                document.getElementById(
                    'pos-held-sales-count'
                ),

            customerHeaderButton:
                document.getElementById(
                    'pos-customer-header-btn'
                ),

            closeButton:
                document.getElementById(
                    'pos-close-btn'
                ),
                


            /*
            |--------------------------------------------------------------------------
            | Cart
            |--------------------------------------------------------------------------
            */

            holdSaleButton:
                document.getElementById(
                    'pos-hold-sale-btn'
                ),

            clearCart:
                document.getElementById(
                    'pos-clear-cart'
                ),

            customerSelector:
                document.getElementById(
                    'pos-customer-selector'
                ),

            selectedCustomerName:
                document.getElementById(
                    'pos-selected-customer-name'
                ),

            selectedCustomerDetail:
                document.getElementById(
                    'pos-selected-customer-detail'
                ),

            cart:
                document.getElementById(
                    'pos-cart'
                ),

            cartItemCount:
                document.getElementById(
                    'pos-cart-item-count'
                ),

            cartQuantity:
                document.getElementById(
                    'pos-cart-quantity'
                ),


            /*
            |--------------------------------------------------------------------------
            | Adjustments
            |--------------------------------------------------------------------------
            */

            discountButton:
                document.getElementById(
                    'pos-discount-btn'
                ),

            taxButton:
                document.getElementById(
                    'pos-tax-btn'
                ),

            discountDisplay:
                document.getElementById(
                    'pos-discount-display'
                ),

            taxDisplay:
                document.getElementById(
                    'pos-tax-display'
                ),

            /*
            |--------------------------------------------------------------------------
            | Approval
            |--------------------------------------------------------------------------
            */

            approvalAction:
                document.getElementById(
                    'pos-approval-action'
                ),

            approvalUser:
                document.getElementById(
                    'pos-approval-user'
                ),

            approvalPassword:
                document.getElementById(
                    'pos-approval-password'
                ),

            approvalPasswordToggle:
                document.getElementById(
                    'pos-approval-password-toggle'
                ),

            approvalSubmit:
                document.getElementById(
                    'pos-approval-submit'
                ),


            /*
            |--------------------------------------------------------------------------
            | Summary
            |--------------------------------------------------------------------------
            */

            subtotal:
                document.getElementById(
                    'pos-subtotal'
                ),

            summaryDiscount:
                document.getElementById(
                    'pos-summary-discount'
                ),

            summaryTax:
                document.getElementById(
                    'pos-summary-tax'
                ),

            grandTotal:
                document.getElementById(
                    'pos-grand-total'
                ),

            payTotal:
                document.getElementById(
                    'pos-pay-total'
                ),

            payButton:
                document.getElementById(
                    'pos-pay-btn'
                ),


            /*
            |--------------------------------------------------------------------------
            | Secondary Actions
            |--------------------------------------------------------------------------
            */

            saveOrderButton:
                document.getElementById(
                    'pos-save-order-btn'
                ),

            printPreviewButton:
                document.getElementById(
                    'pos-print-preview-btn'
                ),


            /*
            |--------------------------------------------------------------------------
            | Customer Modal
            |--------------------------------------------------------------------------
            */

            customerSearch:
                document.getElementById(
                    'pos-customer-search'
                ),

            customerResults:
                document.getElementById(
                    'pos-customer-results'
                ),

            walkInCustomer:
                document.getElementById(
                    'pos-walk-in-customer'
                ),

            newCustomer:
                document.getElementById(
                    'pos-new-customer'
                ),


            /*
            |--------------------------------------------------------------------------
            | Payment Modal
            |--------------------------------------------------------------------------
            */

            paymentTotal:
                document.getElementById(
                    'pos-payment-total'
                ),

            paymentAmount:
                document.getElementById(
                    'pos-payment-amount'
                ),

            paymentChange:
                document.getElementById(
                    'pos-payment-change'
                ),

            paymentReference:
                document.getElementById(
                    'pos-payment-reference'
                ),

            paymentRemarks:
                document.getElementById(
                    'pos-payment-remarks'
                ),

            completePayment:
                document.getElementById(
                    'pos-complete-payment'
                ),

            cashPaymentPanel:
                document.getElementById(
                    'pos-cash-payment-panel'
                ),

            otherPaymentPanel:
                document.getElementById(
                    'pos-other-payment-panel'
                ),


            /*
            |--------------------------------------------------------------------------
            | Held Sales Modal
            |--------------------------------------------------------------------------
            */

            heldSalesSearch:
                document.getElementById(
                    'pos-held-sales-search'
                ),

            heldSalesList:
                document.getElementById(
                    'pos-held-sales-list'
                ),

            heldSalesPagination:
                document.getElementById(
                    'pos-held-sales-pagination'
                ),


            /*
            |--------------------------------------------------------------------------
            | Discount Modal
            |--------------------------------------------------------------------------
            */

            discountList:
                document.getElementById(
                    'pos-discount-list'
                ),

            applyDiscount:
                document.getElementById(
                    'pos-apply-discount'
                ),


            /*
            |--------------------------------------------------------------------------
            | Sale Complete Modal
            |--------------------------------------------------------------------------
            */

            completeTotal:
                document.getElementById(
                    'pos-complete-total'
                ),

            completeOrderNo:
                document.getElementById(
                    'pos-complete-order-no'
                ),

            completePaymentMethod:
                document.getElementById(
                    'pos-complete-payment-method'
                ),

            completeChange:
                document.getElementById(
                    'pos-complete-change'
                ),

            completePrint:
                document.getElementById(
                    'pos-complete-print'
                ),

            completeNewSale:
                document.getElementById(
                    'pos-complete-new-sale'
                ),


            /*
            |--------------------------------------------------------------------------
            | Product Inspector
            |--------------------------------------------------------------------------
            */

            inspectorProductImage:
                document.getElementById(
                    'pos-inspector-product-image'
                ),

            inspectorProductName:
                document.getElementById(
                    'pos-inspector-product-name'
                ),

            inspectorProductCode:
                document.getElementById(
                    'pos-inspector-product-code'
                ),

            inspectorSellingPrice:
                document.getElementById(
                    'pos-inspector-selling-price'
                ),

            inspectorStock:
                document.getElementById(
                    'pos-inspector-stock'
                ),

            inspectorUnit:
                document.getElementById(
                    'pos-inspector-unit'
                ),

            inspectorCategory:
                document.getElementById(
                    'pos-inspector-category'
                ),

            inspectorSku:
                document.getElementById(
                    'pos-inspector-sku'
                ),

            inspectorBarcode:
                document.getElementById(
                    'pos-inspector-barcode'
                ),

            inspectorAddProduct:
                document.getElementById(
                    'pos-inspector-add-product'
                ),

            /*
        |--------------------------------------------------------------------------
        | Sales History
        |--------------------------------------------------------------------------
        */

        salesHistoryButton:
            document.getElementById(
                'pos-sales-history-btn'
            ),

        salesHistorySearch:
            document.getElementById(
                'pos-sales-history-search'
            ),

        salesHistoryBody:
            document.getElementById(
                'pos-sales-history-body'
            ),

        salesHistoryPagination:
            document.getElementById(
                'pos-sales-history-pagination'
            ),

        historyTotalSales:
            document.getElementById(
                'pos-history-total-sales'
            ),

        historyTransactionCount:
            document.getElementById(
                'pos-history-transaction-count'
            ),

        historyAverageSale:
            document.getElementById(
                'pos-history-average-sale'
            ),

        historyCashSales:
            document.getElementById(
                'pos-history-cash-sales'
            ),

        historyCash:
            document.getElementById(
                'pos-history-cash'
            ),

        historyCard:
            document.getElementById(
                'pos-history-card'
            ),

        historyTransfer:
            document.getElementById(
                'pos-history-transfer'
            ),

        historyWallet:
            document.getElementById(
                'pos-history-wallet'
            ),

        };

    },


    /*
    |--------------------------------------------------------------------------
    | Components
    |--------------------------------------------------------------------------
    */

    initializeComponents() {

        this.modals = {

            customer:
                this.getModal(
                    'posCustomerModal'
                ),

            payment:
                this.getModal(
                    'posPaymentModal'
                ),

            heldSales:
                this.getModal(
                    'posHeldSalesModal'
                ),

            discount:
                this.getModal(
                    'posDiscountModal'
                ),

            saleComplete:
                this.getModal(
                    'posSaleCompleteModal'
                ),

            approval:
                this.getModal(
                    'posApprovalModal'
                ),

            salesHistory:
                this.getModal(
                    'posSalesHistoryModal'
                ),

        };


        this.productInspector =
            this.getOffcanvas(
                'posProductInspector'
            );           

    },


    getModal(id) {

        const element =
            document.getElementById(
                id
            );

        if (!element) {
            return null;
        }

        return bootstrap.Modal.getOrCreateInstance(
            element
        );

    },


    getOffcanvas(id) {

        const element =
            document.getElementById(
                id
            );

        if (!element) {
            return null;
        }

        return bootstrap.Offcanvas.getOrCreateInstance(
            element
        );

    },

     


    /*
    |--------------------------------------------------------------------------
    | Context
    |--------------------------------------------------------------------------
    */

    initializeContext() {

        if (
            this.elements.branchName
            && window.PosConfig?.branchId
        ) {
            this.elements.branchName.dataset.branchId =
                window.PosConfig.branchId;
        }


        if (
            this.elements.terminalName
            && window.PosConfig?.terminalId
        ) {
            this.elements.terminalName.dataset.terminalId =
                window.PosConfig.terminalId;
        }


        if (
            this.elements.drawerStatus
        ) {

            this.elements.drawerStatus.classList.remove(
                'd-none'
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

    bindEvents() {

        this.elements.enterFullscreenButton?.addEventListener(
            'click',
            () => this.enterFullscreen()
        );

        document.addEventListener(
            'DOMContentLoaded',
            () => {

                document
                    .getElementById('pos-close-btn')
                    ?.addEventListener(
                        'click',
                        async event => {

                            event.preventDefault();


                            const url =
                                event.currentTarget.href;


                            try {

                                if (
                                    document.fullscreenElement
                                ) {

                                    await document.exitFullscreen();

                                }

                            } catch (error) {

                                console.warn(
                                    'Unable to exit fullscreen:',
                                    error
                                );

                            }


                            window.location.href =
                                url;

                        }
                    );

            }
        );

        /*
        |--------------------------------------------------------------------------
        | Product Search
        |--------------------------------------------------------------------------
        */

        this.elements.productSearch?.addEventListener(
            'input',
            () => {

                clearTimeout(
                    this.state.searchTimer
                );

                const value =
                    this.elements.productSearch.value
                        .trim();


                this.toggle(
                    this.elements.productSearchClear,
                    value.length > 0
                );


                this.state.searchTimer =
                    setTimeout(
                        () => {

                            this.state.productsSearch =
                                value;

                            this.state.productsPage =
                                1;

                            this.hideSearchResults();

                            this.loadProducts();

                        },
                        300
                    );

            }
        );


        this.elements.salesHistoryButton?.addEventListener(
            'click',
            () => this.openSalesHistory()
        );


        this.elements.salesHistorySearch?.addEventListener(
            'input',
            () => {

                clearTimeout(
                    this.state.salesHistoryTimer
                );

                this.state.salesHistoryTimer =
                    setTimeout(
                        () => {

                            this.state.salesHistorySearch =
                                this.elements.salesHistorySearch.value
                                    .trim();

                            this.state.salesHistoryPage =
                                1;

                            this.loadSalesHistory();

                        },
                        300
                    );

            }
        );


        this.elements.productSearch?.addEventListener(
            'keydown',
            event => {

                if (
                    event.key === 'Enter'
                ) {

                    event.preventDefault();

                    this.lookupBarcodeOrSearch();

                }

            }
        );


        this.elements.productSearchClear?.addEventListener(
            'click',
            () => {

                this.elements.productSearch.value =
                    '';

                this.state.productsSearch =
                    '';

                this.state.productsPage =
                    1;

                this.toggle(
                    this.elements.productSearchClear,
                    false
                );

                this.loadProducts();

            }
        );


        this.elements.refreshProducts?.addEventListener(
            'click',
            () => {

                this.loadProducts();

            }
        );


        this.elements.barcodeButton?.addEventListener(
            'click',
            () => {

                this.focusProductSearch();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Category Navigation
        |--------------------------------------------------------------------------
        */

        this.elements.categoryPrev?.addEventListener(
            'click',
            () => {

                this.elements.categoryList?.scrollBy({

                    left: -220,

                    behavior: 'smooth',

                });

            }
        );


        this.elements.categoryNext?.addEventListener(
            'click',
            () => {

                this.elements.categoryList?.scrollBy({

                    left: 220,

                    behavior: 'smooth',

                });

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Customer
        |--------------------------------------------------------------------------
        */

        this.elements.customerSelector?.addEventListener(
            'click',
            () => this.openCustomerModal()
        );


        this.elements.customerHeaderButton?.addEventListener(
            'click',
            () => this.openCustomerModal()
        );


        this.elements.customerSearch?.addEventListener(
            'input',
            () => {

                clearTimeout(
                    this.state.customerSearchTimer
                );

                this.state.customerSearchTimer =
                    setTimeout(
                        () => {

                            this.loadCustomers();

                        },
                        300
                    );

            }
        );


        this.elements.walkInCustomer?.addEventListener(
            'click',
            () => {

                this.selectCustomer(
                    null
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Cart
        |--------------------------------------------------------------------------
        */

        this.elements.clearCart?.addEventListener(
            'click',
            () => this.clearSale()
        );


        this.elements.holdSaleButton?.addEventListener(
            'click',
            () => this.holdSale()
        );

        this.elements.approvalSubmit?.addEventListener(
            'click',
            () => this.approveAdjustment()
        );

        this.elements.approvalPasswordToggle?.addEventListener(
            'click',
            () => {

                const input =
                    this.elements.approvalPassword;

                if (!input) {
                    return;
                }


                const icon =
                    this.elements.approvalPasswordToggle
                        .querySelector('i');


                if (
                    input.type === 'password'
                ) {

                    input.type =
                        'text';

                    icon?.classList.remove(
                        'bi-eye'
                    );

                    icon?.classList.add(
                        'bi-eye-slash'
                    );

                } else {

                    input.type =
                        'password';

                    icon?.classList.remove(
                        'bi-eye-slash'
                    );

                    icon?.classList.add(
                        'bi-eye'
                    );

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Adjustments
        |--------------------------------------------------------------------------
        */

        this.elements.discountButton?.addEventListener(
            'click',
            () => this.requestDiscountApproval()
        );


        this.elements.taxButton?.addEventListener(
            'click',
            () => this.requestTaxApproval()
        );


        this.elements.applyDiscount?.addEventListener(
            'click',
            () => this.applySelectedDiscount()
        );


        /*
        |--------------------------------------------------------------------------
        | Held Sales
        |--------------------------------------------------------------------------
        */

        this.elements.heldSalesButton?.addEventListener(
            'click',
            () => this.openHeldSalesModal()
        );


        this.elements.heldSalesSearch?.addEventListener(
            'input',
            () => {

                clearTimeout(
                    this.state.heldSearchTimer
                );

                this.state.heldSearchTimer =
                    setTimeout(
                        () => {

                            this.state.heldSalesSearch =
                                this.elements.heldSalesSearch.value
                                    .trim();

                            this.state.heldSalesPage =
                                1;

                            this.loadHeldSales();

                        },
                        300
                    );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Payment
        |--------------------------------------------------------------------------
        */

        this.elements.payButton?.addEventListener(
            'click',
            () => this.openPaymentModal()
        );


        document
            .querySelectorAll(
                '[data-payment-method]'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            this.selectPaymentMethod(
                                button.dataset.paymentMethod
                            );

                        }
                    );

                }
            );


        this.elements.paymentAmount?.addEventListener(
            'input',
            () => this.updatePaymentChange()
        );


        this.elements.completePayment?.addEventListener(
            'click',
            () => this.completePayment()
        );


        /*
        |--------------------------------------------------------------------------
        | Completion
        |--------------------------------------------------------------------------
        */

        this.elements.completeNewSale?.addEventListener(
            'click',
            () => this.resetSale()
        );


        this.elements.completePrint?.addEventListener(
            'click',
            () => this.printReceipt()
        );


        /*
        |--------------------------------------------------------------------------
        | Save / Preview
        |--------------------------------------------------------------------------
        */

        this.elements.saveOrderButton?.addEventListener(
            'click',
            () => this.saveCurrentOrder()
        );


        this.elements.printPreviewButton?.addEventListener(
            'click',
            () => this.previewCurrentSale()
        );

    },

    /*
    |--------------------------------------------------------------------------
    | Fullscreen
    |--------------------------------------------------------------------------
    */

    /**
     * Initialize fullscreen requirement.
     */
    initializeFullscreen() {

        if (
            document.fullscreenElement
        ) {

            this.hideFullscreenOverlay();

            return;

        }


        this.showFullscreenOverlay();

    },


    /**
     * Enter browser fullscreen.
     */
    async enterFullscreen() {

        try {

            await document.documentElement.requestFullscreen();

        } catch (error) {

            console.error(
                'Unable to enter fullscreen:',
                error
            );

            this.showError(
                'Unable to enter full screen. Please allow fullscreen mode in your browser.'
            );

            return;

        }


        if (
            document.fullscreenElement
        ) {

            this.hideFullscreenOverlay();

        }

    },


    /**
     * Show fullscreen overlay.
     */
    showFullscreenOverlay() {

        this.elements.fullscreenOverlay?.classList.remove(
            'd-none'
        );

    },


    /**
     * Hide fullscreen overlay.
     */
    hideFullscreenOverlay() {

        this.elements.fullscreenOverlay?.classList.add(
            'd-none'
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Products
    |--------------------------------------------------------------------------
    */

    async loadProducts() {

        this.renderProductsLoading();


        const params =
            new URLSearchParams({

                page:
                    this.state.productsPage,

                search:
                    this.state.productsSearch,

                category_id:
                    this.state.categoryId,

            });


        try {

            const response =
                await this.request(

                    `${PosConfig.urls.products}?${params.toString()}`,

                    'GET'

                );


            const products =
                response.data
                ?? response.products
                ?? [];


            this.state.products =
                products;


            this.state.productsPagination =
                response.pagination
                ?? null;


            this.renderProducts(
                products
            );


            this.renderProductPagination();

        } catch (error) {

            this.renderProductsError(
                'Unable to load products.'
            );

        }

    },


    renderProductsLoading() {

        if (!this.elements.productGrid) {
            return;
        }


        this.elements.productGrid.innerHTML = `

            <div class="pos-products-loading">

                <div
                    class="spinner-border spinner-border-sm"
                    role="status"
                ></div>

                <span>
                    Loading products...
                </span>

            </div>

        `;

    },


    renderProductsError(message) {

        if (!this.elements.productGrid) {
            return;
        }


        this.elements.productGrid.innerHTML = `

            <div class="pos-empty-state">

                <div class="pos-empty-icon">

                    <i class="bi bi-exclamation-circle"></i>

                </div>

                <h6>
                    Unable to load products
                </h6>

                <p>
                    ${this.escape(message)}
                </p>

            </div>

        `;

    },


    renderProducts(products) {

        if (!this.elements.productGrid) {
            return;
        }


        if (!products.length) {

            this.elements.productGrid.innerHTML = `

                <div class="pos-empty-state">

                    <div class="pos-empty-icon">

                        <i class="bi bi-box-seam"></i>

                    </div>

                    <h6>
                        No products found
                    </h6>

                    <p>
                        Try another search or category.
                    </p>

                </div>

            `;

            return;

        }


        this.elements.productGrid.innerHTML =
            products
                .map(
                    product =>
                        this.productCard(
                            product
                        )
                )
                .join('');


        this.elements.productGrid
            .querySelectorAll(
                '[data-product-id]'
            )
            .forEach(
                card => {

                    card.addEventListener(
                        'click',
                        event => {

                            if (
                                event.target.closest(
                                    '[data-product-view]'
                                )
                            ) {

                                this.openProductInspector(
                                    card.dataset.productId
                                );

                                return;

                            }


                            this.addToCart(
                                Number(
                                    card.dataset.productId
                                )
                            );

                        }
                    );

                }
            );

    },


    productCard(product) {

        const stock =
            Number(
                product.stock
                ?? 0
            );


        const image =
            product.image
            ? `
                <img
                    src="/uploads/products/${this.escape(product.image)}"
                    alt="${this.escape(product.name)}"
                >
              `
            : `
                <div class="pos-product-image-placeholder">

                    <i class="bi bi-box-seam"></i>

                </div>
              `;


        return `

            <article
                class="pos-product-card"
                data-product-id="${this.escape(product.id)}"
            >

                <div class="pos-product-image">

                    ${image}

                    <span class="pos-product-stock-badge">

                        ${this.escape(
                            this.formatQuantity(stock)
                        )} in stock

                    </span>

                </div>


                <div class="pos-product-body">

                    <div class="pos-product-name">

                        ${this.escape(
                            product.name
                            ?? 'Unnamed product'
                        )}

                    </div>


                    <div class="pos-product-code">

                        ${this.escape(
                            product.sku
                            ?? product.product_code
                            ?? '—'
                        )}

                    </div>


                    <div class="pos-product-footer">

                        <strong class="pos-product-price">

                            ${this.formatMoney(
                                product.selling_price
                            )}

                        </strong>


                        <button
                            type="button"
                            class="pos-product-add"
                            data-product-view
                            title="View product"
                        >

                            <i class="bi bi-plus-lg"></i>

                        </button>

                    </div>

                </div>

            </article>

        `;

    },


    renderProductPagination() {

        const container =
            this.elements.productPagination;

        const pagination =
            this.state.productsPagination;


        if (
            !container
            || !pagination
        ) {

            if (container) {
                container.innerHTML = '';
            }

            return;

        }


        const currentPage =
            Number(
                pagination.current_page
                ?? 1
            );


        const lastPage =
            Number(
                pagination.last_page
                ?? 1
            );


        if (
            lastPage <= 1
        ) {

            container.innerHTML = '';

            return;

        }


        container.innerHTML = `

            <div class="d-flex align-items-center justify-content-between">

                <small class="text-muted">

                    Page ${currentPage}
                    of
                    ${lastPage}

                </small>


                <div class="btn-group btn-group-sm">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-products-page="${currentPage - 1}"
                        ${currentPage <= 1 ? 'disabled' : ''}
                    >

                        <i class="bi bi-chevron-left"></i>

                    </button>


                    <button
                        type="button"
                        class="btn btn-light"
                        data-products-page="${currentPage + 1}"
                        ${currentPage >= lastPage ? 'disabled' : ''}
                    >

                        <i class="bi bi-chevron-right"></i>

                    </button>

                </div>

            </div>

        `;


        container
            .querySelectorAll(
                '[data-products-page]'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            const page =
                                Number(
                                    button.dataset.productsPage
                                );


                            if (
                                page < 1
                                || page > lastPage
                            ) {

                                return;

                            }


                            this.state.productsPage =
                                page;


                            this.loadProducts();

                        }
                    );

                }
            );

    },


    async lookupBarcodeOrSearch() {

        const value =
            this.elements.productSearch?.value
                ?.trim();


        if (!value) {
            return;
        }


        try {

            const response =
                await this.request(

                    `${PosConfig.urls.productBarcode}/${encodeURIComponent(value)}`,

                    'GET'

                );


            const product =
                response.data
                ?? response.product;


            if (product) {

                this.addProductToCart(
                    product
                );

                this.clearProductSearch();

            }

        } catch (error) {

            this.state.productsSearch =
                value;

            this.state.productsPage =
                1;

            this.loadProducts();

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Categories
    |--------------------------------------------------------------------------
    */

    async loadCategories() {

        try {

            const response =
                await this.request(
                    PosConfig.urls.categories,
                    'GET'
                );


            this.state.categories =
                response.data
                ?? response.categories
                ?? [];


            this.renderCategories();

        } catch (error) {

            this.state.categories = [];

        }

    },


    renderCategories() {

        if (!this.elements.categoryList) {
            return;
        }


        const buttons = `

            <button
                type="button"
                class="pos-category-btn ${
                    this.state.categoryId === ''
                        ? 'active'
                        : ''
                }"
                data-category-id=""
            >
                All
            </button>

        `;


        const categoryButtons =
            this.state.categories
                .map(
                    category => `

                        <button
                            type="button"
                            class="pos-category-btn ${
                                String(
                                    this.state.categoryId
                                )
                                ===
                                String(
                                    category.id
                                )
                                    ? 'active'
                                    : ''
                            }"
                            data-category-id="${this.escape(category.id)}"
                        >

                            ${this.escape(
                                category.name
                            )}

                        </button>

                    `
                )
                .join('');


        this.elements.categoryList.innerHTML =
            buttons + categoryButtons;


        this.elements.categoryList
            .querySelectorAll(
                '[data-category-id]'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            this.state.categoryId =
                                button.dataset.categoryId;

                            this.state.productsPage =
                                1;

                            this.renderCategories();

                            this.loadProducts();

                        }
                    );

                }
            );

    },


    /*
    |--------------------------------------------------------------------------
    | Cart
    |--------------------------------------------------------------------------
    */

    addToCart(productId) {

        const product =
            this.state.products.find(
                item =>
                    Number(item.id)
                    === Number(productId)
            );


        if (!product) {

            this.openProductInspector(
                productId
            );

            return;

        }


        this.addProductToCart(
            product
        );

    },


    addProductToCart(product) {

        const stock =
            Number(
                product.stock
                ?? 0
            );


        if (
            stock <= 0
        ) {

            this.showError(
                'This product is out of stock.'
            );

            return;

        }


        const existing =
            this.state.cart.find(
                item =>
                    Number(item.product_id)
                    === Number(product.id)
            );


        if (existing) {

            if (
                existing.quantity + 1
                > stock
            ) {

                this.showError(
                    'You cannot add more than the available stock.'
                );

                return;

            }


            existing.quantity++;

        } else {

            this.state.cart.push({

                product_id:
                    Number(product.id),

                product_name:
                    product.name,

                image:
                    product.image
                    ? `/uploads/products/${product.image}`
                    : null,

                quantity:
                    1,

                unit_price:
                    Number(
                        product.selling_price
                        ?? 0
                    ),

                stock:
                    stock,

            });
        }


        this.renderCart();

        this.calculateTotals();

    },


    updateCartQuantity(
        productId,
        quantity
    ) {

        const item =
            this.state.cart.find(
                row =>
                    Number(row.product_id)
                    === Number(productId)
            );


        if (!item) {
            return;
        }


        const nextQuantity =
            Number(
                quantity
            );


        if (
            nextQuantity <= 0
        ) {

            this.removeFromCart(
                productId
            );

            return;

        }


        if (
            nextQuantity > item.stock
        ) {

            this.showError(
                'Quantity exceeds available stock.'
            );

            return;

        }


        item.quantity =
            nextQuantity;


        this.renderCart();

        this.calculateTotals();

    },


    removeFromCart(productId) {

        this.state.cart =
            this.state.cart.filter(
                item =>
                    Number(item.product_id)
                    !== Number(productId)
            );


        this.renderCart();

        this.calculateTotals();

    },


    renderCart() {

        const container =
            this.elements.cart;


        if (!container) {
            return;
        }


        const cart =
            this.state.cart;


        const totalItems =
            cart.length;


        const totalQuantity =
            cart.reduce(
                (
                    total,
                    item
                ) =>
                    total
                    + Number(
                        item.quantity
                    ),
                0
            );


        if (
            this.elements.cartItemCount
        ) {

            this.elements.cartItemCount.textContent =
                totalItems;

        }


        if (
            this.elements.cartQuantity
        ) {

            this.elements.cartQuantity.textContent =
                `${this.formatQuantity(totalQuantity)} items`;

        }


        if (!cart.length) {

            container.innerHTML = `

                <div class="pos-cart-empty">

                    <div class="pos-cart-empty-icon">

                        <i class="bi bi-cart3"></i>

                    </div>

                    <strong>
                        Your sale is empty
                    </strong>

                    <span>
                        Select products to add them here.
                    </span>

                </div>

            `;

            return;

        }


        container.innerHTML =
            cart
                .map(
                    item =>
                        this.cartItem(
                            item
                        )
                )
                .join('');


       container
        .querySelectorAll(
            '[data-cart-action]'
        )
        .forEach(
            element => {

                /*
                |--------------------------------------------------------------------------
                | Direct Quantity Input
                |--------------------------------------------------------------------------
                */

                if (
                    element.dataset.cartAction ===
                    'quantity'
                ) {

                    element.addEventListener(
                        'input',
                        () => {

                            const value =
                                Number(
                                    element.value
                                );


                            if (
                                value < 1
                                || Number.isNaN(value)
                            ) {

                                return;

                            }


                            this.updateCartQuantity(
                                Number(
                                    element.dataset.productId
                                ),
                                value
                            );

                        }
                    );


                    element.addEventListener(
                        'keydown',
                        event => {

                            if (
                                event.key === 'Enter'
                            ) {

                                event.preventDefault();

                                element.blur();

                            }

                        }
                    );


                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Button Actions
                |--------------------------------------------------------------------------
                */

                element.addEventListener(
                    'click',
                    () => {

                        const action =
                            element.dataset.cartAction;


                        const productId =
                            Number(
                                element.dataset.productId
                            );


                        const item =
                            this.state.cart.find(
                                row =>
                                    Number(
                                        row.product_id
                                    )
                                    ===
                                    productId
                            );


                        if (!item) {
                            return;
                        }


                        if (
                            action === 'increase'
                        ) {

                            this.updateCartQuantity(
                                productId,
                                item.quantity + 1
                            );

                        }


                        if (
                            action === 'decrease'
                        ) {

                            this.updateCartQuantity(
                                productId,
                                item.quantity - 1
                            );

                        }


                        if (
                            action === 'remove'
                        ) {

                            this.removeFromCart(
                                productId
                            );

                        }

                    }
                );

            }
        );

    },
   


    cartItem(item) {

        const image =
            item.image
            ? `
                <img
                    src="${this.escape(item.image)}"
                    alt="${this.escape(item.product_name)}"
                >
              `
            : `
                <i class="bi bi-box-seam"></i>
              `;


        const lineTotal =
            Number(
                item.quantity
            )
            *
            Number(
                item.unit_price
            );


        return `

            <div class="pos-cart-item">

                <div class="pos-cart-item-thumb">

                    ${image}

                </div>


                <div class="pos-cart-item-main">

                    <div class="pos-cart-item-name">

                        ${this.escape(
                            item.product_name
                        )}

                    </div>


                    <div class="pos-cart-item-meta">

                        ${this.formatMoney(
                            item.unit_price
                        )}

                    </div>


                    <div class="pos-quantity-control">

                        <button
                            type="button"
                            class="pos-quantity-btn"
                            data-cart-action="decrease"
                            data-product-id="${this.escape(item.product_id)}"
                            aria-label="Decrease quantity"
                        >

                            <i class="bi bi-dash"></i>

                        </button>


                        <input
                            type="number"
                            class="pos-quantity-input"
                            data-cart-action="quantity"
                            data-product-id="${this.escape(item.product_id)}"
                            value="${this.escape(item.quantity)}"
                            min="1"
                            max="${this.escape(item.stock)}"
                            step="1"
                            aria-label="Quantity"
                        >


                        <button
                            type="button"
                            class="pos-quantity-btn"
                            data-cart-action="increase"
                            data-product-id="${this.escape(item.product_id)}"
                            aria-label="Increase quantity"
                        >

                            <i class="bi bi-plus"></i>

                        </button>

                    </div>

                </div>


                <div class="pos-cart-item-right">

                    <strong class="pos-cart-item-total">

                        ${this.formatMoney(
                            lineTotal
                        )}

                    </strong>


                    <button
                        type="button"
                        class="pos-cart-remove"
                        data-cart-action="remove"
                        data-product-id="${this.escape(item.product_id)}"
                        title="Remove"
                    >

                        <i class="bi bi-x-lg"></i>

                    </button>

                </div>

            </div>

        `;

    },


    clearSale() {

        if (!this.state.cart.length) {
            return;
        }


        this.confirmAction(
            'Clear Sale',
            'Clear all items from this sale?',
            () => {

                this.resetSale();

            }
        );

    },


    resetSale() {

        this.state.cart = [];

        this.state.selectedCustomer = null;

        this.state.selectedDiscount = null;

        this.state.selectedTaxRate = null;

        this.state.currentOrder = null;

        this.state.selectedOrderId = null;

        this.state.selectedPaymentMethod =
            'Cash';

        this.state.paymentAmount = 0;

        this.renderCart();

        this.renderCustomer();

        this.calculateTotals();

        this.selectPaymentMethod(
            'Cash'
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Totals
    |--------------------------------------------------------------------------
    */

    calculateSubtotal() {

        return this.state.cart.reduce(
            (
                total,
                item
            ) =>
                total
                +
                (
                    Number(item.quantity)
                    *
                    Number(item.unit_price)
                ),
            0
        );

    },


    calculateDiscount() {

        const subtotal =
            this.calculateSubtotal();


        const discount =
            this.state.selectedDiscount;


        if (!discount) {
            return 0;
        }


        const percentage =
            Number(
                discount.percentage
                ?? discount.rate
                ?? discount.discount_percentage
                ?? 0
            );


        if (
            percentage > 0
        ) {

            return Math.min(
                subtotal,
                subtotal
                * (
                    percentage
                    / 100
                )
            );

        }


        const fixed =
            Number(
                discount.amount
                ?? discount.value
                ?? 0
            );


        return Math.min(
            subtotal,
            fixed
        );

    },


    calculateTax() {

        const subtotal =
            this.calculateSubtotal();


        const discount =
            this.calculateDiscount();


        const taxable =
            Math.max(
                0,
                subtotal - discount
            );


        const taxRate =
            this.state.selectedTaxRate;


        if (!taxRate) {
            return 0;
        }


        const rate =
            Number(
                taxRate.rate
                ?? taxRate.percentage
                ?? taxRate.tax_rate
                ?? 0
            );


        return taxable
            * (
                rate / 100
            );

    },


    calculateGrandTotal() {

        return Math.max(
            0,
            this.calculateSubtotal()
            -
            this.calculateDiscount()
            +
            this.calculateTax()
        );

    },


    calculateTotals() {

        const subtotal =
            this.calculateSubtotal();


        const discount =
            this.calculateDiscount();


        const tax =
            this.calculateTax();


        const grandTotal =
            Math.max(
                0,
                subtotal
                - discount
                + tax
            );


        this.setMoney(
            this.elements.subtotal,
            subtotal
        );


        this.setMoney(
            this.elements.discountDisplay,
            discount
        );


        this.setMoney(
            this.elements.taxDisplay,
            tax
        );


        this.setMoney(
            this.elements.summaryDiscount,
            discount
        );


        this.setMoney(
            this.elements.summaryTax,
            tax
        );


        this.setMoney(
            this.elements.grandTotal,
            grandTotal
        );


        this.setMoney(
            this.elements.payTotal,
            grandTotal
        );


        if (
            this.elements.payButton
        ) {

            this.elements.payButton.disabled =
                this.state.cart.length === 0;

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Customer
    |--------------------------------------------------------------------------
    */

    openCustomerModal() {

        this.elements.customerSearch.value =
            '';

        this.modals.customer?.show();

        this.loadCustomers();

    },


    async loadCustomers() {

        const search =
            this.elements.customerSearch?.value
                ?.trim()
                ?? '';


        const params =
            new URLSearchParams({

                search:

                    search,

            });


        try {

            const response =
                await this.request(

                    `${PosConfig.urls.customers}?${params.toString()}`,

                    'GET'

                );


            const customers =
                response.data
                ?? response.customers
                ?? [];


            this.renderCustomers(
                customers
            );

        } catch (error) {

            this.renderCustomerError();

        }

    },


    renderCustomers(customers) {

        if (
            !this.elements.customerResults
        ) {
            return;
        }


        if (!customers.length) {

            this.elements.customerResults.innerHTML = `

                <div class="pos-modal-empty">

                    <i class="bi bi-person-x"></i>

                    <span>
                        No customers found.
                    </span>

                </div>

            `;

            return;

        }


        this.elements.customerResults.innerHTML =
            customers
                .map(
                    customer =>
                        `

                            <button
                                type="button"
                                class="pos-customer-result"
                                data-customer-id="${this.escape(customer.id)}"
                            >

                                <span class="pos-customer-result-icon">

                                    <i class="bi bi-person"></i>

                                </span>


                                <span class="pos-customer-result-content">

                                    <strong class="pos-customer-result-name">

                                        ${this.escape(
                                            customer.name
                                            ?? this.customerName(
                                                customer
                                            )
                                        )}

                                    </strong>


                                    <small class="pos-customer-result-meta">

                                        ${this.escape(
                                            customer.phone
                                            ?? customer.email
                                            ?? ''
                                        )}

                                    </small>

                                </span>

                            </button>

                        `
                )
                .join('');


        this.elements.customerResults
            .querySelectorAll(
                '[data-customer-id]'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            this.selectCustomerById(
                                button.dataset.customerId
                            );

                        }
                    );

                }
            );

    },


    renderCustomerError() {

        if (
            this.elements.customerResults
        ) {

            this.elements.customerResults.innerHTML = `

                <div class="pos-modal-empty">

                    <i class="bi bi-exclamation-circle"></i>

                    <span>
                        Unable to load customers.
                    </span>

                </div>

            `;

        }

    },


    async selectCustomerById(id) {

        try {

            const response =
                await this.request(

                    PosConfig.urls.customerDetails
                    + '/'
                    + id,

                    'GET'

                );


            const customer =
                response.data
                ?? response.customer;


            this.selectCustomer(
                customer
            );


        } catch (error) {

            this.showError(
                'Unable to load customer details.'
            );

        }

    },


    selectCustomer(customer) {

        this.state.selectedCustomer =
            customer;


        this.renderCustomer();

        this.modals.customer?.hide();

    },


    renderCustomer() {

        const customer =
            this.state.selectedCustomer;


        if (!customer) {

            this.setText(
                this.elements.selectedCustomerName,
                'Walk-in Customer'
            );

            this.setText(
                this.elements.selectedCustomerDetail,
                'No customer selected'
            );

            return;

        }


        this.setText(
            this.elements.selectedCustomerName,
            customer.name
            ?? this.customerName(
                customer
            )
            ?? 'Customer'
        );


        this.setText(
            this.elements.selectedCustomerDetail,
            customer.phone
            ?? customer.email
            ?? ''
        );

    },


    customerName(customer) {

        return `${customer.last_name ?? ''} ${customer.first_name ?? ''}`
            .trim();

    },


    /*
|--------------------------------------------------------------------------
| Sales History
|--------------------------------------------------------------------------
*/

/**
 * Open sales history.
 */
async openSalesHistory() {

    this.state.salesHistoryPage =
        1;

    this.state.salesHistorySearch =
        '';

    if (
        this.elements.salesHistorySearch
    ) {

        this.elements.salesHistorySearch.value =
            '';

    }


    this.modals.salesHistory?.show();

    await this.loadSalesHistory();

},


/**
 * Load today's sales history.
 */
async loadSalesHistory() {

    if (
        this.elements.salesHistoryBody
    ) {

        this.elements.salesHistoryBody.innerHTML = `

            <tr>

                <td
                    colspan="7"
                    class="text-center py-5 text-muted"
                >

                    <span
                        class="spinner-border spinner-border-sm me-1"
                    ></span>

                    Loading sales...

                </td>

            </tr>

        `;

    }


    const params =
        new URLSearchParams({

            page:
                this.state.salesHistoryPage,

            search:
                this.state.salesHistorySearch,

        });


    try {

        const response =
            await this.request(

                `${PosConfig.urls.salesHistory}?${params.toString()}`,

                'GET'

            );


        const summary =
            response.summary
            ?? {};


        const sales =
            response.data
            ?? [];


        const pagination =
            response.pagination
            ?? null;


        this.renderSalesHistorySummary(
            summary
        );


        this.renderSalesHistory(
            sales
        );


        this.renderPagination(

            this.elements.salesHistoryPagination,

            pagination,

            page => {

                this.state.salesHistoryPage =
                    page;

                this.loadSalesHistory();

            }

        );


    } catch (error) {

        if (
            this.elements.salesHistoryBody
        ) {

            this.elements.salesHistoryBody.innerHTML = `

                <tr>

                    <td
                        colspan="7"
                        class="text-center py-5 text-danger"
                    >

                        Unable to load sales history.

                    </td>

                </tr>

            `;

        }

    }

},


/**
 * Render sales history summary.
 */
renderSalesHistorySummary(
    summary
) {

    this.setMoney(
        this.elements.historyTotalSales,
        summary.total_sales
        ?? 0
    );


    this.setText(
        this.elements.historyTransactionCount,
        summary.transaction_count
        ?? 0
    );


    this.setMoney(
        this.elements.historyAverageSale,
        summary.average_sale
        ?? 0
    );


    this.setMoney(
        this.elements.historyCashSales,
        summary.cash_sales
        ?? 0
    );


    this.setMoney(
        this.elements.historyCash,
        summary.cash_sales
        ?? 0
    );


    this.setMoney(
        this.elements.historyCard,
        summary.card_sales
        ?? 0
    );


    this.setMoney(
        this.elements.historyTransfer,
        summary.transfer_sales
        ?? 0
    );


    this.setMoney(
        this.elements.historyWallet,
        summary.wallet_sales
        ?? 0
    );

},


/**
 * Render sales history table.
 */
renderSalesHistory(
    sales
) {

    if (
        !this.elements.salesHistoryBody
    ) {
        return;
    }


    if (
        !sales.length
    ) {

        this.elements.salesHistoryBody.innerHTML = `

            <tr>

                <td
                    colspan="7"
                    class="text-center py-5 text-muted"
                >

                    No completed sales found for today.

                </td>

            </tr>

        `;

        return;

    }


    this.elements.salesHistoryBody.innerHTML =
        sales
            .map(
                sale => `

                    <tr>

                        <td>

                            <strong>

                                ${this.escape(
                                    sale.order_no
                                    ?? sale.id
                                )}

                            </strong>

                        </td>


                        <td>

                            ${this.escape(
                                sale.customer_name
                                ?? 'Walk-in Customer'
                            )}

                        </td>


                        <td>

                            ${this.escape(
                                sale.cashier_name
                                ?? '—'
                            )}

                        </td>


                        <td>

                            ${this.escape(
                                sale.payment_method
                                ?? '—'
                            )}

                        </td>


                        <td>

                            <strong>

                                ${this.formatMoney(
                                    sale.total
                                    ?? 0
                                )}

                            </strong>

                        </td>


                        <td>

                            ${this.escape(
                                this.formatDateTime(
                                    sale.completed_at
                                )
                            )}

                        </td>


                        <td class="text-end">

                            <button
                                type="button"
                                class="btn btn-sm btn-light"
                                data-sale-id="${this.escape(
                                    sale.id
                                )}"
                            >

                                <i class="bi bi-eye"></i>

                            </button>

                        </td>

                    </tr>

                `
            )
            .join('');


    this.elements.salesHistoryBody
        .querySelectorAll(
            '[data-sale-id]'
        )
        .forEach(
            button => {

                button.addEventListener(
                    'click',
                    () => {

                        this.viewSaleFromHistory(
                            button.dataset.saleId
                        );

                    }
                );

            }
        );

},


/**
 * View a sale from history.
 */
async viewSaleFromHistory(
    id
) {

    try {

        const response =
            await this.request(

                `${PosConfig.urls.orderDetails}/${id}`,

                'GET'

            );


        const order =
            response.data
            ?? response.order;


        if (!order) {

            throw new Error(
                'Sale details were not returned.'
            );

        }


        this.modals.salesHistory?.hide();


        this.loadOrderIntoCart(
            order
        );


    } catch (error) {

        this.showError(
            'Unable to load sale details.'
        );

    }

},


    /*
    |--------------------------------------------------------------------------
    | Discounts
    |--------------------------------------------------------------------------
    */

    async loadDiscounts() {

        try {

            const response =
                await this.request(
                    PosConfig.urls.discounts,
                    'GET'
                );


            this.state.discounts =
                response.data
                ?? response.discounts
                ?? [];

        } catch (error) {

            this.state.discounts =
                [];

        }

    },


    openDiscountModal() {

        this.state.selectedDiscount =
            this.state.selectedDiscount
            ?? null;


        this.renderDiscounts();

        this.modals.discount?.show();

    },


    renderDiscounts() {

        if (
            !this.elements.discountList
        ) {
            return;
        }


        if (!this.state.discounts.length) {

            this.elements.discountList.innerHTML = `

                <div class="pos-modal-empty">

                    <i class="bi bi-percent"></i>

                    <span>
                        No discounts available.
                    </span>

                </div>

            `;

            return;

        }


        this.elements.discountList.innerHTML =
            this.state.discounts
                .map(
                    discount => `

                        <button
                            type="button"
                            class="pos-discount-option ${
                                Number(
                                    this.state.selectedDiscount?.id
                                )
                                === Number(
                                    discount.id
                                )
                                    ? 'active'
                                    : ''
                            }"
                            data-discount-id="${this.escape(discount.id)}"
                        >

                            <span class="pos-discount-option-content">

                                <span class="pos-discount-option-name">

                                    ${this.escape(
                                        discount.name
                                        ?? 'Discount'
                                    )}

                                </span>


                                <span class="pos-discount-option-description">

                                    ${this.escape(
                                        discount.description
                                        ?? ''
                                    )}

                                </span>

                            </span>


                            <strong>

                                ${this.escape(
                                    this.discountValueLabel(
                                        discount
                                    )
                                )}

                            </strong>

                        </button>

                    `
                )
                .join('');


        this.elements.discountList
            .querySelectorAll(
                '[data-discount-id]'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            const discount =
                                this.state.discounts.find(
                                    item =>
                                        Number(item.id)
                                        ===
                                        Number(
                                            button.dataset.discountId
                                        )
                                );


                            this.state.selectedDiscount =
                                discount
                                ?? null;


                            this.renderDiscounts();

                        }
                    );

                }
            );

    },


    discountValueLabel(discount) {

        const percentage =
            discount.percentage
            ?? discount.rate
            ?? discount.discount_percentage;


        if (
            percentage !== undefined
            && percentage !== null
        ) {

            return `${percentage}%`;

        }


        const amount =
            discount.amount
            ?? discount.value;


        if (
            amount !== undefined
            && amount !== null
        ) {

            return this.formatMoney(
                amount
            );

        }


        return '';

    },


    applySelectedDiscount() {

        this.calculateTotals();

        this.modals.discount?.hide();

    },


    /*
    |--------------------------------------------------------------------------
    | Tax
    |--------------------------------------------------------------------------
    */

    async loadTaxRates() {

        try {

            const response =
                await this.request(
                    PosConfig.urls.taxRates,
                    'GET'
                );


            this.state.taxRates =
                response.data
                ?? response.tax_rates
                ?? [];

        } catch (error) {

            this.state.taxRates =
                [];

        }

    },


    toggleTaxRate() {

        if (
            !this.state.taxRates.length
        ) {

            this.showError(
                'No tax rates are available.'
            );

            return;

        }


        const currentIndex =
            this.state.taxRates.findIndex(
                rate =>
                    Number(rate.id)
                    ===
                    Number(
                        this.state.selectedTaxRate?.id
                    )
            );


        const nextIndex =
            currentIndex + 1;


        if (
            nextIndex >=
            this.state.taxRates.length
        ) {

            this.state.selectedTaxRate =
                null;

        } else {

            this.state.selectedTaxRate =
                this.state.taxRates[
                    nextIndex
                ];

        }


        this.calculateTotals();

    },


    /*
    |--------------------------------------------------------------------------
    | Payment
    |--------------------------------------------------------------------------
    */

    openPaymentModal() {

        if (!this.state.cart.length) {

            this.showError(
                'Add at least one product before payment.'
            );

            return;

        }


        const total =
            this.calculateGrandTotal();


        this.setMoney(
            this.elements.paymentTotal,
            total
        );


        if (
            this.elements.paymentAmount
        ) {

            this.elements.paymentAmount.value =
                '';

        }


        if (
            this.elements.paymentReference
        ) {

            this.elements.paymentReference.value =
                '';

        }


        if (
            this.elements.paymentRemarks
        ) {

            this.elements.paymentRemarks.value =
                '';

        }


        this.state.paymentAmount =
            0;

        this.state.paymentReference =
            '';

        this.state.paymentRemarks =
            '';


        this.selectPaymentMethod(
            'Cash'
        );


        this.modals.payment?.show();

    },


    selectPaymentMethod(method) {

        this.state.selectedPaymentMethod =
            method;


        document
            .querySelectorAll(
                '[data-payment-method]'
            )
            .forEach(
                button => {

                    button.classList.toggle(
                        'active',
                        button.dataset.paymentMethod
                        ===
                        method
                    );

                }
            );


        const isCash =
            method === 'Cash';


        this.toggle(
            this.elements.cashPaymentPanel,
            isCash
        );


        this.toggle(
            this.elements.otherPaymentPanel,
            !isCash
        );


        if (!isCash) {

            this.setText(
                this.elements.paymentChange,
                '₦0.00'
            );

        }

    },


    updatePaymentChange() {

        const total =
            this.calculateGrandTotal();


        const amount =
            Number(
                this.elements.paymentAmount?.value
                ?? 0
            );


        const change =
            Math.max(
                0,
                amount - total
            );


        this.state.paymentAmount =
            amount;


        this.setMoney(
            this.elements.paymentChange,
            change
        );

    },


    async completePayment() {

        if (this.state.isSaving) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Validate Cart
        |--------------------------------------------------------------------------
        */

        if (!this.state.cart.length) {

            this.showError(
                'Add products before completing the sale.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Payment
        |--------------------------------------------------------------------------
        */

        const total =
            this.calculateGrandTotal();

        const method =
            this.state.selectedPaymentMethod;

        const receivedAmount =
            method === 'Cash'
                ? Number(
                    this.elements.paymentAmount?.value ?? 0
                )
                : total;


        if (
            method === 'Cash'
            && receivedAmount < total
        ) {

            this.showError(
                'Amount received is less than the sale total.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Saving State
        |--------------------------------------------------------------------------
        */

        this.state.isSaving = true;

        this.setButtonLoading(
            this.elements.completePayment,
            true,
            'Completing...'
        );


        try {

            /*
            |--------------------------------------------------------------------------
            | Build Complete Sale Request
            |--------------------------------------------------------------------------
            */

            const formData =
                this.buildOrderFormData();


            /*
            |--------------------------------------------------------------------------
            | Payment
            |--------------------------------------------------------------------------
            */

            formData.append(
                'payment_method',
                method
            );

            formData.append(
                'amount',
                String(receivedAmount)
            );


            if (
                this.elements.paymentReference?.value
            ) {

                formData.append(
                    'reference_no',
                    this.elements.paymentReference.value.trim()
                );

            }


            if (
                this.elements.paymentRemarks?.value
            ) {

                formData.append(
                    'remarks',
                    this.elements.paymentRemarks.value.trim()
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Complete Entire Sale
            |--------------------------------------------------------------------------
            */

            const response =
                await this.request(
                    PosConfig.urls.orders,
                    'POST',
                    formData
                );


            const data =
                response.data
                ?? {};


            if (!data.order?.id) {

                throw new Error(
                    'Sale could not be completed.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Store Current Order
            |--------------------------------------------------------------------------
            */

            this.state.currentOrder =
                data.order;


            /*
            |--------------------------------------------------------------------------
            | Success
            |--------------------------------------------------------------------------
            */

            this.showSaleCompleted(
                data
            );

        } catch (error) {

            this.handleRequestError(
                error
            );

        } finally {

            this.state.isSaving =
                false;

            this.setButtonLoading(
                this.elements.completePayment,
                false
            );

        }

    },

    buildOrderFormData() {

    const data =
        new FormData();


    /*
    |--------------------------------------------------------------------------
    | Customer
    |--------------------------------------------------------------------------
    */

    if (
        this.state.selectedCustomer?.id
    ) {

        data.append(
            'customer_id',
            String(
                this.state.selectedCustomer.id
            )
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Discount
    |--------------------------------------------------------------------------
    */

    if (
        this.state.selectedDiscount?.id
    ) {

        data.append(
            'discount_id',
            String(
                this.state.selectedDiscount.id
            )
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Tax Rate
    |--------------------------------------------------------------------------
    */

    if (
        this.state.selectedTaxRate?.id
    ) {

        data.append(
            'tax_rate_id',
            String(
                this.state.selectedTaxRate.id
            )
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Calculate Sale Totals
    |--------------------------------------------------------------------------
    */

    const subtotal =
        this.calculateSubtotal();

    const discount =
        this.calculateDiscount();

    const tax =
        this.calculateTax();

    const total =
        Math.max(
            0,
            subtotal - discount
        );

    const grandTotal =
        this.calculateGrandTotal();


    /*
    |--------------------------------------------------------------------------
    | Totals
    |--------------------------------------------------------------------------
    */

    data.append(
        'subtotal',
        String(subtotal)
    );

    data.append(
        'discount',
        String(discount)
    );

    data.append(
        'tax',
        String(tax)
    );

    data.append(
        'total',
        String(total)
    );

    data.append(
        'grand_total',
        String(grandTotal)
    );


    /*
    |--------------------------------------------------------------------------
    | Item Totals
    |--------------------------------------------------------------------------
    */

    data.append(
        'total_items',
        String(
            this.state.cart.length
        )
    );


    const totalQuantity =
        this.state.cart.reduce(
            (
                total,
                item
            ) => {

                return total
                    + Number(
                        item.quantity ?? 0
                    );

            },
            0
        );


    data.append(
        'total_quantity',
        String(totalQuantity)
    );


    /*
    |--------------------------------------------------------------------------
    | Cart Items
    |--------------------------------------------------------------------------
    */

    this.state.cart.forEach(
        (
            item,
            index
        ) => {

            data.append(
                `items[${index}][product_id]`,
                String(
                    item.product_id
                )
            );

            data.append(
                `items[${index}][quantity]`,
                String(
                    item.quantity
                )
            );

            data.append(
                `items[${index}][unit_price]`,
                String(
                    item.unit_price
                )
            );

            data.append(
                `items[${index}][discount]`,
                '0'
            );

            data.append(
                `items[${index}][tax]`,
                '0'
            );

            data.append(
                `items[${index}][total]`,
                String(
                    Number(item.quantity)
                    * Number(item.unit_price)
                )
            );

        }
    );


    return data;

},

    /*
    |--------------------------------------------------------------------------
    | Save Order
    |--------------------------------------------------------------------------
    */

    async saveCurrentOrder() {

        if (
            !this.state.cart.length
        ) {

            this.showError(
                'There are no items to save.'
            );

            return;

        }


        try {

            const response =
                await this.request(

                    PosConfig.urls.orders,

                    'POST',

                    this.buildOrderFormData()

                );


            this.state.currentOrder =
                response.data
                ?? response.order;


            this.showSuccess(
                'Sale saved successfully.'
            );


        } catch (error) {

            this.handleRequestError(
                error
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Hold Sales
    |--------------------------------------------------------------------------
    */

    async holdSale() {

        if (
            !this.state.cart.length
        ) {

            this.showError(
                'Add products before holding the sale.'
            );

            return;

        }


        try {

            const response =
                await this.request(

                    PosConfig.urls.holdOrder,

                    'POST',

                    this.buildOrderFormData()

                );


            const order =
                response.data
                ?? response.order;


            if (order) {

                this.showSuccess(
                    'Sale held successfully.'
                );

                this.resetSale();

                this.updateHeldSalesCount();

            }

        } catch (error) {

            this.handleRequestError(
                error
            );

        }

    },

    /*
|--------------------------------------------------------------------------
| Adjustment Approval
|--------------------------------------------------------------------------
*/

/**
 * Request discount approval.
 */
requestDiscountApproval() {

    if (
        !this.state.cart.length
    ) {

        this.showError(
            'Add products before applying a discount.'
        );

        return;

    }


    this.state.approvalType =
        'discount';


    this.setText(
        this.elements.approvalAction,
        'Discount'
    );


    this.elements.approvalPassword.value =
        '';


    this.loadApprovalUsers();

    this.modals.approval?.show();

},


/**
 * Request tax approval.
 */
requestTaxApproval() {

    if (
        !this.state.cart.length
    ) {

        this.showError(
            'Add products before applying tax.'
        );

        return;

    }


    this.state.approvalType =
        'tax';


    this.setText(
        this.elements.approvalAction,
        'Tax'
    );


    this.elements.approvalPassword.value =
        '';


    this.loadApprovalUsers();

    this.modals.approval?.show();

},

/**
 * Load authorized approvers.
 */
async loadApprovalUsers() {

    try {

        const response =
            await this.request(
                PosConfig.urls.approvers,
                'GET'
            );


        const users =
            response.data
            ?? response.users
            ?? [];


        this.elements.approvalUser.innerHTML = `

            <option value="">
                Select approver
            </option>

        `;


        this.elements.approvalUser.innerHTML +=
            users
                .map(
                    user => `

                        <option
                            value="${this.escape(user.id)}"
                        >

                            ${this.escape(
                                user.name
                            )}

                        </option>

                    `
                )
                .join('');

    } catch (error) {

        this.showError(
            'Unable to load authorized approvers.'
        );

    }

},

async approveAdjustment() {

    const approverId =
        this.elements.approvalUser?.value;


    const password =
        this.elements.approvalPassword?.value
        ?? '';


    if (!approverId) {

        this.showError(
            'Select an authorized approver.'
        );

        return;

    }


    if (!password) {

        this.showError(
            'Enter the approver password.'
        );

        return;

    }


    this.setButtonLoading(
        this.elements.approvalSubmit,
        true,
        'Verifying...'
    );


    try {

        const data =
            new FormData();


        data.append(
            'approver_id',
            approverId
        );


        data.append(
            'password',
            password
        );


        data.append(
            'action',
            this.state.approvalType
        );


        const response =
            await this.request(
                PosConfig.urls.approval,
                'POST',
                data
            );


        /*
        |--------------------------------------------------------------------------
        | Close Approval Modal
        |--------------------------------------------------------------------------
        */

        this.modals.approval?.hide();


        /*
        |--------------------------------------------------------------------------
        | Continue Original Flow
        |--------------------------------------------------------------------------
        */

        if (
            this.state.approvalType ===
            'discount'
        ) {

            this.openDiscountModal();

        }


        if (
            this.state.approvalType ===
            'tax'
        ) {

            /*
            |----------------------------------------------------------------------
            | Open Tax Selection
            |----------------------------------------------------------------------
            |
            | We will use the existing tax-rate flow here.
            |
            */

            this.openTaxRateModal();

        }


    } catch (error) {

        this.handleRequestError(
            error
        );

    } finally {

        this.setButtonLoading(
            this.elements.approvalSubmit,
            false
        );

    }

},

    async openHeldSalesModal() {

        this.elements.heldSalesSearch.value =
            '';

        this.state.heldSalesSearch =
            '';

        this.state.heldSalesPage =
            1;

        this.modals.heldSales?.show();

        await this.loadHeldSales();

    },


    async loadHeldSales() {

        if (
            !this.elements.heldSalesList
        ) {
            return;
        }


        const params =
            new URLSearchParams({

                page:
                    this.state.heldSalesPage,

                search:
                    this.state.heldSalesSearch,

            });


        this.elements.heldSalesList.innerHTML = `

            <div class="pos-modal-empty">

                <div
                    class="spinner-border spinner-border-sm"
                    role="status"
                ></div>

                <span>
                    Loading held sales...
                </span>

            </div>

        `;


        try {

            const response =
                await this.request(

                    `${PosConfig.urls.heldOrders}?${params.toString()}`,

                    'GET'

                );


            const sales =
                response.data
                ?? response.orders
                ?? [];


            const pagination =
                response.pagination
                ?? null;


            this.state.heldSales =
                sales;


            this.renderHeldSales(
                sales
            );


            this.renderHeldSalesPagination(
                pagination
            );


            this.updateHeldSalesCount(
                pagination?.total
            );


        } catch (error) {

            this.elements.heldSalesList.innerHTML = `

                <div class="pos-modal-empty">

                    <i class="bi bi-exclamation-circle"></i>

                    <span>
                        Unable to load held sales.
                    </span>

                </div>

            `;

        }

    },


    renderHeldSales(sales) {

        if (
            !this.elements.heldSalesList
        ) {
            return;
        }


        if (!sales.length) {

            this.elements.heldSalesList.innerHTML = `

                <div class="pos-modal-empty">

                    <i class="bi bi-pause-circle"></i>

                    <span>
                        No held sales found.
                    </span>

                </div>

            `;

            return;

        }


        this.elements.heldSalesList.innerHTML =
            sales
                .map(
                    order => `

                        <div class="pos-held-sale">

                            <div>

                                <div class="pos-held-sale-number">

                                    ${this.escape(
                                        order.order_no
                                        ?? `Order #${order.id}`
                                    )}

                                </div>


                                <div class="pos-held-sale-meta">

                                    ${this.escape(
                                        order.customer?.name
                                        ?? this.customerName(
                                            order.customer
                                            ?? {}
                                        )
                                        ?? 'Walk-in Customer'
                                    )}

                                </div>

                            </div>


                            <div class="d-flex align-items-center gap-2">

                                <strong class="pos-held-sale-total">

                                    ${this.formatMoney(
                                        order.grand_total
                                        ?? order.total
                                        ?? 0
                                    )}

                                </strong>


                                <button
                                    type="button"
                                    class="btn btn-sm btn-primary"
                                    data-retrieve-order="${this.escape(order.id)}"
                                >

                                    Retrieve

                                </button>

                            </div>

                        </div>

                    `
                )
                .join('');


        this.elements.heldSalesList
            .querySelectorAll(
                '[data-retrieve-order]'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            this.retrieveHeldSale(
                                button.dataset.retrieveOrder
                            );

                        }
                    );

                }
            );

    },


    renderHeldSalesPagination(pagination) {

        this.renderPagination(
            this.elements.heldSalesPagination,
            pagination,
            page => {

                this.state.heldSalesPage =
                    page;

                this.loadHeldSales();

            }
        );

    },


    async retrieveHeldSale(id) {

        try {

            const url =
                `${PosConfig.urls.retrieveOrder}/${id}/retrieve`;


            const response =
                await this.request(
                    url,
                    'POST'
                );


            const order =
                response.data
                ?? response.order;


            if (!order) {
                throw new Error(
                    'Held sale data was not returned.'
                );
            }


            this.loadOrderIntoCart(
                order
            );


            this.modals.heldSales?.hide();


            this.showSuccess(
                'Held sale retrieved.'
            );


        } catch (error) {

            this.handleRequestError(
                error
            );

        }

    },


    loadOrderIntoCart(order) {

        this.state.currentOrder =
            order;


        this.state.selectedCustomer =
            order.customer
            ?? null;


        this.state.cart =
        (
            order.order_items
            ?? order.orderItems
            ?? []
        )
        .map(
            item => ({

                product_id:
                    Number(
                        item.product_id
                    ),

                product_name:
                    item.product_name
                    ?? item.description
                    ?? 'Product',

                image:
                    item.image
                    ?? item.product?.image
                    ?? null,

                quantity:
                    Number(
                        item.quantity
                        ?? 1
                    ),

                unit_price:
                    Number(
                        item.unit_price
                        ?? 0
                    ),

                stock:
                    Number(
                        item.product?.stock
                        ?? 999999
                    ),

            })
        );

        this.renderCustomer();

        this.renderCart();

        this.calculateTotals();

    },


    async updateHeldSalesCount(
        count = null
    ) {

        if (
            count !== null
        ) {

            this.toggle(
                this.elements.heldSalesCount,
                Number(count) > 0
            );


            if (
                this.elements.heldSalesCount
            ) {

                this.elements.heldSalesCount.textContent =
                    count;

            }


            return;

        }


        try {

            const response =
                await this.request(

                    `${PosConfig.urls.heldOrders}?per_page=1`,

                    'GET'

                );


            const pagination =
                response.pagination;


            const countValue =
                Number(
                    pagination?.total
                    ?? 0
                );


            this.toggle(
                this.elements.heldSalesCount,
                countValue > 0
            );


            if (
                this.elements.heldSalesCount
            ) {

                this.elements.heldSalesCount.textContent =
                    countValue;

            }

        } catch (error) {

            // Keep count hidden on failure.

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Product Inspector
    |--------------------------------------------------------------------------
    */

    async openProductInspector(id) {

        try {

            const url =
                `${PosConfig.urls.products}/${id}`;


            const response =
                await this.request(
                    url,
                    'GET'
                );


            const product =
                response.data
                ?? response.product;


            this.state.selectedProduct =
                product;


            this.renderProductInspector(
                product
            );


            this.productInspector?.show();

        } catch (error) {

            this.showError(
                'Unable to load product details.'
            );

        }

    },


    renderProductInspector(product) {

        if (!product) {
            return;
        }


        if (
            this.elements.inspectorProductImage
        ) {

            if (
                product.image
            ) {

                this.elements.inspectorProductImage.innerHTML = `

                    <img
                        src="/uploads/products/${this.escape(product.image)}"
                        alt="${this.escape(product.name)}"
                    >

                `;

            } else {

                this.elements.inspectorProductImage.innerHTML = `

                    <i class="bi bi-box-seam"></i>

                `;

            }

        }


        this.setText(
            this.elements.inspectorProductName,
            product.name
            ?? '—'
        );


        this.setText(
            this.elements.inspectorProductCode,
            product.product_code
            ?? product.sku
            ?? '—'
        );


        this.setMoney(
            this.elements.inspectorSellingPrice,
            product.selling_price
        );


        this.setText(
            this.elements.inspectorStock,
            this.formatQuantity(
                product.stock
                ?? 0
            )
        );


        this.setText(
            this.elements.inspectorUnit,
            product.unit?.name
            ?? '—'
        );


        this.setText(
            this.elements.inspectorCategory,
            product.category?.name
            ?? '—'
        );


        this.setText(
            this.elements.inspectorSku,
            product.sku
            ?? '—'
        );


        this.setText(
            this.elements.inspectorBarcode,
            product.barcode
            ?? '—'
        );


        if (
            this.elements.inspectorAddProduct
        ) {

            this.elements.inspectorAddProduct.onclick =
                () => {

                    this.addProductToCart(
                        product
                    );

                    this.productInspector?.hide();

                };

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Sale Completion
    |--------------------------------------------------------------------------
    */

    showSaleCompleted(data) {

        this.modals.payment?.hide();


        const order =
            data.order
            ?? this.state.currentOrder
            ?? {};


        const payment =
            data.payment
            ?? {};


        this.setMoney(
            this.elements.completeTotal,
            order.grand_total
            ?? order.total
            ?? 0
        );


        this.setText(
            this.elements.completeOrderNo,
            order.order_no
            ?? order.id
            ?? '—'
        );


        this.setText(
            this.elements.completePaymentMethod,
            payment.payment_method
            ?? this.state.selectedPaymentMethod
            ?? '—'
        );


        this.setMoney(
            this.elements.completeChange,
            data.change
            ?? order.change_given
            ?? 0
        );


        this.modals.saleComplete?.show();

    },


    printReceipt() {

        const order =
            this.state.currentOrder;


        if (!order?.id) {

            this.showError(
                'There is no completed sale to print.'
            );

            return;

        }


        const url =
            `${PosConfig.urls.receipt}/${order.id}/receipt`;


        window.open(
            url,
            '_blank'
        );

    },


    previewCurrentSale() {

        if (
            !this.state.cart.length
        ) {

            this.showError(
                'There are no items to preview.'
            );

            return;

        }


        this.showSuccess(
            'Sale preview is available during payment.'
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    focusProductSearch() {

        this.elements.productSearch?.focus();

        this.elements.productSearch?.select();

    },


    clearProductSearch() {

        if (
            this.elements.productSearch
        ) {

            this.elements.productSearch.value =
                '';

        }


        this.state.productsSearch =
            '';

        this.toggle(
            this.elements.productSearchClear,
            false
        );

    },


    hideSearchResults() {

        this.elements.searchResults?.classList.add(
            'd-none'
        );

    },


    setText(
        element,
        value
    ) {

        if (
            element
        ) {

            element.textContent =
                value
                ?? '—';

        }

    },


    setMoney(
        element,
        value
    ) {

        if (
            element
        ) {

            element.textContent =
                this.formatMoney(
                    value
                );

        }

    },


    formatMoney(value) {

        const amount =
            parseFloat(
                value
                ?? 0
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
            Number.isNaN(
                amount
            )
                ? 0
                : amount
        );

    },


    formatQuantity(value) {

        const quantity =
            Number(
                value
                ?? 0
            );


        if (
            Number.isInteger(
                quantity
            )
        ) {

            return String(
                quantity
            );

        }


        return quantity.toFixed(
            2
        );

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


        if (
            loading
        ) {

            button.dataset.originalHtml =
                button.innerHTML;

            button.disabled =
                true;

            button.innerHTML = `

                <span
                    class="spinner-border spinner-border-sm me-1"
                    role="status"
                ></span>

                ${this.escape(text)}

            `;

        } else {

            button.disabled =
                false;


            if (
                button.dataset.originalHtml
            ) {

                button.innerHTML =
                    button.dataset.originalHtml;

            }

        }

    },


    renderPagination(
        container,
        pagination,
        callback
    ) {

        if (!container) {
            return;
        }


        if (!pagination) {

            container.innerHTML =
                '';

            return;

        }


        const currentPage =
            Number(
                pagination.current_page
                ?? 1
            );


        const lastPage =
            Number(
                pagination.last_page
                ?? 1
            );


        if (
            lastPage <= 1
        ) {

            container.innerHTML =
                '';

            return;

        }


        container.innerHTML = `

            <div class="d-flex align-items-center justify-content-between">

                <small class="text-muted">

                    Page ${currentPage}
                    of
                    ${lastPage}

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
                                Number(
                                    button.dataset.page
                                );


                            if (
                                page < 1
                                || page > lastPage
                            ) {

                                return;

                            }


                            callback(
                                page
                            );

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

    confirmAction(
        title,
        message,
        action
    ) {

        if (
            typeof showToast === 'function'
        ) {

            const confirmed =
                window.confirm(
                    `${title}\n\n${message}`
                );


            if (
                confirmed
            ) {

                action();

            }


            return;

        }


        if (
            window.confirm(
                `${title}\n\n${message}`
            )
        ) {

            action();

        }

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

                Accept:
                    'application/json',

                'X-CSRF-TOKEN':
                    document.querySelector(
                        'meta[name="csrf-token"]'
                    )?.getAttribute(
                        'content'
                    ),

            },

        };


        if (
            data
            && method !== 'GET'
        ) {

            options.body =
                data;

        }


        const response =
            await fetch(
                url,
                options
            );


        let result =
            {};


        try {

            result =
                await response.json();

        } catch (error) {

            result =
                {};

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
    | Errors
    |--------------------------------------------------------------------------
    */

    handleRequestError(
        error
    ) {

        if (
            error?.errors
            && Object.keys(
                error.errors
            ).length
        ) {

            const messages =
                Object.values(
                    error.errors
                )
                .flat()
                .join(
                    ' '
                );


            this.showError(
                messages
            );

            return;

        }


        this.showError(
            error?.message
            ?? 'Something went wrong.'
        );

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

    },

    /*
    |--------------------------------------------------------------------------
    | Escape
    |--------------------------------------------------------------------------
    */

    escape(value) {

        const div =
            document.createElement(
                'div'
            );


        div.textContent =
            value
            ?? '';


        return div.innerHTML;

    },

};


/*
|--------------------------------------------------------------------------
| Fullscreen State
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'fullscreenchange',
    () => {

        if (
            document.fullscreenElement
        ) {

            POS.hideFullscreenOverlay();

        } else {

            POS.showFullscreenOverlay();

        }

    }
);


/*
|--------------------------------------------------------------------------
| Initialize POS
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    () => {

        POS.init();

    }
);