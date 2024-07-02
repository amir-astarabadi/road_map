<?php

namespace Modules\Authentication\Controllers;

use Modules\Authentication\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Modules\Authentication\Requests\RegisterRequest;

class RegisterController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"auth", "register"},
     *     summary="Register user",
     *     description="it is clear, isn't it?",
     *     operationId="register",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => [
                'authentication_token' => $token,
                'message' => 'welcome'
            ]
        ]);
    }
}
