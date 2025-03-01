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
			$table->Integer('commission_percentage')->after('agent_id')->default(0);
		 });
    }

    /**
     * Reverse the migrations.
     */
	 
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
			$table->dropColumn('commission_percentage');
		 });
    }
};
