/*
|--------------------------------------------------------------------------
| EMNEX POS
|--------------------------------------------------------------------------
| Product Management
|--------------------------------------------------------------------------
*/

const Products = {

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    currentId: null,

    csrfToken: null,

    modal: null,

    inspector: null,

    statusModal: null,

    deleteModal: null,

    elements: {},

    imagePlaceholder: '/assets/images/no-image.png',


    /*
    |--------------------------------------------------------------------------
    | Initialize
    |--------------------------------------------------------------------------
    */

    init()
    {

        this.csrfToken =
            document.querySelector(
                'meta[name="csrf-token"]'
            )?.getAttribute('content');


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

        this.elements = {

            table:
                document.getElementById(
                    'products-table-container'
                ),

            search:
                document.getElementById(
                    'product-search'
                ),

            statusFilter:
                document.getElementById(
                    'product-status-filter'
                ),

            form:
                document.getElementById(
                    'productForm'
                ),

            modalTitle:
                document.getElementById(
                    'productModalTitle'
                ),

            saveButton:
                document.getElementById(
                    'saveProductBtn'
                ),

            productId:
                document.getElementById(
                    'product_id'
                ),

            productCode:
                document.getElementById(
                    'product_code'
                ),

            image:
                document.getElementById(
                    'image'
                ),

            imagePreview:
                document.getElementById(
                    'product-image-preview'
                ),

            status:
                document.getElementById(
                    'status'
                ),

            statusProductId:
                document.getElementById(
                    'statusProductId'
                ),

            confirmStatusBtn:
                document.getElementById(
                    'confirmStatusBtn'
                ),

            deleteProductId:
                document.getElementById(
                    'deleteProductId'
                ),

            confirmDeleteBtn:
                document.getElementById(
                    'confirmDeleteBtn'
                ),

            inspector:{

                image:
                    document.getElementById('inspector-image'),

                name:
                    document.getElementById('inspector-name'),

                code:
                    document.getElementById('inspector-product-code'),

                status:
                    document.getElementById('inspector-status'),

                sku:
                    document.getElementById('inspector-sku'),

                barcode:
                    document.getElementById('inspector-barcode'),

                qr:
                    document.getElementById('inspector-qr-code'),

                description:
                    document.getElementById('inspector-description'),

                category:
                    document.getElementById('inspector-category'),

                unit:
                    document.getElementById('inspector-unit'),

                tax:
                    document.getElementById('inspector-tax-rate'),

                discount:
                    document.getElementById('inspector-discount'),

                brand:
                    document.getElementById('inspector-brand'),

                manufacturer:
                    document.getElementById('inspector-manufacturer'),

                cost:
                    document.getElementById('inspector-cost-price'),

                selling:
                    document.getElementById('inspector-selling-price'),

                profit:
                    document.getElementById('inspector-profit'),

                margin:
                    document.getElementById('inspector-margin'),

                stock:
                    document.getElementById('inspector-stock'),

                stockStatus:
                    document.getElementById('inspector-stock-status'),

                minimum:
                    document.getElementById('inspector-minimum-stock'),

                maximum:
                    document.getElementById('inspector-maximum-stock'),

                weight:
                    document.getElementById('inspector-weight'),

                expiry:
                    document.getElementById('inspector-expiry-date'),

                created:
                    document.getElementById('inspector-created'),

                updated:
                    document.getElementById('inspector-updated')

            }

        };

    },


    /*
    |--------------------------------------------------------------------------
    | Bootstrap Components
    |--------------------------------------------------------------------------
    */

    initializeComponents()
    {

        this.modal =
            new bootstrap.Modal(
                document.getElementById(
                    'productModal'
                )
            );

        this.inspector =
            new bootstrap.Offcanvas(
                document.getElementById(
                    'productInspector'
                )
            );

        this.statusModal =
            new bootstrap.Modal(
                document.getElementById(
                    'productStatusModal'
                )
            );

        this.deleteModal =
            new bootstrap.Modal(
                document.getElementById(
                    'productDeleteModal'
                )
            );

    },


    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

    bindEvents()
    {

        if(this.elements.search)
        {

            let timer;

            this.elements.search.addEventListener(
                'keyup',
                () => {

                    clearTimeout(timer);

                    timer = setTimeout(() => {

                        this.loadTable();

                    },300);

                }
            );

        }



        if(this.elements.statusFilter)
        {

            this.elements.statusFilter.addEventListener(
                'change',
                () => this.loadTable()
            );

        }



        if(this.elements.form)
        {

            this.elements.form.addEventListener(
                'submit',
                e => {

                    e.preventDefault();

                    this.save();

                }
            );

        }



        if(this.elements.image)
        {

            this.elements.image.addEventListener(
                'change',
                e => this.previewImage(e)
            );

        }



        if(this.elements.confirmStatusBtn)
        {

            this.elements.confirmStatusBtn.addEventListener(
                'click',
                () => this.toggleStatus()
            );

        }



        if(this.elements.confirmDeleteBtn)
        {

            this.elements.confirmDeleteBtn.addEventListener(
                'click',
                () => this.delete()
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | AJAX Table
    |--------------------------------------------------------------------------
    */

    async loadTable(page = null)
    {

        try{

            let url =
                '/products/table?';

            if(page)
            {

                url += 'page=' + page + '&';

            }

            url +=
                'search=' +
                encodeURIComponent(
                    this.elements.search.value
                );

            url +=
                '&status=' +
                encodeURIComponent(
                    this.elements.statusFilter.value
                );


            let response =
                await fetch(url,{

                    headers:{
                        'X-Requested-With':'XMLHttpRequest'
                    }

                });


            this.elements.table.innerHTML =
                await response.text();

            this.bindPagination();

        }
        catch(error)
        {

            console.error(error);

            showToast(
                'Unable to load products.',
                'danger'
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    bindPagination()
    {

        document
            .querySelectorAll(
                '.pagination a'
            )
            .forEach(link=>{

                link.onclick = e=>{

                    e.preventDefault();

                    let url =
                        new URL(link.href);

                    this.loadTable(
                        url.searchParams.get('page')
                    );

                };

            });

    },

        /*
    |--------------------------------------------------------------------------
    | Open Create Modal
    |--------------------------------------------------------------------------
    */

    async openCreateModal()
    {

        this.currentId = null;

        this.resetForm();

        this.elements.modalTitle.textContent =
            'New Product';

        this.elements.saveButton.innerHTML =
            '<i class="bi bi-check-circle me-2"></i> Save Product';

        await this.generateCode();

        this.modal.show();

    },


    /*
    |--------------------------------------------------------------------------
    | Reset Form
    |--------------------------------------------------------------------------
    */

    resetForm()
    {

        this.elements.form.reset();

        this.elements.productId.value = '';

        this.clearValidation();

        /*
        |--------------------------------------------------------------------------
        | Reset Image Preview
        |--------------------------------------------------------------------------
        */

        if(this.elements.image)
        {
            this.elements.image.value = '';
        }

        if(this.elements.imagePreview)
        {
            this.elements.imagePreview.src =
                this.imagePlaceholder;
        }

        /*
        |--------------------------------------------------------------------------
        | Default Status
        |--------------------------------------------------------------------------
        */

        if(this.elements.status)
        {
            this.elements.status.checked = true;
        }

        /*
        |--------------------------------------------------------------------------
        | First Tab
        |--------------------------------------------------------------------------
        */

        document
            .querySelector(
                '#general-tab'
            )
            ?.classList.add(
                'show',
                'active'
            );

        document
            .querySelectorAll(
                '.product-tabs .nav-link'
            )
            .forEach(tab=>{

                tab.classList.remove(
                    'active'
                );

            });

        document
            .querySelector(
                '.product-tabs .nav-link'
            )
            ?.classList.add(
                'active'
            );

    },


    /*
    |--------------------------------------------------------------------------
    | Generate Product Code
    |--------------------------------------------------------------------------
    */

    async generateCode()
    {

        try{

            let response =
                await fetch(
                    '/products/next-code',
                    {
                        headers:{
                            Accept:'application/json'
                        }
                    }
                );

            let result =
                await response.json();

            if(result.success)
            {
                this.elements.productCode.value =
                    result.code;
            }

        }
        catch(error)
        {

            console.error(error);

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Image Preview
    |--------------------------------------------------------------------------
    */

    previewImage(event)
    {

        const file =
            event.target.files[0];

        if(!file)
        {
            return;
        }

        const reader =
            new FileReader();

        reader.onload = e=>{

            this.elements.imagePreview.src =
                e.target.result;

        };

        reader.readAsDataURL(file);

    },


    /*
    |--------------------------------------------------------------------------
    | Save Product
    |--------------------------------------------------------------------------
    */

    async save()
    {

        try{

            this.setLoading(true);

            this.clearValidation();

            const formData =
                new FormData(
                    this.elements.form
                );

            let url =
                '/products';

            let method =
                'POST';

            /*
            |--------------------------------------------------------------------------
            | Update
            |--------------------------------------------------------------------------
            */

            if(this.elements.productId.value)
            {

                url +=
                    '/' +
                    this.elements.productId.value;

                formData.append(
                    '_method',
                    'PUT'
                );

            }

            let response =
                await fetch(url,{

                    method:method,

                    headers:{

                        'X-CSRF-TOKEN':
                            this.csrfToken,

                        Accept:
                            'application/json'

                    },

                    body:formData

                });

            let result =
                await response.json();

            this.setLoading(false);

            /*
            |--------------------------------------------------------------------------
            | Validation Errors
            |--------------------------------------------------------------------------
            */

            if(response.status===422)
            {

                this.showValidationErrors(
                    result.errors
                );

                return;

            }

            /*
            |--------------------------------------------------------------------------
            | Failed
            |--------------------------------------------------------------------------
            */

            if(!result.success)
            {

                showToast(
                    result.message,
                    result.type
                );

                return;

            }

            /*
            |--------------------------------------------------------------------------
            | Success
            |--------------------------------------------------------------------------
            */

            this.modal.hide();

            this.loadTable();

            showToast(
                result.message,
                result.type
            );

        }
        catch(error)
        {

            this.setLoading(false);

            console.error(error);

            showToast(
                'Something went wrong.',
                'danger'
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Loading State
    |--------------------------------------------------------------------------
    */

    setLoading(state)
    {

        if(state)
        {

            this.elements.saveButton.disabled =
                true;

            this.elements.saveButton.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

        }
        else
        {

            this.elements.saveButton.disabled =
                false;

            this.elements.saveButton.innerHTML =

                this.elements.productId.value

                ? '<i class="bi bi-check-circle me-2"></i> Update Product'

                : '<i class="bi bi-check-circle me-2"></i> Save Product';

        }

    },

        /*
    |--------------------------------------------------------------------------
    | Edit Product
    |--------------------------------------------------------------------------
    */

    async edit(id)
    {

        try{

            this.resetForm();

            this.currentId = id;

            let response =
                await fetch(
                    '/products/' + id + '/edit',
                    {
                        headers:{
                            Accept:'application/json'
                        }
                    }
                );

            let result =
                await response.json();

            if(!result.success)
            {

                showToast(
                    result.message,
                    result.type
                );

                return;

            }

            this.populateForm(result.data);

            this.elements.modalTitle.textContent =
                'Edit Product';

            this.elements.saveButton.innerHTML =
                '<i class="bi bi-check-circle me-2"></i> Update Product';

            this.modal.show();

        }
        catch(error)
        {

            console.error(error);

            showToast(
                'Unable to load product.',
                'danger'
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Populate Form
    |--------------------------------------------------------------------------
    */

    populateForm(product)
    {

        this.elements.productId.value =
            product.id;

        Object.keys(product).forEach(key=>{

            let field =
                document.getElementById(key);

            if(!field)
            {
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | NEVER SET FILE INPUT
            |--------------------------------------------------------------------------
            */

            if(field.type === 'file')
            {
                return;
            }

            if(field.type === 'checkbox')
            {

                field.checked =
                    Boolean(product[key]);

                return;

            }

            field.value =
                product[key] ?? '';

        });

        /*
        |--------------------------------------------------------------------------
        | Image Preview
        |--------------------------------------------------------------------------
        */

        if(product.image_url)
        {

            this.elements.imagePreview.src =
                product.image_url;

        }
        else
        {

            this.elements.imagePreview.src =
                this.imagePlaceholder;

        }

        /*
        |--------------------------------------------------------------------------
        | Always clear file input
        |--------------------------------------------------------------------------
        */

        if(this.elements.image)
        {

            this.elements.image.value = '';

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Inspector
    |--------------------------------------------------------------------------
    */

    async openInspector(id)
    {

        try{

            let response =
                await fetch(
                    '/products/' + id + '/details',
                    {
                        headers:{
                            Accept:'application/json'
                        }
                    }
                );

            let result =
                await response.json();

            if(!result.success)
            {

                showToast(
                    result.message,
                    result.type
                );

                return;

            }

            this.populateInspector(
                result.data
            );

            this.inspector.show();

        }
        catch(error)
        {

            console.error(error);

            showToast(
                'Unable to load product details.',
                'danger'
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Populate Inspector
    |--------------------------------------------------------------------------
    */

    populateInspector(product)
    {

        const i =
            this.elements.inspector;

        i.image.src =
            product.image_url;

        i.name.textContent =
            product.name ?? '-';

        i.code.textContent =
            product.product_code ?? '-';

        i.status.innerHTML =
            product.status

            ? '<span class="badge bg-success">Active</span>'

            : '<span class="badge bg-danger">Inactive</span>';

        i.sku.textContent =
            product.sku ?? '-';

        i.barcode.textContent =
            product.barcode ?? '-';

        i.qr.textContent =
            product.qr_code ?? '-';

        i.description.textContent =
            product.description ?? '-';

        i.category.textContent =
            product.category ?? '-';

        i.unit.textContent =
            product.unit ?? '-';

        i.tax.textContent =
            product.tax_rate ?? '-';

        i.discount.textContent =
            product.discount ?? '-';

        i.brand.textContent =
            product.brand ?? '-';

        i.manufacturer.textContent =
            product.manufacturer ?? '-';

        i.cost.textContent =
            product.cost_price;

        i.selling.textContent =
            product.selling_price;

        i.profit.textContent =
            product.profit_amount;

        i.margin.textContent =
            product.profit_margin;

        i.stock.textContent =
            product.stock;

        i.stockStatus.innerHTML =
            '<span class="badge '+product.stock_badge+'">'+
            product.stock_status+
            '</span>';

        i.minimum.textContent =
            product.minimum_stock;

        i.maximum.textContent =
            product.maximum_stock;

        i.weight.textContent =
            product.weight;

        i.expiry.textContent =
            product.expiry_date;

        i.created.textContent =
            product.created_at;

        i.updated.textContent =
            product.updated_at;

    },

        /*
    |--------------------------------------------------------------------------
    | Open Status Modal
    |--------------------------------------------------------------------------
    */

    openStatusModal(id, status)
    {

        this.currentId = id;

        this.elements.statusProductId.value = id;

        const title = status
            ? 'Disable Product'
            : 'Enable Product';

        const message = status
            ? 'Are you sure you want to disable this product?'
            : 'Are you sure you want to enable this product?';

        document.getElementById(
            'statusModalTitle'
        ).textContent = title;

        document.getElementById(
            'statusModalMessage'
        ).textContent = message;

        this.elements.confirmStatusBtn.className =
            status
                ? 'btn btn-danger'
                : 'btn btn-success';

        this.elements.confirmStatusBtn.innerHTML =
            status
                ? '<i class="bi bi-power me-2"></i>Disable'
                : '<i class="bi bi-check-circle me-2"></i>Enable';

        this.statusModal.show();

    },


    /*
    |--------------------------------------------------------------------------
    | Toggle Status
    |--------------------------------------------------------------------------
    */

    async toggleStatus()
    {

        try{

            let id =
                this.elements.statusProductId.value;

            let response =
                await fetch(
                    '/products/' +
                    id +
                    '/toggle-status',
                    {

                        method:'PATCH',

                        headers:{

                            'X-CSRF-TOKEN':
                                this.csrfToken,

                            Accept:'application/json'

                        }

                    }
                );

            let result =
                await response.json();

            if(!result.success)
            {

                showToast(
                    result.message,
                    result.type
                );

                return;

            }

            this.statusModal.hide();

            this.loadTable();

            showToast(
                result.message,
                result.type
            );

        }
        catch(error)
        {

            console.error(error);

            showToast(
                'Unable to update status.',
                'danger'
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Open Delete Modal
    |--------------------------------------------------------------------------
    */

    openDeleteModal(id)
    {

        this.currentId = id;

        this.elements.deleteProductId.value =
            id;

        this.deleteModal.show();

    },


    /*
    |--------------------------------------------------------------------------
    | Delete Product
    |--------------------------------------------------------------------------
    */

    async delete()
    {

        try{

            let id =
                this.elements.deleteProductId.value;

            let response =
                await fetch(
                    '/products/' + id,
                    {

                        method:'DELETE',

                        headers:{

                            'X-CSRF-TOKEN':
                                this.csrfToken,

                            Accept:'application/json'

                        }

                    }
                );

            let result =
                await response.json();

            if(!result.success)
            {

                showToast(
                    result.message,
                    result.type
                );

                return;

            }

            this.deleteModal.hide();

            this.loadTable();

            showToast(
                result.message,
                result.type
            );

        }
        catch(error)
        {

            console.error(error);

            showToast(
                'Unable to delete product.',
                'danger'
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Validation Errors
    |--------------------------------------------------------------------------
    */

    showValidationErrors(errors)
    {

        Object.keys(errors).forEach(key=>{

            const field =
                document.getElementById(key);

            if(!field)
            {
                return;
            }

            field.classList.add(
                'is-invalid'
            );

            let feedback =
                document.createElement('div');

            feedback.className =
                'invalid-feedback';

            feedback.innerText =
                errors[key][0];

            field.parentNode.appendChild(
                feedback
            );

        });

    },


    /*
    |--------------------------------------------------------------------------
    | Clear Validation
    |--------------------------------------------------------------------------
    */

    clearValidation()
    {

        document
            .querySelectorAll('.is-invalid')
            .forEach(field=>{

                field.classList.remove(
                    'is-invalid'
                );

            });

        document
            .querySelectorAll(
                '.invalid-feedback'
            )
            .forEach(el=>el.remove());

    }

};


/*
|--------------------------------------------------------------------------
| Document Ready
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    () => {

        Products.init();

    }
);