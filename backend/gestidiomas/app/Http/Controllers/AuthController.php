<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthServiceInterface;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthServiceInterface  $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $token = $this->authService->login($request->only('email', 'password'));
        return response()->json(['token' => $token]);
    }

    public function register(Request $request)
    {
        $token = $this->authService->register($request->all());
        return response()->json(['token' => $token]);
    }

    public function me()
    {
        return response()->json($this->authService->me());
    }

    public function logout()
    {
        $this->authService->logout();
        return response()->json(['message' => 'Logout Realizado Com Sucesso!']);
    }
}
