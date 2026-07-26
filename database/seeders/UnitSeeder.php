<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
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

        $units = [

            [
                'name' => 'Piece',
                'short_name' => 'PCS',
            ],

            [
                'name' => 'Pack',
                'short_name' => 'PK',
            ],

            [
                'name' => 'Carton',
                'short_name' => 'CTN',
            ],

            [
                'name' => 'Bottle',
                'short_name' => 'BTL',
            ],

            [
                'name' => 'Can',
                'short_name' => 'CAN',
            ],

            [
                'name' => 'Kilogram',
                'short_name' => 'KG',
            ],

            [
                'name' => 'Gram',
                'short_name' => 'G',
            ],

            [
                'name' => 'Litre',
                'short_name' => 'LTR',
            ],

            [
                'name' => 'Millilitre',
                'short_name' => 'ML',
            ],

            [
                'name' => 'Dozen',
                'short_name' => 'DOZ',
            ],

            [
                'name' => 'Bag',
                'short_name' => 'BAG',
            ],

            [
                'name' => 'Roll',
                'short_name' => 'ROL',
            ],

            [
                'name' => 'Box',
                'short_name' => 'BOX',
            ],

        ];

        foreach ($units as $unit) {

            Unit::updateOrCreate(

                [
                    'company_id' => $company->id,
                    'name' => $unit['name'],
                ],

                [
                    'company_id' => $company->id,
                    'name' => $unit['name'],
                    'short_name' => $unit['short_name'],
                    'status' => true,
                ]

            );

        }
    }
}