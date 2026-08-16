/*
|--------------------------------------------------------------------------
| EMNEX POS - Customer Management
|--------------------------------------------------------------------------
|
| Handles:
|
| - Customers
| - Customer Groups
| - Loyalty
| - Customer search
| - Customer filters
| - Group filters
| - Loyalty filters
| - Pagination
| - Customer actions
| - Customer inspector
| - Customer form
|
|--------------------------------------------------------------------------
*/


const CustomerManagement = {


    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    searchTimer: null,

    activeTab: 'groups',

    selectedCustomer: null,

    customerModal: null,

    inspector: null,

    customerGroupModal: null,

    customerGroupInspector: null,

    customerGroupConfirmModal: null,

    groupConfirmAction: null,
    
    customerDropdownMenu: null,

    customerActionCustomerId: null,

    customerActionCustomerName: null,


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

        /*
        |--------------------------------------------------------------------------
        | Main Container
        |--------------------------------------------------------------------------
        */

        this.container =
            document.getElementById(
                'customerManagement'
            );


        /*
        |--------------------------------------------------------------------------
        | Tabs
        |--------------------------------------------------------------------------
        */

        this.customersTab =
            document.getElementById(
                'customers-tab'
            );


        this.groupsTab =
            document.getElementById(
                'customer-groups-tab'
            );


        this.loyaltyTab =
            document.getElementById(
                'loyalty-tab'
            );

        this.groupsTabCount =
            document.getElementById(
                'groupsTabCount'
            );


        /*
        |--------------------------------------------------------------------------
        | Customer Section
        |--------------------------------------------------------------------------
        */

        this.customerTable =
            document.getElementById(
                'customerTableContainer'
            );


        this.customerSearch =
            document.getElementById(
                'customerSearch'
            );


        this.customerStatusFilter =
            document.getElementById(
                'customerStatusFilter'
            );


        this.customerTypeFilter =
            document.getElementById(
                'customerTypeFilter'
            );


        this.customerPagination =
            document.getElementById(
                'customerPagination'
            );


        /*
        |--------------------------------------------------------------------------
        | Group Section
        |--------------------------------------------------------------------------
        */

        this.groupTable =
            document.getElementById(
                'customerGroupTableContainer'
            );


        this.groupSearch =
            document.getElementById(
                'customerGroupSearch'
            );


        this.groupStatusFilter =
            document.getElementById(
                'customerGroupStatusFilter'
            );


        this.groupPagination =
            document.getElementById(
                'customerGroupPagination'
            );

        /*
        |--------------------------------------------------------------------------
        | Group Modal
        |--------------------------------------------------------------------------
        */

        this.customerGroupModalElement =
            document.getElementById(
                'customerGroupModal'
            );


        this.customerGroupForm =
            document.getElementById(
                'customerGroupForm'
            );


        this.customerGroupId =
            document.getElementById(
                'customerGroupIdInput'
            );


        this.customerGroupModalTitle =
            document.getElementById(
                'customerGroupModalTitle'
            );


        this.saveCustomerGroupBtn =
            document.getElementById(
                'saveCustomerGroupBtn'
            );


        /*
        |--------------------------------------------------------------------------
        | Group Inspector
        |--------------------------------------------------------------------------
        */

        this.customerGroupInspector =
            document.getElementById(
                'customerGroupInspector'
            );


        this.customerGroupInspectorName =
            document.getElementById(
                'customerGroupInspectorName'
            );


        this.customerGroupInspectorCode =
            document.getElementById(
                'customerGroupInspectorCode'
            );


        this.customerGroupInspectorDescription =
            document.getElementById(
                'customerGroupInspectorDescription'
            );


        this.customerGroupInspectorDiscount =
            document.getElementById(
                'customerGroupInspectorDiscount'
            );


        this.customerGroupInspectorCreditLimit =
            document.getElementById(
                'customerGroupInspectorCreditLimit'
            );


        this.customerGroupInspectorCustomers =
            document.getElementById(
                'customerGroupInspectorCustomers'
            );


        this.customerGroupInspectorStatus =
            document.getElementById(
                'customerGroupInspectorStatus'
            );


        this.customerGroupInspectorCreated =
            document.getElementById(
                'customerGroupInspectorCreated'
            );


        /*
        |--------------------------------------------------------------------------
        | Group Confirmation
        |--------------------------------------------------------------------------
        */

        this.customerGroupConfirmModalElement =
            document.getElementById(
                'customerGroupConfirmModal'
            );


        this.customerGroupConfirmTitle =
            document.getElementById(
                'customerGroupConfirmTitle'
            );


        this.customerGroupConfirmMessage =
            document.getElementById(
                'customerGroupConfirmMessage'
            );


        this.customerGroupConfirmDescription =
            document.getElementById(
                'customerGroupConfirmDescription'
            );


        this.customerGroupConfirmIcon =
            document.getElementById(
                'customerGroupConfirmIcon'
            );


        this.customerGroupConfirmBtn =
            document.getElementById(
                'customerGroupConfirmBtn'
            );


        /*
        |--------------------------------------------------------------------------
        | Loyalty Section
        |--------------------------------------------------------------------------
        */

        this.loyaltyTable =
            document.getElementById(
                'loyaltyTableContainer'
            );


        this.loyaltySearch =
            document.getElementById(
                'loyaltySearch'
            );


        this.loyaltyStatusFilter =
            document.getElementById(
                'loyaltyStatusFilter'
            );


        this.loyaltyPagination =
            document.getElementById(
                'loyaltyPagination'
            );


        /*
        |--------------------------------------------------------------------------
        | Create Customer
        |--------------------------------------------------------------------------
        */

        this.createCustomerBtn =
            document.getElementById(
                'addCustomerBtn'
            );


        this.sectionAddCustomerBtn =
            document.getElementById(
                'sectionAddCustomerBtn'
            );

        /*
        |--------------------------------------------------------------------------
        | Customer Modal
        |--------------------------------------------------------------------------
        */

        this.customerModalElement =
            document.getElementById(
                'customerModal'
            );


        this.customerForm =
            document.getElementById(
                'customerForm'
            );


        this.customerId =
            document.getElementById(
                'customerId'
            );


        this.customerModalTitle =
            document.getElementById(
                'customerModalTitle'
            );


        this.saveCustomerBtn =
            document.getElementById(
                'saveCustomerBtn'
            );

        /*
        |--------------------------------------------------------------------------
        | Customer Confirmation
        |--------------------------------------------------------------------------
        */

        this.customerConfirmModalElement =
            document.getElementById(
                'customerConfirmModal'
            );


        this.customerConfirmTitle =
            document.getElementById(
                'customerConfirmTitle'
            );


        this.customerConfirmMessage =
            document.getElementById(
                'customerConfirmMessage'
            );


        this.customerConfirmDescription =
            document.getElementById(
                'customerConfirmDescription'
            );


        this.customerConfirmIcon =
            document.getElementById(
                'customerConfirmIcon'
            );


        this.customerConfirmBtn =
            document.getElementById(
                'customerConfirmBtn'
            );


        /*
        |--------------------------------------------------------------------------
        | Inspector
        |--------------------------------------------------------------------------
        */

        this.customerInspector =
            document.getElementById(
                'customerInspector'
            );


        this.inspectorCustomerName =
            document.getElementById(
                'inspectorCustomerName'
            );


        this.inspectorCustomerCode =
            document.getElementById(
                'inspectorCustomerCode'
            );


        this.inspectorCustomerEmail =
            document.getElementById(
                'inspectorCustomerEmail'
            );


        this.inspectorCustomerPhone =
            document.getElementById(
                'inspectorCustomerPhone'
            );


        this.inspectorCustomerAddress =
            document.getElementById(
                'inspectorCustomerAddress'
            );


        this.inspectorCustomerGroup =
            document.getElementById(
                'inspectorCustomerGroup'
            );


        this.inspectorCustomerStatus =
            document.getElementById(
                'inspectorCustomerStatus'
            );


        this.inspectorCustomerCredit =
            document.getElementById(
                'inspectorCustomerCredit'
            );


        this.inspectorCustomerBalance =
            document.getElementById(
                'inspectorCustomerBalance'
            );


        this.inspectorCustomerPoints =
            document.getElementById(
                'inspectorCustomerPoints'
            );

        /*
        |--------------------------------------------------------------------------
        | Global Customer Action Menu
        |--------------------------------------------------------------------------
        */

        this.customerGlobalActionMenu =
            document.getElementById(
                'customerGlobalActionMenu'
            );


        this.customerGlobalStatusAction =
            document.getElementById(
                'customerGlobalStatusAction'
            );


        this.customerGlobalStatusIcon =
            document.getElementById(
                'customerGlobalStatusIcon'
            );


        this.customerGlobalStatusText =
            document.getElementById(
                'customerGlobalStatusText'
            );

        },

        /*
        |--------------------------------------------------------------------------
        | Initialize Components
        |--------------------------------------------------------------------------
        */

        initializeComponents()
        {

            if(this.customerModalElement)
            {

                this.customerModal =
                    new bootstrap.Modal(
                        this.customerModalElement
                    );

            }


            if(this.customerInspector)
            {

                this.inspector =
                    new bootstrap.Offcanvas(
                        this.customerInspector
                    );

            }

            if(this.customerGroupModalElement)
            {

                this.customerGroupModal =
                    new bootstrap.Modal(
                        this.customerGroupModalElement
                    );

            }


            if(this.customerGroupInspector)
            {

                this.customerGroupInspectorInstance =
                    new bootstrap.Offcanvas(
                        this.customerGroupInspector
                    );

            }


            if(this.customerGroupConfirmModalElement)
            {

                this.customerGroupConfirmModal =
                    new bootstrap.Modal(
                        this.customerGroupConfirmModalElement
                    );

            }

            if(this.customerConfirmModalElement)
            {

                this.customerConfirmModal =
                    new bootstrap.Modal(
                        this.customerConfirmModalElement
                    );

            }

        } ,

    /*
    |--------------------------------------------------------------------------
    | Bind Events
    |--------------------------------------------------------------------------
    */

    bindEvents()
    {

        /*
        |--------------------------------------------------------------------------
        | Customer Search
        |--------------------------------------------------------------------------
        */

        this.customerSearch?.addEventListener(
            'input',
            () => {

                this.debounce(
                    () => this.loadCustomers()
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Customer Filters
        |--------------------------------------------------------------------------
        */

        this.customerStatusFilter?.addEventListener(
            'change',
            () => this.loadCustomers()
        );


        this.customerTypeFilter?.addEventListener(
            'change',
            () => this.loadCustomers()
        );


        /*
        |--------------------------------------------------------------------------
        | Group Search
        |--------------------------------------------------------------------------
        */

        this.groupSearch?.addEventListener(
            'input',
            () => {

                this.debounce(
                    () => this.loadGroups()
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Group Status
        |--------------------------------------------------------------------------
        */

        this.groupStatusFilter?.addEventListener(
            'change',
            () => this.loadGroups()
        );


        /*
        |--------------------------------------------------------------------------
        | Loyalty Search
        |--------------------------------------------------------------------------
        */

        this.loyaltySearch?.addEventListener(
            'input',
            () => {

                this.debounce(
                    () => this.loadLoyalty()
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Loyalty Status
        |--------------------------------------------------------------------------
        */

        this.loyaltyStatusFilter?.addEventListener(
            'change',
            () => this.loadLoyalty()
        );


        /*
        |--------------------------------------------------------------------------
        | Create Customer
        |--------------------------------------------------------------------------
        */

        this.createCustomerBtn?.addEventListener(
            'click',
            () => {

                this.openCreateModal();

            }
        );


        this.sectionAddCustomerBtn?.addEventListener(
            'click',
            () => {

                this.openCreateModal();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Save Customer
        |--------------------------------------------------------------------------
        */

        this.saveCustomerBtn?.addEventListener(
            'click',
            () => {

                this.saveCustomer();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Customer Form
        |--------------------------------------------------------------------------
        */

        this.customerForm?.addEventListener(
            'submit',
            (event) => {

                event.preventDefault();

                this.saveCustomer();

            }
        );

        this.customerConfirmBtn?.addEventListener(
            'click',
            () => {

                this.executeCustomerStatusConfirmation();

            }
        );

        /*
        |--------------------------------------------------------------------------
        | Customer Group Form
        |--------------------------------------------------------------------------
        */

        this.customerGroupForm?.addEventListener(
            'submit',
            (event) => {

                event.preventDefault();

                this.saveCustomerGroup();

            }
        );

        this.customerGroupConfirmBtn?.addEventListener(
            'click',
            () => {

                this.executeGroupConfirmation();

            }
        );


        document.addEventListener(
            'click',
            event => {

                const trigger =
                    event.target.closest(
                        '.customer-action-trigger'
                    );


                if(trigger)
                {

                    event.preventDefault();

                    event.stopPropagation();


                    this.openCustomerActionMenu(
                        trigger
                    );

                    return;

                }


                const actionButton =
                    event.target.closest(
                        '#customerGlobalActionMenu [data-action]'
                    );


                if(actionButton)
                {

                    event.preventDefault();

                    this.handleCustomerAction(
                        actionButton.dataset.action
                    );

                    return;

                }


                if(
                    !event.target.closest(
                        '#customerGlobalActionMenu'
                    )
                )
                {

                    this.closeCustomerActionMenu();

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Add Customer Group
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            (event) => {

                const addButton =
                    event.target.closest(
                        '#addCustomerGroupBtn'
                    );


                if(addButton)
                {

                    this.openCreateGroupModal();

                    return;

                }


                /*
                |------------------------------------------------------------------
                | View Group
                |------------------------------------------------------------------
                */

                const viewButton =
                    event.target.closest(
                        '.customer-group-view-btn'
                    );


                if(viewButton)
                {

                    this.openGroupInspector(
                        viewButton.dataset.id
                    );

                    return;

                }


                /*
                |------------------------------------------------------------------
                | Edit Group
                |------------------------------------------------------------------
                */

                const editButton =
                    event.target.closest(
                        '.customer-group-edit-btn'
                    );


                if(editButton)
                {

                    this.openEditGroupModal(
                        editButton.dataset.id
                    );

                    return;

                }


                /*
                |------------------------------------------------------------------
                | Delete Group
                |------------------------------------------------------------------
                */

                const deleteButton =
                    event.target.closest(
                        '.customer-group-delete-btn'
                    );


                if(deleteButton)
                {

                    this.confirmGroupDelete(
                        deleteButton.dataset.id,
                        deleteButton.dataset.name
                    );

                    return;

                }


                /*
                |------------------------------------------------------------------
                | Enable Group
                |------------------------------------------------------------------
                */

                const enableButton =
                    event.target.closest(
                        '.customer-group-enable-btn'
                    );


                if(enableButton)
                {

                    this.confirmGroupStatus(
                        enableButton.dataset.id,
                        enableButton.dataset.name,
                        'enable'
                    );

                    return;

                }


                /*
                |------------------------------------------------------------------
                | Disable Group
                |------------------------------------------------------------------
                */

                const disableButton =
                    event.target.closest(
                        '.customer-group-disable-btn'
                    );


                if(disableButton)
                {

                    this.confirmGroupStatus(
                        disableButton.dataset.id,
                        disableButton.dataset.name,
                        'disable'
                    );

                    return;

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Tabs
        |--------------------------------------------------------------------------
        */

        document.querySelectorAll(
            '.customer-tab'
        ).forEach(
            tab => {

                tab.addEventListener(
                    'click',
                    () => {

                        const section =
                            tab.dataset.section;


                        /*
                        |--------------------------------------------------------------------------
                        | Remove Active State
                        |--------------------------------------------------------------------------
                        */

                        document
                            .querySelectorAll(
                                '.customer-tab'
                            )
                            .forEach(
                                item => {

                                    item.classList.remove(
                                        'active'
                                    );

                                }
                            );


                        document
                            .querySelectorAll(
                                '.customer-management-section'
                            )
                            .forEach(
                                sectionElement => {

                                    sectionElement.classList.remove(
                                        'active'
                                    );

                                }
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | Activate Selected Tab
                        |--------------------------------------------------------------------------
                        */

                        tab.classList.add(
                            'active'
                        );


                        const sectionElement =
                            document.getElementById(
                                `${section}Section`
                            );


                        if(sectionElement)
                        {

                            sectionElement.classList.add(
                                'active'
                            );

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Update State
                        |--------------------------------------------------------------------------
                        */

                        this.activeTab =
                            section;


                        /*
                        |--------------------------------------------------------------------------
                        | Load Section Data
                        |--------------------------------------------------------------------------
                        */

                        if(section === 'customers')
                        {

                            this.loadCustomers();

                        }


                        else if(section === 'groups')
                        {

                            this.loadGroups();

                        }


                        else if(section === 'loyalty')
                        {

                            this.loadLoyalty();

                        }

                    }
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Table Actions
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            (event) => {


                /*
                |--------------------------------------------------------------------------
                | View Customer
                |--------------------------------------------------------------------------
                */

                const viewButton =
                    event.target.closest(
                        '.customer-view-btn'
                    );


                if(viewButton)
                {

                    this.openInspector(
                        viewButton.dataset.id
                    );

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Edit Customer
                |--------------------------------------------------------------------------
                */

                const editButton =
                    event.target.closest(
                        '.customer-edit-btn'
                    );


                if(editButton)
                {

                    this.openEditModal(
                        editButton.dataset.id
                    );

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Delete Customer
                |--------------------------------------------------------------------------
                */

                const deleteButton =
                    event.target.closest(
                        '.customer-delete-btn'
                    );


                if(deleteButton)
                {

                    this.deleteCustomer(
                        deleteButton.dataset.id
                    );

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Customer Pagination
                |--------------------------------------------------------------------------
                */

                const customerPage =
                    event.target.closest(
                        '.customer-page'
                    );


                if(customerPage)
                {

                    const page =
                        customerPage.dataset.page;


                    if(page)
                    {

                        this.loadCustomers(
                            page
                        );

                    }

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Group Pagination
                |--------------------------------------------------------------------------
                */

                const groupPage =
                    event.target.closest(
                        '.customer-group-page'
                    );


                if(groupPage)
                {

                    const page =
                        groupPage.dataset.page;


                    if(page)
                    {

                        this.loadGroups(
                            page
                        );

                    }

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Loyalty Pagination
                |--------------------------------------------------------------------------
                */

                const loyaltyPage =
                    event.target.closest(
                        '.loyalty-page'
                    );


                if(loyaltyPage)
                {

                    const page =
                        loyaltyPage.dataset.page;


                    if(page)
                    {

                        this.loadLoyalty(
                            page
                        );

                    }

                }

            }
        );

    },



    /*
    |--------------------------------------------------------------------------
    | Debounce
    |--------------------------------------------------------------------------
    */

    debounce(callback)
    {

        clearTimeout(
            this.searchTimer
        );


        this.searchTimer =
            setTimeout(
                callback,
                400
            );

    },



    /*
    |--------------------------------------------------------------------------
    | Load Customers
    |--------------------------------------------------------------------------
    */

    async loadCustomers(page = 1)
    {

        if(!this.customerTable)
        {
            return;
        }


        const params =
            new URLSearchParams({

                page: page,

                search:
                    this.customerSearch?.value ?? '',

                status:
                    this.customerStatusFilter?.value ?? '',

                type:
                    this.customerTypeFilter?.value ?? '',

            });


        try
        {

            const response =
                await fetch(
                    `/customers/table?${params.toString()}`,
                    {
                        headers: {
                            'Accept':
                                'application/json'
                        }
                    }
                );


            const result =
                await response.json();


            if(!result.success)
            {

                showToast(
                    result.message ??
                    'Unable to load customers.',
                    'error'
                );

                return;

            }


            this.customerTable.innerHTML =
                result.html;


            if(this.customerPagination)
            {

                this.customerPagination.innerHTML =
                    result.pagination ?? '';

            }


            this.updateCustomerStats(
                result.stats
            );

        }
        catch(error)
        {

            console.error(
                'Customer table error:',
                error
            );


            showToast(
                'Unable to load customers.',
                'error'
            );

        }

    },



    /*
    |--------------------------------------------------------------------------
    | Load Groups
    |--------------------------------------------------------------------------
    */

    async loadGroups(page = 1)
    {

        if(!this.groupTable)
        {
            return;
        }


        const params =
            new URLSearchParams({

                page: page,

                search:
                    this.groupSearch?.value ?? '',

                status:
                    this.groupStatusFilter?.value ?? '',

            });


        try
        {

            const response =
                await fetch(
                    `/customers/groups/table?${params.toString()}`,
                    {
                        headers: {
                            'Accept':
                                'application/json'
                        }
                    }
                );


            const result =
                await response.json();


            if(!result.success)
            {

                showToast(
                    result.message ??
                    'Unable to load customer groups.',
                    'error'
                );

                return;

            }


            this.groupTable.innerHTML =
                result.html;


            if(this.groupPagination)
            {

                this.groupPagination.innerHTML =
                    result.pagination ?? '';

            }

            /*
            |--------------------------------------------------------------------------
            | Update Customer Groups Tab Count
            |--------------------------------------------------------------------------
            */

            if(this.groupsTabCount)
            {

                this.groupsTabCount.textContent =
                    result.stats?.groups ?? 0;

            }

        }
        catch(error)
        {

            console.error(
                'Customer group table error:',
                error
            );


            showToast(
                'Unable to load customer groups.',
                'error'
            );

        }

    },



    /*
    |--------------------------------------------------------------------------
    | Load Loyalty
    |--------------------------------------------------------------------------
    */

    async loadLoyalty(page = 1)
    {

        if(!this.loyaltyTable)
        {
            return;
        }


        const params =
            new URLSearchParams({

                page: page,

                search:
                    this.loyaltySearch?.value ?? '',

                status:
                    this.loyaltyStatusFilter?.value ?? '',

            });


        try
        {

            const response =
                await fetch(
                    `/customers/loyalty/table?${params.toString()}`,
                    {
                        headers: {
                            'Accept':
                                'application/json'
                        }
                    }
                );


            const result =
                await response.json();


            if(!result.success)
            {

                showToast(
                    result.message ??
                    'Unable to load loyalty records.',
                    'error'
                );

                return;

            }


            this.loyaltyTable.innerHTML =
                result.html;


            if(this.loyaltyPagination)
            {

                this.loyaltyPagination.innerHTML =
                    result.pagination ?? '';

            }


            this.updateLoyaltyStats(
                result.stats
            );

        }
        catch(error)
        {

            console.error(
                'Loyalty table error:',
                error
            );


            showToast(
                'Unable to load loyalty records.',
                'error'
            );

        }

    },



    /*
    |--------------------------------------------------------------------------
    | Update Customer Statistics
    |--------------------------------------------------------------------------
    */

    updateCustomerStats(stats)
    {

        if(!stats)
        {
            return;
        }


        const total =
            document.getElementById(
                'totalCustomersCount'
            );


        const active =
            document.getElementById(
                'activeCustomersCount'
            );


        const balance =
            document.getElementById(
                'customerBalance'
            );


        if(total)
        {

            total.innerText =
                stats.total ?? 0;

        }


        if(active)
        {

            active.innerText =
                stats.active ?? 0;

        }


        if(balance)
        {

            balance.innerText =
                stats.balance ?? '0.00';

        }

    },



    /*
    |--------------------------------------------------------------------------
    | Update Loyalty Statistics
    |--------------------------------------------------------------------------
    */

    updateLoyaltyStats(stats)
    {

        if(!stats)
        {
            return;
        }


        const points =
            document.getElementById(
                'totalLoyaltyPoints'
            );


        if(points)
        {

            points.innerText =
                stats.points ?? 0;

        }

    },



    /*
    |--------------------------------------------------------------------------
    | Open Inspector
    |--------------------------------------------------------------------------
    */

    async openInspector(id)
    {

        try
        {

            const response =
                await fetch(
                    `/customers/${id}/details`,
                    {
                        headers: {
                            'Accept':
                                'application/json'
                        }
                    }
                );


            const result =
                await response.json();


            if(!result.success)
            {

                showToast(
                    result.message ??
                    'Unable to load customer details.',
                    'error'
                );

                return;

            }


            this.selectedCustomer =
                result.data;


            this.populateInspector(
                result.data
            );


            this.inspector?.show();

        }
        catch(error)
        {

            console.error(
                'Customer inspector error:',
                error
            );


            showToast(
                'Unable to load customer details.',
                'error'
            );

        }

    },

    async openGroupInspector(id)
    {

        if(!id)
        {
            return;
        }


        try
        {

            const response =
                await fetch(
                    `/customers/groups/${id}/details`,
                    {
                        headers: {
                            'Accept':
                                'application/json'
                        }
                    }
                );


            const result =
                await response.json();


            if(!result.success)
            {

                showToast(
                    result.message ??
                    'Unable to load customer group details.',
                    'error'
                );

                return;

            }


            this.populateGroupInspector(
                result.data
            );


            this.customerGroupInspectorInstance?.show();

        }
        catch(error)
        {

            console.error(
                'Customer group inspector error:',
                error
            );


            showToast(
                'Unable to load customer group details.',
                'error'
            );

        }

    },

/*
|--------------------------------------------------------------------------
| Populate Inspector
|--------------------------------------------------------------------------
*/

populateInspector(customer)
{

    /*
    |--------------------------------------------------------------------------
    | Customer Name
    |--------------------------------------------------------------------------
    */

    if(this.inspectorCustomerName)
    {

        this.inspectorCustomerName.innerText =
            customer.full_name ??
            '-';

    }


    /*
    |--------------------------------------------------------------------------
    | Customer Code
    |--------------------------------------------------------------------------
    */

    if(this.inspectorCustomerCode)
    {

        this.inspectorCustomerCode.innerText =
            customer.customer_code ??
            '-';

    }


    /*
    |--------------------------------------------------------------------------
    | Email
    |--------------------------------------------------------------------------
    */

    if(this.inspectorCustomerEmail)
    {

        this.inspectorCustomerEmail.innerText =
            customer.email ??
            '-';

    }


    /*
    |--------------------------------------------------------------------------
    | Phone
    |--------------------------------------------------------------------------
    */

    if(this.inspectorCustomerPhone)
    {

        this.inspectorCustomerPhone.innerText =
            customer.phone ??
            '-';

    }


    /*
    |--------------------------------------------------------------------------
    | Address
    |--------------------------------------------------------------------------
    */

    if(this.inspectorCustomerAddress)
    {

        this.inspectorCustomerAddress.innerText =
            customer.address ??
            '-';

    }


    /*
    |--------------------------------------------------------------------------
    | Customer Group
    |--------------------------------------------------------------------------
    */

    if(this.inspectorCustomerGroup)
    {

        this.inspectorCustomerGroup.innerText =
            customer.customer_group?.name ??
            'No Group';

    }


    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

    if(this.inspectorCustomerStatus)
    {

        this.inspectorCustomerStatus.innerText =
            customer.status
                ? 'Active'
                : 'Inactive';

    }


    /*
    |--------------------------------------------------------------------------
    | Credit Limit
    |--------------------------------------------------------------------------
    */

    if(this.inspectorCustomerCredit)
    {

        this.inspectorCustomerCredit.innerText =
            `₦${Number(
                customer.credit_limit ?? 0
            ).toLocaleString(
                'en-NG',
                {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }
            )}`;

    }


    /*
    |--------------------------------------------------------------------------
    | Balance
    |--------------------------------------------------------------------------
    */

    if(this.inspectorCustomerBalance)
    {

        this.inspectorCustomerBalance.innerText =
            `₦${Number(
                customer.current_balance ?? 0
            ).toLocaleString(
                'en-NG',
                {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }
            )}`;

    }


    /*
    |--------------------------------------------------------------------------
    | Loyalty Points
    |--------------------------------------------------------------------------
    */

    if(this.inspectorCustomerPoints)
    {

        this.inspectorCustomerPoints.innerText =
            Number(
                customer.loyalty_points ?? 0
            ).toLocaleString();

    }

},

    populateGroupInspector(group)
    {

        if(this.customerGroupInspectorName)
        {

            this.customerGroupInspectorName.innerText =
                group.name ??
                '-';

        }


        if(this.customerGroupInspectorCode)
        {

            this.customerGroupInspectorCode.innerText =
                group.code ??
                '-';

        }


        if(this.customerGroupInspectorDescription)
        {

            this.customerGroupInspectorDescription.innerText =
                group.description ??
                'No description provided.';

        }


        if(this.customerGroupInspectorDiscount)
        {

            this.customerGroupInspectorDiscount.innerText =
                `${Number(
                    group.discount_percentage ?? 0
                ).toFixed(2)}%`;

        }


        if(this.customerGroupInspectorCreditLimit)
        {

            this.customerGroupInspectorCreditLimit.innerText =
                `₦${Number(
                    group.credit_limit ?? 0
                ).toLocaleString(
                    'en-NG',
                    {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }
                )}`;

        }


        if(this.customerGroupInspectorCustomers)
        {

            this.customerGroupInspectorCustomers.innerText =
                group.customers_count ??
                0;

        }


        if(this.customerGroupInspectorCreated)
        {

            this.customerGroupInspectorCreated.innerText =
                group.created_at ??
                '-';

        }


        if(this.customerGroupInspectorStatus)
        {

            this.customerGroupInspectorStatus.innerText =
                group.status
                    ? 'Active'
                    : 'Inactive';


            this.customerGroupInspectorStatus.className =
                group.status
                    ? 'badge bg-success-subtle text-success'
                    : 'badge bg-secondary-subtle text-secondary';

        }

    },

    /*
|--------------------------------------------------------------------------
| Open Customer Action Menu
|--------------------------------------------------------------------------
*/

openCustomerActionMenu(button)
{

    const menu =
        document.getElementById(
            'customerGlobalActionMenu'
        );


    if(!menu)
    {
        return;
    }


    const customerId =
        button.dataset.id;

    const customerStatus =
        String(
            button.dataset.status
        ) === '1';
        
        console.log(
    'Customer ID:',
    customerId
);

console.log(
    'Raw status:',
    button.dataset.status
);

console.log(
    'Customer active:',
    customerStatus
);
   /*
|--------------------------------------------------------------------------
| Customer Status Action
|--------------------------------------------------------------------------
*/

const statusAction =
    document.getElementById(
        'customerGlobalStatusAction'
    );


const statusIcon =
    document.getElementById(
        'customerGlobalStatusIcon'
    );


const statusText =
    document.getElementById(
        'customerGlobalStatusText'
    );


if(statusAction)
{

    statusAction.dataset.action =
        customerStatus
            ? 'disable'
            : 'enable';


    statusAction.classList.remove(
        'text-warning',
        'text-success'
    );


    statusAction.classList.add(
        customerStatus
            ? 'text-warning'
            : 'text-success'
    );

}


if(statusText)
{

    statusText.textContent =
        customerStatus
            ? 'Disable'
            : 'Enable';

}


if(statusIcon)
{

    statusIcon.className =
        customerStatus
            ? 'bi bi-pause-circle me-2'
            : 'bi bi-check-circle me-2';

}

    if(!customerId)
    {
        return;
    }


    this.customerActionCustomerId =
        customerId;


    this.customerActionCustomerName =
        button.dataset.name ?? 'Customer';


    /*
    |--------------------------------------------------------------------------
    | Position
    |--------------------------------------------------------------------------
    */

    const rect =
        button.getBoundingClientRect();


    menu.style.position =
        'fixed';


    menu.style.zIndex =
        '1080';


    menu.classList.add(
        'show'
    );


    /*
    |--------------------------------------------------------------------------
    | Measure Menu
    |--------------------------------------------------------------------------
    */

    const menuRect =
        menu.getBoundingClientRect();


    let top =
        rect.bottom + 4;


    let left =
        rect.right - menuRect.width;


    /*
    |--------------------------------------------------------------------------
    | Keep Inside Viewport
    |--------------------------------------------------------------------------
    */

    if(
        left < 8
    )
    {

        left = 8;

    }


    if(
        left + menuRect.width >
        window.innerWidth - 8
    )
    {

        left =
            window.innerWidth -
            menuRect.width -
            8;

    }


    /*
    |--------------------------------------------------------------------------
    | Open Above If Necessary
    |--------------------------------------------------------------------------
    */

    if(
        top + menuRect.height >
        window.innerHeight - 8
    )
    {

        top =
            rect.top -
            menuRect.height -
            4;

    }


    menu.style.top =
        `${top}px`;


    menu.style.left =
        `${left}px`;


    button.setAttribute(
        'aria-expanded',
        'true'
    );

},


/*
|--------------------------------------------------------------------------
| Close Customer Action Menu
|--------------------------------------------------------------------------
*/

closeCustomerActionMenu()
{

    const menu =
        document.getElementById(
            'customerGlobalActionMenu'
        );


    if(!menu)
    {
        return;
    }


    menu.classList.remove(
        'show'
    );


    menu.style.top =
        '';

    menu.style.left =
        '';


    this.customerActionCustomerId =
        null;

},


/*
|--------------------------------------------------------------------------
| Handle Customer Action
|--------------------------------------------------------------------------
*/

handleCustomerAction(action)
{

    const id =
        this.customerActionCustomerId;


    const name =
        this.customerActionCustomerName;


    if(!id)
    {
        return;
    }


    this.closeCustomerActionMenu();


    switch(action)
    {

        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        case 'view':

            this.openInspector(
                id
            );

            break;


        /*
        |--------------------------------------------------------------------------
        | Edit
        |--------------------------------------------------------------------------
        */

        case 'edit':

            this.openEditModal(
                id
            );

            break;


        /*
        |--------------------------------------------------------------------------
        | Enable / Disable
        |--------------------------------------------------------------------------
        */        

        case 'enable':

            this.confirmCustomerStatus(
                id,
                name,
                'enable'
            );

            break;


        case 'disable':

            this.confirmCustomerStatus(
                id,
                name,
                'disable'
            );

            break;


        /*
        |--------------------------------------------------------------------------
        | Delete
        |--------------------------------------------------------------------------
        */

        case 'delete':

            this.confirmDelete(
                id,
                name
            );

            break;

    }

},
    /*
    |--------------------------------------------------------------------------
    | Open Create Modal
    |--------------------------------------------------------------------------
    */

    openCreateModal()
    {

        this.resetForm();


        if(this.customerModalTitle)
        {

            this.customerModalTitle.innerText =
                'Add Customer';

        }


        this.customerModal?.show();

    },

    openCreateGroupModal()
    {

        if(this.customerGroupForm)
        {

            this.customerGroupForm.reset();

        }


        if(this.customerGroupId)
        {

            this.customerGroupId.value =
                '';

        }


        if(this.customerGroupModalTitle)
        {

            this.customerGroupModalTitle.innerText =
                'Add Customer Group';

        }


        this.customerGroupModal?.show();

    },



    /*
    |--------------------------------------------------------------------------
    | Open Edit Modal
    |--------------------------------------------------------------------------
    */

    async openEditModal(id)
    {

        try
        {

            const response =
                await fetch(
                    `/customers/${id}/details`,
                    {
                        headers: {
                            'Accept':
                                'application/json'
                        }
                    }
                );


            const result =
                await response.json();


            if(!result.success)
            {

                showToast(
                    result.message ??
                    'Unable to load customer.',
                    'error'
                );

                return;

            }


            this.populateForm(
                result.data
            );


            if(this.customerModalTitle)
            {

                this.customerModalTitle.innerText =
                    'Edit Customer';

            }


            this.customerModal?.show();

        }
        catch(error)
        {

            console.error(
                'Customer edit error:',
                error
            );


            showToast(
                'Unable to load customer.',
                'error'
            );

        }

    },

    async openEditGroupModal(id)
    {

        if(!id)
        {
            return;
        }


        try
        {

            const response =
                await fetch(
                    `/customers/groups/${id}/details`,
                    {
                        headers: {
                            'Accept':
                                'application/json'
                        }
                    }
                );


            const result =
                await response.json();


            if(!result.success)
            {

                showToast(
                    result.message ??
                    'Unable to load customer group.',
                    'error'
                );

                return;

            }


            this.populateGroupForm(
                result.data
            );


            if(this.customerGroupModalTitle)
            {

                this.customerGroupModalTitle.innerText =
                    'Edit Customer Group';

            }


            this.customerGroupModal?.show();

        }
        catch(error)
        {

            console.error(
                'Customer group edit error:',
                error
            );


            showToast(
                'Unable to load customer group.',
                'error'
            );

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Populate Customer Form
    |--------------------------------------------------------------------------
    */

    populateForm(customer)
    {

        if(!this.customerForm)
        {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Reset Form
        |--------------------------------------------------------------------------
        */

        this.customerForm.reset();


        /*
        |--------------------------------------------------------------------------
        | Customer ID
        |--------------------------------------------------------------------------
        */

        if(this.customerId)
        {

            this.customerId.value =
                customer.id ?? '';

        }


        /*
        |--------------------------------------------------------------------------
        | Basic Fields
        |--------------------------------------------------------------------------
        */

        const fields = [

            'first_name',

            'last_name',

            'phone',

            'email',

            'address',

        ];


        fields.forEach(
            field => {

                const element =
                    this.customerForm.querySelector(
                        `[name="${field}"]`
                    );


                if(element)
                {

                    element.value =
                        customer[field] ?? '';

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Customer Group
        |--------------------------------------------------------------------------
        */

        const groupSelect =
            this.customerForm.querySelector(
                '[name="customer_group_id"]'
            );


        if(groupSelect)
        {

            groupSelect.value =
                customer.customer_group_id ?? '';

        }


        /*
        |--------------------------------------------------------------------------
        | Customer Type
        |--------------------------------------------------------------------------
        */

        const typeSelect =
            this.customerForm.querySelector(
                '[name="customer_type"]'
            );


        if(typeSelect)
        {

            typeSelect.value =
                customer.customer_type ?? 'Walk-in';

        }


        /*
        |--------------------------------------------------------------------------
        | Default Credit Limit
        |--------------------------------------------------------------------------
        |
        | Credit limit is controlled by the selected customer group.
        | It is therefore not populated from the customer record.
        |
        |--------------------------------------------------------------------------
        */


        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        |
        | Status is no longer part of the customer form.
        |
        |--------------------------------------------------------------------------
        */

    },


    populateGroupForm(group)
    {

        if(!this.customerGroupForm)
        {
            return;
        }


        this.customerGroupForm.reset();


        if(this.customerGroupId)
        {

            this.customerGroupId.value =
                group.id ?? '';

        }


        const fields = [

            'name',

            'code',

            'description',

            'discount_percentage',

            'credit_limit',

        ];


        fields.forEach(
            field => {

                const element =
                    this.customerGroupForm.querySelector(
                        `[name="${field}"]`
                    );


                if(element)
                {

                    element.value =
                        group[field] ?? '';

                }

            }
        );

    },

       /*
    |--------------------------------------------------------------------------
    | Save Customer
    |--------------------------------------------------------------------------
    */

    async saveCustomer()
    {

        if(!this.customerForm)
        {
            return;
        }


        const formData =
            new FormData(
                this.customerForm
            );


        const id =
            this.customerId?.value;


        const isEdit =
            !!id;


        const url =
            isEdit
                ? `/customers/${id}`
                : '/customers';


        /*
        |--------------------------------------------------------------------------
        | Laravel Method Spoofing
        |--------------------------------------------------------------------------
        */

        if(isEdit)
        {

            formData.append(
                '_method',
                'PUT'
            );

        }


        if(this.saveCustomerBtn)
        {

            this.saveCustomerBtn.disabled =
                true;

        }


        try
        {

            const response =
                await fetch(
                    url,
                    {

                        method: 'POST',

                        headers: {

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                document
                                    .querySelector(
                                        'meta[name="csrf-token"]'
                                    )
                                    .content,

                        },

                        body:
                            formData

                    }
                );


            const result =
                await response.json();


            if(result.success)
            {

                showToast(
                    result.message ??
                    'Customer saved successfully.',
                    'success'
                );


                this.customerModal?.hide();


                await this.loadCustomers();

            }
            else
            {

                /*
                |--------------------------------------------------------------------------
                | Validation Errors
                |--------------------------------------------------------------------------
                */

                if(result.errors)
                {

                    const firstError =
                        Object.values(
                            result.errors
                        )[0]?.[0];


                    showToast(
                        firstError ??
                        result.message ??
                        'Unable to save customer.',
                        'error'
                    );

                }
                else
                {

                    showToast(
                        result.message ??
                        'Unable to save customer.',
                        'error'
                    );

                }

            }

        }
        catch(error)
        {

            console.error(
                'Customer save error:',
                error
            );


            showToast(
                'Something went wrong.',
                'error'
            );

        }
        finally
        {

            if(this.saveCustomerBtn)
            {

                this.saveCustomerBtn.disabled =
                    false;

            }

        }

    },

    async saveCustomerGroup()
    {

        if(!this.customerGroupForm)
        {
            return;
        }


        const formData =
            new FormData(
                this.customerGroupForm
            );


        const id =
            this.customerGroupId?.value;


        const isEdit =
            !!id;


        const url =
            isEdit
                ? `/customers/groups/${id}`
                : '/customers/groups';


        /*
        |--------------------------------------------------------------------------
        | Method Spoofing
        |--------------------------------------------------------------------------
        */

        if(isEdit)
        {

            formData.append(
                '_method',
                'PUT'
            );

        }


        if(this.saveCustomerGroupBtn)
        {

            this.saveCustomerGroupBtn.disabled =
                true;

        }


        try
        {

            const response =
                await fetch(
                    url,
                    {

                        method:
                            'POST',

                        headers: {

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                document
                                    .querySelector(
                                        'meta[name="csrf-token"]'
                                    )
                                    .content,

                        },

                        body:
                            formData

                    }
                );


            const result =
                await response.json();


            if(result.success)
            {

                showToast(
                    result.message ??
                    'Customer group saved successfully.',
                    'success'
                );


                this.customerGroupModal?.hide();


                await this.loadGroups(
                    1
                );

            }
            else
            {

                showToast(
                    result.message ??
                    'Unable to save customer group.',
                    'error'
                );


            }

        }
        catch(error)
        {

            console.error(
                'Customer group save error:',
                error
            );


            showToast(
                'Something went wrong.',
                'error'
            );

        }
        finally
        {

            if(this.saveCustomerGroupBtn)
            {

                this.saveCustomerGroupBtn.disabled =
                    false;

            }

        }

    },

    /*
    |--------------------------------------------------------------------------
    | Delete Customer
    |--------------------------------------------------------------------------
    */

    async deleteCustomer(id)
    {

        if(!id)
        {
            return;
        }


        const confirmed =
            await this.confirmDelete();


        if(!confirmed)
        {
            return;
        }


        try
        {

            const response =
                await fetch(
                    `/customers/${id}`,
                    {

                        method: 'DELETE',

                        headers: {

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                document
                                .querySelector(
                                    'meta[name="csrf-token"]'
                                )
                                .content,

                        }

                    }
                );


            const result =
                await response.json();


            if(result.success)
            {

                showToast(
                    result.message ??
                    'Customer deleted successfully.',
                    'success'
                );


                this.loadCustomers();

            }
            else
            {

                showToast(
                    result.message ??
                    'Unable to delete customer.',
                    'error'
                );

            }

        }
        catch(error)
        {

            console.error(
                'Customer delete error:',
                error
            );


            showToast(
                'Something went wrong.',
                'error'
            );

        }

    },



    /*
    |--------------------------------------------------------------------------
    | Delete Confirmation
    |--------------------------------------------------------------------------
    */

    confirmDelete()
    {

        return new Promise(
            resolve => {

                const confirmed =
                    window.confirm(
                        'Are you sure you want to delete this customer?'
                    );


                resolve(
                    confirmed
                );

            }
        );

    },

    confirmGroupDelete(id, name)
    {

        this.groupConfirmAction = {
            type: 'delete',
            id: id,
            name: name
        };


        if(this.customerGroupConfirmTitle)
        {

            this.customerGroupConfirmTitle.innerText =
                'Delete Customer Group';

        }


        if(this.customerGroupConfirmMessage)
        {

            this.customerGroupConfirmMessage.innerText =
                `Delete "${name}"?`;

        }


        if(this.customerGroupConfirmDescription)
        {

            this.customerGroupConfirmDescription.innerText =
                'This action cannot be undone. The group can only be deleted when no customers are assigned to it.';

        }


        if(this.customerGroupConfirmIcon)
        {

            this.customerGroupConfirmIcon.className =
                'bi bi-trash fs-4 text-danger';

        }


        if(this.customerGroupConfirmBtn)
        {

            this.customerGroupConfirmBtn.className =
                'btn btn-danger';

            this.customerGroupConfirmBtn.innerText =
                'Delete Group';

        }


        this.customerGroupConfirmModal?.show();

    },

    confirmGroupStatus(id, name, action)
    {

        this.groupConfirmAction = {
            type: action,
            id: id,
            name: name
        };


        const isEnable =
            action === 'enable';


        if(this.customerGroupConfirmTitle)
        {

            this.customerGroupConfirmTitle.innerText =
                isEnable
                    ? 'Enable Customer Group'
                    : 'Disable Customer Group';

        }


        if(this.customerGroupConfirmMessage)
        {

            this.customerGroupConfirmMessage.innerText =
                isEnable
                    ? `Enable "${name}"?`
                    : `Disable "${name}"?`;

        }


        if(this.customerGroupConfirmDescription)
        {

            this.customerGroupConfirmDescription.innerText =
                isEnable
                    ? 'Customers will be able to use this group.'
                    : 'This group will no longer be available for active customer group usage.';

        }


        if(this.customerGroupConfirmIcon)
        {

            this.customerGroupConfirmIcon.className =
                isEnable
                    ? 'bi bi-check-circle fs-4 text-success'
                    : 'bi bi-pause-circle fs-4 text-warning';

        }


        if(this.customerGroupConfirmBtn)
        {

            this.customerGroupConfirmBtn.className =
                isEnable
                    ? 'btn btn-success'
                    : 'btn btn-warning';

            this.customerGroupConfirmBtn.innerText =
                isEnable
                    ? 'Enable Group'
                    : 'Disable Group';

        }


        this.customerGroupConfirmModal?.show();

    },

    /*
    |--------------------------------------------------------------------------
    | Confirm Customer Status
    |--------------------------------------------------------------------------
    */

    confirmCustomerStatus(
        id,
        name,
        action
    )
    {

        this.customerStatusAction = {

            type:
                action,

            id:
                id,

            name:
                name

        };


        const isEnable =
            action === 'enable';


        /*
        |--------------------------------------------------------------------------
        | Confirmation Title
        |--------------------------------------------------------------------------
        */

        if(this.customerConfirmTitle)
        {

            this.customerConfirmTitle.innerText =
                isEnable
                    ? 'Enable Customer'
                    : 'Disable Customer';

        }


        /*
        |--------------------------------------------------------------------------
        | Confirmation Message
        |--------------------------------------------------------------------------
        */

        if(this.customerConfirmMessage)
        {

            this.customerConfirmMessage.innerText =
                isEnable
                    ? `Enable "${name}"?`
                    : `Disable "${name}"?`;

        }


        /*
        |--------------------------------------------------------------------------
        | Confirmation Description
        |--------------------------------------------------------------------------
        */

        if(this.customerConfirmDescription)
        {

            this.customerConfirmDescription.innerText =
                isEnable
                    ? 'This customer will become active and available for normal transactions.'
                    : 'This customer will become inactive and will no longer be available for active transactions.';

        }


        /*
        |--------------------------------------------------------------------------
        | Confirmation Icon
        |--------------------------------------------------------------------------
        */

        if(this.customerConfirmIcon)
        {

            this.customerConfirmIcon.className =
                isEnable
                    ? 'bi bi-check-circle fs-4 text-success'
                    : 'bi bi-pause-circle fs-4 text-warning';

        }


        /*
        |--------------------------------------------------------------------------
        | Confirmation Button
        |--------------------------------------------------------------------------
        */

        if(this.customerConfirmBtn)
        {

            this.customerConfirmBtn.className =
                isEnable
                    ? 'btn btn-success'
                    : 'btn btn-warning';


            this.customerConfirmBtn.innerText =
                isEnable
                    ? 'Enable Customer'
                    : 'Disable Customer';

        }


        /*
        |--------------------------------------------------------------------------
        | Show Confirmation
        |--------------------------------------------------------------------------
        */

        this.customerConfirmModal?.show();

    },

  async executeGroupConfirmation()
    {

        const action =
            this.groupConfirmAction;


        if(!action)
        {
            return;
        }


        let url;

        let method = 'POST';


        /*
        |--------------------------------------------------------------------------
        | Delete
        |--------------------------------------------------------------------------
        */

        if(action.type === 'delete')
        {

            url =
                `/customers/groups/${action.id}`;

            method =
                'DELETE';

        }


        /*
        |--------------------------------------------------------------------------
        | Enable
        |--------------------------------------------------------------------------
        */

        else if(action.type === 'enable')
        {

            url =
                `/customers/groups/${action.id}/enable`;

            method =
                'PATCH';

        }


        /*
        |--------------------------------------------------------------------------
        | Disable
        |--------------------------------------------------------------------------
        */

        else if(action.type === 'disable')
        {

            url =
                `/customers/groups/${action.id}/disable`;

            method =
                'PATCH';

        }


        if(!url)
        {
            return;
        }


        if(this.customerGroupConfirmBtn)
        {

            this.customerGroupConfirmBtn.disabled =
                true;

        }


        try
        {

            const response =
                await fetch(
                    url,
                    {

                        method:
                            method,

                        headers: {

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                document
                                    .querySelector(
                                        'meta[name="csrf-token"]'
                                    )
                                    .content,

                        }

                    }
                );


            const result =
                await response.json();


            if(result.success)
            {

                showToast(
                    result.message ??
                    'Action completed successfully.',
                    'success'
                );


                this.customerGroupConfirmModal?.hide();


                this.groupConfirmAction =
                    null;


                await this.loadGroups(
                    1
                );

            }
            else
            {

                showToast(
                    result.message ??
                    'Unable to complete the action.',
                    'error'
                );

            }

        }
        catch(error)
        {

            console.error(
                'Customer group action error:',
                error
            );


            showToast(
                'Something went wrong.',
                'error'
            );

        }
        finally
        {

            if(this.customerGroupConfirmBtn)
            {

                this.customerGroupConfirmBtn.disabled =
                    false;

            }

        }

    },

    /*
    |--------------------------------------------------------------------------
    | Execute Customer Status Confirmation
    |--------------------------------------------------------------------------
    */

    async executeCustomerStatusConfirmation()
    {

        const action =
            this.customerStatusAction;


        if(!action)
        {
            return;
        }


        let url;


        /*
        |--------------------------------------------------------------------------
        | Enable
        |--------------------------------------------------------------------------
        */

        if(action.type === 'enable')
        {

            url =
                `/customers/${action.id}/enable`;

        }


        /*
        |--------------------------------------------------------------------------
        | Disable
        |--------------------------------------------------------------------------
        */

        else if(action.type === 'disable')
        {

            url =
                `/customers/${action.id}/disable`;

        }


        if(!url)
        {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Disable Confirmation Button
        |--------------------------------------------------------------------------
        */

        if(this.customerConfirmBtn)
        {

            this.customerConfirmBtn.disabled =
                true;

        }


        try
        {

            const response =
                await fetch(
                    url,
                    {

                        method:
                            'PATCH',

                        headers: {

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                document
                                    .querySelector(
                                        'meta[name="csrf-token"]'
                                    )
                                    .content,

                        }

                    }
                );


            const result =
                await response.json();


            /*
            |--------------------------------------------------------------------------
            | Success
            |--------------------------------------------------------------------------
            */

            if(result.success)
            {

                showToast(
                    result.message ??
                    'Customer status updated successfully.',
                    'success'
                );


                this.customerConfirmModal?.hide();


                this.customerStatusAction =
                    null;


                await this.loadCustomers(
                    1
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Failure
            |--------------------------------------------------------------------------
            */

            else
            {

                showToast(
                    result.message ??
                    'Unable to update customer status.',
                    'error'
                );

            }

        }
        catch(error)
        {

            console.error(
                'Customer status error:',
                error
            );


            showToast(
                'Something went wrong.',
                'error'
            );

        }
        finally
        {

            if(this.customerConfirmBtn)
            {

                this.customerConfirmBtn.disabled =
                    false;

            }

        }

    },

    /*
    |--------------------------------------------------------------------------
    | Reset Form
    |--------------------------------------------------------------------------
    */

    resetForm()
    {

        if(this.customerForm)
        {

            this.customerForm.reset();

        }


        if(this.customerId)
        {

            this.customerId.value =
                '';

        }


        if(this.customerModalTitle)
        {

            this.customerModalTitle.innerText =
                'Add Customer';

        }

    },



    /*
    |--------------------------------------------------------------------------
    | Reset Module
    |--------------------------------------------------------------------------
    */

    reset()
    {

        clearTimeout(
            this.searchTimer
        );


        this.selectedCustomer =
            null;


        this.activeTab =
            'groups';


        this.resetForm();

    }


};



/*
|--------------------------------------------------------------------------
| DOM Ready
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    () => {

        CustomerManagement.init();

    }
);