<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'role_name' => 'Siswa',
        ]);
        Role::create([
            'role_name' => 'Wali Kelas',
        ]);
        Role::create([
            'role_name' => 'Guru BK',
        ]);
        Role::create([
            'role_name' => 'Super Admin'
        ]);
    }
}
