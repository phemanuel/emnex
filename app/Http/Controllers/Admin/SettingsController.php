<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\DB;

class SettingsController extends BaseController
{

    protected ActivityLogger $activityLogger;


    public function __construct(ActivityLogger $activityLogger)
    {
        parent::__construct();

        $this->activityLogger = $activityLogger;
    }


    /**
     * Display settings page
     */
    public function index()
    {
        $settings = Setting::where(
            'company_id',
            $this->companyId
        )->first();



        if (!$settings) {


            $settings = Setting::create([

                'company_id' => $this->companyId,

                'company_name' => $this->company->name,

                'currency' => 'NGN',

                'currency_symbol' => '₦',

                'timezone' => 'Africa/Lagos',

                'date_format' => 'd/m/Y',

                'time_format' => 'H:i',

                'status' => true,

            ]);


        }





        $customers = Customer::where(
            'company_id',
            $this->companyId
        )
        ->orderBy('first_name')
        ->get();





        /*
        |--------------------------------------------------------------------------
        | Localization Options
        |--------------------------------------------------------------------------
        */


        $timezones = timezone_identifiers_list();



        $dateFormats = [

            'd/m/Y' => '31/12/2026',

            'm/d/Y' => '12/31/2026',

            'Y-m-d' => '2026-12-31',

            'd M Y' => '31 Dec 2026',

            'l, d F Y' => 'Monday, 31 December 2026',

        ];





        $timeFormats = [

            'H:i' => '24 Hour (14:30)',

            'h:i A' => '12 Hour (02:30 PM)',

            'H:i:s' => '24 Hour With Seconds (14:30:45)',

        ];






        return view(

            'settings.index',

            compact(

                'settings',

                'customers',

                'timezones',

                'dateFormats',

                'timeFormats'

            )

        );
    }


    /**
     * Update Settings
     */
    public function update(Request $request)
    {

        $validated = $request->validate([


            /*
            |--------------------------------------------------------------------------
            | Company
            |--------------------------------------------------------------------------
            */

            'company_name' => [
                'required',
                'string',
                'max:255'
            ],


            'company_email' => [
                'nullable',
                'email',
                'max:255'
            ],


            'company_phone' => [
                'nullable',
                'string',
                'max:50'
            ],


            'company_address' => [
                'nullable',
                'string'
            ],




            /*
            |--------------------------------------------------------------------------
            | Localization
            |--------------------------------------------------------------------------
            */

            'currency' => [
                'required',
                'string',
                'max:10'
            ],


            'currency_symbol' => [
                'required',
                'string',
                'max:10'
            ],


            'timezone' => [
                'required',
                'string',
                'max:100'
            ],


            'date_format' => [
                'required',
                'string',
                'max:50'
            ],


            'time_format' => [
                'required',
                'string',
                'max:50'
            ],





            /*
            |--------------------------------------------------------------------------
            | Tax
            |--------------------------------------------------------------------------
            */

            'tax_rate' => [
                'nullable',
                'numeric',
                'min:0'
            ],



            /*
            |--------------------------------------------------------------------------
            | Receipt
            |--------------------------------------------------------------------------
            */

            'receipt_header' => [
                'nullable',
                'string'
            ],


            'receipt_footer' => [
                'nullable',
                'string'
            ],


            'receipt_width' => [
                'nullable',
                'integer'
            ],

            /*
            |--------------------------------------------------------------------------
            | Inventory
            |--------------------------------------------------------------------------
            */

            'low_stock_alert' => [
                'nullable',
                'integer',
                'min:0'
            ],



        ]);

        $settings = Setting::where(
            'company_id',
            $this->companyId
        )->first();

        if(!$settings){


            return response()->json([

                'success'=>false,

                'type'=>'warning',

                'message'=>'Settings record not found.'

            ],409);


        }

        /*
        |--------------------------------------------------------------------------
        | Boolean Fields
        |--------------------------------------------------------------------------
        */

        $validated['tax_enabled'] =
            $request->boolean('tax_enabled');


        $validated['allow_negative_stock'] =
            $request->boolean('allow_negative_stock');


        $validated['allow_price_override'] =
            $request->boolean('allow_price_override');


        $validated['allow_discount'] =
            $request->boolean('allow_discount');


        $validated['enable_customer_credit'] =
            $request->boolean('enable_customer_credit');


        $validated['print_logo'] =
            $request->boolean('print_logo');


        $validated['print_barcode'] =
            $request->boolean('print_barcode');


        $oldValues = $settings->toArray();

        $settings->update($validated);

        $newValues = $settings->fresh()->toArray();

        $this->activityLogger->log(

            'Settings Management',

            'Updated',

            'Updated company settings',

            $settings,

            $oldValues,

            $newValues

        );

        return response()->json([

            'success'=>true,

            'type'=>'success',

            'message'=>'Settings updated successfully.'

        ]);

    }



    /**
     * Enable / Disable Settings
     */
    public function toggleStatus(Request $request)
    {

        try {


            $settings = Setting::where(

                'company_id',

                $this->companyId

            )->firstOrFail();



            $settings->update([

                'status'=>
                    !$settings->status

            ]);



            $action = $settings->status
                ? 'Enabled'
                : 'Disabled';



            $this->activityLogger->log(

                'Settings Management',

                $action,

                "Settings {$action}",

                $settings

            );



            return response()->json([

                'success'=>true,

                'type'=>'success',

                'message'=>
                    "Settings {$action} successfully."

            ]);



        } catch(\Exception $e) {


            return response()->json([

                'success'=>false,

                'type'=>'error',

                'message'=>
                    'Unable to update settings status.'

            ],500);

        }

    }

}