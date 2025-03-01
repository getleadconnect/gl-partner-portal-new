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
        Schema::create('notification_statuses', function (Blueprint $table) {
            $table->id();
			$table->integer('admin_id')->nullable();
			$table->integer('email_status')->nullable();
			$table->integer('whatsapp_status')->nullable();
			$table->integer('telegram_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_statuses');
    }
};
