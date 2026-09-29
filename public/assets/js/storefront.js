/**
 * ============================================================================
 * EMNEX — Storefront Management
 * ============================================================================
 *
 * Handles:
 * - Storefront details update
 * - Inline validation
 * - Storefront activation
 * - Storefront disabling
 * - Dedicated URL copy
 * - Button/loading states
 * - Success/error feedback
 *
 * ============================================================================
 */

window.StorefrontManager = {

    /**
     * --------------------------------------------------------------------------
     * State
     * --------------------------------------------------------------------------
     */

    state: {
        updating: false,
        activating: false,
        disabling: false,
    },


    /**
     * --------------------------------------------------------------------------
     * Elements
     * --------------------------------------------------------------------------
     */

    elements: {},


    /**
     * --------------------------------------------------------------------------
     * Initialize
     * --------------------------------------------------------------------------
     */

    init() {

        this.cacheElements();

        this.bindEvents();

    },


    /**
     * --------------------------------------------------------------------------
     * Cache Elements
     * --------------------------------------------------------------------------
     */

    cacheElements() {

        this.elements = {

            updateForm:
                document.getElementById(
                    'storefrontUpdateForm'
                ),

            activateForm:
                document.getElementById(
                    'storefrontActivateForm'
                ),

            disableForm:
                document.getElementById(
                    'storefrontDisableForm'
                ),

            storefrontName:
                document.getElementById(
                    'storefront_name'
                ),

            storefrontSlug:
                document.getElementById(
                    'storefront_slug'
                ),

            updateButton:
                document.getElementById(
                    'storefrontUpdateButton'
                ),

            activateButton:
                document.getElementById(
                    'storefrontActivateButton'
                ),            

            activateModal:
                document.getElementById(
                    'activateStorefrontModal'
                ),

            confirmActivateButton:
                document.getElementById(
                    'confirmActivateStorefront'
                ),            

            disableButton:
                document.getElementById(
                    'storefrontDisableButton'
                ),

            disableModal:
                document.getElementById(
                    'disableStorefrontModal'
                ),

            confirmDisableButton:
                document.getElementById(
                    'confirmDisableStorefront'
                ),

            publicUrl:
                document.getElementById(
                    'storefrontPublicUrl'
                ),

            copyUrlButton:
                document.getElementById(
                    'copyStorefrontUrl'
                ),

            alert:
                document.getElementById(
                    'storefrontAlert'
                ),

            alertIcon:
                document.getElementById(
                    'storefrontAlertIcon'
                ),

            alertMessage:
                document.getElementById(
                    'storefrontAlertMessage'
                ),

            toastContainer:
                document.querySelector(
                    '.toast-container'
                ),

        };

    },


    /**
     * --------------------------------------------------------------------------
     * Bind Events
     * --------------------------------------------------------------------------
     */

    bindEvents() {

        this.elements.updateForm
            ?.addEventListener(
                'submit',
                (event) => {

                    event.preventDefault();

                    this.updateStorefront();

                }
            );       


        this.elements.copyUrlButton
            ?.addEventListener(
                'click',
                () => {

                    this.copyStorefrontUrl();

                }
            );

        this.elements.activateButton
            ?.addEventListener(
                'click',
                () => {

                    this.openActivateModal();

                }
            );


        this.elements.confirmActivateButton
            ?.addEventListener(
                'click',
                () => {

                    this.activateStorefront();

                }
            );

        this.elements.disableButton
            ?.addEventListener(
                'click',
                () => {

                    this.openDisableModal();

                }
            );

        this.elements.confirmDisableButton
            ?.addEventListener(
                'click',
                () => {

                    this.disableStorefront();

                }
            );

            document
            .querySelectorAll(
                '.storefront-theme-input'
            )
            .forEach(input => {

                input.addEventListener(
                    'change',
                    () => {

                        document
                            .querySelectorAll(
                                '.storefront-theme-option'
                            )
                            .forEach(option => {

                                option.classList.remove(
                                    'is-selected'
                                );

                            });


                        input
                            .closest(
                                '.storefront-theme-option'
                            )
                            ?.classList.add(
                                'is-selected'
                            );

                    }
                );

            });


        /**
         * Clear field validation while typing.
         */
        [
            this.elements.storefrontName,
            this.elements.storefrontSlug,
        ].forEach((field) => {

            field?.addEventListener(
                'input',
                () => {

                    this.clearFieldError(
                        field.name
                    );

                    this.hideAlert();

                }
            );

        });

    },


    /**
     * --------------------------------------------------------------------------
     * Update Storefront
     * --------------------------------------------------------------------------
     */

    async updateStorefront() {

        if (this.state.updating) {
            return;
        }


        const form =
            this.elements.updateForm;


        if (!form) {
            return;
        }


        this.clearValidationErrors();

        this.hideAlert();


        this.state.updating = true;

        this.setButtonLoading(
            this.elements.updateButton,
            true,
            'Saving...'
        );


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
                await this.parseResponse(
                    response
                );


            if (
                response.status === 422
            ) {

                this.handleValidationErrors(
                    data.errors || {}
                );

                this.showToast(
                    data.message ||
                    'Please correct the highlighted fields.',
                    'danger'
                );

                return;

            }


            if (!response.ok) {

                throw new Error(
                    data.message ||
                    'Unable to update Storefront.'
                );

            }


            this.showToast(
                data.message ||
                'Storefront updated successfully.',
                'success'
            );


            /**
             * If the slug changed, update
             * the URL shown on-screen.
             */
            if (
                data.data?.public_url &&
                this.elements.publicUrl
            ) {

                this.elements.publicUrl
                    .textContent =
                        data.data.public_url;

            }


        } catch (error) {

            console.error(
                'Storefront update error:',
                error
            );


            this.showToast(
                error.message ||
                'Unable to update Storefront.',
                'danger'
            );


        } finally {

            this.state.updating = false;

            this.setButtonLoading(
                this.elements.updateButton,
                false
            );

        }

    },


    /**
     * --------------------------------------------------------------------------
     * Confirm Activation
     * --------------------------------------------------------------------------
     */

    confirmActivation() {

        const confirmed =
            window.confirm(
                'Activate this Storefront? Once activated, customers will be able to access the public Storefront.'
            );


        if (!confirmed) {
            return;
        }


        this.activateStorefront();

    },


    /**
     * --------------------------------------------------------------------------
     * Activate Storefront
     * --------------------------------------------------------------------------
     */

    async activateStorefront() {

        if (this.state.activating) {
            return;
        }


        const form =
            this.elements.activateForm;


        if (!form) {
            return;
        }


        this.state.activating = true;

        this.hideAlert();


        this.setButtonLoading(
            this.elements.activateButton,
            true,
            'Activating...'
        );


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
                await this.parseResponse(
                    response
                );


            if (
                response.status === 422
            ) {

                this.showToast(
                    data.message ||
                    'Your Storefront is not ready to be activated.',
                    'danger'
                );

                return;

            }


            if (!response.ok) {

                throw new Error(
                    data.message ||
                    'Unable to activate Storefront.'
                );

            }


            this.showToast(
                data.message ||
                'Your Storefront is now live.',
                'success'
            );


            /**
             * Reload so all status cards,
             * buttons and progress indicators
             * reflect the Active state.
             */
            window.setTimeout(
                () => {

                    window.location.reload();

                },
                700
            );


        } catch (error) {

            console.error(
                'Storefront activation error:',
                error
            );


            this.showToast(
                error.message ||
                'Unable to activate Storefront.',
                'danger'
            );


        } finally {

            this.state.activating = false;

            this.setButtonLoading(
                this.elements.activateButton,
                false
            );

        }

    },

    showToast(
        message,
        type = 'success',
        title = null
    ) {

        const container =
            this.elements.toastContainer;


        if (!container) {
            return;
        }


        const toastId =
            `storefrontToast-${Date.now()}`;


        const iconClass =
            type === 'success'
                ? 'bi-check-lg'
                : type === 'warning'
                    ? 'bi-exclamation-triangle'
                    : 'bi-x-lg';


        const toastTitle =
            title ||
            (
                type === 'success'
                    ? 'Success'
                    : type === 'warning'
                        ? 'Notice'
                        : 'Something went wrong'
            );


        const toast =
            document.createElement('div');


        toast.id =
            toastId;


        toast.className =
            `toast storefront-toast is-${type}`;


        toast.setAttribute(
            'role',
            'alert'
        );


        toast.setAttribute(
            'aria-live',
            'assertive'
        );


        toast.setAttribute(
            'aria-atomic',
            'true'
        );


        toast.innerHTML = `
            <div class="toast-header">

                <div class="storefront-toast-icon">

                    <i class="bi ${iconClass}"></i>

                </div>

                <strong class="me-auto">
                    ${this.escapeHtml(toastTitle)}
                </strong>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="toast"
                    aria-label="Close"
                ></button>

            </div>

            <div class="toast-body">
                ${this.escapeHtml(message)}
            </div>
        `;


        container.appendChild(
            toast
        );


        const instance =
            bootstrap.Toast.getOrCreateInstance(
                toast,
                {
                    delay: 3500,
                }
            );


        toast.addEventListener(
            'hidden.bs.toast',
            () => {

                toast.remove();

            }
        );


        instance.show();

    },

    escapeHtml(value) {

        const div =
            document.createElement('div');


        div.textContent =
            value ?? '';


        return div.innerHTML;

    },

    /**
     * --------------------------------------------------------------------------
     * Confirm Disable
     * --------------------------------------------------------------------------
     */

    confirmDisable() {

        const confirmed =
            window.confirm(
                'Disable this Storefront? Customers will no longer be able to access it. Your Storefront configuration, products and sales history will remain intact.'
            );


        if (!confirmed) {
            return;
        }


        this.disableStorefront();

    },


    /**
     * --------------------------------------------------------------------------
     * Disable Storefront
     * --------------------------------------------------------------------------
     */

    async disableStorefront() {

        if (this.state.disabling) {
            return;
        }


        const form =
            this.elements.disableForm;


        if (!form) {
            return;
        }


        this.state.disabling = true;

        this.hideAlert();


        this.setButtonLoading(
            this.elements.disableButton,
            true,
            'Disabling...'
        );


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
                await this.parseResponse(
                    response
                );


            if (!response.ok) {

                throw new Error(
                    data.message ||
                    'Unable to disable Storefront.'
                );

            }


            this.showToast(
                data.message ||
                'Storefront disabled successfully.',
                'success'
            );


            window.setTimeout(
                () => {

                    window.location.reload();

                },
                700
            );


        } catch (error) {

            console.error(
                'Storefront disable error:',
                error
            );


            this.showToast(
                error.message ||
                'Unable to disable Storefront.',
                'danger'
            );


        } finally {

            this.state.disabling = false;

            this.setButtonLoading(
                this.elements.disableButton,
                false
            );

        }

    },

    openActivateModal() {

    const modalElement =
        this.elements.activateModal;


    if (!modalElement) {

        console.error(
            'Activate Storefront modal was not found.'
        );

        return;
    }


    if (
        typeof bootstrap === 'undefined' ||
        !bootstrap.Modal
    ) {

        console.error(
            'Bootstrap Modal is not available.'
        );

        return;
    }


    const modal =
        bootstrap.Modal.getOrCreateInstance(
            modalElement
        );


    modal.show();

},

