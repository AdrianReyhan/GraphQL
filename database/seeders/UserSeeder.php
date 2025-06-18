<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan pengguna belum ada
        if (!User::where('email', 'test@gmail.com')->exists()) {
            User::create([
                'name' => 'Test User',
                'email' => 'test@gmail.com',
                'password' => Hash::make('password'), // Gunakan Hash::make, bukan app('hash')
            ]);
        }
    }
}
