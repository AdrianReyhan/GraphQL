<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // $this->call([
        //     UserSeeder::class,
        // ]);

        // Buat 10 user, masing-masing dengan 3 artikel 
        User::factory()->count(5)->has(Article::factory()->count(2))->create();
    }
}
