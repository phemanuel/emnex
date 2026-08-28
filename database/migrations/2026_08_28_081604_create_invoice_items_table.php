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
        Schema::create(
            'invoice_items',
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
                    ->constrained(
                        'companies'
                    )
                    ->cascadeOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Invoice
                |--------------------------------------------------------------------------
                */

                $table->foreignId(
                    'invoice_id'
                )
                    ->constrained(
                        'invoices'
                    )
                    ->cascadeOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Product
                |--------------------------------------------------------------------------
                */

                $table->foreignId(
                    'product_id'
                )
                    ->constrained(
                        'products'
                    )
                    ->restrictOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Product Snapshot
                |--------------------------------------------------------------------------
                */

                $table->string(
                    'product_name',
                    255
                );


                $table->string(
                    'product_barcode',
                    100
                )->nullable();


                /*
                |--------------------------------------------------------------------------
                | Quantity / Pricing
                |--------------------------------------------------------------------------
                */

                $table->decimal(
                    'quantity',
                    15,
                    2
                );


                $table->decimal(
                    'unit_price',
                    15,
                    2
                );


                $table->decimal(
                    'discount',
                    15,
                    2
                )->default(0);


                $table->decimal(
                    'tax',
                    15,
                    2
                )->default(0);


                $table->decimal(
                    'total',
                    15,
                    2
                )->default(0);


                /*
                |--------------------------------------------------------------------------
                | Timestamps
                |--------------------------------------------------------------------------
                */

                $table->timestamps();


                /*
                |--------------------------------------------------------------------------
                | Indexes
                |--------------------------------------------------------------------------
                */

                $table->index(
                    [
                        'company_id',
                        'invoice_id',
                    ]
                );


                $table->index(
                    [
                        'company_id',
                        'product_id',
                    ]
                );

            }
        );
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(
            'invoice_items'
        );
    }
};