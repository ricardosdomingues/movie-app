<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MovieTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_movie_has_an_user()
    {
        $movie = Movie::factory()->create();
        
        $this->assertInstanceOf(User::class, $movie->user);
    }

    /** @test */
    public function a_movie_belongs_to_many_genres()
    {
        $movie = Movie::factory()->hasGenres(3)->create();

        $this->assertInstanceOf(BelongsToMany::class, $movie->genres());
    }
}
