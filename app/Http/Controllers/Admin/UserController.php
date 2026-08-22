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


    }

