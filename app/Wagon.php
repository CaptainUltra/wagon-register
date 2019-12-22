<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wagon extends Model
{
    /**
     * Get the wagon type to which the wagon belongs
     */
    public function wagonType()
    {
        return $this->belongsTo(WagonType::class);
    }

    /**
     * Get the events associated with the wagon
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }
    /**
     * Get the images associated with the wagon
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

}
