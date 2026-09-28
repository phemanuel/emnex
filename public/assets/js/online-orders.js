/*
|--------------------------------------------------------------------------
| EMNEX POS
|--------------------------------------------------------------------------
| Shipping - Online Orders
|--------------------------------------------------------------------------
*/

window.OnlineOrders = {

    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    elements: {},

    searchTimer: null,


    /*
    |--------------------------------------------------------------------------
    | Initialize
    |--------------------------------------------------------------------------
    */

    init()
    {
        this.cacheElements();

        if (!this.elements.page) {
            return;
        }

        this.bindEvents();
    },


    /*
    |--------------------------------------------------------------------------
    | Cache Elements
    |--------------------------------------------------------------------------
    */

    cacheElements()
    {
        this.elements = {

            page:
                document.getElementById(
                    'onlineOrdersPage'
                ),

            filters:
                document.getElementById(
                    'onlineOrdersFilters'
                ),

            search:
                document.getElementById(
                    'onlineOrdersSearch'
                ),

            fulfilmentStatus:
                document.getElementById(
                    'fulfilment_status'
                ),

            paymentStatus:
                document.getElementById(
                    'payment_status'
                ),

            shippingMethod:
                document.getElementById(
                    'shipping_method'
                ),

            dateFrom:
                document.getElementById(
                    'date_from'
                ),

            dateTo:
                document.getElementById(
                    'date_to'
                ),

        };
    },


    /*
    |--------------------------------------------------------------------------
    | Bind Events
    |--------------------------------------------------------------------------
    */

    bindEvents()
    {
        this.bindSearch();

        this.bindSelectFilters();

        this.bindDateFilters();
    },


    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    |
    | Search submits automatically after the user stops typing.
    |
    */

    bindSearch()
    {
        if (!this.elements.search) {
            return;
        }


        this.elements.search.addEventListener(
            'input',
            () => {

                clearTimeout(
                    this.searchTimer
                );


                this.searchTimer =
                    setTimeout(
                        () => {

                            this.submitFilters();

                        },
                        500
                    );

            }
        );


        this.elements.search.addEventListener(
            'keydown',
            event => {

                if (event.key !== 'Enter') {
                    return;
                }


                event.preventDefault();


                clearTimeout(
                    this.searchTimer
                );


                this.submitFilters();

            }
        );
    },


    /*
    |--------------------------------------------------------------------------
    | Select Filters
    |--------------------------------------------------------------------------
    */

    bindSelectFilters()
    {
        const filters = [

            this.elements.fulfilmentStatus,

            this.elements.paymentStatus,

            this.elements.shippingMethod,

        ];


        filters.forEach(
            element => {

                if (!element) {
                    return;
                }


                element.addEventListener(
                    'change',
                    () => {

                        this.submitFilters();

                    }
                );

            }
        );
    },


    /*
    |--------------------------------------------------------------------------
    | Date Filters
    |--------------------------------------------------------------------------
    |
    | We only auto-submit once a value exists.
    |
    */

    bindDateFilters()
    {
        const dates = [

            this.elements.dateFrom,

            this.elements.dateTo,

        ];


        dates.forEach(
            element => {

                if (!element) {
                    return;
                }


                element.addEventListener(
                    'change',
                    () => {

                        this.validateDates();


                        if (
                            element.value
                        ) {

                            this.submitFilters();

                        }

                    }
                );

            }
        );
    },


    /*
    |--------------------------------------------------------------------------
    | Validate Date Range
    |--------------------------------------------------------------------------
    */

    validateDates()
    {
        const from =
            this.elements.dateFrom?.value
            || null;


        const to =
            this.elements.dateTo?.value
            || null;


        if (
            !from ||
            !to
        ) {
            this.clearDateError();

            return true;
        }


        if (
            new Date(from) >
            new Date(to)
        ) {

            this.showDateError(
                'The start date cannot be after the end date.'
            );

            return false;
        }


        this.clearDateError();

        return true;
    },


    /*
    |--------------------------------------------------------------------------
    | Submit Filters
    |--------------------------------------------------------------------------
    */

    submitFilters()
    {
        if (!this.elements.filters) {
            return;
        }


        if (
            !this.validateDates()
        ) {
            return;
        }


        this.elements.filters.submit();
    },


    /*
    |--------------------------------------------------------------------------
    | Date Error
    |--------------------------------------------------------------------------
    */

    showDateError(message)
    {
        this.clearDateError();


        const container =
            document.createElement(
                'div'
            );


        container.className =
            'online-orders-filter-error';


        container.id =
            'onlineOrdersDateError';


        container.innerHTML = `
            <i class="bi bi-exclamation-circle"></i>
            <span>${this.escapeHtml(message)}</span>
        `;


        this.elements.filters
            ?.appendChild(
                container
            );
    },


    clearDateError()
    {
        document
            .getElementById(
                'onlineOrdersDateError'
            )
            ?.remove();
    },


    /*
    |--------------------------------------------------------------------------
    | Escape HTML
    |--------------------------------------------------------------------------
    */

    escapeHtml(value)
    {
        const element =
            document.createElement(
                'div'
            );


        element.textContent =
            value;


        return element.innerHTML;
    },

};


/*
|--------------------------------------------------------------------------
| Bootstrap
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    function () {

        window.OnlineOrders
            .init();

    }
);