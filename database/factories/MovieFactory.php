<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Movie;
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
        $user = User::factory()->create();

        return [
            'user_id'          => $user->id,
            'title'            => $this->faker->name(),
            'description'      => $this->faker->sentence(5),
            'release_date'     => $this->faker->date(),
            'watched_at'       => rand(0, 1) ? $this->faker->dateTime() : null
        ];
    }
}
