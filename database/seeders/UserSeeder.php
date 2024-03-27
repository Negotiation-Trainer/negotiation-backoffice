<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        //check if demo user exists
        if (User::where('email', 'user@user.com')->exists()) {
            return;
        }

        //create a single user (user@user.com, password)
        User::create([
            'name' => 'Demo User',
            'email' => 'user@user.com',
            'password' => bcrypt('password')
        ]);
    }
}
