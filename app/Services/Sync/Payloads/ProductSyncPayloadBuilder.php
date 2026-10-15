<?php

namespace App\Services\Sync\Payloads;

use App\Models\Discount;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\TaxRate;
use App\Models\Unit;
use RuntimeException;


class ProductSyncPayloadBuilder
{
    /*
    |--------------------------------------------------------------------------
    | Build Product Payload
    |--------------------------------------------------------------------------
    */

    public function build(
        Product $product
    ): array {

        /*
        |--------------------------------------------------------------------------
        | Ensure Product Has Sync Identity
        |--------------------------------------------------------------------------
        */

        if (!$product->sync_uuid) {

            throw new RuntimeException(
                "Product [{$product->id}] does not have a synchronization UUID."
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Company
        |--------------------------------------------------------------------------
        */

        $companyId =
            (int) $product->company_id;


        /*
        |--------------------------------------------------------------------------
        | Resolve Synchronizable Relationships
        |--------------------------------------------------------------------------
        |
        | Never send local numeric foreign keys.
        |
        */

        $categorySyncUuid =
            $this->categorySyncUuid(
                $product,
                $companyId
            );


        $unitSyncUuid =
            $this->unitSyncUuid(
                $product,
                $companyId
            );


        $taxRateSyncUuid =
            $this->taxRateSyncUuid(
                $product,
                $companyId
            );


        $discountSyncUuid =
            $this->discountSyncUuid(
                $product,
                $companyId
            );


        /*
        |--------------------------------------------------------------------------
        | Payload
        |--------------------------------------------------------------------------
        */

        return [

            /*
            |--------------------------------------------------------------------------
            | Relationships
            |--------------------------------------------------------------------------
            */

            'product_category_sync_uuid' =>
                $categorySyncUuid,

            'unit_sync_uuid' =>
                $unitSyncUuid,

            'tax_rate_sync_uuid' =>
                $taxRateSyncUuid,

            'discount_sync_uuid' =>
                $discountSyncUuid,


            /*
            |--------------------------------------------------------------------------
            | Product Identifiers
            |--------------------------------------------------------------------------
            */

            'product_code' =>
                $product->product_code,

            'sku' =>
                $product->sku,

            'barcode' =>
                $product->barcode,

            'qr_code' =>
                $product->qr_code,


            /*
            |--------------------------------------------------------------------------
            | Product Details
            |--------------------------------------------------------------------------
            */

            'name' =>
                $product->name,

            'description' =>
                $product->description,

            'brand' =>
                $product->brand,

            'manufacturer' =>
                $product->manufacturer,


            /*
            |--------------------------------------------------------------------------
            | Pricing
            |--------------------------------------------------------------------------
            */

            'cost_price' =>
                $product->cost_price !== null
                    ? (float) $product->cost_price
                    : null,

            'selling_price' =>
                $product->selling_price !== null
                    ? (float) $product->selling_price
                    : null,


            /*
            |--------------------------------------------------------------------------
            | Stock Behaviour
            |--------------------------------------------------------------------------
            |
            | These describe the Product.
            |
            | Actual quantity, reserved quantity and available quantity are
            | deliberately NOT included.
            |
            */

            'track_stock' =>
                (bool) $product->track_stock,

            'minimum_stock' =>
                $product->minimum_stock !== null
                    ? (float) $product->minimum_stock
                    : 0,

            'maximum_stock' =>
                $product->maximum_stock !== null
                    ? (float) $product->maximum_stock
                    : null,


            /*
            |--------------------------------------------------------------------------
            | Additional Data
            |--------------------------------------------------------------------------
            */

            'weight' =>
                $product->weight !== null
                    ? (float) $product->weight
                    : null,

            'expiry_date' =>
                $product->expiry_date
                    ? $product->expiry_date->format(
                        'Y-m-d'
                    )
                    : null,

            'status' =>
                (bool) $product->status,

            'taxable' =>
                (bool) $product->taxable,

            'dimensions' =>
                $product->dimensions,

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Category Sync UUID
    |--------------------------------------------------------------------------
    */

    private function categorySyncUuid(
        Product $product,
        int $companyId
    ): string {

        if (!$product->product_category_id) {

            throw new RuntimeException(
                "Product [{$product->sync_uuid}] does not have a category."
            );
        }


        $category =
            ProductCategory::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'id',
                    $product->product_category_id
                )
                ->first();


        if (!$category) {

            throw new RuntimeException(
                "Category for Product [{$product->sync_uuid}] could not be found."
            );
        }


        if (!$category->sync_uuid) {

            throw new RuntimeException(
                "Category [{$category->id}] does not have a synchronization UUID."
            );
        }


        return $category->sync_uuid;
    }


    /*
    |--------------------------------------------------------------------------
    | Unit Sync UUID
    |--------------------------------------------------------------------------
    */

    private function unitSyncUuid(
        Product $product,
        int $companyId
    ): ?string {

        if (!$product->unit_id) {
            return null;
        }


        $unit =
            Unit::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'id',
                    $product->unit_id
                )
                ->first();


        if (!$unit) {

            throw new RuntimeException(
                "Unit for Product [{$product->sync_uuid}] could not be found."
            );
        }


        if (!$unit->sync_uuid) {

            throw new RuntimeException(
                "Unit [{$unit->id}] does not have a synchronization UUID."
            );
        }


        return $unit->sync_uuid;
    }


    /*
    |--------------------------------------------------------------------------
    | Tax Rate Sync UUID
    |--------------------------------------------------------------------------
    */

    private function taxRateSyncUuid(
        Product $product,
        int $companyId
    ): ?string {

        if (!$product->tax_rate_id) {
            return null;
        }


        $taxRate =
            TaxRate::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'id',
                    $product->tax_rate_id
                )
                ->first();


        if (!$taxRate) {

            throw new RuntimeException(
                "Tax rate for Product [{$product->sync_uuid}] could not be found."
            );
        }


        if (!$taxRate->sync_uuid) {

            throw new RuntimeException(
                "Tax rate [{$taxRate->id}] does not have a synchronization UUID."
            );
        }


        return $taxRate->sync_uuid;
    }


    /*
    |--------------------------------------------------------------------------
    | Discount Sync UUID
    |--------------------------------------------------------------------------
    */

    private function discountSyncUuid(
        Product $product,
        int $companyId
    ): ?string {

        if (!$product->discount_id) {
            return null;
        }


        $discount =
            Discount::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'id',
                    $product->discount_id
                )
                ->first();


        if (!$discount) {

            throw new RuntimeException(
                "Discount for Product [{$product->sync_uuid}] could not be found."
            );
        }


        if (!$discount->sync_uuid) {

            throw new RuntimeException(
                "Discount [{$discount->id}] does not have a synchronization UUID."
            );
        }


        return $discount->sync_uuid;
    }
}