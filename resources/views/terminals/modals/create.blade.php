{{-- Create Terminal Modal --}}

<div class="modal fade"
     id="createTerminalModal"
     tabindex="-1">


    <div class="modal-dialog modal-lg modal-dialog-centered">


        <div class="modal-content">


            <div class="modal-header">

                <h5 class="modal-title">

                    <i class="bi bi-pc-display me-2"></i>

                    Create Terminal

                </h5>


                <button 
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">

                </button>


            </div>




            <div class="modal-body">


                <form id="createTerminalForm">


                    @csrf


                    <div class="row g-3">



                        {{-- Branch --}}

                        <div class="col-md-6">


                            <label class="form-label">
                                Branch
                            </label>


                            <select 
                                name="branch_id"
                                class="form-select">


                                <option value="">
                                    Select Branch
                                </option>


                                @foreach($branches as $branch)


                                    <option value="{{ $branch->id }}">

                                        {{ $branch->name }}

                                    </option>


                                @endforeach


                            </select>



                            <div class="invalid-feedback"></div>


                        </div>






                        {{-- Terminal Code --}}

                        <div class="col-md-6">


                            <label class="form-label">
                                Terminal Code
                            </label>


                            <input 
                                type="text"
                                name="terminal_code"
                                class="form-control"
                                placeholder="POS001">


                            <div class="invalid-feedback"></div>


                        </div>






                        {{-- Terminal Name --}}

                        <div class="col-md-6">


                            <label class="form-label">
                                Terminal Name
                            </label>


                            <input 
                                type="text"
                                name="terminal_name"
                                class="form-control"
                                placeholder="Front Counter POS">


                            <div class="invalid-feedback"></div>


                        </div>






                        {{-- Device Name --}}

                        <div class="col-md-6">


                            <label class="form-label">
                                Device Name
                            </label>


                            <input 
                                type="text"
                                name="device_name"
                                class="form-control"
                                placeholder="Dell Optiplex">


                            <div class="invalid-feedback"></div>


                        </div>






                        {{-- IP Address --}}

                        <div class="col-md-6">


                            <label class="form-label">
                                IP Address
                            </label>


                            <input 
                                type="text"
                                name="ip_address"
                                class="form-control"
                                placeholder="192.168.1.20">


                            <div class="invalid-feedback"></div>


                        </div>






                        {{-- Description --}}

                        <div class="col-md-6">


                            <label class="form-label">
                                Description
                            </label>


                            <input 
                                type="text"
                                name="description"
                                class="form-control"
                                placeholder="Main checkout terminal">


                            <div class="invalid-feedback"></div>


                        </div>



                    </div>



                </form>


            </div>





            <div class="modal-footer">


                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal">

                    Cancel

                </button>




                <button
                    type="button"
                    id="saveTerminal"
                    class="btn btn-primary">


                    <i class="bi bi-save me-2"></i>

                    Save Terminal


                </button>



            </div>



        </div>


    </div>


</div>