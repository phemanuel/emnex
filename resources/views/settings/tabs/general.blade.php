<div class="tab-pane fade show active"
     id="general"
     role="tabpanel">


    {{-- Company Information --}}
    <div class="settings-card mb-4">


        <div class="settings-card-header">

            <div class="settings-section-icon">

                <i class="bi bi-building"></i>

            </div>


            <div>

                <h5>
                    Company Information
                </h5>

                <p>
                    Basic information displayed throughout EMNEX POS.
                </p>

            </div>


        </div>




        <div class="settings-card-body">


            <div class="row g-3">


                {{-- Company Name --}}
                <div class="col-md-6">


                    <label class="form-label">
                        Company Name
                    </label>


                    <input type="text"
                           name="company_name"
                           class="form-control"
                           value="{{ $settings->company_name }}">


                    <div class="invalid-feedback"></div>


                </div>





                {{-- Company Email --}}
                <div class="col-md-6">


                    <label class="form-label">
                        Company Email
                    </label>


                    <input type="email"
                           name="company_email"
                           class="form-control"
                           value="{{ $settings->company_email }}">


                    <div class="invalid-feedback"></div>


                </div>





                {{-- Phone --}}
                <div class="col-md-6">


                    <label class="form-label">
                        Company Phone
                    </label>


                    <input type="text"
                           name="company_phone"
                           class="form-control"
                           value="{{ $settings->company_phone }}">


                    <div class="invalid-feedback"></div>


                </div>





                {{-- Address --}}
                <div class="col-12">


                    <label class="form-label">
                        Company Address
                    </label>


                    <textarea
                        name="company_address"
                        class="form-control"
                        rows="3">{{ $settings->company_address }}</textarea>


                    <div class="invalid-feedback"></div>


                </div>


            </div>


        </div>


    </div>







   
    {{-- Localization --}}    
    <div class="settings-card">


        <div class="settings-card-header">


            <div class="settings-section-icon">

                <i class="bi bi-globe"></i>

            </div>


            <div>

                <h5>
                    Localization
                </h5>


                <p>
                    Configure currency, timezone and display formats.
                </p>

            </div>


        </div>





        <div class="settings-card-body">


            <div class="row g-3">





                {{-- Currency --}}
                <div class="col-md-4">


                    <label class="form-label">

                        Currency

                    </label>



                    <select
                        name="currency"
                        id="currency"
                        class="form-select">



                        <option value="">
                            Select Currency
                        </option>



                        <option value="NGN"
                                data-symbol="₦"
                                {{ $settings->currency == 'NGN' ? 'selected' : '' }}>

                            Nigerian Naira (NGN)

                        </option>




                        <option value="USD"
                                data-symbol="$"
                                {{ $settings->currency == 'USD' ? 'selected' : '' }}>

                            US Dollar (USD)

                        </option>




                        <option value="GBP"
                                data-symbol="£"
                                {{ $settings->currency == 'GBP' ? 'selected' : '' }}>

                            British Pound (GBP)

                        </option>




                        <option value="EUR"
                                data-symbol="€"
                                {{ $settings->currency == 'EUR' ? 'selected' : '' }}>

                            Euro (EUR)

                        </option>




                        <option value="GHS"
                                data-symbol="₵"
                                {{ $settings->currency == 'GHS' ? 'selected' : '' }}>

                            Ghana Cedi (GHS)

                        </option>




                        <option value="KES"
                                data-symbol="KSh"
                                {{ $settings->currency == 'KES' ? 'selected' : '' }}>

                            Kenyan Shilling (KES)

                        </option>



                    </select>


                </div>









                {{-- Currency Symbol --}}
                <div class="col-md-4">


                    <label class="form-label">

                        Currency Symbol

                    </label>



                    <input type="text"

                        id="currencySymbol"

                        name="currency_symbol"

                        class="form-control"

                        value="{{ $settings->currency_symbol }}"

                        readonly>


                </div>









                {{-- Timezone --}}
                <div class="col-md-4">


                    <label class="form-label">

                        Timezone

                    </label>




                    <select name="timezone"

                            class="form-select">



                        @foreach($timezones as $timezone)


                            <option value="{{ $timezone }}"

                            {{ $settings->timezone == $timezone ? 'selected' : '' }}>


                                {{ $timezone }}


                            </option>


                        @endforeach



                    </select>


                </div>









                {{-- Date Format --}}
                <div class="col-md-6">


                    <label class="form-label">

                        Date Format

                    </label>




                    <select name="date_format"

                            class="form-select">



                        @foreach($dateFormats as $format => $display)


                            <option value="{{ $format }}"

                            {{ $settings->date_format == $format ? 'selected' : '' }}>


                                {{ $display }}

                            </option>



                        @endforeach



                    </select>


                    <small class="text-muted">

                        Example format used throughout the system.

                    </small>


                </div>









                {{-- Time Format --}}
                <div class="col-md-6">


                    <label class="form-label">

                        Time Format

                    </label>




                    <select name="time_format"

                            class="form-select">



                        @foreach($timeFormats as $format => $display)


                            <option value="{{ $format }}"

                            {{ $settings->time_format == $format ? 'selected' : '' }}>


                                {{ $display }}


                            </option>



                        @endforeach



                    </select>



                    <small class="text-muted">

                        Controls how time appears in the application.

                    </small>


                </div>





            </div>


        </div>


    </div>

</div>