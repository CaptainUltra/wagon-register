<?php

namespace App\Policies;

use App\User;
use App\Wagon;
use Illuminate\Auth\Access\HandlesAuthorization;

class WagonPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any wagons.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('wagon-viewAny');
    }

    /**
     * Determine whether the user can view the wagon.
     *
     * @param  \App\User  $user
     * @param  \App\Wagon  $wagon
     * @return mixed
     */
    public function view(User $user, Wagon $wagon)
    {
        return $user->hasPermission('wagon-view');
    }

    /**
     * Determine whether the user can create wagons.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('wagon-create');
    }

    /**
     * Determine whether the user can update the wagon.
     *
     * @param  \App\User  $user
     * @param  \App\Wagon  $wagon
     * @return mixed
     */
    public function update(User $user, Wagon $wagon)
    {
        return $user->hasPermission('wagon-update');
    }

    /**
     * Determine whether the user can delete the wagon.
     *
     * @param  \App\User  $user
     * @param  \App\Wagon  $wagon
     * @return mixed
     */
    public function delete(User $user, Wagon $wagon)
    {
        return $user->hasPermission('wagon-delete');
    }

    /**
     * Determine whether the user can restore the wagon.
     *
     * @param  \App\User  $user
     * @param  \App\Wagon  $wagon
     * @return mixed
     */
    public function restore(User $user, Wagon $wagon)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the wagon.
     *
     * @param  \App\User  $user
     * @param  \App\Wagon  $wagon
     * @return mixed
     */
    public function forceDelete(User $user, Wagon $wagon)
    {
        return false;
    }
}
