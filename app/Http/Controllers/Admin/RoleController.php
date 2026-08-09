<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\ActivityLog;

class RoleController extends Controller
{

    public function __construct(
        protected ActivityLogger $activityLogger
    ) {
    }


    /*
    |--------------------------------------------------------------------------
    | Display Roles
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $companyId = auth()->user()->company_id;

        if (! canAccess('roles.view')) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to view roles.'
            ], 403);
        }

        $roles = Role::where(
            'company_id',
            $companyId
        )
        ->withCount([
            'users',
            'permissions'
        ])
        ->ordered()
        ->paginate(15);


        return view(
            'roles.index',
            compact('roles')
        );
    }



    /*
    |--------------------------------------------------------------------------
    | Create Role
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('roles.create');
    }




    /*
    |--------------------------------------------------------------------------
    | Store Role
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        if (! canAccess('roles.view')) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to view roles.'
            ], 403);
        }
        $companyId = auth()->user()->company_id;


        $validated = $request->validate([

            'name' => [

                'required',
                'string',
                'max:100',

                Rule::unique('roles')
                    ->where(function ($query) use ($companyId) {

                        return $query
                            ->where('company_id', $companyId)
                            ->whereNull('deleted_at');

                    })

            ],

            'code' => [

                'required',
                'string',
                'max:100',

                Rule::unique('roles')
                    ->where(function ($query) use ($companyId) {

                        return $query
                            ->where('company_id', $companyId)
                            ->whereNull('deleted_at');

                    })

            ],

            'display_name' => [

                'required',
                'string',
                'max:150'

            ],

            'description' => [

                'nullable',
                'string'

            ],

            'status' => [

                'required',
                'boolean'

            ],

        ]);


        $role = Role::create([

            'company_id' => $companyId,

            'name' => $validated['name'],

            'code' => strtolower(
                $validated['code']
            ),

            'display_name' =>
                $validated['display_name'],

            'description' =>
                $validated['description'] ?? null,

            'status' =>
                $validated['status'],

        ]);



        $this->activityLogger->log(

            'Authorization',

            'Created',

            "Created role {$role->display_name}",

            $role,

            null,

            $role->toArray()

        );



        return response()->json([
            'success' => true,
            'message' => 'Role created successfully.',
            'data' => [
                'id' => $role->id,
                'name' => $role->displayLabel(),
                'code' => $role->code,
                'description' => $role->description,
                'status' => $role->status,
                'users_count' => 0,
                'permissions_count' => 0,
                'is_system' => $role->is_system,
            ]
        ]);
    }





    /*
    |--------------------------------------------------------------------------
    | Show Role
    |--------------------------------------------------------------------------
    */

