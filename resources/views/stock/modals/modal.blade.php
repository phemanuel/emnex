<div class="modal fade"
     id="stockAdjustmentModal"
     tabindex="-1">


    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">


         <div class="modal-content stock-adjustment-modal">



            {{-- HEADER --}}

            <div class="modal-header">


                <div>

                    <h5 class="modal-title"
                        id="stockModalTitle">

                        Stock Adjustment

                    </h5>


                    <small class="text-muted">

                        Search products and update inventory

                    </small>


                </div>



                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">

                </button>


            </div>





            {{-- BODY --}}

            <div class="modal-body">


                <div class="row g-4">





                    {{-- PRODUCT BROWSER --}}

                    <div class="col-lg-7">


                        <div class="stock-product-browser">



                            <div class="d-flex justify-content-between align-items-center mb-3">


                                <h6 class="mb-0">

                                    Select Product

                                </h6>



                            </div>





                            {{-- SEARCH --}}

                            {{-- ==========================================================
                                PRODUCT SEARCH & FILTERS
                            =========================================================== --}}


                            <div class="stock-adjustment-filters mb-4">



                                {{-- SEARCH --}}

                                <div class="row g-3 mb-3">


                                    <div class="col-md-6">


                                        <div class="input-group">


                                            <span class="input-group-text">

                                                <i class="bi bi-search"></i>

                                            </span>



                                            <input
                                                type="text"
                                                class="form-control"
                                                id="stockProductSearch"
                                                placeholder="Search product name, SKU, barcode...">


                                        </div>


                                    </div>
                                    
                                    {{-- CATEGORY --}}

                                    <div class="col-md-6">


                                        <select
                                            class="form-select"
                                            id="stockAdjustmentCategoryFilter">


                                            <option value="">

                                                All Categories

                                            </option>


                                        </select>


                                    </div>



                                </div>

                                {{-- BRANCH + STOCK STATUS --}}

                                <div class="row g-3">



                                    <div class="col-md-6">


                                        <select
                                            class="form-select"
                                            id="stockAdjustmentBranchFilter">


                                            <option value="">

                                                All Branches

                                            </option>


                                        </select>


                                    </div>

                                    <div class="col-md-6">


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


                            </div>

                            {{-- PRODUCT TABLE --}}


                            <div class="stock-product-table-wrapper">


                                <table class="table stock-product-table">


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


                                            <th>

                                            </th>


                                        </tr>


                                    </thead>



                                    <tbody id="stockProductTable">


                                        <tr>

                                            <td colspan="4"
                                                class="text-center text-muted">


                                                Search products


                                            </td>


                                        </tr>


                                    </tbody>



                                </table>


                            </div>






                            {{-- PAGINATION --}}

                            <div id="stockProductPagination"
                                 class="mt-3">


                            </div>





                        </div>



                    </div>










                    {{-- ADJUSTMENT PANEL --}}


                    <div class="col-lg-5">



                        <div class="stock-adjustment-panel">





                            <h6>

                                Adjustment Details

                            </h6>




                            {{-- Selected Product --}}


                            <div class="selected-stock-product mb-4">


                                <div class="stock-product-image">


                                    <img id="selectedProductImage"
                                         src=""
                                         class="d-none">


                                    <i class="bi bi-box-seam"
                                       id="selectedProductPlaceholder"></i>


                                </div>




                                <div>


                                    <h6 id="selectedProductName">

                                        No product selected

                                    </h6>



                                    <small id="selectedProductInfo"
                                           class="text-muted">

                                    </small>


                                </div>


                            </div>









                            <input type="hidden"
                                   id="stockProductId">



                            <input type="hidden"
                                   id="stockBranchId">







                            <div class="mb-3">


                                <label class="form-label">

                                    Current Stock

                                </label>


                                <input
                                    type="text"
                                    class="form-control"
                                    id="currentStockQuantity"
                                    readonly
                                    value="0">


                            </div>








                            <div class="mb-3">


                                <label class="form-label">

                                    Adjustment Type

                                </label>


                                <select
                                    class="form-select"
                                    id="stockType">


                                    <option value="">

                                        Select Type

                                    </option>


                                    <option value="Opening Stock">

                                        Opening Stock

                                    </option>


                                    <option value="Adjustment In">

                                        Adjustment In

                                    </option>


                                    <option value="Adjustment Out">

                                        Adjustment Out

                                    </option>


                                    <option value="Damaged">

                                        Damaged

                                    </option>


                                    <option value="Expired">

                                        Expired

                                    </option>


                                </select>


                            </div>







                            <div class="mb-3">


                                <label class="form-label">

                                    Quantity

                                </label>


                                <input
                                    type="number"
                                    step="0.01"
                                    class="form-control"
                                    id="stockQuantity">


                            </div>







                            <div class="mb-3">


                                <label class="form-label">

                                    Reason

                                </label>


                                <textarea
                                    class="form-control"
                                    id="stockReason"
                                    rows="3"></textarea>


                            </div>




                        </div>


                    </div>



                </div>


            </div>






            {{-- FOOTER --}}


            <div class="modal-footer">


                <button type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">


                    Cancel


                </button>





                <button type="button"
                        class="btn btn-primary"
                        id="saveStockBtn"
                        disabled>


                    <i class="bi bi-check-circle me-1"></i>


                    Save Adjustment


                </button>



            </div>



        </div>


    </div>


</div>