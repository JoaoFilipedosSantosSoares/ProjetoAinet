<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
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
        return in_array($user->user_type, ['C', 'F']);
    }

   
    public function view(User $user, Order $order): bool
    {
        if ($user->user_type === 'F') {
            return true;
        }

        if ($user->user_type === 'C') {
            return $order->customer_id === $user->id; 
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->user_type === 'C';
    }

    
    public function update(User $user, Order $order): bool
    {
        return $user->user_type === 'F';
    }

    
    public function delete(User $user, Order $order): bool
    {
        return false;
    }

   
    public function restore(User $user, Order $order): bool
    {
        return false;
    }

   
    public function forceDelete(User $user, Order $order): bool
    {
        return false;
    }
}
