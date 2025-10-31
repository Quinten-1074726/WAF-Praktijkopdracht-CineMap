<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Title;
use App\Models\Platform;
use App\Models\Genre;
use Illuminate\Support\Arr;

class TitleSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = User::where('email', 'admin@cinemap.test')->value('id')
            ?? User::query()->value('id');

        if (!$adminId) {
            $this->command->warn('No users found — run UserSeeder first!');
            return;
        }

        $seed = [
            [
                'title' => 'Goodfellas',
                'type' => 'movie',
                'year' => 1990,
                'description' => 'The story of Henry Hill and his life in the mob, covering his relationship with his wife Karen Hill and his mob partners.',
                'platform' => 'Netflix',
                'genres' => ['Drama','Thriller'],
            ],
            [
                'title' => 'Inception',
                'type' => 'movie',
                'year' => 2010,
                'description' => 'A skilled thief leads a team into people\'s dreams to steal their secrets.',
                'platform' => 'Netflix',
                'genres' => ['Science Fiction','Thriller'],
            ],
            [
                'title' => 'Gladiator',
                'type' => 'movie',
                'year' => 2000,
                'description' => 'A betrayed Roman general fights his way through the arena to avenge his family and emperor.',
                'platform' => 'Prime Video',
                'genres' => ['Actie','Drama'],
            ],
            [
                'title' => 'Dune: Part Two',
                'type' => 'movie',
                'year' => 2024,
                'description' => 'Paul Atreides unites with the Fremen to seek revenge against the conspirators who destroyed his family.',
                'platform' => 'HBO Max',
                'genres' => ['Science Fiction','Avontuur'],
            ],
            [
                'title' => 'Interstellar',
                'type' => 'movie',
                'year' => 2014,
                'description' => 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity’s survival.',
                'platform' => 'Prime Video',
                'genres' => ['Science Fiction','Drama'],
            ],
            [
                'title' => 'Game of Thrones',
                'type' => 'series',
                'year' => 2011,
                'description' => 'Nine noble families fight for control over the lands of Westeros, while an ancient enemy returns.',
                'platform' => 'HBO Max',
                'genres' => ['Avontuur','Drama'],
            ],
            [
                'title' => 'Band of Brothers',
                'type' => 'series',
                'year' => 2001,
                'description' => 'The story of Easy Company, a unit of the 506th Regiment of the 101st Airborne Division, from training to the end of World War II.',
                'platform' => 'Netflix',
                'genres' => ['Drama'],
            ],
            [
                'title' => 'The Sopranos',
                'type' => 'series',
                'year' => 1999,
                'description' => 'New Jersey mob boss Tony Soprano deals with personal and professional issues in his home and business life.',
                'platform' => 'HBO Max',
                'genres' => ['Drama','Thriller'],
            ],
            [
                'title' => 'Rome',
                'type' => 'series',
                'year' => 2005,
                'description' => 'A chronicle of the lives of two ordinary Roman soldiers during the last days of the Roman Republic.',
                'platform' => 'Prime Video',
                'genres' => ['Drama','Avontuur'],
            ],
            [
                'title' => 'Breaking Bad',
                'type' => 'series',
                'year' => 2008,
                'description' => 'A chemistry teacher turns to cooking meth after a cancer diagnosis, changing his life forever.',
                'platform' => 'Netflix',
                'genres' => ['Drama','Thriller'],
            ],
        ];

        foreach ($seed as $row) {
            $platformId = Platform::where('name', $row['platform'])->value('id');

            $title = Title::updateOrCreate(
                ['title' => $row['title'], 'type' => $row['type']],
                [
                    'user_id'      => $adminId,
                    'year'         => $row['year'],
                    'description'  => $row['description'],
                    'is_published' => true,
                    'platform_id'  => $platformId, 
                ]
            );

            $genreIds = Genre::whereIn('name', $row['genres'])->pluck('id')->all();
            $title->genres()->sync($genreIds);
        }

        $this->command->info('Titles (with platforms & genres) seeded successfully!');
    }
}
