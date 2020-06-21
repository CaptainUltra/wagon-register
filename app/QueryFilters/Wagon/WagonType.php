<?php

namespace App\QueryFilters\Wagon;

use App\QueryFilters\Filter;

class WagonType extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where('type_id', '=', request($this->filterName()));
    }
}