    public function show(Role $role)
    {
        $this->authorizeCompany($role);

        if (! canAccess('roles.view')) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to view roles.'
            ], 403);
        }


        $role->load([
            'permissions',
            'users'
        ]);


        return view(
            'admin.roles.show',
            compact('role')
        );
    }





    /*
    |--------------------------------------------------------------------------
    | Edit Role
    |--------------------------------------------------------------------------
    */

    public function edit(Role $role)
    {
        $this->authorizeCompany($role);

        return response()->json([
            'success' => true,
            'role' => $role,
        ]);
    }





    /*
    |--------------------------------------------------------------------------
    | Update Role
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Role $role )
    {
        $this->authorizeCompany($role);

        if (! canAccess('roles.update')) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to update roles.'
            ], 403);
        }


        if ($role->is_system) {

            return back()
                ->with(
                    'error',
                    'System roles cannot be modified.'
                );

        }



        $companyId = auth()->user()->company_id;



        $validated = $request->validate([

            'name' => [

                'required',
                'string',
                'max:100',

                Rule::unique('roles')
                    ->where(function ($query) use ($companyId) {

                        return $query
                            ->where('company_id', $companyId)
                            ->whereNull('deleted_at');

                    })
                    ->ignore($role->id)

            ],

            'code' => [

                'required',
                'string',
                'max:100',

                Rule::unique('roles')
                    ->where(function ($query) use ($companyId) {

                        return $query
                            ->where('company_id', $companyId)
                            ->whereNull('deleted_at');

                    })
                    ->ignore($role->id)

            ],

            'display_name' => [

                'required',
                'string',
                'max:150'

            ],

            'description' => [

                'nullable',
                'string'

            ],

            'status' => [

                'required',
                'boolean'

            ],

        ]);

        $oldName = $role->display_name;
        $oldValues = $role->toArray();



        $role->update([

            'name'=>$validated['name'],

            'code'=>strtolower(
                $validated['code']
            ),

            'display_name'=>
                $validated['display_name'],

            'description'=>
                $validated['description'] ?? null,

            'status'=>
                $validated['status'],

        ]);




        $this->activityLogger->log(

            'Authorization',

            'Updated',

            "Updated role {$role->display_name}",

            $role,

            $oldValues,

            $role->fresh()->toArray()

        );




        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully.',
            'data' => [
                'id' => $role->id,
                'name' => $role->displayLabel(),
                'code' => $role->code,
                'description' => $role->description,
                'status' => $role->status,
                'users_count' => 0,
                'permissions_count' => 0,
                'is_system' => $role->is_system,
            ]
        ]);

    }






    /*
    |--------------------------------------------------------------------------
    | Delete Role
    |--------------------------------------------------------------------------
    */

    public function destroy(Role $role)
    {
        $this->authorizeCompany($role);

        if (! canAccess('roles.delete')) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to delete roles.'
            ], 403);
        }

        if ($role->is_system) {

            return response()->json([
                'success' => false,
                'message' => 'System roles cannot be deleted.'
            ], 422);

        }

        if ($role->users()->exists()) {

            return response()->json([
                'success' => false,
                'message' => 'Cannot delete a role assigned to users.'
            ], 422);

        }

        DB::transaction(function () use ($role) {

            $oldValues = $role->toArray();

            $roleName = $role->display_name;

            RolePermission::where(
                'role_id',
                $role->id
            )->delete();

            $role->delete();

            $this->activityLogger->log(

                'Authorization',

                'Deleted',

                "Deleted role {$roleName}",

                null,

                $oldValues,

                null

            );

        });

        return response()->json([

            'success' => true,

            'message' => 'Role deleted successfully.'

        ]);
    }

    
    /*
    |--------------------------------------------------------------------------
    | Role Permissions
    |--------------------------------------------------------------------------
    */

    public function permissions(Role $role)
    {
        $permissions = Permission::query()
            ->where('company_id', auth()->user()->company_id)
            ->where('status', true)
            ->orderBy('module')
            ->orderBy('display_name')
            ->get()
            ->groupBy('module');

        $assignedPermissions = $role->permissions()
            ->pluck('permissions.id')
            ->toArray();

        return view(
            'roles.permissions',
            compact(
                'role',
                'permissions',
                'assignedPermissions'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Save Role Permissions
    |--------------------------------------------------------------------------
    */


    public function updatePermissions(Request $request, Role $role)
    {
        $validated = $request->validate([

            'permissions' => ['nullable', 'array'],

            'permissions.*' => ['exists:permissions,id'],

        ]);

        $oldValues = [

            'permissions' => $role
                ->permissions()
                ->pluck('permissions.id')
                ->toArray(),

        ];

        $syncData = [];

        foreach ($validated['permissions'] ?? [] as $permissionId) {

            $syncData[$permissionId] = [

                'company_id' => auth()->user()->company_id,

            ];

        }

        $role->permissions()->sync($syncData);

        $newValues = [

            'permissions' => $role
                ->permissions()
                ->pluck('permissions.id')
                ->toArray(),

        ];

        $this->activityLogger->log(

            'Authorization',

            'Permissions Updated',

            "Updated permissions for role {$role->display_name}",

            $role,

            $oldValues,

            $newValues

        );

        return response()->json([

            'success' => true,

            'message' => 'Permissions updated successfully.'

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Company Security
    |--------------------------------------------------------------------------
    */

    private function authorizeCompany(Role $role): void
    {

        abort_if(

            $role->company_id !==
            auth()->user()->company_id,

            403

        );

    }


}