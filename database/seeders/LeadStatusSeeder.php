<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use DB;
class LeadStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
	 
    public function run(): void
    {
        DB::table('lead_statuses')->insert([
			[
				'lead_status'	=> 'New',
			],
			[
				'lead_status'	=> 'Got Business',
			],
		]);
		
    }
}
