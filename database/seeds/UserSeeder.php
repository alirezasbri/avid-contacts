<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(\App\User::class, 1)->create();
//        DB::table('users')->insert([
//            'name' => Str::random(10),
//            'family' => Str::random(10),
//            'username' => Str::random(8),
//            'password' => Hash::make('password'),
//            'type' => 'admin'
//        ]);
    }
}