openDisableModal() {

    const modalElement =
        this.elements.disableModal;

    if (!modalElement) {

        console.error(
            'Disable Storefront modal was not found.'
        );

        return;
    }

    if (
        typeof bootstrap === 'undefined' ||
        !bootstrap.Modal
    ) {

        console.error(
            'Bootstrap Modal is not available.'
        );

        return;
    }

    const modal =
        bootstrap.Modal.getOrCreateInstance(
            modalElement
        );

    modal.show();

},

async disableStorefront() {

    if (this.state.disabling) {
        return;
    }

    const form =
        this.elements.disableForm;

    if (!form) {
        return;
    }

    this.state.disabling = true;

    this.setButtonLoading(
        this.elements.confirmDisableButton,
        true,
        'Disabling...'
    );

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
            await this.parseResponse(
                response
            );

        if (!response.ok) {

            throw new Error(
                data.message ||
                'Unable to disable Storefront.'
            );

        }

        const modal =
            bootstrap.Modal.getInstance(
                this.elements.disableModal
            );

        modal?.hide();

        this.showToast(
            data.message ||
            'Storefront disabled successfully.',
            'success',
            'Storefront disabled'
        );

        window.setTimeout(
            () => {

                window.location.reload();

            },
            900
        );

    } catch (error) {

        console.error(
            'Storefront disable error:',
            error
        );

        this.showToast(
            error.message ||
            'Unable to disable Storefront.',
            'danger',
            'Disable failed'
        );

    } finally {

        this.state.disabling = false;

        this.setButtonLoading(
            this.elements.confirmDisableButton,
            false
        );

    }

},


    /**
     * --------------------------------------------------------------------------
     * Copy Public URL
     * --------------------------------------------------------------------------
     */

    async copyStorefrontUrl() {

        const url =
            this.elements.publicUrl
                ?.textContent
                ?.trim();


        if (!url) {
            return;
        }


        try {

            await navigator.clipboard
                .writeText(url);


            const icon =
                this.elements.copyUrlButton
                    ?.querySelector('i');


            if (icon) {

                icon.classList.remove(
                    'bi-copy'
                );

                icon.classList.add(
                    'bi-check-lg'
                );


                window.setTimeout(
                    () => {

                        icon.classList.remove(
                            'bi-check-lg'
                        );

                        icon.classList.add(
                            'bi-copy'
                        );

                    },
                    1500
                );

            }


        } catch (error) {

            console.error(
                'Unable to copy Storefront URL.',
                error
            );


            this.showToast(
                'Unable to copy the Storefront URL.',
                'danger'
            );

        }

    },


    /**
     * --------------------------------------------------------------------------
     * Validation Errors
     * --------------------------------------------------------------------------
     */

    handleValidationErrors(errors) {

        Object.entries(errors)
            .forEach(
                ([key, messages]) => {

                    const message =
                        Array.isArray(messages)
                            ? messages[0]
                            : messages;


                    this.setFieldError(
                        key,
                        message
                    );

                }
            );

    },


    setFieldError(key, message) {

        const form =
            this.elements.updateForm;


        const field =
            form?.querySelector(
                `[name="${key}"]`
            );


        const error =
            form?.querySelector(
                `[data-error-for="${key}"]`
            );


        field?.classList.add(
            'is-invalid'
        );


        if (error) {

            error.textContent =
                message;

            error.classList.add(
                'd-block'
            );

        }

    },


    clearFieldError(key) {

        const form =
            this.elements.updateForm;


        const field =
            form?.querySelector(
                `[name="${key}"]`
            );


        const error =
            form?.querySelector(
                `[data-error-for="${key}"]`
            );


        field?.classList.remove(
            'is-invalid'
        );


        if (error) {

            error.textContent = '';

            error.classList.remove(
                'd-block'
            );

        }

    },


    clearValidationErrors() {

        this.elements.updateForm
            ?.querySelectorAll(
                '.is-invalid'
            )
            .forEach((field) => {

                field.classList.remove(
                    'is-invalid'
                );

            });


        this.elements.updateForm
            ?.querySelectorAll(
                '[data-error-for]'
            )
            .forEach((error) => {

                error.textContent = '';

                error.classList.remove(
                    'd-block'
                );

            });

    },


    /**
     * --------------------------------------------------------------------------
     * Button Loading State
     * --------------------------------------------------------------------------
     */

    setButtonLoading(
        button,
        loading,
        loadingText = 'Processing...'
    ) {

        if (!button) {
            return;
        }


        if (loading) {

            if (
                !button.dataset.originalHtml
            ) {

                button.dataset.originalHtml =
                    button.innerHTML;

            }


            button.disabled = true;


            button.innerHTML = `
                <span
                    class="spinner-border spinner-border-sm"
                    aria-hidden="true"
                ></span>

                <span>
                    ${loadingText}
                </span>
            `;


            return;

        }


        button.disabled = false;


        if (
            button.dataset.originalHtml
        ) {

            button.innerHTML =
                button.dataset.originalHtml;

        }

    },


    /**
     * --------------------------------------------------------------------------
     * Alert
     * --------------------------------------------------------------------------
     */

    showAlert(
        message,
        type = 'success'
    ) {

        const alert =
            this.elements.alert;


        if (!alert) {
            return;
        }


        alert.classList.remove(
            'd-none',
            'alert-success',
            'alert-danger',
            'alert-warning'
        );


        alert.classList.add(
            `alert-${type}`
        );


        if (
            this.elements.alertMessage
        ) {

            this.elements.alertMessage
                .textContent =
                    message;

        }


        if (
            this.elements.alertIcon
        ) {

            this.elements.alertIcon
                .className =
                    type === 'success'
                        ? 'bi bi-check-circle-fill'
                        : 'bi bi-exclamation-circle-fill';

        }


        alert.scrollIntoView({
            behavior: 'smooth',
            block: 'nearest',
        });

    },


    hideAlert() {

        this.elements.alert
            ?.classList.add(
                'd-none'
            );

    },


    /**
     * --------------------------------------------------------------------------
     * Parse Response
     * --------------------------------------------------------------------------
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


        return {
            success: false,
            message:
                'Unexpected server response.',
        };

    },


    /**
     * --------------------------------------------------------------------------
     * CSRF
     * --------------------------------------------------------------------------
     */

    getCsrfToken() {

        return document
            .querySelector(
                'meta[name="csrf-token"]'
            )
            ?.getAttribute(
                'content'
            ) || '';

    },

};


/**
 * ============================================================================
 * Bootstrap Storefront
 * ============================================================================
 */

document.addEventListener(
    'DOMContentLoaded',
    () => {

        window.StorefrontManager.init();

    }
);