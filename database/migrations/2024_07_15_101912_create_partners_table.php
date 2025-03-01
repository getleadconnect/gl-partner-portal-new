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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
			$table->string('name')->nullable();
			$table->string('mobile',50)->nullable();
			$table->string('company_name')->nullable();
			$table->string('email')->nullable()->unique();
			$table->string('website')->nullable();
			$table->string('team_size')->nullable();
			$table->string('country')->nullable();
			$table->string('state')->nullable();
			$table->string('city')->nullable();
			$table->string('pin_code',10)->nullable();
			$table->timestamp('email_verified_at')->nullable();
			$table->string('password')->nullable();
			$table->integer('agent_id')->nullable();
			$table->string('photo')->nullable();
			$table->string('bank_name')->nullable();
			$table->string('ifsc')->nullable();
			$table->string('branch')->nullable();
			$table->string('account_number')->nullable();
			$table->string('upi_id')->nullable();
			$table->string('company_logo')->nullable();
			$table->tinyInteger('status')->nullable();
			$table->tinyInteger('profile_update_status')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
	 
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
