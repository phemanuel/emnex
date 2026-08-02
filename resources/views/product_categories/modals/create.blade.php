<!-- =====================================================
    CREATE / EDIT CATEGORY MODAL
====================================================== -->


<div 
    class="modal fade"
    id="categoryModal"
    tabindex="-1"
>


    <div class="modal-dialog modal-dialog-centered">


        <div class="modal-content emnex-form-modal">


            <div class="modal-header">


                <div class="d-flex align-items-center gap-3">


                    <div class="modal-icon">

                        <i class="bi bi-tags"></i>

                    </div>


                    <div>


                        <h5 class="modal-title">

                            Category

                        </h5>


                        <small class="text-muted">

                            Create or update product category

                        </small>


                    </div>


                </div>




                <button 
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>


            </div>





            <form id="categoryForm">


                <div class="modal-body">


                    <input 
                        type="hidden"
                        id="categoryId"
                    >




                    <div class="mb-3">


                        <label class="form-label">
                            Category Code
                        </label>



                        <div class="input-group">


                            <input
                                type="text"
                                class="form-control"
                                id="categoryCode"
                                name="category_code"
                                placeholder="CAT001"
                            >



                            <button
                                type="button"
                                class="btn btn-outline-primary"
                                onclick="ProductCategories.generateCode()"
                            >

                                <i class="bi bi-magic"></i>

                                Generate

                            </button>


                        </div>


                    </div>






                    <div class="mb-3">


                        <label class="form-label">
                            Name
                        </label>



                        <input
                            type="text"
                            class="form-control"
                            id="categoryName"
                            name="name"
                            placeholder="Category name"
                        >


                    </div>







                    <div class="mb-3">


                        <label class="form-label">
                            Description
                        </label>



                        <textarea
                            class="form-control"
                            id="categoryDescription"
                            name="description"
                            rows="4"
                            placeholder="Description"
                        ></textarea>


                    </div>



                </div>





                <div class="modal-footer">


                    <button 
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >

                        Cancel

                    </button>



                    <button 
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="bi bi-check-circle"></i>

                        Save Category

                    </button>


                </div>



            </form>


        </div>


    </div>


</div>