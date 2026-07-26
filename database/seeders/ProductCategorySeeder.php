<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
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

        $user = User::where('company_id', $company->id)
            ->where('is_owner', true)
            ->first();

        if (!$user) {
            $this->command->error('Owner user not found.');
            return;
        }

        $categories = [

            [
                'category_code' => 'CAT000001',
                'name' => 'Beverages',
                'description' => 'Soft drinks, juices, bottled water and energy drinks.',
            ],

            [
                'category_code' => 'CAT000002',
                'name' => 'Groceries',
                'description' => 'Rice, beans, pasta, noodles and food items.',
            ],

            [
                'category_code' => 'CAT000003',
                'name' => 'Bakery',
                'description' => 'Bread, cakes and pastries.',
            ],

            [
                'category_code' => 'CAT000004',
                'name' => 'Frozen Foods',
                'description' => 'Frozen meat, fish and poultry.',
            ],

            [
                'category_code' => 'CAT000005',
                'name' => 'Dairy',
                'description' => 'Milk, butter, cheese and yoghurt.',
            ],

            [
                'category_code' => 'CAT000006',
                'name' => 'Snacks',
                'description' => 'Biscuits, chocolates and confectioneries.',
            ],

            [
                'category_code' => 'CAT000007',
                'name' => 'Household',
                'description' => 'Cleaning materials and home essentials.',
            ],

            [
                'category_code' => 'CAT000008',
                'name' => 'Toiletries',
                'description' => 'Personal care and hygiene products.',
            ],

            [
                'category_code' => 'CAT000009',
                'name' => 'Baby Products',
                'description' => 'Baby food, diapers and accessories.',
            ],

            [
                'category_code' => 'CAT000010',
                'name' => 'Stationery',
                'description' => 'Office and school supplies.',
            ],

        ];

        foreach ($categories as $category) {

            ProductCategory::updateOrCreate(

                [
                    'company_id' => $company->id,
                    'category_code' => $category['category_code'],
                ],

                [
                    'company_id' => $company->id,
                    'category_code' => $category['category_code'],
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'parent_id' => null,
                    'image' => null,
                    'sort_order' => 0,
                    'status' => true,
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ]

            );

        }
    }
}