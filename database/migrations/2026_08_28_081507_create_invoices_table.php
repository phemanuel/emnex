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
            'invoices',
            function (Blueprint $table) {

                /*
                |--------------------------------------------------------------------------
                | Primary Key
                |--------------------------------------------------------------------------
                */

                $table->id();


                /*
                |--------------------------------------------------------------------------
                | Company / Location
                |--------------------------------------------------------------------------
                */

                $table->foreignId(
                    'company_id'
                )
                    ->constrained(
                        'companies'
                    )
                    ->cascadeOnDelete();


                $table->foreignId(
                    'branch_id'
                )
                    ->constrained(
                        'branches'
                    )
                    ->restrictOnDelete();


                $table->foreignId(
                    'terminal_id'
                )
                    ->nullable()
                    ->constrained(
                        'terminals'
                    )
                    ->nullOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Related Records
                |--------------------------------------------------------------------------
                */

                $table->foreignId(
                    'order_id'
                )
                    ->unique()
                    ->constrained(
                        'orders'
                    )
                    ->restrictOnDelete();


                $table->foreignId(
                    'customer_id'
                )
                    ->nullable()
                    ->constrained(
                        'customers'
                    )
                    ->nullOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Invoice Information
                |--------------------------------------------------------------------------
                */

                $table->string(
                    'invoice_no',
                    50
                );


                $table->date(
                    'invoice_date'
                );


                /*
                |--------------------------------------------------------------------------
                | Financial Information
                |--------------------------------------------------------------------------
                */

                $table->decimal(
                    'subtotal',
                    15,
                    2
                )->default(0);


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


                $table->decimal(
                    'amount_paid',
                    15,
                    2
                )->default(0);


                $table->decimal(
                    'balance',
                    15,
                    2
                )->default(0);


                $table->decimal(
                    'total_quantity',
                    15,
                    2
                )->default(0);


                $table->unsignedInteger(
                    'total_items'
                )->default(0);


                $table->decimal(
                    'grand_total',
                    15,
                    2
                )->default(0);


                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */

                $table->string(
                    'payment_status',
                    30
                )->default(
                    'Pending'
                );


                $table->string(
                    'invoice_status',
                    30
                )->default(
                    'Active'
                );


                /*
                |--------------------------------------------------------------------------
                | Additional Information
                |--------------------------------------------------------------------------
                */

                $table->text(
                    'remarks'
                )->nullable();


                /*
                |--------------------------------------------------------------------------
                | Users
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
                | Timestamps / Soft Deletes
                |--------------------------------------------------------------------------
                */

                $table->timestamps();

                $table->softDeletes();


                /*
                |--------------------------------------------------------------------------
                | Indexes
                |--------------------------------------------------------------------------
                */

                $table->index(
                    [
                        'company_id',
                        'invoice_no',
                    ]
                );


                $table->index(
                    [
                        'company_id',
                        'invoice_status',
                    ]
                );


                $table->index(
                    [
                        'company_id',
                        'payment_status',
                    ]
                );


                $table->index(
                    [
                        'company_id',
                        'invoice_date',
                    ]
                );


                $table->index(
                    [
                        'company_id',
                        'branch_id',
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
            'invoices'
        );
    }
};