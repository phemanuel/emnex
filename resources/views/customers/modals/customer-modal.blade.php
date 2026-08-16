{{-- ==========================================================
    CUSTOMER MODAL
=========================================================== --}}

<div
    class="modal fade"
    id="customerModal"
    tabindex="-1"
>


    <div class="modal-dialog modal-lg modal-dialog-centered">


        <div class="modal-content customer-modal-content">


            <div class="modal-header">


                <div>

                    <h5
                        class="modal-title"
                        id="customerModalTitle"
                    >

                        Add Customer

                    </h5>


                    <small class="text-muted">

                        Customer information

                    </small>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>


            </div>


            <form id="customerForm">


                @csrf


                <input
                    type="hidden"
                    id="customerId"
                    name="id"
                >


                <div class="modal-body customer-modal-body">


                    <div class="row g-3">


                        <div class="col-md-6">

                            <label class="form-label">

                                First Name

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="first_name"
                                id="customerFirstName"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">

                                Last Name

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="last_name"
                                id="customerLastName"
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">

                                Phone

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="phone"
                                id="customerPhone"
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">

                                Email

                            </label>

                            <input
                                type="email"
                                class="form-control"
                                name="email"
                                id="customerEmail"
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">

                                Customer Group

                            </label>

                            <select
                                class="form-select"
                                name="customer_group_id"
                                id="customerGroupId"
                            >

                                <option value="">

                                    No Group

                                </option>


                                @foreach($customerGroups ?? [] as $group)

                                    <option value="{{ $group->id }}">

                                        {{ $group->name }}

                                    </option>

                                @endforeach


                            </select>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">

                                Customer Type

                            </label>

                            <select
                                class="form-select"
                                name="customer_type"
                                id="customerType"
                            >

                                <option value="Walk-in">

                                    Walk-in

                                </option>


                                <option value="Registered">

                                    Registered

                                </option>


                                <option value="Business">

                                    Business

                                </option>


                            </select>

                        </div>


                        <div class="col-12">

                            <label class="form-label">

                                Address

                            </label>

                            <textarea
                                class="form-control"
                                name="address"
                                id="customerAddress"
                                rows="2"
                            ></textarea>

                        </div>


                        <!-- <div class="col-md-6">

                            <label class="form-label">

                                Credit Limit

                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    ₦
                                </span>

                                <input
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    class="form-control"
                                    name="credit_limit"
                                    id="customerCreditLimit"
                                    value="0"
                                >

                            </div>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">

                                Status

                            </label>

                            <select
                                class="form-select"
                                name="status"
                                id="customerStatus"
                            >

                                <option value="1">

                                    Active

                                </option>


                                <option value="0">

                                    Inactive

                                </option>

                            </select>

                        </div> -->


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
                        id="saveCustomerBtn"
                    >

                        Save Customer

                    </button>


                </div>


            </form>


        </div>


    </div>


</div>