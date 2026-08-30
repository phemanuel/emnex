/**
 * ==========================================================
 * EMNEX USERS MANAGEMENT
 * ==========================================================
 */


const Users = {

    createModal: null,

    editModal: null,

    detailsPanel: null,

    currentUserId: null,

    deleteModal: null,

    resetPasswordModal: null,

    toggleStatusModal: null,

    currentUserStatus: null,
    
    permission:
        window.usersPermission || {

            view: false,

            update: false,

            resetPassword: false,

            delete: false

        },

    init()
    {
        this.routes = window.usersRoutes || {};

        const createModalElement =
            document.getElementById(
                'createUserModal'
            );

        if (createModalElement) {

            this.createModal =
                new bootstrap.Modal(
                    createModalElement
                );

        }

        const editModalElement =
            document.getElementById(
                'editUserModal'
            );

        if (editModalElement) {

            this.editModal =
                new bootstrap.Modal(
                    editModalElement
                );

        }

        const resetModal =
            document.getElementById(
                'resetPasswordModal'
            );

        if(resetModal){

            this.resetPasswordModal =
                new bootstrap.Modal(
                    resetModal
                );

        }

        const toggleStatusModal =
            document.getElementById(
                'toggleStatusModal'
            );

        if(toggleStatusModal){

            this.toggleStatusModal =
                new bootstrap.Modal(
                    toggleStatusModal
                );

        }

        const deleteModal =
            document.getElementById(
                'deleteUserModal'
            );

        if(deleteModal){

            this.deleteModal =
                new bootstrap.Modal(
                    deleteModal
                );

        }

         this.detailsPanel =
        document.getElementById(
            'userDetailsPanel'
        );

        this.bindEvents();

        this.bindEditForm();

        /*
    |--------------------------------------------------------------------------
    | Load Users
    |--------------------------------------------------------------------------
    */

    this.loadUsers();

    },




    /**
     * ======================================================
     * EVENTS
     * ======================================================
     */


   bindEvents()
{

    const createForm =
        document.getElementById(
            'createUserForm'
        );

    if (createForm) {

        createForm.addEventListener(

            'submit',

            (event) => {

                event.preventDefault();

                this.storeUser(
                    createForm
                );

            }

        );

    }



    const editForm =
        document.getElementById(
            'editUserForm'
        );

    if (editForm) {

        editForm.addEventListener(

            'submit',

            (event) => {

                event.preventDefault();

                this.updateUser(
                    editForm
                );

            }

        );

    }



    const createButton =
        document.getElementById(
            'openCreateUserModal'
        );

    if (createButton) {

        createButton.addEventListener(

            'click',

            () => {

                this.resetCreateForm();

                bootstrap
                    .Modal
                    .getOrCreateInstance(

                        document.getElementById(
                            'createUserModal'
                        )

                    )
                    .show();

            }

        );

        const searchInput =
            document.getElementById(
                'userSearch'
            );


        const roleFilter =
            document.getElementById(
                'roleFilter'
            );


        const branchFilter =
            document.getElementById(
                'branchFilter'
            );


        const statusFilter =
            document.getElementById(
                'statusFilter'
            );


        const applyFilters = () => {

            const params =
                new URLSearchParams();


            const search =
                searchInput
                    ? searchInput.value.trim()
                    : '';


            const role =
                roleFilter
                    ? roleFilter.value
                    : '';


            const branch =
                branchFilter
                    ? branchFilter.value
                    : '';


            const status =
                statusFilter
                    ? statusFilter.value
                    : '';


            if (search) {

                params.set(
                    'search',
                    search
                );

            }


            if (role) {

                params.set(
                    'role',
                    role
                );

            }


            if (branch) {

                params.set(
                    'branch',
                    branch
                );

            }


            if (status) {

                params.set(
                    'status',
                    status
                );

            }


            const queryString =
                params.toString();


            window.location.href =
                queryString
                    ? `${window.location.pathname}?${queryString}`
                    : window.location.pathname;

        };



        if (searchInput) {

            let searchTimer;


            searchInput.addEventListener(
                'input',
                () => {

                    clearTimeout(
                        searchTimer
                    );


                    searchTimer =
                        setTimeout(
                            applyFilters,
                            400
                        );

                }
            );

        }



        if (roleFilter) {

            roleFilter.addEventListener(
                'change',
                applyFilters
            );

        }



        if (branchFilter) {

            branchFilter.addEventListener(
                'change',
                applyFilters
            );

        }



        if (statusFilter) {

            statusFilter.addEventListener(
                'change',
                applyFilters
            );

        }

    }



    /* -----------------------------------
       RESET PASSWORD
    ----------------------------------- */

    const resetButton =
        document.getElementById(
            'confirmResetPassword'
        );

    if(resetButton){

        resetButton.addEventListener(

            'click',

            ()=>{

                this.resetPassword();

            }

        );

    }

    const copyButton =
        document.getElementById(
            'copyPassword'
        );

    if(copyButton){

        copyButton.addEventListener(

            'click',

            ()=>{

                this.copyGeneratedPassword();

            }

        );

    }


    /* -----------------------------------
       DELETE USER
    ----------------------------------- */

    const deleteButton =
        document.getElementById(
            'confirmDeleteUser'
        );

    if (deleteButton) {

        deleteButton.addEventListener(

            'click',

            () => {

                this.deleteUser();

            }

        );

    }



    /* -----------------------------------
       TOGGLE STATUS
    ----------------------------------- */

    const toggleButton =
        document.getElementById(
            'confirmToggleStatus'
        );

    if (toggleButton) {

        toggleButton.addEventListener(

            'click',

            () => {

                this.toggleStatus();

            }

        );

    }

    /*
    |--------------------------------------------------------------------------
    | Terminal Assignment
    |--------------------------------------------------------------------------
    */

    const saveTerminalAssignmentBtn =
        document.getElementById(
            'saveTerminalAssignmentBtn'
        );

    if (saveTerminalAssignmentBtn) {

        saveTerminalAssignmentBtn.addEventListener(
            'click',
            () => {

                this.saveTerminalAssignment();

            }
        );

    }

},

/**
 * ======================================================
 * ESCAPE HTML
 * ======================================================
 */

escapeHtml(value)
{

    if (value === null || value === undefined) {

        return '';

    }


    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');

},


/*
 * ======================================================
 * RENDER USER ACTIONS
 * ======================================================
 */

renderUserActions(user)
{

    let actions = '';


    /*
     * --------------------------------------------------
     * View
     * --------------------------------------------------
     */

    if (this.permission.view) {

        actions += `
            <li>
                <button
                    type="button"
                    class="dropdown-item"
                    onclick="openUserDetailsPanel(${user.id})"
                >
                    <i class="bi bi-eye me-2"></i>
                    View Details
                </button>
            </li>
        `;
    }


    /*
     * --------------------------------------------------
     * Edit
     * --------------------------------------------------
     */

    if (this.permission.update) {

        actions += `
            <li>
                <button
                    type="button"
                    class="dropdown-item"
                    onclick="openEditUserModal(${user.id})"
                >
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit User
                </button>
            </li>
        `;
    }


    /*
     * --------------------------------------------------
     * Terminal Assignment
     * --------------------------------------------------
     */

    const isCashier =
        user.role
        && user.role.name
        && user.role.name.toLowerCase() === 'cashier';


    if (
        isCashier
        && this.permission.update
    ) {

        const hasActiveTerminal =
            user.active_terminal_assignment
            && user.active_terminal_assignment.status === 'Active';


        actions += `
            <li>
                <button
                    type="button"
                    class="dropdown-item"
                    onclick="Users.openTerminalAssignmentModal(${user.id})"
                >
                    <i class="bi ${
                        hasActiveTerminal
                            ? 'bi-arrow-left-right'
                            : 'bi-pc-display'
                    } me-2"></i>

                    ${
                        hasActiveTerminal
                            ? 'Change Terminal'
                            : 'Assign to Terminal'
                    }
                </button>
            </li>
        `;
    }


    /*
     * --------------------------------------------------
     * Reset Password
     * --------------------------------------------------
     */

    if (this.permission.resetPassword) {

        actions += `
            <li>
                <button
                    type="button"
                    class="dropdown-item"
                    onclick='openResetPasswordModal(${JSON.stringify({
                        id: user.id,
                        first_name: user.first_name,
                        last_name: user.last_name
                    })})'
                >
                    <i class="bi bi-key me-2"></i>
                    Reset Password
                </button>
            </li>
        `;
    }


    /*
     * --------------------------------------------------
     * Toggle Status
     * --------------------------------------------------
     */

    if (this.permission.update) {

        actions += `
            <li>
                <button
                    type="button"
                    class="dropdown-item"
                    onclick='openToggleStatusModal(${JSON.stringify({
                        id: user.id,
                        first_name: user.first_name,
                        last_name: user.last_name,
                        status: !!user.status
                    })})'
                >
                    ${
                        user.status
                            ? `
                                <i class="bi bi-person-x me-2"></i>
                                Disable User
                            `
                            : `
                                <i class="bi bi-person-check me-2"></i>
                                Enable User
                            `
                    }
                </button>
            </li>
        `;
    }


    /*
     * --------------------------------------------------
     * Delete
     * --------------------------------------------------
     */

    if (this.permission.delete) {

        actions += `
            <li>
                <hr class="dropdown-divider">
            </li>

            <li>
                <button
                    type="button"
                    class="dropdown-item text-danger"
                    onclick='openDeleteUserModal(${JSON.stringify({
                        id: user.id,
                        first_name: user.first_name,
                        last_name: user.last_name
                    })})'
                >
                    <i class="bi bi-trash me-2"></i>
                    Delete User
                </button>
            </li>
        `;
    }


    /*
     * --------------------------------------------------
     * Dropdown
     * --------------------------------------------------
     */

    return `
        <div class="dropdown">

            <button
                type="button"
                class="btn btn-light action-btn"
                data-bs-toggle="dropdown"
                data-bs-boundary="viewport"
                data-bs-display="dynamic"
                aria-expanded="false"
            >
                <i class="bi bi-three-dots"></i>
            </button>

            <ul
                class="dropdown-menu dropdown-menu-end"
                data-bs-popper="static"
            >
                ${actions}
            </ul>

        </div>
    `;
},



/*
|--------------------------------------------------------------------------
| Open Terminal Assignment Modal
|--------------------------------------------------------------------------
*/

async openTerminalAssignmentModal(userId) {

    console.log(
        'Terminal assignment user ID:',
        userId
    );


    /*
    |--------------------------------------------------------------------------
    | Modal
    |--------------------------------------------------------------------------
    */

    const modalElement =
        document.getElementById(
            'terminalAssignmentModal'
        );

    if (!modalElement) {

        console.error(
            'Terminal Assignment modal not found.'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Loading
    |--------------------------------------------------------------------------
    */

    const loading =
        document.getElementById(
            'terminalAssignmentLoading'
        );

    if (loading) {

        loading.style.display = 'flex';
    }


    /*
    |--------------------------------------------------------------------------
    | Load Assignment Data
    |--------------------------------------------------------------------------
    */

    try {

        const response =
            await fetch(
                `/users/${userId}/terminal-assignment`,
                {
                    method: 'GET',

                    headers: {

                        'Accept':
                            'application/json',

                        'X-Requested-With':
                            'XMLHttpRequest',

                    },
                }
            );


        const data =
            await response.json();


        if (!response.ok) {

            throw new Error(
                data.message ||
                'Failed to load terminal assignment.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Populate User
        |--------------------------------------------------------------------------
        */

        const user =
            data.user;


        const userNameElement =
            document.getElementById(
                'terminalAssignmentUserName'
            );


        const userRoleElement =
            document.getElementById(
                'terminalAssignmentUserRole'
            );

        const userBranchElement =
            document.getElementById(
                'terminalAssignmentUserBranch'
            );


        if (userNameElement) {

            userNameElement.textContent =
                user.full_name || '—';
        }


        if (userRoleElement) {

            userRoleElement.textContent =
                user.role?.display_name ||
                user.role?.name ||
                'Cashier';
        }

        if (userBranchElement) {

            userBranchElement.textContent =
                user.branch?.name
                || '—';

        }


        /*
        |--------------------------------------------------------------------------
        | Store User ID
        |--------------------------------------------------------------------------
        */

        const userIdElement =
            document.getElementById(
                'terminalAssignmentUserId'
            );


        if (userIdElement) {

            userIdElement.value =
                user.id;
        }


        /*
        |--------------------------------------------------------------------------
        | Current Assignment
        |--------------------------------------------------------------------------
        */

        const current =
            data.current_assignment;


        const currentContainer =
            document.getElementById(
                'terminalAssignmentCurrent'
            );


        const currentName =
            document.getElementById(
                'terminalAssignmentCurrentName'
            );


        if (current) {

            if (currentContainer) {

                currentContainer.style.display =
                    'flex';
            }


            if (currentName) {

                currentName.textContent =
                    current.terminal_name ||
                    current.terminal_code ||
                    '—';
            }

        } else {

            if (currentContainer) {

                currentContainer.style.display =
                    'none';
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Terminals
        |--------------------------------------------------------------------------
        */

       this.populateTerminalAssignmentTerminals(
            data.terminals
        );

        this.populateTerminalAssignmentSelect(
            data.terminals,
            user.id
        );


        /*
        |--------------------------------------------------------------------------
        | Show Modal
        |--------------------------------------------------------------------------
        */

        const modal =
            bootstrap.Modal.getOrCreateInstance(
                modalElement
            );

        modal.show();


    } catch (error) {

        console.error(
            'Terminal assignment error:',
            error
        );

        if (typeof showToast === 'function') {

            showToast(
                error.message ||
                'Failed to load terminal assignment.',
                'error'
            );
        }


    } finally {

        if (loading) {

            loading.style.display = 'none';
        }
    }
},

/**
 * ======================================================
 * POPULATE TERMINAL ASSIGNMENT TERMINALS
 * ======================================================
 */
populateTerminalAssignmentTerminals(terminals)
{
    const list =
        document.getElementById(
            'terminalAssignmentTerminalList'
        );

    const empty =
        document.getElementById(
            'terminalAssignmentTerminalEmpty'
        );

    const loading =
        document.getElementById(
            'terminalAssignmentTerminalLoading'
        );

    const count =
        document.getElementById(
            'terminalAssignmentTerminalCount'
        );


    if (!list) {
        return;
    }


    if (loading) {

        loading.style.display =
            'none';

    }


    list.innerHTML = '';


    if (!terminals || !terminals.length) {

        if (empty) {

            empty.style.display =
                'flex';

        }

        if (count) {

            count.textContent =
                '0';

        }

        return;
    }


    if (empty) {

        empty.style.display =
            'none';

    }


    if (count) {

        count.textContent =
            terminals.length;

    }


    terminals.forEach(terminal => {

        const isActive =
            !!terminal.status;

        const isAssigned =
            !!terminal.assignment;

        const assignedUser =
            terminal.assignment?.user;


        let statusClass =
            'available';

        let statusText =
            'Available';

        if (!isActive) {

            statusClass =
                'inactive';

            statusText =
                'Inactive';

        } else if (isAssigned) {

            statusClass =
                'in-use';

            statusText =
                'In Use';

        }


        const userName =
            assignedUser
                ? [
                    assignedUser.first_name,
                    assignedUser.other_name,
                    assignedUser.last_name
                ]
                .filter(Boolean)
                .join(' ')
                : '—';


        list.insertAdjacentHTML(
            'beforeend',
            `
                <div class="terminal-assignment-terminal-item">

                    <div class="terminal-assignment-terminal-icon">
                        <i class="bi bi-pc-display"></i>
                    </div>

                    <div class="terminal-assignment-terminal-info">

                        <div class="terminal-assignment-terminal-name">
                            ${this.escapeHtml(
                                terminal.terminal_name
                                || 'Unnamed Terminal'
                            )}
                        </div>

                        <div class="terminal-assignment-terminal-code">
                            ${this.escapeHtml(
                                terminal.terminal_code
                                || '—'
                            )}
                        </div>

                    </div>

                    <div class="terminal-assignment-terminal-user">

                        <div class="terminal-assignment-terminal-user-label">
                            Currently Using
                        </div>

                        <div class="terminal-assignment-terminal-user-name">
                            ${this.escapeHtml(userName)}
                        </div>

                    </div>

                    <div class="terminal-assignment-terminal-status ${statusClass}">

                        <span class="terminal-assignment-status-dot"></span>

                        ${statusText}

                    </div>

                </div>
            `
        );

    });

},

/**
 * ======================================================
 * POPULATE AVAILABLE TERMINAL SELECT
 * ======================================================
 */
populateTerminalAssignmentSelect(terminals, userId)
{
    const select =
        document.getElementById(
            'terminalAssignmentTerminal'
        );

    if (!select) {
        return;
    }

    select.innerHTML = `
        <option value="">
            Select terminal
        </option>
    `;


    if (!terminals || !terminals.length) {
        return;
    }


    terminals.forEach(terminal => {

        const isActive =
            !!terminal.status;

        const assignment =
            terminal.assignment;

        const isAssigned =
            !!assignment;

        const assignedUserId =
            assignment?.user_id
            ?? assignment?.user?.id
            ?? null;

        /*
        |--------------------------------------------------------------------------
        | Current cashier's terminal
        |--------------------------------------------------------------------------
        */

        const isCurrentTerminal =
            Number(assignedUserId) ===
            Number(userId);


        /*
        |--------------------------------------------------------------------------
        | Only active terminals which are:
        |
        | 1. Not assigned to anyone
        | OR
        | 2. Already assigned to this cashier
        |--------------------------------------------------------------------------
        */

        if (
            !isActive
            ||
            (
                isAssigned
                &&
                !isCurrentTerminal
            )
        ) {
            return;
        }


        const option =
            document.createElement('option');

        option.value =
            terminal.id;

        option.textContent =
            `${terminal.terminal_name} (${terminal.terminal_code})`;


        /*
        |--------------------------------------------------------------------------
        | Preserve current terminal
        |--------------------------------------------------------------------------
        */

        if (isCurrentTerminal) {

            option.selected =
                true;

        }


        select.appendChild(option);

    });


    /*
    |--------------------------------------------------------------------------
    | Enable / disable save button
    |--------------------------------------------------------------------------
    */

    select.onchange = function () {

        const saveButton =
            document.getElementById(
                'saveTerminalAssignmentBtn'
            );

        if (saveButton) {

            saveButton.disabled =
                !this.value;

        }

    };

},
/*
|--------------------------------------------------------------------------
| TERMINAL ASSIGNMENT LOADING
|--------------------------------------------------------------------------
*/

showTerminalAssignmentLoading()
{

    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    const userNameElement =
        document.getElementById(
            'terminalAssignmentUserName'
        );

    const userRoleElement =
        document.getElementById(
            'terminalAssignmentUserRole'
        );

    const terminalList =
        document.getElementById(
            'terminalAssignmentTerminalList'
        );

    const terminalSelect =
        document.getElementById(
            'terminalAssignmentTerminal'
        );

    const saveButton =
        document.getElementById(
            'saveTerminalAssignmentBtn'
        );


    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */

    if (userNameElement) {

        userNameElement.textContent =
            'Loading...';

    }


    if (userRoleElement) {

        userRoleElement.textContent =
            'Loading...';

    }


    /*
    |--------------------------------------------------------------------------
    | Terminal List
    |--------------------------------------------------------------------------
    */

    if (terminalList) {

        terminalList.innerHTML = `

            <div class="terminal-assignment-loading">

                <div
                    class="spinner-border spinner-border-sm"
                    role="status"
                ></div>

                <span>
                    Loading terminals...
                </span>

            </div>

        `;

    }


    /*
    |--------------------------------------------------------------------------
    | Terminal Selector
    |--------------------------------------------------------------------------
    */

    if (terminalSelect) {

        terminalSelect.innerHTML = `

            <option value="">

                Loading terminals...

            </option>

        `;

        terminalSelect.value = '';

        terminalSelect.disabled = true;

    }


    /*
    |--------------------------------------------------------------------------
    | Save Button
    |--------------------------------------------------------------------------
    */

    if (saveButton) {

        saveButton.disabled = true;

    }

},
/*
|--------------------------------------------------------------------------
| RENDER TERMINAL ASSIGNMENT
|--------------------------------------------------------------------------
*/

renderTerminalAssignment(data)
{
    const user =
        data.user;

    const currentAssignment =
        data.current_assignment;

    const terminals =
        data.terminals || [];

    const availableTerminals =
        data.available_terminals || [];


    /*
    |--------------------------------------------------------------------------
    | Store State
    |--------------------------------------------------------------------------
    */

    this.state =
        this.state || {};

    this.state.terminalAssignment =
        {

            userId:
                user.id,

            currentAssignment:
                currentAssignment,

            terminals:
                terminals,

            availableTerminals:
                availableTerminals,

        };


    /*
    |--------------------------------------------------------------------------
    | User Information
    |--------------------------------------------------------------------------
    */

    const userNameElement =
        document.getElementById(
            'terminalAssignmentUserName'
        );

    const userRoleElement =
        document.getElementById(
            'terminalAssignmentUserRole'
        );

    const userBranchElement =
        document.getElementById(
            'terminalAssignmentUserBranch'
        );


    if (userNameElement) {

        userNameElement.textContent =
            user.full_name
            || '-';
    }


    if (userRoleElement) {

        userRoleElement.textContent =
            user.role?.display_name
            || user.role?.name
            || 'Cashier';
    }


    if (userBranchElement) {

        userBranchElement.textContent =
            user.branch?.name
            || '-';
    }


    /*
    |--------------------------------------------------------------------------
    | Current Assignment
    |--------------------------------------------------------------------------
    */

    this.renderCurrentTerminalAssignment(
        currentAssignment
    );


    /*
    |--------------------------------------------------------------------------
    | All Terminals
    |--------------------------------------------------------------------------
    */

    this.renderTerminalList(
        terminals
    );


    /*
    |--------------------------------------------------------------------------
    | Available Terminal Dropdown
    |--------------------------------------------------------------------------
    */

    this.renderAvailableTerminalOptions(
        availableTerminals,
        currentAssignment
    );
},

/*
|--------------------------------------------------------------------------
| RENDER CURRENT TERMINAL ASSIGNMENT
|--------------------------------------------------------------------------
*/

renderCurrentTerminalAssignment(
    assignment
)
{
    const currentAssignmentElement =
        document.getElementById(
            'terminalCurrentAssignment'
        );

    const assignmentMode =
        document.getElementById(
            'terminalAssignmentMode'
        );

    const saveButtonText =
        document.getElementById(
            'saveTerminalAssignmentBtnText'
        );


    if (!assignment) {

        if (currentAssignmentElement) {

            currentAssignmentElement.classList.add(
                'd-none'
            );
        }

        if (assignmentMode) {

            assignmentMode.textContent =
                'Assign Terminal';
        }

        if (saveButtonText) {

            saveButtonText.textContent =
                'Assign Terminal';
        }

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Current Terminal
    |--------------------------------------------------------------------------
    */

    const terminal =
        assignment.terminal;


    if (currentAssignmentElement) {

        currentAssignmentElement.classList.remove(
            'd-none'
        );


        const name =
            currentAssignmentElement.querySelector(
                '[data-terminal-current-name]'
            );

        const code =
            currentAssignmentElement.querySelector(
                '[data-terminal-current-code]'
            );


        if (name) {

            name.textContent =
                terminal?.terminal_name
                || '-';
        }


        if (code) {

            code.textContent =
                terminal?.terminal_code
                || '-';
        }
    }


    if (assignmentMode) {

        assignmentMode.textContent =
            'Change Terminal';
    }


    if (saveButtonText) {

        saveButtonText.textContent =
            'Change Terminal';
    }
},

/*
|--------------------------------------------------------------------------
| RENDER TERMINAL LIST
|--------------------------------------------------------------------------
*/

renderTerminalList(terminals)
{
    const container =
        document.getElementById(
            'terminalAssignmentTerminalList'
        );

    if (!container) {

        return;
    }


    if (!terminals.length) {

        container.innerHTML = `
            <div class="terminal-assignment-empty">
                <i class="bi bi-pc-display-horizontal"></i>

                <div>
                    <strong>No terminals found</strong>

                    <span>
                        There are no terminals configured for this branch.
                    </span>
                </div>
            </div>
        `;

        return;
    }


    container.innerHTML =
        terminals.map(
            terminal => {

                let usageHtml;


                if (terminal.is_current) {

                    usageHtml = `
                        <span class="terminal-status-badge current">
                            <i class="bi bi-person-check"></i>
                            Current Terminal
                        </span>
                    `;

                } else if (terminal.in_use) {

                    usageHtml = `
                        <span class="terminal-status-badge in-use">
                            <i class="bi bi-person-fill"></i>
                            In Use
                        </span>
                    `;

                } else {

                    usageHtml = `
                        <span class="terminal-status-badge available">
                            <i class="bi bi-check-circle"></i>
                            Available
                        </span>
                    `;
                }


                const statusHtml =
                    terminal.status
                        ? `
                            <span class="terminal-status-badge active">
                                Active
                            </span>
                        `
                        : `
                            <span class="terminal-status-badge inactive">
                                Inactive
                            </span>
                        `;


                const assignedUser =
                    terminal.assigned_user;


                return `
                    <div class="terminal-assignment-row">

                        <div class="terminal-assignment-main">

                            <div class="terminal-assignment-icon">
                                <i class="bi bi-pc-display"></i>
                            </div>

                            <div class="terminal-assignment-info">

                                <div class="terminal-assignment-name">
                                    ${this.escapeHtml(
                                        terminal.terminal_name
                                        || '-'
                                    )}
                                </div>

                                <div class="terminal-assignment-meta">

                                    <span>
                                        ${this.escapeHtml(
                                            terminal.terminal_code
                                            || '-'
                                        )}
                                    </span>

                                    ${
                                        terminal.device_name
                                            ? `
                                                <span>
                                                    ${this.escapeHtml(
                                                        terminal.device_name
                                                    )}
                                                </span>
                                            `
                                            : ''
                                    }

                                </div>

                                ${
                                    assignedUser
                                        ? `
                                            <div class="terminal-assignment-user">
                                                <i class="bi bi-person"></i>

                                                <span>
                                                    ${this.escapeHtml(
                                                        assignedUser.name
                                                        || assignedUser.username
                                                        || '-'
                                                    )}
                                                </span>
                                            </div>
                                        `
                                        : ''
                                }

                            </div>

                        </div>


                        <div class="terminal-assignment-status">

                            ${statusHtml}

                            ${usageHtml}

                        </div>

                    </div>
                `;
            }
        )
        .join('');
},

/*
|--------------------------------------------------------------------------
| RENDER AVAILABLE TERMINAL OPTIONS
|--------------------------------------------------------------------------
*/

renderAvailableTerminalOptions(
    terminals,
    currentAssignment
)
{
    const select =
        document.getElementById(
            'terminalAssignmentTerminal'
        );

    if (!select) {

        return;
    }


    select.innerHTML = `
        <option value="">
            Select terminal
        </option>
    `;


    if (!terminals.length) {

        select.innerHTML = `
            <option value="">
                No available terminals
            </option>
        `;

        select.disabled = true;

        return;
    }


    terminals.forEach(
        terminal => {

            const option =
                document.createElement(
                    'option'
                );

            option.value =
                terminal.id;

            option.textContent =
                `${terminal.terminal_name} (${terminal.terminal_code})`
                + (
                    terminal.is_current
                        ? ' — Current'
                        : ''
                );


            select.appendChild(
                option
            );
        }
    );


    select.disabled = false;


    /*
    |--------------------------------------------------------------------------
    | Preselect Current Terminal
    |--------------------------------------------------------------------------
    */

    if (currentAssignment) {

        select.value =
            currentAssignment.terminal_id;
    }
},

/*
|--------------------------------------------------------------------------
| ESCAPE HTML
|--------------------------------------------------------------------------
*/

escapeHtml(value)
{
    const div =
        document.createElement(
            'div'
        );

    div.textContent =
        value ?? '';

    return div.innerHTML;
},


/**
 * ======================================================
 * LOAD USERS
 * ======================================================
 */

async loadUsers(page = 1)
{

    const search =
        document.getElementById(
            'userSearch'
        )?.value || '';


    const role =
        document.getElementById(
            'roleFilter'
        )?.value || '';


    const branch =
        document.getElementById(
            'branchFilter'
        )?.value || '';


    const status =
        document.getElementById(
            'statusFilter'
        )?.value || '';


    const params =
        new URLSearchParams({

            page: page,

            search: search,

            role_id: role,

            branch_id: branch,

            status: status

        });


    try {

        const response =
            await fetch(

                `${this.routes.table}?${params.toString()}`,

                {

                    headers: {

                        'Accept':
                            'application/json'

                    }

                }

            );


        const responseText =
            await response.text();


        console.log(
            'Users table status:',
            response.status
        );


        console.log(
            'Users table response:',
            responseText
        );


        if (!response.ok) {

            throw new Error(
                `Unable to load users. HTTP ${response.status}`
            );

        }


        let result;


        try {

            result =
                JSON.parse(
                    responseText
                );

        } catch (error) {

            console.error(
                'Users table returned invalid JSON:',
                responseText
            );


            throw new Error(
                'Users table returned invalid JSON.'
            );

        }


        console.log(
            'Users table JSON:',
            result
        );


       if (!result.status) {

            throw new Error(
                result.message ||
                'Unable to load users.'
            );

        }


        this.permissions =
            result.permissions || {};


        this.renderUsers(
            result.users
        );


        this.renderPagination(
            result.pagination
        );


    } catch (error) {

        console.error(
            'Users table error:',
            error
        );

    }

},



/**
 * ======================================================
 * RENDER USERS
 * ======================================================
 */

renderUsers(users)
{

    const tbody =
        document.querySelector(
            '.users-table tbody'
        );


    if (!tbody) {

        return;

    }


    if (!users || !users.length) {

        tbody.innerHTML = `

            <tr>

                <td colspan="6">

                    <div class="empty-state">

                        <i class="bi bi-people"></i>

                        <h6>
                            No Users Found
                        </h6>

                        <p>
                            No users match the selected filters.
                        </p>

                    </div>

                </td>

            </tr>

        `;

        return;

    }


    tbody.innerHTML =
        users.map(user => {

            const initials =
                (
                    (user.first_name || '').charAt(0) +
                    (user.last_name || '').charAt(0)
                ).toUpperCase();


            const fullName =
                user.full_name ||
                `${user.first_name || ''} ${user.last_name || ''}`.trim();


            const roleName =
                user.role
                    ? user.role.display_label
                    : 'No Role';


            const roleCode =
                user.role
                    ? user.role.code
                    : '';


            const branchName =
                user.branch?.name ||
                'All Branches';


            const status =
                Boolean(user.status);


            const lastActivity =
                user.last_activity_human ||
                'Never';


            const lastActivityDate =
                user.last_activity_date ||
                '';


            const avatar =
                user.profile_photo
                    ? `
                        <img
                            src="${user.profile_photo}"
                            class="user-avatar-image"
                        >
                    `
                    : `
                        <div class="user-avatar">
                            ${initials}
                        </div>
                    `;


            return `

                <tr>

                    <td>

                        <div class="user-info">

                            ${avatar}

                            <div>

                                <h6 class="mb-1">
                                    ${this.escapeHtml(fullName)}
                                </h6>

                                <div class="user-email">
                                    ${this.escapeHtml(user.email || '')}
                                </div>

                                <div class="user-username">

                                    <i class="bi bi-person me-1"></i>

                                    ${this.escapeHtml(user.username || '')}

                                </div>

                            </div>

                        </div>

                    </td>


                    <td>

                        ${
                            user.role
                                ? `
                                    <div class="role-info">

                                        <div class="role-icon">

                                            <i class="bi bi-shield-lock"></i>

                                        </div>

                                        <div>

                                            <strong>
                                                ${this.escapeHtml(roleName)}
                                            </strong>

                                            <small>
                                                ${this.escapeHtml(roleCode)}
                                            </small>

                                        </div>

                                    </div>
                                `
                                : `
                                    <span class="text-muted">
                                        No Role
                                    </span>
                                `
                        }

                    </td>


                    <td>

                        <div class="branch-info">

                            <i class="bi bi-building"></i>

                            <span>
                                ${this.escapeHtml(branchName)}
                            </span>

                        </div>

                    </td>


                    <td>

                        ${
                            status
                                ? `
                                    <span class="user-status active">

                                        <span></span>

                                        Active

                                    </span>
                                `
                                : `
                                    <span class="user-status inactive">

                                        <span></span>

                                        Disabled

                                    </span>
                                `
                        }

                    </td>


                    <td>

                        ${
                            user.last_activity_at
                                ? `
                                    <div class="activity-main">

                                        ${this.escapeHtml(lastActivity)}

                                    </div>

                                    <small class="text-muted">

                                        ${this.escapeHtml(lastActivityDate)}

                                    </small>
                                `
                                : `
                                    <span class="text-muted">
                                        Never
                                    </span>
                                `
                        }

                    </td>


                    <td class="text-end">

                        ${this.renderUserActions(user)}

                    </td>

                </tr>

            `;

        }).join('');       


   /*
|--------------------------------------------------------------------------
| Initialize Dropdowns
|--------------------------------------------------------------------------
*/

tbody
    .querySelectorAll(
        '[data-bs-toggle="dropdown"]'
    )
    .forEach(
        dropdownElement => {

            new bootstrap.Dropdown(
                dropdownElement,
                {
                    boundary: 'viewport',
                    popperConfig: {
                        strategy: 'fixed'
                    }
                }
            );

        }
    );

},

/**
 * ======================================================
 * RENDER PAGINATION
 * ======================================================
 */

renderPagination(pagination)
{

    const paginationContainer =
        document.querySelector(
            '#usersPagination'
        );


    if (!paginationContainer) {

        return;

    }


    const currentPage =
        pagination.current_page || 1;

    const lastPage =
        pagination.last_page || 1;


    if (lastPage <= 1) {

        paginationContainer.innerHTML = '';

        return;

    }


    let html = '';


    /*
    |--------------------------------------------------------------------------
    | Previous
    |--------------------------------------------------------------------------
    */

    html += `

        <li class="page-item ${currentPage <= 1 ? 'disabled' : ''}">

            <button
                type="button"
                class="page-link"
                data-page="${currentPage - 1}"
                ${currentPage <= 1 ? 'disabled' : ''}
            >

                <i class="bi bi-chevron-left"></i>

            </button>

        </li>

    `;


    /*
    |--------------------------------------------------------------------------
    | Page Numbers
    |--------------------------------------------------------------------------
    */

    for (
        let page = 1;
        page <= lastPage;
        page++
    ) {

        html += `

            <li class="page-item ${page === currentPage ? 'active' : ''}">

                <button
                    type="button"
                    class="page-link"
                    data-page="${page}"
                >

                    ${page}

                </button>

            </li>

        `;

    }


    /*
    |--------------------------------------------------------------------------
    | Next
    |--------------------------------------------------------------------------
    */

    html += `

        <li class="page-item ${currentPage >= lastPage ? 'disabled' : ''}">

            <button
                type="button"
                class="page-link"
                data-page="${currentPage + 1}"
                ${currentPage >= lastPage ? 'disabled' : ''}
            >

                <i class="bi bi-chevron-right"></i>

            </button>

        </li>

    `;


    paginationContainer.innerHTML = `

        <nav aria-label="Users pagination">

            <ul class="pagination justify-content-end mb-0">

                ${html}

            </ul>

        </nav>

    `;


    /*
    |--------------------------------------------------------------------------
    | Page Events
    |--------------------------------------------------------------------------
    */

    paginationContainer
        .querySelectorAll('[data-page]')
        .forEach(button => {

            button.addEventListener(
                'click',
                () => {

                    const page =
                        parseInt(
                            button.dataset.page
                        );

                    if (
                        page >= 1 &&
                        page <= lastPage
                    ) {

                        this.loadUsers(page);

                    }

                }
            );

        });

},
/**
 * ======================================================
 * RENDER USER ROW
 * ======================================================
 */

renderUserRow(user)
{

    const initials =
        (
            (user.first_name || '').charAt(0)
            +
            (user.last_name || '').charAt(0)
        ).toUpperCase();



    const avatar =
        user.profile_photo

            ? `

                <img
                    src="/storage/${user.profile_photo}"
                    class="user-avatar-image"
                >

            `

            : `

                <div class="user-avatar">

                    ${initials}

                </div>

            `;



    const role =
        user.role

            ? `

                <div class="role-info">

                    <div class="role-icon">

                        <i class="bi bi-shield-lock"></i>

                    </div>

                    <div>

                        <strong>
                            ${this.escapeHtml(
                                user.role.display_label ||
                                user.role.name ||
                                'No Role'
                            )}
                        </strong>

                        <small>
                            ${this.escapeHtml(
                                user.role.code || ''
                            )}
                        </small>

                    </div>

                </div>

            `

            : `

                <span class="text-muted">
                    No Role
                </span>

            `;



    const branch =
        user.branch?.name
            || 'All Branches';



    const status =
        user.status

            ? `

                <span class="user-status active">

                    <span></span>

                    Active

                </span>

            `

            : `

                <span class="user-status inactive">

                    <span></span>

                    Disabled

                </span>

            `;



    let activity = `

        <span class="text-muted">
            Never
        </span>

    `;



    if (user.last_activity_at) {

        const activityDate =
            new Date(
                user.last_activity_at
            );


        activity = `

            <div class="activity-main">

                ${this.formatActivityDate(
                    activityDate
                )}

            </div>

            <small class="text-muted">

                ${this.formatDateTime(
                    activityDate
                )}

            </small>

        `;

    }



    return `

        <tr>


            <td>

                <div class="user-info">

                    ${avatar}

                    <div>

                        <h6 class="mb-1">

                            ${this.escapeHtml(
                                user.full_name ||
                                (
                                    user.first_name
                                    + ' '
                                    + user.last_name
                                )
                            )}

                        </h6>

                        <div class="user-email">

                            ${this.escapeHtml(
                                user.email || ''
                            )}

                        </div>

                        <div class="user-username">

                            <i class="bi bi-person me-1"></i>

                            ${this.escapeHtml(
                                user.username || ''
                            )}

                        </div>

                    </div>

                </div>

            </td>



            <td>

                ${role}

            </td>



            <td>

                <div class="branch-info">

                    <i class="bi bi-building"></i>

                    <span>

                        ${this.escapeHtml(
                            branch
                        )}

                    </span>

                </div>

            </td>



            <td>

                ${status}

            </td>



            <td>

                ${activity}

            </td>



            <td class="text-end">

                ${this.renderUserActions(user)}

            </td>


        </tr>

    `;

},



    /**
     * ======================================================
     * CREATE USER
     * ======================================================
     */


    async storeUser(form){



        const submitButton =
            form.querySelector(
                'button[type="submit"]'
            );



        this.setLoading(
            submitButton,
            true
        );



        const formData =
            new FormData(form);



        this.clearErrors();




        try {



            const response = await fetch(

                USERS.store,

                {


                    method:'POST',



                    headers:{


                        'X-CSRF-TOKEN':

                            document
                            .querySelector(
                                'meta[name="csrf-token"]'
                            )
                            .content,



                        'Accept':'application/json'


                    },



                    body:formData


                }

            );





            const data =
                await response.json();






            if(!response.ok){



                this.setLoading(
                    submitButton,
                    false
                );




                if(data.errors){



                    this.showErrors(
                        data.errors
                    );



                    showToast(

                        'Please correct the highlighted fields.',

                        'warning'

                    );



                }else{



                    showToast(

                        data.message ??
                        'Unable to create user.',

                        'error'

                    );



                }



                return;


            }





            showToast(

                data.message,

                'success'

            );



            this.setLoading(

                submitButton,

                false

            );




            if(this.createModal){


                this.createModal.hide();


            }




            form.reset();



            setTimeout(()=>{


                window.location.reload();



            },1200);





        }

        catch(error){



            console.error(error);




            this.setLoading(

                submitButton,

                false

            );




            showToast(

                'Something went wrong while creating user.',

                'error'

            );


        }




    },

    /**
     * ======================================================
     * BUTTON LOADING STATE
     * ======================================================
     */


    setLoading(button, loading=true){



        if(!button){

            return;

        }




        if(loading){



            button.dataset.originalText =
                button.innerHTML;



            button.disabled = true;



            button.innerHTML = `


                <span class="spinner-border spinner-border-sm me-2"
                      role="status"
                      aria-hidden="true">
                </span>


                Saving...


            `;




        }else{



            button.disabled = false;



            if(button.dataset.originalText){


                button.innerHTML =
                    button.dataset.originalText;


            }



        }



    },

   /**
 * ======================================================
 * SAVE TERMINAL ASSIGNMENT
 * ======================================================
 */
async saveTerminalAssignment()
{
    const userId =
        document.getElementById(
            'terminalAssignmentUserId'
        )?.value;

    const terminalSelect =
        document.getElementById(
            'terminalAssignmentTerminal'
        );

    const saveButton =
        document.getElementById(
            'saveTerminalAssignmentBtn'
        );

    const spinner =
        document.getElementById(
            'saveTerminalAssignmentSpinner'
        );

    const icon =
        document.getElementById(
            'saveTerminalAssignmentIcon'
        );

    const buttonText =
        document.getElementById(
            'saveTerminalAssignmentText'
        );


    if (!userId) {

        console.error(
            'Terminal assignment user ID is missing.'
        );

        return;
    }


    if (!terminalSelect?.value) {

        return;
    }


    const terminalId =
        terminalSelect.value;


    try {

        /*
        |--------------------------------------------------------------------------
        | Loading State
        |--------------------------------------------------------------------------
        */

        if (saveButton) {

            saveButton.disabled = true;

        }

        if (spinner) {

            spinner.classList.remove('d-none');

        }

        if (icon) {

            icon.classList.add('d-none');

        }

        if (buttonText) {

            buttonText.textContent =
                'Saving...';

        }


        /*
        |--------------------------------------------------------------------------
        | Request
        |--------------------------------------------------------------------------
        */

        const response =
            await fetch(
                `/users/${userId}/terminal-assignment`,
                {
                    method: 'POST',

                    headers: {

                        'Content-Type':
                            'application/json',

                        'Accept':
                            'application/json',

                        'X-CSRF-TOKEN':
                            document.querySelector(
                                'meta[name="csrf-token"]'
                            )?.getAttribute('content'),

                    },

                    body: JSON.stringify({

                        terminal_id:
                            terminalId,

                    }),

                }
            );


        const data =
            await response.json();


        /*
        |--------------------------------------------------------------------------
        | Error Response
        |--------------------------------------------------------------------------
        */

        if (!response.ok || !data.status) {

            throw new Error(

                data.message
                ||
                'Failed to save terminal assignment.'

            );

        }


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        if (typeof showToast === 'function') {

            showToast(

                data.message
                ||
                'Terminal assigned successfully.',

                'success'

            );

        }


        /*
        |--------------------------------------------------------------------------
        | Close Modal
        |--------------------------------------------------------------------------
        */

        const modalElement =
            document.getElementById(
                'terminalAssignmentModal'
            );

        if (modalElement) {

            const modal =
                bootstrap.Modal.getInstance(
                    modalElement
                );

            if (modal) {

                modal.hide();

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Refresh Users Table
        |--------------------------------------------------------------------------
        */

        if (
            typeof Users !== 'undefined'
            &&
            typeof Users.loadTable === 'function'
        ) {

            await Users.loadTable();

        }
        else if (
            typeof users !== 'undefined'
            &&
            typeof users.loadTable === 'function'
        ) {

            await users.loadTable();

        }


    } catch (error) {

        console.error(
            'Terminal assignment error:',
            error
        );


        /*
        |--------------------------------------------------------------------------
        | Error Toast
        |--------------------------------------------------------------------------
        */

        if (typeof showToast === 'function') {

            showToast(

                error.message
                ||
                'Failed to save terminal assignment.',

                'error'

            );

        }


    } finally {

        /*
        |--------------------------------------------------------------------------
        | Reset Button
        |--------------------------------------------------------------------------
        */

        if (spinner) {

            spinner.classList.add('d-none');

        }

        if (icon) {

            icon.classList.remove('d-none');

        }

        if (buttonText) {

            buttonText.textContent =
                'Assign Terminal';

        }

        /*
        | Keep disabled until another terminal is selected
        */

        if (saveButton) {

            saveButton.disabled =
                !terminalSelect?.value;

        }

    }

},



    /**
     * ======================================================
     * VALIDATION ERRORS
     * ======================================================
     */


    showErrors(errors){



        Object.keys(errors).forEach(field=>{



            const input =
                document.querySelector(

                    `[name="${field}"]`

                );



            if(input){



                input.classList.add(
                    'is-invalid'
                );




                const feedback =
                    input.parentElement
                    .querySelector(
                        '.invalid-feedback'
                    );



                if(feedback){


                    feedback.innerHTML =
                        errors[field][0];


                }



            }



        });



    },

    clearErrors(){



        document
        .querySelectorAll(
            '.is-invalid'
        )
        .forEach(element=>{



            element.classList.remove(
                'is-invalid'
            );



        });





        document
        .querySelectorAll(
            '.invalid-feedback'
        )
        .forEach(element=>{



            element.innerHTML='';



        });



    },

    resetCreateForm(){



        const form =
            document.getElementById(
                'createUserForm'
            );



        if(form){


            form.reset();


        }




        this.clearErrors();



    },

    /**
     * ======================================================
     * FUTURE USER ACTIONS
     * ======================================================
     */


    view(id){


        console.log(
            'View user:',
            id
        );


    },



    async openEditUserModal(id)
{

    try {


        const response = await fetch(

            USERS.edit + id + '/edit',

            {

                method:'GET',

                headers:{

                    'Accept':'application/json',

                }

            }

        );


        const data = await response.json();



        if(!response.ok){


            showToast(

                data.message ??
                'Unable to load user details.',

                'error'

            );


            return;

        }




        this.populateEditForm(
            data.user
        );



        const modalElement =
            document.getElementById(
                'editUserModal'
            );



        const modal =
            bootstrap.Modal.getOrCreateInstance(
                modalElement
            );


        modal.show();



    }
    catch(error){


        console.error(error);



        showToast(

            'Unable to fetch user details.',

            'error'

        );


    }


},


populateEditForm(user)
{

    const form =
        document.getElementById(
            'editUserForm'
        );

    if (!form) {

        return;

    }

    form.dataset.userId = user.id;

    document.getElementById(
        'edit_branch_id'
    ).value =
        user.branch_id ?? '';

    document.getElementById(
        'edit_role_id'
    ).value =
        user.role_id ?? '';

    document.getElementById(
        'edit_employee_no'
    ).value =
        user.employee_no ?? '';

    document.getElementById(
        'edit_first_name'
    ).value =
        user.first_name ?? '';

    document.getElementById(
        'edit_last_name'
    ).value =
        user.last_name ?? '';

    document.getElementById(
        'edit_other_name'
    ).value =
        user.other_name ?? '';

    document.getElementById(
        'edit_username'
    ).value =
        user.username ?? '';

    document.getElementById(
        'edit_email'
    ).value =
        user.email ?? '';

    document.getElementById(
        'edit_phone'
    ).value =
        user.phone ?? '';

    document.getElementById(
        'edit_gender'
    ).value =
        user.gender ?? '';

    document.getElementById(
        'edit_date_of_birth'
    ).value =
        user.date_of_birth ?? '';

    document.getElementById(
        'edit_employment_date'
    ).value =
        user.employment_date ?? '';

    document.getElementById(
        'edit_address'
    ).value =
        user.address ?? '';

    document.getElementById(
        'edit_notes'
    ).value =
        user.notes ?? '';

        console.log('User status:', user.status, typeof user.status);
        
    document.getElementById(
        'edit_status'
    ).value =
        String(user.status ?? 1);

},

bindEditForm()
{

    const form =
        document.getElementById(
            'editUserForm'
        );

    if (!form) {

        return;

    }

    form.addEventListener(
        'submit',
        (e) =>
        {

            e.preventDefault();

            this.updateUser(form);

        }
    );

},

async updateUser(form)
{

    this.clearErrors(form); 

    const userId =
        form.dataset.userId;

    if (!userId) {

        showToast(
            'Invalid user selected.',
            'error'
        );

        return;

    }

    const submitButton =
        form.querySelector(
            'button[type="submit"]'
        );

    const originalHtml =
        submitButton.innerHTML;

    submitButton.disabled = true;

    submitButton.innerHTML = `

        <span
            class="spinner-border spinner-border-sm me-2">
        </span>

        Saving Changes...

    `;

    try {

        const formData =
            new FormData(form);

        formData.append(
            '_method',
            'PUT'
        );

        const response =
            await fetch(

                `${USERS.update}/${userId}`,

                {

                    method:'POST',

                    headers:{

                        'X-CSRF-TOKEN':
                        document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,

                        'Accept':
                        'application/json'

                    },

                    body:formData

                }

            );

        const data =
            await response.json();

        if (!response.ok) {

            if (data.errors) {

                this.showValidation(
                    form,
                    data.errors
                );

                showToast(
                    'Please correct the highlighted fields.',
                    'warning'
                );

            }
            else {

                showToast(
                    data.message ??
                    'Unable to update user.',
                    'error'
                );

            }

            return;

        }

        this.editModal.hide();

        showToast(
            data.message,
            'success'
        );

        setTimeout(() => {

            window.location.reload();

        }, 800);

    }
    catch (error) {

        console.error(error);

        showToast(
            'An unexpected error occurred.',
            'error'
        );

    }
    finally {

        submitButton.disabled = false;

        submitButton.innerHTML =
            originalHtml;

    }

},




async details(id)
{

    try{

        const response =
            await fetch(
                `${USERS.details}/${id}/details`,
                {
                    headers:{
                        Accept:'application/json'
                    }
                }
            );

        const data =
            await response.json();

        if(!response.ok){

            throw new Error(
                data.message ??
                'Unable to load user.'
            );

        }

        this.populateDetailsPanel(
            data.user
        );

        this.detailsPanel
            .classList
            .add('show');

    }
    catch(error){

        showToast(
            error.message,
            'error'
        );

    }

},

populateDetailsPanel(user)
{
     this.currentUserId = user.id;

    const initials =
        `${user.first_name?.charAt(0) ?? ''}${user.last_name?.charAt(0) ?? ''}`;

    document.getElementById('detailAvatar').textContent =
        initials.toUpperCase();

    document.getElementById('detailFullName').textContent =
        `${user.first_name ?? ''} ${user.last_name ?? ''}`;

    document.getElementById('detailRole').textContent =
        user.role ?? '-';

    document.getElementById('detailBranch').textContent =
        user.branch ?? '-';

    document.getElementById('detailStatus').textContent =
        user.status
            ? 'Active'
            : 'Disabled';

    document.getElementById('detailStatus').className =
        user.status
            ? 'badge bg-success'
            : 'badge bg-danger';

    document.getElementById('detailEmployeeNo').textContent =
        user.employee_no ?? '-';

    document.getElementById('detailUsername').textContent =
        user.username ?? '-';

    document.getElementById('detailEmail').textContent =
        user.email ?? '-';

    document.getElementById('detailPhone').textContent =
        user.phone ?? '-';

    document.getElementById('detailGender').textContent =
        user.gender ?? '-';

    document.getElementById('detailDOB').textContent =
        user.date_of_birth ?? '-';

    document.getElementById('detailBranchName').textContent =
        user.branch ?? '-';

    document.getElementById('detailRoleName').textContent =
        user.role ?? '-';

    document.getElementById('detailEmploymentDate').textContent =
        user.employment_date ?? '-';

    document.getElementById('detailAddress').textContent =
        user.address ?? '-';

    document.getElementById('detailNotes').textContent =
        user.notes ?? '-';

    document.getElementById('detailCreated').textContent =
        user.created_at ?? '-';

    document.getElementById('detailUpdated').textContent =
        user.updated_at ?? '-';

    document.getElementById('panelEditUser').onclick = () => {

        closeUserDetailsPanel();

        openEditUserModal(user.id);

    };

    document.getElementById('panelResetPassword').onclick = () => {

        closeUserDetailsPanel();

        openResetPasswordModal({

            id: user.id,

            first_name: user.first_name,

            last_name: user.last_name

        });

    };

    document.getElementById('panelDeleteUser').onclick = () => {

        closeUserDetailsPanel();

        openDeleteUserModal({

            id: user.id,

            first_name: user.first_name,

            last_name: user.last_name

        });

    };

    const statusButton =
    document.getElementById(
        'panelToggleStatus'
    );

    if (statusButton) {

        if (user.status) {

            statusButton.className =
                'btn btn-outline-secondary';

            statusButton.innerHTML = `

                <i class="bi bi-person-lock"></i>

                Disable

            `;

        }
        else {

            statusButton.className =
                'btn btn-outline-success';

            statusButton.innerHTML = `

                <i class="bi bi-person-check"></i>

                Enable

            `;

        }

        statusButton.onclick = () => {

            closeUserDetailsPanel();

            this.openToggleStatusModal(user);

        };

    }

    },   


    openDeleteUserModal(user)
    {

        this.currentUserId = user.id;

        document.getElementById(
            'deleteUserName'
        ).textContent =
            `${user.first_name} ${user.last_name}`;

        this.deleteModal.show();

    },

    async deleteUser()
{

    const button =
        document.getElementById(
            'confirmDeleteUser'
        );

    const originalHtml =
        button.innerHTML;

    button.disabled = true;

    button.innerHTML = `

        <span class="spinner-border spinner-border-sm me-2"></span>

        Deleting...

    `;

    try{

        const response =
            await fetch(

                `${USERS.destroy}/${this.currentUserId}`,

                {

                    method:'POST',

                    headers:{

                        'X-CSRF-TOKEN':
                        document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,

                        Accept:'application/json'

                    },

                    body:new URLSearchParams({

                        _method:'DELETE'

                    })

                }

            );

        const data =
            await response.json();

        if(!response.ok){

            throw new Error(

                data.message ??

                'Unable to delete user.'

            );

        }

        this.deleteModal.hide();

        showToast(

            data.message,

            'success'

        );

        setTimeout(()=>{

            window.location.reload();

        },600);

    }
    catch(error){

        showToast(

            error.message,

            'error'

        );

    }
    finally{

        button.disabled = false;

        button.innerHTML =

            originalHtml;

    }

},

openResetPasswordModal(user)
{

    this.currentUserId = user.id;

    document.getElementById(
        'resetUserName'
    ).textContent =
        `${user.first_name} ${user.last_name}`;

    document
        .getElementById(
            'generatedPasswordWrapper'
        )
        .classList
        .add('d-none');

    document.getElementById(
        'generatedPassword'
    ).value = '';

    this.resetPasswordModal.show();

},

async resetPassword()
{

    const button =
        document.getElementById(
            'confirmResetPassword'
        );

    const originalHtml =
        button.innerHTML;

    button.disabled = true;

    button.innerHTML = `

        <span class="spinner-border spinner-border-sm me-2"></span>

        Resetting...

    `;

    try{

        const response =
            await fetch(

                `${USERS.resetPassword}/${this.currentUserId}/reset-password`,

                {

                    method:'POST',

                    headers:{

                        'X-CSRF-TOKEN':
                        document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,

                        Accept:'application/json'

                    }

                }

            );

        const data =
            await response.json();

        if(!response.ok){

            throw new Error(

                data.message

            );

        }

        document
            .getElementById(
                'generatedPassword'
            )
            .value =
            data.password;

        document
            .getElementById(
                'generatedPasswordWrapper'
            )
            .classList
            .remove('d-none');

        showToast(

            data.message,

            'success'

        );

    }
    catch(error){

        showToast(

            error.message,

            'error'

        );

    }
    finally{

        button.disabled = false;

        button.innerHTML =
            originalHtml;

    }

},

copyGeneratedPassword()
{

    const password =
        document.getElementById(
            'generatedPassword'
        );

    navigator.clipboard
        .writeText(
            password.value
        );

    showToast(

        'Password copied.',

        'success'

    );

},




   openToggleStatusModal(user)
{

    this.currentUserId =
        user.id;

    this.currentUserStatus =
        Boolean(user.status);

    document.getElementById(
        'toggleStatusUserName'
    ).textContent =
        `${user.first_name} ${user.last_name}`;

    const title =
        document.getElementById(
            'toggleStatusTitle'
        );

    const heading =
        document.getElementById(
            'toggleStatusHeading'
        );

    const message =
        document.getElementById(
            'toggleStatusMessage'
        );

    const icon =
        document.getElementById(
            'toggleStatusIcon'
        );

    const largeIcon =
        document.getElementById(
            'toggleStatusLargeIcon'
        );

    const button =
        document.getElementById(
            'confirmToggleStatus'
        );



    if(this.currentUserStatus){

        title.innerHTML = `

            <i
                class="bi bi-person-x-fill me-2 text-danger">
            </i>

            Disable User

        `;

        heading.textContent =
            'Disable this user?';

        message.textContent =
            'The user will no longer be able to sign into the system until re-enabled.';

        icon.className =
            'bi bi-person-x-fill text-danger';

        largeIcon.className =
            'bi bi-person-x-fill text-danger';

        button.className =
            'btn btn-danger';

        button.innerHTML = `

            <i class="bi bi-person-x me-1"></i>

            Disable User

        `;

    }
    else{

        title.innerHTML = `

            <i
                class="bi bi-person-check-fill me-2 text-success">
            </i>

            Enable User

        `;

        heading.textContent =
            'Enable this user?';

        message.textContent =
            'The user will regain access to the system.';

        icon.className =
            'bi bi-person-check-fill text-success';

        largeIcon.className =
            'bi bi-person-check-fill text-success';

        button.className =
            'btn btn-success';

        button.innerHTML = `

            <i class="bi bi-person-check me-1"></i>

            Enable User

        `;

    }

    this.toggleStatusModal.show();

},

async toggleStatus()
{

    try{

        const formData = new FormData();

    formData.append('_method', 'PATCH');

    const response =
        await fetch(

            `${USERS.toggleStatus}/${this.currentUserId}/toggle-status`,

            {

                method: 'POST',

                headers:{

                    'X-CSRF-TOKEN':
                    document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,

                    'Accept':
                    'application/json'

                },

                body: formData

            }

        );

        const data =
            await response.json();

        if(!response.ok){

            throw new Error(
                data.message ??
                'Unable to update user status.'
            );

        }

        this.toggleStatusModal.hide();

        showToast(
            data.message,
            'success'
        );

        setTimeout(() => {

            window.location.reload();

        }, 700);

    }
    catch(error){

        showToast(
            error.message,
            'error'
        );

    }

},

};  

document.addEventListener(

    'DOMContentLoaded',

    () => {

        Users.init();

    }

);

window.openEditUserModal = function (userId)
{
    Users.openEditUserModal(userId);
};

window.openUserDetailsPanel =
function(id)
{
    Users.details(id);
};

window.closeUserDetailsPanel =
function()
{
    document
        .getElementById(
            'userDetailsPanel'
        )
        .classList
        .remove('show');
};

window.openResetPasswordModal =
function(user)
{
    Users.openResetPasswordModal(user);
};

window.openDeleteUserModal =
function(user)
{
    Users.openDeleteUserModal(user);
};

window.openToggleStatusModal =
function(user)
{
    Users.openToggleStatusModal(user);
};





