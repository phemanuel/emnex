<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            // Dashboard
            ['module' => 'Dashboard', 'name' => 'dashboard.view', 'display_name' => 'View Dashboard'],

            // Users
            ['module' => 'Users', 'name' => 'users.view', 'display_name' => 'View Users'],
            ['module' => 'Users', 'name' => 'users.create', 'display_name' => 'Create Users'],
            ['module' => 'Users', 'name' => 'users.edit', 'display_name' => 'Edit Users'],
            ['module' => 'Users', 'name' => 'users.delete', 'display_name' => 'Delete Users'],

            // Roles
            ['module' => 'Roles', 'name' => 'roles.view', 'display_name' => 'View Roles'],
            ['module' => 'Roles', 'name' => 'roles.create', 'display_name' => 'Create Roles'],
            ['module' => 'Roles', 'name' => 'roles.edit', 'display_name' => 'Edit Roles'],
            ['module' => 'Roles', 'name' => 'roles.delete', 'display_name' => 'Delete Roles'],

            // Products
            ['module' => 'Products', 'name' => 'products.view', 'display_name' => 'View Products'],
            ['module' => 'Products', 'name' => 'products.create', 'display_name' => 'Create Products'],
            ['module' => 'Products', 'name' => 'products.edit', 'display_name' => 'Edit Products'],
            ['module' => 'Products', 'name' => 'products.delete', 'display_name' => 'Delete Products'],

            // Categories
            ['module' => 'Categories', 'name' => 'categories.view', 'display_name' => 'View Categories'],
            ['module' => 'Categories', 'name' => 'categories.create', 'display_name' => 'Create Categories'],
            ['module' => 'Categories', 'name' => 'categories.edit', 'display_name' => 'Edit Categories'],
            ['module' => 'Categories', 'name' => 'categories.delete', 'display_name' => 'Delete Categories'],

            // Customers
            ['module' => 'Customers', 'name' => 'customers.view', 'display_name' => 'View Customers'],
            ['module' => 'Customers', 'name' => 'customers.create', 'display_name' => 'Create Customers'],
            ['module' => 'Customers', 'name' => 'customers.edit', 'display_name' => 'Edit Customers'],
            ['module' => 'Customers', 'name' => 'customers.delete', 'display_name' => 'Delete Customers'],

            // Sales
            ['module' => 'Sales', 'name' => 'sales.view', 'display_name' => 'View Sales'],
            ['module' => 'Sales', 'name' => 'sales.create', 'display_name' => 'Create Sales'],
            ['module' => 'Sales', 'name' => 'sales.cancel', 'display_name' => 'Cancel Sales'],

            // Payments
            ['module' => 'Payments', 'name' => 'payments.view', 'display_name' => 'View Payments'],
            ['module' => 'Payments', 'name' => 'payments.create', 'display_name' => 'Receive Payments'],

            // Inventory
            ['module' => 'Inventory', 'name' => 'inventory.view', 'display_name' => 'View Inventory'],
            ['module' => 'Inventory', 'name' => 'inventory.adjust', 'display_name' => 'Adjust Inventory'],

            // Reports
            ['module' => 'Reports', 'name' => 'reports.view', 'display_name' => 'View Reports'],

            // Settings
            ['module' => 'Settings', 'name' => 'settings.view', 'display_name' => 'View Settings'],
            ['module' => 'Settings', 'name' => 'settings.edit', 'display_name' => 'Edit Settings'],

        ];

        foreach ($permissions as $permission) {

            Permission::updateOrCreate(

                [
                    'company_id' => null,
                    'name' => $permission['name'],
                ],

                [
                    'company_id' => null,
                    'module' => $permission['module'],
                    'name' => $permission['name'],
                    'display_name' => $permission['display_name'],
                    'description' => null,
                    'status' => true,
                ]

            );

        }
    }
}