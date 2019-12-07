<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * Get the wagon that the event belongs to
     */
    public function wagon()
    {
        return $this->belongsTo(Wagon::class);
    }
    /**
     * Get the event type to which the event belongs
     */
    public function type()
    {
        return $this->belongsTo(EventType::class);
    }
}
