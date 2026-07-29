<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaults = config('permissions.defaults');
        $modules  = config('permissions.permissions');

        foreach (Company::all() as $company) {

            foreach ($defaults as $roleCode => $permissionCodes) {

                $role = Role::where('company_id', $company->id)
                    ->where('code', $roleCode)
                    ->first();

                if (! $role) {
                    continue;
                }

                $permissionIds = [];

                /*
                |--------------------------------------------------------------------------
                | Owner / Administrator (*)
                |--------------------------------------------------------------------------
                */

                if (in_array('*', $permissionCodes)) {

                    $permissionIds = Permission::where('company_id', $company->id)
                        ->pluck('id')
                        ->toArray();

                } else {

                    foreach ($permissionCodes as $permission) {

                        /*
                        |--------------------------------------------------------------------------
                        | Module Wildcard
                        |--------------------------------------------------------------------------
                        | Example:
                        | products.*
                        | inventory.*
                        */

                        if (str_ends_with($permission, '.*')) {

                            $module = str_replace('.*', '', $permission);

                            if (isset($modules[$module])) {

                                foreach ($modules[$module] as $action) {

                                    $code = "{$module}.{$action}";

                                    $id = Permission::where('company_id', $company->id)
                                        ->where('code', $code)
                                        ->value('id');

                                    if ($id) {
                                        $permissionIds[] = $id;
                                    }

                                }

                            }

                            continue;
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Single Permission
                        |--------------------------------------------------------------------------
                        */

                        $id = Permission::where('company_id', $company->id)
                            ->where('code', $permission)
                            ->value('id');

                        if ($id) {
                            $permissionIds[] = $id;
                        }
                    }

                }

                /*
                |--------------------------------------------------------------------------
                | Sync Permissions
                |--------------------------------------------------------------------------
                */

                $role->permissions()->sync(
                    collect(array_unique($permissionIds))
                        ->mapWithKeys(function ($permissionId) use ($company) {

                            return [

                                $permissionId => [

                                    'company_id' => $company->id

                                ]

                            ];

                        })
                        ->toArray()
                );

            }

        }
    }
}