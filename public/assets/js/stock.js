/*
|--------------------------------------------------------------------------
| EMNEX POS - Stock Module
|--------------------------------------------------------------------------
|
| Handles:
|
| - Stock listing
| - Stock adjustment
| - Product selection
| - Inspector
| - Stock actions
|
|--------------------------------------------------------------------------
*/


const Stock = {


    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */


    searchTimer: null,


    selectedProduct: null,


    selectedStock: null,


    adjustmentModal: null,


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


   
/*
|--------------------------------------------------------------------------
| Cache Elements
|--------------------------------------------------------------------------
*/

cacheElements()
{

    /*
    |--------------------------------------------------------------------------
    | Main Stock Page
    |--------------------------------------------------------------------------
    */

    this.stockTable =
    document.getElementById(
        'stockTableContainer'
    );


    this.stockSearch =
        document.getElementById(
            'stockSearch'
        );


    this.categoryFilter =
        document.getElementById(
            'stockCategoryFilter'
        );


    this.branchFilter =
        document.getElementById(
            'stockBranchFilter'
        );


    this.statusFilter =
        document.getElementById(
            'stockStatusFilter'
        );


    this.pagination =
        document.getElementById(
            'stockPagination'
        );


    /*
    |--------------------------------------------------------------------------
    | Adjustment Button
    |--------------------------------------------------------------------------
    */

    this.openStockAdjustmentBtn =
        document.getElementById(
            'openStockAdjustmentBtn'
        );


    /*
    |--------------------------------------------------------------------------
    | Stock Adjustment Modal
    |--------------------------------------------------------------------------
    */

    this.stockModal =
        document.getElementById(
            'stockAdjustmentModal'
        );


    this.productSearch =
        document.getElementById(
            'stockProductSearch'
        );


    this.productTable =
        document.getElementById(
            'stockProductTable'
        );


    this.productPagination =
        document.getElementById(
            'stockProductPagination'
        );


    this.productCategoryFilter =
        document.getElementById(
            'stockAdjustmentCategoryFilter'
        );


    this.productBranchFilter =
        document.getElementById(
            'stockAdjustmentBranchFilter'
        );


    this.productStatusFilter =
        document.getElementById(
            'stockAdjustmentStatusFilter'
        );


    /*
    |--------------------------------------------------------------------------
    | Selected Product / Adjustment
    |--------------------------------------------------------------------------
    */

    this.productId =
        document.getElementById(
            'stockProductId'
        );


    this.stockBranchId =
        document.getElementById(
            'stockBranchId'
        );


    this.selectedProductName =
        document.getElementById(
            'selectedProductName'
        );


    this.selectedProductInfo =
        document.getElementById(
            'selectedProductInfo'
        );


    this.currentQuantity =
        document.getElementById(
            'currentStockQuantity'
        );


    this.adjustmentType =
        document.getElementById(
            'stockType'
        );


    this.adjustmentQuantity =
        document.getElementById(
            'stockQuantity'
        );


    this.adjustmentRemarks =
        document.getElementById(
            'stockReason'
        );


    this.saveStockBtn =
        document.getElementById(
            'saveStockBtn'
        );


    /*
    |--------------------------------------------------------------------------
    | Inspector
    |--------------------------------------------------------------------------
    */

    this.stockInspector =
        document.getElementById(
            'stockInspector'
        );


    this.stockInspectorName =
        document.getElementById(
            'stockInspectorName'
        );


    this.stockInspectorSku =
        document.getElementById(
            'stockInspectorSku'
        );


    this.stockInspectorBarcode =
        document.getElementById(
            'stockInspectorBarcode'
        );


    this.stockInspectorCategory =
        document.getElementById(
            'stockInspectorCategory'
        );


    this.stockInspectorUnit =
        document.getElementById(
            'stockInspectorUnit'
        );


    this.stockInspectorBranch =
        document.getElementById(
            'stockInspectorBranch'
        );


    this.stockInspectorQuantity =
        document.getElementById(
            'stockInspectorQuantity'
        );


    this.stockInspectorReserved =
        document.getElementById(
            'stockInspectorReserved'
        );


    this.stockInspectorAvailable =
        document.getElementById(
            'stockInspectorAvailable'
        );


    this.stockMovementList =
        document.getElementById(
            'stockMovementList'
        );

},








    /*
    |--------------------------------------------------------------------------
    | Initialize Components
    |--------------------------------------------------------------------------
    */


    initializeComponents()
    {        

        if(this.stockModal)
        {

            this.adjustmentModal =
                new bootstrap.Modal(
                    this.stockModal
                );

        }



        if(this.stockInspector)
        {

            this.inspector =
                new bootstrap.Offcanvas(
                    this.stockInspector
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
    | Main Search
    |--------------------------------------------------------------------------
    */    

    /*
    |--------------------------------------------------------------------------
    | Adjustment Filters
    |--------------------------------------------------------------------------
    */


    this.productSearch?.addEventListener(
        'input',
        () => {


            clearTimeout(
                this.searchTimer
            );


            this.searchTimer =
                setTimeout(
                    () => {

                        this.loadProducts();

                    },
                    400
                );


        }
    );

    this.productCategoryFilter?.addEventListener(
        'change',
        () => {

            this.loadProducts();

        }
    );

    this.productBranchFilter?.addEventListener(
        'change',
        () => {

            this.stockBranchId.value =
                this.productBranchFilter.value;

            this.clearSelection();

            this.loadProducts();

        }
    );


    this.productStatusFilter?.addEventListener(
        'change',
        () => {

            this.loadProducts();

        }
    );

    this.saveStockBtn?.addEventListener(
        'click',
        () => {

            this.saveAdjustment();

        }
    );
    

    /*
    |--------------------------------------------------------------------------
    | Open Stock Adjustment
    |--------------------------------------------------------------------------
    */


    this.openStockAdjustmentBtn?.addEventListener(
        'click',
        () => {
           

            this.openCreateModal();


        }
    );

    /*
    |--------------------------------------------------------------------------
    | Adjustment Form
    |--------------------------------------------------------------------------
    */

    this.adjustmentType?.addEventListener(
        'change',
        () => {

            this.validateAdjustmentForm();

        }
    );


    this.adjustmentQuantity?.addEventListener(
        'input',
        () => {

            this.validateAdjustmentForm();

        }
    );

    this.stockSearch?.addEventListener(
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

        document.addEventListener(
        'click',
        (event)=>{


            const button =
                event.target.closest(
                    '.stock-product-page'
                );


            if(button)
            {


                const page =
                    button.dataset.page;



                if(page)
                {

                    this.loadProducts(page);

                }


            }


        }
    );

    /*
    |--------------------------------------------------------------------------
    | Select Product
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        (event) => {

            const button =
                event.target.closest(
                    '.select-stock-product'
                );

            if(!button)
            {
                return;
            }

            try {

                const product =
                    JSON.parse(
                        button.dataset.product
                    );

                this.selectProduct(
                    product
                );

            }
            catch(error)
            {

                showToast(
                    'Unable to select product.',
                    'error'
                );

            }

        }
    );

    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */


    this.categoryFilter?.addEventListener(
        'change',
        () => this.loadTable()
    );



    this.branchFilter?.addEventListener(
        'change',
        () => this.loadTable()
    );



    this.statusFilter?.addEventListener(
        'change',
        () => this.loadTable()
    );    

    /*
    |--------------------------------------------------------------------------
    | Table Actions
    |--------------------------------------------------------------------------
    */


    document.addEventListener(
        'click',
        (event) => {



            const adjustButton =
                event.target.closest(
                    '.stock-adjust-btn'
                );


            if(adjustButton)
            {

                this.openCreateModal({

                    id:
                        adjustButton.dataset.product,

                    branch_id:
                        adjustButton.dataset.branch,

                    stock_quantity:
                        adjustButton.dataset.quantity,

                });

            }


            const viewButton =
            event.target.closest(
                '.stock-view-btn'
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
                    '.stock-page'
                );



            if(button)
            {


                const page =
                    button.dataset.page;



                if(page)
                {

                    this.loadTable(page);

                }


            }


        }
    );



},

/*
|--------------------------------------------------------------------------
| Load Stock Table
|--------------------------------------------------------------------------
*/


async loadTable(page = 1)
{


    if(!this.stockTable)
    {
        return;
    }



    const params =
        new URLSearchParams({

            page: page,


            search:
                this.stockSearch?.value ?? '',



            category:
                this.categoryFilter?.value ?? '',



            branch:
                this.branchFilter?.value ?? '',



            status:
                this.statusFilter?.value ?? '',


        });





    try {


        const response =
            await fetch(
                `/stock/table?${params.toString()}`
            );



        const result =
            await response.json();





        if(result.success)
        {


            this.stockTable.innerHTML =
                result.html;



            if(this.pagination)
            {

                this.pagination.innerHTML =
                    result.pagination ?? '';

            }



            this.updateKpis(
                result.stats
            );


        }



    }
    catch(error)
    {


        console.error(
            'Stock table error:',
            error
        );


    }


},







/*
|--------------------------------------------------------------------------
| Update KPI Cards
|--------------------------------------------------------------------------
*/


updateKpis(stats)
{


    if(!stats)
    {
        return;
    }



    const total =
        document.getElementById(
            'totalStockCount'
        );



    const low =
        document.getElementById(
            'lowStockCount'
        );



    const out =
        document.getElementById(
            'outOfStockCount'
        );



    const value =
        document.getElementById(
            'stockValue'
        );



    if(total)
    {

        total.innerText =
            stats.total ?? 0;

    }



    if(low)
    {

        low.innerText =
            stats.low ?? 0;

    }



    if(out)
    {

        out.innerText =
            stats.out ?? 0;

    }



    if(value)
    {

        value.innerText =
            stats.value ?? 0;

    }



},

 /*
|--------------------------------------------------------------------------
| Open Inspector
|--------------------------------------------------------------------------
*/

async openInspector(id)
{


    try {


        const response =
        await fetch(
            `/stock/${id}/details`
        );



        const result =
            await response.json();




        if(result.success)
        {


            const stock =
                result.data;



            this.populateInspector(
                stock
            );



            this.inspector?.show();


        }



    }
    catch(error)
    {


        console.error(
            'Inspector error:',
            error
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
        stock.product;





    if(this.stockInspectorName)
    {

        this.stockInspectorName.innerText =
            product.name ?? '-';

    }




    if(this.stockInspectorSku)
    {

        this.stockInspectorSku.innerText =
            product.sku ?? '-';

    }




    if(this.stockInspectorBarcode)
    {

        this.stockInspectorBarcode.innerText =
            product.barcode ?? '-';

    }




    if(this.stockInspectorCategory)
    {

        this.stockInspectorCategory.innerText =
            product.category?.name ?? '-';

    }




    if(this.stockInspectorUnit)
    {

        this.stockInspectorUnit.innerText =
            product.unit?.name ?? '-';

    }





    if(this.stockInspectorBranch)
    {

        this.stockInspectorBranch.innerText =
            stock.branch?.name ?? '-';

    }





    if(this.stockInspectorQuantity)
    {

        this.stockInspectorQuantity.innerText =
            stock.quantity ?? 0;

    }




    if(this.stockInspectorReserved)
    {

        this.stockInspectorReserved.innerText =
            stock.reserved_quantity ?? 0;

    }




    if(this.stockInspectorAvailable)
    {

        this.stockInspectorAvailable.innerText =
            stock.available_quantity ?? 0;

    }





    this.populateMovements(
        stock.movements
    );


},







/*
|--------------------------------------------------------------------------
| Populate Movement History
|--------------------------------------------------------------------------
*/


populateMovements(movements)
{


    if(!this.stockMovementList)
    {
        return;
    }



    if(!movements || movements.length === 0)
    {


        this.stockMovementList.innerHTML =

        `
            <p class="text-muted">

                No movements available.

            </p>
        `;


        return;


    }






    this.stockMovementList.innerHTML =


        movements.slice(0,5)

        .map(
            movement =>


            `

            <div class="stock-movement-item">


                <div>


                    <strong>

                        ${movement.movement_type ?? '-'}

                    </strong>



                    <small class="text-muted d-block">


                        ${movement.user?.name ?? 'System'}


                    </small>


                </div>





                <div class="text-end">


                    <strong>

                        ${movement.quantity ?? 0}

                    </strong>



                    <small class="text-muted d-block">


                        ${movement.stock_before ?? 0}

                        →

                        ${movement.stock_after ?? 0}


                    </small>



                </div>



            </div>


            `
        )

        .join('');



},

/*
|--------------------------------------------------------------------------
| Open Stock Adjustment Modal
|--------------------------------------------------------------------------
*/

async openCreateModal(product = null)
{
    /*
    |--------------------------------------------------------------------------
    | Reset Current Selection
    |--------------------------------------------------------------------------
    */

    this.clearSelection();


    /*
    |--------------------------------------------------------------------------
    | Store Preselected Product
    |--------------------------------------------------------------------------
    */

    if(product)
    {
        this.selectedProduct = product;
    }


    /*
    |--------------------------------------------------------------------------
    | Load Adjustment Filters
    |--------------------------------------------------------------------------
    */

    await this.loadAdjustmentFilters();


    /*
    |--------------------------------------------------------------------------
    | Branch
    |--------------------------------------------------------------------------
    |
    | Branch is now the first required selection.
    |
    */

    if(
        product?.branch_id &&
        this.productBranchFilter
    )
    {
        this.productBranchFilter.value =
            product.branch_id;


        if(this.stockBranchId)
        {
            this.stockBranchId.value =
                product.branch_id;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Load Products
    |--------------------------------------------------------------------------
    */

    await this.loadProducts();


    /*
    |--------------------------------------------------------------------------
    | Show Modal
    |--------------------------------------------------------------------------
    */

    this.adjustmentModal?.show();
},
/*
|--------------------------------------------------------------------------
| Load Products For Adjustment
|--------------------------------------------------------------------------
*/

async loadProducts(page = 1)
{

    if(!this.productTable)
    {
        return;
    }


    const branchId =
        this.productBranchFilter?.value ?? '';

    
    const params =
        new URLSearchParams({

            page: page,

            search:
                this.productSearch?.value ?? '',

            category:
                this.productCategoryFilter?.value ?? '',

            branch:
                branchId,

            status:
                this.productStatusFilter?.value ?? '',

        });


    try
    {

        const response =
            await fetch(
                `/stock/products?${params.toString()}`,
                {
                    headers: {
                        'Accept': 'application/json'
                    }
                }
            );


        const result =
            await response.json();


        if(!result.success)
        {

            showToast(
                result.message ??
                'Unable to load products.',
                'error'
            );

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Product Table
        |--------------------------------------------------------------------------
        */
         
        if(!result.data || result.data.length === 0)
        {

            this.productTable.innerHTML = `

                <tr>

                    <td
                        colspan="5"
                        class="text-center text-muted py-4">

                        <i class="bi bi-box-seam fs-3 d-block mb-2"></i>

                        No products found.

                    </td>

                </tr>

            `;

        }
        else
        {

            this.productTable.innerHTML =

                result.data.map(
                    product => `

                        <tr>

                            <td>

                                <div class="d-flex align-items-center">

                                    <div class="me-3">

                                        <i class="bi bi-box-seam fs-4"></i>

                                    </div>

                                    <div>

                                        <strong>
                                            ${product.name ?? '-'}
                                        </strong>

                                        <small class="d-block text-muted">

                                            SKU:
                                            ${product.sku ?? '-'}

                                        </small>

                                    </div>

                                </div>

                            </td>


                            <td>

                                ${product.category?.name ?? '-'}

                            </td>


                            <td>

                                ${product.unit?.name ?? '-'}

                            </td>


                            <td>

                                ₦${product.selling_price ?? 0}

                            </td>


                            <td>

                                <button

                                    type="button"

                                    class="btn btn-sm btn-primary select-stock-product"

                                    data-product='${JSON.stringify(product)}'>

                                    Select

                                </button>

                            </td>

                        </tr>

                    `
                ).join('');

        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        if(this.productPagination)
        {

            this.productPagination.innerHTML = '';


            if(result.pagination)
            {

                const currentPage =
                    result.pagination.current_page;


                const lastPage =
                    result.pagination.last_page;


                let paginationHtml = '';


                /*
                |--------------------------------------------------------------------------
                | Previous
                |--------------------------------------------------------------------------
                */

                paginationHtml += `

                    <button

                        type="button"

                        class="btn btn-sm btn-outline-secondary stock-product-page me-1"

                        data-page="${currentPage - 1}"

                        ${currentPage <= 1 ? 'disabled' : ''}>

                        <i class="bi bi-chevron-left"></i>

                    </button>

                `;


                /*
                |--------------------------------------------------------------------------
                | Page Numbers
                |--------------------------------------------------------------------------
                */

                for(
                    let pageNumber = 1;
                    pageNumber <= lastPage;
                    pageNumber++
                )
                {

                    paginationHtml += `

                        <button

                            type="button"

                            class="btn btn-sm

                            ${
                                pageNumber === currentPage
                                ? 'btn-primary'
                                : 'btn-outline-secondary'
                            }

                            stock-product-page me-1"

                            data-page="${pageNumber}">

                            ${pageNumber}

                        </button>

                    `;

                }


                /*
                |--------------------------------------------------------------------------
                | Next
                |--------------------------------------------------------------------------
                */

                paginationHtml += `

                    <button

                        type="button"

                        class="btn btn-sm btn-outline-secondary stock-product-page"

                        data-page="${currentPage + 1}"

                        ${currentPage >= lastPage ? 'disabled' : ''}>

                        <i class="bi bi-chevron-right"></i>

                    </button>

                `;


                this.productPagination.innerHTML =
                    paginationHtml;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Preselect Product
        |--------------------------------------------------------------------------
        */

        if(this.selectedProduct)
        {

            this.selectProduct(
                this.selectedProduct
            );

        }

    }
    catch(error)
    {

        console.error(
            'Product loading error:',
            error
        );


        showToast(
            'Unable to load products.',
            'error'
        );

    }

},


/*
|--------------------------------------------------------------------------
| Load Adjustment Filters
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Load Adjustment Filters
|--------------------------------------------------------------------------
*/

async loadAdjustmentFilters()
{

    try
    {

        const response =
            await fetch(
                '/stock/adjustment-filters'
            );


        const result =
            await response.json();


        if(!result.success)
        {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Category Filter
        |--------------------------------------------------------------------------
        */

        if(this.productCategoryFilter)
        {

            this.productCategoryFilter.innerHTML =

            `
                <option value="">
                    All Categories
                </option>

                ${
                    result.categories.map(
                        category => `

                            <option value="${category.id}">

                                ${category.name}

                            </option>

                        `
                    ).join('')
                }

            `;

        }


        /*
        |--------------------------------------------------------------------------
        | Branch Filter
        |--------------------------------------------------------------------------
        */

        if(
            this.productBranchFilter &&
            result.can_manage_all_branches
        )
        {

            this.productBranchFilter.innerHTML =

            `
                <option value="">
                    Select Branch
                </option>

                ${
                    result.branches.map(
                        branch => `

                            <option value="${branch.id}">

                                ${branch.name}

                            </option>

                        `
                    ).join('')
                }

            `;

        }

    }
    catch(error)
    {

        console.error(
            'Adjustment filter error:',
            error
        );

    }

},


/*
|--------------------------------------------------------------------------
| Product Search
|--------------------------------------------------------------------------
*/


searchProducts()
{


    clearTimeout(
        this.searchTimer
    );



    this.searchTimer =
        setTimeout(
            () => {


                this.loadProducts();


            },
            400
        );


},

/*
|--------------------------------------------------------------------------
| Select Product
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Select Product
|--------------------------------------------------------------------------
*/

selectProduct(product)
{
  

    /*
    |--------------------------------------------------------------------------
    | Store Selected Product
    |--------------------------------------------------------------------------
    */

    this.selectedProduct =
        product;


    /*
    |--------------------------------------------------------------------------
    | Product ID
    |--------------------------------------------------------------------------
    */

    if(this.productId)
    {

        this.productId.value =
            product.id ?? '';

    }


    /*
    |--------------------------------------------------------------------------
    | Stock
    |--------------------------------------------------------------------------
    |
    | The controller now returns ONE normalized stock object:
    |
    | product.stock
    |
    | We must NOT use product.stocks here.
    |
    */

    const stock =
        product.stock ?? null;


    /*
    |--------------------------------------------------------------------------
    | Branch ID
    |--------------------------------------------------------------------------
    */

    const branchId =
        product.branch_id ??
        stock?.branch_id ??
        '';   


    /*
    |--------------------------------------------------------------------------
    | Hidden Stock Branch
    |--------------------------------------------------------------------------
    */

    if(this.stockBranchId)
    {

        this.stockBranchId.value =
            branchId;

    }


    /*
    |--------------------------------------------------------------------------
    | Product Name
    |--------------------------------------------------------------------------
    */

    if(this.selectedProductName)
    {

        this.selectedProductName.innerText =
            product.name ??
            'Unknown Product';

    }


    /*
    |--------------------------------------------------------------------------
    | Product Information
    |--------------------------------------------------------------------------
    */

    if(this.selectedProductInfo)
    {

        this.selectedProductInfo.innerHTML = `

            <div>
                <strong>SKU:</strong>
                ${product.sku ?? '-'}
            </div>

            <div>
                <strong>Barcode:</strong>
                ${product.barcode ?? '-'}
            </div>

            <div>
                <strong>Price:</strong>
                ₦${product.selling_price ?? 0}
            </div>

            <div>
                <strong>Branch:</strong>
                ${product.branch?.name ??
                  stock?.branch?.name ??
                  '-'}

            </div>

        `;

    }


    /*
    |--------------------------------------------------------------------------
    | Current Stock
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    |
    | The quantity comes from:
    |
    | product.stock.quantity
    |
    */

    if(this.currentQuantity)
    {

        this.currentQuantity.innerText =
            stock?.quantity ??
            0;

    }


    /*
    |--------------------------------------------------------------------------
    | No Stock Record
    |--------------------------------------------------------------------------
    */

    if(!stock)
    {

        showToast(
            'This product has no stock record for the selected branch.',
            'warning'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Reset Adjustment Fields
    |--------------------------------------------------------------------------
    */

    if(this.adjustmentType)
    {

        this.adjustmentType.value =
            '';

    }


    if(this.adjustmentQuantity)
    {

        this.adjustmentQuantity.value =
            '';

    }


    if(this.adjustmentRemarks)
    {

        this.adjustmentRemarks.value =
            '';

    }


    /*
    |--------------------------------------------------------------------------
    | Validate Adjustment Form
    |--------------------------------------------------------------------------
    */

    this.validateAdjustmentForm();    

},

/*
|--------------------------------------------------------------------------
| Validate Adjustment Form
|--------------------------------------------------------------------------
*/

validateAdjustmentForm()
{

    const productId =
        this.productId?.value;


    const branchId =
        this.stockBranchId?.value;


    const type =
        this.adjustmentType?.value;


    const quantity =
        parseFloat(
            this.adjustmentQuantity?.value
        );


    const hasStock =
        !!(
            this.selectedProduct &&
            this.selectedProduct.stock
        );


    const valid =
        !!productId &&
        !!branchId &&
        !!type &&
        quantity > 0 &&
        hasStock;


    if(this.saveStockBtn)
    {

        this.saveStockBtn.disabled =
            !valid;

    }

},

/*
|--------------------------------------------------------------------------
| Clear Selected Product
|--------------------------------------------------------------------------
*/

clearSelection()
{

    this.selectedProduct =
        null;


    if(this.productId)
    {

        this.productId.value =
            '';

    }


    if(this.stockBranchId)
    {

        this.stockBranchId.value =
            this.productBranchFilter?.value ?? '';

    }


    if(this.selectedProductName)
    {

        this.selectedProductName.innerText =
            'No product selected';

    }


    if(this.selectedProductInfo)
    {

        this.selectedProductInfo.innerHTML =

        `

            <span class="text-muted">

                No product selected

            </span>

        `;

    }


    if(this.currentQuantity)
    {

        this.currentQuantity.value =
            0;

    }


    if(this.adjustmentType)
    {

        this.adjustmentType.value =
            '';

    }


    if(this.adjustmentQuantity)
    {

        this.adjustmentQuantity.value =
            '';

    }


    if(this.adjustmentRemarks)
    {

        this.adjustmentRemarks.value =
            '';

    }


    if(this.saveStockBtn)
    {

        this.saveStockBtn.disabled =
            true;

    }

},

/*
|--------------------------------------------------------------------------
| Save Stock Adjustment
|--------------------------------------------------------------------------
*/

async saveAdjustment()
{  
    /*
    |--------------------------------------------------------------------------
    | Values
    |--------------------------------------------------------------------------
    */

    const productId =
        this.productId?.value;


    const branchId =
        this.stockBranchId?.value;


    const type =
        this.adjustmentType?.value;


    const quantity =
        this.adjustmentQuantity?.value;


    const reason =
        this.adjustmentRemarks?.value ?? '';


    /*
    |--------------------------------------------------------------------------
    | Product Validation
    |--------------------------------------------------------------------------
    */

    if(!productId)
    {

        showToast(
            'Please select a product first.',
            'error'
        );


        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Branch Validation
    |--------------------------------------------------------------------------
    |
    | The branch comes from the selected product stock.
    |
    | It does NOT come from the branch filter dropdown.
    |
    */

    if(!branchId)
    {

        showToast(
            'Unable to determine the stock branch.',
            'error'
        );


        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Adjustment Type
    |--------------------------------------------------------------------------
    */

    if(!type)
    {

        showToast(
            'Please select an adjustment type.',
            'error'
        );


        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Quantity
    |--------------------------------------------------------------------------
    */

    if(
        !quantity ||
        Number(quantity) <= 0
    )
    {

        showToast(
            'Please enter a valid quantity.',
            'error'
        );


        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Build Payload
    |--------------------------------------------------------------------------
    */

    const payload = {

        product_id:
            productId,

        branch_id:
            branchId,

        type:
            type,

        quantity:
            quantity,

        reason:
            reason,

    };   


    /*
    |--------------------------------------------------------------------------
    | Disable Button
    |--------------------------------------------------------------------------
    */

    if(this.saveStockBtn)
    {

        this.saveStockBtn.disabled =
            true;

    }


    try
    {

        const response =
            await fetch(
                '/stock',
                {

                    method: 'POST',

                    headers: {

                        'Content-Type':
                            'application/json',

                        'Accept':
                            'application/json',

                        'X-CSRF-TOKEN':
                            document
                            .querySelector(
                                'meta[name="csrf-token"]'
                            )
                            .content,

                    },

                    body:
                        JSON.stringify(
                            payload
                        )

                }
            );


        const result =
            await response.json();       


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        if(result.success)
        {
            showToast(
                result.message ??
                'Stock adjusted successfully.',
                'success'
            );

            this.adjustmentModal?.hide();

            setTimeout(() => {

                window.location.reload();

            }, 800);
        }
        else
        {

            showToast(
                result.message ??
                'Unable to update stock.',
                'error'
            );

        }

    }
    catch(error)
    {

        console.error(
            'Stock adjustment error:',
            error
        );


        showToast(
            'Something went wrong.',
            'error'
        );

    }
    finally
    {

        if(this.saveStockBtn)
        {

            this.saveStockBtn.disabled =
                false;

        }

    }

},


/*
|--------------------------------------------------------------------------
| Reset Module
|--------------------------------------------------------------------------
*/

reset()
{


    this.clearSelection();


    this.selectedStock =
        null;


},



};

document.addEventListener(
    'DOMContentLoaded',
    () => {        
        Stock.init();

    }
);