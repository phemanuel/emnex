<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\TaxRate;
use Illuminate\Database\Seeder;

class TaxRateSeeder extends Seeder
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

        $taxRates = [

            [
                'name' => 'No Tax',
                'rate' => 0.00,
            ],

            [
                'name' => 'VAT 7.5%',
                'rate' => 7.50,
            ],

            [
                'name' => 'VAT 15%',
                'rate' => 15.00,
            ],

            [
                'name' => 'Luxury Tax',
                'rate' => 10.00,
            ],

        ];

        foreach ($taxRates as $taxRate) {

            TaxRate::updateOrCreate(

                [
                    'company_id' => $company->id,
                    'name'       => $taxRate['name'],
                ],

                [
                    'company_id' => $company->id,
                    'name'       => $taxRate['name'],
                    'rate'       => $taxRate['rate'],
                    'status'     => true,
                ]

            );

        }
    }
}