window.PlatformAdmin = {

    pendingArchiveUrl: null,

    elements: {},


    init() {

        this.cacheElements();

        this.bindEvents();

        this.initCompanyTabs();

    },


    cacheElements() {

        this.elements = {

            sidebar:
                document.getElementById(
                    'platformSidebar'
                ),

            menuButton:
                document.getElementById(
                    'platformMenuButton'
                ),

            backdrop:
                document.getElementById(
                    'platformSidebarBackdrop'
                ),

            companyTabs:
                document.querySelectorAll(
                    '[data-company-tab]'
                ),

            companyPanels:
                document.querySelectorAll(
                    '[data-company-panel]'
                ),

            lifecycleScanButton:
                document.getElementById(
                    'lifecycleScanButton'
                ),

            lifecycleSettingsForm:
                document.getElementById(
                    'lifecycleSettingsForm'
                ),

            archiveButtons:
                document.querySelectorAll(
                    '[data-archive-company]'
                ),

            archiveModal:
                document.getElementById(
                    'archiveConfirmModal'
                ),

            archiveConfirmButton:
                document.getElementById(
                    'archiveConfirmButton'
                ),

            archiveCancelButton:
                document.getElementById(
                    'archiveCancelButton'
                ),

            archiveConfirmMessage:
                document.getElementById(
                    'archiveConfirmMessage'
                ),

        };

    },


    bindEvents() {

        this.elements.menuButton
            ?.addEventListener(
                'click',
                () => {

                    this.openSidebar();

                }
            );


        this.elements.backdrop
            ?.addEventListener(
                'click',
                () => {

                    this.closeSidebar();

                }
            );


        document.addEventListener(
            'keydown',
            event => {

                if (
                    event.key ===
                    'Escape'
                ) {

                    this.closeSidebar();

                }

            }
        );


        this.elements.companyTabs
            .forEach(
                tab => {

                    tab.addEventListener(
                        'click',
                        event => {

                            event.preventDefault();

                            const tabName =
                                tab.dataset.companyTab;


                            this.switchCompanyTab(
                                tabName
                            );

                        }
                    );

                }
            );

            this.elements.lifecycleScanButton
                ?.addEventListener(
                    'click',
                    () => {

                        this.scanLifecycle();

                    }
                );


            this.elements.lifecycleSettingsForm
                ?.addEventListener(
                    'submit',
                    event => {

                        event.preventDefault();

                        this.saveLifecycleSettings();

                    }
                );


            this.elements.archiveButtons
                ?.forEach(
                    button => {

                        button.addEventListener(
                            'click',
                            () => {

                                this.openArchiveModal(
                                    button
                                );

                            }
                        );

                    }
                );


            this.elements.archiveCancelButton
                ?.addEventListener(
                    'click',
                    () => {

                        this.closeArchiveModal();

                    }
                );


            this.elements.archiveConfirmButton
                ?.addEventListener(
                    'click',
                    () => {

                        this.confirmArchive();

                    }
                );

    },


    initCompanyTabs() {

        if (
            !this.elements.companyTabs.length
            ||
            !this.elements.companyPanels.length
        ) {

            return;

        }


        const activeTab =
            document.querySelector(
                '[data-company-tab].active'
            );


        const firstTab =
            activeTab
            ??
            this.elements.companyTabs[0];


        if (!firstTab) {
            return;
        }


        this.switchCompanyTab(
            firstTab.dataset.companyTab
        );

    },


    switchCompanyTab(tabName) {

        if (!tabName) {
            return;
        }


        this.elements.companyTabs
            .forEach(
                tab => {

                    const isActive =
                        tab.dataset.companyTab ===
                        tabName;


                    tab.classList.toggle(
                        'active',
                        isActive
                    );

                }
            );


        this.elements.companyPanels
            .forEach(
                panel => {

                    const isActive =
                        panel.dataset.companyPanel ===
                        tabName;


                    panel.classList.toggle(
                        'active',
                        isActive
                    );

                }
            );

    },


    openSidebar() {

        this.elements.sidebar
            ?.classList
            .add(
                'open'
            );


        this.elements.backdrop
            ?.classList
            .add(
                'open'
            );

    },


    closeSidebar() {

        this.elements.sidebar
            ?.classList
            .remove(
                'open'
            );


        this.elements.backdrop
            ?.classList
            .remove(
                'open'
            );

    },

    getCsrfToken() {

        return document
            .querySelector(
                'meta[name="csrf-token"]'
            )
            ?.getAttribute(
                'content'
            )
            ?? '';

    },


    async scanLifecycle() {

        const button =
            this.elements
                .lifecycleScanButton;


        if (!button) {
            return;
        }


        const url =
            button.dataset.url;


        button.disabled =
            true;


        const original =
            button.innerHTML;


        button.innerHTML =
            '<i class="bi bi-arrow-repeat"></i> Scanning...';


        try {

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
                                this.getCsrfToken(),

                        },
                    }
                );


            const data =
                await response.json();


            if (!response.ok) {

                throw new Error(
                    data.message
                    ??
                    'Lifecycle scan failed.'
                );

            }


            window.location.reload();

        } catch (error) {

            alert(
                error.message
            );


            button.disabled =
                false;


            button.innerHTML =
                original;

        }

    },


    async saveLifecycleSettings() {

        const form =
            this.elements
                .lifecycleSettingsForm;


        if (!form) {
            return;
        }


        const payload =
            Object.fromEntries(
                new FormData(
                    form
                )
                .entries()
            );


        payload.automatic_scheduling =
            form.querySelector(
                '[name="automatic_scheduling"]'
            )
            ?.checked
                ? 1
                : 0;


        try {

            const response =
                await fetch(
                    form.dataset.url,
                    {
                        method:
                            'PUT',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                this.getCsrfToken(),

                        },

                        body:
                            JSON.stringify(
                                payload
                            ),
                    }
                );


            const data =
                await response.json();


            if (!response.ok) {

                throw new Error(
                    data.message
                    ??
                    'Unable to save lifecycle settings.'
                );

            }


            window.location.reload();

        } catch (error) {

            alert(
                error.message
            );

        }

    },


    openArchiveModal(button) {

        const companyName =
            button.dataset.companyName;


        this.pendingArchiveUrl =
            button.dataset.url;


        if (
            this.elements
                .archiveConfirmMessage
        ) {

            this.elements
                .archiveConfirmMessage
                .textContent =
                    'EMNEX will create and verify a cold archive for '
                    +
                    companyName
                    +
                    '. No company records will be deleted at this stage.';

        }


        this.elements
            .archiveModal
            ?.removeAttribute(
                'hidden'
            );

    },


    closeArchiveModal() {

        this.pendingArchiveUrl =
            null;


        this.elements
            .archiveModal
            ?.setAttribute(
                'hidden',
                ''
            );

    },


    async confirmArchive() {

        if (
            !this.pendingArchiveUrl
        ) {

            return;
        }


        const button =
            this.elements
                .archiveConfirmButton;


        button.disabled =
            true;


        const original =
            button.innerHTML;


        button.innerHTML =
            'Scheduling...';


        try {

            const response =
                await fetch(
                    this.pendingArchiveUrl,
                    {
                        method:
                            'POST',

                        headers: {

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                this.getCsrfToken(),

                        },
                    }
                );


            const data =
                await response.json();


            if (!response.ok) {

                throw new Error(
                    data.message
                    ??
                    'Unable to schedule archive.'
                );

            }


            window.location.reload();

        } catch (error) {

            alert(
                error.message
            );


            button.disabled =
                false;


            button.innerHTML =
                original;

        }

    },

};


document.addEventListener(
    'DOMContentLoaded',
    function () {

        window.PlatformAdmin.init();

    }
);