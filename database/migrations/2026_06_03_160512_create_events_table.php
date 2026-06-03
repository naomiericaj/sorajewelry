<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('events', function (Blueprint $table) {
        $table->id();

        $table->string('title');
        $table->string('email_subject');

        $table->text('description');

        $table->string('discount_code')->nullable();

        $table->timestamp('start_date');
        $table->timestamp('end_date')->nullable();

        $table->boolean('is_active')->default(true);

        $table->boolean('email_sent')->default(false);

        $table->timestamps();
    });
}
};
