<?php

namespace App\Http\Controllers\Admin;

use App\Models\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Services\ActivityLogger;

class SupplierController extends BaseController
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

    /**
     * Display the Suppliers page.
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('suppliers.view')) {

            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $stats = [

            'total' =>
                Supplier::query()
                    ->where(
                        'company_id',
                        $this->companyId
                    )
                    ->count(),

            'active' =>
                Supplier::query()
                    ->where(
                        'company_id',
                        $this->companyId
                    )
                    ->where(
                        'status',
                        true
                    )
                    ->count(),

            'inactive' =>
                Supplier::query()
                    ->where(
                        'company_id',
                        $this->companyId
                    )
                    ->where(
                        'status',
                        false
                    )
                    ->count(),

            'payables' =>
                Supplier::query()
                    ->where(
                        'company_id',
                        $this->companyId
                    )
                    ->sum(
                        'current_balance'
                    ),

        ];


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view(
            'purchase.supplier.index',
            compact(
                'stats'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Table
    |--------------------------------------------------------------------------
    */

    /**
     * Return Suppliers table data.
     */
    public function table(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('suppliers.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view suppliers.',

            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | Query
        |--------------------------------------------------------------------------
        */

        $suppliers =
            Supplier::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->with([
                    'creator:id,first_name,last_name',
                    'updater:id,first_name,last_name',
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

            $suppliers->where(
                function ($query) use ($search) {

                    $query

                        ->where(
                            'supplier_code',
                            'like',
                            '%' . $search . '%'
                        )

                        ->orWhere(
                            'name',
                            'like',
                            '%' . $search . '%'
                        )

                        ->orWhere(
                            'contact_person',
                            'like',
                            '%' . $search . '%'
                        )

                        ->orWhere(
                            'email',
                            'like',
                            '%' . $search . '%'
                        )

                        ->orWhere(
                            'phone',
                            'like',
                            '%' . $search . '%'
                        )

                        ->orWhere(
                            'tax_number',
                            'like',
                            '%' . $search . '%'
                        );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('status')
            && $request->status !== 'all'
        ) {

            $status =
                filter_var(
                    $request->status,
                    FILTER_VALIDATE_BOOLEAN,
                    FILTER_NULL_ON_FAILURE
                );

            if (
                $status !== null
            ) {

                $suppliers->where(
                    'status',
                    $status
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $suppliers =
            $suppliers

                ->latest()

                ->paginate(
                    15
                )

                ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Table HTML
        |--------------------------------------------------------------------------
        */

        $html =
            view(
                'purchase.supplier.partials.table',
                compact(
                    'suppliers'
                )
            )->render();


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        |
        | Statistics intentionally represent the company-wide Supplier
        | summary rather than the filtered/paginated table subset.
        |
        */

        $stats = [

            'total' =>
                Supplier::query()
                    ->where(
                        'company_id',
                        $this->companyId
                    )
                    ->count(),

            'active' =>
                Supplier::query()
                    ->where(
                        'company_id',
                        $this->companyId
                    )
                    ->where(
                        'status',
                        true
                    )
                    ->count(),

            'inactive' =>
                Supplier::query()
                    ->where(
                        'company_id',
                        $this->companyId
                    )
                    ->where(
                        'status',
                        false
                    )
                    ->count(),

            'payables' =>
                Supplier::query()
                    ->where(
                        'company_id',
                        $this->companyId
                    )
                    ->sum(
                        'current_balance'
                    ),

        ];


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
                $suppliers
                    ->links()
                    ->render(),

            'stats' =>
                $stats,

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Details
    |--------------------------------------------------------------------------
    */

    /**
     * Return Supplier details.
     */
    public function details(
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('suppliers.view')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to view suppliers.',

            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | Supplier
        |--------------------------------------------------------------------------
        */

        $supplier =
            Supplier::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->with([
                    'creator:id,first_name,last_name',
                    'updater:id,first_name,last_name',
                ])

                ->find(
                    $id
                );


        /*
        |--------------------------------------------------------------------------
        | Not Found
        |--------------------------------------------------------------------------
        */

        if (! $supplier) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Supplier not found.',

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

            'data' => [

                'id' =>
                    $supplier->id,

                'supplier_code' =>
                    $supplier->supplier_code,

                'name' =>
                    $supplier->name,

                'contact_person' =>
                    $supplier->contact_person,

                'email' =>
                    $supplier->email,

                'phone' =>
                    $supplier->phone,

                'alternate_phone' =>
                    $supplier->alternate_phone,

                'address' =>
                    $supplier->address,

                'city' =>
                    $supplier->city,

                'state' =>
                    $supplier->state,

                'country' =>
                    $supplier->country,

                'tax_number' =>
                    $supplier->tax_number,

                'payment_terms' =>
                    $supplier->payment_terms,

                'credit_limit' =>
                    (float) $supplier->credit_limit,

                'current_balance' =>
                    (float) $supplier->current_balance,

                'available_credit' =>
                    $supplier->availableCredit(),

                'notes' =>
                    $supplier->notes,

                'status' =>
                    $supplier->status,

                'status_label' =>
                    $supplier->statusLabel(),

                'created_by' =>
                    $supplier->creator
                        ? trim(
                            ($supplier->creator->first_name ?? '') .
                            ' ' .
                            ($supplier->creator->last_name ?? '')
                        )
                        : '—',

                'updated_by' =>
                    $supplier->updater
                        ? trim(
                            ($supplier->updater->first_name ?? '') .
                            ' ' .
                            ($supplier->updater->last_name ?? '')
                        )
                        : '—',

                'created_at' =>
                    $supplier->created_at
                        ? $supplier->created_at
                            ->format('d M Y H:i')
                        : null,

                'updated_at' =>
                    $supplier->updated_at
                        ? $supplier->updated_at
                            ->format('d M Y H:i')
                        : null,

            ],

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    /**
     * Create a Supplier.
     */
    public function store(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('suppliers.create')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to create suppliers.',

            ], 403);
        }


        try {

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

                    'contact_person' => [
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

                    'alternate_phone' => [
                        'nullable',
                        'string',
                        'max:30',
                    ],

                    'address' => [
                        'nullable',
                        'string',
                    ],

                    'city' => [
                        'nullable',
                        'string',
                        'max:100',
                    ],

                    'state' => [
                        'nullable',
                        'string',
                        'max:100',
                    ],

                    'country' => [
                        'nullable',
                        'string',
                        'max:100',
                    ],

                    'tax_number' => [
                        'nullable',
                        'string',
                        'max:100',
                    ],

                    'payment_terms' => [
                        'nullable',
                        'string',
                        'max:100',
                    ],

                    'credit_limit' => [
                        'nullable',
                        'numeric',
                        'min:0',
                    ],

                    'notes' => [
                        'nullable',
                        'string',
                    ],

                ]);


            /*
            |--------------------------------------------------------------------------
            | Normalized Values
            |--------------------------------------------------------------------------
            */

            $email =
                $validated['email']
                ?? null;

            $phone =
                $validated['phone']
                ?? null;


            /*
            |--------------------------------------------------------------------------
            | Existing Active Supplier
            |--------------------------------------------------------------------------
            */

            $existing =
                Supplier::query()

                    ->where(
                        'company_id',
                        $this->companyId
                    )

                    ->where(
                        function ($query) use (
                            $email,
                            $phone
                        ) {

                            if ($email) {

                                $query->where(
                                    'email',
                                    $email
                                );
                            }

                            if ($phone) {

                                if ($email) {

                                    $query->orWhere(
                                        'phone',
                                        $phone
                                    );

                                } else {

                                    $query->where(
                                        'phone',
                                        $phone
                                    );
                                }
                            }
                        }
                    )

                    ->first();


            /*
            |--------------------------------------------------------------------------
            | Duplicate Protection
            |--------------------------------------------------------------------------
            */

            if ($existing) {

                return response()->json([

                    'success' =>
                        false,

                    'message' =>
                        'A supplier with the supplied email or phone number already exists.',

                ], 422);
            }


            /*
            |--------------------------------------------------------------------------
            | Soft Deleted Supplier
            |--------------------------------------------------------------------------
            |
            | If the same supplier was previously archived, restore it
            | instead of creating an unnecessary duplicate.
            |
            */

            $deletedQuery =
                Supplier::withTrashed()

                    ->where(
                        'company_id',
                        $this->companyId
                    )

                    ->where(
                        function ($query) use (
                            $email,
                            $phone
                        ) {

                            if ($email) {

                                $query->where(
                                    'email',
                                    $email
                                );
                            }

                            if ($phone) {

                                if ($email) {

                                    $query->orWhere(
                                        'phone',
                                        $phone
                                    );

                                } else {

                                    $query->where(
                                        'phone',
                                        $phone
                                    );
                                }
                            }
                        }
                    );


            $deletedSupplier =
                $deletedQuery
                    ->onlyTrashed()
                    ->first();


            /*
            |--------------------------------------------------------------------------
            | Restore Existing Supplier
            |--------------------------------------------------------------------------
            */

            if ($deletedSupplier) {

                $oldValues =
                    $deletedSupplier->toArray();


                $deletedSupplier->restore();


                $deletedSupplier->fill([

                    'name' =>
                        $validated['name'],

                    'contact_person' =>
                        $validated['contact_person']
                        ?? null,

                    'email' =>
                        $email,

                    'phone' =>
                        $phone,

                    'alternate_phone' =>
                        $validated['alternate_phone']
                        ?? null,

                    'address' =>
                        $validated['address']
                        ?? null,

                    'city' =>
                        $validated['city']
                        ?? null,

                    'state' =>
                        $validated['state']
                        ?? null,

                    'country' =>
                        $validated['country']
                        ?? null,

                    'tax_number' =>
                        $validated['tax_number']
                        ?? null,

                    'payment_terms' =>
                        $validated['payment_terms']
                        ?? null,

                    'credit_limit' =>
                        $validated['credit_limit']
                        ?? 0,

                    'status' =>
                        true,

                    'updated_by' =>
                        auth()->id(),

                ]);


                $deletedSupplier->save();


                /*
                |--------------------------------------------------------------------------
                | Activity Log
                |--------------------------------------------------------------------------
                */

                $this->activityLogger->log(

                    'Suppliers',

                    'Restored',

                    'Restored supplier: ' .
                        $deletedSupplier->name,

                    $deletedSupplier,

                    $oldValues,

                    $deletedSupplier->fresh()
                        ->toArray()

                );


                return response()->json([

                    'success' =>
                        true,

                    'message' =>
                        'The supplier already existed and has been restored successfully.',

                    'data' =>
                        $deletedSupplier->fresh(),

                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Generate Supplier Code
            |--------------------------------------------------------------------------
            */

            $supplierCode =
                $this->generateSupplierCode();


            /*
            |--------------------------------------------------------------------------
            | Create Supplier
            |--------------------------------------------------------------------------
            */

            $supplier =
                DB::transaction(
                    function () use (
                        $validated,
                        $supplierCode
                    ) {

                        return Supplier::create([

                            'company_id' =>
                                $this->companyId,

                            'supplier_code' =>
                                $supplierCode,

                            'name' =>
                                $validated['name'],

                            'contact_person' =>
                                $validated['contact_person']
                                ?? null,

                            'email' =>
                                $validated['email']
                                ?? null,

                            'phone' =>
                                $validated['phone']
                                ?? null,

                            'alternate_phone' =>
                                $validated['alternate_phone']
                                ?? null,

                            'address' =>
                                $validated['address']
                                ?? null,

                            'city' =>
                                $validated['city']
                                ?? null,

                            'state' =>
                                $validated['state']
                                ?? null,

                            'country' =>
                                $validated['country']
                                ?? null,

                            'tax_number' =>
                                $validated['tax_number']
                                ?? null,

                            'payment_terms' =>
                                $validated['payment_terms']
                                ?? null,

                            'credit_limit' =>
                                $validated['credit_limit']
                                ?? 0,

                            'current_balance' =>
                                0,

                            'notes' =>
                                $validated['notes']
                                ?? null,

                            'status' =>
                                true,

                            'created_by' =>
                                auth()->id(),

                            'updated_by' =>
                                auth()->id(),

                        ]);
                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'Suppliers',

                'Created',

                'Created supplier: ' .
                    $supplier->name,

                $supplier,

                null,

                $supplier->toArray()

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
                    'Supplier created successfully.',

                'data' =>
                    $supplier,

            ]);

        } catch (
            ValidationException $e
        ) {

            throw $e;

        } catch (
            \Throwable $e
        ) {

            \Log::error(
                'Supplier creation failed.',
                [

                    'company_id' =>
                        $this->companyId,

                    'error' =>
                        $e->getMessage(),

                ]
            );


            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Unable to create supplier.',

            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    /**
     * Update a Supplier.
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

        if (! canAccess('suppliers.update')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to update suppliers.',

            ], 403);
        }


        try {

            /*
            |--------------------------------------------------------------------------
            | Supplier
            |--------------------------------------------------------------------------
            */

            $supplier =
                Supplier::query()

                    ->where(
                        'company_id',
                        $this->companyId
                    )

                    ->find(
                        $id
                    );


            if (! $supplier) {

                return response()->json([

                    'success' =>
                        false,

                    'message' =>
                        'Supplier not found.',

                ], 404);
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

                    'contact_person' => [
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

                    'alternate_phone' => [
                        'nullable',
                        'string',
                        'max:30',
                    ],

                    'address' => [
                        'nullable',
                        'string',
                    ],

                    'city' => [
                        'nullable',
                        'string',
                        'max:100',
                    ],

                    'state' => [
                        'nullable',
                        'string',
                        'max:100',
                    ],

                    'country' => [
                        'nullable',
                        'string',
                        'max:100',
                    ],

                    'tax_number' => [
                        'nullable',
                        'string',
                        'max:100',
                    ],

                    'payment_terms' => [
                        'nullable',
                        'string',
                        'max:100',
                    ],

                    'credit_limit' => [
                        'nullable',
                        'numeric',
                        'min:0',
                    ],

                    'notes' => [
                        'nullable',
                        'string',
                    ],

                ]);


            /*
            |--------------------------------------------------------------------------
            | Duplicate Contact Check
            |--------------------------------------------------------------------------
            */

            $duplicate =
                Supplier::query()

                    ->where(
                        'company_id',
                        $this->companyId
                    )

                    ->where(
                        'id',
                        '!=',
                        $supplier->id
                    )

                    ->where(
                        function ($query) use (
                            $validated
                        ) {

                            if (
                                ! empty(
                                    $validated['email']
                                )
                            ) {

                                $query->where(
                                    'email',
                                    $validated['email']
                                );
                            }

                            if (
                                ! empty(
                                    $validated['phone']
                                )
                            ) {

                                if (
                                    ! empty(
                                        $validated['email']
                                    )
                                ) {

                                    $query->orWhere(
                                        'phone',
                                        $validated['phone']
                                    );

                                } else {

                                    $query->where(
                                        'phone',
                                        $validated['phone']
                                    );
                                }
                            }
                        }
                    )

                    ->first();


            if ($duplicate) {

                return response()->json([

                    'success' =>
                        false,

                    'message' =>
                        'Another supplier with the supplied email or phone number already exists.',

                ], 422);
            }


            /*
            |--------------------------------------------------------------------------
            | Old Values
            |--------------------------------------------------------------------------
            */

            $oldValues =
                $supplier->toArray();


            /*
            |--------------------------------------------------------------------------
            | Update
            |--------------------------------------------------------------------------
            */

            $supplier->update([

                'name' =>
                    $validated['name'],

                'contact_person' =>
                    $validated['contact_person']
                    ?? null,

                'email' =>
                    $validated['email']
                    ?? null,

                'phone' =>
                    $validated['phone']
                    ?? null,

                'alternate_phone' =>
                    $validated['alternate_phone']
                    ?? null,

                'address' =>
                    $validated['address']
                    ?? null,

                'city' =>
                    $validated['city']
                    ?? null,

                'state' =>
                    $validated['state']
                    ?? null,

                'country' =>
                    $validated['country']
                    ?? null,

                'tax_number' =>
                    $validated['tax_number']
                    ?? null,

                'payment_terms' =>
                    $validated['payment_terms']
                    ?? null,

                'credit_limit' =>
                    $validated['credit_limit']
                    ?? 0,

                'notes' =>
                    $validated['notes']
                    ?? null,

                'updated_by' =>
                    auth()->id(),

            ]);


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'Suppliers',

                'Updated',

                'Updated supplier: ' .
                    $supplier->name,

                $supplier,

                $oldValues,

                $supplier->fresh()
                    ->toArray()

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
                    'Supplier updated successfully.',

                'data' =>
                    $supplier->fresh(),

            ]);

        } catch (
            ValidationException $e
        ) {

            throw $e;

        } catch (
            \Throwable $e
        ) {

            \Log::error(
                'Supplier update failed.',
                [

                    'company_id' =>
                        $this->companyId,

                    'supplier_id' =>
                        $id,

                    'error' =>
                        $e->getMessage(),

                ]
            );


            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Unable to update supplier.',

            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Destroy
    |--------------------------------------------------------------------------
    */

    /**
     * Soft delete a Supplier.
     */
    public function destroy(
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('suppliers.delete')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to delete suppliers.',

            ], 403);
        }


        try {

            /*
            |--------------------------------------------------------------------------
            | Supplier
            |--------------------------------------------------------------------------
            */

            $supplier =
                Supplier::query()

                    ->where(
                        'company_id',
                        $this->companyId
                    )

                    ->find(
                        $id
                    );


            if (! $supplier) {

                return response()->json([

                    'success' =>
                        false,

                    'message' =>
                        'Supplier not found.',

                ], 404);
            }


            /*
            |--------------------------------------------------------------------------
            | Transaction Protection
            |--------------------------------------------------------------------------
            |
            | Purchase Orders, Goods Received and Purchase Returns
            | will be introduced later. For now, the Supplier can be
            | removed because those transaction relationships do not
            | exist yet.
            |
            */


            /*
            |--------------------------------------------------------------------------
            | Old Values
            |--------------------------------------------------------------------------
            */

            $oldValues =
                $supplier->toArray();


            /*
            |--------------------------------------------------------------------------
            | Delete
            |--------------------------------------------------------------------------
            */

            $supplier->delete();


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'Suppliers',

                'Deleted',

                'Deleted supplier: ' .
                    $supplier->name,

                $supplier,

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
                    'Supplier deleted successfully.',

            ]);

        } catch (
            \Throwable $e
        ) {

            \Log::error(
                'Supplier deletion failed.',
                [

                    'company_id' =>
                        $this->companyId,

                    'supplier_id' =>
                        $id,

                    'error' =>
                        $e->getMessage(),

                ]
            );


            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Unable to delete supplier.',

            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Toggle Status
    |--------------------------------------------------------------------------
    */

    /**
     * Toggle Supplier status.
     */
    public function toggleStatus(
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('suppliers.update')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to update supplier status.',

            ], 403);
        }


        try {

            /*
            |--------------------------------------------------------------------------
            | Supplier
            |--------------------------------------------------------------------------
            */

            $supplier =
                Supplier::query()

                    ->where(
                        'company_id',
                        $this->companyId
                    )

                    ->find(
                        $id
                    );


            if (! $supplier) {

                return response()->json([

                    'success' =>
                        false,

                    'message' =>
                        'Supplier not found.',

                ], 404);
            }


            /*
            |--------------------------------------------------------------------------
            | Old Values
            |--------------------------------------------------------------------------
            */

            $oldValues =
                $supplier->toArray();


            /*
            |--------------------------------------------------------------------------
            | Toggle
            |--------------------------------------------------------------------------
            */

            $supplier->status =
                ! $supplier->status;

            $supplier->updated_by =
                auth()->id();

            $supplier->save();


            /*
            |--------------------------------------------------------------------------
            | Status Label
            |--------------------------------------------------------------------------
            */

            $action =
                $supplier->status
                    ? 'Enabled'
                    : 'Disabled';


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'Suppliers',

                $action,

                $action .
                    ' supplier: ' .
                    $supplier->name,

                $supplier,

                $oldValues,

                $supplier->fresh()
                    ->toArray()

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
                    'Supplier ' .
                    strtolower($action) .
                    ' successfully.',

                'data' => [

                    'id' =>
                        $supplier->id,

                    'status' =>
                        $supplier->status,

                    'status_label' =>
                        $supplier->statusLabel(),

                ],

            ]);

        } catch (
            \Throwable $e
        ) {

            \Log::error(
                'Supplier status update failed.',
                [

                    'company_id' =>
                        $this->companyId,

                    'supplier_id' =>
                        $id,

                    'error' =>
                        $e->getMessage(),

                ]
            );


            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Unable to update supplier status.',

            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Generate Supplier Code
    |--------------------------------------------------------------------------
    */

    /**
     * Generate the next Supplier code.
     */
    protected function generateSupplierCode(): string
    {
        $lastSupplier =
            Supplier::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->orderByDesc(
                    'id'
                )

                ->first();


        $nextNumber =
            $lastSupplier
                ? (
                    (int)
                    preg_replace(
                        '/[^0-9]/',
                        '',
                        $lastSupplier->supplier_code
                    )
                    + 1
                )
                : 1;


        return 'SUP-' .
            str_pad(
                $nextNumber,
                5,
                '0',
                STR_PAD_LEFT
            );
    }
}