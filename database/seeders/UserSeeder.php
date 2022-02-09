<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt(123123123),

        ]);
        User::create([
            'name' => 'ali',
            'email' => 'ali@ali.com',
            'password' => Hash::make(123123123),

        ]);
        User::create([
            'name' => 'user',
            'email' => 'user@user.com',
            'password' => bcrypt(123123123),

        ]);
    }
}
