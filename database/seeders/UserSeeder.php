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
    $users = [
      [
        'nip' => fake()->unique()->randomNumber(6),
        'name' => 'Khoirul',
        'gender' => 'Laki-laki',
        'place_of_birth' => 'Jember',
        'date_of_birth' => '1997-09-01',
        'religion' => 'Islam',
        'phone_number' => '081234567890',
        'address' => 'Jl. Cijagra No. 123',
        'email' => 'mkhoirulr97@gmail.com',
        'password' => bcrypt('khoirul123'),
        'role_id' => 1,
      ],
      [
        'nip' => fake()->unique()->randomNumber(6),
        'name' => 'Rizky',
        'email' => 'rizky@gmail.com',
        'gender' => 'Laki-laki',
        'place_of_birth' => 'Jember',
        'date_of_birth' => '1988-10-22',
        'religion' => fake()->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha']),
        'phone_number' => fake()->phoneNumber,
        'address' => fake()->address,
        'password' => bcrypt('password'),
        'role_id' => 2,
      ],
      [
        'nip' => fake()->unique()->randomNumber(6),
        'name' => 'Tia Amelia',
        'email' => 'tia_amel@gmail.com',
        'gender' => 'Perempuan',
        'place_of_birth' => 'Jember',
        'date_of_birth' => '1990-10-22',
        'religion' => fake()->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha']),
        'phone_number' => fake()->phoneNumber,
        'address' => fake()->address,
        'password' => bcrypt('password'),
        'role_id' => 3,
      ],
      [
        'nip' => 'superadmin',
        'name' => 'Super Admin',
        'email' => 'superadmin@gmail.com',
        'password' => bcrypt('superadmin'),
        'role_id' => 4,
      ],
    ];

    foreach ($users as $user) {
      User::create($user);
    }
  }
}
