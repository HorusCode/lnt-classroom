<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{



    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');;
        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'Пользователь не найден',
                'errors' => 'Не авторизован'
            ], 401);
        }

        $user = auth()->user();

        $token = $user->createToken(config('app.name'));
        return response()->json([
            'token_type' => 'Bearer',
            'token' => $token->accessToken,
            'expires_at' => $token->token->expires_at,
            'user' => $user->toArray(),
            'role' => $user->role['name']
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'You are successfully logged out',
        ]);
    }
}
