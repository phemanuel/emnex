const PaymentMethods = {


    createModal: null,

    editModal: null,


    createForm: null,

    editForm: null,


    currentId: null,

    currentStatus: true,


    /*
    |--------------------------------------------------------------------------
    | Init
    |--------------------------------------------------------------------------
    */

    init() {


        this.cacheElements();

        this.bindEvents();


    },

    /*
    |--------------------------------------------------------------------------
    | Cache Elements
    |--------------------------------------------------------------------------
    */

    cacheElements() {


        this.createModal = new bootstrap.Modal(

            document.getElementById(
                'createPaymentMethodModal'
            )

        );


        this.editModal = new bootstrap.Modal(

            document.getElementById(
                'editPaymentMethodModal'
            )

        );



        this.createForm = document.getElementById(

            'createPaymentMethodForm'

        );



        this.editForm = document.getElementById(

            'editPaymentMethodForm'

        );
        /*
        |--------------------------------------------------------------------------
        | Create Preview Elements
        |--------------------------------------------------------------------------
        */


        this.createName = document.getElementById(
            'create_name'
        );


        this.createIcon = document.getElementById(
            'create_icon'
        );


        this.createColor = document.getElementById(
            'create_color'
        );


        this.createPreviewIcon = document.getElementById(
            'create_preview_icon'
        );


        this.createPreviewName = document.getElementById(
            'create_preview_name'
        );

        /*
        |--------------------------------------------------------------------------
        | Edit Preview Elements
        |--------------------------------------------------------------------------
        */


        this.editName = document.getElementById(
            'edit_name'
        );


        this.editIcon = document.getElementById(
            'edit_icon'
        );


        this.editColor = document.getElementById(
            'edit_color'
        );


        this.editPreviewIcon = document.getElementById(
            'edit_preview_icon'
        );


        this.editPreviewName = document.getElementById(
            'edit_preview_name'
        );

        this.editDisplayOrder =
            document.getElementById(
                'edit_display_order'
            );


        this.editRequiresReference =
            document.getElementById(
                'edit_requires_reference'
            );


        this.editIsCash =
            document.getElementById(
                'edit_is_cash'
            );


        this.editAllowChange =
            document.getElementById(
                'edit_allow_change'
            );

        this.deleteModal = new bootstrap.Modal(
            document.getElementById(
                'deletePaymentMethodModal'
            )
        );


        this.confirmDeleteButton =
            document.getElementById(
                'confirmDeletePaymentMethod'
        );

        this.toggleModal = new bootstrap.Modal(

            document.getElementById(
                'togglePaymentMethodModal'
            )

        );

        this.toggleTitle =
            document.getElementById(
                'toggleModalTitle'
            );

        this.toggleIcon =
            document.getElementById(
                'toggleModalIcon'
            );

        this.toggleMessage =
            document.getElementById(
                'toggleModalMessage'
            );

        this.confirmToggleButton =
            document.getElementById(
                'confirmToggleButton'
            );


    },


    /*
    |--------------------------------------------------------------------------
    | Bind Events
    |--------------------------------------------------------------------------
    */

    bindEvents() {



        this.createForm.addEventListener(

            'submit',

            e => {

                e.preventDefault();

                this.store();

            }

        );





        this.editForm.addEventListener(

            'submit',

            e => {

                e.preventDefault();

                this.update();

            }

        );

        this.createName.addEventListener(
            'input',
            () => this.updateCreatePreview()
        );


        this.createIcon.addEventListener(
            'change',
            () => this.updateCreatePreview()
        );


        this.createColor.addEventListener(
            'change',
            () => this.updateCreatePreview()
        );

        this.editName.addEventListener(
            'input',
            () => this.updateEditPreview()
        );


        this.editIcon.addEventListener(
            'change',
            () => this.updateEditPreview()
        );


        this.editColor.addEventListener(
            'change',
            () => this.updateEditPreview()
        );

        this.confirmDeleteButton.addEventListener(

            'click',

            () => this.destroy()

        );

        this.confirmToggleButton.addEventListener(

            'click',

            () => this.toggleStatus()

        );



    },

    updateCreatePreview(){


        const name =
            this.createName.value || 'Payment Method';


        const icon =
            this.createIcon.value || 'bi-cash';


        const color =
            this.createColor.value || 'primary';



        this.createPreviewName.innerHTML = name;



        this.createPreviewIcon.className =
            `payment-preview-icon bg-${color}`;



        this.createPreviewIcon.innerHTML =
            `<i class="bi ${icon}"></i>`;

    },

    updateEditPreview(){


        const name =
            this.editName.value || 'Payment Method';


        const icon =
            this.editIcon.value || 'bi-cash';


        const color =
            this.editColor.value || 'primary';



        this.editPreviewName.innerHTML = name;



        this.editPreviewIcon.className =
            `payment-preview-icon bg-${color}`;



        this.editPreviewIcon.innerHTML =
            `<i class="bi ${icon}"></i>`;

    },





    /*
    |--------------------------------------------------------------------------
    | Open Create Modal
    |--------------------------------------------------------------------------
    */

    openCreateModal() {


        this.createForm.reset();

        this.updateCreatePreview();


        this.clearErrors();



        this.createModal.show();


    },







    /*
    |--------------------------------------------------------------------------
    | Open Edit Modal
    |--------------------------------------------------------------------------
    */

  async openEditModal(id) {

    this.clearErrors();

    this.currentId = id;

    try {

        const response = await fetch(

            window.paymentMethodRoutes.edit.replace(
                ':id',
                id
            ),

            {

                headers: {

                    'Accept': 'application/json'

                }

            }

        );



        const data = await response.json();



        if (!response.ok || !data.success) {

            showToast(

                data.message ?? 'Unable to load payment method.',

                data.type ?? 'warning'

            );

            return;

        }



        const method = data.data;



        /*
        |--------------------------------------------------------------------------
        | Populate Form
        |--------------------------------------------------------------------------
        */

        document.getElementById('edit_name').value =
            method.name;

        document.getElementById('edit_code').value =
            method.code;

        document.getElementById('edit_icon').value =
            method.icon;

        document.getElementById('edit_color').value =
            method.color;

        document.getElementById('edit_display_order').value =
            method.display_order;

        document.getElementById('edit_requires_reference').checked =
            method.requires_reference;

        document.getElementById('edit_is_cash').checked =
            method.is_cash;

        document.getElementById('edit_allow_change').checked =
            method.allow_change;



        /*
        |--------------------------------------------------------------------------
        | Update Preview
        |--------------------------------------------------------------------------
        */

        this.updateEditPreview();



        /*
        |--------------------------------------------------------------------------
        | Show Modal
        |--------------------------------------------------------------------------
        */

        this.editModal.show();

    }

    catch (error) {

        console.error(error);

        showToast(

            'Unable to load payment method.',

            'error'

        );

    }

},
    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    async store() {



        this.clearErrors();



        try {



            const response = await fetch(

                window.paymentMethodRoutes.store,

                {


                    method:'POST',


                    headers:{


                        'Accept':'application/json',


                        'X-CSRF-TOKEN':

                        document.querySelector(

                            'meta[name="csrf-token"]'

                        ).content


                    },


                    body:new FormData(

                        this.createForm

                    )


                }

            );



            const data = await response.json();



            if(!response.ok){


                if(data.errors){


                    this.showValidation(

                        data.errors

                    );


                    return;

                }


                showToast(

                    data.message,

                    data.type

                );


                return;

            }




            this.createModal.hide();



            showToast(

                data.message,

                'success'

            );



            location.reload();



        }
        catch(error){


            showToast(

                'An unexpected error occurred.',

                'error'

            );

        }


    },
    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    async update(){


        this.clearErrors();



        const formData = new FormData(

            this.editForm

        );



        formData.append(

            '_method',

            'PUT'

        );



        try{


            const response = await fetch(

                window.paymentMethodRoutes.update.replace(

                    ':id',

                    this.currentId

                ),

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



            const data = await response.json();



            if(!response.ok){


                if(data.errors){


                    this.showValidation(

                        data.errors

                    );


                    return;

                }


                showToast(

                    data.message,

                    data.type

                );


                return;


            }



            this.editModal.hide();



            showToast(

                data.message,

                'success'

            );



            location.reload();



        }
        catch(error){


            showToast(

                'An unexpected error occurred.',

                'error'

            );


        }


    },

    openToggleModal(id, status) {

        this.currentId = id;

        this.currentStatus = status;



        if (status) {

            this.toggleTitle.innerHTML =

                '<i class="bi bi-toggle-off me-2"></i> Disable Payment Method';


            this.toggleIcon.className =
                'bi bi-toggle-off text-warning display-2';


            this.toggleMessage.innerHTML =

                'Are you sure you want to disable this payment method?<br><small class="text-muted">It will no longer be available during payment.</small>';


            this.confirmToggleButton.className =
                'btn btn-warning';


            this.confirmToggleButton.innerHTML =

                '<i class="bi bi-toggle-off me-2"></i>Disable';

        }

        else {

            this.toggleTitle.innerHTML =

                '<i class="bi bi-toggle-on me-2"></i> Enable Payment Method';


            this.toggleIcon.className =
                'bi bi-toggle-on text-success display-2';


            this.toggleMessage.innerHTML =

                'Enable this payment method so it can be used for new transactions?';


            this.confirmToggleButton.className =
                'btn btn-success';


            this.confirmToggleButton.innerHTML =

                '<i class="bi bi-toggle-on me-2"></i>Enable';

        }



        this.toggleModal.show();

    },


    /*
    |--------------------------------------------------------------------------
    | Toggle Status
    |--------------------------------------------------------------------------
    */

    async toggleStatus() {

        try {

            const response = await fetch(

                window.paymentMethodRoutes.toggleStatus.replace(

                    ':id',

                    this.currentId

                ),

                {

                    method: 'PATCH',

                    headers: {

                        'Accept': 'application/json',

                        'X-CSRF-TOKEN':

                            document.querySelector(

                                'meta[name="csrf-token"]'

                            ).content

                    }

                }

            );



            const data = await response.json();



            this.toggleModal.hide();



            showToast(

                data.message,

                data.type

            );



            if (data.success) {

                setTimeout(() => {

                    location.reload();

                }, 1000);

            }

        }

        catch (error) {

            console.error(error);



            showToast(

                'Unable to update payment method.',

                'error'

            );

        }

    },

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    delete(id) {

        this.currentId = id;

        this.deleteModal.show();

    },

    async destroy() {

    try {

        const response = await fetch(

            window.paymentMethodRoutes.destroy.replace(
                ':id',
                this.currentId
            ),

            {

                method: 'DELETE',

                headers: {

                    'Accept': 'application/json',

                    'X-CSRF-TOKEN':

                        document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content

                }

            }

        );



        const data = await response.json();



        this.deleteModal.hide();



        showToast(

            data.message,

            data.type

        );



        if (data.success) {

            setTimeout(() => {

                location.reload();

            }, 1000);

        }

    }

    catch (error) {

        console.error(error);

        showToast(
            'Unable to delete payment method.',
            'error'
        );

    }

},

    /*
    |--------------------------------------------------------------------------
    | Validation Helpers
    |--------------------------------------------------------------------------
    */

    clearErrors(){


        document.querySelectorAll(

            '.is-invalid'

        ).forEach(el=>{


            el.classList.remove(

                'is-invalid'

            );


        });


    },




    showValidation(errors){


        Object.keys(errors).forEach(field=>{


            const input = document.querySelector(

                `[name="${field}"]`

            );



            if(input){


                input.classList.add(

                    'is-invalid'

                );


                input.nextElementSibling.innerHTML =

                    errors[field][0];


            }


        });


    }



};




document.addEventListener(

    'DOMContentLoaded',

    ()=>{

        PaymentMethods.init();

    }    

);

    

   