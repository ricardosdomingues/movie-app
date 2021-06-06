<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Demo User',
            'email'    => 'demo@mail.com',
            'password' => bcrypt('123456789'),
            'email_verified_at' => Carbon::now()->subDays(1)->toDateTimeString(),
            'created_at'        => Carbon::now()->toDateTimeString(),
            'updated_at'        => Carbon::now()->toDateTimeString(),
        ]);
    }
}
