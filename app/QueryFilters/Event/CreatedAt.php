<?php

namespace App\QueryFilters\Event;

use App\Event;
use Carbon\Carbon;
use App\QueryFilters\Filter;

class CreatedAt extends Filter
{
    protected function applyFilter($builder)
    {
        $date = Carbon::parse(request($this->filterName()))->toDateString();
        return $builder->whereDate('created_at', '=', $date);
    }
}
