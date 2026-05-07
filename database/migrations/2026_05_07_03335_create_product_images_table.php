<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained('products')
                ->onDelete('cascade');

            // Original image
            $table->string('image_path');

            // Processed/compressed/resized image
            $table->string('processed_image_path')->nullable();

            // Main image shown in product card
            $table->boolean('is_main')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};