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
		 Schema::table('partners', function (Blueprint $table) {
			$table->string('country_name',100)->after('country')->nullable();
		 });
    }

    /**
     * Reverse the migrations.
     */
	 
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
			$table->dropColumn('country_name');
		 });
    }
};
