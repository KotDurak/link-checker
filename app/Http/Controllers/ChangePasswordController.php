<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6'
        ]);

        $user = auth()->user();

        $user->password = bcrypt($request->input('password'));
        $user->save();

        return back();
    }
}
