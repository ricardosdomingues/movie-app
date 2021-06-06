<?php

namespace App\Filters\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface Filter
{
    /**
     * Get the order values.
     *
     * @return array
     */
    public static function getSortDirectionValues(): array;

    /**
     * Get the sortable columns.
     *
     * @return array
     */
    public static function getSortableColumns(): array;

    /**
     * Get the searchable columns.
     *
     * @return array
     */
    public static function getSearchableColumns(): array;

    /**
     * Get the sorting column.
     *
     * @return string
     */
    public function getSortColumn(): string;

    /**
     * Set the sorting column.
     *
     * @param string $column
     *
     * @throws \OutOfBoundsException
     *
     * @return self
     */
    public function setSortColumn(string $column): self;

    /**
     * Get the sorting order.
     *
     * @return string
     */
    public function getSortDirection(): string;

    /**
     * Set the sorting order.
     *
     * @param string $order
     *
     * @throws \OutOfBoundsException
     *
     * @return self
     */
    public function setSortDirection(string $order): self;

    /**
     * Set the date column.
     *
     * @param string $column
     *
     * @return self
     */
    public function setDateColumn(string $column): self;

    /**
     * Get the page number.
     *
     * @return int
     */
    public function getPageNumber(): ?int;

    /**
     * Set the page number.
     *
     * @param int $page
     *
     * @throws \OutOfBoundsException
     *
     * @return self
     */
    public function setPageNumber(int $page): self;

    /**
     * Get the number of items per page.
     *
     * @return int
     */
    public function getPageSize(): ?int;

    /**
     * Set the number of items per page.
     *
     * @param int $items
     *
     * @throws \OutOfBoundsException
     *
     * @return self
     */
    public function setPageSize(int $items): self;

    /**
     * Set minimum limit date, records must be after this date
     *
     * @param  mixed $date
     *
     * @return self
     */
    public function setStartDate($date) : self;

    /**
     * Get minimum limit date
     *
     * @param  mixed $date
     *
     * @return self
     */
    public function getStartDate();

    /**
     * Set maximum limit date, records must be before this date
     *
     * @param  mixed $date
     *
     * @return self
     */
    public function setEndDate($date) : self;

    /**
     * Get minimum limit date
     *
     * @param  mixed $date
     *
     * @return self
     */
    public function getEndDate();

    /**
     * Add a search for filtering.
     *
     * @param string $text
     * @param bool   $exactMatch
     *
     * @return self
     */
    public function withSearch(string $text, bool $exactMatch = false): self;

    /**
     * Add relations to eager load.
     *
     * @param array $relations
     *
     * @return self
     */
    public function withRelations(array $relations): self;

    /**
     * Apply filters to the Query Builder.
     *
     * @return self
     */
    public function apply() : self;

    /**
     * Set the base query, on which the filters will be aplied
     *
     * @param Builder $builder
     * @return self
     */
    public function setBaseQuery(Builder $builder) : self;

    /**
     * Get the table name.
     *
     * @return string
     */
    public function getTable(): string;

    /**
     * Get records for the specified filters
     *
     * @return mixed
     */
    public function get();

}
