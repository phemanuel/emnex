<div
    class="offcanvas offcanvas-end low-stock-inspector"
    tabindex="-1"
    id="lowStockInspector"
    aria-labelledby="lowStockInspectorLabel"
>


    {{-- ==========================================================
    HEADER
    =========================================================== --}}


    <div class="offcanvas-header">


        <div>


            <div class="d-flex align-items-center gap-2 mb-1">


                <span class="low-stock-inspector-icon">


                    <i class="bi bi-exclamation-triangle"></i>


                </span>


                <h5
                    class="offcanvas-title mb-0"
                    id="lowStockInspectorLabel"
                >

                    Low Stock Details

                </h5>


            </div>


            <small class="text-muted">

                Inventory and replenishment information

            </small>


        </div>


        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>


    </div>



    {{-- ==========================================================
    BODY
    =========================================================== --}}


    <div class="offcanvas-body">


        {{-- ==========================================================
        PRODUCT SUMMARY
        =========================================================== --}}


        <div class="low-stock-inspector-product mb-4">


            <div class="low-stock-inspector-product-image">


                <img
                    id="lowStockInspectorImage"
                    src="{{ asset('uploads/products/no-image.png') }}"
                    alt="Product"
                >


                <div
                    class="low-stock-inspector-product-placeholder"
                    id="lowStockInspectorImagePlaceholder"
                >


                    <i class="bi bi-box-seam"></i>


                </div>


            </div>


            <div class="flex-grow-1">


                <h6
                    id="lowStockInspectorName"
                    class="mb-1"
                >

                    -

                </h6>


                <small
                    id="lowStockInspectorSku"
                    class="text-muted"
                >

                    -

                </small>


            </div>


        </div>



        {{-- ==========================================================
        STOCK ALERT
        =========================================================== --}}


        <div
            class="low-stock-alert-card mb-4"
            id="lowStockInspectorAlert"
        >


            <div class="low-stock-alert-icon">


                <i
                    class="bi bi-exclamation-triangle"
                    id="lowStockInspectorAlertIcon"
                ></i>


            </div>


            <div>


                <strong id="lowStockInspectorStatus">

                    Low Stock

                </strong>


                <small
                    class="d-block"
                    id="lowStockInspectorAlertMessage"
                >

                    This product requires replenishment.

                </small>


            </div>


        </div>



        {{-- ==========================================================
        STOCK INFORMATION
        =========================================================== --}}


        <div class="low-stock-inspector-card mb-4">


            <h6 class="mb-3">

                Stock Information

            </h6>



            <div class="low-stock-inspector-row">


                <span>

                    Branch

                </span>


                <strong id="lowStockInspectorBranch">

                    -

                </strong>


            </div>



            <div class="low-stock-inspector-row">


                <span>

                    Current Quantity

                </span>


                <strong id="lowStockInspectorQuantity">

                    -

                </strong>


            </div>



            <div class="low-stock-inspector-row">


                <span>

                    Reserved

                </span>


                <strong id="lowStockInspectorReserved">

                    -

                </strong>


            </div>



            <div class="low-stock-inspector-row">


                <span>

                    Available

                </span>


                <strong id="lowStockInspectorAvailable">

                    -

                </strong>


            </div>



            <div class="low-stock-inspector-row">


                <span>

                    Reorder Level

                </span>


                <strong id="lowStockInspectorReorder">

                    -

                </strong>


            </div>



            <div class="low-stock-inspector-row low-stock-inspector-shortage">


                <span>

                    Replenishment Needed

                </span>


                <strong id="lowStockInspectorShortage">

                    -

                </strong>


            </div>


        </div>



        {{-- ==========================================================
        PRODUCT INFORMATION
        =========================================================== --}}


        <div class="low-stock-inspector-card mb-4">


            <h6 class="mb-3">

                Product Information

            </h6>



            <div class="low-stock-inspector-row">


                <span>

                    Product Code

                </span>


                <strong id="lowStockInspectorProductCode">

                    -

                </strong>


            </div>



            <div class="low-stock-inspector-row">


                <span>

                    SKU

                </span>


                <strong id="lowStockInspectorProductSku">

                    -

                </strong>


            </div>



            <div class="low-stock-inspector-row">


                <span>

                    Barcode

                </span>


                <strong id="lowStockInspectorBarcode">

                    -

                </strong>


            </div>



            <div class="low-stock-inspector-row">


                <span>

                    Category

                </span>


                <strong id="lowStockInspectorCategory">

                    -

                </strong>


            </div>



            <div class="low-stock-inspector-row">


                <span>

                    Unit

                </span>


                <strong id="lowStockInspectorUnit">

                    -

                </strong>


            </div>


        </div>



        {{-- ==========================================================
        STOCK LEVEL
        =========================================================== --}}


        <div class="low-stock-inspector-card mb-4">


            <div class="d-flex align-items-center justify-content-between mb-3">


                <h6 class="mb-0">

                    Stock Level

                </h6>


                <span
                    class="badge"
                    id="lowStockInspectorLevelBadge"
                >

                    Low Stock

                </span>


            </div>


            <div class="low-stock-progress">


                <div
                    class="low-stock-progress-bar"
                    id="lowStockInspectorProgress"
                    style="width: 0%;"
                ></div>


            </div>


            <div class="d-flex justify-content-between mt-2">


                <small class="text-muted">

                    Current

                    <strong id="lowStockInspectorProgressQuantity">

                        0

                    </strong>

                </small>


                <small class="text-muted">

                    Reorder

                    <strong id="lowStockInspectorProgressReorder">

                        0

                    </strong>

                </small>


            </div>


        </div>



        {{-- ==========================================================
        RECENT MOVEMENTS
        =========================================================== --}}


        <div class="low-stock-inspector-card">


            <div class="d-flex align-items-center justify-content-between mb-3">


                <h6 class="mb-0">

                    Recent Movements

                </h6>


                <span class="text-muted small">

                    Latest 10

                </span>


            </div>


            <div id="lowStockMovementList">


                <div class="low-stock-movement-empty">


                    <i class="bi bi-clock-history"></i>


                    <p class="text-muted mb-0">

                        No movements available.

                    </p>


                </div>


            </div>


        </div>


    </div>


    {{-- ==========================================================
    FOOTER
    =========================================================== --}}


    <div class="offcanvas-footer">


        @permission('inventory.adjust_stock')


            <a
                href="{{ route('stock.index') }}"
                class="btn btn-primary"
            >

                <i class="bi bi-sliders me-2"></i>

                Adjust Stock

            </a>


        @endpermission


    </div>


</div>