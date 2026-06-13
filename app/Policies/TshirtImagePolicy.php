<?php

namespace App\Policies;

use App\Models\Tshirt_Image;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TshirtImagePolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->user_type === 'A') {
            return true;
        }

        return null;
    }

 
    public function viewAny(User $user): bool
    {
        return false;
    }


    public function view(User $user, Tshirt_Image $tshirtImage): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tshirt_Image $tshirtImage): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tshirt_Image $tshirtImage): bool
    {
        dd([
        'id_do_utilizador_logado' => $user->id,
        'customer_id_da_imagem' => $tshirtImage->customer_id
    ]);

        return $user->id === $tshirtImage->customer_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Tshirt_Image $tshirtImage): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Tshirt_Image $tshirtImage): bool
    {
        return false;
    }
}
