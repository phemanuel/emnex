<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Add Synchronization Identity
        |--------------------------------------------------------------------------
        |
        | Add as nullable first so existing products can be safely backfilled.
        |
        */

        Schema::table('products', function (Blueprint $table) {
            $table->uuid('sync_uuid')
                ->nullable()
                ->after('id')
                ->unique();
        });


        /*
        |--------------------------------------------------------------------------
        | Backfill Existing Products
        |--------------------------------------------------------------------------
        |
        | Every existing Product must receive a permanent synchronization UUID.
        |
        */

        DB::table('products')
            ->select('id')
            ->orderBy('id')
            ->chunkById(500, function ($products) {

                foreach ($products as $product) {

                    DB::table('products')
                        ->where('id', $product->id)
                        ->update([
                            'sync_uuid' => (string) Str::uuid(),
                        ]);
                }

            });


        /*
        |--------------------------------------------------------------------------
        | Enforce Persistent Identity
        |--------------------------------------------------------------------------
        |
        | After all existing Products have an identity, future Products must
        | always have one.
        |
        */

        Schema::table('products', function (Blueprint $table) {
            $table->uuid('sync_uuid')
                ->nullable(false)
                ->change();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->dropUnique([
                'sync_uuid',
            ]);

            $table->dropColumn(
                'sync_uuid'
            );

        });
    }
};