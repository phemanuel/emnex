<div class="modal fade"
     id="deleteStockModal"
     tabindex="-1"
     aria-hidden="true">


    <div class="modal-dialog modal-dialog-centered">


        <div class="modal-content stock-modal">


            <div class="modal-header">


                <h5 class="modal-title">

                    Delete Stock Record

                </h5>


                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">

                </button>


            </div>





            <div class="modal-body">


                <div class="text-center py-3">


                    <div class="stock-delete-icon mb-3">


                        <i class="bi bi-trash"></i>


                    </div>



                    <h5>

                        Are you sure?

                    </h5>



                    <p class="text-muted mb-0">


                        This action cannot be undone.

                        The stock record will be removed.


                    </p>


                </div>




                <input type="hidden"
                       id="deleteStockId">



            </div>





            <div class="modal-footer">


                <button type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">


                    Cancel


                </button>




                <button type="button"
                        class="btn btn-danger"
                        id="confirmDeleteStockBtn">


                    <i class="bi bi-trash me-1"></i>

                    Delete


                </button>


            </div>


        </div>


    </div>


</div>