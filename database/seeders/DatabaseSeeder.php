<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@bookstore.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        // Create customer user
        User::factory()->create([
            'name' => 'Customer Test',
            'email' => 'customer@test.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        // Seed categories and books
        $this->call([
            CategorySeeder::class,
            BookSeeder::class,
        ]);
    }
}
