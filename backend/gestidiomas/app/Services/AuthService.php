<?php

namespace App\Services;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthService implements AuthServiceInterface
{
    public function login(array $credentials)
    {
        if ($token = JWTAuth::attempt($credentials)) {
            return $token;
        }

        throw new \Exception('Unauthorized');
    }

    public function register(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            throw new \Exception('Validation failed', 400);
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return JWTAuth::login($user);
    }

    public function me()
    {
        return auth()->user();
    }

    public function logout()
    {
        auth()->logout();
    }
}
