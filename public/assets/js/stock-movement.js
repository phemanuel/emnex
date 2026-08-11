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
            | Inspector
            |--------------------------------------------------------------------------
            */

            inspector:
                document.getElementById(
                    'stockMovementInspector'
                ),

            inspectorLoading:
                document.getElementById(
                    'stockMovementInspectorLoading'
                ),

            inspectorContent:
                document.getElementById(
                    'stockMovementInspectorContent'
                ),

            inspectorError:
                document.getElementById(
                    'stockMovementInspectorError'
                ),

            inspectorErrorMessage:
                document.getElementById(
                    'stockMovementInspectorErrorMessage'
                ),

            inspectorReference:
                document.getElementById(
                    'stockMovementInspectorReference'
                ),

            inspectorIcon:
                document.getElementById(
                    'stockMovementInspectorIcon'
                ),

            inspectorType:
                document.getElementById(
                    'stockMovementInspectorType'
                ),

            inspectorDate:
                document.getElementById(
                    'stockMovementInspectorDate'
                ),

            inspectorTransferRoute:
                document.getElementById(
                    'stockMovementTransferRoute'
                ),

            inspectorSourceBranch:
                document.getElementById(
                    'stockMovementInspectorSourceBranch'
                ),

            inspectorDestinationBranch:
                document.getElementById(
                    'stockMovementInspectorDestinationBranch'
                ),

            inspectorBranchSection:
                document.getElementById(
                    'stockMovementInspectorBranchSection'
                ),

            inspectorBranch:
                document.getElementById(
                    'stockMovementInspectorBranch'
                ),

            inspectorProduct:
                document.getElementById(
                    'stockMovementInspectorProduct'
                ),

            inspectorSku:
                document.getElementById(
                    'stockMovementInspectorSku'
                ),

            inspectorCategory:
                document.getElementById(
                    'stockMovementInspectorCategory'
                ),

            inspectorUnit:
                document.getElementById(
                    'stockMovementInspectorUnit'
                ),

            inspectorQuantity:
                document.getElementById(
                    'stockMovementInspectorQuantity'
                ),

            inspectorBalance:
                document.getElementById(
                    'stockMovementInspectorBalance'
                ),

            inspectorUnitCost:
                document.getElementById(
                    'stockMovementInspectorUnitCost'
                ),

            inspectorCreatedBy:
                document.getElementById(
                    'stockMovementInspectorCreatedBy'
                ),

            inspectorRemarks:
                document.getElementById(
                    'stockMovementInspectorRemarks'
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

       this.elements.tableBody?.addEventListener(
            'click',
            (event) => {

                const button =
                    event.target.closest(
                        '.st-history-view-btn'
                    );


                if (!button) {

                    return;

                }


                const movementId =
                    button.getAttribute(
                        'data-movement-id'
                    );


                if (!movementId) {

                    console.warn(
                        'Stock movement ID is missing.'
                    );

                    return;

                }


                this.openInspector(
                    movementId
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


        this.showInspectorLoading();


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
                                data-movement-id="${movement.id}"
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

/*
|--------------------------------------------------------------------------
| Open Inspector
|--------------------------------------------------------------------------
*/

async openInspector(id) {

    if (!id) {

        console.warn(
            'Stock movement ID is missing.'
        );

        return;

    }


    const detailsUrl =
        window.STOCK_MOVEMENT?.detailsUrl;


    if (!detailsUrl) {

        console.error(
            'Stock movement details URL is not configured.'
        );

        return;

    }


    const url =
        detailsUrl.replace(
            ':id',
            encodeURIComponent(
                id
            )
        );


    this.showInspectorLoading();


    const offcanvasElement =
        this.elements.inspector;


    if (!offcanvasElement) {

        console.error(
            'Stock movement inspector was not found.'
        );

        return;

    }


    const offcanvas =
        bootstrap.Offcanvas.getOrCreateInstance(
            offcanvasElement
        );


    offcanvas.show();


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
            ! response.ok ||
            ! data.status
        ) {

            throw new Error(
                data.message ||
                'Unable to load stock movement details.'
            );

        }


        this.populateInspector(
            data.data
        );

    }
    catch (error) {

        console.error(
            'Stock movement inspector error:',
            error
        );


        this.showInspectorError(
            error.message ||
            'Unable to load stock movement details.'
        );

    }

},

/*
|--------------------------------------------------------------------------
| Populate Inspector
|--------------------------------------------------------------------------
*/

populateInspector(
    movement
) {

    if (!movement) {

        return;

    }


    if (this.elements.inspectorReference) {

        this.elements.inspectorReference.textContent =
            movement.reference_no ||
            '-';

    }


    if (this.elements.inspectorType) {

        this.elements.inspectorType.textContent =
            movement.movement_type ||
            '-';

    }


    if (this.elements.inspectorDate) {

        this.elements.inspectorDate.textContent =
            movement.created_at_formatted ||
            movement.created_at ||
            '-';

    }


    if (this.elements.inspectorProduct) {

        this.elements.inspectorProduct.textContent =
            movement.product?.name ||
            movement.product_name ||
            '-';

    }


    if (this.elements.inspectorSku) {

        this.elements.inspectorSku.textContent =
            movement.product?.sku ||
            movement.sku ||
            '-';

    }


    if (this.elements.inspectorQuantity) {

        this.elements.inspectorQuantity.textContent =
            this.formatNumber(
                movement.quantity
            );

    }


    if (this.elements.inspectorBalance) {

        this.elements.inspectorBalance.textContent =
            this.formatNumber(
                movement.balance_after
            );

    }


    if (this.elements.inspectorBranch) {

        this.elements.inspectorBranch.textContent =
            movement.branch?.name ||
            movement.branch_name ||
            '-';

    }


    if (this.elements.inspectorUnitCost) {

        this.elements.inspectorUnitCost.textContent =
            this.formatNumber(
                movement.unit_cost
            );

    }


    if (this.elements.inspectorCreatedBy) {

        this.elements.inspectorCreatedBy.textContent =
            movement.created_by?.name ||
            movement.created_by_name ||
            '-';

    }


    if (this.elements.inspectorRemarks) {

        this.elements.inspectorRemarks.textContent =
            movement.remarks ||
            '-';

    }


    if (this.elements.inspectorIcon) {

        const icon =
            this.getMovementIcon(
                movement.movement_type
            );


        this.elements.inspectorIcon.innerHTML =
            `<i class="bi ${icon}"></i>`;

    }

},


/*
|--------------------------------------------------------------------------
| Movement Icon
|--------------------------------------------------------------------------
*/

getMovementIcon(
    movementType
) {

    switch (
        String(
            movementType || ''
        ).toLowerCase()
    ) {

        case 'transfer':

            return 'bi-arrow-left-right';


        case 'adjustment':

            return 'bi-sliders';


        case 'purchase':

            return 'bi-cart-plus';


        case 'sale':

            return 'bi-cart-dash';


        case 'return':

            return 'bi-arrow-return-left';


        case 'opening':

            return 'bi-box-arrow-in-down';


        case 'count':

            return 'bi-clipboard-check';


        default:

            return 'bi-box-seam';

    }

},



   /*
|--------------------------------------------------------------------------
| Show Inspector Loading
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Inspector Loading
|--------------------------------------------------------------------------
*/

showInspectorLoading() {

    if (
        this.elements.inspectorLoading
    ) {

        this.elements.inspectorLoading
            .classList
            .remove('d-none');

    }


    if (
        this.elements.inspectorContent
    ) {

        this.elements.inspectorContent
            .classList
            .add('d-none');

    }


    if (
        this.elements.inspectorError
    ) {

        this.elements.inspectorError
            .classList
            .add('d-none');

    }

},

/*
|--------------------------------------------------------------------------
| Inspector Error
|--------------------------------------------------------------------------
*/

showInspectorError(
    message
) {

    if (
        this.elements.inspectorLoading
    ) {

        this.elements.inspectorLoading
            .classList
            .add('d-none');

    }


    if (
        this.elements.inspectorContent
    ) {

        this.elements.inspectorContent
            .classList
            .add('d-none');

    }


    if (
        this.elements.inspectorError
    ) {

        this.elements.inspectorError
            .classList
            .remove('d-none');

    }


    if (
        this.elements.inspectorErrorMessage
    ) {

        this.elements.inspectorErrorMessage
            .textContent =
                message ||
                'Unable to load movement details.';

    }

},

/*
|--------------------------------------------------------------------------
| Hide Inspector Loading
|--------------------------------------------------------------------------
*/

hideInspectorLoading() {

    if (this.elements.inspectorLoading) {

        this.elements.inspectorLoading.classList.add(
            'd-none'
        );

    }


    if (this.elements.inspectorContent) {

        this.elements.inspectorContent.classList.remove(
            'd-none'
        );

    }

},

/*
|--------------------------------------------------------------------------
| Inspector Content
|--------------------------------------------------------------------------
*/

showInspectorContent() {

    if (
        this.elements.inspectorLoading
    ) {

        this.elements.inspectorLoading
            .classList
            .add('d-none');

    }


    if (
        this.elements.inspectorError
    ) {

        this.elements.inspectorError
            .classList
            .add('d-none');

    }


    if (
        this.elements.inspectorContent
    ) {

        this.elements.inspectorContent
            .classList
            .remove('d-none');

    }

},


/*
|--------------------------------------------------------------------------
| Populate Inspector
|--------------------------------------------------------------------------
*/

populateInspector(
    movement
) {

    if (! movement) {

        this.showInspectorError(
            'Movement details are unavailable.'
        );

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Basic Information
    |--------------------------------------------------------------------------
    */

    const movementType =
        movement.movement_type ||
        '-';


    const reference =
        movement.reference_no ||
        '-';


    /*
    |--------------------------------------------------------------------------
    | Reference
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorReference
    ) {

        this.elements.inspectorReference
            .textContent =
                reference;

    }


    /*
    |--------------------------------------------------------------------------
    | Movement Type
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorType
    ) {

        this.elements.inspectorType
            .textContent =
                movementType;

    }


    /*
    |--------------------------------------------------------------------------
    | Movement Icon
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorIcon
    ) {

        let icon =
            'bi-arrow-left-right';


        if (
            movementType ===
            'Transfer Out'
        ) {

            icon =
                'bi-box-arrow-up-right';

        }
        else if (
            movementType ===
            'Transfer In'
        ) {

            icon =
                'bi-box-arrow-in-down';

        }
        else if (
            movementType
                .toLowerCase()
                .includes('adjust')
        ) {

            icon =
                'bi-sliders';

        }
        else if (
            movementType
                .toLowerCase()
                .includes('sale')
        ) {

            icon =
                'bi-cart-check';

        }
        else if (
            movementType
                .toLowerCase()
                .includes('purchase')
        ) {

            icon =
                'bi-bag-check';

        }


        this.elements.inspectorIcon.innerHTML =
            `<i class="bi ${icon}"></i>`;

    }


    /*
    |--------------------------------------------------------------------------
    | Date
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorDate
    ) {

        const formattedDate =
            this.formatDate(
                movement.created_at
            );


        this.elements.inspectorDate
            .textContent =
                formattedDate.date !== '-'
                    ? `${formattedDate.date} ${formattedDate.time}`
                    : '-';

    }


    /*
    |--------------------------------------------------------------------------
    | Transfer Route / Branch
    |--------------------------------------------------------------------------
    */

    const isTransfer =
        [
            'Transfer',
            'Transfer In',
            'Transfer Out',
        ].includes(
            movementType
        );


    if (isTransfer) {

        /*
        |--------------------------------------------------------------------------
        | Show Transfer Route
        |--------------------------------------------------------------------------
        */

        this.elements.inspectorTransferRoute
            ?.classList
            .remove('d-none');


        this.elements.inspectorBranchSection
            ?.classList
            .add('d-none');


        /*
        |--------------------------------------------------------------------------
        | Source
        |--------------------------------------------------------------------------
        */

        const source =
            movement.source_branch?.name ||
            '-';


        if (
            this.elements.inspectorSourceBranch
        ) {

            this.elements.inspectorSourceBranch
                .textContent =
                    source;

        }


        /*
        |--------------------------------------------------------------------------
        | Destination
        |--------------------------------------------------------------------------
        */

        const destination =
            movement.destination_branch?.name ||
            '-';


        if (
            this.elements.inspectorDestinationBranch
        ) {

            this.elements.inspectorDestinationBranch
                .textContent =
                    destination;

        }

    }
    else {

        /*
        |--------------------------------------------------------------------------
        | Normal Branch
        |--------------------------------------------------------------------------
        */

        this.elements.inspectorTransferRoute
            ?.classList
            .add('d-none');


        this.elements.inspectorBranchSection
            ?.classList
            .remove('d-none');


        if (
            this.elements.inspectorBranch
        ) {

            this.elements.inspectorBranch
                .textContent =
                    movement.branch?.name ||
                    '-';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Product
    |--------------------------------------------------------------------------
    */

    const product =
        movement.product ||
        {};


    if (
        this.elements.inspectorProduct
    ) {

        this.elements.inspectorProduct
            .textContent =
                product.name ||
                '-';

    }


    if (
        this.elements.inspectorSku
    ) {

        this.elements.inspectorSku
            .textContent =
                product.sku
                    ? `SKU: ${product.sku}`
                    : '-';

    }


    if (
        this.elements.inspectorCategory
    ) {

        this.elements.inspectorCategory
            .textContent =
                product.category ||
                '-';

    }


    if (
        this.elements.inspectorUnit
    ) {

        this.elements.inspectorUnit
            .textContent =
                product.unit ||
                '-';

    }


    /*
    |--------------------------------------------------------------------------
    | Quantity
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorQuantity
    ) {

        this.elements.inspectorQuantity
            .textContent =
                this.formatNumber(
                    movement.quantity
                );

    }


    /*
    |--------------------------------------------------------------------------
    | Balance After
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorBalance
    ) {

        this.elements.inspectorBalance
            .textContent =
                this.formatNumber(
                    movement.balance_after
                );

    }


    /*
    |--------------------------------------------------------------------------
    | Unit Cost
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorUnitCost
    ) {

        const unitCost =
            parseFloat(
                movement.unit_cost
            ) || 0;


        this.elements.inspectorUnitCost
            .textContent =
                `₦${this.formatNumber(unitCost)}`;

    }


    /*
    |--------------------------------------------------------------------------
    | Created By
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorCreatedBy
    ) {

        this.elements.inspectorCreatedBy
            .textContent =
                movement.created_by?.name ||
                'System';

    }


    /*
    |--------------------------------------------------------------------------
    | Remarks
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorRemarks
    ) {

        this.elements.inspectorRemarks
            .textContent =
                movement.remarks ||
                'No remarks provided.';

    }


    /*
    |--------------------------------------------------------------------------
    | Show Content
    |--------------------------------------------------------------------------
    */

    this.showInspectorContent();

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