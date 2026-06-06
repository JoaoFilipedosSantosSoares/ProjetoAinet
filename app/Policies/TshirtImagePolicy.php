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

        return null; // Continua para as regras abaixo se não for Admin
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
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
        // Se for um Cliente ('C'), ele só pode apagar se a imagem lhe pertencer
        if ($user->user_type === 'C') {
            // Nota: usamos ?-> para o caso de segurança se a relação falhar
            return $tshirtImage->customer_id === $user->customer?->id;
        }

        // Se for um Funcionário ('F'), por norma não deve apagar as imagens privadas 
        // dos clientes diretamente no painel de personalização deles.
        return false;
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
