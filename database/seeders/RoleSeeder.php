<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
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

        $roles = [

            [
                'name' => 'owner',
                'code' => 'owner',
                'display_name' => 'Owner',
                'description' => 'System owner with unrestricted access.',
            ],

            [
                'name' => 'administrator',
                'code' => 'administrator',
                'display_name' => 'Administrator',
                'description' => 'Company administrator.',
            ],

            [
                'name' => 'branch_manager',
                'code' => 'branch_manager',
                'display_name' => 'Branch Manager',
                'description' => 'Manages a business branch.',
            ],

            [
                'name' => 'supervisor',
                'code' => 'supervisor',
                'display_name' => 'Supervisor',
                'description' => 'Supervises daily business operations.',
            ],

            [
                'name' => 'cashier',
                'code' => 'cashier',
                'display_name' => 'Cashier',
                'description' => 'Processes customer sales.',
            ],

            [
                'name' => 'inventory_manager',
                'code' => 'inventory_manager',
                'display_name' => 'Inventory Manager',
                'description' => 'Manages inventory and stock.',
            ],

            [
                'name' => 'accountant',
                'code' => 'accountant',
                'display_name' => 'Accountant',
                'description' => 'Handles financial operations.',
            ],

        ];

        foreach ($roles as $role) {

            Role::updateOrCreate(

                [
                    'company_id' => $company->id,
                    'name' => $role['name'],
                ],

                [
                    'company_id' => $company->id,
                    'name' => $role['name'],
                    'display_name' => $role['display_name'],
                    'description' => $role['description'],
                    'status' => true,
                ]

            );

        }
    }
}