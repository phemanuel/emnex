<!-- =====================================================
    CREATE / EDIT UNIT MODAL
====================================================== -->

<div
    class="modal fade"
    id="unitModal"
    tabindex="-1"
    aria-hidden="true"
>


    <div class="modal-dialog modal-lg modal-dialog-centered">


        <div class="modal-content emnex-modal">


            <!-- ==========================================
                Header
            =========================================== -->

            <div class="modal-header border-0 pb-0">


                <div class="d-flex align-items-center">


                    <div class="modal-icon bg-primary-subtle text-primary me-3">

                        <i class="bi bi-rulers"></i>

                    </div>


                    <div>


                        <h5
                            class="modal-title mb-1"
                            id="unitModalTitle"
                        >

                            New Unit

                        </h5>


                        <small class="text-muted">

                            Create or update a product measurement unit.

                        </small>


                    </div>


                </div>



                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>


            </div>





            <form id="unitForm">


                <div class="modal-body pt-4">


                    <input
                        type="hidden"
                        id="unitId"
                    >



                    <div class="row g-4">


                        <!-- ======================================
                            Unit Code
                        ======================================= -->

                        <div class="col-md-6">


                            <label class="form-label">

                                Unit Code

                            </label>


                            <div class="input-group">


                                <input
                                    type="text"
                                    class="form-control"
                                    id="unitCode"
                                    name="unit_code"
                                    readonly
                                >


                                <button
                                    type="button"
                                    class="btn btn-outline-primary"
                                    onclick="Units.generateCode()"
                                >

                                    <i class="bi bi-arrow-repeat"></i>

                                </button>


                            </div>


                            <small class="text-muted">

                                Generated from Document Sequences.

                            </small>


                        </div>





                        <!-- ======================================
                            Short Name
                        ======================================= -->

                        <div class="col-md-6">


                            <label class="form-label">

                                Short Name

                            </label>


                            <input
                                type="text"
                                class="form-control"
                                id="shortName"
                                name="short_name"
                                placeholder="PCS"
                            >


                        </div>





                        <!-- ======================================
                            Name
                        ======================================= -->

                        <div class="col-12">


                            <label class="form-label">

                                Unit Name

                            </label>


                            <input
                                type="text"
                                class="form-control"
                                id="unitName"
                                name="name"
                                placeholder="Piece"
                            >


                        </div>





                        <!-- ======================================
                            Description
                        ======================================= -->

                        <div class="col-12">


                            <label class="form-label">

                                Description

                            </label>


                            <textarea
                                class="form-control"
                                rows="4"
                                id="description"
                                name="description"
                                placeholder="Optional description..."
                            ></textarea>


                        </div>


                    </div>


                </div>





                <!-- ==========================================
                    Footer
                =========================================== -->

                <div class="modal-footer border-0 pt-0">


                    <button
                        type="button"
                        class="btn btn-light px-4"
                        data-bs-dismiss="modal"
                    >

                        Cancel

                    </button>



                    <button
                        type="submit"
                        class="btn btn-primary px-4"
                    >

                        <i class="bi bi-check-circle me-2"></i>

                        Save Unit

                    </button>


                </div>


            </form>


        </div>


    </div>


</div>