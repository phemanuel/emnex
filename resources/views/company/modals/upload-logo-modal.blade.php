<!-- ==========================================
     Company Logo Modal
=========================================== -->

<div class="modal fade"
     id="logoModal"
     tabindex="-1"
     aria-hidden="true">


    <div class="modal-dialog modal-dialog-centered">


        <div class="modal-content">


            <div class="modal-header">

                <h5 class="modal-title">
                    Update Company Logo
                </h5>


                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>




            <form id="companyLogoForm" action="{{ route('company.logo.update') }}"
                  method="POST"
                  enctype="multipart/form-data">


                @csrf


                <div class="modal-body">


                    <div class="text-center mb-3">


                        <div class="company-logo-preview-wrapper mx-auto">

                            @if($company->logo)

                                <img src="{{ asset('uploads/company/'.$company->logo) }}"
                                    class="company-logo-preview"
                                    alt="{{ $company->name }}">


                            @else

                                <div class="company-logo-placeholder">

                                    {{ strtoupper(substr($company->name,0,2)) }}

                                </div>

                            @endif

                        </div>


                    </div>



                    <label class="form-label">
                        Select Logo
                    </label>


                    <input type="file"
                           name="logo"
                           class="form-control"
                           accept="image/*"
                           required>


                    <small class="text-muted">
                        Recommended: PNG or JPG, max 2MB
                    </small>


                </div>




                <div class="modal-footer">


                    <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">

                        Cancel

                    </button>


                    <button type="submit"
                            class="btn btn-success">

                        Upload Logo

                    </button>


                </div>


            </form>


        </div>


    </div>


</div>