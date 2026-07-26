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
                'display_name' => 'Owner',
                'description' => 'System owner with full access.',
            ],

            [
                'name' => 'administrator',
                'display_name' => 'Administrator',
                'description' => 'Manages all company operations.',
            ],

            [
                'name' => 'manager',
                'display_name' => 'Manager',
                'description' => 'Oversees daily business activities.',
            ],

            [
                'name' => 'supervisor',
                'display_name' => 'Supervisor',
                'description' => 'Supervises branch operations.',
            ],

            [
                'name' => 'cashier',
                'display_name' => 'Cashier',
                'description' => 'Processes sales transactions.',
            ],

            [
                'name' => 'store_keeper',
                'display_name' => 'Store Keeper',
                'description' => 'Manages inventory and stock.',
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