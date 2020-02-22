<?php

namespace App\Policies;

use App\Train;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TrainPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any trains.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('train-viewAny');
    }

    /**
     * Determine whether the user can view the train.
     *
     * @param  \App\User  $user
     * @param  \App\Train  $train
     * @return mixed
     */
    public function view(User $user, Train $train)
    {
        return $user->hasPermission('train-viewAny');
    }

    /**
     * Determine whether the user can create trains.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('train-viewAny');
    }

    /**
     * Determine whether the user can update the train.
     *
     * @param  \App\User  $user
     * @param  \App\Train  $train
     * @return mixed
     */
    public function update(User $user, Train $train)
    {
        return $user->hasPermission('train-viewAny');
    }

    /**
     * Determine whether the user can delete the train.
     *
     * @param  \App\User  $user
     * @param  \App\Train  $train
     * @return mixed
     */
    public function delete(User $user, Train $train)
    {
        return $user->hasPermission('train-viewAny');
    }

    /**
     * Determine whether the user can restore the train.
     *
     * @param  \App\User  $user
     * @param  \App\Train  $train
     * @return mixed
     */
    public function restore(User $user, Train $train)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the train.
     *
     * @param  \App\User  $user
     * @param  \App\Train  $train
     * @return mixed
     */
    public function forceDelete(User $user, Train $train)
    {
        return false;
    }
}
