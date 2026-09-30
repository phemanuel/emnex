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

    /*
    |--------------------------------------------------------------------------
    | Product Gallery
    |--------------------------------------------------------------------------
    */

    selectedProductImages: [],
    existingProductImageData: [],
    productImageObjectUrls: [],

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

            /*
            |--------------------------------------------------------------------------
            | Product Gallery
            |--------------------------------------------------------------------------
            */

            imagesInput:
                document.getElementById(
                    'images'
                ),

            existingImagesSection:
                document.getElementById(
                    'existing-product-images-section'
                ),

            existingImagesContainer:
                document.getElementById(
                    'existing-product-images'
                ),

            existingImagesCount:
                document.getElementById(
                    'existing-product-images-count'
                ),

            newImagesSection:
                document.getElementById(
                    'new-product-images-section'
                ),

            newImagesContainer:
                document.getElementById(
                    'new-product-images'
                ),

            newImagesCount:
                document.getElementById(
                    'new-product-images-count'
                ),

            primaryImageIndex:
                document.getElementById(
                    'primary_image_index'
                ),

            primaryImageId:
                document.getElementById(
                    'primary_image_id'
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

            inventoryTab:
                document.getElementById(
                    'inventory-tab'
                ),

            trackStock:
                document.getElementById(
                    'track_stock'
                ),

            stockControlledFields:
                Array.from(
                    document.querySelectorAll(
                        '[data-stock-controlled-field]'
                    )
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
        | Product Images
        |--------------------------------------------------------------------------
        */

        if (this.elements.imagesInput) {

            this.elements.imagesInput.addEventListener(
                'change',
                event => {

                    this.handleProductImages(
                        event
                    );

                }
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
        | Track Inventory
        |--------------------------------------------------------------------------
        */

        if (this.elements.trackStock) {

            this.elements.trackStock.addEventListener(
                'change',
                () => {

                    this.updateProductStockFields();

                }
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
        /*
        |--------------------------------------------------------------------------
        | Form
        |--------------------------------------------------------------------------
        */

        this.elements.form.reset();

        this.elements.productId.value =
            '';

        this.clearValidation();


        /*
        |--------------------------------------------------------------------------
        | Reset Gallery State
        |--------------------------------------------------------------------------
        */

        this.releaseProductImageObjectUrls();

        this.selectedProductImages =
            [];

        this.existingProductImageData =
            [];


        /*
        |--------------------------------------------------------------------------
        | File Input
        |--------------------------------------------------------------------------
        */

        if (this.elements.imagesInput) {

            this.elements.imagesInput.value =
                '';

        }


        /*
        |--------------------------------------------------------------------------
        | Primary Image Values
        |--------------------------------------------------------------------------
        */

        if (this.elements.primaryImageIndex) {

            this.elements.primaryImageIndex.value =
                '';

        }


        if (this.elements.primaryImageId) {

            this.elements.primaryImageId.value =
                '';

        }


        /*
        |--------------------------------------------------------------------------
        | Existing Images
        |--------------------------------------------------------------------------
        */

        if (this.elements.existingImagesContainer) {

            this.elements.existingImagesContainer.innerHTML =
                '';

        }


        if (this.elements.existingImagesSection) {

            this.elements.existingImagesSection.classList.add(
                'd-none'
            );

        }


        if (this.elements.existingImagesCount) {

            this.elements.existingImagesCount.textContent =
                '0 images';

        }


        /*
        |--------------------------------------------------------------------------
        | New Images
        |--------------------------------------------------------------------------
        */

        if (this.elements.newImagesContainer) {

            this.elements.newImagesContainer.innerHTML =
                '';

        }


        if (this.elements.newImagesSection) {

            this.elements.newImagesSection.classList.add(
                'd-none'
            );

        }


        if (this.elements.newImagesCount) {

            this.elements.newImagesCount.textContent =
                '0 selected';

        }


        /*
        |--------------------------------------------------------------------------
        | Default Status
        |--------------------------------------------------------------------------
        */

        if (this.elements.status) {

            this.elements.status.checked =
                true;

        }

        /*
        |--------------------------------------------------------------------------
        | Stock Tracking
        |--------------------------------------------------------------------------
        */

        this.resetProductStockTracking();


        /*
        |--------------------------------------------------------------------------
        | Reset Tabs
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '.tab-pane'
            )
            .forEach(
                pane => {

                    pane.classList.remove(
                        'show',
                        'active'
                    );

                }
            );


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
            .forEach(
                tab => {

                    tab.classList.remove(
                        'active'
                    );

                }
            );


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
    | Copy Product Link
    |--------------------------------------------------------------------------
    */

    async copyProductLink(url)
    {
        try {

            if (!url) {

                showToast(
                    'Product link is not available.',
                    'danger'
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Modern Clipboard API
            |--------------------------------------------------------------------------
            */

            if (
                navigator.clipboard &&
                window.isSecureContext
            ) {

                await navigator.clipboard.writeText(
                    url
                );

            }
            else {

                /*
                |--------------------------------------------------------------------------
                | Fallback
                |--------------------------------------------------------------------------
                */

                const textarea =
                    document.createElement(
                        'textarea'
                    );

                textarea.value =
                    url;

                textarea.style.position =
                    'fixed';

                textarea.style.opacity =
                    '0';

                textarea.style.pointerEvents =
                    'none';

                document.body.appendChild(
                    textarea
                );

                textarea.focus();

                textarea.select();

                const copied =
                    document.execCommand(
                        'copy'
                    );

                textarea.remove();


                if (!copied) {

                    throw new Error(
                        'Clipboard copy failed.'
                    );

                }

            }


            showToast(
                'Product link copied.',
                'success'
            );

        }
        catch (error) {

            console.error(
                'Unable to copy product link:',
                error
            );

            showToast(
                'Unable to copy product link.',
                'danger'
            );

        }
    },


    /*
    |--------------------------------------------------------------------------
    | Handle Product Images
    |--------------------------------------------------------------------------
    */

    handleProductImages(event)
    {
        const incomingFiles =
            Array.from(
                event.target.files || []
            );


        if (!incomingFiles.length) {

            return;

        }


        const validFiles =
            incomingFiles.filter(
                file =>
                    this.validateProductImage(
                        file
                    )
            );


        if (!validFiles.length) {

            this.syncProductImageInput();

            return;

        }


        const allowsMultiple =
            this.allowsMultipleProductImages();


        const maxImages =
            this.getMaxProductImages();


        /*
        |--------------------------------------------------------------------------
        | Single Image Business
        |--------------------------------------------------------------------------
        |
        | Selecting a new image replaces the existing image when saved.
        |
        */

        if (!allowsMultiple) {

            this.selectedProductImages =
                [
                    validFiles[0],
                ];

        }


        /*
        |--------------------------------------------------------------------------
        | Multiple Image Business
        |--------------------------------------------------------------------------
        */

        else {

            const mergedFiles = [
                ...this.selectedProductImages,
            ];


            validFiles.forEach(
                file => {

                    const signature =
                        this.productImageFileSignature(
                            file
                        );


                    const alreadySelected =
                        mergedFiles.some(
                            existingFile =>
                                this.productImageFileSignature(
                                    existingFile
                                ) === signature
                        );


                    if (!alreadySelected) {

                        mergedFiles.push(
                            file
                        );

                    }

                }
            );


            const existingCount =
                this.existingProductImageData
                    .length;


            const availableSlots =
                Math.max(
                    0,
                    maxImages -
                    existingCount
                );


            if (
                mergedFiles.length >
                availableSlots
            ) {

                showToast(
                    `This product can have a maximum of ${maxImages} images.`,
                    'warning'
                );

            }


            this.selectedProductImages =
                mergedFiles.slice(
                    0,
                    availableSlots
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Default Primary
        |--------------------------------------------------------------------------
        |
        | For a brand-new Product with no existing primary image, make the first
        | newly selected image the default primary image.
        |
        */

        if (
            this.selectedProductImages.length
            &&
            !this.hasExistingPrimaryImage()
            &&
            !this.elements.primaryImageId?.value
            &&
            !this.elements.primaryImageIndex?.value
        ) {

            this.elements.primaryImageIndex.value =
                '0';

        }


        this.syncProductImageInput();

        this.renderExistingProductImages();

        this.renderNewProductImages();
    },


    /*
    |--------------------------------------------------------------------------
    | Validate Product Image
    |--------------------------------------------------------------------------
    */

    validateProductImage(file)
    {
        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp',
        ];


        if (
            !allowedTypes.includes(
                file.type
            )
        ) {

            showToast(
                `${file.name} is not a supported image type.`,
                'warning'
            );

            return false;

        }


        const maxFileSize =
            2 * 1024 * 1024;


        if (
            file.size >
            maxFileSize
        ) {

            showToast(
                `${file.name} is larger than 2MB.`,
                'warning'
            );

            return false;

        }


        return true;
    },


    /*
    |--------------------------------------------------------------------------
    | Product Image File Signature
    |--------------------------------------------------------------------------
    */

    productImageFileSignature(file)
    {
        return [
            file.name,
            file.size,
            file.lastModified,
        ].join(
            ':'
        );
    },


    /*
    |--------------------------------------------------------------------------
    | Gallery Capability
    |--------------------------------------------------------------------------
    */

    allowsMultipleProductImages()
    {
        return (
            this.elements.imagesInput
                ?.dataset
                ?.multipleImages
            === '1'
        );
    },


    getMaxProductImages()
    {
        const value =
            parseInt(
                this.elements.imagesInput
                    ?.dataset
                    ?.maxImages
                || '1',
                10
            );


        return Number.isNaN(value)
            ? 1
            : Math.max(
                1,
                value
            );
    },


    /*
    |--------------------------------------------------------------------------
    | Synchronize File Input
    |--------------------------------------------------------------------------
    |
    | FileList cannot be modified directly, so DataTransfer is used to rebuild
    | the images[] input after a preview is removed.
    |
    */

    syncProductImageInput()
    {
        if (!this.elements.imagesInput) {

            return;

        }


        const transfer =
            new DataTransfer();


        this.selectedProductImages.forEach(
            file => {

                transfer.items.add(
                    file
                );

            }
        );


        this.elements.imagesInput.files =
            transfer.files;
    },


    /*
    |--------------------------------------------------------------------------
    | Render New Images
    |--------------------------------------------------------------------------
    */

    renderNewProductImages()
    {
        const container =
            this.elements.newImagesContainer;


        const section =
            this.elements.newImagesSection;


        if (
            !container ||
            !section
        ) {

            return;

        }


        this.releaseProductImageObjectUrls();


        container.innerHTML =
            '';


        const count =
            this.selectedProductImages
                .length;


        if (this.elements.newImagesCount) {

            this.elements.newImagesCount.textContent =
                `${count} selected`;

        }


        if (!count) {

            section.classList.add(
                'd-none'
            );

            return;

        }


        section.classList.remove(
            'd-none'
        );


        const selectedPrimaryIndex =
            this.elements.primaryImageIndex
                ?.value;


        this.selectedProductImages.forEach(
            (file, index) => {

                const imageUrl =
                    URL.createObjectURL(
                        file
                    );


                this.productImageObjectUrls.push(
                    imageUrl
                );


                const isPrimary =
                    selectedPrimaryIndex !== ''
                    &&
                    Number(
                        selectedPrimaryIndex
                    ) === index;


                const column =
                    document.createElement(
                        'div'
                    );


                column.className =
                    'col-6 col-md-4 col-lg-3';


                column.innerHTML = `
                    <div class="card h-100">

                        <img
                            src="${imageUrl}"
                            class="card-img-top"
                            alt="${this.escapeHtml(file.name)}"
                            style="
                                height: 150px;
                                object-fit: cover;
                            "
                        >

                        <div class="card-body p-2">

                            <div
                                class="small text-truncate mb-2"
                                title="${this.escapeHtml(file.name)}"
                            >
                                ${this.escapeHtml(file.name)}
                            </div>

                            ${
                                isPrimary
                                    ? `
                                        <span
                                            class="badge bg-primary mb-2"
                                        >
                                            Primary
                                        </span>
                                    `
                                    : ''
                            }

                            <div class="d-flex gap-2">

                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-primary flex-grow-1"
                                    data-new-primary-index="${index}"
                                >
                                    ${
                                        isPrimary
                                            ? 'Primary'
                                            : 'Set Primary'
                                    }
                                </button>

                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-danger"
                                    data-remove-new-image="${index}"
                                    title="Remove image"
                                >
                                    <i class="bi bi-trash"></i>
                                </button>

                            </div>

                        </div>

                    </div>
                `;


                container.appendChild(
                    column
                );

            }
        );


        container
            .querySelectorAll(
                '[data-new-primary-index]'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            this.selectNewPrimaryImage(
                                Number(
                                    button.dataset
                                        .newPrimaryIndex
                                )
                            );

                        }
                    );

                }
            );


        container
            .querySelectorAll(
                '[data-remove-new-image]'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            this.removeNewProductImage(
                                Number(
                                    button.dataset
                                        .removeNewImage
                                )
                            );

                        }
                    );

                }
            );
    },


    /*
    |--------------------------------------------------------------------------
    | Render Existing Images
    |--------------------------------------------------------------------------
    */

    renderExistingProductImages(images = null)
    {
        if (
            Array.isArray(images)
        ) {

            this.existingProductImageData =
                images;

        }


        const container =
            this.elements.existingImagesContainer;


        const section =
            this.elements.existingImagesSection;


        if (
            !container ||
            !section
        ) {

            return;

        }


        container.innerHTML =
            '';


        const count =
            this.existingProductImageData
                .length;


        if (
            this.elements.existingImagesCount
        ) {

            this.elements.existingImagesCount.textContent =
                `${count} ${
                    count === 1
                        ? 'image'
                        : 'images'
                }`;

        }


        if (!count) {

            section.classList.add(
                'd-none'
            );

            return;

        }


        section.classList.remove(
            'd-none'
        );


        const selectedExistingId =
            this.elements.primaryImageId
                ?.value;


        const selectedNewIndex =
            this.elements.primaryImageIndex
                ?.value;


        this.existingProductImageData.forEach(
            image => {

                /*
                |--------------------------------------------------------------------------
                | Image URL
                |--------------------------------------------------------------------------
                */

                const imageUrl =
                    image.image_url
                    ??
                    image.url
                    ??
                    (
                        image.image
                            ? '/uploads/products/'
                                + encodeURIComponent(
                                    image.image
                                )
                            : this.imagePlaceholder
                    );


                /*
                |--------------------------------------------------------------------------
                | Primary State
                |--------------------------------------------------------------------------
                */

                let isPrimary =
                    false;


                if (
                    selectedNewIndex !== ''
                ) {

                    isPrimary =
                        false;

                }
                else if (
                    selectedExistingId !== ''
                ) {

                    isPrimary =
                        Number(
                            selectedExistingId
                        ) === Number(
                            image.id
                        );

                }
                else {

                    isPrimary =
                        Boolean(
                            image.is_primary
                        );

                }


                const column =
                    document.createElement(
                        'div'
                    );


                column.className =
                    'col-6 col-md-4 col-lg-3';


                column.innerHTML = `
                    <div class="card h-100">

                        <img
                            src="${imageUrl}"
                            class="card-img-top"
                            alt="Product image"
                            style="
                                height: 150px;
                                object-fit: cover;
                            "
                        >

                        <div class="card-body p-2">

                            ${
                                isPrimary
                                    ? `
                                        <span
                                            class="badge bg-primary mb-2"
                                        >
                                            Primary
                                        </span>
                                    `
                                    : `
                                        <span
                                            class="badge bg-light text-dark border mb-2"
                                        >
                                            Gallery
                                        </span>
                                    `
                            }

                            ${
                                image.id
                                    ? `
                                        <div class="d-flex gap-2">

                                            ${
                                                image.id
                                                    ? `
                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-outline-primary flex-grow-1"
                                                            data-existing-primary-id="${image.id}"
                                                        >
                                                            ${
                                                                isPrimary
                                                                    ? 'Primary'
                                                                    : 'Set Primary'
                                                            }
                                                        </button>

                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-outline-danger"
                                                            data-delete-existing-image="${image.id}"
                                                            title="Remove image"
                                                        >
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    `
                                                    : ''
                                            }

                                        </div>
                                    `
                                    : ''
                            }

                        </div>

                    </div>
                `;


                container.appendChild(
                    column
                );

            }
        );


        container
            .querySelectorAll(
                '[data-existing-primary-id]'
            )

            
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        () => {

                            this.selectExistingPrimaryImage(
                                Number(
                                    button.dataset
                                        .existingPrimaryId
                                )
                            );

                        }
                    );

                }
            );

            /*
            |--------------------------------------------------------------------------
            | Delete Existing Image
            |--------------------------------------------------------------------------
            */

            container
                .querySelectorAll(
                    '[data-delete-existing-image]'
                )
                .forEach(
                    button => {

                        button.addEventListener(
                            'click',
                            () => {

                                this.deleteExistingProductImage(
                                    Number(
                                        button.dataset
                                            .deleteExistingImage
                                    )
                                );

                            }
                        );

                    }
                );
    },


    /*
    |--------------------------------------------------------------------------
    | Select New Primary Image
    |--------------------------------------------------------------------------
    */

    selectNewPrimaryImage(index)
    {
        if (
            index < 0
            ||
            index >=
                this.selectedProductImages.length
        ) {

            return;

        }


        if (this.elements.primaryImageIndex) {

            this.elements.primaryImageIndex.value =
                String(
                    index
                );

        }


        if (this.elements.primaryImageId) {

            this.elements.primaryImageId.value =
                '';

        }


        this.renderExistingProductImages();

        this.renderNewProductImages();
    },


    /*
    |--------------------------------------------------------------------------
    | Select Existing Primary Image
    |--------------------------------------------------------------------------
    */

    selectExistingPrimaryImage(imageId)
    {
        if (!imageId) {

            return;

        }


        const exists =
            this.existingProductImageData
                .some(
                    image =>
                        Number(
                            image.id
                        ) === Number(
                            imageId
                        )
                );


        if (!exists) {

            return;

        }


        if (this.elements.primaryImageId) {

            this.elements.primaryImageId.value =
                String(
                    imageId
                );

        }


        if (this.elements.primaryImageIndex) {

            this.elements.primaryImageIndex.value =
                '';

        }


        this.renderExistingProductImages();

        this.renderNewProductImages();
    },

    /*
    |--------------------------------------------------------------------------
    | Delete Existing Product Image
    |--------------------------------------------------------------------------
    */

    async deleteExistingProductImage(imageId)
    {
        if (
            !imageId
            ||
            !this.currentId
        ) {

            return;

        }


        const image =
            this.existingProductImageData
                .find(
                    item =>
                        Number(
                            item.id
                        ) === Number(
                            imageId
                        )
                );


        if (!image) {

            return;

        }


        const confirmed =
            window.confirm(
                'Remove this image from the product?'
            );


        if (!confirmed) {

            return;

        }


        try {

            const response =
                await fetch(

                    '/products/'
                    + this.currentId
                    + '/images/'
                    + imageId,

                    {
                        method:
                            'DELETE',

                        headers: {

                            'X-CSRF-TOKEN':
                                this.csrfToken,

                            Accept:
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',

                        },
                    }
                );


            const result =
                await response.json();


            if (!response.ok) {

                showToast(
                    result.message
                        || 'Unable to remove product image.',
                    result.type
                        || 'danger'
                );

                return;

            }


            if (!result.success) {

                showToast(
                    result.message,
                    result.type
                        || 'danger'
                );

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | Update Local Gallery
            |--------------------------------------------------------------------------
            */

            this.existingProductImageData =
                result.data?.images
                ?? [];


            /*
            |--------------------------------------------------------------------------
            | Clear Selection If Deleted Image Was Selected
            |--------------------------------------------------------------------------
            */

            if (
                Number(
                    this.elements.primaryImageId
                        ?.value
                    || 0
                ) === Number(
                    imageId
                )
            ) {

                this.elements.primaryImageId.value =
                    '';

            }


            /*
            |--------------------------------------------------------------------------
            | Re-render Gallery
            |--------------------------------------------------------------------------
            */

            this.renderExistingProductImages();

            this.renderNewProductImages();


            /*
            |--------------------------------------------------------------------------
            | Refresh Product Table
            |--------------------------------------------------------------------------
            |
            | Important if the deleted image was the primary cover image.
            |
            */

            await this.loadTable();


            showToast(
                result.message,
                result.type
                    || 'success'
            );

        }
        catch (error) {

            console.error(
                'Product image deletion failed:',
                error
            );


            showToast(
                'Unable to remove product image.',
                'danger'
            );
        }
    },


    /*
    |--------------------------------------------------------------------------
    | Remove Newly Selected Image
    |--------------------------------------------------------------------------
    */

    removeNewProductImage(index)
    {
        if (
            index < 0
            ||
            index >=
                this.selectedProductImages.length
        ) {

            return;

        }


        const primaryIndexValue =
            this.elements.primaryImageIndex
                ?.value;


        const primaryIndex =
            primaryIndexValue === ''
                ? null
                : Number(
                    primaryIndexValue
                );


        this.selectedProductImages.splice(
            index,
            1
        );


        /*
        |--------------------------------------------------------------------------
        | Adjust Primary Index
        |--------------------------------------------------------------------------
        */

        if (
            primaryIndex !== null
        ) {

            if (
                primaryIndex === index
            ) {

                this.elements.primaryImageIndex.value =
                    '';

            }
            else if (
                primaryIndex > index
            ) {

                this.elements.primaryImageIndex.value =
                    String(
                        primaryIndex - 1
                    );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Default New Primary
        |--------------------------------------------------------------------------
        |
        | Only needed when there is no existing primary image.
        |
        */

        if (
            this.selectedProductImages.length
            &&
            !this.hasExistingPrimaryImage()
            &&
            !this.elements.primaryImageId?.value
            &&
            !this.elements.primaryImageIndex?.value
        ) {

            this.elements.primaryImageIndex.value =
                '0';

        }


        this.syncProductImageInput();

        this.renderExistingProductImages();

        this.renderNewProductImages();
    },


    /*
    |--------------------------------------------------------------------------
    | Existing Primary Image Check
    |--------------------------------------------------------------------------
    */

    hasExistingPrimaryImage()
    {
        return this.existingProductImageData
            .some(
                image =>
                    Boolean(
                        image.is_primary
                    )
            );
    },


    /*
    |--------------------------------------------------------------------------
    | Release Preview URLs
    |--------------------------------------------------------------------------
    */

    releaseProductImageObjectUrls()
    {
        this.productImageObjectUrls
            .forEach(
                imageUrl => {

                    URL.revokeObjectURL(
                        imageUrl
                    );

                }
            );


        this.productImageObjectUrls =
            [];
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
        /*
        |--------------------------------------------------------------------------
        | Product ID
        |--------------------------------------------------------------------------
        */

        this.elements.productId.value =
            product.id;


        /*
        |--------------------------------------------------------------------------
        | Standard Product Fields
        |--------------------------------------------------------------------------
        */

        Object.keys(product).forEach(
            key => {

                const field =
                    document.getElementById(
                        key
                    );


                if (!field) {

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Never Set File Inputs
                |--------------------------------------------------------------------------
                */

                if (
                    field.type ===
                    'file'
                ) {

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Checkbox
                |--------------------------------------------------------------------------
                */

                if (
                    field.type ===
                    'checkbox'
                ) {

                    field.checked =
                        Boolean(
                            product[key]
                        );

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Standard Field
                |--------------------------------------------------------------------------
                */

                field.value =
                    product[key]
                    ?? '';

            }
        );

        /*
        |--------------------------------------------------------------------------
        | Stock Tracking
        |--------------------------------------------------------------------------
        */

        this.updateProductStockFields();


        /*
        |--------------------------------------------------------------------------
        | Reset New Uploads
        |--------------------------------------------------------------------------
        */

        this.releaseProductImageObjectUrls();

        this.selectedProductImages =
            [];


        if (this.elements.imagesInput) {

            this.elements.imagesInput.value =
                '';

        }


        if (this.elements.primaryImageIndex) {

            this.elements.primaryImageIndex.value =
                '';

        }


        if (this.elements.primaryImageId) {

            this.elements.primaryImageId.value =
                '';

        }


        /*
        |--------------------------------------------------------------------------
        | Existing Gallery
        |--------------------------------------------------------------------------
        |
        | Preferred format:
        |
        | product.images = [
        |     {
        |         id: 1,
        |         image: 'filename.jpg',
        |         image_url: '/uploads/products/filename.jpg',
        |         is_primary: true,
        |         sort_order: 0
        |     }
        | ]
        |
        */


        let existingImages =
            Array.isArray(
                product.images
            )
                ? product.images
                : [];


        /*
        |--------------------------------------------------------------------------
        | Legacy Fallback
        |--------------------------------------------------------------------------
        |
        | Until the edit endpoint is updated to return product.images, continue
        | showing the existing products.image cover.
        |
        */

        if (
            !existingImages.length
            &&
            product.image_url
        ) {

            existingImages = [
                {
                    id: null,
                    image:
                        product.image
                        ?? null,
                    image_url:
                        product.image_url,
                    is_primary:
                        true,
                    sort_order:
                        0,
                },
            ];

        }


        this.renderExistingProductImages(
            existingImages
        );


        this.renderNewProductImages();
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

        const tracksStock =
            product.tracks_stock !== false;


        document
            .querySelectorAll(
                '[data-inspector-stock-quantity]'
            )
            .forEach(
                element => {

                    element.classList.toggle(
                        'd-none',
                        !tracksStock
                    );

                }
            );


        document
            .querySelectorAll(
                '[data-inspector-stock-level]'
            )
            .forEach(
                element => {

                    element.classList.toggle(
                        'd-none',
                        !tracksStock
                    );

                }
            );


        /*
        |--------------------------------------------------------------------------
        | Safe Text Setter
        |--------------------------------------------------------------------------
        |
        | Capability-controlled Blade elements may not exist.
        |
        | Example:
        | Electronics may not render Unit, QR Code or Expiry Date.
        |
        */

        const setText =
            (
                element,
                value,
                fallback = '-'
            ) => {

                if (!element) {

                    return;

                }


                element.textContent =
                    value !== null
                    &&
                    value !== undefined
                    &&
                    value !== ''
                        ? value
                        : fallback;

            };


        /*
        |--------------------------------------------------------------------------
        | Safe HTML Setter
        |--------------------------------------------------------------------------
        */

        const setHtml =
            (
                element,
                value
            ) => {

                if (!element) {

                    return;

                }


                element.innerHTML =
                    value ?? '';

            };


        /*
        |--------------------------------------------------------------------------
        | Product Image
        |--------------------------------------------------------------------------
        */

        if (i.image) {

            i.image.src =
                product.image_url
                || this.imagePlaceholder;

        }


        /*
        |--------------------------------------------------------------------------
        | Basic Information
        |--------------------------------------------------------------------------
        */

        setText(
            i.name,
            product.name
        );


        setText(
            i.code,
            product.product_code
        );


        if (i.status) {

            setHtml(
                i.status,

                product.status
                    ? `
                        <span class="badge bg-success">
                            Active
                        </span>
                    `
                    : `
                        <span class="badge bg-danger">
                            Inactive
                        </span>
                    `
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Identifiers
        |--------------------------------------------------------------------------
        */

        setText(
            i.sku,
            product.sku
        );


        setText(
            i.barcode,
            product.barcode
        );


        setText(
            i.qr,
            product.qr_code
        );


        /*
        |--------------------------------------------------------------------------
        | Classification
        |--------------------------------------------------------------------------
        */

        setText(
            i.category,
            product.category
        );


        setText(
            i.unit,
            product.unit
        );


        setText(
            i.tax,
            product.tax_rate
        );


        setText(
            i.discount,
            product.discount
        );


        /*
        |--------------------------------------------------------------------------
        | Product Details
        |--------------------------------------------------------------------------
        */

        setText(
            i.brand,
            product.brand
        );


        setText(
            i.manufacturer,
            product.manufacturer
        );


        setText(
            i.description,
            product.description
        );


        /*
        |--------------------------------------------------------------------------
        | Pricing
        |--------------------------------------------------------------------------
        */

        setText(
            i.cost,
            product.cost_price
        );


        setText(
            i.selling,
            product.selling_price
        );


        setText(
            i.profit,
            product.profit_amount
        );


        setText(
            i.margin,
            product.profit_margin
        );


        /*
        |--------------------------------------------------------------------------
        | Inventory
        |--------------------------------------------------------------------------
        */

        if (tracksStock) {

            setText(
                i.stock,
                product.stock
            );


            setText(
                i.minimum,
                product.minimum_stock
            );


            setText(
                i.maximum,
                product.maximum_stock
            );


            if (i.stockStatus) {

                const stockBadge =
                    product.stock_badge
                    ?? 'bg-secondary';


                const stockStatus =
                    product.stock_status
                    ?? '-';


                setHtml(
                    i.stockStatus,
                    `
                        <span class="badge ${stockBadge}">
                            ${this.escapeHtml(
                                stockStatus
                            )}
                        </span>
                    `
                );

            }

        }
        else {

            setText(
                i.stock,
                '-'
            );


            setText(
                i.minimum,
                '-'
            );


            setText(
                i.maximum,
                '-'
            );


            if (i.stockStatus) {

                setHtml(
                    i.stockStatus,
                    `
                        <span class="badge bg-secondary">
                            Not tracked
                        </span>
                    `
                );

            }

        }


        setText(
            i.weight,
            product.weight
        );


        setText(
            i.expiry,
            product.expiry_date
        );


        /*
        |--------------------------------------------------------------------------
        | System Information
        |--------------------------------------------------------------------------
        */

        setText(
            i.created,
            product.created_at
        );


        setText(
            i.updated,
            product.updated_at
        );
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
        Object.keys(
            errors
        ).forEach(
            key => {

                /*
                |--------------------------------------------------------------------------
                | Gallery Validation Keys
                |--------------------------------------------------------------------------
                |
                | images.0
                | images.1
                | image      (temporary legacy rule)
                |
                | should all display against #images.
                |
                */

                let fieldKey =
                    key;


                if (
                    key === 'image'
                    ||
                    key.startsWith(
                        'images.'
                    )
                ) {

                    fieldKey =
                        'images';

                }


                const field =
                    document.getElementById(
                        fieldKey
                    );


                if (!field) {

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Avoid Duplicate Feedback
                |--------------------------------------------------------------------------
                */

                if (
                    field.classList.contains(
                        'is-invalid'
                    )
                ) {

                    return;

                }


                field.classList.add(
                    'is-invalid'
                );


                const feedback =
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

        this.renderImportPreviewRows(rows);

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

        /*
        |--------------------------------------------------------------------------
        | Button State
        |--------------------------------------------------------------------------
        |
        | At this point the file has already been validated.
        | Therefore:
        |
        | Validate & Preview = hidden
        | Import Products    = shown
        |
        |--------------------------------------------------------------------------
        */

        if (this.elements.importPreviewBtn) {
            this.elements.importPreviewBtn.classList.add('d-none');
            this.elements.importPreviewBtn.disabled = true;
        }

        if (this.elements.importConfirmBtn) {
            this.elements.importConfirmBtn.classList.remove('d-none');
            this.elements.importConfirmBtn.disabled = true;
        }

        /*
        |--------------------------------------------------------------------------
        | Errors
        |--------------------------------------------------------------------------
        */

        if (errorCount > 0) {

            this.setImportPreviewStatus(
                'error',
                'Import cannot continue',
                'Please correct the errors shown in the preview before importing the products.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Warnings
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Enable Import
        |--------------------------------------------------------------------------
        */

        if (this.elements.importConfirmBtn) {
            this.elements.importConfirmBtn.disabled = false;
        }
    },


    /**
     * |--------------------------------------------------------------------------
     * | Render Preview Rows
     * |--------------------------------------------------------------------------
     */
    
    renderImportPreviewRows(rows)
    {
        const tbody =
            this.elements.importPreviewTableBody;

        if (!tbody) {
            return;
        }

        tbody.innerHTML = '';

        if (!Array.isArray(rows) || rows.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="10" class="text-center py-4">
                        <div class="text-muted">
                            No product rows were found in the import file.
                        </div>
                    </td>
                </tr>
            `;

            return;
        }

        rows.forEach((row, index) => {

            const display =
                row.display || {};

            const normalized =
                row.normalized || {};

            const rowNumber =
                row.row ??
                row.row_number ??
                (index + 2);

            const status =
                row.status ??
                'valid';

            const name =
                display.name ??
                normalized.name ??
                row.name ??
                row.data?.name ??
                '-';

            const sku =
                display.sku ??
                normalized.sku ??
                row.sku ??
                row.data?.sku ??
                '-';

            const category =
                display.category ??
                normalized.category ??
                row.category ??
                row.data?.category ??
                '-';

            const unit =
                display.unit ??
                normalized.unit ??
                row.unit ??
                row.data?.unit ??
                '-';

            const costPrice =
                display.cost_price ??
                normalized.cost_price ??
                row.cost_price ??
                row.data?.cost_price ??
                '-';

            const sellingPrice =
                display.selling_price ??
                normalized.selling_price ??
                row.selling_price ??
                row.data?.selling_price ??
                '-';

            const openingStock =
                display.opening_stock ??
                normalized.opening_stock ??
                row.opening_stock ??
                row.data?.opening_stock ??
                0;

            const errors =
                Array.isArray(row.errors)
                    ? row.errors
                    : [];

            const warnings =
                Array.isArray(row.warnings)
                    ? row.warnings
                    : [];

            const hasErrors =
                errors.length > 0 ||
                status === 'error';

            const hasWarnings =
                warnings.length > 0 ||
                status === 'warning';

            let statusBadge = '';

            if (hasErrors) {
                statusBadge = `
                    <span class="badge rounded-pill text-bg-danger">
                        <i class="bi bi-x-circle me-1"></i>
                        Error
                    </span>
                `;
            }
            else if (hasWarnings) {
                statusBadge = `
                    <span class="badge rounded-pill text-bg-warning">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        Warning
                    </span>
                `;
            }
            else {
                statusBadge = `
                    <span class="badge rounded-pill text-bg-success">
                        <i class="bi bi-check-circle me-1"></i>
                        Valid
                    </span>
                `;
            }

            const validationMessages = [];

            errors.forEach(error => {
                if (error) {
                    validationMessages.push(`
                        <div class="text-danger">
                            <i class="bi bi-x-circle me-1"></i>
                            ${this.escapeHtml(error)}
                        </div>
                    `);
                }
            });

            warnings.forEach(warning => {
                if (warning) {
                    validationMessages.push(`
                        <div class="text-warning">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            ${this.escapeHtml(warning)}
                        </div>
                    `);
                }
            });

            if (validationMessages.length === 0) {
                validationMessages.push(`
                    <span class="text-success">
                        <i class="bi bi-check2-circle me-1"></i>
                        Valid
                    </span>
                `);
            }

            const validationHtml =
                validationMessages.join('');

            const rowClass =
                hasErrors
                    ? 'product-import-row-error'
                    : hasWarnings
                        ? 'product-import-row-warning'
                        : '';

            tbody.insertAdjacentHTML(
                'beforeend',
                `
                    <tr class="${rowClass}">
                        <td>
                            <span class="product-import-row-number">
                                ${this.escapeHtml(String(rowNumber))}
                            </span>
                        </td>

                        <td>
                            ${statusBadge}
                        </td>

                        <td>
                            <div class="product-import-product-cell">
                                <strong>
                                    ${this.escapeHtml(String(name))}
                                </strong>
                            </div>
                        </td>

                        <td>
                            <span class="product-import-mono">
                                ${this.escapeHtml(String(sku))}
                            </span>
                        </td>

                        <td>
                            ${this.escapeHtml(String(category))}
                        </td>

                        <td>
                            ${this.escapeHtml(String(unit))}
                        </td>

                        <td>
                            ${this.escapeHtml(String(costPrice))}
                        </td>

                        <td>
                            ${this.escapeHtml(String(sellingPrice))}
                        </td>

                        <td>
                            ${this.escapeHtml(String(openingStock))}
                        </td>

                        <td>
                            <div class="product-import-validation">
                                ${validationHtml}
                            </div>
                        </td>
                    </tr>
                `
            );
        });
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
    | Default Stock Tracking
    |--------------------------------------------------------------------------
    */

    productTracksStockByDefault()
    {
        return (
            this.elements.inventoryTab
                ?.dataset
                ?.trackStockDefault
            ?? '1'
        ) === '1';
    },


    /*
    |--------------------------------------------------------------------------
    | Current Stock Tracking State
    |--------------------------------------------------------------------------
    */

    productTracksStock()
    {
        if (this.elements.trackStock) {

            return Boolean(
                this.elements.trackStock.checked
            );

        }


        return this.productTracksStockByDefault();
    },


    /*
    |--------------------------------------------------------------------------
    | Update Stock Fields
    |--------------------------------------------------------------------------
    */

    updateProductStockFields()
    {
        const tracksStock =
            this.productTracksStock();


        (
            this.elements.stockControlledFields
            ?? []
        ).forEach(
            wrapper => {

                wrapper.classList.toggle(
                    'd-none',
                    !tracksStock
                );


                wrapper
                    .querySelectorAll(
                        'input, select, textarea'
                    )
                    .forEach(
                        field => {

                            const required =
                                field.dataset
                                    .stockRequired
                                === '1';


                            field.required =
                                tracksStock
                                &&
                                required;

                        }
                    );

            }
        );
    },


    /*
    |--------------------------------------------------------------------------
    | Reset Stock Tracking
    |--------------------------------------------------------------------------
    */

    resetProductStockTracking()
    {
        if (
            this.elements.trackStock
        ) {

            this.elements.trackStock.checked =
                this.productTracksStockByDefault();

        }


        this.updateProductStockFields();
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

        if (!this.importPreviewData) {

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

            /*
            |--------------------------------------------------------------------------
            | Import Request
            |--------------------------------------------------------------------------
            */

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

            this.setImportLoading(false);

            /*
            |--------------------------------------------------------------------------
            | Import Error
            |--------------------------------------------------------------------------
            */

            if (
                !response.ok ||
                !result.success
            ) {

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

            /*
            |--------------------------------------------------------------------------
            | Import Successful
            |--------------------------------------------------------------------------
            */

            this.showImportComplete(
                result.data || {},
                result.message
            );

            /*
            |--------------------------------------------------------------------------
            | Footer Button State
            |--------------------------------------------------------------------------
            |
            | Import is complete, so:
            |
            | Validate & Preview = hidden
            | Import Products    = hidden
            | Done               = visible
            |
            |--------------------------------------------------------------------------
            */

            if (this.elements.importPreviewBtn) {

                this.elements.importPreviewBtn.classList.add(
                    'd-none'
                );

                this.elements.importPreviewBtn.disabled =
                    true;
            }

            if (this.elements.importConfirmBtn) {

                this.elements.importConfirmBtn.classList.add(
                    'd-none'
                );

                this.elements.importConfirmBtn.disabled =
                    true;
            }

            if (this.elements.importDoneBtn) {

                this.elements.importDoneBtn.classList.remove(
                    'd-none'
                );

                this.elements.importDoneBtn.disabled =
                    false;
            }

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

            this.setImportLoading(false);

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

