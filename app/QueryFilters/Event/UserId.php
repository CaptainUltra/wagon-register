<?php

namespace App\QueryFilters\Event;

use App\QueryFilters\Filter;

class UserId extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where($this->filterName(), '=', request($this->filterName()));
    }
}