<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@berita.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Editor
        User::create([
            'name' => 'Editor Berita',
            'email' => 'editor@berita.com',
            'password' => Hash::make('password'),
            'role' => 'editor',
        ]);

        // Wartawan
        User::create([
            'name' => 'Wartawan 1',
            'email' => 'wartawan@berita.com',
            'password' => Hash::make('password'),
            'role' => 'wartawan',
        ]);
    }
}
