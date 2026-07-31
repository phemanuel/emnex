const Branches = {

    createModal: null,

    editModal: null,

    deleteModal: null,   

    currentBranchId: null,

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
            '[name="name"]'
        ).value =
            branch.name ?? '';

        form.querySelector(
            '[name="branch_code"]'
        ).value =
            branch.branch_code ?? '';

        form.querySelector(
            '[name="email"]'
        ).value =
            branch.email ?? '';

        form.querySelector(
            '[name="phone"]'
        ).value =
            branch.phone ?? '';

        form.querySelector(
            '[name="address"]'
        ).value =
            branch.address ?? '';

        form.querySelector(
            '[name="status"]'
        ).value =
            branch.status;

        form.querySelector(
            '[name="is_head_office"]'
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
            branch.status;

        form.querySelector(
            '[name="edit_is_head_office"]'
        ).checked =
            Boolean(
                branch.is_head_office
            );

        this.clearErrors(form);

    }
    catch(error){

        showToast(
            error.message,
            'error'
        );

    }

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

    this.currentBranchId = branch.id;


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
