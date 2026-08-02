/*
|--------------------------------------------------------------------------
| PRODUCT CATEGORY MODULE
|--------------------------------------------------------------------------
|
| EMNEX POS
| Master Data - Catalog
|
*/


const ProductCategories = {


    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    elements:{},



    modal:null,

    inspector:null,



    /*
    |--------------------------------------------------------------------------
    | Initialize
    |--------------------------------------------------------------------------
    */


    init(){


        this.cacheElements();


        this.bindEvents();


        this.loadStatistics();


    },





    /*
    |--------------------------------------------------------------------------
    | Cache Elements
    |--------------------------------------------------------------------------
    */


    cacheElements(){


        this.elements.categoryForm =
            document.getElementById('categoryForm');


        this.elements.tableWrapper =
            document.getElementById('categoryTableWrapper');


        this.elements.search =
            document.getElementById('categorySearch');


        this.elements.status =
            document.getElementById('categoryStatusFilter');


        this.elements.modal =
            document.getElementById('categoryModal');


        this.elements.inspector =
            document.getElementById('productCategoryInspector');


        this.elements.inspectorContent =
            document.getElementById(
                'productCategoryInspectorContent'
            );


        this.elements.categoryId =
            document.getElementById('categoryId');


        this.elements.categoryCode =
            document.getElementById('categoryCode');


        this.elements.categoryName =
            document.getElementById('categoryName');


        this.elements.categoryDescription =
            document.getElementById(
                'categoryDescription'
            );



        if(this.elements.modal)
        {

            this.modal =
                new bootstrap.Modal(
                    this.elements.modal
                );

        }



        if(this.elements.inspector)
        {

            this.inspector =
                new bootstrap.Offcanvas(
                    this.elements.inspector
                );

        }


    },







    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */


    bindEvents(){



        if(this.elements.categoryForm)
        {

            this.elements.categoryForm
                .addEventListener(
                    'submit',
                    (e)=>{

                        e.preventDefault();

                        this.save();

                    }
                );

        }




        if(this.elements.search)
        {

            this.elements.search
                .addEventListener(
                    'input',
                    ()=>this.loadData()
                );

        }





        if(this.elements.status)
        {

            this.elements.status
                .addEventListener(
                    'change',
                    ()=>this.loadData()
                );

        }



    },







    /*
    |--------------------------------------------------------------------------
    | Load Table
    |--------------------------------------------------------------------------
    */


    async loadData(){


        let search =
            this.elements.search.value;


        let status =
            this.elements.status.value;



        let url =
            `/product-categories?search=${search}&status=${status}`;




        let response =
            await fetch(url,{

                headers:{

                    'X-Requested-With':'XMLHttpRequest',

                    'Accept':'application/json'

                }

            });



        let result =
            await response.json();




        if(result.success)
        {

            this.elements.tableWrapper.innerHTML =
                result.html;


        }



    },







    /*
    |--------------------------------------------------------------------------
    | Statistics
    |--------------------------------------------------------------------------
    */


    async loadStatistics()
{


    let response =
        await fetch(
            '/product-categories/statistics',
            {

                headers:{

                    'Accept':'application/json'

                }

            }
        );



    let result =
        await response.json();



    if(result.success)
    {


        document.getElementById(
            'totalCategories'
        ).innerText =
            result.data.total;



        document.getElementById(
            'activeCategories'
        ).innerText =
            result.data.active;



        document.getElementById(
            'inactiveCategories'
        ).innerText =
            result.data.inactive;


    }


},

    /*
    |--------------------------------------------------------------------------
    | Open Create Modal
    |--------------------------------------------------------------------------
    */


    openCreateModal(){


        this.elements.categoryForm.reset();

        this.elements.categoryId.value='';


        this.generateCode();


        this.modal.show();


    },

    /*
|--------------------------------------------------------------------------
| Generate Category Code
|--------------------------------------------------------------------------
*/

async generateCode()
{


    let response =
        await fetch(
            '/product-categories/next-code',
            {

                headers:{

                    'Accept':'application/json'

                }

            }
        );



    let result =
        await response.json();



    if(result.success)
    {

        this.elements.categoryCode.value =
            result.code;

    }


},

    /*
    |--------------------------------------------------------------------------
    | Edit Category
    |--------------------------------------------------------------------------
    */


    async edit(id)
    {


        let response =
            await fetch(
                `/product-categories/${id}/edit`,
                {

                    headers:{

                        'Accept':'application/json'

                    }

                }
            );



        let result =
            await response.json();



        if(result.success)
        {


            let category =
                result.data;



            this.elements.categoryId.value =
                category.id;


            this.elements.categoryCode.value =
                category.category_code ?? '';



            this.elements.categoryName.value =
                category.name;



            this.elements.categoryDescription.value =
                category.description ?? '';



            this.modal.show();


        }


    },


    /*
    |--------------------------------------------------------------------------
    | Save Category
    |--------------------------------------------------------------------------
    */


    async save()
    {


        let id =
            this.elements.categoryId.value;



        let url =
            id
            ? `/product-categories/${id}`
            : `/product-categories`;



        let method =
            id
            ? 'PUT'
            : 'POST';




        let formData =
            new FormData(
                this.elements.categoryForm
            );



        if(id)
        {

            formData.append(
                '_method',
                'PUT'
            );

        }




        let response =
            await fetch(url,{

                method:'POST',

                headers:{

                    'X-CSRF-TOKEN':
                    document
                    .querySelector(
                        'meta[name="csrf-token"]'
                    )
                    .content,

                    'Accept':
                    'application/json'

                },


                body:formData


            });




        let result =
            await response.json();




        if(result.success)
        {


            showToast(
                result.message,
                'success'
            );


            this.modal.hide();


            this.loadData();

            this.loadStatistics();


        }
        else
        {

            showToast(
                result.message,
                'error'
            );

        }


    },


    /*
|--------------------------------------------------------------------------
| Inspector
|--------------------------------------------------------------------------
*/


async openInspector(id)
{


    this.inspector.show();



    this.elements.inspectorContent.innerHTML = `

        <div class="category-loading">

            <div class="loading-circle">

                <div class="spinner-border"></div>

            </div>


            <h6>
                Loading category details
            </h6>


            <p>
                Please wait...
            </p>


        </div>

    `;



    let response =
        await fetch(
            `/product-categories/${id}/details`,
            {

                headers:{

                    'X-Requested-With':'XMLHttpRequest',

                    'Accept':'application/json'

                }

            }
        );



    let result =
        await response.json();




    if(result.success)
    {


        let category =
            result.data;




        let statusBadge =
            category.status

            ?

            `
            <span class="badge bg-success">
                Active
            </span>
            `

            :

            `
            <span class="badge bg-secondary">
                Disabled
            </span>
            `;



        this.elements.inspectorContent.innerHTML = `



        <!-- Profile Card -->

        <div class="category-profile-card">


            <div class="category-profile-icon">

                <i class="bi bi-grid"></i>

            </div>



            <div>


                <h4>
                    ${category.name}
                </h4>



                <p>
                    ${category.category_code}
                </p>



                ${statusBadge}


            </div>


        </div>





        <!-- Information -->

        <div class="detail-section">


            <h6>

                Category Information

            </h6>



            <div class="detail-item">

                <span>
                    Category Code
                </span>


                <strong>
                    ${category.category_code}
                </strong>

            </div>





            <div class="detail-item">

                <span>
                    Description
                </span>


                <strong>
                    ${category.description ?? '-'}
                </strong>

            </div>





            <div class="detail-item">

                <span>
                    Parent Category
                </span>


                <strong>

                    ${
                        category.parent
                        ?
                        category.parent.name
                        :
                        'Root Category'
                    }

                </strong>

            </div>



        </div>







        <!-- Audit -->

        <div class="detail-section">


            <h6>

                Audit Information

            </h6>





            <div class="detail-item">

                <span>
                    Created By
                </span>


                <strong>

                    ${
                        category.created_by
                        ?
                        category.created_by.first_name 
                        + ' ' +
                        category.created_by.last_name
                        :
                        '-'
                    }

                </strong>


            </div>

            <div class="detail-item">

                <span>
                    Created Date
                </span>


                <strong>

                    ${
                        new Date(category.created_at)
                        .toLocaleDateString()
                    }

                </strong>


            </div>




            <div class="detail-item">

                <span>
                    Last Updated
                </span>


                <strong>

                    ${
                        new Date(category.updated_at)
                        .toLocaleDateString()
                    }

                </strong>


            </div>

            <div class="detail-item">

                <span>
                    Updated By
                </span>


                <strong>

                    ${
                        category.updated_by
                        ?
                        category.updated_by.first_name 
                        + ' ' +
                        category.updated_by.last_name
                        :
                        '-'
                    }

                </strong>


            </div>



        </div>



        `;


    }
    else
    {


        this.elements.inspectorContent.innerHTML = `

            <div class="alert alert-danger">

                Unable to load category details.

            </div>

        `;


    }


},

    openStatusModal(id, action, name)
    {


        document.getElementById(
            'statusCategoryId'
        ).value = id;



        document.getElementById(
            'statusAction'
        ).value = action;



        document.getElementById(
            'statusActionText'
        ).innerHTML = action;



        document.getElementById(
            'statusCategoryName'
        ).innerHTML = name;



        bootstrap.Modal
            .getOrCreateInstance(
                document.getElementById(
                    'categoryStatusModal'
                )
            )
            .show();


    },

    /*
    |--------------------------------------------------------------------------
    | Toggle Status
    |--------------------------------------------------------------------------
    */


    async confirmStatus()
{


    let id =
        document.getElementById(
            'statusCategoryId'
        ).value;



    let response =
        await fetch(
            `/product-categories/${id}/toggle-status`,
            {

                method:'PATCH',

                headers:{

                    'X-Requested-With':'XMLHttpRequest',

                    'Accept':'application/json',

                    'X-CSRF-TOKEN':
                    document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content

                }

            }
        );



    let result =
        await response.json();



    if(result.success)
    {

        showToast(
            result.message,
            'success'
        );


        bootstrap.Modal
            .getInstance(
                document.getElementById(
                    'categoryStatusModal'
                )
            )
            .hide();


        ProductCategories.loadData();
         this.loadStatistics();

    }
    else
    {

        showToast(
            result.message,
            'error'
        );

    }


},


openDeleteModal(id, name)
{


    document.getElementById(
        'deleteCategoryId'
    ).value = id;



    document.getElementById(
        'deleteCategoryName'
    ).innerHTML = name;



    bootstrap.Modal
        .getOrCreateInstance(
            document.getElementById(
                'categoryDeleteModal'
            )
        )
        .show();


},

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */


   async confirmDelete()
{


    let id =
        document.getElementById(
            'deleteCategoryId'
        ).value;



    let response =
        await fetch(
            `/product-categories/${id}`,
            {

                method:'DELETE',

                headers:{

                    'X-Requested-With':'XMLHttpRequest',

                    'Accept':'application/json',

                    'X-CSRF-TOKEN':
                    document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content

                }

            }
        );



    let result =
        await response.json();



    if(result.success)
    {

        showToast(
            result.message,
            'success'
        );


        bootstrap.Modal
            .getInstance(
                document.getElementById(
                    'categoryDeleteModal'
                )
            )
            .hide();


        ProductCategories.loadData();


    }
    else
    {

        showToast(
            result.message,
            'error'
        );

    }


}


};





document.addEventListener(
    'DOMContentLoaded',
    ()=>{

        ProductCategories.init();

    }
);