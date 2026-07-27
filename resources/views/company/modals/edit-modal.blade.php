<!-- ==========================================
     Edit Company Modal
=========================================== -->

<div class="modal fade"
     id="editCompanyModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">


            <div class="modal-header">

                <h5 class="modal-title">
                    Edit Company Information
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>



            <form id="editCompanyForm" action="{{ route('company.update') }}"
                  method="POST">

                @csrf

                @method('PUT')


                <div class="modal-body">


                    <div class="row g-3">


                        <div class="col-md-6">

                            <label class="form-label">
                                Company Name
                            </label>

                            <input type="text"
                                name="name"
                                class="form-control"
                                value="{{ old('name', $company->name) }}"
                                required>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Business Type
                            </label>

                            <input type="text"
                                name="business_type"
                                class="form-control"
                                value="{{ old('business_type', $company->business_type) }}">

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Email
                            </label>

                            <input type="email"
                                name="email"
                                class="form-control"
                                value="{{ old('email', $company->email) }}">

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Phone
                            </label>

                            <input type="text"
                                name="phone"
                                class="form-control"
                                value="{{ old('phone', $company->phone) }}">

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Registration Number
                            </label>

                            <input type="text"
                                name="registration_no"
                                class="form-control"
                                value="{{ old('registration_no', $company->registration_no) }}">

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                TIN
                            </label>

                            <input type="text"
                                name="tin"
                                class="form-control"
                                value="{{ old('tin', $company->tin) }}">

                        </div>


                        <div class="col-12">

                            <label class="form-label">
                                Address
                            </label>

                            <textarea
                                name="address"
                                class="form-control"
                                rows="3">{{ old('address', $company->address) }}</textarea>

                        </div>


                    </div>


                </div>



                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">

                        Cancel

                    </button>


                    <button type="submit"
                            class="btn btn-primary">

                        Save Changes

                    </button>


                </div>


            </form>


        </div>

    </div>

</div>