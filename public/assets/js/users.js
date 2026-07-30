/**
 * ==========================================================
 * EMNEX USERS MANAGEMENT
 * ==========================================================
 */


const Users = {


    createModal:null,



    init(){


        const modalElement = document.getElementById(
            'createUserModal'
        );


        if(modalElement){

            this.createModal = new bootstrap.Modal(
                modalElement
            );

        }


        this.bindEvents();


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




    async edit(id)
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



    if(!form){

        return;

    }



    form.dataset.userId = user.id;



    form.querySelector(
        '[name="branch_id"]'
    ).value =
        user.branch_id ?? '';



    form.querySelector(
        '[name="role_id"]'
    ).value =
        user.role_id ?? '';



    form.querySelector(
        '[name="employee_no"]'
    ).value =
        user.employee_no ?? '';



    form.querySelector(
        '[name="first_name"]'
    ).value =
        user.first_name ?? '';



    form.querySelector(
        '[name="last_name"]'
    ).value =
        user.last_name ?? '';



    form.querySelector(
        '[name="other_name"]'
    ).value =
        user.other_name ?? '';



    form.querySelector(
        '[name="username"]'
    ).value =
        user.username ?? '';



    form.querySelector(
        '[name="email"]'
    ).value =
        user.email ?? '';



    form.querySelector(
        '[name="phone"]'
    ).value =
        user.phone ?? '';



    form.querySelector(
        '[name="gender"]'
    ).value =
        user.gender ?? '';



    form.querySelector(
        '[name="date_of_birth"]'
    ).value =
        user.date_of_birth ?? '';



    form.querySelector(
        '[name="employment_date"]'
    ).value =
        user.employment_date ?? '';



    form.querySelector(
        '[name="address"]'
    ).value =
        user.address ?? '';



    form.querySelector(
        '[name="notes"]'
    ).value =
        user.notes ?? '';



    form.querySelector(
        '[name="status"]'
    ).value =
        user.status;


},

async updateUser(form)
{


    const userId =
        form.dataset.userId;



    const submitButton =
        form.querySelector(
            'button[type="submit"]'
        );



    this.setLoading(
        submitButton,
        true
    );



    this.clearErrors();



    const formData =
        new FormData(form);



    formData.append(
        '_method',
        'PUT'
    );



    try {


        const response = await fetch(

            USERS.update + userId,

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
                    'Unable to update user.',

                    'error'

                );


            }


            return;


        }




        this.setLoading(
            submitButton,
            false
        );



        showToast(

            data.message,

            'success'

        );



        const modal =
            bootstrap.Modal.getInstance(

                document.getElementById(
                    'editUserModal'
                )

            );



        if(modal){

            modal.hide();

        }



        setTimeout(()=>{


            window.location.reload();


        },1000);



    }
    catch(error){



        console.error(error);



        this.setLoading(
            submitButton,
            false
        );



        showToast(

            'Something went wrong while updating user.',

            'error'

        );


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

    ()=>{


        Users.init();


    }

);


function openEditUserModal(id)
{

    Users.edit(id);

}