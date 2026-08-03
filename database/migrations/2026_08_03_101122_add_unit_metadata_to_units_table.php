<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * --------------------------------------------------------------------------
     * Run the migrations.
     * --------------------------------------------------------------------------
     */
    public function up(): void
    {
        Schema::table('units', function (Blueprint $table) {

            $table->string('unit_code')
                ->after('company_id');

            $table->text('description')
                ->nullable()
                ->after('short_name');

            $table->foreignId('created_by')
                ->nullable()
                ->after('status')
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->after('created_by')
                ->constrained('users')
                ->nullOnDelete();

        });
    }

    /**
     * --------------------------------------------------------------------------
     * Reverse the migrations.
     * --------------------------------------------------------------------------
     */
    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {

            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);

            $table->dropColumn([
                'unit_code',
                'description',
                'created_by',
                'updated_by'
            ]);

        });
    }
};
