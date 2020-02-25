<?php

namespace App\Policies;

use App\Station;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any stations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('station-viewAny');
    }

    /**
     * Determine whether the user can view the station.
     *
     * @param  \App\User  $user
     * @param  \App\Station  $station
     * @return mixed
     */
    public function view(User $user, Station $station)
    {
        return $user->hasPermission('station-view');
    }

    /**
     * Determine whether the user can create stations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('station-create');
    }

    /**
     * Determine whether the user can update the station.
     *
     * @param  \App\User  $user
     * @param  \App\Station  $station
     * @return mixed
     */
    public function update(User $user, Station $station)
    {
        return $user->hasPermission('station-update');
    }

    /**
     * Determine whether the user can delete the station.
     *
     * @param  \App\User  $user
     * @param  \App\Station  $station
     * @return mixed
     */
    public function delete(User $user, Station $station)
    {
        return $user->hasPermission('station-delete');
    }

    /**
     * Determine whether the user can restore the station.
     *
     * @param  \App\User  $user
     * @param  \App\Station  $station
     * @return mixed
     */
    public function restore(User $user, Station $station)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the station.
     *
     * @param  \App\User  $user
     * @param  \App\Station  $station
     * @return mixed
     */
    public function forceDelete(User $user, Station $station)
    {
        return false;
    }
}
