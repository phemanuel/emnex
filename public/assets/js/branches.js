const Branches = {

    createModal: null,

    editModal: null,

    deleteModal: null,   

    currentBranchId: null,

    toggleStatusModal: null,

    currentBranchStatus: null,
   

    init()
    {

        const createModalElement =
            document.getElementById(
                'createBranchModal'
            );

        if(createModalElement){

            this.createModal =
                new bootstrap.Modal(
                    createModalElement
                );

        }

        const editModalElement =
            document.getElementById(
                'editBranchModal'
            );

        if(editModalElement){

            this.editModal =
                new bootstrap.Modal(
                    editModalElement
                );

        }


        const deleteModalElement =
            document.getElementById(
                'deleteBranchModal'
            );

        if(deleteModalElement){

            this.deleteModal =
                new bootstrap.Modal(
                    deleteModalElement
                );

        }    

        const toggleStatusModal =

            document.getElementById(
                'toggleBranchStatusModal'
            );

        if(toggleStatusModal){

            this.toggleStatusModal =

                new bootstrap.Modal(
                    toggleStatusModal
                );

        }

        this.bindEvents();

    },

    bindEvents()
    {

        /*
        |--------------------------------------------------------------------------
        | Open Create Modal
        |--------------------------------------------------------------------------
        */

        const createButton =
            document.getElementById(
                'openCreateBranchModal'
            );

        if(createButton){

            createButton.addEventListener(

                'click',

                ()=>{

                    const form =
                        document.getElementById(
                            'createBranchForm'
                        );

                    form.reset();

                    this.clearErrors(form);

                    this.createModal.show();

                }

            );

        }


        /*
        |--------------------------------------------------------------------------
        | Store Branch
        |--------------------------------------------------------------------------
        */

        const createForm =
            document.getElementById(
                'createBranchForm'
            );

        if(createForm){

            createForm.addEventListener(

                'submit',

                (event)=>{

                    event.preventDefault();

                    this.store(
                        createForm
                    );

                }

            );

        }

        const editForm =
            document.getElementById(
                'editBranchForm'
            );

        if(editForm){

            editForm.addEventListener(

                'submit',

                (event)=>{

                    event.preventDefault();

                    this.updateBranch(
                        editForm
                    );

                }

            );

        }

        const deleteButton =
            document.getElementById(
                'confirmDeleteBranch'
            );

        if(deleteButton){

            deleteButton.addEventListener(

                'click',

                () => {

                    this.delete();

                }

            );

        }

        const toggleButton =

            document.getElementById(
                'confirmToggleBranchStatus'
            );

        if(toggleButton){

            toggleButton.addEventListener(

                'click',

                ()=>{

                    this.toggleStatus();

                }

            );

        }

    },

    async store(form)
{

    this.clearErrors(form);

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

        Saving...

    `;

    try{

        const formData =
            new FormData(form);

        const response =
            await fetch(

                BRANCHES.store,

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
                    data.message ??
                    'Unable to create branch.',
                    'error'
                );

            }

            return;

        }

        this.createModal.hide();

        showToast(
            data.message,
            'success'
        );

        setTimeout(()=>{

            window.location.reload();

        },800);

    }
    catch(error){

        console.error(error);

        showToast(
            'An unexpected error occurred.',
            'error'
        );

    }
    finally{

        submitButton.disabled = false;

        submitButton.innerHTML =
            originalHtml;

    }

},

async edit(id)
{

    try{

        const response =
            await fetch(

                `${BRANCHES.edit}/${id}/edit`,

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

                'Unable to load branch.'

            );

        }

        const branch =
            data.branch;

        const form =
            document.getElementById(
                'editBranchForm'
            );

        form.dataset.branchId =
            branch.id;

        form.querySelector(
            '[name="edit_name"]'
        ).value =
            branch.name ?? '';

        form.querySelector(
            '[name="edit_branch_code"]'
        ).value =
            branch.branch_code ?? '';

        form.querySelector(
            '[name="edit_email"]'
        ).value =
            branch.email ?? '';

        form.querySelector(
            '[name="edit_phone"]'
        ).value =
            branch.phone ?? '';

        form.querySelector(
            '[name="edit_address"]'
        ).value =
            branch.address ?? '';

        form.querySelector(
            '[name="edit_status"]'
        ).value =
            branch.status ? '1' : '0';

        form.querySelector(
            '[name="edit_is_head_office"]'
        ).checked =
            Boolean(
                branch.is_head_office
            );

        this.clearErrors(form);

        this.editModal.show();

    }
    catch(error){

        showToast(
            error.message,
            'error'
        );

    }

},

async updateBranch(form)
{

    this.clearErrors(form);

    const branchId =
        form.dataset.branchId;

    if(!branchId){

        showToast(
            'Invalid branch selected.',
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

    try{

        const formData =
            new FormData(form);

        formData.append(
            '_method',
            'PUT'
        );

        const response =
            await fetch(

                `${BRANCHES.update}/${branchId}`,

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

            }else{

                showToast(
                    data.message ??
                    'Unable to update branch.',
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

        setTimeout(()=>{

            window.location.reload();

        },800);

    }
    catch(error){

        console.error(error);

        showToast(
            'An unexpected error occurred.',
            'error'
        );

    }
    finally{

        submitButton.disabled = false;

        submitButton.innerHTML =
            originalHtml;

    }

},

openDeleteBranchModal(branch)
{

    this.currentBranchId =
        branch.id;

    document.getElementById(
        'deleteBranchName'
    ).textContent =
        branch.name;

    this.deleteModal.show();

},

async delete()
{

    try{

        const response =
            await fetch(

                `${BRANCHES.delete}/${this.currentBranchId}`,

                {

                    method:'DELETE',

                    headers:{

                        'X-CSRF-TOKEN':
                        document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,

                        'Accept':
                        'application/json'

                    }

                }

            );

        const data =
            await response.json();

        if(!response.ok){

            showToast(

                data.message ??
                'Unable to delete branch.',

                'warning'

            );

            return;

        }

        this.deleteModal.hide();

        this.currentBranchId = null;

        showToast(
            data.message,
            'success'
        );

        setTimeout(()=>{

            window.location.reload();

        },800);

    }
    catch(error){

        showToast(
            error.message,
            'error'
        );

    }

},

openToggleStatusModal(branch)
{

    this.currentBranchId =
        branch.id;

    this.currentBranchStatus =
        Boolean(branch.status);

    document.getElementById(
        'toggleBranchStatusName'
    ).textContent =
        branch.name;

    const title =
        document.getElementById(
            'toggleBranchStatusTitle'
        );

    const heading =
        document.getElementById(
            'toggleBranchStatusHeading'
        );

    const message =
        document.getElementById(
            'toggleBranchStatusMessage'
        );

    const icon =
        document.getElementById(
            'toggleBranchStatusIcon'
        );

    const button =
        document.getElementById(
            'confirmToggleBranchStatus'
        );

    if(this.currentBranchStatus){

        title.innerHTML = `

            <i class="bi bi-pause-circle-fill text-warning me-2"></i>

            Disable Branch

        `;

        heading.textContent =
            'Disable this branch?';

        message.textContent =
            'Users assigned to this branch will no longer be able to operate from it.';

        icon.className =
            'bi bi-pause-circle-fill text-warning display-3';

        button.className =
            'btn btn-warning';

        button.innerHTML = `

            <i class="bi bi-pause-circle me-1"></i>

            Disable Branch

        `;

    }
    else{

        title.innerHTML = `

            <i class="bi bi-play-circle-fill text-success me-2"></i>

            Enable Branch

        `;

        heading.textContent =
            'Enable this branch?';

        message.textContent =
            'The branch will become available for use again.';

        icon.className =
            'bi bi-play-circle-fill text-success display-3';

        button.className =
            'btn btn-success';

        button.innerHTML = `

            <i class="bi bi-play-circle me-1"></i>

            Enable Branch

        `;

    }

    this.toggleStatusModal.show();

},

async toggleStatus()
{
    try{

        const response = await fetch(

            `${BRANCHES.toggleStatus}/${this.currentBranchId}/toggle-status`,

            {

                method:'PATCH',

                headers:{

                    'X-CSRF-TOKEN':
                    document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,

                    'Accept':'application/json'

                }

            }

        );

        const data =
            await response.json();

        if(!response.ok){

            showToast(

                data.message ??
                'Unable to update branch status.',

                'warning'

            );

            return;

        }

        this.toggleStatusModal.hide();

        showToast(

            data.message,

            'success'

        );

        setTimeout(()=>{

            window.location.reload();

        },800);

    }
    catch(error){

        showToast(

            error.message,

            'error'

        );

    }

},

clearErrors(form)
{

    form.querySelectorAll(
        '.is-invalid'
    ).forEach(field=>{

        field.classList.remove(
            'is-invalid'
        );

    });

    form.querySelectorAll(
        '.invalid-feedback'
    ).forEach(error=>{

        error.textContent='';

    });

},

showValidation(form,errors)
{

    Object.keys(errors).forEach(field=>{

        const input =
            form.querySelector(
                `[name="${field}"]`
            );

        if(input){

            input.classList.add(
                'is-invalid'
            );

        }

        const feedback =
            form.querySelector(
                `[data-error="${field}"]`
            );

        if(feedback){

            feedback.textContent =
                errors[field][0];

        }

    });

}

};



document.addEventListener(

    'DOMContentLoaded',

    ()=>{

        Branches.init();

    }

);

$(document).on('click','.view-branch',function(){

    let id = $(this).data('id');   


    $.get(
        `/branches/${id}/details`,
        function(response){


            let branch = response.branch;


            // Store selected branch for KPI previews
            window.currentBranchId = branch.id;

            document.getElementById(
                'panelEditBranch'
            ).onclick = function () {

                $('#branchInspector')
                    .removeClass('open');

                $('#branchInspectorOverlay')
                    .removeClass('show');

                openEditBranchModal(
                    window.currentBranchId
                );

            };

            document.getElementById(
                'panelDeleteBranch'
            ).onclick = function () {

                $('#branchInspector')
                    .removeClass('open');

                $('#branchInspectorOverlay')
                    .removeClass('show');

                openDeleteBranchModal({

                    id: branch.id,

                    name: branch.name

                });

                
            };

            const toggleButton =

                    document.getElementById(
                        'panelToggleBranchStatus'
                    );

                if(branch.status){

                    toggleButton.className =
                        'btn btn-outline-warning flex-fill';

                    toggleButton.innerHTML = `

                        <i class="bi bi-pause-circle"></i>

                        Disable

                    `;

                }
                else{

                    toggleButton.className =
                        'btn btn-outline-success flex-fill';

                    toggleButton.innerHTML = `

                        <i class="bi bi-play-circle"></i>

                        Enable

                    `;

                }

                toggleButton.onclick = function () {

                    $('#branchInspector').removeClass('open');
                    $('#branchInspectorOverlay').removeClass('show');

                    Branches.openToggleStatusModal({

                        id: branch.id,

                        name: branch.name,

                        status: branch.status

                    });

                };

            

            $('#inspectorBranchName')
                .text(branch.name);


            $('#inspectorBranchCode')
                .text(branch.branch_code);



            $('#inspectorPhone')
                .text(branch.phone ?? 'Not available');


            $('#inspectorEmail')
                .text(branch.email ?? 'Not available');


            $('#inspectorAddress')
                .text(branch.address ?? 'Not available');



            $('#inspectorUsers')
                .text(branch.users_count ?? 0);



            $('#inspectorTerminals')
                .text(branch.terminals_count ?? 0);



            $('#inspectorOrders')
                .text(branch.orders_count ?? 0);
            
            $('#inspectorCustomers')
            .text(response.customer_count ?? 0);



            $('#inspectorBranchStatus')
                .text(
                    branch.status 
                    ? 'Active'
                    : 'Inactive'
                );



            $('#branchInspector')
                .addClass('open');


            $('#branchInspectorOverlay')
                .addClass('show');


        }
    );



});



$('#closeBranchInspector, #branchInspectorOverlay')
.on('click',function(){


    $('#branchInspector')
        .removeClass('open');


    $('#branchInspectorOverlay')
        .removeClass('show');


    // optional clear
    window.currentBranchId = null;

   

});

$(document).on('click','.branch-preview-btn',function(){


    let type = $(this).data('type');

    let branchId = window.currentBranchId;

    


    if(!branchId){

        return;

    }



    $.get(
        `/branches/${branchId}/${type}`,
        function(response){


            let title =
                type.charAt(0).toUpperCase()
                + type.slice(1);



            $('#previewTitle')
                .text(title);



            let html = '';



            if(response.data.length === 0){


                html = `

                <div class="text-center py-5 text-muted">

                    <i class="bi bi-info-circle fs-2"></i>

                    <p class="mt-2">
                        No ${type} found
                    </p>

                </div>

                `;


            }
            else {



                if(type === 'users'){


                    html = `

                    <table class="preview-table">

                    `;


                    response.data.forEach(user=>{


                        html += `

                        <tr>

                            <td>

                                <div class="preview-title">

                                    ${user.first_name} ${user.last_name}

                                </div>


                                <div class="preview-subtitle">

                                    ${user.email ?? ''}

                                </div>

                            </td>


                            <td class="text-end">

                                <i class="bi bi-person"></i>

                            </td>


                        </tr>

                        `;


                    });


                    html += `</table>`;


                }





                if(type === 'terminals'){


                    html = `

                    <table class="preview-table">

                    `;


                    response.data.forEach(terminal=>{


                        html += `

                        <tr>

                            <td>

                                <div class="preview-title">

                                    ${terminal.terminal_name}

                                </div>


                                <div class="preview-subtitle">

                                    Code:
                                    ${terminal.terminal_code}

                                </div>


                            </td>


                            <td class="text-end">

                                ${
                                    terminal.status 
                                    ? 'Active'
                                    : 'Inactive'
                                }

                            </td>


                        </tr>

                        `;


                    });


                    html += `</table>`;

                }


                if(type === 'customers'){


                    html = `

                    <table class="preview-table">

                    `;


                    response.data.forEach(customer=>{


                        html += `

                        <tr>

                            <td>

                                <div class="preview-title">

                                    ${customer.name}

                                </div>


                                <div class="preview-subtitle">

                                    ${customer.email ?? customer.phone ?? ''}

                                </div>


                            </td>

                        </tr>

                        `;


                    });


                    html += `</table>`;


                }



                if(type === 'orders'){


                    html = `

                    <table class="preview-table">

                    `;


                    response.data.forEach(order=>{


                        html += `

                        <tr>


                            <td>


                                <div class="preview-title">

                                    ${order.order_no}

                                </div>


                                <div class="preview-subtitle">

                                    ${order.created_at}

                                </div>


                            </td>



                            <td class="text-end">

                                ₦${Number(order.total)
                                .toLocaleString()}

                            </td>


                        </tr>

                        `;


                    });


                    html += `</table>`;

                }



            }



            $('#previewContent')
                .html(html);



            $('#branchPreviewModal')
                .modal('show');


        }
    );

   


});

window.openEditBranchModal =
function(id)
{

    Branches.edit(id);

};

window.openDeleteBranchModal =
function(branch)
{

    Branches.openDeleteBranchModal(
        branch
    );

};

window.openToggleBranchStatusModal =
function(branch)
{

    Branches.openToggleStatusModal(
        branch
    );

};
