<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Branch;
use App\Models\CashDrawer;
use App\Models\CashDrawerMovement;
use App\Models\CashDrawerTransaction;
use App\Models\Payment;
use App\Models\Terminal;
use App\Models\User;
use App\Models\TerminalAssignment;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

use App\Services\ActivityLogger;

use Illuminate\Http\RedirectResponse;

class CashDrawerController extends BaseController
{
    protected ActivityLogger $activityLogger;


    public function __construct(ActivityLogger $activityLogger)
    {
        parent::__construct();

        $this->activityLogger = $activityLogger;
    }    

    /**
     * |--------------------------------------------------------------------------
     * | POS TERMINAL ACCESS
     * |--------------------------------------------------------------------------
     */
    private function ensureTerminalAssignment(): ?RedirectResponse
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Cashiers must have an active terminal assignment
        |--------------------------------------------------------------------------
        */

        if (
            $user->hasRole('cashier')
            && ! $user->activeTerminalAssignment()->exists()
        ) {

            return redirect()
                ->route('dashboard')
                ->with(
                    'error',
                    'You do not have a POS terminal assigned to you. Please contact your administrator to assign a terminal before starting a sale.'
                );
        }

        return null;
    }


   /**
     * Cash Drawer index page.
     */
    public function index(
        Request $request
    ) {

        /*
        |--------------------------------------------------------------------------
        | Terminal Assignment
        |--------------------------------------------------------------------------
        */

        if (
            $response =
                $this->ensureTerminalAssignment()
        ) {

            return $response;
        }

        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (
            !canAccess(
                'pos.cash_drawer'
            )
        ) {

            abort(
                403,
                'You do not have permission to access the cash drawer.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Current User
        |--------------------------------------------------------------------------
        */

        $user =
            auth()->user();

        $userId =
            $user->id;

        /*
        |--------------------------------------------------------------------------
        | Access Scope
        |--------------------------------------------------------------------------
        */

        $role =
            $user->role?->code;

        $canManageAllBranches =
            in_array(
                $role,
                [
                    'owner',
                    'administrator',
                ]
            );

        $isBranchManager =
            $role === 'branch_manager';

        $isCashier =
            $role === 'cashier';

        $currentBranchId =
            $user->branch_id;

        /*
        |--------------------------------------------------------------------------
        | Active Terminal Assignment
        |--------------------------------------------------------------------------
        */

        $terminalAssignment =
            TerminalAssignment::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->where(
                    'user_id',
                    $userId
                )
                ->where(
                    'status',
                    'active'
                )
                ->with([
                    'branch',
                    'terminal',
                ])
                ->latest(
                    'assigned_at'
                )
                ->first();

        /*
        |--------------------------------------------------------------------------
        | Current Terminal
        |--------------------------------------------------------------------------
        */

        $currentTerminal =
            $terminalAssignment?->terminal;

        /*
        |--------------------------------------------------------------------------
        | Current Branch
        |--------------------------------------------------------------------------
        */

        $currentBranch =
            $terminalAssignment?->branch;

        /*
        |--------------------------------------------------------------------------
        | Current Drawer
        |--------------------------------------------------------------------------
        */

        $currentDrawer = null;

        if ($currentTerminal) {

            $drawerQuery =
                CashDrawer::query()
                    ->where(
                        'company_id',
                        $this->companyId
                    )
                    ->where(
                        'terminal_id',
                        $currentTerminal->id
                    )
                    ->where(
                        'status',
                        'open'
                    );

            /*
            |--------------------------------------------------------------------------
            | Cashier Scope
            |--------------------------------------------------------------------------
            |
            | A cashier can only see their own open drawer.
            |
            */

            if ($isCashier) {

                $drawerQuery->where(
                    'opened_by',
                    $userId
                );

            /*
            |--------------------------------------------------------------------------
            | Branch Manager Scope
            |--------------------------------------------------------------------------
            |
            | Branch managers can see drawers belonging to their branch.
            |
            */

            } elseif ($isBranchManager) {

                $drawerQuery->where(
                    'branch_id',
                    $currentBranchId
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Current Drawer
            |--------------------------------------------------------------------------
            */

            $currentDrawer =
                $drawerQuery
                    ->latest(
                        'opened_at'
                    )
                    ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | Branches
        |--------------------------------------------------------------------------
        */

        $branchesQuery =
            Branch::query()
                ->where(
                    'company_id',
                    $this->companyId
                );

        /*
        |--------------------------------------------------------------------------
        | Branch Scope
        |--------------------------------------------------------------------------
        |
        | Owner / Administrator:
        |     All branches.
        |
        | Branch Manager:
        |     Own branch.
        |
        | Cashier:
        |     Own branch.
        |
        */

        if (!$canManageAllBranches) {

            $branchesQuery->where(
                'id',
                $currentBranchId
            );
        }

        $branches =
            $branchesQuery
                ->orderBy(
                    'name'
                )
                ->get();

        /*
        |--------------------------------------------------------------------------
        | Terminals
        |--------------------------------------------------------------------------
        */

        $terminalsQuery =
            Terminal::query()
                ->where(
                    'company_id',
                    $this->companyId
                );

        /*
        |--------------------------------------------------------------------------
        | Terminal Scope
        |--------------------------------------------------------------------------
        |
        | Owner / Administrator:
        |     All terminals.
        |
        | Branch Manager:
        |     Terminals in own branch.
        |
        | Cashier:
        |     Current assigned terminal only.
        |
        */

        if ($isCashier) {

            if ($currentTerminal) {

                $terminalsQuery->where(
                    'id',
                    $currentTerminal->id
                );

            } else {

                $terminalsQuery->whereRaw(
                    '1 = 0'
                );
            }

        } elseif ($isBranchManager) {

            $terminalsQuery->where(
                'branch_id',
                $currentBranchId
            );
        }

        $terminals =
            $terminalsQuery
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
                'terminals',
                'terminalAssignment',
                'currentTerminal',
                'currentBranch',
                'currentDrawer',
                'canManageAllBranches',
                'isBranchManager',
                'isCashier',
                'currentBranchId'
            )
        );
    }

    

   /*
    |--------------------------------------------------------------------------
    | Return current cash drawer.
    |--------------------------------------------------------------------------
    */

    /**
     * Return current cash drawer.
     */
    public function current(): JsonResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        if (! canAccess('pos.cash_drawer')) {

            return response()->json([
                'status' =>
                    false,

                'message' =>
                    'You do not have permission to access the cash drawer.',
            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | Current User
        |--------------------------------------------------------------------------
        */

        $user =
            auth()->user();

        $userId =
            $user->id;

        /*
        |--------------------------------------------------------------------------
        | Current Terminal Assignment
        |--------------------------------------------------------------------------
        */

        $terminalAssignment =
            TerminalAssignment::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->where(
                    'user_id',
                    $userId
                )
                ->where(
                    'status',
                    'active'
                )
                ->with([
                    'branch',
                    'terminal',
                ])
                ->latest(
                    'assigned_at'
                )
                ->first();

        if (
            ! $terminalAssignment
        ) {

            return response()->json([
                'status' =>
                    false,

                'message' =>
                    'No active terminal is assigned to the current user.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Current Drawer
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | Find the currently open cash drawer belonging to
        | the authenticated user on their active terminal.
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
                    $terminalAssignment->branch_id
                )
                ->where(
                    'terminal_id',
                    $terminalAssignment->terminal_id
                )
                ->where(
                    'opened_by',
                    $userId
                )
                ->where(
                    'status',
                    'open'
                )
                ->with([
                    'openedBy',
                ])
                ->latest(
                    'opened_at'
                )
                ->first();

        /*
        |--------------------------------------------------------------------------
        | No Open Drawer
        |--------------------------------------------------------------------------
        */

        if (
            ! $drawer
        ) {

            return response()->json([
                'status' =>
                    true,

                'drawer' =>
                    null,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Cash Drawer Transactions
        |--------------------------------------------------------------------------
        */

       $transactions =
        CashDrawerTransaction::query()
            ->where(
                'company_id',
                $this->companyId
            )
            ->where(
                'branch_id',
                $terminalAssignment->branch_id
            )
            ->where(
                'terminal_id',
                $terminalAssignment->terminal_id
            )
            ->where(
                'cash_drawer_id',
                $drawer->id
            )
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Opening Balance
        |--------------------------------------------------------------------------
        */

        $openingBalance =
            (float) (
                $drawer->opening_balance
                ?? 0
            );

        /*
        |--------------------------------------------------------------------------
        | Cash Sale Transactions
        |--------------------------------------------------------------------------
        */

        $cashSaleTransactions =
            $transactions
                ->where(
                    'transaction_type',
                    'Sale'
                );

        /*
        |--------------------------------------------------------------------------
        | Total Cash Sales
        |--------------------------------------------------------------------------
        */

        $cashSales =
            (float)
                $cashSaleTransactions
                    ->sum(
                        'amount'
                    );

        /*
        |--------------------------------------------------------------------------
        | My Cash Sales
        |--------------------------------------------------------------------------
        */

        $myCashSalesTransactions =
            $cashSaleTransactions
                ->where(
                    'created_by',
                    $userId
                );

        $myCashSales =
            (float)
                $myCashSalesTransactions
                    ->sum(
                        'amount'
                    );

        /*
        |--------------------------------------------------------------------------
        | Other Cash Sales
        |--------------------------------------------------------------------------
        */

        $otherCashSalesTransactions =
            $cashSaleTransactions
                ->filter(
                    function ($transaction) use (
                        $userId
                    ) {
                        return (int) $transaction->created_by
                            !== (int) $userId;
                    }
                );

        $otherCashSales =
            (float)
                $otherCashSalesTransactions
                    ->sum(
                        'amount'
                    );

        /*
        |--------------------------------------------------------------------------
        | Cash Sales Users
        |--------------------------------------------------------------------------
        */

        $cashSaleUserIds =
            $cashSaleTransactions
                ->pluck(
                    'created_by'
                )
                ->filter()
                ->unique()
                ->values();

        $cashSaleUsers =
            User::query()
                ->whereIn(
                    'id',
                    $cashSaleUserIds
                )
                ->get([
                    'id',
                    'first_name',
                    'last_name',
                ])
                ->keyBy(
                    'id'
                );

        /*
        |--------------------------------------------------------------------------
        | Cash Sales Breakdown
        |--------------------------------------------------------------------------
        */

        $cashSalesBreakdown =
            $cashSaleTransactions
                ->groupBy(
                    'created_by'
                )
                ->map(
                    function (
                        $userTransactions,
                        $userId
                    ) use (
                        $cashSaleUsers
                    ) {

                        $user =
                            $cashSaleUsers->get(
                                $userId
                            );

                        return [
                            'user_id' =>
                                (int) $userId,

                            'user_name' =>
                                trim(
                                    ($user?->first_name ?? '')
                                    . ' '
                                    . ($user?->last_name ?? '')
                                ),

                            'amount' =>
                                (float)
                                    $userTransactions
                                        ->sum(
                                            'amount'
                                        ),

                            'transactions' =>
                                $userTransactions
                                    ->count(),
                        ];
                    }
                )
                ->values();

        /*
        |--------------------------------------------------------------------------
        | Other Cash Sales Breakdown
        |--------------------------------------------------------------------------
        */

        $otherCashSalesBreakdown =
            $cashSalesBreakdown
                ->filter(
                    function ($sale) use (
                        $userId
                    ) {
                        return (int) $sale['user_id']
                            !== (int) $userId;
                    }
                )
                ->values();

        /*
        |--------------------------------------------------------------------------
        | Cash In
        |--------------------------------------------------------------------------
        */

        $cashIn =
            (float)
                $transactions
                    ->filter(
                        function ($transaction) {

                            return trim(
                                (string) $transaction->transaction_type
                            ) === 'Cash In';
                        }
                    )
                    ->sum(
                        'amount'
                    );


        /*
        |--------------------------------------------------------------------------
        | Cash Out
        |--------------------------------------------------------------------------
        */

        $cashOut =
            (float)
                $transactions
                    ->filter(
                        function ($transaction) {

                            return trim(
                                (string) $transaction->transaction_type
                            ) === 'Cash Out';
                        }
                    )
                    ->sum(
                        'amount'
                    );


        /*
        |--------------------------------------------------------------------------
        | Cash Refunds
        |--------------------------------------------------------------------------
        */

        $cashRefunds =
            (float)
                $transactions
                    ->filter(
                        function ($transaction) {

                            return trim(
                                (string) $transaction->transaction_type
                            ) === 'Refund';
                        }
                    )
                    ->sum(
                        'amount'
                    );




        /*
        |--------------------------------------------------------------------------
        | Expected Balance
        |--------------------------------------------------------------------------
        */

        $expectedBalance =
            $openingBalance
            + $cashSales
            + $cashIn
            - $cashOut
            - $cashRefunds;

        /*
        |--------------------------------------------------------------------------
        | Current Cash Balance
        |--------------------------------------------------------------------------
        */

        $currentBalance =
            $expectedBalance;

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'status' =>
                true,

            'drawer' => [

                'id' =>
                    $drawer->id,

                'status' =>
                    $drawer->status,

                'opening_balance' =>
                    $openingBalance,

                'opened_at' =>
                    $drawer->opened_at?->toISOString(),

                'opened_by' =>
                    $drawer->openedBy
                        ? trim(
                            $drawer->openedBy->first_name
                            . ' '
                            . $drawer->openedBy->last_name
                        )
                        : null,
            ],

            'terminal' => [

                'id' =>
                    $terminalAssignment->terminal?->id,

                'name' =>
                    $terminalAssignment->terminal?->terminal_name,
            ],

            'branch' => [

                'id' =>
                    $terminalAssignment->branch?->id,

                'name' =>
                    $terminalAssignment->branch?->name,
            ],

            'kpis' => [

                'opening_balance' =>
                    $openingBalance,

                'my_cash_sales' =>
                    $myCashSales,

                'other_cash_sales' =>
                    $otherCashSales,

                'cash_sales' =>
                    $cashSales,

                'cash_sales_breakdown' =>
                    $cashSalesBreakdown,

                'other_cash_sales_breakdown' =>
                    $otherCashSalesBreakdown,

                'cash_in' =>
                    $cashIn,

                'cash_out' =>
                    $cashOut,

                'cash_refunds' =>
                    $cashRefunds,

                'expected_balance' =>
                    $expectedBalance,

                'current_balance' =>
                    $currentBalance,
            ],
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
                                    'open',

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
                                'Opening',

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
        $id
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
                                'closed',

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

    /**
     * Return transactions for a cash drawer.
     */
   
    /**
     * ==========================================================================
     * Cash Drawer Transactions
     * ==========================================================================
     */

    /**
     * Return current cash drawer transactions.
     */
    public function transactions(
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
                    'You do not have permission to access cash drawer transactions.',

            ], 403);

        }


        /*
        |--------------------------------------------------------------------------
        | Current Drawer
        |--------------------------------------------------------------------------
        */

        $drawer =
            CashDrawer::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'status',
                    'open'
                )

                ->latest('id')

                ->first();


        /*
        |--------------------------------------------------------------------------
        | No Open Drawer
        |--------------------------------------------------------------------------
        */

        if (! $drawer) {

            return response()->json([

                'success' =>
                    true,

                'data' => [],

                'pagination' => [

                    'current_page' =>
                        1,

                    'last_page' =>
                        1,

                    'per_page' =>
                        15,

                    'total' =>
                        0,

                ],

            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Transactions Query
        |--------------------------------------------------------------------------
        */

        $query =
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

                ]);


       /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        $search =
            trim(
                (string) $request->input(
                    'search',
                    ''
                )
            );


        if ($search !== '') {

            $query->where(

                function ($query) use (
                    $search
                ) {

                    $query

                        ->where(
                            'transaction_type',
                            'like',
                            '%' . $search . '%'
                        )

                        ->orWhere(
                            'reference_no',
                            'like',
                            '%' . $search . '%'
                        )

                        ->orWhere(
                            'remarks',
                            'like',
                            '%' . $search . '%'
                        )

                        ->orWhereHas(
                            'createdBy',
                            function ($userQuery) use (
                                $search
                            ) {

                                $userQuery

                                    ->where(
                                        'first_name',
                                        'like',
                                        '%' . $search . '%'
                                    )

                                    ->orWhere(
                                        'last_name',
                                        'like',
                                        '%' . $search . '%'
                                    );

                            }
                        );

                }

            );

        }

        /*
        |--------------------------------------------------------------------------
        | Transaction Type
        |--------------------------------------------------------------------------
        */

        $transactionType =
            trim(
                (string) $request->input(
                    'transaction_type',
                    ''
                )
            );


        if ($transactionType !== '') {

            $query->where(
                'transaction_type',
                $transactionType
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Transactions
        |--------------------------------------------------------------------------
        */

        $transactions =
            $query
                ->latest()
                ->paginate(
                   5
                );


        /*
        |--------------------------------------------------------------------------
        | Response Transactions
        |--------------------------------------------------------------------------
        */

        $data =
            collect(
                $transactions->items()
            )
            ->map(
                function ($transaction) {

                    $createdBy =
                        $transaction->createdBy;

                    $transaction->created_by_name =
                        $createdBy
                            ? trim(
                                ($createdBy->first_name ?? '')
                                . ' '
                                . ($createdBy->last_name ?? '')
                            )
                            : null;

                    return $transaction;

                }
            )
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'data' =>
                $data,

            'pagination' => [

                'current_page' =>
                    $transactions->currentPage(),

                'last_page' =>
                    $transactions->lastPage(),

                'per_page' =>
                    $transactions->perPage(),

                'total' =>
                    $transactions->total(),

            ],

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
                    (string) $request->search
                );


            $query->where(

                function ($q) use (
                    $search
                ) {

                    /*
                    |----------------------------------------------------------------------
                    | Search Opened By
                    |----------------------------------------------------------------------
                    */

                    $q->whereHas(

                        'openedBy',

                        function ($userQuery) use (
                            $search
                        ) {

                            $userQuery

                                ->where(
                                    'first_name',
                                    'like',
                                    '%' . $search . '%'
                                )

                                ->orWhere(
                                    'last_name',
                                    'like',
                                    '%' . $search . '%'
                                );

                        }

                    );


                    /*
                    |----------------------------------------------------------------------
                    | Search Terminal
                    |----------------------------------------------------------------------
                    */

                    $q->orWhereHas(

                        'terminal',

                        function ($terminalQuery) use (
                            $search
                        ) {

                            $terminalQuery->where(
                                'terminal_name',
                                'like',
                                '%' . $search . '%'
                            );

                        }

                    );


                    /*
                    |----------------------------------------------------------------------
                    | Search Branch
                    |----------------------------------------------------------------------
                    */

                    $q->orWhereHas(

                        'branch',

                        function ($branchQuery) use (
                            $search
                        ) {

                            $branchQuery->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            );

                        }

                    );

                }

            );

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
                    5
                );


       /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        $data =
            collect(
                $drawers->items()
            )
            ->map(
                function ($drawer) {

                    /*
                    |--------------------------------------------------------------------------
                    | Opened By
                    |--------------------------------------------------------------------------
                    */

                    $drawer->opened_by_name =

                        $drawer->openedBy

                            ? trim(
                                ($drawer->openedBy->last_name ?? '')
                                . ' '
                                . ($drawer->openedBy->first_name ?? '')
                            )

                            : null;


                    /*
                    |--------------------------------------------------------------------------
                    | Closed By
                    |--------------------------------------------------------------------------
                    */

                    $drawer->closed_by_name =

                        $drawer->closedBy

                            ? trim(
                                ($drawer->closedBy->last_name ?? '')
                                . ' '
                                . ($drawer->closedBy->first_name ?? '')
                            )

                            : null;


                    return $drawer;

                }
            )
            ->values();


        return response()->json([

            'success' =>
                true,

            'data' =>
                $data,

            'pagination' => [

                'current_page' =>
                    $drawers->currentPage(),

                'last_page' =>
                    $drawers->lastPage(),

                'per_page' =>
                    $drawers->perPage(),

                'total' =>
                    $drawers->total(),

            ],

        ]);

    }
    /*
    |--------------------------------------------------------------------------
    | Cash In
    |--------------------------------------------------------------------------
    */

    /**
     * Record a cash-in transaction.
     */
    public function cashIn(
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
                    'You do not have permission to record cash in.',

            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([

                'amount' => [
                    'required',
                    'numeric',
                    'min:0.01',
                ],

                'reference_no' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'remarks' => [
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
                        | Current User
                        |--------------------------------------------------------------------------
                        */

                        $userId =
                            auth()->id();


                        /*
                        |--------------------------------------------------------------------------
                        | Active Terminal Assignment
                        |--------------------------------------------------------------------------
                        */

                        $terminalAssignment =
                            TerminalAssignment::query()

                                ->where(
                                    'company_id',
                                    $this->companyId
                                )

                                ->where(
                                    'user_id',
                                    $userId
                                )

                                ->where(
                                    'status',
                                    'active'
                                )

                                ->with([
                                    'branch',
                                    'terminal',
                                ])

                                ->latest(
                                    'assigned_at'
                                )

                                ->first();


                        if (! $terminalAssignment) {

                            throw ValidationException::withMessages([

                                'cash_drawer' =>
                                    'No active POS terminal is assigned to the current user.',

                            ]);
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Current Drawer
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
                                    $terminalAssignment->branch_id
                                )

                                ->where(
                                    'terminal_id',
                                    $terminalAssignment->terminal_id
                                )

                                ->where(
                                    'opened_by',
                                    $userId
                                )

                                ->where(
                                    'status',
                                    'open'
                                )

                                ->lockForUpdate()

                                ->first();


                        if (! $drawer) {

                            throw ValidationException::withMessages([

                                'cash_drawer' =>
                                    'There is no open cash drawer for the current user.',

                            ]);
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Balance Before
                        |--------------------------------------------------------------------------
                        */

                        $balanceBefore =
                            (float) $drawer->expected_balance;


                        /*
                        |--------------------------------------------------------------------------
                        | Cash In Amount
                        |--------------------------------------------------------------------------
                        */

                        $amount =
                            (float) $validated['amount'];


                        /*
                        |--------------------------------------------------------------------------
                        | Balance After
                        |--------------------------------------------------------------------------
                        */

                        $balanceAfter =
                            $balanceBefore
                            + $amount;


                        /*
                        |--------------------------------------------------------------------------
                        | Update Drawer
                        |--------------------------------------------------------------------------
                        */

                        $drawer->update([

                            'cash_in' =>
                                (float) $drawer->cash_in
                                + $amount,

                            'expected_balance' =>
                                $balanceAfter,

                        ]);


                        /*
                        |--------------------------------------------------------------------------
                        | Transaction
                        |--------------------------------------------------------------------------
                        */

                        $transaction =
                            CashDrawerTransaction::create([

                                'company_id' =>
                                    $this->companyId,

                                'branch_id' =>
                                    $drawer->branch_id,

                                'terminal_id' =>
                                    $drawer->terminal_id,

                                'cash_drawer_id' =>
                                    $drawer->id,

                                'payment_id' =>
                                    null,

                                'order_id' =>
                                    null,

                                'created_by' =>
                                    $userId,

                                'transaction_type' =>
                                    'Cash In',

                                'amount' =>
                                    $amount,

                                'balance_before' =>
                                    $balanceBefore,

                                'balance_after' =>
                                    $balanceAfter,

                                'reference_no' =>
                                    $validated['reference_no'] ?? null,

                                'remarks' =>
                                    $validated['remarks'] ?? null,

                            ]);


                        return [

                            'drawer' =>
                                $drawer->fresh([
                                    'openedBy',
                                    'branch',
                                    'terminal',
                                ]),

                            'transaction' =>
                                $transaction->fresh([
                                    'createdBy',
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

                'Cash In',

                'Recorded cash in transaction.',

                $result['transaction'],

                null,

                $result['transaction']->toArray()

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
                    'Cash in recorded successfully.',

                'data' => [

                    'drawer' =>
                        $result['drawer'],

                    'transaction' =>
                        $result['transaction'],

                ],

            ]);


        } catch (ValidationException $e) {

            throw $e;


        } catch (\Throwable $e) {

            Log::error(

                'Failed to record cash in.',

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
                    'Unable to record cash in. Please try again.',

            ], 500);

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Cash Out
    |--------------------------------------------------------------------------
    */

    /**
     * Record a cash-out transaction.
     */
    public function cashOut(
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
                    'You do not have permission to record cash out.',

            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([

                'amount' => [
                    'required',
                    'numeric',
                    'min:0.01',
                ],

                'reference_no' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'remarks' => [
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
                        | Current User
                        |--------------------------------------------------------------------------
                        */

                        $userId =
                            auth()->id();


                        /*
                        |--------------------------------------------------------------------------
                        | Active Terminal Assignment
                        |--------------------------------------------------------------------------
                        */

                        $terminalAssignment =
                            TerminalAssignment::query()

                                ->where(
                                    'company_id',
                                    $this->companyId
                                )

                                ->where(
                                    'user_id',
                                    $userId
                                )

                                ->where(
                                    'status',
                                    'active'
                                )

                                ->with([
                                    'branch',
                                    'terminal',
                                ])

                                ->latest(
                                    'assigned_at'
                                )

                                ->first();


                        if (! $terminalAssignment) {

                            throw ValidationException::withMessages([

                                'cash_drawer' =>
                                    'No active POS terminal is assigned to the current user.',

                            ]);
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Current Drawer
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
                                    $terminalAssignment->branch_id
                                )

                                ->where(
                                    'terminal_id',
                                    $terminalAssignment->terminal_id
                                )

                                ->where(
                                    'opened_by',
                                    $userId
                                )

                                ->where(
                                    'status',
                                    'open'
                                )

                                ->lockForUpdate()

                                ->first();


                        if (! $drawer) {

                            throw ValidationException::withMessages([

                                'cash_drawer' =>
                                    'There is no open cash drawer for the current user.',

                            ]);
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Cash-Out Amount
                        |--------------------------------------------------------------------------
                        */

                        $amount =
                            (float) $validated['amount'];


                        /*
                        |--------------------------------------------------------------------------
                        | Balance Before
                        |--------------------------------------------------------------------------
                        */

                        $balanceBefore =
                            (float) $drawer->expected_balance;


                        /*
                        |--------------------------------------------------------------------------
                        | Sufficient Balance
                        |--------------------------------------------------------------------------
                        */

                        if ($amount > $balanceBefore) {

                            throw ValidationException::withMessages([

                                'amount' =>
                                    'Cash out amount cannot exceed the current expected drawer balance.',

                            ]);
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Balance After
                        |--------------------------------------------------------------------------
                        */

                        $balanceAfter =
                            $balanceBefore
                            - $amount;


                        /*
                        |--------------------------------------------------------------------------
                        | Update Drawer
                        |--------------------------------------------------------------------------
                        */

                        $drawer->update([

                            'cash_out' =>
                                (float) $drawer->cash_out
                                + $amount,

                            'expected_balance' =>
                                $balanceAfter,

                        ]);


                        /*
                        |--------------------------------------------------------------------------
                        | Transaction
                        |--------------------------------------------------------------------------
                        */

                        $transaction =
                            CashDrawerTransaction::create([

                                'company_id' =>
                                    $this->companyId,

                                'branch_id' =>
                                    $drawer->branch_id,

                                'terminal_id' =>
                                    $drawer->terminal_id,

                                'cash_drawer_id' =>
                                    $drawer->id,

                                'payment_id' =>
                                    null,

                                'order_id' =>
                                    null,

                                'created_by' =>
                                    $userId,

                                'transaction_type' =>
                                    'Cash Out',

                                'amount' =>
                                    $amount,

                                'balance_before' =>
                                    $balanceBefore,

                                'balance_after' =>
                                    $balanceAfter,

                                'reference_no' =>
                                    $validated['reference_no']
                                    ?? null,

                                'remarks' =>
                                    $validated['remarks']
                                    ?? null,

                            ]);


                        return [

                            'drawer' =>
                                $drawer->fresh([
                                    'openedBy',
                                    'branch',
                                    'terminal',
                                ]),

                            'transaction' =>
                                $transaction->fresh([
                                    'createdBy',
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

                'Cash Out',

                'Recorded cash out transaction.',

                $result['transaction'],

                null,

                $result['transaction']->toArray()

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
                    'Cash out recorded successfully.',

                'data' => [

                    'drawer' =>
                        $result['drawer'],

                    'transaction' =>
                        $result['transaction'],

                ],

            ]);


        } catch (ValidationException $e) {

            throw $e;


        } catch (\Throwable $e) {

            Log::error(

                'Failed to record cash out.',

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
                    'Unable to record cash out. Please try again.',

            ], 500);

        }
    }

    /*
    |--------------------------------------------------------------------------
    | Transaction Details
    |--------------------------------------------------------------------------
    */

    /**
     * Return a single cash drawer transaction.
     */
    public function transactionDetails(
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
        | Transaction
        |--------------------------------------------------------------------------
        */

        $transaction =
            CashDrawerTransaction::query()

                ->where(
                    'company_id',
                    $this->companyId
                )

                ->where(
                    'id',
                    $id
                )

                ->with([
                    'branch',
                    'terminal',
                    'cashDrawer',
                    'createdBy',
                    'payment',
                    'order',
                ])

                ->first();


        /*
        |--------------------------------------------------------------------------
        | Not Found
        |--------------------------------------------------------------------------
        */

        if (! $transaction) {

            return response()->json([

                'success' =>
                    false,

                'message' =>
                    'Cash drawer transaction not found.',

            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | Created By Name
        |--------------------------------------------------------------------------
        */

        $transaction->created_by_name =

            $transaction->createdBy

                ? trim(

                    ($transaction->createdBy->first_name ?? '')
                    . ' '
                    . ($transaction->createdBy->last_name ?? '')

                )

                : null;


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' =>
                true,

            'data' =>
                $transaction,

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | Details
    |--------------------------------------------------------------------------
    */

    /**
     * Return cash drawer details.
     */
    public function details(
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
                    'You do not have permission to access cash drawer details.',

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

                ->with([
                    'branch',
                    'terminal',
                    'openedBy',
                    'closedBy',
                ])

                ->first();


        /*
        |--------------------------------------------------------------------------
        | Not Found
        |--------------------------------------------------------------------------
        */

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

                ->get();


        /*
        |--------------------------------------------------------------------------
        | Opening Balance
        |--------------------------------------------------------------------------
        */

        $openingBalance =
            (float) $drawer->opening_balance;


        /*
        |--------------------------------------------------------------------------
        | Cash Sales
        |--------------------------------------------------------------------------
        */

        $cashSales =
            (float) $transactions

                ->where(
                    'transaction_type',
                    'Sale'
                )

                ->sum(
                    'amount'
                );


        /*
        |--------------------------------------------------------------------------
        | Cash In
        |--------------------------------------------------------------------------
        */

        $cashIn =
            (float) $transactions

                ->where(
                    'transaction_type',
                    'Cash In'
                )

                ->sum(
                    'amount'
                );


        /*
        |--------------------------------------------------------------------------
        | Cash Out
        |--------------------------------------------------------------------------
        */

        $cashOut =
            (float) $transactions

                ->where(
                    'transaction_type',
                    'Cash Out'
                )

                ->sum(
                    'amount'
                );


        /*
        |--------------------------------------------------------------------------
        | Cash Refunds
        |--------------------------------------------------------------------------
        */

        $cashRefunds =
            (float) $transactions

                ->where(
                    'transaction_type',
                    'Refund'
                )

                ->sum(
                    'amount'
                );


        /*
        |--------------------------------------------------------------------------
        | Expected Balance
        |--------------------------------------------------------------------------
        */

        $expectedBalance =
            $openingBalance
            + $cashSales
            + $cashIn
            - $cashOut
            - $cashRefunds;


        /*
        |--------------------------------------------------------------------------
        | Actual Balance
        |--------------------------------------------------------------------------
        */

        $actualBalance =
            $drawer->actual_balance !== null

                ? (float) $drawer->actual_balance

                : null;


        /*
        |--------------------------------------------------------------------------
        | Variance
        |--------------------------------------------------------------------------
        */

        $variance =
            $drawer->variance !== null

                ? (float) $drawer->variance

                : (
                    $actualBalance !== null
                        ? $actualBalance - $expectedBalance
                        : 0
                );


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
                    $drawer->id,

                'status' =>
                    $drawer->status,

                /*
                |--------------------------------------------------------------------------
                | Branch
                |--------------------------------------------------------------------------
                */

                'branch' => [

                    'id' =>
                        $drawer->branch?->id,

                    'name' =>
                        $drawer->branch?->name,

                ],

                /*
                |--------------------------------------------------------------------------
                | Terminal
                |--------------------------------------------------------------------------
                */

                'terminal' => [

                    'id' =>
                        $drawer->terminal?->id,

                    'name' =>
                        $drawer->terminal?->terminal_name,

                ],

                /*
                |--------------------------------------------------------------------------
                | Opening
                |--------------------------------------------------------------------------
                */

                'opening_balance' =>
                    $openingBalance,

                'opened_by' =>

                    $drawer->openedBy

                        ? [

                            'id' =>
                                $drawer->openedBy->id,

                            'first_name' =>
                                $drawer->openedBy->first_name,

                            'last_name' =>
                                $drawer->openedBy->last_name,

                        ]

                        : null,

                'opened_by_name' =>

                    $drawer->openedBy

                        ? trim(
                            ($drawer->openedBy->last_name ?? '')
                            . ' '
                            . ($drawer->openedBy->first_name ?? '')
                        )

                        : null,

                'opened_at' =>
                    $drawer->opened_at?->toISOString(),

                'opening_remarks' =>
                    $drawer->opening_remarks,

                /*
                |--------------------------------------------------------------------------
                | Financial Summary
                |--------------------------------------------------------------------------
                */

                'cash_sales' =>
                    $cashSales,

                'cash_in' =>
                    $cashIn,

                'cash_out' =>
                    $cashOut,

                'cash_refunds' =>
                    $cashRefunds,

                'expected_balance' =>
                    $expectedBalance,

                'actual_balance' =>
                    $actualBalance,

                'variance' =>
                    $variance,

                /*
                |--------------------------------------------------------------------------
                | Closing
                |--------------------------------------------------------------------------
                */

                'closed_by' =>

                    $drawer->closedBy

                        ? [

                            'id' =>
                                $drawer->closedBy->id,

                            'first_name' =>
                                $drawer->closedBy->first_name,

                            'last_name' =>
                                $drawer->closedBy->last_name,

                        ]

                        : null,

                'closed_by_name' =>

                    $drawer->closedBy

                        ? trim(
                            ($drawer->closedBy->last_name ?? '')
                            . ' '
                            . ($drawer->closedBy->first_name ?? '')
                        )

                        : null,

                'closed_at' =>
                    $drawer->closed_at?->toISOString(),

                'closing_remarks' =>
                    $drawer->closing_remarks,

            ],

        ]);

    }
}