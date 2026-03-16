<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginResquest;
use App\Http\Requests\RegisterResquest;
use App\Models\User;

class AuthController extends Controller
{

    public function register(RegisterResquest $request)
    {
        $data = $request->validated();
        $user =  User::create($data);
        $user->roles()->attach(1);
        return response()->json([
            'user' => $user,
        ], 201);
    }

    public  function login(LoginResquest $request)
    {
        $data = $request->validated();

        if (!$token = auth("api")->attempt($data)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return response()->json(['token' => $token], 200);
    }

    public function me()
    {
        return response()->json(auth()->user(), 200);
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
