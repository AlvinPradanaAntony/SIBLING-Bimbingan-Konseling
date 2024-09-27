<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nip' => 'superadmin',
            'name' => 'Super Admin',
            'email' => 'superadmin@mail.com',
            'password' => bcrypt('superadmin'),
            'role_id' => 4,
        ]);
        User::create([
            'nip' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin123'),
            'role_id' => 3,
        ]);
        User::create([
            'nip' => 'khoirul',
            'name' => 'Khoirul',
            'email' => 'mkhoirulr97@gmail.com',
            'password' => bcrypt('khoirul123'),
            'role_id' => 1,
        ]);
    }
}
