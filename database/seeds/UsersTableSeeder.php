<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $id = DB::table('users')->insertGetid([
          'first_name' => 'Admin2',
          'last_name' => 'I-SEE Glasses',
          'email' => 'service@isee-glasses.com',
          'telephone' => '998765436',
          'password' => bcrypt('adminpass'),
          'role_id' => 1,
          'rate_id' => 1,
      ]);

      DB::table('administrators')->insert([
    	    'user_id' => $id,
    	]);
    }
}
