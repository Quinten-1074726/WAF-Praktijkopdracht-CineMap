<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class TitleSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = User::where('email', 'admin@cinemap.test')->value('id');

        if (!$adminId) {
            $adminId = User::query()->value('id');
        }

        if (!$adminId) {
            $this->command->warn('No users found — run UserSeeder first!');
            return;
        }

        DB::table('titles')->insert([
            [
                'user_id' => $adminId,
                'title' => 'Inception',
                'description' => 'A skilled thief leads a team into people\'s dreams to steal secrets.',
                'year' => 2010,
                'type' => 'movie',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $adminId,
                'title' => 'Breaking Bad',
                'description' => 'A chemistry teacher turns to cooking meth after a cancer diagnosis.',
                'year' => 2008,
                'type' => 'series',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $adminId,
                'title' => 'The Dark Knight',
                'description' => 'Batman faces off against the Joker in Gotham City.',
                'year' => 2008,
                'type' => 'movie',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $adminId,
                'title' => 'Stranger Things',
                'description' => 'A group of kids uncover supernatural mysteries in their small town.',
                'year' => 2016,
                'type' => 'series',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $adminId,
                'title' => 'Dune: Part One',
                'description' => 'A young noble leads his people in a battle for survival on a desert planet.',
                'year' => 2021,
                'type' => 'movie',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
