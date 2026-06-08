<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['products', 'categories', 'collections', 'product_images', 'events'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (!Schema::hasColumn($tableName, 'uuid')) {
                    $table->uuid('uuid')->nullable()->unique()->after('id');
                }

                if (!Schema::hasColumn($tableName, 'sync_updated_at')) {
                    $table->timestamp('sync_updated_at')->nullable()->after('uuid');
                }

                if (!Schema::hasColumn($tableName, 'sync_deleted_at')) {
                    $table->timestamp('sync_deleted_at')->nullable()->after('sync_updated_at');
                }

                if (!Schema::hasColumn($tableName, 'sync_origin')) {
                    $table->string('sync_origin')->nullable()->after('sync_deleted_at');
                }
            });
        }
    }

    public function down(): void
    {
        foreach (['products', 'categories', 'collections', 'product_images', 'events'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $columns = [];

                foreach (['uuid', 'sync_updated_at', 'sync_deleted_at', 'sync_origin'] as $column) {
                    if (Schema::hasColumn($tableName, $column)) {
                        $columns[] = $column;
                    }
                }

                if (!empty($columns)) {
                    $table->dropColumn($columns);
                }
            });
        }
    }
};