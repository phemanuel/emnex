<?php

namespace App\Services\Sync\Handlers;

use App\Contracts\Sync\SyncHandler;
use App\Models\ProductCategory;
use App\Models\SyncDevice;
use Illuminate\Support\Facades\Validator;
use RuntimeException;

class ProductCategorySyncHandler implements SyncHandler
{
    public function create(
        string $syncUuid,
        array $payload,
        SyncDevice $device
    ): array {

        $data = $this->validatePayload(
            $payload,
            false
        );

        $category = ProductCategory::withTrashed()
            ->where('company_id', $device->company_id)
            ->where('sync_uuid', $syncUuid)
            ->first();

        $this->ensureIdentifiersAvailable(
            companyId: $device->company_id,
            categoryCode: $data['category_code'],
            name: $data['name'],
            ignoreId: $category?->id
        );

        $parentId = $this->resolveParentId(
            companyId: $device->company_id,
            parentSyncUuid: $data['parent_sync_uuid'] ?? null,
            currentSyncUuid: $syncUuid
        );

        /*
        |--------------------------------------------------------------------------
        | Same Synchronization Identity
        |--------------------------------------------------------------------------
        */

        if ($category) {

            $wasTrashed =
                $category->trashed();

            if ($wasTrashed) {
                $category->restore();
            }

            $category->fill(
                $this->prepareData($data)
            );

            $category->company_id =
                $device->company_id;

            $category->parent_id =
                $parentId;

            $category->save();

            return [
                'entity' => 'product_category',
                'sync_uuid' => $category->sync_uuid,
                'action' => $wasTrashed
                    ? 'restored'
                    : 'updated',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Create
        |--------------------------------------------------------------------------
        */

        $category = new ProductCategory();

        $category->sync_uuid =
            $syncUuid;

        $category->company_id =
            $device->company_id;

        $category->parent_id =
            $parentId;

        $category->fill(
            $this->prepareData($data)
        );

        if (!array_key_exists('sort_order', $data)) {
            $category->sort_order = 0;
        }

        $category->save();

        return [
            'entity' => 'product_category',
            'sync_uuid' => $category->sync_uuid,
            'action' => 'created',
        ];
    }


    public function update(
        string $syncUuid,
        array $payload,
        SyncDevice $device
    ): array {

        $category = ProductCategory::withTrashed()
            ->where('company_id', $device->company_id)
            ->where('sync_uuid', $syncUuid)
            ->first();

        if (!$category) {
            throw new RuntimeException(
                "Product category [{$syncUuid}] could not be found."
            );
        }

        if ($category->trashed()) {
            throw new RuntimeException(
                "Product category [{$syncUuid}] is deleted and cannot be updated."
            );
        }

        $data = $this->validatePayload(
            $payload,
            true
        );

        /*
        |--------------------------------------------------------------------------
        | Business Identifier Conflicts
        |--------------------------------------------------------------------------
        */

        $categoryCode =
            array_key_exists('category_code', $data)
                ? $data['category_code']
                : $category->category_code;

        $name =
            array_key_exists('name', $data)
                ? $data['name']
                : $category->name;

        $this->ensureIdentifiersAvailable(
            companyId: $device->company_id,
            categoryCode: $categoryCode,
            name: $name,
            ignoreId: $category->id
        );

        /*
        |--------------------------------------------------------------------------
        | Parent
        |--------------------------------------------------------------------------
        */

        if (
            array_key_exists(
                'parent_sync_uuid',
                $data
            )
        ) {

            $category->parent_id =
                $this->resolveParentId(
                    companyId: $device->company_id,
                    parentSyncUuid: $data['parent_sync_uuid'],
                    currentSyncUuid: $syncUuid
                );
        }

        $category->fill(
            $this->prepareData($data)
        );

        $category->company_id =
            $device->company_id;

        $category->save();

        return [
            'entity' => 'product_category',
            'sync_uuid' => $category->sync_uuid,
            'action' => 'updated',
        ];
    }


    public function delete(
        string $syncUuid,
        array $payload,
        SyncDevice $device
    ): array {

        $category = ProductCategory::withTrashed()
            ->where('company_id', $device->company_id)
            ->where('sync_uuid', $syncUuid)
            ->first();

        if (!$category) {

            return [
                'entity' => 'product_category',
                'sync_uuid' => $syncUuid,
                'action' => 'already_missing',
            ];
        }

        if ($category->trashed()) {

            return [
                'entity' => 'product_category',
                'sync_uuid' => $category->sync_uuid,
                'action' => 'already_deleted',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Existing Category Behaviour
        |--------------------------------------------------------------------------
        |
        | ProductCategoryController currently soft-deletes categories without
        | introducing an extra product/child restriction here.
        |
        */

        $category->delete();

        return [
            'entity' => 'product_category',
            'sync_uuid' => $category->sync_uuid,
            'action' => 'deleted',
        ];
    }


    private function validatePayload(
        array $payload,
        bool $partial
    ): array {

        $required =
            $partial
                ? 'sometimes'
                : 'required';

        return Validator::make(
            $payload,
            [
                'category_code' => [
                    $required,
                    'string',
                    'max:255',
                ],

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

                'parent_sync_uuid' => [
                    'sometimes',
                    'nullable',
                    'uuid',
                ],

                'sort_order' => [
                    'sometimes',
                    'nullable',
                    'integer',
                    'min:0',
                ],

                'status' => [
                    $required,
                    'boolean',
                ],
            ]
        )->validate();
    }


    private function prepareData(
        array $data
    ): array {

        $prepared = [];

        if (array_key_exists('category_code', $data)) {

            $prepared['category_code'] =
                trim($data['category_code']);
        }

        if (array_key_exists('name', $data)) {

            $prepared['name'] =
                trim($data['name']);
        }

        if (array_key_exists('description', $data)) {

            $prepared['description'] =
                $data['description'];
        }

        if (array_key_exists('sort_order', $data)) {

            $prepared['sort_order'] =
                $data['sort_order'] ?? 0;
        }

        if (array_key_exists('status', $data)) {

            $prepared['status'] =
                (bool) $data['status'];
        }

        /*
        |--------------------------------------------------------------------------
        | parent_sync_uuid Is Not A Database Column
        |--------------------------------------------------------------------------
        */

        return $prepared;
    }


    private function resolveParentId(
        int $companyId,
        ?string $parentSyncUuid,
        string $currentSyncUuid
    ): ?int {

        if (!$parentSyncUuid) {
            return null;
        }

        if ($parentSyncUuid === $currentSyncUuid) {

            throw new RuntimeException(
                'A product category cannot be its own parent.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | withTrashed Allows Better Dependency Errors
        |--------------------------------------------------------------------------
        */

        $parent = ProductCategory::withTrashed()
            ->where('company_id', $companyId)
            ->where('sync_uuid', $parentSyncUuid)
            ->first();

        if (!$parent) {

            throw new RuntimeException(
                "Parent product category [{$parentSyncUuid}] could not be found."
            );
        }

        if ($parent->trashed()) {

            throw new RuntimeException(
                "Parent product category [{$parentSyncUuid}] is deleted and cannot be used."
            );
        }

        return $parent->id;
    }


    private function ensureIdentifiersAvailable(
        int $companyId,
        string $categoryCode,
        string $name,
        ?int $ignoreId = null
    ): void {

        $categoryCode =
            trim($categoryCode);

        $name =
            trim($name);

        /*
        |--------------------------------------------------------------------------
        | Category Code
        |--------------------------------------------------------------------------
        */

        $codeQuery = ProductCategory::withTrashed()
            ->where('company_id', $companyId)
            ->where('category_code', $categoryCode);

        if ($ignoreId !== null) {

            $codeQuery->where(
                'id',
                '!=',
                $ignoreId
            );
        }

        if ($codeQuery->exists()) {

            throw new RuntimeException(
                "Category code [{$categoryCode}] already belongs to another Product Category."
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Category Name
        |--------------------------------------------------------------------------
        */

        $nameQuery = ProductCategory::withTrashed()
            ->where('company_id', $companyId)
            ->where('name', $name);

        if ($ignoreId !== null) {

            $nameQuery->where(
                'id',
                '!=',
                $ignoreId
            );
        }

        if ($nameQuery->exists()) {

            throw new RuntimeException(
                "Category name [{$name}] already belongs to another Product Category."
            );
        }
    }
}