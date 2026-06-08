<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id');
            $table->timestamp('sync_updated_at')->nullable()->after('uuid');
            $table->timestamp('sync_deleted_at')->nullable()->after('sync_updated_at');
            $table->string('sync_origin')->nullable()->after('sync_deleted_at');
        });
    }

    public function down(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            $table->dropColumn([
                'uuid',
                'sync_updated_at',
                'sync_deleted_at',
                'sync_origin',
            ]);
        });
    }
};