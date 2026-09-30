<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'product_images',
            function (Blueprint $table) {

                $table->id();


                /*
                |--------------------------------------------------------------------------
                | Company
                |--------------------------------------------------------------------------
                |
                | Kept explicitly for tenant-safe queries even though the product
                | itself also belongs to a company.
                |
                */

                $table->foreignId('company_id')
                    ->constrained('companies')
                    ->cascadeOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Product
                |--------------------------------------------------------------------------
                */

                $table->foreignId('product_id')
                    ->constrained('products')
                    ->cascadeOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Image
                |--------------------------------------------------------------------------
                |
                | Stores the relative file path in the same general manner as the
                | existing products.image column.
                |
                */

                $table->string(
                    'image',
                    500
                );


                /*
                |--------------------------------------------------------------------------
                | Primary Image
                |--------------------------------------------------------------------------
                |
                | One image can act as the product's cover image.
                |
                | The service layer will ensure only one image per product is
                | primary.
                |
                */

                $table->boolean('is_primary')
                    ->default(false);


                /*
                |--------------------------------------------------------------------------
                | Sort Order
                |--------------------------------------------------------------------------
                |
                | Controls the order images appear in the admin gallery and
                | Storefront.
                |
                */

                $table->unsignedInteger('sort_order')
                    ->default(0);


                $table->timestamps();


                /*
                |--------------------------------------------------------------------------
                | Indexes
                |--------------------------------------------------------------------------
                */

                $table->index([
                    'company_id',
                    'product_id',
                ]);

                $table->index([
                    'product_id',
                    'sort_order',
                ]);

                $table->index([
                    'product_id',
                    'is_primary',
                ]);
            }
        );
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(
            'product_images'
        );
    }
};