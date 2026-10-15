<?php

namespace App\Services\Sync\Handlers;

use App\Contracts\Sync\SyncHandler;
use App\Models\Branch;
use App\Models\Discount;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductStock;
use App\Models\SyncDevice;
use App\Models\TaxRate;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;
use RuntimeException;


class ProductSyncHandler implements SyncHandler
{
    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create(
        string $syncUuid,
        array $payload,
        SyncDevice $device
    ): array {

        $companyId =
            (int) $device->company_id;


        /*
        |--------------------------------------------------------------------------
        | Validate Payload
        |--------------------------------------------------------------------------
        */

        $this->validatePayload(
            $payload,
            true
        );


        /*
        |--------------------------------------------------------------------------
        | Find Existing Sync Entity
        |--------------------------------------------------------------------------
        |
        | sync_uuid is authoritative.
        |
        | A repeated create with a different mutation UUID must never create
        | another Product.
        |
        */

        $product =
            Product::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'sync_uuid',
                    $syncUuid
                )
                ->first();


        /*
        |--------------------------------------------------------------------------
        | Prepare Product Data
        |--------------------------------------------------------------------------
        */

        $data =
            $this->prepareData(
                $payload,
                $companyId,
                $product,
                true
            );


        /*
        |--------------------------------------------------------------------------
        | Business Identifier Conflicts
        |--------------------------------------------------------------------------
        */

        $this->ensureNoIdentifierConflict(
            $data,
            $companyId,
            $product
        );


        /*
        |--------------------------------------------------------------------------
        | Existing Entity
        |--------------------------------------------------------------------------
        */

