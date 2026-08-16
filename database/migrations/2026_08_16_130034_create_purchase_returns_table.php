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
        Schema::create('purchase_returns', function (Blueprint $table) {

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | Company / Branch
            |--------------------------------------------------------------------------
            */

            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->foreignId('branch_id')
                ->constrained('branches')
                ->restrictOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Supplier
            |--------------------------------------------------------------------------
            */

            $table->foreignId('supplier_id')
                ->constrained('suppliers')
                ->restrictOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Related Purchasing Documents
            |--------------------------------------------------------------------------
            */

            $table->foreignId('purchase_order_id')
                ->nullable()
                ->constrained('purchase_orders')
                ->nullOnDelete();

            $table->foreignId('goods_received_id')
                ->nullable()
                ->constrained('goods_received')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Document
            |--------------------------------------------------------------------------
            */

            $table->string('return_number', 100);

            $table->date('return_date');


            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->string('status', 30)
                ->default('Draft');


            /*
            |--------------------------------------------------------------------------
            | Reason / Notes
            |--------------------------------------------------------------------------
            */

            $table->string('reason', 255)
                ->nullable();

            $table->text('notes')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Users
            |--------------------------------------------------------------------------
            */

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Timestamps / Soft Delete
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            $table->softDeletes();


            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'company_id',
                'return_number',
            ]);

            $table->index([
                'company_id',
                'branch_id',
            ]);

            $table->index([
                'company_id',
                'supplier_id',
            ]);

            $table->index([
                'company_id',
                'purchase_order_id',
            ]);

            $table->index([
                'company_id',
                'goods_received_id',
            ]);

            $table->index([
                'company_id',
                'status',
            ]);

            $table->index([
                'company_id',
                'return_date',
            ]);

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(
            'purchase_returns'
        );
    }
};