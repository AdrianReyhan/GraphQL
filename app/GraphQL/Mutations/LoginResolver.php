<?php

namespace App\GraphQL\Mutations;

use GraphQL\Error\Error;
use Illuminate\Support\Facades\Auth;

class LoginResolver
{
    public function __invoke($_,array $args)
    {
        // Coba autentikasi pengguna
        $credentials = [
            'email' => $args['username'],
            'password' => $args['password']
        ];

        if (!Auth::attempt($credentials)) {
            throw new Error('Kredensial tidak valid.');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Buat token Passport
        $token = $user->createToken('auth-token')->accessToken;

        return [
            'user' => $user,
            'access_token' => $token,
        ];
    }
}