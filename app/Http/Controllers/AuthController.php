<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginResquest;
use App\Http\Requests\RegisterResquest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function register(RegisterResquest $request)
    {
        $data = $request->validated();
        if ($data->fails()) {
            return response()->json($data->errors(), 400);
        }
        $user =  User::created($data);
        return response()->json($user, 201);
    }
    public  function login(LoginResquest $request)
    {
        $data = $request->validated();
        if ($data->fails()) {
            return response()->json($data->errors(), 400);
        }
        if (!$token = auth("api")->attempt($data)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return response()->json(['token' => $token], 200);
    }
}
