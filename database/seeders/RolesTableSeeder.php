<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['id' => 1, 'RoleName' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'RoleName' => 'User', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}