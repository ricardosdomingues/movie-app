<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use App\Filters\Contracts\GenreFilter;
use App\Http\Resources\Genre as GenreResource;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, GenreFilter $filter)
    {
        $filter->setSortColumn($request->input('orderBy', $filter->getSortColumn()))
            ->setSortDirection($request->input('ascending', $filter->getSortDirection()))
            ->setPageNumber((int) $request->input('page', $filter->getPageNumber()))
            ->setPageSize($request->input('limit', $filter->getPageSize()));
        
        if ($request->filled('query')) {
            $filter->withSearch($request->input('query'), (bool) $request->input('exact', false));
        }

        $collection = $filter->setBaseQuery(Genre::query())->apply()->get();

        return GenreResource::collection($collection);
    }
}
