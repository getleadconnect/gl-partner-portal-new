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
        Schema::create('payment_verify', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->string('multiple_leads', 100)->nullable();
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->integer('collected_amount')->nullable();
            $table->integer('commission')->nullable();
            $table->integer('paid_amount')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('payment_id')->nullable();
            $table->enum('payment_status', ['Paid', 'Unpaid'])->default('Unpaid');
            $table->text('description')->nullable();
            $table->string('receipt')->nullable();
            $table->enum('verify_status', ['Verified', 'Unverified'])->default('Unverified');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_verify');
    }
};
