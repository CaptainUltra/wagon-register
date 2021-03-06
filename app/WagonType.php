<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WagonType extends Model
{
    protected $fillable = ['name', 'conditioned', 'interior_type_id', 'revision_valid_for'];
    /**
     * Return url to self
     * 
     * @return string
     */
    public function path()
    {
        return '/wagontypes/' . $this->id;
    }
    /**
     * Get the image that the wagon type has
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imagable');
    }
    /**
     * Get the interior type that the wagon type belongs to
     */
    public function interiorType()
    {
        return $this->belongsTo(InteriorType::class);
    }
    /**
     * Get the wagons that the wagon type has
     */
    public function wagons()
    {
        return $this->hasMany(Wagon::class);
    }
    /**
     * Get the trains that the wagon type has
     */
    public function trains()
    {
        return $this->belongsToMany(Train::class)->withPivot('position');
    }
}
