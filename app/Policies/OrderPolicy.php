<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->user_type === 'A') {
            return true; // Administrador ignora as restrições e pode fazer tudo
        }
        return null; // Continua a verificação normal para os outros papéis
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->user_type, ['C', 'F']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): bool
    {
        // 1. Funcionários (F) podem ver qualquer encomenda no sistema
        if ($user->user_type === 'F') {
            return true;
        }

        // 2. Clientes (C) só podem ver a encomenda se forem os donos dela
        if ($user->user_type === 'C') {
            return $order->customer_id === $user->id; 
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->user_type === 'C';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Order $order): bool
    {
        // Funcionários (F) podem alterar os estados das encomendas
        return $user->user_type === 'F';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Order $order): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Order $order): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Order $order): bool
    {
        return false;
    }
}
