<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@pertamina.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
            'email_verified_at' => now(),
            'is_online' => false,
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@pertamina.com');
        $this->command->info('Password: admin123');
    }
}