 {{-- ==============================================================
        Supplier Modal
    ============================================================== --}}

    <div
        class="modal fade"
        id="supplierModal"
        tabindex="-1"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content border-0 shadow-lg">

                <div class="modal-header">

                    <div>

                        <h5
                            class="modal-title fw-semibold"
                            id="supplierModalTitle"
                        >
                            Add Supplier
                        </h5>

                        <p class="text-muted small mb-0">
                            Enter supplier information below.
                        </p>

                    </div>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>

                </div>


                <form
                    id="supplierForm"
                    novalidate
                >

                    <input
                        type="hidden"
                        id="supplierId"
                        name="id"
                    >


                    <div class="modal-body supplier-form-body">

                        {{-- ==================================================
                            Basic Information
                        =================================================== --}}

                        <div class="supplier-form-section">

                            <div class="supplier-form-section-title">

                                <i class="bi bi-building"></i>

                                Supplier Information

                            </div>

                            <div class="row g-3">

                                <div class="col-12">

                                    <label
                                        for="supplierName"
                                        class="form-label"
                                    >
                                        Supplier Name
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        id="supplierName"
                                        name="name"
                                        maxlength="255"
                                        required
                                    >

                                </div>


                                <div class="col-md-6">

                                    <label
                                        for="supplierContactPerson"
                                        class="form-label"
                                    >
                                        Contact Person
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        id="supplierContactPerson"
                                        name="contact_person"
                                        maxlength="255"
                                    >

                                </div>


                                <div class="col-md-6">

                                    <label
                                        for="supplierTaxNumber"
                                        class="form-label"
                                    >
                                        Tax Number
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        id="supplierTaxNumber"
                                        name="tax_number"
                                        maxlength="100"
                                    >

                                </div>

                            </div>

                        </div>


                        {{-- ==================================================
                            Contact Information
                        =================================================== --}}

                        <div class="supplier-form-section">

                            <div class="supplier-form-section-title">

                                <i class="bi bi-person-lines-fill"></i>

                                Contact Information

                            </div>

                            <div class="row g-3">

                                <div class="col-md-6">

                                    <label
                                        for="supplierEmail"
                                        class="form-label"
                                    >
                                        Email
                                    </label>

                                    <input
                                        type="email"
                                        class="form-control"
                                        id="supplierEmail"
                                        name="email"
                                    >

                                </div>


                                <div class="col-md-6">

                                    <label
                                        for="supplierPhone"
                                        class="form-label"
                                    >
                                        Phone
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        id="supplierPhone"
                                        name="phone"
                                        maxlength="30"
                                    >

                                </div>


                                <div class="col-md-6">

                                    <label
                                        for="supplierAlternatePhone"
                                        class="form-label"
                                    >
                                        Alternate Phone
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        id="supplierAlternatePhone"
                                        name="alternate_phone"
                                        maxlength="30"
                                    >

                                </div>

                            </div>

                        </div>


                        {{-- ==================================================
                            Address
                        =================================================== --}}

                        <div class="supplier-form-section">

                            <div class="supplier-form-section-title">

                                <i class="bi bi-geo-alt"></i>

                                Address

                            </div>

                            <div class="row g-3">

                                <div class="col-12">

                                    <label
                                        for="supplierAddress"
                                        class="form-label"
                                    >
                                        Address
                                    </label>

                                    <textarea
                                        class="form-control"
                                        id="supplierAddress"
                                        name="address"
                                        rows="2"
                                    ></textarea>

                                </div>


                                <div class="col-md-4">

                                    <label
                                        for="supplierCity"
                                        class="form-label"
                                    >
                                        City
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        id="supplierCity"
                                        name="city"
                                        maxlength="100"
                                    >

                                </div>


                                <div class="col-md-4">

                                    <label
                                        for="supplierState"
                                        class="form-label"
                                    >
                                        State
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        id="supplierState"
                                        name="state"
                                        maxlength="100"
                                    >

                                </div>


                                <div class="col-md-4">

                                    <label
                                        for="supplierCountry"
                                        class="form-label"
                                    >
                                        Country
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        id="supplierCountry"
                                        name="country"
                                        maxlength="100"
                                        value="Nigeria"
                                    >

                                </div>

                            </div>

                        </div>


                        {{-- ==================================================
                            Financial Information
                        =================================================== --}}

                        <div class="supplier-form-section">

                            <div class="supplier-form-section-title">

                                <i class="bi bi-credit-card"></i>

                                Financial Information

                            </div>

                            <div class="row g-3">

                                <div class="col-md-6">

                                    <label
                                        for="supplierPaymentTerms"
                                        class="form-label"
                                    >
                                        Payment Terms
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        id="supplierPaymentTerms"
                                        name="payment_terms"
                                        maxlength="100"
                                        placeholder="e.g. 30 Days"
                                    >

                                </div>


                                <div class="col-md-6">

                                    <label
                                        for="supplierCreditLimit"
                                        class="form-label"
                                    >
                                        Credit Limit
                                    </label>

                                    <input
                                        type="number"
                                        class="form-control"
                                        id="supplierCreditLimit"
                                        name="credit_limit"
                                        min="0"
                                        step="0.01"
                                        value="0"
                                    >

                                </div>

                            </div>

                        </div>


                        {{-- ==================================================
                            Notes
                        =================================================== --}}

                        <div class="supplier-form-section mb-0">

                            <div class="supplier-form-section-title">

                                <i class="bi bi-sticky"></i>

                                Notes

                            </div>

                            <textarea
                                class="form-control"
                                id="supplierNotes"
                                name="notes"
                                rows="3"
                                placeholder="Optional supplier notes..."
                            ></textarea>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-light border"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>

                        @permission('suppliers.create')

                            <button
                                type="submit"
                                class="btn btn-primary"
                                id="supplierSubmitBtn"
                            >

                                <span
                                    id="supplierSubmitText"
                                >
                                    Save Supplier
                                </span>

                                <span
                                    id="supplierSubmitSpinner"
                                    class="spinner-border spinner-border-sm d-none ms-1"
                                ></span>

                            </button>

                        @endpermission

                    </div>

                </form>

            </div>

        </div>

    </div>