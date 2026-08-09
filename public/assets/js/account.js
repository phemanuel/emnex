const Account = {

    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    elements: {},


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

        this.elements = {

            profileModal:
                document.getElementById(
                    'profileModal'
                ),

            changePasswordModal:
                document.getElementById(
                    'changePasswordModal'
                ),

            openProfileModalBtn:
                document.getElementById(
                    'openProfileModalBtn'
                ),

            openPasswordModalBtn:
                document.getElementById(
                    'openPasswordModalBtn'
                ),

            profileForm:
                document.getElementById(
                    'profileForm'
                ),

            passwordForm:
                document.getElementById(
                    'changePasswordForm'
                ),

            saveProfileBtn:
                document.getElementById(
                    'saveProfileBtn'
                ),

            changePasswordBtn:
                document.getElementById(
                    'changePasswordBtn'
                ),

        };

    },


    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

    bindEvents() {

        const {

            openProfileModalBtn,
            openPasswordModalBtn,
            profileForm,
            passwordForm

        } = this.elements;



        /*
        |--------------------------------------------------------------------------
        | Profile
        |--------------------------------------------------------------------------
        */

        openProfileModalBtn?.addEventListener(
            'click',
            () => {

                this.closeDropdown();

                this.openModal(
                    this.elements.profileModal
                );

            }
        );



        /*
        |--------------------------------------------------------------------------
        | Password
        |--------------------------------------------------------------------------
        */

        openPasswordModalBtn?.addEventListener(
            'click',
            () => {

                this.closeDropdown();

                this.openModal(
                    this.elements.changePasswordModal
                );

            }
        );



        /*
        |--------------------------------------------------------------------------
        | Profile Submit
        |--------------------------------------------------------------------------
        */

        profileForm?.addEventListener(
            'submit',
            (event) => {

                event.preventDefault();

                this.updateProfile();

            }
        );



        /*
        |--------------------------------------------------------------------------
        | Password Submit
        |--------------------------------------------------------------------------
        */

        passwordForm?.addEventListener(
            'submit',
            (event) => {

                event.preventDefault();

                this.updatePassword();

            }
        );



        /*
        |--------------------------------------------------------------------------
        | Password Visibility
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '.password-toggle'
            )
            .forEach(button => {

                button.addEventListener(
                    'click',
                    () => {

                        const target =
                            document.getElementById(
                                button.dataset.target
                            );


                        if (!target) {
                            return;
                        }


                        const icon =
                            button.querySelector(
                                'i'
                            );


                        if (
                            target.type ===
                            'password'
                        ) {

                            target.type =
                                'text';

                            icon.classList
                                .remove(
                                    'bi-eye'
                                );

                            icon.classList
                                .add(
                                    'bi-eye-slash'
                                );

                        } else {

                            target.type =
                                'password';

                            icon.classList
                                .remove(
                                    'bi-eye-slash'
                                );

                            icon.classList
                                .add(
                                    'bi-eye'
                                );

                        }

                    }
                );

            });

    },


    /*
    |--------------------------------------------------------------------------
    | Open Modal
    |--------------------------------------------------------------------------
    */

    openModal(modalElement) {

        if (!modalElement) {
            return;
        }


        const modal =
            bootstrap.Modal.getOrCreateInstance(
                modalElement
            );


        modal.show();

    },


    /*
    |--------------------------------------------------------------------------
    | Close Dropdown
    |--------------------------------------------------------------------------
    */

    closeDropdown() {

        const dropdown =
            document.querySelector(
                '.user-account-dropdown .dropdown-toggle'
            );


        if (!dropdown) {
            return;
        }


        const instance =
            bootstrap.Dropdown.getInstance(
                dropdown
            );


        instance?.hide();

    },


    /*
    |--------------------------------------------------------------------------
    | Update Profile
    |--------------------------------------------------------------------------
    */

    /*
|--------------------------------------------------------------------------
| Update Profile
|--------------------------------------------------------------------------
*/

async updateProfile()
{

    const form =
        this.elements.profileForm;


    const button =
        this.elements.saveProfileBtn;



    if (!form || !button)
    {
        console.error(
            'Profile form or save button not found.'
        );

        return;
    }



    /*
    |--------------------------------------------------------------------------
    | Build Form Data
    |--------------------------------------------------------------------------
    */

    const formData =
        new FormData(form);



    /*
    |--------------------------------------------------------------------------
    | Debug
    |--------------------------------------------------------------------------
    */

    console.log(
        'Profile Form Data:',
        Object.fromEntries(
            formData.entries()
        )
    );



    /*
    |--------------------------------------------------------------------------
    | Method Spoofing
    |--------------------------------------------------------------------------
    */

    formData.append(
        '_method',
        'PUT'
    );



    const originalText =
        button.innerHTML;



    button.disabled = true;



    button.innerHTML = `

        <span
            class="spinner-border spinner-border-sm me-1"
        ></span>

        Saving...

    `;



    try
    {

        const response =
            await fetch(
                '/account/profile',
                {

                    method: 'POST',

                    headers: {

                        'X-CSRF-TOKEN':
                            document.querySelector(
                                'meta[name="csrf-token"]'
                            )?.content,

                        'Accept':
                            'application/json',

                    },

                    body:
                        formData,

                }
            );



        const result =
            await response.json();



        console.log(
            'Profile Update Response:',
            result
        );



        if (!response.ok)
        {

            this.handleValidationError(
                result
            );

            return;

        }



        showToast(
            result.message ??
            'Profile updated successfully.',
            'success'
        );



        const modal =
            bootstrap.Modal.getInstance(
                this.elements.profileModal
            );


        modal?.hide();



        /*
        |--------------------------------------------------------------------------
        | Refresh Header
        |--------------------------------------------------------------------------
        */

        setTimeout(
            () =>
            {

                window.location.reload();

            },
            700
        );

    }
    catch(error)
    {

        console.error(
            'Profile update error:',
            error
        );


        showToast(
            'Unable to update profile.',
            'error'
        );

    }
    finally
    {

        button.disabled = false;

        button.innerHTML =
            originalText;

    }

},


    /*
    |--------------------------------------------------------------------------
    | Update Password
    |--------------------------------------------------------------------------
    */

    /*
|--------------------------------------------------------------------------
| Update Password
|--------------------------------------------------------------------------
*/

async updatePassword()
{

    const form =
        this.elements.passwordForm;


    const button =
        this.elements.changePasswordBtn;



    if (!form || !button)
    {
        console.error(
            'Password form or button not found.'
        );

        return;
    }



    /*
    |--------------------------------------------------------------------------
    | Build Form Data
    |--------------------------------------------------------------------------
    */

    const formData =
        new FormData(form);



    /*
    |--------------------------------------------------------------------------
    | Debug
    |--------------------------------------------------------------------------
    */

    console.log(
        'Password Form Data:',
        Object.fromEntries(
            formData.entries()
        )
    );



    /*
    |--------------------------------------------------------------------------
    | Laravel Method Spoofing
    |--------------------------------------------------------------------------
    */

    formData.append(
        '_method',
        'PUT'
    );



    const originalText =
        button.innerHTML;


    button.disabled = true;


    button.innerHTML = `

        <span
            class="spinner-border spinner-border-sm me-1"
        ></span>

        Updating...

    `;



    try
    {

        const response =
            await fetch(
                '/account/password',
                {

                    method: 'POST',

                    headers: {

                        'X-CSRF-TOKEN':
                            document.querySelector(
                                'meta[name="csrf-token"]'
                            )?.content,

                        'Accept':
                            'application/json',

                    },

                    body:
                        formData,

                }
            );



        const result =
            await response.json();



        console.log(
            'Password Update Response:',
            result
        );



        if (!response.ok)
        {

            this.handleValidationError(
                result
            );

            return;

        }



        showToast(
            result.message ??
            'Password changed successfully.',
            'success'
        );



        form.reset();



        const modal =
            bootstrap.Modal.getInstance(
                this.elements.changePasswordModal
            );


        modal?.hide();

    }
    catch(error)
    {

        console.error(
            'Password update error:',
            error
        );


        showToast(
            'Unable to change password.',
            'error'
        );

    }
    finally
    {

        button.disabled = false;

        button.innerHTML =
            originalText;

    }

},

    /*
    |--------------------------------------------------------------------------
    | Validation Errors
    |--------------------------------------------------------------------------
    */

    handleValidationError(result) {

        if (
            result.errors
        ) {

            const firstError =
                Object.values(
                    result.errors
                )[0]?.[0];


            showToast(
                firstError ??
                'Please check the form.',
                'error'
            );


            return;

        }


        showToast(
            result.message ??
            'Please check the form.',
            'error'
        );

    }

};



document.addEventListener(
    'DOMContentLoaded',
    () => {

        Account.init();

    }
);