window.PublicStorefront = {

    state: {

        cart: [],

        searchTimer: null,

    },


    elements: {},


    init() {

        this.cacheElements();

        this.loadCart();

        this.bindEvents();

        this.updateCartCount();

        this.renderCartDrawer();

        this.renderCartPage();

    },


    cacheElements() {

        this.elements = {

            searchInput:
                document.getElementById(
                    'storefrontSearchInput'
                ),

            searchClear:
                document.getElementById(
                    'storefrontSearchClear'
                ),

            searchResults:
                document.getElementById(
                    'storefrontSearchResults'
                ),

            mobileSearch:
                document.getElementById(
                    'storefrontMobileSearch'
                ),

            menuToggle:
                document.getElementById(
                    'storefrontMenuToggle'
                ),

            navigation:
                document.getElementById(
                    'storefrontNavigation'
                ),

            cartButton:
                document.getElementById(
                    'storefrontCartButton'
                ),

            cartCount:
                document.getElementById(
                    'storefrontCartCount'
                ),

            cartDrawer:
                document.getElementById(
                    'storefrontCartDrawer'
                ),

            cartBackdrop:
                document.getElementById(
                    'storefrontCartBackdrop'
                ),

            cartClose:
                document.getElementById(
                    'storefrontCartClose'
                ),

            drawerItems:
                document.getElementById(
                    'storefrontDrawerItems'
                ),

            drawerEmpty:
                document.getElementById(
                    'storefrontDrawerEmpty'
                ),

            drawerFooter:
                document.getElementById(
                    'storefrontDrawerFooter'
                ),

            drawerSubtotal:
                document.getElementById(
                    'storefrontDrawerSubtotal'
                ),

            cartPage:
                document.getElementById(
                    'storefrontCartPage'
                ),

            cartItems:
                document.getElementById(
                    'storefrontCartItems'
                ),

            emptyCart:
                document.getElementById(
                    'storefrontEmptyCart'
                ),

            cartSummary:
                document.getElementById(
                    'storefrontCartSummary'
                ),

            summaryItems:
                document.getElementById(
                    'cartSummaryItems'
                ),

            summarySubtotal:
                document.getElementById(
                    'cartSummarySubtotal'
                ),

            checkoutButton:
                document.getElementById(
                    'storefrontCheckoutButton'
                ),

            toastStack:
                document.getElementById(
                    'storefrontToastStack'
                ),

            floatingCategoryTrigger:
                document.getElementById(
                    'floatingCategoryTrigger'
                ),

            floatingCategoryPanel:
                document.getElementById(
                    'floatingCategoryPanel'
                ),

            floatingCategoryClose:
                document.getElementById(
                    'floatingCategoryClose'
                ),

            floatingCategoryBackdrop:
                document.getElementById(
                    'floatingCategoryBackdrop'
                ),

        };

    },


    bindEvents() {

        document
            .querySelectorAll(
                '[data-cart-add]'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            this.addFromButton(
                                button
                            );

                        }
                    );

                }
            );


        this.elements.cartButton
            ?.addEventListener(
                'click',
                () => {

                    this.openCartDrawer();

                }
            );


        this.elements.cartClose
            ?.addEventListener(
                'click',
                () => {

                    this.closeCartDrawer();

                }
            );


        this.elements.cartBackdrop
            ?.addEventListener(
                'click',
                () => {

                    this.closeCartDrawer();

                }
            );


        this.elements.menuToggle
            ?.addEventListener(
                'click',
                () => {

                    this.elements.navigation
                        ?.classList.toggle(
                            'is-open'
                        );

                }
            );


        this.elements.mobileSearch
            ?.addEventListener(
                'click',
                () => {

                    this.elements.searchInput
                        ?.focus();

                }
            );


        this.elements.searchInput
            ?.addEventListener(
                'input',
                event => {

                    this.scheduleSearch(
                        event.target.value
                    );

                }
            );


        this.elements.searchClear
            ?.addEventListener(
                'click',
                () => {

                    this.clearSearch();

                }
            );

        this.elements
            .floatingCategoryTrigger
            ?.addEventListener(
                'click',
                () => {

                    this.openCategoryPanel();

                }
            );


        this.elements
            .floatingCategoryClose
            ?.addEventListener(
                'click',
                () => {

                    this.closeCategoryPanel();

                }
            );


        this.elements
            .floatingCategoryBackdrop
            ?.addEventListener(
                'click',
                () => {

                    this.closeCategoryPanel();

                }
            );


        document
            .querySelector(
                '[data-quantity-minus]'
            )
            ?.addEventListener(
                'click',
                () => {

                    this.changeProductQuantity(
                        -1
                    );

                }
            );


        document
            .querySelector(
                '[data-quantity-plus]'
            )
            ?.addEventListener(
                'click',
                () => {

                    this.changeProductQuantity(
                        1
                    );

                }
            );


       this.elements.checkoutButton
        ?.addEventListener(
            'click',
            event => {

                event.preventDefault();

                const checkoutUrl =
                    this.elements
                        .checkoutButton
                        .dataset
                        .checkoutUrl;


                if (!checkoutUrl) {

                    this.showToast(
                        'Checkout is currently unavailable.',
                        'error'
                    );

                    return;

                }


                window.location.href =
                    checkoutUrl;

            }
        );


        document.addEventListener(
            'click',
            event => {

                if (
                    !event.target.closest(
                        '.sf-search-area'
                    )
                ) {

                    this.closeSearch();

                }

            }
        );


        document.addEventListener(
            'keydown',
            event => {

                if (
                    event.key ===
                    'Escape'
                ) {

                    this.closeCartDrawer();

                    this.closeSearch();

                }

            }
        );

    },


    getStorefrontSlug() {

        return document
            .querySelector(
                'meta[name="storefront-slug"]'
            )
            ?.content || 'store';

    },


    getCartKey() {

        return (
            'emnex_storefront_cart_' +
            this.getStorefrontSlug()
        );

    },


    currencySymbol() {

        return document
            .querySelector(
                'meta[name="storefront-currency-symbol"]'
            )
            ?.content || '₦';

    },


    loadCart() {

        try {

            this.state.cart =
                JSON.parse(
                    localStorage.getItem(
                        this.getCartKey()
                    )
                    || '[]'
                );

        } catch (error) {

            this.state.cart = [];

        }

    },


    saveCart() {

        localStorage.setItem(
            this.getCartKey(),
            JSON.stringify(
                this.state.cart
            )
        );

        this.updateCartCount();

        this.renderCartDrawer();

    },

    clearCart() {

        this.state.cart =
            [];

        this.saveCart();

    },


    addFromButton(button) {

        const stock =
            Number(
                button.dataset.productStock
                || 0
            );


        if (stock <= 0) {

            this.showToast(
                'This product is currently out of stock.',
                'warning'
            );

            return;

        }


        let quantity = 1;


        if (
            button.dataset.quantitySource
        ) {

            const source =
                document.getElementById(
                    button.dataset
                        .quantitySource
                );


            quantity =
                Number(
                    source?.value
                    || 1
                );

        }


        const product = {

            id:
                Number(
                    button.dataset
                        .productId
                ),

            code:
                button.dataset
                    .productCode,

            name:
                button.dataset
                    .productName,

            price:
                Number(
                    button.dataset
                        .productPrice
                ),

            image:
                button.dataset
                    .productImage,

            url:
                button.dataset
                    .productUrl,

            stock:
                stock,

        };


        this.addToCart(
            product,
            quantity
        );

    },


    addToCart(
        product,
        quantity = 1
    ) {

        quantity =
            Math.max(
                1,
                Number(quantity)
            );


        const existing =
            this.state.cart.find(
                item =>
                    item.id ===
                    product.id
            );


        if (existing) {

            existing.stock =
                product.stock;


            existing.quantity =
                Math.min(
                    existing.quantity +
                    quantity,
                    product.stock
                );

        } else {

            this.state.cart.push({
                ...product,

                quantity:
                    Math.min(
                        quantity,
                        product.stock
                    ),
            });

        }


        this.saveCart();


        this.showToast(
            `${product.name} added to cart.`,
            'success'
        );


        this.openCartDrawer();

    },


    updateCartCount() {

        const count =
            this.state.cart.reduce(
                (
                    total,
                    item
                ) =>
                    total +
                    Number(
                        item.quantity
                    ),
                0
            );


        if (
            this.elements.cartCount
        ) {

            this.elements.cartCount
                .textContent =
                    count;

        }

    },


    openCartDrawer() {

        this.renderCartDrawer();


        this.elements.cartDrawer
            ?.classList.add(
                'is-open'
            );


        this.elements.cartBackdrop
            ?.classList.add(
                'is-open'
            );


        document.body
            .classList.add(
                'sf-no-scroll'
            );

    },


    closeCartDrawer() {

        this.elements.cartDrawer
            ?.classList.remove(
                'is-open'
            );


        this.elements.cartBackdrop
            ?.classList.remove(
                'is-open'
            );


        document.body
            .classList.remove(
                'sf-no-scroll'
            );

    },


    renderCartDrawer() {

        if (
            !this.elements.drawerItems
        ) {

            return;

        }


        if (
            !this.state.cart.length
        ) {

            this.elements.drawerItems
                .innerHTML = '';


            this.elements.drawerEmpty
                ?.removeAttribute(
                    'hidden'
                );


            if (
                this.elements.drawerFooter
            ) {

                this.elements.drawerFooter
                    .style.display =
                        'none';

            }


            return;

        }


        this.elements.drawerEmpty
            ?.setAttribute(
                'hidden',
                'hidden'
            );


        if (
            this.elements.drawerFooter
        ) {

            this.elements.drawerFooter
                .style.display = '';

        }


        this.elements.drawerItems
            .innerHTML =
                this.state.cart
                    .map(
                        item =>
                            this.drawerItemMarkup(
                                item
                            )
                    )
                    .join('');


        const subtotal =
            this.calculateSubtotal();


        if (
            this.elements.drawerSubtotal
        ) {

            this.elements.drawerSubtotal
                .textContent =
                    this.money(
                        subtotal
                    );

        }


        this.bindDrawerEvents();

    },


    drawerItemMarkup(item) {

        return `

            <div class="sf-drawer-item">

                <a
                    href="${this.escapeHtml(
                        item.url
                    )}"
                    class="sf-drawer-item-image"
                >

                    <img
                        src="${this.escapeHtml(
                            item.image
                        )}"
                        alt="${this.escapeHtml(
                            item.name
                        )}"
                    >

                </a>


                <div class="sf-drawer-item-content">

                    <a
                        href="${this.escapeHtml(
                            item.url
                        )}"
                        class="sf-drawer-item-name"
                    >
                        ${this.escapeHtml(
                            item.name
                        )}
                    </a>


                    <strong>

                        ${this.money(
                            item.price
                        )}

                    </strong>


                    <div class="sf-drawer-quantity">

                        <button
                            type="button"
                            data-drawer-minus="${item.id}"
                        >
                            −
                        </button>

                        <span>
                            ${item.quantity}
                        </span>

                        <button
                            type="button"
                            data-drawer-plus="${item.id}"
                        >
                            +
                        </button>

                    </div>

                </div>


                <button
                    type="button"
                    class="sf-drawer-remove"
                    data-drawer-remove="${item.id}"
                >

                    <i class="bi bi-trash"></i>

                </button>

            </div>

        `;

    },


    bindDrawerEvents() {

        document
            .querySelectorAll(
                '[data-drawer-minus]'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            this.adjustItem(
                                Number(
                                    button.dataset
                                        .drawerMinus
                                ),
                                -1
                            );

                        }
                    );

                }
            );


        document
            .querySelectorAll(
                '[data-drawer-plus]'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            this.adjustItem(
                                Number(
                                    button.dataset
                                        .drawerPlus
                                ),
                                1
                            );

                        }
                    );

                }
            );


        document
            .querySelectorAll(
                '[data-drawer-remove]'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            this.removeCartItem(
                                Number(
                                    button.dataset
                                        .drawerRemove
                                )
                            );

                        }
                    );

                }
            );

    },


    adjustItem(
        id,
        amount
    ) {

        const item =
            this.state.cart.find(
                row =>
                    row.id === id
            );


        if (!item) {
            return;
        }


        this.changeCartQuantity(
            id,
            item.quantity +
            amount
        );

    },


    changeCartQuantity(
        productId,
        quantity
    ) {

        const item =
            this.state.cart.find(
                row =>
                    row.id ===
                    productId
            );


        if (!item) {
            return;
        }


        quantity =
            Number(quantity);


        if (quantity <= 0) {

            this.removeCartItem(
                productId
            );

            return;

        }


        item.quantity =
            Math.min(
                quantity,
                Number(
                    item.stock
                )
            );


        this.saveCart();

        this.renderCartPage();

    },


    removeCartItem(
        productId
    ) {

        this.state.cart =
            this.state.cart.filter(
                item =>
                    item.id !==
                    productId
            );


        this.saveCart();

        this.renderCartPage();

    },


    calculateSubtotal() {

        return this.state.cart.reduce(
            (
                total,
                item
            ) =>
                total +
                (
                    Number(
                        item.price
                    )
                    *
                    Number(
                        item.quantity
                    )
                ),
            0
        );

    },


    renderCartPage() {

        if (
            !this.elements.cartPage ||
            !this.elements.cartItems
        ) {

            return;

        }


        if (
            !this.state.cart.length
        ) {

            this.elements.cartItems
                .innerHTML = '';


            this.elements.emptyCart
                ?.removeAttribute(
                    'hidden'
                );


            if (
                this.elements.cartSummary
            ) {

                this.elements.cartSummary
                    .style.display =
                        'none';

            }


            return;

        }


        this.elements.emptyCart
            ?.setAttribute(
                'hidden',
                'hidden'
            );


        if (
            this.elements.cartSummary
        ) {

            this.elements.cartSummary
                .style.display = '';

        }


        this.elements.cartItems
            .innerHTML =
                this.state.cart
                    .map(
                        item =>
                            this.cartItemMarkup(
                                item
                            )
                    )
                    .join('');


        this.bindCartPageEvents();

        this.updateCartSummary();

    },


    cartItemMarkup(item) {

        return `

            <article class="sf-full-cart-item">

                <a
                    href="${this.escapeHtml(
                        item.url
                    )}"
                    class="sf-full-cart-image"
                >

                    <img
                        src="${this.escapeHtml(
                            item.image
                        )}"
                        alt="${this.escapeHtml(
                            item.name
                        )}"
                    >

                </a>


                <div class="sf-full-cart-info">

                    <a
                        href="${this.escapeHtml(
                            item.url
                        )}"
                    >

                        ${this.escapeHtml(
                            item.name
                        )}

                    </a>


                    <span>

                        ${this.money(
                            item.price
                        )}

                    </span>

                </div>


                <div class="sf-full-cart-quantity">

                    <button
                        type="button"
                        data-cart-minus="${item.id}"
                    >
                        −
                    </button>

                    <input
                        type="number"
                        value="${item.quantity}"
                        min="1"
                        max="${item.stock}"
                        data-cart-quantity="${item.id}"
                    >

                    <button
                        type="button"
                        data-cart-plus="${item.id}"
                    >
                        +
                    </button>

                </div>


                <strong class="sf-full-cart-total">

                    ${this.money(
                        item.price *
                        item.quantity
                    )}

                </strong>


                <button
                    type="button"
                    class="sf-full-cart-remove"
                    data-cart-remove="${item.id}"
                >

                    <i class="bi bi-trash"></i>

                </button>

            </article>

        `;

    },


    openCategoryPanel() {

    this.elements
        .floatingCategoryPanel
        ?.classList.add(
            'is-open'
        );


    this.elements
        .floatingCategoryBackdrop
        ?.classList.add(
            'is-open'
        );


    this.elements
        .floatingCategoryTrigger
        ?.classList.add(
            'is-hidden'
        );


    document.body
        .classList.add(
            'sf-no-scroll'
        );

},


