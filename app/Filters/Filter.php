<?php

namespace App\Filters;

use Exception;
use Carbon\Carbon;
use OutOfBoundsException;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

abstract class Filter implements Contracts\Filter
{   
    /**
     * Sort column.
     *
     * @var Builder
     */
    protected $builder = null;

    /**
     * Sort column.
     *
     * @var string
     */
    protected $sortColumn = 'created_at';

    /**
     * Sort direction.
     *
     * @var string
     */
    protected $sortDirection = 'desc';

    /**
     * Page number.
     *
     * @var int
     */
    protected $pageNumber = 1;

    /**
     * Number of items per page.
     *
     * @var int
     */
    protected $pageSize = 10;

    /**
     * Text search for filtering.
     *
     * @var array
     */
    protected $search = [];

    /**
     * Perform an exact match when searching?
     *
     * @var bool
     */
    protected $exactMatch = false;

    /**
     * Relations to eager load.
     *
     * @var array
     */
    protected $relations = [];

    /**
     * Default Date Column
     * 
     * @var string
     */
    protected $dateColumn = 'created_at';


    /**
     * Records must be after date
     * 
     * @var string
     */
    protected $startDate = null;


    /**
     * Records must be before date
     * 
     * @var string
     */
    protected $endDate = null;


    /**
     * {@inheritDoc}
     */
    public static function getSortDirectionValues(): array
    {
        return [
            'asc',
            'desc',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getSortColumn(): string
    {
        return $this->sortColumn;
    }

    /**
     * {@inheritDoc}
     */
    public function setSortColumn(string $column): Contracts\Filter
    {
        if (! \in_array($column, static::getSortableColumns(), true)) {
            throw new OutOfBoundsException(\sprintf(
                'The sort column must be one of: %s',
                \implode(', ', static::getSortableColumns())
            ));
        }

        $this->sortColumn = $column;

        return $this;
    }

    public function setDateColumn(string $column): Contracts\Filter
    {
        $this->dateColumn = $column;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getSortDirection(): string
    {
        return $this->sortDirection;
    }

    /**
     * {@inheritDoc}
     */
    public function setSortDirection(string $order): Contracts\Filter
    {
        if (! \in_array(\mb_strtolower($order), static::getSortDirectionValues(), true)) {
            throw new OutOfBoundsException(\sprintf(
                'The sort order must be one of: %s',
                \implode(', ', static::getSortDirectionValues())
            ));
        }

        $this->sortDirection = $order;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function getPageNumber(): ?int
    {
        return $this->pageNumber;
    }

    /**
     * {@inheritDoc}
     */
    public function setPageNumber(int $page): Contracts\Filter
    {
        if ($page < 1 && $page != -1) {
            throw new OutOfBoundsException('The page number must be equal or greater than one');
        }

        $this->pageNumber = $page;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function getPageSize(): ?int
    {
        return $this->pageSize;
    }

    /**
     * {@inheritDoc}
     */
    public function setPageSize($items): Contracts\Filter
    {
        if (!is_null($items)) {

            if ($items < 1) {
                throw new OutOfBoundsException('The page size number must be equal or greater than one');
            }

            $items = (int) $items;
        }

        $this->pageSize = $items;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function withSearch(string $text, bool $exactMatch = false): Contracts\Filter
    {
        $this->exactMatch = $exactMatch;

        // Normalise search patterns
         foreach (\preg_split('/\s+/', $text, 0, PREG_SPLIT_NO_EMPTY) as $word) {
            $this->search[] = \mb_strtolower(\str_replace('%', '\%', $word));
        }
        
        // $this->search = Str::lower($text);

        return $this;
    }

    /**
     * Apply default text search filtering.
     *
     * @return void
     */
    protected function applySearch(): void
    {
        if ($this->search) {
            $this->builder->where(function (Builder $query) {
                foreach (static::getSearchableColumns() as $column) {
                    
                    [$relationName, $relationAttribute] = explode('.', $column);

                    if ($relationName !== static::getTable()) {

                        $searchTerm = $this->search;

                        $query->orWhereHas($relationName, function (Builder $subquery) use
                            ($relationAttribute, $searchTerm) {
                                
                            foreach ($searchTerm as $pattern) {
                                $subquery->where($relationAttribute, 'LIKE', '%'.$pattern.'%');
                            }

                        });

                    } else {
                        // $query->orWhere($column, 'LIKE', "%{$this->search}%");

                        foreach ($this->search as $pattern) {
                            $query->orWhere($column, 'LIKE', '%'.$pattern.'%');
                        }
                    }
                }
            });
        }
        /* if ($this->search) {
            $this->builder->where(function (Builder $query) {
                foreach (static::getSearchableColumns() as $column) {
                    if ($this->exactMatch) {
                        $query->orWhere($column, 'LIKE', $this->search);

                        continue;
                    }

                    $query->orWhere($column, 'LIKE', "%{$this->search}%");
                    // foreach ($this->search as $pattern) {
                    //     $query->orWhere($column, 'LIKE', "%$pattern%");
                    // }
                }
            });
        } */
    }

    /**
     * {@inheritDoc}
     */
    public function withRelations(array $relations): Contracts\Filter
    {
        $this->relations = $relations;

        return $this;
    }

    /**
     * Apply eager loading of relations.
     *
     * @return void
     */
    protected function applyRelations(): void
    {
        $relations = $this->relations;
        
        if (isset($this->defaultRelations) && is_array($this->defaultRelations)) {
            $relations = array_merge($this->defaultRelations, $this->relations);
        }

        $this->builder->with($relations);
    }

    /**
     * Apply date filters.
     *
     * @return void
     */
    protected function applyDates () : void 
    {
        if ($this->startDate) {
            $this->builder->whereDate($this->dateColumn, '>=', $this->startDate);
        }

        if ($this->endDate) {
            $this->builder->whereDate($this->dateColumn, '<=', $this->endDate);
        }
    }

    public function applyOrder () : void 
    {
        $this->builder->orderBy($this->getSortColumn(), $this->getSortDirection());
    }


    /**
     * {@inheritDoc}
     */
    public function setStartDate($date) : Contracts\Filter 
    {
        if ($date) {
            try {
                $this->startDate = Carbon::parse($date);
            } catch(Exception $e) {
                // Do nothing
            }
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getStartDate() {
        return $this->startDate;
    }

    /**
     * {@inheritDoc}
     */
    public function setEndDate($date) : Contracts\Filter
    {
        if ($date) {
            try {
                $this->endDate = Carbon::parse($date);
            } catch(Exception $e) {
                // Do nothing
            }
        }
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getEndDate() {
        return $this->endDate;
    }

    /**
     * {@inheritDoc}
     */
    public function setBaseQuery(Builder $builder) : Contracts\Filter 
    {
        $this->builder = $builder;

        return $this;
    }


    /**
     * {@inheritDoc}
     */
    public function apply() : Contracts\Filter
    {   
        // Apply relation eager loading
        $this->applyRelations();

        // Apply text search filtering
        $this->applySearch();

        $this->applyDates();

        // Sort builder
        $this->applyOrder();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function get()
    {   
        if (!is_null($this->getPageSize())) {
            return $this->builder->paginate($this->getPageSize());
        } else {
            return $this->builder->get();
        }
    }
}
