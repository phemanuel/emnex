<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Support\Facades\DB;
use Exception;

class ProductService
{
    /**
     * Create a product.
     */
    public static function create(array $data): Product
    {
        return DB::transaction(function () use ($data) {

            if ($data['selling_price'] < $data['cost_price']) {

                throw new Exception(
                    'Selling price cannot be less than cost price.'
                );

            }

            $product = Product::create([

                'company_id' => companyId(),

                'product_category_id' => $data['product_category_id'],

                'product_code' => DocumentNumberService::generate('product'),

                'barcode' => $data['barcode'] ?? null,

                'sku' => $data['sku'] ?? null,

                'qr_code' => $data['qr_code'] ?? null,

                'name' => $data['name'],

                'description' => $data['description'] ?? null,

                'image' => $data['image'] ?? null,

                'cost_price' => $data['cost_price'],

                'selling_price' => $data['selling_price'],

                'discount_id' => $data['discount_id'] ?? null,

                'unit_id' => $data['unit_id'] ?? null,

                'brand' => $data['brand'] ?? null,

                'manufacturer' => $data['manufacturer'] ?? null,

                'expiry_date' => $data['expiry_date'] ?? null,

                'taxable' => $data['taxable'] ?? true,

                'tax_rate_id' => $data['tax_rate_id'] ?? null,

                'track_stock' => $data['track_stock'] ?? true,

                'minimum_stock' => $data['minimum_stock'] ?? 0,

                'maximum_stock' => $data['maximum_stock'] ?? null,

                'reorder_level' => $data['reorder_level'] ?? 0,

                'status' => true,

                'created_by' => auth()->id(),

            ]);

            foreach ($data['branches'] as $branchId) {

                ProductStock::create([

                    'company_id' => companyId(),

                    'branch_id' => $branchId,

                    'product_id' => $product->id,

                    'quantity' => 0,

                    'reserved_quantity' => 0,

                    'available_quantity' => 0,

                    'reorder_level' => $product->reorder_level,

                    'maximum_stock' => $product->maximum_stock,

                ]);

            }

            return $product;

        });

    }

    public static function update(Product $product, array $data): Product
    {
        return DB::transaction(function () use ($product, $data) {

            if ($data['selling_price'] < $data['cost_price']) {

                throw new Exception(
                    'Selling price cannot be less than cost price.'
                );

            }

            $product->update($data + [

                'updated_by' => auth()->id(),

            ]);

            return $product;

        });
    }

    public static function delete(Product $product): void
    {
        if ($product->stocks()->sum('quantity') > 0) {

            throw new Exception(
                'Cannot delete a product with available stock.'
            );

        }

        $product->delete();
    }

    
}