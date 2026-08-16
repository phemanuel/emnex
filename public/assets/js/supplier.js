const Suppliers = {

    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    searchTimer: null,

    selectedSupplier: null,

    mode: 'create',

    statusAction: null,

    deleteAction: null,

    currentPage: 1,

    actionMenuOpen: false,

    bootstrap: {},


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

        this.loadTable();
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
                    'suppliersPage'
                ),

            table:
                document.getElementById(
                    'supplierTable'
                ),

            pagination:
                document.getElementById(
                    'supplierPagination'
                ),

            search:
                document.getElementById(
                    'supplierSearch'
                ),

            statusFilter:
                document.getElementById(
                    'supplierStatusFilter'
                ),

            refreshBtn:
                document.getElementById(
                    'supplierRefreshBtn'
                ),


            /*
            |--------------------------------------------------------------------------
            | KPI
            |--------------------------------------------------------------------------
            */

            totalCount:
                document.getElementById(
                    'supplierTotalCount'
                ),

            activeCount:
                document.getElementById(
                    'supplierActiveCount'
                ),

            inactiveCount:
                document.getElementById(
                    'supplierInactiveCount'
                ),

            payables:
                document.getElementById(
                    'supplierPayables'
                ),


            /*
            |--------------------------------------------------------------------------
            | Form
            |--------------------------------------------------------------------------
            */

            form:
                document.getElementById(
                    'supplierForm'
                ),

            id:
                document.getElementById(
                    'supplierId'
                ),

            name:
                document.getElementById(
                    'supplierName'
                ),

            contactPerson:
                document.getElementById(
                    'supplierContactPerson'
                ),

            email:
                document.getElementById(
                    'supplierEmail'
                ),

            phone:
                document.getElementById(
                    'supplierPhone'
                ),

            alternatePhone:
                document.getElementById(
                    'supplierAlternatePhone'
                ),

            address:
                document.getElementById(
                    'supplierAddress'
                ),

            city:
                document.getElementById(
                    'supplierCity'
                ),

            state:
                document.getElementById(
                    'supplierState'
                ),

            country:
                document.getElementById(
                    'supplierCountry'
                ),

            taxNumber:
                document.getElementById(
                    'supplierTaxNumber'
                ),

            paymentTerms:
                document.getElementById(
                    'supplierPaymentTerms'
                ),

            creditLimit:
                document.getElementById(
                    'supplierCreditLimit'
                ),

            notes:
                document.getElementById(
                    'supplierNotes'
                ),


            /*
            |--------------------------------------------------------------------------
            | Modal
            |--------------------------------------------------------------------------
            */

            modal:
                document.getElementById(
                    'supplierModal'
                ),

            modalTitle:
                document.getElementById(
                    'supplierModalTitle'
                ),

            submitBtn:
                document.getElementById(
                    'supplierSubmitBtn'
                ),

            submitText:
                document.getElementById(
                    'supplierSubmitText'
                ),

            submitSpinner:
                document.getElementById(
                    'supplierSubmitSpinner'
                ),


            /*
            |--------------------------------------------------------------------------
            | Inspector
            |--------------------------------------------------------------------------
            */

            inspector:
                document.getElementById(
                    'supplierInspector'
                ),

            inspectorName:
                document.getElementById(
                    'supplierInspectorName'
                ),

            inspectorCode:
                document.getElementById(
                    'supplierInspectorCode'
                ),

            inspectorStatus:
                document.getElementById(
                    'supplierInspectorStatus'
                ),

            inspectorContact:
                document.getElementById(
                    'supplierInspectorContact'
                ),

            inspectorEmail:
                document.getElementById(
                    'supplierInspectorEmail'
                ),

            inspectorPhone:
                document.getElementById(
                    'supplierInspectorPhone'
                ),

            inspectorAlternatePhone:
                document.getElementById(
                    'supplierInspectorAlternatePhone'
                ),

            inspectorAddress:
                document.getElementById(
                    'supplierInspectorAddress'
                ),

            inspectorCreditLimit:
                document.getElementById(
                    'supplierInspectorCreditLimit'
                ),

            inspectorBalance:
                document.getElementById(
                    'supplierInspectorBalance'
                ),

            inspectorAvailableCredit:
                document.getElementById(
                    'supplierInspectorAvailableCredit'
                ),

            inspectorTaxNumber:
                document.getElementById(
                    'supplierInspectorTaxNumber'
                ),

            inspectorPaymentTerms:
                document.getElementById(
                    'supplierInspectorPaymentTerms'
                ),

            inspectorNotes:
                document.getElementById(
                    'supplierInspectorNotes'
                ),

            inspectorCreatedBy:
                document.getElementById(
                    'supplierInspectorCreatedBy'
                ),

            inspectorCreatedAt:
                document.getElementById(
                    'supplierInspectorCreatedAt'
                ),

            inspectorUpdatedBy:
                document.getElementById(
                    'supplierInspectorUpdatedBy'
                ),

            inspectorUpdatedAt:
                document.getElementById(
                    'supplierInspectorUpdatedAt'
                ),


            /*
            |--------------------------------------------------------------------------
            | Confirmation
            |--------------------------------------------------------------------------
            */

            confirmModal:
                document.getElementById(
                    'supplierConfirmModal'
                ),

            confirmIcon:
                document.getElementById(
                    'supplierConfirmIcon'
                ),

            confirmTitle:
                document.getElementById(
                    'supplierConfirmTitle'
                ),

            confirmMessage:
                document.getElementById(
                    'supplierConfirmMessage'
                ),

            confirmDescription:
                document.getElementById(
                    'supplierConfirmDescription'
                ),

            confirmBtn:
                document.getElementById(
                    'supplierConfirmBtn'
                ),


            /*
            |--------------------------------------------------------------------------
            | Global Action Menu
            |--------------------------------------------------------------------------
            */

            globalActionMenu:
                document.getElementById(
                    'supplierGlobalActionMenu'
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
        if (
            this.elements.modal
            && window.bootstrap
        ) {

            this.bootstrap.modal =
                bootstrap.Modal.getOrCreateInstance(
                    this.elements.modal
                );
        }


        if (
            this.elements.inspector
            && window.bootstrap
        ) {

            this.bootstrap.inspector =
                bootstrap.Offcanvas.getOrCreateInstance(
                    this.elements.inspector
                );
        }


        if (
            this.elements.confirmModal
            && window.bootstrap
        ) {

            this.bootstrap.confirm =
                bootstrap.Modal.getOrCreateInstance(
                    this.elements.confirmModal
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
        if (this.elements.search) {

            this.elements.search.addEventListener(
                'input',
                () => {

                    clearTimeout(
                        this.searchTimer
                    );

                    this.searchTimer =
                        setTimeout(
                            () => {

                                this.loadTable(1);

                            },
                            350
                        );
                }
            );
        }


        if (this.elements.statusFilter) {

            this.elements.statusFilter.addEventListener(
                'change',
                () => {

                    this.loadTable(1);

                }
            );
        }


        if (this.elements.refreshBtn) {

            this.elements.refreshBtn.addEventListener(
                'click',
                () => {

                    this.loadTable(
                        this.currentPage
                    );

                }
            );
        }


        if (this.elements.form) {

            this.elements.form.addEventListener(
                'submit',
                (event) => {

                    event.preventDefault();

                    this.saveSupplier();

                }
            );
        }


        if (this.elements.confirmBtn) {

            this.elements.confirmBtn.addEventListener(
                'click',
                () => {

                    this.executeConfirmation();

                }
            );
        }


        document.addEventListener(
            'click',
            (event) => {

                const trigger =
                    event.target.closest(
                        '.supplier-action-trigger'
                    );


                if (trigger) {

                    event.preventDefault();

                    event.stopPropagation();

                    this.openActionMenu(
                        trigger
                    );

                    return;
                }


                if (
                    this.elements.globalActionMenu
                    && ! event.target.closest(
                        '#supplierGlobalActionMenu'
                    )
                ) {

                    this.closeActionMenu();

                }

            }
        );


        window.addEventListener(
            'resize',
            () => {

                if (
                    this.actionMenuOpen
                    && this.selectedSupplier
                ) {

                    this.positionActionMenu();

                }

            }
        );


        window.addEventListener(
            'scroll',
            () => {

                if (
                    this.actionMenuOpen
                    && this.selectedSupplier
                ) {

                    this.positionActionMenu();

                }

            },
            true
        );
    },


    /*
    |--------------------------------------------------------------------------
    | Load Table
    |--------------------------------------------------------------------------
    */

    async loadTable(
        page = 1
    )
    {
        this.currentPage = page;

        this.closeActionMenu();

        this.showTableLoading();


        try {

            const params =
                new URLSearchParams({

                    page:
                        page,

                    search:
                        this.elements.search?.value
                        ?? '',

                    status:
                        this.elements.statusFilter?.value
                        ?? 'all',

                });


            const response =
                await fetch(
                    `/purchase/suppliers/table?${params.toString()}`,
                    {
                        headers: {

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',

                        },
                    }
                );


            const result =
                await response.json();


            if (! response.ok) {

                throw new Error(
                    result.message
                    ||
                    'Unable to load suppliers.'
                );
            }


            if (! result.success) {

                throw new Error(
                    result.message
                    ||
                    'Unable to load suppliers.'
                );
            }


            this.elements.table.innerHTML =
                result.html
                ?? '';


            this.elements.pagination.innerHTML =
                result.pagination
                ?? '';


            this.updateStats(
                result.stats
            );


        } catch (error) {

            console.error(
                'Supplier table error:',
                error
            );


            this.elements.table.innerHTML = `

                <div class="supplier-loading-state text-danger">

                    <i class="bi bi-exclamation-circle"></i>

                    <span>
                        ${this.escapeHtml(
                            error.message
                        )}
                    </span>

                </div>

            `;


            this.showToast(
                error.message,
                'error'
            );
        }
    },


    /*
    |--------------------------------------------------------------------------
    | Show Table Loading
    |--------------------------------------------------------------------------
    */

    showTableLoading()
    {
        this.elements.table.innerHTML = `

            <div class="supplier-loading-state">

                <div
                    class="spinner-border spinner-border-sm text-primary"
                    role="status"
                ></div>

                <span>
                    Loading suppliers...
                </span>

            </div>

        `;
    },


    /*
    |--------------------------------------------------------------------------
    | Update Statistics
    |--------------------------------------------------------------------------
    */

    updateStats(
        stats
    )
    {
        if (! stats) {

            return;
        }


        if (this.elements.totalCount) {

            this.elements.totalCount.textContent =
                this.formatNumber(
                    stats.total
                );
        }


        if (this.elements.activeCount) {

            this.elements.activeCount.textContent =
                this.formatNumber(
                    stats.active
                );
        }


        if (this.elements.inactiveCount) {

            this.elements.inactiveCount.textContent =
                this.formatNumber(
                    stats.inactive
                );
        }


        if (this.elements.payables) {

            this.elements.payables.textContent =
                this.formatMoney(
                    stats.payables
                );
        }
    },


    /*
    |--------------------------------------------------------------------------
    | Open Create Modal
    |--------------------------------------------------------------------------
    */

    openCreateModal()
    {
        this.mode = 'create';

        this.clearFormErrors();

        this.elements.form.reset();

        this.elements.id.value =
            '';

        this.elements.country.value =
            'Nigeria';

        this.elements.creditLimit.value =
            '0';

        this.elements.modalTitle.textContent =
            'Add Supplier';

        this.elements.submitText.textContent =
            'Save Supplier';

        this.setSubmitLoading(
            false
        );


        if (this.bootstrap.modal) {

            this.bootstrap.modal.show();

        }
    },


    /*
    |--------------------------------------------------------------------------
    | Open Edit Modal
    |--------------------------------------------------------------------------
    */

    async openEditModal(
        id
    )
    {
        this.mode = 'edit';

        this.clearFormErrors();

        this.setSubmitLoading(
            true
        );


        try {

            const response =
                await fetch(
                    `/purchase/suppliers/${id}/details`,
                    {
                        headers: {

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',

                        },
                    }
                );


            const result =
                await response.json();


            if (! response.ok || ! result.success) {

                throw new Error(
                    result.message
                    ||
                    'Unable to load supplier.'
                );
            }


            this.populateForm(
                result.data
            );


            this.elements.modalTitle.textContent =
                'Edit Supplier';

            this.elements.submitText.textContent =
                'Update Supplier';


            if (this.bootstrap.modal) {

                this.bootstrap.modal.show();

            }

        } catch (error) {

            console.error(
                error
            );

            this.showToast(
                error.message,
                'error'
            );

        } finally {

            this.setSubmitLoading(
                false
            );
        }
    },


    /*
    |--------------------------------------------------------------------------
    | Populate Form
    |--------------------------------------------------------------------------
    */

    populateForm(
        supplier
    )
    {
        this.elements.id.value =
            supplier.id
            ?? '';

        this.elements.name.value =
            supplier.name
            ?? '';

        this.elements.contactPerson.value =
            supplier.contact_person
            ?? '';

        this.elements.email.value =
            supplier.email
            ?? '';

        this.elements.phone.value =
            supplier.phone
            ?? '';

        this.elements.alternatePhone.value =
            supplier.alternate_phone
            ?? '';

        this.elements.address.value =
            supplier.address
            ?? '';

        this.elements.city.value =
            supplier.city
            ?? '';

        this.elements.state.value =
            supplier.state
            ?? '';

        this.elements.country.value =
            supplier.country
            ?? '';

        this.elements.taxNumber.value =
            supplier.tax_number
            ?? '';

        this.elements.paymentTerms.value =
            supplier.payment_terms
            ?? '';

        this.elements.creditLimit.value =
            supplier.credit_limit
            ?? 0;

        this.elements.notes.value =
            supplier.notes
            ?? '';
    },


    /*
    |--------------------------------------------------------------------------
    | Save Supplier
    |--------------------------------------------------------------------------
    */

    async saveSupplier()
    {
        this.clearFormErrors();

        const formData =
            new FormData(
                this.elements.form
            );


        const id =
            this.elements.id.value;


        const isEdit =
            this.mode === 'edit'
            && id;


        let url =
            '/purchase/suppliers';


        if (isEdit) {

            url =
                `/purchase/suppliers/${id}`;

            formData.append(
                '_method',
                'PUT'
            );
        }


        this.setSubmitLoading(
            true
        );


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
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',

                            'X-CSRF-TOKEN':
                                this.getCsrfToken(),

                        },
                    }
                );


            const result =
                await response.json();


            if (
                response.status === 422
                && result.errors
            ) {

                this.displayValidationErrors(
                    result.errors
                );

                this.showToast(
                    result.message
                    ||
                    'Please correct the highlighted fields.',
                    'error'
                );

                return;
            }


            if (! response.ok || ! result.success) {

                throw new Error(
                    result.message
                    ||
                    'Unable to save supplier.'
                );
            }


            if (this.bootstrap.modal) {

                this.bootstrap.modal.hide();

            }


            this.showToast(
                result.message
                ||
                'Supplier saved successfully.',
                'success'
            );


            await this.loadTable(
                1
            );


        } catch (error) {

            console.error(
                'Supplier save error:',
                error
            );


            this.showToast(
                error.message,
                'error'
            );

        } finally {

            this.setSubmitLoading(
                false
            );
        }
    },


    /*
    |--------------------------------------------------------------------------
    | Open Inspector
    |--------------------------------------------------------------------------
    */

    async openInspector(
        id
    )
    {
        try {

            const response =
                await fetch(
                    `/purchase/suppliers/${id}/details`,
                    {
                        headers: {

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',

                        },
                    }
                );


            const result =
                await response.json();


            if (! response.ok || ! result.success) {

                throw new Error(
                    result.message
                    ||
                    'Unable to load supplier details.'
                );
            }


            this.selectedSupplier =
                result.data;


            this.populateInspector(
                result.data
            );


            if (this.bootstrap.inspector) {

                this.bootstrap.inspector.show();

            }

        } catch (error) {

            console.error(
                'Supplier inspector error:',
                error
            );


            this.showToast(
                error.message,
                'error'
            );
        }
    },


    /*
    |--------------------------------------------------------------------------
    | Populate Inspector
    |--------------------------------------------------------------------------
    */

    populateInspector(
        supplier
    )
    {
        this.elements.inspectorName.textContent =
            supplier.name
            ?? '—';

        this.elements.inspectorCode.textContent =
            supplier.supplier_code
            ?? '—';

        this.elements.inspectorContact.textContent =
            supplier.contact_person
            || '—';

        this.elements.inspectorEmail.textContent =
            supplier.email
            || '—';

        this.elements.inspectorPhone.textContent =
            supplier.phone
            || '—';

        this.elements.inspectorAlternatePhone.textContent =
            supplier.alternate_phone
            || '—';

        this.elements.inspectorAddress.textContent =
            this.buildAddress(
                supplier
            );

        this.elements.inspectorCreditLimit.textContent =
            this.formatMoney(
                supplier.credit_limit
            );

        this.elements.inspectorBalance.textContent =
            this.formatMoney(
                supplier.current_balance
            );

        this.elements.inspectorAvailableCredit.textContent =
            this.formatMoney(
                supplier.available_credit
            );

        this.elements.inspectorTaxNumber.textContent =
            supplier.tax_number
            || '—';

        this.elements.inspectorPaymentTerms.textContent =
            supplier.payment_terms
            || '—';

        this.elements.inspectorNotes.textContent =
            supplier.notes
            || '—';

        this.elements.inspectorCreatedBy.textContent =
            supplier.created_by
            || '—';

        this.elements.inspectorCreatedAt.textContent =
            supplier.created_at
            || '—';

        this.elements.inspectorUpdatedBy.textContent =
            supplier.updated_by
            || '—';

        this.elements.inspectorUpdatedAt.textContent =
            supplier.updated_at
            || '—';


        const isActive =
            Boolean(
                supplier.status
            );


        this.elements.inspectorStatus.textContent =
            supplier.status_label
            ||
            (
                isActive
                    ? 'Active'
                    : 'Inactive'
            );


        this.elements.inspectorStatus.className =
            `
                badge
                rounded-pill
                ${
                    isActive
                        ? 'bg-success-subtle text-success'
                        : 'bg-secondary-subtle text-secondary'
                }
            `;
    },


    /*
    |--------------------------------------------------------------------------
    | Build Address
    |--------------------------------------------------------------------------
    */

    buildAddress(
        supplier
    )
    {
        const parts = [

            supplier.address,

            supplier.city,

            supplier.state,

            supplier.country,

        ].filter(
            Boolean
        );


        return parts.length
            ? parts.join(', ')
            : '—';
    },


    /*
    |--------------------------------------------------------------------------
    | Open Action Menu
    |--------------------------------------------------------------------------
    */

    openActionMenu(
        trigger
    )
    {
        const id =
            trigger.dataset.supplierId;


        if (! id) {

            return;
        }


        this.selectedSupplier = {

            id:
                id,

            name:
                trigger.dataset.supplierName
                || 'Supplier',

            status:
                trigger.dataset.status === '1',

        };


        this.renderActionMenu();

        this.positionActionMenu();

        this.elements.globalActionMenu.style.display =
            'block';

        this.actionMenuOpen =
            true;
    },


    /*
    |--------------------------------------------------------------------------
    | Render Action Menu
    |--------------------------------------------------------------------------
    */

    renderActionMenu()
    {
        const supplier =
            this.selectedSupplier;


        let html = '';


        html += `

            <button
                type="button"
                class="dropdown-item"
                data-supplier-action="view"
            >

                <i class="bi bi-eye"></i>

                View

            </button>

        `;


        html += `

            <button
                type="button"
                class="dropdown-item"
                data-supplier-action="edit"
            >

                <i class="bi bi-pencil"></i>

                Edit

            </button>

        `;


        html += '<div class="dropdown-divider"></div>';


        if (supplier.status) {

            html += `

                <button
                    type="button"
                    class="dropdown-item"
                    data-supplier-action="disable"
                >

                    <i class="bi bi-pause-circle"></i>

                    Disable

                </button>

            `;

        } else {

            html += `

                <button
                    type="button"
                    class="dropdown-item"
                    data-supplier-action="enable"
                >

                    <i class="bi bi-check-circle"></i>

                    Enable

                </button>

            `;
        }


        html += `

            <div class="dropdown-divider"></div>

            <button
                type="button"
                class="dropdown-item text-danger"
                data-supplier-action="delete"
            >

                <i class="bi bi-trash"></i>

                Delete

            </button>

        `;


        this.elements.globalActionMenu.innerHTML =
            html;


        this.elements.globalActionMenu
            .querySelectorAll(
                '[data-supplier-action]'
            )
            .forEach(
                (button) => {

                    button.addEventListener(
                        'click',
                        () => {

                            const action =
                                button.dataset.supplierAction;

                            this.closeActionMenu();

                            this.handleAction(
                                action,
                                supplier.id
                            );

                        }
                    );

                }
            );
    },


    /*
    |--------------------------------------------------------------------------
    | Position Action Menu
    |--------------------------------------------------------------------------
    */

    positionActionMenu()
    {
        if (
            ! this.selectedSupplier
        ) {

            return;
        }


        const trigger =
            document.querySelector(
                `.supplier-action-trigger[data-supplier-id="${this.selectedSupplier.id}"]`
            );


        if (! trigger) {

            return;
        }


        const rect =
            trigger.getBoundingClientRect();


        const menu =
            this.elements.globalActionMenu;


        menu.style.display =
            'block';


        const menuWidth =
            menu.offsetWidth
            || 190;

        const menuHeight =
            menu.offsetHeight
            || 180;


        let left =
            rect.right -
            menuWidth;


        let top =
            rect.bottom +
            6;


        if (
            left < 8
        ) {

            left =
                8;
        }


        if (
            left + menuWidth >
            window.innerWidth - 8
        ) {

            left =
                window.innerWidth -
                menuWidth -
                8;
        }


        if (
            top + menuHeight >
            window.innerHeight - 8
        ) {

            top =
                rect.top -
                menuHeight -
                6;
        }


        menu.style.left =
            `${left}px`;

        menu.style.top =
            `${top}px`;
    },


    /*
    |--------------------------------------------------------------------------
    | Close Action Menu
    |--------------------------------------------------------------------------
    */

    closeActionMenu()
    {
        if (
            this.elements?.globalActionMenu
        ) {

            this.elements.globalActionMenu.style.display =
                'none';
        }


        this.actionMenuOpen =
            false;
    },


    /*
    |--------------------------------------------------------------------------
    | Handle Action
    |--------------------------------------------------------------------------
    */

    handleAction(
        action,
        id
    )
    {
        switch (action) {

            case 'view':

                this.openInspector(
                    id
                );

                break;


            case 'edit':

                this.openEditModal(
                    id
                );

                break;


            case 'enable':

                this.openConfirmation(
                    'enable',
                    id
                );

                break;


            case 'disable':

                this.openConfirmation(
                    'disable',
                    id
                );

                break;


            case 'delete':

                this.openConfirmation(
                    'delete',
                    id
                );

                break;

        }
    },


    /*
    |--------------------------------------------------------------------------
    | Open Confirmation
    |--------------------------------------------------------------------------
    */

    openConfirmation(
        action,
        id
    )
    {
        this.statusAction =
            null;

        this.deleteAction =
            null;


        const supplierName =
            this.selectedSupplier?.name
            || 'this supplier';


        if (
            action === 'delete'
        ) {

            this.deleteAction = {

                id:
                    id,

            };


            this.elements.confirmIcon.innerHTML =
                '<i class="bi bi-trash"></i>';

            this.elements.confirmTitle.textContent =
                'Delete Supplier';

            this.elements.confirmMessage.textContent =
                `Delete ${supplierName}?`;

            this.elements.confirmDescription.textContent =
                'The supplier will be archived and removed from the active supplier list.';

            this.elements.confirmBtn.className =
                'btn btn-danger';

            this.elements.confirmBtn.textContent =
                'Delete Supplier';

        } else {

            const enable =
                action === 'enable';


            this.statusAction = {

                id:
                    id,

                status:
                    enable,

            };


            this.elements.confirmIcon.innerHTML =
                enable
                    ? '<i class="bi bi-check-circle"></i>'
                    : '<i class="bi bi-pause-circle"></i>';

            this.elements.confirmTitle.textContent =
                enable
                    ? 'Enable Supplier'
                    : 'Disable Supplier';

            this.elements.confirmMessage.textContent =
                enable
                    ? `Enable ${supplierName}?`
                    : `Disable ${supplierName}?`;

            this.elements.confirmDescription.textContent =
                enable
                    ? 'The supplier will become available for purchasing operations.'
                    : 'The supplier will no longer be available as an active supplier.';

            this.elements.confirmBtn.className =
                enable
                    ? 'btn btn-primary'
                    : 'btn btn-warning';

            this.elements.confirmBtn.textContent =
                enable
                    ? 'Enable Supplier'
                    : 'Disable Supplier';
        }


        if (this.bootstrap.confirm) {

            this.bootstrap.confirm.show();

        }
    },


    /*
    |--------------------------------------------------------------------------
    | Execute Confirmation
    |--------------------------------------------------------------------------
    */

    async executeConfirmation()
    {
        if (this.deleteAction) {

            await this.deleteSupplier(
                this.deleteAction.id
            );

            return;
        }


        if (this.statusAction) {

            await this.updateStatus(
                this.statusAction.id
            );
        }
    },


    /*
    |--------------------------------------------------------------------------
    | Update Status
    |--------------------------------------------------------------------------
    */

    async updateStatus(
        id
    )
    {
        this.setConfirmationLoading(
            true
        );


        try {

            const response =
                await fetch(
                    `/purchase/suppliers/${id}/status`,
                    {
                        method:
                            'PATCH',

                        headers: {

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',

                            'X-CSRF-TOKEN':
                                this.getCsrfToken(),

                        },
                    }
                );


            const result =
                await response.json();


            if (! response.ok || ! result.success) {

                throw new Error(
                    result.message
                    ||
                    'Unable to update supplier status.'
                );
            }


            this.bootstrap.confirm?.hide();


            this.showToast(
                result.message,
                'success'
            );


            await this.loadTable(
                this.currentPage
            );


        } catch (error) {

            console.error(
                error
            );


            this.showToast(
                error.message,
                'error'
            );

        } finally {

            this.setConfirmationLoading(
                false
            );
        }
    },


    /*
    |--------------------------------------------------------------------------
    | Delete Supplier
    |--------------------------------------------------------------------------
    */

    async deleteSupplier(
        id
    )
    {
        this.setConfirmationLoading(
            true
        );


        try {

            const response =
                await fetch(
                    `/purchase/suppliers/${id}`,
                    {
                        method:
                            'DELETE',

                        headers: {

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',

                            'X-CSRF-TOKEN':
                                this.getCsrfToken(),

                        },
                    }
                );


            const result =
                await response.json();


            if (! response.ok || ! result.success) {

                throw new Error(
                    result.message
                    ||
                    'Unable to delete supplier.'
                );
            }


            this.bootstrap.confirm?.hide();


            this.showToast(
                result.message,
                'success'
            );


            await this.loadTable(
                1
            );


        } catch (error) {

            console.error(
                error
            );


            this.showToast(
                error.message,
                'error'
            );

        } finally {

            this.setConfirmationLoading(
                false
            );
        }
    },


    /*
    |--------------------------------------------------------------------------
    | Submit Loading
    |--------------------------------------------------------------------------
    */

    setSubmitLoading(
        loading
    )
    {
        if (
            ! this.elements.submitBtn
        ) {

            return;
        }


        this.elements.submitBtn.disabled =
            loading;


        this.elements.submitSpinner.classList.toggle(
            'd-none',
            ! loading
        );


        if (! loading) {

            this.elements.submitText.textContent =
                this.mode === 'edit'
                    ? 'Update Supplier'
                    : 'Save Supplier';
        }
    },


    /*
    |--------------------------------------------------------------------------
    | Confirmation Loading
    |--------------------------------------------------------------------------
    */

    setConfirmationLoading(
        loading
    )
    {
        if (
            ! this.elements.confirmBtn
        ) {

            return;
        }


        this.elements.confirmBtn.disabled =
            loading;


        if (loading) {

            this.elements.confirmBtn.innerHTML = `

                <span
                    class="spinner-border spinner-border-sm me-1"
                ></span>

                Processing...

            `;

        } else {

            if (this.deleteAction) {

                this.elements.confirmBtn.textContent =
                    'Delete Supplier';

            } else if (
                this.statusAction?.status
            ) {

                this.elements.confirmBtn.textContent =
                    'Enable Supplier';

            } else {

                this.elements.confirmBtn.textContent =
                    'Disable Supplier';
            }
        }
    },


    /*
    |--------------------------------------------------------------------------
    | Clear Form Errors
    |--------------------------------------------------------------------------
    */

    clearFormErrors()
    {
        if (! this.elements.form) {

            return;
        }


        this.elements.form
            .querySelectorAll(
                '.is-invalid'
            )
            .forEach(
                (element) => {

                    element.classList.remove(
                        'is-invalid'
                    );

                }
            );


        this.elements.form
            .querySelectorAll(
                '.supplier-validation-error'
            )
            .forEach(
                (element) => {

                    element.remove();

                }
            );
    },


    /*
    |--------------------------------------------------------------------------
    | Display Validation Errors
    |--------------------------------------------------------------------------
    */

    displayValidationErrors(
        errors
    )
    {
        Object.entries(
            errors
        ).forEach(
            ([field, messages]) => {

                const input =
                    this.elements.form.querySelector(
                        `[name="${field}"]`
                    );


                if (! input) {

                    return;
                }


                input.classList.add(
                    'is-invalid'
                );


                const error =
                    document.createElement(
                        'div'
                    );


                error.className =
                    'invalid-feedback supplier-validation-error';

                error.textContent =
                    messages?.[0]
                    ?? 'Invalid value.';


                input.parentNode.appendChild(
                    error
                );
            }
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
        return Number(
            value ?? 0
        ).toLocaleString(
            'en-US'
        );
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
        return Number(
            value ?? 0
        ).toLocaleString(
            'en-US',
            {
                minimumFractionDigits:
                    2,

                maximumFractionDigits:
                    2,
            }
        );
    },


    /*
    |--------------------------------------------------------------------------
    | Get CSRF Token
    |--------------------------------------------------------------------------
    */

    getCsrfToken()
    {
        return document
            .querySelector(
                'meta[name="csrf-token"]'
            )
            ?.getAttribute(
                'content'
            )
            ?? '';
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
            value
            ?? '';

        return div.innerHTML;
    },


    /*
    |--------------------------------------------------------------------------
    | Build Address
    |--------------------------------------------------------------------------
    */

    formatAddress(
        supplier
    )
    {
        return this.buildAddress(
            supplier
        );
    },


    /*
    |--------------------------------------------------------------------------
    | Toast
    |--------------------------------------------------------------------------
    */

    showToast(
        message,
        type = 'success'
    )
    {
        /*
        |--------------------------------------------------------------------------
        | Existing EMNEX Toast
        |--------------------------------------------------------------------------
        |
        | Use the project's established global toast helper when available.
        |
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


        /*
        |--------------------------------------------------------------------------
        | Bootstrap Toast Fallback
        |--------------------------------------------------------------------------
        */

        const container =
            document.getElementById(
                'toastContainer'
            );


        if (! container) {

            console[type === 'error'
                ? 'error'
                : 'log'](
                message
            );

            return;
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


        toast.innerHTML = `

            <div class="d-flex">

                <div class="toast-body">
                    ${this.escapeHtml(message)}
                </div>

                <button
                    type="button"
                    class="btn-close me-2 m-auto"
                    data-bs-dismiss="toast"
                ></button>

            </div>

        `;


        container.appendChild(
            toast
        );


        const instance =
            bootstrap.Toast.getOrCreateInstance(
                toast
            );


        instance.show();


        toast.addEventListener(
            'hidden.bs.toast',
            () => {

                toast.remove();

            }
        );
    },
};


/*
|--------------------------------------------------------------------------
| Initialize Suppliers
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    () => {

        if (
            document.getElementById(
                'suppliersPage'
            )
        ) {

            Suppliers.init();

        }

    }
);