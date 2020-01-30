<?php

namespace App\Policies;

use App\RevisoryPoint;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RevisoryPointPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any revisory points.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('revisorypoint-viewAny');
    }

    /**
     * Determine whether the user can view the revisory point.
     *
     * @param  \App\User  $user
     * @param  \App\RevisoryPoint  $revisoryPoint
     * @return mixed
     */
    public function view(User $user, RevisoryPoint $revisoryPoint)
    {
        return $user->hasPermission('revisorypoint-view');
    }

    /**
     * Determine whether the user can create revisory points.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('revisorypoint-create');
    }

    /**
     * Determine whether the user can update the revisory point.
     *
     * @param  \App\User  $user
     * @param  \App\RevisoryPoint  $revisoryPoint
     * @return mixed
     */
    public function update(User $user, RevisoryPoint $revisoryPoint)
    {
        return $user->hasPermission('revisorypoint-update');
    }

    /**
     * Determine whether the user can delete the revisory point.
     *
     * @param  \App\User  $user
     * @param  \App\RevisoryPoint  $revisoryPoint
     * @return mixed
     */
    public function delete(User $user, RevisoryPoint $revisoryPoint)
    {
        return $user->hasPermission('revisorypoint-delete');
    }

    /**
     * Determine whether the user can restore the revisory point.
     *
     * @param  \App\User  $user
     * @param  \App\RevisoryPoint  $revisoryPoint
     * @return mixed
     */
    public function restore(User $user, RevisoryPoint $revisoryPoint)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the revisory point.
     *
     * @param  \App\User  $user
     * @param  \App\RevisoryPoint  $revisoryPoint
     * @return mixed
     */
    public function forceDelete(User $user, RevisoryPoint $revisoryPoint)
    {
        return false;
    }
}
