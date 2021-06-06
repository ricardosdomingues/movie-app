<?php

namespace Tests\Feature;

use App\Models\Genre;
use Tests\TestCase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MovieTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    function guests_can_not_get_their_movies()
    {
        $this->get('/movies')
            ->assertStatus(302)
            ->assertRedirect('login');
    }

    /** @test */
    function authentication_users_can_get_their_movies()
    {
        $user = User::factory()->hasMovies(3)->create();

        $this->actingAs($user);
        
        $this->get('/movies')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'title',
                        'description',
                        'genres',
                        'release_date',
                        'watched_at',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

    /** @test */
    function release_date_cannot_be_in_the_future()
    {
        $user = User::factory()->create();

        $genres = Genre::factory(2)->create();
        
        $this->actingAs($user);

        $data = array(
            'title'        => 'Title',
            'description'  => 'Description',
            'genres'       => $genres->map(function ($genre) { return $genre->id; })->toArray(),
            'release_date' => Carbon::tomorrow()->toDateString(),
            'watched'      => false
        );

        $this->postJson('/movies', $data)
            ->assertStatus(422)
            ->assertExactJson([
                'errors' => [
                    'release_date' => ["The release date must be a date before today."]
                ],
                'message' => 'The given data was invalid.'
            ]);

    }

    /** @test */
    function genres_must_exist()
    {
        $user = User::factory()->create();
        
        $this->actingAs($user);

        $data = array(
            'title'        => 'Title',
            'description'  => 'Description',
            'genres'       => [1],
            'release_date' => Carbon::yesterday()->toDateString(),
            'watched'      => false
        );

        $this->postJson('/movies', $data)
            ->assertStatus(422)
            ->assertExactJson([
                'errors' => [
                    'genres' => [["The selected genres.0 is invalid."]]
                ],
                'message' => 'The given data was invalid.'
            ]);

    }

    /** @test */
    function user_can_only_get_their_movies()
    {
        $user = User::factory()->create();

        User::factory()->hasMovies(3)->create();

        $this->actingAs($user);
        
        $this->get('/movies')
            ->assertExactJson([
                'data' => []
            ]);
    }

    /** @test */
    function user_can_only_edit_their_movies()
    {
        $user = User::factory()->create();

        $user2 = User::factory()->hasMovies(3)->create();

        $movie = $user2->movies()->first();

        $this->actingAs($user);
        
        $this->patch('/movies/' . $movie->id)
            ->assertForbidden();
    }
    
    /** @test */
    function user_can_only_view_their_movies()
    {
        $user = User::factory()->create();

        $user2 = User::factory()->hasMovies(3)->create();

        $movie = $user2->movies()->first();

        $this->actingAs($user);
        
        $this->get('/movies/' . $movie->id)
            ->assertForbidden();
    }

    /** @test */
    function user_can_only_delete_their_movies()
    {
        $user = User::factory()->create();

        $user2 = User::factory()->hasMovies(3)->create();

        $movie = $user2->movies()->first();

        $this->actingAs($user);
        
        $this->delete('/movies/' . $movie->id)
            ->assertForbidden();
    }
}