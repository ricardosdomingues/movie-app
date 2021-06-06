<?php

namespace Tests\Unit\Lead;

use App\Models\Genre;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GenreTest extends TestCase
{

    /** @test */
    public function a_genre_belongs_to_many_movies()
    {
        $genre = Genre::factory()->hasMovies(3)->create();

        $this->assertInstanceOf(BelongsToMany::class, $genre->movies());
    }
}
