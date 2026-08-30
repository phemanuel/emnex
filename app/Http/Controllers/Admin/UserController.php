<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Models\Terminal;
use App\Models\TerminalAssignment;


class UserController extends BaseController
{

    public function __construct(
        protected ActivityLogger $activityLogger
    ) {
    }

 public function index()
{
    $companyId = auth()->user()->company_id;


    /*
    |--------------------------------------------------------------------------
    | Filter Options
    |--------------------------------------------------------------------------
    */

    $roles = Role::where(
            'company_id',
            $companyId
        )
        ->where(
            'status',
            true
        )
        ->get();



    $branches = Branch::where(
            'company_id',
            $companyId
        )
        ->get();



    /*
    |--------------------------------------------------------------------------
    | Statistics
    |--------------------------------------------------------------------------
    */

    $totalUsers = User::where(
        'company_id',
        $companyId
    )
    ->count();



    $activeUsers = User::where(
        'company_id',
        $companyId
    )
    ->where(
        'status',
        true
    )
    ->count();



    $disabledUsers = User::where(
        'company_id',
        $companyId
    )
    ->where(
        'status',
        false
    )
    ->count();



    $roleCount = Role::where(
        'company_id',
        $companyId
    )
    ->count(); 



    /*
    |--------------------------------------------------------------------------
    | View
    |--------------------------------------------------------------------------
    */

    return view(
        'users.index',
        compact(
            'roles',
            'branches',
            'totalUsers',
            'activeUsers',
            'disabledUsers',
            'roleCount'
        )
    );
}

public function table(Request $request)
{
    $companyId = auth()->user()->company_id;


    /*
    |--------------------------------------------------------------------------
    | Users Query
    |--------------------------------------------------------------------------
    */

    $query = User::where(
        'company_id',
        $companyId
    )
    ->select([
        'id',
        'company_id',
        'branch_id',
        'role_id',
        'first_name',
        'other_name',
        'last_name',
        'username',
        'email',
        'phone',
        'profile_photo',
        'status',
        'last_activity_at',
    ])
    ->with([
        'role:id,company_id,name,code,display_name',

        'branch:id,company_id,name',

        'activeTerminalAssignment:id,company_id,branch_id,terminal_id,user_id,status,assigned_at',
        'activeTerminalAssignment.terminal:id,company_id,branch_id,terminal_code,terminal_name',
    ]);


   /*
|--------------------------------------------------------------------------
| Search
|--------------------------------------------------------------------------
*/

if ($request->filled('search')) {

    $search = $request->search;

    $query->where(function ($q) use ($search) {

        $q->where(
            'first_name',
            'like',
            "%{$search}%"
        )

        ->orWhere(
            'other_name',
            'like',
            "%{$search}%"
        )

        ->orWhere(
            'last_name',
            'like',
            "%{$search}%"
        )

        ->orWhere(
            'username',
            'like',
            "%{$search}%"
        )

        ->orWhere(
            'email',
            'like',
            "%{$search}%"
        )

        ->orWhere(
            'phone',
            'like',
            "%{$search}%"
        );

    });

}

    /*
    |--------------------------------------------------------------------------
    | Role
    |--------------------------------------------------------------------------
    */

    if ($request->filled('role_id')) {

        $query->where(
            'role_id',
            $request->role_id
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Branch
    |--------------------------------------------------------------------------
    */

    if ($request->filled('branch_id')) {

        $query->where(
            'branch_id',
            $request->branch_id
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

    if (
        $request->filled('status')
    ) {

        $query->where(
            'status',
            $request->status
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    $users = $query
        ->latest()
        ->paginate(15);


    return response()->json([

        'status' => true,

        'users' => $users->items(),

        'pagination' => [

            'current_page' =>
                $users->currentPage(),

            'last_page' =>
                $users->lastPage(),

            'per_page' =>
                $users->perPage(),

            'total' =>
                $users->total(),

        ],

    ]);
}
        
        public function store(Request $request)
        {
            $companyId = auth()->user()->company_id;

            if (! canAccess('users.create')) {
                return response()->json([
                    'status' => false,
                    'message' => 'You do not have permission to create users.'
                ], 403);
            }

            $validated = $request->validate([

                'branch_id' => [
                    'nullable',
                    'exists:branches,id'
                ],

                'role_id' => [
                    'nullable',
                    'exists:roles,id'
                ],

                'employee_no' => [
                    'nullable',
                    'string',
                    'max:50'
                ],

                'first_name' => [
                    'required',
                    'string',
                    'max:100'
                ],

                'last_name' => [
                    'required',
                    'string',
                    'max:100'
                ],

                'other_name' => [
                    'nullable',
                    'string',
                    'max:100'
                ],

                'username' => [

                    'required',
                    'string',
                    'max:100',

                    Rule::unique('users')
                        ->where(function ($query) use ($companyId) {

                            return $query
                                ->where('company_id', $companyId)
                                ->whereNull('deleted_at');

                        })

                ],

                'email' => [

                    'required',
                    'email',
                    'max:150',

                    Rule::unique('users')
                        ->where(function ($query) use ($companyId) {

                            return $query
                                ->where('company_id', $companyId)
                                ->whereNull('deleted_at');

                        })

                ],

                'phone' => [
                    'nullable',
                    'string',
                    'max:30'
                ],

                'gender' => [
                    'nullable',
                    'in:Male,Female'
                ],

                'date_of_birth' => [
                    'nullable',
                    'date'
                ],

                'employment_date' => [
                    'nullable',
                    'date'
                ],

                'address' => [
                    'nullable',
                    'string'
                ],

                'notes' => [
                    'nullable',
                    'string'
                ],

                'password' => [
                    'required',
                    'string',
                    'min:6'
                ],

                'status' => [
                    'required',
                    'boolean'
                ],

            ]);

            $deletedUser = User::onlyTrashed()

            ->where('company_id', $companyId)

            ->where(function ($query) use ($validated) {

                $query

                    ->where('email', $validated['email'])

                    ->orWhere('username', $validated['username']);

            })

            ->first();


            if ($deletedUser) {

                DB::transaction(function () use ($deletedUser, $validated) {

                    $oldValues = $deletedUser->toArray();

                    $deletedUser->restore();

                    $deletedUser->update([

                        'branch_id'             => $validated['branch_id'] ?? null,

                        'role_id'               => $validated['role_id'] ?? null,

                        'employee_no'           => $validated['employee_no'] ?? null,

                        'first_name'            => $validated['first_name'],

                        'last_name'             => $validated['last_name'],

                        'other_name'            => $validated['other_name'] ?? null,

                        'username'              => $validated['username'],

                        'email'                 => $validated['email'],

                        'phone'                 => $validated['phone'] ?? null,

                        'gender'                => $validated['gender'] ?? null,

                        'date_of_birth'         => $validated['date_of_birth'] ?? null,

                        'employment_date'       => $validated['employment_date'] ?? null,

                        'address'               => $validated['address'] ?? null,

                        'notes'                 => $validated['notes'] ?? null,

                        'password'              => Hash::make($validated['password']),

                        'status'                => $validated['status'],

                        'force_password_change' => true,

                        'password_changed_at'   => null,

                    ]);

                    $this->activityLogger->log(

                        'Users',

                        'Restored',

                        "Restored user {$deletedUser->full_name}",

                        $deletedUser,

                        $oldValues,

                        $deletedUser->fresh()->toArray()

                    );

                });

                return response()->json([

                    'success' => true,

                    'message' => 'Previously deleted user restored successfully.'

                ]);

            }

            DB::transaction(function () use ($validated, $companyId, &$user) {

                $user = User::create([

                    'company_id' => $companyId,

                    'branch_id' => $validated['branch_id'] ?? null,

                    'role_id' => $validated['role_id'] ?? null,

                    'employee_no' => $validated['employee_no'] ?? null,

                    'first_name' => $validated['first_name'],

                    'last_name' => $validated['last_name'],

                    'other_name' => $validated['other_name'] ?? null,

                    'username' => $validated['username'],

                    'email' => $validated['email'],

                    'phone' => $validated['phone'] ?? null,

                    'gender' => $validated['gender'] ?? null,

                    'date_of_birth' => $validated['date_of_birth'] ?? null,

                    'employment_date' => $validated['employment_date'] ?? null,

                    'address' => $validated['address'] ?? null,

                    'notes' => $validated['notes'] ?? null,

                    'password' => Hash::make($validated['password']),

                    'status' => $validated['status'],

                    'force_password_change' => true,

                    'password_changed_at' => null,

                    'username' => $validated['username'],

                ]);

                $this->activityLogger->log(

                    'Users',

                    'Created',

                    "Created user {$user->full_name}",

                    $user,

                    null,

                    $user->toArray()

                );

            });

            return response()->json([

                'success' => true,

                'message' => 'User created successfully.'

            ]);
        }

        public function edit(User $user)
        {
            abort_if(
                $user->company_id !== auth()->user()->company_id,
                403
            );


            $user->load([
                'role',
                'branch'
            ]);


            return response()->json([

                'user' => [

                    'id' => $user->id,

                    'branch_id' => $user->branch_id,

                    'role_id' => $user->role_id,

                    'employee_no' => $user->employee_no,

                    'first_name' => $user->first_name,

                    'last_name' => $user->last_name,

                    'other_name' => $user->other_name,

                    'username' => $user->username,

                    'email' => $user->email,

                    'phone' => $user->phone,

                    'gender' => $user->gender,

                    'date_of_birth' => $user->date_of_birth
                    ? date('Y-m-d', strtotime($user->date_of_birth))
                    : null,

                    'employment_date' => $user->employment_date
                    ? date('Y-m-d', strtotime($user->employment_date))
                    : null,

                    'address' => $user->address,

                    'notes' => $user->notes,

                    'status' => (int) $user->status,

                ]

            ]);

        }

        public function update(Request $request, User $user)
        {
            abort_if(
                $user->company_id !== auth()->user()->company_id,
                403
            );

            // Update User

            if (! canAccess('users.update')) {
                return response()->json([
                    'status' => false,
                    'message' => 'You do not have permission to update users.'
                ], 403);
            }

            $validated = $request->validate([

                'branch_id' => [
                    'nullable',
                    'exists:branches,id'
                ],

                'role_id' => [
                    'required',
                    'exists:roles,id'
                ],

                'employee_no' => [
                    'nullable',
                    'string',
                    'max:50'
                ],

                'first_name' => [
                    'required',
                    'string',
                    'max:100'
                ],

                'last_name' => [
                    'required',
                    'string',
                    'max:100'
                ],

                'other_name' => [
                    'nullable',
                    'string',
                    'max:100'
                ],

                'username' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('users')
                        ->ignore($user->id)
                ],

                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users')
                        ->ignore($user->id)
                ],

                'phone' => [
                    'nullable',
                    'string',
                    'max:30'
                ],

                'gender' => [
                    'nullable',
                    'in:Male,Female'
                ],

                'date_of_birth' => [
                    'nullable',
                    'date'
                ],

                'employment_date' => [
                    'nullable',
                    'date'
                ],

                'address' => [
                    'nullable',
                    'string'
                ],

                'notes' => [
                    'nullable',
                    'string'
                ],

                'status' => [
                    'required',
                    'boolean'
                ],

            ]);

            DB::transaction(function () use ($validated, $user) {                

                $validated['status'] = (bool) $validated['status'];

                $oldValues = $user->toArray();

                $user->update($validated);

                $this->activityLogger->log(
                    'User Management',
                    'Updated',
                    "Updated user {$user->full_name}",
                    $user,
                    $oldValues,
                    $user->fresh()->toArray()
                );

            });

            return response()->json([

                'success' => true,

                'message' => 'User updated successfully.'

            ]);
        }

        public function details(User $user)
        {
            if ($user->company_id !== auth()->user()->company_id) {

                abort(403);

            }

            // View User Details

            if (! canAccess('users.view')) {
                return response()->json([
                    'status' => false,
                    'message' => 'You do not have permission to view users.'
                ], 403);
            }

            $user->load([
                'branch',
                'role'
            ]);

            return response()->json([

                'user' => [

                    'id' => $user->id,

                    'employee_no' => $user->employee_no,

                    'first_name' => $user->first_name,

                    'last_name' => $user->last_name,

                    'other_name' => $user->other_name,

                    'username' => $user->username,

                    'email' => $user->email,

                    'phone' => $user->phone,

                    'gender' => $user->gender,

                    'date_of_birth' => optional($user->date_of_birth)->format('Y-m-d'),

                    'employment_date' => optional($user->employment_date)->format('Y-m-d'),

                    'address' => $user->address,

                    'notes' => $user->notes,

                    'status' => $user->status,

                    'created_at' => $user->created_at?->format('d M Y'),

                    'updated_at' => $user->updated_at?->format('d M Y'),

                    'branch' => $user->branch?->name,

                    'role' => $user->role?->displayLabel(),

                ]

            ]);

        }

        public function resetPassword(User $user)
        {
            if ($user->company_id !== auth()->user()->company_id) {

                abort(403);

            }

            if (! canAccess('users.reset_password')) {
                return response()->json([
                    'status' => false,
                    'message' => 'You do not have permission to reset user passwords.'
                ], 403);
            }

            $password = Str::password(
                10,
                letters: true,
                numbers: true,
                symbols: false
            );

            $oldValues = [

                'password' => '********',

                'force_password_change' => $user->force_password_change,

            ];

            $user->update([

                'password' => Hash::make($password),

                'force_password_change' => true,

                'password_changed_at' => null,

            ]);

            $this->activityLogger->log(

                'Users',

                'Password Reset',

                "Reset password for {$user->full_name}",

                $user,

                $oldValues,

                [

                    'password' => '********',

                    'force_password_change' => true,

                ]

            );

            return response()->json([

                'success' => true,

                'message' => 'Password reset successfully.',

                'password' => $password,

            ]);
        }

        public function destroy(User $user)
        {
            if ($user->company_id !== auth()->user()->company_id) {

                abort(403);

            }
                        // Delete User

            if (! canAccess('users.delete')) {
                return response()->json([
                    'status' => false,
                    'message' => 'You do not have permission to delete users.'
                ], 403);
            }

            $oldValues =
                $user->toArray();

            $fullName =
                $user->full_name;

            $user->delete();

            $this->activityLogger->log(

                'User Management',

                'Deleted',

                "Deleted user {$fullName}",

                $user,

                $oldValues,

                []

            );

            return response()->json([

                'success' => true,

                'message' => 'User deleted successfully.'

            ]);
        }

        public function toggleStatus(User $user)
        {
            if ($user->company_id !== auth()->user()->company_id) {

                abort(403);

            }

            // Toggle Status

            if (! canAccess('users.update')) {
                return response()->json([
                    'status' => false,
                    'message' => 'You do not have permission to update users.'
                ], 403);
            }

            $oldValues = [

                'status' => $user->status,

            ];

            $user->update([

                'status' => !$user->status,

            ]);

            $action = $user->status ? 'Enabled' : 'Disabled';

            $this->activityLogger->log(

                'Users',

                $action,

                "{$action} user {$user->full_name}",

                $user,

                $oldValues,

                $user->fresh()->toArray()

            );

            return response()->json([

                'success' => true,

                'message' => "User {$action} successfully.",

                'status' => $user->status,

            ]);
        }


       /**
 * ==========================================================================
 * TERMINAL ASSIGNMENT
 * ==========================================================================
 *
 * Return cashier information, branch terminals, current assignment
 * and available terminals.
 */
public function terminalAssignment(
    int $id
): JsonResponse {

    /*
    |--------------------------------------------------------------------------
    | Find User
    |--------------------------------------------------------------------------
    */
    $companyId = auth()->user()->company_id;

    $user = User::query()
        ->where('company_id', $companyId)
        ->with([
            'role:id,company_id,name,code,display_name',
            'branch:id,company_id,name',
        ])
        ->find($id);

    if (! $user) {

        return response()->json([
            'status' => false,
            'message' => 'User not found.',
        ], 404);
    }


    /*
    |--------------------------------------------------------------------------
    | Current Assignment
    |--------------------------------------------------------------------------
    */

    $currentAssignment = TerminalAssignment::query()
        ->where('company_id', $companyId)
        ->where('user_id', $user->id)
        ->where('status', 'Active')
        ->with([
            'terminal:id,company_id,branch_id,terminal_code,terminal_name,device_name,status',
        ])
        ->first();


    /*
    |--------------------------------------------------------------------------
    | Available Branch Terminals
    |--------------------------------------------------------------------------
    |
    | Only active terminals belonging to the cashier's branch
    | that do not have an active terminal assignment.
    |
    */

    $terminals = Terminal::query()
        ->where(
            'company_id',
            auth()->user()->company_id
        )
        ->where(
            'branch_id',
            $user->branch_id
        )
        ->where(
            'status',
            true
        )
        ->whereNotExists(function ($query) use ($user) {

            $query->select(
                DB::raw(1)
            )
            ->from('terminal_assignments')
            ->whereColumn(
                'terminal_assignments.terminal_id',
                'terminals.id'
            )
            ->where(
                'terminal_assignments.company_id',
                auth()->user()->company_id
            )
            ->where(
                'terminal_assignments.branch_id',
                $user->branch_id
            )
            ->where(
                'terminal_assignments.status',
                'Active'
            );

        })
        ->select([
            'id',
            'company_id',
            'branch_id',
            'terminal_code',
            'terminal_name',
            'device_name',
            'status',
        ])
        ->orderBy(
            'terminal_name'
        )
        ->get();

    /*
    |--------------------------------------------------------------------------
    | Active Terminal Assignments
    |--------------------------------------------------------------------------
    |
    | Get the active assignment for each terminal in this branch.
    |
    */

    $activeAssignments = TerminalAssignment::query()
        ->where('company_id', $companyId)
        ->where('branch_id', $user->branch_id)
        ->where('status', 'Active')
        ->with([
            'user:id,first_name,other_name,last_name',
            'terminal:id,terminal_name,terminal_code',
        ])
        ->get()
        ->keyBy('terminal_id');


    /*
    |--------------------------------------------------------------------------
    | Build Terminal Listing
    |--------------------------------------------------------------------------
    */

    $terminalList = $terminals->map(function ($terminal) use ($activeAssignments, $currentAssignment) {

        $assignment = $activeAssignments->get($terminal->id);

        $isCurrent = $currentAssignment
            && $currentAssignment->terminal_id == $terminal->id;

        return [
            'id' => $terminal->id,

            'terminal_code' =>
                $terminal->terminal_code,

            'terminal_name' =>
                $terminal->terminal_name,

            'device_name' =>
                $terminal->device_name,

            'status' =>
                $terminal->status,

            'in_use' =>
                (bool) $assignment,

            'is_current' =>
                $isCurrent,

            'assigned_user' =>
                $assignment?->user
                    ? trim(implode(' ', array_filter([
                        $assignment->user->first_name,
                        $assignment->user->other_name,
                        $assignment->user->last_name,
                    ])))
                    : null,
        ];
    });


    /*
    |--------------------------------------------------------------------------
    | Available Terminals
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    | Only terminals without an active assignment are returned.
    |
    */

    $availableTerminals = $terminalList
        ->filter(function ($terminal) {

            return ! $terminal['in_use'];
        })
        ->values();

    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    return response()->json([

        'status' => true,

        'user' => [
            'id' => $user->id,

            'first_name' =>
                $user->first_name,

            'other_name' =>
                $user->other_name,

            'last_name' =>
                $user->last_name,

            'full_name' =>
                $user->full_name,

            'role' => [
                'name' =>
                    $user->role?->name,

                'display_name' =>
                    $user->role?->display_name,

            ],

            'branch' => [
                'id' =>
                    $user->branch?->id,

                'name' =>
                    $user->branch?->name,
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Current Assignment
        |--------------------------------------------------------------------------
        */

        'current_assignment' => $currentAssignment
            ? [
                'id' =>
                    $currentAssignment->id,

                'terminal_id' =>
                    $currentAssignment->terminal_id,

                'terminal_code' =>
                    $currentAssignment->terminal?->terminal_code,

                'terminal_name' =>
                    $currentAssignment->terminal?->terminal_name,

                'assigned_at' =>
                    $currentAssignment->assigned_at,
            ]
            : null,

        /*
        |--------------------------------------------------------------------------
        | All Terminals
        |--------------------------------------------------------------------------
        */

        'terminals' =>
            $terminalList->values(),

        /*
        |--------------------------------------------------------------------------
        | Available Terminals
        |--------------------------------------------------------------------------
        */

        'available_terminals' =>
            $availableTerminals,

    ]);
}

    /**
 * ==========================================================================
 * SAVE TERMINAL ASSIGNMENT
 * ==========================================================================
 *
 * Assign a cashier to a terminal.
 *
 * If the cashier already has an active assignment, the existing assignment
 * is closed first and a new assignment is created.
 *
 * The selected terminal must not already be actively assigned to another
 * cashier.
 */
public function saveTerminalAssignment(
    Request $request,
    int $id
): JsonResponse {

    /*
    |--------------------------------------------------------------------------
    | Permission
    |--------------------------------------------------------------------------
    */

    if (! canAccess('users.update')) {

        return response()->json([

            'status' => false,

            'message' => 'You do not have permission to assign terminals.',

        ], 403);

    }


    /*
    |--------------------------------------------------------------------------
    | Company
    |--------------------------------------------------------------------------
    */

    $companyId = auth()->user()->company_id;


    /*
    |--------------------------------------------------------------------------
    | Validate Request
    |--------------------------------------------------------------------------
    */

    $validated = $request->validate([

        'terminal_id' => [

            'required',

            'integer',

        ],

    ]);


    /*
    |--------------------------------------------------------------------------
    | Find User
    |--------------------------------------------------------------------------
    */

    $user = User::where(

        'company_id',

        $companyId

    )->find($id);


    if (! $user) {

        return response()->json([

            'status' => false,

            'message' => 'User not found.',

        ], 404);

    }


    /*
    |--------------------------------------------------------------------------
    | Ensure User Is Active
    |--------------------------------------------------------------------------
    */

    if (! $user->status) {

        return response()->json([

            'status' => false,

            'message' => 'This user is inactive and cannot be assigned to a terminal.',

        ], 422);

    }


    /*
    |--------------------------------------------------------------------------
    | Ensure User Is A Cashier
    |--------------------------------------------------------------------------
    */

    if (! $user->hasRole('cashier')) {

        return response()->json([

            'status' => false,

            'message' => 'Only cashiers can be assigned to POS terminals.',

        ], 422);

    }


    /*
    |--------------------------------------------------------------------------
    | Find Terminal
    |--------------------------------------------------------------------------
    */

    $terminal = Terminal::where(

        'company_id',

        $companyId

    )

        ->where(

            'branch_id',

            $user->branch_id

        )

        ->where(

            'id',

            $validated['terminal_id']

        )

        ->first();


    if (! $terminal) {

        return response()->json([

            'status' => false,

            'message' => 'Terminal not found or does not belong to the cashier\'s branch.',

        ], 404);

    }


    /*
    |--------------------------------------------------------------------------
    | Terminal Status
    |--------------------------------------------------------------------------
    */

    if (! $terminal->status) {

        return response()->json([

            'status' => false,

            'message' => 'The selected terminal is inactive.',

        ], 422);

    }


    /*
    |--------------------------------------------------------------------------
    | Check Existing Terminal Assignment
    |--------------------------------------------------------------------------
    |
    | A terminal can only have one active cashier.
    |
    */

    $terminalInUse = TerminalAssignment::where(

        'company_id',

        $companyId

    )

        ->where(

            'terminal_id',

            $terminal->id

        )

        ->where(

            'status',

            'Active'

        )

        ->first();


    /*
    |--------------------------------------------------------------------------
    | Allow Same User
    |--------------------------------------------------------------------------
    |
    | If the terminal is already assigned to this same cashier, there is
    | nothing to create.
    |
    */

    if (

        $terminalInUse

        &&

        (int) $terminalInUse->user_id !== (int) $user->id

    ) {

        $assignedUser = User::find(

            $terminalInUse->user_id

        );


        $assignedUserName = $assignedUser

            ? $assignedUser->full_name

            : 'another cashier';


        return response()->json([

            'status' => false,

            'message' =>

                'This terminal is currently assigned to '

                . $assignedUserName

                . '.',

        ], 422);

    }


    /*
    |--------------------------------------------------------------------------
    | Existing User Assignment
    |--------------------------------------------------------------------------
    */

    $currentAssignment = TerminalAssignment::where(

        'company_id',

        $companyId

    )

        ->where(

            'user_id',

            $user->id

        )

        ->where(

            'status',

            'Active'

        )

        ->first();


    /*
    |--------------------------------------------------------------------------
    | Already Assigned To Selected Terminal
    |--------------------------------------------------------------------------
    */

    if (

        $currentAssignment

        &&

        (int) $currentAssignment->terminal_id === (int) $terminal->id

    ) {

        return response()->json([

            'status' => true,

            'message' => 'This cashier is already assigned to this terminal.',

            'assignment' => $currentAssignment

                ->fresh()

                ->load('terminal'),

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Begin Transaction
    |--------------------------------------------------------------------------
    */

    DB::beginTransaction();


    try {

        /*
        |--------------------------------------------------------------------------
        | Capture Old Values
        |--------------------------------------------------------------------------
        */

        $oldValues = $currentAssignment

            ? $currentAssignment->fresh()->toArray()

            : [];


        /*
        |--------------------------------------------------------------------------
        | Close Existing Assignment
        |--------------------------------------------------------------------------
        */

        if ($currentAssignment) {

            $currentAssignment->update([

                'status' => 'Inactive',

                'unassigned_at' => now(),

                'updated_by' => auth()->id(),

            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Create New Assignment
        |--------------------------------------------------------------------------
        */

        $assignment = TerminalAssignment::create([

            'company_id' => $companyId,

            'branch_id' => $user->branch_id,

            'terminal_id' => $terminal->id,

            'user_id' => $user->id,

            'assigned_at' => now(),

            'status' => 'Active',

            'created_by' => auth()->id(),

            'updated_by' => auth()->id(),

        ]);


        /*
        |--------------------------------------------------------------------------
        | Load Relationships
        |--------------------------------------------------------------------------
        */

        $assignment->load([

            'terminal',

            'user',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        $this->activityLogger->log(

            'Terminal Assignments',

            $currentAssignment

                ? 'Changed Assignment'

                : 'Assigned',

            $currentAssignment

                ? 'Changed terminal assignment for cashier: '

                    . $user->full_name

                    . ' to terminal: '

                    . $terminal->terminal_name

                : 'Assigned cashier: '

                    . $user->full_name

                    . ' to terminal: '

                    . $terminal->terminal_name,

            $assignment,

            $oldValues,

            $assignment->fresh()->toArray()

        );


        /*
        |--------------------------------------------------------------------------
        | Commit
        |--------------------------------------------------------------------------
        */

        DB::commit();


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'status' => true,

            'message' => $currentAssignment

                ? 'Terminal assignment changed successfully.'

                : 'Cashier assigned to terminal successfully.',

            'assignment' => $assignment,

        ]);


    } catch (\Throwable $e) {

        DB::rollBack();


        \Log::error(

            'Terminal assignment failed.',

            [

                'user_id' => $user->id,

                'terminal_id' => $terminal->id,

                'error' => $e->getMessage(),

            ]

        );


        return response()->json([

            'status' => false,

            'message' => 'Failed to save terminal assignment.',

        ], 500);

    }

}

    }

