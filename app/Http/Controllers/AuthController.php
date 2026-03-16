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

        $user =  User::created($data);
        return response()->json($user, 201);
    }
    public  function login(LoginResquest $request)
    {
        $data = $request->validated();

        if (!$token = auth("api")->attempt($data)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return response()->json(['token' => $token], 200);
    }
}
