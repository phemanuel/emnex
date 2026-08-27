{{-- ==============================================================
    Quick Terminal Modal
============================================================== --}}

<div
    class="modal fade"
    id="orderTerminalModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div
        class="modal-dialog modal-dialog-centered modal-sm"
    >

        <div class="modal-content border-0 shadow-lg">

            {{-- ==================================================
                Header
            =================================================== --}}

            <div class="modal-header border-bottom">

                <div>

                    <div class="text-muted small mb-1">
                        Terminal
                    </div>

                    <h5
                        class="modal-title fw-semibold"
                        id="orderTerminalModalLabel"
                    >
                        New Terminal
                    </h5>

                    <div class="text-muted small">
                        Create a terminal for the selected branch.
                    </div>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            {{-- ==================================================
                Form
            =================================================== --}}

            <form
                id="orderTerminalForm"
            >

                <input
                    type="hidden"
                    id="orderTerminalBranchId"
                    name="branch_id"
                >


                <div class="modal-body">

                    {{-- ==========================================
                        Branch
                    =========================================== --}}

                    <div class="mb-3">

                        <label
                            for="orderTerminalBranchName"
                            class="form-label"
                        >

                            Branch

                        </label>

                        <input
                            type="text"
                            class="form-control bg-light"
                            id="orderTerminalBranchName"
                            readonly
                        >

                    </div>


                    {{-- ==========================================
                        Terminal Name
                    =========================================== --}}

                    <div class="mb-3">

                        <label
                            for="orderTerminalName"
                            class="form-label"
                        >

                            Terminal Name

                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="orderTerminalName"
                            name="terminal_name"
                            maxlength="100"
                            placeholder="e.g. Counter 01"
                            required
                        >

                    </div>


                    {{-- ==========================================
                        Terminal Code
                    =========================================== --}}

                    <div class="mb-3">

                        <label
                            for="orderTerminalCode"
                            class="form-label"
                        >

                            Terminal Code

                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="orderTerminalCode"
                            name="terminal_code"
                            maxlength="50"
                            placeholder="e.g. TERM-001"
                            required
                        >

                    </div>


                    {{-- ==========================================
                        Device Name
                    =========================================== --}}

                    <div class="mb-3">

                        <label
                            for="orderTerminalDeviceName"
                            class="form-label"
                        >

                            Device Name

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="orderTerminalDeviceName"
                            name="device_name"
                            maxlength="150"
                            placeholder="Optional device name"
                        >

                    </div>


                    {{-- ==========================================
                        IP Address
                    =========================================== --}}

                    <div class="mb-3">

                        <label
                            for="orderTerminalIpAddress"
                            class="form-label"
                        >

                            IP Address

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="orderTerminalIpAddress"
                            name="ip_address"
                            maxlength="45"
                            placeholder="Optional IP address"
                        >

                    </div>


                    {{-- ==========================================
                        Description
                    =========================================== --}}

                    <div>

                        <label
                            for="orderTerminalDescription"
                            class="form-label"
                        >

                            Description

                        </label>

                        <textarea
                            class="form-control"
                            id="orderTerminalDescription"
                            name="description"
                            rows="2"
                            maxlength="500"
                            placeholder="Optional description..."
                        ></textarea>

                    </div>

                </div>


                {{-- ==================================================
                    Footer
                =================================================== --}}

                <div class="modal-footer border-top">

                    <button
                        type="button"
                        class="btn btn-light border"
                        data-bs-dismiss="modal"
                    >

                        Cancel

                    </button>


                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="orderTerminalSubmitBtn"
                    >

                        <span id="orderTerminalSubmitText">

                            Create Terminal

                        </span>

                        <span
                            class="spinner-border spinner-border-sm d-none"
                            id="orderTerminalSubmitSpinner"
                        ></span>

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>