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
        DB::table('users')->insert([
            'name' => 'mauriciotntx',
            'email' => 'andresmaopinzon@gmail.com',
            'password' => bcrypt('secret')
        ]);
    }
}
