<?php

namespace App\QueryFilters\Wagon;

use App\QueryFilters\Filter;

class Sort extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->orderBy('number', request($this->filterName()));
    }
}
