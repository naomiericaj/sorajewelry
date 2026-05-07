<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
                ->constrained('categories')
                ->onDelete('cascade');

            $table->foreignId('collection_id')
                ->nullable()
                ->constrained('collections')
                ->onDelete('set null');

            $table->string('name');
            $table->string('slug')->unique();

            $table->text('description')->nullable();

            // Price in Rupiah
            $table->decimal('price', 15, 2);

            // Optional sale price
            $table->decimal('discount_price', 15, 2)->nullable();

            $table->integer('stock')->default(0);

            // Example: silver, gold, stainless steel
            $table->string('material')->nullable();

            // Example: silver, gold, black
            $table->string('color')->nullable();

            $table->enum('status', ['active', 'inactive'])->default('active');

            // For homepage / recommendation
            $table->boolean('is_featured')->default(false);

            // For simple recommendation logic
            $table->integer('view_count')->default(0);
            $table->integer('sold_count')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};