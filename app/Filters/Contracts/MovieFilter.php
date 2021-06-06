<?php

namespace App\Filters\Contracts;

interface MovieFilter extends Filter
{
    /**
     * Include user for filtering.
     *
     * @param int $user
     *
     * @return self
     */
    public function withUser(int $userId): self;
}