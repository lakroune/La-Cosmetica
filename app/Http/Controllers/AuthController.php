<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginResquest;
use App\Http\Requests\RegisterResquest;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function register(RegisterResquest $request) {}
    public  function login(LoginResquest $request)
    {

        $data = $request->validated();
        $user = auth()->attempt($data);
        if (!$user) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json(['message' => 'Login successful']);
    }
}
