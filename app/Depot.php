<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Depot extends Model
{
    protected $fillable = ['name'];
    /**
     * Return url to self
     * 
     * @return string
     */
    public function path()
    {
        return url('/api/depots/' . $this->id);
    }
    /**
     * Get the wagon that the depot has
     */
    public function wagons()
    {
        return $this->hasMany(Wagon::class);
    }
}
