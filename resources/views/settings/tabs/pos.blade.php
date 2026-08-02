<div class="tab-pane fade"
     id="pos"
     role="tabpanel">


    <div class="settings-card">


        <div class="settings-card-header">


            <div class="settings-section-icon">

                <i class="bi bi-cart-check"></i>

            </div>



            <div>

                <h5>
                    POS Configuration
                </h5>


                <p>
                    Control sales behaviour and cashier options.
                </p>


            </div>


        </div>





        <div class="settings-card-body">


            <div class="row g-4">



                {{-- Negative Stock --}}
                <div class="col-md-6">


                    <div class="settings-toggle-card">


                        <div>


                            <h6>
                                Allow Negative Stock
                            </h6>


                            <p>
                                Allow sales when inventory quantity is unavailable.
                            </p>


                        </div>



                        <div class="form-check form-switch">


                            <input class="form-check-input"

                                   type="checkbox"

                                   name="allow_negative_stock"

                                   value="1"

                                   {{ $settings->allow_negative_stock ? 'checked' : '' }}>


                        </div>


                    </div>


                </div>







                {{-- Price Override --}}
                <div class="col-md-6">


                    <div class="settings-toggle-card">


                        <div>


                            <h6>
                                Allow Price Override
                            </h6>


                            <p>
                                Allow authorized users to change selling prices.
                            </p>


                        </div>



                        <div class="form-check form-switch">


                            <input class="form-check-input"

                                   type="checkbox"

                                   name="allow_price_override"

                                   value="1"

                                   {{ $settings->allow_price_override ? 'checked' : '' }}>


                        </div>


                    </div>


                </div>







                {{-- Discounts --}}
                <div class="col-md-6">


                    <div class="settings-toggle-card">


                        <div>


                            <h6>
                                Enable Discounts
                            </h6>


                            <p>
                                Allow discounts during transactions.
                            </p>


                        </div>



                        <div class="form-check form-switch">


                            <input class="form-check-input"

                                   type="checkbox"

                                   name="allow_discount"

                                   value="1"

                                   {{ $settings->allow_discount ? 'checked' : '' }}>


                        </div>


                    </div>


                </div>







                {{-- Customer Credit --}}
                <div class="col-md-6">


                    <div class="settings-toggle-card">


                        <div>


                            <h6>
                                Customer Credit
                            </h6>


                            <p>
                                Allow customers to buy on credit.
                            </p>


                        </div>



                        <div class="form-check form-switch">


                            <input class="form-check-input"

                                   type="checkbox"

                                   name="enable_customer_credit"

                                   value="1"

                                   {{ $settings->enable_customer_credit ? 'checked' : '' }}>


                        </div>


                    </div>


                </div>








                {{-- Default Customer --}}
                <div class="col-md-8">


                    <label class="form-label">

                        Default Customer

                    </label>



                    <select name="default_customer_id"

                            class="form-select">


                        <option value="">

                            Walk-in Customer

                        </option>



                        @foreach($customers as $customer)


                            <option value="{{ $customer->id }}"

                            {{ $settings->default_customer_id == $customer->id ? 'selected' : '' }}>


                                {{ $customer->first_name . " " . $customer->last_name }}


                            </option>


                        @endforeach


                    </select>


                </div>



            </div>


        </div>


    </div>


</div>