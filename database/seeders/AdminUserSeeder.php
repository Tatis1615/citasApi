<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'admin@admin.com';

        // Create default admin if not exists
        if (!User::where('email', $email)->exists()) {
            User::create([
                'name' => 'admin',
                'email' => $email,
                // User model uses 'hashed' cast, so plain text will be hashed automatically
                'password' => '12345678',
                'role' => 'admin',
            ]);
        }
    }
}
