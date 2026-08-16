<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    /*
    |--------------------------------------------------------------------------
    | Run the migrations.
    |--------------------------------------------------------------------------
    */

    public function up(): void
    {

        Schema::create(
            'customer_groups',
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
                    ->constrained()
                    ->cascadeOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Basic Information
                |--------------------------------------------------------------------------
                */

                $table->string(
                    'name'
                );


                $table->string(
                    'code'
                );


                $table->text(
                    'description'
                )
                    ->nullable();


                /*
                |--------------------------------------------------------------------------
                | Commercial Settings
                |--------------------------------------------------------------------------
                */

                $table->decimal(
                    'discount_percentage',
                    5,
                    2
                )
                    ->default(0);


                $table->decimal(
                    'credit_limit',
                    15,
                    2
                )
                    ->default(0);


                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */

                $table->boolean(
                    'status'
                )
                    ->default(true);


                /*
                |--------------------------------------------------------------------------
                | Audit
                |--------------------------------------------------------------------------
                */

                $table->foreignId(
                    'created_by'
                )
                    ->nullable()
                    ->constrained(
                        'users'
                    )
                    ->nullOnDelete();


                $table->foreignId(
                    'updated_by'
                )
                    ->nullable()
                    ->constrained(
                        'users'
                    )
                    ->nullOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Timestamps
                |--------------------------------------------------------------------------
                */

                $table->timestamps();


                /*
                |--------------------------------------------------------------------------
                | Unique Constraints
                |--------------------------------------------------------------------------
                |
                | A company cannot have two customer groups
                | with the same code.
                |
                */

                $table->unique([
                    'company_id',
                    'code',
                ]);

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Reverse the migrations.
    |--------------------------------------------------------------------------
    */

    public function down(): void
    {

        Schema::dropIfExists(
            'customer_groups'
        );

    }

};