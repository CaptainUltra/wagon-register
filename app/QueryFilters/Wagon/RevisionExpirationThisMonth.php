<?php

namespace App\QueryFilters\Wagon;

use App\QueryFilters\Filter;
class RevisionExpirationThisMonth extends Filter
{
    protected function applyFilter($builder)
    {
        if(!request($this->filterName()))
        {
            return $builder;
        }
        return $builder->whereYear('revision_exp_date', date("Y"))->whereMonth('revision_exp_date', date("m"));
    }
}