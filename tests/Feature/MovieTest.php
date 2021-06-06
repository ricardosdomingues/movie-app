<?php

namespace Tests\Feature\Questions;

use Tests\TestCase;
use App\Models\User;

class MovieTest extends TestCase
{
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