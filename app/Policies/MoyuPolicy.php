<?php

namespace App\Policies;

use App\User;
use App\Moyu;
use Illuminate\Auth\Access\HandlesAuthorization;

class MoyuPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the moyu.
     *
     * @param  \App\User  $user
     * @param  \App\Moyu  $moyu
     * @return mixed
     */
    public function view(User $user, Moyu $moyu)
    {
        //
    }

    /**
     * Determine whether the user can create moyus.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the moyu.
     *
     * @param  \App\User  $user
     * @param  \App\Moyu  $moyu
     * @return mixed
     */
    public function update(User $user, Moyu $moyu)
    {
        return $moyu->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the moyu.
     *
     * @param  \App\User  $user
     * @param  \App\Moyu  $moyu
     * @return mixed
     */
    public function delete(User $user, Moyu $moyu)
    {
        //
    }
}
