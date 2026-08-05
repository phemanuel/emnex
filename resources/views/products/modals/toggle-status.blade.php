{{-- ==========================================================
    PRODUCT STATUS MODAL
========================================================== --}}

<div class="modal fade"
     id="productStatusModal"
     tabindex="-1"
     aria-hidden="true">


    <div class="modal-dialog modal-dialog-centered">


        <div class="modal-content">


            <div class="modal-header">


                <h5 class="modal-title"
                    id="statusModalTitle">

                    Disable Product

                </h5>


                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>


            </div>




            <div class="modal-body">


                <input type="hidden"
                       id="statusProductId">



                <div class="text-center">


                    <i class="bi bi-exclamation-triangle-fill text-warning"
                       style="font-size:50px;">
                    </i>



                    <p class="mt-3"
                       id="statusModalMessage">

                        Are you sure you want to disable this product?

                    </p>


                </div>


            </div>





            <div class="modal-footer">


                <button type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                    Cancel

                </button>




                <button type="button"
                        class="btn btn-danger"
                        id="confirmStatusBtn">

                    <i class="bi bi-power me-2"></i>

                    Disable

                </button>


            </div>


        </div>


    </div>


</div>