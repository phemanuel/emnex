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

    // Product Import
    importModal: null,
    importFile: null,
    importPreviewData: null,
    importElements: {},

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

            /*
            |--------------------------------------------------------------------------
            | Product Inspector
            |--------------------------------------------------------------------------
            */

            inspector: {

                image:
                    document.getElementById(
                        'inspector-image'
                    ),

                name:
                    document.getElementById(
                        'inspector-name'
                    ),

                code:
                    document.getElementById(
                        'inspector-product-code'
                    ),

                status:
                    document.getElementById(
                        'inspector-status'
                    ),

                sku:
                    document.getElementById(
                        'inspector-sku'
                    ),

                barcode:
                    document.getElementById(
                        'inspector-barcode'
                    ),

                qr:
                    document.getElementById(
                        'inspector-qr-code'
                    ),

                description:
                    document.getElementById(
                        'inspector-description'
                    ),

                category:
                    document.getElementById(
                        'inspector-category'
                    ),

                unit:
                    document.getElementById(
                        'inspector-unit'
                    ),

                tax:
                    document.getElementById(
                        'inspector-tax-rate'
                    ),

                discount:
                    document.getElementById(
                        'inspector-discount'
                    ),

                brand:
                    document.getElementById(
                        'inspector-brand'
                    ),

                manufacturer:
                    document.getElementById(
                        'inspector-manufacturer'
                    ),

                cost:
                    document.getElementById(
                        'inspector-cost-price'
                    ),

                selling:
                    document.getElementById(
                        'inspector-selling-price'
                    ),

                profit:
                    document.getElementById(
                        'inspector-profit'
                    ),

                margin:
                    document.getElementById(
                        'inspector-margin'
                    ),

                stock:
                    document.getElementById(
                        'inspector-stock'
                    ),

                stockStatus:
                    document.getElementById(
                        'inspector-stock-status'
                    ),

                minimum:
                    document.getElementById(
                        'inspector-minimum-stock'
                    ),

                maximum:
                    document.getElementById(
                        'inspector-maximum-stock'
                    ),

                weight:
                    document.getElementById(
                        'inspector-weight'
                    ),

                expiry:
                    document.getElementById(
                        'inspector-expiry-date'
                    ),

                created:
                    document.getElementById(
                        'inspector-created'
                    ),

                updated:
                    document.getElementById(
                        'inspector-updated'
                    )
            },


            /*
            |--------------------------------------------------------------------------
            | Product Import
            |--------------------------------------------------------------------------
            */

            importModal:
                document.getElementById(
                    'productImportModal'
                ),

            importStepIndicator1:
                document.getElementById(
                    'productImportStepIndicator1'
                ),

            importStepIndicator2:
                document.getElementById(
                    'productImportStepIndicator2'
                ),

            importStepIndicator3:
                document.getElementById(
                    'productImportStepIndicator3'
                ),

            importError:
                document.getElementById(
                    'productImportError'
                ),

            importErrorMessage:
                document.getElementById(
                    'productImportErrorMessage'
                ),

            importUploadStep:
                document.getElementById(
                    'productImportUploadStep'
                ),

            importDropzone:
                document.getElementById(
                    'productImportDropzone'
                ),

            importFile:
                document.getElementById(
                    'productImportFile'
                ),

            importBrowseBtn:
                document.getElementById(
                    'productImportBrowseBtn'
                ),

            importSelectedFile:
                document.getElementById(
                    'productImportSelectedFile'
                ),

            importSelectedFileName:
                document.getElementById(
                    'productImportSelectedFileName'
                ),

            importSelectedFileSize:
                document.getElementById(
                    'productImportSelectedFileSize'
                ),

            importRemoveFile:
                document.getElementById(
                    'productImportRemoveFile'
                ),

            importExcelTemplateBtn:
                document.getElementById(
                    'productImportExcelTemplateBtn'
                ),

            importCsvTemplateBtn:
                document.getElementById(
                    'productImportCsvTemplateBtn'
                ),

            importUploadValidation:
                document.getElementById(
                    'productImportUploadValidation'
                ),

            importUploadValidationTitle:
                document.getElementById(
                    'productImportUploadValidationTitle'
                ),

            importUploadValidationMessage:
                document.getElementById(
                    'productImportUploadValidationMessage'
                ),

            importPreviewStep:
                document.getElementById(
                    'productImportPreviewStep'
                ),

            importTotalCount:
                document.getElementById(
                    'productImportTotalCount'
                ),

            importValidCount:
                document.getElementById(
                    'productImportValidCount'
                ),

            importWarningCount:
                document.getElementById(
                    'productImportWarningCount'
                ),

            importErrorCount:
                document.getElementById(
                    'productImportErrorCount'
                ),

            importPreviewStatus:
                document.getElementById(
                    'productImportPreviewStatus'
                ),

            importPreviewStatusTitle:
                document.getElementById(
                    'productImportPreviewStatusTitle'
                ),

            importPreviewStatusMessage:
                document.getElementById(
                    'productImportPreviewStatusMessage'
                ),

            importPreviewFileName:
                document.getElementById(
                    'productImportPreviewFileName'
                ),

            importPreviewTableBody:
                document.getElementById(
                    'productImportPreviewTableBody'
                ),

            importProcessingStep:
                document.getElementById(
                    'productImportProcessingStep'
                ),

            importProgressBar:
                document.getElementById(
                    'productImportProgressBar'
                ),

            importCompleteStep:
                document.getElementById(
                    'productImportCompleteStep'
                ),

            importImportedCount:
                document.getElementById(
                    'productImportImportedCount'
                ),

            importGeneratedProducts:
                document.getElementById(
                    'productImportGeneratedProducts'
                ),

            importLoading:
                document.getElementById(
                    'productImportLoading'
                ),

            importLoadingMessage:
                document.getElementById(
                    'productImportLoadingMessage'
                ),

            importResetBtn:
                document.getElementById(
                    'productImportResetBtn'
                ),

            importCancelBtn:
                document.getElementById(
                    'productImportCancelBtn'
                ),

            importPreviewBtn:
                document.getElementById(
                    'productImportPreviewBtn'
                ),

            importConfirmBtn:
                document.getElementById(
                    'productImportConfirmBtn'
                ),

            importDoneBtn:
                document.getElementById(
                    'productImportDoneBtn'
                )
        };
    },


    /*
    |--------------------------------------------------------------------------
    | Bootstrap Components
    |--------------------------------------------------------------------------
    */

    initializeComponents()
    {
        const productModal =
            document.getElementById(
                'productModal'
            );

        const productInspector =
            document.getElementById(
                'productInspector'
            );

        const productStatusModal =
            document.getElementById(
                'productStatusModal'
            );

        const productDeleteModal =
            document.getElementById(
                'productDeleteModal'
            );

        if (productModal) {
            this.modal =
                new bootstrap.Modal(
                    productModal
                );
        }

        if (productInspector) {
            this.inspector =
                new bootstrap.Offcanvas(
                    productInspector
                );
        }

        if (productStatusModal) {
            this.statusModal =
                new bootstrap.Modal(
                    productStatusModal
                );
        }

        if (productDeleteModal) {
            this.deleteModal =
                new bootstrap.Modal(
                    productDeleteModal
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Product Import Modal
        |--------------------------------------------------------------------------
        */

        if (this.elements.importModal) {

            this.importModal =
                new bootstrap.Modal(
                    this.elements.importModal
                );

        }
    },


    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

    bindEvents()
    {
        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if (this.elements.search) {

            let timer;

            this.elements.search.addEventListener(
                'keyup',
                () => {

                    clearTimeout(timer);

                    timer =
                        setTimeout(
                            () => {
                                this.loadTable();
                            },
                            300
                        );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if (this.elements.statusFilter) {

            this.elements.statusFilter.addEventListener(
                'change',
                () => this.loadTable()
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Product Form
        |--------------------------------------------------------------------------
        */

        if (this.elements.form) {

            this.elements.form.addEventListener(
                'submit',
                e => {

                    e.preventDefault();

                    this.save();
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Product Image
        |--------------------------------------------------------------------------
        */

        if (this.elements.image) {

            this.elements.image.addEventListener(
                'change',
                e => this.previewImage(e)
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        if (this.elements.confirmStatusBtn) {

            this.elements.confirmStatusBtn.addEventListener(
                'click',
                () => this.toggleStatus()
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Delete
        |--------------------------------------------------------------------------
        */

        if (this.elements.confirmDeleteBtn) {

            this.elements.confirmDeleteBtn.addEventListener(
                'click',
                () => this.delete()
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Product Import
        |--------------------------------------------------------------------------
        */

        this.bindImportEvents();
    },


    /*
    |--------------------------------------------------------------------------
    | AJAX Table
    |--------------------------------------------------------------------------
    */

    async loadTable(page = null)
    {
        try {

            let url =
                '/products/table?';

            if (page) {

                url +=
                    'page=' +
                    page +
                    '&';
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
                await fetch(
                    url,
                    {
                        headers: {
                            'X-Requested-With':
                                'XMLHttpRequest'
                        }
                    }
                );

            this.elements.table.innerHTML =
                await response.text();

            this.bindPagination();

        }
        catch (error) {

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
            .forEach(link => {

                link.onclick =
                    e => {

                        e.preventDefault();

                        let url =
                            new URL(
                                link.href
                            );

                        this.loadTable(
                            url.searchParams.get(
                                'page'
                            )
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

        if (this.elements.image) {

            this.elements.image.value = '';

        }

        if (this.elements.imagePreview) {

            this.elements.imagePreview.src =
                this.imagePlaceholder;

        }


        /*
        |--------------------------------------------------------------------------
        | Default Status
        |--------------------------------------------------------------------------
        */

        if (this.elements.status) {

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
            .forEach(tab => {

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
        try {

            let response =
                await fetch(
                    '/products/next-code',
                    {
                        headers: {
                            Accept:
                                'application/json'
                        }
                    }
                );

            let result =
                await response.json();

            if (result.success) {

                this.elements.productCode.value =
                    result.code;
            }

        }
        catch (error) {

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

        if (!file) {

            return;
        }

        const reader =
            new FileReader();

        reader.onload =
            e => {

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
        try {

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

            if (this.elements.productId.value) {

                url +=
                    '/' +
                    this.elements.productId.value;

                formData.append(
                    '_method',
                    'PUT'
                );
            }


            let response =
                await fetch(
                    url,
                    {
                        method: method,

                        headers: {

                            'X-CSRF-TOKEN':
                                this.csrfToken,

                            Accept:
                                'application/json'
                        },

                        body: formData
                    }
                );


            let result =
                await response.json();


            this.setLoading(false);


            /*
            |--------------------------------------------------------------------------
            | Validation Errors
            |--------------------------------------------------------------------------
            */

            if (response.status === 422) {

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

            if (!result.success) {

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
        catch (error) {

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
        if (state) {

            this.elements.saveButton.disabled =
                true;

            this.elements.saveButton.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

        }
        else {

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
        try {

            this.resetForm();

            this.currentId = id;

            let response =
                await fetch(
                    '/products/' +
                    id +
                    '/edit',
                    {
                        headers: {
                            Accept:
                                'application/json'
                        }
                    }
                );

            let result =
                await response.json();

            if (!result.success) {

                showToast(
                    result.message,
                    result.type
                );

                return;
            }

            this.populateForm(
                result.data
            );

            this.elements.modalTitle.textContent =
                'Edit Product';

            this.elements.saveButton.innerHTML =
                '<i class="bi bi-check-circle me-2"></i> Update Product';

            this.modal.show();

        }
        catch (error) {

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

        Object.keys(product).forEach(
            key => {

                let field =
                    document.getElementById(
                        key
                    );

                if (!field) {

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | NEVER SET FILE INPUT
                |--------------------------------------------------------------------------
                */

                if (field.type === 'file') {

                    return;
                }


                if (field.type === 'checkbox') {

                    field.checked =
                        Boolean(
                            product[key]
                        );

                    return;
                }


                field.value =
                    product[key] ?? '';
            }
        );


        /*
        |--------------------------------------------------------------------------
        | Image Preview
        |--------------------------------------------------------------------------
        */

        if (product.image_url) {

            this.elements.imagePreview.src =
                product.image_url;

        }
        else {

            this.elements.imagePreview.src =
                this.imagePlaceholder;
        }


        /*
        |--------------------------------------------------------------------------
        | Always clear file input
        |--------------------------------------------------------------------------
        */

        if (this.elements.image) {

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
        try {

            let response =
                await fetch(
                    '/products/' +
                    id +
                    '/details',
                    {
                        headers: {
                            Accept:
                                'application/json'
                        }
                    }
                );

            let result =
                await response.json();

            if (!result.success) {

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
        catch (error) {

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
            '<span class="badge ' +
            product.stock_badge +
            '">' +
            product.stock_status +
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

        this.elements.statusProductId.value =
            id;

        const title =
            status
                ? 'Disable Product'
                : 'Enable Product';

        const message =
            status
                ? 'Are you sure you want to disable this product?'
                : 'Are you sure you want to enable this product?';

        document.getElementById(
            'statusModalTitle'
        ).textContent =
            title;

        document.getElementById(
            'statusModalMessage'
        ).textContent =
            message;

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
        try {

            let id =
                this.elements.statusProductId.value;

            let response =
                await fetch(
                    '/products/' +
                    id +
                    '/toggle-status',
                    {
                        method: 'PATCH',

                        headers: {

                            'X-CSRF-TOKEN':
                                this.csrfToken,

                            Accept:
                                'application/json'
                        }
                    }
                );

            let result =
                await response.json();

            if (!result.success) {

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
        catch (error) {

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
        try {

            let id =
                this.elements.deleteProductId.value;

            let response =
                await fetch(
                    '/products/' +
                    id,
                    {
                        method: 'DELETE',

                        headers: {

                            'X-CSRF-TOKEN':
                                this.csrfToken,

                            Accept:
                                'application/json'
                        }
                    }
                );

            let result =
                await response.json();

            if (!result.success) {

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
        catch (error) {

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
        Object.keys(errors).forEach(
            key => {

                const field =
                    document.getElementById(
                        key
                    );

                if (!field) {

                    return;
                }

                field.classList.add(
                    'is-invalid'
                );

                let feedback =
                    document.createElement(
                        'div'
                    );

                feedback.className =
                    'invalid-feedback';

                feedback.innerText =
                    errors[key][0];

                field.parentNode.appendChild(
                    feedback
                );
            }
        );
    },


    /*
    |--------------------------------------------------------------------------
    | Clear Validation
    |--------------------------------------------------------------------------
    */

    clearValidation()
    {
        document
            .querySelectorAll(
                '.is-invalid'
            )
            .forEach(field => {

                field.classList.remove(
                    'is-invalid'
                );
            });

        document
            .querySelectorAll(
                '.invalid-feedback'
            )
            .forEach(
                el => el.remove()
            );
    },


    /*
    |--------------------------------------------------------------------------
    | PRODUCT IMPORT
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | Bind Import Events
    |--------------------------------------------------------------------------
    */

    bindImportEvents()
    {
        /*
        |--------------------------------------------------------------------------
        | Browse Button
        |--------------------------------------------------------------------------
        */

        if (this.elements.importBrowseBtn) {

            this.elements.importBrowseBtn.addEventListener(
                'click',
                () => {

                    if (this.elements.importFile) {

                        this.elements.importFile.click();

                    }
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | File Input
        |--------------------------------------------------------------------------
        */

        if (this.elements.importFile) {

            this.elements.importFile.addEventListener(
                'change',
                event => {

                    const file =
                        event.target.files[0];

                    if (file) {

                        this.handleImportFile(
                            file
                        );
                    }
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Dropzone
        |--------------------------------------------------------------------------
        */

        if (this.elements.importDropzone) {

            this.elements.importDropzone.addEventListener(
                'dragover',
                event => {

                    event.preventDefault();

                    this.elements.importDropzone.classList.add(
                        'is-dragover'
                    );
                }
            );


            this.elements.importDropzone.addEventListener(
                'dragleave',
                event => {

                    event.preventDefault();

                    this.elements.importDropzone.classList.remove(
                        'is-dragover'
                    );
                }
            );


            this.elements.importDropzone.addEventListener(
                'drop',
                event => {

                    event.preventDefault();

                    this.elements.importDropzone.classList.remove(
                        'is-dragover'
                    );

                    const files =
                        event.dataTransfer.files;

                    if (!files.length) {

                        return;
                    }

                    this.handleImportFile(
                        files[0]
                    );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Remove Selected File
        |--------------------------------------------------------------------------
        */

        if (this.elements.importRemoveFile) {

            this.elements.importRemoveFile.addEventListener(
                'click',
                () => {

                    this.clearImportFile();

                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Preview
        |--------------------------------------------------------------------------
        */

        if (this.elements.importPreviewBtn) {

            this.elements.importPreviewBtn.addEventListener(
                'click',
                () => {

                    this.previewImport();

                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Confirm Import
        |--------------------------------------------------------------------------
        */

        if (this.elements.importConfirmBtn) {

            this.elements.importConfirmBtn.addEventListener(
                'click',
                () => {

                    this.confirmImport();

                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Reset
        |--------------------------------------------------------------------------
        */

        if (this.elements.importResetBtn) {

            this.elements.importResetBtn.addEventListener(
                'click',
                () => {

                    this.resetImport();

                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Cancel
        |--------------------------------------------------------------------------
        */

        if (this.elements.importCancelBtn) {

            this.elements.importCancelBtn.addEventListener(
                'click',
                () => {

                    this.resetImport();

                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Done
        |--------------------------------------------------------------------------
        */

        if (this.elements.importDoneBtn) {

            this.elements.importDoneBtn.addEventListener(
                'click',
                () => {

                    if (this.importModal) {

                        this.importModal.hide();

                    }

                    this.resetImport();

                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Modal Reset
        |--------------------------------------------------------------------------
        */

        if (this.elements.importModal) {

            this.elements.importModal.addEventListener(
                'hidden.bs.modal',
                () => {

                    this.resetImport();

                }
            );
        }
    },


    /*
    |--------------------------------------------------------------------------
    | Open Import Modal
    |--------------------------------------------------------------------------
    */

    openImportModal()
    {
        if (!this.importModal) {

            return;
        }

        this.resetImport();

        this.importModal.show();
    },


    /*
    |--------------------------------------------------------------------------
    | Validate Selected File
    |--------------------------------------------------------------------------
    */

    handleImportFile(file)
    {
        this.hideImportError();

        const allowedExtensions = [
            'xlsx',
            'xls',
            'csv'
        ];

        const fileName =
            file.name || '';

        const extension =
            fileName
                .split('.')
                .pop()
                .toLowerCase();

        if (!allowedExtensions.includes(extension)) {

            this.showImportError(
                'Invalid File',
                'Please select an Excel (.xlsx, .xls) or CSV (.csv) file.'
            );

            this.clearImportFile();

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | 10 MB Client-Side Limit
        |--------------------------------------------------------------------------
        |
        | The server remains authoritative. This only prevents obviously
        | unsuitable files from being submitted unnecessarily.
        |
        */

        const maxSize =
            10 * 1024 * 1024;

        if (file.size > maxSize) {

            this.showImportError(
                'File Too Large',
                'Please select a file smaller than 10 MB.'
            );

            this.clearImportFile();

            return;
        }


        this.importFile = file;

        this.updateImportFileDisplay(
            file
        );


        if (this.elements.importPreviewBtn) {

            this.elements.importPreviewBtn.disabled =
                false;
        }
    },


    /*
    |--------------------------------------------------------------------------
    | Update Selected File Display
    |--------------------------------------------------------------------------
    */

    updateImportFileDisplay(file)
    {
        if (this.elements.importSelectedFile) {

            this.elements.importSelectedFile.classList.remove(
                'd-none'
            );
        }

        if (this.elements.importSelectedFileName) {

            this.elements.importSelectedFileName.textContent =
                file.name;
        }

        if (this.elements.importSelectedFileSize) {

            this.elements.importSelectedFileSize.textContent =
                this.formatFileSize(
                    file.size
                );
        }
    },


    /*
    |--------------------------------------------------------------------------
    | Clear Selected File
    |--------------------------------------------------------------------------
    */

    clearImportFile()
    {
        this.importFile = null;

        if (this.elements.importFile) {

            this.elements.importFile.value = '';

        }

        if (this.elements.importSelectedFile) {

            this.elements.importSelectedFile.classList.add(
                'd-none'
            );
        }

        if (this.elements.importSelectedFileName) {

            this.elements.importSelectedFileName.textContent =
                '';
        }

        if (this.elements.importSelectedFileSize) {

            this.elements.importSelectedFileSize.textContent =
                '';
        }

        if (this.elements.importPreviewBtn) {

            this.elements.importPreviewBtn.disabled =
                true;
        }
    },


    /*
    |--------------------------------------------------------------------------
    | Format File Size
    |--------------------------------------------------------------------------
    */

    formatFileSize(bytes)
    {
        if (!bytes) {

            return '0 KB';
        }

        const units = [
            'Bytes',
            'KB',
            'MB',
            'GB'
        ];

        const index =
            Math.floor(
                Math.log(bytes) /
                Math.log(1024)
            );

        const size =
            bytes /
            Math.pow(
                1024,
                index
            );

        return (
            Math.round(
                size * 100
            ) / 100
        ) +
        ' ' +
        units[index];
    },


    /*
    |--------------------------------------------------------------------------
    | Preview Import
    |--------------------------------------------------------------------------
    */

    async previewImport()
    {
        if (!this.importFile) {

            this.showImportError(
                'No File Selected',
                'Please select a product import file first.'
            );

            return;
        }


        try {

            this.hideImportError();

            this.setImportLoading(
                true,
                'Validating your product file...'
            );

            const formData =
                new FormData();

            formData.append(
                'file',
                this.importFile
            );


            const response =
                await fetch(
                    '/products/import/preview',
                    {
                        method: 'POST',

                        headers: {

                            'X-CSRF-TOKEN':
                                this.csrfToken,

                            Accept:
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest'
                        },

                        body: formData
                    }
                );


            const result =
                await this.parseImportResponse(
                    response
                );


            this.setImportLoading(
                false
            );


            if (!response.ok || !result.success) {

                if (response.status === 422 &&
                    result.errors) {

                    this.showImportValidationErrors(
                        result.errors
                    );

                    return;
                }

                throw new Error(
                    result.message ||
                    'Unable to validate the import file.'
                );
            }


            this.importPreviewData =
                result.data || {};


            this.renderImportPreview(
                this.importPreviewData
            );


            this.showImportPreviewStep();


        }
        catch (error) {

            this.setImportLoading(
                false
            );

            console.error(
                'Product import preview error:',
                error
            );

            this.showImportError(
                'Unable to Validate File',
                error.message ||
                'Something went wrong while validating the file.'
            );
        }
    },


    /*
    |--------------------------------------------------------------------------
    | Parse Import Response
    |--------------------------------------------------------------------------
    */

    async parseImportResponse(response)
    {
        const contentType =
            response.headers.get(
                'content-type'
            ) || '';

        if (
            contentType.includes(
                'application/json'
            )
        ) {

            return await response.json();

        }

        const text =
            await response.text();

        return {
            success: false,
            message:
                text ||
                'Unexpected server response.'
        };
    },


    /*
    |--------------------------------------------------------------------------
    | Render Import Preview
    |--------------------------------------------------------------------------
    */

    renderImportPreview(data)
    {
        const summary =
            data.summary ||
            {};

        const rows =
            data.rows ||
            data.preview ||
            data.products ||
            [];


        /*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

        this.setImportText(
            this.elements.importTotalCount,
            summary.total ??
            data.total ??
            rows.length
        );

        this.setImportText(
            this.elements.importValidCount,
            summary.valid ??
            data.valid ??
            0
        );

        this.setImportText(
            this.elements.importWarningCount,
            summary.warnings ??
            data.warnings_count ??
            0
        );

        this.setImportText(
            this.elements.importErrorCount,
            summary.errors ??
            data.errors_count ??
            0
        );


        /*
        |--------------------------------------------------------------------------
        | File Name
        |--------------------------------------------------------------------------
        */

        this.setImportText(
            this.elements.importPreviewFileName,
            this.importFile?.name || ''
        );


        /*
        |--------------------------------------------------------------------------
        | Preview Rows
        |--------------------------------------------------------------------------
        */

        this.renderImportPreviewRows(
            rows
        );


        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        const errorCount =
            Number(
                summary.errors ??
                data.errors_count ??
                0
            );

        const warningCount =
            Number(
                summary.warnings ??
                data.warnings_count ??
                0
            );


        if (errorCount > 0) {

            this.setImportPreviewStatus(
                'error',
                'Import cannot continue',
                'Please correct the errors shown in the preview before importing the products.'
            );

            if (this.elements.importConfirmBtn) {

                this.elements.importConfirmBtn.disabled =
                    true;
            }

            return;
        }


        if (warningCount > 0) {

            this.setImportPreviewStatus(
                'warning',
                'Review the warnings',
                'The file is valid, but some rows contain warnings. You can continue with the import.'
            );

        }
        else {

            this.setImportPreviewStatus(
                'success',
                'Ready to import',
                'All product rows passed validation and are ready to be imported.'
            );
        }


        if (this.elements.importConfirmBtn) {

            this.elements.importConfirmBtn.disabled =
                false;
        }
    },


    /*
    |--------------------------------------------------------------------------
    | Render Preview Rows
    |--------------------------------------------------------------------------
    */

    renderImportPreviewRows(rows)
    {
        const tbody =
            this.elements.importPreviewTableBody;

        if (!tbody) {

            return;
        }

        tbody.innerHTML = '';


        if (!Array.isArray(rows) || !rows.length) {

            tbody.innerHTML = `
                <tr>
                    <td colspan="100%" class="text-center py-4 text-muted">
                        No preview rows were returned.
                    </td>
                </tr>
            `;

            return;
        }


        rows.forEach(
            (row, index) => {

                const tr =
                    document.createElement(
                        'tr'
                    );


                const rowNumber =
                    row.row ??
                    row.row_number ??
                    index + 2;

                const status =
                    String(
                        row.status ??
                        ''
                    ).toLowerCase();


                let statusClass =
                    'bg-secondary';

                let statusText =
                    row.status ||
                    'Unknown';


                if (
                    status === 'valid' ||
                    status === 'success' ||
                    status === 'ok'
                ) {

                    statusClass =
                        'bg-success';

                    statusText =
                        'Valid';

                }
                else if (
                    status === 'warning' ||
                    status === 'warnings'
                ) {

                    statusClass =
                        'bg-warning text-dark';

                    statusText =
                        'Warning';

                }
                else if (
                    status === 'error' ||
                    status === 'invalid'
                ) {

                    statusClass =
                        'bg-danger';

                    statusText =
                        'Error';
                }


                const errors =
                    Array.isArray(
                        row.errors
                    )
                        ? row.errors
                        : [];

                const warnings =
                    Array.isArray(
                        row.warnings
                    )
                        ? row.warnings
                        : [];


                const messages =
                    [
                        ...errors,
                        ...warnings
                    ];


                const messageText =
                    messages.length
                        ? messages.join(
                            ' '
                        )
                        : (
                            row.message ||
                            ''
                        );


                const name =
                    row.name ??
                    row.data?.name ??
                    '-';

                const sku =
                    row.sku ??
                    row.data?.sku ??
                    '-';

                const barcode =
                    row.barcode ??
                    row.data?.barcode ??
                    '-';

                const category =
                    row.category ??
                    row.data?.category ??
                    '-';

                const unit =
                    row.unit ??
                    row.data?.unit ??
                    '-';


                tr.innerHTML = `
                    <td>${this.escapeHtml(rowNumber)}</td>

                    <td>
                        <div class="fw-semibold">
                            ${this.escapeHtml(name)}
                        </div>
                    </td>

                    <td>
                        ${this.escapeHtml(sku)}
                    </td>

                    <td>
                        ${this.escapeHtml(barcode)}
                    </td>

                    <td>
                        ${this.escapeHtml(category)}
                    </td>

                    <td>
                        ${this.escapeHtml(unit)}
                    </td>

                    <td>
                        <span class="badge ${statusClass}">
                            ${this.escapeHtml(statusText)}
                        </span>

                        ${
                            messageText
                                ? `
                                    <div class="small text-muted mt-1">
                                        ${this.escapeHtml(
                                            messageText
                                        )}
                                    </div>
                                `
                                : ''
                        }
                    </td>
                `;


                tbody.appendChild(
                    tr
                );
            }
        );
    },


    /*
    |--------------------------------------------------------------------------
    | Import Preview Status
    |--------------------------------------------------------------------------
    */

    setImportPreviewStatus(
        type,
        title,
        message
    )
    {
        const container =
            this.elements.importPreviewStatus;

        if (!container) {

            return;
        }


        container.classList.remove(
            'd-none',
            'is-success',
            'is-warning',
            'is-error'
        );


        container.classList.add(
            'is-' + type
        );


        this.setImportText(
            this.elements.importPreviewStatusTitle,
            title
        );

        this.setImportText(
            this.elements.importPreviewStatusMessage,
            message
        );
    },


    /*
    |--------------------------------------------------------------------------
    | Show Import Preview Step
    |--------------------------------------------------------------------------
    */

    showImportPreviewStep()
    {
        if (this.elements.importUploadStep) {

            this.elements.importUploadStep.classList.add(
                'd-none'
            );
        }

        if (this.elements.importPreviewStep) {

            this.elements.importPreviewStep.classList.remove(
                'd-none'
            );
        }

        if (this.elements.importProcessingStep) {

            this.elements.importProcessingStep.classList.add(
                'd-none'
            );
        }

        if (this.elements.importCompleteStep) {

            this.elements.importCompleteStep.classList.add(
                'd-none'
            );
        }


        this.updateImportStepIndicators(
            2
        );
    },


    /*
    |--------------------------------------------------------------------------
    | Confirm Import
    |--------------------------------------------------------------------------
    */

    async confirmImport()
    {
        if (!this.importFile) {

            this.showImportError(
                'No File Selected',
                'Please select an import file.'
            );

            return;
        }


        if (
            !this.importPreviewData
        ) {

            this.showImportError(
                'Preview Required',
                'Please validate and preview the file before importing.'
            );

            return;
        }


        const summary =
            this.importPreviewData.summary ||
            {};

        const errorCount =
            Number(
                summary.errors ??
                this.importPreviewData.errors_count ??
                0
            );


        if (errorCount > 0) {

            this.showImportError(
                'Import Blocked',
                'Please correct all validation errors before importing.'
            );

            return;
        }


        try {

            this.hideImportError();

            this.showImportProcessingStep();

            this.setImportLoading(
                true,
                'Importing products...'
            );


            const formData =
                new FormData();

            formData.append(
                'file',
                this.importFile
            );


            /*
            |--------------------------------------------------------------------------
            | Send Preview Token / Reference When Available
            |--------------------------------------------------------------------------
            */

            const importToken =
                this.importPreviewData.import_token ??
                this.importPreviewData.token ??
                null;

            if (importToken) {

                formData.append(
                    'import_token',
                    importToken
                );
            }


            const response =
                await fetch(
                    '/products/import',
                    {
                        method: 'POST',

                        headers: {

                            'X-CSRF-TOKEN':
                                this.csrfToken,

                            Accept:
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest'
                        },

                        body: formData
                    }
                );


            const result =
                await this.parseImportResponse(
                    response
                );


            this.setImportLoading(
                false
            );


            if (!response.ok || !result.success) {

                if (
                    response.status === 422 &&
                    result.errors
                ) {

                    this.showImportValidationErrors(
                        result.errors
                    );

                    this.showImportPreviewStep();

                    return;
                }

                throw new Error(
                    result.message ||
                    'Unable to import products.'
                );
            }


            this.showImportComplete(
                result.data || {},
                result.message
            );


            /*
            |--------------------------------------------------------------------------
            | Refresh Product Directory
            |--------------------------------------------------------------------------
            */

            await this.loadTable();


            showToast(
                result.message ||
                'Products imported successfully.',
                result.type ||
                'success'
            );

        }
        catch (error) {

            this.setImportLoading(
                false
            );

            console.error(
                'Product import error:',
                error
            );

            this.showImportError(
                'Import Failed',
                error.message ||
                'Something went wrong while importing the products.'
            );
        }
    },


    /*
    |--------------------------------------------------------------------------
    | Show Processing Step
    |--------------------------------------------------------------------------
    */

    showImportProcessingStep()
    {
        if (this.elements.importUploadStep) {

            this.elements.importUploadStep.classList.add(
                'd-none'
            );
        }

        if (this.elements.importPreviewStep) {

            this.elements.importPreviewStep.classList.add(
                'd-none'
            );
        }

        if (this.elements.importProcessingStep) {

            this.elements.importProcessingStep.classList.remove(
                'd-none'
            );
        }

        if (this.elements.importCompleteStep) {

            this.elements.importCompleteStep.classList.add(
                'd-none'
            );
        }


        this.updateImportStepIndicators(
            3
        );


        if (this.elements.importProgressBar) {

            this.elements.importProgressBar.style.width =
                '15%';

        }


        /*
        |--------------------------------------------------------------------------
        | Smooth Visual Progress
        |--------------------------------------------------------------------------
        |
        | This is only visual feedback. The server response remains the
        | authoritative indication that the import has completed.
        |
        */

        window.clearInterval(
            this.importProgressTimer
        );

        this.importProgressTimer =
            window.setInterval(
                () => {

                    if (
                        !this.elements.importProgressBar
                    ) {

                        return;
                    }

                    const current =
                        parseFloat(
                            this.elements.importProgressBar.style.width
                        ) || 15;

                    if (current >= 85) {

                        return;
                    }

                    this.elements.importProgressBar.style.width =
                        Math.min(
                            current + 10,
                            85
                        ) +
                        '%';

                },
                500
            );
    },


    /*
    |--------------------------------------------------------------------------
    | Show Import Complete
    |--------------------------------------------------------------------------
    */

    showImportComplete(
        data,
        message = null
    )
    {
        window.clearInterval(
            this.importProgressTimer
        );


        if (this.elements.importProgressBar) {

            this.elements.importProgressBar.style.width =
                '100%';

        }


        if (this.elements.importUploadStep) {

            this.elements.importUploadStep.classList.add(
                'd-none'
            );
        }

        if (this.elements.importPreviewStep) {

            this.elements.importPreviewStep.classList.add(
                'd-none'
            );
        }

        if (this.elements.importProcessingStep) {

            this.elements.importProcessingStep.classList.add(
                'd-none'
            );
        }

        if (this.elements.importCompleteStep) {

            this.elements.importCompleteStep.classList.remove(
                'd-none'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Imported Count
        |--------------------------------------------------------------------------
        */

        const importedCount =
            data.imported_count ??
            data.imported ??
            data.count ??
            0;

        this.setImportText(
            this.elements.importImportedCount,
            importedCount
        );


        /*
        |--------------------------------------------------------------------------
        | Generated Products
        |--------------------------------------------------------------------------
        */

        const generatedProducts =
            data.generated_products ??
            data.products ??
            [];


        this.renderGeneratedProducts(
            generatedProducts
        );


        /*
        |--------------------------------------------------------------------------
        | Optional Completion Message
        |--------------------------------------------------------------------------
        */

        if (
            message &&
            this.elements.importCompleteStep
        ) {

            const messageElement =
                this.elements.importCompleteStep.querySelector(
                    '[data-import-complete-message]'
                );

            if (messageElement) {

                messageElement.textContent =
                    message;
            }
        }


        this.updateImportStepIndicators(
            3
        );
    },


    /*
    |--------------------------------------------------------------------------
    | Render Generated Product Codes
    |--------------------------------------------------------------------------
    */

    renderGeneratedProducts(products)
    {
        const container =
            this.elements.importGeneratedProducts;

        if (!container) {

            return;
        }


        container.innerHTML = '';


        if (
            !Array.isArray(products) ||
            !products.length
        ) {

            return;
        }


        products.forEach(
            product => {

                const row =
                    document.createElement(
                        'div'
                    );

                row.className =
                    'product-import-generated-item';


                const name =
                    product.name ??
                    '-';

                const code =
                    product.product_code ??
                    product.code ??
                    '-';


                row.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center gap-3">
                        <span class="fw-semibold">
                            ${this.escapeHtml(name)}
                        </span>

                        <span class="badge bg-light text-dark border">
                            ${this.escapeHtml(code)}
                        </span>
                    </div>
                `;


                container.appendChild(
                    row
                );
            }
        );
    },


    /*
    |--------------------------------------------------------------------------
    | Import Loading Overlay
    |--------------------------------------------------------------------------
    */

    setImportLoading(
        state,
        message = 'Please wait...'
    )
    {
        if (!this.elements.importLoading) {

            return;
        }


        if (state) {

            this.elements.importLoading.classList.remove(
                'd-none'
            );

            this.setImportText(
                this.elements.importLoadingMessage,
                message
            );

        }
        else {

            this.elements.importLoading.classList.add(
                'd-none'
            );
        }
    },


    /*
    |--------------------------------------------------------------------------
    | Import Error
    |--------------------------------------------------------------------------
    */

    showImportError(
        title,
        message
    )
    {
        if (this.elements.importError) {

            this.elements.importError.classList.remove(
                'd-none'
            );
        }

        this.setImportText(
            this.elements.importErrorMessage,
            message
        );


        /*
        |--------------------------------------------------------------------------
        | If the modal has a title element, use it.
        |--------------------------------------------------------------------------
        */

        const titleElement =
            this.elements.importError?.querySelector(
                '.product-import-error-title'
            );

        if (titleElement) {

            titleElement.textContent =
                title;
        }


        /*
        |--------------------------------------------------------------------------
        | Dedicated title element
        |--------------------------------------------------------------------------
        */

        const dedicatedTitle =
            this.elements.importError?.querySelector(
                '#productImportErrorTitle'
            );

        if (dedicatedTitle) {

            dedicatedTitle.textContent =
                title;
        }
    },


    /*
    |--------------------------------------------------------------------------
    | Hide Import Error
    |--------------------------------------------------------------------------
    */

    hideImportError()
    {
        if (this.elements.importError) {

            this.elements.importError.classList.add(
                'd-none'
            );
        }
    },


    /*
    |--------------------------------------------------------------------------
    | Import Validation Errors
    |--------------------------------------------------------------------------
    */

    showImportValidationErrors(errors)
    {
        if (!errors) {

            this.showImportError(
                'Validation Failed',
                'Please review the import file and try again.'
            );

            return;
        }


        let messages = [];


        if (Array.isArray(errors)) {

            messages =
                errors.map(
                    error => {

                        if (
                            typeof error ===
                            'string'
                        ) {

                            return error;
                        }

                        return (
                            error.message ||
                            error.error ||
                            JSON.stringify(
                                error
                            )
                        );
                    }
                );

        }
        else {

            Object.keys(errors).forEach(
                key => {

                    const value =
                        errors[key];

                    if (Array.isArray(value)) {

                        value.forEach(
                            message => {

                                messages.push(
                                    message
                                );
                            }
                        );

                    }
                    else if (
                        typeof value ===
                        'string'
                    ) {

                        messages.push(
                            value
                        );

                    }
                }
            );
        }


        this.showImportError(
            'Validation Failed',
            messages.length
                ? messages.join(' ')
                : 'Please review the import file and try again.'
        );
    },


    /*
    |--------------------------------------------------------------------------
    | Reset Import
    |--------------------------------------------------------------------------
    */

    resetImport()
    {
        window.clearInterval(
            this.importProgressTimer
        );


        this.importFile = null;

        this.importPreviewData = null;


        /*
        |--------------------------------------------------------------------------
        | Reset File
        |--------------------------------------------------------------------------
        */

        if (this.elements.importFile) {

            this.elements.importFile.value = '';

        }


        /*
        |--------------------------------------------------------------------------
        | Selected File
        |--------------------------------------------------------------------------
        */

        if (this.elements.importSelectedFile) {

            this.elements.importSelectedFile.classList.add(
                'd-none'
            );
        }

        this.setImportText(
            this.elements.importSelectedFileName,
            ''
        );

        this.setImportText(
            this.elements.importSelectedFileSize,
            ''
        );


        /*
        |--------------------------------------------------------------------------
        | Reset Steps
        |--------------------------------------------------------------------------
        */

        if (this.elements.importUploadStep) {

            this.elements.importUploadStep.classList.remove(
                'd-none'
            );
        }

        if (this.elements.importPreviewStep) {

            this.elements.importPreviewStep.classList.add(
                'd-none'
            );
        }

        if (this.elements.importProcessingStep) {

            this.elements.importProcessingStep.classList.add(
                'd-none'
            );
        }

        if (this.elements.importCompleteStep) {

            this.elements.importCompleteStep.classList.add(
                'd-none'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Reset Buttons
        |--------------------------------------------------------------------------
        */

        if (this.elements.importPreviewBtn) {

            this.elements.importPreviewBtn.disabled =
                true;
        }

        if (this.elements.importConfirmBtn) {

            this.elements.importConfirmBtn.disabled =
                true;
        }


        /*
        |--------------------------------------------------------------------------
        | Reset Preview Table
        |--------------------------------------------------------------------------
        */

        if (this.elements.importPreviewTableBody) {

            this.elements.importPreviewTableBody.innerHTML =
                '';
        }


        /*
        |--------------------------------------------------------------------------
        | Reset Summary
        |--------------------------------------------------------------------------
        */

        this.setImportText(
            this.elements.importTotalCount,
            '0'
        );

        this.setImportText(
            this.elements.importValidCount,
            '0'
        );

        this.setImportText(
            this.elements.importWarningCount,
            '0'
        );

        this.setImportText(
            this.elements.importErrorCount,
            '0'
        );

        this.setImportText(
            this.elements.importImportedCount,
            '0'
        );


        if (this.elements.importGeneratedProducts) {

            this.elements.importGeneratedProducts.innerHTML =
                '';
        }


        /*
        |--------------------------------------------------------------------------
        | Reset Status
        |--------------------------------------------------------------------------
        */

        if (this.elements.importPreviewStatus) {

            this.elements.importPreviewStatus.classList.add(
                'd-none'
            );

            this.elements.importPreviewStatus.classList.remove(
                'is-success',
                'is-warning',
                'is-error'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Reset Error
        |--------------------------------------------------------------------------
        */

        this.hideImportError();


        /*
        |--------------------------------------------------------------------------
        | Reset Loading
        |--------------------------------------------------------------------------
        */

        this.setImportLoading(
            false
        );


        /*
        |--------------------------------------------------------------------------
        | Reset Progress
        |--------------------------------------------------------------------------
        */

        if (this.elements.importProgressBar) {

            this.elements.importProgressBar.style.width =
                '0%';
        }


        /*
        |--------------------------------------------------------------------------
        | Reset Step Indicator
        |--------------------------------------------------------------------------
        */

        this.updateImportStepIndicators(
            1
        );
    },


    /*
    |--------------------------------------------------------------------------
    | Import Step Indicators
    |--------------------------------------------------------------------------
    */

    updateImportStepIndicators(step)
    {
        const indicators = [
            this.elements.importStepIndicator1,
            this.elements.importStepIndicator2,
            this.elements.importStepIndicator3
        ];


        indicators.forEach(
            (indicator, index) => {

                if (!indicator) {

                    return;
                }


                const stepNumber =
                    index + 1;


                indicator.classList.remove(
                    'active',
                    'completed'
                );


                if (stepNumber < step) {

                    indicator.classList.add(
                        'completed'
                    );

                }
                else if (
                    stepNumber === step
                ) {

                    indicator.classList.add(
                        'active'
                    );
                }
            }
        );
    },


    /*
    |--------------------------------------------------------------------------
    | Import Text Helper
    |--------------------------------------------------------------------------
    */

    setImportText(
        element,
        value
    )
    {
        if (!element) {

            return;
        }

        element.textContent =
            value ?? '';
    },


    /*
    |--------------------------------------------------------------------------
    | Escape HTML
    |--------------------------------------------------------------------------
    */

    escapeHtml(value)
    {
        const div =
            document.createElement(
                'div'
            );

        div.textContent =
            value ?? '';

        return div.innerHTML;
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

