<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name' => 'admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => bcrypt('admin')
            ],
            [
                'name' => 'owner',
                'username' => 'owner',
                'email' => 'owner@gmail.com',
                'role' => 'owner',
                'password' => bcrypt('owner')
            ],
            [
                'name' => 'kasir',
                'username' => 'kasir',
                'email' => 'kasir@gmail.com',
                'role' => 'kasir',
                'password' => bcrypt('kasir')
            ],
        ];

        foreach ($userData as $key => $val) {
            User::create($val);
        }
    }
}
