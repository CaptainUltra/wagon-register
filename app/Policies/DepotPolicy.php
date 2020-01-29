<?php

namespace App\Policies;

use App\Depot;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepotPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any depots.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('depot-viewAny');
    }

    /**
     * Determine whether the user can view the depot.
     *
     * @param  \App\User  $user
     * @param  \App\Depot  $depot
     * @return mixed
     */
    public function view(User $user, Depot $depot)
    {
        return $user->hasPermission('depot-view');
    }

    /**
     * Determine whether the user can create depots.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('depot-create');
    }

    /**
     * Determine whether the user can update the depot.
     *
     * @param  \App\User  $user
     * @param  \App\Depot  $depot
     * @return mixed
     */
    public function update(User $user, Depot $depot)
    {
        return $user->hasPermission('depot-update');
    }

    /**
     * Determine whether the user can delete the depot.
     *
     * @param  \App\User  $user
     * @param  \App\Depot  $depot
     * @return mixed
     */
    public function delete(User $user, Depot $depot)
    {
        return $user->hasPermission('depot-delete');
    }

    /**
     * Determine whether the user can restore the depot.
     *
     * @param  \App\User  $user
     * @param  \App\Depot  $depot
     * @return mixed
     */
    public function restore(User $user, Depot $depot)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the depot.
     *
     * @param  \App\User  $user
     * @param  \App\Depot  $depot
     * @return mixed
     */
    public function forceDelete(User $user, Depot $depot)
    {
        return false;
    }
}
