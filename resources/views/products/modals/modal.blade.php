@php

    $productFieldModes =
        $productFieldModes ?? [];


    $fieldMode =
        fn (string $field) =>
            $productFieldModes[$field]
            ?? 'optional';


    $fieldVisible =
        fn (string $field) =>
            $fieldMode($field) !== 'hidden';


    $fieldRequired =
        fn (string $field) =>
            $fieldMode($field) === 'required';


    $inventoryFields = [
        'minimum_stock',
        'maximum_stock',
        'opening_stock',
        'weight',
        'expiry_date',
    ];


    $showInventoryTab =
        collect($inventoryFields)
            ->contains(
                fn ($field) =>
                    $fieldVisible($field)
            );

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


    $inventoryFields = [
        'minimum_stock',
        'maximum_stock',
        'opening_stock',
        'weight',
        'expiry_date',
    ];


    $showInventoryTab =
        $trackStockChangeable
        ||
        collect(
            $inventoryFields
        )->contains(
            fn ($field) =>
                $fieldVisible(
                    $field
                )
        );

@endphp

<div class="modal fade"
     id="productModal"
     tabindex="-1"
     aria-hidden="true">


    <div class="modal-dialog modal-xl modal-dialog-centered">


        <div class="modal-content product-modal">


            <div class="modal-header">


                <h5 class="modal-title"
                    id="productModalTitle">

                    New Product

                </h5>



                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>


            </div>





            <form id="productForm"
                  enctype="multipart/form-data">


                @csrf


                <input type="hidden"
                       id="product_id"
                       name="product_id">





                <div class="modal-body">



                    <ul class="nav nav-tabs product-tabs">


                        <li class="nav-item">

                            <button class="nav-link active"
                                    data-bs-toggle="tab"
                                    data-bs-target="#general-tab"
                                    type="button">

                                General

                            </button>

                        </li>



                        <li class="nav-item">

                            <button class="nav-link"
                                    data-bs-toggle="tab"
                                    data-bs-target="#pricing-tab"
                                    type="button">

                                Pricing

                            </button>

                        </li>



                       @if($showInventoryTab)

                            <li class="nav-item">

                                <button
                                    class="nav-link"
                                    data-bs-toggle="tab"
                                    data-bs-target="#inventory-tab"
                                    type="button"
                                >
                                    Inventory
                                </button>

                            </li>

                        @endif



                        @if(
                            $fieldVisible('image')
                            &&
                            (
                                $productImageSettings['enabled']
                                ?? true
                            )
                        )

                            <li class="nav-item">

                                <button
                                    class="nav-link"
                                    data-bs-toggle="tab"
                                    data-bs-target="#image-tab"
                                    type="button"
                                >
                                    {{ (
                                        $productImageSettings['multiple']
                                        ?? false
                                    )
                                        ? 'Images'
                                        : 'Image'
                                    }}
                                </button>

                            </li>

                        @endif


                    </ul>





                    <div class="tab-content pt-4">



                        {{-- GENERAL --}}

                        <div class="tab-pane fade show active"
                             id="general-tab">


                            <div class="row g-3">


                                <div class="col-md-6">

                                   <label>
                                        Product Code

                                        @if($fieldRequired('product_code'))
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>

                                    <input type="text"
                                        id="product_code"
                                        name="product_code"
                                        class="form-control"
                                        readonly>

                                        <small class="text-muted">
                                            Product code is generated automatically.
                                        </small>

                                </div>




                               @if($fieldVisible('sku'))

                                    <div class="col-md-6">

                                        <label>
                                            SKU

                                            @if($fieldRequired('sku'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>

                                        <input
                                            type="text"
                                            id="sku"
                                            name="sku"
                                            class="form-control"
                                            @required($fieldRequired('sku'))
                                        >

                                    </div>

                                @endif



                                @if($fieldVisible('barcode'))

                                    <div class="col-md-6">

                                        <label>
                                            Barcode

                                            @if($fieldRequired('barcode'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>

                                        <input
                                            type="text"
                                            id="barcode"
                                            name="barcode"
                                            class="form-control"
                                            @required($fieldRequired('barcode'))
                                        >

                                    </div>

                                @endif



                                @if($fieldVisible('qr_code'))

                                    <div class="col-md-6">

                                        <label>
                                            QR Code

                                            @if($fieldRequired('qr_code'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>

                                        <input
                                            type="text"
                                            id="qr_code"
                                            name="qr_code"
                                            class="form-control"
                                            @required($fieldRequired('qr_code'))
                                        >

                                    </div>

                                @endif




                                @if($fieldVisible('name'))

                                    <div class="col-12">

                                        <label>
                                            Product Name

                                            @if($fieldRequired('name'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>

                                        <input
                                            type="text"
                                            id="name"
                                            name="name"
                                            class="form-control"
                                            @required($fieldRequired('name'))
                                        >

                                    </div>

                                @endif




                                @if($fieldVisible('description'))

                                    <div class="col-12">

                                        <label>
                                            Description

                                            @if($fieldRequired('description'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>

                                        <textarea
                                            id="description"
                                            name="description"
                                            class="form-control"
                                            rows="3"
                                            @required($fieldRequired('description'))
                                        ></textarea>

                                    </div>

                                @endif




                                @if($fieldVisible('product_category_id'))

                                    <div class="col-md-6">

                                        <label>
                                            Category

                                            @if($fieldRequired('product_category_id'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>

                                        <select
                                            id="product_category_id"
                                            name="product_category_id"
                                            class="form-select"
                                            @required(
                                                $fieldRequired(
                                                    'product_category_id'
                                                )
                                            )
                                        >

                                            <option value="">
                                                Select Category
                                            </option>

                                            @foreach($categories as $category)

                                                <option value="{{ $category->id }}">
                                                    {{ $category->name }}
                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                @endif




                                @if($fieldVisible('unit_id'))

                                    <div class="col-md-6">

                                        <label>
                                            Unit

                                            @if($fieldRequired('unit_id'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>

                                        <select
                                            id="unit_id"
                                            name="unit_id"
                                            class="form-select"
                                            @required($fieldRequired('unit_id'))
                                        >

                                            <option value="">
                                                Select Unit
                                            </option>

                                            @foreach($units as $unit)

                                                <option value="{{ $unit->id }}">
                                                    {{ $unit->name }}
                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                @endif




                                @if($fieldVisible('brand'))

                                    <div class="col-md-6">

                                        <label>
                                            Brand

                                            @if($fieldRequired('brand'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>

                                        <input
                                            type="text"
                                            id="brand"
                                            name="brand"
                                            class="form-control"
                                            @required($fieldRequired('brand'))
                                        >

                                    </div>

                                @endif




                                @if($fieldVisible('manufacturer'))

                                    <div class="col-md-6">

                                        <label>
                                            Manufacturer

                                            @if($fieldRequired('manufacturer'))
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>

                                        <input
                                            type="text"
                                            id="manufacturer"
                                            name="manufacturer"
                                            class="form-control"
                                            @required(
                                                $fieldRequired(
                                                    'manufacturer'
                                                )
                                            )
                                        >

                                    </div>

                                @endif


                            </div>


                        </div>

                        {{-- =================================================
                        PRICING TAB
                    ================================================= --}}

                    <div class="tab-pane fade"
                        id="pricing-tab">


                        <div class="row g-3">


                            @if($fieldVisible('cost_price'))

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Cost Price

                                        @if($fieldRequired('cost_price'))
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>

                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        id="cost_price"
                                        name="cost_price"
                                        class="form-control"
                                        @required(
                                            $fieldRequired(
                                                'cost_price'
                                            )
                                        )
                                    >

                                </div>

                            @endif




                            @if($fieldVisible('selling_price'))

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Selling Price

                                        @if($fieldRequired('selling_price'))
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>

                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        id="selling_price"
                                        name="selling_price"
                                        class="form-control"
                                        @required(
                                            $fieldRequired(
                                                'selling_price'
                                            )
                                        )
                                    >

                                </div>

                            @endif





                            @if($fieldVisible('tax_rate_id'))

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Tax Rate

                                        @if($fieldRequired('tax_rate_id'))
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>

                                    <select
                                        id="tax_rate_id"
                                        name="tax_rate_id"
                                        class="form-select"
                                        @required(
                                            $fieldRequired(
                                                'tax_rate_id'
                                            )
                                        )
                                    >

                                        <option value="">
                                            No Tax
                                        </option>

                                        @foreach($taxRates as $tax)

                                            <option value="{{ $tax->id }}">
                                                {{ $tax->name }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            @endif





                            @if($fieldVisible('discount_id'))

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Discount

                                        @if($fieldRequired('discount_id'))
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>

                                    <select
                                        id="discount_id"
                                        name="discount_id"
                                        class="form-select"
                                        @required(
                                            $fieldRequired(
                                                'discount_id'
                                            )
                                        )
                                    >

                                        <option value="">
                                            No Discount
                                        </option>

                                        @foreach($discounts as $discount)

                                            <option value="{{ $discount->id }}">
                                                {{ $discount->name }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            @endif



                        </div>


                    </div>


                    {{-- =================================================
                        INVENTORY TAB
                    ================================================= --}}
                    @if($showInventoryTab)

                    <div
                        class="tab-pane fade"
                        id="inventory-tab"
                        data-track-stock-default="{{ $trackStockDefault ? '1' : '0' }}"
                        data-track-stock-changeable="{{ $trackStockChangeable ? '1' : '0' }}"
                    >

                        <div class="row g-3">


                            {{-- =================================================
                                TRACK INVENTORY
                            ================================================= --}}

                            @if($trackStockChangeable)

                                <div class="col-12">

                                    <div class="border rounded p-3">

                                        <div class="form-check form-switch">

                                            <input
                                                type="hidden"
                                                name="track_stock"
                                                value="0"
                                            >

                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                role="switch"
                                                id="track_stock"
                                                name="track_stock"
                                                value="1"
                                                @checked($trackStockDefault)
                                            >

                                            <label
                                                class="form-check-label fw-semibold"
                                                for="track_stock"
                                            >
                                                Track Inventory
                                            </label>

                                        </div>


                                        <small class="text-muted d-block mt-1">

                                            Turn this off for services, fees or other items
                                            that do not have a physical stock quantity.

                                        </small>

                                    </div>

                                </div>

                            @endif



                            {{-- =================================================
                                MINIMUM STOCK
                            ================================================= --}}

                            @if($fieldVisible('minimum_stock'))

                                <div
                                    class="col-md-6
                                        {{ !$trackStockDefault ? 'd-none' : '' }}"
                                    data-stock-controlled-field
                                >

                                    <label class="form-label">

                                        Minimum Stock

                                        @if($fieldRequired('minimum_stock'))

                                            <span class="text-danger">*</span>

                                        @endif

                                    </label>


                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        id="minimum_stock"
                                        name="minimum_stock"
                                        value="0"
                                        class="form-control"
                                        data-stock-required="{{ $fieldRequired('minimum_stock') ? '1' : '0' }}"
                                        @required(
                                            $trackStockDefault
                                            &&
                                            $fieldRequired('minimum_stock')
                                        )
                                    >

                                </div>

                            @endif



                            {{-- =================================================
                                MAXIMUM STOCK
                            ================================================= --}}

                            @if($fieldVisible('maximum_stock'))

                                <div
                                    class="col-md-6
                                        {{ !$trackStockDefault ? 'd-none' : '' }}"
                                    data-stock-controlled-field
                                >

                                    <label class="form-label">

                                        Maximum Stock

                                        @if($fieldRequired('maximum_stock'))

                                            <span class="text-danger">*</span>

                                        @endif

                                    </label>


                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        id="maximum_stock"
                                        name="maximum_stock"
                                        value="1000"
                                        class="form-control"
                                        data-stock-required="{{ $fieldRequired('maximum_stock') ? '1' : '0' }}"
                                        @required(
                                            $trackStockDefault
                                            &&
                                            $fieldRequired('maximum_stock')
                                        )
                                    >

                                </div>

                            @endif



                            {{-- =================================================
                                OPENING STOCK
                            ================================================= --}}

                            @if($fieldVisible('opening_stock'))

                                <div
                                    class="col-md-6
                                        {{ !$trackStockDefault ? 'd-none' : '' }}"
                                    data-stock-controlled-field
                                    data-create-only-stock-field
                                >

                                    <label class="form-label">

                                        Opening Stock

                                        @if($fieldRequired('opening_stock'))

                                            <span class="text-danger">*</span>

                                        @endif

                                    </label>


                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        id="opening_stock"
                                        name="opening_stock"
                                        value="0"
                                        class="form-control"
                                        data-stock-required="{{ $fieldRequired('opening_stock') ? '1' : '0' }}"
                                    >


                                    <small class="text-muted">

                                        Initial stock quantity for Head Office.

                                    </small>

                                </div>

                            @endif



                            {{-- =================================================
                                WEIGHT
                            ================================================= --}}

                            @if($fieldVisible('weight'))

                                <div class="col-md-6">

                                    <label class="form-label">

                                        Weight

                                        @if($fieldRequired('weight'))

                                            <span class="text-danger">*</span>

                                        @endif

                                    </label>


                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        id="weight"
                                        name="weight"
                                        value="0"
                                        class="form-control"
                                        @required(
                                            $fieldRequired('weight')
                                        )
                                    >

                                </div>

                            @endif



                            {{-- =================================================
                                EXPIRY DATE
                            ================================================= --}}

                            @if($fieldVisible('expiry_date'))

                                <div class="col-md-6">

                                    <label class="form-label">

                                        Expiry Date

                                        @if($fieldRequired('expiry_date'))

                                            <span class="text-danger">*</span>

                                        @endif

                                    </label>


                                    <input
                                        type="date"
                                        id="expiry_date"
                                        name="expiry_date"
                                        class="form-control"
                                        @required(
                                            $fieldRequired('expiry_date')
                                        )
                                    >

                                </div>

                            @endif


                        </div>

                    </div>

                    @endif


                    {{-- =================================================
                        IMAGE TAB
                    ================================================= --}}

                    @if(
                        $fieldVisible('image')
                        &&
                        (
                            $productImageSettings['enabled']
                            ?? true
                        )
                    )

                        @php

                            $allowsMultipleImages =
                                (bool) (
                                    $productImageSettings['multiple']
                                    ?? false
                                );


                            $maxProductImages =
                                $allowsMultipleImages
                                    ? max(
                                        1,
                                        (int) (
                                            $productImageSettings['max_images']
                                            ?? 1
                                        )
                                    )
                                    : 1;

                        @endphp


                        <div
                            class="tab-pane fade"
                            id="image-tab"
                        >

                            <div class="row g-4">


                                {{-- =================================================
                                    IMAGE UPLOAD
                                ================================================= --}}

                                <div class="col-12">

                                    <label
                                        for="images"
                                        class="form-label"
                                    >

                                        {{ $allowsMultipleImages
                                            ? 'Product Images'
                                            : 'Product Image'
                                        }}

                                        @if($fieldRequired('image'))

                                            <span class="text-danger">
                                                *
                                            </span>

                                        @endif

                                    </label>


                                    <input
                                        type="file"
                                        id="images"
                                        name="images[]"
                                        class="form-control"
                                        accept="image/png,image/jpeg,image/webp"
                                        data-max-images="{{ $maxProductImages }}"
                                        data-multiple-images="{{ $allowsMultipleImages ? '1' : '0' }}"
                                        @if($allowsMultipleImages)
                                            multiple
                                        @endif
                                    >


                                    <div class="form-text">

                                        @if($allowsMultipleImages)

                                            Upload up to
                                            {{ $maxProductImages }}
                                            images.

                                            JPG, PNG or WEBP.
                                            Maximum 2MB per image.

                                        @else

                                            JPG, PNG or WEBP.
                                            Maximum 2MB.

                                        @endif

                                    </div>

                                </div>


                                {{-- =================================================
                                    EXISTING IMAGES
                                ================================================= --}}

                                <div
                                    class="col-12 d-none"
                                    id="existing-product-images-section"
                                >

                                    <div
                                        class="d-flex
                                            align-items-center
                                            justify-content-between
                                            mb-2"
                                    >

                                        <label class="form-label mb-0">

                                            Existing Images

                                        </label>


                                        <small
                                            class="text-muted"
                                            id="existing-product-images-count"
                                        >
                                            0 images
                                        </small>

                                    </div>


                                    <div
                                        id="existing-product-images"
                                        class="row g-3"
                                    >
                                        {{-- Filled by product.js in edit mode --}}
                                    </div>

                                </div>


                                {{-- =================================================
                                    NEW IMAGE PREVIEWS
                                ================================================= --}}

                                <div
                                    class="col-12 d-none"
                                    id="new-product-images-section"
                                >

                                    <div
                                        class="d-flex
                                            align-items-center
                                            justify-content-between
                                            mb-2"
                                    >

                                        <label class="form-label mb-0">

                                            New Images

                                        </label>


                                        <small
                                            class="text-muted"
                                            id="new-product-images-count"
                                        >
                                            0 selected
                                        </small>

                                    </div>


                                    <div
                                        id="new-product-images"
                                        class="row g-3"
                                    >
                                        {{-- Filled by product.js --}}
                                    </div>

                                </div>


                                {{-- =================================================
                                    GALLERY HELP
                                ================================================= --}}

                                @if($allowsMultipleImages)

                                    <div class="col-12">

                                        <div
                                            class="alert
                                                alert-light
                                                border
                                                mb-0"
                                        >

                                            <div
                                                class="d-flex
                                                    gap-2
                                                    align-items-start"
                                            >

                                                <i
                                                    class="bi
                                                        bi-images
                                                        mt-1"
                                                ></i>


                                                <div>

                                                    <div class="fw-semibold">
                                                        Product gallery
                                                    </div>

                                                    <small class="text-muted">

                                                        Select the image you want
                                                        customers to see first as the
                                                        primary image.

                                                    </small>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                @endif


                                {{-- =================================================
                                    PRIMARY IMAGE VALUES
                                ================================================= --}}

                                <input
                                    type="hidden"
                                    id="primary_image_index"
                                    name="primary_image_index"
                                    value=""
                                >


                                <input
                                    type="hidden"
                                    id="primary_image_id"
                                    name="primary_image_id"
                                    value=""
                                >


                            </div>

                        </div>

                    @endif

                </div> {{-- end tab-content --}}

                    {{-- =================================================
                        PRODUCT STATUS
                    ================================================= --}}

                    <div class="product-status-section mt-4">


                        <div class="form-check form-switch">


                            <input class="form-check-input"
                                type="checkbox"
                                id="status"
                                name="status"
                                value="1"
                                checked>


                            <label class="form-check-label"
                                for="status">

                                Active Product

                            </label>


                        </div>


                    </div>



                    </div> {{-- end modal-body --}}





                    {{-- =================================================
                        FOOTER
                    ================================================= --}}

                    <div class="modal-footer">


                        <button type="button"
                                class="btn btn-light"
                                data-bs-dismiss="modal">

                            Cancel

                        </button>





                        <button type="submit"
                                id="saveProductBtn"
                                class="btn btn-primary">


                            <i class="bi bi-check-circle me-2"></i>

                            Save Product


                        </button>


                    </div>



                    </form>


                    </div> {{-- modal-content --}}


                    </div> {{-- modal-dialog --}}


                    </div> {{-- modal --}}