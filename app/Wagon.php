<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wagon extends Model
{
    protected $fillable = ['number', 'type_id', 'depot_id'];
    public function setTypeIdAttribute($value)
    {
        $wagonType = substr($this->number, 4, 2).'-'.substr($this->number, 6, 2);
        $this->attributes['type_id'] = WagonType::where('name', $wagonType)->firstOrFail()->id;
    }
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
