<div class="tab-pane fade"
     id="receipt"
     role="tabpanel">


    <div class="settings-card">


        <div class="settings-card-header">


            <div class="settings-section-icon">

                <i class="bi bi-receipt"></i>

            </div>



            <div>

                <h5>
                    Receipt Configuration
                </h5>


                <p>
                    Configure how customer receipts are printed.
                </p>


            </div>


        </div>





        <div class="settings-card-body">


            <div class="row g-4">



                {{-- Receipt Header --}}
                <div class="col-12">


                    <label class="form-label">

                        Receipt Header

                    </label>


                    <textarea

                        name="receipt_header"

                        class="form-control"

                        rows="3"

                        placeholder="Example: Thank you for shopping with us">

                        {{ $settings->receipt_header }}

                    </textarea>


                    <small class="text-muted">

                        Appears at the top of printed receipts.

                    </small>


                </div>







                {{-- Receipt Footer --}}
                <div class="col-12">


                    <label class="form-label">

                        Receipt Footer

                    </label>


                    <textarea

                        name="receipt_footer"

                        class="form-control"

                        rows="3"

                        placeholder="Example: Visit again">

                        {{ $settings->receipt_footer }}

                    </textarea>


                    <small class="text-muted">

                        Appears at the bottom of printed receipts.

                    </small>


                </div>








                {{-- Receipt Width --}}
                <div class="col-md-4">


                    <label class="form-label">

                        Receipt Paper Size

                    </label>



                    <select name="receipt_width"

                            class="form-select">



                        <option value="58"

                        {{ $settings->receipt_width == 58 ? 'selected' : '' }}>

                            58mm Thermal Printer

                        </option>





                        <option value="80"

                        {{ $settings->receipt_width == 80 ? 'selected' : '' }}>

                            80mm Thermal Printer

                        </option>



                    </select>


                </div>







                {{-- Print Logo --}}
                <div class="col-md-4">


                    <div class="settings-toggle-card">


                        <div>


                            <h6>

                                Print Company Logo

                            </h6>


                            <p>

                                Display company logo on receipts.

                            </p>


                        </div>




                        <div class="form-check form-switch">


                            <input class="form-check-input"

                                   type="checkbox"

                                   name="print_logo"

                                   value="1"

                                   {{ $settings->print_logo ? 'checked' : '' }}>


                        </div>


                    </div>


                </div>








                {{-- Barcode --}}
                <div class="col-md-4">


                    <div class="settings-toggle-card">


                        <div>


                            <h6>

                                Print Barcode

                            </h6>


                            <p>

                                Show product barcode on receipt.

                            </p>


                        </div>




                        <div class="form-check form-switch">


                            <input class="form-check-input"

                                   type="checkbox"

                                   name="print_barcode"

                                   value="1"

                                   {{ $settings->print_barcode ? 'checked' : '' }}>


                        </div>


                    </div>


                </div>



            </div>


        </div>


    </div>


</div>