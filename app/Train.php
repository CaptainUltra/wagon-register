<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    use Searchable;
    
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
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = [
            'id' => $this->id,
            'number' => $this->number
        ];

        return $array;
    }
    /**
     * Get the wagon that the depot has
     */
    public function wagonTypes()
    {
        return $this->belongsToMany(WagonType::class)->withPivot('position');
    }
}