        if ($product) {

            $restored =
                $product->trashed();


            if ($restored) {
                $product->restore();
            }


            $product->fill(
                $data
            );

            $product->company_id =
                $companyId;

            $product->save();


            /*
            |--------------------------------------------------------------------------
            | Product Stock State
            |--------------------------------------------------------------------------
            */

            $this->syncProductStockState(
                $product,
                $companyId
            );


            $product->refresh();


            return [

                'entity' =>
                    'product',

                'sync_uuid' =>
                    $product->sync_uuid,

                'action' =>
                    $restored
                        ? 'restored'
                        : 'updated',

            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Create Product
        |--------------------------------------------------------------------------
        */

        $product =
            new Product();


        /*
        |--------------------------------------------------------------------------
        | Preserve Incoming Sync Identity
        |--------------------------------------------------------------------------
        |
        | sync_uuid is deliberately not fillable.
        |
        */

        $product->sync_uuid =
            $syncUuid;


        $product->fill(
            $data
        );


        /*
        |--------------------------------------------------------------------------
        | Company Comes From Authenticated Device
        |--------------------------------------------------------------------------
        */

        $product->company_id =
            $companyId;


        $product->save();


        /*
        |--------------------------------------------------------------------------
        | Product Stock State
        |--------------------------------------------------------------------------
        */

        $this->syncProductStockState(
            $product,
            $companyId
        );


        $product->refresh();


        return [

            'entity' =>
                'product',

            'sync_uuid' =>
                $product->sync_uuid,

            'action' =>
                'created',

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        string $syncUuid,
        array $payload,
        SyncDevice $device
    ): array {

        $companyId =
            (int) $device->company_id;


        /*
        |--------------------------------------------------------------------------
        | Validate Payload
        |--------------------------------------------------------------------------
        */

        $this->validatePayload(
            $payload,
            false
        );


        /*
        |--------------------------------------------------------------------------
        | Find Product
        |--------------------------------------------------------------------------
        */

        $product =
            Product::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'sync_uuid',
                    $syncUuid
                )
                ->first();


        if (!$product) {

            throw new RuntimeException(
                "Product [{$syncUuid}] does not exist for this company."
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Deleted Product Protection
        |--------------------------------------------------------------------------
        |
        | An update must not silently resurrect a Product.
        |
        | A proper create/restore mutation must do that.
        |
        */

        if ($product->trashed()) {

            throw new RuntimeException(
                "Product [{$syncUuid}] is deleted and cannot be updated."
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Prepare Product Data
        |--------------------------------------------------------------------------
        */

        $data =
            $this->prepareData(
                $payload,
                $companyId,
                $product,
                false
            );


        /*
        |--------------------------------------------------------------------------
        | Business Identifier Conflicts
        |--------------------------------------------------------------------------
        */

        $this->ensureNoIdentifierConflict(
            $data,
            $companyId,
            $product
        );


        /*
        |--------------------------------------------------------------------------
        | Update Product
        |--------------------------------------------------------------------------
        */

        $product->fill(
            $data
        );


        /*
        |--------------------------------------------------------------------------
        | Never Trust Payload Company
        |--------------------------------------------------------------------------
        */

        $product->company_id =
            $companyId;


        $product->save();


        /*
        |--------------------------------------------------------------------------
        | Synchronize Stock Structure / Limits
        |--------------------------------------------------------------------------
        |
        | This does NOT synchronize quantities.
        |
        */

        $this->syncProductStockState(
            $product,
            $companyId
        );


        $product->refresh();


        return [

            'entity' =>
                'product',

            'sync_uuid' =>
                $product->sync_uuid,

            'action' =>
                'updated',

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function delete(
        string $syncUuid,
        array $payload,
        SyncDevice $device
    ): array {

        $companyId =
            (int) $device->company_id;


        /*
        |--------------------------------------------------------------------------
        | Find Product
        |--------------------------------------------------------------------------
        */

        $product =
            Product::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'sync_uuid',
                    $syncUuid
                )
                ->first();


        /*
        |--------------------------------------------------------------------------
        | Already Missing
        |--------------------------------------------------------------------------
        |
        | Entity-level delete is safely idempotent.
        |
        */

        if (!$product) {

            return [

                'entity' =>
                    'product',

                'sync_uuid' =>
                    $syncUuid,

                'action' =>
                    'already_missing',

            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Already Deleted
        |--------------------------------------------------------------------------
        */

        if ($product->trashed()) {

            return [

                'entity' =>
                    'product',

                'sync_uuid' =>
                    $syncUuid,

                'action' =>
                    'already_deleted',

            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Protect Sales History
        |--------------------------------------------------------------------------
        |
        | Match the existing Product business rule.
        |
        */

        if (
            $product
                ->orderItems()
                ->exists()
        ) {

            throw new RuntimeException(
                'This product has sales history and cannot be deleted.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Soft Delete
        |--------------------------------------------------------------------------
        */

        $product->delete();


        return [

            'entity' =>
                'product',

            'sync_uuid' =>
                $syncUuid,

            'action' =>
                'deleted',

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Validate Payload
    |--------------------------------------------------------------------------
    */

    private function validatePayload(
        array $payload,
        bool $creating
    ): void {

        $required =
            $creating
                ? 'required'
                : 'sometimes';


        Validator::make(
            $payload,
            [

                /*
                |--------------------------------------------------------------------------
                | Synchronizable Relationships
                |--------------------------------------------------------------------------
                */

                'product_category_sync_uuid' => [
                    $required,
                    'uuid',
                ],

                'unit_sync_uuid' => [
                    'sometimes',
                    'nullable',
                    'uuid',
                ],

                'tax_rate_sync_uuid' => [
                    'sometimes',
                    'nullable',
                    'uuid',
                ],

                'discount_sync_uuid' => [
                    'sometimes',
                    'nullable',
                    'uuid',
                ],


                /*
                |--------------------------------------------------------------------------
                | Product Identity
                |--------------------------------------------------------------------------
                */

                'product_code' => [
                    $required,
                    'string',
                    'max:50',
                ],

                'sku' => [
                    'sometimes',
                    'nullable',
                    'string',
                    'max:100',
                ],

                'barcode' => [
                    'sometimes',
                    'nullable',
                    'string',
                    'max:100',
                ],

                'qr_code' => [
                    'sometimes',
                    'nullable',
                    'string',
                    'max:100',
                ],


                /*
                |--------------------------------------------------------------------------
                | Product Data
                |--------------------------------------------------------------------------
                */

                'name' => [
                    $required,
                    'string',
                    'max:255',
                ],

                'description' => [
                    'sometimes',
                    'nullable',
                    'string',
                ],

                'brand' => [
                    'sometimes',
                    'nullable',
                    'string',
                    'max:150',
                ],

                'manufacturer' => [
                    'sometimes',
                    'nullable',
                    'string',
                    'max:150',
                ],


                /*
                |--------------------------------------------------------------------------
                | Pricing
                |--------------------------------------------------------------------------
                */

                'cost_price' => [
                    'sometimes',
                    'nullable',
                    'numeric',
                    'min:0',
                ],

                'selling_price' => [
                    'sometimes',
                    'nullable',
                    'numeric',
                    'min:0',
                ],


                /*
                |--------------------------------------------------------------------------
                | Stock Behaviour
                |--------------------------------------------------------------------------
                */

                'track_stock' => [
                    $required,
                    'boolean',
                ],

                'minimum_stock' => [
                    'sometimes',
                    'nullable',
                    'numeric',
                    'min:0',
                ],

                'maximum_stock' => [
                    'sometimes',
                    'nullable',
                    'numeric',
                    'min:0',
                ],


                /*
                |--------------------------------------------------------------------------
                | Additional Product Data
                |--------------------------------------------------------------------------
                */

                'weight' => [
                    'sometimes',
                    'nullable',
                    'numeric',
                    'min:0',
                ],

                'expiry_date' => [
                    'sometimes',
                    'nullable',
                    'date',
                ],

                'status' => [
                    $required,
                    'boolean',
                ],

                'dimensions' => [
                    'sometimes',
                    'nullable',
                    'string',
                    'max:255',
                ],

                'taxable' => [
                    'sometimes',
                    'boolean',
                ],

            ]
        )->validate();
    }


    /*
    |--------------------------------------------------------------------------
    | Prepare Product Data
    |--------------------------------------------------------------------------
    */

    private function prepareData(
        array $payload,
        int $companyId,
        ?Product $product,
        bool $creating
    ): array {

        $data = [];


        /*
        |--------------------------------------------------------------------------
        | Category
        |--------------------------------------------------------------------------
        */

        if (
            $creating
            ||
            array_key_exists(
                'product_category_sync_uuid',
                $payload
            )
        ) {

            $data['product_category_id'] =
                $this->resolveCategory(
                    $payload[
                        'product_category_sync_uuid'
                    ],
                    $companyId
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Unit
        |--------------------------------------------------------------------------
        */

        if (
            array_key_exists(
                'unit_sync_uuid',
                $payload
            )
        ) {

            $data['unit_id'] =
                $payload['unit_sync_uuid']
                    ? $this->resolveUnit(
                        $payload[
                            'unit_sync_uuid'
                        ],
                        $companyId
                    )
                    : null;
        }


        /*
        |--------------------------------------------------------------------------
        | Tax Rate
        |--------------------------------------------------------------------------
        */

        if (
            array_key_exists(
                'tax_rate_sync_uuid',
                $payload
            )
        ) {

            $data['tax_rate_id'] =
                $payload['tax_rate_sync_uuid']
                    ? $this->resolveTaxRate(
                        $payload[
                            'tax_rate_sync_uuid'
                        ],
                        $companyId
                    )
                    : null;
        }


        /*
        |--------------------------------------------------------------------------
        | Discount
        |--------------------------------------------------------------------------
        */

        if (
            array_key_exists(
                'discount_sync_uuid',
                $payload
            )
        ) {

            $data['discount_id'] =
                $payload['discount_sync_uuid']
                    ? $this->resolveDiscount(
                        $payload[
                            'discount_sync_uuid'
                        ],
                        $companyId
                    )
                    : null;
        }


        /*
        |--------------------------------------------------------------------------
        | Allowed Product Fields
        |--------------------------------------------------------------------------
        |
        | Deliberately excluded:
        |
        | company_id
        | sync_uuid
        | numeric relationship IDs
        | image / images
        | opening_stock
        | quantity / reserved / available stock
        |
        */

        $fields = [

            'product_code',

            'sku',

            'barcode',

            'qr_code',

            'name',

            'description',

            'brand',

            'manufacturer',

            'cost_price',

            'selling_price',

            'track_stock',

            'minimum_stock',

            'maximum_stock',

            'weight',

            'expiry_date',

            'status',

            'dimensions',

            'taxable',

        ];


        foreach ($fields as $field) {

            if (
                array_key_exists(
                    $field,
                    $payload
                )
            ) {

                $data[$field] =
                    $payload[$field];
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Normalize Strings
        |--------------------------------------------------------------------------
        */

        foreach (
            [
                'product_code',
                'sku',
                'barcode',
                'qr_code',
                'name',
                'brand',
                'manufacturer',
                'dimensions',
            ]
            as $field
        ) {

            if (
                array_key_exists(
                    $field,
                    $data
                )
                &&
                $data[$field] !== null
            ) {

                $data[$field] =
                    trim(
                        (string) $data[$field]
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Minimum Stock
        |--------------------------------------------------------------------------
        |
        | Existing products table expects minimum_stock to behave as zero when
        | no threshold is supplied.
        |
        */

        if (
            $creating
            &&
            !array_key_exists(
                'minimum_stock',
                $data
            )
        ) {

            $data['minimum_stock'] =
                0;
        }


        if (
            array_key_exists(
                'minimum_stock',
                $data
            )
            &&
            $data['minimum_stock'] === null
        ) {

            $data['minimum_stock'] =
                0;
        }


        /*
        |--------------------------------------------------------------------------
        | Validate Stock Limits
        |--------------------------------------------------------------------------
        */

        $minimumStock =
            array_key_exists(
                'minimum_stock',
                $data
            )
                ? (float) $data['minimum_stock']
                : (float) (
                    $product?->minimum_stock
                    ?? 0
                );


        $maximumStock =
            array_key_exists(
                'maximum_stock',
                $data
            )
                ? (
                    $data['maximum_stock']
                    !== null
                        ? (float)
                            $data['maximum_stock']
                        : null
                )
                : (
                    $product?->maximum_stock
                    !== null
                        ? (float)
                            $product->maximum_stock
                        : null
                );


        if (
            $maximumStock !== null
            &&
            $maximumStock <
                $minimumStock
        ) {

            throw new RuntimeException(
                'Maximum stock must be greater than or equal to minimum stock.'
            );
        }


        return $data;
    }


    /*
    |--------------------------------------------------------------------------
    | Resolve Product Category
    |--------------------------------------------------------------------------
    */

    private function resolveCategory(
        string $syncUuid,
        int $companyId
    ): int {

        $category =
            ProductCategory::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'sync_uuid',
                    $syncUuid
                )
                ->first();

        if (!$category) {

            throw new RuntimeException(
                "Product category [{$syncUuid}] has not been synchronized yet."
            );
        }

        if ($category->trashed()) {

            throw new RuntimeException(
                "Product category [{$syncUuid}] is deleted and cannot be assigned to a Product."
            );
        }

        return (int) $category->id;
    }


    /*
    |--------------------------------------------------------------------------
    | Resolve Unit
    |--------------------------------------------------------------------------
    */

    private function resolveUnit(
        string $syncUuid,
        int $companyId
    ): int {

        $unit =
            Unit::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'sync_uuid',
                    $syncUuid
                )
                ->first();

        if (!$unit) {

            throw new RuntimeException(
                "Unit [{$syncUuid}] has not been synchronized yet."
            );
        }

        if ($unit->trashed()) {

            throw new RuntimeException(
                "Unit [{$syncUuid}] is deleted and cannot be assigned to a Product."
            );
        }

        return (int) $unit->id;
    }

    /*
    |--------------------------------------------------------------------------
    | Resolve Tax Rate
    |--------------------------------------------------------------------------
    */

    private function resolveTaxRate(
        string $syncUuid,
        int $companyId
    ): int {

        $taxRate =
            TaxRate::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'sync_uuid',
                    $syncUuid
                )
                ->first();

        if (!$taxRate) {

            throw new RuntimeException(
                "Tax rate [{$syncUuid}] has not been synchronized yet."
            );
        }

        if ($taxRate->trashed()) {

            throw new RuntimeException(
                "Tax rate [{$syncUuid}] is deleted and cannot be assigned to a Product."
            );
        }

        return (int) $taxRate->id;
    }

    /*
    |--------------------------------------------------------------------------
    | Resolve Discount
    |--------------------------------------------------------------------------
    */

    private function resolveDiscount(
        string $syncUuid,
        int $companyId
    ): int {

        $discount =
            Discount::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'sync_uuid',
                    $syncUuid
                )
                ->first();

        if (!$discount) {

            throw new RuntimeException(
                "Discount [{$syncUuid}] has not been synchronized yet."
            );
        }

        if ($discount->trashed()) {

            throw new RuntimeException(
                "Discount [{$syncUuid}] is deleted and cannot be assigned to a Product."
            );
        }

        return (int) $discount->id;
    }


    /*
    |--------------------------------------------------------------------------
    | Business Identifier Conflict Check
    |--------------------------------------------------------------------------
    */

    private function ensureNoIdentifierConflict(
        array $data,
        int $companyId,
        ?Product $currentProduct = null
    ): void {

        $productCode =
            $data['product_code']
            ?? $currentProduct?->product_code;


        $sku =
            array_key_exists(
                'sku',
                $data
            )
                ? $data['sku']
                : $currentProduct?->sku;


        $barcode =
            array_key_exists(
                'barcode',
                $data
            )
                ? $data['barcode']
                : $currentProduct?->barcode;


        $query =
            Product::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                );


        if ($currentProduct) {

            $query->where(
                'id',
                '!=',
                $currentProduct->id
            );
        }


        $query->where(
            function ($query) use (
                $productCode,
                $sku,
                $barcode
            ) {

                if ($productCode) {

                    $query->where(
                        'product_code',
                        $productCode
                    );
                }


                if ($sku) {

                    $query->orWhere(
                        'sku',
                        $sku
                    );
                }


                if ($barcode) {

                    $query->orWhere(
                        'barcode',
                        $barcode
                    );
                }
            }
        );


        $conflict =
            $query->first();


        if (!$conflict) {
            return;
        }


        throw new RuntimeException(
            'Product synchronization conflict: another Product with a different sync_uuid already uses the same Product Code, SKU or Barcode.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Synchronize Product Stock State
    |--------------------------------------------------------------------------
    |
    | Product synchronization manages:
    |
    | - whether the Product tracks stock
    | - Head Office ProductStock existence
    | - minimum/reorder limits
    | - maximum stock limit
    |
    | Product synchronization DOES NOT synchronize quantities.
    |
    */

    private function syncProductStockState(
        Product $product,
        int $companyId
    ): void {

        /*
        |--------------------------------------------------------------------------
        | Non-Stock Product
        |--------------------------------------------------------------------------
        */

        if (!$product->tracksStock()) {

            /*
            |--------------------------------------------------------------------------
            | Protect Existing Inventory
            |--------------------------------------------------------------------------
            */

            $hasInventory =
                ProductStock::query()

                    ->where(
                        'company_id',
                        $companyId
                    )

                    ->where(
                        'product_id',
                        $product->id
                    )

                    ->where(
                        function ($query) {

                            $query

                                ->where(
                                    'quantity',
                                    '!=',
                                    0
                                )

                                ->orWhere(
                                    'reserved_quantity',
                                    '!=',
                                    0
                                )

                                ->orWhere(
                                    'available_quantity',
                                    '!=',
                                    0
                                );
                        }
                    )

                    ->exists();


            if ($hasInventory) {

                throw new RuntimeException(
                    'Stock tracking cannot be disabled while this product still has inventory.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Remove Empty Current Stock State
            |--------------------------------------------------------------------------
            */

            ProductStock::query()

                ->where(
                    'company_id',
                    $companyId
                )

                ->where(
                    'product_id',
                    $product->id
                )

                ->delete();


            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Head Office
        |--------------------------------------------------------------------------
        */

        $headOffice =
            Branch::query()

                ->where(
                    'company_id',
                    $companyId
                )

                ->headOffice()

                ->first();


        if (!$headOffice) {

            throw new RuntimeException(
                'No Head Office branch has been configured for this company.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Head Office Stock State
        |--------------------------------------------------------------------------
        */

        $headOfficeStock =
            ProductStock::firstOrNew([

                'company_id' =>
                    $companyId,

                'branch_id' =>
                    $headOffice->id,

                'product_id' =>
                    $product->id,

            ]);


        /*
        |--------------------------------------------------------------------------
        | New Stock State Starts At Zero
        |--------------------------------------------------------------------------
        |
        | Actual quantities belong to the Stock synchronization module.
        |
        */

        if (!$headOfficeStock->exists) {

            $headOfficeStock->quantity =
                0;

            $headOfficeStock->reserved_quantity =
                0;

            $headOfficeStock->available_quantity =
                0;
        }


        /*
        |--------------------------------------------------------------------------
        | Product Stock Limits
        |--------------------------------------------------------------------------
        */

        $headOfficeStock->reorder_level =
            $product->minimum_stock
            ?? 0;


        $headOfficeStock->maximum_stock =
            $product->maximum_stock;


        $headOfficeStock->save();


        /*
        |--------------------------------------------------------------------------
        | Synchronize Limits Across Existing Branch Stock Rows
        |--------------------------------------------------------------------------
        |
        | Never change branch quantities here.
        |
        */

        ProductStock::query()

            ->where(
                'company_id',
                $companyId
            )

            ->where(
                'product_id',
                $product->id
            )

            ->update([

                'reorder_level' =>
                    $product->minimum_stock
                    ?? 0,

                'maximum_stock' =>
                    $product->maximum_stock,

            ]);
    }
}