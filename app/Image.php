<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'file_name', 'user_id'];

    /**
     * Return url to self
     *
     * @return string
     */
    public function path()
    {
        return '/images/' . $this->id;
    }
}
