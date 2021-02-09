<?php

namespace App\Services;


use App\Http\Requests\CreateUserRequest;
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

    public function createUserFromRequest(CreateUserRequest $request): User
    {
        $user = User::make($request->only(['name', 'surname', 'email']));
        $user->is_admin = 0;
        $user->password = bcrypt($request->input('password'));

        $user->saveOrFail();

        return $user;
    }
}