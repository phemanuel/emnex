/**
 * ==========================================================
 * EMNEX POS - STOCK COUNT
 * ==========================================================
 *
 * Handles:
 *
 * - Stock Count table
 * - Search
 * - Branch filter
 * - Status filter
 * - Date filters
 * - Pagination
 * - KPI calculations
 * - Create Stock Count
 * - Edit Stock Count
 * - Delete Stock Count
 * - Stock Count inspector
 * - Loading / empty / error states
 *
 * Backend:
 *
 * GET    stock-count/table
 * GET    stock-count/{id}
 * POST   stock-count
 * PUT    stock-count/{id}
 * DELETE stock-count/{id}
 *
 * ==========================================================
 */

const StockCount = {

    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    state: {

        page: 1,

        perPage: 10,

        searchTimer: null,

        selectedId: null,

        deleteId: null,

        mode: 'create',

        tableRequest: null,

        inspectorRequest: null,

        countingTimer:  null,

        countingStartedAt:  null,

        countingId: null,

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

    components: {

        formModal: null,

        deleteModal: null,

        inspector: null,

    },


    /*
    |--------------------------------------------------------------------------
    | Init
    |--------------------------------------------------------------------------
    */

    init() {

        this.cacheElements();

        this.initializeComponents();

        this.bindEvents();

        this.loadTable(1);

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
            | Table
            |--------------------------------------------------------------------------
            */

            tableBody:
                document.getElementById(
                    'stockCountTableBody'
                ),

            tableState:
                document.getElementById(
                    'stockCountTableState'
                ),

            stateTitle:
                document.getElementById(
                    'stockCountStateTitle'
                ),

            stateMessage:
                document.getElementById(
                    'stockCountStateMessage'
                ),


            /*
            |--------------------------------------------------------------------------
            | Search / Filters
            |--------------------------------------------------------------------------
            */

            search:
                document.getElementById(
                    'stockCountSearch'
                ),

            branchFilter:
                document.getElementById(
                    'stockCountBranchFilter'
                ),

            statusFilter:
                document.getElementById(
                    'stockCountStatusFilter'
                ),

            dateFrom:
                document.getElementById(
                    'stockCountDateFrom'
                ),

            dateTo:
                document.getElementById(
                    'stockCountDateTo'
                ),

            clearFilters:
                document.getElementById(
                    'stockCountClearFilters'
                ),


            /*
            |--------------------------------------------------------------------------
            | Pagination
            |--------------------------------------------------------------------------
            */

            pagination:
                document.getElementById(
                    'stockCountPagination'
                ),

            paginationInfo:
                document.getElementById(
                    'stockCountPaginationInfo'
                ),

            paginationWrapper:
                document.getElementById(
                    'stockCountPaginationWrapper'
                ),


            /*
            |--------------------------------------------------------------------------
            | KPI
            |--------------------------------------------------------------------------
            */

            totalKpi:
                document.getElementById(
                    'stockCountTotalKpi'
                ),

            draftKpi:
                document.getElementById(
                    'stockCountDraftKpi'
                ),

            progressKpi:
                document.getElementById(
                    'stockCountProgressKpi'
                ),

            completedKpi:
                document.getElementById(
                    'stockCountCompletedKpi'
                ),


            /*
            |--------------------------------------------------------------------------
            | Create Button
            |--------------------------------------------------------------------------
            */

            createButton:
                document.getElementById(
                    'createStockCountButton'
                ),            

           

            /*
            |--------------------------------------------------------------------------
            | Form
            |--------------------------------------------------------------------------
            */

            form:
                document.getElementById(
                    'stockCountForm'
                ),

            formModal:
                document.getElementById(
                    'stockCountFormModal'
                ),

            formModalLabel:
                document.getElementById(
                    'stockCountFormModalLabel'
                ),

            formModalDescription:
                document.getElementById(
                    'stockCountFormModalDescription'
                ),

            id:
                document.getElementById(
                    'stockCountId'
                ),

            formBranch:
                document.getElementById(
                    'stockCountFormBranch'
                ),

            formDate:
                document.getElementById(
                    'stockCountFormDate'
                ),

            formNotes:
                document.getElementById(
                    'stockCountFormNotes'
                ),

            saveButton:
                document.getElementById(
                    'stockCountSaveButton'
                ),

            saveSpinner:
                document.getElementById(
                    'stockCountSaveSpinner'
                ),

            saveIcon:
                document.getElementById(
                    'stockCountSaveIcon'
                ),

            saveText:
                document.getElementById(
                    'stockCountSaveText'
                ),


            /*
            |--------------------------------------------------------------------------
            | Form Errors
            |--------------------------------------------------------------------------
            */

            branchError:
                document.getElementById(
                    'stockCountBranchError'
                ),

            dateError:
                document.getElementById(
                    'stockCountDateError'
                ),

            notesError:
                document.getElementById(
                    'stockCountNotesError'
                ),


            /*
            |--------------------------------------------------------------------------
            | Delete
            |--------------------------------------------------------------------------
            */

            deleteModal:
                document.getElementById(
                    'stockCountDeleteModal'
                ),

            confirmDelete:
                document.getElementById(
                    'confirmStockCountDelete'
                ),

            deleteSpinner:
                document.getElementById(
                    'stockCountDeleteSpinner'
                ),

            deleteIcon:
                document.getElementById(
                    'stockCountDeleteIcon'
                ),

            /*
            |--------------------------------------------------------------------------
            | Complete
            |--------------------------------------------------------------------------
            */

            completeButton:
                document.getElementById(
                    'stockCountCompleteButton'
                ),

            completeModal:
                document.getElementById(
                    'stockCountCompleteModal'
                ),

            confirmComplete:
                document.getElementById(
                    'confirmStockCountComplete'
                ),

            completeSpinner:
                document.getElementById(
                    'stockCountCompleteSpinner'
                ),

            completeIcon:
                document.getElementById(
                    'stockCountCompleteIcon'
                ),


            /*
            |--------------------------------------------------------------------------
            | Inspector
            |--------------------------------------------------------------------------
            */

            inspector:
                document.getElementById(
                    'stockCountInspector'
                ),

            inspectorLoading:
                document.getElementById(
                    'stockCountInspectorLoading'
                ),

            inspectorError:
                document.getElementById(
                    'stockCountInspectorError'
                ),

            inspectorErrorTitle:
                document.getElementById(
                    'stockCountInspectorErrorTitle'
                ),

            inspectorErrorMessage:
                document.getElementById(
                    'stockCountInspectorErrorMessage'
                ),

            inspectorContent:
                document.getElementById(
                    'stockCountInspectorContent'
                ),

            inspectorReference:
                document.getElementById(
                    'stockCountInspectorReference'
                ),

            inspectorReferenceValue:
                document.getElementById(
                    'stockCountInspectorReferenceValue'
                ),

            inspectorStatus:
                document.getElementById(
                    'stockCountInspectorStatus'
                ),

            startCountButton:
                document.getElementById(
                    'stockCountStartButton'
                ),

            continueCountButton:
                document.getElementById(
                    'stockCountContinueButton'
                ),

            inspectorDate:
                document.getElementById(
                    'stockCountInspectorDate'
                ),

            inspectorBranch:
                document.getElementById(
                    'stockCountInspectorBranch'
                ),

            inspectorCreatedBy:
                document.getElementById(
                    'stockCountInspectorCreatedBy'
                ),

            inspectorCreatedAt:
                document.getElementById(
                    'stockCountInspectorCreatedAt'
                ),

            inspectorCompletedBy:
                document.getElementById(
                    'stockCountInspectorCompletedBy'
                ),

            inspectorCompletedAt:
                document.getElementById(
                    'stockCountInspectorCompletedAt'
                ),

            inspectorItemCount:
                document.getElementById(
                    'stockCountInspectorItemCount'
                ),

            inspectorVarianceCount:
                document.getElementById(
                    'stockCountInspectorVarianceCount'
                ),

            inspectorPositiveVariance:
                document.getElementById(
                    'stockCountInspectorPositiveVariance'
                ),

            inspectorNegativeVariance:
                document.getElementById(
                    'stockCountInspectorNegativeVariance'
                ),

            inspectorNotes:
                document.getElementById(
                    'stockCountInspectorNotes'
                ),

            inspectorItems:
                document.getElementById(
                    'stockCountInspectorItems'
                ),

            inspectorItemsBadge:
                document.getElementById(
                    'stockCountInspectorItemsBadge'
                ),

            /*
            |--------------------------------------------------------------------------
            | Counting Modal
            |--------------------------------------------------------------------------
            */

            countingModal:
                document.getElementById(
                    'stockCountCountingModal'
                ),

            countingReference:
                document.getElementById(
                    'stockCountCountingReference'
                ),

            timer:
                document.getElementById(
                    'stockCountTimer'
                ),

            countedProgress:
                document.getElementById(
                    'stockCountCountedProgress'
                ),

            totalProgress:
                document.getElementById(
                    'stockCountTotalProgress'
                ),

            progressPercentage:
                document.getElementById(
                    'stockCountProgressPercentage'
                ),

            progressBar:
                document.getElementById(
                    'stockCountProgressBar'
                ),

            countingSearch:
                document.getElementById(
                    'stockCountCountingSearch'
                ),

            countingItems:
                document.getElementById(
                    'stockCountCountingItems'
                ),

            countingEmpty:
                document.getElementById(
                    'stockCountCountingEmpty'
                ),

            totalVariance:
                document.getElementById(
                    'stockCountTotalVariance'
                ),

            completeButton:
                document.getElementById(
                    'stockCountCompleteButton'
                ),

        };

    },


   /*
    |--------------------------------------------------------------------------
    | Initialize Bootstrap Components
    |--------------------------------------------------------------------------
    */

    initializeComponents() {

        /*
        |--------------------------------------------------------------------------
        | Form Modal
        |--------------------------------------------------------------------------
        */

        if (
            this.elements.formModal
            && window.bootstrap
        ) {

            this.components.formModal =
                bootstrap.Modal.getOrCreateInstance(
                    this.elements.formModal
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Delete Modal
        |--------------------------------------------------------------------------
        */

        if (
            this.elements.deleteModal
            && window.bootstrap
        ) {

            this.components.deleteModal =
                bootstrap.Modal.getOrCreateInstance(
                    this.elements.deleteModal
                );

        }

        /*
        |--------------------------------------------------------------------------
        | Complete Modal
        |--------------------------------------------------------------------------
        */

        if (
            this.elements.completeModal
            && window.bootstrap
        ) {

            this.components.completeModal =
                bootstrap.Modal.getOrCreateInstance(
                    this.elements.completeModal
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Inspector
        |--------------------------------------------------------------------------
        */

        if (
            this.elements.inspector
            && window.bootstrap
        ) {

            this.components.inspector =
                bootstrap.Offcanvas.getOrCreateInstance(
                    this.elements.inspector
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Counting Modal
        |--------------------------------------------------------------------------
        */

        if (
            this.elements.countingModal
            && window.bootstrap
        ) {

            this.components.countingModal =
                bootstrap.Modal.getOrCreateInstance(
                    this.elements.countingModal
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
        |--------------------------------------------------------------------------
        | New Stock Count
        |--------------------------------------------------------------------------
        */

        if (this.elements.createButton) {

            this.elements.createButton.addEventListener(
                'click',
                () => this.openCreateModal()
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if (this.elements.search) {

            this.elements.search.addEventListener(
                'input',
                () => {

                    clearTimeout(
                        this.state.searchTimer
                    );

                    this.state.searchTimer =
                        setTimeout(
                            () => this.loadTable(1),
                            350
                        );

                }
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Counting Search
        |--------------------------------------------------------------------------
        */

        if (this.elements.countingSearch) {

            this.elements.countingSearch.addEventListener(
                'input',
                () => this.filterCountingItems()
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Counting Modal Hidden
        |--------------------------------------------------------------------------
        */

        if (this.elements.countingModal) {

            this.elements.countingModal.addEventListener(
                'hidden.bs.modal',
                () => this.stopCountingTimer()
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */

        [
            this.elements.branchFilter,
            this.elements.statusFilter,
            this.elements.dateFrom,
            this.elements.dateTo

        ].forEach(
            element => {

                if (! element) {
                    return;
                }

                element.addEventListener(
                    'change',
                    () => this.loadTable(1)
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Clear Filters
        |--------------------------------------------------------------------------
        */

        if (this.elements.clearFilters) {

            this.elements.clearFilters.addEventListener(
                'click',
                () => this.clearFilters()
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Form Submit
        |--------------------------------------------------------------------------
        */

        if (this.elements.form) {

            this.elements.form.addEventListener(
                'submit',
                event => {

                    event.preventDefault();

                    this.submitForm();

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Delete
        |--------------------------------------------------------------------------
        */

        if (this.elements.confirmDelete) {

            this.elements.confirmDelete.addEventListener(
                'click',
                () => this.deleteStockCount()
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Complete Counting
        |--------------------------------------------------------------------------
        */

        if (this.elements.completeButton) {

            this.elements.completeButton.addEventListener(
                'click',
                () => {

                    this.components.completeModal?.show();

                }
            );

        }


        if (this.elements.confirmComplete) {

            this.elements.confirmComplete.addEventListener(
                'click',
                () => this.completeCounting()
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Start Count
        |--------------------------------------------------------------------------
        */

        if (this.elements.startCountButton) {

            this.elements.startCountButton.addEventListener(
                'click',
                () => this.startCount()
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Continue Counting
        |--------------------------------------------------------------------------
        */

        if (this.elements.continueCountButton) {

            this.elements.continueCountButton.addEventListener(
                'click',
                () => this.openCountingModal()
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Table Delegation
        |--------------------------------------------------------------------------
        */

        if (this.elements.tableBody) {

            this.elements.tableBody.addEventListener(
                'click',
                event => this.handleTableAction(event)
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        if (this.elements.pagination) {

            this.elements.pagination.addEventListener(
                'click',
                event => {

                    const button =
                        event.target.closest(
                            '[data-page]'
                        );

                    if (! button) {
                        return;
                    }

                    const page =
                        parseInt(
                            button.dataset.page,
                            10
                        );

                    if (! page) {
                        return;
                    }

                    this.loadTable(page);

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Counting Quantity Input
        |--------------------------------------------------------------------------
        */

        if (this.elements.countingItems) {

            this.elements.countingItems.addEventListener(
                'input',
                event => {

                    const input =
                        event.target.closest(
                            '.stock-count-physical-input'
                        );


                    if (! input) {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Mark Item As Counted
                    |--------------------------------------------------------------------------
                    */

                    input.dataset.counted =
                        'true';


                    /*
                    |--------------------------------------------------------------------------
                    | Update Variance
                    |--------------------------------------------------------------------------
                    */

                    this.updateCountingItemVariance(
                        input
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Update Progress
                    |--------------------------------------------------------------------------
                    */

                    this.updateCountingProgress();

                }
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Load Table
    |--------------------------------------------------------------------------
    */

    async loadTable(page = 1) {

        this.state.page = page;

        this.showTableLoading();

        const params =
            new URLSearchParams();


        params.set(
            'page',
            page
        );


        params.set(
            'per_page',
            this.state.perPage
        );


        if (
            this.elements.search
            && this.elements.search.value.trim()
        ) {

            params.set(
                'search',
                this.elements.search.value.trim()
            );

        }


        if (
            this.elements.branchFilter
            && this.elements.branchFilter.value
        ) {

            params.set(
                'branch_id',
                this.elements.branchFilter.value
            );

        }


        if (
            this.elements.statusFilter
            && this.elements.statusFilter.value
        ) {

            params.set(
                'status',
                this.elements.statusFilter.value
            );

        }


        if (
            this.elements.dateFrom
            && this.elements.dateFrom.value
        ) {

            params.set(
                'date_from',
                this.elements.dateFrom.value
            );

        }


        if (
            this.elements.dateTo
            && this.elements.dateTo.value
        ) {

            params.set(
                'date_to',
                this.elements.dateTo.value
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Abort Previous Request
        |--------------------------------------------------------------------------
        */

        if (this.state.tableRequest) {

            this.state.tableRequest.abort();

        }


        this.state.tableRequest =
            new AbortController();


        try {

            const response =
                await fetch(
                    `${window.STOCK_COUNT.tableUrl}?${params.toString()}`,
                    {
                        method: 'GET',

                        headers: {

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',

                        },

                        signal:
                            this.state.tableRequest.signal,

                    }
                );


            const result =
                await response.json();


            if (! response.ok) {

                throw new Error(
                    result.message
                    || 'Unable to load Stock Counts.'
                );

            }


            if (! result.status) {

                throw new Error(
                    result.message
                    || 'Unable to load Stock Counts.'
                );

            }


            this.renderTable(
                result.data || []
            );


            this.renderPagination(
                result.pagination
            );


            /*
            |--------------------------------------------------------------------------
            | KPI
            |--------------------------------------------------------------------------
            |
            | The table endpoint is paginated, so calculate the
            | visible status totals from the current response.
            |
            | We will replace this with a dedicated KPI endpoint
            | later if exact company-wide totals are required.
            |
            */

            this.updateKpis(
                result.data || [],
                result.pagination
            );


        } catch (error) {

            if (
                error.name ===
                'AbortError'
            ) {

                return;

            }


            console.error(
                'Stock Count table error:',
                error
            );


            this.showTableError(
                error.message
                || 'Unable to load Stock Counts.'
            );

        } finally {

            this.state.tableRequest =
                null;

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Render Table
    |--------------------------------------------------------------------------
    */

    renderTable(data) {

        if (! this.elements.tableBody) {
            return;
        }


        this.elements.tableBody.innerHTML =
            '';


        if (! data.length) {

            this.showTableEmpty();

            return;

        }


        this.hideTableState();


        data.forEach(
            count => {

                const row =
                    document.createElement(
                        'tr'
                    );


                row.innerHTML = `

                    <td>

                        <div class="fw-semibold">
                            ${this.escapeHtml(
                                count.reference_no || '—'
                            )}
                        </div>

                    </td>


                    <td>

                        ${this.escapeHtml(
                            count.branch || '—'
                        )}

                    </td>


                    <td>

                        ${this.escapeHtml(
                            count.count_date || '—'
                        )}

                    </td>


                    <td>

                        ${this.renderStatusBadge(
                            count.status
                        )}

                    </td>


                    <td>

                        ${this.escapeHtml(
                            count.created_by || 'System'
                        )}

                    </td>


                    <td>

                        <span class="small text-muted">

                            ${this.escapeHtml(
                                count.created_at || '—'
                            )}

                        </span>

                    </td>


                    <td class="text-end">

                        <div class="dropdown">

                            <button
                                type="button"
                                class="btn btn-sm btn-light"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                <i class="bi bi-three-dots"></i>
                            </button>


                            <ul class="dropdown-menu dropdown-menu-end">

                                <li>

                                    <button
                                        type="button"
                                        class="dropdown-item"
                                        data-action="view"
                                        data-id="${count.id}"
                                    >

                                        <i class="bi bi-eye me-2"></i>

                                        View

                                    </button>

                                </li>


                                ${
                                    count.status === 'Draft'
                                        || count.status === 'In Progress'
                                        ? `

                                            <li>

                                                <button
                                                    type="button"
                                                    class="dropdown-item"
                                                    data-action="edit"
                                                    data-id="${count.id}"
                                                >

                                                    <i class="bi bi-pencil me-2"></i>

                                                    Edit

                                                </button>

                                            </li>

                                        `
                                        : ''
                                }


                                ${
                                    count.status === 'Draft'
                                        ? `

                                            <li>

                                                <hr class="dropdown-divider">

                                            </li>

                                            <li>

                                                <button
                                                    type="button"
                                                    class="dropdown-item text-danger"
                                                    data-action="delete"
                                                    data-id="${count.id}"
                                                    data-reference="${this.escapeAttribute(
                                                        count.reference_no || ''
                                                    )}"
                                                >

                                                    <i class="bi bi-trash3 me-2"></i>

                                                    Delete

                                                </button>

                                            </li>

                                        `
                                        : ''
                                }

                            </ul>

                        </div>

                    </td>

                `;


                this.elements.tableBody.appendChild(
                    row
                );                

            }
        );

        

    },

    


    /*
    |--------------------------------------------------------------------------
    | Table Action
    |--------------------------------------------------------------------------
    */

    handleTableAction(event) {

        const button =
            event.target.closest(
                '[data-action]'
            );


        if (! button) {
            return;
        }


        const action =
            button.dataset.action;


        const id =
            parseInt(
                button.dataset.id,
                10
            );


        if (! id) {
            return;
        }


        switch (action) {

            case 'view':

                this.openInspector(id);

                break;


            case 'edit':

                this.openEditModal(id);

                break;


            case 'delete':

                this.openDeleteModal(
                    id,
                    button.dataset.reference
                );

                break;

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Status Badge
    |--------------------------------------------------------------------------
    */

    renderStatusBadge(status) {

        let className =
            'bg-secondary-subtle text-secondary';

        let icon =
            'bi-circle';


        switch (status) {

            case 'Draft':

                className =
                    'bg-secondary-subtle text-secondary';

                icon =
                    'bi-file-earmark';

                break;


            case 'In Progress':

                className =
                    'bg-warning-subtle text-warning-emphasis';

                icon =
                    'bi-arrow-repeat';

                break;


            case 'Completed':

                className =
                    'bg-success-subtle text-success';

                icon =
                    'bi-check2-circle';

                break;


            case 'Cancelled':

                className =
                    'bg-danger-subtle text-danger';

                icon =
                    'bi-x-circle';

                break;

        }


        return `

            <span class="badge ${className}">

                <i class="bi ${icon} me-1"></i>

                ${this.escapeHtml(
                    status || 'Unknown'
                )}

            </span>

        `;

    },


    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    renderPagination(pagination) {

        if (! pagination) {
            return;
        }


        const current =
            parseInt(
                pagination.current_page,
                10
            ) || 1;


        const last =
            parseInt(
                pagination.last_page,
                10
            ) || 1;


        const from =
            pagination.from || 0;


        const to =
            pagination.to || 0;


        const total =
            pagination.total || 0;


        if (this.elements.paginationInfo) {

            this.elements.paginationInfo.textContent =
                `Showing ${from} to ${to} of ${total}`;

        }


        if (! this.elements.pagination) {
            return;
        }


        this.elements.pagination.innerHTML =
            '';


        if (last <= 1) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Previous
        |--------------------------------------------------------------------------
        */

        this.appendPageButton(
            'Previous',
            current - 1,
            current <= 1,
            'bi-chevron-left'
        );


        /*
        |--------------------------------------------------------------------------
        | Page Numbers
        |--------------------------------------------------------------------------
        */

        const pages =
            this.getPaginationPages(
                current,
                last
            );


        pages.forEach(
            page => {

                if (page === '...') {

                    const li =
                        document.createElement(
                            'li'
                        );

                    li.className =
                        'page-item disabled';


                    li.innerHTML = `

                        <span class="page-link">
                            …
                        </span>

                    `;


                    this.elements.pagination.appendChild(
                        li
                    );

                    return;

                }


                this.appendPageButton(
                    page,
                    page,
                    false,
                    null,
                    page === current
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Next
        |--------------------------------------------------------------------------
        */

        this.appendPageButton(
            'Next',
            current + 1,
            current >= last,
            'bi-chevron-right'
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Pagination Button
    |--------------------------------------------------------------------------
    */

    appendPageButton(
        label,
        page,
        disabled = false,
        icon = null,
        active = false
    ) {

        const li =
            document.createElement(
                'li'
            );


        li.className =
            'page-item';


        if (disabled) {

            li.classList.add(
                'disabled'
            );

        }


        if (active) {

            li.classList.add(
                'active'
            );

        }


        const button =
            document.createElement(
                'button'
            );


        button.type =
            'button';


        button.className =
            'page-link';


        if (! disabled) {

            button.dataset.page =
                page;

        }


        if (icon) {

            button.innerHTML =
                `<i class="bi ${icon}"></i>`;

        }
        else {

            button.textContent =
                label;

        }


        button.setAttribute(
            'aria-label',
            label
        );


        li.appendChild(
            button
        );


        this.elements.pagination.appendChild(
            li
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Pagination Pages
    |--------------------------------------------------------------------------
    */

    getPaginationPages(
        current,
        last
    ) {

        if (last <= 7) {

            return Array.from(
                {
                    length: last
                },
                (_, index) =>
                    index + 1
            );

        }


        const pages = [

            1,

        ];


        if (current > 4) {

            pages.push('...');

        }


        const start =
            Math.max(
                2,
                current - 1
            );


        const end =
            Math.min(
                last - 1,
                current + 1
            );


        for (
            let page = start;
            page <= end;
            page++
        ) {

            pages.push(page);

        }


        if (current < last - 3) {

            pages.push('...');

        }


        pages.push(
            last
        );


        return pages;

    },


    /*
    |--------------------------------------------------------------------------
    | KPI
    |--------------------------------------------------------------------------
    */

    updateKpis(
        data,
        pagination
    ) {

        /*
        |--------------------------------------------------------------------------
        | Important
        |--------------------------------------------------------------------------
        |
        | The current table endpoint returns paginated records.
        | Therefore pagination.total is the exact total count,
        | but Draft/In Progress/Completed totals cannot be known
        | exactly without a dedicated KPI query.
        |
        | For now we calculate the status values from the returned
        | records.
        |
        */

        const total =
            pagination?.total
            ?? data.length;


        const draft =
            data.filter(
                item =>
                    item.status === 'Draft'
            ).length;


        const progress =
            data.filter(
                item =>
                    item.status === 'In Progress'
            ).length;


        const completed =
            data.filter(
                item =>
                    item.status === 'Completed'
            ).length;


        this.setKpi(
            this.elements.totalKpi,
            total
        );


        this.setKpi(
            this.elements.draftKpi,
            draft
        );


        this.setKpi(
            this.elements.progressKpi,
            progress
        );


        this.setKpi(
            this.elements.completedKpi,
            completed
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Set KPI
    |--------------------------------------------------------------------------
    */

    setKpi(
        element,
        value
    ) {

        if (! element) {
            return;
        }


        element.textContent =
            Number(
                value || 0
            ).toLocaleString();

    },


    /*
    |--------------------------------------------------------------------------
    | Open Create Modal
    |--------------------------------------------------------------------------
    */

    openCreateModal() {

        this.state.mode =
            'create';


        this.state.selectedId =
            null;


        this.resetForm();


        if (this.elements.formModalLabel) {

            this.elements.formModalLabel.textContent =
                'New Stock Count';

        }


        if (this.elements.formModalDescription) {

            this.elements.formModalDescription.textContent =
                'Create a new inventory counting session.';

        }


        if (this.elements.saveText) {

            this.elements.saveText.textContent =
                'Create Stock Count';

        }


        if (this.elements.formDate) {

            this.elements.formDate.value =
                this.getToday();

        }


        this.components.formModal?.show();

    },




    /*
    |--------------------------------------------------------------------------
    | Open Edit Modal
    |--------------------------------------------------------------------------
    */

    async openEditModal(id) {

        this.state.mode =
            'edit';


        this.state.selectedId =
            id;


        this.resetForm();


        if (this.elements.formModalLabel) {

            this.elements.formModalLabel.textContent =
                'Edit Stock Count';

        }


        if (this.elements.formModalDescription) {

            this.elements.formModalDescription.textContent =
                'Update the Stock Count information.';

        }


        if (this.elements.saveText) {

            this.elements.saveText.textContent =
                'Save Changes';

        }


        this.components.formModal?.show();


        this.setFormLoading(
            true
        );


        try {

            const data =
                await this.fetchDetails(
                    id
                );


            this.populateForm(
                data
            );


        } catch (error) {

            console.error(
                'Stock Count edit loading error:',
                error
            );


            this.components.formModal?.hide();


            this.showToast(
                error.message
                || 'Unable to load Stock Count.',
                'danger'
            );

        } finally {

            this.setFormLoading(
                false
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Populate Form
    |--------------------------------------------------------------------------
    */

    populateForm(data) {

        if (! data) {
            return;
        }


        if (this.elements.id) {

            this.elements.id.value =
                data.id || '';

        }


        if (this.elements.formBranch) {

            this.elements.formBranch.value =
                data.branch?.id || '';

        }


        if (this.elements.formDate) {

            this.elements.formDate.value =
                data.count_date || '';

        }


        if (this.elements.formNotes) {

            this.elements.formNotes.value =
                data.notes || '';

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Submit Form
    |--------------------------------------------------------------------------
    */

    async submitForm() {

        this.clearFormErrors();


        const formData =
            new FormData(
                this.elements.form
            );


        const id =
            this.elements.id?.value;


        const isEdit =
            this.state.mode === 'edit'
            && id;


        const url =
            isEdit

                ? window.STOCK_COUNT.updateUrl.replace(
                    ':id',
                    id
                )

                : window.STOCK_COUNT.storeUrl;


        /*
        |--------------------------------------------------------------------------
        | Laravel Method Spoofing
        |--------------------------------------------------------------------------
        */

        if (isEdit) {

            formData.append(
                '_method',
                'PUT'
            );

        }


        this.setFormLoading(
            true
        );


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

                            'X-Requested-With':
                                'XMLHttpRequest',

                            'X-CSRF-TOKEN':
                                this.getCsrfToken(),

                        },

                        body:
                            formData,

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
                && result.errors
            ) {

                this.displayValidationErrors(
                    result.errors
                );


                throw new Error(
                    result.message
                    || 'Please correct the highlighted fields.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | General Error
            |--------------------------------------------------------------------------
            */

            if (! response.ok) {

                throw new Error(
                    result.message
                    || 'Unable to save Stock Count.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Application Error
            |--------------------------------------------------------------------------
            */

            if (! result.status) {

                throw new Error(
                    result.message
                    || 'Unable to save Stock Count.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Success
            |--------------------------------------------------------------------------
            */

            this.components.formModal?.hide();


            this.showToast(
                result.message
                || (
                    isEdit
                        ? 'Stock Count updated successfully.'
                        : 'Stock Count created successfully.'
                ),
                'success'
            );


            this.loadTable(
                this.state.page
            );


        } catch (error) {

            console.error(
                'Stock Count save error:',
                error
            );


            if (
                error.message
                !==
                'Please correct the highlighted fields.'
            ) {

                this.showToast(
                    error.message
                    || 'Unable to save Stock Count.',
                    'danger'
                );

            }

        } finally {

            this.setFormLoading(
                false
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Open Delete Modal
    |--------------------------------------------------------------------------
    */

    openDeleteModal(
        id,
        reference = ''
    ) {

        this.state.deleteId =
            id;


        if (
            this.elements.deleteModal
        ) {

            const title =
                this.elements.deleteModal
                    .querySelector(
                        '#stockCountDeleteModalLabel'
                    );

            if (title) {

                title.textContent =
                    reference
                        ? `Delete Stock Count ${reference}?`
                        : 'Delete Stock Count?';

            }

        }


        this.setDeleteLoading(
            false
        );


        this.components.deleteModal?.show();

    },


    /*
    |--------------------------------------------------------------------------
    | Delete Stock Count
    |--------------------------------------------------------------------------
    */

    async deleteStockCount() {

        const id =
            this.state.deleteId;


        if (! id) {
            return;
        }


        this.setDeleteLoading(
            true
        );


        try {

            const url =
                window.STOCK_COUNT.destroyUrl.replace(
                    ':id',
                    id
                );


            const response =
                await fetch(
                    url,
                    {

                        method: 'DELETE',

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


            if (! response.ok) {

                throw new Error(
                    result.message
                    || 'Unable to delete Stock Count.'
                );

            }


            if (! result.status) {

                throw new Error(
                    result.message
                    || 'Unable to delete Stock Count.'
                );

            }


            this.components.deleteModal?.hide();


            this.showToast(
                result.message
                || 'Stock Count deleted successfully.',
                'success'
            );


            /*
            |--------------------------------------------------------------------------
            | Reload Current Page
            |--------------------------------------------------------------------------
            */

            this.loadTable(
                this.state.page
            );


        } catch (error) {

            console.error(
                'Stock Count deletion error:',
                error
            );


            this.showToast(
                error.message
                || 'Unable to delete Stock Count.',
                'danger'
            );

        } finally {

            this.setDeleteLoading(
                false
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Open Inspector
    |--------------------------------------------------------------------------
    */

    async openInspector(id) {

        this.state.selectedId =
            id;


        this.resetInspector();


        this.components.inspector?.show();


        this.showInspectorLoading();


        try {

            const data =
                await this.fetchDetails(
                    id
                );


            this.populateInspector(
                data
            );


        } catch (error) {

            console.error(
                'Stock Count inspector error:',
                error
            );


            this.showInspectorError(
                error.message
                || 'Unable to load Stock Count details.'
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Fetch Details
    |--------------------------------------------------------------------------
    */

    async fetchDetails(id) {

        if (this.state.inspectorRequest) {

            this.state.inspectorRequest.abort();

        }


        this.state.inspectorRequest =
            new AbortController();


        try {

            const url =
                window.STOCK_COUNT.detailsUrl.replace(
                    ':id',
                    id
                );


            const response =
                await fetch(
                    url,
                    {

                        method: 'GET',

                        headers: {

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',

                        },

                        signal:
                            this.state.inspectorRequest.signal,

                    }
                );


            const result =
                await response.json();


            if (! response.ok) {

                throw new Error(
                    result.message
                    || 'Unable to load Stock Count.'
                );

            }


            if (! result.status) {

                throw new Error(
                    result.message
                    || 'Unable to load Stock Count.'
                );

            }


            return result.data;


        } finally {

            this.state.inspectorRequest =
                null;

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Populate Inspector
    |--------------------------------------------------------------------------
    */

    populateInspector(data) {

        this.hideInspectorStates();


        if (! data) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Header
        |--------------------------------------------------------------------------
        */

        this.setText(
            this.elements.inspectorReference,
            data.reference_no || '—'
        );


        this.setText(
            this.elements.inspectorReferenceValue,
            data.reference_no || '—'
        );

        /*
        |--------------------------------------------------------------------------
        | Inspector Actions
        |--------------------------------------------------------------------------
        */

        if (this.elements.startCountButton) {

            this.elements.startCountButton.classList.toggle(
                'd-none',
                data.status !== 'Draft'
            );

        }


        if (this.elements.continueCountButton) {

            this.elements.continueCountButton.classList.toggle(
                'd-none',
                data.status !== 'In Progress'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

        if (this.elements.inspectorStatus) {

            this.elements.inspectorStatus.innerHTML =
                this.renderStatusBadge(
                    data.status
                );

        }


        this.setText(
            this.elements.inspectorDate,
            this.formatDate(
                data.count_date
            )
        );


        /*
        |--------------------------------------------------------------------------
        | Information
        |--------------------------------------------------------------------------
        */

        this.setText(
            this.elements.inspectorBranch,
            data.branch?.name || '—'
        );


        this.setText(
            this.elements.inspectorCreatedBy,
            data.created_by || 'System'
        );


        this.setText(
            this.elements.inspectorCreatedAt,
            data.created_at || '—'
        );


        this.setText(
            this.elements.inspectorCompletedBy,
            data.completed_by || '—'
        );


        this.setText(
            this.elements.inspectorCompletedAt,
            data.completed_at || '—'
        );


        /*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

        this.setText(
            this.elements.inspectorItemCount,
            this.formatNumber(
                data.item_count || 0
            )
        );


        this.setText(
            this.elements.inspectorVarianceCount,
            this.formatNumber(
                data.variance_item_count || 0
            )
        );


        this.setText(
            this.elements.inspectorPositiveVariance,
            this.formatQuantity(
                data.positive_variance || 0
            )
        );


        this.setText(
            this.elements.inspectorNegativeVariance,
            this.formatQuantity(
                data.negative_variance || 0
            )
        );


        /*
        |--------------------------------------------------------------------------
        | Notes
        |--------------------------------------------------------------------------
        */

        this.setText(
            this.elements.inspectorNotes,
            data.notes || 'No notes provided.'
        );


        /*
        |--------------------------------------------------------------------------
        | Items
        |--------------------------------------------------------------------------
        */

        this.renderInspectorItems(
            data.items || []
        );

    },


    /*
|--------------------------------------------------------------------------
| Render Inspector Items
|--------------------------------------------------------------------------
*/

renderInspectorItems(items) {

    if (! this.elements.inspectorItems) {
        return;
    }


    this.elements.inspectorItems.innerHTML =
        '';


    /*
    |--------------------------------------------------------------------------
    | Badge
    |--------------------------------------------------------------------------
    */

    if (this.elements.inspectorItemsBadge) {

        this.elements.inspectorItemsBadge.textContent =
            items.length;

    }


    /*
    |--------------------------------------------------------------------------
    | Empty
    |--------------------------------------------------------------------------
    */

    if (! items.length) {

        this.elements.inspectorItems.innerHTML = `

            <div class="stock-count-inspector-empty">

                <div class="stock-count-inspector-empty-icon">

                    <i class="bi bi-box-seam"></i>

                </div>

                <div class="fw-semibold">
                    No Count Items
                </div>

                <div class="small text-muted">
                    No products have been added to this count yet.
                </div>

            </div>

        `;

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Items
    |--------------------------------------------------------------------------
    */

    items.forEach(
        item => {

            const product =
                item.product || {};


            const variance =
                Number(
                    item.variance || 0
                );


            const varianceValue =
                Number(
                    item.variance_value || 0
                );


            /*
            |--------------------------------------------------------------------------
            | Variance Styling
            |--------------------------------------------------------------------------
            */

            let varianceClass =
                'stock-count-variance-neutral';


            let varianceIcon =
                'bi-dash';


            let varianceLabel =
                'No Variance';


            if (variance > 0) {

                varianceClass =
                    'stock-count-variance-positive';

                varianceIcon =
                    'bi-arrow-up';

                varianceLabel =
                    'Over';

            } else if (variance < 0) {

                varianceClass =
                    'stock-count-variance-negative';

                varianceIcon =
                    'bi-arrow-down';

                varianceLabel =
                    'Short';

            }


            /*
            |--------------------------------------------------------------------------
            | Product Initial
            |--------------------------------------------------------------------------
            */

            const productName =
                product.name
                || 'Deleted Product';


            const productInitial =
                productName
                    .charAt(0)
                    .toUpperCase();


            /*
            |--------------------------------------------------------------------------
            | Wrapper
            |--------------------------------------------------------------------------
            */

            const wrapper =
                document.createElement(
                    'div'
                );


            wrapper.className =
                'stock-count-inspector-item';


            wrapper.innerHTML = `

                

                <div class="stock-count-inspector-item-header">

                    <div
                        class="stock-count-product-avatar"
                    >

                        ${this.escapeHtml(
                            productInitial
                        )}

                    </div>


                    <div class="stock-count-product-info">

                        <div
                            class="stock-count-product-name"
                            title="${this.escapeHtml(
                                productName
                            )}"
                        >

                            ${this.escapeHtml(
                                productName
                            )}

                        </div>


                        <div class="stock-count-product-meta">

                            <span>

                                ${this.escapeHtml(
                                    product.sku
                                    || product.product_code
                                    || '—'
                                )}

                            </span>


                            ${
                                product.category
                                    ? `

                                        <span class="stock-count-meta-separator">
                                            ·
                                        </span>

                                        <span>
                                            ${this.escapeHtml(
                                                product.category
                                            )}
                                        </span>

                                    `
                                    : ''
                            }

                        </div>

                    </div>


                    <div
                        class="stock-count-variance ${varianceClass}"
                    >

                        <div class="stock-count-variance-label">

                            ${varianceLabel}

                        </div>

                        <div class="stock-count-variance-value">

                            <i class="bi ${varianceIcon}"></i>

                            ${this.formatQuantity(
                                variance
                            )}

                        </div>

                    </div>

                </div>


                

                <div class="stock-count-item-stats">

                    <div class="stock-count-item-stat">

                        <span>
                            System
                        </span>

                        <strong>
                            ${this.formatQuantity(
                                item.system_quantity
                            )}
                        </strong>

                    </div>


                    <div class="stock-count-item-stat">

                        <span>
                            Counted
                        </span>

                        <strong>
                            ${this.formatQuantity(
                                item.counted_quantity
                            )}
                        </strong>

                    </div>


                    <div class="stock-count-item-stat">

                        <span>
                            Variance Value
                        </span>

                        <strong>
                            ${this.formatCurrency(
                                varianceValue
                            )}
                        </strong>

                    </div>

                </div>

            `;


            this.elements.inspectorItems.appendChild(
                wrapper
            );

        }
    );

}, 

/*
|--------------------------------------------------------------------------
| Start Count
|--------------------------------------------------------------------------
*/

async startCount() {

    const id =
        this.state.selectedId;


    if (! id) {
        return;
    }


    try {

        const url =
            window.STOCK_COUNT.startUrl.replace(
                ':id',
                id
            );


        const response =
            await fetch(
                url,
                {

                    method: 'POST',

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


        if (! response.ok) {

            throw new Error(
                result.message
                || 'Unable to start Stock Count.'
            );

        }


        if (! result.status) {

            throw new Error(
                result.message
                || 'Unable to start Stock Count.'
            );

        }


        this.showToast(
            result.message
            || 'Stock Count started successfully.',
            'success'
        );


        /*
        |--------------------------------------------------------------------------
        | Reload Inspector
        |--------------------------------------------------------------------------
        */

        const data =
            await this.fetchDetails(
                id
            );


        this.populateInspector(
            data
        );


    } catch (error) {

        console.error(
            'Stock Count start error:',
            error
        );


        this.showToast(
            error.message
            || 'Unable to start Stock Count.',
            'danger'
        );

    }

},

/*
|--------------------------------------------------------------------------
| Open Counting Modal
|--------------------------------------------------------------------------
*/

async openCountingModal() {

    const id =
        this.state.selectedId;


    if (! id) {

        this.showToast(
            'Unable to continue Stock Count.',
            'danger'
        );

        return;

    }


    try {

        /*
        |--------------------------------------------------------------------------
        | Store Counting ID
        |--------------------------------------------------------------------------
        */

        this.state.countingId =
            id;


        /*
        |--------------------------------------------------------------------------
        | Reset Search
        |--------------------------------------------------------------------------
        */

        if (this.elements.countingSearch) {

            this.elements.countingSearch.value =
                '';

        }


        /*
        |--------------------------------------------------------------------------
        | Load Stock Count
        |--------------------------------------------------------------------------
        */

        const data =
            await this.fetchDetails(
                id
            );


        if (! data) {

            throw new Error(
                'Unable to load Stock Count.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Reference
        |--------------------------------------------------------------------------
        */

        this.setText(
            this.elements.countingReference,
            data.reference_no || '—'
        );


        /*
        |--------------------------------------------------------------------------
        | Render Items
        |--------------------------------------------------------------------------
        */

        this.renderCountingItems(
            data.items || []
        );


        /*
        |--------------------------------------------------------------------------
        | Open Modal
        |--------------------------------------------------------------------------
        */

        this.components.countingModal?.show();

        this.startCountingTimer();


    } catch (error) {

        console.error(
            'Stock Count counting modal error:',
            error
        );


        this.showToast(
            error.message
            || 'Unable to open Stock Count.',
            'danger'
        );

    }

},

/*
|--------------------------------------------------------------------------
| Render Counting Items
|--------------------------------------------------------------------------
*/

renderCountingItems(items) {

    if (! this.elements.countingItems) {
        return;
    }


    this.elements.countingItems.innerHTML =
        '';


    /*
    |--------------------------------------------------------------------------
    | Total Items
    |--------------------------------------------------------------------------
    */

    this.setText(
        this.elements.totalProgress,
        items.length
    );


    /*
    |--------------------------------------------------------------------------
    | Empty
    |--------------------------------------------------------------------------
    */

    if (! items.length) {

        this.elements.countingEmpty?.classList.remove(
            'd-none'
        );

        this.updateCountingProgress();

        return;

    }


    this.elements.countingEmpty?.classList.add(
        'd-none'
    );


    /*
    |--------------------------------------------------------------------------
    | Render Items
    |--------------------------------------------------------------------------
    */

    items.forEach(
        item => {

            const product =
                item.product || {};


            const systemQuantity =
                Number(
                    item.system_quantity || 0
                );


            const countedQuantity =
                Number(
                    item.counted_quantity || 0
                );


            const variance =
                countedQuantity -
                systemQuantity;


            const row =
                document.createElement(
                    'tr'
                );


            row.dataset.itemId =
                item.id;


            row.innerHTML = `

                <td>

                    <div class="fw-semibold">

                        ${this.escapeHtml(
                            product.name
                            || 'Deleted Product'
                        )}

                    </div>

                </td>


                <td>

                    <span class="small text-muted">

                        ${this.escapeHtml(
                            product.sku
                            || product.product_code
                            || '—'
                        )}

                    </span>

                </td>


                <td class="text-end">

                    <span class="fw-semibold">

                        ${this.formatQuantity(
                            systemQuantity
                        )}

                    </span>

                </td>


                <td>

                    <input
                        type="number"
                        class="form-control text-end stock-count-physical-input"
                        value="${countedQuantity}"
                        min="0"
                        step="0.01"
                        data-item-id="${item.id}"
                        data-system-quantity="${systemQuantity}"
                        data-counted="false"
                    >

                </td>


                <td class="text-end">

                    <span
                        class="fw-semibold stock-count-item-variance"
                        data-variance-for="${item.id}"
                    >
                        ${this.formatQuantity(
                            variance
                        )}
                    </span>

                </td>

            `;


            this.elements.countingItems.appendChild(
                row
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Update Progress
    |--------------------------------------------------------------------------
    */

    this.updateCountingProgress();

},



/*
|--------------------------------------------------------------------------
| Start Counting Timer
|--------------------------------------------------------------------------
*/

startCountingTimer() {

    /*
    |--------------------------------------------------------------------------
    | Clear Existing Timer
    |--------------------------------------------------------------------------
    */

    if (this.state.countingTimer) {

        clearInterval(
            this.state.countingTimer
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Start Time
    |--------------------------------------------------------------------------
    */

    this.state.countingStartedAt =
        Date.now();


    /*
    |--------------------------------------------------------------------------
    | Initial Display
    |--------------------------------------------------------------------------
    */

    this.updateCountingTimer();


    /*
    |--------------------------------------------------------------------------
    | Timer
    |--------------------------------------------------------------------------
    */

    this.state.countingTimer =
        setInterval(
            () => this.updateCountingTimer(),
            1000
        );

},

/*
|--------------------------------------------------------------------------
| Update Counting Timer
|--------------------------------------------------------------------------
*/

updateCountingTimer() {

    if (! this.elements.timer) {
        return;
    }


    if (! this.state.countingStartedAt) {
        return;
    }


    const elapsed =
        Math.floor(
            (
                Date.now()
                -
                this.state.countingStartedAt
            ) / 1000
        );


    const hours =
        Math.floor(
            elapsed / 3600
        );


    const minutes =
        Math.floor(
            (elapsed % 3600) / 60
        );


    const seconds =
        elapsed % 60;


    const formatted =
        [
            hours,
            minutes,
            seconds
        ]
        .map(
            value =>
                String(value)
                    .padStart(2, '0')
        )
        .join(':');


    this.elements.timer.textContent =
        formatted;

},

/*
|--------------------------------------------------------------------------
| Stop Counting Timer
|--------------------------------------------------------------------------
*/

stopCountingTimer() {

    if (this.state.countingTimer) {

        clearInterval(
            this.state.countingTimer
        );

        this.state.countingTimer =
            null;

    }


    this.state.countingStartedAt =
        null;


    if (this.elements.timer) {

        this.elements.timer.textContent =
            '00:00:00';

    }

},

/*
|--------------------------------------------------------------------------
| Update Counting Item
|--------------------------------------------------------------------------
*/

updateCountingItem(input) {

    const itemId =
        input.dataset.itemId;


    const systemQuantity =
        Number(
            input.dataset.systemQuantity || 0
        );


    const countedQuantity =
        Number(
            input.value || 0
        );


    const variance =
        countedQuantity -
        systemQuantity;


    const varianceElement =
        this.elements.countingItems.querySelector(
            `[data-variance-for="${itemId}"]`
        );


    if (! varianceElement) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Variance Class
    |--------------------------------------------------------------------------
    */

    varianceElement.classList.remove(
        'text-success',
        'text-danger',
        'text-muted'
    );


    if (variance > 0) {

        varianceElement.classList.add(
            'text-success'
        );

    } else if (variance < 0) {

        varianceElement.classList.add(
            'text-danger'
        );

    } else {

        varianceElement.classList.add(
            'text-muted'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Variance Value
    |--------------------------------------------------------------------------
    */

    varianceElement.textContent =
        this.formatQuantity(
            variance
        );


    /*
    |--------------------------------------------------------------------------
    | Progress
    |--------------------------------------------------------------------------
    */

    this.updateCountingProgress();

},


/*
|--------------------------------------------------------------------------
| Update Counting Progress
|--------------------------------------------------------------------------
*/

updateCountingProgress() {

    if (! this.elements.countingItems) {
        return;
    }


    const inputs =
        this.elements.countingItems.querySelectorAll(
            '.stock-count-physical-input'
        );


    const total =
        inputs.length;


    let counted =
        0;


    let totalVariance =
        0;


    inputs.forEach(
        input => {

            /*
            |--------------------------------------------------------------------------
            | Counted Status
            |--------------------------------------------------------------------------
            */

            if (
                input.dataset.counted === 'true'
            ) {

                counted++;

            }


            /*
            |--------------------------------------------------------------------------
            | Variance
            |--------------------------------------------------------------------------
            */

            const systemQuantity =
                Number(
                    input.dataset.systemQuantity || 0
                );


            const countedQuantity =
                Number(
                    input.value || 0
                );


            totalVariance +=
                countedQuantity -
                systemQuantity;

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Progress Percentage
    |--------------------------------------------------------------------------
    */

    const percentage =
        total > 0
            ? Math.round(
                (counted / total) * 100
            )
            : 0;


    /*
    |--------------------------------------------------------------------------
    | Update UI
    |--------------------------------------------------------------------------
    */

    this.setText(
        this.elements.countedProgress,
        counted
    );


    this.setText(
        this.elements.totalProgress,
        total
    );


    this.setText(
        this.elements.progressPercentage,
        `${percentage}%`
    );


    if (this.elements.progressBar) {

        this.elements.progressBar.style.width =
            `${percentage}%`;

    }


    /*
    |--------------------------------------------------------------------------
    | Total Variance
    |--------------------------------------------------------------------------
    */

    this.setText(
        this.elements.totalVariance,
        this.formatQuantity(
            totalVariance
        )
    );


    /*
    |--------------------------------------------------------------------------
    | Complete Button
    |--------------------------------------------------------------------------
    */

    if (this.elements.completeButton) {

        this.elements.completeButton.disabled =
            total === 0
            || counted < total;

    }

},


/*
|--------------------------------------------------------------------------
| Update Counting Item Variance
|--------------------------------------------------------------------------
*/

updateCountingItemVariance(input) {

    if (! input) {
        return;
    }


    const itemId =
        input.dataset.itemId;


    const systemQuantity =
        Number(
            input.dataset.systemQuantity || 0
        );


    const countedQuantity =
        input.value === ''
            ? 0
            : Number(input.value);


    const variance =
        countedQuantity -
        systemQuantity;


    /*
    |--------------------------------------------------------------------------
    | Variance Element
    |--------------------------------------------------------------------------
    */

    const varianceElement =
        this.elements.countingItems?.querySelector(
            `[data-variance-for="${itemId}"]`
        );


    if (varianceElement) {

        varianceElement.textContent =
            this.formatQuantity(
                variance
            );


        varianceElement.classList.remove(
            'text-success',
            'text-danger',
            'text-muted'
        );


        if (variance > 0) {

            varianceElement.classList.add(
                'text-success'
            );

        } else if (variance < 0) {

            varianceElement.classList.add(
                'text-danger'
            );

        } else {

            varianceElement.classList.add(
                'text-muted'
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Update Progress
    |--------------------------------------------------------------------------
    */

    this.updateCountingProgress();

},

/*
|--------------------------------------------------------------------------
| Set Complete Loading
|--------------------------------------------------------------------------
*/

setCompleteLoading(loading) {

    if (
        this.elements.completeSpinner
        && this.elements.completeIcon
    ) {

        this.elements.completeSpinner.classList.toggle(
            'd-none',
            ! loading
        );

        this.elements.completeIcon.classList.toggle(
            'd-none',
            loading
        );

    }


    if (this.elements.confirmComplete) {

        this.elements.confirmComplete.disabled =
            loading;

    }

},

/*
|--------------------------------------------------------------------------
| Complete Counting
|--------------------------------------------------------------------------
*/

async completeCounting() {

    const id =
        this.state.countingId;


    if (! id) {

        this.showToast(
            'Unable to complete Stock Count.',
            'danger'
        );

        return;

    }


    this.setCompleteLoading(
        true
    );


    try {

        /*
        |--------------------------------------------------------------------------
        | Collect Items
        |--------------------------------------------------------------------------
        */

        const inputs =
            this.elements.countingItems
                ?.querySelectorAll(
                    '.stock-count-physical-input'
                );


        if (! inputs || ! inputs.length) {

            throw new Error(
                'This Stock Count has no items.'
            );

        }


        const items = [];


        inputs.forEach(
            input => {

                items.push({

                    id:
                        Number(
                            input.dataset.itemId
                        ),

                    counted_quantity:
                        Number(
                            input.value
                        ),

                });

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Validate Quantities
        |--------------------------------------------------------------------------
        */

        const incomplete =
            items.some(
                item =>
                    ! Number.isFinite(
                        item.counted_quantity
                    )
            );


        if (incomplete) {

            throw new Error(
                'Please enter a physical quantity for every item.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Request
        |--------------------------------------------------------------------------
        */

        const url =
            window.STOCK_COUNT.completeUrl.replace(
                ':id',
                id
            );


        const response =
            await fetch(
                url,
                {

                    method: 'POST',

                    headers: {

                        'Accept':
                            'application/json',

                        'Content-Type':
                            'application/json',

                        'X-Requested-With':
                            'XMLHttpRequest',

                        'X-CSRF-TOKEN':
                            this.getCsrfToken(),

                    },

                    body:
                        JSON.stringify({

                            items:
                                items,

                        }),

                }
            );


        const result =
            await response.json();


        if (! response.ok) {

            throw new Error(
                result.message
                || 'Unable to complete Stock Count.'
            );

        }


        if (! result.status) {

            throw new Error(
                result.message
                || 'Unable to complete Stock Count.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Stop Timer
        |--------------------------------------------------------------------------
        */

        this.stopCountingTimer();


        /*
        |--------------------------------------------------------------------------
        | Close Confirmation
        |--------------------------------------------------------------------------
        */

        this.components.completeModal?.hide();


        /*
        |--------------------------------------------------------------------------
        | Close Counting Modal
        |--------------------------------------------------------------------------
        */

        this.components.countingModal?.hide();


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        this.showToast(
            result.message
            || 'Stock Count completed successfully.',
            'success'
        );


        /*
        |--------------------------------------------------------------------------
        | Refresh Table
        |--------------------------------------------------------------------------
        */

        this.loadTable(
            this.state.page
        );


        /*
        |--------------------------------------------------------------------------
        | Refresh Inspector
        |--------------------------------------------------------------------------
        */

        if (this.state.selectedId) {

            await this.openInspector(
                this.state.selectedId
            );

        }

    } catch (error) {

        console.error(
            'Stock Count completion error:',
            error
        );


        this.showToast(
            error.message
            || 'Unable to complete Stock Count.',
            'danger'
        );

    } finally {

        this.setCompleteLoading(
            false
        );

    }

},


/*
|--------------------------------------------------------------------------
| Filter Counting Items
|--------------------------------------------------------------------------
*/

filterCountingItems() {

    if (! this.elements.countingItems) {
        return;
    }


    const search =
        (
            this.elements.countingSearch?.value
            || ''
        )
        .trim()
        .toLowerCase();


    const rows =
        this.elements.countingItems.querySelectorAll(
            'tr'
        );


    let visibleCount =
        0;


    rows.forEach(
        row => {

            const text =
                row.textContent
                    .toLowerCase();


            const matches =
                ! search
                || text.includes(search);


            row.classList.toggle(
                'd-none',
                ! matches
            );


            if (matches) {

                visibleCount++;

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Empty State
    |--------------------------------------------------------------------------
    */

    if (this.elements.countingEmpty) {

        if (
            rows.length > 0
            && visibleCount === 0
        ) {

            this.elements.countingEmpty.classList.remove(
                'd-none'
            );

        } else {

            this.elements.countingEmpty.classList.add(
                'd-none'
            );

        }

    }

},
    /*
    |--------------------------------------------------------------------------
    | Reset Form
    |--------------------------------------------------------------------------
    */

    resetForm() {

        if (! this.elements.form) {
            return;
        }


        this.elements.form.reset();


        if (this.elements.id) {

            this.elements.id.value =
                '';

        }


        this.clearFormErrors();


        this.setFormLoading(
            false
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Clear Form Errors
    |--------------------------------------------------------------------------
    */

    clearFormErrors() {

        [
            this.elements.formBranch,
            this.elements.formDate,
            this.elements.formNotes

        ].forEach(
            element => {

                if (! element) {
                    return;
                }

                element.classList.remove(
                    'is-invalid'
                );

            }
        );


        [
            this.elements.branchError,
            this.elements.dateError,
            this.elements.notesError

        ].forEach(
            element => {

                if (element) {

                    element.textContent =
                        '';

                }

            }
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Display Validation Errors
    |--------------------------------------------------------------------------
    */

    displayValidationErrors(errors) {

        this.clearFormErrors();


        if (
            errors.branch_id
            && this.elements.formBranch
        ) {

            this.elements.formBranch.classList.add(
                'is-invalid'
            );


            if (this.elements.branchError) {

                this.elements.branchError.textContent =
                    errors.branch_id[0];

            }

        }


        if (
            errors.count_date
            && this.elements.formDate
        ) {

            this.elements.formDate.classList.add(
                'is-invalid'
            );


            if (this.elements.dateError) {

                this.elements.dateError.textContent =
                    errors.count_date[0];

            }

        }


        if (
            errors.notes
            && this.elements.formNotes
        ) {

            this.elements.formNotes.classList.add(
                'is-invalid'
            );


            if (this.elements.notesError) {

                this.elements.notesError.textContent =
                    errors.notes[0];

            }

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Form Loading
    |--------------------------------------------------------------------------
    */

    setFormLoading(
        loading
    ) {

        if (! this.elements.saveButton) {
            return;
        }


        this.elements.saveButton.disabled =
            loading;


        if (this.elements.saveSpinner) {

            this.elements.saveSpinner.classList.toggle(
                'd-none',
                ! loading
            );

        }


        if (this.elements.saveIcon) {

            this.elements.saveIcon.classList.toggle(
                'd-none',
                loading
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Delete Loading
    |--------------------------------------------------------------------------
    */

    setDeleteLoading(
        loading
    ) {

        if (
            ! this.elements.confirmDelete
        ) {
            return;
        }


        this.elements.confirmDelete.disabled =
            loading;


        if (this.elements.deleteSpinner) {

            this.elements.deleteSpinner.classList.toggle(
                'd-none',
                ! loading
            );

        }


        if (this.elements.deleteIcon) {

            this.elements.deleteIcon.classList.toggle(
                'd-none',
                loading
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Table Loading
    |--------------------------------------------------------------------------
    */

    showTableLoading() {

        if (this.elements.tableBody) {

            this.elements.tableBody.innerHTML = `

                <tr>

                    <td
                        colspan="7"
                        class="text-center py-5"
                    >

                        <div
                            class="spinner-border spinner-border-sm text-primary mb-2"
                            role="status"
                        ></div>

                        <div class="small text-muted">
                            Loading Stock Counts...
                        </div>

                    </td>

                </tr>

            `;

        }


        this.hideTableState();

    },


    /*
    |--------------------------------------------------------------------------
    | Table Empty
    |--------------------------------------------------------------------------
    */

    showTableEmpty() {

        if (this.elements.tableBody) {

            this.elements.tableBody.innerHTML =
                '';

        }


        if (this.elements.stateTitle) {

            this.elements.stateTitle.textContent =
                'No Stock Counts Found';

        }


        if (this.elements.stateMessage) {

            this.elements.stateMessage.textContent =
                'There are no Stock Counts matching your filters.';

        }


        this.elements.tableState?.classList.remove(
            'd-none'
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Table Error
    |--------------------------------------------------------------------------
    */

    showTableError(message) {

        if (this.elements.tableBody) {

            this.elements.tableBody.innerHTML =
                '';

        }


        if (this.elements.stateTitle) {

            this.elements.stateTitle.textContent =
                'Unable to Load Stock Counts';

        }


        if (this.elements.stateMessage) {

            this.elements.stateMessage.textContent =
                message;

        }


        this.elements.tableState?.classList.remove(
            'd-none'
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Hide Table State
    |--------------------------------------------------------------------------
    */

    hideTableState() {

        this.elements.tableState?.classList.add(
            'd-none'
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Clear Filters
    |--------------------------------------------------------------------------
    */

    clearFilters() {

        if (this.elements.search) {

            this.elements.search.value =
                '';

        }


        if (this.elements.branchFilter) {

            this.elements.branchFilter.value =
                '';

        }


        if (this.elements.statusFilter) {

            this.elements.statusFilter.value =
                '';

        }


        if (this.elements.dateFrom) {

            this.elements.dateFrom.value =
                '';

        }


        if (this.elements.dateTo) {

            this.elements.dateTo.value =
                '';

        }


        this.loadTable(1);

    },


    /*
    |--------------------------------------------------------------------------
    | Inspector Loading
    |--------------------------------------------------------------------------
    */

    showInspectorLoading() {

        this.elements.inspectorLoading?.classList.remove(
            'd-none'
        );


        this.elements.inspectorError?.classList.add(
            'd-none'
        );


        this.elements.inspectorContent?.classList.add(
            'd-none'
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Inspector Error
    |--------------------------------------------------------------------------
    */

    showInspectorError(
        message
    ) {

        this.elements.inspectorLoading?.classList.add(
            'd-none'
        );


        this.elements.inspectorContent?.classList.add(
            'd-none'
        );


        this.elements.inspectorError?.classList.remove(
            'd-none'
        );


        this.setText(
            this.elements.inspectorErrorMessage,
            message
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Hide Inspector States
    |--------------------------------------------------------------------------
    */

    hideInspectorStates() {

        this.elements.inspectorLoading?.classList.add(
            'd-none'
        );


        this.elements.inspectorError?.classList.add(
            'd-none'
        );


        this.elements.inspectorContent?.classList.remove(
            'd-none'
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Reset Inspector
    |--------------------------------------------------------------------------
    */

    resetInspector() {

        this.elements.inspectorContent?.classList.add(
            'd-none'
        );


        this.elements.inspectorError?.classList.add(
            'd-none'
        );


        this.elements.inspectorLoading?.classList.remove(
            'd-none'
        );


        [
            this.elements.inspectorReference,
            this.elements.inspectorReferenceValue,
            this.elements.inspectorDate,
            this.elements.inspectorBranch,
            this.elements.inspectorCreatedBy,
            this.elements.inspectorCreatedAt,
            this.elements.inspectorCompletedBy,
            this.elements.inspectorCompletedAt,
            this.elements.inspectorNotes

        ].forEach(
            element => {

                this.setText(
                    element,
                    '—'
                );

            }
        );


        this.setText(
            this.elements.inspectorItemCount,
            '0'
        );


        this.setText(
            this.elements.inspectorVarianceCount,
            '0'
        );


        this.setText(
            this.elements.inspectorPositiveVariance,
            '0'
        );


        this.setText(
            this.elements.inspectorNegativeVariance,
            '0'
        );


        if (this.elements.inspectorStatus) {

            this.elements.inspectorStatus.textContent =
                '—';

        }


        if (this.elements.inspectorItems) {

            this.elements.inspectorItems.innerHTML =
                '';

        }


        if (this.elements.inspectorItemsBadge) {

            this.elements.inspectorItemsBadge.textContent =
                '0';

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Set Text
    |--------------------------------------------------------------------------
    */

    setText(
        element,
        value
    ) {

        if (! element) {
            return;
        }


        element.textContent =
            value ?? '—';

    },


    /*
    |--------------------------------------------------------------------------
    | Format Number
    |--------------------------------------------------------------------------
    */

    formatNumber(
        value
    ) {

        return Number(
            value || 0
        ).toLocaleString(
            'en-US'
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Format Quantity
    |--------------------------------------------------------------------------
    */

    formatQuantity(
        value
    ) {

        return Number(
            value || 0
        ).toLocaleString(
            'en-US',
            {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Format Currency
    |--------------------------------------------------------------------------
    */

    formatCurrency(
        value
    ) {

        return Number(
            value || 0
        ).toLocaleString(
            'en-NG',
            {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Format Date
    |--------------------------------------------------------------------------
    */

    formatDate(
        value
    ) {

        if (! value) {
            return '—';
        }


        const date =
            new Date(
                value
            );


        if (
            Number.isNaN(
                date.getTime()
            )
        ) {

            return value;

        }


        return date.toLocaleDateString(
            'en-GB',
            {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
            }
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Today's Date
    |--------------------------------------------------------------------------
    */

    getToday() {

        const date =
            new Date();


        const year =
            date.getFullYear();


        const month =
            String(
                date.getMonth() + 1
            ).padStart(
                2,
                '0'
            );


        const day =
            String(
                date.getDate()
            ).padStart(
                2,
                '0'
            );


        return `${year}-${month}-${day}`;

    },


    /*
    |--------------------------------------------------------------------------
    | CSRF Token
    |--------------------------------------------------------------------------
    */

    getCsrfToken() {

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
    | Escape HTML
    |--------------------------------------------------------------------------
    */

    escapeHtml(
        value
    ) {

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
    | Escape Attribute
    |--------------------------------------------------------------------------
    */

    escapeAttribute(
        value
    ) {

        return this.escapeHtml(
            value
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


    /*
    |--------------------------------------------------------------------------
    | Toast
    |--------------------------------------------------------------------------
    |
    | Uses the project's existing showToast() if available.
    | Falls back to a Bootstrap alert if the project does not
    | expose the helper.
    |
    */

    showToast(
        message,
        type = 'success'
    ) {

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
        | Fallback
        |--------------------------------------------------------------------------
        */

        const alert =
            document.createElement(
                'div'
            );


        alert.className =
            `alert alert-${type} position-fixed top-0 end-0 m-3 shadow`;
            

        alert.style.zIndex =
            '9999';


        alert.textContent =
            message;


        document.body.appendChild(
            alert
        );


        setTimeout(
            () => {

                alert.remove();

            },
            3500
        );

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

        StockCount.init();

    }
);