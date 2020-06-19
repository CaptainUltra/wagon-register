<?php

namespace App\QueryFilters\Wagon;

use App\QueryFilters\Filter;

class Depot extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where('depot_id', '=', request($this->filterName()));
    }
}
