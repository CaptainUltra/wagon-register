<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarouselSlide extends Model
{
    /**
     * Get the image of the carousel slide
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imagable');
    }
    
}
