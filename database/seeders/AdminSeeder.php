<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['login' => 'admin'],
            [
                'name' => 'admin',
                'FIO' => 'Администратор',
                'number' => '0000000000',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
                'role' => 'admin',
            ]
        );
    }
}
