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
        Schema::create('cash_drawers', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Ownership
            |--------------------------------------------------------------------------
            */

            $table->foreignId('company_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('branch_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('terminal_id')
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Users
            |--------------------------------------------------------------------------
            */

            $table->foreignId('opened_by')
                ->constrained('users');

            $table->foreignId('closed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Balances
            |--------------------------------------------------------------------------
            */

            $table->decimal('opening_balance', 15, 2)
                ->default(0);

            $table->decimal('cash_sales', 15, 2)
                ->default(0);

            $table->decimal('cash_in', 15, 2)
                ->default(0);

            $table->decimal('cash_out', 15, 2)
                ->default(0);

            $table->decimal('cash_refunds', 15, 2)
                ->default(0);

            $table->decimal('expected_balance', 15, 2)
                ->default(0);

            $table->decimal('actual_balance', 15, 2)
                ->nullable();

            $table->decimal('variance', 15, 2)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'Open',
                'Closed',
            ])->default('Open');

            /*
            |--------------------------------------------------------------------------
            | Dates
            |--------------------------------------------------------------------------
            */

            $table->timestamp('opened_at')
                ->nullable();

            $table->timestamp('closed_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Remarks
            |--------------------------------------------------------------------------
            */

            $table->text('opening_remarks')
                ->nullable();

            $table->text('closing_remarks')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index([
                'company_id',
                'branch_id',
                'terminal_id',
                'status',
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_drawers');
    }
};