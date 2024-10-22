<?php

namespace App\Policies;

use App\Models\User;

class AdminPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        $user = new User();
        return $user->role === 'admin';
    }

    public function manage(User $user)
    {
        return $user->isAdmin(); // Gebruik de isAdmin-methode
    }
}
