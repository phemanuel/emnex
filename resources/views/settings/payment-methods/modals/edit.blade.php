<div class="modal fade payment-method-modal"
     id="editPaymentMethodModal"
     tabindex="-1"
     aria-hidden="true">


    <div class="modal-dialog modal-lg modal-dialog-centered">


        <div class="modal-content border-0 shadow">


            <form id="editPaymentMethodForm">


                @csrf

                @method('PUT')


                <input
                    type="hidden"
                    id="edit_payment_method_id"
                    name="payment_method_id">



                <div class="modal-header">


                    <h5 class="modal-title">


                        <i class="bi bi-pencil-square me-2"></i>


                        Edit Payment Method


                    </h5>



                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">

                    </button>


                </div>







                <div class="modal-body">


                    <div class="row g-4">





                        {{-- Name --}}

                        <div class="col-md-6">


                            <label class="form-label">

                                Name

                            </label>


                            <input
                                type="text"
                                class="form-control"
                                id="edit_name"
                                name="name">


                            <div class="invalid-feedback"></div>


                        </div>






                        {{-- Code --}}

                        <div class="col-md-6">


                            <label class="form-label">

                                Code

                            </label>


                            <input
                                type="text"
                                class="form-control text-uppercase"
                                id="edit_code"
                                name="code">


                            <div class="invalid-feedback"></div>


                        </div>







                        {{-- Icon --}}

                        <div class="col-md-6">


                            <label class="form-label">

                                Icon

                            </label>


                            <select
                                class="form-select"
                                id="edit_icon"
                                name="icon">


                                <option value="bi-cash">

                                    Cash

                                </option>


                                <option value="bi-credit-card">

                                    Card

                                </option>


                                <option value="bi-bank">

                                    Bank

                                </option>


                                <option value="bi-wallet2">

                                    Wallet

                                </option>


                                <option value="bi-receipt">

                                    Receipt

                                </option>


                            </select>


                        </div>







                        {{-- Color --}}

                        <div class="col-md-6">


                            <label class="form-label">

                                Color

                            </label>


                            <select
                                class="form-select"
                                id="edit_color"
                                name="color">


                                <option value="success">

                                    Green

                                </option>


                                <option value="primary">

                                    Blue

                                </option>


                                <option value="info">

                                    Cyan

                                </option>


                                <option value="warning">

                                    Yellow

                                </option>


                                <option value="dark">

                                    Dark

                                </option>


                            </select>


                        </div>








                        {{-- Options --}}

                        <div class="col-md-12">


                            <label class="form-label">

                                Options

                            </label>



                            <div class="d-flex flex-column gap-2">



                                <div class="form-check">


                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="edit_requires_reference"
                                        name="requires_reference"
                                        value="1">


                                    <label
                                        class="form-check-label"
                                        for="edit_requires_reference">

                                        Requires transaction reference

                                    </label>


                                </div>






                                <div class="form-check">


                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="edit_is_cash"
                                        name="is_cash"
                                        value="1">


                                    <label
                                        class="form-check-label"
                                        for="edit_is_cash">

                                        Cash payment method

                                    </label>


                                </div>






                                <div class="form-check">


                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="edit_allow_change"
                                        name="allow_change"
                                        value="1">


                                    <label
                                        class="form-check-label"
                                        for="edit_allow_change">

                                        Allow change calculation

                                    </label>


                                </div>


                            </div>


                        </div>







                        {{-- Display Order --}}

                        <div class="col-md-6">


                            <label class="form-label">

                                Display Order

                            </label>


                            <input
                                type="number"
                                class="form-control"
                                id="edit_display_order"
                                name="display_order">


                            <div class="invalid-feedback"></div>


                        </div>







                        {{-- Preview --}}

                        <div class="col-md-6">


                            <label class="form-label">

                                Preview

                            </label>




                            <div class="payment-preview">



                                <div
                                    class="payment-preview-icon bg-success"
                                    id="edit_preview_icon">


                                    <i class="bi bi-cash"></i>


                                </div>



                                <div>


                                    <div
                                        class="fw-semibold"
                                        id="edit_preview_name">

                                        Cash

                                    </div>


                                    <small class="text-muted">

                                        Payment Method

                                    </small>


                                </div>


                            </div>


                        </div>





                    </div>


                </div>







                <div class="modal-footer">


                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Cancel

                    </button>





                    <button
                        type="submit"
                        class="btn btn-primary">


                        <i class="bi bi-check-circle me-2"></i>


                        Save Changes


                    </button>


                </div>




            </form>


        </div>


    </div>


</div>