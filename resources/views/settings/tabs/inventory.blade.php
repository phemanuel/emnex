<div class="tab-pane fade"
     id="inventory"
     role="tabpanel">


    <div class="settings-card">


        <div class="settings-card-header">


            <div class="settings-section-icon">

                <i class="bi bi-box-seam"></i>

            </div>



            <div>

                <h5>
                    Inventory Configuration
                </h5>


                <p>
                    Manage stock monitoring and inventory alerts.
                </p>


            </div>


        </div>





        <div class="settings-card-body">


            <div class="row g-4">





                {{-- Low Stock Alert --}}
                <div class="col-md-6">


                    <label class="form-label">

                        Low Stock Alert Quantity

                    </label>



                    <div class="input-group">


                        <input type="number"

                               name="low_stock_alert"

                               class="form-control"

                               min="0"

                               value="{{ $settings->low_stock_alert }}">



                        <span class="input-group-text">

                            Units

                        </span>


                    </div>



                    <small class="text-muted">

                        Products reaching this quantity will be flagged
                        as low stock.

                    </small>


                </div>







                {{-- Inventory Information --}}
                <div class="col-md-6">


                    <div class="inventory-info-card">


                        <div class="icon">


                            <i class="bi bi-info-circle"></i>


                        </div>



                        <div>


                            <h6>
                                Inventory Management
                            </h6>


                            <p>
                                Advanced stock operations such as stock
                                adjustments, transfers, warehouses and
                                inventory reports will be configured in
                                the Inventory module.
                            </p>


                        </div>


                    </div>


                </div>





            </div>


        </div>


    </div>


</div>