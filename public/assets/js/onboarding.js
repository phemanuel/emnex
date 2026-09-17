/**
 * ============================================================================
 * EMNEX — Company Onboarding
 * ============================================================================
 *
 * Handles:
 * - Three-step registration flow
 * - Step navigation
 * - Client-side validation
 * - Review screen population
 * - Password visibility
 * - Server validation errors
 * - Submit/loading state
 * - Successful onboarding state
 *
 * ============================================================================
 */

window.Onboarding = {

    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    state: {
        currentStep: 1,
        totalSteps: 3,
        submitting: false,
    },


    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    elements: {},


    /*
    |--------------------------------------------------------------------------
    | Initialization
    |--------------------------------------------------------------------------
    */

    init() {

        this.cacheElements();
        this.bindEvents();
        this.initializeContext();

    },


    /*
    |--------------------------------------------------------------------------
    | Cache Elements
    |--------------------------------------------------------------------------
    */

    cacheElements() {

        this.elements = {

            app: document.getElementById('onboardingApp'),

            form: document.getElementById('onboardingForm'),

            alert: document.getElementById('onboardingAlert'),
            alertMessage: document.getElementById('onboardingAlertMessage'),
            alertClose: document.getElementById('onboardingAlertClose'),

            progress: document.getElementById('onboardingProgress'),

            steps: {
                1: document.getElementById('onboardingStep1'),
                2: document.getElementById('onboardingStep2'),
                3: document.getElementById('onboardingStep3'),
            },

            nextStep1: document.getElementById('onboardingNextStep'),
            previousStep2: document.getElementById('onboardingPreviousStep'),
            nextStep2: document.getElementById('onboardingNextStep2'),
            previousStep3: document.getElementById('onboardingPreviousStep2'),

            submitButton: document.getElementById('onboardingSubmit'),
            submitLabel: document.querySelector('.onboarding-submit-label'),
            submitLoading: document.querySelector('.onboarding-submit-loading'),
            submitIcon: document.querySelector('.onboarding-submit-icon'),

            success: document.getElementById('onboardingSuccess'),

            passwordToggles: document.querySelectorAll(
                '[data-password-target]'
            ),

            reviewEditButtons: document.querySelectorAll(
                '[data-edit-step]'
            ),

            stepIndicators: document.querySelectorAll(
                '[data-step-indicator]'
            ),

            errorFields: document.querySelectorAll(
                '[data-error-for]'
            ),

            companyName: document.getElementById('company_name'),
            businessType: document.getElementById('businessType'),
            companyEmail: document.getElementById('company_email'),
            companyPhone: document.getElementById('company_phone'),
            currency: document.getElementById('currency'),
            timezone: document.getElementById('timezone'),
            companyAddress: document.getElementById('company_address'),

            ownerFirstName: document.getElementById('owner_first_name'),
            ownerLastName: document.getElementById('owner_last_name'),
            ownerUsername: document.getElementById('owner_username'),
            ownerEmail: document.getElementById('owner_email'),
            ownerPhone: document.getElementById('owner_phone'),
            ownerPassword: document.getElementById('owner_password'),
            ownerPasswordConfirmation: document.getElementById(
                'owner_password_confirmation'
            ),

            acceptTerms: document.getElementById('accept_terms'),

            reviewCompanyName: document.getElementById(
                'reviewCompanyName'
            ),

            reviewBusinessType: document.getElementById(
                'reviewBusinessType'
            ),

            reviewCompanyEmail: document.getElementById(
                'reviewCompanyEmail'
            ),

            reviewCompanyPhone: document.getElementById(
                'reviewCompanyPhone'
            ),

            reviewCurrency: document.getElementById(
                'reviewCurrency'
            ),

            reviewTimezone: document.getElementById(
                'reviewTimezone'
            ),

            reviewCompanyAddress: document.getElementById(
                'reviewCompanyAddress'
            ),

            reviewOwnerName: document.getElementById(
                'reviewOwnerName'
            ),

            reviewOwnerUsername: document.getElementById(
                'reviewOwnerUsername'
            ),

            reviewOwnerEmail: document.getElementById(
                'reviewOwnerEmail'
            ),

            reviewOwnerPhone: document.getElementById(
                'reviewOwnerPhone'
            ),

        };

    },


    /*
    |--------------------------------------------------------------------------
    | Bind Events
    |--------------------------------------------------------------------------
    */

    bindEvents() {

        const {
            form,
            nextStep1,
            previousStep2,
            nextStep2,
            previousStep3,
            alertClose,
            passwordToggles,
            reviewEditButtons,
        } = this.elements;


        /*
        |--------------------------------------------------------------------------
        | Step 1
        |--------------------------------------------------------------------------
        */

        nextStep1?.addEventListener('click', () => {

            if (!this.validateStep(1)) {
                return;
            }

            this.goToStep(2);

        });


        /*
        |--------------------------------------------------------------------------
        | Step 2 Back
        |--------------------------------------------------------------------------
        */

        previousStep2?.addEventListener('click', () => {

            this.goToStep(1);

        });


        /*
        |--------------------------------------------------------------------------
        | Step 2 Continue
        |--------------------------------------------------------------------------
        */

        nextStep2?.addEventListener('click', () => {

            if (!this.validateStep(2)) {
                return;
            }

            this.populateReview();
            this.goToStep(3);

        });


        /*
        |--------------------------------------------------------------------------
        | Step 3 Back
        |--------------------------------------------------------------------------
        */

        previousStep3?.addEventListener('click', () => {

            this.goToStep(2);

        });


        /*
        |--------------------------------------------------------------------------
        | Form Submission
        |--------------------------------------------------------------------------
        */

        form?.addEventListener('submit', (event) => {

            event.preventDefault();

            this.handleSubmit();

        });


        /*
        |--------------------------------------------------------------------------
        | Close Alert
        |--------------------------------------------------------------------------
        */

        alertClose?.addEventListener('click', () => {

            this.hideAlert();

        });


        /*
        |--------------------------------------------------------------------------
        | Password Toggles
        |--------------------------------------------------------------------------
        */

        passwordToggles.forEach((button) => {

            button.addEventListener('click', () => {

                this.togglePassword(button);

            });

        });


        /*
        |--------------------------------------------------------------------------
        | Review Edit Buttons
        |--------------------------------------------------------------------------
        */

        reviewEditButtons.forEach((button) => {

            button.addEventListener('click', () => {

                const step = Number(
                    button.dataset.editStep
                );

                if (!step) {
                    return;
                }

                this.goToStep(step);

            });

        });


        /*
        |--------------------------------------------------------------------------
        | Live Field Validation Cleanup
        |--------------------------------------------------------------------------
        */

        this.bindFieldValidation();


        /*
        |--------------------------------------------------------------------------
        | Terms Checkbox
        |--------------------------------------------------------------------------
        */

        this.elements.acceptTerms?.addEventListener(
            'change',
            () => {

                this.clearFieldError('accept_terms');

            }
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Initialize Context
    |--------------------------------------------------------------------------
    */

    initializeContext() {

        this.goToStep(1);

    },


    /*
    |--------------------------------------------------------------------------
    | Go To Step
    |--------------------------------------------------------------------------
    */

    goToStep(step) {

        step = Number(step);

        if (
            !step ||
            step < 1 ||
            step > this.state.totalSteps
        ) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Hide All Steps
        |--------------------------------------------------------------------------
        */

        Object.values(this.elements.steps).forEach((element) => {

            if (!element) {
                return;
            }

            element.classList.remove('is-active');
            element.hidden = true;

        });


        /*
        |--------------------------------------------------------------------------
        | Show Selected Step
        |--------------------------------------------------------------------------
        */

        const selectedStep = this.elements.steps[step];

        if (selectedStep) {

            selectedStep.hidden = false;
            selectedStep.classList.add('is-active');

        }


        this.state.currentStep = step;

        this.updateProgress(step);
        this.hideAlert();

        window.scrollTo({
            top: 0,
            behavior: 'smooth',
        });

    },


    /*
    |--------------------------------------------------------------------------
    | Update Progress
    |--------------------------------------------------------------------------
    */

    updateProgress(step) {

        this.elements.stepIndicators.forEach((indicator) => {

            const indicatorStep = Number(
                indicator.dataset.stepIndicator
            );

            indicator.classList.remove(
                'is-active',
                'is-complete'
            );


            if (indicatorStep < step) {

                indicator.classList.add(
                    'is-complete'
                );

            } else if (indicatorStep === step) {

                indicator.classList.add(
                    'is-active'
                );

            }

        });

    },


    /*
    |--------------------------------------------------------------------------
    | Validate Step
    |--------------------------------------------------------------------------
    */

    validateStep(step) {

        let valid = true;


        if (step === 1) {

            const fields = [
                {
                    element: this.elements.companyName,
                    key: 'company_name',
                    message: 'Company name is required.',
                },
                {
                    element: this.elements.businessType,
                    key: 'business_type',
                    message: 'Business type is required.',
                },
                {
                    element: this.elements.currency,
                    key: 'currency',
                    message: 'Please select a currency.',
                },
                {
                    element: this.elements.timezone,
                    key: 'timezone',
                    message: 'Please select a timezone.',
                },
            ];

            fields.forEach((field) => {

                if (
                    !field.element ||
                    !field.element.value.trim()
                ) {

                    this.setFieldError(
                        field.key,
                        field.message
                    );

                    valid = false;

                } else {

                    this.clearFieldError(
                        field.key
                    );

                }

            });


            if (
                this.elements.companyEmail?.value.trim() &&
                !this.isValidEmail(
                    this.elements.companyEmail.value.trim()
                )
            ) {

                this.setFieldError(
                    'company_email',
                    'Please enter a valid business email address.'
                );

                valid = false;

            }


            if (
                this.elements.companyPhone?.value.trim() &&
                this.elements.companyPhone.value.trim().length < 7
            ) {

                this.setFieldError(
                    'company_phone',
                    'Please enter a valid business phone number.'
                );

                valid = false;

            }

        }


        if (step === 2) {

            const fields = [
                {
                    element: this.elements.ownerFirstName,
                    key: 'first_name',
                    message: 'First name is required.',
                },
                {
                    element: this.elements.ownerLastName,
                    key: 'last_name',
                    message: 'Last name is required.',
                },
                {
                    element: this.elements.ownerUsername,
                    key: 'username',
                    message: 'Username is required.',
                },
                {
                    element: this.elements.ownerEmail,
                    key: 'email',
                    message: 'Email address is required.',
                },
                {
                    element: this.elements.ownerPassword,
                    key: 'password',
                    message: 'Password is required.',
                },
                {
                    element: this.elements.ownerPasswordConfirmation,
                    key: 'password_confirmation',
                    message: 'Please confirm your password.',
                },
            ];


            fields.forEach((field) => {

                if (
                    !field.element ||
                    !field.element.value.trim()
                ) {

                    this.setFieldError(
                        field.key,
                        field.message
                    );

                    valid = false;

                } else {

                    this.clearFieldError(
                        field.key
                    );

                }

            });


            const email = this.elements.ownerEmail?.value.trim();

            if (
                email &&
                !this.isValidEmail(email)
            ) {

                this.setFieldError(
                    'email',
                    'Please enter a valid email address.'
                );

                valid = false;

            }


            const username =
                this.elements.ownerUsername?.value.trim();


            if (
                username &&
                !/^[A-Za-z0-9._-]+$/.test(username)
            ) {

                this.setFieldError(
                    'username',
                    'Username may contain letters, numbers, dots, underscores, and hyphens only.'
                );

                valid = false;

            }


            const password =
                this.elements.ownerPassword?.value || '';


            const confirmation =
                this.elements.ownerPasswordConfirmation?.value || '';


            if (
                password &&
                password.length < 8
            ) {

                this.setFieldError(
                    'password',
                    'Password must be at least 8 characters.'
                );

                valid = false;

            }


            if (
                password &&
                confirmation &&
                password !== confirmation
            ) {

                this.setFieldError(
                    'password_confirmation',
                    'Passwords do not match.'
                );

                valid = false;

            }


            if (
                this.elements.ownerPhone?.value.trim() &&
                this.elements.ownerPhone.value.trim().length < 7
            ) {

                this.setFieldError(
                    'phone',
                    'Please enter a valid phone number.'
                );

                valid = false;

            }

        }


        if (step === 3) {

            if (
                !this.elements.acceptTerms?.checked
            ) {

                this.setFieldError(
                    'accept_terms',
                    'You must confirm the information before creating your workspace.'
                );

                valid = false;

            } else {

                this.clearFieldError(
                    'accept_terms'
                );

            }

        }


        if (!valid) {

            this.showAlert(
                'Please correct the highlighted fields before continuing.'
            );

        }


        return valid;

    },


    /*
    |--------------------------------------------------------------------------
    | Bind Live Validation
    |--------------------------------------------------------------------------
    */

    bindFieldValidation() {

        const fields = this.elements.form?.querySelectorAll(
            'input, select, textarea'
        );


        fields?.forEach((field) => {

            field.addEventListener('input', () => {

                const key = field.name;

                if (!key) {
                    return;
                }

                this.clearFieldError(key);

                this.hideAlert();

            });


            field.addEventListener('change', () => {

                const key = field.name;

                if (!key) {
                    return;
                }

                this.clearFieldError(key);

                this.hideAlert();

            });

        });

    },


    /*
    |--------------------------------------------------------------------------
    | Set Field Error
    |--------------------------------------------------------------------------
    */

    setFieldError(key, message) {

        const field = this.elements.form?.querySelector(
            `[name="${key}"]`
        );

        const error = this.elements.form?.querySelector(
            `[data-error-for="${key}"]`
        );


        field?.classList.add('is-invalid');


        if (error) {

            error.textContent = message;
            error.classList.add('d-block');

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Clear Field Error
    |--------------------------------------------------------------------------
    */

    clearFieldError(key) {

        const field = this.elements.form?.querySelector(
            `[name="${key}"]`
        );

        const error = this.elements.form?.querySelector(
            `[data-error-for="${key}"]`
        );


        field?.classList.remove('is-invalid');


        if (error) {

            error.textContent = '';
            error.classList.remove('d-block');

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Clear All Field Errors
    |--------------------------------------------------------------------------
    */

    clearAllFieldErrors() {

        this.elements.form
            ?.querySelectorAll('.is-invalid')
            .forEach((field) => {

                field.classList.remove('is-invalid');

            });


        this.elements.form
            ?.querySelectorAll('[data-error-for]')
            .forEach((error) => {

                error.textContent = '';
                error.classList.remove('d-block');

            });

    },


    /*
    |--------------------------------------------------------------------------
    | Populate Review
    |--------------------------------------------------------------------------
    */

    populateReview() {

        const value = (element, fallback = '—') => {

            const result = element?.value?.trim();

            return result || fallback;

        };


        /*
        |--------------------------------------------------------------------------
        | Company
        |--------------------------------------------------------------------------
        */

        this.setReviewValue(
            this.elements.reviewCompanyName,
            value(this.elements.companyName)
        );


        this.setReviewValue(
            this.elements.reviewBusinessType,
            value(this.elements.businessType)
        );


        this.setReviewValue(
            this.elements.reviewCompanyEmail,
            value(this.elements.companyEmail)
        );


        this.setReviewValue(
            this.elements.reviewCompanyPhone,
            value(this.elements.companyPhone)
        );


        this.setReviewValue(
            this.elements.reviewCurrency,
            this.getSelectedOptionText(
                this.elements.currency
            )
        );


        this.setReviewValue(
            this.elements.reviewTimezone,
            this.getSelectedOptionText(
                this.elements.timezone
            )
        );


        this.setReviewValue(
            this.elements.reviewCompanyAddress,
            value(this.elements.companyAddress)
        );


        /*
        |--------------------------------------------------------------------------
        | Owner
        |--------------------------------------------------------------------------
        */

        const firstName =
            value(this.elements.ownerFirstName, '');


        const lastName =
            value(this.elements.ownerLastName, '');


        const fullName =
            `${firstName} ${lastName}`.trim() || '—';


        this.setReviewValue(
            this.elements.reviewOwnerName,
            fullName
        );


        this.setReviewValue(
            this.elements.reviewOwnerUsername,
            value(this.elements.ownerUsername)
        );


        this.setReviewValue(
            this.elements.reviewOwnerEmail,
            value(this.elements.ownerEmail)
        );


        this.setReviewValue(
            this.elements.reviewOwnerPhone,
            value(this.elements.ownerPhone)
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Set Review Value
    |--------------------------------------------------------------------------
    */

    setReviewValue(element, value) {

        if (!element) {
            return;
        }

        element.textContent = value || '—';

    },


    /*
    |--------------------------------------------------------------------------
    | Get Selected Option Text
    |--------------------------------------------------------------------------
    */

    getSelectedOptionText(select) {

        if (!select) {
            return '—';
        }


        const option =
            select.options[select.selectedIndex];


        if (!option || !option.value) {
            return '—';
        }


        return option.textContent.trim();

    },


    /*
    |--------------------------------------------------------------------------
    | Password Toggle
    |--------------------------------------------------------------------------
    */

    togglePassword(button) {

        const targetId =
            button.dataset.passwordTarget;


        if (!targetId) {
            return;
        }


        const input =
            document.getElementById(targetId);


        if (!input) {
            return;
        }


        const icon =
            button.querySelector('i');


        const isPassword =
            input.type === 'password';


        input.type =
            isPassword ? 'text' : 'password';


        if (icon) {

            icon.classList.toggle(
                'bi-eye',
                !isPassword
            );

            icon.classList.toggle(
                'bi-eye-slash',
                isPassword
            );

        }


        button.setAttribute(
            'aria-label',
            isPassword
                ? 'Hide password'
                : 'Show password'
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Handle Submit
    |--------------------------------------------------------------------------
    */

    async handleSubmit() {

        if (this.state.submitting) {
            return;
        }


        if (!this.validateStep(3)) {
            return;
        }


        const form =
            this.elements.form;


        if (!form) {
            return;
        }


        this.state.submitting = true;

        this.setSubmittingState(true);
        this.hideAlert();


        try {

            const response =
                await fetch(
                    form.action,
                    {
                        method: 'POST',

                        headers: {
                            'X-CSRF-TOKEN':
                                this.getCsrfToken(),

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',
                        },

                        body:
                            new FormData(form),
                    }
                );


            const data =
                await this.parseResponse(response);


            if (
                response.status === 422
            ) {

                this.handleValidationErrors(
                    data
                );

                return;

            }


            if (!response.ok) {

                throw new Error(
                    data?.message ||
                    'Something went wrong while creating your workspace.'
                );

            }


            if (
                data?.success
            ) {

                this.handleSuccess(
                    data
                );

                return;

            }


            throw new Error(
                data?.message ||
                'Unable to complete registration.'
            );

        } catch (error) {

            console.error(
                'Onboarding registration error:',
                error
            );


            this.showAlert(
                error.message ||
                'Unable to create your workspace. Please try again.'
            );

        } finally {

            this.state.submitting = false;

            this.setSubmittingState(false);

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Parse Response
    |--------------------------------------------------------------------------
    */

    async parseResponse(response) {

        const contentType =
            response.headers.get(
                'content-type'
            ) || '';


        if (
            contentType.includes(
                'application/json'
            )
        ) {

            return await response.json();

        }


        const text =
            await response.text();


        return {
            success: false,
            message:
                text ||
                'Unexpected server response.',
        };

    },


    /*
    |--------------------------------------------------------------------------
    | Handle Validation Errors
    |--------------------------------------------------------------------------
    */

    handleValidationErrors(data) {

        this.clearAllFieldErrors();


        const errors =
            data?.errors || {};


        let firstErrorStep = null;


        Object.entries(errors).forEach(
            ([key, messages]) => {

                const message =
                    Array.isArray(messages)
                        ? messages[0]
                        : messages;


                this.setFieldError(
                    key,
                    message
                );


                const step =
                    this.getStepForField(key);


                if (
                    !firstErrorStep &&
                    step
                ) {

                    firstErrorStep = step;

                }

            }
        );


        this.showAlert(
            data?.message ||
            'Please correct the highlighted fields.'
        );


        if (firstErrorStep) {

            this.goToStep(
                firstErrorStep
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Determine Step For Field
    |--------------------------------------------------------------------------
    */

    getStepForField(key) {

        const companyFields = [
            'company_name',
            'business_type',
            'company_email',
            'company_phone',
            'company_address',
            'currency',
            'timezone',
        ];


        const ownerFields = [
            'first_name',
            'last_name',
            'username',
            'email',
            'phone',
            'password',
            'password_confirmation',
        ];


        if (
            companyFields.includes(key)
        ) {

            return 1;

        }


        if (
            ownerFields.includes(key)
        ) {

            return 2;

        }


        if (
            key === 'accept_terms'
        ) {

            return 3;

        }


        return null;

    },


    /*
    |--------------------------------------------------------------------------
    | Submit State
    |--------------------------------------------------------------------------
    */

    setSubmittingState(submitting) {

        const {
            submitButton,
            submitLabel,
            submitLoading,
            submitIcon,
        } = this.elements;


        if (!submitButton) {
            return;
        }


        submitButton.disabled =
            submitting;


        if (submitting) {

            submitLabel?.classList.add(
                'd-none'
            );

            submitIcon?.classList.add(
                'd-none'
            );

            submitLoading?.classList.remove(
                'd-none'
            );

        } else {

            submitLabel?.classList.remove(
                'd-none'
            );

            submitIcon?.classList.remove(
                'd-none'
            );

            submitLoading?.classList.add(
                'd-none'
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Handle Success
    |--------------------------------------------------------------------------
    */

    handleSuccess(data) {

        const {
            form,
            progress,
            intro,
            success,
        } = {
            form: this.elements.form,
            progress: this.elements.progress,
            intro: document.getElementById(
                'onboardingIntro'
            ),
            success: this.elements.success,
        };


        if (form) {
            form.classList.add('d-none');
        }


        if (progress) {
            progress.classList.add('d-none');
        }


        if (intro) {
            intro.classList.add('d-none');
        }


        success?.classList.remove(
            'd-none'
        );


        this.elements.stepIndicators
            .forEach((indicator) => {

                indicator.classList.remove(
                    'is-active'
                );

                indicator.classList.add(
                    'is-complete'
                );

            });


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        |
        | The backend may return a redirect URL after successful
        | provisioning. Otherwise use the dashboard route.
        |
        */

        const redirectUrl =
            data?.redirect_url ||
            '/dashboard';


        window.setTimeout(() => {

            window.location.href =
                redirectUrl;

        }, 1200);

    },


    /*
    |--------------------------------------------------------------------------
    | Alert
    |--------------------------------------------------------------------------
    */

    showAlert(message) {

        const {
            alert,
            alertMessage,
        } = this.elements;


        if (!alert || !alertMessage) {
            return;
        }


        alertMessage.textContent =
            message || 'Please check your information.';


        alert.classList.remove(
            'd-none'
        );


        alert.scrollIntoView({
            behavior: 'smooth',
            block: 'nearest',
        });

    },


    /*
    |--------------------------------------------------------------------------
    | Hide Alert
    |--------------------------------------------------------------------------
    */

    hideAlert() {

        this.elements.alert?.classList.add(
            'd-none'
        );

    },


    /*
    |--------------------------------------------------------------------------
    | CSRF Token
    |--------------------------------------------------------------------------
    */

    getCsrfToken() {

        const meta =
            document.querySelector(
                'meta[name="csrf-token"]'
            );


        return meta?.getAttribute(
            'content'
        ) || '';

    },


    /*
    |--------------------------------------------------------------------------
    | Email Validation
    |--------------------------------------------------------------------------
    */

    isValidEmail(email) {

        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(
            email
        );

    },

};


/*
|--------------------------------------------------------------------------
| Bootstrap Onboarding
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    () => {

        window.Onboarding.init();

    }
);

