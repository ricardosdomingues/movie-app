<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Seeder;

class MovieTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $genres = Genre::all();

        Movie::factory()->count(5)->create()->each(function ($movie) use ($genres) {
            $movieGenres = $genres->random(rand(2, 4));
            $movie->genres()->sync($movieGenres);
        });
    }
}
