<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Company;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Database\Seeder;

class ProductStockSeeder extends Seeder
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

        $branch = Branch::where('company_id', $company->id)
            ->where('is_head_office', true)
            ->first();

        if (!$branch) {
            $this->command->error('Head Office branch not found.');
            return;
        }

        $products = Product::where('company_id', $company->id)->get();

        foreach ($products as $product) {

            ProductStock::updateOrCreate(

                [
                    'company_id' => $company->id,
                    'branch_id'  => $branch->id,
                    'product_id' => $product->id,
                ],

                [
                    'company_id'         => $company->id,
                    'branch_id'          => $branch->id,
                    'product_id'         => $product->id,

                    'quantity'           => 100,

                    'reserved_quantity'  => 0,

                    'available_quantity' => 100,

                    'reorder_level'      => 20,

                    'maximum_stock'      => 500,

                ]

            );

        }
    }
}