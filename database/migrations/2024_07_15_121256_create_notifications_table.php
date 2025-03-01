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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('partner_id')->nullable();
			$table->text('notification')->nullable();
			$table->tinyInteger('category')->nullable()->comment('1-admin,2-partner');
			$table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
	
};
