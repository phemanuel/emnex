/* ==========================================================
   EMNEX POS
   Units Module
========================================================== */

const Units = {

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    elements: {},

    currentId: null,

    currentAction: null,

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

        this.loadData();

        this.csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content');

    },



    /*
    |--------------------------------------------------------------------------
    | Cache DOM Elements
    |--------------------------------------------------------------------------
    */

    cacheElements()
    {

        this.elements.table = document.getElementById('unitsTable');

        this.elements.search = document.getElementById('search');

        this.elements.statusFilter = document.getElementById('statusFilter');



        this.elements.form = document.getElementById('unitForm');

        this.elements.modalTitle = document.getElementById('unitModalTitle');



        this.elements.unitId = document.getElementById('unitId');

        this.elements.unitCode = document.getElementById('unitCode');

        this.elements.name = document.getElementById('unitName');

        this.elements.shortName = document.getElementById('shortName');

        this.elements.description = document.getElementById('description');



        this.elements.inspectorContent = document.getElementById(

            'unitInspectorContent'

        );



        this.elements.statusUnitId = document.getElementById(

            'statusUnitId'

        );

        this.elements.statusAction = document.getElementById(

            'statusAction'

        );



        this.elements.confirmStatusBtn = document.getElementById(

            'confirmStatusBtn'

        );



        this.elements.deleteUnitId = document.getElementById(

            'deleteUnitId'

        );



        this.elements.deleteUnitName = document.getElementById(

            'deleteUnitName'

        );



        this.elements.confirmDeleteBtn = document.getElementById(

            'confirmDeleteBtn'

        );



        this.elements.totalUnits = document.getElementById(

            'totalUnits'

        );



        this.elements.activeUnits = document.getElementById(

            'activeUnits'

        );



        this.elements.inactiveUnits = document.getElementById(

            'inactiveUnits'

        );

    },



    /*
    |--------------------------------------------------------------------------
    | Bootstrap Components
    |--------------------------------------------------------------------------
    */

    initializeComponents()
    {

        this.modal = new bootstrap.Modal(

            document.getElementById('unitModal')

        );



        this.inspector = new bootstrap.Offcanvas(

            document.getElementById('unitInspector')

        );



        this.statusModal = new bootstrap.Modal(

            document.getElementById('statusModal')

        );



        this.deleteModal = new bootstrap.Modal(

            document.getElementById('deleteModal')

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

        this.elements.search.addEventListener(

            'keyup',

            () => this.loadData()

        );



        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        this.elements.statusFilter.addEventListener(

            'change',

            () => this.loadData()

        );



        /*
        |--------------------------------------------------------------------------
        | Save Form
        |--------------------------------------------------------------------------
        */

        this.elements.form.addEventListener(

            'submit',

            (e) => {

                e.preventDefault();

                this.save();

            }

        );



        /*
        |--------------------------------------------------------------------------
        | Confirm Status
        |--------------------------------------------------------------------------
        */

        this.elements.confirmStatusBtn.addEventListener(

            'click',

            () => this.toggleStatus()

        );



        /*
        |--------------------------------------------------------------------------
        | Confirm Delete
        |--------------------------------------------------------------------------
        */

        this.elements.confirmDeleteBtn.addEventListener(

            'click',

            () => this.delete()

        );

    },



    /*
    |--------------------------------------------------------------------------
    | Load Table
    |--------------------------------------------------------------------------
    */

    async loadData(page = 1)
    {

        try{


            this.elements.table.innerHTML = `

                <div class="text-center py-5">

                    <div class="spinner-border text-primary"></div>

                    <p class="mt-3 text-muted">

                        Loading units...

                    </p>

                </div>

            `;



            const response = await fetch(

                `/units/table?page=${page}&search=${encodeURIComponent(

                    this.elements.search.value

                )}&status=${this.elements.statusFilter.value}`,

                {

                    headers:{

                        'X-Requested-With':'XMLHttpRequest',

                        'Accept':'application/json',

                         'X-CSRF-TOKEN': this.csrfToken

                    }

                }

            );



            const result = await response.json();



            if(result.success)
            {

                this.elements.table.innerHTML = result.html;



                /*
                |--------------------------------------------------------------------------
                | Statistics
                |--------------------------------------------------------------------------
                */

                if(result.statistics)
                {

                    this.elements.totalUnits.textContent =

                        result.statistics.total;



                    this.elements.activeUnits.textContent =

                        result.statistics.active;



                    this.elements.inactiveUnits.textContent =

                        result.statistics.inactive;

                }



                this.bindPagination();

            }

        }
        catch(error)
        {

            console.error(error);

            showToast(

                'Unable to load units.',

                'danger'

            );

        }

    },



    /*
    |--------------------------------------------------------------------------
    | AJAX Pagination
    |--------------------------------------------------------------------------
    */

    bindPagination()
    {

        document.querySelectorAll(

            '#unitsTable .pagination a'

        ).forEach(link => {

            link.addEventListener(

                'click',

                (e)=>{

                    e.preventDefault();

                    this.loadData(

                        new URL(

                            link.href

                        ).searchParams.get(

                            'page'

                        )

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



        this.elements.unitId.value = '';



        this.elements.modalTitle.textContent =

            'New Unit';

    },
    /*
    |--------------------------------------------------------------------------
    | Open Create Modal
    |--------------------------------------------------------------------------
    */

    async openCreateModal()
    {

        this.resetForm();



        await this.generateCode();



        this.modal.show();

    },



    /*
    |--------------------------------------------------------------------------
    | Generate Next Unit Code
    |--------------------------------------------------------------------------
    */

    async generateCode()
    {

        try{

            const response = await fetch(

                '/units/next-code',

                {

                    headers:{

                        'X-Requested-With':'XMLHttpRequest',

                        'Accept':'application/json',

                         'X-CSRF-TOKEN': this.csrfToken

                    }

                }

            );



            const result = await response.json();



            if(result.success)
            {

                this.elements.unitCode.value =

                    result.code;

            }

        }
        catch(error)
        {

            console.error(error);

        }

    },



    /*
    |--------------------------------------------------------------------------
    | Save
    |--------------------------------------------------------------------------
    */

    async save()
    {

        let button =

            this.elements.form.querySelector(

                'button[type="submit"]'

            );



        const originalHtml =

            button.innerHTML;



        button.disabled = true;

        button.innerHTML = `

            <span class="spinner-border spinner-border-sm me-2"></span>

            Saving...

        `;



        try{


            const formData = new FormData();



            formData.append(

                'unit_code',

                this.elements.unitCode.value

            );



            formData.append(

                'name',

                this.elements.name.value

            );



            formData.append(

                'short_name',

                this.elements.shortName.value

            );



            formData.append(

                'description',

                this.elements.description.value

            );



            let url = '/units';

            let method = 'POST';



            if(this.currentId)
            {

                url = `/units/${this.currentId}`;

                formData.append('_method','PUT');

            }



            const response = await fetch(

                url,

                {

                    method:'POST',

                    headers:{

                        'X-Requested-With':'XMLHttpRequest',

                        'Accept':'application/json',

                         'X-CSRF-TOKEN': this.csrfToken

                    },

                    body:formData

                }

            );



            const result = await response.json();



            if(result.success)
            {

                this.modal.hide();



                this.loadData();



                showToast(
                result.message,
                result.type
            );

            }
            else
            {

                showToast(

                    result.message,

                    'warning'

                );

            }


        }
        catch(error)
        {

            console.error(error);



            showToast(

                'Unable to save unit.',

                'danger'

            );

        }
        finally
        {

            button.disabled = false;

            button.innerHTML = originalHtml;

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


            this.resetForm();



            const response = await fetch(

                `/units/${id}/edit`,

                {

                    headers:{

                        'X-Requested-With':'XMLHttpRequest',

                        'Accept':'application/json',

                         'X-CSRF-TOKEN': this.csrfToken

                    }

                }

            );



            const result = await response.json();



            if(result.success)
            {

                const unit = result.data;



                this.currentId =

                    unit.id;



                this.elements.modalTitle.textContent =

                    'Edit Unit';



                this.elements.unitId.value =

                    unit.id;



                this.elements.unitCode.value =

                    unit.unit_code;



                this.elements.name.value =

                    unit.name;



                this.elements.shortName.value =

                    unit.short_name;



                this.elements.description.value =

                    unit.description ?? '';



                this.modal.show();

            }

        }
        catch(error)
        {

            console.error(error);



            showToast(

                'Unable to load unit.',

                'danger'

            );

        }

    },

        /*
    |--------------------------------------------------------------------------
    | Open Inspector
    |--------------------------------------------------------------------------
    */

    async openInspector(id)
    {

        this.inspector.show();



        this.elements.inspectorContent.innerHTML = `

            <div class="inspector-loading">

                <div class="spinner-border text-primary"></div>

                <h6 class="mt-4 mb-2">

                    Loading Unit

                </h6>

                <p class="text-muted mb-0">

                    Please wait...

                </p>

            </div>

        `;



        try{

            const response = await fetch(

                `/units/${id}/details`,

                {

                    headers:{

                        'X-Requested-With':'XMLHttpRequest',

                        'Accept':'application/json',

                         'X-CSRF-TOKEN': this.csrfToken

                    }

                }

            );



            const result = await response.json();



            if(result.success)
            {

                const unit = result.data;



                this.elements.inspectorContent.innerHTML = `

                    <div class="inspector-body">


                        <div class="inspector-section">


                            <div class="section-title">

                                Basic Information

                            </div>


                            <div class="info-grid">


                                <div class="info-item">

                                    <label>Unit Code</label>

                                    <div>${unit.unit_code}</div>

                                </div>



                                <div class="info-item">

                                    <label>Status</label>

                                    <div>

                                        ${
                                            unit.status
                                            ? '<span class="badge bg-success">Active</span>'
                                            : '<span class="badge bg-secondary">Disabled</span>'
                                        }

                                    </div>

                                </div>



                                <div class="info-item">

                                    <label>Name</label>

                                    <div>${unit.name}</div>

                                </div>



                                <div class="info-item">

                                    <label>Short Name</label>

                                    <div>${unit.short_name}</div>

                                </div>



                                <div class="info-item full-width">

                                    <label>Description</label>

                                    <div>${unit.description ?? '-'}</div>

                                </div>


                            </div>


                        </div>





                        <div class="inspector-section">


                            <div class="section-title">

                                Audit Information

                            </div>


                            <div class="info-grid">


                                <div class="info-item">

                                    <label>Created By</label>

                                    <div>

                                        ${unit.created_by
                                            ? `${unit.created_by.first_name} ${unit.created_by.last_name}`
                                            : '-'}

                                    </div>

                                </div>



                                <div class="info-item">

                                    <label>Updated By</label>

                                    <div>

                                        ${unit.updated_by
                                            ? `${unit.updated_by.first_name} ${unit.updated_by.last_name}`
                                            : '-'}

                                    </div>

                                </div>



                                <div class="info-item">

                                    <label>Created At</label>

                                    <div>${unit.created_at}</div>

                                </div>



                                <div class="info-item">

                                    <label>Updated At</label>

                                    <div>${unit.updated_at}</div>

                                </div>


                            </div>


                        </div>


                    </div>

                `;

            }

        }
        catch(error)
        {

            console.error(error);

            showToast(

                'Unable to load unit details.',

                'danger'

            );

        }

    },



    /*
    |--------------------------------------------------------------------------
    | Open Status Modal
    |--------------------------------------------------------------------------
    */

    openStatusModal(id, action, name)
    {

        this.elements.statusUnitId.value = id;

        this.elements.statusAction.value = action;



        document.getElementById('statusModalTitle').textContent =

            `${action} Unit`;



        document.getElementById('statusHeading').textContent =

            `${action} Unit?`;



        document.getElementById('statusMessage').innerHTML = `

            You are about to <strong>${action.toLowerCase()}</strong>

            <br>

            <strong>${name}</strong>

        `;



        const button =

            this.elements.confirmStatusBtn;



        if(action === 'Enable')
        {

            button.classList.remove(

                'btn-warning',

                'btn-danger'

            );



            button.classList.add(

                'btn-success'

            );



            button.innerHTML = `

                <i class="bi bi-check-circle me-2"></i>

                Enable Unit

            `;

        }
        else
        {

            button.classList.remove(

                'btn-success',

                'btn-danger'

            );



            button.classList.add(

                'btn-warning'

            );



            button.innerHTML = `

                <i class="bi bi-power me-2"></i>

                Disable Unit

            `;

        }



        this.statusModal.show();

    },



    /*
    |--------------------------------------------------------------------------
    | Toggle Status
    |--------------------------------------------------------------------------
    */

    async toggleStatus()
    {

        const id =

            this.elements.statusUnitId.value;



        const button =

            this.elements.confirmStatusBtn;



        const originalHtml =

            button.innerHTML;



        button.disabled = true;

        button.innerHTML = `

            <span class="spinner-border spinner-border-sm me-2"></span>

            Processing...

        `;



        try{

            const response = await fetch(

                `/units/${id}/toggle-status`,

                {

                    method:'PATCH',

                    headers:{

                        'X-Requested-With':'XMLHttpRequest',

                        'Accept':'application/json',

                         'X-CSRF-TOKEN': this.csrfToken

                    }

                }

            );



            const result = await response.json();



            if(result.success)
            {

                this.statusModal.hide();

                this.loadData();

                showToast(

                    result.message,

                    'success'

                );

            }
            else
            {

                showToast(

                    result.message,

                    'warning'

                );

            }

        }
        catch(error)
        {

            console.error(error);

            showToast(

                'Unable to update unit status.',

                'danger'

            );

        }
        finally
        {

            button.disabled = false;

            button.innerHTML = originalHtml;

        }

    },

        /*
    |--------------------------------------------------------------------------
    | Open Delete Modal
    |--------------------------------------------------------------------------
    */

    openDeleteModal(id, name)
    {

        this.elements.deleteUnitId.value = id;

        this.elements.deleteUnitName.textContent = name;

        this.deleteModal.show();

    },



    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    async delete()
    {

        const id = this.elements.deleteUnitId.value;

        const button = this.elements.confirmDeleteBtn;

        const originalHtml = button.innerHTML;



        button.disabled = true;

        button.innerHTML = `

            <span class="spinner-border spinner-border-sm me-2"></span>

            Deleting...

        `;



        try{

            const response = await fetch(

                `/units/${id}`,

                {

                    method:'DELETE',

                    headers:{

                        'X-Requested-With':'XMLHttpRequest',

                        'Accept':'application/json',

                         'X-CSRF-TOKEN': this.csrfToken

                    }

                }

            );



            const result = await response.json();



            if(result.success)
            {

                this.deleteModal.hide();

                this.loadData();

                showToast(

                    result.message,

                    'success'

                );

            }
            else
            {

                showToast(

                    result.message,

                    'warning'

                );

            }

        }
        catch(error)
        {

            console.error(error);



            showToast(

                'Unable to delete unit.',

                'danger'

            );

        }
        finally
        {

            button.disabled = false;

            button.innerHTML = originalHtml;

        }

    },



    /*
    |--------------------------------------------------------------------------
    | Toast Notification
    |--------------------------------------------------------------------------
    */

    showToast(message, type = 'success')
    {

        /*
        |--------------------------------------------------------------------------
        | Use Global Toast Helper
        |--------------------------------------------------------------------------
        */

        if(typeof showToast === 'function')
        {

            showToast(type, message);

            return;

        }



        /*
        |--------------------------------------------------------------------------
        | Fallback
        |--------------------------------------------------------------------------
        */

        alert(message);

    }

};



/*
|--------------------------------------------------------------------------
| Initialize
|--------------------------------------------------------------------------
*/

document.addEventListener(

    'DOMContentLoaded',

    () => {

        Units.init();

    }

);