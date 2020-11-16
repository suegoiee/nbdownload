<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function admin(User $user)
    {
        return $user->isAdmin();
    }

    public function super(User $user)
    {
        return $user->isSuper();
    }

    public function josh(User $user)
    {
        return $user->isJosh();
    }
}
