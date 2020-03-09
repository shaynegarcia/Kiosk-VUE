<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	App\User::create([
            'user_no' => 'BITVERSEADMIN',
            'lastname' => 'Support',
            'firstname' => 'Bitverse',
            'username' => 'BITVERSEADMIN',
            'email' => 'admin@bit-verse.com',
            'password' => bcrypt('12password34'),
            'remember_token' => null,
            'is_pos' => 0,
    	]);
    }
}
