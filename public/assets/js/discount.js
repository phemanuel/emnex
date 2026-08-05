const Discounts = {

    currentId: null,

    csrfToken: null,

    currentMode: 'create',

    elements: {},

    modal: null,

    inspector: null,

    statusModal: null,

    deleteModal: null,

    init() {

        this.csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute('content');

        this.cacheElements();

        this.initializeComponents();

        this.bindEvents();

        this.loadData();

    },

    cacheElements() {

        this.elements = {

            tableContainer: document.getElementById('discountTableContainer'),

            search: document.getElementById('searchDiscount'),

            status: document.getElementById('statusFilter'),

            createButton: document.getElementById('btnCreateDiscount'),

            form: document.getElementById('discountForm'),

            saveButton: document.getElementById('saveDiscountBtn'),

            modalTitle: document.getElementById('discountModalLabel'),

            statusTitle: document.getElementById('statusModalTitle'),

            statusMessage: document.getElementById('statusModalMessage'),

            deleteMessage: document.getElementById('deleteModalMessage'),

            confirmStatus: document.getElementById('confirmStatusBtn'),

            confirmDelete: document.getElementById('confirmDeleteBtn'),


            discountId: document.getElementById('discountId'),

            name: document.getElementById('name'),

            type: document.getElementById('type'),

            value: document.getElementById('value'),

            startDate: document.getElementById('start_date'),

            endDate: document.getElementById('end_date'),

            automatic: document.getElementById('is_automatic'),

            

        };

        this.elements.inspector = {
            name: document.getElementById('inspector-name'),
            type: document.getElementById('inspector-type'),
            value: document.getElementById('inspector-value'),
            automatic: document.getElementById('inspector-automatic'),
            current: document.getElementById('inspector-current'),
            status: document.getElementById('inspector-status'),
            startDate: document.getElementById('inspector-start-date'),
            endDate: document.getElementById('inspector-end-date'),
            products: document.getElementById('inspector-products'),
            created: document.getElementById('inspector-created'),
            updated: document.getElementById('inspector-updated'),
        };

    },

    initializeComponents() {

        const modal = document.getElementById('discountModal');
        if (modal) {
            this.modal = new bootstrap.Modal(modal);
        }

        const inspector = document.getElementById('discountInspector');
        if (inspector) {
            this.inspector = new bootstrap.Offcanvas(inspector);
        }

        const statusModal = document.getElementById('statusModal');
        if (statusModal) {
            this.statusModal = new bootstrap.Modal(statusModal);
        }

        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            this.deleteModal = new bootstrap.Modal(deleteModal);
        }

    },

    bindEvents() {

        this.elements.createButton?.addEventListener(
            'click',
            () => this.openCreateModal()
        );

        let searchTimer;

        this.elements.search?.addEventListener('input', () => {

            clearTimeout(searchTimer);

            searchTimer = setTimeout(() => {

                this.loadData();

            }, 300);

        });

        this.elements.status?.addEventListener(
            'change',
            () => this.loadData()
        );

        this.elements.form?.addEventListener(
            'submit',
            (e) => {

                e.preventDefault();

                this.save();

            }
        );

        this.elements.confirmStatus?.addEventListener(
            'click',
            () => this.toggleStatus()
        );

        this.elements.confirmDelete?.addEventListener(
            'click',
            () => this.delete()
        );

    },

    getHeaders() {

        return {

            'X-CSRF-TOKEN': this.csrfToken,

            'X-Requested-With': 'XMLHttpRequest',

            'Accept': 'application/json'

        };

    },

    loadData(page = 1) {

    const params = new URLSearchParams({

        search: this.elements.search?.value || '',

        status: this.elements.status?.value || '',

        page

    });

    this.elements.tableContainer.innerHTML = `
        <div class="table-loading">
            <div class="spinner-border text-primary"></div>
        </div>
    `;

    fetch(`/discounts/table?${params.toString()}`, {

        headers: this.getHeaders()

    })
    .then(response => response.text())
    .then(html => {

        this.elements.tableContainer.innerHTML = html;

        this.bindPagination();

        this.bindTableActions();

    })
    .catch(() => {

        this.elements.tableContainer.innerHTML = '';

        showToast(
            'Unable to load discounts.',
            'danger'
        );

    });

},

bindPagination() {

    this.elements.tableContainer
        .querySelectorAll('.pagination a')
        .forEach(link => {

            link.addEventListener('click', (e) => {

                e.preventDefault();

                const url = new URL(link.href);

                const page = url.searchParams.get('page') || 1;

                this.loadData(page);

            });

        });

},

resetForm() {

    this.elements.form.reset();

    document.getElementById('discountId').value = '';

    document.getElementById('is_automatic').checked = false;

    this.currentId = null;

    this.currentMode = 'create';

    this.elements.modalTitle.textContent = 'New Discount';

    this.elements.saveButton.innerHTML = `
        <i class="bi bi-check-circle me-2"></i>
        Save Discount
    `;

},

openCreateModal() {

    this.resetForm();

    this.modal.show();

},

bindTableActions() {

    this.elements.tableContainer
        .querySelectorAll('.btn-view')
        .forEach(button => {

            button.addEventListener('click', () => {

                this.openInspector(button.dataset.id);

            });

        });

    this.elements.tableContainer
        .querySelectorAll('.btn-edit')
        .forEach(button => {

            button.addEventListener('click', () => {

                this.edit(button.dataset.id);

            });

        });

    this.elements.tableContainer
        .querySelectorAll('.btn-status')
        .forEach(button => {

            button.addEventListener('click', () => {

                this.openStatusModal(
                    button.dataset.id,
                    button.dataset.status
                );

            });

        });

    this.elements.tableContainer
        .querySelectorAll('.btn-delete')
        .forEach(button => {

            button.addEventListener('click', () => {

                this.openDeleteModal(button.dataset.id);

            });

        });

},

