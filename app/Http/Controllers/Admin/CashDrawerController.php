<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\CashDrawer;
use App\Models\CashDrawerTransaction;
use App\Models\Terminal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Services\ActivityLogger;

class CashDrawerController extends BaseController
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
     * Cash Drawer index page.
     */
    public function index(
        Request $request
    ) {
        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('pos.cash_drawer')) {

            abort(
                403,
                'You do not have permission to access the cash drawer.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Branches
        |--------------------------------------------------------------------------
        */

        $branches =
            Branch::query()
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
        | Terminals
        |--------------------------------------------------------------------------
        */

        $terminals =
            Terminal::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->orderBy(
                    'terminal_name'
                )
                ->get();

        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view(
            'pos.cash-drawer.index',
            compact(
                'branches',
                'terminals'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Current
    |--------------------------------------------------------------------------
    */

    /**
     * Return the currently open drawer.
     */
    public function current(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('pos.cash_drawer')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to access the cash drawer.',

            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([

                'branch_id' => [
                    'required',
                    'integer',
                    'exists:branches,id',
                ],

                'terminal_id' => [
                    'required',
                    'integer',
                    'exists:terminals,id',
                ],

            ]);

        /*
        |--------------------------------------------------------------------------
        | Drawer
        |--------------------------------------------------------------------------
        */

        $drawer =
            CashDrawer::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->where(
                    'branch_id',
                    $validated['branch_id']
                )
                ->where(
                    'terminal_id',
                    $validated['terminal_id']
                )
                ->open()
                ->with([
                    'openedBy',
                    'branch',
                    'terminal',
                ])
                ->latest(
                    'id'
                )
                ->first();

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'data' =>
                $drawer,

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Open
    |--------------------------------------------------------------------------
    */

    /**
     * Open a cash drawer.
     */
    public function open(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('pos.cash_drawer')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to open a cash drawer.',

            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([

                'branch_id' => [
                    'required',
                    'integer',
                    'exists:branches,id',
                ],

                'terminal_id' => [
                    'required',
                    'integer',
                    'exists:terminals,id',
                ],

                'opening_balance' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'opening_remarks' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],

            ]);

        try {

            $result =
                DB::transaction(

                    function () use (
                        $validated
                    ) {

                        /*
                        |--------------------------------------------------------------------------
                        | Branch
                        |--------------------------------------------------------------------------
                        */

                        $branch =
                            Branch::query()
                                ->where(
                                    'company_id',
                                    $this->companyId
                                )
                                ->where(
                                    'id',
                                    $validated['branch_id']
                                )
                                ->first();

                        if (! $branch) {

                            throw ValidationException::withMessages([

                                'branch_id' =>
                                    'Selected branch is not available.',

                            ]);
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Terminal
                        |--------------------------------------------------------------------------
                        */

                        $terminal =
                            Terminal::query()
                                ->where(
                                    'company_id',
                                    $this->companyId
                                )
                                ->where(
                                    'id',
                                    $validated['terminal_id']
                                )
                                ->first();

                        if (! $terminal) {

                            throw ValidationException::withMessages([

                                'terminal_id' =>
                                    'Selected terminal is not available.',

                            ]);
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Existing Open Drawer
                        |--------------------------------------------------------------------------
                        */

                        $existingDrawer =
                            CashDrawer::query()
                                ->where(
                                    'company_id',
                                    $this->companyId
                                )
                                ->where(
                                    'branch_id',
                                    $validated['branch_id']
                                )
                                ->where(
                                    'terminal_id',
                                    $validated['terminal_id']
                                )
                                ->open()
                                ->lockForUpdate()
                                ->first();

                        if ($existingDrawer) {

                            throw ValidationException::withMessages([

                                'cash_drawer' =>
                                    'An open cash drawer already exists for the selected branch and terminal.',

                            ]);
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Create Drawer
                        |--------------------------------------------------------------------------
                        */

                        $drawer =
                            CashDrawer::create([

                                'company_id' =>
                                    $this->companyId,

                                'branch_id' =>
                                    $validated['branch_id'],

                                'terminal_id' =>
                                    $validated['terminal_id'],

                                'opened_by' =>
                                    auth()->id(),

                                'closed_by' =>
                                    null,

                                'opening_balance' =>
                                    $validated['opening_balance'],

                                'cash_sales' =>
                                    0,

                                'cash_in' =>
                                    0,

                                'cash_out' =>
                                    0,

                                'cash_refunds' =>
                                    0,

                                'expected_balance' =>
                                    $validated['opening_balance'],

                                'actual_balance' =>
                                    0,

                                'variance' =>
                                    0,

                                'status' =>
                                    'Open',

                                'opened_at' =>
                                    now(),

                                'closed_at' =>
                                    null,

                                'opening_remarks' =>
                                    $validated['opening_remarks'] ?? null,

                                'closing_remarks' =>
                                    null,

                            ]);

                        /*
                        |--------------------------------------------------------------------------
                        | Opening Transaction
                        |--------------------------------------------------------------------------
                        */

                        CashDrawerTransaction::create([

                            'company_id' =>
                                $this->companyId,

                            'branch_id' =>
                                $validated['branch_id'],

                            'terminal_id' =>
                                $validated['terminal_id'],

                            'cash_drawer_id' =>
                                $drawer->id,

                            'payment_id' =>
                                null,

                            'order_id' =>
                                null,

                            'created_by' =>
                                auth()->id(),

                            'transaction_type' =>
                                'Cash In',

                            'amount' =>
                                $validated['opening_balance'],

                            'balance_before' =>
                                0,

                            'balance_after' =>
                                $validated['opening_balance'],

                            'reference_no' =>
                                null,

                            'remarks' =>
                                'Cash drawer opened.',

                        ]);

                        return [

                            'drawer' =>
                                $drawer->fresh([
                                    'openedBy',
                                    'branch',
                                    'terminal',
                                ]),

                        ];
                    }
                );

            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'cash_drawer',

                'Opened',

                'Opened cash drawer.',

                $result['drawer'],

                null,

                $result['drawer']->toArray()

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
                    'Cash drawer opened successfully.',

                'data' =>
                    $result['drawer'],

            ]);

        } catch (ValidationException $e) {

            throw $e;

        } catch (\Throwable $e) {

            Log::error(

                'Failed to open cash drawer.',

                [

                    'company_id' =>
                        $this->companyId,

                    'user_id' =>
                        auth()->id(),

                    'error' =>
                        $e->getMessage(),

                ]

            );

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Unable to open cash drawer. Please try again.',

            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Close
    |--------------------------------------------------------------------------
    */

    /**
     * Close a cash drawer.
     */
    public function close(
        Request $request,
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('pos.cash_drawer')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to close a cash drawer.',

            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([

                'actual_balance' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'closing_remarks' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],

            ]);

        try {

            $result =
                DB::transaction(

                    function () use (
                        $validated,
                        $id
                    ) {

                        /*
                        |--------------------------------------------------------------------------
                        | Drawer
                        |--------------------------------------------------------------------------
                        */

                        $drawer =
                            CashDrawer::query()
                                ->where(
                                    'company_id',
                                    $this->companyId
                                )
                                ->where(
                                    'id',
                                    $id
                                )
                                ->lockForUpdate()
                                ->first();

                        if (! $drawer) {

                            throw ValidationException::withMessages([

                                'cash_drawer' =>
                                    'Cash drawer not found.',

                            ]);
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Status
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $drawer->status !==
                            'Open'
                        ) {

                            throw ValidationException::withMessages([

                                'cash_drawer' =>
                                    'This cash drawer is already closed.',

                            ]);
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Expected Balance
                        |--------------------------------------------------------------------------
                        */

                        $expectedBalance =
                            (float) (
                                $drawer->opening_balance
                                +
                                $drawer->cash_sales
                                +
                                $drawer->cash_in
                                -
                                $drawer->cash_out
                                -
                                $drawer->cash_refunds
                            );

                        /*
                        |--------------------------------------------------------------------------
                        | Actual Balance
                        |--------------------------------------------------------------------------
                        */

                        $actualBalance =
                            (float)
                            $validated['actual_balance'];

                        /*
                        |--------------------------------------------------------------------------
                        | Variance
                        |--------------------------------------------------------------------------
                        */

                        $variance =
                            $actualBalance -
                            $expectedBalance;

                        /*
                        |--------------------------------------------------------------------------
                        | Old Values
                        |--------------------------------------------------------------------------
                        */

                        $oldValues =
                            $drawer->toArray();

                        /*
                        |--------------------------------------------------------------------------
                        | Update Drawer
                        |--------------------------------------------------------------------------
                        */

                        $drawer->update([

                            'expected_balance' =>
                                $expectedBalance,

                            'actual_balance' =>
                                $actualBalance,

                            'variance' =>
                                $variance,

                            'status' =>
                                'Closed',

                            'closed_by' =>
                                auth()->id(),

                            'closed_at' =>
                                now(),

                            'closing_remarks' =>
                                $validated['closing_remarks'] ?? null,

                        ]);

                        return [

                            'drawer' =>
                                $drawer->fresh([
                                    'openedBy',
                                    'closedBy',
                                    'branch',
                                    'terminal',
                                ]),

                            'old_values' =>
                                $oldValues,

                        ];
                    }
                );

            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'cash_drawer',

                'Closed',

                'Closed cash drawer.',

                $result['drawer'],

                $result['old_values'],

                $result['drawer']->toArray()

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
                    'Cash drawer closed successfully.',

                'data' =>
                    $result['drawer'],

            ]);

        } catch (ValidationException $e) {

            throw $e;

        } catch (\Throwable $e) {

            Log::error(

                'Failed to close cash drawer.',

                [

                    'company_id' =>
                        $this->companyId,

                    'user_id' =>
                        auth()->id(),

                    'cash_drawer_id' =>
                        $id,

                    'error' =>
                        $e->getMessage(),

                ]

            );

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Unable to close cash drawer. Please try again.',

            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Transactions
    |--------------------------------------------------------------------------
    */

    /**
     * Return transactions for a cash drawer.
     */
    public function transactions(
        Request $request,
        int $id
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('pos.cash_drawer')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to access cash drawer transactions.',

            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | Drawer
        |--------------------------------------------------------------------------
        */

        $drawer =
            CashDrawer::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->where(
                    'id',
                    $id
                )
                ->first();

        if (! $drawer) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Cash drawer not found.',

            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | Transactions
        |--------------------------------------------------------------------------
        */

        $transactions =
            CashDrawerTransaction::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->where(
                    'cash_drawer_id',
                    $drawer->id
                )
                ->with([
                    'createdBy',
                    'payment',
                    'order',
                ])
                ->latest()
                ->paginate(
                    15
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
                $transactions,

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | History
    |--------------------------------------------------------------------------
    */

    /**
     * Return cash drawer history.
     */
    public function history(
        Request $request
    ): JsonResponse {

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('pos.cash_drawer')) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'You do not have permission to access cash drawer history.',

            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | Query
        |--------------------------------------------------------------------------
        */

        $query =
            CashDrawer::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->with([
                    'branch',
                    'terminal',
                    'openedBy',
                    'closedBy',
                ]);

        /*
        |--------------------------------------------------------------------------
        | Branch Filter
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled(
                'branch_id'
            )
        ) {

            $query->where(
                'branch_id',
                $request->branch_id
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Terminal Filter
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled(
                'terminal_id'
            )
        ) {

            $query->where(
                'terminal_id',
                $request->terminal_id
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled(
                'status'
            )
        ) {

            $query->where(
                'status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled(
                'search'
            )
        ) {

            $search =
                trim(
                    $request->search
                );

            $query->where(function ($q) use ($search) {

                $q->whereHas(
                    'openedBy',
                    function ($userQuery) use ($search) {

                        $userQuery
                            ->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            );
                    }
                );

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $drawers =
            $query
                ->latest(
                    'id'
                )
                ->paginate(
                    15
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
                $drawers,

        ]);
    }
}