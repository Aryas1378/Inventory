<?php

namespace App\Policies;

use App\Models\Borrow;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BorrowPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('staff') or $user->hasRole('technical_manager') or $user->hasRole('manager');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Borrow  $borrow
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Borrow $borrow)
    {
        return $user->hasRole('staff') or $user->hasRole('technical_manager') or $user->hasRole('manager');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasRole('staff');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Borrow  $borrow
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Borrow $borrow)
    {
        return $user->hasRole('staff') or $user->hasRole('technical_manager') or $user->hasRole('manager');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Borrow  $borrow
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Borrow $borrow)
    {
        return $user->hasRole('staff');
    }

}
