<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Throwable;

class ProductImageService
{
    public function __construct(
        protected BusinessProfileService $businessProfileService
    ) {
    }


    /*
    |--------------------------------------------------------------------------
    | Image Capability
    |--------------------------------------------------------------------------
    */

    public function imagesEnabled(
        Product $product
    ): bool {

        return (bool) $this->businessProfileService
            ->get(
                $this->company($product),
                'product.images.enabled',
                true
            );
    }


    public function allowsMultiple(
        Product $product
    ): bool {

        return (bool) $this->businessProfileService
            ->get(
                $this->company($product),
                'product.images.multiple',
                false
            );
    }


    public function maxImages(
        Product $product
    ): int {

        $maxImages =
            (int) $this->businessProfileService
                ->get(
                    $this->company($product),
                    'product.images.max_images',
                    1
                );


        if (!$this->allowsMultiple($product)) {
            return 1;
        }


        return max(
            1,
            $maxImages
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store Uploaded Images
    |--------------------------------------------------------------------------
    |
    | $primaryIndex refers to the position inside the NEW uploaded image list.
    |
    | Example:
    |
    | files = [front, back, box]
    | primaryIndex = 0
    |
    | "front" becomes the primary image.
    |
    */

    public function storeUploadedImages(
        Product $product,
        array $images,
        ?int $primaryIndex = null
    ): Collection {

        $images =
            collect($images)
                ->filter(
                    fn ($image) =>
                        $image instanceof UploadedFile
                        &&
                        $image->isValid()
                )
                ->values();


        if ($images->isEmpty()) {
            return collect();
        }


        if (!$this->imagesEnabled($product)) {

            throw ValidationException::withMessages([
                'images' =>
                    'Product images are not enabled for this business.',
            ]);
        }


        if (
            !$this->allowsMultiple($product)
            &&
            $images->count() > 1
        ) {

            throw ValidationException::withMessages([
                'images' =>
                    'Only one product image is allowed.',
            ]);
        }


        if (
            $primaryIndex !== null
            &&
            (
                $primaryIndex < 0
                ||
                $primaryIndex >= $images->count()
            )
        ) {

            throw ValidationException::withMessages([
                'primary_image_index' =>
                    'The selected primary image is invalid.',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Bring Legacy Cover Image Into Gallery
        |--------------------------------------------------------------------------
        |
        | Existing EMNEX products may have products.image but no product_images
        | record yet.
        |
        */

        $this->ensureLegacyPrimary(
            $product
        );


        $uploadedFilenames = [];


        try {

            return DB::transaction(
                function () use (
                    $product,
                    $images,
                    $primaryIndex,
                    &$uploadedFilenames
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | Lock Existing Gallery
                    |--------------------------------------------------------------------------
                    */

                    $existingImages =
                        ProductImage::query()
                            ->where(
                                'company_id',
                                $product->company_id
                            )
                            ->where(
                                'product_id',
                                $product->id
                            )
                            ->lockForUpdate()
                            ->orderBy(
                                'sort_order'
                            )
                            ->orderBy(
                                'id'
                            )
                            ->get();


                    $maxImages =
                        $this->maxImages(
                            $product
                        );


                    if (
                        $existingImages->count()
                        +
                        $images->count()
                        >
                        $maxImages
                    ) {

                        throw ValidationException::withMessages([
                            'images' =>
                                "A maximum of {$maxImages} product images is allowed.",
                        ]);
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Starting Sort Position
                    |--------------------------------------------------------------------------
                    */

                    $nextSortOrder =
                        $existingImages->isEmpty()
                            ? 0
                            : (
                                (int) $existingImages
                                    ->max('sort_order')
                                + 1
                            );


                    $hasPrimary =
                        $existingImages
                            ->contains(
                                fn ($image) =>
                                    (bool) $image->is_primary
                            );


                    $created =
                        collect();


                    foreach (
                        $images as
                        $index => $image
                    ) {

                        $filename =
                            $this->uploadImage(
                                $image
                            );


                        $uploadedFilenames[] =
                            $filename;


                        /*
                        |--------------------------------------------------------------------------
                        | Primary Selection
                        |--------------------------------------------------------------------------
                        |
                        | Explicit selection wins.
                        |
                        | Otherwise, if the product has no primary image yet,
                        | the first uploaded image becomes primary.
                        |
                        */

                        $makePrimary =
                            $primaryIndex !== null
                                ? $index === $primaryIndex
                                : (
                                    !$hasPrimary
                                    &&
                                    $index === 0
                                );


                        if ($makePrimary) {

                            ProductImage::query()
                                ->where(
                                    'company_id',
                                    $product->company_id
                                )
                                ->where(
                                    'product_id',
                                    $product->id
                                )
                                ->update([
                                    'is_primary' =>
                                        false,
                                ]);
                        }


                        $productImage =
                            ProductImage::create([

                                'company_id' =>
                                    $product->company_id,

                                'product_id' =>
                                    $product->id,

                                'image' =>
                                    $filename,

                                'is_primary' =>
                                    $makePrimary,

                                'sort_order' =>
                                    $nextSortOrder++,

                            ]);


                        $created->push(
                            $productImage
                        );


                        if ($makePrimary) {

                            $this->syncProductCover(
                                $product,
                                $filename
                            );

                            $hasPrimary = true;
                        }
                    }


                    return $created;
                }
            );

        } catch (Throwable $exception) {

            /*
            |--------------------------------------------------------------------------
            | Remove Files From Failed Transaction
            |--------------------------------------------------------------------------
            */

            foreach (
                $uploadedFilenames as $filename
            ) {

                $this->deletePhysicalImage(
                    $filename
                );
            }


            throw $exception;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Set Primary Image
    |--------------------------------------------------------------------------
    */

    public function setPrimary(
        Product $product,
        ProductImage $productImage
    ): ProductImage {

        $this->assertOwnership(
            $product,
            $productImage
        );


        return DB::transaction(
            function () use (
                $product,
                $productImage
            ) {

                ProductImage::query()
                    ->where(
                        'company_id',
                        $product->company_id
                    )
                    ->where(
                        'product_id',
                        $product->id
                    )
                    ->lockForUpdate()
                    ->get();


                ProductImage::query()
                    ->where(
                        'company_id',
                        $product->company_id
                    )
                    ->where(
                        'product_id',
                        $product->id
                    )
                    ->update([
                        'is_primary' =>
                            false,
                    ]);


                $productImage->update([
                    'is_primary' =>
                        true,
                ]);


                $this->syncProductCover(
                    $product,
                    $productImage->image
                );


                return $productImage->fresh();
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Image
    |--------------------------------------------------------------------------
    */

    public function delete(
        Product $product,
        ProductImage $productImage
    ): void {

        $this->assertOwnership(
            $product,
            $productImage
        );


        $filename =
            $productImage->image;


        DB::transaction(
            function () use (
                $product,
                $productImage
            ) {

                $image =
                    ProductImage::query()
                        ->where(
                            'company_id',
                            $product->company_id
                        )
                        ->where(
                            'product_id',
                            $product->id
                        )
                        ->where(
                            'id',
                            $productImage->id
                        )
                        ->lockForUpdate()
                        ->first();


                if (!$image) {
                    return;
                }


                $wasPrimary =
                    (bool) $image->is_primary;


                $image->delete();


                /*
                |--------------------------------------------------------------------------
                | Select Replacement Primary
                |--------------------------------------------------------------------------
                */

                if ($wasPrimary) {

                    $replacement =
                        ProductImage::query()
                            ->where(
                                'company_id',
                                $product->company_id
                            )
                            ->where(
                                'product_id',
                                $product->id
                            )
                            ->orderBy(
                                'sort_order'
                            )
                            ->orderBy(
                                'id'
                            )
                            ->first();


                    if ($replacement) {

                        $replacement->update([
                            'is_primary' =>
                                true,
                        ]);


                        $this->syncProductCover(
                            $product,
                            $replacement->image
                        );

                    } else {

                        $this->syncProductCover(
                            $product,
                            null
                        );
                    }
                }
            }
        );


        /*
        |--------------------------------------------------------------------------
        | Delete Physical File After Successful DB Commit
        |--------------------------------------------------------------------------
        */

        $this->deletePhysicalImage(
            $filename
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Reorder Gallery
    |--------------------------------------------------------------------------
    |
    | Expects all image IDs in the desired order.
    |
    */

    public function reorder(
        Product $product,
        array $imageIds
    ): void {

        $imageIds =
            array_values(
                array_unique(
                    array_map(
                        'intval',
                        $imageIds
                    )
                )
            );


        DB::transaction(
            function () use (
                $product,
                $imageIds
            ) {

                $images =
                    ProductImage::query()
                        ->where(
                            'company_id',
                            $product->company_id
                        )
                        ->where(
                            'product_id',
                            $product->id
                        )
                        ->lockForUpdate()
                        ->get();


                $existingIds =
                    $images
                        ->pluck('id')
                        ->map(
                            fn ($id) =>
                                (int) $id
                        )
                        ->sort()
                        ->values()
                        ->all();


                $submittedIds =
                    collect($imageIds)
                        ->sort()
                        ->values()
                        ->all();


                if (
                    $existingIds !==
                    $submittedIds
                ) {

                    throw ValidationException::withMessages([
                        'images' =>
                            'The product image order is invalid.',
                    ]);
                }


                foreach (
                    $imageIds as
                    $sortOrder => $imageId
                ) {

                    ProductImage::query()
                        ->where(
                            'company_id',
                            $product->company_id
                        )
                        ->where(
                            'product_id',
                            $product->id
                        )
                        ->where(
                            'id',
                            $imageId
                        )
                        ->update([
                            'sort_order' =>
                                $sortOrder,
                        ]);
                }
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Legacy Product Image
    |--------------------------------------------------------------------------
    |
    | Existing products already have products.image.
    |
    | The first time the new gallery touches such a product, this creates
    | the matching primary gallery record without copying the physical file.
    |
    */

    public function ensureLegacyPrimary(
        Product $product
    ): ?ProductImage {

        if (!$product->image) {
            return null;
        }


        return DB::transaction(
            function () use ($product) {

                $existing =
                    ProductImage::query()
                        ->where(
                            'company_id',
                            $product->company_id
                        )
                        ->where(
                            'product_id',
                            $product->id
                        )
                        ->lockForUpdate()
                        ->orderBy(
                            'sort_order'
                        )
                        ->orderBy(
                            'id'
                        )
                        ->get();


                if ($existing->isNotEmpty()) {

                    $primary =
                        $existing->firstWhere(
                            'is_primary',
                            true
                        );


                    return $primary
                        ?? $existing->first();
                }


                return ProductImage::create([

                    'company_id' =>
                        $product->company_id,

                    'product_id' =>
                        $product->id,

                    'image' =>
                        $product->image,

                    'is_primary' =>
                        true,

                    'sort_order' =>
                        0,

                ]);
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Synchronize Legacy Cover Column
    |--------------------------------------------------------------------------
    */

    protected function syncProductCover(
        Product $product,
        ?string $filename
    ): void {

        $product->image =
            $filename;

        $product->save();
    }


    /*
    |--------------------------------------------------------------------------
    | Upload Physical Image
    |--------------------------------------------------------------------------
    */

    protected function uploadImage(
        UploadedFile $image
    ): string {

        $directory =
            public_path(
                'uploads/products'
            );


        if (!is_dir($directory)) {

            mkdir(
                $directory,
                0755,
                true
            );
        }


        $filename =
            time()
            . '_'
            . uniqid()
            . '.'
            . $image
                ->getClientOriginalExtension();


        $image->move(
            $directory,
            $filename
        );


        return $filename;
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Physical Image
    |--------------------------------------------------------------------------
    */

    protected function deletePhysicalImage(
        ?string $filename
    ): void {

        if (!$filename) {
            return;
        }


        $path =
            public_path(
                'uploads/products/'
                . $filename
            );


        if (!file_exists($path)) {
            return;
        }


        unlink(
            $path
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Ownership
    |--------------------------------------------------------------------------
    */

    protected function assertOwnership(
        Product $product,
        ProductImage $productImage
    ): void {

        if (
            $productImage->company_id
                !== $product->company_id
            ||
            $productImage->product_id
                !== $product->id
        ) {

            throw ValidationException::withMessages([
                'image' =>
                    'The selected product image is invalid.',
            ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Company
    |--------------------------------------------------------------------------
    */

    protected function company(
        Product $product
    ): Company {

        $company =
            $product->relationLoaded('company')
                ? $product->company
                : $product
                    ->company()
                    ->first();


        if (!$company) {

            throw new RuntimeException(
                'The product company could not be resolved.'
            );
        }


        return $company;
    }

    /*
    |--------------------------------------------------------------------------
    | Replace Single Image
    |--------------------------------------------------------------------------
    |
    | Used by profiles that only allow one product image.
    |
    | The new image is uploaded first. The database is then updated, and old
    | physical files are deleted only after the database operation succeeds.
    |
    */

    public function replaceSingleImage(
        Product $product,
        UploadedFile $image
    ): ProductImage {

        if (!$this->imagesEnabled($product)) {

            throw ValidationException::withMessages([
                'image' =>
                    'Product images are not enabled for this business.',
            ]);
        }


        $this->ensureLegacyPrimary(
            $product
        );


        $newFilename =
            $this->uploadImage(
                $image
            );


        $oldFilenames = [];


        try {

            $productImage =
                DB::transaction(
                    function () use (
                        $product,
                        $newFilename,
                        &$oldFilenames
                    ) {

                        $existingImages =
                            ProductImage::query()
                                ->where(
                                    'company_id',
                                    $product->company_id
                                )
                                ->where(
                                    'product_id',
                                    $product->id
                                )
                                ->lockForUpdate()
                                ->get();


                        $oldFilenames =
                            $existingImages
                                ->pluck('image')
                                ->filter()
                                ->unique()
                                ->values()
                                ->all();


                        ProductImage::query()
                            ->where(
                                'company_id',
                                $product->company_id
                            )
                            ->where(
                                'product_id',
                                $product->id
                            )
                            ->delete();


                        $productImage =
                            ProductImage::create([

                                'company_id' =>
                                    $product->company_id,

                                'product_id' =>
                                    $product->id,

                                'image' =>
                                    $newFilename,

                                'is_primary' =>
                                    true,

                                'sort_order' =>
                                    0,

                            ]);


                        $this->syncProductCover(
                            $product,
                            $newFilename
                        );


                        return $productImage;
                    }
                );

        } catch (Throwable $exception) {

            $this->deletePhysicalImage(
                $newFilename
            );

            throw $exception;
        }


        foreach (
            $oldFilenames as $oldFilename
        ) {

            if (
                $oldFilename !==
                $newFilename
            ) {

                $this->deletePhysicalImage(
                    $oldFilename
                );
            }
        }


        return $productImage;
    }
}