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
        User::updateOrCreate(
            ['email' => 'dsahil@gmail.com'],
            [
                'name' => 'sahil',
                'number' => '7622920559',
                'password' => Hash::make('123456'),
                'role' => 'admin',
                'status' => 1,
            ]
        );
    }
}
