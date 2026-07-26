<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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

        $headOffice = Branch::where('company_id', $company->id)
            ->where('is_head_office', true)
            ->first();

        if (!$headOffice) {
            $this->command->error('Head Office branch not found. Please run BranchSeeder first.');
            return;
        }

        $roles = Role::where('company_id', $company->id)
            ->get()
            ->keyBy('name');

        $users = [

            [
                'employee_no' => 'EMP0001',
                'first_name' => 'System',
                'last_name' => 'Owner',
                'username' => 'owner',
                'email' => 'owner@emmanexitconsult.com',
                'role' => 'owner',
                'is_owner' => true,
            ],

            [
                'employee_no' => 'EMP0002',
                'first_name' => 'System',
                'last_name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@emmanexitconsult.com',
                'role' => 'administrator',
                'is_owner' => false,
            ],

            [
                'employee_no' => 'EMP0003',
                'first_name' => 'Branch',
                'last_name' => 'Manager',
                'username' => 'manager',
                'email' => 'manager@emmanexitconsult.com',
                'role' => 'manager',
                'is_owner' => false,
            ],

            [
                'employee_no' => 'EMP0004',
                'first_name' => 'Main',
                'last_name' => 'Cashier',
                'username' => 'cashier',
                'email' => 'cashier@emmanexitconsult.com',
                'role' => 'cashier',
                'is_owner' => false,
            ],

            [
                'employee_no' => 'EMP0005',
                'first_name' => 'Store',
                'last_name' => 'Keeper',
                'username' => 'storekeeper',
                'email' => 'storekeeper@emmanexitconsult.com',
                'role' => 'store_keeper',
                'is_owner' => false,
            ],

        ];

        foreach ($users as $user) {

            $role = $roles->get($user['role']);

            User::updateOrCreate(

                [
                    'company_id' => $company->id,
                    'username' => $user['username'],
                ],

                [
                    'company_id' => $company->id,
                    'branch_id' => $headOffice->id,
                    'role_id' => $role?->id,

                    'employee_no' => $user['employee_no'],

                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],

                    'username' => $user['username'],
                    'email' => $user['email'],

                    'is_owner' => $user['is_owner'],

                    'email_verified_at' => now(),

                    'two_factor_enabled' => false,

                    'phone' => null,

                    'password' => Hash::make('password'),

                    'profile_photo' => null,

                    'gender' => null,

                    'date_of_birth' => null,

                    'employment_date' => now()->toDateString(),

                    'status' => true,

                    'last_login_at' => null,

                    'last_login_ip' => null,

                    'force_password_change' => true,

                    'password_changed_at' => null,
                ]

            );

        }
    }
}