<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken($user->name)->accessToken;
            return response()->json([
                'code' => 200,
                'user_id' => $user->id,
                'access_token' => $token,
                'token_type' => 'Bearer'
            ], 200);
        } else {
            return response()->json([
                'code' => 401,
                'error' => 'Unauthorized'
            ], 200);
        }
    }

    public function getUser()
    {
        return response()->json(auth()->user());
    }
}
