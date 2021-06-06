<?php

namespace Database\Seeders;

use \Carbon\Carbon;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        DB::table('movies')->insert([
            'user_id'      => 1,
            'title'        => 'Inception',
            'description'  => 'Inception is a 2010 science fiction action film written and directed by Christopher Nolan',
            'release_date' => '2010-07-08',
            'watched_at'   => null,
            'created_at'   => Carbon::now()->toDateTimeString(),
            'updated_at'   => Carbon::now()->toDateTimeString(),
        ]);

        DB::table('movies')->insert([
            'user_id'      => 1,
            'title'        => 'Interstellar',
            'description'  => 'Interstellar is about Earth’s last chance to find a habitable planet before a lack of resources causes the human race to go extinct.',
            'release_date' => '2014-10-26',
            'watched_at'   => Carbon::now()->subMonth(6)->toDateTimeString(),
            'created_at'   => Carbon::now()->toDateTimeString(),
            'updated_at'   => Carbon::now()->toDateTimeString(),
        ]);
        
        DB::table('movies')->insert([
            'user_id'      => 1,
            'title'        => 'The Whole Truth',
            'description'  => 'A defense attorney uncovers disturbing facts when defending a teen client accused of murdering his wealthy father.',
            'release_date' => '2016-06-10',
            'watched_at'   => Carbon::now()->subMonth(3)->toDateTimeString(),
            'created_at'   => Carbon::now()->toDateTimeString(),
            'updated_at'   => Carbon::now()->toDateTimeString(),
        ]);

        DB::table('movies')->insert([
            'user_id'      => 1,
            'title'        => 'The Woman in the Window',
            'description'  => 'An agoraphobic woman is convinced she saw her neighbor get murdered, only for everyone to tell her she\'s wrong.',
            'release_date' => '2021-02-03',
            'watched_at'   => null,
            'created_at'   => Carbon::now()->toDateTimeString(),
            'updated_at'   => Carbon::now()->toDateTimeString(),
        ]);

        DB::table('movies')->insert([
            'user_id'      => 1,
            'title'        => 'Home',
            'description'  => 'When aliens invade Earth, a young girl strikes up a friendship with one of the aliens named Oh.',
            'release_date' => '2016-06-08',
            'watched_at'   => Carbon::now()->subYear(2)->toDateTimeString(),
            'created_at'   => Carbon::now()->toDateTimeString(),
            'updated_at'   => Carbon::now()->toDateTimeString(),
        ]);

        $movies = Movie::all();

        $movies->each((function ($movie) use ($genres) {
            $mGenres = $genres->random(rand(2, 4));
            $movie->genres()->sync($mGenres);
        }));
    }
}
