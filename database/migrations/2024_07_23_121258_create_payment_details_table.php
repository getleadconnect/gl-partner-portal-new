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
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
			$table->integer('lead_id')->nullable();
			$table->integer('partner_id')->nullable();
			$table->integer('collected_amount')->nullable();
			$table->integer('commission')->nullable();
			$table->integer('percentage')->nullable();
			$table->integer('amount')->nullable();
			$table->integer('balance')->nullable();
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_details');
    }
};
