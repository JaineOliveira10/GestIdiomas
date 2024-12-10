<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;

class JwtAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Verifica se o token está presente no cabeçalho da requisição
            $user = JWTAuth::parseToken()->authenticate();

            // Se o token não for válido, retorna um erro
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Token is invalid or expired'], 401);
        }

        return $next($request);
    }
}

