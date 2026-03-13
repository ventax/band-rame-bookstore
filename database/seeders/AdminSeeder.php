<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin ATigaBookStore',
            'email' => 'admin@ATigaBookStore.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '08123456789',
        ]);

        echo "Admin user created successfully!\n";
        echo "Email: admin@ATigaBookStore.com\n";
        echo "Password: admin123\n";
    }
}
