<?php

namespace App\Http\Controllers;

use App\DTOs\RegisterDTO;
use App\Http\Requests\LoginResquest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\RegisterResquest;
use App\Models\User;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {
        // 
    }

public function register(RegisterRequest $request)
    {
        $dto = RegisterDTO::fromRequest($request);
        $user = $this->authService->registerUser($dto);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user->load('roles'),
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
