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

class UserController extends BaseController
{

    public function __construct(
        protected ActivityLogger $activityLogger
    ) {
    }

 public function index()
{
            $companyId = auth()->user()->company_id;


            $users = User::where(
                    'company_id',
                    $companyId
                )
                ->with([
                    'role',
                    'branch'
                ])
                ->latest()
                ->paginate(15);



            $roles = Role::where(
                    'company_id',
                    $companyId
                )
                ->where('status', true)
                ->get();



            $branches = Branch::where(
                    'company_id',
                    $companyId
                )
                ->get();



            $totalUsers = User::where(
                'company_id',
                $companyId
            )->count();



            $activeUsers = User::where(
                'company_id',
                $companyId
            )
            ->where('status', true)
            ->count();



            $disabledUsers = User::where(
                'company_id',
                $companyId
            )
            ->where('status', false)
            ->count();



            $roleCount = Role::where(
                'company_id',
                $companyId
            )->count();



            return view(
                'users.index',
                compact(
                    'users',
                    'roles',
                    'branches',
                    'totalUsers',
                    'activeUsers',
                    'disabledUsers',
                    'roleCount'
                )
            );
        }

        public function toggleStatus(User $user)
        {
            abort_if(
                $user->company_id !== auth()->user()->company_id,
                403
            );

            $oldValues = $user->toArray();

            $user->update([

                'status' => ! $user->status

            ]);

            $this->activityLogger->log(

                'Users',

                $user->status
                    ? 'User Activated'
                    : 'User Deactivated',

                $user->status
                    ? "Activated {$user->full_name}"
                    : "Deactivated {$user->full_name}",

                $user,

                $oldValues

            );

            return response()->json([

                'success' => true,

                'status' => $user->status,

                'message' => $user->status
                    ? 'User activated successfully.'
                    : 'User deactivated successfully.'

            ]);
        }

        public function store(Request $request)
        {
            $companyId = auth()->user()->company_id;

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
                        ->where(fn ($query) => $query->where('company_id', $companyId))
                ],

                'email' => [

                    'required',
                    'email',
                    'max:150',

                    Rule::unique('users')
                        ->where(fn ($query) => $query->where('company_id', $companyId))
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


    }

