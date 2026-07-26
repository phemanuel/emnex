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
        Schema::create('discounts', function (Blueprint $table) {

            $table->id();

            $table->foreignId('company_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name'); 
            $table->unique([
                'company_id',
                'name'
            ]);

            $table->boolean('is_automatic')->default(false);

            $table->enum('type',[
                'Percentage',
                'Fixed'
            ]);

            $table->decimal('value',15,2);

            $table->date('start_date');

            $table->date('end_date');

            $table->boolean('status')->default(true);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
