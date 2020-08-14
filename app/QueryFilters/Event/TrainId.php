<?php

namespace App\QueryFilters\Event;

use App\QueryFilters\Filter;

class TrainId extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where($this->filterName(), '=', request($this->filterName()));
    }
}