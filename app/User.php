<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Return url to self
     * 
     * @return string
     */
    public function path()
    {
        return '/users/' . $this->id;
    }
    /**
     * Get the roles that the user has
     * 
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasPermission($permission)
    {
        foreach ($this->roles as $role) {
            foreach ($role->permissions as $userPermisson) {
                if ($userPermisson['slug'] === $permission) return true;
            }
        }
        return false;
    }

    /**
     * Get the slugs of the user's roles' permissions
     * 
     * @return string
     */
    public function getPermissionsSlugs()
    {
        $permissions = [];
        foreach ($this->roles as $role) {
            foreach ($role->permissions as $userPermisson) {
                $slug = $userPermisson['slug'];
                array_push($permissions, $slug);
            }
        }
        return json_encode($permissions);
    }
    /**
     * Get the slugs of the user's roles
     * 
     * @return string
     */
    public function getRolesSlugs()
    {
        $roles = [];
        foreach ($this->roles as $role) {
            $slug = $role['slug'];
            array_push($roles, $slug);
        }
        return json_encode($roles);
    }
}
