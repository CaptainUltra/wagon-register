<?php

namespace App\Policies;

use App\User;
use App\WagonType;
use Illuminate\Auth\Access\HandlesAuthorization;

class WagonTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any wagon types.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('wagontype-viewAny');
    }

    /**
     * Determine whether the user can view the wagon type.
     *
     * @param  \App\User  $user
     * @param  \App\WagonType  $wagonType
     * @return mixed
     */
    public function view(User $user, WagonType $wagonType)
    {
        return $user->hasPermission('wagontype-view');
    }

    /**
     * Determine whether the user can create wagon types.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('wagontype-create');
    }

    /**
     * Determine whether the user can update the wagon type.
     *
     * @param  \App\User  $user
     * @param  \App\WagonType  $wagonType
     * @return mixed
     */
    public function update(User $user, WagonType $wagonType)
    {
        return $user->hasPermission('wagontype-update');
    }

    /**
     * Determine whether the user can delete the wagon type.
     *
     * @param  \App\User  $user
     * @param  \App\WagonType  $wagonType
     * @return mixed
     */
    public function delete(User $user, WagonType $wagonType)
    {
        return $user->hasPermission('wagontype-delete');
    }

    /**
     * Determine whether the user can restore the wagon type.
     *
     * @param  \App\User  $user
     * @param  \App\WagonType  $wagonType
     * @return mixed
     */
    public function restore(User $user, WagonType $wagonType)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the wagon type.
     *
     * @param  \App\User  $user
     * @param  \App\WagonType  $wagonType
     * @return mixed
     */
    public function forceDelete(User $user, WagonType $wagonType)
    {
        return false;
    }
}
