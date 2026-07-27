<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;

use App\Models\ActivityLog;
use App\Models\Branch;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Terminal;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Customer;


class CompanyController extends BaseController
{

    public function index()
    {
        $company = $this->company;


        /*
        |--------------------------------------------------------------------------
        | Company Statistics
        |--------------------------------------------------------------------------
        */

        $stats = [

            'branches' => Branch::where('company_id', $this->companyId)
                ->count(),


            'terminals' => Terminal::where('company_id', $this->companyId)
                ->count(),


            'users' => User::where('company_id', $this->companyId)
                ->count(),


            'products' => Product::where('company_id', $this->companyId)
                ->count(),


            'orders' => Order::where('company_id', $this->companyId)
                ->count(),


            'customers' => Customer::where('company_id', $this->companyId)
                ->count(),


            /*
            |--------------------------------------------------------------------------
            | Inventory Value
            |--------------------------------------------------------------------------
            */

            'inventory_value' => ProductStock::join(
                    'products',
                    'products.id',
                    '=',
                    'product_stocks.product_id'
                )
                ->where('product_stocks.company_id', $this->companyId)
                ->sum(
                    \DB::raw(
                        'product_stocks.quantity * products.cost_price'
                    )
                ),


            /*
            |--------------------------------------------------------------------------
            | Total Revenue
            |--------------------------------------------------------------------------
            |
            | Temporary calculation.
            | We will refine this when we review the Order model.
            |
            */

            'revenue' => Order::where('company_id', $this->companyId)
                ->sum('total'),

        ];



        /*
        |--------------------------------------------------------------------------
        | Recent Activities
        |--------------------------------------------------------------------------
        */

        $activities = ActivityLog::with('user')
            ->where('company_id', $this->companyId)
            ->latest()
            ->take(10)
            ->get();

        $branches = Branch::where('company_id', $this->companyId)
        ->with([
            'terminals',
            'users'
        ])
        ->latest()
        ->get();



        return view(
            'company.show',
            compact(
                'company',
                'stats',
                'activities',
                'branches'
            )
        );
    }


    /**
     * Company Profile
     */
    public function show()
    {
       
    }

    
    /**
     * Update Company
     */
    public function update(Request $request)
    {

        $company = $this->company;


        $company->update($request->validate([

            'name'=>'required',
            'business_type'=>'nullable',
            'email'=>'nullable|email',
            'phone'=>'nullable',
            'registration_no'=>'nullable',
            'tin'=>'nullable',
            'address'=>'nullable',

        ]));


        return response()->json([

            'status'=>true,

            'message'=>'Company updated'

        ]);

    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048'
        ]);


        $company = $this->company;


        if ($request->hasFile('logo')) {


            $file = $request->file('logo');


            // Generate unique filename
            $filename = time().'_'.$file->getClientOriginalName();


            // Destination folder
            $destination = public_path('uploads/company');


            // Create folder if it does not exist
            if (!file_exists($destination)) {

                mkdir($destination, 0755, true);

            }


            // Move file
            $file->move(
                $destination,
                $filename
            );


            // Delete old logo if exists
            if ($company->logo) {

                $oldLogo = public_path(
                    'uploads/company/'.$company->logo
                );


                if (file_exists($oldLogo)) {

                    unlink($oldLogo);

                }

            }


            // Save filename
            $company->update([

                'logo' => $filename

            ]);

        }


        return response()->json([

            'status' => true,

            'message' => 'Company logo updated successfully'

        ]);

    }
    
}