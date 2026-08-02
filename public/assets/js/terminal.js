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



    // ==========================
    // Initialization
    // ==========================


    init() {

        this.cacheElements();

        this.bindEvents();

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


        const terminalButtons =
            document.querySelectorAll(
                '.viewTerminal'
            );          


        if(terminalButtons.length){


            terminalButtons.forEach(button => {


                button.onclick = () => {                 


                    const id =
                        button.dataset.id;


                    this.openInspector(id);


                };


            });


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


// ==========================
// Render Inspector
// ==========================

renderInspector(terminal){


    const container =
        document.getElementById(
            'terminalInspectorContent'
        );


    if(!container){

        return;

    }


    container.innerHTML = `

<div class="terminal-profile">


    <div class="terminal-header">

        <div class="terminal-icon">

            <i class="bi bi-pc-display"></i>

        </div>


        <div>

            <h5 class="mb-1">
                ${terminal.terminal_name}
            </h5>


            <span class="terminal-code">
                ${terminal.terminal_code}
            </span>

        </div>


    </div>




    <div class="terminal-info-card">


        <div class="terminal-detail-grid">


            <div class="terminal-detail-item">

                <span class="detail-label">
                    Branch
                </span>

                <span class="detail-value">
                    ${terminal.branch?.name ?? '-'}
                </span>

            </div>



            <div class="terminal-detail-item">

                <span class="detail-label">
                    Device Name
                </span>

                <span class="detail-value">
                    ${terminal.device_name ?? '-'}
                </span>

            </div>



            <div class="terminal-detail-item">

                <span class="detail-label">
                    IP Address
                </span>

                <span class="detail-value">
                    ${terminal.ip_address ?? '-'}
                </span>

            </div>



            <div class="terminal-detail-item">

                <span class="detail-label">
                    Status
                </span>

                <span class="detail-value">

                    ${
                        terminal.status
                        ?
                        `
                        <span class="status-badge active">
                            Active
                        </span>
                        `
                        :
                        `
                        <span class="status-badge inactive">
                            Disabled
                        </span>
                        `
                    }

                </span>

            </div>


        </div>


    </div>


</div>




    <div class="terminal-actions">


        <h6>
            Quick Actions
        </h6>


        <div class="action-grid">


            <button
                id="panelEditTerminal"
                class="terminal-panel-btn primary">

                <i class="bi bi-pencil-square"></i>

                Edit

            </button>



            <button
                id="panelToggleTerminal"
                class="terminal-panel-btn warning">


                ${
                    terminal.status
                    ?
                    `
                    <i class="bi bi-toggle-off"></i>
                    Disable Terminal
                    `
                    :
                    `
                    <i class="bi bi-toggle-on"></i>
                    Enable Terminal
                    `
                }


            </button>



            <button
                id="panelDeleteTerminal"
                class="terminal-panel-btn danger">

                <i class="bi bi-trash"></i>

                Delete

            </button>


        </div>


    </div>



</div>

`;


    this.bindInspectorActions();
    


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