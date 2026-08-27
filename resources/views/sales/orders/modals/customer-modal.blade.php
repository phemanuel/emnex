{{-- ==============================================================
    Quick Customer Modal
============================================================== --}}

<div
    class="modal fade"
    id="orderCustomerModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div
        class="modal-dialog modal-dialog-centered modal-sm"
    >

        <div class="modal-content border-0 shadow-lg">

            {{-- ==================================================
                Header
            =================================================== --}}

            <div class="modal-header border-bottom">

                <div>

                    <div class="text-muted small mb-1">
                        Customer
                    </div>

                    <h5
                        class="modal-title fw-semibold"
                        id="orderCustomerModalLabel"
                    >
                        New Customer
                    </h5>

                    <div class="text-muted small">
                        Add a customer without leaving the order.
                    </div>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            {{-- ==================================================
                Form
            =================================================== --}}

            <form
                id="orderCustomerForm"
            >

                <div class="modal-body">

                    {{-- ==========================================
                        First Name
                    =========================================== --}}

                    <div class="mb-3">

                        <label
                            for="orderCustomerFirstName"
                            class="form-label"
                        >

                            First Name

                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="orderCustomerFirstName"
                            name="first_name"
                            maxlength="100"
                            autocomplete="given-name"
                            required
                        >

                    </div>


                    {{-- ==========================================
                        Last Name
                    =========================================== --}}

                    <div class="mb-3">

                        <label
                            for="orderCustomerLastName"
                            class="form-label"
                        >

                            Last Name

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="orderCustomerLastName"
                            name="last_name"
                            maxlength="100"
                            autocomplete="family-name"
                        >

                    </div>


                    {{-- ==========================================
                        Phone
                    =========================================== --}}

                    <div class="mb-3">

                        <label
                            for="orderCustomerPhone"
                            class="form-label"
                        >

                            Phone

                        </label>

                        <input
                            type="tel"
                            class="form-control"
                            id="orderCustomerPhone"
                            name="phone"
                            maxlength="30"
                            autocomplete="tel"
                        >

                    </div>


                    {{-- ==========================================
                        Email
                    =========================================== --}}

                    <div class="mb-3">

                        <label
                            for="orderCustomerEmail"
                            class="form-label"
                        >

                            Email

                        </label>

                        <input
                            type="email"
                            class="form-control"
                            id="orderCustomerEmail"
                            name="email"
                            maxlength="150"
                            autocomplete="email"
                        >

                    </div>


                    {{-- ==========================================
                        Customer Type
                    =========================================== --}}

                    <div class="mb-3">

                        <label
                            for="orderCustomerType"
                            class="form-label"
                        >

                            Customer Type

                        </label>

                        <select
                            class="form-select"
                            id="orderCustomerType"
                            name="customer_type"
                        >

                            <option value="Walk-in">
                                Walk-in
                            </option>

                            <option value="Corporate">
                                Registered
                            </option>

                            <option value="Wholesale">
                                Business
                            </option>   

                        </select>

                    </div>


                    {{-- ==========================================
                        Customer Group
                    =========================================== --}}

                    <div class="mb-3">

                        <label
                            for="orderCustomerGroup"
                            class="form-label"
                        >

                            Customer Group

                        </label>

                        <select
                            class="form-select"
                            id="orderCustomerGroup"
                            name="customer_group_id"
                        >

                            <option value="">
                                No Group
                            </option>

                        </select>

                    </div>


                    {{-- ==========================================
                        Address
                    =========================================== --}}

                    <div class="mb-3">

                        <label
                            for="orderCustomerAddress"
                            class="form-label"
                        >

                            Address

                        </label>

                        <textarea
                            class="form-control"
                            id="orderCustomerAddress"
                            name="address"
                            rows="2"
                            maxlength="500"
                            placeholder="Customer address..."
                        ></textarea>

                    </div>                    

                </div>


                {{-- ==================================================
                    Footer
                =================================================== --}}

                <div class="modal-footer border-top">

                    <button
                        type="button"
                        class="btn btn-light border"
                        data-bs-dismiss="modal"
                    >

                        Cancel

                    </button>


                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="orderCustomerSubmitBtn"
                    >

                        <span id="orderCustomerSubmitText">

                            Create Customer

                        </span>

                        <span
                            class="spinner-border spinner-border-sm d-none"
                            id="orderCustomerSubmitSpinner"
                        ></span>

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>