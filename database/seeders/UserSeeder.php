<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Kepala Toko',
                'email' => 'admin@example.com',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'kepala_toko'
            ],
            [
                'name' => 'Karyawan',
                'email' => 'karyawan@example.com',
                'username' => 'karyawan',
                'password' => Hash::make('password'),
                'role' => 'karyawan'
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'username' => $userData['username'],
                'password' => $userData['password']
            ]);

            $user->assignRole($userData['role']);
        }
    }
}
