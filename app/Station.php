<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $fillable = ['name'];
    /**
     * Return url to self
     * 
     * @return string
     */
    public function path()
    {
        return '/stations/' . $this->id;
    }
}
