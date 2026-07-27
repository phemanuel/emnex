<?php

namespace App\Http\Controllers\Admin;


use App\Models\Branch;
use App\Models\Terminal;
use App\Models\User;
use App\Models\Order;
use App\Models\Customer;


use Illuminate\Http\Request;


class BranchController extends BaseController
{


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


}