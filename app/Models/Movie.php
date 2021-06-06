<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'genre',
        'watched',
        'release_date'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'release_date' => 'date',
        'watched_at'   => 'datetime'
    ];

    /**
     * The genres that belong to the movie.
     */
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'movie_genre')->withTimestamps();
    }

    /**
     * The user that belong to the movie.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