closeCategoryPanel() {

    this.elements
        .floatingCategoryPanel
        ?.classList.remove(
            'is-open'
        );


    this.elements
        .floatingCategoryBackdrop
        ?.classList.remove(
            'is-open'
        );


    this.elements
        .floatingCategoryTrigger
        ?.classList.remove(
            'is-hidden'
        );


    document.body
        .classList.remove(
            'sf-no-scroll'
        );

},


    bindCartPageEvents() {

        document
            .querySelectorAll(
                '[data-cart-minus]'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            this.adjustItem(
                                Number(
                                    button.dataset
                                        .cartMinus
                                ),
                                -1
                            );

                        }
                    );

                }
            );


        document
            .querySelectorAll(
                '[data-cart-plus]'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            this.adjustItem(
                                Number(
                                    button.dataset
                                        .cartPlus
                                ),
                                1
                            );

                        }
                    );

                }
            );


        document
            .querySelectorAll(
                '[data-cart-remove]'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            this.removeCartItem(
                                Number(
                                    button.dataset
                                        .cartRemove
                                )
                            );

                        }
                    );

                }
            );


        document
            .querySelectorAll(
                '[data-cart-quantity]'
            )
            .forEach(
                input => {

                    input.addEventListener(
                        'change',
                        () => {

                            this.changeCartQuantity(
                                Number(
                                    input.dataset
                                        .cartQuantity
                                ),
                                Number(
                                    input.value
                                )
                            );

                        }
                    );

                }
            );

    },


    updateCartSummary() {

        const items =
            this.state.cart.reduce(
                (
                    total,
                    item
                ) =>
                    total +
                    Number(
                        item.quantity
                    ),
                0
            );


        if (
            this.elements.summaryItems
        ) {

            this.elements.summaryItems
                .textContent =
                    items;

        }


        if (
            this.elements.summarySubtotal
        ) {

            this.elements.summarySubtotal
                .textContent =
                    this.money(
                        this.calculateSubtotal()
                    );

        }

    },


    changeProductQuantity(
        amount
    ) {

        const input =
            document.getElementById(
                'productQuantity'
            );


        if (!input) {
            return;
        }


        const min =
            Number(
                input.min || 1
            );


        const max =
            Number(
                input.max || 999999
            );


        const next =
            Number(
                input.value || 1
            ) + amount;


        input.value =
            Math.max(
                min,
                Math.min(
                    next,
                    max
                )
            );

    },


    scheduleSearch(value) {

        clearTimeout(
            this.state.searchTimer
        );


        const query =
            String(
                value || ''
            ).trim();


        if (
            query.length < 2
        ) {

            this.closeSearch();

            return;

        }


        this.state.searchTimer =
            setTimeout(
                () => {

                    this.search(
                        query
                    );

                },
                250
            );

    },


    async search(query) {

        const endpoint =
            document
                .querySelector(
                    'meta[name="storefront-search-url"]'
                )
                ?.content;


        if (!endpoint) {
            return;
        }


        try {

            const response =
                await fetch(
                    `${endpoint}?q=${encodeURIComponent(
                        query
                    )}`,
                    {
                        headers: {

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',

                        },
                    }
                );


            const data =
                await response.json();


            if (!response.ok) {

                throw new Error(
                    data.message ||
                    'Unable to search.'
                );

            }


            this.renderSearchResults(
                data.data || []
            );


        } catch (error) {

            console.error(
                'Storefront search:',
                error
            );

        }

    },


    renderSearchResults(
        products
    ) {

        const container =
            this.elements.searchResults;


        if (!container) {
            return;
        }


        if (!products.length) {

            container.innerHTML = `

                <div class="sf-search-empty">

                    <i class="bi bi-search"></i>

                    <span>
                        No matching products found
                    </span>

                </div>

            `;


            container.classList.add(
                'is-open'
            );

            return;

        }


        container.innerHTML =
            products
                .map(
                    product => `

                        <a
                            href="${this.escapeHtml(
                                product.url
                            )}"
                            class="sf-search-result"
                        >

                            <img
                                src="${this.escapeHtml(
                                    product.image_url
                                )}"
                                alt=""
                            >

                            <span>

                                <strong>
                                    ${this.escapeHtml(
                                        product.name
                                    )}
                                </strong>

                                <small>

                                    ${this.escapeHtml(
                                        product.formatted_price
                                    )}

                                </small>

                            </span>

                            ${
                                product.in_stock
                                    ? ''
                                    : '<em>Out of stock</em>'
                            }

                        </a>

                    `
                )
                .join('');


        container.classList.add(
            'is-open'
        );

    },


    clearSearch() {

        if (
            this.elements.searchInput
        ) {

            this.elements.searchInput
                .value = '';

        }


        this.closeSearch();

    },


    closeSearch() {

        this.elements.searchResults
            ?.classList.remove(
                'is-open'
            );

    },


    money(value) {

        return (
            this.currencySymbol()
            +
            Number(value)
                .toLocaleString(
                    undefined,
                    {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    }
                )
        );

    },


    showToast(
        message,
        type = 'success'
    ) {

        const container =
            this.elements.toastStack;


        if (!container) {
            return;
        }


        const toast =
            document.createElement(
                'div'
            );


        toast.className =
            `sf-toast is-${type}`;


        const icon =
            type === 'success'
                ? 'bi-check-circle-fill'
                : type === 'warning'
                    ? 'bi-exclamation-circle-fill'
                    : 'bi-info-circle-fill';


        toast.innerHTML = `

            <i class="bi ${icon}"></i>

            <span>

                ${this.escapeHtml(
                    message
                )}

            </span>

        `;


        container.appendChild(
            toast
        );


        requestAnimationFrame(
            () => {

                toast.classList.add(
                    'is-visible'
                );

            }
        );


        setTimeout(
            () => {

                toast.classList.remove(
                    'is-visible'
                );


                setTimeout(
                    () => toast.remove(),
                    250
                );

            },
            3000
        );

    },


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


document.addEventListener(
    'DOMContentLoaded',
    () => {

        window.PublicStorefront.init();

    }
);