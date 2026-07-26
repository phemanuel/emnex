<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Discount;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
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

        $discounts = [

            [
                'name' => 'No Discount',
                'type' => 'Percentage',
                'value' => 0.00,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addYears(10)->toDateString(),
                'is_automatic' => true,
            ],

            [
                'name' => 'Opening Promotion',
                'type' => 'Percentage',
                'value' => 5.00,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addMonth()->toDateString(),
                'is_automatic' => true,
            ],

            [
                'name' => 'Manager Discount',
                'type' => 'Percentage',
                'value' => 10.00,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addYear()->toDateString(),
                'is_automatic' => false,
            ],

            [
                'name' => 'Special Customer',
                'type' => 'Fixed',
                'value' => 500.00,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addYear()->toDateString(),
                'is_automatic' => false,
            ],

        ];

        foreach ($discounts as $discount) {

            Discount::updateOrCreate(

                [
                    'company_id' => $company->id,
                    'name' => $discount['name'],
                ],

                [
                    'company_id' => $company->id,

                    'name' => $discount['name'],

                    'type' => $discount['type'],

                    'value' => $discount['value'],

                    'start_date' => $discount['start_date'],

                    'end_date' => $discount['end_date'],

                    'is_automatic' => $discount['is_automatic'],

                    'status' => true,

                ]

            );

        }
    }
}