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
        App\User::insert([
            'name' => 'Admin',
            'phone_number' => '+6288888',
            'access' => 1,
            'username' => 'admin',
            'password' => Hash::make('rahasia'),
            'photo' => asset('/images/users/userdefault.png'),
            'status' => true,
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
        App\User::insert([
            'name' => 'Rian Kusdiono',
            'phone_number' => '089633847',
            'access' => 2,
            'username' => 'riankusdiono',
            'password' => Hash::make('rahasia'),
            'photo' => asset('/images/users/userdefault.png'),
            'status' => true,
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
        App\User::insert([
            'name' => 'M. Irham Akbar',
            'phone_number' => '0896551',
            'access' => 3,
            'username' => 'irhamakbar',
            'password' => Hash::make('rahasia'),
            'photo' => asset('/images/users/userdefault.png'),
            'status' => true,
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
    }
}
