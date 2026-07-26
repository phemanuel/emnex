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
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            $table->foreignId('company_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('product_category_id')
                ->constrained()
                ->cascadeOnDelete();

           $table->string('product_code');

            $table->unique([
                'company_id',
                'product_code'
            ]);

            $table->string('barcode')->nullable();

            $table->unique([
                'company_id',
                'barcode'
            ]);

            $table->string('sku')->nullable();

            $table->unique([
                'company_id',
                'sku'
            ]);

            $table->string('qr_code')->nullable();

            $table->string('name');

            $table->text('description')->nullable();

            $table->string('image')->nullable();

            $table->decimal('cost_price',15,2)->default(0);

            $table->decimal('selling_price',15,2);

            $table->foreignId('discount_id')
            ->nullable()
            ->constrained()
            ->nullOnDelete();

            $table->foreignId('unit_id')
            ->nullable()
            ->constrained()
            ->nullOnDelete();

            $table->string('shelf_location')->nullable();

            $table->boolean('track_stock')->default(true);

            $table->string('brand')->nullable();

            $table->string('manufacturer')->nullable();

            $table->date('expiry_date')->nullable();

            $table->boolean('taxable')->default(true);

            $table->foreignId('tax_rate_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->boolean('status')->default(true);

            $table->decimal('minimum_stock',15,2)->default(0);

            $table->decimal('maximum_stock',15,2)->nullable();

            $table->decimal('weight',10,2)->nullable();

            $table->string('dimensions')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->softDeletes();            

            $table->decimal('reorder_level',15,2)->default(0);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
