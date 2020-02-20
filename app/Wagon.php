<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Wagon extends Model
{
    use Searchable;
    
    protected $fillable = ['number', 'letter_index', 'v_max', 'seats', 'depot_id', 'revisory_point_id', 'revision_date'];
    protected $dates = ['revision_date'];
    /**
     * Return url to self
     * 
     * @return string
     */
    public function path()
    {
        return '/wagons/' . $this->id;
    }
    /**
     * Stylized number (with spaces and dashes)
     */
    public function getStylizedNumber()
    {
        $ab = substr($this->number, 0, 2);
        $cd = substr($this->number, 2, 2);
        $ef = substr($this->number, 4, 2);
        $gh = substr($this->number, 6, 2);
        $xyz = substr($this->number, 8, 3);
        $k = substr($this->number, 11);
        //AB CD EF-GH XYZ-K
        $number = $ab . ' ' . $cd . ' ' . $ef . '-' . $gh . ' ' . $xyz . '-' . $k;
        return $number;
    }
    public function getShortStylizedNumber()
    {
        $ef = substr($this->number, 4, 2);
        $gh = substr($this->number, 6, 2);
        $xyz = substr($this->number, 8, 3);
        $number = $ef . '-' . $gh . ' ' . $xyz;
        return $number;
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
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = [
            'id' => $this->id,
            //'number' => $this->number
            'short_number' => $this->getShortStylizedNumber()
            //'stylized_number' => $this->getStylizedNumber()
        ];

        return $array;
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
