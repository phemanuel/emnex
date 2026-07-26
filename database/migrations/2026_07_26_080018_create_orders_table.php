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
        Schema::create('orders', function (Blueprint $table) {

            $table->id();

            $table->foreignId('company_id')
                ->constrained()
                ->cascadeOnDelete();
            
            $table->foreignId('branch_id')
            ->constrained()
            ->cascadeOnDelete();            

            $table->string('order_no');

            $table->unique([
                'company_id',
                'order_no'
            ]);

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('cashier_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->decimal('subtotal',15,2)->default(0);

            $table->decimal('discount',15,2)->default(0);
            $table->foreignId('discount_id')
            ->nullable()
            ->constrained()
            ->nullOnDelete();

            $table->foreignId('tax_rate_id')
            ->nullable()
            ->constrained()
            ->nullOnDelete();

            $table->decimal('tax',15,2)->default(0);

            $table->decimal('total',15,2)->default(0);

            $table->decimal('amount_paid',15,2)->default(0);

            $table->decimal('balance',15,2)->default(0);

            $table->integer('total_items')->default(0);

            $table->decimal('total_quantity',15,2)->default(0);

            $table->decimal('change_given',15,2)->default(0);

            $table->decimal('grand_total',15,2)->default(0);

            $table->timestamp('completed_at')->nullable();

            $table->enum('payment_status',[
                'Pending',
                'Partial',
                'Paid',
                'Refunded'
            ])->default('Pending');

            $table->enum('order_status',[
                'Draft',
                'Held',
                'Completed',
                'Cancelled',
                'Refunded'
            ])->default('Draft');

            $table->enum('sales_channel',[
                'POS',
                'Online',
                'Phone'
            ])->default('POS');

            $table->foreignId('terminal_id')
            ->nullable()
            ->constrained()
            ->nullOnDelete();

            $table->boolean('receipt_printed')
            ->default(false);

            $table->text('remarks')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->softDeletes();
            

        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
