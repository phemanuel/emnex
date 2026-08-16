<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | Run Migrations
    |--------------------------------------------------------------------------
    */

    public function up(): void
    {
        Schema::create(
            'suppliers',
            function (Blueprint $table) {

                /*
                |--------------------------------------------------------------------------
                | Primary Key
                |--------------------------------------------------------------------------
                */

                $table->id();


                /*
                |--------------------------------------------------------------------------
                | Company
                |--------------------------------------------------------------------------
                */

                $table->foreignId(
                    'company_id'
                )
                    ->constrained('companies')
                    ->cascadeOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Supplier Information
                |--------------------------------------------------------------------------
                */

                $table->string(
                    'supplier_code',
                    50
                );

                $table->string(
                    'name'
                );

                $table->string(
                    'contact_person'
                )->nullable();

                $table->string(
                    'email'
                )->nullable();

                $table->string(
                    'phone',
                    30
                )->nullable();

                $table->string(
                    'alternate_phone',
                    30
                )->nullable();


                /*
                |--------------------------------------------------------------------------
                | Address
                |--------------------------------------------------------------------------
                */

                $table->text(
                    'address'
                )->nullable();

                $table->string(
                    'city'
                )->nullable();

                $table->string(
                    'state'
                )->nullable();

                $table->string(
                    'country'
                )->nullable();


                /*
                |--------------------------------------------------------------------------
                | Business Information
                |--------------------------------------------------------------------------
                */

                $table->string(
                    'tax_number',
                    100
                )->nullable();

                $table->string(
                    'payment_terms',
                    100
                )->nullable();


                /*
                |--------------------------------------------------------------------------
                | Financial Information
                |--------------------------------------------------------------------------
                */

                $table->decimal(
                    'credit_limit',
                    15,
                    2
                )->default(0);

                $table->decimal(
                    'current_balance',
                    15,
                    2
                )->default(0);


                /*
                |--------------------------------------------------------------------------
                | Additional Information
                |--------------------------------------------------------------------------
                */

                $table->text(
                    'notes'
                )->nullable();


                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */

                $table->boolean(
                    'status'
                )->default(true);


                /*
                |--------------------------------------------------------------------------
                | Audit Users
                |--------------------------------------------------------------------------
                */

                $table->foreignId(
                    'created_by'
                )
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();

                $table->foreignId(
                    'updated_by'
                )
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();


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
                    'supplier_code',
                ]);

                $table->index([
                    'company_id',
                    'name',
                ]);

                $table->index([
                    'company_id',
                    'status',
                ]);

                $table->index([
                    'company_id',
                    'email',
                ]);

                $table->index([
                    'company_id',
                    'phone',
                ]);
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Reverse Migrations
    |--------------------------------------------------------------------------
    */

    public function down(): void
    {
        Schema::dropIfExists(
            'suppliers'
        );
    }
};