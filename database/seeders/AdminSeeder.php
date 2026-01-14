<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // php artisan db:seed --class=AdminSeeder

        User::create([
            'name' => 'Admin',
            // 'prenom' => 'Admin',
            'role' => 'admin',
            // 'genre' => '1',
            // 'ville' => 'Casablanca',
            'email' => 'dany@example.com',
            'password' => Hash::make('dany@example.com'),
        ]);
    }
}
