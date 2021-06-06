<?php

namespace App\Filters;

class MovieFilter extends Filter implements Contracts\MovieFilter
{

    /*
     * User used for filtering.
     * 
     * @var int
     */
    protected $user = null;

    /*
     * Default relationships that should be loaded everytime.
     * 
     * @var array
     */
    protected $defaultRelations = [
        'genres'
    ];

    /**
     * Number of items per page.
     *
     * @var int
     */
    protected $pageSize = null;
    
    /**
     * {@inheritdoc}
     */
    public function getTable(): string
    {
        return 'movies';
    }
    
    /**
     * {@inheritDoc}
     */
    public static function getSearchableColumns(): array
    {
        return [
            'title',
            'description',
            'genre'
        ];
    }
    
    /**
     * {@inheritDoc}
     */
    public static function getSortableColumns(): array
    {
        return [
            'release_date',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function withUser(int $userId): Contracts\MovieFilter
    {
        $this->user = $userId;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function apply(): Contracts\Filter
    {
        parent::apply();

        $this->builder->where('user_id', $this->user);

        return $this;
    }
}