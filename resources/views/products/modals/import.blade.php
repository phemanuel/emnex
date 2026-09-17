{{-- ======================================================
    PRODUCT IMPORT MODAL
======================================================= --}}

<div
    class="modal fade"
    id="productImportModal"
    tabindex="-1"
    aria-labelledby="productImportModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content product-import-modal">

            {{-- ==================================================
                MODAL HEADER
            =================================================== --}}
            <div class="modal-header product-import-header">

                <div>

                    <div class="product-import-title-row">

                        <div class="product-import-icon">
                            <i class="bi bi-cloud-arrow-up"></i>
                        </div>

                        <div>

                            <h5
                                class="modal-title"
                                id="productImportModalLabel"
                            >
                                Import Products
                            </h5>

                            <p class="product-import-subtitle mb-0">
                                Add multiple products to your catalog using Excel or CSV.
                            </p>

                        </div>

                    </div>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>



            {{-- ==================================================
                MODAL BODY
            =================================================== --}}
            <div class="modal-body product-import-body">


                {{-- ==================================================
                    STEP INDICATOR
                =================================================== --}}
                <div class="product-import-steps">

                    <div
                        class="product-import-step active"
                        id="productImportStepIndicator1"
                    >

                        <span class="product-import-step-number">
                            1
                        </span>

                        <div>
                            <strong>
                                Upload
                            </strong>

                            <small>
                                Select your file
                            </small>
                        </div>

                    </div>


                    <div class="product-import-step-line"></div>


                    <div
                        class="product-import-step"
                        id="productImportStepIndicator2"
                    >

                        <span class="product-import-step-number">
                            2
                        </span>

                        <div>
                            <strong>
                                Preview
                            </strong>

                            <small>
                                Review your products
                            </small>
                        </div>

                    </div>


                    <div class="product-import-step-line"></div>


                    <div
                        class="product-import-step"
                        id="productImportStepIndicator3"
                    >

                        <span class="product-import-step-number">
                            3
                        </span>

                        <div>
                            <strong>
                                Import
                            </strong>

                            <small>
                                Add to catalog
                            </small>
                        </div>

                    </div>

                </div>



                {{-- ==================================================
                    GLOBAL ERROR
                =================================================== --}}
                <div
                    id="productImportError"
                    class="alert alert-danger product-import-alert d-none"
                    role="alert"
                >

                    <div class="d-flex align-items-start gap-2">

                        <i class="bi bi-exclamation-triangle-fill"></i>

                        <div id="productImportErrorMessage">
                            An error occurred while processing the import.
                        </div>

                    </div>

                </div>



                {{-- ==================================================
                    STEP 1 — UPLOAD
                =================================================== --}}
                <div
                    id="productImportUploadStep"
                    class="product-import-panel"
                >

                    <div class="product-import-upload-layout">


                        {{-- ==================================================
                            FILE DROPZONE
                        =================================================== --}}
                        <div
                            id="productImportDropzone"
                            class="product-import-dropzone"
                        >

                            <input
                                type="file"
                                id="productImportFile"
                                class="d-none"
                                accept=".xlsx,.xls,.csv"
                            >


                            <div class="product-import-upload-icon">

                                <i class="bi bi-file-earmark-spreadsheet"></i>

                            </div>


                            <h6>
                                Choose your product file
                            </h6>


                            <p>
                                Drag and drop your Excel or CSV file here,
                                or click to browse.
                            </p>


                            <button
                                type="button"
                                id="productImportBrowseBtn"
                                class="btn btn-outline-primary"
                            >
                                <i class="bi bi-folder2-open me-2"></i>
                                Browse File
                            </button>


                            <div
                                id="productImportSelectedFile"
                                class="product-import-selected-file d-none"
                            >

                                <div class="product-import-selected-file-icon">

                                    <i class="bi bi-file-earmark-check"></i>

                                </div>


                                <div class="product-import-selected-file-info">

                                    <strong id="productImportSelectedFileName">
                                        product-import.xlsx
                                    </strong>

                                    <span id="productImportSelectedFileSize">
                                        0 KB
                                    </span>

                                </div>


                                <button
                                    type="button"
                                    id="productImportRemoveFile"
                                    class="btn btn-sm btn-light"
                                    aria-label="Remove selected file"
                                >
                                    <i class="bi bi-x-lg"></i>
                                </button>

                            </div>

                        </div>



                        {{-- ==================================================
                            IMPORT INFORMATION
                        =================================================== --}}
                        <div class="product-import-info-card">

                            <div class="product-import-info-header">

                                <div class="product-import-info-icon">
                                    <i class="bi bi-info-circle"></i>
                                </div>

                                <div>

                                    <h6>
                                        Before you import
                                    </h6>

                                    <p>
                                        Prepare your spreadsheet using the
                                        supported columns.
                                    </p>

                                </div>

                            </div>


                            <ul class="product-import-requirements">

                                <li>
                                    <i class="bi bi-check2"></i>
                                    Product name is required.
                                </li>

                                <li>
                                    <i class="bi bi-check2"></i>
                                    Category and unit must already exist.
                                </li>

                                <li>
                                    <i class="bi bi-check2"></i>
                                    Cost, selling and minimum stock values are required.
                                </li>

                                <li>
                                    <i class="bi bi-check2"></i>
                                    SKU and barcode must be unique.
                                </li>

                                <li>
                                    <i class="bi bi-check2"></i>
                                    Product codes are generated automatically.
                                </li>

                                <li>
                                    <i class="bi bi-check2"></i>
                                    Opening stock is added to Head Office.
                                </li>

                            </ul>


                            <div class="product-import-template-links">

                                <span>
                                    Need a template?
                                </span>


                                <div class="d-flex flex-wrap gap-2">

                                    <a
                                        href="{{ route('products.import.template.excel') }}"
                                        class="btn btn-sm btn-light"
                                        id="productImportExcelTemplateBtn"
                                    >
                                        <i class="bi bi-file-earmark-excel me-1"></i>
                                        Excel Template
                                    </a>


                                    <a
                                        href="{{ route('products.import.template.csv') }}"
                                        class="btn btn-sm btn-light"
                                        id="productImportCsvTemplateBtn"
                                    >
                                        <i class="bi bi-filetype-csv me-1"></i>
                                        CSV Template
                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>



                    {{-- ==================================================
                        UPLOAD VALIDATION
                    =================================================== --}}
                    <div
                        id="productImportUploadValidation"
                        class="product-import-upload-validation d-none"
                    >

                        <div class="product-import-upload-validation-icon">
                            <i class="bi bi-exclamation-circle"></i>
                        </div>

                        <div>

                            <strong id="productImportUploadValidationTitle">
                                File validation failed
                            </strong>

                            <p
                                id="productImportUploadValidationMessage"
                                class="mb-0"
                            >
                                Please select a valid import file.
                            </p>

                        </div>

                    </div>

                </div>



                {{-- ==================================================
                    STEP 2 — PREVIEW
                =================================================== --}}
                <div
                    id="productImportPreviewStep"
                    class="product-import-panel d-none"
                >

                    {{-- ==================================================
                        SUMMARY CARDS
                    =================================================== --}}
                    <div class="product-import-summary">

                        <div class="product-import-summary-card">

                            <span class="summary-label">
                                Total Rows
                            </span>

                            <strong
                                id="productImportTotalCount"
                                class="summary-value"
                            >
                                0
                            </strong>

                        </div>


                        <div class="product-import-summary-card success">

                            <span class="summary-label">
                                Valid
                            </span>

                            <strong
                                id="productImportValidCount"
                                class="summary-value"
                            >
                                0
                            </strong>

                        </div>


                        <div class="product-import-summary-card warning">

                            <span class="summary-label">
                                Warnings
                            </span>

                            <strong
                                id="productImportWarningCount"
                                class="summary-value"
                            >
                                0
                            </strong>

                        </div>


                        <div class="product-import-summary-card danger">

                            <span class="summary-label">
                                Errors
                            </span>

                            <strong
                                id="productImportErrorCount"
                                class="summary-value"
                            >
                                0
                            </strong>

                        </div>

                    </div>



                    {{-- ==================================================
                        PREVIEW STATUS
                    =================================================== --}}
                    <div
                        id="productImportPreviewStatus"
                        class="product-import-preview-status"
                    >

                        <div class="product-import-preview-status-icon">
                            <i class="bi bi-check-circle"></i>
                        </div>

                        <div>

                            <strong id="productImportPreviewStatusTitle">
                                Ready to import
                            </strong>

                            <p
                                id="productImportPreviewStatusMessage"
                                class="mb-0"
                            >
                                Review the rows below before continuing.
                            </p>

                        </div>

                    </div>



                    {{-- ==================================================
                        PREVIEW TABLE
                    =================================================== --}}
                    <div class="product-import-preview-wrapper">

                        <div class="product-import-preview-header">

                            <div>

                                <h6>
                                    Product Preview
                                </h6>

                                <p class="mb-0">
                                    Review validation results for each row.
                                </p>

                            </div>

                            <span
                                id="productImportPreviewFileName"
                                class="product-import-preview-file"
                            ></span>

                        </div>


                        <div class="table-responsive">

                            <table
                                class="table product-import-preview-table"
                            >

                                <thead>

                                    <tr>

                                        <th>
                                            Row
                                        </th>

                                        <th>
                                            Status
                                        </th>

                                        <th>
                                            Product
                                        </th>

                                        <th>
                                            SKU
                                        </th>

                                        <th>
                                            Category
                                        </th>

                                        <th>
                                            Unit
                                        </th>

                                        <th>
                                            Cost
                                        </th>

                                        <th>
                                            Selling
                                        </th>

                                        <th>
                                            Stock
                                        </th>

                                        <th>
                                            Validation
                                        </th>

                                    </tr>

                                </thead>


                                <tbody id="productImportPreviewTableBody">

                                    {{-- Rows rendered by JavaScript --}}

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>



                {{-- ==================================================
                    STEP 3 — IMPORTING
                =================================================== --}}
                <div
                    id="productImportProcessingStep"
                    class="product-import-panel d-none"
                >

                    <div class="product-import-processing">

                        <div class="product-import-processing-icon">

                            <div
                                class="spinner-border"
                                role="status"
                                aria-hidden="true"
                            ></div>

                        </div>


                        <h5>
                            Importing products...
                        </h5>


                        <p>
                            Please keep this window open while your products
                            are being added to the catalog.
                        </p>


                        <div class="product-import-processing-progress">

                            <div
                                class="progress"
                                role="progressbar"
                                aria-label="Product import progress"
                            >

                                <div
                                    id="productImportProgressBar"
                                    class="progress-bar"
                                    style="width: 0%;"
                                ></div>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- ==================================================
                    STEP 4 — COMPLETE
                =================================================== --}}
                <div
                    id="productImportCompleteStep"
                    class="product-import-panel d-none"
                >

                    <div class="product-import-complete">

                        <div class="product-import-complete-icon">

                            <i class="bi bi-check-lg"></i>

                        </div>


                        <h5>
                            Products imported successfully
                        </h5>


                        <p>
                            Your products have been added to the catalog.
                        </p>


                        <div class="product-import-complete-count">

                            <strong id="productImportImportedCount">
                                0
                            </strong>

                            <span>
                                products imported
                            </span>

                        </div>


                        <div
                            id="productImportGeneratedProducts"
                            class="product-import-generated-products"
                        >

                            {{-- Generated product codes rendered by JavaScript --}}

                        </div>

                    </div>

                </div>



                {{-- ==================================================
                    LOADING OVERLAY
                =================================================== --}}
                <div
                    id="productImportLoading"
                    class="product-import-loading d-none"
                >

                    <div class="product-import-loading-content">

                        <div
                            class="spinner-border text-primary"
                            role="status"
                        ></div>

                        <span id="productImportLoadingMessage">
                            Processing import...
                        </span>

                    </div>

                </div>

            </div>



            {{-- ==================================================
                MODAL FOOTER
            =================================================== --}}
            <div class="modal-footer product-import-footer">


                {{-- Reset --}}
                <button
                    type="button"
                    id="productImportResetBtn"
                    class="btn btn-light me-auto"
                >
                    <i class="bi bi-arrow-counterclockwise me-1"></i>
                    Start Over
                </button>


                {{-- Cancel --}}
                <button
                    type="button"
                    id="productImportCancelBtn"
                    class="btn btn-light"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>


                {{-- Preview --}}
                <button
                    type="button"
                    id="productImportPreviewBtn"
                    class="btn btn-primary"
                    disabled
                >
                    <i class="bi bi-search me-2"></i>
                    Validate & Preview
                </button>


                {{-- Import --}}
                <button
                    type="button"
                    id="productImportConfirmBtn"
                    class="btn btn-primary d-none"
                    disabled
                >
                    <i class="bi bi-cloud-arrow-up me-2"></i>
                    Import Products
                </button>


                {{-- Complete --}}
                <button
                    type="button"
                    id="productImportDoneBtn"
                    class="btn btn-primary d-none"
                    data-bs-dismiss="modal"
                >
                    <i class="bi bi-check2 me-2"></i>
                    Done
                </button>

            </div>

        </div>

    </div>
</div>

