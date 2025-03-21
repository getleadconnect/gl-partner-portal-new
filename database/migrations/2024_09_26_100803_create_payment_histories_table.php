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
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('lead_id')->nullable();
			$table->unsignedBigInteger('partner_id')->nullable();
			$table->integer('amount')->nullable();
			$table->date('payment_date')->nullable();
			$table->string('payment_id')->nullable();
			$table->string('receipt')->nullable();
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_histories');
    }
};
