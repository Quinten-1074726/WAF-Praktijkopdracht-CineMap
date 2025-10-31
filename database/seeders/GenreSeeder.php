<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            'Actie',
            'Avontuur',
            'Drama',
            'Komedie',
            'Thriller',
            'Horror',
            'Science Fiction',
            'Romantiek',
            'Animatie',
            'Documentaire',
        ];

        foreach ($genres as $name) {
            Genre::firstOrCreate(['name' => $name]);
        }
    }
}
