<?php

namespace Database\Factories;

use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Movie::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'          => 1,
            'title'            => $this->faker->name(),
            'description'      => $this->faker->sentence(5),
            'release_date'     => $this->faker->date(),
            'watched_at'       => rand(0, 1) ? $this->faker->dateTime() : null
        ];
    }
}
