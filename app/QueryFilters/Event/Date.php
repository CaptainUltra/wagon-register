<?php

namespace App\QueryFilters\Event;

use Carbon\Carbon;
use App\QueryFilters\Filter;

class Date extends Filter
{
    protected function applyFilter($builder)
    {
        $date = Carbon::parse(request($this->filterName()))->toDateString();
        return $builder->whereDate($this->filterName(), '=', $date);
    }
}
