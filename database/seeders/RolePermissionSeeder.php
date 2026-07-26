<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = Company::first();

        if (!$company) {
            $this->command->error('Company not found. Please run CompanySeeder first.');
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Load Roles
        |--------------------------------------------------------------------------
        */

        $roles = Role::where('company_id', $company->id)
            ->get()
            ->keyBy('name');

        /*
        |--------------------------------------------------------------------------
        | Load Permissions
        |--------------------------------------------------------------------------
        */

        $permissions = Permission::whereNull('company_id')
            ->get()
            ->keyBy('name');

        /*
        |--------------------------------------------------------------------------
        | Permission Map
        |--------------------------------------------------------------------------
        */

        $map = [

            /*
            |--------------------------------------------------------------------------
            | Owner
            |--------------------------------------------------------------------------
            */

            'owner' => $permissions->keys()->toArray(),

            /*
            |--------------------------------------------------------------------------
            | Administrator
            |--------------------------------------------------------------------------
            */

            'administrator' => $permissions->keys()->toArray(),

            /*
            |--------------------------------------------------------------------------
            | Manager
            |--------------------------------------------------------------------------
            */

            'manager' => [

                'dashboard.view',

                'products.view',
                'products.create',
                'products.edit',

                'categories.view',

                'customers.view',
                'customers.create',
                'customers.edit',

                'sales.view',
                'sales.create',

                'payments.view',

                'inventory.view',
                'inventory.adjust',

                'reports.view',

            ],

            /*
            |--------------------------------------------------------------------------
            | Supervisor
            |--------------------------------------------------------------------------
            */

            'supervisor' => [

                'dashboard.view',

                'products.view',

                'customers.view',

                'sales.view',

                'inventory.view',

                'reports.view',

            ],

            /*
            |--------------------------------------------------------------------------
            | Cashier
            |--------------------------------------------------------------------------
            */

            'cashier' => [

                'dashboard.view',

                'products.view',

                'customers.view',
                'customers.create',

                'sales.view',
                'sales.create',

                'payments.view',
                'payments.create',

            ],

            /*
            |--------------------------------------------------------------------------
            | Store Keeper
            |--------------------------------------------------------------------------
            */

            'store_keeper' => [

                'dashboard.view',

                'products.view',
                'products.create',
                'products.edit',

                'categories.view',

                'inventory.view',
                'inventory.adjust',

            ],

        ];

        /*
        |--------------------------------------------------------------------------
        | Save Role Permissions
        |--------------------------------------------------------------------------
        */

        foreach ($map as $roleName => $permissionNames) {

            $role = $roles->get($roleName);

            if (!$role) {
                continue;
            }

            foreach ($permissionNames as $permissionName) {

                $permission = $permissions->get($permissionName);

                if (!$permission) {
                    continue;
                }

                RolePermission::updateOrCreate(

                    [
                        'company_id'   => $company->id,
                        'role_id'      => $role->id,
                        'permission_id'=> $permission->id,
                    ],

                    [
                        'company_id'   => $company->id,
                        'role_id'      => $role->id,
                        'permission_id'=> $permission->id,
                    ]

                );

            }

        }
    }
}