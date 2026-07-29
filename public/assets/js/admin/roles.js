/*
|--------------------------------------------------------------------------
| EMNEX POS
| Roles Management
|--------------------------------------------------------------------------
*/

const Role = {

    currentId: null,

    saving: false,

    deleting: false,

    modal: null,

    deleteModal: null,

    codeEdited: false,

    init() {

        this.modal = document.getElementById('roleModal');

        this.deleteModal = document.getElementById('deleteRoleModal');

        this.bindEvents();

    },

    bindEvents() {

        document
            .getElementById('roleForm')
            .addEventListener('submit', this.save.bind(this));

        document
            .getElementById('name')
            .addEventListener('keyup', this.generateCode.bind(this));

        document
            .getElementById('code')
            .addEventListener('keyup', () => {

                this.codeEdited = true;

            });

        document.addEventListener('keydown', (e) => {

            if (
                e.key === 'Escape' &&
                this.modal.classList.contains('show')
            ) {

                this.close();

            }

        });

    },

    /*
    |--------------------------------------------------------------------------
    | Modal
    |--------------------------------------------------------------------------
    */

    openCreate() {

        this.currentId = null;

        this.codeEdited = false;

        this.clearErrors();

        document.getElementById('roleForm').reset();

        document.getElementById('roleModalTitle').innerHTML =
            '<i class="bi bi-shield-lock-fill text-primary me-2"></i>Add Role';

        document.getElementById('saveRoleBtn').innerHTML =
            '<i class="bi bi-check-circle me-2"></i>Save Role';

        this.modal.classList.add('show');

        document.body.style.overflow = 'hidden';

    },

    async openEdit(id) {

        this.currentId = id;

        this.codeEdited = true;

        this.clearErrors();

        try {

            const response = await fetch(`/roles/${id}/edit`, {

                headers: {

                    Accept: 'application/json'

                }

            });

            const data = await response.json();

            const role = data.role;

            document.getElementById('name').value = role.name;

            document.getElementById('code').value = role.code;

            document.getElementById('display_name').value =
                role.display_name ?? '';

            document.getElementById('description').value =
                role.description ?? '';

            document.getElementById('status').checked =
                role.status;

            document.getElementById('roleModalTitle').innerHTML =
                '<i class="bi bi-pencil-square text-primary me-2"></i>Edit Role';

            document.getElementById('saveRoleBtn').innerHTML =
                '<i class="bi bi-pencil-square me-2"></i>Update Role';

            this.modal.classList.add('show');

            document.body.style.overflow = 'hidden';

        }
        catch {

            showToast('Unable to load role.', 'error');

        }

    },

    close() {

        this.modal.classList.remove('show');

        document.body.style.overflow = '';

        this.currentId = null;

        this.clearErrors();

    },

    /*
    |--------------------------------------------------------------------------
    | Save
    |--------------------------------------------------------------------------
    */

    async save(e) {

        e.preventDefault();

        if (this.saving) {

            return;

        }

        this.saving = true;

        this.clearErrors();

        const button = document.getElementById('saveRoleBtn');

        button.disabled = true;

        button.innerHTML =
            '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

        const form = document.getElementById('roleForm');

        const formData = new FormData(form);

        if (!document.getElementById('status').checked) {

            formData.set('status', 0);

        }

        let url = '/roles';

        if (this.currentId) {

            url = `/roles/${this.currentId}`;

            formData.append('_method', 'PUT');

        }

        try {

            const response = await fetch(url, {

                method: 'POST',

                headers: {

                    'X-CSRF-TOKEN':
                        document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,

                    Accept: 'application/json'

                },

                body: formData

            });

            const data = await response.json();

            if (!response.ok) {

                if (data.errors) {

                    this.showErrors(data.errors);

                    showToast(
                        'Please correct the highlighted fields.',
                        'warning'
                    );

                } else {

                    showToast(
                        data.message ?? 'Unable to save role.',
                        'error'
                    );

                }

                return;

            }

            this.close();

            showToast(data.message, 'success');

            setTimeout(() => {

                location.reload();

            }, 400);

        }
        catch {

            showToast(
                'Unexpected server error.',
                'error'
            );

        }
        finally {

            this.saving = false;

            button.disabled = false;

            button.innerHTML = this.currentId
                ? '<i class="bi bi-pencil-square me-2"></i>Update Role'
                : '<i class="bi bi-check-circle me-2"></i>Save Role';

        }

    },

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    confirmDelete(id) {

        this.currentId = id;

        this.deleteModal.classList.add('show');

    },

     closeDelete() {

        document
            .getElementById('deleteRoleModal')
            .classList.remove('show');

        document.body.style.overflow = '';

        this.currentId = null;

    },

    async delete() {

        if (this.deleting) {

            return;

        }

        this.deleting = true;

        try {

            const response = await fetch(

                `/roles/${this.currentId}`,

                {

                    method: 'POST',

                    headers: {

                        'X-CSRF-TOKEN':
                            document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content,

                        Accept: 'application/json'

                    },

                    body: new URLSearchParams({

                        _method: 'DELETE'

                    })

                }

            );

            const data = await response.json();

            if (!response.ok) {

                showToast(data.message, 'error');

                return;

            }

            this.deleteModal.classList.remove('show');

            showToast(data.message, 'success');

            setTimeout(() => {

                location.reload();

            }, 400);

        }
        catch {

            showToast('Unable to delete role.', 'error');

        }
        finally {

            this.deleting = false;

        }

    },

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    generateCode() {

        if (this.codeEdited) {

            return;

        }

        const name = document
            .getElementById('name')
            .value;

        document.getElementById('code').value =

            name

                .trim()

                .toLowerCase()

                .replace(/\s+/g, '_')

                .replace(/[^a-z0-9_]/g, '');

    },

    showErrors(errors) {

        Object.keys(errors).forEach(field => {

            const input = document.getElementById(field);

            if (!input) {

                return;

            }

            input.classList.add('is-invalid');

            const div = document.createElement('div');

            div.className = 'invalid-feedback';

            div.innerHTML = errors[field][0];

            input.after(div);

        });

    },

    clearErrors() {

        document

            .querySelectorAll('.is-invalid')

            .forEach(el => {

                el.classList.remove('is-invalid');

            });

        document

            .querySelectorAll('.invalid-feedback')

            .forEach(el => {

                el.remove();

            });

    }

};

/*
|--------------------------------------------------------------------------
| Global Functions
|--------------------------------------------------------------------------
*/

function openCreateRoleModal() {

    Role.openCreate();

}

function openEditRoleModal(id) {

    Role.openEdit(id);

}

function closeRoleModal() {

    Role.close();

}

function confirmDeleteRole(id) {

    Role.confirmDelete(id);

}

function deleteRole() {

    Role.delete();

}

document.addEventListener('DOMContentLoaded', () => {

    Role.init();

});

