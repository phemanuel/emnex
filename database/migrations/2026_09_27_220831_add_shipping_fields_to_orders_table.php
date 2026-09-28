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
        Schema::table('orders', function (Blueprint $table) {

            $table->string(
                'shipping_method',
                30
            )->nullable();

            $table->unsignedBigInteger(
                'shipping_location_id'
            )->nullable();

            $table->string(
                'shipping_location_name'
            )->nullable();

            $table->text(
                'shipping_address'
            )->nullable();

            $table->string(
                'shipping_city',
                100
            )->nullable();

            $table->string(
                'shipping_state',
                100
            )->nullable();

            $table->decimal(
                'shipping_fee',
                15,
                2
            )->default(0);


            /*
            |--------------------------------------------------------------------------
            | Fulfilment
            |--------------------------------------------------------------------------
            */

            $table->string(
                'fulfilment_status',
                30
            )->nullable();

            $table->string(
                'tracking_reference'
            )->nullable();

            $table->text(
                'shipping_notes'
            )->nullable();

            $table->timestamp(
                'shipped_at'
            )->nullable();

            $table->timestamp(
                'delivered_at'
            )->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
