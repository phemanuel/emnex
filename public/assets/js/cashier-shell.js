
/*
|--------------------------------------------------------------------------
| EMNEX POS - CASHIER SHELL
|--------------------------------------------------------------------------
*/

window.CashierShell = {

    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    elements: {

        shell:
            document.getElementById(
                'cashier-shell'
            ),

        workspace:
            document.getElementById(
                'cashier-shell-workspace'
            ),

        homeView:
            document.getElementById(
                'cashier-home-view'
            ),

        frameView:
            document.getElementById(
                'cashier-frame-view'
            ),

        frame:
            document.getElementById(
                'cashier-shell-frame'
            ),

        homeButton:
            document.getElementById(
                'cashier-home-button'
            ),

        fullscreenOverlay:
            document.getElementById(
                'pos-fullscreen-overlay'
            ),

        fullscreenButton:
            document.getElementById(
                'pos-enter-fullscreen'
            ),

        drawerStatus:
            document.getElementById(
                'cashier-shell-drawer-status'
            ),

        drawerStatusText:
            document.getElementById(
                'cashier-shell-status-text'
            ),

        drawerStatusDot:
            document.getElementById(
                'cashier-shell-status-dot'
            ),

        /*
        |--------------------------------------------------------------------------
        | Cashier KPI
        |--------------------------------------------------------------------------
        */

        salesKpi:
            document.getElementById(
                'cashier-kpi-sales'
            ),

        transactionsKpi:
            document.getElementById(
                'cashier-kpi-transactions'
            ),

        cashSalesKpi:
            document.getElementById(
                'cashier-kpi-cash-sales'
            ),

        transferSalesKpi:
            document.getElementById(
                'cashier-kpi-transfer-sales'
            ),

        walletSalesKpi:
            document.getElementById(
                'cashier-kpi-wallet-sales'
            ),

        cardSalesKpi:
            document.getElementById(
                'cashier-kpi-card-sales'
            ),

        submissionKpi:
            document.getElementById(
                'cashier-kpi-submission'
            ),

        drawerKpi:
            document.getElementById(
                'cashier-kpi-drawer'
            )

    },


    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    state: {

        currentView:
            'home',

        currentUrl:
            null,

        statsRequest:
            null,

        drawerRequest:
            null,

        frameLoading:
            false

    },


    /*
    |--------------------------------------------------------------------------
    | Initialize
    |--------------------------------------------------------------------------
    */

    init() {

        if (
            !this.elements.shell
        ) {

            return;
        }


        this.bindNavigation();

        this.bindFullscreen();

        this.bindFrame();

        this.loadInitialState();

    },


    /*
    |--------------------------------------------------------------------------
    | Initial State
    |--------------------------------------------------------------------------
    */

    loadInitialState() {

        this.showHome();

        this.loadCashierStats();

        this.loadDrawerStatus();

        this.updateFullscreenState();

    },


    /*
    |--------------------------------------------------------------------------
    | Navigation
    |--------------------------------------------------------------------------
    */

    bindNavigation() {

        /*
        |--------------------------------------------------------------------------
        | Header Navigation
        |--------------------------------------------------------------------------
        */

        const navigationButtons =
            document.querySelectorAll(
                '[data-cashier-page]'
            );


        navigationButtons.forEach(
            button => {

                button.addEventListener(
                    'click',
                    event => {

                        event.preventDefault();

                        const url =
                            button.dataset.cashierPage;


                        if (!url) {

                            return;
                        }


                        this.navigate(
                            url
                        );

                    }
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Cashier Home
        |--------------------------------------------------------------------------
        */

        this.elements.homeButton?.addEventListener(
            'click',
            event => {

                event.preventDefault();

                this.showHome();

            }
        );

    },

 /*
    |--------------------------------------------------------------------------
    | Navigate Url
    |--------------------------------------------------------------------------
    */

   navigate(url) {

    if (!url) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Cashier Home
    |--------------------------------------------------------------------------
    */

    if (
        this.isCashierHomeUrl(url)
    ) {

        this.showHome();

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Embedded Page
    |--------------------------------------------------------------------------
    */

    if (
        !this.elements.frame
        || !this.elements.frameView
    ) {

        return;
    }


    this.state.currentView =
        'frame';

    this.state.currentUrl =
        url;

    this.state.frameLoading =
        true;


    /*
    |--------------------------------------------------------------------------
    | Hide Old Frame Content
    |--------------------------------------------------------------------------
    |
    | Prevent the previous page from flashing while the new
    | embedded page is loading.
    |
    */

    this.elements.frameView
        .classList.add(
            'is-loading'
        );


    /*
    |--------------------------------------------------------------------------
    | Clear Previous Page
    |--------------------------------------------------------------------------
    */

    this.elements.frame.src =
        'about:blank';


    /*
    |--------------------------------------------------------------------------
    | Show Frame
    |--------------------------------------------------------------------------
    */

    this.elements.homeView
        ?.classList.add(
            'd-none'
        );

    this.elements.frameView
        ?.classList.remove(
            'd-none'
        );


    /*
    |--------------------------------------------------------------------------
    | Load New Page
    |--------------------------------------------------------------------------
    */

    requestAnimationFrame(
        () => {

            this.elements.frame.src =
                this.appendEmbeddedParameter(
                    url
                );

        }
    );

},


    /*
    |--------------------------------------------------------------------------
    | Show Home
    |--------------------------------------------------------------------------
    */

    showHome() {

        this.state.currentView =
            'home';

        this.state.currentUrl =
            null;

        this.state.frameLoading =
            false;


        this.elements.frameView
            ?.classList.add(
                'd-none'
            );


        this.elements.homeView
            ?.classList.remove(
                'd-none'
            );


        /*
        |--------------------------------------------------------------------------
        | Refresh Home Data
        |--------------------------------------------------------------------------
        */

        this.loadCashierStats();

        this.loadDrawerStatus();

    },


    /*
    |--------------------------------------------------------------------------
    | Determine Cashier Home URL
    |--------------------------------------------------------------------------
    */

    isCashierHomeUrl(url) {

        try {

            const target =
                new URL(
                    url,
                    window.location.origin
                );


            const pathname =
                target.pathname.replace(
                    /\/+$/,
                    ''
                );


            return (
                pathname === '/pos/cashier'
            );

        } catch (error) {

            return (
                String(url)
                    .replace(
                        /\/+$/,
                        ''
                    )
                    .endsWith(
                        '/pos/cashier'
                    )
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Embedded Parameter
    |--------------------------------------------------------------------------
    */

    appendEmbeddedParameter(url) {

        try {

            const target =
                new URL(
                    url,
                    window.location.origin
                );


            target.searchParams.set(
                'embedded',
                '1'
            );


            return target.toString();

        } catch (error) {

            return url;
        }

    },


    /*
    |--------------------------------------------------------------------------
    | Frame
    |--------------------------------------------------------------------------
    */

    bindFrame() {

        this.elements.frame?.addEventListener(
            'load',
            () => {

                this.state.frameLoading =
                    false;


                this.prepareFrame();

            }
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Prepare Embedded Page
    |--------------------------------------------------------------------------
    */

    prepareFrame() {

        const frame =
            this.elements.frame;


        if (!frame) {

            return;
        }


        try {

            const frameDocument =
                frame.contentDocument
                || frame.contentWindow?.document;


            if (!frameDocument) {

                return;
            }


            this.injectFrameStyles(
                frameDocument
            );


            this.bindFrameNavigation(
                frameDocument
            );


        } catch (error) {

            console.error(
                'Unable to prepare cashier frame:',
                error
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Embedded Navigation
    |--------------------------------------------------------------------------
    */

    bindFrameNavigation(document) {

        const links =
            document.querySelectorAll(
                'a[data-cashier-page]'
            );


        links.forEach(
            link => {

                link.addEventListener(
                    'click',
                    event => {

                        event.preventDefault();

                        const url =
                            link.dataset.cashierPage;


                        if (!url) {

                            return;
                        }


                        this.navigate(
                            url
                        );

                    }
                );

            }
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Inject Embedded Page Styles
    |--------------------------------------------------------------------------
    */

    injectFrameStyles(document) {

        if (
            document.getElementById(
                'emnex-cashier-shell-frame-style'
            )
        ) {

            return;
        }


        const style =
            document.createElement(
                'style'
            );


        style.id =
            'emnex-cashier-shell-frame-style';


        style.textContent = `

            html,
            body {

                width:
                    100% !important;

                min-width:
                    0 !important;

                max-width:
                    none !important;

                margin:
                    0 !important;

                padding:
                    0 !important;

            }


            /*
            |--------------------------------------------------------------------------
            | Hide Embedded Headers
            |--------------------------------------------------------------------------
            */

            .cashier-topbar,
            .pos-topbar {

                display:
                    none !important;

            }


            /*
            |--------------------------------------------------------------------------
            | Hide Embedded Fullscreen Overlay
            |--------------------------------------------------------------------------
            */

            .pos-fullscreen-overlay {

                display:
                    none !important;

            }


            /*
            |--------------------------------------------------------------------------
            | Remove Embedded Application Restrictions
            |--------------------------------------------------------------------------
            */

            .cashier-app {

                width:
                    100% !important;

                min-width:
                    0 !important;

                max-width:
                    none !important;

                height:
                    100% !important;

                min-height:
                    100% !important;

            }


            .cashier-main {

                width:
                    100% !important;

                max-width:
                    none !important;

                min-width:
                    0 !important;

                margin:
                    0 !important;

            }


            /*
            |--------------------------------------------------------------------------
            | Embedded POS Screen
            |--------------------------------------------------------------------------
            */

            .pos-app {

                width:
                    100% !important;

                min-width:
                    0 !important;

                max-width:
                    none !important;

            }

        `;


        document.head.appendChild(
            style
        );

    },


   /*
    |--------------------------------------------------------------------------
    | Cashier Statistics
    |--------------------------------------------------------------------------
    */

    async loadCashierStats() {

        if (
            this.state.statsRequest
        ) {

            this.state.statsRequest.abort();

        }


        this.state.statsRequest =
            new AbortController();


        try {

            const response =
                await fetch(
                    '/pos/cashier/stats',
                    {
                        method: 'GET',

                        headers: {

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest'

                        },

                        signal:
                            this.state.statsRequest.signal

                    }
                );


            const result =
                await response.json();


            /*
            |--------------------------------------------------------------------------
            | Response Validation
            |--------------------------------------------------------------------------
            */

            if (
                !response.ok
            ) {

                throw new Error(
                    result.message
                    || 'Unable to load cashier statistics.'
                );

            }


            if (
                !result.success
            ) {

                throw new Error(
                    result.message
                    || 'Unable to load cashier statistics.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Statistics
            |--------------------------------------------------------------------------
            */

            const data =
                result.data
                || {};


            /*
            |--------------------------------------------------------------------------
            | Total Sales
            |--------------------------------------------------------------------------
            */

            this.updateKpi(
                this.elements.salesKpi,
                data.sales ?? 0,
                true
            );


            /*
            |--------------------------------------------------------------------------
            | Transactions
            |--------------------------------------------------------------------------
            */

            this.updateKpi(
                this.elements.transactionsKpi,
                data.transactions ?? 0,
                false
            );


            /*
            |--------------------------------------------------------------------------
            | Cash Sales
            |--------------------------------------------------------------------------
            */

            this.updateKpi(
                this.elements.cashSalesKpi,
                data.cash_sales ?? 0,
                true
            );


            /*
            |--------------------------------------------------------------------------
            | Transfer Sales
            |--------------------------------------------------------------------------
            */

            this.updateKpi(
                this.elements.transferSalesKpi,
                data.transfer_sales ?? 0,
                true
            );


            /*
            |--------------------------------------------------------------------------
            | Wallet Sales
            |--------------------------------------------------------------------------
            */

            this.updateKpi(
                this.elements.walletSalesKpi,
                data.wallet_sales ?? 0,
                true
            );


            /*
            |--------------------------------------------------------------------------
            | Card Sales
            |--------------------------------------------------------------------------
            */

            this.updateKpi(
                this.elements.cardSalesKpi,
                data.card_sales ?? 0,
                true
            );


            /*
            |--------------------------------------------------------------------------
            | Drawer Balance
            |--------------------------------------------------------------------------
            */

            this.updateKpi(
                this.elements.drawerKpi,
                data.drawer_balance ?? 0,
                true
            );

            /*
            |--------------------------------------------------------------------------
            | Expected Submission
            |--------------------------------------------------------------------------
            */

            this.updateKpi(
                this.elements.submissionKpi,
                data.expected_submission ?? 0,
                true
             );


        } catch (error) {

            if (
                error.name ===
                'AbortError'
            ) {

                return;
            }


            console.error(
                'Cashier statistics error:',
                error
            );

        } finally {

            this.state.statsRequest =
                null;

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Get Statistic Value
    |--------------------------------------------------------------------------
    */

    getStat(
        data,
        keys,
        fallback = 0
    ) {

        for (
            const key of keys
        ) {

            if (
                data[key] !== undefined
                && data[key] !== null
            ) {

                return data[key];

            }

        }


        return fallback;

    },


    /*
    |--------------------------------------------------------------------------
    | Update KPI
    |--------------------------------------------------------------------------
    */

    updateKpi(
        element,
        value,
        currency = false
    ) {

        if (!element) {

            return;
        }


        const numericValue =
            Number(
                value || 0
            );


        if (currency) {

            element.textContent =
                this.formatCurrency(
                    numericValue
                );

            return;
        }


        element.textContent =
            numericValue.toLocaleString();

    },


    /*
    |--------------------------------------------------------------------------
    | Format Currency
    |--------------------------------------------------------------------------
    */

    formatCurrency(value) {

        const numericValue =
            Number(
                value || 0
            );


        return (
            '₦' +
            numericValue.toLocaleString(
                'en-NG',
                {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }
            )
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Drawer Status
    |--------------------------------------------------------------------------
    */

    async loadDrawerStatus() {

        if (
            this.state.drawerRequest
        ) {

            this.state.drawerRequest.abort();

        }


        this.state.drawerRequest =
            new AbortController();


        try {

            const response =
                await fetch(
                    '/cash-drawer/current',
                    {
                        method: 'GET',

                        headers: {

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest'

                        },

                        signal:
                            this.state.drawerRequest.signal

                    }
                );


            const result =
                await response.json();


            if (
                !response.ok
            ) {

                throw new Error(
                    result.message
                    || 'Unable to load drawer status.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Current Drawer Response
            |--------------------------------------------------------------------------
            |
            | Use the drawer returned by the existing Cash Drawer endpoint.
            |
            */

            const drawer =
                result.data?.drawer
                ?? result.drawer
                ?? result.data?.currentDrawer
                ?? result.currentDrawer
                ?? null;


            const status =
                String(
                    drawer?.status
                    ?? ''
                ).toLowerCase();


            const isOpen =
                status === 'open';


            this.updateDrawerStatus(
                isOpen
            );


        } catch (error) {

            if (
                error.name ===
                'AbortError'
            ) {

                return;
            }


            console.error(
                'Cashier drawer status error:',
                error
            );


            /*
            |--------------------------------------------------------------------------
            | Do Not Incorrectly Report Closed
            |--------------------------------------------------------------------------
            */

            return;

        } finally {

            this.state.drawerRequest =
                null;

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Update Drawer Status
    |--------------------------------------------------------------------------
    */

    updateDrawerStatus(isOpen) {

        if (
            this.elements.drawerStatus
        ) {

            this.elements.drawerStatus.classList.toggle(
                'is-open',
                isOpen
            );


            this.elements.drawerStatus.classList.toggle(
                'is-closed',
                !isOpen
            );

        }


        if (
            this.elements.drawerStatusText
        ) {

            this.elements.drawerStatusText.textContent =
                isOpen
                    ? 'Drawer Open'
                    : 'Drawer Closed';

        }


        if (
            this.elements.drawerStatusDot
        ) {

            this.elements.drawerStatusDot.classList.toggle(
                'is-open',
                isOpen
            );


            this.elements.drawerStatusDot.classList.toggle(
                'is-closed',
                !isOpen
            );

        }

    },


   


    /*
    |--------------------------------------------------------------------------
    | Fullscreen
    |--------------------------------------------------------------------------
    */

    bindFullscreen() {

        /*
        |--------------------------------------------------------------------------
        | Existing POS Fullscreen Implementation
        |--------------------------------------------------------------------------
        */

        if (
            window.POS
            && typeof POS.cacheElements ===
                'function'
        ) {

            POS.cacheElements();

        }


        if (
            this.elements.fullscreenButton
        ) {

            this.elements.fullscreenButton
                .addEventListener(
                    'click',
                    () => {

                        this.enterFullscreen();

                    }
                );

        }


        document.addEventListener(
            'fullscreenchange',
            () => {

                this.updateFullscreenState();

            }
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Enter Fullscreen
    |--------------------------------------------------------------------------
    */

    async enterFullscreen() {

        try {

            if (
                document.fullscreenElement
            ) {

                this.hideFullscreenOverlay();

                return;
            }


            await document.documentElement.requestFullscreen();


        } catch (error) {

            console.error(
                'Unable to enter fullscreen:',
                error
            );


            if (
                window.POS
                && typeof POS.showError ===
                    'function'
            ) {

                POS.showError(
                    'Unable to enter full screen. Please allow fullscreen mode in your browser.'
                );

            }

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Fullscreen State
    |--------------------------------------------------------------------------
    */

    updateFullscreenState() {

        if (
            document.fullscreenElement
        ) {

            this.hideFullscreenOverlay();

            return;
        }


        this.showFullscreenOverlay();

    },


    /*
    |--------------------------------------------------------------------------
    | Show Fullscreen Overlay
    |--------------------------------------------------------------------------
    */

    showFullscreenOverlay() {

        this.elements.fullscreenOverlay
            ?.classList.remove(
                'd-none'
            );

    },


    /*
    |--------------------------------------------------------------------------
    | Hide Fullscreen Overlay
    |--------------------------------------------------------------------------
    */

    hideFullscreenOverlay() {

        this.elements.fullscreenOverlay
            ?.classList.add(
                'd-none'
            );

    }

};


/*
|--------------------------------------------------------------------------
| Initialize Cashier Shell
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    () => {

        window.CashierShell.init();

    }
);
