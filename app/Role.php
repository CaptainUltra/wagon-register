<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'slug'];
    /**
     * Return url to self
     * 
     * @return string
     */
    public function path()
    {
        return url('/api/roles/' . $this->id);
    }
    /**
     * Get the permissions that belong to the role.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
