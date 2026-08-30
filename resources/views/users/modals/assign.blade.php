{{-- ==========================================================
TERMINAL ASSIGNMENT MODAL
========================================================== --}}

<div
    class="modal fade"
    id="terminalAssignmentModal"
    tabindex="-1"
    aria-labelledby="terminalAssignmentModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">


    <div class="modal-content terminal-assignment-modal">

        {{-- ==================================================
             HEADER
             ================================================== --}}

        <div class="modal-header">

            <div>

                <h5
                    class="modal-title"
                    id="terminalAssignmentModalLabel"
                >
                    Assign to Terminal
                </h5>

                <p
                    class="terminal-assignment-subtitle mb-0"
                    id="terminalAssignmentModalSubtitle"
                >
                    Assign this cashier to a POS terminal.
                </p>

            </div>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>

        </div>


        {{-- ==================================================
             BODY
             ================================================== --}}

        <div class="modal-body">

            {{-- Hidden User ID --}}

            <input
                type="hidden"
                id="terminalAssignmentUserId"
            >


            {{-- ==================================================
                CASHIER INFORMATION
                ================================================== --}}
            <div class="terminal-assignment-user">

                <div class="terminal-assignment-user-icon">
                    <i class="bi bi-person"></i>
                </div>

                <div class="flex-grow-1">

                    <div
                        class="terminal-assignment-user-name"
                        id="terminalAssignmentUserName"
                    >
                        —
                    </div>

                    <div
                        class="terminal-assignment-user-role"
                        id="terminalAssignmentUserRole"
                    >
                        Cashier
                    </div>

                    <div
                        class="terminal-assignment-user-branch"
                        id="terminalAssignmentUserBranch"
                    >
                        —
                    </div>

                </div>

            </div>

            {{-- ==================================================
                 CURRENT TERMINAL
                 ================================================== --}}

            <div
                class="terminal-assignment-current"
                id="terminalAssignmentCurrent"
                style="display: none;"
            >

                <div class="terminal-assignment-current-icon">
                    <i class="bi bi-pc-display"></i>
                </div>

                <div class="terminal-assignment-current-content">

                    <div class="terminal-assignment-label">
                        Current Terminal
                    </div>

                    <div
                        class="terminal-assignment-current-name"
                        id="terminalAssignmentCurrentName"
                    >
                        —
                    </div>

                    <div
                        class="terminal-assignment-current-code"
                        id="terminalAssignmentCurrentCode"
                    >
                        —
                    </div>

                </div>

                <span
                    class="terminal-assignment-status"
                    id="terminalAssignmentCurrentStatus"
                >
                    Active
                </span>

            </div>


            {{-- ==================================================
                BRANCH TERMINALS
                ================================================== --}}
            <div class="terminal-assignment-terminals">

                <div class="terminal-assignment-section-header">

                    <div>
                        <div class="terminal-assignment-section-title">
                            Branch Terminals
                        </div>

                        <div class="terminal-assignment-section-subtitle">
                            Current terminal availability and assignments.
                        </div>
                    </div>

                    <span
                        class="terminal-assignment-terminal-count"
                        id="terminalAssignmentTerminalCount"
                    >
                        0
                    </span>

                </div>

                {{-- Loading --}}
                <div
                    class="terminal-assignment-terminal-loading"
                    id="terminalAssignmentTerminalLoading"
                >

                    <div
                        class="spinner-border spinner-border-sm"
                        role="status"
                    ></div>

                    <span>
                        Loading terminals...
                    </span>

                </div>


                {{-- Terminal List --}}
                <div
                    class="terminal-assignment-terminal-list"
                    id="terminalAssignmentTerminalList"
                >
                    {{-- Populated by JavaScript --}}
                </div>


                {{-- Empty --}}
                <div
                    class="terminal-assignment-terminal-empty"
                    id="terminalAssignmentTerminalEmpty"
                    style="display: none;"
                >

                    <div class="terminal-assignment-empty-icon">
                        <i class="bi bi-pc-display-horizontal"></i>
                    </div>

                    <div>

                        <div class="terminal-assignment-empty-title">
                            No terminals found
                        </div>

                        <div class="terminal-assignment-empty-text">
                            There are no POS terminals configured for this branch.
                        </div>

                    </div>

                </div>

            </div>


            

            {{-- ==================================================
                 TERMINAL SELECTOR
                 ================================================== --}}

            <div class="mb-0">

                <label
                    for="terminalAssignmentTerminal"
                    class="form-label"
                >
                    <span id="terminalAssignmentSelectLabel">
                        Terminal
                    </span>

                    <span class="text-danger">*</span>
                </label>

                <select
                    class="form-select"
                    id="terminalAssignmentTerminal"
                >

                    <option value="">
                        Select terminal
                    </option>

                </select>

                <div
                    class="invalid-feedback"
                    id="terminalAssignmentTerminalError"
                ></div>

                <div class="terminal-assignment-help">
                    Only available terminals for the cashier's
                    branch will be listed.
                </div>

            </div>


            {{-- ==================================================
                 LOADING
                 ================================================== --}}

            <div
                class="terminal-assignment-loading"
                id="terminalAssignmentLoading"
                style="display: none;"
            >

                <div
                    class="spinner-border spinner-border-sm"
                    role="status"
                ></div>

                <span>
                    Loading terminals...
                </span>

            </div>


            {{-- ==================================================
                 NO TERMINALS
                 ================================================== --}}

            <div
                class="terminal-assignment-empty"
                id="terminalAssignmentEmpty"
                style="display: none;"
            >

                <div class="terminal-assignment-empty-icon">

                    <i class="bi bi-pc-display-horizontal"></i>

                </div>

                <div>

                    <div class="terminal-assignment-empty-title">
                        No available terminals
                    </div>

                    <div
                        class="terminal-assignment-empty-text"
                        id="terminalAssignmentEmptyText"
                    >
                        There are no available POS terminals for
                        this cashier's branch.
                    </div>

                </div>

            </div>

        </div>


        {{-- ==================================================
             FOOTER
             ================================================== --}}

        <div class="modal-footer">

            <button
                type="button"
                class="btn btn-light"
                data-bs-dismiss="modal"
            >
                Cancel
            </button>

            <button
                type="button"
                class="btn btn-primary"
                id="saveTerminalAssignmentBtn"
                disabled
            >

                <span
                    class="spinner-border spinner-border-sm me-2 d-none"
                    id="saveTerminalAssignmentSpinner"
                    role="status"
                ></span>

                <i
                    class="bi bi-check2-circle me-1"
                    id="saveTerminalAssignmentIcon"
                ></i>

                <span id="saveTerminalAssignmentText">
                    Assign Terminal
                </span>

            </button>

        </div>

    </div>

</div>


</div>
