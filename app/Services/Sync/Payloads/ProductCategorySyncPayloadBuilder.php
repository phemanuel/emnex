<?php

namespace App\Services\Sync\Payloads;

use App\Models\ProductCategory;
use RuntimeException;

class ProductCategorySyncPayloadBuilder
{
    public function build(
        ProductCategory $category
    ): array {

        if (!$category->sync_uuid) {
            throw new RuntimeException(
                "Product category [{$category->id}] does not have a synchronization UUID."
            );
        }

        $parentSyncUuid =
            $this->parentSyncUuid(
                $category
            );

        return [
            'category_code' =>
                $category->category_code,

            'name' =>
                $category->name,

            'description' =>
                $category->description,

            'parent_sync_uuid' =>
                $parentSyncUuid,

            'sort_order' =>
                (int) ($category->sort_order ?? 0),

            'status' =>
                (bool) $category->status,
        ];
    }


    private function parentSyncUuid(
        ProductCategory $category
    ): ?string {

        if (!$category->parent_id) {
            return null;
        }

        $parent = ProductCategory::withTrashed()
            ->where(
                'company_id',
                $category->company_id
            )
            ->where(
                'id',
                $category->parent_id
            )
            ->first();

        if (!$parent) {
            throw new RuntimeException(
                "Parent category for Product Category [{$category->sync_uuid}] could not be found."
            );
        }

        if (!$parent->sync_uuid) {
            throw new RuntimeException(
                "Parent Product Category [{$parent->id}] does not have a synchronization UUID."
            );
        }

        return $parent->sync_uuid;
    }
}