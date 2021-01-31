<?php


namespace App\Services;


use App\User;

class UserRoleService
{
    public function setAdmin(User $user)
    {
        $user->is_admin = true;
        $user->saveOrFail();
    }

    public function cancelAdmin(User $user)
    {
        $user->is_admin = false;
        $user->saveOrFail();
    }
}