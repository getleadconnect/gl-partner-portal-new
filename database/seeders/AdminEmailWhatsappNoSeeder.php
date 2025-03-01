<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use DB;
class AdminEmailWhatsappNoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
	 
    public function run(): void
    {
        DB::table('admin_message_settings')->where('id',1)->delete();
		
		DB::table('admin_message_settings')->insert([
			'id'=>1,'email'	=> null,'whatsapp_no'=>null
		]);
		
    }
}
