<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GenreTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_genre_belongs_to_many_movies()
    {
        $genre = Genre::factory()->hasMovies(3)->create();

        $this->assertInstanceOf(BelongsToMany::class, $genre->movies());
    }
}
