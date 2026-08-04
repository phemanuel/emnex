const TaxRates = {

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    currentId: null,

    csrfToken: document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content'),

    elements: {},

    modal: null,

    inspector: null,

    statusModal: null,

    deleteModal: null,



    /*
    |--------------------------------------------------------------------------
    | Initialize
    |--------------------------------------------------------------------------
    */

    init()
    {

        this.cacheElements();

        this.initializeComponents();

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

            table:
                document.getElementById(
                    'taxRateTable'
                ),

            form:
                document.getElementById(
                    'taxRateForm'
                ),

            modalTitle:
                document.getElementById(
                    'taxRateModalTitle'
                ),

            id:
                document.getElementById(
                    'taxRateId'
                ),

            name:
                document.getElementById(
                    'taxRateName'
                ),

            rate:
                document.getElementById(
                    'taxRateValue'
                ),

            saveButton:
                document.getElementById(
                    'saveTaxRateBtn'
                ),

            search:
                document.getElementById(
                    'searchTaxRate'
                ),

            status:
                document.getElementById(
                    'statusFilter'
                ),

            previewName:
                document.getElementById(
                    'taxPreviewName'
                ),

            previewRate:
                document.getElementById(
                    'taxPreviewRate'
                ),

            inspectorContent:
                document.getElementById(
                    'taxRateInspectorContent'
                )

        };

    },



    /*
    |--------------------------------------------------------------------------
    | Bootstrap Components
    |--------------------------------------------------------------------------
    */

    initializeComponents()
    {

        this.modal = new bootstrap.Modal(

            document.getElementById(
                'taxRateModal'
            )

        );



        this.inspector = new bootstrap.Offcanvas(

            document.getElementById(
                'taxRateInspector'
            )

        );



        this.statusModal = new bootstrap.Modal(

            document.getElementById(
                'statusModal'
            )

        );



        this.deleteModal = new bootstrap.Modal(

            document.getElementById(
                'deleteModal'
            )

        );

    },



    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

    bindEvents()
    {

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        this.elements.search?.addEventListener(

            'keyup',

            () => this.loadData()

        );



        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        this.elements.status?.addEventListener(

            'change',

            () => this.loadData()

        );



        /*
        |--------------------------------------------------------------------------
        | Form
        |--------------------------------------------------------------------------
        */

        this.elements.form?.addEventListener(

            'submit',

            (e) => {

                e.preventDefault();

                this.save();

            }

        );



        /*
        |--------------------------------------------------------------------------
        | Live Preview
        |--------------------------------------------------------------------------
        */

        this.elements.name?.addEventListener(

            'input',

            () => {

                this.elements.previewName.textContent =

                    this.elements.name.value ||

                    'Tax Name';

            }

        );



        this.elements.rate?.addEventListener(

            'input',

            () => {

                let value =

                    this.elements.rate.value || '0.00';

                this.elements.previewRate.textContent =

                    parseFloat(value).toFixed(2) + '%';

            }

        );

    },



    /*
    |--------------------------------------------------------------------------
    | Headers
    |--------------------------------------------------------------------------
    */

    getHeaders()
    {

        return {

            'X-CSRF-TOKEN':
                this.csrfToken,

            'X-Requested-With':
                'XMLHttpRequest',

            'Accept':
                'application/json'

        };

    },



    /*
    |--------------------------------------------------------------------------
    | Load Table
    |--------------------------------------------------------------------------
    */

    async loadData(url = null)
    {

        url ??=

            `/tax-rates/table?search=${encodeURIComponent(

                this.elements.search.value

            )}&status=${this.elements.status.value}`;



        const response =

            await fetch(url, {

                headers: {

                    Accept: 'text/html'

                }

            });



        this.elements.table.innerHTML =

            await response.text();



        this.bindPagination();

    },



    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    bindPagination()
    {

        this.elements.table

            .querySelectorAll('.pagination a')

            .forEach(link => {

                link.addEventListener(

                    'click',

                    (e) => {

                        e.preventDefault();

                        this.loadData(

                            link.href

                        );

                    }

                );

            });

    },

        /*
    |--------------------------------------------------------------------------
    | Reset Form
    |--------------------------------------------------------------------------
    */

    resetForm()
    {

        this.currentId = null;

        this.elements.form.reset();

        this.elements.id.value = '';

        this.elements.modalTitle.textContent =
            'New Tax Rate';

        this.elements.saveButton.innerHTML = `

            <i class="bi bi-check-circle me-1"></i>

            Save Tax Rate

        `;

        this.elements.previewName.textContent =
            'Tax Name';

        this.elements.previewRate.textContent =
            '0.00%';

    },



    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    openCreateModal()
    {

        this.resetForm();

        this.modal.show();

    },



    /*
    |--------------------------------------------------------------------------
    | Save
    |--------------------------------------------------------------------------
    */

    async save()
    {

        const id =
            this.elements.id.value;

        const formData =
            new FormData(
                this.elements.form
            );

        let url = '/tax-rates';

        if(id)
        {

            formData.append(
                '_method',
                'PUT'
            );

            url =
                `/tax-rates/${id}`;

        }

        this.elements.saveButton.disabled = true;

        this.elements.saveButton.innerHTML =

            `
                <span class="spinner-border spinner-border-sm me-2"></span>

                Saving...
            `;

        try{

            const response =
                await fetch(url,{

                    method:'POST',

                    headers:this.getHeaders(),

                    body:formData

                });

            const result =
                await response.json();

            if(!response.ok)
            {

                throw result;

            }

            showToast(

                result.type,

                result.message

            );

            this.modal.hide();

            this.loadData();

        }
        catch(error)
        {

            if(error.errors)
            {

                Object.values(
                    error.errors
                ).forEach(messages=>{

                    showToast(
                        'error',
                        messages[0]
                    );

                });

            }
            else
            {

                showToast(

                    error.type ?? 'error',

                    error.message ?? 'Unable to save tax rate.'

                );

            }

        }
        finally
        {

            this.elements.saveButton.disabled = false;

            this.elements.saveButton.innerHTML =

                `
                    <i class="bi bi-check-circle me-1"></i>

                    Save Tax Rate
                `;

        }

    },



    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    async edit(id)
    {

        try{

            const response =
                await fetch(

                    `/tax-rates/${id}/edit`,

                    {

                        headers:{
                            Accept:'application/json'
                        }

                    }

                );

            const result =
                await response.json();

            if(!result.success)
            {

                showToast(

                    result.type,

                    result.message

                );

                return;

            }

            const taxRate =
                result.data;

            this.resetForm();

            this.currentId = id;

            this.elements.id.value =
                taxRate.id;

            this.elements.name.value =
                taxRate.name;

            this.elements.rate.value =
                taxRate.rate;

            this.elements.modalTitle.textContent =
                'Edit Tax Rate';

            this.elements.previewName.textContent =
                taxRate.name;

            this.elements.previewRate.textContent =
                parseFloat(taxRate.rate).toFixed(2)+'%';

            this.modal.show();

        }
        catch(e)
        {

            showToast(

                'error',

                'Unable to load tax rate.'

            );

        }

    },

        /*
    |--------------------------------------------------------------------------
    | Inspector
    |--------------------------------------------------------------------------
    */

    async openInspector(id)
    {

        this.inspector.show();

        this.elements.inspectorContent.innerHTML = `

            <div class="inspector-loading">

                <div class="spinner-border text-primary"></div>

                <h6 class="mt-4">

                    Loading Tax Rate...

                </h6>

                <p class="text-muted mb-0">

                    Please wait...

                </p>

            </div>

        `;

        try{

            const response =
                await fetch(

                    `/tax-rates/${id}/details`,

                    {

                        headers:{
                            Accept:'application/json'
                        }

                    }

                );

            const result =
                await response.json();

            if(!result.success)
            {

                showToast(

                    result.type,

                    result.message

                );

                return;

            }

            const taxRate =
                result.data;

            const statusBadge =
                taxRate.status

                ? '<span class="badge bg-success">Active</span>'

                : '<span class="badge bg-danger">Inactive</span>';

            this.elements.inspectorContent.innerHTML = `

                <div class="inspector-hero">

                    <div class="inspector-hero-icon">

                        <i class="bi bi-percent"></i>

                    </div>

                    <h3 class="mb-2">

                        ${taxRate.name}

                    </h3>

                    <h5 class="mb-3">

                        ${parseFloat(taxRate.rate).toFixed(2)}%

                    </h5>

                    ${statusBadge}

                </div>



                <div class="inspector-section">

                    <div class="inspector-section-title">

                        General Information

                    </div>

                    <div class="info-item">

                        <span class="info-label">

                            Tax Name

                        </span>

                        <span class="info-value">

                            ${taxRate.name}

                        </span>

                    </div>

                    <div class="info-item">

                        <span class="info-label">

                            Rate

                        </span>

                        <span class="info-value">

                            ${parseFloat(taxRate.rate).toFixed(2)}%

                        </span>

                    </div>

                    <div class="info-item">

                        <span class="info-label">

                            Status

                        </span>

                        <span class="info-value">

                            ${statusBadge}

                        </span>

                    </div>

                    <div class="info-item">

                        <span class="info-label">

                            Products Using Tax

                        </span>

                        <span class="info-value">

                            ${taxRate.products_count}

                        </span>

                    </div>

                </div>



                <div class="inspector-section">

                    <div class="inspector-section-title">

                        Timeline

                    </div>

                    <div class="info-item">

                        <span class="info-label">

                            Created

                        </span>

                        <span class="info-value">

                            ${new Date(taxRate.created_at).toLocaleString()}

                        </span>

                    </div>

                    <div class="info-item">

                        <span class="info-label">

                            Updated

                        </span>

                        <span class="info-value">

                            ${new Date(taxRate.updated_at).toLocaleString()}

                        </span>

                    </div>

                </div>

            `;

        }
        catch(e)
        {

            showToast(

                'error',

                'Unable to load tax rate details.'

            );

        }

    },

        /*
    |--------------------------------------------------------------------------
    | Status Modal
    |--------------------------------------------------------------------------
    */

    openStatusModal(id, action, name)
    {

        this.currentId = id;

        document.getElementById('statusTaxRateId').value = id;

        document.getElementById('statusTaxRateName').textContent = name;

        document.getElementById('statusActionText').textContent = action;

        document.getElementById('statusModalTitle').textContent =
            `${action} Tax Rate`;

        const button =
            document.getElementById(
                'confirmStatusBtn'
            );

        const icon =
            document.getElementById(
                'statusModalIcon'
            );

        const iconClass =
            document.getElementById(
                'statusModalIconClass'
            );

        const alert =
            document.getElementById(
                'statusAlert'
            );

        if(action === 'Enable')
        {

            button.className =
                'btn btn-success';

            button.innerHTML = `

                <i class="bi bi-check-circle me-1"></i>

                Enable Tax Rate

            `;

            icon.className =
                'modal-action-icon bg-success-subtle text-success';

            iconClass.className =
                'bi bi-check-circle';

            alert.className =
                'alert alert-success mt-4 mb-0';

            alert.textContent =
                'This tax rate will become available for use immediately.';

        }
        else
        {

            button.className =
                'btn btn-warning';

            button.innerHTML = `

                <i class="bi bi-power me-1"></i>

                Disable Tax Rate

            `;

            icon.className =
                'modal-action-icon bg-warning-subtle text-warning';

            iconClass.className =
                'bi bi-power';

            alert.className =
                'alert alert-warning mt-4 mb-0';

            alert.textContent =
                'This tax rate will no longer be available for future transactions.';

        }

        button.onclick =
            () => this.toggleStatus();

        this.statusModal.show();

    },



    /*
    |--------------------------------------------------------------------------
    | Toggle Status
    |--------------------------------------------------------------------------
    */

    async toggleStatus()
    {

        const button =
            document.getElementById(
                'confirmStatusBtn'
            );

        button.disabled = true;

        try{

            const response =
                await fetch(

                    `/tax-rates/${this.currentId}/toggle-status`,

                    {

                        method:'PATCH',

                        headers:this.getHeaders()

                    }

                );

            const result =
                await response.json();

            showToast(

                result.type,

                result.message

            );

            if(result.success)
            {

                this.statusModal.hide();

                this.loadData();

            }

        }
        catch(e)
        {

            showToast(

                'error',

                'Unable to update tax rate status.'

            );

        }
        finally
        {

            button.disabled = false;

        }

    },



    /*
    |--------------------------------------------------------------------------
    | Delete Modal
    |--------------------------------------------------------------------------
    */

    openDeleteModal(id,name)
    {

        this.currentId = id;

        document.getElementById(
            'deleteTaxRateId'
        ).value = id;

        document.getElementById(
            'deleteTaxRateName'
        ).textContent = name;

        document.getElementById(
            'confirmDeleteBtn'
        ).onclick =
            () => this.delete();

        this.deleteModal.show();

    },



    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    async delete()
    {

        const button =
            document.getElementById(
                'confirmDeleteBtn'
            );

        button.disabled = true;

        button.innerHTML = `

            <span class="spinner-border spinner-border-sm me-2"></span>

            Deleting...

        `;

        try{

            const response =
                await fetch(

                    `/tax-rates/${this.currentId}`,

                    {

                        method:'DELETE',

                        headers:this.getHeaders()

                    }

                );

            const result =
                await response.json();

            showToast(

                result.type,

                result.message

            );

            if(result.success)
            {

                this.deleteModal.hide();

                this.loadData();

            }

        }
        catch(e)
        {

            showToast(

                'error',

                'Unable to delete tax rate.'

            );

        }
        finally
        {

            button.disabled = false;

            button.innerHTML = `

                <i class="bi bi-trash3 me-1"></i>

                Delete Tax Rate

            `;

        }

    }

};

document.addEventListener(

    'DOMContentLoaded',

    () => TaxRates.init()

);

