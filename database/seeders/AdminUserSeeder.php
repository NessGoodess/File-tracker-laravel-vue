<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('email', 'admin@example.com')->exists()) {
            $admin = User::create([
                'name' => 'Administrador',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
            ]);

            $admin->assignRole('admin');
        }
    }
}
