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
            'company_business_profiles',
            function (Blueprint $table) {

                $table->id();

                /*
                |--------------------------------------------------------------------------
                | Company
                |--------------------------------------------------------------------------
                |
                | One business profile configuration per company.
                |
                */

                $table->foreignId('company_id')
                    ->unique()
                    ->constrained('companies')
                    ->cascadeOnDelete();


                /*
                |--------------------------------------------------------------------------
                | Profile
                |--------------------------------------------------------------------------
                |
                | Examples:
                |
                | general_retail
                | grocery
                | pharmacy
                | electronics
                | fashion
                | beauty
                | food_service
                | wholesale
                | specialty_retail
                |
                */

                $table->string(
                    'profile_key',
                    100
                )->index();


                /*
                |--------------------------------------------------------------------------
                | Capability Overrides
                |--------------------------------------------------------------------------
                |
                | Stores company-specific differences from the selected
                | EMNEX business profile.
                |
                | Example:
                |
                | {
                |   "product.fields.sku": "required",
                |   "product.fields.weight": "hidden"
                | }
                |
                | Operational data must not be stored here.
                |
                */

                $table->json(
                    'capability_overrides'
                )->nullable();


                $table->timestamps();
            }
        );
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(
            'company_business_profiles'
        );
    }
};