<div class="tab-pane fade"
     id="tax"
     role="tabpanel">


    <div class="settings-card">


        <div class="settings-card-header">


            <div class="settings-section-icon">

                <i class="bi bi-percent"></i>

            </div>



            <div>

                <h5>
                    Tax Configuration
                </h5>


                <p>
                    Configure tax calculation rules for sales transactions.
                </p>


            </div>


        </div>





        <div class="settings-card-body">


            <div class="row g-4">





                {{-- Enable Tax --}}
                <div class="col-md-6">


                    <div class="settings-toggle-card">


                        <div>


                            <h6>
                                Enable Tax
                            </h6>


                            <p>
                                Automatically calculate tax during sales.
                            </p>


                        </div>




                        <div class="form-check form-switch">


                            <input class="form-check-input"

                                   type="checkbox"

                                   name="tax_enabled"

                                   value="1"

                                   {{ $settings->tax_enabled ? 'checked' : '' }}>


                        </div>


                    </div>


                </div>








                {{-- Tax Rate --}}
                <div class="col-md-6">


                    <label class="form-label">

                        Tax Rate

                    </label>



                    <div class="input-group">


                        <input type="number"

                               name="tax_rate"

                               class="form-control"

                               step="0.01"

                               min="0"

                               value="{{ $settings->tax_rate }}">



                        <span class="input-group-text">

                            %

                        </span>


                    </div>



                    <small class="text-muted">

                        Example: VAT rate applied to taxable products.

                    </small>


                </div>







                {{-- Tax Information --}}
                <div class="col-12">


                    <div class="tax-info-card">


                        <div class="icon">

                            <i class="bi bi-info-circle"></i>

                        </div>



                        <div>


                            <h6>
                                Tax Management
                            </h6>


                            <p>

                                Advanced tax rules such as multiple tax
                                rates, product tax groups and exemptions
                                will be managed from the Tax Rates module.

                            </p>


                        </div>


                    </div>


                </div>




            </div>


        </div>


    </div>


</div>