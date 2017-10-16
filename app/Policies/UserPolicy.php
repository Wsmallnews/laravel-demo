<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy extends Policy
{

    public function index (User $user) {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function show(User $user)
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user, User $ouser)
    {
        return $user->isSuperAdmin() || $user->id == $ouser->id;
    }


    public function resetPass(User $user) {
        return $user->isSuperAdmin();
    }


    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function destroy(User $user)
    {
        return $user->isSuperAdmin();
    }
}
