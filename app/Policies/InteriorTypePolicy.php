<?php

namespace App\Policies;

use App\InteriorType;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InteriorTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any interior types.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('interiortype-viewAny');
    }

    /**
     * Determine whether the user can view the interior type.
     *
     * @param  \App\User  $user
     * @param  \App\InteriorType  $interiorType
     * @return mixed
     */
    public function view(User $user, InteriorType $interiorType)
    {
        return $user->hasPermission('interiortype-view');
    }

    /**
     * Determine whether the user can create interior types.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('interiortype-create');
    }

    /**
     * Determine whether the user can update the interior type.
     *
     * @param  \App\User  $user
     * @param  \App\InteriorType  $interiorType
     * @return mixed
     */
    public function update(User $user, InteriorType $interiorType)
    {
        return $user->hasPermission('interiortype-update');
    }

    /**
     * Determine whether the user can delete the interior type.
     *
     * @param  \App\User  $user
     * @param  \App\InteriorType  $interiorType
     * @return mixed
     */
    public function delete(User $user, InteriorType $interiorType)
    {
        return $user->hasPermission('interiortype-delete');
    }

    /**
     * Determine whether the user can restore the interior type.
     *
     * @param  \App\User  $user
     * @param  \App\InteriorType  $interiorType
     * @return mixed
     */
    public function restore(User $user, InteriorType $interiorType)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the interior type.
     *
     * @param  \App\User  $user
     * @param  \App\InteriorType  $interiorType
     * @return mixed
     */
    public function forceDelete(User $user, InteriorType $interiorType)
    {
        return false;
    }
}
