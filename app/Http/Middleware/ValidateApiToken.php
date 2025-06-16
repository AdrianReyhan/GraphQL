<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;

class ValidateApiToken
{
    public function handle($request, Closure $next)
    {
        // Mendapatkan token dari header Authorization
        $token = $request->bearerToken(); // Menggunakan bearerToken() untuk mengambil token JWT dengan lebih mudah

        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Menemukan pengguna berdasarkan token
        $user = User::where('api_token', $token)->first();

        if (!$user || $user->token_expiration < now()) {
            return response()->json(['message' => 'Token expired or invalid'], 401);
        }

        // Menyimpan data pengguna dalam request untuk digunakan di dalam GraphQL
        $request->auth = $user;

        return $next($request);
    }
}
