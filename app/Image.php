<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'file_name', 'user_id', 'date'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date'];

    /**
     * Set the image's date as an instance of carbon
     *
     * @param  string  $value
     * @return void
     */
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::parse($value);
    }

    /**
     * Return url to self
     *
     * @return string
     */
    public function path()
    {
        return '/images/' . $this->id;
    }

    /**
     * Get wagons which belong to the image.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function wagons()
    {
        return $this->belongsToMany(Wagon::class)->withPivot('primary');
    }
}
