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
            'stock_counts',
            function (Blueprint $table) {

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
                | Branch
                |--------------------------------------------------------------------------
                */

                $table->foreignId(
                    'branch_id'
                )
                ->constrained()
                ->cascadeOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Reference
                |--------------------------------------------------------------------------
                */

                $table->string(
                    'reference_no'
                );


                /*
                |--------------------------------------------------------------------------
                | Count Date
                |--------------------------------------------------------------------------
                */

                $table->date(
                    'count_date'
                );


                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */

                $table->enum(
                    'status',
                    [
                        'Draft',
                        'In Progress',
                        'Completed',
                        'Cancelled',
                    ]
                )->default('Draft');


                /*
                |--------------------------------------------------------------------------
                | Notes
                |--------------------------------------------------------------------------
                */

                $table->text(
                    'notes'
                )->nullable();


                /*
                |--------------------------------------------------------------------------
                | Created By
                |--------------------------------------------------------------------------
                */

                $table->foreignId(
                    'created_by'
                )
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Completed By
                |--------------------------------------------------------------------------
                */

                $table->foreignId(
                    'completed_by'
                )
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Completed At
                |--------------------------------------------------------------------------
                */

                $table->timestamp(
                    'completed_at'
                )->nullable();


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

                $table->index([
                    'company_id',
                    'branch_id',
                ]);

                $table->index([
                    'company_id',
                    'status',
                ]);

                $table->index(
                    'reference_no'
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
            'stock_counts'
        );

    }

};