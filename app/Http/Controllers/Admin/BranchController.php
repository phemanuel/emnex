<?php

namespace App\Http\Controllers\Admin;


use App\Models\Branch;
use App\Models\Terminal;
use App\Models\User;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


use Illuminate\Http\Request;


class BranchController extends BaseController
{

    public function __construct(
    protected ActivityLogger $activityLogger
    ) {

        parent::__construct();

    }

    /*
    |--------------------------------------------------------------------------
    | Branch Listing
    |--------------------------------------------------------------------------
    */

    public function index()
    {

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $stats = [

            'branches' => Branch::where(
                'company_id',
                $this->companyId
            )->count(),


            'active' => Branch::where(
                'company_id',
                $this->companyId
            )
            ->where('status',true)
            ->count(),


            'inactive' => Branch::where(
                'company_id',
                $this->companyId
            )
            ->where('status',false)
            ->count(),


            'terminals' => Terminal::where(
                'company_id',
                $this->companyId
            )->count(),


            'users' => User::where(
                'company_id',
                $this->companyId
            )->count(),

        ];



        /*
        |--------------------------------------------------------------------------
        | Branch List
        |--------------------------------------------------------------------------
        */

        $branches = Branch::where(
                'company_id',
                $this->companyId
            )
            ->withCount([

                'users',

                'terminals',

                'orders'

            ])
            ->latest()
            ->paginate(10);



        return view(
            'branches.index',
            compact(
                'stats',
                'branches'
            )
        );

    }



    /*
    |--------------------------------------------------------------------------
    | Branch Inspector Data
    |--------------------------------------------------------------------------
    */

    public function details(Branch $branch)
    {

        abort_if(
            $branch->company_id !== $this->companyId,
            403
        );


        $branch->load([
            'activityLogs'
        ]);


        $branch->loadCount([

            'users',

            'terminals',

            'orders'

        ]);


        $customerCount = Order::where('branch_id', $branch->id)
            ->whereNotNull('customer_id')
            ->distinct('customer_id')
            ->count('customer_id');



        return response()->json([

            'branch'=>$branch,

            'customer_count'=>$customerCount

        ]);

    }
    
    public function users(Branch $branch)
    {

        $users = $branch->users()
        ->select(
            'id',
            'first_name',
            'last_name',
            'email'
        )
        ->latest()
        ->get();


        return response()->json([

            'data'=>$users

        ]);

    }

    public function terminals(Branch $branch)
    {

        $terminals = $branch->terminals()
            ->select(
                'id',
                'terminal_name',
                'terminal_code',
                'status'
            )
            ->latest()
            ->get();


        return response()->json([

            'data'=>$terminals

        ]);

    }

    public function orders(Branch $branch)
    {

        $orders = $branch->orders()
            ->select(
                'id',
                'order_no',
                'total',
                'payment_status',
                'created_at'
            )
            ->latest()
            ->limit(10)
            ->get();



        return response()->json([

            'data'=>$orders

        ]);

    }

    public function customers(Branch $branch)
    {

        $customers = Customer::whereHas('orders', function($query) use ($branch){

                $query->where('branch_id',$branch->id);

            })
            ->select(
                'id',
                'first_name',
                'last_name',
                'email',
                'phone'
            )
            ->distinct()
            ->limit(20)
            ->get();



        return response()->json([

            'data'=>$customers

        ]);

    }

