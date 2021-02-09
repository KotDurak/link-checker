<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Services\CreateUserService;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;

    public function __construct(CreateUserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('can:admin');
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(CreateUserRequest $request)
    {
        $user = $this->userService->createUserFromRequest($request);

        return redirect()->route('user.update', ['user' => $user]);
    }

    public function update(User $user)
    {
        return view('user.update', ['user' => $user]);
    }
}
