<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InteriorType extends Model
{
    protected $fillable = ['name'];
    public function wagonTypes()
    {
        return $this->hasMany(WagonType::class);
    }
}
