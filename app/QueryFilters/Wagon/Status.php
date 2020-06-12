<?php

namespace App\QueryFilters\Wagon;

use App\QueryFilters\Filter;

class Status extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->join('statuses', 'statuses.id', '=', 'wagons.status_id')->where('status_id', '=', request($this->filterName()));
    }
}
