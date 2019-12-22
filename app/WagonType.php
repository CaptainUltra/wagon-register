<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WagonType extends Model
{
    /**
     * Get the image that the wagon type has
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imagable');
    }
}
