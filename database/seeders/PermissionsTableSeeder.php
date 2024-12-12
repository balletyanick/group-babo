<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            [
                'id' => Str::uuid(),
                'name' => 'LISTE PAIEMENT',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => Str::uuid(),
                'name' => 'LISTE SOUSCRIPTION EN COURS',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => Str::uuid(),
                'name' => 'LISTE SOUSCRIPTION EXPIRE',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            
            
        ]);
    }
}
