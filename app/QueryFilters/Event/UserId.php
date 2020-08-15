<?php

namespace App\QueryFilters\Event;

use App\Event;
use App\QueryFilters\Filter;
use Illuminate\Support\Facades\Auth;

class UserId extends Filter
{
    protected function applyFilter($builder)
    {
        if (Auth::user()->can('viewUser', Event::class)) {
            return $builder->where($this->filterName(), '=', request($this->filterName()));
        }
        return $builder;
    }
}
