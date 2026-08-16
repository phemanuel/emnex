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
        Schema::create('goods_received_items', function (Blueprint $table) {

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | Goods Received
            |--------------------------------------------------------------------------
            */

            $table->foreignId('goods_received_id')
                ->constrained('goods_received')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Purchase Order Item
            |--------------------------------------------------------------------------
            */

            $table->foreignId('purchase_order_item_id')
                ->nullable()
                ->constrained('purchase_order_items')
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
            | Quantities / Pricing
            |--------------------------------------------------------------------------
            */

            $table->decimal('ordered_quantity', 15, 2)
                ->default(0);

            $table->decimal('received_quantity', 15, 2);

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
                'goods_received_id'
            );

            $table->index(
                'purchase_order_item_id'
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
            'goods_received_items'
        );
    }
};