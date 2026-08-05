<div class="offcanvas offcanvas-end product-inspector"
     tabindex="-1"
     id="productInspector"
     aria-labelledby="productInspectorLabel">

    <div class="offcanvas-header border-bottom">

        <h5 class="offcanvas-title"
            id="productInspectorLabel">

            Product Details

        </h5>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas"
                aria-label="Close">
        </button>

    </div>

    <div class="offcanvas-body">

        {{-- ===========================================
            PRODUCT IMAGE
        ============================================ --}}

        <div class="text-center mb-4">

            <img src="{{ asset('assets/images/no-image.png') }}"
                 id="inspector-image"
                 class="inspector-product-image"
                 alt="Product Image">

        </div>

        {{-- ===========================================
            BASIC INFORMATION
        ============================================ --}}

        <div class="inspector-section">

            <h6>
                Basic Information
            </h6>

            <div class="inspector-row">

                <span>Name</span>

                <strong id="inspector-name">
                    -
                </strong>

            </div>

            <div class="inspector-row">

                <span>Product Code</span>

                <strong id="inspector-product-code">
                    -
                </strong>

            </div>

            <div class="inspector-row">

                <span>Status</span>

                <span id="inspector-status">
                    -
                </span>

            </div>

        </div>

        {{-- ===========================================
            CLASSIFICATION
        ============================================ --}}

        <div class="inspector-section">

            <h6>
                Classification
            </h6>

            <div class="inspector-row">

                <span>Category</span>

                <span id="inspector-category">
                    -
                </span>

            </div>

            <div class="inspector-row">

                <span>Unit</span>

                <span id="inspector-unit">
                    -
                </span>

            </div>

            <div class="inspector-row">

                <span>Tax Rate</span>

                <span id="inspector-tax-rate">
                    -
                </span>

            </div>

            <div class="inspector-row">

                <span>Discount</span>

                <span id="inspector-discount">
                    -
                </span>

            </div>

        </div>

        {{-- ===========================================
            IDENTIFIERS
        ============================================ --}}

        <div class="inspector-section">

            <h6>
                Identifiers
            </h6>

            <div class="inspector-row">

                <span>SKU</span>

                <span id="inspector-sku">
                    -
                </span>

            </div>

            <div class="inspector-row">

                <span>Barcode</span>

                <span id="inspector-barcode">
                    -
                </span>

            </div>

            <div class="inspector-row">

                <span>QR Code</span>

                <span id="inspector-qr-code">
                    -
                </span>

            </div>

        </div>

                {{-- ===========================================
            PRICING
        ============================================ --}}

        <div class="inspector-section">

            <h6>
                Pricing
            </h6>

            <div class="inspector-row">

                <span>Cost Price</span>

                <strong id="inspector-cost-price">
                    -
                </strong>

            </div>

            <div class="inspector-row">

                <span>Selling Price</span>

                <strong id="inspector-selling-price">
                    -
                </strong>

            </div>

            <div class="inspector-row">

                <span>Profit</span>

                <strong id="inspector-profit">
                    -
                </strong>

            </div>

            <div class="inspector-row">

                <span>Profit Margin</span>

                <strong id="inspector-margin">
                    -
                </strong>

            </div>

        </div>





        {{-- ===========================================
            INVENTORY
        ============================================ --}}

        <div class="inspector-section">

            <h6>
                Inventory
            </h6>

            <div class="inspector-row">

                <span>Current Stock</span>

                <strong id="inspector-stock">
                    -
                </strong>

            </div>

            <div class="inspector-row">

                <span>Stock Status</span>

                <span id="inspector-stock-status">
                    -
                </span>

            </div>

            <div class="inspector-row">

                <span>Minimum Stock</span>

                <span id="inspector-minimum-stock">
                    -
                </span>

            </div>

            <div class="inspector-row">

                <span>Maximum Stock</span>

                <span id="inspector-maximum-stock">
                    -
                </span>

            </div>

            <div class="inspector-row">

                <span>Weight</span>

                <span id="inspector-weight">
                    -
                </span>

            </div>

            <div class="inspector-row">

                <span>Expiry Date</span>

                <span id="inspector-expiry-date">
                    -
                </span>

            </div>

        </div>





        {{-- ===========================================
            PRODUCT DETAILS
        ============================================ --}}

        <div class="inspector-section">

            <h6>
                Product Details
            </h6>

            <div class="inspector-row">

                <span>Brand</span>

                <span id="inspector-brand">
                    -
                </span>

            </div>

            <div class="inspector-row">

                <span>Manufacturer</span>

                <span id="inspector-manufacturer">
                    -
                </span>

            </div>

            <div class="mt-3">

                <label class="small text-muted d-block mb-2">

                    Description

                </label>

                <div id="inspector-description"
                     class="inspector-description">

                    -

                </div>

            </div>

        </div>





        {{-- ===========================================
            SYSTEM INFORMATION
        ============================================ --}}

        <div class="inspector-section">

            <h6>
                System Information
            </h6>

            <div class="inspector-row">

                <span>Created</span>

                <span id="inspector-created">
                    -
                </span>

            </div>

            <div class="inspector-row">

                <span>Last Updated</span>

                <span id="inspector-updated">
                    -
                </span>

            </div>

        </div>

    </div> {{-- /.offcanvas-body --}}

</div> {{-- /.offcanvas --}}