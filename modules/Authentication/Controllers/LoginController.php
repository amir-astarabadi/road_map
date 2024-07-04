<?php

namespace Modules\Authentication\Controllers;

use Modules\Authentication\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    public function login()
    {
        request()->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::whereEmail(request()->get('email'))->first();
        if (!$user || !Hash::check(request()->get('password'), $user->password)) {
            return response()->json(['errors' => ['invalid credentials']], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => ['authentication_token' => $token]
        ]);
    }
}