async save() {

    try {

        this.elements.saveButton.disabled = true;

        this.elements.saveButton.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2"></span>
            Saving...
        `;

        const formData = new FormData(this.elements.form);

        let url = '/discounts';

        let method = 'POST';

        if (this.currentMode === 'edit') {

            url = `/discounts/${this.currentId}`;

            formData.append('_method', 'PUT');

        }

        const response = await fetch(url, {

            method,

            headers: this.getHeaders(),

            body: formData

        });

        const result = await response.json();

        showToast(
            result.message,
            result.type
        );

        if (result.success) {

            this.modal.hide();

            this.loadData();

        }

    } catch (error) {

        showToast(
            'Unable to save discount.',
            'danger'
        );

        console.error(error);

    } finally {

        this.elements.saveButton.disabled = false;

        this.elements.saveButton.innerHTML = `
            <i class="bi bi-check-circle me-2"></i>
            Save Discount
        `;

    }

},

async edit(id) {

    try {

        const response = await fetch(

            `/discounts/${id}/edit`,

            {

                headers: this.getHeaders()

            }

        );

        const result = await response.json();

        if (!result.success) {

            showToast(
                result.message,
                result.type
            );

            return;

        }

        const discount = result.data;

        this.resetForm();

        this.currentId = discount.id;

        this.currentMode = 'edit';

        this.elements.modalTitle.textContent = 'Edit Discount';

        this.elements.saveButton.innerHTML = `
            <i class="bi bi-check-circle me-2"></i>
            Update Discount
        `;

        document.getElementById('discountId').value = discount.id;

        document.getElementById('name').value = discount.name;

        document.getElementById('type').value = discount.type;

        document.getElementById('value').value = discount.value;

        document.getElementById('start_date').value = discount.start_date;

        document.getElementById('end_date').value = discount.end_date;
        //  console.log(discount.is_automatic, typeof discount.is_automatic);
        this.elements.automatic.checked = discount.is_automatic;

        this.modal.show();

    } catch (error) {

        showToast(
            'Unable to load discount.',
            'danger'
        );

        console.error(error);

    }

},

async openInspector(id) {

    try {

        const response = await fetch(
            `/discounts/${id}/details`,
            {
                headers: this.getHeaders()
            }
        );

        const result = await response.json();

        if (!result.success) {
            showToast(result.message, result.type);
            return;
        }

        // THIS LINE IS REQUIRED
        const data = result.data;

        const inspector = this.elements.inspector;

        inspector.name.textContent = data.name;
        inspector.type.textContent = data.type;
        inspector.value.textContent = data.display_value;
       
        inspector.automatic.innerHTML = data.is_automatic
            ? '<span class="badge badge-auto">Yes</span>'
            : '<span class="badge badge-manual">No</span>';

        inspector.current.innerHTML = data.is_current
            ? '<span class="badge badge-current">Current</span>'
            : '<span class="badge badge-expired">Expired / Upcoming</span>';

        inspector.status.className = data.status
            ? 'badge badge-status-active'
            : 'badge badge-status-inactive';

        inspector.status.textContent = data.status
            ? 'Active'
            : 'Inactive';

        inspector.startDate.textContent = data.start_date;
        inspector.endDate.textContent = data.end_date;
        inspector.products.textContent = data.products_count;
        inspector.created.textContent = data.created_at;
        inspector.updated.textContent = data.updated_at;

        this.inspector.show();

    } catch (error) {

        console.error(error);

        showToast(
            'Unable to load discount details.',
            'danger'
        );

    }

},

openStatusModal(id, status) {

    this.currentId = id;

    const active = status == 1;

    this.elements.statusTitle.textContent =
        active
            ? 'Disable Discount?'
            : 'Enable Discount?';

    this.elements.statusMessage.textContent =
        active
            ? 'The discount will no longer be available until it is enabled again.'
            : 'The discount will become available immediately.';

    this.elements.confirmStatus.className =
        active
            ? 'btn btn-warning'
            : 'btn btn-success';

    this.elements.confirmStatus.innerHTML =
        active
            ? '<i class="bi bi-pause-circle me-2"></i>Disable'
            : '<i class="bi bi-check-circle me-2"></i>Enable';

    this.statusModal.show();

},

async toggleStatus() {

    try {

        this.elements.confirmStatus.disabled = true;

        const response = await fetch(

            `/discounts/${this.currentId}/toggle-status`,

            {

                method: 'PATCH',

                headers: this.getHeaders()

            }

        );

        const result = await response.json();

        showToast(
            result.message,
            result.type
        );

        if (result.success) {

            this.statusModal.hide();

            this.loadData();

        }

    } catch (error) {

        console.error(error);

        showToast(
            'Unable to update discount status.',
            'danger'
        );

    } finally {

        this.elements.confirmStatus.disabled = false;

        this.currentId = null;

    }

},

openDeleteModal(id) {

    this.currentId = id;

    this.deleteModal.show();

},

async delete() {

    try {

        this.elements.confirmDelete.disabled = true;

        const response = await fetch(

            `/discounts/${this.currentId}`,

            {

                method: 'DELETE',

                headers: this.getHeaders()

            }

        );

        const result = await response.json();

        showToast(
            result.message,
            result.type
        );

        if (result.success) {

            this.deleteModal.hide();

            this.loadData();

        }

    } catch (error) {

        console.error(error);

        showToast(
            'Unable to delete discount.',
            'danger'
        );

    } finally {

        this.elements.confirmDelete.disabled = false;

        this.currentId = null;

    }

}

};

window.Discounts = Discounts;

document.addEventListener(

    'DOMContentLoaded',

    () => {

        Discounts.init();

    }

);