<?php

namespace Tests\Feature;

use App\Models\Genre;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GenreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_can_not_get_genres()
    {
        Genre::factory(5)->create();

        $this->get('/genres')
            ->assertStatus(302)
            ->assertRedirect('login');
    }

    /** @test */
    function authentication_users_can_get_genres()
    {
        Genre::factory(5)->create();

        $user = User::factory()->create();

        $this->actingAs($user);

        $this->get('/genres')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'name',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }
}