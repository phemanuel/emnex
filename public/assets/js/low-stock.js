/*
|--------------------------------------------------------------------------
| EMNEX POS - Low Stock Module
|--------------------------------------------------------------------------
|
| Handles:
|
| - Low stock listing
| - Search
| - Category filter
| - Branch filter
| - Pagination
| - Stock details inspector
|
|--------------------------------------------------------------------------
*/


const LowStock = {


    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    searchTimer: null,

    inspector: null,



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


    },



    /*
    |--------------------------------------------------------------------------
    | Cache Elements
    |--------------------------------------------------------------------------
    */

    cacheElements()
    {

        /*
        |--------------------------------------------------------------------------
        | Table
        |--------------------------------------------------------------------------
        */

        this.table =
            document.getElementById(
                'lowStockTableContainer'
            );


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        this.search =
            document.getElementById(
                'lowStockSearch'
            );


        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */

        this.categoryFilter =
            document.getElementById(
                'lowStockCategoryFilter'
            );


        this.branchFilter =
            document.getElementById(
                'lowStockBranchFilter'
            );

        this.statusFilter =
            document.getElementById(
                'lowStockStatusFilter'
            );


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        this.pagination =
            document.getElementById(
                'lowStockPagination'
            );


        /*
        |--------------------------------------------------------------------------
        | Inspector
        |--------------------------------------------------------------------------
        */

        this.inspectorElement =
            document.getElementById(
                'lowStockInspector'
            );


        this.inspectorName =
            document.getElementById(
                'lowStockInspectorName'
            );


        this.inspectorSku =
            document.getElementById(
                'lowStockInspectorSku'
            );


        this.inspectorBarcode =
            document.getElementById(
                'lowStockInspectorBarcode'
            );


        this.inspectorCategory =
            document.getElementById(
                'lowStockInspectorCategory'
            );


        this.inspectorUnit =
            document.getElementById(
                'lowStockInspectorUnit'
            );


        this.inspectorBranch =
            document.getElementById(
                'lowStockInspectorBranch'
            );


        this.inspectorQuantity =
            document.getElementById(
                'lowStockInspectorQuantity'
            );


        this.inspectorReserved =
            document.getElementById(
                'lowStockInspectorReserved'
            );


        this.inspectorAvailable =
            document.getElementById(
                'lowStockInspectorAvailable'
            );


        this.inspectorReorder =
            document.getElementById(
                'lowStockInspectorReorder'
            );


        this.inspectorMovementList =
            document.getElementById(
                'lowStockMovementList'
            );

    },



    /*
    |--------------------------------------------------------------------------
    | Initialize Components
    |--------------------------------------------------------------------------
    */

    initializeComponents()
    {

        if(this.inspectorElement)
        {

            this.inspector =
                new bootstrap.Offcanvas(
                    this.inspectorElement
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

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        this.search?.addEventListener(
            'input',
            () => {

                clearTimeout(
                    this.searchTimer
                );


                this.searchTimer =
                    setTimeout(
                        () => {

                            this.loadTable();

                        },
                        400
                    );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Category Filter
        |--------------------------------------------------------------------------
        */

        this.categoryFilter?.addEventListener(
            'change',
            () => {

                this.loadTable();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Branch Filter
        |--------------------------------------------------------------------------
        */

        this.branchFilter?.addEventListener(
            'change',
            () => {

                this.loadTable();

            }
        );

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        this.statusFilter?.addEventListener(
                'change',
                () => {

                    this.loadTable();

                }
            );


        /*
        |--------------------------------------------------------------------------
        | Table Actions
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            (event) => {

                const viewButton =
                    event.target.closest(
                        '.low-stock-view-btn'
                    );


                if(viewButton)
                {

                    this.openInspector(
                        viewButton.dataset.id
                    );

                }

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
                        '.low-stock-page'
                    );


                if(!button)
                {
                    return;
                }


                const page =
                    button.dataset.page;


                if(page)
                {

                    this.loadTable(page);

                }

            }
        );

    },



    /*
    |--------------------------------------------------------------------------
    | Load Low Stock Table
    |--------------------------------------------------------------------------
    */

    async loadTable(page = 1)
    {

        if(!this.table)
        {
            return;
        }


        const params =
            new URLSearchParams({

                page: page,

                search:
                    this.search?.value ?? '',

                category:
                    this.categoryFilter?.value ?? '',

                branch:
                    this.branchFilter?.value ?? '',

                status:
                     this.statusFilter?.value ?? '',

            });


        /*
        |--------------------------------------------------------------------------
        | Loading State
        |--------------------------------------------------------------------------
        */

        this.showLoading();


        try
        {

            const response =
                await fetch(
                    `/low-stock/table?${params.toString()}`,
                    {
                        headers: {

                            'Accept':
                                'application/json',

                        }
                    }
                );


            const result =
                await response.json();


            /*
            |--------------------------------------------------------------------------
            | Permission / Server Error
            |--------------------------------------------------------------------------
            */

            if(
                response.status === 403 ||
                !result.success
            )
            {

                this.showError(
                    result.message ??
                    'Unable to load low stock.'
                );


                return;

            }


            /*
            |--------------------------------------------------------------------------
            | Table
            |--------------------------------------------------------------------------
            */

            this.table.innerHTML =
                result.html ?? '';


            /*
            |--------------------------------------------------------------------------
            | Pagination
            |--------------------------------------------------------------------------
            */

            if(this.pagination)
            {

                this.pagination.innerHTML =
                    result.pagination ?? '';

            }


            /*
            |--------------------------------------------------------------------------
            | Update Statistics
            |--------------------------------------------------------------------------
            */

            this.updateStats(
                result.stats
            );

        }
        catch(error)
        {

            console.error(
                'Low stock table error:',
                error
            );


            this.showError(
                'Unable to load low stock records.'
            );

        }

    },



    /*
    |--------------------------------------------------------------------------
    | Update Statistics
    |--------------------------------------------------------------------------
    */

    updateStats(stats)
    {

        if(!stats)
        {
            return;
        }


        const total =
            document.getElementById(
                'lowStockTotal'
            );


        const critical =
            document.getElementById(
                'lowStockCritical'
            );


        const out =
            document.getElementById(
                'lowStockOut'
            );


        if(total)
        {

            total.innerText =
                stats.total ?? 0;

        }


        if(critical)
        {

            critical.innerText =
                stats.critical ?? 0;

        }


        if(out)
        {

            out.innerText =
                stats.out ?? 0;

        }

    },



    /*
    |--------------------------------------------------------------------------
    | Loading State
    |--------------------------------------------------------------------------
    */

    showLoading()
    {

        if(!this.table)
        {
            return;
        }


        this.table.innerHTML = `

            <div class="low-stock-loading">

                <div class="spinner-border"
                     role="status">

                    <span class="visually-hidden">
                        Loading...
                    </span>

                </div>

                <span>
                    Loading low stock records...
                </span>

            </div>

        `;

    },



    /*
    |--------------------------------------------------------------------------
    | Error State
    |--------------------------------------------------------------------------
    */

    showError(message)
    {

        if(!this.table)
        {
            return;
        }


        this.table.innerHTML = `

            <div class="low-stock-error">

                <div class="low-stock-error-icon">

                    <i class="bi bi-exclamation-triangle"></i>

                </div>

                <h6>
                    Unable to load stock
                </h6>

                <p>
                    ${message}
                </p>

                <button
                    type="button"
                    class="btn btn-sm btn-primary"
                    onclick="LowStock.loadTable()"
                >

                    <i class="bi bi-arrow-clockwise me-1"></i>

                    Try Again

                </button>

            </div>

        `;

    },



    /*
    |--------------------------------------------------------------------------
    | Open Inspector
    |--------------------------------------------------------------------------
    */

    async openInspector(id)
    {

        if(!id)
        {
            return;
        }


        try
        {

            const response =
                await fetch(
                    `/low-stock/${id}/details`,
                    {
                        headers: {

                            'Accept':
                                'application/json',

                        }
                    }
                );


            const result =
                await response.json();


            if(
                response.status === 403 ||
                !result.success
            )
            {

                showToast(
                    result.message ??
                    'Unable to view stock details.',
                    'error'
                );


                return;

            }


            this.populateInspector(
                result.data
            );


            this.inspector?.show();

        }
        catch(error)
        {

            console.error(
                'Low stock inspector error:',
                error
            );


            showToast(
                'Unable to load stock details.',
                'error'
            );

        }

    },



    /*
    |--------------------------------------------------------------------------
    | Populate Inspector
    |--------------------------------------------------------------------------
    */

    populateInspector(stock)
    {

        const product =
            stock.product ?? {};


        /*
        |--------------------------------------------------------------------------
        | Product Name
        |--------------------------------------------------------------------------
        */

        if(this.inspectorName)
        {

            this.inspectorName.innerText =
                product.name ?? '-';

        }


        /*
        |--------------------------------------------------------------------------
        | SKU
        |--------------------------------------------------------------------------
        */

        if(this.inspectorSku)
        {

            this.inspectorSku.innerText =
                product.sku ?? '-';

        }


        /*
        |--------------------------------------------------------------------------
        | Barcode
        |--------------------------------------------------------------------------
        */

        if(this.inspectorBarcode)
        {

            this.inspectorBarcode.innerText =
                product.barcode ?? '-';

        }


        /*
        |--------------------------------------------------------------------------
        | Category
        |--------------------------------------------------------------------------
        */

        if(this.inspectorCategory)
        {

            this.inspectorCategory.innerText =
                product.category?.name ?? '-';

        }


        /*
        |--------------------------------------------------------------------------
        | Unit
        |--------------------------------------------------------------------------
        */

        if(this.inspectorUnit)
        {

            this.inspectorUnit.innerText =
                product.unit?.name ?? '-';

        }


        /*
        |--------------------------------------------------------------------------
        | Branch
        |--------------------------------------------------------------------------
        */

        if(this.inspectorBranch)
        {

            this.inspectorBranch.innerText =
                stock.branch?.name ?? '-';

        }


        /*
        |--------------------------------------------------------------------------
        | Quantity
        |--------------------------------------------------------------------------
        */

        if(this.inspectorQuantity)
        {

            this.inspectorQuantity.innerText =
                stock.quantity ?? 0;

        }


        /*
        |--------------------------------------------------------------------------
        | Reserved
        |--------------------------------------------------------------------------
        */

        if(this.inspectorReserved)
        {

            this.inspectorReserved.innerText =
                stock.reserved_quantity ?? 0;

        }


        /*
        |--------------------------------------------------------------------------
        | Available
        |--------------------------------------------------------------------------
        */

        if(this.inspectorAvailable)
        {

            this.inspectorAvailable.innerText =
                stock.available_quantity ?? 0;

        }


        /*
        |--------------------------------------------------------------------------
        | Reorder Level
        |--------------------------------------------------------------------------
        */

        if(this.inspectorReorder)
        {

            this.inspectorReorder.innerText =
                stock.reorder_level ?? 0;

        }


        /*
        |--------------------------------------------------------------------------
        | Movement History
        |--------------------------------------------------------------------------
        */

        this.populateMovements(
            stock.movements ?? []
        );

    },



    /*
    |--------------------------------------------------------------------------
    | Populate Movement History
    |--------------------------------------------------------------------------
    */

    populateMovements(movements)
    {

        if(!this.inspectorMovementList)
        {
            return;
        }


        if(
            !movements ||
            movements.length === 0
        )
        {

            this.inspectorMovementList.innerHTML = `

                <div class="low-stock-empty-movements">

                    <i class="bi bi-clock-history"></i>

                    <span>
                        No movements available.
                    </span>

                </div>

            `;


            return;

        }


        this.inspectorMovementList.innerHTML =

            movements
                .slice(0, 10)
                .map(
                    movement => {

                        const quantity =
                            Number(
                                movement.quantity ?? 0
                            );


                        const movementType =
                            movement.movement_type ??
                            '-';


                        const user =
                            movement.user?.name ??
                            'System';


                        return `

                            <div class="low-stock-movement-item">

                                <div>

                                    <strong>

                                        ${movementType}

                                    </strong>

                                    <small class="text-muted d-block">

                                        ${user}

                                    </small>

                                </div>


                                <div class="text-end">

                                    <strong>

                                        ${quantity.toFixed(2)}

                                    </strong>


                                    <small class="text-muted d-block">

                                        ${
                                            movement.stock_before ??
                                            0
                                        }

                                        →

                                        ${
                                            movement.stock_after ??
                                            0
                                        }

                                    </small>

                                </div>

                            </div>

                        `;

                    }
                )
                .join('');

    },



    /*
    |--------------------------------------------------------------------------
    | Reset Filters
    |--------------------------------------------------------------------------
    */

    resetFilters()
    {

        if(this.search)
        {

            this.search.value =
                '';

        }


        if(this.categoryFilter)
        {

            this.categoryFilter.value =
                '';

        }


        if(this.branchFilter)
        {

            this.branchFilter.value =
                '';

        }


        this.loadTable();

    },



    /*
    |--------------------------------------------------------------------------
    | Refresh
    |--------------------------------------------------------------------------
    */

    refresh()
    {

        this.loadTable();

    },



};



/*
|--------------------------------------------------------------------------
| DOM Ready
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    () => {

        LowStock.init();

    }
);