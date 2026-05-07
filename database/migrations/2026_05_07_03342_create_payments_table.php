<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained('orders')
                ->onDelete('cascade');

            // Example: bank_transfer, gopay, qris, credit_card
            $table->string('payment_method')->nullable();

            // pending, success, failed, expired
            $table->string('payment_status')->default('pending');

            // Midtrans fields
            $table->string('midtrans_order_id')->nullable();
            $table->string('transaction_id')->nullable();

            $table->decimal('amount', 15, 2);

            // Store Midtrans response as JSON
            $table->json('payment_response')->nullable();

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};