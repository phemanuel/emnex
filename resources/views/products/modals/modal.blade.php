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



                        <li class="nav-item">

                            <button class="nav-link"
                                    data-bs-toggle="tab"
                                    data-bs-target="#inventory-tab"
                                    type="button">

                                Inventory

                            </button>

                        </li>



                        <li class="nav-item">

                            <button class="nav-link"
                                    data-bs-toggle="tab"
                                    data-bs-target="#image-tab"
                                    type="button">

                                Image

                            </button>

                        </li>


                    </ul>





                    <div class="tab-content pt-4">



                        {{-- GENERAL --}}

                        <div class="tab-pane fade show active"
                             id="general-tab">


                            <div class="row g-3">


                                <div class="col-md-6">

                                    <label>
                                        Product Code *
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




                                <div class="col-md-6">

                                    <label>
                                        SKU
                                    </label>

                                    <input type="text"
                                           id="sku"
                                           name="sku"
                                           class="form-control">

                                </div>



                                <div class="col-md-6">

                                    <label>
                                        Barcode
                                    </label>

                                    <input type="text"
                                           id="barcode"
                                           name="barcode"
                                           class="form-control">

                                </div>



                                <div class="col-md-6">

                                    <label>
                                        QR Code
                                    </label>

                                    <input type="text"
                                           id="qr_code"
                                           name="qr_code"
                                           class="form-control">

                                </div>




                                <div class="col-12">

                                    <label>
                                        Product Name *
                                    </label>

                                    <input type="text"
                                           id="name"
                                           name="name"
                                           class="form-control">

                                </div>




                                <div class="col-12">

                                    <label>
                                        Description
                                    </label>


                                    <textarea
                                        id="description"
                                        name="description"
                                        class="form-control"
                                        rows="3"></textarea>


                                </div>




                                <div class="col-md-6">

                                    <label>
                                        Category *
                                    </label>


                                    <select id="product_category_id"
                                            name="product_category_id"
                                            class="form-select">


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




                                <div class="col-md-6">

                                    <label>
                                        Unit *
                                    </label>


                                    <select id="unit_id"
                                            name="unit_id"
                                            class="form-select">


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




                                <div class="col-md-6">

                                    <label>
                                        Brand
                                    </label>


                                    <input type="text"
                                           id="brand"
                                           name="brand"
                                           class="form-control">

                                </div>




                                <div class="col-md-6">

                                    <label>
                                        Manufacturer
                                    </label>


                                    <input type="text"
                                           id="manufacturer"
                                           name="manufacturer"
                                           class="form-control">

                                </div>


                            </div>


                        </div>

                        {{-- =================================================
    PRICING TAB
================================================= --}}

<div class="tab-pane fade"
     id="pricing-tab">


    <div class="row g-3">


        <div class="col-md-6">

            <label class="form-label">
                Cost Price *
            </label>


            <input type="number"
                   step="0.01"
                   id="cost_price"
                   name="cost_price"
                   class="form-control">

        </div>




        <div class="col-md-6">

            <label class="form-label">
                Selling Price *
            </label>


            <input type="number"
                   step="0.01"
                   id="selling_price"
                   name="selling_price"
                   class="form-control">

        </div>





        <div class="col-md-6">


            <label class="form-label">
                Tax Rate
            </label>


            <select id="tax_rate_id"
                    name="tax_rate_id"
                    class="form-select">


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





        <div class="col-md-6">


            <label class="form-label">
                Discount
            </label>


            <select id="discount_id"
                    name="discount_id"
                    class="form-select">


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



    </div>


</div>


{{-- =================================================
    INVENTORY TAB
================================================= --}}

<div class="tab-pane fade"
     id="inventory-tab">


    <div class="row g-3">



        <div class="col-md-6">


            <label class="form-label">
                Minimum Stock
            </label>


            <input type="number"
                   step="0.01"
                   id="minimum_stock"
                   name="minimum_stock"
                   value="0"
                   class="form-control">


        </div>





        <div class="col-md-6">


            <label class="form-label">
                Maximum Stock
            </label>


            <input type="number"
                   step="0.01"
                   id="maximum_stock"
                   name="maximum_stock"
                   class="form-control">


        </div>





        <div class="col-md-6">


            <label class="form-label">
                Weight
            </label>


            <input type="number"
                   step="0.01"
                   id="weight"
                   name="weight"
                   class="form-control">


        </div>





        <div class="col-md-6">


            <label class="form-label">
                Expiry Date
            </label>


            <input type="date"
                   id="expiry_date"
                   name="expiry_date"
                   class="form-control">


        </div>



    </div>


</div>



{{-- =================================================
    IMAGE TAB
================================================= --}}

<div class="tab-pane fade"
     id="image-tab">


    <div class="row g-4 align-items-center">



        <div class="col-md-5">


            <div class="product-image-preview-box">


                <img src="{{ asset('assets/images/no-image.png') }}"
                     id="product-image-preview"
                     class="product-image-preview"
                     alt="Product Image">


            </div>


        </div>





        <div class="col-md-7">


            <label class="form-label">

                Product Image

            </label>



            <input type="file"
                   id="image"
                   name="image"
                   class="form-control"
                   accept="image/png,image/jpeg,image/webp">



            <small class="text-muted">

                JPG, PNG or WEBP. Maximum size 2MB.

            </small>


        </div>



    </div>


</div>

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