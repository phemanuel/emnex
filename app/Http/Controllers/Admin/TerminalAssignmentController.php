<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CompanyHelper;
use App\Http\Controllers\Admin\BaseController;
use App\Models\Branch;
use App\Models\Terminal;
use App\Models\TerminalAssignment;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TerminalAssignmentController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Constructor
    |--------------------------------------------------------------------------
    */

    public function __construct(
        protected ActivityLogger $activityLogger
    ) {
        parent::__construct();
    }


    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    /**
     * Return terminal assignment page data.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'status' => true,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | User Assignment Details
    |--------------------------------------------------------------------------
    */

    /**
     * Return the current terminal assignment for a user.
     */
    public function userAssignment(
        int $userId
    ): JsonResponse {

        $user = User::query()
            ->where(
                'company_id',
                $this->companyId
            )
            ->findOrFail($userId);


        $assignment = TerminalAssignment::query()
            ->with([
                'terminal',
                'branch',
                'createdBy',
                'updatedBy',
            ])
            ->where(
                'company_id',
                $this->companyId
            )
            ->where(
                'user_id',
                $user->id
            )
            ->where(
                'status',
                'active'
            )
            ->first();


        return response()->json([

            'status' => true,

            'assignment' => $assignment,

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Available Terminals
    |--------------------------------------------------------------------------
    */

    /**
     * Return terminals available for assignment to a user.
     */
    public function availableTerminals(
        int $userId
    ): JsonResponse {

        $user = User::query()
            ->where(
                'company_id',
                $this->companyId
            )
            ->findOrFail($userId);


        $query = Terminal::query()
            ->where(
                'company_id',
                $this->companyId
            )
            ->where(
                'branch_id',
                $user->branch_id
            )
            ->where(
                'status',
                'active'
            );


        /*
        |--------------------------------------------------------------------------
        | Exclude Terminals Occupied By Another Active Assignment
        |--------------------------------------------------------------------------
        */

        $query->whereNotExists(function ($subQuery) {

            $subQuery
                ->selectRaw('1')
                ->from('terminal_assignments')
                ->whereColumn(
                    'terminal_assignments.terminal_id',
                    'terminals.id'
                )
                ->where(
                    'terminal_assignments.company_id',
                    $this->companyId
                )
                ->where(
                    'terminal_assignments.status',
                    'active'
                );

        });


        /*
        |--------------------------------------------------------------------------
        | Include Current Terminal
        |--------------------------------------------------------------------------
        */

        $currentAssignment = TerminalAssignment::query()
            ->where(
                'company_id',
                $this->companyId
            )
            ->where(
                'user_id',
                $user->id
            )
            ->where(
                'status',
                'active'
            )
            ->first();


        if ($currentAssignment) {

            $query->orWhere(function ($q) use ($currentAssignment) {

                $q->where(
                    'company_id',
                    $this->companyId
                );

                $q->where(
                    'id',
                    $currentAssignment->terminal_id
                );

            });

        }


        $terminals = $query
            ->orderBy(
                'terminal_code'
            )
            ->get();


        return response()->json([

            'status' => true,

            'terminals' => $terminals,

            'current_terminal_id' =>
                $currentAssignment?->terminal_id,

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Assign
    |--------------------------------------------------------------------------
    */

    /**
     * Assign a cashier to a terminal.
     *
     * If the selected terminal is occupied by another cashier,
     * the two active terminal assignments are switched.
     */
    public function assign(
        Request $request
    ): JsonResponse {

        $validated = $request->validate([

            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],

            'terminal_id' => [
                'required',
                'integer',
                'exists:terminals,id',
            ],

        ]);


        return DB::transaction(function () use (
            $validated
        ) {

            /*
            |--------------------------------------------------------------------------
            | Lock User
            |--------------------------------------------------------------------------
            */

            $user = User::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->lockForUpdate()
                ->findOrFail(
                    $validated['user_id']
                );


            /*
            |--------------------------------------------------------------------------
            | Lock Terminal
            |--------------------------------------------------------------------------
            */

            $terminal = Terminal::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->lockForUpdate()
                ->findOrFail(
                    $validated['terminal_id']
                );


            /*
            |--------------------------------------------------------------------------
            | Branch Validation
            |--------------------------------------------------------------------------
            */

            if (
                $user->branch_id
                !==
                $terminal->branch_id
            ) {

                throw ValidationException::withMessages([

                    'terminal_id' => [
                        'The selected terminal does not belong to the cashier\'s branch.',
                    ],

                ]);

            }


            /*
            |--------------------------------------------------------------------------
            | Current User Assignment
            |--------------------------------------------------------------------------
            */

            $userAssignment =
                TerminalAssignment::query()
                    ->where(
                        'company_id',
                        $this->companyId
                    )
                    ->where(
                        'user_id',
                        $user->id
                    )
                    ->where(
                        'status',
                        'active'
                    )
                    ->lockForUpdate()
                    ->first();


            /*
            |--------------------------------------------------------------------------
            | Already Assigned To Selected Terminal
            |--------------------------------------------------------------------------
            */

            if (
                $userAssignment
                &&
                (int) $userAssignment->terminal_id
                    ===
                (int) $terminal->id
            ) {

                return response()->json([

                    'status' => true,

                    'message' =>
                        'Cashier is already assigned to this terminal.',

                    'assignment' =>
                        $userAssignment->load([
                            'terminal',
                            'branch',
                        ]),

                ]);

            }


            /*
            |--------------------------------------------------------------------------
            | Existing Terminal Occupant
            |--------------------------------------------------------------------------
            */

            $terminalAssignment =
                TerminalAssignment::query()
                    ->where(
                        'company_id',
                        $this->companyId
                    )
                    ->where(
                        'terminal_id',
                        $terminal->id
                    )
                    ->where(
                        'status',
                        'active'
                    )
                    ->lockForUpdate()
                    ->first();


            /*
            |--------------------------------------------------------------------------
            | TERMINAL IS OCCUPIED
            |--------------------------------------------------------------------------
            |
            | If:
            |
            | Cashier A -> Terminal 1
            | Cashier B -> Terminal 2
            |
            | And Cashier A is assigned to Terminal 2,
            |
            | We switch:
            |
            | Cashier A -> Terminal 2
            | Cashier B -> Terminal 1
            |
            */

            if ($terminalAssignment) {

                /*
                |--------------------------------------------------------------------------
                | Prevent Self Conflict
                |--------------------------------------------------------------------------
                */

                if (
                    $terminalAssignment->user_id
                    ===
                    $user->id
                ) {

                    return response()->json([

                        'status' => true,

                        'message' =>
                            'Cashier is already assigned to this terminal.',

                        'assignment' =>
                            $terminalAssignment->load([
                                'terminal',
                                'branch',
                            ]),

                    ]);

                }


                /*
                |--------------------------------------------------------------------------
                | User Must Have Current Assignment
                |--------------------------------------------------------------------------
                */

                if (!$userAssignment) {

                    throw ValidationException::withMessages([

                        'terminal_id' => [
                            'This terminal is currently assigned to another cashier.',
                        ],

                    ]);

                }


                /*
                |--------------------------------------------------------------------------
                | Lock Existing Occupant User
                |--------------------------------------------------------------------------
                */

                $occupant = User::query()
                    ->where(
                        'company_id',
                        $this->companyId
                    )
                    ->lockForUpdate()
                    ->findOrFail(
                        $terminalAssignment->user_id
                    );


                /*
                |--------------------------------------------------------------------------
                | Capture Old Values
                |--------------------------------------------------------------------------
                */

                $userOldValues =
                    $userAssignment
                        ->fresh()
                        ->toArray();


                $occupantOldValues =
                    $terminalAssignment
                        ->fresh()
                        ->toArray();


                /*
                |--------------------------------------------------------------------------
                | Previous Terminal
                |--------------------------------------------------------------------------
                */

                $previousTerminal =
                    Terminal::query()
                        ->where(
                            'company_id',
                            $this->companyId
                        )
                        ->find(
                            $userAssignment->terminal_id
                        );


                /*
                |--------------------------------------------------------------------------
                | Switch Assignments
                |--------------------------------------------------------------------------
                */

                $userAssignment->update([

                    'terminal_id' =>
                        $terminal->id,

                    'updated_by' =>
                        auth()->id(),

                ]);


                $terminalAssignment->update([

                    'terminal_id' =>
                        $previousTerminal->id,

                    'updated_by' =>
                        auth()->id(),

                ]);


                /*
                |--------------------------------------------------------------------------
                | Activity Log - Current Cashier
                |--------------------------------------------------------------------------
                */

                $this->activityLogger->log(

                    'Terminal Management',

                    'Switched',

                    "Terminal assignment switched for {$user->name}. "
                    . "Moved from {$previousTerminal->terminal_code} "
                    . "to {$terminal->terminal_code}.",

                    $userAssignment,

                    $userOldValues,

                    $userAssignment
                        ->fresh()
                        ->toArray()

                );


                /*
                |--------------------------------------------------------------------------
                | Activity Log - Other Cashier
                |--------------------------------------------------------------------------
                */

                $this->activityLogger->log(

                    'Terminal Management',

                    'Switched',

                    "Terminal assignment switched for {$occupant->name}. "
                    . "Moved from {$terminal->terminal_code} "
                    . "to {$previousTerminal->terminal_code}.",

                    $terminalAssignment,

                    $occupantOldValues,

                    $terminalAssignment
                        ->fresh()
                        ->toArray()

                );


                return response()->json([

                    'status' => true,

                    'message' =>
                        'Terminal assignments switched successfully.',

                    'assignment' =>
                        $userAssignment->load([
                            'terminal',
                            'branch',
                            'createdBy',
                            'updatedBy',
                        ]),

                ]);

            }


            /*
            |--------------------------------------------------------------------------
            | User Already Has Another Assignment
            |--------------------------------------------------------------------------
            */

            if ($userAssignment) {

                $oldValues =
                    $userAssignment
                        ->fresh()
                        ->toArray();


                $oldTerminal =
                    Terminal::query()
                        ->where(
                            'company_id',
                            $this->companyId
                        )
                        ->find(
                            $userAssignment->terminal_id
                        );


                $userAssignment->update([

                    'terminal_id' =>
                        $terminal->id,

                    'updated_by' =>
                        auth()->id(),

                ]);


                /*
                |--------------------------------------------------------------------------
                | Activity Log - Changed Terminal
                |--------------------------------------------------------------------------
                */

                $this->activityLogger->log(

                    'Terminal Management',

                    'Updated',

                    "Terminal assignment for {$user->name} "
                    . "changed from "
                    . ($oldTerminal?->terminal_code ?? 'Unknown')
                    . " to {$terminal->terminal_code}.",

                    $userAssignment,

                    $oldValues,

                    $userAssignment
                        ->fresh()
                        ->toArray()

                );


                return response()->json([

                    'status' => true,

                    'message' =>
                        'Terminal assignment updated successfully.',

                    'assignment' =>
                        $userAssignment->load([
                            'terminal',
                            'branch',
                            'createdBy',
                            'updatedBy',
                        ]),

                ]);

            }


            /*
            |--------------------------------------------------------------------------
            | New Assignment
            |--------------------------------------------------------------------------
            */

            $assignment =
                TerminalAssignment::create([

                    'company_id' =>
                        $this->companyId,

                    'branch_id' =>
                        $terminal->branch_id,

                    'terminal_id' =>
                        $terminal->id,

                    'user_id' =>
                        $user->id,

                    'assigned_at' =>
                        now(),

                    'status' =>
                        'active',

                    'created_by' =>
                        auth()->id(),

                ]);


            /*
            |--------------------------------------------------------------------------
            | Activity Log - Created
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'Terminal Management',

                'Created',

                "Cashier {$user->name} assigned to terminal "
                . "{$terminal->terminal_code}.",

                $assignment,

                [],

                $assignment
                    ->fresh()
                    ->toArray()

            );


            return response()->json([

                'status' => true,

                'message' =>
                    'Cashier assigned to terminal successfully.',

                'assignment' =>
                    $assignment->load([
                        'terminal',
                        'branch',
                        'createdBy',
                    ]),

            ]);

        });
    }


    /*
    |--------------------------------------------------------------------------
    | Unassign
    |--------------------------------------------------------------------------
    */

    /**
     * Remove the active terminal assignment from a cashier.
     */
    public function unassign(
        int $userId
    ): JsonResponse {

        return DB::transaction(function () use (
            $userId
        ) {

            $assignment =
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
                    ->lockForUpdate()
                    ->first();


            if (!$assignment) {

                return response()->json([

                    'status' => false,

                    'message' =>
                        'No active terminal assignment was found.',

                ], 404);

            }


            /*
            |--------------------------------------------------------------------------
            | User
            |--------------------------------------------------------------------------
            */

            $user = User::query()
                ->where(
                    'company_id',
                    $this->companyId
                )
                ->findOrFail(
                    $assignment->user_id
                );


            /*
            |--------------------------------------------------------------------------
            | Old Values
            |--------------------------------------------------------------------------
            */

            $oldValues =
                $assignment
                    ->fresh()
                    ->toArray();


            /*
            |--------------------------------------------------------------------------
            | Close Assignment
            |--------------------------------------------------------------------------
            */

            $assignment->update([

                'status' =>
                    'inactive',

                'unassigned_at' =>
                    now(),

                'updated_by' =>
                    auth()->id(),

            ]);


            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            $this->activityLogger->log(

                'Terminal Management',

                'Deleted',

                "Terminal assignment removed for {$user->name}.",

                $assignment,

                $oldValues,

                $assignment
                    ->fresh()
                    ->toArray()

            );


            return response()->json([

                'status' => true,

                'message' =>
                    'Terminal assignment removed successfully.',

            ]);

        });
    }
}