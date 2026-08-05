<div class="modal fade"
     id="productDeleteModal"
     tabindex="-1"
     aria-hidden="true">


    <div class="modal-dialog modal-dialog-centered">


        <div class="modal-content product-action-modal">



            <div class="modal-header">


                <h5 class="modal-title">

                    Delete Product

                </h5>



                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">

                </button>


            </div>






            <div class="modal-body text-center">



                <div class="action-icon delete-icon">


                    <i class="bi bi-trash"></i>


                </div>





                <h5 class="mt-3">

                    Are you sure?

                </h5>




                <p class="text-muted"
                   id="deleteProductMessage">


                    This product will be moved to trash.


                </p>




                <input type="hidden"
                       id="deleteProductId">



            </div>







            <div class="modal-footer justify-content-center">


                <button type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">


                    Cancel


                </button>





                <button type="button"
                        class="btn btn-danger"
                        id="confirmDeleteBtn">


                    Delete Product


                </button>



            </div>




        </div>


    </div>


</div>