<?php

namespace App\QueryFilters\Wagon;

use App\QueryFilters\Filter;
use Carbon\Carbon;

class RevisionDate extends Filter
{
    protected function applyFilter($builder)
    {
        $date = Carbon::parse(request($this->filterName()))->toDateString();
        return $builder->whereDate('revision_date', $date);
    }
}
