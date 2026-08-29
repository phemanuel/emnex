
/*
|--------------------------------------------------------------------------
| EMNEX POS - Sales Invoices
|--------------------------------------------------------------------------
*/

const InvoiceModule = {

    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    state: {

        page:
            1,

        perPage:
            10,

        search:
            '',

        branchId:
            '',

        orderStatus:
            '',

        paymentStatus:
            '',

        dateFrom:
            '',

        dateTo:
            '',

        searchTimer:
            null,

        selectedInvoiceId:
            null,

        selectedOrderId:
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
    | Initialize
    |--------------------------------------------------------------------------
    */

    init() {

        this.cacheElements();     

        this.bindEvents();

        this.loadStats();

        this.loadTable();

    },


    /*
|--------------------------------------------------------------------------
| Cache Elements
|--------------------------------------------------------------------------
*/

cacheElements()
{

    this.elements = {
     
        /*
        |--------------------------------------------------------------------------
        | KPI
        |--------------------------------------------------------------------------
        */

        draftCount:
            document.getElementById(
                'invoiceDraftCount'
            ),

        heldCount:
            document.getElementById(
                'invoiceHeldCount'
            ),

        totalValue:
            document.getElementById(
                'invoiceTotalValue'
            ),

        outstandingBalance:
            document.getElementById(
                'invoiceOutstandingBalance'
            ),


        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */

        search:
            document.getElementById(
                'invoiceSearch'
            ),

        branch:
            document.getElementById(
                'invoiceBranchFilter'
            ),

        orderStatus:
            document.getElementById(
                'invoiceStatusFilter'
            ),

        paymentStatus:
            document.getElementById(
                'invoicePaymentStatusFilter'
            ),

        dateFrom:
            document.getElementById(
                'invoiceDateFrom'
            ),

        dateTo:
            document.getElementById(
                'invoiceDateTo'
            ),

        resetFilters:
            document.getElementById(
                'resetInvoiceFilters'
            ),

        refresh:
            document.getElementById(
                'refreshInvoices'
            ),


        /*
        |--------------------------------------------------------------------------
        | Table
        |--------------------------------------------------------------------------
        */

        tableBody:
            document.getElementById(
                'invoicesTableBody'
            ),

        paginationInfo:
            document.getElementById(
                'invoicePaginationInfo'
            ),

        pagination:
            document.getElementById(
                'invoicePagination'
            ),


       /*
|--------------------------------------------------------------------------
| Inspector
|--------------------------------------------------------------------------
*/

inspector:
    document.getElementById(
        'invoiceInspector'
    ),

inspectorLabel:
    document.getElementById(
        'invoiceInspectorLabel'
    ),

inspectorOrderStatus:
    document.getElementById(
        'invoiceInspectorOrderStatus'
    ),

inspectorPaymentStatus:
    document.getElementById(
        'invoiceInspectorPaymentStatus'
    ),

inspectorNumber:
    document.getElementById(
        'invoiceInspectorNumber'
    ),

inspectorOrderNumber:
    document.getElementById(
        'invoiceInspectorOrderNumber'
    ),

inspectorCustomer:
    document.getElementById(
        'invoiceInspectorCustomer'
    ),

inspectorBranch:
    document.getElementById(
        'invoiceInspectorBranch'
    ),

inspectorTerminal:
    document.getElementById(
        'invoiceInspectorTerminal'
    ),

inspectorDate:
    document.getElementById(
        'invoiceInspectorDate'
    ),

inspectorItems:
    document.getElementById(
        'invoiceInspectorItems'
    ),

inspectorItemCount:
    document.getElementById(
        'invoiceInspectorItemCount'
    ),

inspectorQuantity:
    document.getElementById(
        'invoiceInspectorQuantity'
    ),

inspectorSubtotal:
    document.getElementById(
        'invoiceInspectorSubtotal'
    ),

inspectorDiscount:
    document.getElementById(
        'invoiceInspectorDiscount'
    ),

inspectorTax:
    document.getElementById(
        'invoiceInspectorTax'
    ),

inspectorTotal:
    document.getElementById(
        'invoiceInspectorTotal'
    ),

inspectorAmountPaid:
    document.getElementById(
        'invoiceInspectorAmountPaid'
    ),

inspectorBalance:
    document.getElementById(
        'invoiceInspectorBalance'
    ),

inspectorChange:
    document.getElementById(
        'invoiceInspectorChange'
    ),

inspectorRemarks:
    document.getElementById(
        'invoiceInspectorRemarks'
    ),

inspectorCreatedBy:
    document.getElementById(
        'invoiceInspectorCreatedBy'
    ),

inspectorCreatedAt:
    document.getElementById(
        'invoiceInspectorCreatedAt'
    ),

inspectorUpdatedBy:
    document.getElementById(
        'invoiceInspectorUpdatedBy'
    ),

inspectorUpdatedAt:
    document.getElementById(
        'invoiceInspectorUpdatedAt'
    ),

goToOrder:
    document.getElementById(
        'invoiceGoToOrder'
    ),

    };

},


    /*
    |--------------------------------------------------------------------------
    | Bind Events
    |--------------------------------------------------------------------------
    */

    bindEvents() {

        /*
        |----------------------------------------------------------------------
        | Search
        |----------------------------------------------------------------------
        */

        this.elements.search
            ?.addEventListener(
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
        |----------------------------------------------------------------------
        | Branch
        |----------------------------------------------------------------------
        */

        this.elements.branch
            ?.addEventListener(
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
        |----------------------------------------------------------------------
        | Order Status
        |----------------------------------------------------------------------
        */

        this.elements.orderStatus
            ?.addEventListener(
                'change',
                () => {

                    this.state.orderStatus =
                        this.elements.orderStatus.value;

                    this.state.page =
                        1;

                    this.loadTable();

                }
            );


        /*
        |----------------------------------------------------------------------
        | Payment Status
        |----------------------------------------------------------------------
        */

        this.elements.paymentStatus
            ?.addEventListener(
                'change',
                () => {

                    this.state.paymentStatus =
                        this.elements.paymentStatus.value;

                    this.state.page =
                        1;

                    this.loadTable();

                }
            );


        /*
        |----------------------------------------------------------------------
        | Date From
        |----------------------------------------------------------------------
        */

        this.elements.dateFrom
            ?.addEventListener(
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
        |----------------------------------------------------------------------
        | Date To
        |----------------------------------------------------------------------
        */

        this.elements.dateTo
            ?.addEventListener(
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
        |----------------------------------------------------------------------
        | Reset Filters
        |----------------------------------------------------------------------
        */

        this.elements.resetFilters
            ?.addEventListener(
                'click',
                () => {

                    this.resetFilters();

                }
            );


        /*
        |----------------------------------------------------------------------
        | Refresh
        |----------------------------------------------------------------------
        */

        this.elements.refresh
            ?.addEventListener(
                'click',
                () => {

                    this.refresh();

                }
            );


        /*
|--------------------------------------------------------------------------
| Table Actions
|--------------------------------------------------------------------------
*/

this.elements.tableBody
    ?.addEventListener(
        'click',
        event => {

            const button =
                event.target.closest(
                    '.invoice-action-btn'
                );


            if (!button) {

                return;

            }


            const action =
                button.getAttribute(
                    'data-invoice-action'
                );


            const invoiceId =
                button.getAttribute(
                    'data-invoice-id'
                );


            const orderId =
                button.getAttribute(
                    'data-order-id'
                );


            console.log(
                'INVOICE ACTION',
                {
                    action:
                        action,

                    invoiceId:
                        invoiceId,

                    orderId:
                        orderId,

                    button:
                        button
                }
            );


            /*
            |--------------------------------------------------------------------------
            | View
            |--------------------------------------------------------------------------
            */

            if (
                action === 'view'
            ) {

                if (!invoiceId) {

                    this.notify(
                        'Invoice could not be identified.',
                        'warning'
                    );

                    return;

                }


                this.openInvoiceInspector(
                    invoiceId
                );

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | Print
            |--------------------------------------------------------------------------
            */

            if (
                action === 'print'
            ) {

                if (!invoiceId) {

                    this.notify(
                        'Invoice could not be identified.',
                        'warning'
                    );

                    return;

                }


                this.printInvoice(
                    invoiceId
                );

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | Finalize
            |--------------------------------------------------------------------------
            */

            if (
                action === 'finalize'
            ) {

                if (!orderId) {

                    this.notify(
                        'Sales order could not be identified.',
                        'warning'
                    );

                    return;

                }


                this.openOrder(
                    orderId
                );

                return;

            }

        }
    );


        /*
        |----------------------------------------------------------------------
        | Pagination
        |----------------------------------------------------------------------
        */

        this.elements.pagination
            ?.addEventListener(
                'click',
                event => {

                    const button =
                        event.target.closest(
                            '[data-page]'
                        );


                    if (!button) {

                        return;

                    }


                    if (
                        button.disabled
                    ) {

                        return;

                    }


                    const page =
                        parseInt(
                            button.dataset.page,
                            10
                        );


                    if (
                        !page ||
                        page === this.state.page
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
    | Load Statistics
    |--------------------------------------------------------------------------
    */

    async loadStats() {

        try {

            const response =
                await fetch(
                    '/sales/invoices/stats',
                    {

                        method:
                            'GET',

                        headers: {

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest'

                        }

                    }
                );


            const result =
                await response.json();


            if (
                !response.ok ||
                !result.success
            ) {

                throw new Error(
                    result.message ??
                    'Unable to load invoice statistics.'
                );

            }


            this.updateStats(
                result.data ?? {}
            );

        }
        catch (error) {

            console.error(
                'Invoice statistics error:',
                error
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Update Statistics
    |--------------------------------------------------------------------------
    */

    updateStats(
        stats = {}
    ) {

        if (
            this.elements.draftCount
        ) {

            this.elements.draftCount.textContent =
                this.formatNumber(
                    stats.draft_count ??
                    0
                );

        }


        if (
            this.elements.heldCount
        ) {

            this.elements.heldCount.textContent =
                this.formatNumber(
                    stats.held_count ??
                    0
                );

        }


        if (
            this.elements.totalValue
        ) {

            this.elements.totalValue.textContent =
                this.formatMoney(
                    stats.invoice_value ??
                    0
                );

        }


        if (
            this.elements.outstandingBalance
        ) {

            this.elements.outstandingBalance.textContent =
                this.formatMoney(
                    stats.outstanding_balance ??
                    0
                );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Load Table
    |--------------------------------------------------------------------------
    */

    async loadTable() {

        if (
            this.elements.tableBody
        ) {

            this.elements.tableBody.innerHTML = `

                <tr>

                    <td
                        colspan="10"
                        class="text-center py-5"
                    >

                        <div class="text-muted">

                            <div
                                class="spinner-border spinner-border-sm me-2"
                                role="status"
                            ></div>

                            Loading invoices...

                        </div>

                    </td>

                </tr>

            `;

        }


        try {

            const params =
                new URLSearchParams({

                    page:
                        this.state.page,

                    per_page:
                        this.state.perPage,

                    search:
                        this.state.search,

                    branch_id:
                        this.state.branchId,

                    order_status:
                        this.state.orderStatus,

                    payment_status:
                        this.state.paymentStatus,

                    date_from:
                        this.state.dateFrom,

                    date_to:
                        this.state.dateTo,

                });


            const response =
                await fetch(
                    `/sales/invoices/table?${params.toString()}`,
                    {

                        method:
                            'GET',

                        headers: {

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest'

                        }

                    }
                );


            const result =
                await response.json();


            if (
                !response.ok ||
                !result.success
            ) {

                throw new Error(
                    result.message ??
                    'Unable to load invoices.'
                );

            }


            this.state.invoices =
                result.data ?? [];


            this.renderTable(
                this.state.invoices
            );


            this.renderPagination(
                result.pagination ??
                {}
            );

        }
        catch (error) {

            console.error(
                'Invoice table error:',
                error
            );


            if (
                this.elements.tableBody
            ) {

                this.elements.tableBody.innerHTML = `

                    <tr>

                        <td
                            colspan="10"
                            class="text-center py-5"
                        >

                            <div class="text-danger">

                                <i class="bi bi-exclamation-circle me-1"></i>

                                Unable to load invoices.

                            </div>

                        </td>

                    </tr>

                `;

            }

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Render Table
    |--------------------------------------------------------------------------
    */

    renderTable(
        invoices = []
    ) {

        const container =
            this.elements.tableBody;


        if (!container) {

            return;

        }


        if (
            !invoices.length
        ) {

            container.innerHTML = `

                <tr>

                    <td
                        colspan="10"
                        class="text-center py-5"
                    >

                        <div class="text-muted">

                            <i class="bi bi-receipt fs-3 d-block mb-2"></i>

                            No invoices found.

                        </div>

                    </td>

                </tr>

            `;

            return;

        }


        container.innerHTML =
            invoices
                .map(
                    invoice =>
                        this.renderInvoiceRow(
                            invoice
                        )
                )
                .join('');

    },


    /*
    |--------------------------------------------------------------------------
    | Render Invoice Row
    |--------------------------------------------------------------------------
    */

    renderInvoiceRow(
        invoice
    ) {

        const total =
            parseFloat(
                invoice.total ??
                invoice.grand_total
            ) || 0;


        const amountPaid =
            parseFloat(
                invoice.amount_paid
            ) || 0;


        const balance =
            parseFloat(
                invoice.balance
            ) || 0;


        const orderStatus =
            invoice.order_status ??
            '—';


        const paymentStatus =
            invoice.payment_status ??
            '—';


        const invoiceId =
            invoice.id ??
            '';


        const orderId =
            invoice.order_id ??
            '';


        return `

            <tr>

                <td>

                    <div class="fw-semibold">

                        ${this.escapeHtml(
                            invoice.invoice_no ??
                            '—'
                        )}

                    </div>


                    <div class="text-muted small">

                        ${this.formatDate(
                            invoice.invoice_date ??
                            invoice.created_at
                        )}

                    </div>

                </td>


                <td>

                    <div class="fw-semibold">

                        ${this.escapeHtml(
                            invoice.order_no ??
                            '—'
                        )}

                    </div>

                </td>


                <td>

                    ${this.escapeHtml(
                        invoice.customer?.name ??
                        'Walk-in Customer'
                    )}

                </td>


                <td>

                    ${this.escapeHtml(
                        invoice.branch?.name ??
                        '—'
                    )}

                </td>


                <td class="fw-semibold">

                    ${this.formatMoney(
                        total
                    )}

                </td>


                <td>

                    ${this.formatMoney(
                        amountPaid
                    )}

                </td>


                <td>

                    <span class="${
                        balance > 0
                            ? 'text-danger fw-semibold'
                            : 'text-muted'
                    }">

                        ${this.formatMoney(
                            balance
                        )}

                    </span>

                </td>


                <td>

                    ${this.renderPaymentStatus(
                        paymentStatus
                    )}

                </td>


                <td>

                    ${this.renderOrderStatus(
                        orderStatus
                    )}

                </td>


                <td class="text-end">

                    <div class="d-flex justify-content-end gap-2">

                        <button
                            type="button"
                            class="btn btn-outline-primary btn-sm invoice-action-btn"
                            data-invoice-action="view"
                            data-invoice-id="${invoice.id}"
                            title="View invoice details"
                        >

                            <i class="bi bi-eye"></i>

                        </button>

                        <button
                            type="button"
                            class="btn btn-outline-secondary btn-sm invoice-action-btn"
                            data-invoice-action="print"
                            data-invoice-id="${invoice.id}"
                            title="Print invoice"
                        >

                            <i class="bi bi-printer"></i>

                        </button>


                        <button
                            type="button"
                            class="btn btn-outline-success btn-sm invoice-action-btn"
                            data-invoice-action="finalize"
                            data-invoice-id="${invoice.id}"
                            data-order-id="${invoice.order_id ?? invoice.order?.id ?? ''}"
                            title="Finalize order"
                        >

                            <i class="bi bi-check2-circle"></i>

                        </button>

                    </div>

                </td>
            </tr>

        `;

    },


    /*
    |--------------------------------------------------------------------------
    | Payment Status
    |--------------------------------------------------------------------------
    */

    renderPaymentStatus(
        status
    ) {

        const normalized =
            String(
                status ?? ''
            ).toLowerCase();


        let classes =
            'bg-secondary-subtle text-secondary';


        if (
            normalized === 'pending'
        ) {

            classes =
                'bg-warning-subtle text-warning-emphasis';

        }


        if (
            normalized === 'partial'
        ) {

            classes =
                'bg-info-subtle text-info-emphasis';

        }


        if (
            normalized === 'paid'
        ) {

            classes =
                'bg-success-subtle text-success-emphasis';

        }


        return `

            <span class="badge ${classes}">

                ${this.escapeHtml(
                    status ??
                    '—'
                )}

            </span>

        `;

    },


    /*
    |--------------------------------------------------------------------------
    | Order Status
    |--------------------------------------------------------------------------
    */

    renderOrderStatus(
        status
    ) {

        const normalized =
            String(
                status ?? ''
            ).toLowerCase();


        let classes =
            'bg-secondary-subtle text-secondary';


        if (
            normalized === 'draft'
        ) {

            classes =
                'bg-primary-subtle text-primary';

        }


        if (
            normalized === 'held'
        ) {

            classes =
                'bg-warning-subtle text-warning-emphasis';

        }


        return `

            <span class="badge ${classes}">

                ${this.escapeHtml(
                    status ??
                    '—'
                )}

            </span>

        `;

    },


   async openInspector(
    invoiceId,
    orderId
) {

    if (!invoiceId || !orderId) {

        this.notify(
            'Invoice could not be identified.',
            'warning'
        );

        return;

    }

    try {

        /*
        |--------------------------------------------------------------------------
        | Load Invoice / Order
        |--------------------------------------------------------------------------
        */

        const response =
            await fetch(
                `/sales/orders/${orderId}/details`,
                {

                    method:
                        'GET',

                    headers: {

                        'Accept':
                            'application/json',

                        'X-Requested-With':
                            'XMLHttpRequest'

                    }

                }
            );


        const result =
            await response.json();


        if (
            !response.ok ||
            !result.success
        ) {

            throw new Error(
                result.message ??
                'Unable to load invoice details.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Order Data
        |--------------------------------------------------------------------------
        */

        const order =
            result.data;


        /*
        |--------------------------------------------------------------------------
        | Find Invoice Row
        |--------------------------------------------------------------------------
        */

        const invoice =
            this.state.invoices?.find(
                item =>
                    String(item.id) ===
                    String(invoiceId)
            );


        /*
        |--------------------------------------------------------------------------
        | Merge Invoice + Order
        |--------------------------------------------------------------------------
        */

        const inspectorData = {

            ...order,

            invoice_no:
                invoice?.invoice_no ??
                '—',

        };


        /*
        |--------------------------------------------------------------------------
        | Populate Inspector
        |--------------------------------------------------------------------------
        */

        this.populateInspector(
            inspectorData
        );


        /*
        |--------------------------------------------------------------------------
        | Open Inspector
        |--------------------------------------------------------------------------
        */

        const inspector =
            document.getElementById(
                'invoiceInspector'
            );


        if (inspector) {

            bootstrap.Offcanvas
                .getOrCreateInstance(
                    inspector
                )
                .show();

        }

    }
    catch (error) {

        console.error(
            'Invoice inspector error:',
            error
        );


        this.notify(
            error.message ??
            'Unable to load invoice details.',
            'error'
        );

    }

},

    /*
    |--------------------------------------------------------------------------
    | Populate Inspector
    |--------------------------------------------------------------------------
    */

    populateInspector(
        invoice
    ) {

        /*
        |----------------------------------------------------------------------
        | Header
        |----------------------------------------------------------------------
        */

        this.setInspectorText(
            'invoiceInspectorNumber',
            invoice.invoice_no ??
            '—'
        );


        this.setInspectorText(
            'invoiceInspectorOrder',
            invoice.order_no ??
            '—'
        );


        this.setInspectorText(
            'invoiceInspectorCustomer',
            invoice.customer?.name ??
            'Walk-in Customer'
        );


        this.setInspectorText(
            'invoiceInspectorBranch',
            invoice.branch?.name ??
            '—'
        );


        this.setInspectorText(
            'invoiceInspectorStatus',
            invoice.order_status ??
            '—'
        );


        this.setInspectorText(
            'invoiceInspectorPaymentStatus',
            invoice.payment_status ??
            '—'
        );


        /*
        |----------------------------------------------------------------------
        | Amounts
        |----------------------------------------------------------------------
        */

        this.setInspectorText(
            'invoiceInspectorSubtotal',
            this.formatMoney(
                invoice.subtotal ??
                0
            )
        );


        this.setInspectorText(
            'invoiceInspectorDiscount',
            this.formatMoney(
                invoice.discount ??
                0
            )
        );


        this.setInspectorText(
            'invoiceInspectorTax',
            this.formatMoney(
                invoice.tax ??
                0
            )
        );


        this.setInspectorText(
            'invoiceInspectorTotal',
            this.formatMoney(
                invoice.grand_total ??
                invoice.total ??
                0
            )
        );


        this.setInspectorText(
            'invoiceInspectorAmountPaid',
            this.formatMoney(
                invoice.amount_paid ??
                0
            )
        );


        this.setInspectorText(
            'invoiceInspectorBalance',
            this.formatMoney(
                invoice.balance ??
                0
            )
        );


        /*
        |----------------------------------------------------------------------
        | Date
        |----------------------------------------------------------------------
        */

        this.setInspectorText(
            'invoiceInspectorDate',
            this.formatDateTime(
                invoice.invoice_date ??
                invoice.created_at
            )
        );


        /*
        |----------------------------------------------------------------------
        | Remarks
        |----------------------------------------------------------------------
        */

        this.setInspectorText(
            'invoiceInspectorRemarks',
            invoice.remarks ??
            '—'
        );


        /*
        |----------------------------------------------------------------------
        | Items
        |----------------------------------------------------------------------
        */

        this.populateInspectorItems(
            invoice.items ??
            invoice.invoice_items ??
            []
        );

    },

 /*
|--------------------------------------------------------------------------
| Open Invoice Inspector
|--------------------------------------------------------------------------
*/

/**
 * Open the Sales Invoice inspector.
 */
async openInvoiceInspector(
    invoiceId
)
{

    if (!invoiceId) {

        this.notify(
            'Invoice could not be identified.',
            'warning'
        );

        return;

    }


    const inspector =
        this.elements.inspector;


    if (!inspector) {

        return;

    }


    try {

        /*
        |--------------------------------------------------------------------------
        | Show Inspector
        |--------------------------------------------------------------------------
        */

        const offcanvas =
            bootstrap.Offcanvas.getOrCreateInstance(
                inspector
            );


        offcanvas.show();


        /*
        |--------------------------------------------------------------------------
        | Loading State
        |--------------------------------------------------------------------------
        */

        this.resetInvoiceInspector();


        this.setInspectorText(
            'invoiceInspectorLabel',
            'Loading...'
        );


        /*
        |--------------------------------------------------------------------------
        | Request
        |--------------------------------------------------------------------------
        */

        const response =
            await fetch(
                `/sales/invoices/${encodeURIComponent(
                    invoiceId
                )}`,
                {

                    method:
                        'GET',

                    headers: {

                        'Accept':
                            'application/json',

                        'X-Requested-With':
                            'XMLHttpRequest'

                    }

                }
            );


        const result =
            await response.json();


        console.log(
            'INVOICE DETAILS RESPONSE',
            result
        );


        if (
            !response.ok ||
            !result.success ||
            !result.data
        ) {

            throw new Error(
                result.message ??
                'Unable to load invoice details.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Populate Inspector
        |--------------------------------------------------------------------------
        */

        this.populateInvoiceInspector(
            result.data
        );

    }
    catch (error) {

        console.error(
            'Invoice inspector error:',
            error
        );


        this.notify(
            error.message ??
            'Unable to load invoice details.',
            'danger'
        );

    }

},

/*
|--------------------------------------------------------------------------
| Reset Invoice Inspector
|--------------------------------------------------------------------------
*/

/**
 * Reset the Sales Invoice inspector.
 */
resetInvoiceInspector()
{

    const fields = {

        invoiceInspectorLabel:
            '—',

        invoiceInspectorOrderStatus:
            '—',

        invoiceInspectorPaymentStatus:
            '—',

        invoiceInspectorNumber:
            '—',

        invoiceInspectorOrderNumber:
            '—',

        invoiceInspectorCustomer:
            '—',

        invoiceInspectorBranch:
            '—',

        invoiceInspectorTerminal:
            '—',

        invoiceInspectorDate:
            '—',

        invoiceInspectorItemCount:
            '0',

        invoiceInspectorQuantity:
            '0',

        invoiceInspectorSubtotal:
            '0.00',

        invoiceInspectorDiscount:
            '0.00',

        invoiceInspectorTax:
            '0.00',

        invoiceInspectorTotal:
            '0.00',

        invoiceInspectorAmountPaid:
            '0.00',

        invoiceInspectorBalance:
            '0.00',

        invoiceInspectorChange:
            '0.00',

        invoiceInspectorRemarks:
            '—',

        invoiceInspectorCreatedBy:
            '—',

        invoiceInspectorCreatedAt:
            '—',

        invoiceInspectorUpdatedBy:
            '—',

        invoiceInspectorUpdatedAt:
            '—',

    };


    Object.entries(
        fields
    ).forEach(
        (
            [
                id,
                value
            ]
        ) => {

            this.setInspectorText(
                id,
                value
            );

        }
    );


    this.populateInvoiceInspectorItems(
        []
    );

},

/*
|--------------------------------------------------------------------------
| Populate Invoice Inspector Items
|--------------------------------------------------------------------------
*/

/**
 * Populate invoice items in the Sales Invoice inspector.
 */
populateInvoiceInspectorItems(
    items = []
)
{

    const container =
        this.elements.inspectorItems;


    if (!container) {

        return;

    }


    if (
        !items.length
    ) {

        container.innerHTML = `

            <div class="purchase-inspector-items-empty">

                <div class="purchase-inspector-items-empty-icon">

                    <i class="bi bi-box-seam"></i>

                </div>


                <div class="purchase-inspector-items-empty-title">

                    No items available

                </div>


                <div class="purchase-inspector-items-empty-text">

                    This invoice does not contain any products.

                </div>

            </div>

        `;

        return;

    }


    container.innerHTML =
        items
            .map(
                item => {

                    const quantity =
                        parseFloat(
                            item.quantity
                        ) || 0;


                    const unitPrice =
                        parseFloat(
                            item.unit_price
                        ) || 0;


                    const total =
                        parseFloat(
                            item.total
                        ) || 0;


                    return `

                        <div class="purchase-inspector-item">

                            <div class="purchase-inspector-item-main">

                                <div class="purchase-inspector-item-name">

                                    ${this.escapeHtml(
                                        item.product_name ??
                                        'Unknown Product'
                                    )}

                                </div>


                                <div class="purchase-inspector-item-meta">

                                    ${
                                        item.product_barcode
                                            ? `

                                                <span>

                                                    ${this.escapeHtml(
                                                        item.product_barcode
                                                    )}

                                                </span>

                                            `
                                            : ''
                                    }


                                    ${
                                        item.product_barcode
                                            ? `

                                                <span class="purchase-inspector-item-meta-divider">

                                                    •

                                                </span>

                                            `
                                            : ''
                                    }


                                    <span>

                                        ${this.formatMoney(
                                            unitPrice
                                        )} / unit

                                    </span>

                                </div>

                            </div>


                            <div class="purchase-inspector-item-summary">

                                <span class="purchase-inspector-item-quantity">

                                    ${quantity}
                                    ×

                                </span>


                                <strong class="purchase-inspector-item-total">

                                    ${this.formatMoney(
                                        total
                                    )}

                                </strong>

                            </div>

                        </div>

                    `;

                }
            )
            .join('');

},

/*
|--------------------------------------------------------------------------
| Populate Invoice Inspector
|--------------------------------------------------------------------------
*/

/**
 * Populate the Sales Invoice inspector.
 */
populateInvoiceInspector(
    invoice
)
{

    if (!invoice) {

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Header
    |--------------------------------------------------------------------------
    */

    this.setInspectorText(
        'invoiceInspectorLabel',
        invoice.invoice_no ??
        '—'
    );


    /*
    |--------------------------------------------------------------------------
    | Order Status
    |--------------------------------------------------------------------------
    */

    this.setInspectorText(
        'invoiceInspectorOrderStatus',
        invoice.order_status ??
        '—'
    );


    /*
    |--------------------------------------------------------------------------
    | Payment Status
    |--------------------------------------------------------------------------
    */

    this.setInspectorText(
        'invoiceInspectorPaymentStatus',
        invoice.payment_status ??
        '—'
    );


    /*
    |--------------------------------------------------------------------------
    | Invoice Information
    |--------------------------------------------------------------------------
    */

    this.setInspectorText(
        'invoiceInspectorNumber',
        invoice.invoice_no ??
        '—'
    );


    this.setInspectorText(
        'invoiceInspectorOrderNumber',
        invoice.order_no ??
        '—'
    );


    this.setInspectorText(
        'invoiceInspectorCustomer',
        invoice.customer?.name ??
        'Walk-in Customer'
    );


    this.setInspectorText(
        'invoiceInspectorBranch',
        invoice.branch?.name ??
        '—'
    );


    this.setInspectorText(
        'invoiceInspectorTerminal',
        invoice.terminal?.name ??
        '—'
    );


    this.setInspectorText(
        'invoiceInspectorDate',
        this.formatDateTime(
            invoice.invoice_date
        )
    );


    /*
    |--------------------------------------------------------------------------
    | Summary
    |--------------------------------------------------------------------------
    */

    this.setInspectorText(
        'invoiceInspectorItemCount',
        this.formatNumber(
            invoice.total_items ??
            0
        )
    );


    this.setInspectorText(
        'invoiceInspectorQuantity',
        this.formatNumber(
            invoice.total_quantity ??
            0
        )
    );


    this.setInspectorText(
        'invoiceInspectorSubtotal',
        this.formatMoney(
            invoice.subtotal ??
            0
        )
    );


    this.setInspectorText(
        'invoiceInspectorDiscount',
        this.formatMoney(
            invoice.discount ??
            0
        )
    );


    this.setInspectorText(
        'invoiceInspectorTax',
        this.formatMoney(
            invoice.tax ??
            0
        )
    );


    this.setInspectorText(
        'invoiceInspectorTotal',
        this.formatMoney(
            invoice.grand_total ??
            invoice.total ??
            0
        )
    );


    this.setInspectorText(
        'invoiceInspectorAmountPaid',
        this.formatMoney(
            invoice.amount_paid ??
            0
        )
    );


    this.setInspectorText(
        'invoiceInspectorBalance',
        this.formatMoney(
            invoice.balance ??
            0
        )
    );


    this.setInspectorText(
        'invoiceInspectorChange',
        this.formatMoney(
            invoice.change_given ??
            0
        )
    );


    /*
    |--------------------------------------------------------------------------
    | Items
    |--------------------------------------------------------------------------
    */

    this.populateInvoiceInspectorItems(
        invoice.items ??
        []
    );


    /*
    |--------------------------------------------------------------------------
    | Remarks
    |--------------------------------------------------------------------------
    */

    this.setInspectorText(
        'invoiceInspectorRemarks',
        invoice.remarks ??
        '—'
    );


    /*
    |--------------------------------------------------------------------------
    | Activity
    |--------------------------------------------------------------------------
    */

    this.setInspectorText(
        'invoiceInspectorCreatedBy',
        invoice.created_by?.name ??
        '—'
    );


    this.setInspectorText(
        'invoiceInspectorCreatedAt',
        this.formatDateTime(
            invoice.created_at
        )
    );


    this.setInspectorText(
        'invoiceInspectorUpdatedBy',
        invoice.updated_by?.name ??
        '—'
    );


    this.setInspectorText(
        'invoiceInspectorUpdatedAt',
        this.formatDateTime(
            invoice.updated_at
        )
    );


    /*
    |--------------------------------------------------------------------------
    | Continue to Order
    |--------------------------------------------------------------------------
    */

    const orderButton =
        document.getElementById(
            'invoiceGoToOrder'
        );


    if (orderButton) {

        orderButton.dataset.orderId =
            invoice.order?.id ??
            '';

    }

},


    /*
    |--------------------------------------------------------------------------
    | Populate Inspector Items
    |--------------------------------------------------------------------------
    */

    populateInspectorItems(
        items = []
    ) {

        const container =
            document.getElementById(
                'invoiceInspectorItems'
            );


        if (!container) {

            return;

        }


        if (
            !items.length
        ) {

            container.innerHTML = `

                <div class="text-muted small py-3">

                    No invoice items available.

                </div>

            `;

            return;

        }


        container.innerHTML =
            items
                .map(
                    item => {

                        const quantity =
                            parseFloat(
                                item.quantity
                            ) || 0;


                        const unitPrice =
                            parseFloat(
                                item.unit_price
                            ) || 0;


                        const total =
                            parseFloat(
                                item.total
                            ) || 0;


                        return `

                            <div
                                class="d-flex align-items-center justify-content-between py-2 border-bottom"
                            >

                                <div>

                                    <div class="fw-semibold">

                                        ${this.escapeHtml(
                                            item.product_name ??
                                            'Unknown Product'
                                        )}

                                    </div>


                                    <div class="text-muted small">

                                        ${quantity}
                                        ×
                                        ${this.formatMoney(
                                            unitPrice
                                        )}

                                    </div>

                                </div>


                                <strong>

                                    ${this.formatMoney(
                                        total
                                    )}

                                </strong>

                            </div>

                        `;

                    }
                )
                .join('');

    },


   /*
|--------------------------------------------------------------------------
| Print Invoice
|--------------------------------------------------------------------------
*/

/**
 * Open the invoice print view.
 */
printInvoice(
    invoiceId
) {

    if (!invoiceId) {

        this.notify(
            'Invoice could not be identified.',
            'warning'
        );

        return;

    }


    window.open(
        `/sales/invoices/${encodeURIComponent(
            invoiceId
        )}/print`,
        '_blank'
    );

},


    /*
    |--------------------------------------------------------------------------
    | Open Sales Order
    |--------------------------------------------------------------------------
    */

    openOrder(
        orderId
    ) {

        if (!orderId) {

            this.notify(
                'Sales order could not be identified.',
                'warning'
            );

            return;

        }


        window.location.href =
            `/sales/orders?order_id=${encodeURIComponent(
                orderId
            )}`;

    },


    /*
    |--------------------------------------------------------------------------
    | Reset Filters
    |--------------------------------------------------------------------------
    */

    resetFilters() {

        this.state.page =
            1;

        this.state.search =
            '';

        this.state.branchId =
            '';

        this.state.orderStatus =
            '';

        this.state.paymentStatus =
            '';

        this.state.dateFrom =
            '';

        this.state.dateTo =
            '';


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
            this.elements.orderStatus
        ) {

            this.elements.orderStatus.value =
                '';

        }


        if (
            this.elements.paymentStatus
        ) {

            this.elements.paymentStatus.value =
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
    | Refresh
    |--------------------------------------------------------------------------
    */

    async refresh() {

        await Promise.all([

            this.loadStats(),

            this.loadTable(),

        ]);

    },


    /*
    |--------------------------------------------------------------------------
    | Set Inspector Text
    |--------------------------------------------------------------------------
    */

    setInspectorText(
        id,
        value
    ) {

        const element =
            document.getElementById(
                id
            );


        if (!element) {

            return;

        }


        element.textContent =
            value ??
            '—';

    },


    /*
    |--------------------------------------------------------------------------
    | Format Money
    |--------------------------------------------------------------------------
    */

    formatMoney(
        value
    ) {

        const amount =
            parseFloat(
                value
            ) || 0;


        return amount.toLocaleString(
            'en-NG',
            {

                minimumFractionDigits:
                    2,

                maximumFractionDigits:
                    2,

            }
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Format Number
    |--------------------------------------------------------------------------
    */

    formatNumber(
        value
    ) {

        return (
            parseInt(
                value,
                10
            ) || 0
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
        value
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


        return date.toLocaleDateString(
            'en-NG',
            {

                day:
                    '2-digit',

                month:
                    'short',

                year:
                    'numeric',

            }
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Format Date Time
    |--------------------------------------------------------------------------
    */

    formatDateTime(
        value
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


        return date.toLocaleString(
            'en-NG',
            {

                day:
                    '2-digit',

                month:
                    'short',

                year:
                    'numeric',

                hour:
                    '2-digit',

                minute:
                    '2-digit',

            }
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Escape HTML
    |--------------------------------------------------------------------------
    */

    escapeHtml(
        value
    ) {

        const div =
            document.createElement(
                'div'
            );


        div.textContent =
            value ??
            '';


        return div.innerHTML;

    },


    /*
    |--------------------------------------------------------------------------
    | Notification
    |--------------------------------------------------------------------------
    */

    notify(
        message,
        type = 'info'
    ) {

        if (
            typeof this.showToast ===
            'function'
        ) {

            this.showToast(
                message,
                type
            );

            return;

        }


        if (
            typeof window.showToast ===
            'function'
        ) {

            window.showToast(
                message,
                type
            );

            return;

        }


        console.log(
            `[${type}] ${message}`
        );

    },


    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    renderPagination(
        pagination = {}
    ) {

        const container =
            this.elements.pagination;


        const info =
            this.elements.paginationInfo;


        if (!container) {

            return;

        }


        const currentPage =
            parseInt(
                pagination.current_page ??
                1,
                10
            );


        const lastPage =
            parseInt(
                pagination.last_page ??
                1,
                10
            );


        const total =
            parseInt(
                pagination.total ??
                0,
                10
            );


        const from =
            pagination.from ??
            0;


        const to =
            pagination.to ??
            0;


        this.state.page =
            currentPage;


        if (info) {

            info.textContent =
                `Showing ${from}–${to} of ${total}`;

        }


        if (
            lastPage <= 1
        ) {

            container.innerHTML =
                '';

            return;

        }


        let html =
            '';


        html += `

            <button
                type="button"
                class="btn btn-sm btn-light"
                data-page="${currentPage - 1}"
                ${currentPage <= 1 ? 'disabled' : ''}
            >

                <i class="bi bi-chevron-left"></i>

            </button>

        `;


        const start =
            Math.max(
                1,
                currentPage - 2
            );


        const end =
            Math.min(
                lastPage,
                currentPage + 2
            );


        for (
            let page = start;
            page <= end;
            page++
        ) {

            html += `

                <button
                    type="button"
                    class="btn btn-sm ${
                        page === currentPage
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
                class="btn btn-sm btn-light"
                data-page="${currentPage + 1}"
                ${currentPage >= lastPage ? 'disabled' : ''}
            >

                <i class="bi bi-chevron-right"></i>

            </button>

        `;


        container.innerHTML =
            html;

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

        InvoiceModule.init();

    }
);

