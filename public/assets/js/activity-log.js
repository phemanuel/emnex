/*==========================================================
    EMNEX POS
    Activity Logs Module
==========================================================*/


const ActivityLogs = {


    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */


    tableWrapper: null,

    filterForm: null,

    searchInput: null,

    moduleFilter: null,

    actionFilter: null,

    inspector: null,

    debounceTimer: null,



    /*
    |--------------------------------------------------------------------------
    | Initialize
    |--------------------------------------------------------------------------
    */


    init() {


        this.cacheElements();


        this.bindEvents();


        this.bindPagination();


        this.bindInspector();


    },



    /*
    |--------------------------------------------------------------------------
    | Cache DOM Elements
    |--------------------------------------------------------------------------
    */


    cacheElements() {


        this.tableWrapper =
            document.getElementById(
                'activityLogTable'
            );


        this.filterForm =
            document.getElementById(
                'filterForm'
            );


        this.searchInput =
            document.getElementById(
                'searchLogs'
            );


        this.moduleFilter =
            document.getElementById(
                'filterModule'
            );


        this.actionFilter =
            document.getElementById(
                'filterAction'
            );


        this.inspector =
            document.getElementById(
                'activityLogInspector'
            );


    },



    /*
    |--------------------------------------------------------------------------
    | Bind Events
    |--------------------------------------------------------------------------
    */


    bindEvents() {


        if (!this.filterForm) {

            return;

        }



        /*
        |--------------------------------------------------------------------------
        | Module Filter
        |--------------------------------------------------------------------------
        */


        if (this.moduleFilter) {


            this.moduleFilter
                .addEventListener(
                    'change',
                    () => {

                        this.loadLogs();

                    }
                );


        }



        /*
        |--------------------------------------------------------------------------
        | Action Filter
        |--------------------------------------------------------------------------
        */


        if (this.actionFilter) {


            this.actionFilter
                .addEventListener(
                    'change',
                    () => {

                        this.loadLogs();

                    }
                );


        }




        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */


        if (this.searchInput) {


            this.searchInput
                .addEventListener(
                    'keyup',
                    () => {


                        clearTimeout(
                            this.debounceTimer
                        );


                        this.debounceTimer =
                            setTimeout(
                                () => {

                                    this.loadLogs();

                                },
                                500
                            );


                    }
                );


        }


    },



    /*
    |--------------------------------------------------------------------------
    | Load Logs Using AJAX
    |--------------------------------------------------------------------------
    */


    loadLogs(url = null) {

      console.log(
    'filterForm tag:',
    this.filterForm.tagName
);

console.log(
    'filterForm id:',
    this.filterForm.id
);

console.log(
    'filterForm action:',
    this.filterForm.getAttribute('action')
);

        let requestUrl;


        if (url) {


            requestUrl = url;


        } else {


            const formData =
                new FormData(
                    this.filterForm
                );


            const params =
                new URLSearchParams(
                    formData
                );


            requestUrl =
            `${this.filterForm.getAttribute('action')}?${params.toString()}`;


        }



        this.showLoading();



        fetch(
            requestUrl,
            {

                method:'GET',

                headers: {

                    'X-Requested-With':
                        'XMLHttpRequest',

                    'Accept':
                        'text/html'

                }

            }
        )


        .then(response => {


            if (!response.ok) {


                throw new Error(
                    'Failed loading activity logs'
                );


            }


            return response.text();


        })


        .then(html => {


            this.tableWrapper.innerHTML =
                html;


            this.bindPagination();


        })


        .catch(error => {


            console.error(
                'Activity Log Error:',
                error
            );


        });


    },



    /*
    |--------------------------------------------------------------------------
    | Pagination AJAX
    |--------------------------------------------------------------------------
    */


    bindPagination() {


        if (!this.tableWrapper) {

            return;

        }



        const links =
            this.tableWrapper
                .querySelectorAll(
                    '.pagination a'
                );



        links.forEach(link => {


            link.addEventListener(
                'click',
                event => {


                    event.preventDefault();


                    this.loadLogs(
                        link.href
                    );


                }
            );


        });


    },



    /*
    |--------------------------------------------------------------------------
    | Loading State
    |--------------------------------------------------------------------------
    */


    showLoading() {


        if (!this.tableWrapper) {

            return;

        }


        this.tableWrapper.classList.add(
            'loading'
        );


    },



    hideLoading() {


        if (!this.tableWrapper) {

            return;

        }


        this.tableWrapper.classList.remove(
            'loading'
        );


    },



    /*
    |--------------------------------------------------------------------------
    | Inspector
    |--------------------------------------------------------------------------
    */


    bindInspector() {


        window.ActivityLogs = this;


        document
            .querySelectorAll('.btn-inspect')
            .forEach(button => {


                button.addEventListener(
                    'click',
                    () => {


                        const id =
                            button.dataset.id;


                        this.openInspector(id);


                    }
                );


            });


    },

    /*
    |--------------------------------------------------------------------------
    | Open Inspector
    |--------------------------------------------------------------------------
    */


    openInspector(id) {


        const url =
            window.activityLogRoutes.show
                .replace(
                    ':id',
                    id
                );



        fetch(
            url,
            {

                headers: {

                    'X-Requested-With':
                        'XMLHttpRequest',

                    'Accept':
                        'application/json'

                }

            }
        )


        .then(response =>
            response.json()
        )


        .then(result => {


            if (!result.success) {


                showToast(
                    result.message,
                    'danger'
                );


                return;

            }



            this.renderInspector(
                result.data
            );



        })


        .catch(error => {


            console.error(
                error
            );


        });


    },



    /*
    |--------------------------------------------------------------------------
    | Render Inspector
    |--------------------------------------------------------------------------
    */


    renderInspector(log) {


    const panel =
        document.getElementById(
            'activityLogInspectorContent'
        );


    const template =
        document.getElementById(
            'activityLogInspectorTemplate'
        );


    const inspector =
        document.getElementById(
            'activityLogInspector'
        );


    if (!panel || !template || !inspector) {

        console.error(
            'Inspector elements missing'
        );

        return;

    }



    /*
    |--------------------------------------------------------------------------
    | Load Template
    |--------------------------------------------------------------------------
    */

    panel.innerHTML =
        template.innerHTML;



    /*
    |--------------------------------------------------------------------------
    | Populate Data
    |--------------------------------------------------------------------------
    */


    document.getElementById('logModule').innerHTML =
        log.module ?? '-';


    document.getElementById('logActionBadge').innerHTML =
        log.action ?? '-';


    document.getElementById('logDescription').innerHTML =
        log.description ?? '-';



    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */


    document.getElementById('logUser').innerHTML =
        log.user
            ? `${log.user.first_name ?? ''} ${log.user.last_name ?? ''}`
            : '-';


    document.getElementById('logEmail').innerHTML =
        log.user?.email ?? '-';



    /*
    |--------------------------------------------------------------------------
    | Branch / Terminal
    |--------------------------------------------------------------------------
    */


    document.getElementById('logBranch').innerHTML =
        log.branch?.name ?? '-';


    document.getElementById('logTerminal').innerHTML =
        log.terminal?.name ?? '-';



    /*
    |--------------------------------------------------------------------------
    | Record
    |--------------------------------------------------------------------------
    */


    document.getElementById('logRecordType').innerHTML =
        log.record_type ?? '-';


    document.getElementById('logRecordId').innerHTML =
        log.record_id ?? '-';



    /*
    |--------------------------------------------------------------------------
    | Date
    |--------------------------------------------------------------------------
    */


    if(log.created_at){


        const date =
            new Date(log.created_at);


        document.getElementById('logDate').innerHTML =
            date.toLocaleDateString();


        document.getElementById('logTime').innerHTML =
            date.toLocaleTimeString();


    }



    /*
    |--------------------------------------------------------------------------
    | Request
    |--------------------------------------------------------------------------
    */


    document.getElementById('logMethod').innerHTML =
        log.method ?? '-';


    document.getElementById('logUrl').innerHTML =
        log.url ?? '-';


    document.getElementById('logIp').innerHTML =
        log.ip_address ?? '-';


    document.getElementById('logUserAgent').innerHTML =
        log.user_agent ?? '-';



    /*
    |--------------------------------------------------------------------------
    | Changes
    |--------------------------------------------------------------------------
    */


    this.renderChanges(
        log.old_values,
        log.new_values
    );



    /*
    |--------------------------------------------------------------------------
    | Open Bootstrap Offcanvas
    |--------------------------------------------------------------------------
    */


    const offcanvas =
        bootstrap.Offcanvas.getOrCreateInstance(
            inspector
        );


    offcanvas.show();


},

formatValue(value) {


    if(value === null || value === undefined){

        return '-';

    }


    if(typeof value === 'boolean'){

        return value
            ? 'Yes'
            : 'No';

    }


    if(
        typeof value === 'object'
    ){

        return JSON.stringify(
            value
        );

    }


    return value;

},

formatFieldName(field){


    return field
        .replaceAll('_',' ')
        .replace(
            /\b\w/g,
            char => char.toUpperCase()
        );


},

renderChanges(oldValues, newValues){


    const tbody =
        document.getElementById(
            'changesTableBody'
        );


    if(!tbody){

        return;

    }



    tbody.innerHTML = '';



    const oldData =
        oldValues ?? {};


    const newData =
        newValues ?? {};



    const fields =
        new Set([
            ...Object.keys(oldData),
            ...Object.keys(newData)
        ]);



    fields.forEach(field => {


        const oldValue =
            this.formatValue(
                oldData[field]
            );


        const newValue =
            this.formatValue(
                newData[field]
            );



        if(oldValue === newValue){

            return;

        }



        tbody.innerHTML += `

            <tr>

                <td class="fw-semibold">

                    ${this.formatFieldName(field)}

                </td>


                <td class="text-danger">

                    ${oldValue}

                </td>


                <td class="text-success">

                    ${newValue}

                </td>

            </tr>

        `;


    });



},
    /*
    |--------------------------------------------------------------------------
    | Close Inspector
    |--------------------------------------------------------------------------
    */


    closeInspector() {


        if(this.inspector){


            this.inspector.classList.remove(
                'active'
            );


        }


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


        ActivityLogs.init();


    }
);