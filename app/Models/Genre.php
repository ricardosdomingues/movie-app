<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genre extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The movies that belong to the genre.
     */
    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'movie_genre')->withTimestamps();
    }
}
