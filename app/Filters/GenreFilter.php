<?php

namespace App\Filters;

class GenreFilter extends Filter implements Contracts\GenreFilter
{
    /*
     * Default relationships that should be loaded everytime.
     * 
     * @var array
     */
    protected $defaultRelations = [];

    /**
     * Number of items per page in case of paginated.
     *
     * @var int
     */
    protected $pageSize = null;

    /**
     * {@inheritdoc}
     */
    public function getTable(): string
    {
        return 'genres';
    }
    
    /**
     * {@inheritDoc}
     */
    public static function getSearchableColumns(): array
    {
        return [
            'name'
        ];
    }
    
    /**
     * {@inheritDoc}
     */
    public static function getSortableColumns(): array
    {
        return [
            'name',
            'created_at',
            'updated_at'
        ];
    }
}