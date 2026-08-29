const PaymentModule = {

    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    state: {

        search:
            '',

        branchId:
            '',

        paymentMethod:
            '',

        paymentStatus:
            '',

        dateFrom:
            '',

        dateTo:
            '',

        page:
            1,

        perPage:
            10,

        selectedPaymentId:
            null,

        selectedPayment:
            null,

        searchTimer:
            null,

    },


    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    elements: {},


    /*
    |--------------------------------------------------------------------------
    | Init
    |--------------------------------------------------------------------------
    */

    init() {

        this.cacheElements();

        this.initializeComponents();

        this.bindEvents();

        this.loadTable();

    },


    /*
    |--------------------------------------------------------------------------
    | Cache Elements
    |--------------------------------------------------------------------------
    */

    cacheElements() {

        this.elements = {

            /*
            |--------------------------------------------------------------------------
            | Filters
            |--------------------------------------------------------------------------
            */

            search:
                document.getElementById(
                    'paymentSearch'
                ),

            branch:
                document.getElementById(
                    'paymentBranchFilter'
                ),

            method:
                document.getElementById(
                    'paymentMethodFilter'
                ),

            status:
                document.getElementById(
                    'paymentStatusFilter'
                ),

            dateFrom:
                document.getElementById(
                    'paymentDateFrom'
                ),

            dateTo:
                document.getElementById(
                    'paymentDateTo'
                ),


            /*
            |--------------------------------------------------------------------------
            | Actions
            |--------------------------------------------------------------------------
            */

            refresh:
                document.getElementById(
                    'refreshPayments'
                ),

            resetFilters:
                document.getElementById(
                    'resetPaymentFilters'
                ),


            /*
            |--------------------------------------------------------------------------
            | KPI
            |--------------------------------------------------------------------------
            */

            totalCount:
                document.getElementById(
                    'paymentTotalCount'
                ),

            completedCount:
                document.getElementById(
                    'paymentCompletedCount'
                ),

            pendingCount:
                document.getElementById(
                    'paymentPendingCount'
                ),

            totalAmount:
                document.getElementById(
                    'paymentTotalAmount'
                ),


            /*
            |--------------------------------------------------------------------------
            | Table
            |--------------------------------------------------------------------------
            */

            tableBody:
                document.getElementById(
                    'paymentsTableBody'
                ),

            pagination:
                document.getElementById(
                    'paymentPagination'
                ),

            paginationInfo:
                document.getElementById(
                    'paymentPaginationInfo'
                ),


             /*                                                                         |
            | -------------------------------------------------------------------------- |
            | Inspector                                                                  |
            | -------------------------------------------------------------------------- |
            | */    
            
            inspector:
            document.getElementById(
            'paymentInspector'
            ),

            inspectorLabel:
            document.getElementById(
            'paymentInspectorLabel'
            ),           

            inspectorStatus:
            document.getElementById(
            'paymentInspectorStatus'
            ),

            inspectorNumber:
            document.getElementById(
            'paymentInspectorNumber'
            ),

            inspectorOrderNumber:
            document.getElementById(
            'paymentInspectorOrderNumber'
            ),

            inspectorInvoiceNumber:
            document.getElementById(
            'paymentInspectorInvoiceNumber'
            ),

            inspectorCustomer:
            document.getElementById(
            'paymentInspectorCustomer'
            ),

            inspectorBranch:
            document.getElementById(
            'paymentInspectorBranch'
            ),

            inspectorTerminal:
            document.getElementById(
            'paymentInspectorTerminal'
            ),

            inspectorMethod:
            document.getElementById(
            'paymentInspectorMethod'
            ),

            inspectorDate:
            document.getElementById(
            'paymentInspectorDate'
            ),

            /*                                                                         |
            | -------------------------------------------------------------------------- |
            | Order & Payment Summary                                                    |
            | -------------------------------------------------------------------------- |
            | */                                                                         

            inspectorOrderTotal:
            document.getElementById(
            'paymentInspectorOrderTotal'
            ),

            inspectorAmountPaid:
            document.getElementById(
            'paymentInspectorAmountPaid'
            ),

            inspectorAmount:
            document.getElementById(
            'paymentInspectorAmount'
            ),

            inspectorBalance:
            document.getElementById(
            'paymentInspectorBalance'
            ),

            inspectorOrderStatus:
            document.getElementById(
            'paymentInspectorOrderStatus'
            ),

            /*                                                                         |
            | -------------------------------------------------------------------------- |
            | References                                                                 |
            | -------------------------------------------------------------------------- |
            | */                                                                         

            inspectorReference:
            document.getElementById(
            'paymentInspectorReference'
            ),

            inspectorTransactionReference:
            document.getElementById(
            'paymentInspectorTransactionReference'
            ),

            inspectorGateway:
            document.getElementById(
            'paymentInspectorGateway'
            ),

             /*                                                                         |
            | -------------------------------------------------------------------------- |
            | Remarks                                                                    |
            | -------------------------------------------------------------------------- |
            | */                                                                         

            inspectorRemarks:
            document.getElementById(
            'paymentInspectorRemarks'
            ),

            /*                                                                         |
            | -------------------------------------------------------------------------- |
            | Activity                                                                   |
            | -------------------------------------------------------------------------- |
            | */                                                                         

            inspectorReceivedBy:
            document.getElementById(
            'paymentInspectorReceivedBy'
            ),

            inspectorCreatedAt:
            document.getElementById(
            'paymentInspectorCreatedAt'
            ),

            inspectorUpdatedAt:
            document.getElementById(
            'paymentInspectorUpdatedAt'
            ),

             /*                                                                         |
            | -------------------------------------------------------------------------- |
            | Receipt                                                                    |
            | -------------------------------------------------------------------------- |
            | */                                                                         

            printReceipt:
            document.getElementById(
            'paymentPrintReceipt'
            ),

        };

    },


    /*
    |--------------------------------------------------------------------------
    | Initialize Components
    |--------------------------------------------------------------------------
    */

    initializeComponents() {

        if (
            this.elements.inspector
            && typeof bootstrap !== 'undefined'
        ) {

            this.inspector =
                bootstrap.Offcanvas.getOrCreateInstance(
                    this.elements.inspector
                );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Bind Events
    |--------------------------------------------------------------------------
    */

    bindEvents() {

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        this.elements.search?.addEventListener(
            'input',
            () => {

                clearTimeout(
                    this.state.searchTimer
                );


                this.state.searchTimer =
                    setTimeout(
                        () => {

                            this.state.search =
                                this.elements.search.value.trim();

                            this.state.page =
                                1;

                            this.loadTable();

                        },
                        350
                    );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Branch
        |--------------------------------------------------------------------------
        */

        this.elements.branch?.addEventListener(
            'change',
            () => {

                this.state.branchId =
                    this.elements.branch.value;

                this.state.page =
                    1;

                this.loadTable();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Method
        |--------------------------------------------------------------------------
        */

        this.elements.method?.addEventListener(
            'change',
            () => {

                this.state.paymentMethod =
                    this.elements.method.value;

                this.state.page =
                    1;

                this.loadTable();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        this.elements.status?.addEventListener(
            'change',
            () => {

                this.state.paymentStatus =
                    this.elements.status.value;

                this.state.page =
                    1;

                this.loadTable();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Date From
        |--------------------------------------------------------------------------
        */

        this.elements.dateFrom?.addEventListener(
            'change',
            () => {

                this.state.dateFrom =
                    this.elements.dateFrom.value;

                this.state.page =
                    1;

                this.loadTable();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Date To
        |--------------------------------------------------------------------------
        */

        this.elements.dateTo?.addEventListener(
            'change',
            () => {

                this.state.dateTo =
                    this.elements.dateTo.value;

                this.state.page =
                    1;

                this.loadTable();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Refresh
        |--------------------------------------------------------------------------
        */

        this.elements.refresh?.addEventListener(
            'click',
            () => {

                this.loadTable();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Reset
        |--------------------------------------------------------------------------
        */

        this.elements.resetFilters?.addEventListener(
            'click',
            () => {

                this.resetFilters();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Table Actions
        |--------------------------------------------------------------------------
        */

        this.elements.tableBody?.addEventListener(
            'click',
            (event) => {

                const viewButton =
                    event.target.closest(
                        '[data-payment-view]'
                    );


                if (viewButton) {

                    const id =
                        viewButton.dataset.paymentView;

                    this.openInspector(
                        id
                    );

                    return;

                }


                const printButton =
                    event.target.closest(
                        '[data-payment-print]'
                    );


                if (printButton) {

                    const id =
                        printButton.dataset.paymentPrint;

                    this.printReceipt(
                        id
                    );

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Print Inspector Receipt
        |--------------------------------------------------------------------------
        */

        this.elements.printReceipt?.addEventListener(
            'click',
            () => {

                if (
                    this.state.selectedPaymentId
                ) {

                    this.printReceipt(
                        this.state.selectedPaymentId
                    );

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        this.elements.pagination?.addEventListener(
            'click',
            (event) => {

                const button =
                    event.target.closest(
                        '[data-page]'
                    );


                if (!button) {

                    return;

                }


                const page =
                    parseInt(
                        button.dataset.page,
                        10
                    );


                if (
                    !Number.isInteger(page)
                    || page < 1
                    || page === this.state.page
                ) {

                    return;

                }


                this.state.page =
                    page;

                this.loadTable();

            }
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Load Table
    |--------------------------------------------------------------------------
    */

    async loadTable() {

        this.showTableLoading();


        try {

            const params =
                new URLSearchParams({

                    search:
                        this.state.search,

                    branch_id:
                        this.state.branchId,

                    payment_method:
                        this.state.paymentMethod,

                    payment_status:
                        this.state.paymentStatus,

                    date_from:
                        this.state.dateFrom,

                    date_to:
                        this.state.dateTo,

                    page:
                        this.state.page,

                    per_page:
                        this.state.perPage,

                });


            const response =
                await fetch(
                    `/sales/payments/table?${params.toString()}`,
                    {

                        headers: {

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',

                        },

                    }
                );


            const result =
                await response.json();


            if (
                !response.ok
                || !result.success
            ) {

                throw new Error(
                    result.message
                    ||
                    'Unable to load payments.'
                );

            }


            const data =
                result.data;


            this.updateKpis(
                data.stats
            );


            this.renderTable(
                data.payments
            );


            this.renderPagination(
                data.pagination
            );

        }
        catch (error) {

            console.error(
                'Payment table error:',
                error
            );


            this.showTableError(
                error.message
                ||
                'Unable to load payments.'
            );

        }

    },


   /*                                                                         |
    | -------------------------------------------------------------------------- |
    | Update KPIs                                                                |
    | -------------------------------------------------------------------------- |
    | */                                                                         

    updateKpis(stats) {


    if (!stats) {

        return;

    }


    if (
        this.elements.totalCount
    ) {

        this.elements.totalCount.textContent =
            this.formatNumber(
                stats.total_count
                ?? 0
            );

    }


    if (
        this.elements.completedCount
    ) {

        this.elements.completedCount.textContent =
            this.formatNumber(
                stats.completed_count
                ?? 0
            );

    }


    if (
        this.elements.pendingCount
    ) {

        this.elements.pendingCount.textContent =
            this.formatNumber(
                stats.pending_count
                ?? 0
            );

    }


    if (
        this.elements.totalAmount
    ) {

        this.elements.totalAmount.textContent =
            this.formatCurrency(
                stats.total_amount
                ?? 0
            );

    }


    },



    /*
    |--------------------------------------------------------------------------
    | Render Table
    |--------------------------------------------------------------------------
    */

    renderTable(payments) {

        if (
            !this.elements.tableBody
        ) {

            return;

        }


        if (
            !payments
            || !payments.length
        ) {

            this.elements.tableBody.innerHTML = `

                <tr>

                    <td
                        colspan="8"
                        class="text-center py-5"
                    >

                        <div class="text-muted">

                            <i class="bi bi-credit-card fs-3 d-block mb-2"></i>

                            No payments found.

                        </div>

                    </td>

                </tr>

            `;

            return;

        }


        this.elements.tableBody.innerHTML =
            payments.map(
                payment =>
                    this.renderTableRow(
                        payment
                    )
            ).join('');

    },


    /*                                                                         |
    | -------------------------------------------------------------------------- |
    | Render Table Row                                                           |
    | -------------------------------------------------------------------------- |
    | */                                                                         

    renderTableRow(payment) {

   
    const orderStatus =
        this.renderStatusBadge(
            payment.order_status
            ?? '—'
        );


    const paymentStatus =
        this.renderStatusBadge(
            payment.payment_status
            ?? '—'
        );


    return `

        <tr>            

            <td class="ps-4">

                <div class="fw-semibold">

                    ${this.escapeHtml(
                        payment.payment_number
                        ?? '—'
                    )}

                </div>


                ${
                    payment.reference_no
                        ? `
                            <div class="text-muted small">

                                ${this.escapeHtml(
                                    payment.reference_no
                                )}

                            </div>
                        `
                        : ''
                }

            </td>


            <td>

                ${
                    payment.order_no
                        ? `
                            <div class="fw-medium">

                                ${this.escapeHtml(
                                    payment.order_no
                                )}

                            </div>
                        `
                        : '—'
                }

            </td>


            <td>

                <div class="fw-medium">

                    ${this.escapeHtml(
                        payment.customer
                        ?? 'Walk-in Customer'
                    )}

                </div>

            </td>


            <td>

                <span class="fw-medium">

                    ${this.formatCurrency(
                        payment.order_total
                        ?? 0
                    )}

                </span>

            </td>

            <td>

                <span class="text-muted">

                    ${this.formatCurrency(
                        payment.amount_paid
                        ?? 0
                    )}

                </span>

            </td>


            <td>

                <span class="fw-semibold">

                    ${this.formatCurrency(
                        payment.amount
                        ?? 0
                    )}

                </span>


                <div class="text-muted small">

                    ${this.escapeHtml(
                        payment.payment_method
                        ?? '—'
                    )}

                </div>

            </td>

            <td>

                <span class="${
                    Number(payment.balance ?? 0) > 0
                        ? 'text-warning fw-semibold'
                        : 'text-success fw-semibold'
                }">

                    ${this.formatCurrency(
                        payment.balance
                        ?? 0
                    )}

                </span>

            </td>

            <td>

                ${orderStatus}

            </td>


            <td>

                ${paymentStatus}

            </td>


            <td>

                <div>

                    ${this.formatDate(
                        payment.payment_date
                    )}

                </div>

            </td>

            <td class="text-end pe-4">

                <div class="dropdown">

                    <button
                        type="button"
                        class="btn btn-light btn-sm"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >

                        <i class="bi bi-three-dots"></i>

                    </button>


                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>

                            <button
                                type="button"
                                class="dropdown-item"
                                data-payment-view="${payment.id}"
                            >

                                <i class="bi bi-eye me-2"></i>

                                View

                            </button>

                        </li>


                        <li>

                            <button
                                type="button"
                                class="dropdown-item"
                                data-payment-print="${payment.id}"
                            >

                                <i class="bi bi-printer me-2"></i>

                                Print Receipt

                            </button>

                        </li>

                    </ul>

                </div>

            </td>

        </tr>

    `;


    },



    /*
    |--------------------------------------------------------------------------
    | Open Inspector
    |--------------------------------------------------------------------------
    */

    async openInspector(id) {

        this.state.selectedPaymentId =
            id;


        this.resetInspector();


        try {

            const response =
                await fetch(
                    `/sales/payments/${id}/details`,
                    {

                        headers: {

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',

                        },

                    }
                );


            const result =
                await response.json();


            if (
                !response.ok
                || !result.success
            ) {

                throw new Error(
                    result.message
                    ||
                    'Payment could not be identified.'
                );

            }


            const payment =
                result.data;


            this.state.selectedPayment =
                payment;


            this.populateInspector(
                payment
            );


            if (
                this.inspector
            ) {

                this.inspector.show();

            }

        }
        catch (error) {

            console.error(
                'Payment inspector error:',
                error
            );


            this.showError(
                error.message
                ||
                'Unable to load payment details.'
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Reset Inspector
    |--------------------------------------------------------------------------
    */

    resetInspector() {

        const values = [

            'inspectorStatus',

            'inspectorNumber',

            'inspectorOrderNumber',

            'inspectorInvoiceNumber',

            'inspectorCustomer',

            'inspectorBranch',

            'inspectorTerminal',

            'inspectorMethod',

            'inspectorDate',

            'inspectorAmount',

            'inspectorReference',

            'inspectorTransactionReference',

            'inspectorGateway',

            'inspectorRemarks',

            'inspectorReceivedBy',

            'inspectorCreatedAt',

            'inspectorUpdatedAt',

        ];


        values.forEach(
            key => {

                if (
                    this.elements[key]
                ) {

                    this.elements[key].textContent =
                        key === 'inspectorAmount'
                            ? '₦0.00'
                            : '—';

                }

            }
        );

    },


   /*                                                                         |
    | -------------------------------------------------------------------------- |
    | Populate Inspector                                                         |
    | -------------------------------------------------------------------------- |
    | */                                                                         

    populateInspector(payment) {        
    
    /*
    |--------------------------------------------------------------------------
    | Payment Status
    |--------------------------------------------------------------------------
    */

    /*                                                                         |
    | -------------------------------------------------------------------------- |
    | Inspector Header                                                           |
    | -------------------------------------------------------------------------- |
    | */                                                                         

    if (
    this.elements.inspectorLabel
    ) {
    
    this.elements.inspectorLabel.textContent =
        payment.payment_number
        ?? '—';  

    }


    if (
        this.elements.inspectorStatus
    ) {

        this.elements.inspectorStatus.textContent =
            payment.payment_status
            ?? '—';


        this.elements.inspectorStatus.className =
            `badge ${this.getStatusClass(
                payment.payment_status
            )}`;

    }


    /*
    |--------------------------------------------------------------------------
    | Payment Number
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorNumber
    ) {

        this.elements.inspectorNumber.textContent =
            payment.payment_number
            ?? '—';

    }


    /*
    |--------------------------------------------------------------------------
    | Order Number
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorOrderNumber
    ) {

        this.elements.inspectorOrderNumber.textContent =
            payment.order?.order_no
            ?? '—';

    }


    /*
    |--------------------------------------------------------------------------
    | Invoice Number
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorInvoiceNumber
    ) {

        this.elements.inspectorInvoiceNumber.textContent =
            payment.order?.invoice_no
            ?? '—';

    }


    /*
    |--------------------------------------------------------------------------
    | Customer
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorCustomer
    ) {

        this.elements.inspectorCustomer.textContent =
            payment.customer?.name
            ?? 'Walk-in Customer';

    }


    /*
    |--------------------------------------------------------------------------
    | Branch
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorBranch
    ) {

        this.elements.inspectorBranch.textContent =
            payment.branch?.name
            ?? '—';

    }


    /*
    |--------------------------------------------------------------------------
    | Terminal
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorTerminal
    ) {

        this.elements.inspectorTerminal.textContent =
            payment.terminal?.name
            ?? '—';

    }


    /*
    |--------------------------------------------------------------------------
    | Payment Method
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorMethod
    ) {

        this.elements.inspectorMethod.textContent =
            payment.payment_method
            ?? '—';

    }


    /*
    |--------------------------------------------------------------------------
    | Payment Date
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorDate
    ) {

        this.elements.inspectorDate.textContent =
            this.formatDate(
                payment.payment_date,
                true
            );

    }


    /*
    |--------------------------------------------------------------------------
    | Order Total
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorOrderTotal
    ) {

        this.elements.inspectorOrderTotal.textContent =
            this.formatCurrency(
                payment.order?.order_total
                ?? 0
            );

    }


    /*
    |--------------------------------------------------------------------------
    | Amount Paid
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorAmountPaid
    ) {

        this.elements.inspectorAmountPaid.textContent =
            this.formatCurrency(
                payment.order?.amount_paid
                ?? 0
            );

    }


    /*
    |--------------------------------------------------------------------------
    | This Payment
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorAmount
    ) {

        this.elements.inspectorAmount.textContent =
            this.formatCurrency(
                payment.amount
                ?? 0
            );

    }


    /*
    |--------------------------------------------------------------------------
    | Balance
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorBalance
    ) {

        this.elements.inspectorBalance.textContent =
            this.formatCurrency(
                payment.order?.balance
                ?? 0
            );

    }


    /*
    |--------------------------------------------------------------------------
    | Order Status
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorOrderStatus
    ) {

        this.elements.inspectorOrderStatus.textContent =
            payment.order?.order_status
            ?? '—';


        this.elements.inspectorOrderStatus.className =
            `badge ${this.getStatusClass(
                payment.order?.order_status
            )}`;

    }


    /*
    |--------------------------------------------------------------------------
    | References
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorReference
    ) {

        this.elements.inspectorReference.textContent =
            payment.reference_no
            ?? '—';

    }


    if (
        this.elements.inspectorTransactionReference
    ) {

        this.elements.inspectorTransactionReference.textContent =
            payment.transaction_reference
            ?? '—';

    }


    if (
        this.elements.inspectorGateway
    ) {

        this.elements.inspectorGateway.textContent =
            payment.payment_gateway
            ?? '—';

    }


    /*
    |--------------------------------------------------------------------------
    | Remarks
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorRemarks
    ) {

        this.elements.inspectorRemarks.textContent =
            payment.remarks
            ?? '—';

    }


    /*
    |--------------------------------------------------------------------------
    | Received By
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorReceivedBy
    ) {

        this.elements.inspectorReceivedBy.textContent =
            payment.received_by?.name
            ?? '—';

    }


    /*
    |--------------------------------------------------------------------------
    | Created At
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorCreatedAt
    ) {

        this.elements.inspectorCreatedAt.textContent =
            this.formatDate(
                payment.created_at,
                true
            );

    }


    /*
    |--------------------------------------------------------------------------
    | Updated At
    |--------------------------------------------------------------------------
    */

    if (
        this.elements.inspectorUpdatedAt
    ) {

        this.elements.inspectorUpdatedAt.textContent =
            this.formatDate(
                payment.updated_at,
                true
            );

    }


    },


    /*
    |--------------------------------------------------------------------------
    | Print Receipt
    |--------------------------------------------------------------------------
    */

    printReceipt(id) {

        if (!id) {

            return;

        }


        window.open(
            `/sales/payments/${id}/receipt`,
            '_blank'
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    renderPagination(pagination) {

        if (
            !this.elements.pagination
            || !pagination
        ) {

            return;

        }


        const current =
            parseInt(
                pagination.current_page,
                10
            );


        const last =
            parseInt(
                pagination.last_page,
                10
            );


        const total =
            parseInt(
                pagination.total,
                10
            );


        if (
            this.elements.paginationInfo
        ) {

            if (!total) {

                this.elements.paginationInfo.textContent =
                    'No payments';

            }
            else {

                const from =
                    (
                        (
                            current - 1
                        )
                        *
                        pagination.per_page
                    ) + 1;


                const to =
                    Math.min(
                        current *
                        pagination.per_page,
                        total
                    );


                this.elements.paginationInfo.textContent =
                    `Showing ${from}–${to} of ${total}`;

            }

        }


        if (
            last <= 1
        ) {

            this.elements.pagination.innerHTML =
                '';

            return;

        }


        let html = '';


        html += `

            <button
                type="button"
                class="btn btn-light btn-sm"
                data-page="${current - 1}"
                ${current <= 1 ? 'disabled' : ''}
            >

                <i class="bi bi-chevron-left"></i>

            </button>

        `;


        for (
            let page = 1;
            page <= last;
            page++
        ) {

            if (
                last > 7
                &&
                page > 2
                &&
                page < last - 1
                &&
                Math.abs(page - current) > 1
            ) {

                if (
                    page === 3
                ) {

                    html += `
                        <span class="px-1 text-muted">
                            …
                        </span>
                    `;

                }

                continue;

            }


            html += `

                <button
                    type="button"
                    class="btn btn-sm ${
                        page === current
                            ? 'btn-primary'
                            : 'btn-light'
                    }"
                    data-page="${page}"
                >

                    ${page}

                </button>

            `;

        }


        html += `

            <button
                type="button"
                class="btn btn-light btn-sm"
                data-page="${current + 1}"
                ${current >= last ? 'disabled' : ''}
            >

                <i class="bi bi-chevron-right"></i>

            </button>

        `;


        this.elements.pagination.innerHTML =
            html;

    },


    /*
    |--------------------------------------------------------------------------
    | Reset Filters
    |--------------------------------------------------------------------------
    */

    resetFilters() {

        this.state.search =
            '';

        this.state.branchId =
            '';

        this.state.paymentMethod =
            '';

        this.state.paymentStatus =
            '';

        this.state.dateFrom =
            '';

        this.state.dateTo =
            '';

        this.state.page =
            1;


        if (
            this.elements.search
        ) {

            this.elements.search.value =
                '';

        }


        if (
            this.elements.branch
        ) {

            this.elements.branch.value =
                '';

        }


        if (
            this.elements.method
        ) {

            this.elements.method.value =
                '';

        }


        if (
            this.elements.status
        ) {

            this.elements.status.value =
                '';

        }


        if (
            this.elements.dateFrom
        ) {

            this.elements.dateFrom.value =
                '';

        }


        if (
            this.elements.dateTo
        ) {

            this.elements.dateTo.value =
                '';

        }


        this.loadTable();

    },


    /*
    |--------------------------------------------------------------------------
    | Loading State
    |--------------------------------------------------------------------------
    */

    showTableLoading() {

        if (
            !this.elements.tableBody
        ) {

            return;

        }


        this.elements.tableBody.innerHTML = `

            <tr>

                <td
                    colspan="8"
                    class="text-center py-5"
                >

                    <div class="text-muted">

                        <span
                            class="spinner-border spinner-border-sm me-2"
                        ></span>

                        Loading payments...

                    </div>

                </td>

            </tr>

        `;

    },


    /*
    |--------------------------------------------------------------------------
    | Error State
    |--------------------------------------------------------------------------
    */

    showTableError(message) {

        if (
            !this.elements.tableBody
        ) {

            return;

        }


        this.elements.tableBody.innerHTML = `

            <tr>

                <td
                    colspan="8"
                    class="text-center py-5"
                >

                    <div class="text-danger">

                        <i class="bi bi-exclamation-circle fs-4 d-block mb-2"></i>

                        ${this.escapeHtml(
                            message
                        )}

                    </div>

                </td>

            </tr>

        `;

    },


    /*
    |--------------------------------------------------------------------------
    | Status Badge
    |--------------------------------------------------------------------------
    */

    renderStatusBadge(status) {

        return `

            <span
                class="badge ${this.getStatusClass(status)}"
            >

                ${this.escapeHtml(
                    status
                    ?? '—'
                )}

            </span>

        `;

    },


    getStatusClass(status) {

        switch (
            String(
                status
                ?? ''
            ).toLowerCase()
        ) {

            case 'completed':

                return 'bg-success-subtle text-success';


            case 'pending':

                return 'bg-warning-subtle text-warning';


            case 'failed':

                return 'bg-danger-subtle text-danger';


            case 'cancelled':

                return 'bg-secondary-subtle text-secondary';


            case 'refunded':

                return 'bg-info-subtle text-info';


            default:

                return 'bg-secondary-subtle text-secondary';

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Format Currency
    |--------------------------------------------------------------------------
    */

    formatCurrency(value) {

        const amount =
            Number(
                value
            ) || 0;


        return (
            '₦' +
            amount.toLocaleString(
                'en-NG',
                {

                    minimumFractionDigits:
                        2,

                    maximumFractionDigits:
                        2,

                }
            )
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Format Number
    |--------------------------------------------------------------------------
    */

    formatNumber(value) {

        return Number(
            value
        || 0
        ).toLocaleString(
            'en-NG'
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Format Date
    |--------------------------------------------------------------------------
    */

    formatDate(
        value,
        withTime = false
    ) {

        if (!value) {

            return '—';

        }


        const date =
            new Date(
                value
            );


        if (
            Number.isNaN(
                date.getTime()
            )
        ) {

            return '—';

        }


        const options = {

            day:
                '2-digit',

            month:
                'short',

            year:
                'numeric',

        };


        if (
            withTime
        ) {

            options.hour =
                '2-digit';

            options.minute =
                '2-digit';

        }


        return date.toLocaleString(
            'en-GB',
            options
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Escape HTML
    |--------------------------------------------------------------------------
    */

    escapeHtml(value) {

        const div =
            document.createElement(
                'div'
            );


        div.textContent =
            value
            ?? '';


        return div.innerHTML;

    },


    /*
    |--------------------------------------------------------------------------
    | Toast / Error
    |--------------------------------------------------------------------------
    */

    showError(message) {

        if (
            typeof window.showToast ===
            'function'
        ) {

            window.showToast(
                message,
                'danger'
            );

            return;

        }


        console.error(
            message
        );

    },

};


/*
|--------------------------------------------------------------------------
| Initialize
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    () => {

        PaymentModule.init();

    }
);