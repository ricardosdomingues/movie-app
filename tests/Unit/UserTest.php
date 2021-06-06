<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_user_has_many_movies()
    {
        $user = User::factory()->hasMovies(3)->create();

        $this->assertInstanceOf(HasMany::class, $user->movies());
    }
}
