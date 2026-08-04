<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\TaxRate;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

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

        $this->activityLogger = $activityLogger;
    }

    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $statistics = [

            'total' => TaxRate::forCompany(
                $this->companyId
            )->count(),

            'active' => TaxRate::forCompany(
                $this->companyId
            )->where(
                'status',
                true
            )->count(),

            'inactive' => TaxRate::forCompany(
                $this->companyId
            )->where(
                'status',
                false
            )->count(),

        ];

        $taxRates = TaxRate::forCompany(
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
        $query = TaxRate::query()

            ->forCompany(
                $this->companyId
            );

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim(
                $request->search
            );

            $query->where(function ($q) use ($search) {

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

            });

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

        $taxRates = $query

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
        try {

            /*
            |--------------------------------------------------------------------------
            | Validate
            |--------------------------------------------------------------------------
            */

            $validated = $request->validate([

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
            | Check Existing Tax Rate
            |--------------------------------------------------------------------------
            */

            $exists = TaxRate::where(

                    'company_id',

                    $this->companyId

                )

                ->whereRaw(

                    'LOWER(name) = ?',

                    [strtolower(trim($validated['name']))]

                )

                ->exists();

            if ($exists) {

                return response()->json([

                    'success' => false,

                    'type' => 'warning',

                    'message' => 'A tax rate with this name already exists.'

                ], 422);

            }

            /*
            |--------------------------------------------------------------------------
            | Create Tax Rate
            |--------------------------------------------------------------------------
            */

            $taxRate = TaxRate::create([

                'company_id' => $this->companyId,

                'name' => trim($validated['name']),

                'rate' => $validated['rate'],

                'status' => true,

            ]);

            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'Tax Rates',

                'Created',

                'Created tax rate: ' . $taxRate->name,

                $taxRate

            );

            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'success' => true,

                'type' => 'success',

                'message' => 'Tax rate created successfully.'

            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            throw $e;

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'type' => 'error',

                'message' => 'Unable to create tax rate.'

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
        try {

            /*
            |--------------------------------------------------------------------------
            | Company Check
            |--------------------------------------------------------------------------
            */

            if ($taxRate->company_id != $this->companyId) {

                return response()->json([

                    'success' => false,

                    'type'    => 'error',

                    'message' => 'Tax rate not found.'

                ], 404);

            }

            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'success' => true,

                'data'    => $taxRate

            ]);

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'type'    => 'error',

                'message' => 'Unable to load tax rate.'

            ], 500);

        }
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, TaxRate $taxRate)
    {
        try {

            /*
            |--------------------------------------------------------------------------
            | Company Check
            |--------------------------------------------------------------------------
            */

            if ($taxRate->company_id != $this->companyId) {

                return response()->json([

                    'success' => false,

                    'type' => 'error',

                    'message' => 'Tax rate not found.'

                ], 404);

            }

            /*
            |--------------------------------------------------------------------------
            | Validate
            |--------------------------------------------------------------------------
            */

            $validated = $request->validate([

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
            | Duplicate Check
            |--------------------------------------------------------------------------
            */

            $exists = TaxRate::where(

                    'company_id',

                    $this->companyId

                )

                ->whereRaw(

                    'LOWER(name) = ?',

                    [strtolower(trim($validated['name']))]

                )

                ->where(

                    'id',

                    '!=',

                    $taxRate->id

                )

                ->exists();

            if ($exists) {

                return response()->json([

                    'success' => false,

                    'type' => 'warning',

                    'message' => 'A tax rate with this name already exists.'

                ], 422);

            }

            /*
            |--------------------------------------------------------------------------
            | Old Values
            |--------------------------------------------------------------------------
            */

            $oldValues = $taxRate->toArray();

            /*
            |--------------------------------------------------------------------------
            | Update
            |--------------------------------------------------------------------------
            */

            $taxRate->update([

                'name' => trim($validated['name']),

                'rate' => $validated['rate'],

            ]);

            /*
            |--------------------------------------------------------------------------
            | New Values
            |--------------------------------------------------------------------------
            */

            $newValues = $taxRate->fresh()->toArray();

            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'Tax Rates',

                'Updated',

                'Updated tax rate: '.$taxRate->name,

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

                'success' => true,

                'type' => 'success',

                'message' => 'Tax rate updated successfully.'

            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            throw $e;

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'type' => 'error',

                'message' => 'Unable to update tax rate.'

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
        try {

            /*
            |--------------------------------------------------------------------------
            | Company Check
            |--------------------------------------------------------------------------
            */

            if ($taxRate->company_id != $this->companyId) {

                return response()->json([

                    'success' => false,

                    'type'    => 'error',

                    'message' => 'Tax rate not found.'

                ], 404);

            }

            /*
            |--------------------------------------------------------------------------
            | Load Relationships
            |--------------------------------------------------------------------------
            */

            $taxRate->loadCount('products');

            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'success' => true,

                'data'    => $taxRate

            ]);

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'type'    => 'error',

                'message' => 'Unable to load tax rate details.'

            ], 500);

        }
    }

    /*
    |--------------------------------------------------------------------------
    | Toggle Status
    |--------------------------------------------------------------------------
    */

    public function toggleStatus(Request $request, TaxRate $taxRate)
    {
        try {

            /*
            |--------------------------------------------------------------------------
            | Company Check
            |--------------------------------------------------------------------------
            */

            if ($taxRate->company_id != $this->companyId) {

                return response()->json([

                    'success' => false,

                    'type' => 'error',

                    'message' => 'Tax rate not found.'

                ], 404);

            }

            /*
            |--------------------------------------------------------------------------
            | Update Status
            |--------------------------------------------------------------------------
            */

            $taxRate->update([

                'status' => !$taxRate->status,

            ]);

            /*
            |--------------------------------------------------------------------------
            | Action
            |--------------------------------------------------------------------------
            */

            $action = $taxRate->status
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

                "Tax rate {$action}: {$taxRate->name}",

                $taxRate

            );

            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'success' => true,

                'type' => 'success',

                'message' => "Tax rate {$action} successfully."

            ]);

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'type' => 'error',

                'message' => 'Unable to update tax rate status.'

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
        try {

            /*
            |--------------------------------------------------------------------------
            | Company Check
            |--------------------------------------------------------------------------
            */

            if ($taxRate->company_id != $this->companyId) {

                return response()->json([

                    'success' => false,

                    'type'    => 'error',

                    'message' => 'Tax rate not found.'

                ], 404);

            }

            /*
            |--------------------------------------------------------------------------
            | Check Usage
            |--------------------------------------------------------------------------
            */

            if ($taxRate->products()->exists()) {

                return response()->json([

                    'success' => false,

                    'type'    => 'warning',

                    'message' => 'This tax rate is assigned to one or more products and cannot be deleted.'

                ], 422);

            }

            /*
            |--------------------------------------------------------------------------
            | Delete
            |--------------------------------------------------------------------------
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

                'Deleted tax rate: '.$taxRate->name,

                $taxRate

            );

            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'success' => true,

                'type'    => 'success',

                'message' => 'Tax rate deleted successfully.'

            ]);

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'type'    => 'error',

                'message' => 'Unable to delete tax rate.'

            ], 500);

        }
    }
}