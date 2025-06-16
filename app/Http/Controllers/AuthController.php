<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Metode untuk Registrasi Pengguna Baru
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Membuat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Menghasilkan token API dan menetapkan waktu kedaluwarsa
        $this->generateApiToken($user);

        // Mengembalikan respons dengan token
        return response()->json([
            'user' => $user,
            'api_token' => $user->api_token
        ], 201);
    }

    // Metode untuk Login Pengguna
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Mencari pengguna berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Memeriksa kecocokan password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Jika login berhasil, menghasilkan token API baru
        $this->generateApiToken($user);

        // Mengembalikan respons dengan token
        return response()->json([
            'user' => $user,
            'api_token' => $user->api_token
        ]);
    }

    // Method untuk menghasilkan API token dan mengatur kedaluwarsa
    private function generateApiToken($user)
    {
        $token = Str::random(60); // Menghasilkan string acak sepanjang 60 karakter
        $user->api_token = $token;
        $user->token_expiration = Carbon::now()->addHours(1); // Token berlaku 1 jam
        $user->save();
    }
}
