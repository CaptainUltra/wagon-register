<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Wagon extends Model
{
    protected $fillable = ['number', 'letter_index', 'v_max', 'seats', 'depot_id', 'revisory_point_id', 'revision_date'];
    protected $dates = ['revision_date'];
    /**
     * Return url to self
     * 
     * @return string
     */
    public function path()
    {
        return url('/api/wagontypes/' . $this->id);
    }
    /**
     * Set the wagon's date as an instance of carbon
     *
     * @param  string  $value
     * @return void
     */
    public function setRevisionDateAttribute($value)
    {
        $this->attributes['revision_date'] = Carbon::parse($value);
    }
    /**
     * Get the wagon type to which the wagon belongs
     */
    public function wagonType()
    {
        return $this->belongsTo(WagonType::class, 'type_id');
    }
    /**
     * Get the depot that the wagon belongs to
     */
    public function depot()
    {
        return $this->belongsTo(Depot::class);
    }
    /**
     * Get the revisory point that the wagon belongs to
     */
    public function revisoryPoint()
    {
        return $this->belongsTo(RevisoryPoint::class, 'revisory_point_id');
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
