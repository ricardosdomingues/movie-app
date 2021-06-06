<?php

namespace Tests\Feature\Questions;

use Tests\TestCase;
use App\Models\User;

class GenreTest extends TestCase
{
    /** @test */
    function guests_can_not_get_genres()
    {
        $this->get('/genres')
            ->assertStatus(302)
            ->assertRedirect('login');
    }

    /** @test */
    function authentication_users_can_get_genres()
    {
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