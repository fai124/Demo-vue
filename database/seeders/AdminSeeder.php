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
            ['login' => 'Conf2027'],
            [
                'name' => 'admin',
                'FIO' => 'Администратор',
                'number' => '000',
                'email' => 'admin@admin',
                'password' => Hash::make('Demo77'),
                'role' => 'admin',
            ]
        );
    }
}
