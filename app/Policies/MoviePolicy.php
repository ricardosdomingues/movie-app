<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Movie;
use Illuminate\Auth\Access\HandlesAuthorization;

class MoviePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given movie can be viewed by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Movie  $movie
     * @return bool
     */
    public function view(User $user, Movie $movie)
    {
        return $user->id === $movie->user_id;
    }

    /**
     * Determine if the given movie can be updated by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Movie  $movie
     * @return bool
     */
    public function update(User $user, Movie $movie)
    {
        return $user->id === $movie->user_id;
    }

    /**
     * Determine if the given movie can be deleted by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Movie  $movie
     * @return bool
     */
    public function delete(User $user, Movie $movie)
    {
        return $user->id === $movie->user_id;
    }
}
