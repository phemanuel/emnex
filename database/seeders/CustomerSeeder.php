<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = Company::first();

        if (!$company) {
            $this->command->error('Company not found.');
            return;
        }

        $owner = User::where('company_id', $company->id)
            ->where('is_owner', true)
            ->first();

        if (!$owner) {
            $this->command->error('Owner user not found.');
            return;
        }

        $customers = [

            [
                'customer_code' => 'CUS000001',
                'first_name' => 'Walk-in',
                'last_name' => 'Customer',
                'customer_type' => 'Walk-in',
            ],

            [
                'customer_code' => 'CUS000002',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'phone' => '08030000001',
                'customer_type' => 'Regular',
            ],

            [
                'customer_code' => 'CUS000003',
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane@example.com',
                'phone' => '08030000002',
                'customer_type' => 'Regular',
            ],

            [
                'customer_code' => 'CUS000004',
                'first_name' => 'Michael',
                'last_name' => 'Johnson',
                'email' => 'michael@example.com',
                'phone' => '08030000003',
                'customer_type' => 'Wholesale',
            ],

            [
                'customer_code' => 'CUS000005',
                'first_name' => 'Sarah',
                'last_name' => 'Williams',
                'email' => 'sarah@example.com',
                'phone' => '08030000004',
                'customer_type' => 'VIP',
            ],

        ];

        foreach ($customers as $customer) {

            Customer::updateOrCreate(

                [
                    'company_id' => $company->id,
                    'customer_code' => $customer['customer_code'],
                ],

                [
                    'company_id' => $company->id,

                    'customer_code' => $customer['customer_code'],

                    'first_name' => $customer['first_name'],

                    'last_name' => $customer['last_name'] ?? null,

                    'email' => $customer['email'] ?? null,

                    'phone' => $customer['phone'] ?? null,

                    'address' => null,

                    'credit_limit' => 0,

                    'current_balance' => 0,

                    'customer_type' => $customer['customer_type'],

                    'loyalty_points' => 0,

                    'last_purchase_date' => null,

                    'status' => true,

                    'created_by' => $owner->id,

                    'updated_by' => $owner->id,

                ]

            );

        }
    }
}