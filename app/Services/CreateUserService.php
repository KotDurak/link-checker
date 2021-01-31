<?php

namespace App\Services;


use App\User;

class CreateUserService
{
    public function createAdmin()
    {
        $user = new User();
        $user->is_admin = 1;
        $user->name = 'Admin';
        $user->email = 'admin@mail.ru';
        $user->password = bcrypt('123456');

        $user->saveOrFail();
    }
}