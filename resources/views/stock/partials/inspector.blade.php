<div class="offcanvas offcanvas-end stock-inspector"
     tabindex="-1"
     id="stockInspector">


    {{-- ================================================= --}}
    {{-- HEADER --}}
    {{-- ================================================= --}}

    <div class="offcanvas-header">


        <div>

            <h5 class="offcanvas-title">

                Stock Details

            </h5>


            <small class="text-muted">

                Inventory information

            </small>

        </div>



        <button type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas">

        </button>


    </div>

   
    <div class="stock-inspector-unit-price px-3 py-3">

        <span class="text-muted small d-block mb-1">
            Unit Price
        </span>

        <strong
            id="stockInspectorUnitPrice"
            class="fs-3 fw-semibold"
        >
            {{ \App\Helpers\CurrencyHelper::symbol() }}0.00
        </strong>

    </div>



    <div class="offcanvas-body">

        {{-- ================================================= --}}
        {{-- PRODUCT SUMMARY --}}
        {{-- ================================================= --}}


        <div class="stock-inspector-product mb-4">


            <div class="stock-product-image">


                <div class="stock-product-placeholder">


                    <i class="bi bi-box-seam"></i>


                </div>


            </div>

            <div>


                <h6 id="stockInspectorName"
                    class="mb-1">

                    -

                </h6>



                <small id="stockInspectorSku"
                       class="text-muted">

                    -

                </small>


            </div>


        </div>


        {{-- ================================================= --}}
        {{-- STOCK INFORMATION --}}
        {{-- ================================================= --}}


        <div class="stock-inspector-card">


            <h6 class="mb-3">

                Stock Information

            </h6>

            <div class="inspector-row">


                <span>
                    Branch
                </span>


                <strong id="stockInspectorBranch">

                    -

                </strong>


            </div>

            <div class="inspector-row">


                <span>
                    Quantity
                </span>


                <strong id="stockInspectorQuantity">

                    -

                </strong>


            </div>


            <div class="inspector-row">


                <span>
                    Reserved
                </span>


                <strong id="stockInspectorReserved">

                    -

                </strong>


            </div>

            <div class="inspector-row">


                <span>
                    Available
                </span>


                <strong id="stockInspectorAvailable">

                    -

                </strong>


            </div>



        </div>

        {{-- ================================================= --}}
        {{-- PRODUCT INFORMATION --}}
        {{-- ================================================= --}}


        <div class="stock-inspector-card">


            <h6 class="mb-3">

                Product Information

            </h6>

            <div class="inspector-row">


                <span>
                    Barcode
                </span>


                <strong id="stockInspectorBarcode">

                    -

                </strong>


            </div>

            <div class="inspector-row">


                <span>
                    Category
                </span>


                <strong id="stockInspectorCategory">

                    -

                </strong>


            </div>

            <div class="inspector-row">


                <span>
                    Unit
                </span>


                <strong id="stockInspectorUnit">

                    -

                </strong>


            </div>

        </div>

        {{-- ================================================= --}}
        {{-- MOVEMENT HISTORY --}}
        {{-- ================================================= --}}


        <div class="stock-inspector-card">


            <h6 class="mb-3">

                Recent Movements

            </h6>

            <div id="stockMovementList">


                <p class="text-muted">

                    No movements available.

                </p>


            </div>



        </div>






    </div>


</div>