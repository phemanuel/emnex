<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Customer;
use App\Models\CustomerGroup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\ActivityLogger;

class CustomerController extends BaseController
{
    protected ActivityLogger $activityLogger;


    public function __construct(ActivityLogger $activityLogger)
    {
        parent::__construct();

        $this->activityLogger = $activityLogger;
    }

    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('customers.view')) {

            abort(
                403,
                'You do not have permission to view customers.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Customer Groups
        |--------------------------------------------------------------------------
        */

        $groups = CustomerGroup::query()

            ->where(
                'company_id',
                $this->companyId
            )

            ->orderBy(
                'name'
            )

            ->get();


        /*
        |--------------------------------------------------------------------------
        | Initial Customer Statistics
        |--------------------------------------------------------------------------
        */

        $customerQuery = Customer::query()

            ->where(
                'company_id',
                $this->companyId
            );


        $stats = [

            'total' =>
                (clone $customerQuery)
                    ->count(),

            'active' =>
                (clone $customerQuery)
                    ->where(
                        'status',
                        true
                    )
                    ->count(),

            'inactive' =>
                (clone $customerQuery)
                    ->where(
                        'status',
                        false
                    )
                    ->count(),

            'balance' =>
                (float) (
                    clone $customerQuery
                )
                ->sum('current_balance'),

            'loyalty' =>
                (int) (
                    clone $customerQuery
                )
                ->sum('loyalty_points'),

            'groups' =>
                CustomerGroup::query()
                    ->where(
                        'company_id',
                        $this->companyId
                    )
                    ->count(),

        ];


        /*
        |--------------------------------------------------------------------------
        | Initial Customer Table
        |--------------------------------------------------------------------------
        */

        $customers = (clone $customerQuery)

            ->with([
                'customerGroup',
            ])

            ->latest()

            ->paginate(15)

            ->withQueryString();

        
            /*
            |--------------------------------------------------------------------------
            | Initial Loyalty Table
            |--------------------------------------------------------------------------
            */

            $loyaltyCustomers = (clone $customerQuery)

                ->with([
                    'customerGroup',
                ])

                ->latest()

                ->paginate(15)

                ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Customer Groups
        |--------------------------------------------------------------------------
        */

        $customerGroups =
            CustomerGroup::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->withCount(
                    'customers'
                )

                ->latest()

                ->get();


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view(
            'customers.index',
            compact(
                'stats',
                'groups',
                'customers',
                'customerGroups',
                'loyaltyCustomers'
            )
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Customer Table
    |--------------------------------------------------------------------------
    */

    public function table(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('customers.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view customers.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */

        $customers = Customer::query()

            ->where(
                'company_id',
                $this->companyId
            )

            ->with([
                'customerGroup',
            ]);


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search =
                trim(
                    $request->search
                );


            $customers->where(

                function ($query) use ($search) {

                    $query

                        ->where(
                            'customer_code',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'first_name',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'last_name',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'email',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'phone',
                            'like',
                            "%{$search}%"
                        );

                }

            );

        }


        /*
        |--------------------------------------------------------------------------
        | Customer Group
        |--------------------------------------------------------------------------
        */

        if ($request->filled('group')) {

            $customers->where(
                'customer_group_id',
                $request->group
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Customer Type
        |--------------------------------------------------------------------------
        */

        if ($request->filled('type')) {

            $customers->where(
                'customer_type',
                $request->type
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            if ($request->status === 'active') {

                $customers->where(
                    'status',
                    true
                );

            }

            elseif ($request->status === 'inactive') {

                $customers->where(
                    'status',
                    false
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $customers = $customers

            ->latest()

            ->paginate(15)

            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $statsQuery = Customer::query()

            ->where(
                'company_id',
                $this->companyId
            );


        $stats = [

            'total' =>
                (clone $statsQuery)
                    ->count(),

            'active' =>
                (clone $statsQuery)
                    ->where(
                        'status',
                        true
                    )
                    ->count(),

            'inactive' =>
                (clone $statsQuery)
                    ->where(
                        'status',
                        false
                    )
                    ->count(),

            'balance' =>
                (float) (
                    clone $statsQuery
                )
                ->sum('current_balance'),

            'loyalty' =>
                (int) (
                    clone $statsQuery
                )
                ->sum('loyalty_points'),

        ];


        /*
        |--------------------------------------------------------------------------
        | Table HTML
        |--------------------------------------------------------------------------
        */

        $html = view(

            'customers.partials.table',

            compact(
                'customers'
            )

        )->render();


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'html' =>
                $html,

            'pagination' =>
                $customers
                    ->links()
                    ->render(),

            'stats' =>
                $stats,

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Customer Details
    |--------------------------------------------------------------------------
    */

    public function details(
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('customers.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view customer details.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Customer
        |--------------------------------------------------------------------------
        */

        $customer =
            Customer::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->with([
                    'customerGroup',
                    'orders',
                    'payments',
                ])

                ->findOrFail(
                    $id
                );


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'data' => [

                'id' =>
                    $customer->id,

                'customer_code' =>
                    $customer->customer_code,

                'first_name' =>
                    $customer->first_name,

                'last_name' =>
                    $customer->last_name,

                'full_name' =>
                    $customer->fullName(),

                'email' =>
                    $customer->email,

                'phone' =>
                    $customer->phone,

                'address' =>
                    $customer->address,

               'customer_type' =>
                    $customer->customer_type,

                'customer_group_id' =>
                    $customer->customer_group_id,

                'customer_group' => [

                    'id' =>
                        $customer
                            ->customerGroup
                            ?->id,

                    'name' =>
                        $customer
                            ->customerGroup
                            ?->name,

                ],

                'credit_limit' =>
                    $customer->credit_limit,

                'current_balance' =>
                    $customer->current_balance,

                'available_credit' =>
                    max(
                        0,
                        (float) $customer->credit_limit -
                        (float) $customer->current_balance
                    ),

                'loyalty_points' =>
                    $customer->loyalty_points,

                'last_purchase_date' =>
                    $customer
                        ->last_purchase_date
                        ?->format('Y-m-d'),

                'status' =>
                    (bool) $customer->status,

                'orders_count' =>
                    $customer->orders->count(),

                'payments_count' =>
                    $customer->payments->count(),

            ],

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Store Customer
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('customers.create')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to create customers.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([

                'customer_code' => [

                    'nullable',

                    'string',

                    'max:255',

                    Rule::unique(
                        'customers',
                        'customer_code'
                    )->where(
                        fn ($query) =>
                            $query->where(
                                'company_id',
                                $this->companyId
                            )
                    ),

                ],

                'customer_group_id' => [

                    'nullable',

                    'integer',

                    Rule::exists(
                        'customer_groups',
                        'id'
                    )->where(
                        fn ($query) =>
                            $query->where(
                                'company_id',
                                $this->companyId
                            )
                            ->where(
                                'status',
                                true
                            )
                    ),

                ],

                'first_name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'last_name' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'email' => [
                    'nullable',
                    'email',
                    'max:255',
                ],

                'phone' => [
                    'nullable',
                    'string',
                    'max:30',
                ],

                'address' => [
                    'nullable',
                    'string',
                ],

                'customer_type' => [
                    'required',
                    'string',
                    'max:255',
                ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | Generate Customer Code
        |--------------------------------------------------------------------------
        */

        $customerCode =
            $validated['customer_code']
            ??
            'CUS-' .
            strtoupper(
                str_pad(
                    (string) (
                        Customer::withTrashed()
                            ->where(
                                'company_id',
                                $this->companyId
                            )
                            ->count() + 1
                    ),
                    5,
                    '0',
                    STR_PAD_LEFT
                )
            );

            /*
        |--------------------------------------------------------------------------
        | Customer Group
        |--------------------------------------------------------------------------
        */

        $customerGroup = null;


        if (! empty($validated['customer_group_id'])) {

            $customerGroup =
                CustomerGroup::query()

                    ->where(
                        'company_id',
                        $this->companyId
                    )

                    ->findOrFail(
                        $validated['customer_group_id']
                    );

        }

        /*
        |--------------------------------------------------------------------------
        | Create
        |--------------------------------------------------------------------------
        */

        $customer =
            Customer::create([

                'company_id' =>
                    $this->companyId,

                'customer_group_id' =>
                    $validated['customer_group_id']
                    ?? null,

                'customer_code' =>
                    $customerCode,

                'first_name' =>
                    $validated['first_name'],

                'last_name' =>
                    $validated['last_name']
                    ?? null,

                'email' =>
                    $validated['email']
                    ?? null,

                'phone' =>
                    $validated['phone']
                    ?? null,

                'address' =>
                    $validated['address']
                    ?? null,

                /*
                |--------------------------------------------------------------------------
                | Credit
                |--------------------------------------------------------------------------
                |
                | Credit limit is now controlled by the customer's group.
                | Customer starts with zero outstanding balance.
                |
                */

                'credit_limit' =>
                $customerGroup
                    ? (float) $customerGroup->credit_limit
                    : 0,

                'current_balance' =>
                    0,

                'customer_type' =>
                    $validated['customer_type'],

                'loyalty_points' =>
                    0,

                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                |
                | Every newly created customer starts as Active.
                | Enable/Disable is handled separately.
                |
                */

                'status' =>
                    true,

                'created_by' =>
                    auth()->id(),

            ]);


        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        $this->activityLogger->log(

            'customers',

            'create',

            'Created customer: ' .
                $customer->displayName(),

            $customer,

            null,

            $customer->toArray()

        );


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'message' =>
                'Customer created successfully.',

            'data' =>
                $customer,

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Update Customer
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('customers.update')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to update customers.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Customer
        |--------------------------------------------------------------------------
        */

        $customer =
            Customer::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->findOrFail(
                    $id
                );


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([                

                'customer_group_id' => [

                    'nullable',

                    'integer',

                    Rule::exists(
                        'customer_groups',
                        'id'
                    )->where(
                        fn ($query) =>
                            $query->where(
                                'company_id',
                                $this->companyId
                            )
                    ),

                ],

                'first_name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'last_name' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'email' => [
                    'nullable',
                    'email',
                    'max:255',
                ],

                'phone' => [
                    'nullable',
                    'string',
                    'max:30',
                ],

                'address' => [
                    'nullable',
                    'string',
                ],               

                'customer_type' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | Old Values
        |--------------------------------------------------------------------------
        */

        $oldValues =
            $customer->toArray();


        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $customer->update([

            'customer_group_id' =>
                $validated['customer_group_id']
                ?? null,            

            'first_name' =>
                $validated['first_name'],

            'last_name' =>
                $validated['last_name']
                ?? null,

            'email' =>
                $validated['email']
                ?? null,

            'phone' =>
                $validated['phone']
                ?? null,

            'address' =>
                $validated['address']
                ?? null,           

            'customer_type' =>
                $validated['customer_type']
                ?? 'Walk-in',

            'updated_by' =>
                auth()->id(),

        ]);


        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        $this->activityLogger->log(

            'customers',

            'update',

            'Updated customer: ' .
                $customer->displayName(),

            $customer,

            $oldValues,

            $customer->fresh()->toArray()

        );


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'message' =>
                'Customer updated successfully.',

            'data' =>
                $customer->fresh(),

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Delete Customer
    |--------------------------------------------------------------------------
    */

    public function destroy(
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('customers.delete')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to delete customers.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Customer
        |--------------------------------------------------------------------------
        */

        $customer =
            Customer::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->findOrFail(
                    $id
                );


        /*
        |--------------------------------------------------------------------------
        | Old Values
        |--------------------------------------------------------------------------
        */

        $oldValues =
            $customer->toArray();


        /*
        |--------------------------------------------------------------------------
        | Delete
        |--------------------------------------------------------------------------
        */

        $customer->delete();


        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        $this->activityLogger->log(

            'customers',

            'delete',

            'Deleted customer: ' .
                $customer->displayName(),

            $customer,

            $oldValues,

            null

        );


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'message' =>
                'Customer deleted successfully.',

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Enable Customer
    |--------------------------------------------------------------------------
    */

    public function enable(
        int $id
    ): JsonResponse {

        return $this->changeCustomerStatus(
            $id,
            true
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Disable Customer
    |--------------------------------------------------------------------------
    */

    public function disable(
        int $id
    ): JsonResponse {

        return $this->changeCustomerStatus(
            $id,
            false
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Change Customer Status
    |--------------------------------------------------------------------------
    */

    private function changeCustomerStatus(
        int $id,
        bool $status
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('customers.update')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to update customers.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Customer
        |--------------------------------------------------------------------------
        */

        $customer =
            Customer::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->findOrFail(
                    $id
                );


        /*
        |--------------------------------------------------------------------------
        | Old Values
        |--------------------------------------------------------------------------
        */

        $oldValues =
            $customer->toArray();


        /*
        |--------------------------------------------------------------------------
        | Update Status
        |--------------------------------------------------------------------------
        */

        $customer->update([

            'status' =>
                $status,

            'updated_by' =>
                auth()->id(),

        ]);


        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        $this->activityLogger->log(

            'customers',

            $status
                ? 'enable'
                : 'disable',

            ($status
                ? 'Enabled customer: '
                : 'Disabled customer: ')
                .
                $customer->displayName(),

            $customer,

            $oldValues,

            $customer->fresh()->toArray()

        );


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'message' =>
                $status
                    ? 'Customer enabled successfully.'
                    : 'Customer disabled successfully.',

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Customer Groups
    |--------------------------------------------------------------------------
    */

    public function groups(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('customer_groups.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view customer groups.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Query
        |--------------------------------------------------------------------------
        */

        $groups =
            CustomerGroup::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->withCount(
                    'customers'
                );


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search =
                trim(
                    $request->search
                );


            $groups->where(

                function ($query) use ($search) {

                    $query

                        ->where(
                            'name',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'code',
                            'like',
                            "%{$search}%"
                        );

                }

            );

        }


        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            if ($request->status === 'active') {

                $groups->where(
                    'status',
                    true
                );

            }

            elseif ($request->status === 'inactive') {

                $groups->where(
                    'status',
                    false
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $groups =
            $groups

                ->latest()

                ->paginate(10)

                ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Table
        |--------------------------------------------------------------------------
        */

        $html = view(

            'customers.partials.groups-table',

            compact(
                'groups'
            )

        )->render();


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'html' =>
                $html,

            'pagination' =>
                $groups
                    ->links()
                    ->render(),

            'stats' => [

                'groups' =>
                    CustomerGroup::query()
                        ->where(
                            'company_id',
                            $this->companyId
                        )
                        ->count(),

                'total' =>
                    $groups->total(),

                'active' =>
                    CustomerGroup::query()
                        ->where(
                            'company_id',
                            $this->companyId
                        )
                        ->where(
                            'status',
                            true
                        )
                        ->count(),            

            ],

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Customer Group Details
    |--------------------------------------------------------------------------
    */

    public function groupDetails(
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('customer_groups.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view customer group details.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Group
        |--------------------------------------------------------------------------
        */

        $group =
            CustomerGroup::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->withCount(
                    'customers'
                )

                ->findOrFail(
                    $id
                );


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'data' => [

                'id' =>
                    $group->id,

                'name' =>
                    $group->name,

                'code' =>
                    $group->code,

                'description' =>
                    $group->description,

                'discount_percentage' =>
                    $group->discount_percentage,

                'credit_limit' =>
                    $group->credit_limit,

                'customers_count' =>
                    $group->customers_count,

                'status' =>
                    (bool) $group->status,

                'created_at' =>
                    $group->created_at
                        ?->format('Y-m-d'),

            ],

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Store Customer Group
    |--------------------------------------------------------------------------
    */

    public function storeGroup(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('customer_groups.create')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to create customer groups.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([

                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'code' => [

                    'required',

                    'string',

                    'max:100',

                    Rule::unique(
                        'customer_groups',
                        'code'
                    )->where(
                        fn ($query) =>
                            $query->where(
                                'company_id',
                                $this->companyId
                            )
                    ),

                ],

                'description' => [
                    'nullable',
                    'string',
                ],

                'discount_percentage' => [
                    'nullable',
                    'numeric',
                    'min:0',
                    'max:100',
                ],

                'credit_limit' => [
                    'nullable',
                    'numeric',
                    'min:0',
                ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | Create
        |--------------------------------------------------------------------------
        */

        $group =
            CustomerGroup::create([

                'company_id' =>
                    $this->companyId,

                'name' =>
                    $validated['name'],

                'code' =>
                    $validated['code'],

                'description' =>
                    $validated['description']
                    ?? null,

                'discount_percentage' =>
                    $validated['discount_percentage']
                    ?? 0,

                'credit_limit' =>
                    $validated['credit_limit']
                    ?? 0,

                'status' =>
                    true,

                'created_by' =>
                    auth()->id(),

            ]);


        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        $this->activityLogger->log(

            'customer_groups',

            'create',

            'Created customer group: ' .
                $group->displayName(),

            $group,

            null,

            $group->toArray()

        );


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'message' =>
                'Customer group created successfully.',

            'data' =>
                $group,

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Update Customer Group
    |--------------------------------------------------------------------------
    */

    public function updateGroup(
        Request $request,
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('customer_groups.update')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to update customer groups.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Group
        |--------------------------------------------------------------------------
        */

        $group =
            CustomerGroup::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->findOrFail(
                    $id
                );


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([

                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'code' => [

                    'required',

                    'string',

                    'max:100',

                    Rule::unique(
                        'customer_groups',
                        'code'
                    )

                    ->ignore(
                        $group->id
                    )

                    ->where(
                        fn ($query) =>
                            $query->where(
                                'company_id',
                                $this->companyId
                            )
                    ),

                ],

                'description' => [
                    'nullable',
                    'string',
                ],

                'discount_percentage' => [
                    'nullable',
                    'numeric',
                    'min:0',
                    'max:100',
                ],

                'credit_limit' => [
                    'nullable',
                    'numeric',
                    'min:0',
                ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | Old Values
        |--------------------------------------------------------------------------
        */

        $oldValues =
            $group->toArray();


        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $group->update([

            'name' =>
                $validated['name'],

            'code' =>
                $validated['code'],

            'description' =>
                $validated['description']
                ?? null,

            'discount_percentage' =>
                $validated['discount_percentage']
                ?? 0,

            'credit_limit' =>
                $validated['credit_limit']
                ?? 0,

            'updated_by' =>
                auth()->id(),

        ]);


        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        $this->activityLogger->log(

            'customer_groups',

            'update',

            'Updated customer group: ' .
                $group->displayName(),

            $group,

            $oldValues,

            $group->fresh()->toArray()

        );


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'message' =>
                'Customer group updated successfully.',

            'data' =>
                $group->fresh(),

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Delete Customer Group
    |--------------------------------------------------------------------------
    */

    public function destroyGroup(
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('customer_groups.delete')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to delete customer groups.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Group
        |--------------------------------------------------------------------------
        */

        $group =
            CustomerGroup::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->findOrFail(
                    $id
                );


        /*
        |--------------------------------------------------------------------------
        | Prevent Delete When Customers Exist
        |--------------------------------------------------------------------------
        */

        if ($group->customers()->exists()) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'This customer group cannot be deleted because customers are assigned to it.',

            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | Old Values
        |--------------------------------------------------------------------------
        */

        $oldValues =
            $group->toArray();


        /*
        |--------------------------------------------------------------------------
        | Delete
        |--------------------------------------------------------------------------
        */

        $group->delete();


        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        $this->activityLogger->log(

            'customer_groups',

            'delete',

            'Deleted customer group: ' .
                $group->displayName(),

            $group,

            $oldValues,

            null

        );


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'message' =>
                'Customer group deleted successfully.',

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Enable Customer Group
    |--------------------------------------------------------------------------
    */

    public function enableGroup(
        int $id
    ): JsonResponse {

        return $this->changeGroupStatus(
            $id,
            true
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Disable Customer Group
    |--------------------------------------------------------------------------
    */

    public function disableGroup(
        int $id
    ): JsonResponse {

        return $this->changeGroupStatus(
            $id,
            false
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Change Customer Group Status
    |--------------------------------------------------------------------------
    */

    private function changeGroupStatus(
        int $id,
        bool $status
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('customer_groups.update')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to update customer groups.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Group
        |--------------------------------------------------------------------------
        */

        $group =
            CustomerGroup::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->findOrFail(
                    $id
                );


        /*
        |--------------------------------------------------------------------------
        | Old Values
        |--------------------------------------------------------------------------
        */

        $oldValues =
            $group->toArray();


        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $group->update([

            'status' =>
                $status,

            'updated_by' =>
                auth()->id(),

        ]);


        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        $this->activityLogger->log(

            'customer_groups',

            $status
                ? 'enable'
                : 'disable',

            ($status
                ? 'Enabled customer group: '
                : 'Disabled customer group: ')
                .
                $group->displayName(),

            $group,

            $oldValues,

            $group->fresh()->toArray()

        );


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'message' =>
                $status
                    ? 'Customer group enabled successfully.'
                    : 'Customer group disabled successfully.',

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Loyalty
    |--------------------------------------------------------------------------
    */

    public function loyalty(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('customers.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view customer loyalty.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Query
        |--------------------------------------------------------------------------
        */

        $customers =
            Customer::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'loyalty_points',
                    '>',
                    0
                )

                ->with([
                    'customerGroup',
                ]);


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search =
                trim(
                    $request->search
                );


            $customers->where(

                function ($query) use ($search) {

                    $query

                        ->where(
                            'customer_code',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'first_name',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'last_name',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'phone',
                            'like',
                            "%{$search}%"
                        );

                }

            );

        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $customers =
            $customers

                ->orderByDesc(
                    'loyalty_points'
                )

                ->paginate(15)

                ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Table
        |--------------------------------------------------------------------------
        */

        $html = view(

            'customers.partials.loyalty-table',

            compact(
                'customers'
            )

        )->render();


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'html' =>
                $html,

            'pagination' =>
                $customers
                    ->links()
                    ->render(),

            'stats' => [

                'customers' =>
                    Customer::query()
                        ->where(
                            'company_id',
                            $this->companyId
                        )
                        ->where(
                            'loyalty_points',
                            '>',
                            0
                        )
                        ->count(),

                'points' =>
                    Customer::query()
                        ->where(
                            'company_id',
                            $this->companyId
                        )
                        ->sum('loyalty_points'),

            ],

        ]);

    }

}