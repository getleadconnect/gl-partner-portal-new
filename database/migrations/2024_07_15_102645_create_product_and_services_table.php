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
        Schema::create('product_and_services', function (Blueprint $table) {
            $table->id();
			$table->string('plan_name')->nullable();
			$table->integer('type')->nullable();
			$table->integer('users')->nullable();
			$table->integer('month')->nullable();
			$table->bigInteger('pricing')->nullable();
			$table->tinyInteger('status')->nullable();
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_and_services');
    }
};
