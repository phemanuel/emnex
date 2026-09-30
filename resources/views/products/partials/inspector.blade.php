@php

    /*
    |--------------------------------------------------------------------------
    | Product Capabilities
    |--------------------------------------------------------------------------
    */

    $productFieldModes =
        $productFieldModes
        ?? [];


    $fieldVisible =
        fn (string $field) =>
            (
                $productFieldModes[$field]
                ?? 'optional'
            ) !== 'hidden';


    /*
    |--------------------------------------------------------------------------
    | Product Stock Settings
    |--------------------------------------------------------------------------
    */

    $productStockSettings =
        $productStockSettings
        ?? [];


    $trackStockDefault =
        (bool) (
            $productStockSettings['default']
            ?? true
        );


    $trackStockChangeable =
        (bool) (
            $productStockSettings['changeable']
            ?? false
        );


    $stockFeatureAvailable =
        $trackStockDefault
        ||
        $trackStockChangeable;


    /*
    |--------------------------------------------------------------------------
    | Section Visibility
    |--------------------------------------------------------------------------
    */

    $showClassificationSection =
        $fieldVisible('product_category_id')
        ||
        $fieldVisible('unit_id')
        ||
        $fieldVisible('tax_rate_id')
        ||
        $fieldVisible('discount_id');


    $showIdentifiersSection =
        $fieldVisible('sku')
        ||
        $fieldVisible('barcode')
        ||
        $fieldVisible('qr_code');


    $showPricingSection =
        $fieldVisible('cost_price')
        ||
        $fieldVisible('selling_price');


    $showInventorySection =
        $stockFeatureAvailable
        ||
        $fieldVisible('weight')
        ||
        $fieldVisible('expiry_date');


    $showProductDetailsSection =
        $fieldVisible('brand')
        ||
        $fieldVisible('manufacturer')
        ||
        $fieldVisible('description');

@endphp


<div
    class="offcanvas offcanvas-end product-inspector"
    tabindex="-1"
    id="productInspector"
    aria-labelledby="productInspectorLabel"
