<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('platforms')->upsert([
            ['name' => 'Netflix'],
            ['name' => 'Disney+'],
            ['name' => 'Prime Video'],
            ['name' => 'HBO Max'],
        ], ['name']); 
    }
}

