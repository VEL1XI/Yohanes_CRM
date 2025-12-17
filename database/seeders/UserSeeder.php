<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@isp.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'aktif'
        ]);

        User::create([
            'name' => 'Manager',
            'email' => 'manager@isp.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'status' => 'aktif'
        ]);

        User::create([
            'name' => 'Sales 1',
            'email' => 'sales@isp.com',
            'password' => Hash::make('password'),
            'role' => 'sales',
            'status' => 'aktif'
        ]);
    }
}