<?php

namespace App\Services;

interface AuthServiceInterface
{
    public function login(array $credentials);
    public function register(array $data);
    public function me();
    public function logout();
}