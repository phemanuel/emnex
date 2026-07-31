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

                    Rule::unique('branches')
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

                    Rule::unique('branches')
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


}