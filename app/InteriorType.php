<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InteriorType extends Model
{
    protected $fillable = ['name'];
    /**
     * Return url to self
     * 
     * @return string
     */
    public function path()
    {
        return url('/api/interiortypes/' . $this->id);
    }
    /**
     * Get wagon types that have this interior type
     */
    public function wagonTypes()
    {
        return $this->hasMany(WagonType::class);
    }
}
