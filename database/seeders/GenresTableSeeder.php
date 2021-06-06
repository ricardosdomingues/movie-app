<?php

namespace Database\Seeders;

use \Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genres')->insert([
            'id'         => 1,
            'name'       => 'Action',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('genres')->insert([
            'id'         => 2,
            'name'       => 'Comedy',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('genres')->insert([
            'id'         => 3,
            'name'       => 'Drama',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('genres')->insert([
            'id'         => 4,
            'name'       => 'Fantasy',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('genres')->insert([
            'id'         => 5,
            'name'       => 'Horror',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('genres')->insert([
            'id'         => 6,
            'name'       => 'Mystery',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('genres')->insert([
            'id'         => 7,
            'name'       => 'Romance',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('genres')->insert([
            'id'         => 8,
            'name'       => 'Thriller',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('genres')->insert([
            'id'         => 9,
            'name'       => 'Western',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