    public function store(Request $request)
    {
        try {

            $companyId = auth()->user()->company_id;

            $validated = $request->validate([

                'branch_code' => [

                    'required',

                    'string',

                    'max:50',

                    Rule::unique('branches', 'branch_code')

                        ->where(function ($query) use ($companyId) {

                            return $query

                                ->where('company_id', $companyId)

                                ->whereNull('deleted_at');

                        })

                ],

                'name' => [

                    'required',

                    'string',

                    'max:150',

                    Rule::unique('branches', 'name')

                        ->where(function ($query) use ($companyId) {

                            return $query

                                ->where('company_id', $companyId)

                                ->whereNull('deleted_at');

                        })

                ],

                'email' => [

                    'nullable',

                    'email',

                    'max:150'

                ],

                'phone' => [

                    'nullable',

                    'string',

                    'max:30'

                ],

                'address' => [

                    'nullable',

                    'string'

                ],

                'status' => [

                    'required',

                    'boolean'

                ],

                'is_head_office' => [

                    'nullable',

                    'boolean'

                ]

            ]);

           $existingBranch = Branch::where('company_id', $companyId)

                ->whereNull('deleted_at')

                ->where(function ($query) use ($validated) {

                    $query

                        ->where('branch_code', $validated['branch_code'])

                        ->orWhere('name', $validated['name']);

                    if (!empty($validated['email'])) {

                        $query->orWhere('email', $validated['email']);

                    }

                })

                ->first();

            if ($existingBranch) {

                if ($existingBranch->branch_code === $validated['branch_code']) {

                    return response()->json([

                        'success' => false,

                        'type' => 'warning',

                        'message' => 'The Branch Code "' . $validated['branch_code'] . '" is already assigned to another branch.'

                    ], 409);

                }

                if ($existingBranch->name === $validated['name']) {

                    return response()->json([

                        'success' => false,

                        'type' => 'warning',

                        'message' => 'A branch with the name "' . $validated['name'] . '" already exists.'

                    ], 409);

                }

                if (
                    !empty($validated['email']) &&
                    $existingBranch->email === $validated['email']
                ) {

                    return response()->json([

                        'success' => false,

                        'type' => 'warning',

                        'message' => 'The email address "' . $validated['email'] . '" is already being used by another branch.'

                    ], 409);

                }

            }

            $deletedBranch = Branch::onlyTrashed()

            ->where('company_id', $companyId)

            ->where(function ($query) use ($validated) {

                $query

                    ->where('branch_code', $validated['branch_code'])

                    ->orWhere('name', $validated['name']);

            })

            ->first();

            if ($deletedBranch) {

                $oldValues = $deletedBranch->toArray();

                $deletedBranch->restore();

                $deletedBranch->update([

                    'branch_code'    => $validated['branch_code'],

                    'name'           => $validated['name'],

                    'email'          => $validated['email'],

                    'phone'          => $validated['phone'],

                    'address'        => $validated['address'],

                    'status'         => $validated['status'],

                    'is_head_office' => $validated['is_head_office'] ?? false,

                ]);

                $this->activityLogger->log(

                    'Branch Management',

                    'Restored',

                    "Restored branch {$deletedBranch->name}",

                    $deletedBranch,

                    $oldValues,

                    $deletedBranch->fresh()->toArray()

                );

                return response()->json([

                    'success' => true,

                    'type'    => 'success',

                    'message' => 'A previously deleted branch has been restored successfully.'

                ]);

            }

            DB::transaction(function () use (
                $validated,
                $companyId,
                &$branch
            ) {

                $branch = Branch::create([

                    'company_id' => $companyId,

                    'branch_code' => $validated['branch_code'],

                    'name' => $validated['name'],

                    'email' => $validated['email'] ?? null,

                    'phone' => $validated['phone'] ?? null,

                    'address' => $validated['address'] ?? null,

                    'status' => $validated['status'],

                    'is_head_office' => $validated['is_head_office'] ?? false,

                ]);

                $this->activityLogger->log(

                    'Branch Management',

                    'Created',

                    "Created branch {$branch->name}",

                    $branch,

                    null,

                    $branch->toArray()

                );

            });

            return response()->json([

                'success' => true,

                'message' => 'Branch created successfully.'

            ]);

        } catch (\Throwable $exception) {

            report($exception);

            return response()->json([

                'message' => app()->environment('production')
                    ? 'Unable to create branch.'
                    : $exception->getMessage()

            ], 500);

        }
    }

    public function edit(Branch $branch)
    {
        abort_unless(
            $branch->company_id === $this->companyId,
            404
        );

        return response()->json([

            'branch' => $branch

        ]);
    }

