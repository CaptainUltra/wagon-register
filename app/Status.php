<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['name'];
    /**
     * Return url to self
     * 
     * @return string
     */
    public function path()
    {
        return '/statuses/' . $this->id;
    }
    /**
     * Get the wagon that the status has
     */
    public function wagons()
    {
        return $this->hasMany(Wagon::class);
    }
}
