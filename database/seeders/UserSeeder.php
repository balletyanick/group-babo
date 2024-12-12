<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id' => Str::uuid(),
            'avatar' => null,
            'first_name' => 'Ballet',
            'last_name' => 'Yanick',
            'phone' => '1234567890',
            'role_id' => '4cdd46a2-ce1b-4dd0-b830-875596c8ab05', 
            'fonction' => 'Developpeur',
            'email' => 'balletyanick53@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'user_id' => null,
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
