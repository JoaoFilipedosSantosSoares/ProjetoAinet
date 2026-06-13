<?php

namespace App\Policies;

use App\Models\User;


class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->user_type === 'A';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->user_type === 'A';
    }

  
    public function update(User $user, User $model): bool
    {
        return $user->user_type === 'A';
    }

   
    public function delete(User $user, User $model): bool
    {
        if ($user->user_type !== 'A') {
            return false;
        }

        return $user->id !== $model->id;
    }

    
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
