<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Depot extends Model
{
    protected $fillable = ['name'];
    /**
     * Get the wagon that the depot has
     */
    public function wagons()
    {
        return $this->hasMany(Wagon::class);
    }
}
