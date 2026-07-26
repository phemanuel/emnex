<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Discount;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\TaxRate;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
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

        $categories = ProductCategory::where('company_id', $company->id)
            ->get()
            ->keyBy('name');

        $units = Unit::where('company_id', $company->id)
            ->get()
            ->keyBy('short_name');

        $tax = TaxRate::where('company_id', $company->id)
            ->where('name', 'VAT 7.5%')
            ->first();

        $discount = Discount::where('company_id', $company->id)
            ->where('name', 'No Discount')
            ->first();

        $products = [

            [
                'code' => 'PRD000001',
                'barcode' => '100000000001',
                'sku' => 'COKE50CL',
                'name' => 'Coca-Cola 50cl',
                'category' => 'Beverages',
                'unit' => 'PCS',
                'cost' => 500,
                'price' => 700,
                'brand' => 'Coca-Cola',
                'manufacturer' => 'NBC',
            ],

            [
                'code' => 'PRD000002',
                'barcode' => '100000000002',
                'sku' => 'FANTA50CL',
                'name' => 'Fanta 50cl',
                'category' => 'Beverages',
                'unit' => 'PCS',
                'cost' => 500,
                'price' => 700,
                'brand' => 'Fanta',
                'manufacturer' => 'NBC',
            ],

            [
                'code' => 'PRD000003',
                'barcode' => '100000000003',
                'sku' => 'SPRITE50CL',
                'name' => 'Sprite 50cl',
                'category' => 'Beverages',
                'unit' => 'PCS',
                'cost' => 500,
                'price' => 700,
                'brand' => 'Sprite',
                'manufacturer' => 'NBC',
            ],

            [
                'code' => 'PRD000004',
                'barcode' => '100000000004',
                'sku' => 'PEAK500',
                'name' => 'Peak Milk 500g',
                'category' => 'Dairy',
                'unit' => 'PCS',
                'cost' => 4200,
                'price' => 4800,
                'brand' => 'Peak',
                'manufacturer' => 'FrieslandCampina',
            ],

            [
                'code' => 'PRD000005',
                'barcode' => '100000000005',
                'sku' => 'INDM70',
                'name' => 'Indomie Chicken Noodles',
                'category' => 'Groceries',
                'unit' => 'PCS',
                'cost' => 180,
                'price' => 250,
                'brand' => 'Indomie',
                'manufacturer' => 'Dufil',
            ],

            [
                'code' => 'PRD000006',
                'barcode' => '100000000006',
                'sku' => 'SUG1KG',
                'name' => 'Dangote Sugar 1kg',
                'category' => 'Groceries',
                'unit' => 'PCS',
                'cost' => 1450,
                'price' => 1650,
                'brand' => 'Dangote',
                'manufacturer' => 'Dangote',
            ],

            [
                'code' => 'PRD000007',
                'barcode' => '100000000007',
                'sku' => 'BREAD001',
                'name' => 'Family Bread',
                'category' => 'Bakery',
                'unit' => 'PCS',
                'cost' => 900,
                'price' => 1200,
                'brand' => 'Local',
                'manufacturer' => 'Bakery',
            ],

            [
                'code' => 'PRD000008',
                'barcode' => '100000000008',
                'sku' => 'RICE50KG',
                'name' => 'Mama Gold Rice 50kg',
                'category' => 'Groceries',
                'unit' => 'BAG',
                'cost' => 82000,
                'price' => 90000,
                'brand' => 'Mama Gold',
                'manufacturer' => 'Mama Gold',
            ],

            [
                'code' => 'PRD000009',
                'barcode' => '100000000009',
                'sku' => 'SOAP001',
                'name' => 'Premier Soap',
                'category' => 'Household',
                'unit' => 'PCS',
                'cost' => 500,
                'price' => 700,
                'brand' => 'Premier',
                'manufacturer' => 'PZ',
            ],

            [
                'code' => 'PRD000010',
                'barcode' => '100000000010',
                'sku' => 'PAMP001',
                'name' => 'Pampers Size 3',
                'category' => 'Baby Products',
                'unit' => 'PK',
                'cost' => 7800,
                'price' => 8600,
                'brand' => 'Pampers',
                'manufacturer' => 'P&G',
            ],

        ];

        foreach ($products as $item) {

            Product::updateOrCreate(

                [
                    'company_id' => $company->id,
                    'product_code' => $item['code'],
                ],

                [
                    'company_id' => $company->id,

                    'product_category_id' => optional($categories->get($item['category']))->id,

                    'product_code' => $item['code'],

                    'barcode' => $item['barcode'],

                    'sku' => $item['sku'],

                    'qr_code' => null,

                    'name' => $item['name'],

                    'description' => null,

                    'image' => null,

                    'cost_price' => $item['cost'],

                    'selling_price' => $item['price'],

                    'discount_id' => optional($discount)->id,

                    'unit_id' => optional($units->get($item['unit']))->id,

                    'shelf_location' => null,

                    'track_stock' => true,

                    'brand' => $item['brand'],

                    'manufacturer' => $item['manufacturer'],

                    'expiry_date' => null,

                    'taxable' => true,

                    'tax_rate_id' => optional($tax)->id,

                    'status' => true,

                    'minimum_stock' => 10,

                    'maximum_stock' => 500,

                    'weight' => null,

                    'dimensions' => null,

                    'created_by' => $owner->id,

                    'updated_by' => $owner->id,

                    'reorder_level' => 20,

                ]

            );

        }
    }
}