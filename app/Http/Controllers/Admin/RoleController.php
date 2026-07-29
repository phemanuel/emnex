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
        $companyId = auth()->user()->company_id;


        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:100'
            ],

            'code' => [
                'required',
                'string',
                'max:100',

                Rule::unique('roles')
                    ->where(
                        'company_id',
                        $companyId
                    )
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

            $role

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

    public function update(
        Request $request,
        Role $role
    )
    {
        $this->authorizeCompany($role);



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
                'max:100'
            ],


            'code' => [

                'required',
                'string',
                'max:100',

                Rule::unique('roles')
                    ->where(
                        'company_id',
                        $companyId
                    )
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

            "Updated role {$oldName}",

            $role

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



        if ($role->is_system) {

            return back()
                ->with(
                    'error',
                    'System roles cannot be deleted.'
                );

        }



        if ($role->users()->exists()) {

            return back()
                ->with(
                    'error',
                    'Cannot delete role assigned to users.'
                );

        }



        DB::transaction(function () use ($role) {


            RolePermission::where(
                'role_id',
                $role->id
            )
            ->delete();



            $this->activityLogger->log(

                'Authorization',

                'Deleted',

                "Deleted role {$role->display_name}",

                $role

            );



            $role->delete();


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
        $this->authorizeCompany($role);



        $companyId = auth()->user()->company_id;



        $permissions = Permission::where(
                'company_id',
                $companyId
            )
            ->active()
            ->ordered()
            ->get()
            ->groupBy('module');




        $assignedPermissions =
            RolePermission::where([
                'company_id'=>$companyId,
                'role_id'=>$role->id,
            ])
            ->pluck('permission_id')
            ->toArray();




        return view(
            'admin.roles.permissions',
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

    public function updatePermissions(
        Request $request,
        Role $role
    )
    {

        $this->authorizeCompany($role);



        $request->validate([

            'permissions'=>'nullable|array',

            'permissions.*'=>
                'exists:permissions,id',

        ]);



        $companyId = auth()->user()->company_id;



        DB::transaction(function () use (
            $request,
            $role,
            $companyId
        ) {


            RolePermission::where([

                'company_id'=>$companyId,

                'role_id'=>$role->id,

            ])
            ->delete();




            foreach(
                $request->permissions ?? []
                as $permissionId
            ) {


                RolePermission::create([

                    'company_id'=>$companyId,

                    'role_id'=>$role->id,

                    'permission_id'=>$permissionId,

                ]);

            }



        });




        $this->activityLogger->log(

            'Authorization',

            'Permissions Updated',

            "Updated permissions for role {$role->display_name}",

            $role

        );





        return redirect()
            ->route(
                'roles.permissions',
                $role
            )
            ->with(
                'success',
                'Permissions updated successfully.'
            );

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