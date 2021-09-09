<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'redha@gmail.com',
            'name' => 'Redha Bayu Anggara',
            'password' => \Hash::make('123456'),
            'status' => 'active',
        ]);

        User::create([
            'email' => 'red@fake.com',
            'name' => 'zoro',
            'password' => \Hash::make('123456'),
            'status' => 'active',
        ]);

        User::create([
            'email' => 'bl@fake.com',
            'name' => 'bl',
            'password' => \Hash::make('123456'),
            'status' => 'active',
        ]);
    }
}
