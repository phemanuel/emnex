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


        window.ActivityLogs =
            this;


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
                'activityLogInspectorBody'
            );


        if (!panel) {

            return;

        }



        panel.innerHTML = `

            <div class="inspector-section">

                <label>Module</label>

                <strong>
                    ${log.module ?? '-'}
                </strong>

            </div>


            <div class="inspector-section">

                <label>Action</label>

                <strong>
                    ${log.action ?? '-'}
                </strong>

            </div>


            <div class="inspector-section">

                <label>Description</label>

                <p>
                    ${log.description ?? '-'}
                </p>

            </div>


        `;



        this.inspector.classList.add(
            'active'
        );


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