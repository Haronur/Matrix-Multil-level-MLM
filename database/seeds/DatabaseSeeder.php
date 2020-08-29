<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        DB::table('users')->insert([
            'username' => 'adminuser',
            'fName' => 'John',
            'lName' => 'Doe',
            'gender' => 'M',
            'join_date' => '2020-30-08',
            'mobile_number' => '1234567890',
            'upline_id' => 0,
            'level_no' => 1,
            'sameline_no' => 1,
            'path'=>'0',
            'email' =>'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'is_admin' => '1',
        ]);
        DB::table('adminsettings')->insert([
            'width' => 2,
            'depth' => 4,
        ]);
    }
}
