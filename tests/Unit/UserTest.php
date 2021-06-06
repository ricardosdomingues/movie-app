<?php

namespace Tests\Unit\Lead;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserTest extends TestCase
{

    /** @test */
    public function an_user_has_many_movies()
    {
        $user = User::factory()->hasMovies(3)->create();

        $this->assertInstanceOf(HasMany::class, $user->movies());
    }
}
