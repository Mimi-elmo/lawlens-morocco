<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@lawlens.ma'],
            [
                'name' => 'Admin LawLens',
                'password' => Hash::make('Admin@123456'),
                'role' => 'admin',
                'statut' => 'actif',
            ]
        );
    }
}
