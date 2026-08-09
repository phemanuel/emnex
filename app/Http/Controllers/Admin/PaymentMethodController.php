<?php

namespace App\Http\Controllers\Admin;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class PaymentMethodController extends BaseController
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

    public function index()
    {
        if (! canAccess('payment_methods.view')) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to view payment methods.'
            ], 403);
        }

        $paymentMethods = PaymentMethod::where(
                'company_id',
                $this->companyId
            )
            ->orderBy(
                'display_order'
            )
            ->get();


        return view(
            'settings.payment-methods.index',
            compact(
                'paymentMethods'
            )
        );

    }



    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        if (! canAccess('payment_methods.create')) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to create payment methods.'
            ], 403);
        }

        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:50'
            ],

            'code' => [
                'required',
                'string',
                'max:30'
            ],

            'icon' => [
                'nullable',
                'string'
            ],

            'color' => [
                'required',
                'string'
            ],

            'display_order' => [
                'required',
                'integer'
            ],

            'requires_reference' => [
                'nullable',
                'boolean'
            ],

            'is_cash' => [
                'nullable',
                'boolean'
            ],

            'allow_change' => [
                'nullable',
                'boolean'
            ],

        ]);

        /*
        |--------------------------------------------------------------------------
        | Normalize Checkbox Values
        |--------------------------------------------------------------------------
        */

        $validated['requires_reference'] = $request->boolean(
            'requires_reference'
        );


        $validated['is_cash'] = $request->boolean(
            'is_cash'
        );


        $validated['allow_change'] = $request->boolean(
            'allow_change'
        );



        /*
        |--------------------------------------------------------------------------
        | Duplicate / Restore Check
        |--------------------------------------------------------------------------
        */

        $existing = PaymentMethod::withTrashed()
            ->where(
                'company_id',
                $this->companyId
            )
            ->where(
                'code',
                $validated['code']
            )
            ->first();



        if ($existing) {


            if ($existing->trashed()) {


                $existing->restore();


                $existing->update(
                    $validated
                );


                return response()->json([

                    'success' => true,

                    'type' => 'success',

                    'message' =>
                        'Payment method restored successfully.'

                ]);

            }


            return response()->json([

                'success' => false,

                'type' => 'warning',

                'message' =>
                    'Payment method already exists.'

            ],422);

        }



        /*
        |--------------------------------------------------------------------------
        | Create
        |--------------------------------------------------------------------------
        */

        $paymentMethod = PaymentMethod::create([

            ...$validated,

            'company_id' =>
                $this->companyId,

            'status' => true,

        ]);



        $this->activityLogger->log(

            'Payment Methods',

            'Created',

            "Created payment method {$paymentMethod->name}.",

            $paymentMethod

        );



        return response()->json([

            'success' => true,

            'type' => 'success',

            'message' =>
                'Payment method created successfully.'

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(PaymentMethod $paymentMethod)
    {
        if (! canAccess('payment_methods.update')) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to edit payment methods.'
            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | Company Ownership
        |--------------------------------------------------------------------------
        */

        if ($paymentMethod->company_id !== $this->companyId) {

            return response()->json([

                'success' => false,

                'type'    => 'warning',

                'message' => 'Payment method not found.'

            ], 404);

        }



        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'type'    => 'success',

            'message' => 'Payment method loaded successfully.',

            'data'    => $paymentMethod,

        ]);

    }
    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update( Request $request, PaymentMethod $paymentMethod ) 
    {
        if (! canAccess('payment_methods.update')) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to edit payment methods.'
            ], 403);
        }

        if ($paymentMethod->company_id !== $this->companyId) {

            return response()->json([

                'success' => false,

                'type' => 'warning',

                'message' =>
                    'Payment method not found.'

            ],404);

        }



        $validated = $request->validate([


            'name' => [

                'required',

                'string',

                'max:50'

            ],


            'code' => [

                'required',

                'string',

                'max:30'

            ],


            'icon' => [

                'nullable',

                'string'

            ],


            'color' => [

                'required',

                'string'

            ],


            'display_order' => [

                'required',

                'integer'

            ],


            'requires_reference' => [

                'nullable',

                'boolean'

            ],


            'is_cash' => [

                'nullable',

                'boolean'

            ],


            'allow_change' => [

                'nullable',

                'boolean'

            ],


        ]);

        /*
        |--------------------------------------------------------------------------
        | Normalize Checkbox Values
        |--------------------------------------------------------------------------
        */

        $validated['requires_reference'] = $request->boolean(
            'requires_reference'
        );


        $validated['is_cash'] = $request->boolean(
            'is_cash'
        );


        $validated['allow_change'] = $request->boolean(
            'allow_change'
        );



        /*
        |--------------------------------------------------------------------------
        | Duplicate Check
        |--------------------------------------------------------------------------
        */

        $duplicate = PaymentMethod::where(
                'company_id',
                $this->companyId
            )
            ->where(
                'code',
                $validated['code']
            )
            ->where(
                'id',
                '!=',
                $paymentMethod->id
            )
            ->exists();



        if ($duplicate) {

            return response()->json([

                'success' => false,

                'type' => 'warning',

                'message' =>
                    'Payment method code already exists.'

            ],422);

        }



        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $oldValues = $paymentMethod->toArray();

        $paymentMethod->update($validated);

        $newValues = $paymentMethod->fresh()->toArray();



        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        $this->activityLogger->log(

            'Payment Methods',

            'Updated',

            "Updated {$paymentMethod->name} payment method.",

            $paymentMethod,

            $oldValues,

            $newValues

        );



        return response()->json([

            'success' => true,

            'type' => 'success',

            'message' =>
                'Payment method updated successfully.'

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Toggle Status
    |--------------------------------------------------------------------------
    */

    public function toggleStatus(PaymentMethod $paymentMethod ) 
    {
        if (! canAccess('payment_methods.update')) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to update payment method status.'
            ], 403);
        }


        if ($paymentMethod->company_id !== $this->companyId) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Payment method not found.'

            ],404);

        }



        $paymentMethod->update([

            'status' =>
                !$paymentMethod->status

        ]);



        $this->activityLogger->log(

            'Payment Methods',

            $paymentMethod->status
                ? 'Enabled'
                : 'Disabled',

            "{$paymentMethod->name} payment method status changed.",

            $paymentMethod

        );



        return response()->json([

            'success' => true,

            'type' => 'success',

            'message' =>

                $paymentMethod->status

                    ? 'Payment method enabled successfully.'

                    : 'Payment method disabled successfully.'

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Destroy
    |--------------------------------------------------------------------------
    */

    public function destroy( PaymentMethod $paymentMethod) 
    {
        if (! canAccess('payment_methods.delete')) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to delete payment methods.'
            ], 403);
        }


        if ($paymentMethod->company_id !== $this->companyId) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Payment method not found.'

            ],404);

        }



        $paymentMethod->delete();



        $this->activityLogger->log(

            'Payment Methods',

            'Deleted',

            "Deleted {$paymentMethod->name} payment method.",

            $paymentMethod

        );



        return response()->json([

            'success' => true,

            'type' => 'success',

            'message' =>
                'Payment method deleted successfully.'

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Restore
    |--------------------------------------------------------------------------
    */

    public function restore($id)
    {

        if (! canAccess('payment_methods.restore')) {
                return response()->json([
                    'status' => false,
                    'message' => 'You do not have permission to restore payment methods.'
                ], 403);
            }

        $paymentMethod = PaymentMethod::withTrashed()
            ->where(
                'company_id',
                $this->companyId
            )
            ->where(
                'id',
                $id
            )
            ->first();



        if (!$paymentMethod) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Payment method not found.'

            ],404);

        }



        $paymentMethod->restore();



        $this->activityLogger->log(

            'Payment Methods',

            'Restored',

            "Restored {$paymentMethod->name} payment method.",

            $paymentMethod

        );



        return response()->json([

            'success' => true,

            'type' => 'success',

            'message' =>
                'Payment method restored successfully.'

        ]);

    }

}