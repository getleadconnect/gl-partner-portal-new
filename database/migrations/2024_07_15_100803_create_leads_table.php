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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('partner_id')->nullable();
			$table->string('name')->nullable();
			$table->string('mobile')->nullable()->unique();
			$table->string('email')->nullable()->unique();
			$table->string('designation')->nullable();
			$table->string('company_name')->nullable();
			$table->integer('bussiness_category_id')->nullable();
			$table->string('country')->nullable();
			$table->string('state')->nullable();
			$table->string('area')->nullable();
			$table->string('pincode')->nullable();
			$table->text('address')->nullable();
			$table->integer('plan_type')->nullable();
			$table->integer('plan_id')->nullable();
			$table->text('remarks')->nullable();
			$table->integer('amount_collected')->nullable();
			$table->integer('commission_amount')->nullable();
			$table->integer('total_amount')->nullable();
			$table->integer('paid_amount')->nullable();
			$table->integer('balance')->nullable();
			$table->timestamp('payment_date')->nullable();
			$table->integer('payment_status')->nullable();
			$table->string('lead_status',50)->nullable();
			
			$table->integer('owner_type')->nullable();
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