>


    {{-- =================================================
        HEADER
    ================================================= --}}

    <div class="offcanvas-header border-bottom">

        <h5
            class="offcanvas-title"
            id="productInspectorLabel"
        >
            Product Details
        </h5>


        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>

    </div>



    <div class="offcanvas-body">


        {{-- =================================================
            PRODUCT IMAGE
        ================================================= --}}

        @if(
            $fieldVisible(
                'image'
            )
        )

            <div class="text-center mb-4">

                <img
                    src="{{ asset('assets/images/no-image.png') }}"
                    id="inspector-image"
                    class="inspector-product-image"
                    alt="Product Image"
                >

            </div>

        @endif



        {{-- =================================================
            BASIC INFORMATION
        ================================================= --}}

        <div class="inspector-section">

            <h6>
                Basic Information
            </h6>


            <div class="inspector-row">

                <span>
                    Name
                </span>

                <strong id="inspector-name">
                    -
                </strong>

            </div>


            <div class="inspector-row">

                <span>
                    Product Code
                </span>

                <strong id="inspector-product-code">
                    -
                </strong>

            </div>


            <div class="inspector-row">

                <span>
                    Status
                </span>

                <span id="inspector-status">
                    -
                </span>

            </div>

        </div>



        {{-- =================================================
            CLASSIFICATION
        ================================================= --}}

        @if(
            $showClassificationSection
        )

            <div class="inspector-section">

                <h6>
                    Classification
                </h6>


                @if(
                    $fieldVisible(
                        'product_category_id'
                    )
                )

                    <div class="inspector-row">

                        <span>
                            Category
                        </span>

                        <span id="inspector-category">
                            -
                        </span>

                    </div>

                @endif


                @if(
                    $fieldVisible(
                        'unit_id'
                    )
                )

                    <div class="inspector-row">

                        <span>
                            Unit
                        </span>

                        <span id="inspector-unit">
                            -
                        </span>

                    </div>

                @endif


                @if(
                    $fieldVisible(
                        'tax_rate_id'
                    )
                )

                    <div class="inspector-row">

                        <span>
                            Tax Rate
                        </span>

                        <span id="inspector-tax-rate">
                            -
                        </span>

                    </div>

                @endif


                @if(
                    $fieldVisible(
                        'discount_id'
                    )
                )

                    <div class="inspector-row">

                        <span>
                            Discount
                        </span>

                        <span id="inspector-discount">
                            -
                        </span>

                    </div>

                @endif

            </div>

        @endif



        {{-- =================================================
            IDENTIFIERS
        ================================================= --}}

        @if(
            $showIdentifiersSection
        )

            <div class="inspector-section">

                <h6>
                    Identifiers
                </h6>


                @if(
                    $fieldVisible(
                        'sku'
                    )
                )

                    <div class="inspector-row">

                        <span>
                            SKU
                        </span>

                        <span id="inspector-sku">
                            -
                        </span>

                    </div>

                @endif


                @if(
                    $fieldVisible(
                        'barcode'
                    )
                )

                    <div class="inspector-row">

                        <span>
                            Barcode
                        </span>

                        <span id="inspector-barcode">
                            -
                        </span>

                    </div>

                @endif


                @if(
                    $fieldVisible(
                        'qr_code'
                    )
                )

                    <div class="inspector-row">

                        <span>
                            QR Code
                        </span>

                        <span id="inspector-qr-code">
                            -
                        </span>

                    </div>

                @endif

            </div>

        @endif



        {{-- =================================================
            PRICING
        ================================================= --}}

        @if(
            $showPricingSection
        )

            <div class="inspector-section">

                <h6>
                    Pricing
                </h6>


                @if(
                    $fieldVisible(
                        'cost_price'
                    )
                )

                    <div class="inspector-row">

                        <span>
                            Cost Price
                        </span>

                        <strong id="inspector-cost-price">
                            -
                        </strong>

                    </div>

                @endif


                @if(
                    $fieldVisible(
                        'selling_price'
                    )
                )

                    <div class="inspector-row">

                        <span>
                            Selling Price
                        </span>

                        <strong id="inspector-selling-price">
                            -
                        </strong>

                    </div>

                @endif


                @if(
                    $fieldVisible('cost_price')
                    &&
                    $fieldVisible('selling_price')
                )

                    <div class="inspector-row">

                        <span>
                            Profit
                        </span>

                        <strong id="inspector-profit">
                            -
                        </strong>

                    </div>


                    <div class="inspector-row">

                        <span>
                            Profit Margin
                        </span>

                        <strong id="inspector-margin">
                            -
                        </strong>

                    </div>

                @endif

            </div>

        @endif



        {{-- =================================================
            INVENTORY
        ================================================= --}}

        @if($showInventorySection)

            <div class="inspector-section">

                <h6>
                    Inventory
                </h6>


                @if($stockFeatureAvailable)

                    <div
                        class="inspector-row"
                        data-inspector-stock-quantity
                    >

                        <span>
                            Current Stock
                        </span>

                        <strong id="inspector-stock">
                            -
                        </strong>

                    </div>


                    <div
                        class="inspector-row"
                        data-inspector-stock-status
                    >

                        <span>
                            Stock Status
                        </span>

                        <span id="inspector-stock-status">
                            -
                        </span>

                    </div>


                    @if(
                        $fieldVisible(
                            'minimum_stock'
                        )
                    )

                        <div
                            class="inspector-row"
                            data-inspector-stock-level
                        >

                            <span>
                                Minimum Stock
                            </span>

                            <span id="inspector-minimum-stock">
                                -
                            </span>

                        </div>

                    @endif


                    @if(
                        $fieldVisible(
                            'maximum_stock'
                        )
                    )

                        <div
                            class="inspector-row"
                            data-inspector-stock-level
                        >

                            <span>
                                Maximum Stock
                            </span>

                            <span id="inspector-maximum-stock">
                                -
                            </span>

                        </div>

                    @endif

                @endif


                @if(
                    $fieldVisible(
                        'weight'
                    )
                )

                    <div class="inspector-row">

                        <span>
                            Weight
                        </span>

                        <span id="inspector-weight">
                            -
                        </span>

                    </div>

                @endif


                @if(
                    $fieldVisible(
                        'expiry_date'
                    )
                )

                    <div class="inspector-row">

                        <span>
                            Expiry Date
                        </span>

                        <span id="inspector-expiry-date">
                            -
                        </span>

                    </div>

                @endif

            </div>

        @endif



        {{-- =================================================
            PRODUCT DETAILS
        ================================================= --}}

        @if(
            $showProductDetailsSection
        )

            <div class="inspector-section">

                <h6>
                    Product Details
                </h6>


                @if(
                    $fieldVisible(
                        'brand'
                    )
                )

                    <div class="inspector-row">

                        <span>
                            Brand
                        </span>

                        <span id="inspector-brand">
                            -
                        </span>

                    </div>

                @endif


                @if(
                    $fieldVisible(
                        'manufacturer'
                    )
                )

                    <div class="inspector-row">

                        <span>
                            Manufacturer
                        </span>

                        <span id="inspector-manufacturer">
                            -
                        </span>

                    </div>

                @endif


                @if(
                    $fieldVisible(
                        'description'
                    )
                )

                    <div class="mt-3">

                        <label
                            class="small text-muted d-block mb-2"
                        >
                            Description
                        </label>


                        <div
                            id="inspector-description"
                            class="inspector-description"
                        >
                            -
                        </div>

                    </div>

                @endif

            </div>

        @endif



        {{-- =================================================
            SYSTEM INFORMATION
        ================================================= --}}

        <div class="inspector-section">

            <h6>
                System Information
            </h6>


            <div class="inspector-row">

                <span>
                    Created
                </span>

                <span id="inspector-created">
                    -
                </span>

            </div>


            <div class="inspector-row">

                <span>
                    Last Updated
                </span>

                <span id="inspector-updated">
                    -
                </span>

            </div>

        </div>


    </div>

</div>