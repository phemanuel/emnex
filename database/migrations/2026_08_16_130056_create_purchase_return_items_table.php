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
        Schema::create('purchase_return_items', function (Blueprint $table) {

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | Purchase Return
            |--------------------------------------------------------------------------
            */

            $table->foreignId('purchase_return_id')
                ->constrained('purchase_returns')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Goods Received Item
            |--------------------------------------------------------------------------
            */

            $table->foreignId('goods_received_item_id')
                ->nullable()
                ->constrained('goods_received_items')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Product
            |--------------------------------------------------------------------------
            */

            $table->foreignId('product_id')
                ->constrained('products')
                ->restrictOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Quantity / Pricing
            |--------------------------------------------------------------------------
            */

            $table->decimal('quantity', 15, 2);

            $table->decimal('unit_cost', 15, 2);

            $table->decimal('total', 15, 2)
                ->default(0);


            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index(
                'purchase_return_id'
            );

            $table->index(
                'goods_received_item_id'
            );

            $table->index(
                'product_id'
            );

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(
            'purchase_return_items'
        );
    }
};