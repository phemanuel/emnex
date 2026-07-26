<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::updateOrCreate(

            [
                'company_code' => 'COMP-0001',
            ],

            [
                'company_code' => 'COMP-0001',

                'name' => 'Emmanex Supermarket',

                'slug' => Str::slug('Emmanex Supermarket'),

                'email' => 'info@emmanexitconsult.com',

                'phone' => '08012345678',

                'address' => 'Lagos, Nigeria',

                'logo' => null,

                'currency' => 'NGN',

                'currency_symbol' => '₦',

                'timezone' => 'Africa/Lagos',

                'subscription_start' => now(),

                'subscription_end' => now()->addYear(),

                'subscription_status' => 'Active',

                'business_type' => 'Retail Supermarket',

                'registration_no' => 'RC123456',

                'tin' => 'TIN123456789',

                'status' => true,

            ]

        );
    }
}