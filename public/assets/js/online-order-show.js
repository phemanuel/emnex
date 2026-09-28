/*
|--------------------------------------------------------------------------
| EMNEX POS
|--------------------------------------------------------------------------
| Shipping - Online Order Details
|--------------------------------------------------------------------------
*/

window.OnlineOrderShow = {

    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    elements: {},

    modal: null,

    isSubmitting: false,


    /*
    |--------------------------------------------------------------------------
    | Initialize
    |--------------------------------------------------------------------------
    */

    init()
    {
        this.cacheElements();

        if (!this.elements.page) {
            return;
        }

        this.initializeModal();

        this.bindEvents();
    },


    /*
    |--------------------------------------------------------------------------
    | Cache Elements
    |--------------------------------------------------------------------------
    */

    cacheElements()
    {
        this.elements = {

            page:
                document.getElementById(
                    'onlineOrderShowPage'
                ),

            form:
                document.getElementById(
                    'onlineOrderFulfilmentForm'
                ),

            updateButton:
                document.getElementById(
                    'onlineOrderUpdateButton'
                ),

            confirmButton:
                document.getElementById(
                    'onlineOrderConfirmStatusButton'
                ),

            spinner:
                document.getElementById(
                    'onlineOrderStatusSpinner'
                ),

            nextStatus:
                document.getElementById(
                    'onlineOrderNextStatus'
                ),

            modalElement:
                document.getElementById(
                    'onlineOrderStatusModal'
                ),

            trackingReference:
                document.getElementById(
                    'tracking_reference'
                ),

            shippingNotes:
                document.getElementById(
                    'shipping_notes'
                ),

        };
    },


    /*
    |--------------------------------------------------------------------------
    | Initialize Bootstrap Modal
    |--------------------------------------------------------------------------
    */

    initializeModal()
    {
        if (
            !this.elements.modalElement ||
            typeof bootstrap === 'undefined'
        ) {
            return;
        }

        this.modal =
            bootstrap.Modal.getOrCreateInstance(
                this.elements.modalElement
            );
    },


    /*
    |--------------------------------------------------------------------------
    | Bind Events
    |--------------------------------------------------------------------------
    */

    bindEvents()
    {
        if (
            this.elements.confirmButton
        ) {
            this.elements.confirmButton
                .addEventListener(
                    'click',
                    () => {

                        this.submitFulfilment();

                    }
                );
        }


        if (
            this.elements.form
        ) {
            this.elements.form
                .addEventListener(
                    'submit',
                    event => {

                        if (
                            !this.isSubmitting
                        ) {
                            event.preventDefault();
                        }

                    }
                );
        }


        if (
            this.elements.modalElement
        ) {
            this.elements.modalElement
                .addEventListener(
                    'hidden.bs.modal',
                    () => {

                        if (
                            !this.isSubmitting
                        ) {
                            this.setLoading(
                                false
                            );
                        }

                    }
                );
        }
    },


    /*
    |--------------------------------------------------------------------------
    | Submit Fulfilment
    |--------------------------------------------------------------------------
    */

    submitFulfilment()
    {
        if (
            this.isSubmitting ||
            !this.elements.form
        ) {
            return;
        }


        if (
            !this.validate()
        ) {
            return;
        }


        this.isSubmitting = true;

        this.setLoading(
            true
        );


        this.elements.form.submit();
    },


    /*
    |--------------------------------------------------------------------------
    | Validate
    |--------------------------------------------------------------------------
    */

    validate()
    {
        const nextStatus =
            this.elements.nextStatus
                ?.value
                ?.trim();


        if (!nextStatus) {

            this.showValidationError(
                'Unable to determine the next fulfilment status.'
            );

            return false;
        }


        /*
        |--------------------------------------------------------------------------
        | Tracking Reference
        |--------------------------------------------------------------------------
        |
        | Tracking reference is optional for now.
        | If later we decide it must be required when marking an order
        | as shipped, that rule should also be enforced server-side.
        |
        */

        const trackingReference =
            this.elements.trackingReference
                ?.value
                ?.trim()
            || '';


        if (
            trackingReference.length >
            190
        ) {

            this.showValidationError(
                'Tracking reference must not exceed 190 characters.'
            );

            return false;
        }


        /*
        |--------------------------------------------------------------------------
        | Shipping Notes
        |--------------------------------------------------------------------------
        */

        const shippingNotes =
            this.elements.shippingNotes
                ?.value
            || '';


        if (
            shippingNotes.length >
            2000
        ) {

            this.showValidationError(
                'Shipping notes must not exceed 2000 characters.'
            );

            return false;
        }


        this.clearValidationError();

        return true;
    },


    /*
    |--------------------------------------------------------------------------
    | Loading State
    |--------------------------------------------------------------------------
    */

    setLoading(isLoading)
    {
        const button =
            this.elements.confirmButton;


        if (!button) {
            return;
        }


        button.disabled =
            isLoading;


        const label =
            button.querySelector(
                '.online-order-confirm-label'
            );


        if (label) {

            if (
                !label.dataset.originalText
            ) {
                label.dataset.originalText =
                    label.textContent.trim();
            }


            label.textContent =
                isLoading
                    ? 'Updating...'
                    : label.dataset.originalText;

        }


        if (
            this.elements.spinner
        ) {
            this.elements.spinner
                .classList
                .toggle(
                    'd-none',
                    !isLoading
                );
        }


        if (
            this.elements.updateButton
        ) {
            this.elements.updateButton.disabled =
                isLoading;
        }
    },


    /*
    |--------------------------------------------------------------------------
    | Validation Error
    |--------------------------------------------------------------------------
    */

    showValidationError(message)
    {
        this.clearValidationError();


        const container =
            document.createElement(
                'div'
            );


        container.id =
            'onlineOrderValidationError';


        container.className =
            'online-order-js-error';


        const icon =
            document.createElement(
                'i'
            );


        icon.className =
            'bi bi-exclamation-circle';


        const text =
            document.createElement(
                'span'
            );


        text.textContent =
            message;


        container.appendChild(
            icon
        );


        container.appendChild(
            text
        );


        const target =
            this.elements.form;


        if (target) {

            target.prepend(
                container
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Close Modal
        |--------------------------------------------------------------------------
        |
        | This makes the validation error visible in the fulfilment panel.
        |
        */

        if (this.modal) {

            this.modal.hide();

        }
    },


    clearValidationError()
    {
        document
            .getElementById(
                'onlineOrderValidationError'
            )
            ?.remove();
    },

};


/*
|--------------------------------------------------------------------------
| Bootstrap
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    function () {

        window.OnlineOrderShow
            .init();

    }
);