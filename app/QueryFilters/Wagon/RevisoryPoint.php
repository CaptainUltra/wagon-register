<?php

namespace App\QueryFilters\Wagon;

use App\QueryFilters\Filter;

class RevisoryPoint extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where('revisory_point_id', '=', request($this->filterName()));
    }
}
