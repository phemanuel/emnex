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
        Schema::table('tax_rates', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | Tax Rate Code
            |--------------------------------------------------------------------------
            */

            $table->string('tax_rate_code')
                ->after('company_id');

            $table->unique([
                'company_id',
                'tax_rate_code'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Description
            |--------------------------------------------------------------------------
            */

            $table->text('description')
                ->nullable()
                ->after('rate');

            /*
            |--------------------------------------------------------------------------
            | Audit
            |--------------------------------------------------------------------------
            */

            $table->foreignId('created_by')
                ->nullable()
                ->after('description')
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->after('created_by')
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Soft Deletes
            |--------------------------------------------------------------------------
            */

            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tax_rates', function (Blueprint $table) {

            $table->dropUnique([
                'company_id',
                'tax_rate_code'
            ]);

            $table->dropConstrainedForeignId('created_by');

            $table->dropConstrainedForeignId('updated_by');

            $table->dropColumn([
                'tax_rate_code',
                'description',
                'deleted_at'
            ]);

        });
    }
};
