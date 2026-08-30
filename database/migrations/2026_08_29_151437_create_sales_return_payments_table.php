<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    /*
    |--------------------------------------------------------------------------
    | Run
    |--------------------------------------------------------------------------
    */

    public function up(): void
    {

        Schema::create(
            'sales_return_payments',
            function (Blueprint $table) {

                $table->id();


                /*
                |--------------------------------------------------------------------------
                | Sales Return
                |--------------------------------------------------------------------------
                */

                $table->foreignId(
                    'sales_return_id'
                )
                    ->constrained(
                        'sales_returns'
                    )
                    ->cascadeOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Payment
                |--------------------------------------------------------------------------
                */

                $table->foreignId(
                    'payment_id'
                )
                    ->constrained()
                    ->cascadeOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Refunded Amount
                |--------------------------------------------------------------------------
                */

                $table->decimal(
                    'amount',
                    15,
                    2
                );


                $table->timestamps();

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Reverse
    |--------------------------------------------------------------------------
    */

    public function down(): void
    {

        Schema::dropIfExists(
            'sales_return_payments'
        );

    }

};