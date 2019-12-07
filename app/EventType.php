<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    /**
     * Get the events of this type
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
