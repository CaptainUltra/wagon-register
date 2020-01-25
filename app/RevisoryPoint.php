<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RevisoryPoint extends Model
{
    protected $fillable = ['name', 'abbreviation'];
    /**
     * Get the wagons that the revisory point has
     */
    public function wagons()
    {
        return $this->hasMany(Wagon::class);
    }
}
