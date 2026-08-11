const StockMovement = {

    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    state: {

        page: 1,

        perPage: 15,

        search: '',

        movementType: '',

        branch: '',

        loading: false,

    },


    /*
    |--------------------------------------------------------------------------
    | Elements
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

        this.bindEvents();

        this.loadTable();

    },


    /*
    |--------------------------------------------------------------------------
    | Cache DOM Elements
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
                    'stockMovementTableBody'
                ),


            /*
            |--------------------------------------------------------------------------
            | Search
            |--------------------------------------------------------------------------
            */

            search:
                document.getElementById(
                    'stockMovementSearch'
                ),


            /*
            |--------------------------------------------------------------------------
            | Movement Type
            |--------------------------------------------------------------------------
            */

            movementType:
                document.getElementById(
                    'stockMovementTypeFilter'
                ),


            /*
            |--------------------------------------------------------------------------
            | Branch
            |--------------------------------------------------------------------------
            */

            branch:
                document.getElementById(
                    'stockMovementBranchFilter'
                ),


            /*
            |--------------------------------------------------------------------------
            | KPI
            |--------------------------------------------------------------------------
            */

            totalMovements:
                document.getElementById(
                    'historyTotalMovements'
                ),

            totalProducts:
                document.getElementById(
                    'historyTotalProducts'
                ),

            totalQuantity:
                document.getElementById(
                    'historyTotalQuantity'
                ),

            totalBranches:
                document.getElementById(
                    'historyDestinationBranches'
                ),

        };

    },


    /*
    |--------------------------------------------------------------------------
    | Bind Events
    |--------------------------------------------------------------------------
    */

    bindEvents() {

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if (this.elements.search) {

            let searchTimer = null;


            this.elements.search.addEventListener(
                'input',
                () => {

                    clearTimeout(
                        searchTimer
                    );


                    searchTimer =
                        setTimeout(
                            () => {

                                this.state.search =
                                    this.elements.search.value
                                        .trim();


                                this.state.page =
                                    1;


                                this.loadTable();

                            },
                            350
                        );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Movement Type
        |--------------------------------------------------------------------------
        */

        if (this.elements.movementType) {

            this.elements.movementType.addEventListener(
                'change',
                () => {

                    this.state.movementType =
                        this.elements.movementType.value;


                    this.state.page =
                        1;


                    this.loadTable();

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Branch
        |--------------------------------------------------------------------------
        */

        if (this.elements.branch) {

            this.elements.branch.addEventListener(
                'change',
                () => {

                    this.state.branch =
                        this.elements.branch.value;


                    this.state.page =
                        1;


                    this.loadTable();

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | View Movement
        |--------------------------------------------------------------------------
        */

        this.elements.tableBody
            ?.addEventListener(
                'click',
                (event) => {

                    const button =
                        event.target.closest(
                            '[data-reference]'
                        );


                    if (!button) {

                        return;

                    }


                    const reference =
                        button.dataset.reference;


                    if (!reference) {

                        return;

                    }


                    this.openInspector(
                        reference
                    );

                }
            );


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            (event) => {

                const button =
                    event.target.closest(
                        '[data-stock-movement-page]'
                    );


                if (!button) {

                    return;

                }


                event.preventDefault();


                const page =
                    parseInt(
                        button.dataset.stockMovementPage,
                        10
                    );


                if (
                    !page ||
                    page === this.state.page
                ) {

                    return;

                }


                this.state.page =
                    page;


                this.loadTable();

            }
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Load Table
    |--------------------------------------------------------------------------
    */

    async loadTable() {

        if (this.state.loading) {

            return;

        }


        const tableBody =
            this.elements.tableBody;


        if (!tableBody) {

            return;

        }


        this.state.loading =
            true;


        this.showLoading();


        try {

            const params =
                new URLSearchParams();


            params.set(
                'page',
                this.state.page
            );


            params.set(
                'per_page',
                this.state.perPage
            );


            if (this.state.search) {

                params.set(
                    'search',
                    this.state.search
                );

            }


            if (this.state.movementType) {

                params.set(
                    'movement_type',
                    this.state.movementType
                );

            }


            if (this.state.branch) {

                params.set(
                    'branch_id',
                    this.state.branch
                );

            }


            const response =
                await fetch(
                    `${this.getTableUrl()}?${params.toString()}`,
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
                !data.status
            ) {

                throw new Error(
                    data.message ||
                    'Unable to load stock movements.'
                );

            }


            this.renderTable(
                data.data || [],
                data.pagination || {}
            );


            this.updateKpis(
                data.kpis || null
            );

        }
        catch (error) {

            console.error(
                'Stock movement error:',
                error
            );


            tableBody.innerHTML = `

                <tr>

                    <td
                        colspan="8"
                        class="st-history-empty-cell"
                    >

                        <div class="st-history-empty">

                            <div class="st-history-empty-icon">

                                <i class="bi bi-exclamation-circle"></i>

                            </div>

                            <h6>
                                Unable to Load Movements
                            </h6>

                            <p>
                                ${this.escapeHtml(
                                    error.message ||
                                    'Something went wrong while loading stock movements.'
                                )}
                            </p>

                        </div>

                    </td>

                </tr>

            `;

        }
        finally {

            this.state.loading =
                false;

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Render Table
    |--------------------------------------------------------------------------
    */

    renderTable(
        movements,
        pagination
    ) {

        const tableBody =
            this.elements.tableBody;


        if (!tableBody) {

            return;

        }


        if (!movements.length) {

            tableBody.innerHTML = `

                <tr>

                    <td
                        colspan="8"
                        class="st-history-empty-cell"
                    >

                        <div class="st-history-empty">

                            <div class="st-history-empty-icon">

                                <i class="bi bi-arrow-left-right"></i>

                            </div>

                            <h6>
                                No stock movements
                            </h6>

                            <p>
                                No movements match the current filters.
                            </p>

                        </div>

                    </td>

                </tr>

            `;


            this.renderPagination(
                pagination
            );


            return;

        }


        let rows = '';


        movements.forEach(
            movement => {

                const reference =
                    movement.reference_no ||
                    '-';


                const movementType =
                    movement.movement_type ||
                    '-';


                const productName =
                    movement.product?.name ||
                    '-';


                const sku =
                    movement.product?.sku ||
                    '';


                const branchName =
                    movement.branch?.name ||
                    '-';


                const quantity =
                    this.formatNumber(
                        movement.quantity
                    );


                const date =
                    this.formatDate(
                        movement.date
                    );


                const createdBy =
                    movement.created_by?.name ||
                    'System';


                rows += `

                    <tr>

                        <td>

                            <div class="st-history-reference">

                                <span class="st-history-reference-icon">

                                    <i class="bi bi-receipt"></i>

                                </span>

                                <div>

                                    <strong>
                                        ${this.escapeHtml(
                                            reference
                                        )}
                                    </strong>

                                    <small>
                                        Stock Movement
                                    </small>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="st-history-product-count">

                                ${this.escapeHtml(
                                    movementType
                                )}

                            </span>

                        </td>


                        <td>

                            <div>

                                <strong>
                                    ${this.escapeHtml(
                                        productName
                                    )}
                                </strong>

                                ${
                                    sku
                                        ? `
                                            <small class="d-block text-muted">
                                                ${this.escapeHtml(sku)}
                                            </small>
                                        `
                                        : ''
                                }

                            </div>

                        </td>


                        <td>

                            <div class="st-history-branch">

                                <span class="st-history-branch-icon">

                                    <i class="bi bi-building"></i>

                                </span>

                                <span>
                                    ${this.escapeHtml(
                                        branchName
                                    )}
                                </span>

                            </div>

                        </td>


                        <td>

                            <strong class="st-history-quantity">

                                ${quantity}

                            </strong>

                        </td>


                        <td>

                            <div class="st-history-date">

                                <strong>
                                    ${this.escapeHtml(
                                        date.date
                                    )}
                                </strong>

                                <small>
                                    ${this.escapeHtml(
                                        date.time
                                    )}
                                </small>

                            </div>

                        </td>


                        <td>

                            <div class="st-history-user">

                                <span class="st-history-user-avatar">

                                    ${this.escapeHtml(
                                        this.getInitial(
                                            createdBy
                                        )
                                    )}

                                </span>

                                <span>
                                    ${this.escapeHtml(
                                        createdBy
                                    )}
                                </span>

                            </div>

                        </td>


                        <td class="text-end">

                            <button
                                type="button"
                                class="btn btn-sm st-history-view-btn"
                                data-reference="${this.escapeHtml(
                                    reference
                                )}"
                            >

                                <i class="bi bi-eye me-1"></i>

                                View

                            </button>

                        </td>

                    </tr>

                `;

            }
        );


        tableBody.innerHTML =
            rows;


        this.renderPagination(
            pagination
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Update KPIs
    |--------------------------------------------------------------------------
    */

    updateKpis(
        kpis
    ) {

        if (!kpis) {

            return;

        }


        if (this.elements.totalMovements) {

            this.elements.totalMovements.textContent =
                this.formatInteger(
                    kpis.total_movements
                );

        }


        if (this.elements.totalProducts) {

            this.elements.totalProducts.textContent =
                this.formatInteger(
                    kpis.total_products
                );

        }


        if (this.elements.totalQuantity) {

            this.elements.totalQuantity.textContent =
                this.formatNumber(
                    kpis.total_quantity
                );

        }


        if (this.elements.totalBranches) {

            this.elements.totalBranches.textContent =
                this.formatInteger(
                    kpis.total_branches
                );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Render Pagination
    |--------------------------------------------------------------------------
    */

    renderPagination(
        pagination
    ) {

        const footer =
            document.querySelector(
                '.st-history-card-footer'
            );


        if (!footer) {

            return;

        }


        const currentPage =
            parseInt(
                pagination.current_page,
                10
            ) || 1;


        const lastPage =
            parseInt(
                pagination.last_page,
                10
            ) || 1;


        const total =
            parseInt(
                pagination.total,
                10
            ) || 0;


        if (
            total === 0 ||
            lastPage <= 1
        ) {

            footer.innerHTML =
                '';

            return;

        }


        let buttons = '';


        for (
            let page = 1;
            page <= lastPage;
            page++
        ) {

            buttons += `

                <button
                    type="button"
                    class="btn btn-sm ${
                        page === currentPage
                            ? 'btn-primary'
                            : 'btn-light'
                    }"
                    data-stock-movement-page="${page}"
                >

                    ${page}

                </button>

            `;

        }


        footer.innerHTML = `

            <div class="st-history-pagination-info">

                Showing

                <strong>
                    ${(
                        (currentPage - 1) *
                        this.state.perPage
                    ) + 1}
                </strong>

                to

                <strong>
                    ${Math.min(
                        currentPage *
                        this.state.perPage,
                        total
                    )}
                </strong>

                of

                <strong>
                    ${total}
                </strong>

                movements

            </div>


            <div class="st-history-pagination">

                ${buttons}

            </div>

        `;

    },


    /*
    |--------------------------------------------------------------------------
    | Open Inspector
    |--------------------------------------------------------------------------
    */

    async openInspector(
        reference
    ) {

        if (!reference) {

            return;

        }


        const detailsUrl =
            window.STOCK_MOVEMENT
                ?.detailsUrl;


        if (!detailsUrl) {

            console.warn(
                'Stock movement details URL is not configured.'
            );

            return;

        }


        const url =
            detailsUrl.replace(
                ':reference',
                encodeURIComponent(
                    reference
                )
            );


        try {

            const response =
                await fetch(
                    url,
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
                !data.status
            ) {

                throw new Error(
                    data.message ||
                    'Unable to load movement details.'
                );

            }


            console.log(
                'Stock movement details:',
                data.data
            );

        }
        catch (error) {

            console.error(
                'Stock movement details error:',
                error
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Loading
    |--------------------------------------------------------------------------
    */

    showLoading() {

        const tableBody =
            this.elements.tableBody;


        if (!tableBody) {

            return;

        }


        tableBody.innerHTML = `

            <tr>

                <td
                    colspan="8"
                    class="st-history-empty-cell"
                >

                    <div class="st-history-empty">

                        <div class="st-history-empty-icon">

                            <span
                                class="spinner-border spinner-border-sm"
                            ></span>

                        </div>

                        <h6>
                            Loading Stock Movements
                        </h6>

                        <p>
                            Please wait...
                        </p>

                    </div>

                </td>

            </tr>

        `;

    },


    /*
    |--------------------------------------------------------------------------
    | Table URL
    |--------------------------------------------------------------------------
    */

    getTableUrl() {

        return (
            window.STOCK_MOVEMENT
                ?.tableUrl ||
            ''
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

        const date =
            new Date(
                value
            );


        if (
            Number.isNaN(
                date.getTime()
            )
        ) {

            return {

                date: '-',

                time: '-',

            };

        }


        return {

            date:
                date.toLocaleDateString(
                    'en-GB',
                    {

                        day:
                            '2-digit',

                        month:
                            'short',

                        year:
                            'numeric',

                    }
                ),

            time:
                date.toLocaleTimeString(
                    'en-US',
                    {

                        hour:
                            '2-digit',

                        minute:
                            '2-digit',

                    }
                ),

        };

    },


    /*
    |--------------------------------------------------------------------------
    | Number Formatting
    |--------------------------------------------------------------------------
    */

    formatNumber(
        value
    ) {

        const number =
            parseFloat(
                value
            ) || 0;


        return new Intl.NumberFormat(
            'en-US',
            {

                minimumFractionDigits:
                    2,

                maximumFractionDigits:
                    2,

            }
        ).format(
            number
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Integer Formatting
    |--------------------------------------------------------------------------
    */

    formatInteger(
        value
    ) {

        return new Intl.NumberFormat(
            'en-US'
        ).format(
            parseInt(
                value,
                10
            ) || 0
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Initial
    |--------------------------------------------------------------------------
    */

    getInitial(
        name
    ) {

        return (
            String(
                name ||
                'System'
            )
            .trim()
            .charAt(0)
            .toUpperCase()
        );

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

};


/*
|--------------------------------------------------------------------------
| Initialize
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    () => {

        StockMovement.init();

    }
);