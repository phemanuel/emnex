<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Add Synchronization Identity + Soft Deletes
        |--------------------------------------------------------------------------
        */

        Schema::table('tax_rates', function (Blueprint $table) {

            $table->uuid('sync_uuid')
                ->nullable()
                ->after('id')
                ->unique();

            $table->softDeletes();
        });


        /*
        |--------------------------------------------------------------------------
        | Backfill Existing Tax Rates
        |--------------------------------------------------------------------------
        */

        DB::table('tax_rates')
            ->select('id')
            ->orderBy('id')
            ->chunkById(500, function ($taxRates) {

                foreach ($taxRates as $taxRate) {

                    DB::table('tax_rates')
                        ->where('id', $taxRate->id)
                        ->update([
                            'sync_uuid' => (string) Str::uuid(),
                        ]);
                }

            });


        /*
        |--------------------------------------------------------------------------
        | Require Synchronization Identity
        |--------------------------------------------------------------------------
        */

        Schema::table('tax_rates', function (Blueprint $table) {
            $table->uuid('sync_uuid')
                ->nullable(false)
                ->change();
        });
    }


    public function down(): void
    {
        Schema::table('tax_rates', function (Blueprint $table) {

            $table->dropUnique([
                'sync_uuid',
            ]);

            $table->dropColumn(
                'sync_uuid'
            );

            $table->dropSoftDeletes();
        });
    }
};