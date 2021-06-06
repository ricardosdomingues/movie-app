<?php

namespace App\Http\Controllers;

use \Carbon\Carbon;
use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Requests\Movies\Store;
use App\Http\Requests\Movies\Update;
use Illuminate\Support\Facades\Auth;
use App\Filters\Contracts\MovieFilter;
use App\Http\Resources\Movie as MovieResource;

class MovieController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, MovieFilter $filter)
    {
        $filter->setSortColumn($request->input('orderBy', $filter->getSortColumn()))
            ->setSortDirection($request->input('ascending', $filter->getSortDirection()))
            ->setPageNumber((int) $request->input('page', $filter->getPageNumber()))
            ->setPageSize($request->input('limit', $filter->getPageSize()));
        
        $filter->withUser(Auth::user()->id);
        
        if ($request->filled('query')) {
            $filter->withSearch($request->input('query'), (bool) $request->input('exact', false));
        }

        $collection = $filter->setBaseQuery(Movie::query())->apply()->get();

        return MovieResource::collection($collection);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Store  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $data = $request->validated();

        // Ensure watched_at timestamp saved is generated server side
        if (array_key_exists('watched', $data)) {
            $data['watched_at'] = $data['watched'] ? Carbon::now()->toDateTimeString() : null;
            unset($data['watched']);
        }

        $movie = Auth::user()->movies()->create($data);

        if (count($data['genres']) > 0) {
            $movie->genres()->sync($data['genres']);
        }

        $movie->loadMissing([
            'genres'
        ]);

        return new MovieResource($movie);
    }

    /**
     * Display the specified resource.
     *
     * @param  Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        $this->authorize('view', $movie);

        $movie->loadMissing([
            'genres'
        ]);

        return new MovieResource($movie);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Update  $request
     * @param  Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, Movie $movie)
    {
        $this->authorize('update', $movie);

        $data = $request->validated();
        
        if (array_key_exists('title', $data)) {
            $movie->title = $data['title'];
        }

        if (array_key_exists('description', $data)) {
            $movie->description = $data['description'];
        }

        if (array_key_exists('release_date', $data)) {
            $movie->release_date = $data['release_date'];
        }

        if (array_key_exists('watched', $data)) {
            $movie->watched_at = (bool) $data['watched'] ? Carbon::now()->toDateTimeString() : null;
        }

        if (array_key_exists('genres', $data)) {
            $movie->genres()->sync($data['genres']);
        }

        $movie->save();

        $movie->loadMissing([
            'genres'
        ]);

        return new MovieResource($movie);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        $this->authorize('delete', $movie);

        $movie->delete();

        return response()->noContent();
    }
}
