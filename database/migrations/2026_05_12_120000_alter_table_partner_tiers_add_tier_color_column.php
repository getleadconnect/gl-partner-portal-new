<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('partner_tiers') && !Schema::hasColumn('partner_tiers', 'tier_color')) {
            Schema::table('partner_tiers', function (Blueprint $table) {
                $table->string('tier_color', 9)->nullable()->after('partner_tier');
            });

            $defaults = [
                1 => '#B68B3C',
                2 => '#1E3A5F',
                3 => '#64748B',
                4 => '#7C3AED',
            ];
            foreach ($defaults as $id => $color) {
                DB::table('partner_tiers')->where('id', $id)->whereNull('tier_color')->update(['tier_color' => $color]);
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('partner_tiers') && Schema::hasColumn('partner_tiers', 'tier_color')) {
            Schema::table('partner_tiers', function (Blueprint $table) {
                $table->dropColumn('tier_color');
            });
        }
    }
};
