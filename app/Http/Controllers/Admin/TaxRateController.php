<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\TaxRate;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TaxRateController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    protected ActivityLogger $activityLogger;


    /*
    |--------------------------------------------------------------------------
    | Constructor
    |--------------------------------------------------------------------------
    */

    public function __construct(
        ActivityLogger $activityLogger
    ) {
        parent::__construct();

        $this->activityLogger =
            $activityLogger;
    }


    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $statistics = [

            'total' =>
                TaxRate::forCompany(
                    $this->companyId
                )
                    ->count(),

            'active' =>
                TaxRate::forCompany(
                    $this->companyId
                )
                    ->where(
                        'status',
                        true
                    )
                    ->count(),

            'inactive' =>
                TaxRate::forCompany(
                    $this->companyId
                )
                    ->where(
                        'status',
                        false
                    )
                    ->count(),

        ];


        $taxRates =
            TaxRate::forCompany(
                $this->companyId
            )
                ->latest()
                ->paginate(15);


        return view(
            'tax-rates.index',
            compact(
                'statistics',
                'taxRates'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Table
    |--------------------------------------------------------------------------
    */

    public function table(Request $request)
    {
        $query =
            TaxRate::query()
                ->forCompany(
                    $this->companyId
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


            $query->where(
                function ($q) use ($search) {

                    $q->where(
                        'name',
                        'like',
                        "%{$search}%"
                    )
                        ->orWhere(
                            'rate',
                            'like',
                            "%{$search}%"
                        );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }


        $taxRates =
            $query
                ->latest()
                ->paginate(15);


        return view(
            'tax-rates.partials.table',
            compact('taxRates')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (!canAccess('tax_rates.create')) {

            return response()->json([
                'status' => false,
                'message' =>
                    'You do not have permission to create tax rates.',
            ], 403);
        }


        try {

            /*
            |--------------------------------------------------------------------------
            | Validate
            |--------------------------------------------------------------------------
            */

            $validated =
                $request->validate([

                    'name' => [
                        'required',
                        'string',
                        'max:255',
                    ],

                    'rate' => [
                        'required',
                        'numeric',
                        'min:0',
                        'max:100',
                    ],

                ]);


            /*
            |--------------------------------------------------------------------------
            | Normalize Name
            |--------------------------------------------------------------------------
            */

            $name =
                trim(
                    $validated['name']
                );


            /*
            |--------------------------------------------------------------------------
            | Find Existing Tax Rate
            |--------------------------------------------------------------------------
            |
            | Include soft-deleted records because the database unique constraint
            | on company_id + name remains active even after soft deletion.
            |
            */

            $existing =
                TaxRate::withTrashed()
                    ->where(
                        'company_id',
                        $this->companyId
                    )
                    ->whereRaw(
                        'LOWER(name) = ?',
                        [
                            strtolower($name),
                        ]
                    )
                    ->first();


            /*
            |--------------------------------------------------------------------------
            | Active Duplicate
            |--------------------------------------------------------------------------
            */

            if (
                $existing
                &&
                !$existing->trashed()
            ) {

                return response()->json([

                    'success' =>
                        false,

                    'type' =>
                        'warning',

                    'message' =>
                        'A tax rate with this name already exists.',

                ], 422);
            }


            /*
            |--------------------------------------------------------------------------
            | Restore State
            |--------------------------------------------------------------------------
            */

            $restoring =
                $existing
                &&
                $existing->trashed();


            /*
            |--------------------------------------------------------------------------
            | Restore Or Create
            |--------------------------------------------------------------------------
            */

            $taxRate =
                DB::transaction(
                    function () use (
                        $existing,
                        $restoring,
                        $name,
                        $validated
                    ) {

                        /*
                        |--------------------------------------------------------------------------
                        | Restore Deleted Tax Rate
                        |--------------------------------------------------------------------------
                        */

                        if ($restoring) {

                            $oldValues =
                                $existing->toArray();


                            /*
                            |--------------------------------------------------------------------------
                            | Restore
                            |--------------------------------------------------------------------------
                            */

                            $existing->restore();


                            /*
                            |--------------------------------------------------------------------------
                            | Update Restored Values
                            |--------------------------------------------------------------------------
                            */

                            $existing->update([

                                'name' =>
                                    $name,

                                'rate' =>
                                    $validated['rate'],

                                'status' =>
                                    true,

                            ]);


                            /*
                            |--------------------------------------------------------------------------
                            | Refresh
                            |--------------------------------------------------------------------------
                            */

                            $existing->refresh();


                            /*
                            |--------------------------------------------------------------------------
                            | Activity Log
                            |--------------------------------------------------------------------------
                            */

                            $this->activityLogger->log(

                                'Tax Rates',

                                'Restored',

                                'Restored tax rate: '
                                    . $existing->name,

                                $existing,

                                $oldValues,

                                $existing->toArray()

                            );


                            return $existing;
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Create New Tax Rate
                        |--------------------------------------------------------------------------
                        */

                        $taxRate =
                            TaxRate::create([

                                'company_id' =>
                                    $this->companyId,

                                'name' =>
                                    $name,

                                'rate' =>
                                    $validated['rate'],

                                'status' =>
                                    true,

                            ]);


                        /*
                        |--------------------------------------------------------------------------
                        | Activity Log
                        |--------------------------------------------------------------------------
                        */

                        $this->activityLogger->log(

                            'Tax Rates',

                            'Created',

                            'Created tax rate: '
                                . $taxRate->name,

                            $taxRate

                        );


                        return $taxRate;
                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'success' =>
                    true,

                'type' =>
                    'success',

                'message' =>
                    $restoring
                        ? 'Tax rate restored successfully.'
                        : 'Tax rate created successfully.',

                'data' =>
                    $taxRate,

            ], $restoring ? 200 : 201);


        } catch (
            \Illuminate\Validation\ValidationException $e
        ) {

            /*
            |--------------------------------------------------------------------------
            | Laravel Validation Response
            |--------------------------------------------------------------------------
            */

            throw $e;


        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Unexpected Failure
            |--------------------------------------------------------------------------
            */

            report($e);


            return response()->json([

                'success' =>
                    false,

                'type' =>
                    'error',

                'message' =>
                    'Unable to create tax rate.',

            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(TaxRate $taxRate)
    {
        if (!canAccess('tax_rates.edit')) {

            return response()->json([
                'status' => false,
                'message' =>
                    'You do not have permission to edit tax rates.',
            ], 403);
        }


        try {

            /*
            |--------------------------------------------------------------------------
            | Company Check
            |--------------------------------------------------------------------------
            */

            if (
                $taxRate->company_id
                != $this->companyId
            ) {

                return response()->json([

                    'success' =>
                        false,

                    'type' =>
                        'error',

                    'message' =>
                        'Tax rate not found.',

                ], 404);
            }


            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'success' =>
                    true,

                'data' =>
                    $taxRate,

            ]);


        } catch (\Throwable $e) {

            report($e);


            return response()->json([

                'success' =>
                    false,

                'type' =>
                    'error',

                'message' =>
                    'Unable to load tax rate.',

            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        TaxRate $taxRate
    ) {
        try {

            /*
            |--------------------------------------------------------------------------
            | Company Check
            |--------------------------------------------------------------------------
            */

            if (
                $taxRate->company_id
                != $this->companyId
            ) {

                return response()->json([

                    'success' =>
                        false,

                    'type' =>
                        'error',

                    'message' =>
                        'Tax rate not found.',

                ], 404);
            }


            /*
            |--------------------------------------------------------------------------
            | Validate
            |--------------------------------------------------------------------------
            */

            $validated =
                $request->validate([

                    'name' => [
                        'required',
                        'string',
                        'max:255',
                    ],

                    'rate' => [
                        'required',
                        'numeric',
                        'min:0',
                        'max:100',
                    ],

                ]);


            /*
            |--------------------------------------------------------------------------
            | Normalize Name
            |--------------------------------------------------------------------------
            */

            $name =
                trim(
                    $validated['name']
                );


            /*
            |--------------------------------------------------------------------------
            | Duplicate Check
            |--------------------------------------------------------------------------
            |
            | Include soft-deleted TaxRates because their names remain protected
            | by the database unique constraint.
            |
            */

            $exists =
                TaxRate::withTrashed()
                    ->where(
                        'company_id',
                        $this->companyId
                    )
                    ->whereRaw(
                        'LOWER(name) = ?',
                        [
                            strtolower($name),
                        ]
                    )
                    ->where(
                        'id',
                        '!=',
                        $taxRate->id
                    )
                    ->exists();


            if ($exists) {

                return response()->json([

                    'success' =>
                        false,

                    'type' =>
                        'warning',

                    'message' =>
                        'A tax rate with this name already exists.',

                ], 422);
            }


            /*
            |--------------------------------------------------------------------------
            | Old Values
            |--------------------------------------------------------------------------
            */

            $oldValues =
                $taxRate->toArray();


            /*
            |--------------------------------------------------------------------------
            | Update
            |--------------------------------------------------------------------------
            */

            $taxRate->update([

                'name' =>
                    $name,

                'rate' =>
                    $validated['rate'],

            ]);


            /*
            |--------------------------------------------------------------------------
            | Refresh
            |--------------------------------------------------------------------------
            */

            $taxRate->refresh();


            /*
            |--------------------------------------------------------------------------
            | New Values
            |--------------------------------------------------------------------------
            */

            $newValues =
                $taxRate->toArray();


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'Tax Rates',

                'Updated',

                'Updated tax rate: '
                    . $taxRate->name,

                $taxRate,

                $oldValues,

                $newValues

            );


            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'success' =>
                    true,

                'type' =>
                    'success',

                'message' =>
                    'Tax rate updated successfully.',

            ]);


        } catch (
            \Illuminate\Validation\ValidationException $e
        ) {

            throw $e;


        } catch (\Throwable $e) {

            report($e);


            return response()->json([

                'success' =>
                    false,

                'type' =>
                    'error',

                'message' =>
                    'Unable to update tax rate.',

            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Details
    |--------------------------------------------------------------------------
    */

    public function details(TaxRate $taxRate)
    {
        if (!canAccess('tax_rates.view')) {

            return response()->json([
                'status' => false,
                'message' =>
                    'You do not have permission to view tax rates.',
            ], 403);
        }


        try {

            /*
            |--------------------------------------------------------------------------
            | Company Check
            |--------------------------------------------------------------------------
            */

            if (
                $taxRate->company_id
                != $this->companyId
            ) {

                return response()->json([

                    'success' =>
                        false,

                    'type' =>
                        'error',

                    'message' =>
                        'Tax rate not found.',

                ], 404);
            }


            /*
            |--------------------------------------------------------------------------
            | Load Relationships
            |--------------------------------------------------------------------------
            */

            $taxRate->loadCount(
                'products'
            );


            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'success' =>
                    true,

                'data' =>
                    $taxRate,

            ]);


        } catch (\Throwable $e) {

            report($e);


            return response()->json([

                'success' =>
                    false,

                'type' =>
                    'error',

                'message' =>
                    'Unable to load tax rate details.',

            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Toggle Status
    |--------------------------------------------------------------------------
    */

    public function toggleStatus(
        Request $request,
        TaxRate $taxRate
    ) {
        if (
            !canAccess(
                'tax_rates.toggle_status'
            )
        ) {

            return response()->json([
                'status' => false,
                'message' =>
                    'You do not have permission to change tax rate status.',
            ], 403);
        }


        try {

            /*
            |--------------------------------------------------------------------------
            | Company Check
            |--------------------------------------------------------------------------
            */

            if (
                $taxRate->company_id
                != $this->companyId
            ) {

                return response()->json([

                    'success' =>
                        false,

                    'type' =>
                        'error',

                    'message' =>
                        'Tax rate not found.',

                ], 404);
            }


            /*
            |--------------------------------------------------------------------------
            | Old Values
            |--------------------------------------------------------------------------
            */

            $oldValues =
                $taxRate->toArray();


            /*
            |--------------------------------------------------------------------------
            | Update Status
            |--------------------------------------------------------------------------
            */

            $taxRate->update([

                'status' =>
                    !$taxRate->status,

            ]);


            /*
            |--------------------------------------------------------------------------
            | Refresh
            |--------------------------------------------------------------------------
            */

            $taxRate->refresh();


            /*
            |--------------------------------------------------------------------------
            | Action
            |--------------------------------------------------------------------------
            */

            $action =
                $taxRate->status
                    ? 'Enabled'
                    : 'Disabled';


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'Tax Rates',

                $action,

                "Tax rate {$action}: "
                    . $taxRate->name,

                $taxRate,

                $oldValues,

                $taxRate->toArray()

            );


            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'success' =>
                    true,

                'type' =>
                    'success',

                'message' =>
                    "Tax rate {$action} successfully.",

            ]);


        } catch (\Throwable $e) {

            report($e);


            return response()->json([

                'success' =>
                    false,

                'type' =>
                    'error',

                'message' =>
                    'Unable to update tax rate status.',

            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Destroy
    |--------------------------------------------------------------------------
    */

    public function destroy(TaxRate $taxRate)
    {
        if (!canAccess('tax_rates.delete')) {

            return response()->json([
                'status' => false,
                'message' =>
                    'You do not have permission to delete tax rates.',
            ], 403);
        }


        try {

            /*
            |--------------------------------------------------------------------------
            | Company Check
            |--------------------------------------------------------------------------
            */

            if (
                $taxRate->company_id
                != $this->companyId
            ) {

                return response()->json([

                    'success' =>
                        false,

                    'type' =>
                        'error',

                    'message' =>
                        'Tax rate not found.',

                ], 404);
            }


            /*
            |--------------------------------------------------------------------------
            | Check Usage
            |--------------------------------------------------------------------------
            |
            | Keep existing behaviour: a TaxRate assigned to Products cannot be
            | deleted even though deletion is now soft.
            |
            */

            if (
                $taxRate
                    ->products()
                    ->exists()
            ) {

                return response()->json([

                    'success' =>
                        false,

                    'type' =>
                        'warning',

                    'message' =>
                        'This tax rate is assigned to one or more products and cannot be deleted.',

                ], 422);
            }


            /*
            |--------------------------------------------------------------------------
            | Old Values
            |--------------------------------------------------------------------------
            */

            $oldValues =
                $taxRate->toArray();


            /*
            |--------------------------------------------------------------------------
            | Soft Delete
            |--------------------------------------------------------------------------
            |
            | TaxRate now uses SoftDeletes, so delete() preserves the row,
            | sync_uuid and historical identity.
            |
            */

            $taxRate->delete();


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'Tax Rates',

                'Deleted',

                'Deleted tax rate: '
                    . $taxRate->name,

                $taxRate,

                $oldValues,

                $taxRate->toArray()

            );


            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'success' =>
                    true,

                'type' =>
                    'success',

                'message' =>
                    'Tax rate deleted successfully.',

            ]);


        } catch (\Throwable $e) {

            report($e);


            return response()->json([

                'success' =>
                    false,

                'type' =>
                    'error',

                'message' =>
                    'Unable to delete tax rate.',

            ], 500);
        }
    }
}