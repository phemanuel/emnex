{{-- ==========================================================
    CUSTOMER GROUP MODAL
=========================================================== --}}

<div
    class="modal fade"
    id="customerGroupModal"
    tabindex="-1"
>


    <div class="modal-dialog modal-md modal-dialog-centered">


        <div class="modal-content">


            <div class="modal-header">


                <div>

                    <h5
                        class="modal-title"
                        id="customerGroupModalTitle"
                    >

                        Add Customer Group

                    </h5>


                    <small class="text-muted">

                        Group configuration

                    </small>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>


            </div>


            <form id="customerGroupForm">


                @csrf


                <input
                    type="hidden"
                    name="id"
                    id="customerGroupIdInput"
                >


                <div class="modal-body">


                    <div class="mb-3">

                        <label class="form-label">

                            Group Name

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            id="customerGroupName"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">

                            Code

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="code"
                            id="customerGroupCode"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">

                            Description

                        </label>

                        <textarea
                            class="form-control"
                            name="description"
                            id="customerGroupDescription"
                            rows="3"
                        ></textarea>

                    </div>


                    <div class="row g-3">


                        <div class="col-md-6">

                            <label class="form-label">

                                Discount %

                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                class="form-control"
                                name="discount_percentage"
                                id="customerGroupDiscount"
                                value="0"
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">

                                Credit Limit

                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                class="form-control"
                                name="credit_limit"
                                id="customerGroupCreditLimit"
                                value="0"
                            >

                        </div>


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
                        id="saveCustomerGroupBtn"
                    >

                        Save Group

                    </button>


                </div>


            </form>


        </div>


    </div>


</div>