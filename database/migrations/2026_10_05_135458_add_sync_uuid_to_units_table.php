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
        | Add Synchronization Identity
        |--------------------------------------------------------------------------
        */

        Schema::table('units', function (Blueprint $table) {
            $table->uuid('sync_uuid')
                ->nullable()
                ->after('id')
                ->unique();
        });


        /*
        |--------------------------------------------------------------------------
        | Backfill Existing Units
        |--------------------------------------------------------------------------
        */

        DB::table('units')
            ->select('id')
            ->orderBy('id')
            ->chunkById(500, function ($units) {

                foreach ($units as $unit) {

                    DB::table('units')
                        ->where('id', $unit->id)
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

        Schema::table('units', function (Blueprint $table) {
            $table->uuid('sync_uuid')
                ->nullable(false)
                ->change();
        });
    }


    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {

            $table->dropUnique([
                'sync_uuid',
            ]);

            $table->dropColumn(
                'sync_uuid'
            );

        });
    }
};