/**
 * ==========================================================
 * EMNEX USERS MANAGEMENT
 * ==========================================================
 */


const Users = {

    createModal: null,

    editModal: null,

    init()
    {

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

        this.bindEvents();

        this.bindEditForm();

    },




    /**
     * ======================================================
     * EVENTS
     * ======================================================
     */


    bindEvents(){


        const createForm =
            document.getElementById(
                'createUserForm'
            );



        if(createForm){


            createForm.addEventListener(
                'submit',
                (event)=>{


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


if(editForm){


    editForm.addEventListener(
        'submit',
        (event)=>{


            event.preventDefault();


            this.updateUser(
                editForm
            );


        }

    );


}

        const createButton = document.getElementById(
            'openCreateUserModal'
        );


        if(createButton){

            createButton.addEventListener(
                'click',
                ()=>{


                    console.log('Open create user clicked');


                    this.resetCreateForm();


                    const modalElement =
                        document.getElementById(
                            'createUserModal'
                        );


                    if(modalElement){


                        const modal =
                            bootstrap.Modal.getOrCreateInstance(
                                modalElement
                            );


                        modal.show();


                    }else{


                        console.error(
                            'createUserModal not found'
                        );


                    }


                }

            );

        }


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




    delete(id){


        console.log(
            'Delete user:',
            id
        );


    },




    resetPassword(id){


        console.log(
            'Reset password:',
            id
        );


    },




    toggleStatus(id){


        console.log(
            'Toggle status:',
            id
        );


    }



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

