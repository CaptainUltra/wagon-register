<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RevisoryPoint extends Model
{
    protected $fillable = ['name', 'abbreviation'];
    /**
     * Return url to self
     * 
     * @return string
     */
    public function path()
    {
        return '/revisorypoints/' . $this->id;
    }
    /**
     * Get the wagons that the revisory point has
     */
    public function wagons()
    {
        return $this->hasMany(Wagon::class);
    }
}
