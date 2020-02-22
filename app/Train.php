<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    protected $fillable = ['number', 'route', 'description'];
    /**
     * Return url to self
     * 
     * @return string
     */
    public function path()
    {
        return '/trains/' . $this->id;
    }
    /**
     * Get the wagon that the depot has
     */
    public function wagonTypes()
    {
        return $this->belongsToMany(WagonType::class)->withPivot('position');
    }
}