    public function update(Request $request, Branch $branch)
    {
        abort_unless(
            $branch->company_id === $this->companyId,
            404
        );

        $validated = $request->validate([

            'edit_name' => [
                'required',
                'string',
                'max:150'
            ],

            'edit_branch_code' => [

                'required',
                'string',
                'max:50',

                Rule::unique(
                    'branches',
                    'branch_code'
                )
                ->ignore($branch->id)
                ->where(function ($query) {

                    return $query
                        ->where('company_id', $this->companyId)
                        ->whereNull('deleted_at');

                })

            ],

            'edit_email' => [

                'nullable',
                'email',
                'max:150',

                Rule::unique(
                    'branches',
                    'email'
                )
                ->ignore($branch->id)
                ->where(function ($query) {

                    return $query
                        ->where('company_id', $this->companyId)
                        ->whereNull('deleted_at');

                })

            ],

            'edit_phone' => [
                'nullable',
                'string',
                'max:30'
            ],

            'edit_address' => [
                'nullable',
                'string'
            ],

            'edit_status' => [
                'required',
                'boolean'
            ],

            'edit_is_head_office' => [
                'nullable',
                'boolean'
            ],

        ]);

        $oldValues = $branch->toArray();

        DB::transaction(function () use (
            $branch,
            $validated,
            $oldValues
        ) {

            $branch->update([

                'name' => $validated['edit_name'],

                'branch_code' => $validated['edit_branch_code'],

                'email' => $validated['edit_email'],

                'phone' => $validated['edit_phone'],

                'address' => $validated['edit_address'],

                'status' => $validated['edit_status'],

                'is_head_office' => $validated['edit_is_head_office'] ?? false,

            ]);

            $this->activityLogger->log(

                'Branch Management',

                'Updated',

                "Updated branch {$branch->name}",

                $branch,

                $oldValues,

                $branch->fresh()->toArray()

            );

        });

        return response()->json([

            'success' => true,

            'message' => 'Branch updated successfully.'

        ]);
    }

    public function destroy(Branch $branch)
    {
        abort_unless(
            $branch->company_id === $this->companyId,
            404
        );

        if ($branch->is_head_office) {

            return response()->json([

                'success' => false,

                'message' => 'The Head Office branch cannot be deleted.'

            ], 422);

        }

        if ($branch->users()->exists()) {

            return response()->json([

                'success' => false,

                'message' => 'This branch cannot be deleted because it has users assigned to it.'

            ], 422);

        }

        if ($branch->terminals()->exists()) {

            return response()->json([

                'success' => false,

                'message' => 'This branch cannot be deleted because it has terminals assigned to it.'

            ], 422);

        }

        if ($branch->orders()->exists()) {

            return response()->json([

                'success' => false,

                'message' => 'This branch cannot be deleted because it has sales transactions.'

            ], 422);

        }
        

        $oldValues = $branch->toArray();

        DB::transaction(function () use (
            $branch,
            $oldValues
        ) {

            $branch->delete();

            $this->activityLogger->log(

                'Branch Management',

                'Deleted',

                "Deleted branch {$branch->name}",

                $branch,

                $oldValues,

                null

            );

        });

        return response()->json([

            'success' => true,

            'message' => 'Branch deleted successfully.'

        ]);
    }

    public function toggleStatus(Branch $branch)
    {
        abort_unless(
            $branch->company_id === $this->companyId,
            404
        );

        /*
        |--------------------------------------------------------------------------
        | Prevent disabling Head Office
        |--------------------------------------------------------------------------
        */

        if (
            $branch->is_head_office &&
            $branch->status
        ) {

            return response()->json([

                'success' => false,

                'message' => 'The Head Office branch cannot be disabled.'

            ],422);

        }

        $newStatus = ! $branch->status;

        $oldValues = $branch->toArray();

        DB::transaction(function () use (
            $branch,
            $oldValues,
            $newStatus
        ) {

            $branch->update([

                'status' => $newStatus

            ]);

            $action =

                $newStatus
                    ? 'Enabled'
                    : 'Disabled';

            $this->activityLogger->log(

                'Branch Management',

                $action,

                "{$action} branch {$branch->name}",

                $branch,

                $oldValues,

                $branch->fresh()->toArray()

            );

        });

        return response()->json([

            'success' => true,

            'message' =>

                $newStatus
                    ? 'Branch enabled successfully.'
                    : 'Branch disabled successfully.'

        ]);
    }


}