<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WagonType extends Model
{
    protected $fillable = ['name', 'conditioned', 'interior_type_id'];
    public function setInteriorTypeIdAttribute(string $interiorTypeName)
    {
        $this->attributes['interior_type_id'] = InteriorType::where('name', $interiorTypeName)->firstOrFail()->id;
    }
    /**
     * Get the image that the wagon type has
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imagable');
    }
    /**
     * Get the image that the wagon type has
     */
    public function interiorType()
    {
        return $this->belongsTo(InteriorType::class);
    }
    
}
