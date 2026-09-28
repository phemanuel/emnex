window.StorefrontCheckout = {

    state: {

        items: [],

        quote: null,

        loading: false,

    },


    elements: {},


    init() {

        this.cacheElements();

        if (!this.elements.root) {
            return;
        }

        this.state.items =
            this.getCartItems();

        this.bindEvents();

        this.loadQuote();

    },


    cacheElements() {

        this.elements = {

            root:
                document.getElementById(
                    'storefrontCheckout'
                ),

            form:
                document.getElementById(
                    'storefrontCheckoutForm'
                ),

            alert:
                document.getElementById(
                    'checkoutAlert'
                ),

            loading:
                document.getElementById(
                    'checkoutLoading'
                ),

            items:
                document.getElementById(
                    'checkoutItems'
                ),

            empty:
                document.getElementById(
                    'checkoutEmpty'
                ),

            totals:
                document.getElementById(
                    'checkoutTotals'
                ),

            itemCount:
                document.getElementById(
                    'checkoutItemCount'
                ),

            subtotal:
                document.getElementById(
                    'checkoutSubtotal'
                ),

            discountRow:
                document.getElementById(
                    'checkoutDiscountRow'
                ),

            discount:
                document.getElementById(
                    'checkoutDiscount'
                ),

            taxRow:
                document.getElementById(
                    'checkoutTaxRow'
                ),

            tax:
                document.getElementById(
                    'checkoutTax'
                ),

            grandTotal:
                document.getElementById(
                    'checkoutGrandTotal'
                ),

            payButton:
                document.getElementById(
                    'checkoutPayButton'
                ),

            payText:
                document.querySelector(
                    '.shop-checkout-pay-text'
                ),

            payLoader:
                document.getElementById(
                    'checkoutPayLoader'
                ),

            shippingLocation:
                document.getElementById(
                    'shipping_location_id'
                ),

            shippingRow:
                document.getElementById(
                    'checkoutShippingRow'
                ),

            shipping:
                document.getElementById(
                    'checkoutShipping'
                ),

        };

    },


    bindEvents() {

        this.elements.form
            ?.addEventListener(
                'submit',
                event => {

                    event.preventDefault();

                    this.submit();

                }
            );

            this.elements.shippingLocation
            ?.addEventListener(
                'change',
                () => {

                    this.loadQuote();

                }
            );

        document
        .querySelectorAll('.shop-shipping-option')
        .forEach(option => {

            option.addEventListener(
                'click',
                () => {

                    const select =
                        document.getElementById(
                            'shipping_location_id'
                        );

                    const buttonText =
                        document.getElementById(
                            'shippingLocationButtonText'
                        );


                    if (!select || !buttonText) {
                        return;
                    }


                    select.value =
                        option.dataset.locationId;


                    buttonText.textContent =
                        `${option.dataset.locationName} — ${
                            this.state.quote?.currency_symbol || '₦'
                        }${this.money(
                            option.dataset.locationFee
                        )}`;


                    select.dispatchEvent(
                        new Event(
                            'change',
                            {
                                bubbles: true
                            }
                        )
                    );

                }
            );

        });

    },


    /*
    |--------------------------------------------------------------------------
    | Cart Bridge
    |--------------------------------------------------------------------------
    */

    getCartItems() {

        /*
         * The existing PublicStorefront module owns the cart.
         */

        if (
            window.PublicStorefront &&
            typeof window.PublicStorefront.getCheckoutItems ===
                'function'
        ) {

            return window.PublicStorefront
                .getCheckoutItems();

        }


        /*
         * Fallback when state is publicly available.
         */

        const cart =
            window.PublicStorefront
                ?.state
                ?.cart;


        if (Array.isArray(cart)) {

            return cart
                .map(item => ({

                    id:
                        Number(
                            item.id ??
                            item.product_id
                        ),

                    quantity:
                        Number(
                            item.quantity ??
                            item.qty ??
                            1
                        ),

                }))
                .filter(
                    item =>
                        item.id > 0 &&
                        item.quantity > 0
                );

        }


        return [];

    },


    /*
    |--------------------------------------------------------------------------
    | Quote
    |--------------------------------------------------------------------------
    */

    async loadQuote() {

        this.hideAlert();


        if (!this.state.items.length) {

            this.renderEmpty();

            return;

        }


        this.elements.loading
            ?.removeAttribute(
                'hidden'
            );

            this.elements.payButton.disabled =  true;


        try {

            const response =
                await fetch(
                    this.elements.root
                        .dataset
                        .quoteUrl,
                    {

                        method:
                            'POST',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                this.csrfToken(),

                        },

                        body:
                        JSON.stringify({

                            items:
                                this.state.items,

                            shipping_location_id:
                                this.elements.shippingLocation
                                    ? Number(
                                        this.elements
                                            .shippingLocation
                                            .value
                                    ) || null
                                    : null,

                        }),

                    }
                );


            const data =
                await response.json();


            if (!response.ok) {

                throw new Error(
                    this.responseMessage(
                        data
                    )
                );

            }


            this.state.quote =
                data.data;


            this.renderQuote(
                data.data
            );

        } catch (error) {

            this.showAlert(
                error.message ||
                'We could not validate your bag.'
            );

            this.elements.payButton.disabled =
                true;

        } finally {

            this.elements.loading
                ?.setAttribute(
                    'hidden',
                    'hidden'
                );

        }

    },


    renderQuote(quote) {

        if (
            !quote.items ||
            !quote.items.length
        ) {

            this.renderEmpty();

            return;

        }


        const currency =
            quote.currency_symbol ||
            '₦';


        this.elements.items.innerHTML =
            quote.items
                .map(
                    item => `
                        <article class="shop-checkout-item">

                            <div class="shop-checkout-item-image">

                                <img
                                    src="${this.escapeHtml(item.image_url)}"
                                    alt="${this.escapeHtml(item.product_name)}"
                                >

                                <span>
                                    ${item.quantity}
                                </span>

                            </div>


                            <div class="shop-checkout-item-info">

                                <h3>
                                    ${this.escapeHtml(item.product_name)}
                                </h3>

                                <p>
                                    Qty ${item.quantity}
                                </p>

                            </div>


                            <strong class="shop-checkout-item-price">
                                ${currency}${this.money(item.total)}
                            </strong>

                        </article>
                    `
                )
                .join('');


        this.elements.items
            .removeAttribute(
                'hidden'
            );


        this.elements.empty
            ?.setAttribute(
                'hidden',
                'hidden'
            );


        this.elements.totals
            ?.removeAttribute(
                'hidden'
            );


        this.elements.itemCount.textContent =
            `${quote.total_quantity} ${
                Number(
                    quote.total_quantity
                ) === 1
                    ? 'item'
                    : 'items'
            }`;


        this.elements.subtotal.textContent =
            `${currency}${this.money(
                quote.subtotal
            )}`;


        if (
            Number(
                quote.discount
            ) > 0
        ) {

            this.elements.discountRow
                .removeAttribute(
                    'hidden'
                );


            this.elements.discount.textContent =
                `-${currency}${this.money(
                    quote.discount
                )}`;

        } else {

            this.elements.discountRow
                .setAttribute(
                    'hidden',
                    'hidden'
                );

        }


        if (
            Number(
                quote.tax
            ) > 0
        ) {

            this.elements.taxRow
                .removeAttribute(
                    'hidden'
                );


            this.elements.tax.textContent =
                `${currency}${this.money(
                    quote.tax
                )}`;

        } else {

            this.elements.taxRow
                .setAttribute(
                    'hidden',
                    'hidden'
                );

        }

        if (quote.shipping_enabled) {

            this.elements.shippingRow
                ?.removeAttribute(
                    'hidden'
                );


            if (this.elements.shipping) {

                this.elements.shipping.textContent =
                    `${currency}${this.money(
                        quote.shipping_fee
                    )}`;

            }

        } else {

            this.elements.shippingRow
                ?.setAttribute(
                    'hidden',
                    'hidden'
                );

        }


        this.elements.grandTotal.textContent =
            `${currency}${this.money(
                quote.grand_total
            )}`;


        this.elements.payButton.disabled =
         quote.shipping_resolved === false;

    },


    renderEmpty() {

        this.elements.loading
            ?.setAttribute(
                'hidden',
                'hidden'
            );


        this.elements.items
            ?.setAttribute(
                'hidden',
                'hidden'
            );


        this.elements.totals
            ?.setAttribute(
                'hidden',
                'hidden'
            );


        this.elements.empty
            ?.removeAttribute(
                'hidden'
            );


        this.elements.payButton.disabled =
            true;


        if (
            this.elements.itemCount
        ) {

            this.elements.itemCount.textContent =
                '0 items';

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Submit
    |--------------------------------------------------------------------------
    */

    async submit() {

        if (
            this.state.loading ||
            !this.state.quote
        ) {
            return;
        }


        if (
            !this.elements.form
                .checkValidity()
        ) {

            this.elements.form
                .reportValidity();

            return;

        }


        this.setLoading(
            true
        );


        this.hideAlert();


        const formData =
            new FormData(
                this.elements.form
            );


        const payload = {

            first_name:
                formData.get(
                    'first_name'
                ),

            last_name:
                formData.get(
                    'last_name'
                ),

            email:
                formData.get(
                    'email'
                ),

            phone:
                formData.get(
                    'phone'
                ),

            address:
                formData.get(
                    'address'
                ),

            city:
                formData.get(
                    'city'
                ),

            state:
                formData.get(
                    'state'
                ),

            shipping_location_id:
                formData.get(
                    'shipping_location_id'
                )
                    ? Number(
                        formData.get(
                            'shipping_location_id'
                        )
                    )
                    : null,

            items:
                this.state.items,

        };

        try {

            const response =
                await fetch(
                    this.elements.root
                        .dataset
                        .payUrl,
                    {

                        method:
                            'POST',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                this.csrfToken(),

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
                    this.responseMessage(
                        data
                    )
                );

            }


            if (
                !data.authorization_url
            ) {

                throw new Error(
                    'The secure payment page could not be opened.'
                );

            }


            window.location.href =
                data.authorization_url;

        } catch (error) {

            this.showAlert(
                error.message ||
                'We could not start your payment.'
            );


            this.setLoading(
                false
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | UI
    |--------------------------------------------------------------------------
    */

    setLoading(loading) {

        this.state.loading =
            loading;


        this.elements.payButton.disabled =
            loading;


        if (loading) {

            this.elements.payText
                ?.setAttribute(
                    'hidden',
                    'hidden'
                );


            this.elements.payLoader
                ?.removeAttribute(
                    'hidden'
                );

        } else {

            this.elements.payLoader
                ?.setAttribute(
                    'hidden',
                    'hidden'
                );


            this.elements.payText
                ?.removeAttribute(
                    'hidden'
                );


            if (
                this.state.quote
            ) {

                this.elements.payButton.disabled =
                    false;

            }

        }

    },


    showAlert(message) {

        if (!this.elements.alert) {
            return;
        }


        this.elements.alert.textContent =
            message;


        this.elements.alert
            .removeAttribute(
                'hidden'
            );


        this.elements.alert
            .scrollIntoView({

                behavior:
                    'smooth',

                block:
                    'center',

            });

    },


    hideAlert() {

        this.elements.alert
            ?.setAttribute(
                'hidden',
                'hidden'
            );

    },


    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    csrfToken() {

        return this.elements.form
            ?.querySelector(
                'input[name="_token"]'
            )
            ?.value
            || '';

    },


    responseMessage(data) {

        if (data?.message) {

            return data.message;

        }


        if (data?.errors) {

            const first =
                Object.values(
                    data.errors
                )[0];


            if (
                Array.isArray(first)
            ) {

                return first[0];

            }

        }


        return 'Something went wrong. Please try again.';

    },


    money(value) {

        return Number(
            value || 0
        )
        .toLocaleString(
            undefined,
            {

                minimumFractionDigits:
                    2,

                maximumFractionDigits:
                    2,

            }
        );

    },

    getCheckoutItems() {

    return this.state.cart
        .map(item => ({

            id:
                Number(
                    item.id ??
                    item.product_id
                ),

            quantity:
                Number(
                    item.quantity ??
                    item.qty ??
                    1
                ),

        }))
        .filter(
            item =>
                item.id > 0 &&
                item.quantity > 0
        );

},


clearCart() {

    this.state.cart =
        [];


    this.saveCart();


    if (
        typeof this.renderCartDrawer ===
        'function'
    ) {

        this.renderCartDrawer();

    }


    if (
        typeof this.renderFullCart ===
        'function'
    ) {

        this.renderFullCart();

    }


    if (
        typeof this.updateCartCount ===
        'function'
    ) {

        this.updateCartCount();

    }

},


    escapeHtml(value) {

        return String(
            value ?? ''
        )
        .replace(
            /&/g,
            '&amp;'
        )
        .replace(
            /</g,
            '&lt;'
        )
        .replace(
            />/g,
            '&gt;'
        )
        .replace(
            /"/g,
            '&quot;'
        )
        .replace(
            /'/g,
            '&#039;'
        );

    },

};

window.addEventListener(
    'pageshow',
    event => {

        const checkout =
            window.StorefrontCheckout;


        if (
            !checkout ||
            !checkout.elements?.root
        ) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Reset Payment Button
        |--------------------------------------------------------------------------
        |
        | When the customer returns from Paystack, the browser may restore the
        | checkout page from its back-forward cache with the payment button
        | still showing "Preparing payment...".
        |
        */

        checkout.setLoading(false);


        /*
        |--------------------------------------------------------------------------
        | Revalidate Quote After Returning
        |--------------------------------------------------------------------------
        |
        | If this page was restored from browser history, re-check the cart,
        | stock and shipping fee before allowing another payment attempt.
        |
        */

        if (event.persisted) {

            checkout.loadQuote();

        }

    }
);


document.addEventListener(
    'DOMContentLoaded',
    function () {

        window.StorefrontCheckout
            .init();

    }
);