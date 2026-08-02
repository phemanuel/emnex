const DocumentSequences = {

    editModal: null,

    currentId: null,

    form: null,

    preview: null,

    prefix: null,

    suffix: null,

    separator: null,

    currentNumber: null,

    numberLength: null,



    init() {

        this.cacheElements();

        this.bindEvents();

    },



    cacheElements() {

        this.editModal = new bootstrap.Modal(
            document.getElementById('editSequenceModal')
        );

        this.form = document.getElementById('editSequenceForm');

        this.preview = document.getElementById('sequencePreview');

        this.prefix = document.getElementById('prefix');

        this.suffix = document.getElementById('suffix');

        this.separator = document.getElementById('separator');

        this.currentNumber = document.getElementById('current_number');

        this.numberLength = document.getElementById('number_length');

    },



    bindEvents() {

        document.addEventListener('click', (e) => {

            const editBtn = e.target.closest('.edit-sequence-btn');

            if (editBtn) {

                this.openEditModal(
                    editBtn.dataset.id
                );

            }

        });



        document.addEventListener('click', (e) => {

            const toggleBtn = e.target.closest('.toggle-status-btn');

            if (toggleBtn) {

                this.toggleStatus(
                    toggleBtn.dataset.id
                );

            }

        });



        this.form.addEventListener('submit', (e) => {

            e.preventDefault();

            this.update();

        });



        [
            this.prefix,
            this.suffix,
            this.separator,
            this.currentNumber,
            this.numberLength

        ].forEach(field => {

            field.addEventListener(
                'input',
                () => this.updatePreview()
            );

            field.addEventListener(
                'change',
                () => this.updatePreview()
            );

        });

    },



    async openEditModal(id) {

        this.currentId = id;

        this.clearErrors();

        try {

            const response = await fetch(

                window.documentSequenceRoutes.edit.replace(':id', id),

                {

                    headers: {

                        'Accept': 'application/json'

                    }

                }

            );

            const data = await response.json();

            if (!data.success) {

                showToast(
                    data.message,
                    data.type ?? 'warning'
                );

                return;

            }

            const sequence = data.sequence;

            document.getElementById('sequence_id').value = sequence.id;

            document.getElementById('document_type').value = sequence.document_type;

            this.prefix.value = sequence.prefix;

            this.suffix.value = sequence.suffix ?? '';

            this.separator.value = sequence.separator;

            this.currentNumber.value = sequence.current_number;

            this.numberLength.value = sequence.number_length;

            document.getElementById('reset_frequency').value =
                sequence.reset_frequency;

            this.updatePreview();

            this.editModal.show();

        } catch (error) {

            showToast(
                'Unable to load document sequence.',
                'error'
            );

        }

    },



    updatePreview() {

        const number = String(this.currentNumber.value)
            .padStart(
                this.numberLength.value,
                '0'
            );

        let preview = '';

        if (this.prefix.value) {

            preview += this.prefix.value;

        }

        if (this.separator.value) {

            preview += this.separator.value;

        }

        preview += number;

        if (this.suffix.value) {

            preview += this.suffix.value;

        }

        this.preview.textContent = preview;

    },



 async update() {

    this.clearErrors();

    const formData = new FormData(this.form);

    // Debug
    console.log('Form:', this.form);

    for (const [key, value] of formData.entries()) {
        console.log(key, value);
    }

    try {

        const response = await fetch(

            window.documentSequenceRoutes.update.replace(
                ':id',
                this.currentId
            ),

            {

                method: 'POST',

                headers: {

                    'Accept': 'application/json',

                    'X-CSRF-TOKEN': document
                        .querySelector(
                            'meta[name="csrf-token"]'
                        )
                        .content

                },

                body: formData

            }

        );

        const data = await response.json();

        if (!response.ok) {

            if (data.errors) {

                this.showValidation(data.errors);

                showToast(
                    'Please correct the highlighted fields.',
                    'warning'
                );

                return;

            }

            showToast(
                data.message ?? 'Update failed.',
                data.type ?? 'warning'
            );

            return;

        }

        this.editModal.hide();

        showToast(
            data.message,
            'success'
        );

        setTimeout(() => {

            location.reload();

        }, 1800);        

    } catch (error) {

        console.error(error);

        showToast(
            'An unexpected error occurred.',
            'error'
        );

    }

},


    async toggleStatus(id) {

        try {

            const response = await fetch(

                window.documentSequenceRoutes.toggle.replace(
                    ':id',
                    id
                ),

                {

                    method: 'PATCH',

                    headers: {

                        'Accept': 'application/json',

                        'X-CSRF-TOKEN': document
                            .querySelector(
                                'meta[name="csrf-token"]'
                            )
                            .content

                    }

                }

            );

            const data = await response.json();

            showToast(
                data.message,
                data.type
            );

            if (data.success) {

                setTimeout(() => {

                    location.reload();

                }, 1800);

            }

        } catch (error) {

            showToast(
                'Unable to update status.',
                'error'
            );

        }

    },



    clearErrors() {

        this.form
            .querySelectorAll('.is-invalid')
            .forEach(input => {

                input.classList.remove('is-invalid');

            });

        this.form
            .querySelectorAll('.invalid-feedback')
            .forEach(div => {

                div.textContent = '';

            });

    },



    showValidation(errors) {

        Object.keys(errors).forEach(field => {

            const input = document.getElementById(field);

            if (!input) return;

            input.classList.add('is-invalid');

            const feedback = input.nextElementSibling;

            if (
                feedback &&
                feedback.classList.contains('invalid-feedback')
            ) {

                feedback.textContent = errors[field][0];

            }

        });

    }

};



document.addEventListener(

    'DOMContentLoaded',

    () => {

        DocumentSequences.init();

    }

);