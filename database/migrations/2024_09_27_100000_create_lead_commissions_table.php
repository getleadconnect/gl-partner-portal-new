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
        Schema::create('lead_commissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->integer('amount_collected')->nullable();
            $table->integer('commission_amount')->nullable();
            $table->integer('total_amount')->nullable();
            $table->integer('paid_amount')->nullable();
            $table->integer('balance')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->integer('payment_status')->default(0);
            $table->string('lead_status', 50)->nullable();
            $table->string('renewal_status', 50)->nullable();
            $table->string('description', 250)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_commissions');
    }
};
