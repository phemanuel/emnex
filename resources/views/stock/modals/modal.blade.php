
<div class="modal fade"
     id="stockAdjustmentModal"
     tabindex="-1"
     aria-labelledby="stockModalTitle"
     aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content stock-adjustment-modal">


            {{-- ==========================================================
                HEADER
            =========================================================== --}}

            <div class="modal-header stock-adjustment-header">

                <div class="d-flex align-items-center gap-3">

                    <div class="stock-adjustment-header-icon">

                        <i class="bi bi-boxes"></i>

                    </div>


                    <div>

                        <h5 class="modal-title mb-1"
                            id="stockModalTitle">

                            Stock Adjustment

                        </h5>


                        <div class="stock-adjustment-subtitle">

                            Manage inventory movements for your products

                        </div>

                    </div>

                </div>


                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                </button>

            </div>


            {{-- ==========================================================
                BODY
            =========================================================== --}}

            <div class="modal-body stock-adjustment-body">

                <div class="row g-0 stock-adjustment-workspace">


                    {{-- ==================================================
                        LEFT
                        PRODUCT BROWSER
                    =================================================== --}}

                    <div class="col-lg-7 stock-product-section">


                        {{-- ==================================================
                            STEP 1 HEADER
                        =================================================== --}}

                        <div class="stock-workspace-header">

                            <div>

                                <div class="stock-step-label">
                                    STEP 1
                                </div>


                                <h6 class="mb-1">
                                    Select Product
                                </h6>


                                <span>
                                    Select a branch, then choose the product
                                    you want to update.
                                </span>

                            </div>


                            {{-- FILTER TOGGLE --}}

                            <div class="stock-section-actions">

                                <button
                                    type="button"
                                    class="btn btn-light stock-filter-toggle"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#stockAdjustmentFiltersPanel"
                                    aria-expanded="false"
                                    aria-controls="stockAdjustmentFiltersPanel"
                                    title="Show filters">

                                    <i class="bi bi-funnel"></i>

                                    <span>
                                        Filters
                                    </span>

                                </button>


                                <div class="stock-section-icon">

                                    <i class="bi bi-box-seam"></i>

                                </div>

                            </div>

                        </div>


                        {{-- ==================================================
                            BRANCH SELECTION
                        =================================================== --}}

                        @if(canManageAllBranches())

                            <div class="stock-branch-selection mb-3">


                                <label class="stock-filter-label">

                                    Branch

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>


                                <select
                                    class="form-select"
                                    id="stockAdjustmentBranchFilter">

                                    <option value="">
                                        Select Branch
                                    </option>

                                </select>


                                <div class="stock-filter-note mt-2">

                                    <i class="bi bi-info-circle"></i>

                                    <span>

                                        Select a branch first. Only products
                                        with stock records for the selected
                                        branch will be available.

                                    </span>

                                </div>


                            </div>

                        @endif


                        {{-- ==================================================
                            FILTER PANEL
                        =================================================== --}}

                        <div
                            id="stockAdjustmentFiltersPanel"
                            class="collapse stock-adjustment-filter-panel">


                            {{-- ==================================================
                                SEARCH
                            =================================================== --}}

                            <div class="stock-search-box mb-3">

                                <div class="input-group">

                                    <span class="input-group-text">

                                        <i class="bi bi-search"></i>

                                    </span>


                                    <input
                                        type="text"
                                        class="form-control"
                                        id="stockProductSearch"
                                        placeholder="Search by product, SKU or barcode...">

                                </div>

                            </div>


                            {{-- ==================================================
                                CATEGORY
                            =================================================== --}}

                            <div class="mb-3">

                                <label class="stock-filter-label">

                                    Category

                                </label>


                                <select
                                    class="form-select"
                                    id="stockAdjustmentCategoryFilter">

                                    <option value="">
                                        All Categories
                                    </option>

                                </select>

                            </div>


                            {{-- ==================================================
                                STOCK STATUS
                            =================================================== --}}

                            <div class="mb-3">

                                <label class="stock-filter-label">

                                    Stock Status

                                </label>


                                <select
                                    class="form-select"
                                    id="stockAdjustmentStatusFilter">

                                    <option value="">
                                        All Stock
                                    </option>

                                    <option value="in_stock">
                                        In Stock
                                    </option>

                                    <option value="low_stock">
                                        Low Stock
                                    </option>

                                    <option value="out_stock">
                                        Out Of Stock
                                    </option>

                                </select>

                            </div>


                        </div>


                        {{-- ==================================================
                            PRODUCT TABLE
                        =================================================== --}}

                        <div class="stock-product-table-wrapper">


                            <table class="table stock-product-table align-middle mb-0">

                                <thead>

                                    <tr>

                                        <th>
                                            Product
                                        </th>

                                        <th>
                                            Stock
                                        </th>

                                        <th>
                                            Price
                                        </th>

                                        <th class="text-end">
                                            Action
                                        </th>

                                    </tr>

                                </thead>


                                <tbody id="stockProductTable">

                                    <tr>

                                        <td
                                            colspan="4"
                                            class="text-center py-5">

                                            <div class="stock-table-empty">


                                                <div class="stock-empty-icon">

                                                    <i class="bi bi-box-seam"></i>

                                                </div>


                                                <strong>
                                                    Select a branch
                                                </strong>


                                                <span>

                                                    Choose a branch above to
                                                    load available products.

                                                </span>


                                            </div>

                                        </td>

                                    </tr>

                                </tbody>

                            </table>


                        </div>


                        {{-- ==================================================
                            PAGINATION
                        =================================================== --}}

                        <div
                            id="stockProductPagination"
                            class="stock-product-pagination">

                        </div>


                    </div>


                    {{-- ==================================================
                        RIGHT
                        TRANSACTION WORKSPACE
                    =================================================== --}}

                    <div class="col-lg-5 stock-transaction-section">


                        <div class="stock-transaction-panel">


                            {{-- ==================================================
                                TRANSACTION HEADER
                            =================================================== --}}

                            <div class="stock-transaction-header">

                                <div>

                                    <div class="stock-step-label">
                                        STEP 2
                                    </div>


                                    <h6>
                                        Adjustment Details
                                    </h6>


                                    <span>
                                        Define how the stock should change.
                                    </span>

                                </div>


                                <div class="stock-transaction-icon">

                                    <i class="bi bi-sliders2"></i>

                                </div>

                            </div>


                            {{-- ==================================================
                                SELECTED PRODUCT CARD
                            =================================================== --}}

                            <div class="selected-product-card">


                                <div class="selected-product-image">

                                    <img
                                        id="selectedProductImage"
                                        src=""
                                        class="d-none"
                                        alt="Product image">


                                    <i
                                        class="bi bi-box-seam"
                                        id="selectedProductPlaceholder">
                                    </i>

                                </div>


                                <div class="selected-product-details">

                                    <div class="selected-product-label">

                                        SELECTED PRODUCT

                                    </div>


                                    <h6 id="selectedProductName">

                                        No product selected

                                    </h6>


                                    <small id="selectedProductInfo">

                                        Choose a product from the list.

                                    </small>

                                </div>


                                <div class="selected-product-check">

                                    <i class="bi bi-check-circle-fill"></i>

                                </div>


                            </div>


                            {{-- ==================================================
                                HIDDEN VALUES
                            =================================================== --}}

                            <input
                                type="hidden"
                                id="stockProductId">


                            <input
                                type="hidden"
                                id="stockBranchId">


                            {{-- ==================================================
                                STOCK SNAPSHOT
                            =================================================== --}}

                            <div class="stock-snapshot-card">


                                <div class="snapshot-header">

                                    <span>
                                        STOCK SNAPSHOT
                                    </span>


                                    <i class="bi bi-bar-chart-line"></i>

                                </div>


                                <div class="snapshot-values">


                                    {{-- CURRENT STOCK --}}

                                    <div class="snapshot-value">

                                        <span>
                                            Current Stock
                                        </span>


                                        <strong id="currentStockQuantity">

                                            0

                                        </strong>


                                        <small>
                                            units
                                        </small>

                                    </div>


                                    <div class="snapshot-arrow">

                                        <i class="bi bi-arrow-right"></i>

                                    </div>


                                    {{-- PROJECTED STOCK --}}

                                    <div class="snapshot-value projected">

                                        <span>
                                            New Stock
                                        </span>


                                        <strong id="projectedStockQuantity">

                                            0

                                        </strong>


                                        <small>
                                            units
                                        </small>

                                    </div>


                                </div>


                            </div>


                            {{-- ==================================================
                                MOVEMENT FORM
                            =================================================== --}}

                            <div class="stock-form-section">


                                <div class="stock-form-section-title">

                                    <span>
                                        Movement Information
                                    </span>

                                </div>


                                {{-- MOVEMENT TYPE --}}

                                <div class="stock-form-group">

                                    <label class="form-label">

                                        Movement Type

                                        <span class="text-danger">
                                            *
                                        </span>

                                    </label>


                                    <select
                                        class="form-select"
                                        id="stockType">

                                        <option value="">
                                            Select movement type
                                        </option>


                                        <option value="Opening Stock">
                                            Opening Stock
                                        </option>


                                        <option value="Purchase">
                                            Purchase
                                        </option>


                                        <option value="Return">
                                            Return
                                        </option>


                                        <option value="Transfer">
                                            Transfer
                                        </option>


                                        <option value="Damage">
                                            Damage
                                        </option>


                                        <option value="Expired">
                                            Expired
                                        </option>

                                    </select>


                                    <div class="movement-help">

                                        <i class="bi bi-info-circle"></i>


                                        <span id="stockMovementHelp">

                                            Select the reason for this
                                            stock movement.

                                        </span>

                                    </div>

                                </div>


                                {{-- QUANTITY --}}

                                <div class="stock-form-group">

                                    <label class="form-label">

                                        Quantity

                                        <span class="text-danger">
                                            *
                                        </span>

                                    </label>


                                    <div class="quantity-input-wrapper">

                                        <input
                                            type="number"
                                            step="0.01"
                                            min="0.01"
                                            class="form-control"
                                            id="stockQuantity"
                                            placeholder="0.00">


                                        <span>
                                            units
                                        </span>

                                    </div>

                                </div>


                                {{-- REASON --}}

                                <div class="stock-form-group">

                                    <label class="form-label">

                                        Reason / Remarks

                                    </label>


                                    <textarea
                                        class="form-control"
                                        id="stockReason"
                                        rows="3"
                                        maxlength="255"
                                        placeholder="Explain the reason for this movement..."></textarea>

                                </div>


                            </div>


                            {{-- ==================================================
                                TRANSACTION NOTICE
                            =================================================== --}}

                            <div class="stock-transaction-notice">


                                <div class="notice-icon">

                                    <i class="bi bi-shield-check"></i>

                                </div>


                                <div>

                                    <strong>
                                        Inventory control
                                    </strong>


                                    <p>

                                        This change will update the selected
                                        branch's stock and create a movement
                                        record for audit purposes.

                                    </p>

                                </div>


                            </div>


                        </div>

                    </div>

                </div>

            </div>


            {{-- ==========================================================
                FOOTER
            =========================================================== --}}

            <div class="modal-footer stock-adjustment-footer">


                <div class="stock-footer-status">

                    <i class="bi bi-lock-fill"></i>

                    Inventory changes are tracked.

                </div>


                <div class="d-flex gap-2">


                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Cancel

                    </button>


                    <button
                        type="button"
                        class="btn btn-primary px-4"
                        id="saveStockBtn"
                        disabled>

                        <i class="bi bi-check2-circle me-1"></i>

                        Save Adjustment

                    </button>


                </div>


            </div>


        </div>

    </div>

</div>

