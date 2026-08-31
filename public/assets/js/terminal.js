const Terminals = {


    // ==========================
    // Properties
    // ==========================


    createModal: null,

    editModal: null,

    deleteModal: null,

    inspector: null,

    currentTerminalData: null,

    toggleStatusModal: null,

    currentTerminalStatus: null,

    currentTerminalId: null,

    searchTimer: null,



    // ==========================
    // Initialization
    // ==========================


    init() {

        this.cacheElements();

        this.bindEvents();

        this.initializeSearch();

    },



    // ==========================
    // Cache DOM Elements
    // ==========================


    cacheElements() {


        const createModal =
            document.getElementById(
                'createTerminalModal'
            );


        if(createModal){

            this.createModal =
                new bootstrap.Modal(
                    createModal
                );

        }




        const editModal =
            document.getElementById(
                'editTerminalModal'
            );


        if(editModal){

            this.editModal =
                new bootstrap.Modal(
                    editModal
                );

        }





        const deleteModal =
            document.getElementById(
                'deleteTerminalModal'
            );


        if(deleteModal){

            this.deleteModal =
                new bootstrap.Modal(
                    deleteModal
                );

        }





        const toggleModal =
            document.getElementById(
                'toggleTerminalStatusModal'
            );


        if(toggleModal){


            this.toggleStatusModal =
                new bootstrap.Modal(
                    toggleModal
                );


        }

        const inspector =
            document.getElementById(
                'terminalInspector'
            );


        if(inspector){

            this.inspector =
                new bootstrap.Offcanvas(
                    inspector
                );

        }


    },
    
    // ==========================
    // Event Binding
    // ==========================


    bindEvents() {


        /*
        |--------------------------------------------------------------------------
        | Terminal Search
        |--------------------------------------------------------------------------
        */

        const terminalSearch =
            document.getElementById('terminalSearch');

        if (terminalSearch) {

            terminalSearch.addEventListener(
                'input',
                () => {

                    clearTimeout(
                        this.searchTimer
                    );

                    this.searchTimer =
                        setTimeout(() => {

                            const search =
                                terminalSearch.value.trim();

                            const url =
                                new URL(
                                    window.location.href
                                );

                            /*
                            |--------------------------------------------------------------------------
                            | Update Search
                            |--------------------------------------------------------------------------
                            */

                            if (search) {

                                url.searchParams.set(
                                    'search',
                                    search
                                );

                            } else {

                                url.searchParams.delete(
                                    'search'
                                );

                            }

                            /*
                            |--------------------------------------------------------------------------
                            | Reset Pagination
                            |--------------------------------------------------------------------------
                            */

                            url.searchParams.delete(
                                'page'
                            );

                            /*
                            |--------------------------------------------------------------------------
                            | Reload Table
                            |--------------------------------------------------------------------------
                            */

                            window.location.href =
                                url.toString();

                        }, 500);

                }
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Create Terminal
        |--------------------------------------------------------------------------
        */


        const createButton =
            document.getElementById(
                'addTerminalBtn'
            );


        if(createButton){

            createButton.onclick = () => {

                this.openCreateModal();

            };

        }




        const saveButton =
            document.getElementById(
                'saveTerminal'
            );


        if(saveButton){

            saveButton.onclick = () => {

                this.store();

            };

        }    

      /*
        |--------------------------------------------------------------------------
        | Table Inspector Buttons
        |--------------------------------------------------------------------------
        */

        const terminalTable =
            document.getElementById(
                'terminalTable'
            );

        if (terminalTable) {

            terminalTable.addEventListener(
                'click',
                (event) => {

                    const button =
                        event.target.closest(
                            '.viewTerminal'
                        );

                    if (!button) {
                        return;
                    }

                    const id =
                        button.dataset.id;

                    if (!id) {
                        return;
                    }

                    this.openInspector(id);

                }
            );

        }
        /*
        |--------------------------------------------------------------------------
        | Update Terminal
        |--------------------------------------------------------------------------
        */


        const updateButton =
            document.getElementById(
                'updateTerminal'
            );


        if(updateButton){

            updateButton.onclick = () => {

                this.update();

            };

        }

        const confirmToggle =
            document.getElementById(
                'confirmToggleTerminal'
            );


        if(confirmToggle){


            confirmToggle.onclick = () => {


                this.toggleStatus();


            };


        }

        const confirmDelete =
            document.getElementById(
                'confirmDeleteTerminal'
            );


        if(confirmDelete){


            confirmDelete.onclick = () => {


                this.delete();


            };


        }


    },



    // ==========================
    // Open Create Modal
    // ==========================


    openCreateModal(){


        const form =
            document.getElementById(
                'createTerminalForm'
            );


        if(form){

            form.reset();

            this.clearErrors(form);

        }


        this.createModal.show();


    },





    // ==========================
    // Store Terminal
    // ==========================


    async store(){


        const form =
            document.getElementById(
                'createTerminalForm'
            );


        this.clearErrors(form);


        const formData =
            new FormData(form);


        try{


            const response =
                await fetch(
                    '/terminals',
                    {

                        method:'POST',

                        headers:{

                            'Accept':'application/json',

                            'X-CSRF-TOKEN':
                            document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content

                        },

                        body:formData

                    }
                );


            const data =
                await response.json();


            if(!response.ok){

                if(data.errors){

                    this.showValidation(
                        form,
                        data.errors
                    );


                    showToast(
                        'Please correct the highlighted fields.',
                        'warning'
                    );

                }
                else{

                    showToast(
                        data.message,
                        data.type ?? 'warning'
                    );

                }


                return;

            }


            showToast(
                data.message,
                data.type ?? 'success'
            );


            this.createModal.hide();


            form.reset();


            setTimeout(()=>{

                window.location.reload();

            },1000);



        }
        catch(error){


            console.error(error);


            showToast(
                'Unable to create terminal.',
                'error'
            );


        }


    },

 // ==========================
// Open Inspector
// ==========================

async openInspector(id){

console.log(
        'Opening inspector for terminal:',
        id
    );
    this.currentTerminalId = id;


    try{


        const response =
            await fetch(
                `/terminals/${id}/details`,
                {

                    headers:{

                        'Accept': 'application/json'

                    }

                }
            );


        const data =
            await response.json();


        if(!response.ok){


            showToast(
                data.message,
                data.type ?? 'warning'
            );


            return;

        }


        this.currentTerminalData =
            data.terminal;


        this.renderInspector(
            data.terminal
        );


        if(this.inspector){

            this.inspector.show();

        }


    }
    catch(error){


        console.error(error);


        showToast(
            'Unable to load terminal details.',
            'error'
        );


    }


},

/*
|--------------------------------------------------------------------------
| Terminal Search
|--------------------------------------------------------------------------
*/

initializeSearch()
{
    const searchInput =
        document.getElementById(
            'terminalSearch'
        );

    if (!searchInput) {
        return;
    }

    searchInput.addEventListener(
        'input',
        () => {

            clearTimeout(
                this.searchTimer
            );

            this.searchTimer =
                setTimeout(() => {

                    this.loadTable(
                        searchInput.value.trim()
                    );

                }, 250);

        }
    );
},

/*
|--------------------------------------------------------------------------
| Load Terminal Table
|--------------------------------------------------------------------------
*/

async loadTable(search = '')
{
    const tableBody =
        document.getElementById(
            'terminalTable'
        );

    if (!tableBody) {
        return;
    }

    try {

        tableBody.style.opacity = '0.5';

        const params =
            new URLSearchParams();

        if (search) {

            params.set(
                'search',
                search
            );

        }

        const response =
            await fetch(
                `/terminals/table?${params.toString()}`,
                {
                    method: 'GET',

                    headers: {
                        'X-Requested-With':
                            'XMLHttpRequest',

                        'Accept':
                            'text/html'
                    }
                }
            );

        if (!response.ok) {

            throw new Error(
                'Failed to load terminal table.'
            );

        }

        const html =
            await response.text();

        tableBody.innerHTML =
            html;

    } catch (error) {

        console.error(
            'Terminal search error:',
            error
        );

    } finally {

        tableBody.style.opacity = '1';

    }
},

/*
|--------------------------------------------------------------------------
| Render Inspector
|--------------------------------------------------------------------------
*/

renderInspector(terminal) {

    const container =
        document.getElementById(
            'terminalInspectorContent'
        );

    if (!container) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Current Assignment
    |--------------------------------------------------------------------------
    */

    const assignment =
        terminal.activeAssignment
        ?? terminal.active_assignment
        ?? null;


    const assignedUser =
        assignment?.user
        ?? null;


    const assignedUserName =
        assignedUser
            ? [
                assignedUser.first_name,
                assignedUser.other_name,
                assignedUser.last_name
            ]
                .filter(Boolean)
                .join(' ')
            : null;


    const isInUse =
        !!assignment
        && assignment.status === 'Active';


    /*
    |--------------------------------------------------------------------------
    | Terminal Status
    |--------------------------------------------------------------------------
    */

    const terminalStatus =
        terminal.status
            ? 'Active'
            : 'Disabled';


    const terminalStatusClass =
        terminal.status
            ? 'active'
            : 'disabled';


    /*
    |--------------------------------------------------------------------------
    | Assignment Status
    |--------------------------------------------------------------------------
    */

    const assignmentStatusClass =
        isInUse
            ? 'in-use'
            : 'available';


    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    container.innerHTML = `

        <div class="terminal-inspector">           

            <div class="terminal-inspector-header">

                <div class="terminal-profile-main">

                    <div class="terminal-profile-icon">

                        <i class="bi bi-pc-display"></i>

                    </div>

                    <div class="terminal-profile-heading">

                        <h4>
                            ${terminal.terminal_name ?? '-'}
                        </h4>

                        <div class="terminal-profile-code">

                            <span>
                                ${terminal.terminal_code ?? '-'}
                            </span>

                        </div>

                    </div>

                </div>


                <div class="terminal-header-status">

                    <span class="terminal-status-pill ${terminalStatusClass}">

                        <span class="status-dot"></span>

                        ${terminalStatus}

                    </span>

                </div>

            </div>


            <div class="terminal-operational-card">

                <div class="operational-card-header">

                    <div>

                        <span class="section-eyebrow">
                            Terminal Status
                        </span>

                        <h6>
                            Current availability
                        </h6>

                    </div>

                    <div class="operational-icon ${assignmentStatusClass}">

                        <i class="bi ${
                            isInUse
                                ? 'bi-person-check'
                                : 'bi-check-circle'
                        }"></i>

                    </div>

                </div>


                <div class="operational-status-row">

                    <div>

                        <span class="operational-label">
                            ${isInUse ? 'In Use' : 'Available'}
                        </span>

                        <span class="operational-description">

                            ${
                                isInUse
                                    ? 'This terminal is currently assigned to a cashier.'
                                    : 'This terminal is currently available for assignment.'
                            }

                        </span>

                    </div>


                    <span class="assignment-status ${assignmentStatusClass}">

                        ${isInUse ? 'In Use' : 'Available'}

                    </span>

                </div>

            </div>



            <div class="terminal-section">

                <div class="terminal-section-header">

                    <div>

                        <span class="section-eyebrow">
                            Assignment
                        </span>

                        <h6>
                            Current Cashier
                        </h6>

                    </div>

                </div>


                <div class="terminal-cashier-card">

                    <div class="terminal-cashier-avatar">

                        ${
                            assignedUser
                                ? `
                                    ${
                                        (
                                            assignedUser.first_name?.charAt(0)
                                            ?? ''
                                        )
                                        +
                                        (
                                            assignedUser.last_name?.charAt(0)
                                            ?? ''
                                        )
                                    }
                                `
                                : `
                                    <i class="bi bi-person"></i>
                                `
                        }

                    </div>


                    <div class="terminal-cashier-info">

                        <div class="terminal-cashier-name">

                            ${
                                assignedUserName
                                ?? 'No cashier assigned'
                            }

                        </div>


                        <div class="terminal-cashier-meta">

                            ${
                                isInUse
                                    ? `
                                        <span>
                                            <i class="bi bi-person-badge"></i>
                                            Cashier
                                        </span>
                                      `
                                    : `
                                        <span>
                                            <i class="bi bi-dash-circle"></i>
                                            Terminal available
                                        </span>
                                      `
                            }

                        </div>

                    </div>


                    ${
                        isInUse
                            ? `
                                <div class="terminal-cashier-active">

                                    <span class="status-dot"></span>

                                    Active

                                </div>
                              `
                            : ''
                    }

                </div>

            </div>


            <div class="terminal-section">

                <div class="terminal-section-header">

                    <div>

                        <span class="section-eyebrow">
                            Configuration
                        </span>

                        <h6>
                            Terminal Information
                        </h6>

                    </div>

                </div>


                <div class="terminal-detail-grid">

                    <div class="terminal-detail-card">

                        <span class="terminal-detail-label">
                            Branch
                        </span>

                        <span class="terminal-detail-value">

                            ${terminal.branch?.name ?? '-'}

                        </span>

                    </div>


                    <div class="terminal-detail-card">

                        <span class="terminal-detail-label">
                            Device Name
                        </span>

                        <span class="terminal-detail-value">

                            ${terminal.device_name ?? '-'}

                        </span>

                    </div>


                    <div class="terminal-detail-card">

                        <span class="terminal-detail-label">
                            IP Address
                        </span>

                        <span class="terminal-detail-value">

                            ${terminal.ip_address ?? '-'}

                        </span>

                    </div>


                    <div class="terminal-detail-card">

                        <span class="terminal-detail-label">
                            Terminal Code
                        </span>

                        <span class="terminal-detail-value">

                            ${terminal.terminal_code ?? '-'}

                        </span>

                    </div>

                </div>

            </div>


            <div class="terminal-section terminal-actions-section">

                <div class="terminal-section-header">

                    <div>

                        <span class="section-eyebrow">
                            Actions
                        </span>

                        <h6>
                            Quick Actions
                        </h6>

                    </div>

                </div>


                <div class="action-grid">

                    ${
                        window.terminalPermissions?.update
                            ?

                            `
                                <button
                                    type="button"
                                    id="panelEditTerminal"
                                    class="terminal-panel-btn primary"
                                >

                                    <i class="bi bi-pencil-square"></i>

                                    <span>
                                        Edit Terminal
                                    </span>

                                </button>
                            `

                            :

                            ''
                    }


                    ${
                        window.terminalPermissions?.update
                            ?

                            `
                                <button
                                    type="button"
                                    id="panelToggleTerminal"
                                    class="terminal-panel-btn warning"
                                >

                                    <i class="bi ${
                                        terminal.status
                                            ? 'bi-toggle-off'
                                            : 'bi-toggle-on'
                                    }"></i>

                                    <span>

                                        ${
                                            terminal.status
                                                ? 'Disable Terminal'
                                                : 'Enable Terminal'
                                        }

                                    </span>

                                </button>
                            `

                            :

                            ''
                    }


                    ${
                        window.terminalPermissions?.delete
                            ?

                            `
                                <button
                                    type="button"
                                    id="panelDeleteTerminal"
                                    class="terminal-panel-btn danger"
                                >

                                    <i class="bi bi-trash"></i>

                                    <span>
                                        Delete Terminal
                                    </span>

                                </button>
                            `

                            :

                            ''
                    }

                </div>

            </div>


            <div class="terminal-section">

                <div class="terminal-section-header">

                    <div>

                        <span class="section-eyebrow">
                            History
                        </span>

                        <h6>
                            Terminal Activity
                        </h6>

                    </div>

                </div>


                <div
                    id="terminalAssignmentActivity"
                    class="terminal-activity-list"
                >

                    <div class="terminal-activity-empty">

                        <i class="bi bi-clock-history"></i>

                        <span>
                            No recent terminal activity.
                        </span>

                    </div>

                </div>

            </div>


        </div>

    `;


    /*
    |--------------------------------------------------------------------------
    | Render Assignment Activities
    |--------------------------------------------------------------------------
    */

    this.renderTerminalAssignmentActivity(
        terminal
    );


    /*
    |--------------------------------------------------------------------------
    | Bind Inspector Actions
    |--------------------------------------------------------------------------
    */

    this.bindInspectorActions();

},

/*
|--------------------------------------------------------------------------
| Format Date / Time
|--------------------------------------------------------------------------
*/

formatDateTime(value) {

    if (!value) {
        return '-';
    }

    const date = new Date(value);

    if (Number.isNaN(date.getTime())) {
        return '-';
    }

    return date.toLocaleString(
        'en-NG',
        {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        }
    );
},

/*
|--------------------------------------------------------------------------
| Render Terminal Assignment Activity
|--------------------------------------------------------------------------
*/

renderTerminalAssignmentActivity(terminal) {

    const container =
        document.getElementById(
            'terminalAssignmentActivity'
        );

    if (!container) {
        return;
    }


    const assignments =
        terminal.assignments
        ?? terminal.terminal_assignments
        ?? [];


    if (!assignments.length) {

        container.innerHTML = `

            <div class="terminal-activity-empty">

                <i class="bi bi-clock-history"></i>

                <span>
                    No terminal assignment activity yet.
                </span>

            </div>

        `;

        return;
    }


    container.innerHTML =
        assignments
            .map(assignment => {

                const user =
                    assignment.user
                    ?? null;


                const userName =
                    user
                        ? [
                            user.first_name,
                            user.other_name,
                            user.last_name
                        ]
                            .filter(Boolean)
                            .join(' ')
                        : 'Unknown user';


                const status =
                    assignment.status
                    ?? 'Unknown';


                const statusClass =
                    status.toLowerCase() === 'active'
                        ? 'active'
                        : 'inactive';


                const assignedAt =
                    assignment.assigned_at
                    ?? assignment.created_at
                    ?? null;


                return `

                    <div class="terminal-activity-item">

                        <div class="terminal-activity-icon">

                            <i class="bi bi-person-check"></i>

                        </div>


                        <div class="terminal-activity-content">

                            <div class="terminal-activity-title">

                                ${userName}

                            </div>


                            <div class="terminal-activity-description">

                                Terminal assignment

                            </div>


                            ${
                                assignedAt
                                    ? `
                                        <div class="terminal-activity-date">

                                            <i class="bi bi-clock"></i>

                                            ${this.formatDateTime(assignedAt)}

                                        </div>
                                      `
                                    : ''
                            }

                        </div>


                        <span class="assignment-history-status ${statusClass}">

                            ${status}

                        </span>

                    </div>

                `;

            })
            .join('');

},


// ==========================
// Bind Inspector Actions
// ==========================

bindInspectorActions(){   


    const editButton =
        document.getElementById(
            'panelEditTerminal'
        );


    if(editButton){


        editButton.onclick = () => {


            if(this.inspector){

                this.inspector.hide();

            }


            this.edit(
                this.currentTerminalId
            );


        };


    }

    const toggleButton =
        document.getElementById(
            'panelToggleTerminal'
        );


    if(toggleButton){


        toggleButton.onclick = () => {


            this.openToggleModal();


        };


    }

    const deleteButton =
    document.getElementById(
        'panelDeleteTerminal'
    );


    if(deleteButton){


        deleteButton.onclick = () => {


            this.openDeleteModal();


        };


    }


},


// ==========================
// Edit Terminal
// ==========================

async edit(id){


    this.currentTerminalId = id;


    try{


        const response =
            await fetch(
                `/terminals/${id}/edit`,
                {

                    headers:{

                        'Accept': 'application/json'

                    }

                }
            );


        const data =
            await response.json();


        if(!response.ok){


            showToast(
                data.message,
                data.type ?? 'warning'
            );


            return;

        }


        const terminal =
            data.terminal;


        const form =
            document.getElementById(
                'editTerminalForm'
            );


        if(!form){

            showToast(
                'The edit terminal form could not be found.',
                'error'
            );

            return;

        }


        this.clearErrors(form);


        form.querySelector(
            '[name="branch_id"]'
        ).value = terminal.branch_id ?? '';


        form.querySelector(
            '[name="terminal_code"]'
        ).value = terminal.terminal_code ?? '';


        form.querySelector(
            '[name="terminal_name"]'
        ).value = terminal.terminal_name ?? '';


        form.querySelector(
            '[name="device_name"]'
        ).value = terminal.device_name ?? '';


        form.querySelector(
            '[name="ip_address"]'
        ).value = terminal.ip_address ?? '';


        form.querySelector(
            '[name="description"]'
        ).value = terminal.description ?? '';


        if(this.editModal){

            this.editModal.show();

        }


    }
    catch(error){


        console.error(error);


        showToast(
            'Unable to load terminal.',
            'error'
        );


    }


},

    

async update(){


    const form =
        document.getElementById(
            'editTerminalForm'
        );


    this.clearErrors(form);



    const id =
        this.currentTerminalId;



    const formData =
        new FormData(form);


    formData.append(
        '_method',
        'PUT'
    );



    try{


        const response =
            await fetch(
                `/terminals/${id}`,
                {


                    method:'POST',


                    headers:{


                        'Accept':'application/json',


                        'X-CSRF-TOKEN':
                        document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content


                    },


                    body:formData


                }
            );



        const data =
            await response.json();




        if(!response.ok){


            if(data.errors){


                this.showValidation(
                    form,
                    data.errors
                );


                showToast(
                    'Please correct the highlighted fields.',
                    'warning'
                );


            }
            else{


                showToast(
                    data.message,
                    data.type ?? 'warning'
                );


            }


            return;

        }




        showToast(
            data.message,
            data.type ?? 'success'
        );



        this.editModal.hide();



        setTimeout(()=>{

            location.reload();

        },1000);



    }
    catch(error){


        console.error(error);


        showToast(
            'Unable to update terminal.',
            'error'
        );


    }


},

// ==========================
// Open Toggle Modal
// ==========================


openToggleModal()
{


    const message =
        document.getElementById(
            'toggleTerminalMessage'
        );


    if(this.currentTerminalData.status){


        message.innerHTML =
        `
        Are you sure you want to disable
        <strong>
        ${this.currentTerminalData.terminal_name}
        </strong>?
        `;


    }
    else{


        message.innerHTML =
        `
        Are you sure you want to enable
        <strong>
        ${this.currentTerminalData.terminal_name}
        </strong>?
        `;


    }


    this.toggleStatusModal.show();


},

// ==========================
// Toggle Status
// ==========================


async toggleStatus()
{


    try{


        const response =
            await fetch(
            `/terminals/${this.currentTerminalId}/toggle-status`,
            {

                method:'POST',

                headers:{


                    'Accept':'application/json',

                    'Content-Type':'application/json',

                    'X-CSRF-TOKEN':
                    document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content


                },


                body: JSON.stringify({

                    _method:'PATCH'

                })

            }
        );



        const data =
            await response.json();




        if(!response.ok){


            showToast(
                data.message,
                data.type ?? 'warning'
            );


            return;

        }



        showToast(

            data.message,

            data.type ?? 'success'

        );



        this.toggleStatusModal.hide();



        setTimeout(()=>{


            location.reload();


        },1000);



    }
    catch(error){


        console.error(error);


        showToast(

            'Unable to change terminal status.',

            'error'

        );


    }


},

// ==========================
// Open Delete Modal
// ==========================


openDeleteModal()
{


    const message =
        document.getElementById(
            'deleteTerminalMessage'
        );


    message.innerHTML =
    `
    Are you sure you want to delete
    <strong>
    ${this.currentTerminalData.terminal_name}
    </strong>?
    `;


    this.deleteModal.show();


},

// ==========================
// Delete Terminal
// ==========================


async delete()
{


    try{


        const response =
            await fetch(
                `/terminals/${this.currentTerminalId}`,
                {


                    method:'DELETE',


                    headers:{


                        'Accept':'application/json',


                        'X-CSRF-TOKEN':
                        document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content


                    }


                }
            );



        const data =
            await response.json();




        if(!response.ok){


            showToast(

                data.message,

                data.type ?? 'warning'

            );


            return;


        }




        showToast(

            data.message,

            data.type ?? 'success'

        );



        this.deleteModal.hide();



        setTimeout(()=>{


            window.location.reload();


        },1000);



    }
    catch(error){


        console.error(error);


        showToast(

            'Unable to delete terminal.',

            'error'

        );


    }


},



    // ==========================
    // Helpers
    // ==========================


    clearErrors(form){


        form.querySelectorAll('.is-invalid')
            .forEach(element=>{


                element.classList.remove(
                    'is-invalid'
                );


            });



        form.querySelectorAll('.invalid-feedback')
            .forEach(element=>{


                element.textContent='';


            });


    },





    showValidation(form, errors){


        Object.keys(errors)
            .forEach(field=>{


                const input =
                    form.querySelector(
                        `[name="${field}"]`
                    );



                if(input){


                    input.classList.add(
                        'is-invalid'
                    );



                    const feedback =
                        input.parentElement.querySelector(
                            '.invalid-feedback'
                        );



                    if(feedback){

                        feedback.textContent =
                            errors[field][0];

                    }


                }


            });


    }



};





// Start Module

document.addEventListener(
    'DOMContentLoaded',
    ()=>{


        Terminals.init();


    }
);