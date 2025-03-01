<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use DB;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
	 
    public function run(): void
    {
        DB::table('admins')->insert([
			[
				'name'	=> 'admin',
				'email'	=> 'admin@gmail.com',
				'email_verified_at'=>null,
				'remember_token'=>null,
				'password'	=> Hash::make('12345'),
			],
		]);
		
    }
}
