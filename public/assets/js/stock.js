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


    cacheElements()
    {


        /*
        |--------------------------------------------------------------------------
        | Main Stock Page
        |--------------------------------------------------------------------------
        */


        this.stockTable =
            document.getElementById(
                'stockTable'
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
        | Adjustment Buttons
        |--------------------------------------------------------------------------
        */


        this.openStockAdjustmentBtn =
            document.getElementById(
                'openStockAdjustmentBtn'
            );

        //     console.log(
        //     'Adjustment Button:',
        //     this.openStockAdjustmentBtn
        // );
        /*
        |--------------------------------------------------------------------------
        | Adjustment Modal
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





        /*
        |--------------------------------------------------------------------------
        | Selected Product
        |--------------------------------------------------------------------------
        */


        this.productId =
            document.getElementById(
                'stockProductId'
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
                'stockAdjustmentType'
            );



        this.adjustmentQuantity =
            document.getElementById(
                'stockAdjustmentQuantity'
            );



        this.adjustmentRemarks =
            document.getElementById(
                'stockAdjustmentRemarks'
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

         console.log(
        'Initializing Components'
    );


    console.log(
        'Stock Modal:',
        this.stockModal
    );

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

    console.log('Stock events binding');
    console.log(
        'Binding adjust button:',
        this.openStockAdjustmentBtn
    );

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

            this.loadProducts();

        }
    );

    this.productStatusFilter?.addEventListener(
        'change',
        () => {

            this.loadProducts();

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


            console.log(
                'TOP ADJUST CLICKED'
            );


            this.openCreateModal();


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
    | Open Adjustment Modal
    |--------------------------------------------------------------------------
    */


    // this.openStockAdjustmentBtn?.addEventListener(
    //     'click',
    //     () => {


    //         this.openCreateModal();


    //     }
    // );

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

                    product_id:
                        adjustButton.dataset.product,


                    branch_id:
                        adjustButton.dataset.branch,


                    quantity:
                        adjustButton.dataset.quantity,


                });


            }







            const viewButton =
                event.target.closest(
                    '.view-stock-btn'
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
                `/stock/details/${id}`
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
    console.log(
    'OPEN CREATE MODAL CALLED'
);

    this.clearSelection();



    if(product)
    {

        this.selectedProduct = product;

    }



    await this.loadAdjustmentFilters();


    await this.loadProducts();

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



    const params =
        new URLSearchParams({

            page: page,


            search:
                this.productSearch?.value ?? '',


            category:
                this.productCategoryFilter?.value ?? '',


            branch:
                this.productBranchFilter?.value ?? '',


        });





    try
    {


        const response =
            await fetch(
                `/stock/products?${params.toString()}`
            );



        const result =
            await response.json();





        if(result.success)
        {


            this.productTable.innerHTML =


                result.data.map(product => `

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

                                data-product='${JSON.stringify(product)}'

                            >

                                Select

                            </button>


                        </td>



                    </tr>


                `).join('');





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
                    | Previous
                    */

                    paginationHtml += `

                        <button

                            type="button"

                            class="btn btn-sm btn-outline-secondary stock-product-page me-1"

                            data-page="${currentPage - 1}"

                            ${currentPage <= 1 ? 'disabled' : ''}

                        >

                            <i class="bi bi-chevron-left"></i>

                        </button>

                    `;
                    /*
                    | Page Numbers
                    */

                    for(
                        let page = 1;
                        page <= lastPage;
                        page++
                    )
                    {


                        paginationHtml += `


                            <button

                                type="button"

                                class="btn btn-sm 

                                ${
                                    page === currentPage

                                    ?

                                    'btn-primary'

                                    :

                                    'btn-outline-secondary'

                                }

                                stock-product-page me-1"


                                data-page="${page}"

                            >

                                ${page}

                            </button>


                        `;


                    }

                    /*
                    | Next
                    */

                    paginationHtml += `


                        <button

                            type="button"

                            class="btn btn-sm btn-outline-secondary stock-product-page"

                            data-page="${currentPage + 1}"

                            ${currentPage >= lastPage ? 'disabled' : ''}

                        >

                            <i class="bi bi-chevron-right"></i>

                        </button>


                    `;




                    this.productPagination.innerHTML =
                        paginationHtml;


                }


            }

            /*
            |--------------------------------------------------------------------------
            | Preselect Product From Dropdown
            |--------------------------------------------------------------------------
            */


            if(this.selectedProduct)
            {


                this.selectProduct(
                    this.selectedProduct
                );


            }



        }


    }
    catch(error)
    {


        console.error(
            'Product loading error:',
            error
        );


    }



},


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


        console.log(
            'Category Filter:',
            this.productCategoryFilter
        );


        console.log(
            'Branch Filter:',
            this.productBranchFilter
        );
        this.productCategoryFilter.innerHTML =
        `
            <option value="">
                All Categories
            </option>

            ${
                result.categories.map(category => `

                    <option value="${category.id}">

                        ${category.name}

                    </option>


                `).join('')
            }

        `;



        this.productBranchFilter.innerHTML =
        `
            <option value="">
                All Branches
            </option>

            ${
                result.branches.map(branch => `

                    <option value="${branch.id}">

                        ${branch.name}

                    </option>


                `).join('')
            }

        `;



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


selectProduct(product)
{


    this.selectedProduct =
        product;




    if(this.productId)
    {

        this.productId.value =
            product.id;

    }





    if(this.selectedProductName)
    {

        this.selectedProductName.innerText =
            product.name ?? '-';

    }





    if(this.selectedProductInfo)
    {


        this.selectedProductInfo.innerHTML =

        `
            <div>
                <strong>
                    SKU:
                </strong>

                ${product.sku ?? '-'}
            </div>


            <div>
                <strong>
                    Barcode:
                </strong>

                ${product.barcode ?? '-'}
            </div>


            <div>
                <strong>
                    Price:
                </strong>

                ${product.selling_price ?? 0}
            </div>
        `;


    }





    if(this.currentQuantity)
    {

        this.currentQuantity.value =
            product.stock_quantity ?? 0;

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

        this.productId.value = '';

    }




    if(this.selectedProductName)
    {

        this.selectedProductName.innerText =
            'Select Product';

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



},

/*
|--------------------------------------------------------------------------
| Save Stock Adjustment
|--------------------------------------------------------------------------
*/

async saveAdjustment()
{


    const productId =
        this.productId?.value;



    if(!productId)
    {

        showToast(
            'Please select a product first.',
            'error'
        );


        return;

    }




    const payload = {


        product_id:
            productId,


        adjustment_type:
            this.adjustmentType?.value,


        quantity:
            this.adjustmentQuantity?.value,


        remarks:
            this.adjustmentRemarks?.value ?? '',


    };





    try
    {


        const response =
            await fetch(
                '/stock/store',
                {


                    method:'POST',


                    headers:{


                        'Content-Type':
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






        if(result.success)
        {


            showToast(
                result.message ??
                'Stock updated successfully.',
                'success'
            );



            this.adjustmentModal?.hide();



            this.clearSelection();



            this.loadTable();



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