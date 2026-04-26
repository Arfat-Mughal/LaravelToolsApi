<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'arfat.bjs@gmail.com'],
            [
                'name' => 'Arfat',
                'password' => Hash::make('password@123'),
            ]
        );
    }
}
