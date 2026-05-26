<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'view_count')) {
                $table->integer('view_count')->default(0);
            }

            if (!Schema::hasColumn('products', 'sold_count')) {
                $table->integer('sold_count')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'view_count')) {
                $table->dropColumn('view_count');
            }

            if (Schema::hasColumn('products', 'sold_count')) {
                $table->dropColumn('sold_count');
            }
        });
    }
};