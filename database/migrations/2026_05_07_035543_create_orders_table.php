<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->string('order_number')->unique();

            $table->decimal('subtotal', 15, 2);
            $table->decimal('shipping_cost', 15, 2)->default(0);
            $table->decimal('total_price', 15, 2);

            $table->enum('order_status', [
                'pending',
                'processing',
                'shipped',
                'completed',
                'cancelled'
            ])->default('pending');

            $table->string('receiver_name');
            $table->string('receiver_phone');
            $table->text('shipping_address');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};